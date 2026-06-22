<?php

namespace App\Http\Controllers\v1\Central;

use App\Http\Controllers\Controller;
use App\Http\Services\KafkaProducerService;
use App\Http\Services\UserService;
use App\Models\ExternalObserver;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ExternalObserverController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function requestAccess(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'to' => 'required|exists:tenants,id',
        ]);

        $currentTenant = Tenant::findOrFail($request->header('X-Tenant'));

        if ($currentTenant->id === $validated['to']) {
            return response()->json(['message' => 'You cannot request access to yourself.'], 422);
        }

        $exists = ExternalObserver::where('from', $currentTenant->id)
            ->where('to', $validated['to'])
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'A request already exists or has been accepted.'], 422);
        }

        $targetTenant = Tenant::findOrFail($validated['to']);

        $user = auth()->user();

        $accessRequest = ExternalObserver::create([
            'from'      => $currentTenant->id,
            'from_name' => $currentTenant->name,
            'to'        => $targetTenant->id,
            'to_name'   => $targetTenant->name,
            'status'    => 'pending',
            'applied_by' => $user->first_name . ' ' . $user->last_name,
            'applied_by_uuid' => $user->external_id,
        ]);

        return response()->json(['message' => 'Request sent successfully.', 'data' => $accessRequest], 210);
    }

    /**
     * Get requests sent by the current tenant.
     */
    public function outgoingRequests(Request $request): JsonResponse
    {
        $tenant = Tenant::findOrFail($request->header('X-Tenant'));
        $requests = ExternalObserver::where('from', $tenant->id)->get();
        return response()->json(['data' => $requests]);
    }

    /**
     * Get requests received by the current tenant.
     */
    public function incomingRequests(Request $request): JsonResponse
    {
        $tenant = Tenant::findOrFail($request->header('X-Tenant'));
        $requests = ExternalObserver::where('to', $tenant->id)->where('status', 'pending')->get();
        return response()->json(['data' => $requests]);
    }

    /**
     * Accept an incoming request.
     */
    public function acceptRequest(Request $request, $request_id): JsonResponse
    {
        $accessRequest = ExternalObserver::where('to', $request->header('X-Tenant'))
            ->where('status', 'pending')
            ->findOrFail($request_id);

        $originTenant = Tenant::findOrFail($accessRequest->from);
        $applicantUuid = $accessRequest->applied_by_uuid;

        $applicantData = $originTenant->run(function () use ($applicantUuid) {
            $user = User::where('external_id', $applicantUuid)->first();

            if ($user) {
                $data = $user->makeVisible(['password'])->toArray();

                unset($data['id']);
                return $data;
            }

            return null;
        });

        if (!$applicantData) {
            return response()->json(['error' => 'Applicant user not found in the origin tenant.'], 404);
        }

        tenancy()->initialize($request->header('X-Tenant'));

        DB::transaction(function () use ($accessRequest, $applicantData, $request) {
            $user = $this->userService->create($applicantData);

            $user->assignRole('external_observer');

            $user->syncPermissions($request->input('permissions'));

            $authData = [
                'tenant_id'   => $request->header('X-Tenant'),
                'roles'        => ['external_observer'],
                'permissions' => $request->input('permissions')
            ];


            Redis::set("user:{$user->external_id}:auth", json_encode($authData));

            $accessRequest->update([
                'status' => 'approved',
                'action_by' => auth()->user()->id
            ]);
        });

        return response()->json([

            'message' => 'Request accepted and user copied successfully.'
        ]);
    }

    /**
     * Reject an incoming request.
     */
    public function rejectRequest(Request $request, $request_id): JsonResponse
    {
        $accessRequest = ExternalObserver::where('to', $request->header('X-Tenant'))
            ->where('status', 'pending')
            ->findOrFail($request_id);

        $accessRequest->update(['status' => 'rejected', 'action_by' => auth()->user()->id]);

        $accessRequest->save();

        return response()->json(['message' => 'Request rejected successfully.']);
    }

    public function subsidiaries(Request $request): JsonResponse
    {
        $currentTenant = Tenant::findOrFail($request->header('X-Tenant'));
        $subsidiaries = ExternalObserver::where('from', $currentTenant->id)->where('status', 'approved')->get();
        return response()->json(['data' => $subsidiaries]);
    }
}

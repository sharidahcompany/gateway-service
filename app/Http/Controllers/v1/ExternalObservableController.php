<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\ExternalObservable;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExternalObservableController extends Controller
{
    /**
     * Send an access request to another tenant.
     */
    public function requestAccess(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'to' => 'required|exists:tenants,id', // Ensure the target tenant actually exists
        ]);

        $currentTenant = Tenant::findOrFail($request->header('X-Tenant')); // Assumes your multi-tenancy package provides this

        // Prevent a tenant from requesting access to themselves
        if ($currentTenant->id === $validated['to']) {
            return response()->json(['message' => 'You cannot request access to yourself.'], 422);
        }

        // Prevent duplicate pending/accepted requests
        $exists = ExternalObservable::where('from', $currentTenant->id)
            ->where('to', $validated['to'])
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'A request already exists or has been accepted.'], 422);
        }

        $targetTenant = Tenant::findOrFail($validated['to']);

        $accessRequest = ExternalObservable::create([
            'from'      => $currentTenant->id,
            'from_name' => $currentTenant->name,
            'to'        => $targetTenant->id,
            'to_name'   => $targetTenant->name,
            'status'    => 'pending',
        ]);

        return response()->json(['message' => 'Request sent successfully.', 'data' => $accessRequest], 210);
    }

    /**
     * Get requests sent by the current tenant.
     */
    public function outgoingRequests(Request $request): JsonResponse
    {
        $tenant = Tenant::findOrFail($request->header('X-Tenant'));
        $requests = ExternalObservable::where('from', $tenant->id)->get();
        return response()->json(['data' => $requests]);
    }

    /**
     * Get requests received by the current tenant.
     */
    public function incomingRequests(Request $request): JsonResponse
    {
        $tenant = Tenant::findOrFail($request->header('X-Tenant'));
        $requests = ExternalObservable::where('to', $tenant->id)->where('status', 'pending')->get();
        return response()->json(['data' => $requests]);
    }

    /**
     * Accept an incoming request.
     */
    public function acceptRequest(Request $request, $request_id): JsonResponse
    {
        $accessRequest = ExternalObservable::where('to', $request->header('X-Tenant'))
            ->where('status', 'pending')
            ->findOrFail($request_id);

        $accessRequest->update(['status' => 'approved']);

        return response()->json(['message' => 'Request accepted successfully.']);
    }

    /**
     * Reject an incoming request.
     */
    public function rejectRequest(Request $request, $request_id): JsonResponse
    {
        // SECURE: Scoped to ensure only the receiving tenant can reject it
        $accessRequest = ExternalObservable::where('to', $request->header('X-Tenant'))
            ->where('status', 'pending')
            ->findOrFail($request_id);

        $accessRequest->update(['status' => 'rejected']);

        return response()->json(['message' => 'Request rejected successfully.']);
    }

    public function subsidiaries(Request $request): JsonResponse
    {
        $currentTenant = Tenant::findOrFail($request->header('X-Tenant'));
        $subsidiaries = ExternalObservable::where('from', $currentTenant->id)->where('status', 'approved')->get();
        return response()->json(['data' => $subsidiaries]);
    }
}

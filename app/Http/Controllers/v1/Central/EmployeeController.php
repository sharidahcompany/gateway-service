<?php

namespace App\Http\Controllers\v1\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmployeeRequest;
use App\Http\Services\UserService;
use App\Mail\UserInvitationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class EmployeeController extends Controller
{
    public function __construct(
        protected UserService $user_service
    ) {}

    public function invite(EmployeeRequest $request)
    {
        $tenantId = $request->header('X-Tenant');
        $token = $request->bearerToken();
        $data = $request->validated();

        $data['user']['external_id'] = (string) Str::uuid();

        // 1. Workforce Sync
        $workforceResponse = Http::withToken($token)->acceptJson()
            ->withHeaders(['X-Tenant' => $tenantId])
            ->post('http://workforce-web/api/v1/users', $data['user']);

        if (!$workforceResponse->successful()) {
            // Try parsing JSON from the microservice response, fallback to raw body text
            $errorDetails = $workforceResponse->json() ?? $workforceResponse->body();

            return response()->json([
                'message' => 'Failed to sync with workforce microservice.',
                'microservice_status' => $workforceResponse->status(),
                'microservice_error' => $errorDetails
            ], $workforceResponse->status());
        }

        // 2. Accounting Sync
        $accountingResponse = Http::withToken($token)->acceptJson()
            ->withHeaders(['X-Tenant' => $tenantId])
            ->post('http://accounting-web/api/v1/users', $data['user']);

        if (!$accountingResponse->successful()) {
            $errorDetails = $accountingResponse->json() ?? $accountingResponse->body();

            return response()->json([
                'message' => 'Failed to sync with accounting microservice.',
                'microservice_status' => $accountingResponse->status(),
                'microservice_error' => $errorDetails
            ], $accountingResponse->status());
        }

        $user = DB::transaction(function () use ($data) {
            $createdUser = $this->user_service->create($data['user']);
            $createdUser->syncPermissions($data['permissions']);
            $createdUser->assignRole(['employee']);
            return $createdUser;
        });

        $experiences = [
            'user_external_id' => $user['external_id'],
            'experiences' => $data['experiences'],
        ];

        $exp = Http::withToken($token)->acceptJson()
            ->withHeaders(['X-Tenant' => $tenantId])
            ->post('http://workforce-web/api/v1/experiences', $experiences);

        if (!$exp->successful()) {
            $errorDetails = $exp->json() ??  $exp->body();

            return response()->json([
                'message' => 'Failed to sync with accounting microservice.',
                'microservice_status' =>  $exp->status(),
                'microservice_error' => $errorDetails
            ],  $exp->status());
        }

        tenancy()->end();

        $this->user_service->create($data['user']);

        // 5. Notification
        Mail::to($data['user']['email'])->send(new UserInvitationMail($tenantId, $user));

        return
            response()->json(['message' => 'تم ارسال دعوة عبر البريد الإلكتروني للموظف بنجاح.'], 200);
    }
}

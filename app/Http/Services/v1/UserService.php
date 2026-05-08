<?php

namespace App\Http\Services\v1;

use App\Http\Repositories\v1\UserRepository;
use App\Http\Services\v1\Kafka\KafkaProducerService;
use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function __construct(protected UserRepository $userRepo, protected KafkaProducerService $kafka) {}

    public function index()
    {
        return $this->userRepo->index();
    }

    public function create(array $data)
    {
        $tenantId = tenant('id');

        if (!$tenantId) {
            return response()->json([
                'message' => 'Tenant not found'
            ]);
        };
        return DB::transaction(function () use ($data, $tenantId) {
            $avatar = $data['avatar'] ?? null;

            unset($data['avatar']);


            $data['status'] = $data['status'] ?? 'active';
            $data['external_id'] = (string) Str::uuid();

            $user = $this->userRepo->create($data);



            $kafka_data = [
                'user' =>   $user,
                'tenant_id' =>      $tenantId
            ];

            $this->kafka->publish('user_created', $tenantId, $user->toArray());

            if ($avatar instanceof UploadedFile) {
                $user->addMedia($avatar)->toMediaCollection('avatar');
            }

            return $user;
        });
    }

    public function find(int $id): ?User
    {
        return $this->userRepo->find($id);
    }

    public function update(int $id, array $data): User
    {
        return DB::transaction(function () use ($id, $data) {
            $avatar = $data['avatar'] ?? null;
            unset($data['avatar']);

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user = $this->userRepo->update($id, $data);

            if ($avatar instanceof UploadedFile) {
                $user->clearMediaCollection('avatar');
                $user->addMedia($avatar)->toMediaCollection('avatar');
            }

            return $user;
        });
    }

    public function delete(array $ids)
    {
        return $this->userRepo->delete($ids);
    }

    public function confirm_email(array $data): string
    {
        $otp = OTP::where('user_id', $data['user_id'])
            ->where('otp', $data['otp'])
            ->first();

        if (!$otp) {
            return 'invalid';
        }

        if ($otp['expired_at']->isPast()) {
            return 'expired';
        }

        $user = $this->userRepo->find($data['user_id']);

        $user->email_verified_at = now();
        $user->save();

        $otp->delete();

        return 'success';
    }
    public function findByEmail(string $email)
    {
        return $this->userRepo->findByEmail($email);
    }
}

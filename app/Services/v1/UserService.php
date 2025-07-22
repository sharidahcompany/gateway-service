<?php

namespace App\Services\v1;

use App\Models\User;
use App\Repositories\v1\UserRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $userRepo)
    {

    }

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $avatar = $data['avatar'] ?? null;

            unset($data['avatar']);

            $data['password'] = Hash::make($data['password']);

            $user = $this->userRepo->create($data);

            if ($avatar instanceof UploadedFile) {
                $user->addMedia($avatar)->toMediaCollection('avatar');
            }

            return $user;
        });
    }

    public function find (int $id): ?User {
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

    public function delete(array $ids) {
        return $this->userRepo->delete($ids);
    }
}

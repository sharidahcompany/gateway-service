<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteMultipleRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\v1\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $user_service) {}

    public function index() {
        $users = $this->user_service->index();

        return UserResource::collection($users)->response()->setStatusCode(200);
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->user_service->create($data);

        return (new UserResource($user))
            ->additional([
                 'message' => trans('auth.register.success'),
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show($id) {
        $user = $this->user_service->find($id);

        return new UserResource($user);
    }

    public function update(int $id, UpdateUserRequest $request ) {

        $user = $this->user_service->update($id, $request->validated());

        return (new UserResource($user))->additional(['message' => trans('user.update.success')])->response()->setStatusCode(200);
    }
    public function destroy(DeleteMultipleRequest $request) {
        $ids = $request->get('ids');

        $this->user_service->delete($ids);

        return response()->json(['message' => trans('user.delete.success')], 200);
    }
}

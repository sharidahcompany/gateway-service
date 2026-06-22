<?php

namespace App\Http\Controllers\v1\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteMultipleRequest;
use App\Http\Requests\Tenant\CreateTenantRequest;
use App\Http\Requests\Tenant\SwitchTenantRequest;
use App\Http\Requests\Tenant\UpdateTenantRequest;
use App\Http\Resources\TenantResource;
use App\Http\Resources\UserResource;
use App\Http\Services\KafkaProducerService;
use App\Http\Services\TenantService;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function __construct(protected TenantService $tenantService, protected KafkaProducerService $kafka) {}
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);

        return TenantResource::collection(Tenant::latest()->paginate($limit));
    }

    public function store(CreateTenantRequest $request)
    {
        $data = $request->validated();

        $tenant = $this->tenantService->create($data);

        $user = Auth::user();

        $tenant->users()->attach($user->id);

        $tenant->run(function () use ($user) {

            Artisan::call('db:seed', [
                '--class' => \Database\Seeders\RoleSeeder::class,

            ]);

            Artisan::call('db:seed', [
                '--class' => \Database\Seeders\PermissionSeeder::class,

            ]);
            $tenant_user =  User::create([
                'external_id' => $user->external_id,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'username'   => $user->username,
                'email'      => $user->email,
                'phone'      => $user->phone,
                'password'   => $user->password,
                'status'     => $user->status ?? 'active',
            ]);

            $tenant_user->assignRole('owner');
        });

        $kafka_data = [
            'user' => $user->toArray(),
            'tenant_id' => $tenant?->id,
        ];

        $this->kafka->publish('tenant_created', null, $kafka_data);

        $tenant_id = $tenant->id;

        return (new TenantResource($tenant))->additional(['message' => trans('tenant.create.success'), 'tenant_id' => $tenant_id])
            ->response()
            ->setStatusCode(201);
    }

    public function show(string $id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant['logo'] = $tenant->getFirstMediaUrl('logo');

        return response()->json([
            'data' => $tenant,
        ]);
    }

    public function update(UpdateTenantRequest $request, string $id)
    {
        $data = $request->validated();

        $tenant = $this->tenantService->update($id, $data);

        return (new TenantResource($tenant))
            ->additional(['message' => trans('tenant.update.success')])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy_bulk(DeleteMultipleRequest $request)
    {
        $validated = $request->validated();

        $this->tenantService->delete($validated['ids']);

        return response()->json(['message' => trans('tenant.delete.success')], 200);
    }

    public function upload_logo(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $tenant = tenant();

        $tenant->clearMediaCollection('logo');

        $media = $tenant
            ->addMediaFromRequest('image')
            ->usingFileName('logo_' . time() . '.' . $request->image->extension())
            ->toMediaCollection('logo');

        return response()->json([
            'message' => 'Logo uploaded successfully',
            'logo' => $media->getFullUrl(),
        ]);
    }

    public function delete_logo(Request $request)
    {
        $tenant = tenant();

        $tenant->clearMediaCollection('logo');

        return response()->json([
            'message' => trans('crud.deleted'),
        ]);
    }

    public function switch(SwitchTenantRequest $request)
    {
        $validated = $request->validated();

        $tenant = Tenant::findOrFail($validated['tenant_id']);

        $user = auth()->user();

        return $tenant->run(function () use ($user) {
            $tenantUser = User::where('external_id', $user->external_id)->first();

            if ($tenantUser) {
                return (new UserResource($tenantUser->load('roles', 'permissions')))
                    ->response()
                    ->setStatusCode(200);
            }

            return response()->json([
                'message' => trans('Unauthenticated!')
            ], 401);
        });
    }}

<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteMultipleRequest;
use App\Http\Requests\Tenant\CreateTenantRequest;
use App\Http\Requests\Tenant\UpdateTenantRequest;
use App\Http\Resources\TenantResource;
use App\Services\v1\TenantService;

class TenantController extends Controller
{
    public function __construct(protected TenantService $tenantService)
    {

    }
    public function store( CreateTenantRequest $request )
    {
        $data = $request->validated();

        $tenant = $this->tenantService->create($data);

        return (new TenantResource($tenant))->additional(['message' => trans('tenant.create.success')])
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateTenantRequest $request, int $id)
    {
        $data = $request->validated();

        $tenant = $this->tenantService->update($id, $data);

        return (new TenantResource($tenant))
            ->additional(['message' => trans('tenant.update.success')])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(DeleteMultipleRequest $request) {
        $ids = $request->get('ids');

        $this->tenantService->delete($ids);

        return response()->json(['message' => trans('tenant.delete.success')], 200);
    }
}

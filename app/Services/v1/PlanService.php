<?php

namespace App\Services\v1;

use App\Models\Plan;
use App\Repositories\v1\PlanRepository;

class PlanService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected PlanRepository $plan_repository)
    {
        //
    }

    public function index()
    {
        return $this->plan_repository->index();
    }

    public function create(array $data) :Plan {
        return $this->plan_repository->create($data);
    }

    public function show(int $id):Plan {
        return $this->plan_repository->show($id);
    }

    public function update(int $id, array $data) :Plan
    {
        return $this->plan_repository->update($id, $data);
    }

    public function destroy(array $ids) {
        return $this->plan_repository->destroy($ids);
    }
}

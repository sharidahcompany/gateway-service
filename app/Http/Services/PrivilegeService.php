<?php

namespace App\Http\Services;

use App\Http\Repositories\PrivilegeRepository;

class PrivilegeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected PrivilegeRepository $privilege_repository)
    {
        //
    }

    public function index()
    {
        return $this->privilege_repository->index();
    }
}

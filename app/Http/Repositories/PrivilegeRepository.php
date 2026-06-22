<?php

namespace App\Http\Repositories;

use App\Models\Privilege;

class PrivilegeRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return Privilege::latest()->paginate(25);
    }
}

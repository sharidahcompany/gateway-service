<?php

namespace App\Http\Controllers\v1\Central;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->map(function ($permission) {
            return [
                'name' => $permission->name,
                'permission' => trans('permission.' . $permission->name)
            ];
        });
        return response()->json(['data' => $permissions], 200);
    }
}

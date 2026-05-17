<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'view-reports',
                'guard_name' => 'api',
            ],
            [
                'name' => 'view-hr',
                'guard_name' => 'api',
            ],
            [
                'name' => 'approve-leave-requests',
                'guard_name' => 'api',
            ],
            [
                'name' => 'approve-scholarship-requests',
                'guard_name' => 'api',
            ],
            [
                'name' => 'approve-mission-requests',
                'guard_name' => 'api',
            ],
            [
                'name' => 'view-accounting',
                'guard_name' => 'api',
            ],
            [
                'name' => 'reopen-closed-periods',
                'guard_name' => 'api',
            ],
            [
                'name' => 'view-project-management',
                'guard_name' => 'api',
            ],
            [
                'name' => 'assign-tasks',
                'guard_name' => 'api',
            ],
            [
                'name' => 'view-buffet',
                'guard_name' => 'api',
            ],
            [
                'name' => 'create-buffet-order',
                'guard_name' => 'api',
            ],
            [
                'name' => 'receive-buffet-order',
                'guard_name' => 'api',
            ],
            [
                'name' => 'make-interviews',
                'guard_name' => 'api',
            ]

        ];

        Permission::insert($permissions);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'owner',
                'guard_name' => 'api',
            ],
            [
                'name' => 'employee',
                'guard_name' => 'api',
            ],
            [
                'name' => 'job_seeker',
                'guard_name' => 'api',
            ],
            [
                'name' => 'customer',
                'guard_name' => 'api',
            ],
            [
                'name' => 'external_observer',
                'guard_name' => 'api',
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

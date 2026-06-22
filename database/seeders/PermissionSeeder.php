<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Modules Access
            [
              'name' => 'access_org_structure',
              'guard_name' => 'api',
            ],[
              'name' => 'access_hr',
              'guard_name' => 'api',
            ],[
              'name' => 'access_accounting',
              'guard_name' => 'api',
            ],[
              'name' => 'access_project_management',
              'guard_name' => 'api',
            ],[
              'name' => 'access_website_setting',
              'guard_name' => 'api',
            ],[
              'name' => 'access_buffet',
              'guard_name' => 'api',
            ],[
              'name' => 'access_external_observer',
              'guard_name' => 'api',
            ],

            // Home
            [
                'name' => 'view_home_reports',
                'guard_name' => 'api',
            ],
            // Project Management
            // Projects
            [
                'name' => 'view_projects',
                'guard_name' => 'api',
            ],
            [
                'name' => 'create_project',
                'guard_name' => 'api',
            ],
            [
                'name' => 'update_project',
                'guard_name' => 'api',
            ],
            [
                'name' => 'delete_project',
                'guard_name' => 'api',
            ],
            // Project Tasks
            [
                'name' => 'view_tasks',
                'guard_name' => 'api',
            ],
            [
                'name' => 'create_task',
                'guard_name' => 'api',
            ],
            [
                'name' => 'update_task',
                'guard_name' => 'api',
            ],
            [
                'name' => 'delete_task',
                'guard_name' => 'api',
            ],
            // Project Team
            [
                'name' => 'view_project_team',
                'guard_name' => 'api',
            ],
            [
                'name' => 'add_team_member_to_project',
                'guard_name' => 'api',
            ],
            [
                'name' => 'delete_team_member_from_project',
                'guard_name' => 'api',
            ],
            // Project Files
            [
                'name' => 'view_project_files',
                'guard_name' => 'api',
            ],
            [
                'name' => 'upload_files_to_project',
                'guard_name' => 'api',
            ],
            [
                'name' => 'delete_files_from_project',
                'guard_name' => 'api',
            ],
            // Organization Structure
            // Branches
            [
                'name' => 'view_branches',
                'guard_name' => 'api',
            ],
            [
                'name' => 'create_branch',
                'guard_name' => 'api',
            ],
            [
                'name' => 'update_branch',
                'guard_name' => 'api',
            ],
            [
                'name' => 'delete_branch',
                'guard_name' => 'api',
            ],
            // Departments
            [
                'name' => 'view_departments',
                'guard_name' => 'api',
            ],
            [
                'name' => 'create_department',
                'guard_name' => 'api',
            ],
            [
                'name' => 'update_department',
                'guard_name' => 'api',
            ],
            [
                'name' => 'delete_department',
                'guard_name' => 'api',
            ],

            // HR
            // Employees
            [
                'name' => 'view_employees',
                'guard_name' => 'api',
            ],
            [
                'name' => 'create_employees',
                'guard_name' => 'api',
            ],
            [
                'name' => 'update_employees',
                'guard_name' => 'api',
            ],
            [
                'name' => 'delete_employees',
                'guard_name' => 'api',
            ],
            // Jobs
            [
                'name' => 'view_jobs',
                'guard_name' => 'api',
            ],
            [
                'name' => 'create_jobs',
                'guard_name' => 'api',
            ], [
                'name' => 'update_jobs',
                'guard_name' => 'api',
            ], [
                'name' => 'delete_jobs',
                'guard_name' => 'api',
            ],
            // Job Posts
            [
                'name' => 'view_job_posts',
                'guard_name' => 'api'
            ], [
                'name' => 'create_job_posts',
                'guard_name' => 'api'
            ], [
                'name' => 'update_job_posts',
                'guard_name' => 'api'
            ], [
                'name' => 'delete_job_posts',
                'guard_name' => 'api'
            ],
            // Job Applications
            [
                'name' => 'view_job_applications',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_job_applications',
                'guard_name' => 'api'
            ],
            // Interviews
            [
                'name' => 'view_interviews',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_interviews',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_interviews',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_interviews',
                'guard_name' => 'api'
            ],
            // Shifts
            [
                'name' => 'view_shifts',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_shifts',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_shifts',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_shifts',
                'guard_name' => 'api'
            ],
            // Holidays
            [
                'name' => 'view_holidays',
                'guard_name' => 'api'
            ],[
                'name' => 'create_holidays',
                'guard_name' => 'api'
            ],[
                'name' => 'update_holidays',
                'guard_name' => 'api'
            ],[
                'name' => 'delete_holidays',
                'guard_name' => 'api'
            ],
            // Attendance
            [
                'name' => 'view_attendance',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_attendance',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_attendance',
                'guard_name' => 'api'
            ],
            // Missions
            [
                'name' => 'view_missions',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_missions',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_missions',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_missions',
                'guard_name' => 'api'
            ],
            // Attendance_Permissions
            [
                'name' => 'view_attendance_permissions',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_attendance_permissions',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_attendance_permissions',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_attendance_permissions',
                'guard_name' => 'api'
            ],
            // Scholarships
            [
                'name' => 'view_scholarships',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_scholarships',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_scholarships',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_scholarships',
                'guard_name' => 'api'
            ],
            // Scholarship Requests
            [
                'name' => 'view_scholarship_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_scholarship_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_scholarship_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_scholarship_requests',
                'guard_name' => 'api'
            ],
            // Leave Requests
            [
                'name' => 'view_leave_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_leave_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_leave_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_leave_requests',
                'guard_name' => 'api'
            ],
            // Mission Requests
            [
                'name' => 'view_mission_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_mission_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'update_mission_requests',
                'guard_name' => 'api'
            ],
            [
                'name' => 'delete_mission_requests',
                'guard_name' => 'api'
            ],
            // Accounting
            [
                'name' => 'view_financial_reports',
                'guard_name' => 'api'
            ],[
                'name' => 'view_sales',
                'guard_name' => 'api'
            ],[
                'name' => 'view_purchases',
                'guard_name' => 'api'
            ],[
                'name' => 'view_customers',
                'guard_name' => 'api'
            ],[
                'name' => 'view_payroll',
                'guard_name' => 'api'
            ],[
                'name' => 'view_inventory',
                'guard_name' => 'api'
            ],[
                'name' => 'view_accounting',
                'guard_name' => 'api'
            ],[
                'name' => 'view_cost_centers',
                'guard_name' => 'api'
            ],[
                'name' => 'view_bank_accounts',
                'guard_name' => 'api'
            ],[
                'name' => 'view_fixed_assets',
                'guard_name' => 'api'
            ],
            // Buffet
            [
                'name' => 'manage_buffet',
                'guard_name' => 'api'
            ],
            [
                'name' => 'create_buffet_orders',
                'guard_name' => 'api'
            ]
        ];

        Permission::insert($permissions);
    }
}

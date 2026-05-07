<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    return response()->json([
        "status" => "success",
        "data" => [
            "stats" => [
                "active_tasks" => "23",
                "active_tasks_change" => "+12%",
                "is_tasks_positive" => true,

                "orders_today" => "89",
                "orders_today_change" => "+12%",
                "is_orders_positive" => true,

                "attendance" => "95%",
                "attendance_change" => "-2%",
                "is_attendance_positive" => false,
            ],

            "main_services" => [
                [
                    "id" => "1",
                    "title" => "إدارة المشاريع",
                    "subtitle" => "متابعة المهام والجدول الزمني",
                    "icon_url" => "https://api.sharidah.com/icons/project.png",
                    "hex_color" => "#FFCC00",
                    "is_icon_colored" => false,
                    "route_name" => "/dashboard/pm",
                ],
                [
                    "id" => "2",
                    "title" => "الموارد البشرية",
                    "subtitle" => "إدارة الموظفين والطلبات",
                    "icon_url" => "https://api.sharidah.com/icons/hr.png",
                    "hex_color" => "#10B981",
                    "is_icon_colored" => false,
                    "route_name" => "/dashboard/hr",
                ],
                [
                    "id" => "3",
                    "title" => "الهيكل التنظيمي",
                    "subtitle" => "إدارة الأقسام والمسميات الوظيفية",
                    "icon_url" => "https://api.sharidah.com/icons/project.png",
                    "hex_color" => "#FFCC00",
                    "is_icon_colored" => false,
                    "route_name" => "/dashboard/organizational-structure",
                ],
                [
                    "id" => "4",
                    "title" => "البوفية",
                    "subtitle" => "متابعة الطلبات والمشروبات اليومية",
                    "icon_url" => "https://api.sharidah.com/icons/project.png",
                    "hex_color" => "#FFCC00",
                    "is_icon_colored" => false,
                    "route_name" => "/dashboard/buffet",
                ],
                
            ],

            "project_overview" => [
                "active_projects_count" => 12,
                "completion_stats" => [
                    "completed" => 45,
                    "in_progress" => 23,
                    "pending" => 15,
                    "total_percentage" => 54,
                ],
                "featured_projects" => [
                    [
                        "name" => "تطبيق الهاتف",
                        "total_tasks" => 26,
                        "done_tasks" => 15,
                        "pending_tasks" => 8,
                        "color" => "#FFCC00",
                    ],
                    [
                        "name" => "تحديث الموقع",
                        "total_tasks" => 19,
                        "done_tasks" => 12,
                        "pending_tasks" => 5,
                        "color" => "#10B981",
                    ],
                ],
            ],

            "buffet_overview" => [
                "today_orders" => 129,
                "stats" => [
                    "drinks" => [
                        "value" => "69",
                        "change" => "+12%",
                    ],
                    "meals" => [
                        "value" => "60",
                        "change" => "+8%",
                    ],
                ],
                "chart_data" => [
                    ["label" => "سلطة", "value" => 16],
                    ["label" => "شاي", "value" => 18],
                    ["label" => "ساندوتش", "value" => 20],
                    ["label" => "قهوة", "value" => 24],
                ],
            ],

            "recent_activities" => [
                [
                    "title" => "تم إضافة مهمة جديدة",
                    "subtitle" => "مشروع تطبيق الجوال",
                    "time_ago" => "منذ 5 دقائق",
                    "type" => "assignment",
                    "hex_color" => "#FFCC00",
                ],
                [
                    "title" => "طلب بوفيه جديد",
                    "subtitle" => "قهوة تركية - مكتب 10",
                    "time_ago" => "منذ 15 دقيقة",
                    "type" => "coffee",
                    "hex_color" => "#795548",
                ],
            ],
        ],
    ]);
}
}

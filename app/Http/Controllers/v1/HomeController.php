<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                        "title" => __("home.main_services.project_management.title"),
                        "subtitle" => __("home.main_services.project_management.subtitle"),
                        "icon_url" => "https://api.sharidah.com/icons/project.png",
                        "hex_color" => "#FFCC00",
                        "is_icon_colored" => false,
                        "route_name" => "/dashboard/pm",
                    ],
                    [
                        "id" => "2",
                        "title" => __("home.main_services.human_resources.title"),
                        "subtitle" => __("home.main_services.human_resources.subtitle"),
                        "icon_url" => "https://api.sharidah.com/icons/hr.png",
                        "hex_color" => "#10B981",
                        "is_icon_colored" => false,
                        "route_name" => "/dashboard/hr",
                    ],
                    [
                        "id" => "3",
                        "title" => __("home.main_services.accounting.title"),
                        "subtitle" => __("home.main_services.accounting.subtitle"),
                        "icon_url" => "https://api.sharidah.com/icons/hr.png",
                        "hex_color" => "#10B981",
                        "is_icon_colored" => false,
                        "route_name" => "/accounting",
                    ],
                    [
                        "id" => "4",
                        "title" => __("home.main_services.organizational_structure.title"),
                        "subtitle" => __("home.main_services.organizational_structure.subtitle"),
                        "icon_url" => "https://api.sharidah.com/icons/project.png",
                        "hex_color" => "#FFCC00",
                        "is_icon_colored" => false,
                        "route_name" => "/dashboard/organizational-structure",
                    ],
                    [
                        "id" => "5",
                        "title" => __("home.main_services.buffet.title"),
                        "subtitle" => __("home.main_services.buffet.subtitle"),
                        "icon_url" => "https://api.sharidah.com/icons/project.png",
                        "hex_color" => "#FFCC00",
                        "is_icon_colored" => false,
                        "route_name" => "/dashboard/settings/branch-buffets",
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
                            "name" => __("home.project_overview.mobile_app"),
                            "total_tasks" => 26,
                            "done_tasks" => 15,
                            "pending_tasks" => 8,
                            "color" => "#FFCC00",
                        ],
                        [
                            "name" => __("home.project_overview.website_update"),
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
                        ["label" => __("home.buffet.salad"), "value" => 16],
                        ["label" => __("home.buffet.tea"), "value" => 18],
                        ["label" => __("home.buffet.sandwich"), "value" => 20],
                        ["label" => __("home.buffet.coffee"), "value" => 24],
                    ],
                ],

                "recent_activities" => [
                    [
                        "title" => __("home.recent_activities.new_task_added"),
                        "subtitle" => __("home.recent_activities.mobile_app_project"),
                        "time_ago" => __("home.recent_activities.five_minutes_ago"),
                        "type" => "assignment",
                        "hex_color" => "#FFCC00",
                    ],
                    [
                        "title" => __("home.recent_activities.new_buffet_order"),
                        "subtitle" => __("home.recent_activities.turkish_coffee_office_10"),
                        "time_ago" => __("home.recent_activities.fifteen_minutes_ago"),
                        "type" => "coffee",
                        "hex_color" => "#795548",
                    ],
                ],
            ],
        ]);
    }
}

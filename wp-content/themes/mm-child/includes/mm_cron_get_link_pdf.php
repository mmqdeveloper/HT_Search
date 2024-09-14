<?php

// if (!function_exists('mm_add_weekly_cron_schedule')) {
//     function mm_add_weekly_cron_schedule($schedules) {
//         if (!isset($schedules['weekly'])) {
//             $schedules['weekly'] = array(
//                 'interval' => 604800,
//                 'display' => __('Once Weekly'),
//             );
//         }
//         return $schedules;
//     }
//     add_filter('cron_schedules', 'mm_add_weekly_cron_schedule');
// }

// if (!wp_next_scheduled('mm_cron_fetch_hotel_pdf')) {
//     wp_schedule_event(time(), 'weekly', 'mm_cron_fetch_hotel_pdf');
// }

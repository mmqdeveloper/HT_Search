<?php

//Create cruise post type
if (!function_exists('mm_cruise_post_type')) {
    function mm_cruise_post_type()
    {
        $labels = array(
            'name' => _x('Cruise', ''),
            'singular_name' => _x('Cruise', ''),
            'add_new' => __('Add New', ''),
            'add_new_item' => __('Add New Cruise', ''),
            'new_item' => __('New Cruise', ''),
            'edit_item' => __('Edit Cruise', ''),
            'view_item' => __('View Cruise', ''),
            'all_items' => __('All Cruise', '')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'rewrite' => array('slug' => 'excursions', 'with_front' => true),
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => null,
            'taxonomies' => array('post_tag'),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'genesis-seo',
                'custom-fields',
                'page-attributes'
            )
        );

        register_post_type('cruise', $args);
    }

    add_action('init', 'mm_cruise_post_type');
}

// Hide posts drafts
function mm_exclude_drafts_from_tours($options, $field, $the_post)
{
    $options['post_status'] = array('publish');
    return $options;
}

add_filter('acf/fields/post_object/query/name=tours_available_day_1', 'mm_exclude_drafts_from_tours', 10, 3);
add_filter('acf/fields/post_object/query/name=tours_available_day_2', 'mm_exclude_drafts_from_tours', 10, 3);

// Define the shortcode function for displaying breadcrumbs
if (!function_exists('mm_custom_breadcrumb_shortcode')) {
    function mm_custom_breadcrumb_shortcode()
    {

        $breadcrumbs = '<div class="breadcrumbs">' . cruise_breadcrumb_content() . '</div>';

        return $breadcrumbs;
    }

    add_shortcode('cruise_breadcrumb', 'mm_custom_breadcrumb_shortcode');
}

// Function to generate breadcrumb content
if (!function_exists('cruise_breadcrumb_content')) {
    function cruise_breadcrumb_content()
    {
        $output = '';

        if (!is_home() && !is_front_page()) {
            $output .= '<a href="' . home_url() . '">Hawaii Tours</a>';
        }

        if (is_singular() && get_post_type() == 'cruise') {
            $output .= '<a href="' . get_site_url() . '/shore-excursions">Excursions</a>';
        }

        if (is_single()) {
            $output .= '<span>' . get_the_title() . '</span>';
        }

        if (is_page()) {
            $output .= '<span>' . get_the_title() . '</span>';
        }

        return $output;
    }
}

function mm_handle_cruise_ship_date_to_json($post_id)
{
    $json_data = get_field('cruise_ship_dates', $post_id);
    $cruise_ship_data = [];

    $data_dates_path = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/mm-cruise-dates/data_dates.json';
    $data = (array)wp_json_file_decode($data_dates_path);
    if ($json_data) {
        foreach ($json_data as $value) {
            // Convert minutes to decimal
            $minutes_decimal = $value['duration_minute'] / 60;

            // Combine hours and minutes
            $duration_decimal = $value['duration_time'] + $minutes_decimal;
            $value['duration_time'] = $duration_decimal;
            if (!in_array($value['arrival_date'], $data, true)) {
                $data[] = $value['arrival_date'];
            }

            $cruise_ship_data[] = $value;

            if ($value['duration_time'] > 24 & $value['duration_time'] <= 48) {
                $arr_day2 = $value;
                $cruise_ship_date = DateTime::createFromFormat("m-d-Y", $value['arrival_date'])->modify("+1 day")->format('m-d-Y');
                $arr_day2 = array_replace($arr_day2, array('arrival_date' => $cruise_ship_date));
                $arr_day2 = array_merge($arr_day2, array('day2' => true));
                $cruise_ship_data[] = $arr_day2;
                if (!in_array($cruise_ship_date, $data, true)) {
                    $data[] = $cruise_ship_date;
                }
            }elseif ($value['duration_time'] > 48) {
                $arr_day2 = $value;
                $cruise_ship_date = DateTime::createFromFormat("m-d-Y", $value['arrival_date'])->modify("+1 day")->format('m-d-Y');
                $arr_day2 = array_replace($arr_day2, array('arrival_date' => $cruise_ship_date));
                $arr_day2 = array_merge($arr_day2, array('day2' => true));
                $arr_day2 = array_merge($arr_day2, array('day_mid' => true));
                $cruise_ship_data[] = $arr_day2;
                if (!in_array($cruise_ship_date, $data, true)) {
                    $data[] = $cruise_ship_date;
                }
                $arr_day3 = $value;
                $cruise_ship_date = DateTime::createFromFormat("m-d-Y", $value['arrival_date'])->modify("+2 day")->format('m-d-Y');
                $arr_day3 = array_replace($arr_day3, array('arrival_date' => $cruise_ship_date));
                $arr_day3 = array_merge($arr_day3, array('day3' => true));
                $cruise_ship_data[] = $arr_day3;
                if (!in_array($cruise_ship_date, $data, true)) {
                    $data[] = $cruise_ship_date;
                }
            }
        }
    }

    $dateHawaii = new DateTime();
    $dateHawaii->setTimezone(new DateTimeZone('Pacific/Honolulu'));
    $current_date = $dateHawaii->format("m-d-Y");
    $data_new = [];
    if ($data) {
        foreach ($data as $date) {

            if ($date >= $current_date) {
                $data_new[] = $date;
            }
        }
    }

    $uploads_dir = wp_upload_dir();
    $folder_path = trailingslashit($uploads_dir['basedir']) . 'mm-cruise-dates/';

    if (!file_exists($folder_path)) {
        if (!wp_mkdir_p($folder_path)) {
            error_log('Failed to create folder: ' . $folder_path);
            return;
        }
    }

    // Create or update the JSON file
    $file_path = $folder_path . $post_id . '.json';
    $file_data_dates = $folder_path . 'data_dates.json';
    if ($cruise_ship_data & !file_put_contents($file_path, json_encode($cruise_ship_data))) {
        error_log('Failed to create file: ' . $file_path);
    }
    if ($data_new & !file_put_contents($file_data_dates, json_encode($data_new))) {
        error_log('Failed to create file: ' . $file_data_dates);
    }
}

// Save Cruise Ship json data

if (!function_exists('save_cruise_ship_json_data')) {
    function save_cruise_ship_json_data($post_id)
    {
        // Check if this is not an autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        if (get_post_type($post_id) !== 'cruise') return;

        mm_handle_cruise_ship_date_to_json($post_id);
    }

    add_action('acf/save_post', 'save_cruise_ship_json_data', 30);
}

if (!function_exists('mm_cruise_calendar_list')) {
    function mm_cruise_calendar_list()
    {
        ob_start();
        global $post;
        $post_id = $post->ID;

        $folder_path = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/mm-cruise-dates/' . $post_id . '.json';
        $data = wp_json_file_decode($folder_path);

        $arrival_dates = array_map(function ($item) {
            return $item->arrival_date;
        }, $data);


        $dateHawaii = new DateTime();
        $dateHawaii->setTimezone(new DateTimeZone('Pacific/Honolulu'));
        $dateHawaii->modify('+1 day');
        $currentTimestamp = strtotime($dateHawaii->format("m/d/Y"));
        $closestDate = $_GET['date'];
        if (empty($closestDate)) {
            $closestDiff = PHP_INT_MAX;
            foreach ($data as $value) {
                $tourTimestamp = strtotime(str_replace('-', '/', $value->arrival_date));
                if ($tourTimestamp >= $currentTimestamp) {
                    $diff = abs($currentTimestamp - $tourTimestamp);

                    if ($diff < $closestDiff) {
                        $closestDiff = $diff;
                        $closestDate = $value->arrival_date;
                    }
                }
            }
        }

        $i = array_search($closestDate, array_column($data, 'arrival_date'));
        $getCruiseShip = ($i !== false ? $data[$i] : null);

        $cruiseShipInfo = [
            'cruise-ship' => get_post_field('post_name', $post_id),
            'cruise-destination' => $getCruiseShip->destination,
            'cruise-date' => $closestDate,
            'cruise-time' => $getCruiseShip->arrival_time
        ];

        $sailing_day = $closestDate;
        if ($getCruiseShip->day2) {
            $day = 2;
            $sailing_day = DateTime::createFromFormat("m-d-Y", $closestDate)->modify("-1 day")->format('m-d-Y');
        }elseif ($getCruiseShip->day3) {
            $day = 3;
            $sailing_day = DateTime::createFromFormat("m-d-Y", $closestDate)->modify("-2 day")->format('m-d-Y');
        } else {
            $day = 1;
        }

        $cruiseShipName = json_encode(get_post_field('post_name', $post_id));
        $cruiseShipData = json_encode($getCruiseShip);
        $cruiseShipDataJson = json_encode($data);
        $dates = json_encode($arrival_dates);
        $sailing_day = json_encode($sailing_day);
        $excerpt = get_the_excerpt();
        $html = '<div class="cs-calendar-and-info"><div class="cs-calender-box"><div id="datepicker" class="cruise-ship-calender">
               </div></div>';
        $html .= '<div class="cs-info">';
        $html .= '<img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDkiIGhlaWdodD0iNDkiIHZpZXdCb3g9IjAgMCA0OSA0OSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzQ0MV81NDcpIj4KPHBhdGggZD0iTTM3Ljk0MDEgMjAuMjc1OFYxMi4wMTk4SDMyLjE4MDFWNi4yNTk3N0gxNi44MjAxVjEyLjAxOThIMTEuMDYwMVYyMC4yNzU4IiBzdHJva2U9IiMyMTg5QzEiIHN0cm9rZS13aWR0aD0iMS45MiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yNC41IDAuNVY1Ljc4IiBzdHJva2U9IiMyMTg5QzEiIHN0cm9rZS13aWR0aD0iMy44NCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIi8+CjxwYXRoIGQ9Ik00MC44MTk5IDQyLjI2MDRWMzMuMTQwNEw0NC4zNzE5IDI1LjQ2MDRDNDUuMDQzOSAyNC4xMTY0IDQ0LjI3NTkgMjIuNDg0NCA0Mi44MzU5IDIyLjAwNDRMMjQuNDk5OSAxNS44NjA0TDYuMDY3ODkgMjIuMDA0NEM0LjYyNzg5IDIyLjQ4NDQgMy45NTU4OSAyNC4xMTY0IDQuNTMxODkgMjUuNDYwNEw4LjE3OTg5IDMzLjE0MDRWNDIuMjYwNCIgc3Ryb2tlPSIjMjE4OUMxIiBzdHJva2Utd2lkdGg9IjEuOTIiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik00Ny41NCA0My4zMTU3QzQ3LjA2IDQzLjUwNzcgNDYuNDg0IDQzLjYwMzcgNDUuODEyIDQzLjYwMzdDNDQuMzcyIDQzLjYwMzcgNDIuMDY4IDQzLjIxOTcgNDAuNTMyIDQxLjk3MTdDMzguOTk2IDQzLjIxOTcgMzYuNjkyIDQzLjYwMzcgMzUuMjUyIDQzLjYwMzdDMzMuODEyIDQzLjYwMzcgMzEuNTA4IDQzLjIxOTcgMjkuOTcyIDQxLjk3MTdDMjguNDM2IDQzLjIxOTcgMjYuMTMyIDQzLjYwMzcgMjQuNjkyIDQzLjYwMzdDMjMuMjUyIDQzLjYwMzcgMjAuOTQ4IDQzLjIxOTcgMTkuNDEyIDQxLjk3MTdDMTcuODc2IDQzLjIxOTcgMTUuNTcyIDQzLjYwMzcgMTQuMTMyIDQzLjYwMzdDMTIuNjkyIDQzLjYwMzcgMTAuMzg4IDQzLjIxOTcgOC44NTE5OSA0MS45NzE3QzcuMzE1OTkgNDMuMjE5NyA1LjAxMTk5IDQzLjYwMzcgMy41NzE5OSA0My42MDM3QzIuODk5OTkgNDMuNjAzNyAyLjMyMzk5IDQzLjUwNzcgMS44NDM5OSA0My41MDc3IiBzdHJva2U9IiMyMTg5QzEiIHN0cm9rZS13aWR0aD0iMS45MiIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTQ3LjU0IDQ3LjE1NTVDNDcuMDYgNDcuMzQ3NSA0Ni40ODQgNDcuNDQzNSA0NS44MTIgNDcuNDQzNUM0NC4zNzIgNDcuNDQzNSA0Mi4wNjggNDcuMDU5NSA0MC41MzIgNDUuODExNUMzOC45OTYgNDcuMDU5NSAzNi42OTIgNDcuNDQzNSAzNS4yNTIgNDcuNDQzNUMzMy44MTIgNDcuNDQzNSAzMS41MDggNDcuMDU5NSAyOS45NzIgNDUuODExNUMyOC40MzYgNDcuMDU5NSAyNi4xMzIgNDcuNDQzNSAyNC42OTIgNDcuNDQzNUMyMy4yNTIgNDcuNDQzNSAyMC45NDggNDcuMDU5NSAxOS40MTIgNDUuODExNUMxNy44NzYgNDcuMDU5NSAxNS41NzIgNDcuNDQzNSAxNC4xMzIgNDcuNDQzNUMxMi42OTIgNDcuNDQzNSAxMC4zODggNDcuMDU5NSA4Ljg1MTk5IDQ1LjgxMTVDNy4zMTU5OSA0Ny4wNTk1IDUuMDExOTkgNDcuNDQzNSAzLjU3MTk5IDQ3LjQ0MzVDMi44OTk5OSA0Ny40NDM1IDIuMzIzOTkgNDcuMzQ3NSAxLjg0Mzk5IDQ3LjM0NzUiIHN0cm9rZT0iIzIxODlDMSIgc3Ryb2tlLXdpZHRoPSIxLjkyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPgo8cGF0aCBkPSJNMzIuNjYgMjkuM0MzMy40NTUzIDI5LjMgMzQuMSAyOC4yMjU1IDM0LjEgMjYuOUMzNC4xIDI1LjU3NDUgMzMuNDU1MyAyNC41IDMyLjY2IDI0LjVDMzEuODY0NyAyNC41IDMxLjIyIDI1LjU3NDUgMzEuMjIgMjYuOUMzMS4yMiAyOC4yMjU1IDMxLjg2NDcgMjkuMyAzMi42NiAyOS4zWiIgZmlsbD0iIzIxODlDMSIvPgo8cGF0aCBkPSJNMTYuMzM5OSAyOS4zQzE3LjEzNTIgMjkuMyAxNy43Nzk5IDI4LjIyNTUgMTcuNzc5OSAyNi45QzE3Ljc3OTkgMjUuNTc0NSAxNy4xMzUyIDI0LjUgMTYuMzM5OSAyNC41QzE1LjU0NDYgMjQuNSAxNC44OTk5IDI1LjU3NDUgMTQuODk5OSAyNi45QzE0Ljg5OTkgMjguMjI1NSAxNS41NDQ2IDI5LjMgMTYuMzM5OSAyOS4zWiIgZmlsbD0iIzIxODlDMSIvPgo8L2c+CjxkZWZzPgo8Y2xpcFBhdGggaWQ9ImNsaXAwXzQ0MV81NDciPgo8cmVjdCB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIGZpbGw9IndoaXRlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjUgMC41KSIvPgo8L2NsaXBQYXRoPgo8L2RlZnM+Cjwvc3ZnPgo=" />';
        $html .= '<h3 class="ship-name">' . get_the_title($post_id) . '</h3>';
        $html .= '<div class="cs-arrival-date-text">Sailing on <span class="cs-arrival-date"></span></div>';
        $html .= '<div class="cs-destination"><span class="cs-destination-label">Destination:&nbsp;</span><span class="cs-destination-text">0</span></div>';
        $html .= '<div class="cs-arrival-time"><span class="cs-arrival-time-label">Arrival time:&nbsp;</span><span class="cs-arrival-time-text">0</span></div>';
        $html .= '<div class="cs-dock-time"><span class="cs-dock-time-label">Dock time:&nbsp;</span><span class="cs-dock-time-text cs-dock-time-value">0</span></div>';
        $html .= '<a class="cs-view-excursions" href="#list-tours-box">VIEW EXCURSIONS</a>';
        $html .= '<div class="cs-excerpt">' . $excerpt . '</div>';
        $html .= '</div></div><div class="cs-tours-available">';
        $html .= '<div id="list-tours-box" class="list-tours-box">';
        if (!empty($getCruiseShip)) {
            $html .= '<div class="list-tours" id="list-tours">' . mm_load_tours_by_cruise_ship($getCruiseShip, $cruiseShipInfo, $day) . '</div>';
        } else {
            $html .= '<div class="list-tours" id="list-tours"><p style="margin-bottom: 0;font-size: 16px;text-align: center;">There are no available tours suitable for this cruise ship</p></div>';
        }
        $html .= '</div></div>' . ob_get_clean();
        ?>
        <script>
            jQuery(document).ready(function ($) {

                let availableDates =  <?php echo $dates; ?>;
                let cruiseShipData =  <?php echo $cruiseShipData; ?>;
                let cruiseShipDataJson =  <?php echo $cruiseShipDataJson; ?>;
                let cruiseShipName = <?php echo $cruiseShipName?>;
                let sailing_day = <?php echo $sailing_day?>;
                let defaultDate, dateSelect ='';

                if (cruiseShipData != null) {
                    var inputDate = new Date(Date.parse(sailing_day.replace(/-/g, '/')));
                    var formattedDate = inputDate.toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });
                    $('.cs-arrival-date').text(formattedDate);
                    $('.cs-destination-text').text(cruiseShipData.destination);
                    $('.cs-arrival-time-text').text(cruiseShipData.arrival_time);
                    $('.cs-dock-time-value').text(formatDuration(cruiseShipData.duration_time));

                    defaultDate = new Date(Date.parse(cruiseShipData.arrival_date.replace(/-/g, '/')));
                } else {
                    inputDate = new Date();
                    let currentDate = inputDate.toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });
                    $('.cs-arrival-date').text(currentDate);
                }

                function formatDuration(duration) {
                    let hours = Math.floor(duration);
                    let minutes = Math.round((duration - hours) * 60);
                    if (minutes !== 0) {
                        return hours + " Hours " + minutes + " Minutes";
                    }
                    return hours + " Hours";
                }

                function compareDates(formattedDate, dateNow) {
                    const formattedDateObj = new Date(Date.parse(formattedDate.replace(/-/g, '/')));
                    const dateNowObj = new Date(Date.parse(dateNow.replace(/-/g, '/')));

                    return formattedDateObj >= dateNowObj;
                }

                function pad(num) {
                    return String(num).padStart(2, '0');
                }

                let now = new Date();
                now.setDate(now.getDate() + 1);
                let dateNow = now.toLocaleString('en-US', {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                    timeZone: 'Pacific/Honolulu'
                });

                // Initialize datepicker
                $("#datepicker").datepicker({
                    beforeShowDay: function (date) {
                        var formattedDate = $.datepicker.formatDate('mm-dd-yy', date);
                        if ($.inArray(formattedDate, availableDates) !== -1 && compareDates(formattedDate, dateNow)) {
                            return [true, "available", "Available"]; // Available day
                        } else {
                            return [false, "unavailable", "Unavailable"]; // Unavailable day
                        }
                    },
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '2024:2025',
                    dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
                    defaultDate: defaultDate,
                    onSelect: function (dateText, inst) {
                        let day = '';
                        let cruiseShip = $.grep(cruiseShipDataJson, function (element, index) {
                            return (element.arrival_date === $.datepicker.formatDate('mm-dd-yy', new Date(dateText)));
                        });
                        if (cruiseShip[0].day2 !== undefined && cruiseShip[0].day2 === true) {
                            day = 2;
                            let date = new Date(dateText);
                            dateSelect = `${pad(date.getMonth() + 1)}-${pad(date.getDate())}-${date.getFullYear()}`;
                            date.setDate(date.getDate() - 1);
                            dateText = `${pad(date.getMonth() + 1)}-${pad(date.getDate())}-${date.getFullYear()}`;
                        }else if(cruiseShip[0].day3 !== undefined && cruiseShip[0].day3 === true) {
                            day = 3;
                            let date = new Date(dateText);
                            dateSelect = `${pad(date.getMonth() + 1)}-${pad(date.getDate())}-${date.getFullYear()}`;
                            date.setDate(date.getDate() - 2);
                            dateText = `${pad(date.getMonth() + 1)}-${pad(date.getDate())}-${date.getFullYear()}`;
                        } else {
                            day = 1;
                            let date = new Date(dateText);
                            dateSelect = `${pad(date.getMonth() + 1)}-${pad(date.getDate())}-${date.getFullYear()}`;
                        }
                        let inputDate = new Date(dateText);
                        let formattedDate = inputDate.toLocaleDateString('en-US', {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric'
                        });
                        $('.cs-arrival-date').text(formattedDate);
                        $('.cs-destination-text').text(cruiseShip[0].destination);
                        $('.cs-arrival-time-text').text(cruiseShip[0].arrival_time);
                        $('.cs-dock-time-value').text(formatDuration(cruiseShip[0].duration_time));
                        jQuery.ajax({
                            type: "post",
                            dataType: "html",
                            url: ajax_custom_js.ajax_url,
                            data: {
                                action: "load_tours_cruise_ship",
                                date: dateSelect,
                                day: day,
                                cruiseShip: cruiseShipName,
                                postId: <?php echo $post_id ?>
                            },
                            beforeSend: function () {
                                $('.list-tours').empty().append('<div class="loader"><span class="loader__dot"></span><span class="loader__dot"></span><span class="loader__dot"></span></div>');
                            },
                            success: function (response) {
                                $('.list-tours').empty().append(response);
                                jQuery('.products .inner_product_header').matchHeight();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });
                    }
                });
            });
        </script>
        <?php
        return $html;
    }

    add_shortcode('mm_cruise_calendar_list', 'mm_cruise_calendar_list');
}

if (!function_exists('mm_ajax_load_tours_cruise_ship')) {
    function mm_ajax_load_tours_cruise_ship()
    {
        $date = $_POST['date'];
        $post_id = $_POST['postId'];
        $day = $_POST['day'];

        $folder_path = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/mm-cruise-dates/' . $post_id . '.json';
        $data = wp_json_file_decode($folder_path);
        $i = array_search($date, array_column($data, 'arrival_date'));
        $getCruiseShip = ($i !== false ? $data[$i] : null);

        $cruiseShipInfo = [
            'cruise-ship' => $_POST['cruiseShip'],
            'cruise-destination' => $getCruiseShip->destination,
            'cruise-date' => $date,
            'cruise-time' => $getCruiseShip->arrival_time
        ];
        $result = mm_load_tours_by_cruise_ship($getCruiseShip, $cruiseShipInfo, $day);
        echo $result;
        wp_die();
    }

    add_action('wp_ajax_load_tours_cruise_ship', 'mm_ajax_load_tours_cruise_ship');
    add_action('wp_ajax_nopriv_load_tours_cruise_ship', 'mm_ajax_load_tours_cruise_ship');
}

if (!function_exists('mm_load_tours_by_cruise_ship')) {
    function mm_load_tours_by_cruise_ship($data, $cruise_ship_info, $day = null)
    {
        $html = '';
        $heading_day = '<h2 class="mm-mt4">TOP EXCURSIONS OF THE DAY FOR YOUR CRUISE SHIP</h2>';
        $heading_night = '<h2 class="mm-mt4">TOP NIGHT EXCURSIONS FOR YOUR CRUISE SHIP</h2>';
        if ($data) {
            if ($data->show_tours_by_tags & !empty($data->tours_tag_day_1)) {
                if ($day == 1) {
                    $arr = array(
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'id',
                                'terms' => $data->tours_tag_day_1,
                            )
                        ),
                    );
                    $cruise_day1 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 1, $data->duration_time);
                    if ($cruise_day1) {
                        $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day1 . '</div>';
                    }
                }

                if (!empty($data->tours_tag_day_2) & $data->duration_time > 24 & $day >= 2) {
                    if($data->duration_time > 48 & $data->day_mid) {
                        $term_ids = $data->tours_tag_day_1;
                        $term_ids = array_merge($term_ids, $data->tours_tag_day_2);
                    }else {
                        $term_ids = $data->tours_tag_day_2;
                    }
                    $arr = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'id',
                                'terms' => $term_ids,
                            ),
                        ),
                    );
                    $cruise_day2 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time, $data->day_mid);
                    if (!empty($cruise_day2)) {
                        $html .= '<div class="cs-list-tour-day2">' . $heading_day . $cruise_day2 . '</div>';
                    }
                }

            } elseif (!$data->show_tours_by_tags & !empty($data->tours_available_day_1)) {
                if ($day == 1) {
                    $arr = array(
                        'post__in' => $data->tours_available_day_1,
                        'orderby' => 'post__in',
                    );
                    $cruise_day1 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 1, $data->duration_time);
                    if ($cruise_day1) {
                        $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day1 . '</div>';
                    }
                }

                if (!empty($data->tours_available_day_2) & $data->duration_time > 24 & $day >= 2) {
                    if ($data->duration_time > 48 & $data->day_mid) {
                        $ids = $data->tours_available_day_1;
                        $ids = array_merge($ids, $data->tours_available_day_2 );
                    }else {
                        $ids = $data->tours_available_day_2;
                    }
                    $arr = array(
                        'post__in' => $ids,
                        'orderby' => 'post__in',
                    );
                    $cruise_day2 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time, $data->day_mid);
                    if ($cruise_day2) {
                        $html .= '<div class="cs-list-tour-day2">' . $heading_day . $cruise_day2 . '</div>';
                    }
                }

            } else {
                if (strpos($data->destination, 'Maui')) {
                    if ($day == 1) {
                        $terms = ['mauicruiseday1'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day1 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 1, $data->duration_time);
                        if (!empty($cruise_day1)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day1 . '</div>';
                        }
                    }

                    if ($data->duration_time > 24 & $day == 1) {
                        $terms = ['mauicruisenight'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_night = mm_layout_tours_cruise_ship($arr, $cruise_ship_info);
                        $content = get_option('cruise_ship_maui_night');
                        if (!empty($cruise_night)) {
                            $html .= $heading_night . '<p class="cs-content-day">' . $content . '</p>' . $cruise_night;
                        }
                    }
                    if ($data->duration_time > 48 & $data->day_mid) {
                        $terms = ['mauicruiseday1', 'mauicruisenight', 'mauicruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time, $data->day_mid);
                        if (!empty($cruise_day)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day . '</div>';
                        }
                    } elseif ($data->duration_time > 24 & $day >= 2 & !$data->day_mid) {
                        $terms = ['mauicruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day2 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time);
                        if (!empty($cruise_day2)) {
                            $html .= '<div class="cs-list-tour-day2">' . $heading_day . $cruise_day2 . '</div>';
                        }
                    }
                } elseif (strpos($data->destination, 'auai,')) {
                    if ($day == 1) {
                        $terms = ['kauaicruiseday1'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day1 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 1, $data->duration_time);
                        if (!empty($cruise_day1)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day1 . '</div>';
                        }
                    }

                    if ($data->duration_time > 24 & $day == 1) {
                        $terms = ['kauaicruisenight'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_night = mm_layout_tours_cruise_ship($arr, $cruise_ship_info);
                        $content = get_option('cruise_ship_kauai_night');
                        if (!empty($cruise_night)) {
                            $html .= $heading_night . '<p class="cs-content-day">' . $content . '</p>' . $cruise_night;
                        }
                    }
                    if ($data->duration_time > 48 & $data->day_mid) {
                        $terms = ['kauaicruiseday1', 'kauaicruisenight', 'kauaicruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time, $data->day_mid);
                        if (!empty($cruise_day)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day . '</div>';
                        }
                    } elseif ($data->duration_time > 24 & $day >= 2 & !$data->day_mid) {
                        $terms = ['kauaicruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day2 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time);
                        if (!empty($cruise_day2)) {
                            $html .= '<div class="cs-list-tour-day2">' . $heading_day . $cruise_day2 . '</div>';
                        }
                    }

                } elseif (strpos($data->destination, 'ahu,') & $cruise_ship_info['cruise-ship'] != 'pride-of-america') {
                    if ($day == 1) {
                        $terms = ['oahucruiseday1'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day1 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 1, $data->duration_time);
                        if (!empty($cruise_day1)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day1 . '</div>';
                        }
                    }

                    if ($data->duration_time > 24 & $day == 1) {
                        $terms = ['oahucruisenight'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_night = mm_layout_tours_cruise_ship($arr, $cruise_ship_info);
                        $content = get_option('cruise_ship_oahu_night');
                        if (!empty($cruise_night)) {
                            $html .= $heading_night . '<p class="cs-content-day">' . $content . '</p>' . $cruise_night;
                        }
                    }
                    if ($data->duration_time > 48 & $data->day_mid) {
                        $terms = ['oahucruiseday1', 'oahucruisenight', 'oahucruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time, $data->day_mid);
                        if (!empty($cruise_day)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day . '</div>';
                        }
                    } elseif ($data->duration_time > 24 & $day >= 2) {
                        $terms = ['oahucruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day2 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time);
                        if (!empty($cruise_day2)) {
                            $html .= '<div class="cs-list-tour-day2">' . $heading_day . $cruise_day2 . '</div>';
                        }
                    }

                } elseif (strpos($data->destination, 'Big Island')) {
                    if ($day == 1) {
                        $terms = ['bigislandcruiseday1'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day1 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 1, $data->duration_time);
                        if (!empty($cruise_day1)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day1 . '</div>';
                        }
                    }
                    if ($data->duration_time > 24 & $day == 1) {
                        $terms = ['bigislandcruisenight'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_night = mm_layout_tours_cruise_ship($arr, $cruise_ship_info);
                        $content = get_option('cruise_ship_bigisland_night');
                        if (!empty($cruise_night)) {
                            $html .= $heading_night . '<p class="cs-content-day">' . $content . '</p>' . $cruise_night;
                        }
                    }
                    if ($data->duration_time > 48 & $data->day_mid) {
                        $terms = ['bigislandcruiseday1', 'bigislandcruisenight', 'bigislandcruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time, $data->day_mid);
                        if (!empty($cruise_day)) {
                            $html .= '<div class="cs-list-tour-day1">' . $heading_day . $cruise_day . '</div>';
                        }
                    } elseif ($data->duration_time > 24 & $day >= 2 & !$data->day_mid) {
                        $terms = ['bigislandcruiseday2'];
                        $arr = array(
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field' => 'slug',
                                    'terms' => $terms,
                                ),
                            ),
                        );
                        $cruise_day2 = mm_layout_tours_cruise_ship($arr, $cruise_ship_info, true, 2, $data->duration_time);
                        if (!empty($cruise_day2)) {
                            $html .= '<div class="cs-list-tour-day2">' . $heading_day . $cruise_day2 . '</div>';
                        }
                    }
                }
            }

        } else {
            $html = '<p style="margin-bottom: 0;font-size: 16px;text-align: center;">There are no available tours suitable for this cruise ship</p>';
        }

        $html .= mm_load_transfers_cruise_ship($data, $cruise_ship_info);
        if($html) {
            return $html;
        }else {
            return '<p style="margin-bottom: 0;font-size: 16px;text-align: center;">There are no available tours suitable for this cruise ship</p>';
        }
    }
}

if (!function_exists('mm_load_transfers_cruise_ship')) {
    function mm_load_transfers_cruise_ship($data, $cruise_ship_info)
    {
        $html = '';
        $text = '<p>Here you can get a charter service to explore the island or you can reserve a shuttle transfer to your activities.</p>';
        if ($data) {
            $arr = array();
            if ($data->activity_transfers & !empty($data->activity_transfers_tag)) {
                $arr = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_tag',
                            'field' => 'id',
                            'terms' => $data->activity_transfers_tag,
                        ),
                    ),
                );
                $html = '<h2 class="mm-mt4">PIER SHUTTLES TO AIRPORT OR HOTELS & ACTIVITY TRANSFERS</h2>' . $text;
            } elseif ($data->activity_transfers & empty($data->activity_transfers_tag) || !$data->activity_transfers) {
                if (strpos($data->destination, 'Maui')) {
                    $terms = ['maui-transportation'];
                    $arr = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'slug',
                                'terms' => $terms,
                            ),
                        ),
                    );
                    $html = '<h2 class="mm-mt4">MAUI PIER SHUTTLES TO AIRPORT OR HOTELS & ACTIVITY TRANSFERS</h2>' . $text;
                } elseif (strpos($data->destination, 'auai')) {
                    $terms = ['kauai-transportation'];
                    $arr = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'slug',
                                'terms' => $terms,
                            ),
                        ),
                    );
                    $html = '<h2 class="mm-mt4">Kauai PIER SHUTTLES TO AIRPORT OR HOTELS & ACTIVITY TRANSFERS</h2>' . $text;
                } elseif (strpos($data->destination, 'ahu,')) {
                    $terms = ['oahu-transportation'];
                    $arr = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'slug',
                                'terms' => $terms,
                            ),
                        ),
                    );
                    $html = '<h2 class="mm-mt4">OAHU SHUTTLES TO AIRPORT OR HOTELS & ACTIVITY TRANSFERS</h2>' . $text;
                } elseif (strpos($data->destination, 'Big Island')) {
                    $terms = ['big-island-transportation'];
                    $arr = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'slug',
                                'terms' => $terms,
                            ),
                        ),
                    );
                    $html = '<h2 class="mm-mt4">Big Island SHUTTLES TO AIRPORT OR HOTELS & ACTIVITY TRANSFERS</h2>' . $text;
                } else {
                    return null;
                }
            }
            $cs_transportation = mm_layout_tours_cruise_ship($arr, $cruise_ship_info);
            if ($cs_transportation) {
                $html .= mm_layout_tours_cruise_ship($arr, $cruise_ship_info);
            } else {
                return null;
            }
        }
        return $html;
    }
}

function mm_calculate_leave_time($arrivalTime, $duration)
{
    $arrivalDateTime = DateTime::createFromFormat('m-d-Y g:i A', $arrivalTime);
    if (!$arrivalDateTime) {
        // Invalid arrival time format
        return "Invalid arrival time format";
    }
    list($hours, $minutes) = explode(':', $duration);

    $totalMinutes = ($hours * 60) + $minutes;

    if ($totalMinutes >= 1440) {
        $days = floor($totalMinutes / 1440); // 1440 minutes in a day
        $remainingMinutes = $totalMinutes % 1440;

        $arrivalDateTime->add(new DateInterval("P{$days}D"));

        $arrivalDateTime->add(new DateInterval("PT{$remainingMinutes}M"));
    } else {
        $arrivalDateTime->add(new DateInterval("PT{$totalMinutes}M"));
    }

    return $arrivalDateTime->format('g:i A');
}

function mm_layout_tours_cruise_ship($arr, $cruise_ship_info, $list_tour = false, $day = 1, $duration_time = 0, $day_mid = false)
{
    ob_start();
    $html = '';
    $content1 = $content2 = $content3 = '';
    $check_avail = false;
    if (strpos($cruise_ship_info['cruise-destination'], 'Maui')) {
        $content1 = get_option('cruise_ship_maui_day1');
        $content2 = get_option('cruise_ship_maui_day2');
        $content3 = get_option('cruise_ship_maui_middle');
    } elseif (strpos($cruise_ship_info['cruise-destination'], 'auai')) {
        $content1 = get_option('cruise_ship_kauai_day1');
        $content2 = get_option('cruise_ship_kauai_day2');
        $content3 = get_option('cruise_ship_kauai_middle');
    } elseif (strpos($cruise_ship_info['cruise-destination'], 'ahu,')) {
        $content1 = get_option('cruise_ship_oahu_day1');
        $content2 = get_option('cruise_ship_oahu_day2');
        $content3 = get_option('cruise_ship_oahu_middle');
    } elseif (strpos($cruise_ship_info['cruise-destination'], 'Big Island')) {
        $content1 = get_option('cruise_ship_bigisland_day1');
        $content2 = get_option('cruise_ship_bigisland_day2');
        $content3 = get_option('cruise_ship_bigisland_middle');
    }
    if ($list_tour & $day == 1) {
        if ($duration_time < 24) {
            $date_time = $cruise_ship_info['cruise-date'] . ' ' . $cruise_ship_info['cruise-time'];
            $time = mm_calculate_leave_time($date_time, $duration_time . ':00');
            $text = '<span class="cs-subtitle-list-tour-below">Arrival time ' . strtoupper($cruise_ship_info['cruise-time']) . ' And All Aboard at ' . $time . '</span>';
        }elseif($duration_time > 48) {
            $text = '<span class="cs-subtitle-list-tour-below">Arrival time ' . strtoupper($cruise_ship_info['cruise-time']);
        } else {
            $text = '<span class="cs-subtitle-list-tour-below">Arrival time ' . strtoupper($cruise_ship_info['cruise-time']) . ' And Leaves Port Next Day</span>';
        }
        $day_text = DateTime::createFromFormat("m-d-Y", $cruise_ship_info['cruise-date'])->format('l');
        $html .= '<h3 class="cs-subtitle-list-tour">' . $day_text . ' Experiences From ' . $cruise_ship_info['cruise-destination'] . '</h3>' . $text . '<p class="cs-content-day">' . $content1 . '</p>';
    } elseif ($list_tour & $day == 2) {
        $date_time = $cruise_ship_info['cruise-date'] . ' ' . $cruise_ship_info['cruise-time'];
        $day_text = DateTime::createFromFormat("m-d-Y", $cruise_ship_info['cruise-date'])->format('l');
        if($day_mid) {
            $text = '';
            $content_day = $content3;
        }else {
            $time = mm_calculate_leave_time($date_time, $duration_time . ':00');
            $text = '<span class="cs-subtitle-list-tour-below">All Aboard at '.$time.'</span>';
            $content_day = $content2;
        }
        $html .= '<h3 class="cs-subtitle-list-tour">' . $day_text . ' Experiences From ' . $cruise_ship_info['cruise-destination'] . '</h3>' . $text . '<p class="cs-content-day">' . $content_day . '</p>';
    }
    $html .= '<div class="mm_filter_product_element">';
    $html .= '<div data-interval="" data-animation="" data-hoverpause="1" class="shop-filter-product template-shop avia-content-slider avia-content-grid-active avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling">';
    $html .= '<div class="avia-content-slider-inner">';
    $html .= '<ul class="products mm-filter-product" style="grid-template-columns: repeat(3, 1fr);">';

    wp_reset_query();
    global $wpdb;
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $args = array_merge($arr, $args);
    $query = new WP_Query($args);

    $count = $query->found_posts;
    $availability = mm_cruise_ship_products_availability(wp_list_pluck($query->posts, 'ID'));
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = $query->post->ID;
        $product_title = $query->post->post_title;
        $fareharbor_link = get_post_meta($post_id, 'enable_fareharbor_popup_link', true);
        $avail =$availability[$post_id];
        $avail_date = DateTime::createFromFormat("m-d-Y", $cruise_ship_info['cruise-date'])->format('Y-m-d');

        if (in_array($avail_date, $avail)) {
            $check_avail = true;
            $cruise_ship_date = $cruise_ship_info['cruise-date'];
            $link_product = get_permalink() . '?cruise-ship=' . $cruise_ship_info['cruise-ship'] . '&cruise-destination=' . $cruise_ship_info['cruise-destination'] . '&cruise-date=' . $cruise_ship_date . '&cruise-time=' . $cruise_ship_info['cruise-time'];
            if (!empty($fareharbor_link)) {
                $link_product = $fareharbor_link;
            }
            $html .= '<li class="' . implode(" ", get_post_class()) . '">';
            $html .= '<a target="_plank" href="' . $link_product . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
            $html .= '<div class="thumbnail_container mm_thumbnail"><div class="mm-tag-button">';
            ?>
            <?php
            if (is_object_in_term($post_id, 'product_tag', 'likely-to-sell-out')) {
                $html .= '<span class="tag-like-to-sell-out">Likely to Sell Out</span>';
            }
            if (is_object_in_term($post_id, 'product_tag', 'popular-tour')) {
                $html .= '<span class="tag-popular-tour">Popular Tour</span>';
            }
            $html .= '</div>' . get_the_post_thumbnail($post_id, "shop_catalog");
            $html .= '<p class="woocommerce-loop-product__title title_mm">' . $product_title;

            $rating = 5;
            $postmeta_table = $wpdb->prefix . "postmeta";
            $query_rating = "SELECT meta_value
                FROM $postmeta_table
                WHERE `post_id` = %s AND `meta_key` LIKE '%bsf-schema-pro-rating%'";
            $query_rating = $wpdb->prepare($query_rating, $post_id);
            $results_rating = $wpdb->get_results($query_rating);
            if (!empty($results_rating)) {
                if (isset($results_rating[0]->meta_value)) {
                    $rating = $results_rating[0]->meta_value;
                }
            }
            $full = '<span class="dashicons dashicons-star-filled"></span>';
            $semi = '<span class="dashicons dashicons-star-half"></span>';
            $empty = '<span class="dashicons dashicons-star-empty"></span>';

            $html_rating = str_repeat($full, floor($rating));

            if ($rating > floor($rating)) {

                $html_rating .= $semi;
            }

            $html_rating .= str_repeat($empty, 5 - ceil($rating));
            $star_rating = '<span class="mm-title-rating">' . $html_rating . '</span>';
            $html .= $star_rating . '</p></div>';

            $html .= '<div class="inner_product_header">';
            $mm_b_short = get_post_meta($post_id, 'mm_builder', true);
            if ($mm_b_short == 'activate') {
                $short_description = get_post_meta($post_id, 'short_description_description', true);
                if ($short_description) {
                    $description = wordwrap($short_description, 100);
                    $description = explode("\n", $description);
                    $description = $description[0] . '...';
                    $short_description = $description . ' <span class="more-description">More</span>';
                    $html .= '<p>' . $short_description . '</p>';
                }

                $number_list_items = get_post_meta($post_id, 'short_description_list_items', true);
                if ($number_list_items > 0) {
                    $output_list_items = "";
                    for ($j = 0; $j < $number_list_items; $j++) {
                        $list_items_text = get_post_meta($post_id, 'short_description_list_items_' . $j . '_text', true);
                        $list_items_icon = get_post_meta($post_id, 'short_description_list_items_' . $j . '_icon', true);
                        if ($list_items_text) {
                            $output_list_items .= '<li>';
                            if ($list_items_icon) {
                                $src_text = wp_get_attachment_url($list_items_icon);
                                $alt_text = get_post_meta($list_items_icon, '_wp_attachment_image_alt', true);

                                $output_list_items .= '<div class="av-icon-char" style="padding-right: 10px;" aria-hidden="true">';
                                $output_list_items .= '<img loading="lazy" src="' . $src_text . '" alt="' . $alt_text . '" width="55" height="55">';
                                $output_list_items .= '</div>';
                            }
                            $output_list_items .= $list_items_text;
                            $output_list_items .= '</li>';
                        }
                    }
                    $html .= '<ul style="padding-top: 20px">' . $output_list_items . '</ul>';
                }
            } else {
                $excerpt_inner = get_the_excerpt();
                if (is_front_page() || $excerpt_inner == '') {
                    $excerpt_inner = get_the_excerpt();
                } else {
                    $excerpt_inner = stripslashes(wpautop(trim(html_entity_decode($excerpt_inner))));
                }
                $pos_array = array();
                if (strlen(strstr($excerpt_inner, '</p>')) > 0) {
                    $pos_array[] = strpos($excerpt_inner, '</p>');
                }
                if (strlen(strstr($excerpt_inner, '<br')) > 0) {
                    $pos_array[] = strpos($excerpt_inner, '<br');
                }
                if (strlen(strstr($excerpt_inner, 'av_hr')) > 0) {
                    $pos_array[] = strpos($excerpt_inner, '[av_hr');
                }
                if (empty($pos_array)) {
                    if (strlen(strstr($excerpt_inner, '<ul')) > 0) {
                        $pos_array[] = strpos($excerpt_inner, '<ul');
                    }
                }
                if (!empty($pos_array)) {
                    $pos = min($pos_array);
                    $description = substr($excerpt_inner, 0, $pos);
                    $feature_list = substr($excerpt_inner, $pos);
                    $description = wordwrap($description, 100);
                    $description = explode("\n", $description);
                    $description = $description[0] . '...';
                    $excerpt_inner = $description . ' <span class="more-description">More</span> ' . $feature_list;
                }
                $html .= $excerpt_inner;
            }
            $html .= '</div><div class="avia_cart_buttons single_button">';
            if (is_object_in_term($post_id, 'product_tag', 'deal')) {
                $html .= '<div class="wc-price-wrap"><span class="wc-price mm-price-before-sale">
                              <span class="starting-price">from</span>' . wc_price(wc_get_product($post_id)->get_price()) . '</span>';
            }
            $price = wc_get_product($post_id)->get_price();
            $from = 'from';
            $end_tag = '';
            if (is_object_in_term($post_id, 'product_tag', 'deal')) {
                $price = floor($price * (1 - (5 / 100)));
                $from = 'Now<br />from';
                $end_tag = '</div>';
            }

            $html .= '<span class="wc-price"><span class="starting-price">' . $from . '</span>' . wc_price($price) . '</span>';
            $html .= $end_tag . '<button data-quantity="1" data-product_sku="" class="button product_type_booking add_to_cart_button">BOOK NOW</button></div></a>';
            do_action('woocommerce_like_after_shop_loop_product', $post_id);
            $html .= '</li>';
        }
    }
    wp_reset_query();
    wp_reset_postdata();
    $html .= '</ul>';

    $html .= '</div></div></div>' . ob_get_clean();

    $html = do_shortcode($html);
    if (!$check_avail || $count == 0) {
        return null;
    }

    return $html;
}

if (!function_exists('mm_shortcode_cruise_ship_filter')) {
    function mm_shortcode_cruise_ship_filter()
    {
        ob_start();
        global $wpdb;

        $tag_order = array('cs-special-deal', '1', '2', '3', '4', '5', '6');
        $order_string = implode(', ', array_map(function ($tag) {
            return "'$tag'";
        }, $tag_order));
        $sql = "SELECT DISTINCT p.ID, p.post_title
        FROM {$wpdb->prefix}posts p
        LEFT JOIN {$wpdb->prefix}term_relationships tr ON p.ID = tr.object_id
        LEFT JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        LEFT JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id
        WHERE p.post_type = 'cruise'
         ORDER BY CASE WHEN t.slug IS NULL THEN 1
                      WHEN t.slug NOT IN ($order_string) THEN 2
                      ELSE 0 END, FIELD(t.slug, $order_string) ASC";

        $post_ids = $wpdb->get_col($sql);
        $args = array(
            'post_type' => 'cruise',
            'posts_per_page' => -1,
            'post__in' => $post_ids,
            'orderby' => 'post__in'
        );

        $data = get_posts($args);
        $array = [];
        foreach ($data as $value) {
            $folder_path = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/mm-cruise-dates/' . $value->ID . '.json';
            $data = wp_json_file_decode($folder_path);

            $arrival_dates = array_map(function ($item) {
                return $item->arrival_date;
            }, $data);
            $array[] = [
                'title' => $value->post_title,
                'slug' => $value->post_name,
                'calendar' => implode(',', $arrival_dates)
            ];
        }

        $data_dates_path = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/mm-cruise-dates/data_dates.json';
        $data = (array)wp_json_file_decode($data_dates_path);
        $data = implode(",", $data);

        ?>
        <div class="cruise-ship-filter-box">
            <div class="cruise-ship-calendar-box" data-datecruiseship="<?= $data ?>">
                <input type="text" class="cruise-ship-calendar" placeholder="CHOOSE DATE"
                       onkeydown="return false;" readonly>
                <div class="cs-calender-box" style="display:none;">
                    <div class="cs-back-choose-date"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</div>
                    <div id="cruise-ship-calendar" class="cruise-ship-calender"></div>
                </div>
            </div>
            <div class="cruise-ship-name-box">
                <select name="cruise-ship-name" id="cruise-ship-name">
                    <option value="" disabled selected>Choose cruise ship</option>
                    <option value="all-cruise-ship">All cruise ship</option>
                    <?php foreach ($array as $value):
                        if ($value['calendar']):
                            ?>
                            <option value="<?= $value['slug'] ?>"
                                    data-cs-calendar="<?= $value['calendar'] ?>"><?= $value['title'] ?></option>
                        <?php endif; endforeach; ?>
                </select>
            </div>
            <a class="cruise-ship-see-detail" href="#">View Cruise Details</a>
        </div>
        <?php
        return ob_get_clean();
    }

    add_shortcode('mm_shortcode_cruise_ship_filter', 'mm_shortcode_cruise_ship_filter');
}

if (!function_exists('mm_shortcode_list_cruise_ship')) {
    function mm_shortcode_list_cruise_ship($atts)
    {
        ob_start();
        $a = shortcode_atts(array(
            'columns' => '4',
            'cs_order_by' => ''
        ), $atts);

        global $wpdb;

        $w = array();
        if (empty($a['cs_order_by']) || $a['cs_order_by'] == 'tag') {
            $tag_order = array('cs-special-deal', '1', '2', '3', '4', '5', '6');
            $order_string = implode(', ', array_map(function ($tag) {
                return "'$tag'";
            }, $tag_order));

            $sql = "SELECT DISTINCT p.ID, p.post_title
        FROM {$wpdb->prefix}posts p
        LEFT JOIN {$wpdb->prefix}term_relationships tr ON p.ID = tr.object_id
        LEFT JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        LEFT JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id
        WHERE p.post_type = 'cruise'
         ORDER BY CASE WHEN t.slug IS NULL THEN 1
                      WHEN t.slug NOT IN ($order_string) THEN 2
                      ELSE 0 END, FIELD(t.slug, $order_string) ASC";

            $post_ids = $wpdb->get_col($sql);
            $w = array(
                'post__in' => $post_ids,
                'orderby' => 'post__in'
            );
        }

        if (!empty($a['cs_order_by']) & $a['cs_order_by'] == 'title') {
            $w = array(
                'orderby' => 'title',
                'order' => 'ASC',
            );
        }

        if (!empty($a['cs_order_by']) & $a['cs_order_by'] == 'date') {
            $w = array(
                'orderby' => 'publish_date',
                'order' => 'ASC',
            );
        }

        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'cruise',
        );

        $args = array_merge($w, $args);

        $results = get_posts($args);

        $sort_default = 'priority';

        if ($a['cs_order_by'] == 'title') {
            $sort_default = 'atoz';
        }

        if (!empty($results)) {
            echo '<div class="list-cruise-ship-sort"><span class="cs-sort">Sort by:</span>
            <select name="cruise-ship-sort" data-sort-default="' . $sort_default . '"><option value="atoz">A to Z</option><option value="priority">Priority</option></select></div>';
            echo '<div class="list-cruise-ship" style="grid-template-columns: repeat(' . $a['columns'] . ', 1fr);">';
            foreach ($results as $value):?>
                <div class="cruise-ship-item"
                    <?php
                    if (is_object_in_term($value->ID, 'post_tag', 'cs-special-deal')) {
                        echo 'data-priority="1"';
                    } elseif (is_object_in_term($value->ID, 'post_tag', '1')) {
                        echo 'data-priority="2"';
                    } elseif (is_object_in_term($value->ID, 'post_tag', '2')) {
                        echo 'data-priority="3"';
                    } elseif (is_object_in_term($value->ID, 'post_tag', '3')) {
                        echo 'data-priority="4"';
                    } elseif (is_object_in_term($value->ID, 'post_tag', '4')) {
                        echo 'data-priority="5"';
                    } elseif (is_object_in_term($value->ID, 'post_tag', '5')) {
                        echo 'data-priority="6"';
                    } elseif (is_object_in_term($value->ID, 'post_tag', '5')) {
                        echo 'data-priority="7"';
                    } else {
                        echo 'data-priority="50"';
                    }

                    echo 'data-title=' . substr($value->post_title, 0, 1);
                    ?>
                >
                    <a href="<?= get_permalink($value->ID) ?>">
                        <?php
                        if (is_object_in_term($value->ID, 'post_tag', 'cs-special-deal')) {
                            echo '<span class="tag-cs-special-deal">Special Deal</span>';
                        }
                        ?>
                        <img src="<?= get_the_post_thumbnail_url($value->ID) ?>" alt="Cruise ship image">
                        <div class="cs-content-box">
                            <h3 class="cs-title"><?= $value->post_title ?></h3>
                            <p><?= wp_trim_words($value->post_excerpt, 10, '...') ?></p>
                            <span class="cs-see-detail-button">SEE DETAILS</span>
                        </div>
                    </a>
                </div>
            <?php
            endforeach;
        }
        return ob_get_clean();
    }

    add_shortcode('list_cruise_ship', 'mm_shortcode_list_cruise_ship');
}

if (!function_exists('mm_cruise_ship_calendar')) {
    function mm_cruise_ship_calendar()
    {
        ob_start();
        $date = new DateTime("now", new DateTimeZone('Pacific/Honolulu'));
        $date = $date->format("Ymd");
        echo '<div class="calendar-cruise-ship-section">';
        echo mm_load_calendar_for_all_cruise_ship($date);
        echo '<div class="cruise-load-loader"></div>';
        echo '</div>';
        echo '<div id="calendar-cruise-ship-mobile" class="cruise-ship-calender"></div>';
        return ob_get_clean();
    }

    add_shortcode('mm_cruise_ship_calendar', 'mm_cruise_ship_calendar');
}

add_filter('posts_where', 'my_posts_where');
function my_posts_where($where)
{
    $where = str_replace("meta_key = 'cruise_ship_dates_$", "meta_key LIKE 'cruise_ship_dates_%", $where);
    return $where;
}

if (!function_exists('mm_load_calendar_for_all_cruise_ship')) {
    function mm_load_calendar_for_all_cruise_ship($date): CalendarForCruiseShip
    {
        $first_date = date('Ym01', strtotime($date));
        $last_date = date('Ymt', strtotime($date));
        $all_events = array(
            'post_type' => 'cruise',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'cruise_ship_dates_$_arrival_date',
                    'value' => array($first_date, $last_date),
                    'compare' => 'BETWEEN',
                ),
            ),
        );
        $query = new WP_Query($all_events);
        $calendar = new CalendarForCruiseShip($date);
        $time_zone = new DateTimeZone('Pacific/Honolulu');
        $current_date = new DateTime('now', $time_zone);
        $current_date->modify('+1 day');
        $current_timestamp = strtotime($current_date->format('Ymd'));
        foreach ($query->posts as $post) {
            $folder_path = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/mm-cruise-dates/' . $post->ID . '.json';
            $data = wp_json_file_decode($folder_path);
            $arrival_dates = array_map(function ($item) {
                return $item->arrival_date;
            }, $data);
            foreach ($arrival_dates as $value) {
                if (strtotime(str_replace('-','/',$value)) >= $current_timestamp & date_format(date_create($first_date), 'm-d-Y') <= $value & $value <= date_format(date_create($last_date), 'm-d-Y')) {
                    $a = '<a href="' . get_permalink($post->ID) . '?date=' . $value . '">' . $post->post_title . '</a>';
                    $arrival_date = DateTime::createFromFormat("m-d-Y", $value)->format("Y-m-d");
                    $color = get_field('cruise_ship_color', $post->ID);
                    if (empty($color)) $color = '#FF9903';
                    $calendar->add_event($a, $arrival_date, 1, $color);
                }
            }
        }
        wp_reset_postdata();
        return $calendar;
    }
}

if (!function_exists('mm_ajax_load_calendar_with_cruise_ship')) {
    function mm_ajax_load_calendar_with_cruise_ship()
    {
        $slug = $_POST['slug'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        if ($slug && $slug != 'all-cruise-ship') {
            $date = $month . '-01-' . $year;
            echo mm_load_calendar_by_cruise_ship($date, $slug);
        } elseif (empty($month)) {
            $date = new DateTime("now", new DateTimeZone('Pacific/Honolulu'));
            $date = $date->format("Ymd");
            echo mm_load_calendar_for_all_cruise_ship($date);
        } else {
            $date = $year . '/' . $month . '/01';
            echo mm_load_calendar_for_all_cruise_ship($date);
        }
        wp_die();
    }

    add_action('wp_ajax_load_calendar_with_cruise_ship', 'mm_ajax_load_calendar_with_cruise_ship');
    add_action('wp_ajax_nopriv_load_calendar_with_cruise_ship', 'mm_ajax_load_calendar_with_cruise_ship');
}
if (!function_exists('mm_load_calendar_by_cruise_ship')) {
    function mm_load_calendar_by_cruise_ship($date, $slug): CalendarForCruiseShip
    {
        if (empty($date)) {
            $date = new DateTime("now", new DateTimeZone('Pacific/Honolulu'));
            $date = $date->format("Ymd");
        }
        $first_date = DateTime::createFromFormat("m-d-Y", $date)->format("Ym01");
        $last_date = DateTime::createFromFormat("m-d-Y", $date)->format("Ymt");
        $all_events = array(
            'post_type' => 'cruise',
            'posts_per_page' => -1,
            'name' => $slug
        );
        $query = new WP_Query($all_events);
        $calendar = new CalendarForCruiseShip(DateTime::createFromFormat("m-d-Y", $date)->format("Ym01"));
        $time_zone = new DateTimeZone('Pacific/Honolulu');
        $current_date = new DateTime('now', $time_zone);
        $current_date->modify('+1 day');
        $current_timestamp = strtotime($current_date->format('Ymd'));
        foreach ($query->posts as $post) {
            $folder_path = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/mm-cruise-dates/' . $post->ID . '.json';
            $data = wp_json_file_decode($folder_path);
            $arrival_dates = array_map(function ($item) {
                return $item->arrival_date;
            }, $data);
            foreach ($arrival_dates as $value) {
                if (strtotime(str_replace('-','/',$value)) >= $current_timestamp & date_format(date_create($first_date), 'm-d-Y') <= $value & $value <= date_format(date_create($last_date), 'm-d-Y')) {
                    $a = '<a href="' . get_permalink($post->ID) . '?date=' . $value . '">' . $post->post_title . '</a>';
                    $arrival_date = DateTime::createFromFormat("m-d-Y", $value)->format("Y-m-d");
                    $color = get_field('cruise_ship_color', $post->ID);
                    if (empty($color)) $color = '#FF9903';
                    $calendar->add_event($a, $arrival_date, 1, $color);
                }
            }
        }
        wp_reset_postdata();
        return $calendar;
    }
}

if (!function_exists('mm_ajax_load_calendar_by_cruise_ship')) {
    function mm_ajax_load_calendar_by_cruise_ship(): CalendarForCruiseShip
    {
        $date = $_POST['date'];
        $slug = $_POST['slug'];
        echo mm_load_calendar_by_cruise_ship($date, $slug);
        wp_die();
    }

    add_action('wp_ajax_load_calendar_by_cruise_ship', 'mm_ajax_load_calendar_by_cruise_ship');
    add_action('wp_ajax_nopriv_load_calendar_by_cruise_ship', 'mm_ajax_load_calendar_by_cruise_ship');
}

if (!function_exists('mm_ajax_load_cruise_ship_by_date')) {
    function mm_ajax_load_cruise_ship_by_date()
    {
        $date = $_POST['date'];
        $date = date('Ymd', strtotime($date));
        $args = array(
            'post_type' => 'cruise',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'cruise_ship_dates_$_arrival_date',
                    'value' => $date,
                    'compare' => '=',
                ),
            ),
        );
        $query = new WP_Query($args);
        if (count($query->posts) > 0) {
            echo '<div class="list-cruise-ship-by-date-section"><div><span>' . date('d', strtotime($date)) . '</span><span>' . date('D', strtotime($date)) . '</span></div><div class="list-cruise-ship-by-date">';
            foreach ($query->posts as $value) {
                $color = get_field('cruise_ship_color', $value->ID);
                ?>
                <a href="<?php echo get_permalink($value->ID) . '?date=' . date('m-d-Y', strtotime($date)) ?>"
                   style="background-color: <?= $color ?>">
                    <?= $value->post_title ?>
                </a>
                <?php
            }
            echo '</div></div>';
        }
        wp_die();
    }

    add_action('wp_ajax_load_cruise_ship_by_date', 'mm_ajax_load_cruise_ship_by_date');
    add_action('wp_ajax_nopriv_load_cruise_ship_by_date', 'mm_ajax_load_cruise_ship_by_date');
}

class CalendarForCruiseShip
{

    private $active_year, $active_month, $active_day;
    private $events = [];

    public function __construct($date = null)
    {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }

    public function add_event($txt, $date, $days = 1, $color = '')
    {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }

    public function __toString()
    {
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar-cruise-ship">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= '<div class="calendar-cs-month-year"><select class="cs-month">';
        for ($i = 1; $i <= 12; $i++) {
            $selected = ($this->active_month == $i) ? "selected" : "";
            $html .= '<option value="' . $i . '" ' . $selected . '>' . $months[$i - 1] . '</option>';
        }
        $html .= '</select><select class="cs-year">
                  <option value="2024" ' . ($this->active_year == '2024' ? "selected" : "") . '>2024</option>
                  <option value="2025" ' . ($this->active_year == '2025' ? "selected" : "") . '>2025</option>
                </select></div><div class="cs-month-next-prev">
                <button class="cs-prev-month" type="button" ' . ($this->active_month == 1 & $this->active_year == 2024 ? "disabled" : "") . ' data-month="' . ($this->active_month - 1) . '"></button>
                <button class="cs-next-month" type="button" ' . ($this->active_month == 12 & $this->active_year == 2025 ? "disabled" : "") . ' data-month="' . ($this->active_month + 1) . '"></button>
                </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month - $i + 1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
//            if ($i == $this->active_day) {
//                $selected = ' selected';
//            }
            $html .= '<div class="day_num' . $selected . '">';
            $html .= '<div><span>' . ($i < 10 ? '0' . $i : $i) . '</span> <span class="day_text">' . date('D', strtotime($this->active_year . '-' . $this->active_month . '-' . $i)) . '</span> </div>';
            foreach ($this->events as $event) {
                for ($d = 0; $d <= ($event[2] - 1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
                        $html .= '<div class="event" style="background-color: ' . $event[3] . '">';
                        $html .= $event[0];
                        $html .= '</div>';
                    }
                }
            }
            $html .= '</div>';
        }
        if ($first_day_of_week < 4) {
            $cells = 35;
        } else {
            $cells = 42;
        }
        for ($i = 1; $i <= ($cells - $num_days - max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}

// Cruise ship options page
function mm_cruise_ship_options_page() {
    add_menu_page(
        'Content For Cruise Ship Detail',
        'Cruise Ship Options',
        'manage_options',
        'mm-cruise-ship-options',
        'mm_cruise_ship_options_page_callback',
        'dashicons-admin-settings',
    );
    register_setting('mm-cruise-ship-options', 'cruise_ship_maui_day1');
    register_setting('mm-cruise-ship-options', 'cruise_ship_maui_day2');
    register_setting('mm-cruise-ship-options', 'cruise_ship_kauai_day1');
    register_setting('mm-cruise-ship-options', 'cruise_ship_kauai_day2');
    register_setting('mm-cruise-ship-options', 'cruise_ship_oahu_day1');
    register_setting('mm-cruise-ship-options', 'cruise_ship_oahu_day2');
    register_setting('mm-cruise-ship-options', 'cruise_ship_bigisland_day1');
    register_setting('mm-cruise-ship-options', 'cruise_ship_bigisland_day2');
    register_setting('mm-cruise-ship-options', 'cruise_ship_maui_night');
    register_setting('mm-cruise-ship-options', 'cruise_ship_kauai_night');
    register_setting('mm-cruise-ship-options', 'cruise_ship_oahu_night');
    register_setting('mm-cruise-ship-options', 'cruise_ship_bigisland_night');
    register_setting('mm-cruise-ship-options', 'cruise_ship_maui_middle');
    register_setting('mm-cruise-ship-options', 'cruise_ship_kauai_middle');
    register_setting('mm-cruise-ship-options', 'cruise_ship_oahu_middle');
    register_setting('mm-cruise-ship-options', 'cruise_ship_bigisland_middle');
}

function mm_cruise_ship_options_page_callback()
{
    ?>
    <div class="wrap">
        <h1>Content For Cruise Ship Detail</h1>
        <form method="post" action="options.php">
            <?php settings_fields('mm-cruise-ship-options'); ?>
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_maui_day1">Maui Day 1</label></th>
                    <td>
                        <textarea name="cruise_ship_maui_day1" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_maui_day1')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_maui_day2">Maui Day 2</label></th>
                    <td>
                        <textarea name="cruise_ship_maui_day2" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_maui_day2')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_maui_middle">Maui Day - Extra</label></th>
                    <td>
                        <textarea name="cruise_ship_maui_middle" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_maui_middle')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_kauai_day1">Kauai Day 1</label></th>
                    <td>
                        <textarea name="cruise_ship_kauai_day1" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_kauai_day1')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_kauai_day2">Kauai Day 2</label></th>
                    <td>
                        <textarea name="cruise_ship_kauai_day2" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_kauai_day2')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_kauai_middle">Kauai Day - Extra</label></th>
                    <td>
                        <textarea name="cruise_ship_kauai_middle" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_kauai_middle')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_oahu_day1">Oahu Day 1</label></th>
                    <td>
                        <textarea name="cruise_ship_oahu_day1" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_oahu_day1')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_oahu_day2">Oahu Day 2</label></th>
                    <td>
                        <textarea name="cruise_ship_oahu_day2" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_oahu_day2')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_oahu_middle">Oahu Day - Extra</label></th>
                    <td>
                        <textarea name="cruise_ship_oahu_middle" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_oahu_middle')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_bigisland_day1">Big Island Day
                            1</label></th>
                    <td>
                        <textarea name="cruise_ship_bigisland_day1" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_bigisland_day1')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_bigisland_day2">Big Island Day
                            2</label></th>
                    <td>
                        <textarea name="cruise_ship_bigisland_day2" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_bigisland_day2')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_bigisland_middle">Big Island - Extra</label></th>
                    <td>
                        <textarea name="cruise_ship_bigisland_middle" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_bigisland_middle')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_maui_night">Maui Night</label></th>
                    <td>
                        <textarea name="cruise_ship_maui_night" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_maui_night')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_kauai_night">Kauai Night</label></th>
                    <td>
                        <textarea name="cruise_ship_kauai_night" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_kauai_night')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_oahu_night">Oahu Night</label></th>
                    <td>
                        <textarea name="cruise_ship_oahu_night" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_oahu_night')); ?></textarea>
                    </td>
                    <th scope="row" style="width: 110px;"><label for="cruise_ship_bigisland_night">Big island
                            Night</label></th>
                    <td>
                        <textarea name="cruise_ship_bigisland_night" cols="40"
                                  rows="5"><?php echo esc_attr(get_option('cruise_ship_bigisland_night')); ?></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('admin_menu', 'mm_cruise_ship_options_page');

if (!function_exists('cron_mm_cron_delete_date_cruise_ship_function')) {
    function mm_cron_delete_date_cruise_ship_function()
    {
        global $wpdb;
        $prefix_tbl = $wpdb->prefix;
        $all_cruise_ship = $wpdb->get_results($wpdb->prepare("SELECT ID FROM {$prefix_tbl}posts WHERE post_type='cruise' AND post_status='publish'"), ARRAY_A);

        $time_zone = new DateTimeZone('Pacific/Honolulu');
        $current_date = new DateTime('now', $time_zone);

        $current_format_date = $current_date->format('Ymd');
        $less_2_date = $current_date->modify('-2 days')->format('Ymd');
        $less_3_date = $current_date->modify('-1 days')->format('Ymd');

        $current_timestamp = strtotime($current_format_date);

        foreach ($all_cruise_ship as $cruise) {
            $cruise_ship_dates = get_field('cruise_ship_dates', $cruise['ID']);
            if ($cruise_ship_dates) {
                foreach ($cruise_ship_dates as $index => $row) {
                    $date = DateTime::createFromFormat('m-d-Y', $row['arrival_date'])->format('Ymd');
                    $duration_time = $row['duration_time'] + ((float)$row['duration_minute'] / 60);

                    if (strtotime($date) < $current_timestamp & $duration_time < 24) {
                        delete_row('cruise_ship_dates', $index, $cruise['ID']);
                        unset($cruise_ship_dates[$index]);
                    } else if (strtotime($date) <= strtotime($less_2_date) & $duration_time > 24 & $duration_time < 48) {
                        delete_row('cruise_ship_dates', $index, $cruise['ID']);
                        unset($cruise_ship_dates[$index]);
                    } else if (strtotime($date) <= strtotime($less_3_date) & $duration_time > 48) {
                        delete_row('cruise_ship_dates', $index, $cruise['ID']);
                        unset($cruise_ship_dates[$index]);
                    } else {
                        $cruise_ship_dates[$index]['arrival_date'] = $date;
                    }
                }
                update_field('cruise_ship_dates', $cruise_ship_dates, $cruise['ID']);
                mm_handle_cruise_ship_date_to_json($cruise['ID']);
            }
        }
    }

    add_action('mm_cron_delete_date_cruise_ship', 'mm_cron_delete_date_cruise_ship_function', 10, 0);
}

function mm_cruise_ship_products_availability($ids) {

    global $wpdb;

    $availability_table = $wpdb->prefix . "daily_product_availability";

    $id_placeholders = implode(', ', array_fill(0, count($ids), '%d'));

    if(!empty($id_placeholders)){
        $query = "
            SELECT      *
            FROM        $availability_table
            WHERE       product_id IN ( $id_placeholders )
        ";
    }else{
        $query = "
            SELECT      *
            FROM        $availability_table

        ";
    }
    $query = $wpdb->prepare($query, $ids);

    $time_zone = new DateTimeZone('Pacific/Honolulu');
    $current_date = new DateTime('now', $time_zone);

    $current_time = $current_date->format('Y-m-d H:i');
    if(!empty($id_placeholders)){
        $query .= "
            AND      `date` >= CAST( DATE_ADD( %s, INTERVAL `min_date` HOUR ) AS DATE )
            AND      `date` >= CAST( %s AS DATE )
         ";
    }else{
        $query .= "
           WHERE    `date` >= CAST( DATE_ADD( %s, INTERVAL `min_date` HOUR ) AS DATE )
           AND      `date` >= CAST( %s AS DATE )
        ";
    }

    $query = $wpdb->prepare($query, $current_time, $current_time);

    $date_start = !empty($_GET["date_start"]) ? $_GET["date_start"] : date('Y-m-d');
    $date_end = !empty($_GET["date_end"]) ? $_GET["date_end"] : date('Y-m-d', strtotime('+2 year'));

    $query .= $wpdb->prepare(" AND `date` >= %s", $date_start);
    $query .= $wpdb->prepare(" AND `date` <= %s", $date_end);

    $query .= " ORDER BY product_id ASC, date ASC";

    $results = $wpdb->get_results($query);

    $availability = [];

    foreach ($results as $result) {

        if (!isset($availability[$result->product_id])) {

            $availability[$result->product_id] = [];
        }

        $availability[$result->product_id][] = $result->date;
    }

    return $availability;
}

if (!function_exists('cruise_ship_operator')) {
    function cruise_ship_operator()
    {
        ob_start();
        $cruise_ship_operator = get_terms( array(
            'taxonomy' => 'cruise_ship_operator',
            'orderby' => 'count',
            'order' => 'DESC',
            'exclude' => array(17848)
        ) );
        $html = '<div class="cruise-ship-operator"> <div class="operator-items">';
        foreach ($cruise_ship_operator as $operator) {
            $logo = get_field('operator_logo', 'term_' . $operator->term_id);
            $cruise_ships = get_cruise_ship_by_operator($operator->term_id);
            $html .= '<div class="operator-item"> <img src="'.$logo.'" alt="'.$operator->name.'">';
            $html .= '<div class="operator-list-cs">';
            foreach ($cruise_ships as $cruise_ship) {
                if(get_field('cruise_ship_dates', $cruise_ship->ID)) {
                    $html .= '<a target="_blank" href="'.get_permalink($cruise_ship->ID).'">'.$cruise_ship->post_title.'</a>';
                }
            }
            $html .= '</div></div>';
        }
        $html .= '</div></div>';

        return $html . ob_get_clean();
    }

    add_shortcode('cruise_ship_operator', 'cruise_ship_operator');
}

function get_cruise_ship_by_operator($operator)
{
    global $wpdb;

    $query = $wpdb->prepare(
        "SELECT ID, post_title FROM {$wpdb->prefix}posts AS p
    INNER JOIN {$wpdb->prefix}term_relationships AS tr ON p.ID = tr.object_id
    INNER JOIN {$wpdb->prefix}term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    WHERE p.post_type = 'cruise'
    AND tt.taxonomy = 'cruise_ship_operator'
    AND tt.term_id = (%d)
    GROUP BY p.ID",
        $operator
    );

    return $wpdb->get_results( $query );
}
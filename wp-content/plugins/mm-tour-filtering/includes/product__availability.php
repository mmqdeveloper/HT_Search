<?php

/**
 * Hooks related to the Product
 * 
 */

namespace MauiMarketing\MMTF\Product\Availability;

use MauiMarketing\MMTF\Logs;
use MauiMarketing\MMTF\Core;

/**
 * Calls the function that updates the Availability table
 * 
 * 
 * Runs whenever a Product is saved.
 * 
 * Whenever the Product availability changes, the dynamic availability of the Product also changes.
 * 
 * The function {@see \MauiMarketing\MMTF\Availability\recalculate_products() Availability\recalculate_products()}
 * updates a custom table for easier search of the Product's availability.
 * 
 * 
 * @uses MauiMarketing\MMTF\Product\Availability\update_post_availability()  Product\Availability\update_post_availability()
 * @uses MauiMarketing\MMTF\Product\Availability\_get_available_days()       Product\Availability\_get_available_days()
 * @uses MauiMarketing\MMTF\Product\Availability\_delete_availability()      Product\Availability\_delete_availability()
 * @uses MauiMarketing\MMTF\Product\Availability\_insert_availability()      Product\Availability\_insert_availability()
 * 
 * @see https://developer.wordpress.org/reference/hooks/save_post_post-post_type/ Codex, action: save_post_{$post->post_type}
 * 
 * 
 * @param    int        $post_id    Description for $post_id
 * @param    \WP_Post   $post    Description for $post
 * @param    bool       $update    Description for $update
 * 
 * @return void
 */
function update_availability_table($post_id, $post, $update) {

    // Logs\debug_log( $_POST, "update_availability_table-_POST" );

    update_post_availability($post_id);
    update_post_priority($post_id);
}

add_action('save_post_product', __NAMESPACE__ . '\\' . 'update_availability_table', 10, 3);

function update_post_priority($post_id) {


    // Logs\debug_log( $post_id, "update_post_priority-product_id" );


    $product = (object) [
                "ID" => $post_id,
                "tags" => get_the_terms($post_id, 'product_tag'),
    ];

    // Logs\debug_log( $product, "update_post_priority-product" );

    $tags = wp_list_pluck($product->tags, 'name', 'slug');

    // Logs\debug_log( $tags, "update_post_priority-tags" );


    switch (true) {
        case!empty($tags["1"]) : $priority = 1;
            break;
        case!empty($tags["2"]) : $priority = 2;
            break;
        case!empty($tags["3"]) : $priority = 3;
            break;
        case!empty($tags["4"]) : $priority = 4;
            break;
        case!empty($tags["5"]) : $priority = 5;
            break;
        case!empty($tags["6"]) : $priority = 6;
            break;
        case!empty($tags["a"]) : $priority = 10;
            break;
        case!empty($tags["a1"]) : $priority = 20;
            break;
        case!empty($tags["a2"]) : $priority = 30;
            break;
        case!empty($tags["a3"]) : $priority = 40;
            break;
        case!empty($tags["a4"]) : $priority = 41;
            break;
        case!empty($tags["a5"]) : $priority = 42;
            break;
        case!empty($tags["a6"]) : $priority = 43;
            break;
        case!empty($tags["b"]) : $priority = 50;
            break;
        case!empty($tags["b1"]) : $priority = 51;
            break;
        case!empty($tags["b2"]) : $priority = 52;
            break;
        case!empty($tags["b3"]) : $priority = 53;
            break;
        case!empty($tags["b4"]) : $priority = 54;
            break;
        case!empty($tags["b5"]) : $priority = 55;
            break;
        case!empty($tags["b6"]) : $priority = 56;
            break;
        case!empty($tags["c"]) : $priority = 60;
            break;
        case!empty($tags["c1"]) : $priority = 61;
            break;
        case!empty($tags["c2"]) : $priority = 62;
            break;
        case!empty($tags["c3"]) : $priority = 63;
            break;
        case!empty($tags["c4"]) : $priority = 64;
            break;
        case!empty($tags["c5"]) : $priority = 65;
            break;
        case!empty($tags["c6"]) : $priority = 66;
            break;
        case!empty($tags["d"]) : $priority = 70;
            break;
        case!empty($tags["d1"]) : $priority = 71;
            break;
        case!empty($tags["d2"]) : $priority = 72;
            break;
        case!empty($tags["d3"]) : $priority = 73;
            break;
        case!empty($tags["d4"]) : $priority = 74;
            break;
        case!empty($tags["d5"]) : $priority = 75;
            break;
        case!empty($tags["d6"]) : $priority = 76;
            break;
        case!empty($tags["e"]) : $priority = 80;
            break;
        case!empty($tags["e1"]) : $priority = 81;
            break;
        case!empty($tags["e2"]) : $priority = 82;
            break;
        case!empty($tags["e3"]) : $priority = 83;
            break;
        case!empty($tags["e4"]) : $priority = 84;
            break;
        case!empty($tags["e5"]) : $priority = 85;
            break;
        case!empty($tags["e6"]) : $priority = 86;
            break;
        case!empty($tags["f"]) : $priority = 90;
            break;
        case!empty($tags["f1"]) : $priority = 91;
            break;
        case!empty($tags["f2"]) : $priority = 92;
            break;
        case!empty($tags["f3"]) : $priority = 93;
            break;
        case!empty($tags["f4"]) : $priority = 94;
            break;
        case!empty($tags["f5"]) : $priority = 95;
            break;
        case!empty($tags["f6"]) : $priority = 96;
            break;

        // case ! empty( $tags["a1"] ) || ( ! empty( $tags["a"] ) && ! empty( $tags["1"] ) ) : $priority =  1; break;
        // case ! empty( $tags["a2"] ) || ( ! empty( $tags["a"] ) && ! empty( $tags["2"] ) ) : $priority =  2; break;
        // case ! empty( $tags["a3"] ) || ( ! empty( $tags["a"] ) && ! empty( $tags["3"] ) ) : $priority =  3; break;
        // case ! empty( $tags["a4"] ) || ( ! empty( $tags["a"] ) && ! empty( $tags["4"] ) ) : $priority =  4; break;
        // case ! empty( $tags["a5"] ) || ( ! empty( $tags["a"] ) && ! empty( $tags["5"] ) ) : $priority =  5; break;


        default :
            $priority = 100;
    }

    update_post_meta($post_id, 'filtering_priority', $priority);
}

function update_post_availability($post_id) {

    $product = (object) [
                "ID" => $post_id,
                "categories" => _filter_ids(get_the_terms($post_id, 'product_cat')),
                "tags" => _filter_ids(get_the_terms($post_id, 'product_tag')),
                "has_restricted_days" => get_post_meta($post_id, '_wc_booking_has_restricted_days', true),
                "restricted_days" => get_post_meta($post_id, '_wc_booking_restricted_days', true),
                "min_date" => 0,
                "default_date_availability" => get_post_meta($post_id, '_wc_booking_default_date_availability', true),
                "wc_availability" => get_post_meta($post_id, '_wc_booking_availability', true),
    ];

    // Logs\debug_log( $product, "update_post_availability-product" );

    $min_date = get_post_meta($post_id, '_wc_booking_min_date', true);
    $min_date_unit = get_post_meta($post_id, '_wc_booking_min_date_unit', true);

    $overwrite_36_hours = get_post_meta($post_id, 'enable_overwrite_36_hours', true);
    if ($overwrite_36_hours != 'yes') {
        $minium_block = get_option('wc_global_minium_block_booking_availability');
        $setting_min_date = $minium_block['min_date'];
        $minium_block_unit = $minium_block['min_date_unit'];
        $tmp_priority = 10;
        $terms_tag = get_the_terms($post_id, 'product_tag');
        foreach ($terms_tag as $term_tag) {
            $min_date_priority = get_term_meta($term_tag->term_id, 'tag_min_date_priority', true);
            $min_date_tag = get_term_meta($term_tag->term_id, 'tag_min_date', true);
            $min_date_tag_unit = get_term_meta($term_tag->term_id, 'tag_min_date_unit', true);

            if ($min_date_priority <= $tmp_priority && $min_date_tag != '' && $min_date_tag_unit != '') {
                $tmp_priority = $min_date_priority;
                $setting_min_date = $min_date_tag;
                $minium_block_unit = $min_date_tag_unit;
            }
        }
        if ($setting_min_date) {
            $min_date = $setting_min_date;
            $min_date_unit = $minium_block_unit;
        }
    }

    switch ($min_date_unit) {

        case 'day':
            $min_date = $min_date * 24;
            break;

        case 'month':
            $min_date = $min_date * 24 * 30;
            break;

        default:// treat it as an hourly unit
            $min_date = $min_date * 1;
    }

    // minimum bookable day is that many hours into the future from now
    $product->min_date = $min_date;

    // Logs\debug_log( $product, "update_post_availability-product" );

    $product->wc_availability = _sort_by_priority($product->wc_availability);

    $product->restricted_days = maybe_unserialize($product->restricted_days);

    if (empty($product->restricted_days)) {

        $product->restricted_days = [];
    }

    // Logs\debug_log( $product, "update_post_availability-product" );
    // return;


    $available_days = _get_available_days($product);

    // Logs\debug_log( $available_days, "update_post_availability-available_days: " . $product->ID );
    // return;



    _delete_availability($product->ID);

    if ($available_days) {

        _insert_availability($product, $available_days);
    }
}

/**
 * Inserts the availability rows for a given Product ID
 * 
 * Uses the custom table `daily_product_availability`
 * 
 * 
 * @global   $wpdb - WordPress database access abstraction class
 * 
 * 
 * @param    object     $product                Object with Product properties
 * @param    string[]   $available_days         Array of dates Y-m-d
 * 
 * @return   void
 */
function _insert_availability($product, $available_days) {

    global $wpdb;

    $values = [];

    foreach ($available_days as $date_string) {

        $values[] = $wpdb->prepare("%s, %d, %d", [
            $date_string,
            $product->ID,
            $product->min_date,
        ]);
    }

    $separator = ")," . PHP_EOL . "(";
    $values = "(" . implode($separator, $values) . ")";

    // Logs\debug_log( $values, "_insert_availability-values" );
    // return;


    $table_name = $wpdb->prefix . 'daily_product_availability';

    $query = "
        INSERT
        INTO    $table_name ( date, product_id, min_date )
        VALUES  $values
    ";

    $inserted_count = $wpdb->query($query);

    // Logs\debug_log( $inserted_count, "_insert_availability-inserted_count" );
}

/**
 * Deletes all the availability rows for a given Product ID
 * 
 * Uses the custom table `daily_product_availability`
 * 
 * 
 * @global   $wpdb - WordPress database access abstraction class
 * 
 * 
 * @param    int    $product_id    Product ID
 * 
 * @return   void
 */
function _delete_availability($product_id) {

    global $wpdb;

    $table_name = $wpdb->prefix . 'daily_product_availability';

    $query = "
        DELETE
        FROM    $table_name
        WHERE   product_id = %d
    ";

    $query = $wpdb->prepare($query, $product_id);

    $deleted_count = $wpdb->query($query);

    // Logs\debug_log( $deleted_count, "_delete_availability-deleted_count" );
}

function _sort_by_priority($wc_availability) {

    if (!is_array($wc_availability) || empty($wc_availability)) {
        return [];
    }

    usort($wc_availability, function ($a, $b) {
        return $a['priority'] <=> $b['priority'];
    });

    // rules with higher priority numbers are strongest, so we want them last
    $wc_availability = array_reverse($wc_availability);

    return $wc_availability;
}

function _filter_ids($taxonomies) {

    if (empty($taxonomies) || is_wp_error($taxonomies)) {

        return [];
    }

    return wp_list_pluck($taxonomies, "term_id");
}

// $product is not a WooCommerce object, it's a custom object from update_post_availability()
function _get_available_days($product) {

    $now = new \DateTime();
    $end = new \DateTime();

    $end->add(new \DateInterval("P24M"));

    $period = new \DatePeriod($now, new \DateInterval('P1D'), $end);

    // Logs\debug_log( $period, "_get_available_days-period: " . $product->ID );


    $global_availability = Core\get_global_availability();

    // Logs\debug_log( $global_availability, "_get_available_days-global_availability: " . $product->ID );

    $available_days = [];
    $mm_product = wc_get_product($product->ID);
    if ($mm_product->is_type('booking')) {
        if ($mm_product->has_resources() || $mm_product->is_resource_assignment_type('customer')) {
            $resources = $mm_product->get_resources();
        }
    }
    $mm_fareharbor_api = get_post_meta($product->ID, 'mm_fareharbor_api', true);
    $dataArray = array();
    if (!empty($mm_fareharbor_api) && !empty(unserialize($mm_fareharbor_api))) {
        $dataArray = unserialize($mm_fareharbor_api);

        $data_block_date = array();
        if (!empty($dataArray)) {
            foreach ($dataArray as $item) {
                $resource_id = $item['resource'];
                $product_code = $item['productcode'];
                $file_name = $product_code . '.json';
                if (!empty($product_code)) {
                    $upload_dir = wp_upload_dir();
                    $json_file = $upload_dir['basedir'] . '/mm-api/' . $file_name;
                    $file_content = file_get_contents($json_file, true);
                    $file_content = json_decode($file_content, true);
                    $mm_list_block_date = $file_content['mm_list_block_date'];
                    if (!empty($resource_id)) {
                        $data_block_date[$resource_id] = $mm_list_block_date;
                    } else {
                        foreach ($resources as $resource) {
                            $resource_id = $resource->ID;
                            $data_block_date[$resource_id] = $mm_list_block_date;
                        }
                    }
                }
            }
        }
    }

    foreach ($period as $date_object) {

        $date = (object) [
                    "ymd" => $date_object->format("Y-m-d"),
                    "dow" => $date_object->format("N"), // ISO 8601 numeric representation of the day of the week   - 1 (for Monday) through 7 (for Sunday)
                    "dowzero" => $date_object->format("w"), // Numeric representation of the day of the week             - 0 (for Sunday) through 6 (for Saturday)
                    "week" => $date_object->format("W"), // ISO 8601 week number of year, weeks starting on Monday   - Example: 42 (the 42nd week in the year)
                    "month" => $date_object->format("n"), // Numeric representation of a month, without leading zeros - 1 through 12
        ];

        /// is the date available by default
        $available = $product->default_date_availability == "available";
        if (!empty($data_block_date)) {
            $resource_available = false;
            $block = false;
            if ($resources) {
                foreach ($resources as $resource) {
                    $resource_id = $resource->ID;

                    if (isset($data_block_date[$resource_id])) {

                        if (in_array($date->ymd, $data_block_date[$resource_id])) {
                            $block = true;
                        } else {
                            $resource_available = true;
                        }
                    } else {
                        $resource_available = true;
                    }
                }
            }

            if (!$resource_available && $block) {
                $available = false;
                continue;
            }
        }

        // are the week days restricted?
        if ($product->has_restricted_days) {

            if (!in_array($date->dowzero, $product->restricted_days)) {

                // the booking can not start on this day of the week, move on
                $available = false;
                continue;
            }
        }

        if (!is_array($product->wc_availability) || empty($product->wc_availability)) {
            //continue;
        }

        foreach ($product->wc_availability as $range) {

            // bookable means whether this range rules allow booking or not
            $bookable = ( $range["bookable"] == "yes" );

            // if range is 'no' and available is already false or range is 'yes' and available is already true
            if ($bookable == $available) {
                continue;
            }


            // type of the range
            $type = $range["type"];

            if ($type == "time" && $bookable) {

                $available = $bookable;
            }

            if ($type == "days") {

                if ($date->dow >= $range["from"] && $date->dow <= $range["to"]) {

                    $available == $bookable;
                }
            }

            if ($type == "custom") {

                if ($date->ymd >= $range["from"] && $date->ymd <= $range["to"]) {
                    if($range["bookable"] == "no"){
                        $available = false;
                        continue;
                    }
                    $available == $bookable;
                }
            }
        }
        if ($resources && !$available) {
            foreach ($resources as $resource) {
                $get_availability = $resource->get_availability('edit'); 
                if (!empty($get_availability) && is_array($get_availability)) {
                    foreach ($get_availability as $range_resource) {
                        $bookable_resource = ( $range_resource["bookable"] == "yes" );
                        if ($bookable_resource == $available) {
                            continue;
                        }
                        $type_resource = $range_resource["type"];

                        if ($type_resource == "time" && $bookable_resource) {

                            $available = $bookable_resource;
                        }

                        if ($type_resource == "days") {

                            if ($date->dow >= $range_resource["from"] && $date->dow <= $range_resource["to"]) {

                                $available == $bookable_resource;
                            }
                        }

                        if ($type_resource == "custom") {

                            if ($date->ymd >= $range_resource["from"] && $date->ymd <= $range_resource["to"]) {
                                if($range_resource["bookable"] == "no"){
                                    $available = false;
                                    continue;
                                }
                                $available == $bookable_resource;
                            }
                        }
                    }
                }

            }
        }


        // let's check the global availability now 
        // we'll assume that global availaility is always only restricting dates
        // and always is of type 'custom'
        if ($available) {

            // Logs\debug_log( $product->tags,       "_get_available_days-product-tags: "       . $product->ID );
            // Logs\debug_log( $product->categories, "_get_available_days-product-categories: " . $product->ID );
            // [type]       => custom
            // [bookable]   => no
            // [priority]   => 1
            // [category]   => 
            // [tag]        => 16124
            // [excategory] => 
            // [extag]      => 
            // [product]    => 
            // [exproduct]  => 
            // [from]       => 2022-12-24
            // [to]         => 2022-12-25

            foreach ($global_availability as $range) {

                // does this reange even applies to the date currently being checked?
                if (!( $date->ymd >= $range["from"] && $date->ymd <= $range["to"] )) {
                    continue;
                }

                if (
                        (
                        !empty(array_intersect($product->tags, $range["tag"])) ||
                        !empty(array_intersect($product->categories, $range["category"])) ||
                        in_array($product->ID, $range["product"])
                        ) &&
                        (
                        empty(array_intersect($product->tags, $range["extag"])) &&
                        empty(array_intersect($product->categories, $range["excategory"])) &&
                        !in_array($product->ID, $range["exproduct"])
                        )
                ) {
                    $available = false;
                }
            }
        }


        if ($available) {

            $available_days[] = $date->ymd;
        }
    }
    return $available_days;
}

function add_bulk_action__product($bulk_actions) {

    $bulk_actions['recalculate_availability'] = 'Recalculate availability';

    return $bulk_actions;
}

add_filter('bulk_actions-edit-' . 'product', __NAMESPACE__ . '\\' . 'add_bulk_action__product', 10, 1);

function process_bulk_action__product($redirect_url, $action, $post_ids) {

    if ($action == 'recalculate_availability') {

        foreach ($post_ids as $post_id) {

            update_post_availability($post_id);
            update_post_priority($post_id);
        }

        $redirect_url = add_query_arg('availability_recalculated', count($post_ids), $redirect_url);
    }

    return $redirect_url;
}

add_filter('handle_bulk_actions-edit-' . 'product', __NAMESPACE__ . '\\' . 'process_bulk_action__product', 10, 3);

// function add_bulk_action__taxonomy($bulk_actions) {

//     $bulk_actions['exclude_from_search'] = 'Exclude from Search Page';
//     $bulk_actions['include_in_search'] = 'Include in Search Page';

//     return $bulk_actions;
// }

// add_filter('bulk_actions-edit-' . 'product_cat', __NAMESPACE__ . '\\' . 'add_bulk_action__taxonomy', 10, 1);
// add_filter('bulk_actions-edit-' . 'product_tag', __NAMESPACE__ . '\\' . 'add_bulk_action__taxonomy', 10, 1);
// add_filter('bulk_actions-edit-' . 'certificates', __NAMESPACE__ . '\\' . 'add_bulk_action__taxonomy', 10, 1);

// function process_bulk_action__cat($redirect_url, $action, $term_ids) {

//     if ($action == 'exclude_from_search') {

//         $exclude_categories = array_unique(array_merge(Core\config()["exclude_categories"], $term_ids));

//         Core\update_config('exclude_categories', $exclude_categories);

//         $redirect_url = add_query_arg('cats_excluded_from_search', count($term_ids), $redirect_url);
//     }

//     if ($action == 'include_in_search') {

//         $include_categories = array_diff(Core\config()["exclude_categories"], $term_ids);

//         Core\update_config('exclude_categories', $include_categories);

//         $redirect_url = add_query_arg('cats_included_in_search', count($term_ids), $redirect_url);
//     }

//     return $redirect_url;
// }

// add_filter('handle_bulk_actions-edit-' . 'product_cat', __NAMESPACE__ . '\\' . 'process_bulk_action__cat', 10, 3);

// function process_bulk_action__tag($redirect_url, $action, $term_ids) {

//     if ($action == 'exclude_from_search') {

//         $exclude_tags = array_unique(array_merge(Core\config()["exclude_tags"], $term_ids));

//         Core\update_config('exclude_tags', $exclude_tags);

//         $redirect_url = add_query_arg('tags_excluded_from_search', count($term_ids), $redirect_url);
//     }

//     if ($action == 'include_in_search') {

//         $include_tags = array_diff(Core\config()["exclude_tags"], $term_ids);

//         Core\update_config('exclude_tags', $include_tags);

//         $redirect_url = add_query_arg('tags_included_in_search', count($term_ids), $redirect_url);
//     }

//     return $redirect_url;
// }

// add_filter('handle_bulk_actions-edit-' . 'product_tag', __NAMESPACE__ . '\\' . 'process_bulk_action__tag', 10, 3);

// function process_bulk_action__cert($redirect_url, $action, $term_ids) {

//     if ($action == 'exclude_from_search') {

//         $exclude_certs = array_unique(array_merge(Core\config()["exclude_certs"], $term_ids));

//         Core\update_config('exclude_certs', $exclude_certs);

//         $redirect_url = add_query_arg('certs_excluded_from_search', count($term_ids), $redirect_url);
//     }

//     if ($action == 'include_in_search') {

//         $include_certs = array_diff(Core\config()["exclude_certs"], $term_ids);

//         Core\update_config('exclude_certs', $include_certs);

//         $redirect_url = add_query_arg('certs_included_in_search', count($term_ids), $redirect_url);
//     }

//     return $redirect_url;
// }

// add_filter('handle_bulk_actions-edit-' . 'certificates', __NAMESPACE__ . '\\' . 'process_bulk_action__cert', 10, 3);

function admin_notices() {

    if (!empty($_REQUEST['availability_recalculated'])) {

        $num_changed = (int) $_REQUEST['availability_recalculated'];

        printf('<div style="display: block !important;" id="availability_recalculated_message" class="updated notice is-dismissable"><p>' . 'Recalculated availability for %d products.' . '</p></div>', $num_changed);
    }

    // if (!empty($_REQUEST['cats_excluded_from_search'])) {

    //     $num_changed = (int) $_REQUEST['cats_excluded_from_search'];

    //     printf('<div style="display: block !important;" id="availability_recalculated_message" class="updated notice is-dismissable"><p>' . '%d categories excluded from the Search page.' . '</p></div>', $num_changed);
    // }

    // if (!empty($_REQUEST['cats_included_in_search'])) {

    //     $num_changed = (int) $_REQUEST['cats_included_in_search'];

    //     printf('<div style="display: block !important;" id="availability_recalculated_message" class="updated notice is-dismissable"><p>' . '%d categories included on the Search page.' . '</p></div>', $num_changed);
    // }

    // if (!empty($_REQUEST['tags_excluded_from_search'])) {

    //     $num_changed = (int) $_REQUEST['tags_excluded_from_search'];

    //     printf('<div style="display: block !important;" id="availability_recalculated_message" class="updated notice is-dismissable"><p>' . '%d tags excluded from the Search page.' . '</p></div>', $num_changed);
    // }

    // if (!empty($_REQUEST['tags_included_in_search'])) {

    //     $num_changed = (int) $_REQUEST['tags_included_in_search'];

    //     printf('<div style="display: block !important;" id="availability_recalculated_message" class="updated notice is-dismissable"><p>' . '%d tags included on the Search page.' . '</p></div>', $num_changed);
    // }

    // if (!empty($_REQUEST['certs_excluded_from_search'])) {

    //     $num_changed = (int) $_REQUEST['certs_excluded_from_search'];

    //     printf('<div style="display: block !important;" id="availability_recalculated_message" class="updated notice is-dismissable"><p>' . '%d certificates excluded from the Search page.' . '</p></div>', $num_changed);
    // }

    // if (!empty($_REQUEST['certs_included_in_search'])) {

    //     $num_changed = (int) $_REQUEST['certs_included_in_search'];

    //     printf('<div style="display: block !important;" id="availability_recalculated_message" class="updated notice is-dismissable"><p>' . '%d certificates included on the Search page.' . '</p></div>', $num_changed);
    // }
}

add_action('admin_notices', __NAMESPACE__ . '\\' . 'admin_notices');

// function custom_columns__tax($columns) {

//     $columns['in_search'] = "In search<style>.column-in_search{ width: 60px; text-align: center; }</style>";

//     return $columns;
// }

// add_filter('manage_edit-' . 'product_cat' . '_columns', __NAMESPACE__ . '\\' . 'custom_columns__tax', 10, 1);
// add_filter('manage_edit-' . 'product_tag' . '_columns', __NAMESPACE__ . '\\' . 'custom_columns__tax', 10, 1);
// add_filter('manage_edit-' . 'certificates' . '_columns', __NAMESPACE__ . '\\' . 'custom_columns__tax', 10, 1);

// function search_column_content__tax($string, $column_name, $term_id) {

//     if ($column_name != 'in_search') {
//         return;
//     }

//     $action = current_action();

//     $config_key = "";

//     if ($action == 'manage_' . 'product_cat' . '_custom_column') {

//         $config_key = "exclude_categories";
//     }

//     if ($action == 'manage_' . 'product_tag' . '_custom_column') {

//         $config_key = "exclude_tags";
//     }

//     if ($action == 'manage_' . 'certificates' . '_custom_column') {

//         $config_key = "exclude_certs";
//     }

//     if ($config_key && in_array($term_id, Core\config()[$config_key])) {

//         echo '<span class="dashicons dashicons-minus"></span>';
//     } else {

//         echo '<span class="dashicons dashicons-yes"></span>';
//     }
// }

// add_action('manage_' . 'product_cat' . '_custom_column', __NAMESPACE__ . '\\' . 'search_column_content__tax', 10, 3);
// add_action('manage_' . 'product_tag' . '_custom_column', __NAMESPACE__ . '\\' . 'search_column_content__tax', 10, 3);
// add_action('manage_' . 'certificates' . '_custom_column', __NAMESPACE__ . '\\' . 'search_column_content__tax', 10, 3);

function get_filtered_products_availability($ids) {

    global $wpdb;

    $availability_table = $wpdb->prefix . "daily_product_availability";

    // Logs\debug_log( $ids, "Filtering-get_filtered_products_availability-ids" );

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

    //$current_time = current_time('mysql');
    $current_time = date('Y-m-d H:i',strtotime('now'));
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
    $date_end = !empty($_GET["date_end"]) ? $_GET["date_end"] : date('Y-m-d', strtotime('+1 year'));

    $query .= $wpdb->prepare(" AND `date` >= %s", $date_start);
    $query .= $wpdb->prepare(" AND `date` <= %s", $date_end);

    $query .= " ORDER BY product_id ASC, date ASC";

    // Logs\debug_log( $query, "Filtering-get_filtered_products_availability-query" );


    $results = $wpdb->get_results($query);

    // Logs\debug_log( $results, "Filtering-get_filtered_products_availability-results" );


    $availability = [];

    foreach ($results as $result) {

        if (!isset($availability[$result->product_id])) {

            $availability[$result->product_id] = [];
        }

        $availability[$result->product_id][] = $result->date;
    }

    // Logs\debug_log( $availability, "Filtering-get_filtered_products_availability-availability" );


    return $availability;
}

function get_formatted_availability_dates($availability_dates) {

    $dates = [];

    foreach ($availability_dates as $date) {

        // $formatted_dates[] = date( "j M", strtotime( $date ) );

        $day = date("j", strtotime($date));
        $monthyear = date("MY", strtotime($date));

        if (!isset($dates[$monthyear])) {

            $dates[$monthyear] = [];
        }

        $dates[$monthyear][] = $day;
    }

    // Logs\debug_log( $dates, "Filtering-get_filtered_products_availability-dates" );


    $formatted_dates = [];

    foreach ($dates as $monthyear => $days) {

        $text = "";

        $start = 0;
        $last = 0;

        foreach ($days as $day) {

            // we just started this month

            if (!$start) {

                $start = $day;
                $last = $day;
                $text .= $day;
                continue;
            }

            // we didn't just start, but it's a consecutive day

            if ($last + 1 == $day) {

                $last = $day;
                $text .= substr($text, -3) !== " - " ? " - " : "";
                continue;
            }

            // it's not consecutive day, so we need to start new range

            $text .= $last == $start ? "" : $last;

            $start = $day;
            $last = $day;
            $text .= ", ";
            $text .= $day;
        }

        $text .= $last == $start ? "" : $last;

        $text .= " " . substr($monthyear, 0, 3);

        $formatted_dates[] = $text;
    }


    return implode('<br/>', $formatted_dates);
}

if (!function_exists('mm_cron_update_product_availability_data_func')) {

    function mm_cron_update_product_availability_data_func() {
        $args = array(
            'posts_per_page' => 2,
            'post_type' => array('product'),
            'post_status' => 'publish',
            'meta_query' => array(
                /*array(
                    'key' => 'mm_enable_fareharbor_api',
                    'value' => 'yes',
                    'compare' => '==',
                ),*/
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'mm_update_availability_data',
                        'compare' => 'NOT EXISTS',
                    ), array(
                        'key' => 'mm_update_availability_data',
                        'compare' => '==',
                        'value' => 'no',
                    )
                ),
            ),
        );
        $post = new \WP_Query($args);
        if ($post->have_posts()) {
            while ($post->have_posts()) {
                $post->the_post();
                $post_id = get_the_ID();
                update_post_availability($post_id);
                update_post_meta($post_id, 'mm_update_availability_data', 'yes');
            }
        } else {
            mm_reset_update_availability_data();
        }
        wp_reset_query();
    }

}
add_action('mm_cron_update_product_availability_data', __NAMESPACE__ . '\\' . 'mm_cron_update_product_availability_data_func');

if (!function_exists('mm_reset_update_availability_data')) {

    function mm_reset_update_availability_data() {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => array('product'),
            'post_status' => 'publish',
            /*'meta_query' => array(
                array(
                    'key' => 'mm_enable_fareharbor_api',
                    'value' => 'yes',
                    'compare' => '==',
                ),
            ),*/
        );
        $post = new \WP_Query($args);
        while ($post->have_posts()) {
            $post->the_post();
            $post_id = get_the_ID();
            update_post_meta($post_id, 'mm_update_availability_data', 'no');
        }
        wp_reset_query();
    }

}

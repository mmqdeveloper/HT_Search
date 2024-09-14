<?php

add_action('woocommerce_thankyou', 'mm_prevent_duplicate_booking_cookie');
if (!function_exists('mm_prevent_duplicate_booking_cookie')) {
    function mm_prevent_duplicate_booking_cookie ($order_id) {
        $order = wc_get_order($order_id);
        if ($order) {
            $items = $order->get_items();
            $product_select = 6285;
            $is_product_select = false;
            if ($items) {
                foreach ($items as $item) {
                    if ($product_select == $item->get_product_id()) {
                        $is_product_select = true;
                        break;
                    }
                }
            }
            if ($is_product_select == true) {
                setcookie("mm_info_booking_{$product_select}", true, time()+4*3600, '/');
            }
        }
    }
}

add_filter('woocommerce_add_to_cart_validation', 'mm_prevent_duplicate_booking_check', 10, 2);
if (!function_exists('mm_prevent_duplicate_booking_check')) {
    function mm_prevent_duplicate_booking_check ($passed, $product_id) {
        if ($product_id == 6285) {
            $booking_day = isset($_POST['wc_bookings_field_start_date_day']) ? sanitize_text_field($_POST['wc_bookings_field_start_date_day']) : '';
            $booking_month = isset($_POST['wc_bookings_field_start_date_month']) ? sanitize_text_field($_POST['wc_bookings_field_start_date_month']) : '';
            $booking_year = isset($_POST['wc_bookings_field_start_date_year']) ? sanitize_text_field($_POST['wc_bookings_field_start_date_year']) : '';
            $booking_time = isset($_POST['wc_bookings_field_start_date_time']) ? sanitize_text_field($_POST['wc_bookings_field_start_date_time']) : '';
            $info_booking = array(
                'day' => $booking_day,
                'month' => $booking_month,
                'year' => $booking_year,
                'time' => $booking_time,
            );
            $product_exist = array();
            if (class_exists('WooCommerce')) {
                if (WC()->cart->get_cart_contents_count() > 0) {
                    $cart_items = WC()->cart->get_cart(); 
                    foreach ($cart_items as $cart_item_key => $cart_item) {
                        if ($cart_item['product_id'] == 6285) {
                            $product_exist = array(
                                'day' => sprintf("%02d", $cart_item['booking']['_day']),
                                'month' => sprintf("%02d", $cart_item['booking']['_month']),
                                'year' => $cart_item['booking']['_year'],
                                'time' => $cart_item['booking']['_time'],
                            );
                        }
                    }
                }
            }

            if (!empty($info_booking) && !empty($product_exist)) {
                if (
                    $info_booking['day'] == $product_exist['day']
                    &&
                    $info_booking['month'] == $product_exist['month']
                    &&
                    $info_booking['year'] == $product_exist['year']
                    &&
                    $info_booking['time'] == $product_exist['time']
                ) {
                    return false;
                }
            }

            $user_roles = wp_get_current_user()->roles;
            $lockable = true;
            if (in_array("shop_manager", $user_roles) || in_array("administrator", $user_roles)) {
                $lockable = false;
            }
            if ($lockable == true && isset($_COOKIE["mm_info_booking_{$product_id}"])) {
                return false;
            }
        } 
        return $passed;
    }
}
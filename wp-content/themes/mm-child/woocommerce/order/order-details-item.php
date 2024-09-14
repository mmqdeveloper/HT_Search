<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 * This template can be overridden by copying it to yourtheme/woocommerce/order/booking-display.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2.0
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
    return;
}
$header_email_product = '';
$footer_email_product = '';
$booking_ids = [];
$product_id = $item->get_product_id();
$ht_custom_content_tour_header = get_post_meta($product_id, 'content_header_email_meta_box', true);
$ht_custom_content_tour = get_post_meta($product_id, 'content_email_meta_box', true);
if (class_exists('WC_Booking_Data_Store')) {
    $booking_ids = WC_Booking_Data_Store::get_booking_ids_from_order_item_id($item_id);
}
if (!$order->has_status('failed') && (!empty($ht_custom_content_tour_header) || !empty($ht_custom_content_tour))) {
    if (class_exists('WC_Booking_Data_Store')) {

        foreach ($booking_ids as $booking_id) {
            if (class_exists('WC_Booking') && $booking_id > 0) {
                $booking_mm = new WC_Booking($booking_id);
                $tour_date_mm = date("l, F d, Y", strtotime($booking_mm->get_start_date()));
                $get_all_day_mm = $booking_mm->get_all_day('edit');
                if ($get_all_day_mm) {
                    $start_time_mm = '';
                } else {
                    $start_time_mm = date('h:i A', $booking_mm->get_start('edit'));
                }
            }
        }
    }
    $content_header = $ht_custom_content_tour_header;
    $content_footer = $ht_custom_content_tour;
    $search_strpos = "[Date]";
    $search = ['[Date]', '[Time]'];
    $replace = [$tour_date_mm, $start_time_mm];
    if (!empty($content_header)) {
        if (strpos($content_header, $search_strpos)) {
            $header_email_product .= '<div class="header_email_content">';
            $header_email_product .= stripslashes(wpautop(trim(html_entity_decode(str_replace($search, $replace, $content_header)))));
            $header_email_product .= '</div>';
        } else {
            $header_email_product .= '<div class="header_email_content">';
            $header_email_product .= stripslashes(wpautop(trim(html_entity_decode($ht_custom_content_tour_header))));
            $header_email_product .= '</div>';
        }
    }
    if (!empty($content_footer)) {
        if (strpos($content_footer, $search_strpos)) {
            $footer_email_product .= '<div class="footer_email_content">';
            $footer_email_product .= stripslashes(wpautop(trim(html_entity_decode(str_replace($search, $replace, $content_footer)))));
            $footer_email_product .= '</div>';
        } else {
            $footer_email_product .= '<div class="footer_email_content">';
            $footer_email_product .= stripslashes(wpautop(trim(html_entity_decode($content_footer))));
            $footer_email_product .= '</div>';
        }
    }
}
if (!empty($header_email_product)) {
    echo $header_email_product;
}
?>
<table style="border: none" class="woocommerce-table woocommerce-table--order-details shop_table order_details">


    <tbody>

        <tr style="border: none;" class=" <?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order)); ?>">

            <td class="woocommerce-table__product-name product-name">

                <div class="detail-order">

                    <div class="row-one" style="">
                        <div>
                            <?php
                            $order_id = $order->get_id();
                            $edit_url = admin_url('post.php?post=' . $order_id . '&action=edit');

                            global $current_user;
                            $user_roles = $current_user->roles;
                            $user_role = array_shift($user_roles);

                            if ($user_role === 'administrator' || $user_role === 'shop_manager') {
                                $order_id = $order->get_id();
                                $edit_url = admin_url('post.php?post=' . $order_id . '&action=edit');
                                ?>
                                <p style="display: inline-block;font-size: 18px;">Order: <a href="<?php echo esc_url($edit_url); ?>" class="edit-order-button"><?php echo esc_html($order->get_order_number()); ?></a> (<?php echo wc_format_datetime($order->get_date_created()); ?>)</p>
                                <?php
                            } else {
                                ?>
                                <p style="text-transform: uppercase; display: inline-block;font-size: 18px;">Order: <?php echo esc_html($order->get_order_number()); ?> (<?php echo wc_format_datetime($order->get_date_created()); ?>)</p>
                                <?php
                            }
                            ?>  

                            <?php
                            if (class_exists('WC_Booking_Data_Store')) {
                                if ($booking_ids) {
                                    foreach ($booking_ids as $booking_id) {
                                        $booking = new WC_Booking($booking_id);
                                        ?>
                                        <p class="order-status" style="display: inline-block;">
                                            <span class="status-<?php echo esc_attr($booking->get_status()); ?>">
                                                <?php echo esc_html(wc_bookings_get_status_label($booking->get_status())) ?>
                                            </span>
                                        </p>
                                        <?php
                                    }
                                }
                            }
                            ?>

                        </div> 
                        <div>
                            <p style="font-size: 18px;">Total: <?php echo $order->get_formatted_line_subtotal($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped      ?></p>
                        </div>
                    </div>
                    <div class="row-two">
                        <div >  
                            <?php
                            $is_visible = $product && $product->is_visible();
                            $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                            $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                            $product_image = $product->get_image();
                            ?>

                            <div class="product-row">
                                <div class="product-image">
                                    <?php echo $product_image; ?>
                                </div>
                                <div class="product-details">        
                                    <!-- <p class="order-date">Date: <?php echo wc_format_datetime($order->get_date_created()); ?></p> -->
                                    <?php echo apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped  ?>
                                    <?php
                                    $qty = $item->get_quantity();
                                    $refunded_qty = $order->get_qty_refunded_for_item($item_id);

                                    if ($refunded_qty) {
                                        $qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ( $refunded_qty * -1 )) . '</ins>';
                                    } else {
                                        $qty_display = esc_html($qty);
                                    }

                                    echo apply_filters('woocommerce_order_item_quantity_html', ' <strong class="product-quantity" style="font-size: 23px;color: #000;">' . sprintf('&times;&nbsp;%s', $qty_display) . '</strong>', $item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    ?>
                                    <?php if ($order->get_payment_method_title()): ?>
                                        <div class="pay-method">
                                            <p>Pay Method: <?php echo wp_kses_post($order->get_payment_method_title()); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <a style="color: #2189c1;font-size: 16px;" class="view-my-booking" href="/my-account/bookings/" target="_blank">View my bookings →</a>
                                    </div>                 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="your-booking"><?php do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false); ?>
                    </div>

                    <?php
                    $is_visible = $product && $product->is_visible();
                    $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                    $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                    $qty = $item->get_quantity();
                    $refunded_qty = $order->get_qty_refunded_for_item($item_id);

                    if ($refunded_qty) {
                        $qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ( $refunded_qty * -1 )) . '</ins>';
                    } else {
                        $qty_display = esc_html($qty);
                    }

                    wc_display_item_meta($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

                    $pickup_text = get_post_meta($item_id, 'mm_fareharbor_pickup_text', true);
                    if (empty($pickup_text)) {
                        $pickup_text = wc_get_order_item_meta($item_id, 'mm_fareharbor_pickup_text', true);
                    }
                    $map_url = get_post_meta($item_id, 'mm_fareharbor_pickup_map_url', true);
                    if (empty($map_url)) {
                        $map_url = wc_get_order_item_meta($item_id, 'mm_fareharbor_pickup_map_url', true);
                    }
                    $pickup_description = get_post_meta($item_id, 'mm_fareharbor_pickup_description', true);
                    if (empty($pickup_description)) {
                        $pickup_description = wc_get_order_item_meta($item_id, 'mm_fareharbor_pickup_description', true);
                    }
                    if ($pickup_text != '') {
                        ?>

                        <div class="fareharbor-pickup" style=""> 
                            <h4 style="color:#B01D15;font-size:18px;">IMPORTANCE: <?php echo $pickup_text; ?></h4>
                            <div class="pickup_description">
                            <h4 style="color:#B01D15;font-size:18px;margin-top:10px;">PLEASE MEET US AT:</h4>
                            <?php 
                                echo $pickup_description; 
                            ?>
                            </div>
                            <?php if ($map_url != '') { ?>
                                <a href="<?php echo $map_url; ?>" target="_blank">See pickup location on a map</a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>



            </td>

        <!-- <td class="woocommerce-table__product-total product-total">
            <?php echo $order->get_formatted_line_subtotal($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped  ?>
        </td> -->

        </tr>

        <?php if ($show_purchase_note && $purchase_note) : ?>

            <tr class="woocommerce-table__product-purchase-note product-purchase-note">

                <td colspan="2"><?php echo wpautop(do_shortcode(wp_kses_post($purchase_note))); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped      ?></td>

            </tr>

        <?php endif; ?>
    </tbody>
</table>
<?php
$upload_dir = wp_upload_dir();
$ticketNumber = wc_get_order_item_meta($item_id, 'mm_galaxyconnect_ticketNumber', true);
if(!empty($ticketNumber)){
    $ticketNumber_arr = explode(',', $ticketNumber);
    foreach ($ticketNumber_arr as $ticket) {
        $file_ticket = $order_id.'-'.$ticket.'.png';
        $file_ticket_url = $upload_dir['basedir'] . '/tickets/' . $file_ticket;
        $ticket_image = $upload_dir['baseurl'] . '/tickets/' . $file_ticket;
        //$file_ticket_url = MM_GALAXYCONNECT_PLUGIN_DIR . 'tickets/' . $file_ticket;
        //$ticket_image = MM_GALAXYCONNECT_PLUGIN_URL . 'tickets/' . $file_ticket;
        if (file_exists($file_ticket_url)) {
            echo "<a href='".$ticket_image."' download class='noLightbox'><img src='".$ticket_image."' class='ticket_number' alt='".$ticket."'></a>";
        }
    }
}?>
<?php
if (!empty($footer_email_product)) {
    echo $footer_email_product;
}

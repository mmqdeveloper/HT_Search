<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */
defined('ABSPATH') || exit;

$text_align = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ($items as $item_id => $item) :
    $product = $item->get_product();
    $sku = '';
    $purchase_note = '';
    $image = '';

    if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
        continue;
    }

    if (is_object($product)) {
        $sku = $product->get_sku();
        $purchase_note = $product->get_purchase_note();
        $image = $product->get_image($image_size);
    }
    ?>
    <tr class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'order_item', $item, $order)); ?>">
        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
            <?php
            // Show title/image etc.
            if ($show_image) {
                echo wp_kses_post(apply_filters('woocommerce_order_item_thumbnail', $image, $item));
            }

            // Product name.
            echo wp_kses_post(apply_filters('woocommerce_order_item_name', $item->get_name(), $item, false));

            // SKU.
            if ($show_sku && $sku) {
                echo wp_kses_post(' (#' . $sku . ')');
            }

            // allow other plugins to add additional product information here.
            do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text);

            wc_display_item_meta(
                    $item,
                    array(
                        'label_before' => '<strong class="wc-item-meta-label" style="float: ' . esc_attr($text_align) . '; margin-' . esc_attr($margin_side) . ': .25em; clear: both">',
                    )
            );

            // allow other plugins to add additional product information here.
            do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text);
            $pickup_text = get_post_meta($item_id, 'mm_fareharbor_pickup_text', true);
            if(empty($pickup_text)){
                $pickup_text = wc_get_order_item_meta($item_id, 'mm_fareharbor_pickup_text', true);
            }
            $map_url = get_post_meta($item_id, 'mm_fareharbor_pickup_map_url', true);
            if(empty($map_url)){
                $map_url = wc_get_order_item_meta($item_id, 'mm_fareharbor_pickup_map_url', true);
            }
            $pickup_description = get_post_meta($item_id, 'mm_fareharbor_pickup_description', true);
            if(empty($pickup_description)){
                $pickup_description = wc_get_order_item_meta($item_id, 'mm_fareharbor_pickup_description', true);
            }
            if ($pickup_text != '') {
                ?>
                <div class="fareharbor-pickup" style="display: inherit;width: 100%;border: 1px;border-style: dashed;border-color: #ddd;border-radius: 5px;padding: 15px;">
                    <h4 style="font-size: 1em;"><?php echo $pickup_text; ?></h4>
                    <div><?php echo $pickup_description; ?></div>
                    <?php if ($map_url != '') { ?>
                        <a href="<?php echo $map_url; ?>" target="_blank">See pickup location on a map</a>
                    <?php } ?>
                </div>
            <?php } elseif ( $item->get_product_id() == 34517 )  {?>
                <p><strong>Pickup time:</strong> 8:00 AM</p>
            <?php }?>
            <?php if(count($order->get_items())>1){
                $header_email_product = '';
                $footer_email_product = '';
                $product_id = $item->get_product_id();
                $ht_custom_content_tour_header = get_post_meta( $product_id, 'content_header_email_meta_box', true );
        $ht_custom_content_tour = get_post_meta( $product_id, 'content_email_meta_box', true );
        if ( !empty( $ht_custom_content_tour_header ) || !empty( $ht_custom_content_tour ) ) {
                    if(class_exists( 'WC_Booking_Data_Store') && $order->ID) {
                        $booking_ids_mm = WC_Booking_Data_Store::get_booking_ids_from_order_item_id($item_id);
                        foreach (  $booking_ids_mm as $booking_id ){
                            if(class_exists( 'WC_Booking' )&& $booking_id > 0){
                                $booking_mm = new WC_Booking( $booking_id );
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
                    $subject = $ht_custom_content_tour_header  ;
                    $footer = $ht_custom_content_tour  ;
                    $search_strpos = "[Date]";
                    $search = ['[Date]','[Time]'];
                    $replace = [$tour_date_mm,$start_time_mm];
                    if(!empty($subject)){
                        if(strpos($subject,$search_strpos)){
                            $header_email_product.= '</br>';
                            $header_email_product.= '<div style="color:#636363;" class="content">';
                            $header_email_product.= stripslashes(wpautop(trim(html_entity_decode( str_replace($search,$replace,$subject)) )));
                            $header_email_product.= '</div>';
                            $header_email_product.= '</br>';
                        }else{
                            $header_email_product.= '</br>';
                            $header_email_product.= '<div style="color:#636363;" class="content">';
                            $header_email_product.= stripslashes(wpautop(trim(html_entity_decode( $ht_custom_content_tour_header) )));
                            $header_email_product.= '</div>';
                            $header_email_product.= '</br>';
                        }
                    }
                    if(!empty($footer)){
                        if(strpos($footer,$search_strpos)){
                            $footer_email_product.= '</br>';
                            $footer_email_product.= '<div style="color:#636363;" class="content">';
                            $footer_email_product.= stripslashes(wpautop(trim(html_entity_decode( str_replace($search,$replace,$footer)) )));
                            $footer_email_product.= '</div>';
                            $footer_email_product.= '</br>';
                        }else{
                            $footer_email_product.= '</br>';
                            $footer_email_product.= '<div style="color:#636363;" class="content">';
                            $footer_email_product.= stripslashes(wpautop(trim(html_entity_decode( $footer) )));
                            $footer_email_product.= '</div>';
                            $footer_email_product.= '</br>';
                        }
                    }
                }
                $galaxyconnect_is_OK = get_post_meta($order->ID, 'mm_galaxyconnect_is_success', true);
                $check_galaxy_api = get_post_meta($product_id,"mm_enable_galaxy_api", true);
                if($galaxyconnect_is_OK == 'Yes' && $check_galaxy_api == 'yes'){
                    $header_email_product = '';
                }
                echo $header_email_product;
                echo $footer_email_product;
            }?>
        </td>
        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
            <?php
            $qty = $item->get_quantity();
            $refunded_qty = $order->get_qty_refunded_for_item($item_id);

            if ($refunded_qty) {
                $qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ( $refunded_qty * -1 )) . '</ins>';
            } else {
                $qty_display = esc_html($qty);
            }
            echo wp_kses_post(apply_filters('woocommerce_email_order_item_quantity', $qty_display, $item));
            ?>
        </td>
        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
            <?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?>
        </td>
    </tr>
    <?php
    if ($show_purchase_note && $purchase_note) {
        ?>
        <tr>
            <td colspan="3" style="text-align:<?php echo esc_attr($text_align); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
                <?php
                echo wp_kses_post(wpautop(do_shortcode($purchase_note)));
                ?>
            </td>
        </tr>
        <?php
    }
    ?>

<?php endforeach; ?>

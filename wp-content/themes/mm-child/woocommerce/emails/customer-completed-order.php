<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     3.7.0
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
$email_heading_customer_process_order = '';
do_action('woocommerce_email_header', $email_heading_customer_process_order, $email);
// do_action('woocommerce_email_header', $email_heading, $email);

echo '<img src="https://www.hawaiitours.com/wp-content/uploads/2024/07/icon-checked-email.png" alt="icon check email" style="display: block; margin: 10px auto;" />';
echo '<h2 style="text-align: center;color: #2189C1 !important;font-size: 25px !important;font-weight: 500 !important;">Mahalo for booking with Hawaii Tours</h2>';
echo '<p style="text-align: center;color: #000;">We hope you have an amazing time in Hawaii! If you have any questions or concerns, please contact us at <a href="mailto:info@hawaiitours.com" style="color: #E81B10;font-weight: 600;text-decoration: none;">info@hawaiitours.com</a> or call us at <a href="tel:1-808-379-3701" style="color: #E81B10;font-weight: 600;text-decoration: none;">1-808-379-3701</a>. We are here to help! The following contact information is what we will use while you are in Hawaii.</p>';

$firstName = get_post_meta($order->ID, '_billing_first_name', true);
$lastName = get_post_meta($order->ID, '_billing_last_name', true);
$email = get_post_meta($order->ID, '_billing_email', true);
$phone = get_post_meta($order->ID, '_billing_phone', true);

?>
<div style="margin: 20px auto;border-left: 1px solid #707070;width: max-content;padding-left: 10px;">
    <p style="font-weight: 600 !important;color:#000 !important;margin-bottom:0;"><?php echo $firstName.' '.$lastName; ?></p>
    <a href="mailto:<?php echo $email ?>" style="color: #000;text-decoration: none; display: block;"><?php echo $email ?></a>
    <a href="tel:<?php echo $phone ?>" style="color: #000;text-decoration: none; display: block;"><?php echo $phone ?></a>
</div>

<div style="display: flex;margin-bottom:15px;">
    <a href="mailto:info@hawaiitours.com" style="color: #000;text-decoration: none;font-weight: 600;"><img src="https://www.hawaiitours.com/wp-content/uploads/2024/07/mail.png" alt="icon mail" />info@hawaiitours.com</a>
    <a href="tel:1-808-379-3701" style="color: #000;text-decoration: none;font-weight: 600;margin-left: auto;"><img src="https://www.hawaiitours.com/wp-content/uploads/2024/07/phone.png" alt="icon mail" />1-808-379-3701</a>
</div>

<?php
$pht_tour = false;
foreach ($order->get_items() as $order_item_id => $item) {
    $product_id = $item->get_product_id();
    $categories = get_the_terms( $product_id, 'product_cat' );
    foreach($categories as $category ){
        if($category->name =='Pearl Harbor' || $category->name =='Pearl Harbor Tours'){
            $pht_tour = true;
        }
    }
}

$header_email_product = '';
$footer_email_product = '';
if (!empty($order->get_items()) && is_array($order->get_items()) && count($order->get_items()) == 1 ) {
    foreach ($order->get_items() as $item) {
        $product_id = $item->get_product_id();
        $ht_custom_content_tour_header = get_post_meta($product_id, 'content_header_email_meta_box', true);
        $ht_custom_content_tour = get_post_meta($product_id, 'content_email_meta_box', true);
        if (!empty($ht_custom_content_tour_header) || !empty($ht_custom_content_tour)) {
            if (class_exists('WC_Booking_Data_Store') && $order->ID) {
                $booking_ids_mm = WC_Booking_Data_Store::get_booking_ids_from_order_id($order->ID);
                foreach ($booking_ids_mm as $booking_id) {
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
            $subject = $ht_custom_content_tour_header;
            $footer = $ht_custom_content_tour;
            $search_strpos = "[Date]";
            $search = ['[Date]', '[Time]'];
            $replace = [$tour_date_mm, $start_time_mm];
            if (!empty($subject)) {
                if (strpos($subject, $search_strpos)) {
                    $header_email_product .= '</br>';
                    $header_email_product .= '<div style="color:#636363;" class="content">';
                    $header_email_product .= stripslashes(wpautop(trim(html_entity_decode(str_replace($search, $replace, $subject)))));
                    $header_email_product .= '</div>';
                    $header_email_product .= '</br>';
                } else {
                    $header_email_product .= '</br>';
                    $header_email_product .= '<div style="color:#636363;" class="content">';
                    $header_email_product .= stripslashes(wpautop(trim(html_entity_decode($ht_custom_content_tour_header))));
                    $header_email_product .= '</div>';
                    $header_email_product .= '</br>';
                }
            }
            if (!empty($footer)) {
                if (strpos($footer, $search_strpos)) {
                    $footer_email_product .= '</br>';
                    $footer_email_product .= '<div style="color:#636363;" class="content">';
                    $footer_email_product .= stripslashes(wpautop(trim(html_entity_decode(str_replace($search, $replace, $footer)))));
                    $footer_email_product .= '</div>';
                    $footer_email_product .= '</br>';
                } else {
                    $footer_email_product .= '</br>';
                    $footer_email_product .= '<div style="color:#636363;" class="content">';
                    $footer_email_product .= stripslashes(wpautop(trim(html_entity_decode($footer))));
                    $footer_email_product .= '</div>';
                    $footer_email_product .= '</br>';
                }
            }
            $galaxyconnect_is_OK = get_post_meta($order->ID, 'mm_galaxyconnect_is_success', true);
            $check_galaxy_api = get_post_meta($product_id,"mm_enable_galaxy_api", true);
            if($galaxyconnect_is_OK == 'Yes' && $check_galaxy_api == 'yes'){
                $header_email_product = '';
            }
        }
        
    }
}
echo $header_email_product;
?>
<?php
/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
?>
<div style="display: flex;padding: 10px;border: 1px solid #C9CCD0;">
    <div>
        <p style="color:#000;"><?php echo 'Order: #HT-'.$order->ID.' ('.$order->get_date_created()->format('F j, Y').')'; ?></p>
        <p style="color:#000;margin-bottom:0;">Total: <?php echo wc_price($order->get_total()); ?></p>
    </div>
    <div style="margin-left: auto;padding: 5px 15px;background-color:#2189C1;border-radius:20px;text-transform: uppercase;color:#fff;height: max-content;"><?php echo wc_get_order_status_name($order->get_status()); ?></div>
</div>

<?php 
$islands_id = array();
foreach ($order->get_items() as $item_id => $item) {
    $product = $item->get_product();
    $product_id = $product->get_id();
    $tags = get_the_terms( $product_id, 'product_tag' );
    foreach($tags as $tag ){
        if($tag->name =='Oahu' || $tag->name =='Maui' || $tag->name =='Big Island' || $tag->name =='Kauai' || $tag->name =='Package'){
            $islands[] = $tag->name;
            if(!in_array($tag->term_id, $islands_id)){
                $islands_id[] = $tag->term_id;
            }
        }
    }
    $categories = get_the_terms( $product_id, 'product_cat' );
    foreach($categories as $category ){
        if($category->name =='Pearl Harbor' || $category->name =='Pearl Harbor Tours'){
            $exclude_cate_pht = '587,16738';
        }
    }
    ?>
    <table style="border: none;padding:10px;border: 1px solid #C9CCD0;width:100%;border-top:0;margin-bottom:15px;" class="woocommerce-table woocommerce-table--order-details shop_table order_details">
        <tbody>
            <tr style="border: none;" class=" <?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order)); ?>">
                <td class="woocommerce-table__product-name product-name">
                    <div class="detail-order">
                        <div class="row-two">
                            <div >  
                                <?php
                                $is_visible = $product && $product->is_visible();
                                $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                                $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                                $product_image = $product->get_image(array( 150, 106 ));
                                ?>
                                <div class="product-row" style="display:flex;">
                                    <div class="product-image">
                                        <?php echo $product_image; ?>
                                    </div>
                                    <div class="product-details" style="margin-left:10px;">        
                                        <?php echo apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s" style="color:#000 !important;text-decoration:none;font-size:16px;">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped  ?>
                                        <?php
                                        $qty = $item->get_quantity();
                                        $refunded_qty = $order->get_qty_refunded_for_item($item_id);

                                        if ($refunded_qty) {
                                            $qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ( $refunded_qty * -1 )) . '</ins>';
                                        } else {
                                            $qty_display = esc_html($qty);
                                        }
                                        echo apply_filters('woocommerce_order_item_quantity_html', sprintf('<span style="color:#000;">&times;&nbsp;%s</span>', $qty_display), $item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        ?>
                                        <?php if ($order->get_payment_method_title()): ?>
                                            <div class="pay-method">
                                                <p style="color:#000;font-size:15px;">Pay Method: <?php echo wp_kses_post($order->get_payment_method_title()); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <a style="color: #2189c1;font-size: 16px;" class="view-my-booking" href="https://www.hawaiitours.com/my-account/bookings/" target="_blank">View my bookings →</a>
                                        </div>                 
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <?php
                        if (class_exists('WC_Booking_Data_Store') && $item_id) {
                            $booking_ids = WC_Booking_Data_Store::get_booking_ids_from_order_item_id($item_id);
                            if (!empty($booking_ids)) {
                                foreach ($booking_ids as $booking_id) {
                                    $get_booking_id = $booking_id;
                                    $booking = new WC_Booking($booking_id);
                                    $tour_date = date("l, F d, Y", strtotime($booking->get_start_date()));
                                    $start_time = date('h:i A', $booking->get_start('edit'));
                                    $resource = $booking->get_resource();
                                    ?>
                                        <div style="display: flex;margin-top: 15px;">
                                            <div style="width:max-content;color:#000;margin: 0 auto 0 0;">
                                                TOUR DATE:<br /><?php echo $tour_date; ?>
                                            </div>
                                            <div style="width:max-content;color:#000;margin: 0 auto;"> 
                                                START TIME:<br /><?php echo $start_time; ?>
                                            </div>
                                            <?php
                                                if ($product->has_persons()) {
                                                    if ($product->has_person_types()) {
                                                        $person_types = $product->get_person_types();
                                                        $person_counts = $booking->get_person_counts();
                                                        if (!empty($person_types) && is_array($person_types)) {
                                                            foreach ($person_types as $person_type) {
                                                                if (empty($person_counts[$person_type->get_id()])) {
                                                                    continue;
                                                                }
                                                                echo '<div style="width:max-content;color:#000;margin: 0 auto;text-align:center;"><span style="text-transform:uppercase;">'.$person_type->get_name().':</span><br />'.$person_counts[$person_type->get_id()].'</div>';
                                                            }
                                                        }
                                                    } else {
                                                        echo '<div style="width:max-content;color:#000;margin: 0 auto;text-align:center;">Persons:<br/>'.array_sum($booking->get_person_counts()).'</div>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <div style="width:100%;color:#000; margin-top: 15px;">
                                            <?php echo '<span style="text-transform:uppercase;">'.$product->get_resource_label().':</span><br />'.$resource->get_name(); ?>
                                        </div>
                                    <?php
                                }
                            }
                        }
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
                                <h4 style="color:#E81B10 !important;font-size:16px !important;margin-top:10px;">IMPORTANCE: <?php echo $pickup_text; ?></h4>
                                <div class="pickup_description">
                                <h4 style="color:#E81B10 !important;font-size:16px !important;margin-top:10px;">PLEASE MEET US AT:</h4>
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
            if (file_exists($file_ticket_url)) {
                echo "<a href='".$ticket_image."' download class='noLightbox'><img src='".$ticket_image."' class='ticket_number' alt='".$ticket."'></a>";
            }
        }
    }
    if (!empty($footer_email_product)) {
        echo $footer_email_product;
    }
}

echo '<a href="https://www.hawaiitours.com/" target="_blank" style="background-color: #4299c8;border-radius: 20px;padding: 10px 20px; display: block; width: max-content; margin: 15px auto;color:#fff;text-decoration: none;">CONTINUE TO HOMEPAGE</a>';
echo '<h2 style="text-align: center;color: #2189C1 !important;font-size: 25px !important;font-weight: 500 !important;">You may be interested in…</h2>';

?>

<div>
    <div>
        <div>
            <div>
                <ul style="grid-template-columns: repeat(3, 1fr);list-style:none;padding-left:0;">
                <?php
                wp_reset_query();
                global $wpdb;
                $tax_query = array();
                $tax_query[] = array(
                    'taxonomy' => 'product_tag',
                    'field' => 'id',
                    'terms' => $islands_id,
                    'operator' => 'AND'
                );
                if(!empty($exclude_cate_pht)){
                    $tax_query[] = array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => explode(',', $exclude_cate_pht),
                        'operator' => 'NOT IN'
                    );
                }
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => 1,
                    'meta_key'  => 'filtering_priority',
                    'orderby'   => 'meta_value_num',
                    'order' => 'ASC',
                    'offset' => 0,
                    'posts_per_page' => 3,
                    'tax_query' => $tax_query,
                    'post__not_in' => $exclude_product_ids
                );
                $query = new WP_Query($args);
                $count_product = $query->found_posts;
                if ($count_product < 3) {
                    $tax_query_or = array();
                    $tax_query_or[] = array(
                        'taxonomy' => 'product_tag',
                        'field' => 'id',
                        'terms' => $islands_id,
                        'operator' => 'OR'
                    );
                    $args_or = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'meta_key'  => 'filtering_priority',
                        'orderby'   => 'meta_value_num',
                        'order' => 'ASC',
                        'offset' => 0,
                        'posts_per_page' => 9,
                        'tax_query' => $tax_query_or,
                        'post__not_in' => $exclude_product_ids
                    );
                    $query = new WP_Query($args_or);
                }

                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = $query->post->ID;
                    $product_title = $query->post->post_title;
                    $fareharbor_link = get_post_meta($post_id, 'enable_fareharbor_popup_link', true);
                    $link_product = get_permalink();
                    if (!empty($fareharbor_link)) {
                        $link_product = $fareharbor_link;
                    }
                    ?>
                    <li class="<?php echo implode(" ", get_post_class()); ?>" style="margin-left:0;margin-bottom:20px;">
                        <a href="<?php echo $link_product; ?>" style="text-decoration:none;display:flex;">
                            <?php echo get_the_post_thumbnail($post_id, 'medium'); ?>
                            <div class="avia_cart_buttons single_button">
                                <p style="color:#000;font-size:17px;font-weight:600;"><?php echo $product_title; ?></p>
                                <?php
                                $mm_builder_open = get_post_meta( $post_id, 'mm_builder', true );
                                if ($mm_builder_open == 'activate'){?>
                                    <?php
                                        $short_description = get_post_meta( $post_id, 'short_description_description', true );
                                        if($short_description){
                                            $description = wordwrap($short_description, 65);
                                            $description = explode("\n", $description);
                                            $description = $description[0] . '...';
                                            $short_description = $description;
                                            echo '<p style="font-size:15px;">' . $short_description . '</p>';
                                        }
                                    }else{
                                        $excerpt_inner = get_the_excerpt();
                                        $excerpt_inner = stripslashes(wpautop(trim(html_entity_decode($excerpt_inner))));
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
                                            $description = wordwrap($description, 65);
                                            $description = explode("\n", $description);
                                            $description = $description[0] . '...';
                                            $excerpt_inner = $description;
                                        }
                                        echo '<p style="font-size:15px;">'.$excerpt_inner.'</p>';
                                        ?>
                                <?php } ?>
                                <button style="background-color:#FF9903;border:none;padding: 10px 20px;border-radius:20px;color:#fff;cursor:pointer !important;">Explore now</button>
                            </div>
                        </a>
                    </li>
                    <?php
                }
                wp_reset_query();
                wp_reset_postdata();
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
do_action('woocommerce_email_footer', $email);

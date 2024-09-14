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
do_action('woocommerce_email_header', $email_heading, $email);


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
$emailTemplate = get_option('ht_email_template_content');

$firstName = get_post_meta($order->ID, '_billing_first_name', true);
?>
<h3>Aloha <?php echo $firstName . ','; ?></h3>
<?php
if (!empty($emailTemplate) && $pht_tour) {
    echo '</br>';
    echo '<div style="color:#636363;" class="content">';
    echo $emailTemplate;
    echo '</div>';
    echo '</br>';
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
echo '<br>'; 
?>
<?php
/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email);
echo $footer_email_product;
/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);

/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
$emailTemplate = get_option('ht_email_template_content_footer');
if (!empty($emailTemplate) && $pht_tour) {
    echo '<div style="color:#636363;" class="content">';
    echo $emailTemplate;
    echo '</div>';
}
do_action('woocommerce_email_footer', $email);

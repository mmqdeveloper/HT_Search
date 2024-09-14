<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.7.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="woocommerce-order">
    
    <?php if ($order) : ?>
        

        <?php if ($order->has_status('failed')) : ?>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                <?php
                    $pay_url = esc_url($order->get_checkout_payment_url());
                    $invoice_id = get_post_meta($order->get_id(), 'mm_sliced_invoice_id', true);
                    if(!empty($invoice_id)){
                        $pay_url = esc_url(get_permalink($invoice_id));
                    }
                ?>
                <a href="<?php echo $pay_url; ?>" class="button pay"><?php _e('Pay', 'woocommerce') ?></a>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php _e('My account', 'woocommerce'); ?></a>
                <?php endif; ?>
            </p>

        <?php else : ?>
            <div class="section-thank-you">
                <div class="confirm-icon">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_414_17)">
                        <path d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z" fill="#2189C1"/>
                        <path d="M15.9665 30.2704C15.2022 30.3263 14.5709 29.9966 14.0257 29.4838C11.8659 27.4503 9.70391 25.4168 7.55866 23.3676C6.38101 22.2425 6.29162 20.6447 7.30615 19.5553C8.34749 18.438 10.0056 18.3944 11.1978 19.4905C12.5832 20.7642 13.9587 22.0503 15.3039 23.3654C15.6927 23.7453 15.905 23.7866 16.3095 23.3698C20.1933 19.371 24.0994 15.3944 28.0034 11.4134C28.5408 10.8648 29.0391 10.257 29.8291 10.0425C31.0838 9.70168 32.2972 10.1508 32.9184 11.1832C33.5374 12.2134 33.3922 13.5117 32.4972 14.4436C30.4581 16.5676 28.4022 18.6737 26.3475 20.7821C23.5866 23.6145 20.819 26.4402 18.0592 29.2726C17.4838 29.8626 16.8536 30.3162 15.9654 30.2682L15.9665 30.2704Z" fill="white"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_414_17">
                        <rect width="40" height="40" fill="white"/>
                        </clipPath>
                        </defs>
                    </svg>
                </div>
                <div class="thank-for">Mahalo for booking with us</div>
                <p style="text-align: center;margin-bottom: 20px;">We want to extend a big MAHALO to you for choosing <?php $site_name = get_bloginfo('name');echo $site_name;?>.<br> You will love your time in Hawaii!</p>
                <div class="contact-info">If you have any questions or concerns, please email our office at <a href="mailto:<?php $email = get_option('admin_email'); echo $email; ?>"><strong><?php $email = get_option('admin_email'); echo $email?></strong></a> or call <a href="tel:808-379-3701"><strong>808-379-3701</strong></a> for further assistance. We look forward to serving you further.
                </div>
                <div style="text-align: center;">
                    <p style="margin-top:30px;">This is the info we will be using to contact you while in Hawaii. If this is a home number, please let us know.</p>
                    <div style="font-size: 18px;line-height: 25px;display: inline-block;border-left: 1px solid #000000;padding-left: 19px;text-align: left;" class="info-customer">
                        <?php 
                        
                        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();

                        $customer_email = $order->get_billing_email();

                        $customer_phone = $order->get_billing_phone();
                        echo  '<b style="color:#000;">'.$customer_name.'</b>'; ?><br><?php
                        echo  $customer_email;?><br><?php
                        echo  $customer_phone;?>
                    </div>
                    <p style="margin-top:20px;">International travelers should download Whatsapp so we can communicate with you if you don’t have local service.</p>
                </div>

                <div>
                    <p style="margin-top: 30px;">
                        We will send you an email about <strong>72</strong> hours prior to your tour or activity with details about your experience as a reminder, please check that carefully to make sure we have all the right info.
                    </p>
                </div>
                <div>
                    <p class="dont-forget" style="font-style: italic;">
                        Don’t forget to check your spam/junk folder if you don’t see your booking email within <strong>15 minutes</strong>. 
                        You will receive a confirmation email from one of our team with more information about the experience within <strong>48 hours</strong>.
                    </p>
                </div>
            </div> 
            

            <div id="confirm-ss1">
            <h2 class="title-comfirm" style="display: none;"><?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you for booking your tour!', 'woocommerce'), $order); ?></h2>
            <ul class="confirm-header">
                <li style="border-bottom: 1px solid #d8d8d8; padding: 20px; background: #ebebeb;"><strong>Order number: <?php echo $order->get_order_number(); ?></strong></li>
                <li style="border-bottom: 1px solid #d8d8d8; padding: 8px;">
                    <p>We will send you an email about 48 hours prior to your tour or activity with details about pick up time from your hotel, or airport and flight details, depending on which Hawaii Tours you booked.</p>
                </li>
                <li style="border-bottom: 1px solid #d8d8d8; padding: 8px; font-style: italic;font-weight: 600;color: #1B85BD;">
                    <p>Don't forget to check your spam/junk folder if you don't receive your confirmation email within 15 minutes. Contact our customer support team if you need assistance.</p>
                </li>
                <li style="padding: 8px;">
                    <p> Please feel free to email our office at <a href="mailto:<?php $email = get_option('admin_email'); echo $email; ?>"><strong>808-379-3701</strong></a> for further assistance.<br> We look forward to serving you further.</p>
                </li>
            </ul>
            </div>
            <div id="confirm-ss2">
                <h3 style="padding: 40px 0px;"><span class="underline">Reservation</span> Received</h3>
				<div style="overflow-x:auto;">
                <table class="order-received" style="width:100%">
                    <tr>
                        <td>ORDER NUMBER</td>
                        <td>DATE</td>
                        <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                        <td>EMAIL</td>
                        <?php endif; ?>
                        <td>TOTAL</td>
                        <?php if ($order->get_payment_method_title()) : ?>
                        <td>PAYMENT METHOD</td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td><strong><?php echo $order->get_order_number(); ?></strong></td>
                        <td><strong><?php echo wc_format_datetime($order->get_date_created()); ?></strong></td>
                        <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                        <td><strong><?php echo $order->get_billing_email(); ?></strong></td>
                        <?php endif; ?>
                        <td><strong><?php echo $order->get_formatted_order_total(); ?></strong></td>
                        <?php if ($order->get_payment_method_title()) : ?>
                        <td><strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong></td>
                        <?php endif; ?>
                    </tr>
                </table>
				</div>
            </div>
            
            
            <p style="display: none">Mahalo,<br>Pearl Harbor Tours</p>
            

        <?php endif; ?>

        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

    <?php else : ?>

	    <?php wp_redirect( 'https://www.hawaiitours.com/' );
	    exit;
	    ?>

    <?php endif; ?>

    <div class="avia-button-wrap avia-button-center">
        <a class="avia-button avia-icon_select-no avia-color-custom avia-size-large avia-position-center btn-homepage" href="<?php echo site_url(); ?>">
            <span class="avia_iconbox_title">CONTINUE TO HOMEPAGE</span>
        </a>
    </div>

</div>
<?php
$islands = array();
$islands_id = array();
$exclude_product_ids = array();
$exclude_cate_pht = '';
foreach ($order->get_items() as $order_item_id => $item) {
    $product_id = $item->get_product_id();
    $exclude_product_ids[]=$product_id;
    $categories = get_the_terms( $product_id, 'product_cat' );
    foreach($categories as $category ){
        /*if($category->name =='Oahu' || $category->name =='Maui' || $category->name =='Big Island' || $category->name =='Kauai' || $category->name =='Packages'){
            $islands[] = $category->name;
            if(!in_array($category->term_id, $islands_id)){
                $islands_id[] = $category->term_id;
            }
        }*/
        if($category->name =='Pearl Harbor' || $category->name =='Pearl Harbor Tours'){
            $exclude_cate_pht = '587,16738';
        }
    }
    $tags = get_the_terms( $product_id, 'product_tag' );
    foreach($tags as $tag ){
        if($tag->name =='Oahu' || $tag->name =='Maui' || $tag->name =='Big Island' || $tag->name =='Kauai' || $tag->name =='Package'){
            $islands[] = $tag->name;
            if(!in_array($tag->term_id, $islands_id)){
                $islands_id[] = $tag->term_id;
            }
        }
    }
}
$islands_id[] = 5057;

// if(!empty($islands)){
//     $popular_title = "Do More On ".$islands[0].". Consider These Popular Experiences!";
// }else{
//     $popular_title = "Most Popular ".get_bloginfo('name');
// }
$popular_title = "You may be interested in…";
?>
<div class="popular-post">
    <h3 class="heading-title"><?php echo $popular_title;  ?></h3>
    <div class="mmproduct-slider">
        <div data-interval data-animation data-hoverpause='1' class='shop-filter-product template-shop avia-content-slider avia-content-grid-active avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling' >
            <div class='avia-content-slider-inner'>
                <ul class="products mm-filter-product" style="grid-template-columns: repeat(3, 1fr);">
                    
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
                    'posts_per_page' => 9,
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
                    <li class="<?php echo implode(" ", get_post_class()); ?>">
                        <a href="<?php echo $link_product; ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                            <div class="thumbnail_container mm_thumbnail">
                                <div class="mm-tag-button">
                                    <?php
                                    if (is_object_in_term($post_id, 'product_tag', 'likely-to-sell-out')) {
                                        ?>
                                        <span class="tag-like-to-sell-out">Likely to Sell Out</span>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (is_object_in_term($post_id, 'product_tag', 'popular-tour')) {
                                        ?>
                                        <span class="tag-popular-tour">Popular Tour</span>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php echo get_the_post_thumbnail($post_id, 'shop_catalog'); ?>
                                <p class="woocommerce-loop-product__title title_mm">
                                    <?php echo $product_title; ?>
                                    <?php
                                    $rating = 5;
                                    $postmeta_table = $wpdb->prefix . "postmeta";
                                    $query_rating = "
                                        SELECT      meta_value
                                        FROM        $postmeta_table
                                        WHERE       `post_id` = %s AND `meta_key` LIKE '%bsf-schema-pro-rating%'
                                    ";
                                    $query_rating = $wpdb->prepare($query_rating, $post_id);
                                    $results_rating = $wpdb->get_results($query_rating);
                                    if(!empty($results_rating)){
                                        if(isset($results_rating[0]->meta_value)){
                                            $rating = $results_rating[0]->meta_value;
                                        }
                                    }
                                    $full  = '<span class="dashicons dashicons-star-filled"></span>';
                                    $semi  = '<span class="dashicons dashicons-star-half"></span>';
                                    $empty = '<span class="dashicons dashicons-star-empty"></span>';

                                    $html_rating = str_repeat( $full, floor( $rating ) );

                                    if( $rating > floor( $rating ) ){

                                        $html_rating .= $semi;
                                    }

                                    $html_rating .= str_repeat( $empty, 5 - ceil( $rating ) );
                                    $star_rating = '<span class="mm-title-rating">'.$html_rating.'</span>';
                                    ?>
                                    <?php echo $star_rating; ?>
                                </p>
                            </div>
                            <!--</a>-->
                            <?php
                            $mm_builder_open = get_post_meta( $post_id, 'mm_builder', true );
                            if ($mm_builder_open == 'activate'){?>
                                <div class="inner_product_header">
                                    <?php
                                        $short_description = get_post_meta( $post_id, 'short_description_description', true );
                                        if($short_description){
                                            $description = wordwrap($short_description, 65);
                                            $description = explode("\n", $description);
                                            $description = $description[0] . '...';
                                            $short_description = $description . ' <span class="more-description">More</span>';
                                            echo '<p>' . $short_description . '</p>';
                                        }

                                        $number_list_items = get_post_meta($post_id, 'short_description_list_items', true);
                                        if($number_list_items > 0){
                                            $output_list_items = "";
                                            for( $j = 0; $j < $number_list_items; $j++ ){
                                                $list_items_text = get_post_meta( $post_id, 'short_description_list_items_' . $j . '_text', true );
                                                $list_items_icon = get_post_meta( $post_id, 'short_description_list_items_' . $j . '_icon', true );
                                                if( $list_items_text ){
                                                    $output_list_items .= '<li>';
                                                    if( $list_items_icon ){
                                                        $src_text = wp_get_attachment_url( $list_items_icon );
                                                        $alt_text = get_post_meta($list_items_icon, '_wp_attachment_image_alt', true);
                                                        
                                                        $output_list_items .= '<div class="av-icon-char" style="padding-right: 10px;" aria-hidden="true">';
                                                        $output_list_items .= '<img loading="lazy" src="' . $src_text . '" alt="' . $alt_text . '" width="55" height="55">';
                                                        $output_list_items .= '</div>';
                                                    }
                                                    $output_list_items .= $list_items_text;
                                                    $output_list_items .= '</li>';
                                                }
                                            }
                                            echo '<ul style="padding-top: 20px">' . $output_list_items . '</ul>';
                                        }
                                    ?>
                                </div>
                            <?php }else{ ?>
                                <div class="inner_product_header">
                                    <?php
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
                                            $feature_list = substr($excerpt_inner, $pos);
                                            $description = wordwrap($description, 65);
                                            $description = explode("\n", $description);
                                            $description = $description[0] . '...';
                                            $excerpt_inner = $description . ' <span class="more-description">More</span> ' . $feature_list;
                                        }
                                        echo do_shortcode($excerpt_inner);
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="avia_cart_buttons single_button">
                                <span class="wc-price">
                                    <span class="starting-price">from</span>
                                    <?php
                                    $product = wc_get_product($post_id);
                                    if ('gift-card' == $product->get_type()) {
                                        $amounts = $product->get_amounts_to_be_shown();
                                        foreach ($amounts as $value => $item) {
                                            echo wc_price($item['price']);
                                            break;
                                        }
                                    } else
                                        echo wc_price($product->get_price());
                                    ?>
                                </span>
                                <button data-quantity="1"  data-product_sku="" class="button product_type_booking add_to_cart_button">BOOK NOW</button>

                            </div>
                        </a>
                            <?php do_action('woocommerce_like_after_shop_loop_product',$post_id); ?>
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
<script>
jQuery.get("https://api.ipdata.co", function (response) {
                sessionStorage.setItem("country_code", response.country_code); 
 }, "jsonp");
  
 
</script>
<?php
$add_apigg =  get_post_meta( $order->get_id(), 'show_api', true );
if($add_apigg == ''){
	update_post_meta( $order->get_id(), 'show_api', 'yes' );
	?>
	<script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>
	<script>
		window.renderOptIn = function() {
			window.gapi.load('surveyoptin', function() {
				var country_code = sessionStorage.getItem("country_code");
				var date_booking = jQuery(".booking-date").text();
				window.gapi.surveyoptin.render({
					 // REQUIRED FIELDS
					 "merchant_id": 121191830,
					 "order_id": <?php echo $order->get_id(); ?>,
					 "email": "<?php echo $order->get_billing_email(); ?>",
					 "delivery_country": country_code,
					 "estimated_delivery_date": date_booking,
				   });
			   });
			}
	</script>
<?php }
 ?>

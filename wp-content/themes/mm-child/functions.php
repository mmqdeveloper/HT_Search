<?php
@ini_set('memory_limit', '-1');
 
if (!class_exists("Mobile_Detect")) {
    require "includes/Mobile_Detect.php";
}
require "includes/booking-you-save.php";
require "core/custom-metabox.php";
require "includes/add_search_select_resource.php";
require "core/remove_shortcodes.php";
require "core/wpseo-class-support-wp-core.php";
require "core/wpseo-remove-date-publish.php";
require "core/hook-wpmail-func.php";
require "core/core_meta_boxes.php";
require_once ('module/index.php');

//Ben
require "hubspot.php";

if( ! defined('TEMPLATE_FILE_POPUP') ){
    
    define('TEMPLATE_FILE_POPUP', get_template_directory() . '/config-templatebuilder/avia-template-builder/php');
}

if (TEMPLATE_FILE_POPUP) {
    if (file_exists(TEMPLATE_FILE_POPUP . '/shortcode-template.class.php')) {
        require_once( TEMPLATE_FILE_POPUP . '/shortcode-template.class.php');
    }else{
        require_once( TEMPLATE_FILE_POPUP . '/class-shortcode-template.php');
    }
    require "includes/gallery.php";
    require "includes/slideshow_accordion.php";
    require "includes/mm_testimonials.php";
    require "includes/mm_text_block.php";
    require "includes/mm_snippet_information-icon.php";
    require "includes/mm_image_hotspots.php";
    require "includes/avia_social_media_icons.php";
    //require "includes/image.php";
    require "includes/mm_toggles.php";
    require "includes/mm_productslider.php";
    require "includes/mm_tabs.php";
    require "includes/mm_products.php";
    require "includes/mm_grid_products.php";
    require "includes/filter-product.php";
    require "includes/mm_box_image.php";
    require "includes/mm_review_star_bar.php";
    require "includes/mm_codeblock.php";
    require "includes/mm_slideshow.php";
    require "includes/mm_slideshowzoom.php";
    require "includes/mm_video.php";
    require "includes/mm_booking_slider.php";
    require "includes/mm-av-helper-booking-slide.php";
    require "includes/button_mm.php";
    require "includes/mm-blog.php";
    require "includes/mm_masory_gallery.php";
    require "includes/mm_section.php";
    require "includes/mm_grid_row.php";
    require "includes/mm-av-helper-masonry.php";
	require "includes/mm-av-helper-booking-slide.php";
    require "includes/time_open.php";
    require "includes/vt_resize.php";
    require "includes/mm_blog_post.php";
    require "includes/mm_auto_update_price_rc.php";
    require "includes/mm_filter_table_list_admin.php";
    //require "includes/mm_hook.php";
    require "includes/sidebar-blog.php";
    require "includes/mm_special_heading_h1.php";
    require "includes/mm_special_heading_h2.php";
    require "includes/mm_special_heading_h3.php";
    require "includes/mm_special_heading_h4.php";
    require "includes/mm_special_heading_h5.php";
    require "includes/mm_special_heading_wishlist_share.php";
    require "includes/mm_color_section_element.php";
    require "includes/mm_faq.php";
    //require "includes/mm_faq_pap.php";
    require "includes/mm_faq_pt.php";
    require "includes/product_snippet_button.php";
    require "includes/mm_grid_content.php";
    require "includes/global-option.php";
    require "includes/gallery_horizontal.php";
    require "includes/mm_certificate_tags.php";
//    require "includes/mm_faq_icons.php";
    require "includes/site-map.php";
    require "includes/mm_image_desktop_mobile.php";
    require "includes/tab_section.php";
    require "includes/tab_sub_section.php";
    require "includes/mm-bookingbox-product.php";
    require "includes/mm-fareharbor-box.php";
    require "includes/mm_restaurants.php";
    require "includes/mm_hotels.php";
	require "includes/mm_reviews.php";
	require "includes/show-phone-header.php";
	require "includes/mm_search_faq.php";
    require "includes/site-map-tag.php";
    require "includes/mm_social_share.php";
    require "includes/mm-heading.php";
    require "includes/mm_breadcrumb.php";
    require "includes/mm-blogs-filtering.php";
    require "includes/mm_image_zoom.php";
	//require "includes/mm_cron_add_SKU_product.php";
}
require "includes/mm_restaurant_function.php";
require "includes/mm_hotel_function.php";
require "includes/product-short-description.php";
require "includes/mm_bookable_resource.php";
require "includes/mm_hide_some_sections_for_user_editor.php";
require "includes/mm_prevent_duplicate_booking.php";
require "includes/mm_role_permission.php";
require "includes/mm_tour_filtering.php";
require "includes/mm_certificate_default_vp.php";
require "includes/mm-cruise-ship.php";
require "includes/mm_tracking_log_edit.php";
require "includes/mm_blogs_filtering_ajax.php";
require "module/search/mms.php";
// require "includes/mm_export_data_fhdn_product.php";

if (!function_exists('mm_check_tour_island')) {
    function mm_check_tour_island ($classes) {
        global $post;
        if (is_singular() && 'product' === get_post_type($post)) {
            $product_cates = wp_get_post_terms(get_the_ID(), 'product_cat');
            $islands = 'island-';
            if ($product_cates) {
                foreach($product_cates as $product_cate) {
                    if ($product_cate->parent != 0) {
                        $islands .= get_term($product_cate->parent, 'product_cat')->slug;
                        break;
                    }
                }
                $classes[] = $islands;
            }
        }
        return $classes;
    }
    add_filter('body_class', 'mm_check_tour_island');
}

if (!function_exists('mm_check_cart_empty')) {
    function mm_check_cart_empty ($classes) {
        global $woocommerce;
        if (isset($woocommerce) && is_object($woocommerce)) {
            if (!empty($woocommerce->cart) && empty($woocommerce->cart->get_cart())) {
                $classes[] = 'cart-empty';
            }
        }
        return $classes;
    }
    add_filter('body_class', 'mm_check_cart_empty');
}

// mm remove cc and bcc for email request password
if (!function_exists('mm_remove_cc_and_bcc_for_email_request_password')) {
    function mm_remove_cc_and_bcc_for_email_request_password ($atts) {
        if (isset($atts['subject']) && strpos($atts['subject'], 'Password Reset Request') !== false) {
            $atts['headers'] = array();
        }
        return $atts;
    }
    add_filter('wp_mail', 'mm_remove_cc_and_bcc_for_email_request_password');
}

if (!function_exists('mm_check_is_vp_page')) {
    function mm_check_is_vp_page ($classes) {
        global $post;
        $is_vp_page = get_post_meta( $post->ID, 'header_transparency', true );
        if (isset($is_vp_page) && ($is_vp_page == 'header_vacation_packages')) {
            $classes[] = 'mm-vp-page';
        }
        return $classes;
    }
    add_filter('body_class', 'mm_check_is_vp_page');
}

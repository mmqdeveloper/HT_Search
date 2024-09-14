<?php

/**
 * Loads the parent stylesheet.
 */
function mm_load_parent_stylesheet() {
    wp_enqueue_style('parent-styles', get_template_directory_uri() . '/style.css');
}

/* Indeed */
if (!function_exists('ht_remove_affiliate_pro_css')) {

    function ht_remove_affiliate_pro_css() {
        wp_dequeue_style('uap_public_style');
        wp_dequeue_style('uap_templates');
    }

}
add_action('wp_print_styles', 'ht_remove_affiliate_pro_css', 100);

if (!function_exists('ht_indeed_add_google_fonts')) {
 
    function ht_indeed_add_google_fonts() {
        // wp_enqueue_style( 'ht-google-fonts-open-san', 'https://fonts.googleapis.com/css?family=Open+Sans:100,400,300,500,600,700', false ); 
        // wp_enqueue_style( 'ht-google-fonts-oswald', 'https://fonts.googleapis.com/css?family=Oswald:100,400,300,600,700', false ); 
        // wp_enqueue_style( 'ht-google-fonts-roboto', 'https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,600,700', false ); 
    }

}
add_action('wp_enqueue_scripts', 'ht_indeed_add_google_fonts');

/* End Indeed */


add_action('wp_enqueue_scripts', 'mm_load_parent_stylesheet');
if (!function_exists('mm_child_script')) {

    function mm_child_script() {
	    global $post;
        wp_enqueue_style('css-slider', get_stylesheet_directory_uri() . '/assets/css/flickity-docs.css', array(), '1.0.1', 'all');
        wp_enqueue_style('mm-booking-box-css', get_stylesheet_directory_uri() . '/assets/css/booking-box.css', array(), '4.5.3', 'all');
        wp_enqueue_style('mm-cruise-ship-css', get_stylesheet_directory_uri() . '/assets/css/cruise-ship.css', array(), '1.2.2', 'all');
        wp_enqueue_style('mm-child-css', get_stylesheet_directory_uri() . '/assets/css/mm-child.css', array(), '1.5.9', 'all');
        wp_enqueue_style('custom-mm-child-css', get_stylesheet_directory_uri() . '/assets/css/custom-mm-child.css', array(), '1.5.1', 'all');
        wp_enqueue_style('css-custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), '11.2.3', 'all');
        wp_enqueue_style('css-min-fontawesome', get_stylesheet_directory_uri() . '/assets/css/font-awesome.min.css', array(), '1.0.1', 'all');
        wp_enqueue_style('css-form', get_stylesheet_directory_uri() . '/assets/css/form.css', array(), '1.8.7', 'all');
        wp_enqueue_style('css-menu', get_stylesheet_directory_uri() . '/assets/css/css-menu.css', array(), '1.3.6', 'all');
        wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/custom-style.css', array(), '4.8.5', 'all');
        wp_enqueue_style('css-toggle', get_stylesheet_directory_uri() . '/assets/css/toggle.css', array(), '1.0.2', 'all');
        wp_enqueue_style('ninjaform-style', get_stylesheet_directory_uri() . '/assets/css/ninjaform-style.css', array(), '1.1.7', 'all');
        wp_enqueue_style('google-fonts-Raleway', 'https://fonts.googleapis.com/css?family=Raleway:300,300italic,400,400italic,500,500italic,600,600italic,700,700italic', false);
        wp_enqueue_style('yellow-pencil', get_stylesheet_directory_uri() . '/assets/css/yellow_pencil_style.css', array(), '1.1.3', 'all');
        wp_enqueue_style('tour-box', get_stylesheet_directory_uri() . '/assets/css/tour-box.css', array(), '2.1.0', 'all');
        wp_enqueue_style('checkout-page', get_stylesheet_directory_uri() . '/assets/css/checkout-page.css', array(), '1.7.8', 'all');
        wp_enqueue_style('my-account-page', get_stylesheet_directory_uri() . '/assets/css/my_account.css', array(), '1.2.0', 'all');
        //Indeed
        wp_enqueue_style('indeed_main_public', get_stylesheet_directory_uri() . '/assets/css/indeed_main_public.css', array(), '1.0.1', 'all');
        wp_enqueue_style('indeed_templates', get_stylesheet_directory_uri() . '/assets/css/indeed_templates.css', array(), '1.0.2', 'all');
        //End Indeed
        wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), '4.7.4', true);
	    wp_localize_script( 'custom-js', 'ajax_custom_js', array(
			    'ajax_url' => admin_url( 'admin-ajax.php' ),
			    'product_id' => $post->ID )
	    );
        wp_enqueue_style('mms-search', get_stylesheet_directory_uri() . '/assets/css/mms.css', array(), '1.0.0', 'all');
        wp_enqueue_script('mms-search-js', get_stylesheet_directory_uri() . '/assets/js/mms.js', array('jquery'), '1.0.0', true);
        wp_localize_script('mms-search-js', 'mmsAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
        //wp_enqueue_script('match-height', 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/9487/jquery.matchHeight-min.js', array('jquery'), '1.0', true); 
        wp_enqueue_script('match-height-js', get_stylesheet_directory_uri() . '/assets/js/jquery.matchHeight.js', array('jquery'), '1.0.1', true);
        wp_enqueue_script('auto-select-js', get_stylesheet_directory_uri() . '/assets/js/auto_select_island.js', array('jquery'), '1.7.5', true);
        wp_enqueue_script('js-booking-form', get_stylesheet_directory_uri() . '/assets/js/booking_form.js', array('jquery'), '7.8.6', true);
        wp_enqueue_script('avia_styleswitch', get_stylesheet_directory_uri() . '/assets/js/avia_styleswitch.js', array('jquery'), '1.0.1', true);
        //wp_enqueue_style('font-awesome-icon', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
        wp_enqueue_script('flickity-slider', get_stylesheet_directory_uri() . '/assets/js/flickity-docs.min.js', array('jquery'), '1.0.1', true);
        if ( is_product() ){
            wp_enqueue_style('mm-select2', get_stylesheet_directory_uri() . '/assets/css/select2.min.css', array(), '1.0.0', 'all');
            wp_enqueue_script('mm-select2', get_stylesheet_directory_uri() . '/assets/js/select2.min.js', array('jquery'), '1.0.0', true);
            wp_enqueue_style('mm-timepicker', get_stylesheet_directory_uri() . '/assets/css/jquery.timepicker.min.css', array(), '1.0.0', 'all');
            wp_enqueue_script('mm-timepicker', get_stylesheet_directory_uri() . '/assets/js/jquery.timepicker.min.js', array('jquery'), '1.0.0', true);
        }
        wp_enqueue_script('mm-booking-box-js', get_stylesheet_directory_uri() . '/assets/js/booking-box.js', array('jquery'), '2.6.5', true);
        wp_enqueue_script('mm-js', get_stylesheet_directory_uri() . '/assets/js/mm-script.js', array('jquery'), '1.2.0', true);
        wp_enqueue_script('mm-hotel-rooms-js', get_stylesheet_directory_uri() . '/assets/js/mm-hotel-rooms.js', array('jquery'), '1.0.1', true);
        wp_enqueue_script('prevent-duplicate-booking-js', get_stylesheet_directory_uri() . '/assets/js/mm_prevent_duplicate_booking.js', array('jquery'), '1.5.6', true);
        wp_localize_script( 'prevent-duplicate-booking-js', 'prevent_duplicate_booking', array(
            'user_role' => json_encode(wp_get_current_user()->roles) )
        );
        if (!is_cart() && !is_checkout()) {
            wp_dequeue_script('wc-cart-fragments');
        }
        if (is_cart() || is_checkout()){
            wp_enqueue_script('slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.js', array('jquery'), '1.0.1', true);
            wp_enqueue_style('css-slick', get_stylesheet_directory_uri() . '/assets/css/slick.css', array(), '1.0.1', 'all');
        
        }

        if(get_queried_object_id()==8224){
            wp_enqueue_style( 'about-us-styles', get_stylesheet_directory_uri() . '/assets/css/about-us.css', array(), '1.1.2', 'all');;
        }
        if( get_post_type()=='cruise'||get_queried_object_id()==626756 || is_checkout()) {
            wp_enqueue_style('mm-select2', get_stylesheet_directory_uri() . '/assets/css/select2.min.css', array(), '1.0.0', 'all');
            wp_enqueue_script('mm-select2', get_stylesheet_directory_uri() . '/assets/js/select2.min.js', array('jquery'), '1.0.0', true);
        }
        wp_enqueue_script('cruise-ship-js', get_stylesheet_directory_uri() . '/assets/js/cruise-ship.js', array('jquery'), '1.2.9', true);

    }

    add_action('wp_enqueue_scripts', 'mm_child_script', 9);
}
add_filter( 'ninja_forms_enqueue_scripts', 'mm_nf_datepicker_custom' ); 
if(!function_exists('mm_nf_datepicker_custom')){
    function mm_nf_datepicker_custom() { 
        wp_enqueue_script( 'mm-ninjaform', get_stylesheet_directory_uri() . '/assets/js/mm-ninjaform.js', array( 'jquery' ), '1.0.1', true ); 

    }
}
if (!function_exists('mm_js_filter_element')) {

    function mm_js_filter_element() {
        wp_enqueue_script('js_filter_element', get_stylesheet_directory_uri() . '/assets/js/admin-filter-product.js');
        wp_enqueue_style('css_filter_element', get_stylesheet_directory_uri() . '/assets/css/admin-filter-product.css', array(), '1.6', 'all');
    }

    add_action('admin_enqueue_scripts', 'mm_js_filter_element');
}

// Add file css and js for tracking edit log
if (!function_exists('mm_css_js_mm_tracking_edit_log')) {
    function mm_css_js_mm_tracking_edit_log() {
        wp_enqueue_style('mm-tracking-log-edit-css', get_stylesheet_directory_uri() . '/assets/css/mm-tracking-log-edit.css', array(), '1.0.6', 'all');
        wp_enqueue_script('mm-tracking-log-edit-js', get_stylesheet_directory_uri() . '/assets/js/mm-tracking-log-edit.js', array('jquery'), '1.3.3', true);
	    wp_localize_script( 'mm-tracking-log-edit-js', 'ajax_mm_tracking_log_edit_js', array(
			    'ajax_url' => admin_url( 'admin-ajax.php' ))
	    );
    }
    add_action('admin_enqueue_scripts', 'mm_css_js_mm_tracking_edit_log');
}

/* ---------------------------------------------------------------------------
 * Scripts
 * --------------------------------------------------------------------------- */
if (!function_exists('mm_vie_frontend_scripts')) {

    function mm_vie_frontend_scripts() {
        //js theme 
        wp_enqueue_script('theme-js', get_stylesheet_directory_uri() . '/assets/js/theme.js', false, "10.1", true);
    }

}


if (!function_exists('no_post_nav')) {

    function no_post_nav($entries) {
        $entries = array();
        return $entries;
    }

    add_filter('avia_post_nav_entries', 'no_post_nav');
}


/* Full size */
add_filter('avf_avia_builder_helper_lightbox_size', 'mm_avf_avia_builder_helper_lightbox_size');

function mm_avf_avia_builder_helper_lightbox_size($size) {
    $size = "full";
    return $size;
}

function show_popup_info_special_day() {
    date_default_timezone_set('Pacific/Honolulu');
    $time_hawaii = date('Y-m-d H:i:s');
    $day = date('d', strtotime($time_hawaii));
    $month = date('m', strtotime($time_hawaii));
    $year = date('Y', strtotime($time_hawaii));
    if ($day < 23 && $month == 7 && $year == 2016) {
        ?>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <?php if (is_active_sidebar('info_special_day')) : ?>
                            <?php dynamic_sidebar('info_special_day'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

add_action('wp_footer', 'show_popup_info_special_day');

function feed_the_excerpt() {
    if (is_feed()) {
        global $post;
        $content_new_excerpt = html_entity_decode(apply_filters('the_content', get_the_excerpt($post->ID)));
        $content_excerpt_p = str_replace('<p>', '', $content_new_excerpt);
        $content_excerpt = str_replace('</p>', '', $content_excerpt_p);
        echo '<source><![CDATA[' . $content_excerpt . ']]></source>' . "\n";
    }
}

add_action("rss_item", 'feed_the_excerpt', 1, 1);
add_action("rss2_item", 'feed_the_excerpt', 1, 1);


if (!function_exists('avia_ajax_search')) {
    //now hook into wordpress ajax function to catch any ajax requests
    add_action('wp_ajax_avia_ajax_search', 'avia_ajax_search');
    add_action('wp_ajax_nopriv_avia_ajax_search', 'avia_ajax_search');

    function avia_ajax_search() {
        global $avia_config;

        unset($_REQUEST['action']);
        if (empty($_REQUEST['s']))
            $_REQUEST['s'] = array_shift(array_values($_REQUEST));
        if (empty($_REQUEST['s']))
            die();

        $defaults = array('numberposts' => 5, 'post_type' => array('post', 'page', 'product'), 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false, 'results_hide_fields' => '');

        $_REQUEST['s'] = apply_filters('get_search_query', $_REQUEST['s']);

        $search_parameters = array_merge($defaults, $_REQUEST);

        if ($search_parameters['results_hide_fields'] !== '') {
            $search_parameters['results_hide_fields'] = explode(',', $_REQUEST['results_hide_fields']);
        } else {
            $search_parameters['results_hide_fields'] = array();
        }

        $search_query = apply_filters('avf_ajax_search_query', http_build_query($search_parameters));
        $query_function = apply_filters('avf_ajax_search_function', 'get_posts', $search_query, $search_parameters, $defaults);
        $posts = (($query_function == 'get_posts') || !function_exists($query_function)) ? get_posts($search_query) : $query_function($search_query, $search_parameters, $defaults);

        $search_messages = array(
            'no_criteria_matched' => __("Sorry, no posts matched your criteria", 'avia_framework'),
            'another_search_term' => __("Please try another search term", 'avia_framework'),
            'time_format' => get_option('date_format'),
            'all_results_query' => http_build_query($_REQUEST),
            'all_results_link' => home_url('?' . http_build_query($_REQUEST)),
            'view_all_results' => __('View all results', 'avia_framework')
        );

        $search_messages = apply_filters('avf_ajax_search_messages', $search_messages, $search_query);

        if (empty($posts)) {
            $output = "<span class='ajax_search_entry ajax_not_found'>";
            $output .= "<span class='ajax_search_image " . av_icon_string('info') . "'>";
            $output .= "</span>";
            $output .= "<span class='ajax_search_content'>";
            $output .= "    <span class='ajax_search_title'>";
            $output .= $search_messages['no_criteria_matched'];
            $output .= "    </span>";
            $output .= "    <span class='ajax_search_excerpt'>";
            $output .= $search_messages['another_search_term'];
            $output .= "    </span>";
            $output .= "</span>";
            $output .= "</span>";
            echo $output;
            die();
        }

        //if we got posts resort them by post type
        $output = "";
        $sorted = array();
        $post_type_obj = array();
        foreach ($posts as $post) {
            $sorted[$post->post_type][] = $post;
            if (empty($post_type_obj[$post->post_type])) {
                $post_type_obj[$post->post_type] = get_post_type_object($post->post_type);
            }
        }



        //now we got everything we need to preapre the output
        foreach ($sorted as $key => $post_type) {

            // check if post titles are in the hidden fields list
            if (!in_array('post_titles', $search_parameters['results_hide_fields'])) {
                if (isset($post_type_obj[$key]->labels->name)) {
                    $label = apply_filters('avf_ajax_search_label_names', $post_type_obj[$key]->labels->name);
                    $output .= "<h4>" . $label . "</h4>";
                } else {
                    $output .= "<hr />";
                }
            }


            foreach ($post_type as $post) {


                $image = "";
                $extra_class = "";

                // check if image is in the hidden fields list
                if (!in_array('image', $search_parameters['results_hide_fields'])) {
                    $image = get_the_post_thumbnail($post->ID, 'thumbnail');
                    $extra_class = $image ? "with_image" : "";
                    $post_type = $image ? "" : ( get_post_format($post->ID) != "" ? get_post_format($post->ID) : "standard" );
                    $iconfont = $image ? "" : av_icon_string($post_type);
                }

                $excerpt = "";

                // check if post meta fields are in the hidden fields list
                if (!in_array('meta', $search_parameters['results_hide_fields'])) {
                    if (!empty($post->post_excerpt)) {
                        $excerpt = apply_filters('avf_ajax_search_excerpt', avia_backend_truncate($post->post_excerpt, 70, " ", "...", true, '', true));
                    } else {
                        $excerpt = apply_filters('avf_ajax_search_no_excerpt', get_the_time($search_messages['time_format'], $post->ID), $post);
                    }
                }


                $link = apply_filters('av_custom_url', get_permalink($post->ID), $post);

                $output .= "<a class ='ajax_search_entry {$extra_class}' href='" . $link . "'>";

                if ($image !== "" || $iconfont) {
                    $output .= "<span class='ajax_search_image' {$iconfont}>";
                    $output .= $image;
                    $output .= "</span>";
                }
                $output .= "<span class='ajax_search_content'>";
                $output .= "    <span class='ajax_search_title'>";
                $output .= get_the_title($post->ID);
                $output .= "    </span>";
                $output .= "    <span class='ajax_search_excerpt'>";
                $output .= $excerpt;
                $output .= "    </span>";
                $output .= "</span>";
                $output .= "</a>";
            }
        }

        $output .= "<a class='ajax_search_entry ajax_search_entry_view_all' href='" . $search_messages['all_results_link'] . "'>" . $search_messages['view_all_results'] . "</a>";

        echo $output;
        die();
    }

}
add_filter('searchwp_live_search_query_args', 'ht_filter_live_search', 999);

function ht_filter_live_search($args) {
    $args['post_type'] = array('post', 'page', 'product');
    return $args;
}

add_filter('yikes_woocommerce_custom_repeatable_product_tabs_heading', 'ht_custom_product_tabs_customize_title', 10, 2);

function ht_custom_product_tabs_customize_title($title, $tab) {
    return str_replace(array('<h2', '</h2>'), array('<h5', '</h5>'), $title);
}

//if(!function_exists('avia_ajax_search'))
//{
//now hook into wordpress ajax function to catch any ajax requests
add_action('wp_ajax_avia_ajax_search', 'avia_ajax_search');
add_action('wp_ajax_nopriv_avia_ajax_search', 'avia_ajax_search');

function avia_ajax_search() {
    global $avia_config;

    unset($_REQUEST['action']);
    if (empty($_REQUEST['s']))
        $_REQUEST['s'] = array_shift(array_values($_REQUEST));
    if (empty($_REQUEST['s']))
        die();

    $defaults = array('numberposts' => 5, 'post_type' => 'any', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false, 'results_hide_fields' => '');

    $_REQUEST['s'] = apply_filters('get_search_query', $_REQUEST['s']);

    $search_parameters = array_merge($defaults, $_REQUEST);

    if ($search_parameters['results_hide_fields'] !== '') {
        $search_parameters['results_hide_fields'] = explode(',', $_REQUEST['results_hide_fields']);
    } else {
        $search_parameters['results_hide_fields'] = array();
    }

    $search_query = apply_filters('avf_ajax_search_query', http_build_query($search_parameters));
    $query_function = apply_filters('avf_ajax_search_function', 'get_posts', $search_query, $search_parameters, $defaults);
    $posts = (($query_function == 'get_posts') || !function_exists($query_function)) ? get_posts($search_query) : $query_function($search_query, $search_parameters, $defaults);

    $search_messages = array(
        'no_criteria_matched' => __("Sorry, no posts matched your criteria", 'avia_framework'),
        'another_search_term' => __("Please try another search term", 'avia_framework'),
        'time_format' => get_option('date_format'),
        'all_results_query' => http_build_query($_REQUEST),
        'all_results_link' => home_url('?' . http_build_query($_REQUEST)),
        'view_all_results' => __('View all results', 'avia_framework')
    );

    $search_messages = apply_filters('avf_ajax_search_messages', $search_messages, $search_query);

    if (empty($posts)) {
        $output = "<span class='ajax_search_entry ajax_not_found'>";
        $output .= "<span class='ajax_search_image " . av_icon_string('info') . "'>";
        $output .= "</span>";
        $output .= "<span class='ajax_search_content'>";
        $output .= "    <span class='ajax_search_title'>";
        $output .= $search_messages['no_criteria_matched'];
        $output .= "    </span>";
        $output .= "    <span class='ajax_search_excerpt'>";
        $output .= $search_messages['another_search_term'];
        $output .= "    </span>";
        $output .= "</span>";
        $output .= "</span>";
        echo $output;
        die();
    }

    //if we got posts resort them by post type
    $output = "";
    $sorted = array();
    $post_type_obj = array();
    foreach ($posts as $post) {
        $sorted[$post->post_type][] = $post;
        if (empty($post_type_obj[$post->post_type])) {
            $post_type_obj[$post->post_type] = get_post_type_object($post->post_type);
        }
    }



    //now we got everything we need to preapre the output
    foreach ($sorted as $key => $post_type) {

        // check if post titles are in the hidden fields list
        if (!in_array('post_titles', $search_parameters['results_hide_fields'])) {
            if (isset($post_type_obj[$key]->labels->name)) {
                $label = apply_filters('avf_ajax_search_label_names', $post_type_obj[$key]->labels->name);
                switch ($label) {
                    case 'Page':
                        $label = 'Information & Lists';
                        break;
                    case 'Products':
                        $label = 'Activity';
                        break;
                    case 'Post':
                        $label = 'Information';
                        break;
                    case 'MM FAQ':
                        $label = 'FAQ';
                        break;
                    default:
                        break;
                }
                $output .= "<h4>" . $label . "</h4>";
            } else {
                $output .= "<hr />";
            }
        }


        foreach ($post_type as $post) {


            $image = "";
            $extra_class = "";

            // check if image is in the hidden fields list
            if (!in_array('image', $search_parameters['results_hide_fields'])) {
                $image = get_the_post_thumbnail($post->ID, 'thumbnail');
                $extra_class = $image ? "with_image" : "";
                $post_type = $image ? "" : ( get_post_format($post->ID) != "" ? get_post_format($post->ID) : "standard" );
                $iconfont = $image ? "" : av_icon_string($post_type);
            }

            $excerpt = "";

            // check if post meta fields are in the hidden fields list
            if (!in_array('meta', $search_parameters['results_hide_fields'])) {
                if (!empty($post->post_excerpt)) {
                    $excerpt = apply_filters('avf_ajax_search_excerpt', avia_backend_truncate($post->post_excerpt, 70, " ", "...", true, '', true));
                } else {
                    $excerpt = apply_filters('avf_ajax_search_no_excerpt', get_the_time($search_messages['time_format'], $post->ID), $post);
                }
            }


            $link = apply_filters('av_custom_url', get_permalink($post->ID), $post);

            $output .= "<a class ='ajax_search_entry {$extra_class}' href='" . $link . "'>";

            if ($image !== "" || $iconfont) {
                $output .= "<span class='ajax_search_image' {$iconfont}>";
                $output .= $image;
                $output .= "</span>";
            }
            $output .= "<span class='ajax_search_content'>";
            $output .= "    <span class='ajax_search_title'>";
            $output .= get_the_title($post->ID);
            $output .= "    </span>";
            $output .= "    <span class='ajax_search_excerpt'>";
            $output .= $excerpt;
            $output .= "    </span>";
            $output .= "</span>";
            $output .= "</a>";
        }
    }

    $output .= "<a class='ajax_search_entry ajax_search_entry_view_all' href='" . $search_messages['all_results_link'] . "'>" . $search_messages['view_all_results'] . "</a>";

    echo $output;
    die();
}

//}
add_filter('wp_nav_menu_items', 'avia_append_search_nav', 9997, 2);
add_filter('avf_fallback_menu_items', 'avia_append_search_nav', 9997, 2);

function avia_append_search_nav($items, $args) {
    if (avia_get_option('header_searchicon', 'header_searchicon') != "header_searchicon")
        return $items;
    if (avia_get_option('header_position', 'header_top') != "header_top")
        return $items;

    if ((is_object($args) && $args->theme_location == 'avia') || (is_string($args) && $args = "fallback_menu")) {
        global $avia_config;
        ob_start();
        get_search_form();
        $form = htmlspecialchars(ob_get_clean());

        $items .= '<li id="menu-item-search" class="noMobile menu-item menu-item-search-dropdown menu-item-avia-special">
                                                <a href="/" rel="nofollow" data-avia-search-tooltip="' . $form . '" ' . av_icon_string('search') . '><span class="avia_hidden_link_text">' . __('Search', 'avia_framework') . '</span></a>
                           </li>';
    }
    return $items;
}

function mm_disable_lazyload_menuimage_wprocket($attributes) {
    $attributes[] = 'class="menu-image';

    return $attributes;
}

add_filter('rocket_lazyload_excluded_attributes', 'mm_disable_lazyload_menuimage_wprocket');

/*
 * Remove H2 wp_print_media_templates 12/09/1020
 *
 */
if (!function_exists('remove_print_media_templates')) {

    add_action('wp_head', 'remove_print_media_templates');

    function remove_print_media_templates() {
        remove_action('wp_footer', 'wp_print_media_templates');
    }

}
if (!function_exists('mm_current_year')) {
    add_shortcode('current_year', 'mm_current_year');

    function mm_current_year() {
        return date("Y");
    }

}
/*
 * shortcode [mm_footer_search_Tour] 03/14/2023 Lam Truong
 *
 */
if (!function_exists('mm_footer_search_tour')) {
    
    add_shortcode('footer_search_tour', 'mm_footer_search_tour');

    function mm_footer_search_tour($args) {
        if( is_front_page() )
            return '';
            
        return '<div class="footer_search">
        <p class="headding-findtour">' .$args['headding-findtour']. '</p>
        ' .do_shortcode('[mm_quick_search]'). '
        </div>';
    }
}

//Ben
add_theme_support('avia_template_builder_custom_tab_toogle_id');

/*
 * Some server configurations seem to cache WP options and do not return changed options - so we generate a new file again and again
 * This filter allows to return the same value (or a custom value) for each file. "---" is added to seperate and identify as added value.
 * Return empty string to avoid adding.
 * 
 * The following snippet shows what to return.
 * 
 * @since 4.7.2.1
 * @param string $uniqid
 * @param array $data
 * @param WP_Scripts $enqueued
 * @param string $file_group_name
 * @param array $conditions
 * @return string               
 */

function avf_custom_merged_files_unique_id($uniqid, $file_type, $data, $enqueued, $file_group_name, $conditions) {
    return '';
}

add_filter('avf_merged_files_unique_id', 'avf_custom_merged_files_unique_id', 10, 6);
//ninja-form waitlist
//add_filter( 'ninja_forms_submit_data', 'my_ninja_forms_submit_data' );
//
//function my_ninja_forms_submit_data( $form_data ) {
//    echo "ninja form";
//  foreach( $form_data[ 'fields' ] as $field ) { // Field settigns, including the field key and value.
//
//      if( 'deal_name_1619608543892' != $field[ 'key' ] ) continue; // Check the field key to see if this is the field that I need to update.
//
//      $field[ 'value' ] = 'foo'; // Update the submitted field value.
//  }
//
//  $form_settings = $form_data[ 'settings' ]; // Form settings.
//
//  $extra_data = $form_data[ 'extra' ]; // Extra data included with the submission.
//
//  return $form_data;
//}
//add_action( 'ninja_forms_after_submission', 'my_ninja_forms_processing_callback' );
//
///**
// * @param $form_data array
// * @return void
// */
//function my_ninja_forms_processing_callback( $form_data ){
//  $form_id       = $form_data[ 'form_id' ];
//
//  $form_fields   =  $form_data[ 'fields' ];
//  foreach( $form_fields as $field ){
//      $field_id    = $field[ 'id' ];
//      $field_key   = $field[ 'key' ];
//      $field_value = $field[ 'value' ];
//
//      // Example Field Key comparison
//      if( 'deal_name_1619608543892' == $field_key ){
//          // This is the field that you are looking for.
//          $field_value = 'hung trinh';
//      }
//  }
//
//  $form_settings = $form_data[ 'settings' ];
//  $form_title    = $form_data[ 'settings' ][ 'title' ];
//}
add_filter('auto_update_plugin', '__return_false');
add_filter('auto_update_theme', '__return_false');
add_filter('woocommerce_breadcrumb_defaults', 'mm_breadcrumb_delimiter');

function mm_breadcrumb_delimiter($defaults) {
    $defaults['delimiter'] = ' > ';
    return $defaults;
}

// hidden all widget on dashboard
if (!function_exists('remove_dashboard_widgets')) {

    function remove_dashboard_widgets() {
        $uid = get_current_user_id();
        // hide welcome panel
        update_user_meta($uid, 'show_welcome_panel', '0');
        // get the current hidden metaboxes
        $hidden = get_user_meta($uid, 'metaboxhidden_dashboard');
        // the metaboxes to be hidden
        $to_hide = array(
            'dashboard_right_now',
            'dashboard_activity',
            'dashboard_quick_press',
            'dashboard_primary',
            'sendgrid_statistics_widget',
            'wpseo-dashboard-overview',
            'woosea_rss_dashboard_widget',
            'fue-dashboard',
            'wordfence_activity_report_widget',
            'jetpack_summary_widget',
            'dashboard_site_health',
            'yith_dashboard_products_news',
            'yith_dashboard_blog_news',
            'wpseo-dashboard-overview',
            'woocommerce_dashboard_status',
            'dashboard_php_nag'
        );
        // if not already hidden, hide
        if ($hidden !== $to_hide) {
            update_user_meta($uid, 'metaboxhidden_dashboard', $to_hide);
        }
    }

    add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
    add_action('wp_user_dashboard_setup', 'remove_dashboard_widgets');
}
if (!function_exists('mm_page404_redirection')) {
    function mm_page404_redirection() {
        global $mapage;
        if (is_404()) {
            wp_redirect(home_url("404-error")); 
            exit;
        }
    }
}
add_action('wp', 'mm_page404_redirection', 1);

add_theme_support('avia_rel_nofollow_for_links');






if (!function_exists('ht_update_recently_viewed_cookie')) {

    function ht_update_recently_viewed_cookie() {
        if (is_singular('product')) { 
            $product_id = get_the_ID();
    
            if (isset($_COOKIE['recently_viewed'])) {
                $recently_viewed = $_COOKIE['recently_viewed'];
                $product_ids = explode(',', $recently_viewed);
    
                $product_ids = array_diff($product_ids, array($product_id));
                
                array_unshift($product_ids, $product_id);
    
                $product_ids = array_slice($product_ids, 0, 5);
    
                $recently_viewed = implode(',', $product_ids);
            } else {
                $recently_viewed = $product_id;
            }
    
            setcookie('recently_viewed', $recently_viewed, time() + 30 * DAY_IN_SECONDS, '/');
        }
        
    }

    add_action('wp', 'ht_update_recently_viewed_cookie');
}
if (!function_exists('ht_update_recently_viewed_cookie')) {

    function ht_update_recently_viewed_cookie() {
        if (is_singular('product')) { 
            $product_id = get_the_ID();
    
            if (isset($_COOKIE['recently_viewed'])) {
                $recently_viewed = $_COOKIE['recently_viewed'];
                $product_ids = explode(',', $recently_viewed);
    
                $product_ids = array_diff($product_ids, array($product_id));
                
                array_unshift($product_ids, $product_id);
    
                $product_ids = array_slice($product_ids, 0, 5);
    
                $recently_viewed = implode(',', $product_ids);
            } else {
                $recently_viewed = $product_id;
            }
    
            setcookie('recently_viewed', $recently_viewed, time() + 30 * DAY_IN_SECONDS, '/');
        }
        
    }
    add_action('wp', 'ht_update_recently_viewed_cookie');
}
if (!function_exists('ht_recently_viewed_shortcode')) {
    function ht_recently_viewed_shortcode($atts) {

        if (isset($_COOKIE['recently_viewed'])) {
            global $wpdb;
            $product_ids = explode(',', $_COOKIE['recently_viewed']);

            $args = array(
                'post_type' => 'product',
                'post__in' => $product_ids,
                'orderby' => 'post__in',
                'posts_per_page' => 9
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) {
                ob_start();
                ?>
                <div data-interval data-animation data-hoverpause="1" class="shop-filter-product template-shop avia-content-slider avia-content-grid-active avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling" >
                    <div class="avia-content-slider-inner">
                        <ul class="products mm-filter-product" style="grid-template-columns: repeat(3, 1fr);">
                        <?php
                        $i = 0;
                        while ($query->have_posts()) : $query->the_post();
                            $mm_product_id = get_the_ID();
                            $mm_product = wc_get_product($mm_product_id);
                            $mm_related_categories_product = wp_get_post_terms($mm_product_id, 'product_cat', array('fields' => 'names'));
                            $mm_related_tags_product = wp_get_post_terms($mm_product_id, 'product_tag', array('fields' => 'names'));

                            $fareharbor_link = get_post_meta($mm_product_id, 'content_book_booking_box_fareharbor_popup', true);
                            if (empty($fareharbor_link)) {
                                $fareharbor_link = get_post_meta($mm_product_id, 'enable_fareharbor_popup_link', true);
                            }
                            $link_product = get_permalink($mm_product_id);
                            if (!empty($fareharbor_link)) {
                                $link_product = $fareharbor_link;
                            }
                            ?>
                            <li class="post-<?php echo $mm_product_id; ?> product type-product status-publish has-post-thumbnail certificates-adventure certificates-be-reef-safe certificates-bucket-list certificates-hvcb-member <?php echo implode(' product_cat-', $mm_related_categories_product ); ?> <?php echo implode(' product_tag-', $mm_related_tags_product ); ?> tm-no-options first instock sold-individually taxable shipping-taxable purchasable product-type-booking">
                                <a href="<?php echo $link_product; ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                    <div class="thumbnail_container mm_thumbnail">
                                        <div class="mm-tag-button">
                                            <?php
                                            if (is_object_in_term($mm_product_id, 'product_tag', 'likely-to-sell-out')) {
                                                ?>
                                                <span class="tag-like-to-sell-out">Likely to Sell Out</span>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if (is_object_in_term($mm_product_id, 'product_tag', 'popular-tour')) {
                                                ?>
                                                <span class="tag-popular-tour">Popular Tour</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php echo $mm_product->get_image(); ?>
                                        <p class="woocommerce-loop-product__title title_mm">
                                            <?php echo $mm_product->get_title(); ?>
                                            <?php
                                            $rating = 5;
                                            $postmeta_table = $wpdb->prefix . "postmeta";
                                            $query_rating = "
                                                SELECT      meta_value
                                                FROM        $postmeta_table
                                                WHERE       `post_id` = %s AND `meta_key` LIKE '%bsf-schema-pro-rating%'
                                            ";
                                            $query_rating = $wpdb->prepare($query_rating, $mm_product_id);
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
                                    <?php 
                                    $mm_builder_open = get_post_meta( $mm_product_id, 'mm_builder', true );
                                    if ($mm_builder_open == 'activate'){?>
                                        <div class="inner_product_header">
                                            <?php
                                                $short_description = get_post_meta( $mm_product_id, 'short_description_description', true );
                                                if($short_description){
                                                    $description = wordwrap($short_description, 65);
                                                    $description = explode("\n", $description);
                                                    $description = $description[0] . '...';
                                                    $short_description = $description . ' <span class="more-description">More</span>';
                                                    echo '<p>' . $short_description . '</p>';
                                                }

                                                $number_list_items = get_post_meta($mm_product_id, 'short_description_list_items', true);
                                                if($number_list_items > 0){
                                                    $output_list_items = "";
                                                    for( $i = 0; $i < $number_list_items; $i++ ){
                                                        $list_items_text = get_post_meta( $mm_product_id, 'short_description_list_items_' . $i . '_text', true );
                                                        $list_items_icon = get_post_meta( $mm_product_id, 'short_description_list_items_' . $i . '_icon', true );
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
                                        /*$excerpt = get_post_meta($mm_product_id, 'description_inner', true);
                                        if (is_front_page() || $excerpt == '') {
                                            $excerpt = $mm_product->get_short_description();
                                        } else {
                                            $excerpt = stripslashes(wpautop(trim(html_entity_decode($excerpt))));
                                        }*/
                                        $excerpt = $mm_product->get_short_description();
                                        $pos_array = array();
                                        if (strlen(strstr($excerpt, '</p>')) > 0) {
                                            $pos_array[] = strpos($excerpt, '</p>');
                                        }
                                        if (strlen(strstr($excerpt, '<br')) > 0) {
                                            $pos_array[] = strpos($excerpt, '<br');
                                        }
                                        if (strlen(strstr($excerpt, 'av_hr')) > 0) {
                                            $pos_array[] = strpos($excerpt, '[av_hr');
                                        }
                                        if(empty($pos_array)){
                                            if (strlen(strstr($excerpt, '<ul')) > 0) {
                                                $pos_array[] = strpos($excerpt, '<ul');
                                            }
                                        }
                                        if (!empty($pos_array)) {
                                            $pos = min($pos_array);
                                            $description = substr($excerpt, 0, $pos);
                                            $feature_list = substr($excerpt, $pos);
                                            $description = wordwrap($description, 65);
                                            $description = explode("\n", $description);
                                            $description = $description[0] . '...';
                                            $excerpt = $description . ' <span class="more-description">More</span> ' . $feature_list;
                                        }

                                        echo $excerpt;
                                        ?>
                                    </div>
                                    <?php } ?>
                                    <div class="avia_cart_buttons single_button">
                                        <span class="wc-price">
                                            <span class="starting-price">from</span>
                                            <?php
                                            if ('gift-card' == $mm_product->get_type()) {
                                                $amounts = $mm_product->get_amounts_to_be_shown();
                                                foreach ($amounts as $value => $item) {
                                                    echo wc_price($item['price']);
                                                    break;
                                                }
                                            } else
                                                echo wc_price($mm_product->get_price());
                                            ?>
                                        </span>
                                        <button data-quantity="1"  data-product_sku="" class="button product_type_booking add_to_cart_button">BOOK NOW</button>
                                    </div>
                                </a>
                                <?php 
                                if ( shortcode_exists('yith_wcwl_add_to_wishlist') ) {
                                    echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $mm_product_id . '"]'); 
                                }?>
                            </li>
                        <?php
                        $i +=1;
                        endwhile; ?>
                        </ul>
                    </div>
                </div>
                <?php
                wp_reset_postdata();
                $out_filter = '<div class="mm_filter_product_element">';
                $output = $out_filter . ob_get_clean() . '</div>';
                return $output;
            }
        }

        return 'There are no recently viewed products.';
    }
    add_shortcode('ht_recently_viewed', 'ht_recently_viewed_shortcode');
}
//shortcode share_product
if (!function_exists('ht_custom_share_product_shortcode')) {

    add_shortcode('ht_custom_share_product', 'ht_custom_share_product_shortcode');

    function ht_custom_share_product_shortcode($atts) {
        $output = '';
        if(!empty($atts)){
            if (!empty($atts['product_id'])) {
                global $avia_config, $avia_pages, $avia_elements;
                $social_share_array = $avia_config['social_share_array'];
                $product_id = $atts['product_id'];
                $output .= '<div class="ht-share-product">';
                $output .= '<div class="ht-custom-share"><span class="shareIcon__1aBl"><svg width="24" height="24" viewBox="0 0 24 22" xmlns="http://www.w3.org/2000/svg" class="icon__3A1i" fill="#000"><path d="M6.22 7.22a.75.75 0 001.06 1.06L11 4.56v11.69a.75.75 0 001.5 0V4.56l3.72 3.72a.75.75 0 101.06-1.06l-5-5a.75.75 0 00-1.06 0l-5 5z"></path><path d="M6.25 22A3.25 3.25 0 013 18.75v-7a.75.75 0 011.5 0v7c0 .97.78 1.75 1.75 1.75h11c.97 0 1.75-.78 1.75-1.75v-7a.75.75 0 011.5 0v7c0 1.8-1.46 3.25-3.25 3.25h-11z"></path></svg></span><span class="shareText__1FAK"></span></div>';
                $output .= '<div class="ht-dropdown-share-product">';
                $output .= '<svg class="arrowShadowBottom__Sszp" width="17" height="17" preserveAspectRatio="xMaxYMax" viewBox="0 0 17 8"><path fill="white" stroke-width="0" stroke="black" d="M 0 8 H 15.999999999999998 C 8.999999999999998 1 7.999999999999999 0 7.999999999999999 0 C 7.999999999999999 0 6.999999999999999 1 0 8"></path><path fill="white" d="M 0 8 H 15.999999999999998 L 15.999999999999998 8 H 0 Z"></path></svg>';
                $output .= '<ul class="items-dropdown-share">';
                foreach( $social_share_array as $name => $id ){
                    $shop_social_share = avia_get_option( 'shop_share_' . $id );
                    if($shop_social_share != 'disabled' && !empty($shop_social_share)){
                        $link_share = '';
                        switch($id){
                            case 'copylink' :
                                $link_share = '<a rel="nofollow" href="#" class="ht-copy-link link-share-custom" data-copy-text="' . get_permalink( $product_id ) . '"><i class="fa fa-clone"></i>' . $name .'</a>';
                                break;
                            case 'email' :
                                $link_share = '<a rel="nofollow" href="' . "mailto:?body=I found this on Hawaiitours and thought you'd love it: " . get_the_title( $product_id ) . "%0D%0A%0D%0ACheck it out - " . get_permalink( $product_id ) . "&subject=Check out this Experience on Hawaiitours!" . '" class="link-share-custom"><i class="fa fa-envelope-o"></i>' . $name .'</a>';
                                break;
                            case 'facebook' :
                                $link_share = '<a rel="nofollow" href="https://www.facebook.com/sharer.php?u=' . get_permalink( $product_id ) . '" class="link-share-custom" target="_blank"><i class="fa fa-facebook-square"></i>' . $name .'</a>';
                                break;
                            case 'twitter' :
                                $link_share = '<a rel="nofollow" href="http://www.twitter.com/share?url=' . get_permalink( $product_id ) . '" class="link-share-custom" target="_blank"><i class="fa fa-twitter-square"></i>' . $name .'</a>';
                                break;
                            case 'pinterest' :
                                $link_share = '<a rel="nofollow" href="http://pinterest.com/pin/create/link/?url=' . get_permalink( $product_id ) . '" class="link-share-custom" target="_blank"><i class="fa fa-pinterest-square"></i>' . $name .'</a>';
                                break;
                            default:
                                $link_share = '<a href="' . get_permalink( $product_id ) . '" class="link-share-custom">' . $name .'</a>';
                        }
                        $output .= '<li class="item-share">' . $link_share . '</li>';
                    }
                }
                $output .= '</ul>';
                $output .= '</div>';
                $output .= '</div>';
                
            }
        }
        
        return $output;
    }

}


//shortcode result description
if (!function_exists('mm_product_result_description_shortcode')) {
    
    add_shortcode('mm_product_result_description_shortcode', 'mm_product_result_description_shortcode');

    function mm_product_result_description_shortcode($atts) {
        $output = '';
        if(!empty($atts)){
            if (!empty($atts['product_id'])) {
                $product_id = $atts['product_id'];
                $output_description = '';
                // Get CATEGORY
                $primary_product_cat = get_post_meta( $product_id, '_yoast_wpseo_primary_product_cat', true );
                if($primary_product_cat){
                    $product_cat = get_term( $primary_product_cat, 'product_cat' );
                    $output_description .= $product_cat->name;
                   
                }else{
                    $mm_categories_product = wp_get_post_terms($product_id, 'product_cat');
                    $output_description .= $mm_categories_product[0]->name;
                }

                // Get DURATION
                $mm_duration = '';
                $mm_duration_unit = '';
                if (class_exists('WC_Product_Booking')) {
                    $bookable_product = new WC_Product_Booking($product_id);
                    $product_resources  = $bookable_product->get_resource_ids( 'edit' );
                    if($product_resources){
                        foreach ( $product_resources as $resource_id ) {
                            $mm_duration = get_post_meta($resource_id, '_mm_resource_duration', true);
                            if($mm_duration){
                                $mm_duration_unit = get_post_meta($resource_id, '_mm_resource_duration_unit', true);
                                break;
                            }
                        }
                    }
                    if(empty($mm_duration)){
                        $mm_duration = get_post_meta($product_id, '_mm_duration', true);
                        if($mm_duration){
                            $mm_duration_unit = get_post_meta($product_id, '_mm_duration_unit', true);
                            $output_description .= ' - ' . $mm_duration . ' ' . $mm_duration_unit;
                        }
                    }else{
                        $output_description .= ' - ' . $mm_duration . ' ' . $mm_duration_unit;
                    }
                }
                
                // Get PICKUP AVAILABLE
                $mm_pickup = get_post_meta($product_id, '_mm_pickup', true);
                if($mm_pickup){
                    if (trim(strtolower($mm_pickup)) == 'pickup available' || trim(strtolower($mm_pickup)) == 'pickup semi-avail') {
                        $mm_pickup = 'pickup';
                    }
                    $output_description .= ' - ' . $mm_pickup;
                }
                echo strtoupper( $output_description );
                
            }
        }
        
        return $output;
    }

}


//shortcode result description mm filtering
if (!function_exists('mm_filtering_product_result_description_shortcode')) {
    
    add_shortcode('mm_filtering_product_result_description_shortcode', 'mm_filtering_product_result_description_shortcode');

    function mm_filtering_product_result_description_shortcode($atts) {
        $output = '';
        if(!empty($atts)){
            if (!empty($atts['product_id'])) {
                $product_id = $atts['product_id'];
                $output_description = '';
                // Get CATEGORY
                $primary_product_cat = get_post_meta( $product_id, '_yoast_wpseo_primary_product_cat', true );
                if($primary_product_cat){
                    $product_cat = get_term( $primary_product_cat, 'product_cat' );
                    $output_description .= '<div class="mm-tags">'.$product_cat->name.'</div>';
                   
                }else{
                    $mm_categories_product = wp_get_post_terms($product_id, 'product_cat');
                    $output_description .= '<div class="mm-tags">'.$mm_categories_product[0]->name.'</div>';
                }

                // Get DURATION
                $mm_duration = '';
                $mm_duration_unit = '';
                if (class_exists('WC_Product_Booking')) {
                    $bookable_product = new WC_Product_Booking($product_id);
                    $product_resources  = $bookable_product->get_resource_ids( 'edit' );
                    if($product_resources){
                        foreach ( $product_resources as $resource_id ) {
                            $mm_duration = get_post_meta($resource_id, '_mm_resource_duration', true);
                            if($mm_duration){
                                $mm_duration_unit = get_post_meta($resource_id, '_mm_resource_duration_unit', true);
                                break;
                            }
                        }
                    }
                    if(empty($mm_duration)){
                        $mm_duration = get_post_meta($product_id, '_mm_duration', true);
                        if($mm_duration){
                            $mm_duration_unit = get_post_meta($product_id, '_mm_duration_unit', true);
                            if (!empty($mm_duration_unit)) {
                                $mm_duration_unit = $mm_duration_unit.'s';
                            }
                            $output_description .= '<div class="mm-duration">'.$mm_duration.' '.$mm_duration_unit.'</div>';
                        }
                    }else{
                        if (!empty($mm_duration_unit)) {
                            $mm_duration_unit = $mm_duration_unit.'s';
                        }
                        $output_description .= '<div class="mm-duration">'.$mm_duration.' '.$mm_duration_unit.'</div>';
                    }
                }
                
                // Get PICKUP AVAILABLE
                // $mm_pickup = get_post_meta($product_id, '_mm_pickup', true);
                // if($mm_pickup){
                //     if (trim(strtolower($mm_pickup)) == 'pickup available' || trim(strtolower($mm_pickup)) == 'pickup semi-avail') {
                //         $mm_pickup = 'pickup';
                //     }
                //     $output_description .= '<div class="mm-pickup">'.$mm_pickup.'</div>';
                // }
                echo $output_description;
                
            }
        }
        
        return $output;
    }

}

// mm_disalbe_coupon_not_sale_agents
if (!function_exists('mm_disalbe_coupon_not_sale_agents')) {
    //add_action('init', 'mm_disalbe_coupon_not_sale_agents');
    function mm_disalbe_coupon_not_sale_agents () {
        if (!is_admin() && !current_user_can('shop_manager')) {
            add_filter('woocommerce_coupons_enabled', false);
        }
    }
}

if(!function_exists("mm_custom_terms_checkbox_text")){
    add_filter( 'woocommerce_get_terms_and_conditions_checkbox_text', 'mm_custom_terms_checkbox_text' );

    function mm_custom_terms_checkbox_text( $text ) {
        $text = 'I have read and <a href="/about-us/refund-policy/" target="_blank">agree</a> to the website terms and conditions <abbr class="required" title="required">*</abbr>'; // Replace this text with your custom text

        return $text;
    }
}

function av_breadcrumbs_shortcode( $atts ) {
    $breadcrumbs = Avia_Breadcrumb_Trail()->get_trail( array(
        'separator'   => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
        'richsnippet' => true
    ) );
    $custom_home_text = 'Hawaii Tours';
    return str_replace('Home', $custom_home_text, $breadcrumbs);
}
add_shortcode( 'mm_breadcrumbs_page', 'av_breadcrumbs_shortcode' );

add_filter( 'body_class', 'mm_add_vp_tour_class_body_class' );
if(!function_exists('mm_add_vp_tour_class_body_class')){
    function mm_add_vp_tour_class_body_class( $classes ) {
        global $post;
        if (is_object_in_term($post->ID, 'product_tag', 'Package') || is_object_in_term($post->ID, 'product_tag', 'Packages')) {
            $classes[] = 'mm_vp_tour';
        }
        return $classes;
    }
}

if(!function_exists("update_bookable_resource_qty_after_save")){
    function update_bookable_resource_qty_after_save($post_id) {
        if (get_post_type($post_id) === 'bookable_resource') {
            update_post_meta($post_id, 'qty', '10000000');
        }
    }

    add_action('save_post', 'update_bookable_resource_qty_after_save', 11);
    add_action('edit_post', 'update_bookable_resource_qty_after_save', 11);
}
if(!function_exists("mm_facebook_for_woocommerce_integration_prepare_product")){
    function mm_facebook_for_woocommerce_integration_prepare_product($product_data, $id) {
        $product_data['quantity_to_sell_on_facebook'] = 10000;
        return $product_data;
    }

    add_filter('facebook_for_woocommerce_integration_prepare_product', 'mm_facebook_for_woocommerce_integration_prepare_product', 10, 2);
}
if(!function_exists("mm_facebook_woocommerce_pixel_init")){
    function mm_facebook_woocommerce_pixel_init($js_code) {
        return '';
    }

    add_filter('facebook_woocommerce_pixel_init', 'mm_facebook_woocommerce_pixel_init');
}

//shortcode social bookmarks
if (!function_exists('mm_social_bookmarks_shortcode')) {
    function mm_social_bookmarks_shortcode() {
        $social_args = array('outside'=>'ul', 'inside'=>'li', 'append' => '');
        $social	= avia_social_media_icons($social_args, false);
        return $social;
    }
    add_shortcode('mm-social-bookmarks', 'mm_social_bookmarks_shortcode');
}

// Add custom column to the custom post type admin
function mm_custom_post_type_columns($columns) {
    // Add the column after the title column
    $columns['seo_column__yoast_meta-robots-noindex'] = 'Index';

    return $columns;
}
add_filter('manage_cruise_posts_columns', 'mm_custom_post_type_columns');
add_filter('manage_hotel_posts_columns', 'mm_custom_post_type_columns');
add_filter('manage_restaurant_posts_columns', 'mm_custom_post_type_columns');

// Make the custom column sortable
function mm_custom_post_type_sortable_columns($columns) {
    $columns['seo_column__yoast_meta-robots-noindex'] = 'seo_column__yoast_meta-robots-noindex';

    return $columns;
}
// Make the column sortable for each of your custom post types
add_filter('manage_edit-cruise_sortable_columns', 'mm_custom_post_type_sortable_columns');
add_filter('manage_edit-hotel_sortable_columns', 'mm_custom_post_type_sortable_columns');
add_filter('manage_edit-restaurant_sortable_columns', 'mm_custom_post_type_sortable_columns');

// Make the custom column available in the Screen Options
function mm_custom_post_type_columns_screen_options($args) {
    $args['seo_column__yoast_meta-robots-noindex'] = 'Index';

    return $args;
}
add_filter('manage_edit-cruise_columns', 'mm_custom_post_type_columns_screen_options');
add_filter('manage_edit-hotel_columns', 'mm_custom_post_type_columns_screen_options');
add_filter('manage_edit-restaurant_columns', 'mm_custom_post_type_columns_screen_options');

// Disable New User Notification Email to Admin - Minh
add_filter('wp_new_user_notification_email_admin', '__return_false');

// Disable email password changed
add_filter( 'woocommerce_disable_password_change_notification', '__return_true' );

add_action('wp_dashboard_setup', 'mm_remove_wpseo_dashboard_overview' );
function mm_remove_wpseo_dashboard_overview() {
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
    remove_meta_box('wpseo-wincher-dashboard-overview', 'dashboard', 'normal');
}

//Remove link pagination
add_filter( 'wpseo_next_rel_link', '__return_false' );
add_filter( 'wpseo_prev_rel_link', '__return_false' );

if (!function_exists('mm_search_action_redirect_page404')) {
    function mm_search_action_redirect_page404() {
        $url      = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if((strpos($url, '/search/page_action/') !== false)){
            wp_redirect(home_url("404-error")); 
            exit;
        }
    }
}
add_action('wp', 'mm_search_action_redirect_page404', 1);
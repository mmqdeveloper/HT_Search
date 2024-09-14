<?php

if (!function_exists('mmt_admin_enqueue')) {

    function mmt_admin_enqueue() {
        wp_enqueue_style('mmt_admin_css', get_stylesheet_directory_uri() . '/module/assets/admin/css/module-admin.css', array(), '1.7.4', 'all');

        wp_enqueue_script('mmt_admin_repeater_js', get_stylesheet_directory_uri() . '/module/assets/admin/js/jquery.repeater.js', array('jquery'), '1.2.1', true);
        wp_enqueue_script('mmt_admin_js', get_stylesheet_directory_uri() . '/module/assets/admin/js/admin.js', array('jquery'), '1.2.5', true);
        wp_localize_script('mmt_admin_js', 'mmt_ajax_obj', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'site_url' => site_url()
        ));
    }

    add_action('admin_enqueue_scripts', 'mmt_admin_enqueue');
}

//Add js to admin
function mm_admin_enqueue_scripts() {
    $special_user = array("6", "9", "24", "41");
    $user = wp_get_current_user();
    if (!in_array($user->ID, $special_user)) {
        wp_enqueue_script('mm-admin-script', get_stylesheet_directory_uri() . '/assets/js/mm-admin-js.js', array('jquery'), '2.9', true);
    }
}

add_action('admin_enqueue_scripts', 'mm_admin_enqueue_scripts', 2000);

add_theme_support('avia_custom_shop_page');

add_filter('woocommerce_register_post_type_product', 'hw_modify_product_post_type');

function hw_modify_product_post_type($args) {
    $args['supports'][] = 'revisions';

    return $args;
}

function wc_custom_save_custom_fields($post_id) {
    global $post;

    if (!empty($_POST['_custom_layer_slider'])) {
        update_post_meta($post_id, '_custom_layer_slider', esc_attr($_POST['_custom_layer_slider']));
    }
}

add_action('woocommerce_process_product_meta', 'wc_custom_save_custom_fields');
add_action('avia_builder_mode', "builder_set_debug");

function builder_set_debug() {
    return "debug";
}

//Custom Backend Login

function mm_change_login_logo_image() {
    echo "
        <style>
        body.login #login h1 a {
        background: url('" . get_stylesheet_directory_uri() . "/assets/images/logo.png') 8px 0 no-repeat transparent;
        height:100px;
        width:320px; }
        </style>
";
}

add_action("login_head", "mm_change_login_logo_image");

function mm_login_logo_url() {
    return 'http://mauimarketing.com';
}

add_filter('login_headerurl', 'mm_login_logo_url');

//Enfold

function kriesi_backlink($frontpage_only = false) {
    $no = "";
    $theme_string = "";
    $random_number = get_option(THEMENAMECLEAN . "_fixed_random");
    if ($random_number % 3 == 0)
        $theme_string = THEMENAME . " Theme by Maui Marketing";
    if ($random_number % 3 == 1)
        $theme_string = THEMENAME . " WordPress Theme by Maui Marketing";
    if ($random_number % 3 == 2)
        $theme_string = "powered by " . THEMENAME . " Maui Marketing";
    if (!empty($frontpage_only) && !is_front_page())
        $no = "rel='nofollow'";

    $link = " - <a {$no} href='http://mauimarketing.com'>{$theme_string}</a>";

    $link = apply_filters("kriesi_backlink", $link);
    return $link;
}

//Change default logo
//Change default logo

add_filter('avf_logo', 'mm_avf_logo_filter', 10, 1);

function mm_avf_logo_filter($logo) {
    if (!avia_get_option('logo')) {
        return get_stylesheet_directory_uri() . '/assets/images/logo.png';
    } else {
        return $logo;
    }
}

if (!function_exists('media_avia_new_section')) {

    function media_avia_new_section($params = array()) {
        global $avia_section_markup, $avia_config;

        $defaults = array('class' => 'main_color',
            'bg' => '',
            'close' => true,
            'open' => true,
            'open_structure' => true,
            'open_color_wrap' => true,
            'data' => '',
            "style" => '',
            'id' => "",
            'main_container' => false,
            'min_height' => '',
            'min_height_px' => '',
            'video' => '',
            'video_ratio' => '16:9',
            'video_mobile_disabled' => '',
            'attach' => "",
            'before_new' => "",
            'custom_markup' => ''
        );

        $defaults = array_merge($defaults, $params);
        extract($defaults);

        $post_class = "";
        $output = "";
        $bg_slider = "";
        $container_style = "";
        if ($id)
            $id = "id='{$id}'";

        //close old content structure. only necessary when previous element was a section. other fullwidth elements dont need this
        if ($close) {
            $cm = avia_section_close_markup();
            $output .= "</div></div>{$cm}</div>" . avia_sc_section::$add_to_closing . avia_sc_section::$close_overlay . "</div>";
        }
        //start new
        if ($open) {
            if (function_exists('avia_get_the_id'))
                $post_class = "post-entry-" . avia_get_the_id();

            if ($open_color_wrap) {
                if (!empty($min_height)) {
                    $class .= " av-minimum-height av-minimum-height-" . $min_height;
                    if ($min_height == 'custom' && $min_height_px != "") {
                        $min_height_px = (int) $min_height_px;
                        $container_style = "style='height:{$min_height_px}px'";
                    }
                }

                if (!empty($video)) {
                    $slide = array(
                        'shortcode' => 'av_slideshow',
                        'content' => '',
                        'attr' => array('id' => '',
                            'video' => $video,
                            'slide_type' => 'video',
                            'video_mute' => true,
                            'video_loop' => true,
                            'video_ratio' => $video_ratio,
                            'video_controls' => 'disabled',
                            'video_section_bg' => true,
                            'video_format' => '',
                            'video_mobile' => '',
                            'video_mobile_disabled' => $video_mobile_disabled
                        )
                    );


                    $bg_slider = new avia_slideshow(array('content' => array($slide)));
                    $bg_slider->set_extra_class('av-section-video-bg');
                    $class .= " av-section-with-video-bg";
                    $class .= !empty($video_mobile_disabled) ? " av-section-mobile-video-disabled" : "";
                    $data .= "  data-section-video-ratio='{$video_ratio}'";
                }
                $output .= $before_new;

                if ($class == "main_color")
                    $class .= " av_default_container_wrap";

                $output .= "<div {$id} class='{$class} container_wrap " . avia_layout_class('main', false) . "' {$bg} {$data} {$style}>";
                $output .= !empty($bg_slider) ? $bg_slider->html() : "";
                $output .= $attach;
                $output .= apply_filters('avf_section_container_add', '', $defaults);
            }


            //this applies only for sections. other fullwidth elements dont need the container for centering
            if ($open_structure) {
                if (!empty($main_container)) {
                    $markup = 'main ' . avia_markup_helper(array('context' => 'content', 'echo' => false, 'custom_markup' => $custom_markup));
                    $avia_section_markup = 'main';
                } else {
                    $markup = "div";
                }

                $output .= "<div class='container' {$container_style}>";
                $output .= "<{$markup} class='template-page content  " . avia_layout_class('content', false) . " units'>";
                $output .= "<div class='post-entry post-entry-type-page {$post_class}'>";
                $output .= "<div class='entry-content-wrapper clearfix'>";
            }
        }
        return $output;
    }

}

add_filter('avf_portfolio_cpt_args', 'hma_avia_add_portfolio_revision', 10, 1);

function hma_avia_add_portfolio_revision($args) {
    $args['supports'] = array('title', 'thumbnail', 'excerpt', 'editor', 'comments', 'revisions');
    return $args;
}

/* Add Builder to Tours */
add_filter('avf_builder_boxes', 'mm_add_builder_to_cpt');

function mm_add_builder_to_cpt($boxes) {
    $boxes[] = array('title' => __('Avia Layout Builder', 'avia_framework'), 'id' => 'avia_builder', 'page' => array('tours', 'post', 'portfolio', 'page', 'product','hotel','restaurant', 'cruise'), 'context' => 'normal', 'expandable' => true);
    $boxes[] = array('title' => __('Layout', 'avia_framework'), 'id' => 'layout', 'page' => array('tours', 'portfolio', 'page', 'post','hotel','restaurant', 'cruise'), 'context' => 'side', 'priority' => 'low');
    $boxes[] = array('title' => __('Additional Portfolio Settings', 'avia_framework'), 'id' => 'preview', 'page' => array('tours'), 'context' => 'normal', 'priority' => 'high');

    return $boxes;
}

add_action('widgets_init', 'tours_booking_widgets_init_special');

function tours_booking_widgets_init_special() {
    register_sidebar(array(
        'name' => __('Info 22/07', 'mm-als'),
        'id' => 'info_special_day',
        'description' => __('Show information day special', 'mm-als'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}

/* phone number menu header */
add_action('widgets_init', 'menu_phone_number_widgets');

function menu_phone_number_widgets() {
    register_sidebar(array(
        'name' => __('Phone Number Menu', 'avia_framework'),
        'id' => 'phone_number_menu',
        'description' => __('Widgets add phone number in main menu.', 'avia_framework'),
        'before_widget' => '<div class="text-phone-number">',
        'after_widget' => '</div>',
            )
    );
}

add_filter('pre_get_posts', 'mm_postype_search_result');

function mm_postype_search_result($query) {

    if (!is_admin() && $query->is_search) {
        $query->set('post_type', array('post', 'page', 'product'));
    }

    return $query;
}

if (!function_exists('filter_product_edit_columns_email')) {

    function filter_product_edit_columns_email($columns) {
        $columns['mm_email'] = __('MM Email', 'mm');
        $columns['vendor'] = __('Vendor', 'mm');
        $columns['mm_cache'] = __('Clear Cache', 'mm');
        return $columns;
    }

    add_filter("manage_edit-product_columns", "filter_product_edit_columns_email");
}

if (!function_exists('filter_product_custom_columns_email')) {

    function filter_product_custom_columns_email($column, $post) {
        global $post;
        $id = (int) $post->ID;
        switch ($column) {

            case "mm_email":
                
                $ht_custom_content_tour_header = get_post_meta( $id, 'content_header_email_meta_box', true );
        $ht_custom_content_tour = get_post_meta( $id, 'content_email_meta_box', true );
                if(!empty($ht_custom_content_tour_header) || !empty($ht_custom_content_tour) ){
                    echo 'Yes';
                }
                break;
            case "vendor":
                $vendor_name = get_post_meta($id, 'mm_product_vendor', true);
                echo $vendor_name;
                break;
            case "mm_cache":
                $upload_dir = wp_upload_dir();
                $file_resource = $upload_dir['basedir'] . '/mm-bookingbox/' . $id.'_resource.json';
                $file_custom_bookingbox = $upload_dir['basedir'] . '/mm-bookingbox/' . $id.'_bookingbox_option_2.json';
                if (file_exists($file_resource) || file_exists($file_custom_bookingbox)) {
                    echo "<span data-post_id='".$id."' class='dashicons-before dashicons-update'>Clear Cache</span>";
                }
                break;
        }
    }

    add_action("manage_posts_custom_column", "filter_product_custom_columns_email", 10, 2);
}
add_action('admin_enqueue_scripts', 'mm_ds_admin_theme_style');
add_action('login_enqueue_scripts', 'mm_ds_admin_theme_style');

function mm_ds_admin_theme_style() {
    if (current_user_can( 'manage_options' )) {
        echo '<style>.update-nag, .updated,.wp-admin .fs-notice.updated, .error, .is-dismissible, .notice-error,
 #wp-admin-bar-avia,#wp-admin-bar-avia_ext,#wp-admin-bar-uap_dashboard_menu,#wp-admin-bar-uap_affiliates,#wp-admin-bar-uap_referrals,
 #wp-admin-bar-updraft_admin_node{ display: none !important; }</style>';
    }
    $show_product_data_option = false;
    $is_writer = false;
    if (is_user_logged_in()) {
        $user_ID = get_current_user_id();
        $user = new WP_User($user_ID);
        if (!empty($user->roles) && is_array($user->roles)) {
            foreach ($user->roles as $role){
                if ($role == 'developer' || $role == "administrator" || $role == "qa" || $role == "editor") {
                    $show_product_data_option = true;
                }
                if ($role == "editor"){
                    $is_writer = true;
                }
            }
        }
    }
    if(!$show_product_data_option){
         echo '<style>#screen-options-wrap label[for="woocommerce-product-data-hide"], #woocommerce-product-data{ display: none !important; }</style>';
    }
    if($is_writer){
         echo '<style>#woocommerce-product-data .postbox-header .product-data-wrapper , #woocommerce-product-data .product_data_tabs li:not(.bookings_resources_options), #woocommerce-product-data .panel-wrap .woocommerce_options_panel:not(#bookings_resources) { display: none !important; }</style>';
    }
}
if ( !function_exists( 'wp_password_change_notification' ) ) {
    function wp_password_change_notification() {}
}
add_image_size( 'mm-header-image-size', 1920, 500, true );
if(!function_exists('mm_add_custom_image_sizes')){
    
    function mm_add_custom_image_sizes( $size_names ) {
        $new_sizes = array(
            'mm-header-image-size' => __('Header image (1920x500)'),
        );
        return array_merge( $size_names, $new_sizes );
    }
    add_filter( 'image_size_names_choose', 'mm_add_custom_image_sizes');
}
if (!function_exists('mm_add_author_woocommerce')) {
    function mm_add_author_woocommerce() {
        add_post_type_support( 'product', 'author' );
    }
    add_action( 'after_setup_theme', 'mm_add_author_woocommerce' );
}

add_action('wp_ajax_mm_clear_cache_product', 'mm_clear_cache_product');
if(!function_exists('mm_clear_cache_product')){
    function mm_clear_cache_product() {
        $post_id = $_POST['postid'];
        $upload_dir = wp_upload_dir();
        $file_resource = $upload_dir['basedir'] . '/mm-bookingbox/' . $post_id.'_resource.json';
        unlink($file_resource);
        $file_person = $upload_dir['basedir'] . '/mm-bookingbox/' . $post_id.'_person.json';
        unlink($file_person);
        $file_custom_bookingbox = $upload_dir['basedir'] . '/mm-bookingbox/' . $post_id.'_bookingbox_option_2.json';
        unlink($file_custom_bookingbox);
    }
}

if(!function_exists('add_minimum_block_product_tag_columns')){
    function add_minimum_block_product_tag_columns( $columns ) {
        $columns['min_date'] = 'Minimum block';
        $columns['priority'] = 'Priority';
        return $columns;
    }
}
add_filter( 'manage_edit-product_tag_columns', 'add_minimum_block_product_tag_columns' );

if(!function_exists('add_minimum_block_product_tag_column_content')){
    function add_minimum_block_product_tag_column_content( $content, $column_name, $term_id ) {
        $min_date_tag = get_term_meta($term_id, 'tag_min_date', true);
        $min_date_tag_unit = get_term_meta($term_id, 'tag_min_date_unit', true);
        $min_date_priority = get_term_meta($term_id, 'tag_min_date_priority', true);
        
        switch ( $column_name ) {
            case 'min_date':
                $content = $min_date_tag.' '.$min_date_tag_unit;
                if(empty($min_date_tag) || $min_date_tag == 0){
                    $content = '---';
                }
                $content = '<div class="mm_tag_minimum_block" data-type="mm_tag_minimum_block" data-term_id="' . $term_id . '" data-min_date="' . $min_date_tag . '" data-min_date_unit="' . $min_date_tag_unit . '" data-min_date_priority="' . $min_date_priority . '"  >
                            <span class="mm_tag_min_date"><span>' . $content . '</span></span>
                        </div>';
                
                break;
            case 'priority':
                if(empty($min_date_tag)){
                    $min_date_priority = '';
                }
                $content = $min_date_priority;
                break;
            default:
                break;
        }

        return $content;
    }
}
add_filter( 'manage_product_tag_custom_column', 'add_minimum_block_product_tag_column_content', 10, 3 );

if(!function_exists('register_sortable_column_for_product_tag')){
    function register_sortable_column_for_product_tag($columns) {
        $columns['min_date'] = 'tag_min_date';
        $columns['priority'] = 'tag_min_date_priority';
        return $columns;
    }
}
add_filter('manage_edit-product_tag_sortable_columns', 'register_sortable_column_for_product_tag');

if(!function_exists('product_tag_sort_min_date_column')){
    function product_tag_sort_min_date_column($pieces, $taxonomies, $args) {
        global $pagenow, $wpdb;
        if(!is_admin()) {
            return $pieces;
        }
        if(is_admin() && $pagenow == 'edit-tags.php' && $taxonomies[0] == 'product_tag' && !isset($_GET['orderby']) ) {
            $pieces[ 'join' ] .= ' INNER JOIN ' . $wpdb->termmeta . ' AS tm ON t.term_id = tm.term_id ';
            $pieces[ 'orderby' ]  = ' ORDER BY tm.meta_value ';
            $pieces[ 'order' ]  = ' desc ';
            $pieces[ 'where' ] .= ' AND tm.meta_key = "tag_min_date"';
        }
        if(is_admin() && $pagenow == 'edit-tags.php' && $taxonomies[0] == 'product_tag' && (isset($_GET['orderby']) && $_GET['orderby'] == 'tag_min_date')) {
            $pieces[ 'join' ] .= ' INNER JOIN ' . $wpdb->termmeta . ' AS tm ON t.term_id = tm.term_id ';
            $pieces[ 'orderby' ]  = ' ORDER BY tm.meta_value ';
            $pieces[ 'where' ] .= ' AND tm.meta_key = "tag_min_date"';
        }
        if(is_admin() && $pagenow == 'edit-tags.php' && $taxonomies[0] == 'product_tag' && (isset($_GET['orderby']) && $_GET['orderby'] == 'tag_min_date_priority')) {
            $pieces[ 'join' ] .= ' INNER JOIN ' . $wpdb->termmeta . ' AS tm ON t.term_id = tm.term_id ';
            $pieces[ 'orderby' ]  = ' ORDER BY tm.meta_value ';
            $pieces[ 'where' ] .= ' AND tm.meta_key = "tag_min_date_priority"';
        }

        return $pieces;
    }
}
add_filter('terms_clauses', 'product_tag_sort_min_date_column', 10, 3);

add_action('wp_ajax_mm_save_tag_min_date', 'mm_save_tag_min_date');
if(!function_exists('mm_save_tag_min_date')){
    function mm_save_tag_min_date() {
        $term_id = $_POST['term_id'];
        $min_date = $_POST['min_date'];
        $min_date_unit = $_POST['min_date_unit'];
        $min_date_priority = $_POST['min_date_priority'];
        if(empty($min_date) || $min_date == 0){
            $min_date = '';
            $min_date_unit = '';
            $min_date_priority = '';
        }
        update_term_meta($term_id, 'tag_min_date', $min_date);
        update_term_meta($term_id, 'tag_min_date_unit', $min_date_unit);
        update_term_meta($term_id, 'tag_min_date_priority', $min_date_priority);
    }
}

/*add_action('save_post', 'mm_reset_cache_html_activities_sitemap', 10, 4);
if(!function_exists('mm_reset_cache_html_activities_sitemap')){
    function mm_reset_cache_html_activities_sitemap($post_id) {
        if (!isset($_POST['post_type'])) {
            return false;
        }
        if ($_POST['post_type'] != 'page') {
            return false;
        }
        if ($post_id == 32408){
            $upload_dir = wp_upload_dir();
            $file_resource = $upload_dir['basedir'] . '/mm-bookingbox/activities_page.json';
            unlink($file_resource);
        }
    }
}*/
if( isset( $_GET["action"]) && isset( $_GET["type"]) && $_GET["action"] == 'purge_cache' &&  $_GET["type"] == 'post-32408' ){
    $upload_dir = wp_upload_dir();
    $target_dir = $upload_dir['basedir'] . '/data_shortcode_sitemap/data_shortcode_sitemap.json';
    if (file_exists($target_dir)) {
        file_put_contents($target_dir, '');
    }
}
if(!function_exists('mm_register_mauimarketing_menu_page')){
    function mm_register_mauimarketing_menu_page() {
            add_menu_page(
                    __( 'Maui Marketing Menu', 'mm' ),
                    'Maui Marketing Menu',
                    'manage_options',
                    'maui-marketing-menu',
                    'mauimarketing_menu_page_callback',
                    get_stylesheet_directory_uri() . '/assets/images/Icon-mm.png',
                    10
            );
            add_submenu_page(
		'maui-marketing-menu',
		'Global Avaibility',
		'Global Avaibility',
		'manage_options',
		'edit.php?post_type=wc_booking&page=wc_bookings_global_availability', );
            // if(defined( 'YITH_YWGC_DIR' )){
                add_submenu_page(
                    'maui-marketing-menu',
                    'Gift Card',
                    'Gift Card',
                    'manage_options',
                    'edit.php?post_type=gift_card&yith-plugin-fw-panel-skip-redirect=1', );
            // }
            if(defined( 'UAP_PATH' )){
                add_submenu_page(
                    'maui-marketing-menu',
                    'MM Affiliates',
                    'MM Affiliates',
                    'manage_options',
                    'admin.php?page=ultimate_affiliates_pro&tab=affiliates', );
            }
            if ( defined( 'WCPFC_PLUGIN_DIR' ) ) {
                add_submenu_page(
                    'maui-marketing-menu',
                    'Product Fees',
                    'Product Fees',
                    'manage_options',
                    'admin.php?page=wcpfc-pro-list', );
            }
            add_submenu_page(
                    'maui-marketing-menu',
                    'Coupons',
                    'Coupons',
                    'manage_options',
                    'edit.php?post_type=shop_coupon', );
            add_submenu_page(
                    'maui-marketing-menu',
                    'Invoice',
                    'Invoice',
                    'manage_options',
                    'edit.php?post_type=sliced_invoice', );
            if ( defined( 'MM_CHANGE_AUTHOR_DIR' ) ) {
                add_submenu_page(
                    'maui-marketing-menu',
                    'MM Change Author',
                    'MM Change Author',
                    'manage_options',
                    'tools.php?page=mm_change_author_settings', );
            }
            if ( defined( 'FAQ_PLUGIN_URL' ) ) {
                add_submenu_page(
                    'maui-marketing-menu',
                    'MM FAQ Setting',
                    'MM FAQ Setting',
                    'manage_options',
                    'tools.php?page=mmfaq_settings', );
            }
            if ( defined( 'MM_FAREHARBOR_PLUGIN_DIR' ) ) {
                add_submenu_page(
                    'maui-marketing-menu',
                    'MM Fareharbor check available',
                    'MM Fareharbor check available',
                    'manage_options',
                    'tools.php?page=mmfareharbor_available_settings', );
            }
            if ( defined( 'MM_PONOREZ_PLUGIN_DIR' ) ) {
                add_submenu_page(
                    'maui-marketing-menu',
                    'MM Ponorez check available',
                    'MM Ponorez check available',
                    'manage_options',
                    'tools.php?page=mmponorez_available_settings', );
            }
            if ( defined( 'MM_AVAILABLE_VENDOR_PLUGIN_DIR' ) ) {
                add_submenu_page(
                    'maui-marketing-menu',
                    'MM Other Vendor check available',
                    'MM Other Vendor check available',
                    'manage_options',
                    'tools.php?page=mmvendor_available_settings', );
            }
            
    }
}
add_action( 'admin_menu', 'mm_register_mauimarketing_menu_page' );
if(!function_exists('mauimarketing_menu_page_callback')){
    function mauimarketing_menu_page_callback() { 
        ?>
        <div class="wrap">
            <h1><?php _e( 'Maui Marketing Menu', 'textdomain' ); ?></h1>
        </div>
        <?php
    }
}


/* ----------------------------------------------------------
 * ADD column Tour Date on order
 * ----------------------------------------------------------*/
if( !function_exists('mm_name_display_mm_tour_date') ){
    function mm_name_display_mm_tour_date($columns) {
        $columns['tour_date'] = 'Tour Date';
        return $columns;
    }
    add_filter('manage_shop_order_posts_columns', 'mm_name_display_mm_tour_date', 11);
}
if( !function_exists('mm_custom_shop_order_sortable_columns') ){
    add_filter('manage_edit-shop_order_sortable_columns', 'mm_custom_shop_order_sortable_columns');
    function mm_custom_shop_order_sortable_columns($sortable_columns) {
        $sortable_columns['tour_date'] = 'Tour Date';
        return $sortable_columns;
    }
}
if( !function_exists('mm_display_mm_tour_date') ){
    // Display contents of custom column
    function mm_display_mm_tour_date($column_name, $post_id) {
        if ($column_name === 'tour_date') {
            // Add your custom content here
            $order = wc_get_order( $post_id );
            if($order){
                $list_tour_date = array();
                foreach ($order->get_items() as $order_item_id => $item) {
                    $sumo_pp_payment_id = wc_get_order_item_meta($order_item_id, '_sumo_pp_payment_id', true);
                    $booking_ids = WC_Booking_Data_Store::get_booking_ids_from_order_item_id($order_item_id);
                    if(!empty($sumo_pp_payment_id)){
                        $parent_order_id = get_post_meta( $sumo_pp_payment_id,'_initial_payment_order_id', true);
                        $booking_ids  = WC_Booking_Data_Store::get_booking_ids_from_order_id( $parent_order_id );
                    }
                    if (!empty($booking_ids)) {
                        foreach ($booking_ids as $booking_id) {
                            $booking_mm = new WC_Booking($booking_id);
                            $tour_date= date("l, F d, Y", strtotime($booking_mm->get_start_date()));
                            if(!in_array($tour_date, $list_tour_date)){
                                $list_tour_date[] = $tour_date;
                            }
                        }
                    }
                    
                }
                echo implode('<br>', $list_tour_date);
            }
            
        }
    }
    add_action('manage_shop_order_posts_custom_column', 'mm_display_mm_tour_date', 15, 2);
}
if (!function_exists('mm_add_author_columns_list_invoice')) {

    function mm_add_author_columns_list_invoice($columns) {
        $columns['mm_author'] = __('Author', 'mm');
        return $columns;
    }

    add_filter("manage_edit-sliced_invoice_columns", "mm_add_author_columns_list_invoice");
    add_filter("manage_edit-sliced_quote_columns", "mm_add_author_columns_list_invoice");
}

if (!function_exists('mm_add_author_columns_list_invoice_detail')) {

    function mm_add_author_columns_list_invoice_detail($column, $post) {
        global $post;
        $id = (int) $post->ID;
        switch ($column) {

            case "mm_author":
                $author_id=$post->post_author;
                echo get_the_author_meta('display_name', $author_id);
                break;
            
        }
    }

    add_action("manage_sliced_invoice_posts_custom_column", "mm_add_author_columns_list_invoice_detail", 10, 2);
    add_action("manage_sliced_quote_posts_custom_column", "mm_add_author_columns_list_invoice_detail", 10, 2);
}

add_action( 'wp_ajax_mm_invoice_search_contact_hubspot', 'mm_invoice_search_contact_hubspot' );

if ( ! function_exists( 'mm_invoice_search_contact_hubspot' ) ) {
    
    function mm_invoice_search_contact_hubspot() {
        
        $data= array();
        $access_token = get_option( 'nf_hs_access_token' );
        $email = (isset($_POST['value']))? $_POST['value'] : '';
        $user = get_user_by('email', $email);
        if($user){
            $data['error'] = 'user existing';
            $data['user_id'] = $user->ID;
            $user_meta = get_user_meta ( $user->ID);
            $display_name = $user->display_name;
            $address = $user_meta['billing_address_1'][0].' '.$user_meta['billing_city'][0].' '.$user_meta['billing_postcode'][0];
            $data['company_name'] = $display_name;
            $data['address'] = $address;
            //update_user_meta( $user->ID, 'show_admin_bar_front', 'false' );
            update_user_meta( $user->ID, '_sliced_client_business', $display_name );
            if(!empty($address)){
                update_user_meta( $user->ID, '_sliced_client_address', $address );
            }
            wp_send_json_error($data);
        }else{
            $url_search = "https://api.hubapi.com/crm/v3/objects/contact/search";
            $data_search = '{
                "filterGroups": [
                    {
                        "filters": [
                            {
                                "propertyName": "email",
                                "operator": "EQ",
                                "value": "' . $email . '"
                            }
                        ]
                    }
                ]
            }';

            $curl_search = curl_init();
            curl_setopt_array($curl_search, array(
                CURLOPT_URL => $url_search,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data_search,
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "content-type: application/json",
                    "Authorization: Bearer " . $access_token,
                ),
            ));
            $response_search = json_decode(curl_exec($curl_search));
            $err_search = curl_error($curl_search);
            curl_close($curl_search);
            //print_r($response_search);
            if (!$err_search && $response_search->total >=1) {
                $response_data = $response_search->results;
                foreach ($response_data as $contact) {
                    $firstname = $contact->properties->firstname;
                    $lastname = $contact->properties->lastname;
                    $email = $contact->properties->email;
                    $data['firstname'] = $firstname;
                    $data['lastname'] = $lastname;
                }
            }
            wp_send_json_success( $data );
        }
        die();
    }
}
add_action( 'wp_ajax_mm_invoice_search_contact_for_user_id', 'mm_invoice_search_contact_for_user_id' );
if ( ! function_exists( 'mm_invoice_search_contact_for_user_id' ) ) {
    function mm_invoice_search_contact_for_user_id(){
        $data= array();
        $user_id = (isset($_POST['user_id']))? $_POST['user_id'] : '';
        if($user_id != ''){
            $user = get_user_by('id', $user_id);
            $user_meta = get_user_meta ( $user_id);
            $display_name = $user->display_name;
            $address = $user_meta['billing_address_1'][0].' '.$user_meta['billing_city'][0].' '.$user_meta['billing_postcode'][0];
            $data['company_name'] = $display_name;
            $data['address'] = $address;
        }
        wp_send_json_success( $data );
        die();
    }
}

if (!function_exists('mm_hide_columns_in_sliced_invoice')) {
    function mm_hide_columns_in_sliced_invoice($columns) {
        unset($columns['seo_column__h1']);
        unset($columns['seo_column__h2']);
        unset($columns['seo_column__h3']);
        unset($columns['seo_column__subs']);
        unset($columns['seo_column__bold']);
        unset($columns['seo_column__yoast_title']);
        unset($columns['seo_column__yoast_metadesc']);
        unset($columns['seo_column__yoast_focuskw']);
        unset($columns['seo_column__hero_image']);
        unset($columns['seo_column__yoast_meta-robots-noindex']);
        unset($columns['seo_column__yoast_meta-robots-nofollow']);
        unset($columns['wpseo-links']);
        unset($columns['wpseo-linked']);
        unset($columns['wpseo-cornerstone']);
        unset($columns['date']);
        return $columns;
    }
    add_filter('manage_sliced_invoice_posts_columns', 'mm_hide_columns_in_sliced_invoice', 99);
}

// add meta box footer vp for page
if (!function_exists('mm_add_custom_meta_box_footer_vp')) {
    function mm_add_custom_meta_box_footer_vp() {
        add_meta_box(
            'mm_footer_vp',
            'Footer VP',
            'mm_render_meta_box_footer_vp',
            array(
                'page',
                'product',
            ),
            'side',
            'default'
        );
    }
}

if (!function_exists('mm_render_meta_box_footer_vp')) {
    function mm_render_meta_box_footer_vp($post) {
        $mm_footer_vp = get_post_meta($post->ID, 'mm_footer_vp', true);
        ?>
        <select class="avia-style" name="mm_footer_vp" data-initial="header_transparent">
            <option value="no" <?php echo($mm_footer_vp != 'yes' ? 'selected' : ''); ?>>No</option>
            <option value="yes" <?php echo($mm_footer_vp == 'yes' ? 'selected' : ''); ?>>Yes</option>
        </select>
        <?php
    }
}

if (!function_exists('mm_save_meta_box_footer_vp')) {
    function mm_save_meta_box_footer_vp($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_page', $post_id)) {
            return;
        }

        if (isset($_POST['mm_footer_vp'])) {
            update_post_meta($post_id, 'mm_footer_vp', sanitize_text_field($_POST['mm_footer_vp']));
        }
    }
}

add_action('add_meta_boxes', 'mm_add_custom_meta_box_footer_vp', 1);
add_action('save_post', 'mm_save_meta_box_footer_vp');
add_action('edit_form_advanced', 'mm_add_vendor_meta_to_invoice');
if (!function_exists('mm_add_vendor_meta_to_invoice')) {
    function mm_add_vendor_meta_to_invoice() {
        global $post;
        $post_id = $post->ID;
        $screen = get_current_screen();
        if ($screen->post_type == 'sliced_invoice') {
            $mm_sliced_invoice_vendor = get_post_meta($post_id, 'mm_sliced_invoice_vendor', true);
            ?>
            <div class="mm_metabox_sliced_invoice postbox cmb2-postbox">
                <div class="inside" >
                    <div class="label" style="color: #222;font-weight: bold;">Vendor</div>
                    <input type="text" name="mm_sliced_invoice_vendor" value="<?php echo $mm_sliced_invoice_vendor; ?>" style="width: 100%;margin-top: 5px;"/>
                </div>
            </div>
            <?php
        }
    }
}
add_action('save_post', 'mm_add_vendor_meta_invoice_save');
if (!function_exists('mm_add_vendor_meta_invoice_save')) {

    function mm_add_vendor_meta_invoice_save($post_id) {
        //Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
        if (isset($_POST['mm_sliced_invoice_vendor'])) {
            update_post_meta($post_id, 'mm_sliced_invoice_vendor', $_POST['mm_sliced_invoice_vendor']);
        }
    }
}

// hide column Yoast SEO except product
if (!function_exists('mm_hide_column_yoast_seo_admin_list')) {
    function mm_hide_column_yoast_seo_admin_list($columns) {
        $columns_hide = array(
            'seo_column__h1',
            'seo_column__h2',
            'seo_column__h3',
            'seo_column__subs',
            'seo_column__bold',
            'seo_column__yoast_title',
            'seo_column__yoast_metadesc',
            'seo_column__yoast_focuskw',
            'seo_column__yoast_meta-robots-noindex',
            'seo_column__yoast_meta-robots-nofollow',
            'seo_column__yoast_meta-robots-nofollow',
            'wpseo-score',
            'wpseo-score-readability',
            'wpseo-cornerstone',
        );

        foreach($columns_hide as $column_hide) {
            if (isset($columns[$column_hide])) {
                unset($columns[$column_hide]);
            }
        }

        return $columns;
    }

    add_action('admin_init', function () {
        $post_types = get_post_types(['public' => true], 'names', 'and');
        foreach ($post_types as $post_type) {
            if ($post_type == 'product') {
                continue;
            }
            add_filter("manage_{$post_type}_posts_columns", 'mm_hide_column_yoast_seo_admin_list', 99, 1);
        }
    });
}

// Custom Column Count In Table Category Product
if (!function_exists('mm_add_column_count_custom')) {
    add_filter('manage_edit-product_cat_columns', 'mm_add_column_count_custom');
    function mm_add_column_count_custom($columns) {
        $columns['mm_cat_count_product'] = 'Count';
        return $columns;
    }
}

if (!function_exists('mm_cat_count_product_sortable')) {
    add_filter('manage_edit-product_cat_sortable_columns', 'mm_cat_count_product_sortable');
    function mm_cat_count_product_sortable($columns) {
        $columns['mm_cat_count_product'] = 'mm_cat_count_product';
        return $columns;
    }
}

if (!function_exists('mm_product_cat_sort_by_product_count')) {
    add_action('pre_get_terms', 'mm_product_cat_sort_by_product_count');
    function mm_product_cat_sort_by_product_count($query) {
        global $pagenow;
        if (is_admin() && $pagenow == 'edit-tags.php' && isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'product_cat' && isset($_GET['orderby']) && $_GET['orderby'] == 'mm_cat_count_product') {
            $query->query_vars['orderby'] = 'count'; 
        }
    }
}

if (!function_exists('mm_custom_hide_count_default_column')) {
    add_filter('manage_edit-product_cat_columns', 'mm_custom_hide_count_default_column', 10, 1);
    function mm_custom_hide_count_default_column($columns) {
        unset($columns['posts']);
        return $columns;
    }  
}

if (!function_exists('mm_column_count_custom_content')) {
    add_action( 'manage_product_cat_custom_column' , 'mm_column_count_custom_content', 10, 3 );
    function mm_column_count_custom_content( $content, $column_name, $term_id ) {
        if ( 'mm_cat_count_product' === $column_name ) {
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                ),
            );

            $products = new WP_Query( $args );

            $count = $products->found_posts;

            $cat = get_term_by('id', $term_id, 'product_cat');
            $cat_slug = $cat->slug;

            $count_html = "<a style='text-align:center;' href='edit.php?product_cat={$cat_slug}&post_type=product'>{$count}</a>";

            wp_reset_postdata();

            echo $count_html;
        }
    }
}
// End Custom Column Count In Table Category Product
<?php
/**
 * Core functions
 * 
 */

namespace MauiMarketing\MMTF\Core;

use MauiMarketing\MMTF\Logs;

/**
 * Sets up the database tables on plugin activation
 * 
 * Creates table `daily_product_availability`
 * 
 * @global   $wpdb - WordPress database access abstraction class
 * 
 * @uses     \MauiMarketing\MMTF\PLUGIN_FILE PLUGIN_FILE
 * 
 * @see      https://developer.wordpress.org/reference/functions/dbdelta/                   Codex, function: dbDelta()
 * @see      https://developer.wordpress.org/reference/functions/register_activation_hook/  Codex, function: register_activation_hook()
 * 
 * @return   void
 */
function on_activation_of_the_plugin(){
    
    // Logs\debug_log( "", "core-register_activation_hook-on_activation_of_the_plugin" );
    
    global $wpdb;
    
    $wpdb_collate = $wpdb->get_charset_collate();
    $table_name   = $wpdb->prefix . 'daily_product_availability';
    
    if ( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
        
        $query = "
            CREATE TABLE $table_name (
                date DATE NOT NULL,
                product_id BIGINT(20) UNSIGNED NOT NULL,
                min_date SMALLINT UNSIGNED NOT NULL,
                PRIMARY KEY  ( date, product_id ),
                KEY product_id (product_id)
            )
            $wpdb_collate
        ";
        
    }
    
    if( ! empty( $query ) ){
        
        // Logs\debug_log( $query, "on_activation_of_the_plugin-query" );
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        dbDelta( $query );
    }

}
register_activation_hook( \MauiMarketing\MMTF\PLUGIN_FILE, __NAMESPACE__ . '\\' . 'on_activation_of_the_plugin' );

function on_deactivation_of_the_plugin(){
    
    // Logs\debug_log( "", "core-register_deactivation_hook-on_deactivation_of_the_plugin" );
    
    global $wpdb;
    
    $table_name   = $wpdb->prefix . 'daily_product_availability';
    
    $query = "
        DROP TABLE IF EXISTS $table_name
    ";
    
    $wpdb->query( $query );

}
register_deactivation_hook( \MauiMarketing\MMTF\PLUGIN_FILE, __NAMESPACE__ . '\\' . 'on_deactivation_of_the_plugin' );

function after_activation_redirect( $plugin ) {
    
    // Logs\debug_log( $plugin, "core-activated_plugin-after_activation_redirect, constant: " . \MauiMarketing\MMTF\PLUGIN_ID );
    
    if( $plugin == \MauiMarketing\MMTF\PLUGIN_ID ) {
        
        // Logs\debug_log( "plugin == \MauiMarketing\MMTF\PLUGIN_ID", "core-activated_plugin-after_activation_redirect" );
        
        if( wp_redirect( admin_url( 'edit.php?post_type=product&page=mmtf_options_availability' ) ) ){
            
            exit;
        }
    }
}
add_action( 'activated_plugin', __NAMESPACE__ . '\\' . 'after_activation_redirect' );


/**
 * Returns the Config singleton instance
 * 
 * @uses     \MauiMarketing\MMTF\Core\Config Class: Core\Config
 * 
 * @return   array
 */
function config(){
    
    return Config::get_instance()->get_config();
}
/**
 * Updates and saves a value
 * 
 * @uses     \MauiMarketing\MMTF\Core\Config Class: Core\Config
 * 
 * @return   array
 */
function update_config( $key, $value ){
    
    return Config::get_instance()->update_ini( $key, $value );
}

function get_global_availability(){
    
    return Config::get_instance()->get_global_availability();
}

/**
 * Loads scripts and styles
 * 
 * @uses     \MauiMarketing\MMTF\Core\enqueue_JS()                                  Core\enqueue_JS()
 * @uses     \MauiMarketing\MMTF\Core\enqueue_CSS()                                 Core\enqueue_CSS()
 * 
 * @see      https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/             Codex, action: admin_enqueue_scripts
 * 
 * @global   $post    - (WP_Post) The post object for the current post
 * @global   $pagenow - (string) File name of the current WordPress admin screen
 * @global   $typenow - (string) Current post type
 * @global   $taxnow  - (string) Current taxonomy slug
 * 
 * @return   void
 */
function load_admin_scripts( $hook ){
    
    // global $post, $pagenow, $typenow, $taxnow;
    
    $screen = get_current_screen();
    
    // Logs\debug_log( $screen, "load_admin_scripts-debug_screen" );
    // Logs\debug_log( $hook, "load_admin_scripts-hook" );
    
    $mm_object = [
        'admin_url' => admin_url(),
        'ajax_url'  => admin_url('admin-ajax.php'),
    ];
    
    
    
    // options: Settings page
    if ( $hook === 'product_page_mmtf_options_availability' ) {
        
		enqueue_CSS( 'mmtf-recalculate-style',  'css/recalculate.css' );
		enqueue_JS(  'mmtf-recalculate-script', 'js/recalculate.js'   );
        
		wp_localize_script('mmtf-recalculate-script', 'mm_object', $mm_object );
        
	}
    
    // editing: ACF Field Group
    if ( $screen->post_type === 'acf-field-group' && $screen->base === 'post' ) {
        
		enqueue_CSS( 'mmtf-acf-extended',  'css/acf-edit.css' );
	}
    
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\' . 'load_admin_scripts' );
    
    
function load_frontend_scripts(){
    
    global $post;
    
    // include required assets for the shortcode mm_quick_search
    #if( has_shortcode( $post->post_content, 'mm_quick_search' ) ){
    // if( is_page() && has_shortcode( $post->post_content, 'mm_quick_search' ) ){
        
        // Logs\debug_log( "Has shortcode: mm_quick_search!", "load_admin_scripts-is_page-has_shortcode-post_id: " . $post->ID );
        
    enqueue_CSS( 'mmqs-style',  'css/mmqs.css' );
    enqueue_CSS( 'mmqs-range',  'css/datepicker_range.css' );
    enqueue_CSS( 'mm-filter-search-style',  'css/filter_search_style.css' );
    
    wp_enqueue_script('jquery-ui-datepicker');
    
    enqueue_JS(  'mmqs-range', 'js/datepicker_range.js', [ 'jquery', 'jquery-ui-datepicker' ]   );
    enqueue_JS(  'mmqs-script', 'js/mmqs.js', [ 'mmqs-range' ]   );
    
    $search_page = get_page_by_path( config()["search_page_slug"] );
    
    $mm_object = [
        'admin_url'         => admin_url(),
        'ajax_url'          => admin_url('admin-ajax.php'),
        'search_page_url'   => get_the_permalink( $search_page ),
    ];
    
    wp_localize_script('mmqs-script', 'mm_object', $mm_object );

    // if(!is_front_page() && !is_home() && !is_checkout() && !is_cart()) {
    if(!is_checkout() && !is_cart()) {
        enqueue_JS(  'mm-filter-search-js', 'js/filter_search.js', [ 'jquery', 'jquery-ui-datepicker' ]   );
        wp_localize_script('mm-filter-search-js', 'ajaxurl_mm_search_mobile_header', admin_url('admin-ajax.php'));
    }
  
    #}
    
    if( (is_page() && is_page_template( 'mmtf.php' ) ) || has_shortcode( $post->post_content, 'mm_tour_search') || has_shortcode( $post->post_content, 'av_mm_tour_search')){
        
        // Logs\debug_log( "Is template: mmtf!", "load_admin_scripts-is_page-is_page_template-post_id: " . $post->ID );
        
        wp_enqueue_style( 'dashicons' );
        
        wp_dequeue_style('uap_jquery-ui.min.css');
        wp_dequeue_style('jquery-ui-style');
        
		enqueue_CSS( 'mmtf-style',  'css/mmtf.css' );
		enqueue_CSS( 'mmtf-range',  'css/datepicker_range.css' );
        
        
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-slider');
        
		// enqueue_JS(  'mmtf-range', 'js/datepicker_range.js', [ 'jquery', 'jquery-ui-datepicker', 'jquery-ui-slider' ]   );
		// enqueue_JS(  'mmtf-script', 'js/mmtf.js', [ 'mmtf-range' ]   );
		enqueue_JS(  'mmtf-script', 'js/mmtf.js', []   );
        

        $mm_object = [
            'admin_url'         => admin_url(),
            'ajax_url'          => admin_url('admin-ajax.php'),
        ];
        
		wp_localize_script('mmtf-script', 'mm_object', $mm_object );
        
    }
    
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\' . 'load_frontend_scripts', 999 );

// https://developer.wordpress.org/reference/hooks/theme_page_templates/
function include_templates( $page_templates, $theme, $post ){
    
    // Logs\debug_log( $page_templates, "include_templates-page_templates" );
    
    $page_templates['mmtf.php'] = 'MM Filtering Page';
    
	return $page_templates;
}
add_filter( 'theme_page_templates', __NAMESPACE__ . '\\' . 'include_templates', 20, 3 );

// https://developer.wordpress.org/reference/hooks/type_template/
function locate_templates( $template ){
    
    $template_slug = get_page_template_slug();
    
    // Logs\debug_log( $template_slug, "locate_templates-template_slug: ");
    
    if( $template_slug === 'mmtf.php' ){
        
        $template = \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/mmtf.php';
    }
    
	return $template;
}
add_filter( 'template_include', __NAMESPACE__ . '\\' . 'locate_templates', 20, 1 );

/**
 * Removes unnecessary items from the wp-admin sidebar menu
 * 
 * @see      https://developer.wordpress.org/reference/hooks/admin_menu/  Codex, action: admin_menu
 * 
 * @return   void
 */
function remove_sidebar_menu_items(){
    
    // remove_menu_page( 'index.php' );                  // Dashboard
    // remove_menu_page( 'edit.php' );                   // Posts
    // remove_menu_page( 'upload.php' );                 // Media
    // remove_menu_page( 'edit.php?post_type=page' );    // Pages
    // remove_menu_page( 'edit-comments.php' );          // Comments
    // remove_menu_page( 'themes.php' );                 // Appearance
    // remove_menu_page( 'plugins.php' );                // Plugins
    // remove_menu_page( 'users.php' );                  // Users
    // remove_menu_page( 'options-general.php' );        // Settings
  
    if( ! current_user_can('manage_options') ){
        
        remove_menu_page( 'tools.php' );                  //Tools
    }
   
}
// add_action( 'admin_menu', __NAMESPACE__ . '\\' . 'remove_sidebar_menu_items' );

/**
 * Reorders the items in the wp-admin sidebar menu
 * 
 * 
 * When filtering the order array, any menus that are not mentioned in the array will be sorted after ones that are mentioned.
 * 
 * Unmentioned menus are sorted in their usual order, relative to other unmentioned menus.
 * 
 * 
 * @see      https://developer.wordpress.org/reference/hooks/custom_menu_order/     Codex, filter: custom_menu_order
 * @see      https://developer.wordpress.org/reference/hooks/menu_order/            Codex, filter: menu_order
 * 
 * @param    array    $menu_order     Truthy value for `custom_menu_order` and array of sorted items for `menu_order`
 * 
 * @return   array    Defined order for some menu items
 */
function reorder_sidebar_menu( $menu_order  ) {
    return array(
        'index.php',  // Dashboard
        'separator1', // --Space--
        'edit.php?post_type=post',
        'edit.php?post_type=page',
        'separator2', // --Space--
   );
}
// add_action( 'custom_menu_order', __NAMESPACE__ . '\\' . 'reorder_sidebar_menu' );
// add_action( 'menu_order',        __NAMESPACE__ . '\\' . 'reorder_sidebar_menu' );

/**
 * Removes the items from the top admin bar
 * 
 * 
 * @global   $wp_admin_bar - WordPress class for generating the Toolbar
 * 
 * @see      https://developer.wordpress.org/reference/classes/wp_admin_bar/                Codex, class: WP_Admin_Bar
 * @see      https://developer.wordpress.org/reference/hooks/wp_before_admin_bar_render/    Codex, action: wp_before_admin_bar_render
 * 
 * @return   void
 */
function remove_topbar_items(){
    // $user = wp_get_current_user();

    // if ( in_array( 'editor', (array) $user->roles ) ) {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
        // $wp_admin_bar->remove_menu('site-name');
        // $wp_admin_bar->remove_menu('comments');
        // $wp_admin_bar->remove_menu('new-content');
    // }
}
// add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\\' . 'remove_topbar_items' );

/* hides the Dates Filter */
// add_filter('months_dropdown_results', '__return_empty_array');

/**
 * Enquques a JS script
 * 
 * The enqueued JS gets it's version generated from the last changed date and time of the file,
 * which avoids cache only if the file has been changed since the cached version.
 * 
 * @uses     \MauiMarketing\MMTF\PLUGIN_DIR PLUGIN_DIR
 * @uses     \MauiMarketing\MMTF\PLUGIN_URL PLUGIN_URL
 * 
 * @param    string    $scriptname    script handle
 * @param    string    $filename      relative path of the JS file
 * @param    string[]  $dependency    list of dependency handles, default: empty array
 * @param    bool      $is_footer     should the script get loaded in the footer, default: true
 * 
 * @return   void
 */
function enqueue_JS(  $scriptname, $filename, $dependency = array(), $is_footer = true ){

    $js_ver  = date("ymd-Gis", filemtime( 	\MauiMarketing\MMTF\PLUGIN_DIR . $filename  ));
	wp_enqueue_script( 	$scriptname, 		\MauiMarketing\MMTF\PLUGIN_URL . $filename, $dependency, $js_ver, $is_footer );
    
}

/**
 * Enquques a CSS file
 * 
 * The enqueued CSS gets it's version generated from the last changed date and time of the file,
 * which avoids cache only if the file has been changed since the cached version.
 * 
 * @uses     \MauiMarketing\MMTF\PLUGIN_DIR PLUGIN_DIR
 * @uses     \MauiMarketing\MMTF\PLUGIN_URL PLUGIN_URL<
 * 
 * @param    string    $scriptname    Style handle
 * @param    string    $filename      relative path of the CSS file
 * @param    string[]  $dependency    list of dependency handles, default: empty array
 * 
 * @return   void
 */
function enqueue_CSS( $scriptname, $filename, $dependency = array() ){

    $css_ver = date("ymd-Gis", filemtime( 	\MauiMarketing\MMTF\PLUGIN_DIR . $filename ));
	wp_register_style( 	$scriptname, 		\MauiMarketing\MMTF\PLUGIN_URL . $filename, $dependency, $css_ver );
    wp_enqueue_style ( 	$scriptname );
    
}

/**
 * Checks if we're on the login or register page
 * 
 * @global   $pagenow - File name of the current WordPress admin screen
 * 
 * @return   bool
 */
function is_login_page(){
    
    global $pagenow;
    
    return in_array( $pagenow, [ 'wp-login.php', 'wp-register.php' ] );
}

/**
 * Replaces array keys, even in a multi-dimensional array
 * 
 * Given an array and a set of `old => new` keys,
 * will recursively replace all array keys that
 * are old with their corresponding new value.
 *
 * @param array $source_array       Original array that needs it's keys replaced
 * @param array $old_to_new_keys    old_key => new_key array, it's not mandatory to have all old keys
 *
 * @return array
 */
function array_replace_keys( $source_array, $old_to_new_keys ){
    
    if( ! is_array( $source_array ) ){
        return $source_array;
    }
    
    $new_array    = [];
    
    foreach( $source_array as $key => $value ){
        
        if( ! empty( $old_to_new_keys[ $key ] ) ){
            
            $key = $old_to_new_keys[ $key ];
        }
        
        if( is_array( $value ) ){
            
            $value = array_replace_keys( $value, $old_to_new_keys );
        }
        
        $new_array[ $key ] = $value;
    }
    
    return $new_array;
}

function replace_avia_search_view_all_results( $search_messages, $search_query ){
    
    $params = $_REQUEST;
    
    if( isset( $params["s"] ) ){
        
        $params["sr"] = $params["s"];
        
        unset( $params["s"] );
    }
    
    $search_page = get_page_by_path( config()["search_page_slug"] );
    
    $search_url = get_the_permalink( $search_page ) . '?' . http_build_query( $params );
    
    $search_messages["all_results_link"] = $search_url;
    
    return $search_messages;
}
// add_filter( 'avf_ajax_search_messages', __NAMESPACE__ . '\\' . 'replace_avia_search_view_all_results', 20, 2 );

function customize_avia_search( $search_params ){
    
    $search_page = get_page_by_path( config()["search_page_slug"] );
    
	$search_params = [
        'placeholder'  	=> __('Search','avia_framework'),
        'search_id'	   	=> 'sr',
        'form_action'	=> get_the_permalink( $search_page ),
        'ajax_disable'	=> true,
    ];
    
    return $search_params;
}
add_filter( 'avf_frontend_search_form_param', __NAMESPACE__ . '\\' . 'customize_avia_search', 20, 1 );


function options_page__availability() {
    
	add_submenu_page(
        'edit.php?post_type=product',
		'Recalculate All Products',
		'Recalculate Availability',
		'manage_options',
		'mmtf_options_availability',
		__NAMESPACE__ . '\\' . 'options_page_html__availability'
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\\' . 'options_page__availability' );

function options_page_html__availability() {
    
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	echo '<div class="wrap">';
		echo '<h1>' . esc_html( get_admin_page_title() ) . '</h1>';
	echo '</div>';
    
	echo '<p>' . 'This action will recalculate the <b>availability</b> and <b>priority</b> for all published products which will be used for indexing the Search page results.' . '</p>';
	echo '<p>' . 'Do not close this page until the process is complete, otherwise you will have to start all over from scratch.' . '</p>';
    
	echo '<div id="progress_bar" class="animate">';
	echo    '<span><span></span></span>';
	echo '</div>';
    
	echo '<div id="progress_start_wrapper">';
    echo     '<div id="progress_start">';
	echo	    'Start recalculating';
    echo     '</div>';
	echo '</div>';
    
	echo '<div id="progress_result_wrapper">';
    echo     'Please wait, progress: ';
    echo     '<span id="progress_result">';
	echo	    '0 / ???';
    echo     '</span>';
	echo '</div>';
}



if (!function_exists('mm_clear_cache_search_page_func')) {
    function mm_clear_cache_search_page_func () {
        $upload_dir = wp_upload_dir();
        $cache_folder = $upload_dir['basedir'] . '/mm_cache_result_search/';
        if (file_exists($cache_folder) && is_dir($cache_folder)) {
            $files = glob($cache_folder . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    }
    add_action('mm_clear_cache_search_page', __NAMESPACE__ . '\\' . 'mm_clear_cache_search_page_func');
}
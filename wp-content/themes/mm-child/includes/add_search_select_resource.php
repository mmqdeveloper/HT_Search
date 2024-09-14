<?php
add_action( 'admin_enqueue_scripts', 'custom_scripts_search_product_resource' );
if (!function_exists('custom_scripts_search_product_resource')) {
    function custom_scripts_search_product_resource() {
    if ( is_admin() ) {
        if ( isset( $_GET['post'] )  && isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) {
            wp_enqueue_script('mm-search-product-resource', get_stylesheet_directory_uri() . '/assets/js/search_product_resource.js', array('jquery'), '1.0.52', true);
            wp_enqueue_script('mm_search_product_resource_select2', get_stylesheet_directory_uri() . '/assets/js/select2.js', array('jquery'), '1.0.0', true);
        }
    }
    }
}
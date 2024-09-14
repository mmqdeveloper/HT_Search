<?php

// remove version from head
remove_action('wp_head', 'wp_generator');

// remove version from rss
add_filter('the_generator', '__return_empty_string');

// remove version from scripts and styles
if( !function_exists( 'mm_remove_version_scripts_styles' ) ) {
    function mm_remove_version_scripts_styles($src)
    {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }

    add_filter('style_loader_src', 'mm_remove_version_scripts_styles', 10, 2);
    add_filter('script_loader_src', 'mm_remove_version_scripts_styles', 10, 2);
}

if( !function_exists( 'mm_check_string_array' ) ){
    function mm_check_string_array( $array_haystack, $search ){

        $result = $search;

        foreach ( $array_haystack as $string ) {
            if( strpos( $search, $string ) )
                return true;
        }
    }
}

if( !function_exists( 'mm_js_defer' ) ){

    function mm_js_defer( $tag, $handle, $src ) {

        $array_search = array(
            // themes
            '/mm/config-templatebuilder/avia-shortcodes/countdown/countdown.js',
            '/mm-child/assets/js/jquery.matchHeight.js',
            '/mm/config-templatebuilder/avia-shortcodes/google_maps/google_maps.js',
            '/mm/config-templatebuilder/avia-shortcodes/image_hotspots/image_hotspots.js',
            '/mm/config-templatebuilder/avia-shortcodes/slideshow/slideshow.js',
            '/mm/config-templatebuilder/avia-shortcodes/portfolio/isotope.js',
            '/mm/config-templatebuilder/avia-shortcodes/masonry_entries/masonry_entries.js',
            '/mm/config-templatebuilder/avia-shortcodes/notification/notification.js',

            // wp-includes
            '/wp-includes/js/hoverintent-js.min.js',
            '/wp-includes/js/admin-bar.min.js',
            '/wp-includes/js/jquery/ui/core.min.js',
            '/wp-includes/js/jquery/ui/datepicker.min.js',
        '/wp-content/themes/mm/js/shortcodes.js',
            'maps-api-v3/api/js/40/9/util.js',


        );
        $array_single = array(
            '/plugins/update-alt-attribute/js/altimage.js',
            '/mm-child/assets/js/mm-script.js',
            '/mm/config-templatebuilder/avia-shortcodes/iconlist/iconlist.js',
            '/mm/config-templatebuilder/avia-shortcodes/image_hotspots/image_hotspots.js',
            '/mm/config-templatebuilder/avia-shortcodes/progressbar/progressbar.js',
            '/mm/config-templatebuilder/avia-shortcodes/testimonials/testimonials.js',
        );

        if( mm_check_string_array( $array_search, $src ) && is_front_page() ){
            $tag = "<script type='text/javascript' src='" . $src . "' defer ></script>";
        }
        if ( mm_check_string_array( $array_single, $src ) && is_single()) {
            $tag = "<script type='text/javascript' src='" . $src . "' defer ></script>";
        }

        return $tag;
    }
//    add_filter( 'script_loader_tag', 'mm_js_defer', 10, 4 );
}

// Inline small CSS
global $mm_count_speed;
if( !function_exists( 'mm_inline_css' ) ){
    function mm_inline_css($html, $handle, $href, $media) {
        global $mm_count_speed;

        $array_search = array(
            '/plugins/sumopaymentplans/assets/css/sumo-pp-single-product-page.css',
            '/plugins/wp-schema-pro/admin/assets/css/frontend.css',
            '/themes/mm-child/style.css',
            '/mm/config-templatebuilder/avia-shortcodes/buttonrow/buttonrow.css',
            '/mm/config-templatebuilder/avia-shortcodes/google_maps/google_maps.css',
            '/mm/config-templatebuilder/avia-shortcodes/grid_row/grid_row.css',
            '/mm/config-templatebuilder/avia-shortcodes/video/video.css',
            '/themes/mm/css/custom.css',
            '/themes/mm/style.css',
        );

        $style = '';
        $style_name = explode( '/', get_stylesheet_directory() )[count(explode( '/', get_stylesheet_directory() )) - 1 ] . '.css';
        if( mm_check_string_array( $array_search ,$href ) ){
            if( empty( $mm_count_speed ) ){
                $style = '<link rel="stylesheet" id="' . $handle . ' " href="' . get_stylesheet_directory_uri() . '/module/speed/css/' . $style_name . '" type="text/css" media="all">';
                $mm_count_speed++;
            }
        }else{
            $style = '<link rel="stylesheet" id="' . $handle . ' " href="' . $href . '" type="text/css" media="all">';
        }

        if (is_admin())
            return $html;

        $html = $style;
        return $html;
    }
    add_filter( 'style_loader_tag', 'mm_inline_css', 10, 4 );
}

//Inline JS

global $mm_count_js_speed;
if( !function_exists( 'mm_inline_js' ) ){

    function mm_inline_js( $tag, $handle, $src ) {
        global $mm_count_js_speed;

        $array_search = array(
            'plugins/update-alt-attribute/js/altimage.js',
            'mm/config-templatebuilder/avia-shortcodes/iconlist/iconlist.js',
            'plugins/yotpo-social-reviews-for-woocommerce/assets/js/headerScript.js',
            'mm/config-templatebuilder/avia-shortcodes/image_hotspots/image_hotspots.js',
            'mm/config-templatebuilder/avia-shortcodes/progressbar/progressbar.js',
            'mm/config-templatebuilder/avia-shortcodes/testimonials/testimonials.js',

        );

        if( mm_check_string_array( $array_search, $src ) && is_single() ){
            $style_name = explode( '/', get_stylesheet_directory() )[count(explode( '/', get_stylesheet_directory() )) - 1 ] . '.js';

            if( empty( $mm_count_js_speed ) ){
                $tag = '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/module/speed/js/' . $style_name . '" defer ></script>';
                $mm_count_js_speed++;
            }else{
                $tag = '';
            }
        }

        return $tag;
    }
    add_filter( 'script_loader_tag', 'mm_inline_js', 10, 4 );
}

function add_rel_preload($html, $handle, $href, $media) {

    if (is_admin())
        return $html;

    $html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;
    return $html;
}

//add_filter( 'style_loader_tag', 'add_rel_preload', 10, 4 );

if( !function_exists( 'mm_remove_update_notifications' ) ) {
    function mm_remove_update_notifications($value)
    {

        if (isset($value) && is_object($value)) {
            unset($value->response['shins-pageload-magic/shins-pageload-magic.php']);
        }
        return $value;
    }

    add_filter('site_transient_update_plugins', 'mm_remove_update_notifications');
}
function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
}
//add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );
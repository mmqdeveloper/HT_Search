<?php
if (!defined('ABSPATH')) {
    die();
}

//do_action('wp_mm_pre_header_hook'); test
//ben

global $avia_config;

$lightbox_option = avia_get_option('lightbox_active');
$avia_config['use_standard_lightbox'] = empty($lightbox_option) || ( 'lightbox_active' == $lightbox_option ) ? 'lightbox_active' : 'disabled';
/**
 * Allow to overwrite the option setting for using the standard lightbox
 * Make sure to return 'disabled' to deactivate the standard lightbox - all checks are done against this string
 * 
 * @added_by Günter
 * @since 4.2.6
 * @param string $use_standard_lightbox				'lightbox_active' | 'disabled'
 * @return string									'lightbox_active' | 'disabled'
 */
$avia_config['use_standard_lightbox'] = apply_filters('avf_use_standard_lightbox', $avia_config['use_standard_lightbox']);

$style = $avia_config['box_class'];
$responsive = avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
$blank = isset($avia_config['template']) ? $avia_config['template'] : "";
$av_lightbox = $avia_config['use_standard_lightbox'] != "disabled" ? 'av-default-lightbox' : 'av-custom-lightbox';
$preloader = avia_get_option('preloader') == "preloader" ? 'av-preloader-active av-preloader-enabled' : 'av-preloader-disabled';
$sidebar_styling = avia_get_option('sidebar_styling');
$filterable_classes = avia_header_class_filter(avia_header_class_string());
$av_classes_manually = "av-no-preview"; /* required for live previews */
$av_classes_manually .= avia_is_burger_menu() ? " html_burger_menu_active" : " html_text_menu_active";

/**
 * @since 4.2.3 we support columns in rtl order (before they were ltr only). To be backward comp. with old sites use this filter.
 */
$rtl_support = 'yes' == apply_filters('avf_rtl_column_support', 'yes') ? ' rtl_columns ' : '';
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo "html_{$style} " . $responsive . " " . $preloader . " " . $av_lightbox . " " . $filterable_classes . " " . $av_classes_manually ?> ">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <?php
        /*
         * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
         * located in framework/php/function-set-avia-frontend.php
         */
        if (function_exists('avia_set_follow')) {
            echo avia_set_follow();
        }
        ?>


        <!-- mobile setting -->
        <?php
        if (strpos($responsive, 'responsive') !== false)
            echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
        ?>


        <!-- Scripts/CSS and wp_head hook -->
        <?php
        /* Always have wp_head() just before the closing </head>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to add elements to <head> such
         * as styles, scripts, and meta tags.
         */

        wp_head();
        $PageClass = get_post_meta(get_queried_object_id(), 'mm_page_class', true);
        ?>

		<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<meta name="facebook-domain-verification" content="0p75wokujynznzg6k4d62jqd1anodz" />
    </head>

    <body id="top" <?php
    body_class($rtl_support . $style . " " . $avia_config['font_stack'] . " " . $blank . " " . $sidebar_styling." ". $PageClass);
    avia_markup_helper(array('context' => 'body'));
    ?>>

		        <?php
	        
        do_action('ava_after_body_opening_tag');

        if ("av-preloader-active av-preloader-enabled" === $preloader) {
            echo avia_preload_screen();
        }
        ?>

        <div id='wrap_all'>

            <?php
            if (!$blank) { //blank templates dont display header nor footer 
                //fetch the template file that holds the main menu, located in includes/helper-menu-main.php
                get_template_part('includes/helper', 'main-menu');
            }
            ?>

            <div id='main' class='all_colors' data-scroll-offset='<?php echo avia_header_setting('header_scroll_offset'); ?>'>

                <?php
                if (isset($avia_config['temp_logo_container']))
                    echo $avia_config['temp_logo_container'];
                do_action('ava_after_main_container');
                ?>

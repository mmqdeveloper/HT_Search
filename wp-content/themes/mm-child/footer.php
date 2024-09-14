<?php
do_action('ava_before_footer');

global $avia_config;
$blank = isset($avia_config['template']) ? $avia_config['template'] : "";

//reset wordpress query in case we modified it
wp_reset_query();


//get footer display settings
$the_id = avia_get_the_id(); //use avia get the id instead of default get id. prevents notice on 404 pages
$footer = get_post_meta($the_id, 'footer', true);
$footer_widget_setting = !empty($footer) ? $footer : avia_get_option('display_widgets_socket');
$disable_section_footer = get_post_meta($the_id, 'mm_disable_section_footer', true);
$is_footer_vp = get_post_meta($the_id, 'mm_footer_vp', true);
if($disable_section_footer!='Yes' && $footer_widget_setting != 'landingpage' && $is_footer_vp != 'yes' && 'cruise' != get_post_type() && 'post' != get_post_type()){
   dynamic_sidebar( 'Section Footer' );
}
if($is_footer_vp == 'yes'){
    dynamic_sidebar( 'Section Footer VP' );
}
if (is_product()) {
    ?>
    <div class="sticky-start-booking" style="display: none">
        <button type="button" name="start-booking" id="start-booking">
            Book Now
        </button>
    </div>
<?php
}

if ($the_id == 8203 || $the_id == 20299) {
    ?>
    <div class="sticky-custom-vacation-planner" style="display: none">
        <a href="#custom-vacation-planner" class="link-custom-vacation-planner">
            Create A Vacation Package
        </a>
    </div>
<?php
}

if ($the_id == 111) {
    ?>
    <div class="sticky-custom-vacation-planner" style="display: none">
        <a href="#free-consultation-form" class="link-custom-vacation-planner">
            Create A Group Vacation
        </a>
    </div>
<?php
}

if ($is_footer_vp == 'yes') {
    ?>
    <div class='container_wrap footer_color footer-vp' id='footer'>
        <?php if(is_product() || is_archive()){?>
            <div id="breadcrumb_product">
                <?php woocommerce_breadcrumb(); ?>
            </div>
        <?php } ?>
        <div class='container'>
            <?php
            $columns_footer_vp = 3;

            $class = 'av_one_third';

            $firstCol = "first el_before_{$class}";

            for ($i = 1; $i <= $columns_footer_vp; $i++) {
                $class2 = "";
                if ($i != 1)
                    $class2 = " el_after_{$class}  el_before_{$class}";
                echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
                if (function_exists('dynamic_sidebar') ) :
                    dynamic_sidebar('Footer VP Column ' . $i);
                else:
                    avia_dummy_widget($i);
                endif;

                if ($i == 1) {
                    if (avia_get_option('footer_social', 'disabled') != "disabled") {
                        $social_args = array('outside' => 'ul', 'inside' => 'li', 'append' => '');
                        echo avia_social_media_icons($social_args, false);
                    }
                }

                echo "</div>";
                $firstCol = "";
            }
            ?>
        </div>
    </div>

    <?php

    //copyright
    $copyright = do_shortcode(avia_get_option('copyright', "&copy; " . __('Copyright', 'avia_framework') . "  - <a href='" . home_url('/') . "'>" . get_bloginfo('name') . "</a>"));

    $kriesi_at_backlink = kriesi_backlink(get_option(THEMENAMECLEAN . "_initial_version"));

    if ($copyright && strpos($copyright, '[nolink]') !== false) {
        $kriesi_at_backlink = "";
        $copyright = str_replace("[nolink]", "", $copyright);
    }

    if ($footer_widget_setting != 'nosocket') {
        ?>

        <footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper(array('context' => 'footer')); ?>>
            <div class='container'>

                <span class='copyright'><?php echo $copyright . $kriesi_at_backlink; ?></span>
                <div class="socket_right">
                    <a href="/about-us/privacy-policy/">Privacy Policy</a> | <a href="/about-us/refund-policy/">Cancellation Policy</a>
                    <?php

                    $avia_theme_location = 'avia3';
                    $avia_menu_class = $avia_theme_location . '-menu';

                    $args = array(
                        'theme_location' => $avia_theme_location,
                        'menu_id' => $avia_menu_class,
                        'container_class' => $avia_menu_class,
                        'fallback_cb' => '',
                        'depth' => 1,
                        'echo' => false,
                        'walker' => new avia_responsive_mega_menu(array('megamenu' => 'disabled'))
                    );

                    ?>
                </div>
            </div>
        </footer>
        <a href="tel:+18088004799" class="all-inclusive-sticky-phone">1 (808) 800-4799</a>
        <?php
    }
}
//check if we should display a footer
if (!$blank && $footer_widget_setting != 'nofooterarea' && $is_footer_vp != 'yes') {
    if ($footer_widget_setting != 'nofooterwidgets') {
        //get columns
        $columns = avia_get_option('footer_columns');
        ?>
        <div class='container_wrap footer_color' id='footer'>
	        <?php if(is_product() || is_archive()){?>
                <div id="breadcrumb_product">
			        <?php woocommerce_breadcrumb(); ?>

                </div>
	        <?php } ?>
            <div class='container'>

        <?php
//        if (wp_is_mobile()) {
//
//            do_action('avia_before_footer_columns');
//
//            //create the footer columns by iterating
//
//            switch ($columns) {
//                case 1: $class = '';
//                    break;
//                case 2: $class = 'av_one_half';
//                    break;
//                case 3: $class = 'av_one_third';
//                    break;
//                case 4: $class = 'av_one_fourth';
//                    break;
//                case 5: $class = 'av_one_fifth';
//                    break;
//                case 6: $class = 'av_one_sixth';
//                    break;
//            }
//
//            $firstCol = "first el_before_{$class}";
//
//            //display the footer widget that was defined at appearenace->widgets in the wordpress backend
//            //if no widget is defined display a dummy widget, located at the bottom of includes/register-widget-area.php
//            for ($i = 1; $i <= $columns; $i++) {
//                if($i == 1){
//                    $class2 = ""; // initialized to avoid php notices
//                    echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
//                    if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer - column' . $i)) : else : avia_dummy_widget($i);
//                    endif;
//                    if ($i == 1) {
//                        if (avia_get_option('footer_social', 'disabled') != "disabled") {
//                            $social_args = array('outside' => 'ul', 'inside' => 'li', 'append' => '');
//                            echo avia_social_media_icons($social_args, false);
//                        }
//                    }
//                    echo "</div>";
//                    $firstCol = "";
//                }
//                if($i == 2 ){
//                    $class2 = " el_after_{$class}  el_before_{$class}";
//                    echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
//                    if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer - Mobile')) : else : dynamic_sidebar('Footer - Mobile');
//                    endif;
//                    echo "</div>";
//                    $firstCol = "";
//                    break;
//                }
//
//            }
//
//            do_action('avia_after_footer_columns');
//
//        } else {
                    
            do_action('avia_before_footer_columns');

            //create the footer columns by iterating

            switch ($columns) {
                case 1: $class = '';
                    break;
                case 2: $class = 'av_one_half';
                    break;
                case 3: $class = 'av_one_third';
                    break;
                case 4: $class = 'av_one_fourth';
                    break;
                case 5: $class = 'av_one_fifth';
                    break;
                case 6: $class = 'av_one_sixth';
                    break;
            }

            $firstCol = "first el_before_{$class}";

            //display the footer widget that was defined at appearenace->widgets in the wordpress backend
            //if no widget is defined display a dummy widget, located at the bottom of includes/register-widget-area.php
            if($footer_widget_setting == 'landingpage'){
                for ($i = 1; $i <= $columns; $i++) {
                    $class2 = ""; // initialized to avoid php notices
                    if ($i != 1)
                        $class2 = " el_after_{$class}  el_before_{$class}";
                    echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
                    if (function_exists('dynamic_sidebar') ) : 
                        dynamic_sidebar('Footer-Landing-Page-' . $i);
                    else: 
                        avia_dummy_widget($i);
                    endif;
                    echo "</div>";
                    $firstCol = "";
                }
            }else{
                for ($i = 1; $i <= $columns; $i++) {
                    $class2 = ""; // initialized to avoid php notices
                    if ($i != 1)
                        $class2 = " el_after_{$class}  el_before_{$class}";
                    echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
                    if (function_exists('dynamic_sidebar') ) : 
                        dynamic_sidebar('Footer - column' . $i);
                    else: 
                        avia_dummy_widget($i);
                    endif;

                    if ($i == 1) {
                        if (avia_get_option('footer_social', 'disabled') != "disabled") {
                            $social_args = array('outside' => 'ul', 'inside' => 'li', 'append' => '');
                            echo avia_social_media_icons($social_args, false);
                        }
                    }

                    echo "</div>";
                    $firstCol = "";
                }
            }

            do_action('avia_after_footer_columns');
//        }

        ?>


            </div>


            <!-- ####### END FOOTER CONTAINER ####### -->
        </div>

    <?php } //endif nofooterwidgets  ?>





    <?php
    //copyright
    $copyright = do_shortcode(avia_get_option('copyright', "&copy; " . __('Copyright', 'avia_framework') . "  - <a href='" . home_url('/') . "'>" . get_bloginfo('name') . "</a>"));

    // you can filter and remove the backlink with an add_filter function
    // from your themes (or child themes) functions.php file if you dont want to edit this file
    // you can also just keep that link. I really do appreciate it ;)
    $kriesi_at_backlink = kriesi_backlink(get_option(THEMENAMECLEAN . "_initial_version"));


    //you can also remove the kriesi.at backlink by adding [nolink] to your custom copyright field in the admin area
    if ($copyright && strpos($copyright, '[nolink]') !== false) {
        $kriesi_at_backlink = "";
        $copyright = str_replace("[nolink]", "", $copyright);
    }

    if ($footer_widget_setting != 'nosocket') { 
        ?>

        <footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper(array('context' => 'footer')); ?>>
            <div class='container'>

                <span class='copyright'><?php echo $copyright . $kriesi_at_backlink; ?></span>
                <div class="socket_right">
                    <a href="/about-us/privacy-policy/">Privacy Policy</a> | <a href="/about-us/refund-policy/">Cancellation Policy</a>
        <?php
        //dynamic_sidebar( 'socket-left' );

//        if (avia_get_option('footer_social', 'disabled') != "disabled") {
//            $social_args = array('outside' => 'ul', 'inside' => 'li', 'append' => '');
//            echo avia_social_media_icons($social_args, false);
//        }


        $avia_theme_location = 'avia3';
        $avia_menu_class = $avia_theme_location . '-menu';

        $args = array(
            'theme_location' => $avia_theme_location,
            'menu_id' => $avia_menu_class,
            'container_class' => $avia_menu_class,
            'fallback_cb' => '',
            'depth' => 1,
            'echo' => false,
            'walker' => new avia_responsive_mega_menu(array('megamenu' => 'disabled'))
        );

        //$menu = wp_nav_menu($args);

        /*  if($menu){ 
          echo "<nav class='sub_menu_socket' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
          echo $menu;
          echo "</nav>";
          } */
        ?>
                </div>
            </div>
<!--            <script src='https://pearlharborwp.wpengine.com/wp-content/themes/mm-child/js/custom_height.js'></script>-->
            <!-- ####### END SOCKET CONTAINER ####### -->
        </footer>


        <?php
    } //end nosocket check
} //end blank & nofooterarea check
?>
<!-- end main -->
</div>

<?php
//display link to previeous and next portfolio entry
echo avia_post_nav();

echo "<!-- end wrap_all --></div>";


if (isset($avia_config['fullscreen_image'])) {
    ?>
    <!--[if lte IE 8]>
    <style type="text/css">
    .bg_container {
    -ms-filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale')";
    filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale');
    }
    </style>
    <![endif]-->
    <?php
    echo "<div class='bg_container' style='background-image:url(" . $avia_config['fullscreen_image'] . ");'></div>";
}
?>


<?php
/* Always have wp_footer() just before the closing <?php do_action('wp_mm_body_prior_close_hook'); ?>
  </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */


wp_footer();
?>
<a href='#top' title='<?php _e('Scroll to top', 'avia_framework'); ?>' id='scroll-top-link' <?php echo av_icon_string('scrolltop'); ?>><span class="avia_hidden_link_text"><?php _e('Scroll to top', 'avia_framework'); ?></span></a>

<div id="fb-root"></div>
<?php do_action('wp_mm_body_prior_close_hook'); ?> 
</body>
</html>

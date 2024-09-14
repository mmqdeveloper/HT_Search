<?php
global $avia_config;

$responsive = avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
$headerS = avia_header_setting();
$social_args = array('outside' => 'ul', 'inside' => 'li', 'append' => '');
$icons = !empty($headerS['header_social']) ? avia_social_media_icons($social_args, false) : "";

$alternate_menu_id = ! empty( $headerS['alternate_menu'] ) && is_numeric( $headerS['alternate_menu'] ) && empty( $headerS['menu_display'] ) ? $headerS['alternate_menu'] : false;

/**
 * For sidebar menus this filter allows to activate alternate menus - are disabled by default
 *
 * @since 4.5
 * @param int|false $alternate_menu_id
 * @param array $headerS
 * @return int|false
 */
$alternate_menu_id = apply_filters( 'avf_alternate_mobile_menu_id', $alternate_menu_id, $headerS );

if (isset($headerS['disabled']))
    return;
?>

<header id='header' class='all_colors header_color <?php avia_is_dark_bg('header_color');
echo " " . $headerS['header_class'];
?>' <?php avia_markup_helper(array('context' => 'header', 'post_type' => 'forum')); ?>>

    <?php
//subheader, only display when the user chooses a social header
    if ($headerS['header_topbar'] == true) {
        ?>
        <div id='header_meta' class='container_wrap container_wrap_meta <?php echo avia_header_class_string(array('header_social', 'header_secondary_menu', 'header_phone_active'), 'av_'); ?>'>

            <div class='container'>
                <?php
                /*
                 *  display the themes social media icons, defined in the wordpress backend
                 *   the avia_social_media_icons function is located in includes/helper-social-media-php
                 */
                $nav = "";

                //display icons
                if (strpos($headerS['header_social'], 'extra_header_active') !== false)
                    echo $icons;

                //display navigation
                if (strpos($headerS['header_secondary_menu'], 'extra_header_active') !== false) {
                    //display the small submenu
                    $avia_theme_location = 'avia2';
                    $avia_menu_class = $avia_theme_location . '-menu';
                    $args = array(
                        'theme_location' => $avia_theme_location,
                        'menu_id' => $avia_menu_class,
                        'container_class' => $avia_menu_class,
                        'fallback_cb' => '',
                        'container' => '',
                        'echo' => false
                    );

                    $nav = wp_nav_menu($args);
                }

                if (!empty($nav) || apply_filters('avf_execute_avia_meta_header', false)) {
                    echo "<nav class='sub_menu' " . avia_markup_helper(array('context' => 'nav', 'echo' => false)) . ">";
                    echo $nav;
                    do_action('avia_meta_header'); // Hook that can be used for plugins and theme extensions (currently: the wpml language selector)
                    echo '</nav>';
                }


                //phone/info text   
                $phone = $headerS['header_phone_active'] != "" ? $headerS['phone'] : "";
                $phone_class = !empty($nav) ? "with_nav" : "";
                if ($phone) {
                    echo "<div class='phone-info {$phone_class}'><span>" . do_shortcode($phone) . "</span></div>";
                }
                ?>
            </div>
        </div>

        <?php
    }



    $output = "";
    $temp_output = "";
    $icon_beside = "";

    if ($headerS['header_social'] == 'icon_active_main' && empty($headerS['bottom_menu'])) {
        $icon_beside = " av_menu_icon_beside";
    }
    ?>
    <div  id='header_main' class='container_wrap container_wrap_logo'>

        <?php
        /*
         * Hook that can be used for plugins and theme extensions (currently:  the woocommerce shopping cart)
         */
        do_action('ava_main_header');

        if ($headerS['header_position'] != "header_top")
            do_action('ava_main_header_sidebar');


        $output .= "<div class='container av-logo-container'>";

        $output .= "<div class='inner-container'>";

        /*
         *  display the theme logo by checking if the default logo was overwritten in the backend.
         *   the function is located at framework/php/function-set-avia-frontend-functions.php in case you need to edit the output
         */
        $addition = false;
        if (!empty($headerS['header_transparency']) && !empty($headerS['header_replacement_logo'])) {
            $addition = "<img src='" . $headerS['header_replacement_logo'] . "' class='alternate' alt='Hawaii Tours and Activities' title='' />";
        }
        if (is_cart() || is_checkout()) {
            $output .= '<span class="logo avia-standard-logo"><a href="/" class="" style="max-height: 88px;"><img src="https://www.hawaiitours.com/wp-content/uploads/2019/06/ht-logo-blue-orange-sm.png" height="100" width="300" alt="Hawaii Tours and Activities" title="" style="max-height: 88px;"></a></span>';
        }else{
        $output .= avia_logo(AVIA_BASE_URL . 'images/layout/logo.png', $addition, 'span', true);
        }
        if (!empty($headerS['bottom_menu'])) {
            ob_start();
            do_action('ava_before_bottom_main_menu'); // todo: replace action with filter, might break user customizations
            $output .= ob_get_clean();
        }

        if ($headerS['header_social'] == 'icon_active_main' && !empty($headerS['bottom_menu'])) {
            $output .= $icons;
        }
        global $post;
        $header_vacation_packages = "";
        if($post){
            $header_vacation_packages = get_post_meta( $post->ID, 'header_transparency', true );
        }
        
        if ($header_vacation_packages != 'header_vacation_packages'):


            /*
             *  display the main navigation menu
             *   modify the output in your wordpress admin backend at appearance->menus
             */

            if ($headerS['bottom_menu']) {
                $output .= "</div>";
                $output .= "</div>";

                if (!empty($headerS['header_menu_above'])) {
                    $avia_config['temp_logo_container'] = "<div class='av-section-bottom-logo header_color'>" . $output . "</div>";
                    $output = "";
                }

                $output .= "<div id='header_main_alternate' class='container_wrap'>";
                $output .= "<div class='container'>";
            }
            if(!is_checkout() && !is_cart() && class_exists( 'WPCleverWoofc' )){
                $output .= "<ul class='mm-flycart-menu-mobile'>";
                $output .= WPCleverWoofc::get_cart_menu();
                $output .= "</ul>";
            }
            // =====================================================================
            if(!is_checkout() && !is_cart() && !is_account_page() && shortcode_exists('mm_template_search_mobile_header1')) {
                $output .= do_shortcode('[mm_template_search_mobile_header1]');
            }
            // =====================================================================

            $output .= "<nav class='main_menu' data-selectname='" . __('Select a page', 'avia_framework') . "' " . avia_markup_helper(array('context' => 'nav', 'echo' => false)) . ">";
            
            if (is_cart() || is_checkout()) {
                $avia_theme_location = 'mm-menu-cart';
                $avia_menu_class = 'avia-menu';
            }
            else {
            $avia_theme_location = 'avia';
            $avia_menu_class = $avia_theme_location . '-menu';
            }
            
            $args = array(
                'theme_location' => $avia_theme_location,
                'menu_id' => $avia_menu_class,
                'menu_class' => 'menu av-main-nav',
                'container_class' => $avia_menu_class . ' av-main-nav-wrap' . $icon_beside,
                'fallback_cb' => 'avia_fallback_menu',
                'echo' => false,
                'walker' => new avia_responsive_mega_menu()
            );

            $main_nav = wp_nav_menu($args);
            if(!is_checkout() && !is_cart() && !is_account_page()) {
                $output .= '<div class="mm-search-header">
                    <form action="/search/" id="searchform" method="get" class="av_disable_ajax_search" data-hs-cf-bound="true">
                        <div class="fields-group">
                            <button type="submit" id="searchsubmit" value="" class="button avia-font-entypo-fontello"></button>
                            <input type="text" id="s" name="keyword" value="" placeholder="Search for a place or activity">
                            <input type="hidden" name="mmtf_query_by" value="ajax">
                        </div>
                    </form>
                </div>';
            }
            $output .= $main_nav;
            ob_start();
            dynamic_sidebar("phone_number_menu");
            $phone = ob_get_clean();
            $output .= '<div class="menu-phone-number"><div class="main-phone-number">' . $phone . '</div></div>';

            /*
             * Hook that can be used for plugins and theme extensions
             */
            ob_start();
            do_action('ava_inside_main_menu'); // todo: replace action with filter, might break user customizations
            $output .= ob_get_clean();

            if ($icon_beside) {
                $output .= $icons;
            }

            $output .= '</nav>';

            /*
             * Hook that can be used for plugins and theme extensions
             */
            ob_start();
            do_action('ava_after_main_menu'); // todo: replace action with filter, might break user customizations
            $output .= ob_get_clean();

        endif;

        if ($header_vacation_packages == 'header_vacation_packages'):
            $menu_items = wp_get_nav_menu_items('Menu VP Top');

            $output .= "<div id='mm-nav-vp-hamburger'>";
            $output .= "<div class='mm-nav-vp-hamburger-bar'></div>";
            $output .= "<div class='mm-nav-vp-hamburger-bar'></div>";
            $output .= "<div class='mm-nav-vp-hamburger-bar'></div>";
            $output .= "</div>";

            $output .= "<div class='mm-nav-vp-wrap'>";
            if (!empty($menu_items)) {
                foreach($menu_items as $menu_item) {
                    $icon = '';
                    if (in_array('vp-phone-btn', $menu_item->classes)) {
                        $icon .= '<svg width="18" height="18" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7748 15.5627V18.5627C20.776 18.8412 20.7189 19.1168 20.6073 19.372C20.4958 19.6272 20.3321 19.8563 20.1269 20.0445C19.9217 20.2328 19.6794 20.3762 19.4156 20.4654C19.1518 20.5546 18.8722 20.5877 18.5948 20.5627C15.5177 20.2283 12.5618 19.1768 9.96484 17.4927C7.54866 15.9573 5.50017 13.9088 3.96484 11.4927C2.27481 8.88388 1.22308 5.91367 0.894835 2.82268C0.869846 2.54614 0.90271 2.26744 0.991336 2.0043C1.07996 1.74116 1.22241 1.49936 1.4096 1.2943C1.5968 1.08923 1.82464 0.925384 2.07863 0.813197C2.33261 0.70101 2.60718 0.642937 2.88484 0.642675H5.88484C6.37014 0.637899 6.84063 0.809754 7.2086 1.12621C7.57657 1.44266 7.81691 1.88212 7.88484 2.36268C8.01146 3.32274 8.24629 4.2654 8.58484 5.17268C8.71938 5.5306 8.7485 5.91959 8.66874 6.29356C8.58899 6.66752 8.4037 7.01079 8.13484 7.28268L6.86484 8.55268C8.28839 11.0562 10.3613 13.1291 12.8648 14.5527L14.1348 13.2827C14.4067 13.0138 14.75 12.8285 15.124 12.7488C15.4979 12.669 15.8869 12.6981 16.2448 12.8327C17.1521 13.1712 18.0948 13.4061 19.0548 13.5327C19.5406 13.6012 19.9842 13.8459 20.3014 14.2202C20.6185 14.5945 20.787 15.0723 20.7748 15.5627Z" fill="white"/></svg>';
                    }
                    $class = implode(' ', $menu_item->classes);
                    $output .= "<a class='mm-nav-vp-item {$class}' href='{$menu_item->url}'>{$icon}{$menu_item->title}</a>";
                }
            }
            $output .= "</div>";
        endif;

        /* inner-container */
        $output .= "</div>";

        /* end container */
        $output .= " </div> ";


        //output the whole menu     
        echo $output;
        ?>

        <!-- end container_wrap-->
    </div>
    <?php
        /**
         * Add a hidden container for alternate mobile menu
         *
         * We use the same structure as main menu to be able to use same logic in js to build burger menu
         *
         * @added_by Günter
         * @since 4.5
         */
        if ($header_vacation_packages != 'header_vacation_packages'):
            $out_alternate = '';
            $avia_alternate_location = 'avia_alternate';
            $avia_alternate_menu_class = $avia_alternate_location . '_menu';

            if( false !== $alternate_menu_id && is_nav_menu( $alternate_menu_id ) )
            {
                $out_alternate .= '<div id="avia_alternate_menu_container" style="display: none;">';

                $alternate_nav =    "<nav class='main_menu' data-selectname='" . __( 'Select a page', 'avia_framework' ) . "' " . avia_markup_helper( array( 'context' => 'nav', 'echo' => false ) ) . '>';

                $args = array(
                                'menu'              => $alternate_menu_id,
                                'menu_id'           => $avia_alternate_menu_class,
                                'menu_class'        => 'menu av-main-nav',
                                'container_class'   => $avia_alternate_menu_class.' av-main-nav-wrap',
                                'fallback_cb'       => 'avia_fallback_menu',
                                'echo'              => false,
                                'walker'            => new avia_responsive_mega_menu()
                            );

                $wp_nav_alternate = wp_nav_menu( $args );

                /**
                 * Hook that can be used for plugins and theme extensions
                 *
                 * @since 4.5
                 * @return string
                 */
                $alternate_nav .=       apply_filters( 'avf_inside_alternate_main_menu_nav', $wp_nav_alternate, $avia_alternate_location, $avia_alternate_menu_class );

                $alternate_nav .=   '</nav>';

                /**
                 * Allow to modify or remove alternate menu for special pages.
                 *
                 * @since 4.5
                 * @return string
                 */
                $out_alternate .= apply_filters( 'avf_alternate_main_menu_nav', $alternate_nav );

                $out_alternate .= '</div>';
            }

            /**
             * Hook to remove or modify alternate mobile menu
             *
             * @since 4.5
             * @return string
             */
            $out_alternate = apply_filters( 'avf_alternate_mobile_menu', $out_alternate );

            if( ! empty ( $out_alternate ) )
            {
                echo $out_alternate;
            }
        endif;
    ?>
    <div class='header_bg'></div>

    <!-- end header -->
</header>

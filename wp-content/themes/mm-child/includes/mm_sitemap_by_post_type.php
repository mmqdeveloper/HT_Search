<?php
/**
 * Post/Page Content
 *
 * Element is in Beta and by default disabled. Todo: test with layerslider elements. currently throws error bc layerslider is only included if layerslider element is detected which is not the case with the post/page element
 */
if (!class_exists('avia_sc_site_map_post_type') && class_exists('woocommerce')) {
    class avia_sc_site_map_post_type extends aviaShortcodeTemplate {
        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM SiteMap By Post Type', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-postslider.png";
            $this->config['order'] = 30;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'avia_sc_site_map_post_type';
            $this->config['tooltip'] = __('Display list post type', 'avia_framework');
            $this->config['drag-level'] = 3;
        }
        /**
         * Popup Elements
         *
         * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
         * opens a modal window that allows to edit the element properties
         *
         * @return void
         */
        function popup_elements() {
            $post_type = ['Select post type' => -1];
            $sitemap_post_type = get_option( 'mm_sitemap_post_type' );
            if ($sitemap_post_type) {
                foreach ($sitemap_post_type as $value) {
                    $post_type[ucfirst($value)] = $value;
                }
            }
            $this->elements = array(
                array(
                    "type" => "tab_container", 'nodescription' => true
                ),
                array(
                    "type" => "tab",
                    "name" => __("Content", 'avia_framework'),
                    'nodescription' => true
                ),
                array(
                    "name" 	=> __("Sitemap Title", 'avia_framework' ),
                    "id" 	=> "heading",
                    'container_class' =>"avia-element-fullwidth",
                    "std" 	=> __("Sitemap title", 'avia_framework' ),
                    "type" 	=> "input"
                ),
                array(
                    "name" => __("Post Type", 'avia_framework'),
                    "desc" => __("Select Post Type for Sitemap", 'avia_framework'),
                    "id" => "mm_sitemap_post_type",
                    "type" => "select",
                    "subtype" => $post_type,
                ),
                array(
                    "name" => __("Hotel Tag", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_hotel_tag",
                    "type" => "select",
                    "required" => array('mm_sitemap_post_type', 'equals', 'hotel'),
                    "taxonomy" => "hotel_tags",
                    "subtype" => "cat",
                    "multiple" => 6
                ),
                array(
                    "name" => __("Restaurant Tag", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_restaurant_tag",
                    "type" => "select",
                    "required" => array('mm_sitemap_post_type', 'equals', 'restaurant'),
                    "taxonomy" => "restaurant_tags",
                    "subtype" => "cat",
                    "multiple" => 6
                ),
                array(
                    "name" => __("Post Tag", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_post_tag",
                    "type" => "select",
                    "required" => array('mm_sitemap_post_type', 'equals', 'post'),
                    "taxonomy" => "post_tag",
                    "subtype" => "cat",
                    "multiple" => 6
                ),
                array(
                    "name" => __("Cruise Ship Tag", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_post_tag_cruise",
                    "type" => "select",
                    "required" => array('mm_sitemap_post_type', 'equals', 'cruise'),
                    "taxonomy" => "post_tag",
                    "subtype" => "cat",
                    "multiple" => 6
                ),
                array(
                    "name" 	=> __("Number items", 'avia_framework' ),
                    "desc" => __("Input Number Items You Want Show On A Column", 'avia_framework'),
                    "id" 	=> "mm_number_item_on_column",
                    "std" 	=> __("", 'avia_framework' ),
                    "type" 	=> "input"
                ),
                array(
                    "type" => "close_div",
                    'nodescription' => true
                ),
                array(
                    "type" => "tab",
                    "name" => __("Screen Options", 'avia_framework'),
                    'nodescription' => true
                ),
                array(
                    "name" => __("Element Visibility", 'avia_framework'),
                    "desc" => __("Set the visibility for this element, based on the device screensize.", 'avia_framework'),
                    "type" => "heading",
                    "description_class" => "av-builder-note av-neutral",
                ),
                array(
                    "desc" => __("Hide on large screens (wider than 990px - eg: Desktop)", 'avia_framework'),
                    "id" => "av-desktop-hide",
                    "std" => "",
                    "container_class" => 'av-multi-checkbox',
                    "type" => "checkbox"),
                array(
                    "desc" => __("Hide on medium sized screens (between 768px and 989px - eg: Tablet Landscape)", 'avia_framework'),
                    "id" => "av-medium-hide",
                    "std" => "",
                    "container_class" => 'av-multi-checkbox',
                    "type" => "checkbox"),
                array(
                    "desc" => __("Hide on small screens (between 480px and 767px - eg: Tablet Portrait)", 'avia_framework'),
                    "id" => "av-small-hide",
                    "std" => "",
                    "container_class" => 'av-multi-checkbox',
                    "type" => "checkbox"),
                array(
                    "desc" => __("Hide on very small screens (smaller than 479px - eg: Smartphone Portrait)", 'avia_framework'),
                    "id" => "av-mini-hide",
                    "std" => "",
                    "container_class" => 'av-multi-checkbox',
                    "type" => "checkbox"),
                array(
                    "type" => "close_div",
                    'nodescription' => true
                ),
                array(
                    "type" => "close_div",
                    'nodescription' => true
                ),
            );
        }
        /**
         * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
         * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
         * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
         *
         *
         * @param array $params this array holds the default values for $content and $args.
         * @return $params the return array usually holds an innerHtml key that holds item specific markup.
         */
        function editor_element($params) {
            $params['innerHtml'] = "<img src='" . $this->config['icon'] . "' title='" . $this->config['name'] . "' />";
            $params['innerHtml'] .= "<div class='avia-element-label'>" . $this->config['name'] . "</div>";
            $params['content'] = NULL; //remove to allow content elements
            return $params;
        }
        /**
         * Frontend Shortcode Handler
         *
         * @param array $atts array of attributes
         * @param string $content text within enclosing form of shortcode element
         * @param string $shortcodename the shortcode found, when == callback name
         * @return string $output returns the modified html string
         */
        function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "") {
            global $avia_config, $woocommerce;
            $page_id_sitemap_shortcode = get_the_ID();
            $atts = shortcode_atts(array(
                'heading' => '',
                'mm_sitemap_post_type' => '',
                'mm_post_tag' => '',
                'mm_hotel_tag' => '',
                'mm_restaurant_tag' => '',
                'mm_post_tag_cruise' => '',
                'mm_number_item_on_column' => ''
            ), $atts, $this->config['shortcode']);
            extract($atts);
            $post_type = $atts['mm_sitemap_post_type'];
            $tag_type = '';
            if($post_type == 'post') {
                $tag_type = 'post_tag';
                if (!empty($atts['mm_post_tag'])) {
                    $id_tag = explode(',', $atts['mm_post_tag']);
                }
            }
            if($post_type == 'cruise') {
                $tag_type = 'post_tag';
                if (!empty($atts['mm_post_tag_cruise'])) {
                    $id_tag = explode(',', $atts['mm_post_tag_cruise']);
                }
            }elseif ($post_type == 'hotel') {
                $tag_type = 'hotel_tags';
                if (!empty($atts['mm_hotel_tag'])) {
                    $id_tag = explode(',', $atts['mm_hotel_tag']);
                }
            }elseif ($post_type == 'restaurant') {
                $tag_type = 'restaurant_tags';
                if (!empty($atts['mm_restaurant_tag'])) {
                    $id_tag = explode(',', $atts['mm_restaurant_tag']);
                }
            }
            $args = array(
                'post_type' => $post_type,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby'   => 'meta_value_num',
                'order' => 'ASC',
                'offset' => 0,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => $tag_type,
                        'field' => 'id',
                        'terms' => $id_tag,
                    ),
                ),
            );
            $args_product = $this->query_sort_by($args);
            $result = array();
            if ($args_product) {
                $result = array_merge($result, $args_product);
            }
            $temp = array_unique(array_column($result, 'id'));
            $result = array_intersect_key($result, $temp);
            // The Loop
            if ($result) {
                ob_start();
                $is_set_number_item_on_column = false;
                if (!empty($atts['mm_number_item_on_column']) && (count($result) > (int)$atts['mm_number_item_on_column'])) {
                    $is_set_number_item_on_column = true;
                    $result_separate = array_chunk($result, (int)$atts['mm_number_item_on_column']);
                }
                ?>
                <div data-interval data-animation data-hoverpause='1' class='template-shop avia-content-slider avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling' >
                    <div class='avia-content-slider-inner'>
                        <h3 class="av-special-heading-tag " itemprop="headline"><?php echo !empty( $atts['heading'] )? $atts['heading'] : ''; ?></h3>
                        <div class="mm-site-map-list-wrap">
                            <?php 
                                if ($is_set_number_item_on_column && is_array($result_separate) && !empty($result_separate)) { 
                                    foreach($result_separate as $result_val) {
                                        ?>
                                            <ul class="sitemap">
                                                <?php foreach($result_val as $val) { ?>
                                                    <li class="">
                                                        <a target="_blank" href="<?php echo $val['link']; ?>"><?php echo $val['title']; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php
                                    }
                                } else { 
                            ?>
                                <ul class="sitemap">
                            <?php
                                foreach ($result as $post_val) {
                                    ?>
                                        <li class="">
                                            <a target="_blank" href="<?php echo $post_val['link']; ?>"><?php echo $post_val['title']; ?></a>
                                        </li>
                                    <?php
                                }
                                ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                $output = ob_get_clean();
            } else {
                $output = 'No post type found which match your selection.';
            }
            wp_reset_query();
            return $output;
        }
        function query_sort_by($args) {
            if (!empty($args)) {
                query_posts($args);
                if (have_posts()) {
                    $arg_sitemap = array();
                    $i = 0;
                    while (have_posts()) {
                        the_post();
                        $post_id = get_the_ID();
                        $arg_sitemap[$i]['id'] = get_the_ID();
                        $arg_sitemap[$i]['title'] = get_the_title();
                        $arg_sitemap[$i]['link'] = get_permalink();
                        $arg_sitemap[$i]['class'] = implode(" ", get_post_class());
                        $i++;
                    }
                }
                wp_reset_query();
            }
            return $arg_sitemap;
        }
    }
}
//setting page
function mm_sitemap_post_type_menu() {
    add_submenu_page(
        'maui-marketing-menu',
        'MM SiteMap By Post Types',
        'MM SiteMap Post Types',
        'manage_options',
        'mm-sitemap-post-type-setting',
        'mm_sitemap_post_type_settings_page'
    );
}
function mm_sitemap_post_type_settings_page() {
    ?>
    <div class="wrap">
        <form method="post" action="options.php">
            <?php
            settings_fields( 'mm_note_post_status_settings_group' );
            do_settings_sections( 'mm-sitemap-post-type-setting' );
            submit_button();
            ?>
        </form>
        <style>
            .maui-marketing-menu_page_mm-sitemap-post-type-setting .form-table th,
            .maui-marketing-menu_page_mm-sitemap-post-type-setting .notice-warning {
                display: none;
            }
            .mm-list-post-types .mm-list-post-type {
                font-size: 16px;
            }
        </style>
    </div>
    <?php
}
function mm_sitemap_post_type_register_settings() {
    add_settings_section(
        'mm_note_post_status_settings_section',
        'Select post type to add MM Sitemap By Post Type',
        '',
        'mm-sitemap-post-type-setting'
    );
    add_settings_field(
        'mm_list_post_type_tracking',
        'Post types',
        'mm_sitemap_post_type_settings_callback',
        'mm-sitemap-post-type-setting',
        'mm_note_post_status_settings_section',
    );
    register_setting( 'mm_note_post_status_settings_group', 'mm_sitemap_post_type' );
}
function mm_sitemap_post_type_settings_callback() {
    $args = array(
        'public' => true,
    );
    $post_types      = get_post_types( $args, 'objects' );
    $post_type_value = get_option( 'mm_sitemap_post_type' );
    echo '<ul class="mm-list-post-types">';
    foreach ( $post_types as $post_type ):
        $checked = in_array( $post_type->name, (array) $post_type_value ) ? 'checked' : '';
        ?>
        <li class="mm-list-post-type">
            <input type="checkbox" name="mm_sitemap_post_type[]" value="<?= $post_type->name ?>" <?= $checked ?>> <?= $post_type->label ?>
        </li>
    <?php
    endforeach;
    echo '</ul>';
}
add_action( 'admin_menu', 'mm_sitemap_post_type_menu' );
add_action( 'admin_init', 'mm_sitemap_post_type_register_settings' );
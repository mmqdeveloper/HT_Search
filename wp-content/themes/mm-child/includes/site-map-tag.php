<?php
/**
 * Post/Page Content
 *
 * Element is in Beta and by default disabled. Todo: test with layerslider elements. currently throws error bc layerslider is only included if layerslider element is detected which is not the case with the post/page element
 */
if (!class_exists('avia_sc_site_map_tag') && class_exists('woocommerce')) {

    class avia_sc_site_map_tag extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM SiteMap Product by TAG', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-postslider.png";
            $this->config['order'] = 30;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'avia_sc_site_map_tag';
            $this->config['tooltip'] = __('Display list prouct by tag', 'avia_framework');
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
                    "name" 	=> __("Products Title", 'avia_framework' ),
                    "id" 	=> "heading",
                    'container_class' =>"avia-element-fullwidth",
                    "std" 	=> __("Product title", 'avia_framework' ),
                    "type" 	=> "input"
                ),
                array(
                    "name" => __("Which Tag?", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_tag",
                    "type" => "select",
                    "taxonomy" => "product_tag",
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

            static $count_shortcode_sitemap = 0;
            $count_shortcode_sitemap++;

            if ($page_id_sitemap_shortcode == 32408) {
                $upload_dir = wp_upload_dir();
                $data_shortcode_sitemap_dir = $upload_dir['basedir'] . '/data_shortcode_sitemap';
                wp_mkdir_p($data_shortcode_sitemap_dir);
                $file_path_data_shortcode = $data_shortcode_sitemap_dir . '/data_shortcode_sitemap.json';
                if (!file_exists($file_path_data_shortcode)) {
                    touch($file_path_data_shortcode);
                }

                $target_dir = $upload_dir['basedir'] . '/data_shortcode_sitemap/data_shortcode_sitemap.json';
                if (file_exists($target_dir)) {
                    $json_content = file_get_contents($target_dir);
                    $data_json = json_decode($json_content, true);
    
                    if ($count_shortcode_sitemap < max(array_keys($data_json[$page_id_sitemap_shortcode])) && !empty($data_json[$page_id_sitemap_shortcode][$count_shortcode_sitemap])) {
                        return $data_json[$page_id_sitemap_shortcode][$count_shortcode_sitemap];
                    }
                }
            }
            
            $atts = shortcode_atts(array(
                'heading' => '',
                'mm_tag' => '',
                'post_type' => 'product',
                'mm_number_item_on_column' => ''
            ), $atts, $this->config['shortcode']);

            extract($atts);
            $terms = array();
            if (!empty($atts['mm_tag'])) {
                $id_tag = explode(',', $atts['mm_tag']);
            }
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                // 'meta_key'  => 'filtering_priority_sitemap',
                'meta_key'  => 'filtering_priority',
                'orderby'   => 'meta_value_num',
                'order' => 'ASC',
                'offset' => 0,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                       'taxonomy' => 'product_tag',
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
                $output = 'No products found which match your selection.';
            }
            wp_reset_query();

            if (!is_admin() && $page_id_sitemap_shortcode == 32408 && file_exists($target_dir)) {
                $data_shortcode = json_encode(array(
                    $page_id_sitemap_shortcode => array(
                        $count_shortcode_sitemap => $output,
                    )
                ));

                if (empty($data_json)) {
                    file_put_contents($target_dir, $data_shortcode);
                    return;
                } else {
                    $data_json[$page_id_sitemap_shortcode][$count_shortcode_sitemap] = $output;
                    file_put_contents($target_dir, json_encode($data_json));
                    return;
                }
            }
            
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
                        //$arg_sitemap[$i]['content'] = get_the_content();
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
    
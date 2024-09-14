<?php
/**
 * Post/Page Content
 *
 * Element is in Beta and by default disabled. Todo: test with layerslider elements. currently throws error bc layerslider is only included if layerslider element is detected which is not the case with the post/page element
 */
if (!class_exists('avia_sc_site_map') && class_exists('woocommerce')) {

    class avia_sc_site_map extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM SiteMap Product', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-postslider.png";
            $this->config['order'] = 30;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'avia_sc_site_map';
            $this->config['tooltip'] = __('Display single of Product Entries', 'avia_framework');
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
                    "name" => __("Which Category?", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "categories",
                    "type" => "select",
                    "taxonomy" => "product_cat",
                    "subtype" => "cat",
                    "multiple" => 6
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
                    "name" => __("Which Badge Tag?", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_certificate",
                    "type" => "select",
                    "taxonomy" => "certificates",
                    "subtype" => "cat",
                    "multiple" => 6
                ),
                array(
                    "name" => __("Sort By Tag Name", 'avia_framework'),
                    "desc" => __("Click Which Tag? above to order by Tag", 'avia_framework'),
                    "id" => "sort_tag_name",
                    "type" => "input",
                    "subtype" => "",
                ),
                array(
                    "name" => __("Sort By Tag", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "sort_tag",
                    "type" => "hidden",
                    "subtype" => "",
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
                'mm_certificate'=>'',
                'taxonomy' => 'product_cat',
                'post_type' => 'product',
                'sort_tag' => '',
                'categories' => '',
            ), $atts, $this->config['shortcode']);

            extract($atts);
            $terms = array();
            if (!empty($atts['categories'])) {
                //get the product categories
                $terms = explode(',', $atts['categories']);
            }
            $ids_current = get_the_ID();
            //if we find no terms for the taxonomy fetch all taxonomy terms
            if (empty($terms[0]) || is_null($terms[0]) || $terms[0] === "null") {
                $terms = array();
                /*$allTax = get_terms($atts['taxonomy']);
                foreach ($allTax as $tax) {
                    $terms[] = $tax->term_id;
                }*/
            }
            $terms_certificate ='';
            if (!empty($atts['mm_certificate'])) {
                $terms_certificate = explode(',', $atts['mm_certificate']);
            }
            if (!empty($atts['sort_tag'])) {
                //get the product categories
                $id_tag_sort = explode(',', $atts['sort_tag']);
            }
            if (empty($id_tag_sort[0]) || is_null($id_tag_sort[0]) || $id_tag_sort[0] === "null") {
                $tags = array();
                /*$allTag = get_terms('product_tag');
                foreach ($allTag as $itemtag) {
                    $tags[] = $itemtag->term_id;
                }*/
            }
            $term_arr = '';
            if (!empty($terms)) {
                $term_arr = array(
                    'taxonomy' => $atts['taxonomy'],
                    'field' => 'id',
                    'terms' => $terms,
                );
            }
            $certificate_arr = '';
            if (!empty($atts['mm_certificate'])) {
                $certificate_arr = array(
                    'taxonomy' => 'certificates',
                    'field' => 'id',
                    'terms' => $atts['mm_certificate'],
                    'operator' => 'EXISTS'
                );
            }
            if (!empty($id_tag_sort)) {
                $id_tag_sort_arr = array(
                    'taxonomy' => 'product_tag',
                    'field' => 'id',
                    'terms' => $id_tag_sort,
                );
            } 
            if(!empty($term_arr)){
                $tax_query_featured[] = $term_arr;
            }
            if(!empty($id_tag_sort_arr)){
                $tax_query_featured[] = $id_tag_sort_arr;
            }
            if(!empty($certificate_arr)){
                $tax_query_featured[] = $certificate_arr;
            }
            $tax_query_featured[] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'featured',
                );

            $args_featured = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'orderby' => 'menu_order title',
                'order' => 'ASC',
                'offset' => 0,
                'posts_per_page' => -1,
                'tax_query' => $tax_query_featured
            );
            $args_featureds = $this->query_sort_by($args_featured);

            $post_not_in = wc_get_featured_product_ids();
            array_push($post_not_in, $ids_current);

            $result = array();
            if ($args_featureds) {

                $result = array_merge($result, $args_featureds);
            }
            if ($id_tag_sort) {
                //foreach ($id_tag_sort as $key => $value) {
                    if (!empty($terms)) {
                        $relation = 'AND';
                    } else {
                        $relation = 'OR';
                    }
                    $relation = 'AND';
                    if(!empty($term_arr)){
                        $tax_query = array(
                            $term_arr,
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'id',
                                'terms' => $id_tag_sort,
                            ),
                            $certificate_arr
                        );
                    }else{
                        $tax_query = array(
                            array(
                                'taxonomy' => 'product_tag',
                                'field' => 'id',
                                'terms' => $id_tag_sort,
                            ),
                            $certificate_arr
                        );
                    }
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'meta_key'  => 'filtering_priority',
                        'orderby'   => 'meta_value_num',
                        'order' => 'ASC',
                        'offset' => 0,
                        'posts_per_page' => -1,
                        'tax_query' => $tax_query,
                        'post__not_in' => $post_not_in
                    );
                    $args_product = $this->query_sort_by($args);

                    if ($args_product) {
                        $result = array_merge($result, $args_product);
                    }
                //}
            } else {
                if (!empty($terms) && !empty($tags)) {
                    $relation = 'AND';
                } else {
                    $relation = 'OR';
                }
                $relation = 'AND';
                $tax_query = array();
                if(!empty($tags)){
                    $tax_query[] = array(
                                'taxonomy' => 'product_tag',
                                'field' => 'id',
                                'terms' => $tags,
                            );
                }
                if(!empty($term_arr)){
                    $tax_query[] = $term_arr;
                }
                if(!empty($certificate_arr)){
                    $tax_query[] = $certificate_arr;
                }
                
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'menu_order title',
                    'order' => 'ASC',
                    'offset' => 0,
                    'posts_per_page' => -1,
                    'tax_query' => $tax_query,
                    'post__not_in' => $post_not_in
                );

                $args_product = $this->query_sort_by($args);

                if ($args_product) {
                    $result = array_merge($result, $args_product);
                }
            }

            //unique product
            $temp = array_unique(array_column($result, 'id'));
            $result = array_intersect_key($result, $temp);

            // The Loop
            if ($result) {
                ob_start();
                ?>
                <div data-interval data-animation data-hoverpause='1' class='template-shop avia-content-slider avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling' >
                    <div class='avia-content-slider-inner'>
                        <h3 class="av-special-heading-tag " itemprop="headline"><?php echo !empty( $atts['heading'] )? $atts['heading'] : ''; ?></h3>
                        <ul class="sitemap">
                            <?php
                            $i = 0;
                            foreach ($result as $products_key => $products_val) {
                                $i++;
                                $post_id = $products_val['id'];
                                ?>
                                <li class="">
                                    <a target="_blank" href="<?php echo get_permalink($post_id) ?>"><?php echo get_the_title($post_id); ?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
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
                        $arg_sitemap[$i]['id'] = get_the_ID();
                        $i++;
                    }
                }
                wp_reset_query();
            }
            return $arg_sitemap;
        }

    }

}
    
<?php
/**
 * Post/Page Content
 *
 * Element is in Beta and by default disabled. Todo: test with layerslider elements. currently throws error bc layerslider is only included if layerslider element is detected which is not the case with the post/page element
 */
if (!class_exists('avia_sc_mm_faq_pp') && class_exists('woocommerce')) {

    class avia_sc_mm_faq_pp extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM FAQ', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-accordion.png";
            $this->config['order'] = 30;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'avia_sc_mm_faq_pp';
            $this->config['tooltip'] = __('Maui Marketing MM Faq', 'avia_framework');
            //$this->config['drag-level'] = 3;
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
                    "name" 	=> __("Behavior", 'avia_framework' ),
                    "desc" 	=> __("Should only one toggle be active at a time and the others be hidden or can multiple toggles be open at the same time?", 'avia_framework' ),
                    "id" 	=> "mode",
                    "type" 	=> "select",
                    "std" 	=> "accordion",
                    "subtype" => array( __('Only one toggle open at a time (Accordion Mode)', 'avia_framework' ) =>'accordion', __("Multiple toggles open allowed (Toggle Mode)", 'avia_framework' ) => 'toggle')
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
            global $avia_config, $post;
            $mmtagfaqs = get_post_meta($post->ID, 'mmfaqtags', true);

            $atts = shortcode_atts(array(
                'mm_tag' => '',
                'post_type' => 'mmfaq',
                'mode' => '',
                'mmfaq_tag' => $mmtagfaqs
            ), $atts, $this->config['shortcode']);

            extract($atts);

            if($mode == 'accordion') $addClass = 'toggle_close_all ';

            if (!empty($atts['categories'])) {
                //get the product categories
                $terms = explode(',', $atts['categories']);
            }
            $ids_current = get_the_ID();
            //if we find no terms for the taxonomy fetch all taxonomy terms
            if (empty($terms[0]) || is_null($terms[0]) || $terms[0] === "null") {
                $terms = array();
                $allTax = get_terms($atts['taxonomy']);
                foreach ($allTax as $tax) {
                    $terms[] = $tax->term_id;
                }
            }

            if (!empty($atts['sort_tag'])) {
                //get the product categories
                $id_tag_sort = explode(',', $atts['sort_tag']);
            }
            if (empty($id_tag_sort[0]) || is_null($id_tag_sort[0]) || $id_tag_sort[0] === "null") {
                $tags = array();
                $allTag = get_terms('mmfaq_tag');
                foreach ($allTag as $itemtag) {
                    $tags[] = $itemtag->term_id;
                }
            }
            if (!empty($terms)) {
                $term_arr = array(
                    'taxonomy' => $atts['taxonomy'],
                    'field' => 'id',
                    'terms' => $terms,
                );
            }
            if (!empty($id_tag_sort)) {
                $id_tag_sort_arr = array(
                    'taxonomy' => 'mmfaq_tag',
                    'field' => 'id',
                    'terms' => $id_tag_sort,
                );
            } else {
                $id_tag_sort_arr = array(
                    'taxonomy' => 'mmfaq_tag',
                    'field' => 'id',
                    'terms' => $tags,
                );
            }
            $tax_query_featured = array(
                'relation' => 'AND',
                $term_arr,
                $id_tag_sort_arr,
                array(
                    'taxonomy' => 'categories',
                    'field' => 'name',
                    'terms' => 'featured',
                ),
            );

            $args_featured = array(
                'post_type' => 'mmfaq',
                'post_status' => 'publish',
                'order' => 'ASC',
                'offset' => 0,
                'posts_per_page' => -1,
                //'tax_query' => $tax_query_featured
            );
            $args_featureds = $this->query_sort_by($args_featured);

            $result = array();
            if ($args_featureds) {
                $result = array_merge($result, $args_featureds);
            }

            // The Loop
            if ($result) {
                ob_start();

                ?>
                <div class="togglecontainer  <?php echo $addClass .' '. $meta['el_class']; ?>">
                    <?php
                    $i = 1;
                    foreach ( $result as $mmfaq_key => $mmfaq_val ) {
                        $id = (string)$mmfaq_val["id"];

                        if ( strpos($mmfaq_tag, $id) !== false ) {

                            ?>
                            <section
                                class="av_toggle_section <?php echo(!empty($mmfaq_val["class"]) ? $mmfaq_val["class"] : ""); ?>"
                                itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
                                <div class="single_toggle" data-tags="{All} ">
                                    <p data-fake-id="#toggle-id-<?php echo $i; ?>" class="toggler"
                                       itemprop="headline"><?php echo(!empty($mmfaq_val["title"]) ? $mmfaq_val["title"] : ""); ?>
                                        <span class="toggle_icon">
                                    <span class="vert_icon"></span>
                                    <span class="hor_icon"></span>
                                </span>
                                    </p>
                                    <div id="toggle-id-<?php echo $i; ?>-container" class="toggle_wrap" style="">
                                        <div class="toggle_content invers-color " itemprop="text">
                                            <p><?php echo(!empty($mmfaq_val["content"]) ? $mmfaq_val["content"] : ""); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <?php
                            $i++;
                        }
                    }
                    ?>

                </div>
                <?php
                $output = ob_get_clean();
            } else {
                $output = 'No MM FAQ found which match your selection.';
            }
            return $output;
        }

        function query_sort_by($args) {

            if (!empty($args)) {

                query_posts($args);

                if (have_posts()) {

                    $arg_mmfaq = array();

                    $i = 0;
                    while (have_posts()) {
                        the_post();
                        $post_id = get_the_ID();
                        $arg_mmfaq[$i]['id'] = get_the_ID();
                        $arg_mmfaq[$i]['title'] = get_the_title();
                        $arg_mmfaq[$i]['content'] = get_the_content();
                        $arg_mmfaq[$i]['class'] = implode(" ", get_post_class());
                        $i++;
                    }
                }

            }
            return $arg_mmfaq;
        }

    }

}

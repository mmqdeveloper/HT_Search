<?php
/**
 * Post/Page Content
 *
 * Element is in Beta and by default disabled. Todo: test with layerslider elements. currently throws error bc layerslider is only included if layerslider element is detected which is not the case with the post/page element
 */
if (!class_exists('avia_sc_mm_faq_post') && class_exists('woocommerce')) {

    class avia_sc_mm_faq_post extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM FAQ', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-accordion.png";
            $this->config['order'] = 30;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'avia_sc_mm_faq_post';
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
                    "name" => __("Entry Number", 'avia_framework'),
                    "desc" => __("How many items should be displayed?", 'avia_framework'),
                    "id" => "items",
                    "type" => "select",
                    "std" => "-1",
                    "subtype" => AviaHtmlHelper::number_array(1, 100, 1, array('All' => '-1'))
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
            $post_id = (int) $post->ID;
            $post_title = get_the_title($post_id);

            ob_start();
            $atts = shortcode_atts(array(
                'mm_tag' => '',
                'post_type' => 'mmfaq',
                'mode' => '',
                'items' =>'-1',
                'post_id' => $post_id,
            ), $atts, $this->config['shortcode']);

            extract($atts);

            if($mode == 'accordion') $addClass = 'toggle_close_all ';

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
            wp_reset_query();

            // The Loop
            if ($result) {
                ob_start();

                ?>
                <div class="togglecontainer  <?php echo $addClass .' '. $meta['el_class']; ?>">
                    <?php
                    $i = 1;
                    foreach ( $result as $mmfaq_key => $mmfaq_val ) {
                        $mmfaqused_id = get_post_meta( $mmfaq_val['id'], 'mmfaqused_id', true);
                        $mm_id = explode(",", $mmfaqused_id );
                        $custom_post_data = get_post_meta( 1, 'wp_mmfaq_metabox_allow_post', true);
                        if (!empty($custom_post_data)) {
                            $posts_from_db = unserialize($custom_post_data);
                        }

                        if ( in_array( $post_id, $mm_id ) && in_array( get_post_type(), $posts_from_db ) ) {
                            ?>
                            <section
                                    class="av_toggle_section <?php if($items < $i && $items!='-1') echo 'hide-faq-item';?> <?php echo(!empty($mmfaq_val["class"]) ? $mmfaq_val["class"] : ""); ?>"
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
                    if($items!='-1' && $items < $i){
                        ?>
                        <div class="avia-button-wrap avia-button-center  avia-builder-el-6  el_after_av_textblock  el_before_av_hr  ">
                            <a class="faq-readmore avia-button   avia-icon_select-yes-left-icon avia-color-theme-color avia-size-large avia-position-center " href="#" style="margin-top:40px;" >
                                <span class="avia_iconbox_title">LOAD MORE</span>
                            </a>
                        </div>
                    <?php
                        //echo '<a class="faq-readmore" href="#">Load more</a>';
                    }
                    ?>

                </div>
                <?php
                $output = ob_get_clean();
            } else {
                $output = 'No MM FAQ found which match your selection.';
            }
            wp_reset_query();
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

<?php

/**
 * MM Review Star Bar
 * Shortcode which creates a text element wrapped in a div 
 * Ben Lee 
 * - Lightbox with full size and disable lightbox for mobile and small screen
 * 
 */
if (!class_exists('avia_review_star_bar')) {

    class avia_review_star_bar extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM Review Star Bar', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-hr.png";
            $this->config['order'] = 100;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'av_eview_star_bar';
            $this->config['tooltip'] = __('Display the "Review Star Bar" for the current product', 'avia_framework');
            $this->config['drag-level'] = 3;
            $this->config['tinyMCE'] = array('disable' => "true");
            $this->config['posttype'] = array('product', __('This element can only be used on single product pages', 'avia_framework'));
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
                    "name" => __("Review Star Bar Settings", 'avia_framework'),
                    'nodescription' => true
                ),
                array(
                    "name" => __("Caption Text", 'avia_framework'),
                    "desc" => __("Text review", 'avia_framework'),
                    "id" => "text_review",
                    "type" => "input",
                    "std" => "",
                ),
                array(
                    "type" => "close_div",
                    'nodescription' => true
                )
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
            $params['innerHtml'] = "<img src='" . $this->config['icon'] . "' title='" . $this->config['name'] . "' style='position: unset;margin-bottom: -20px;'/>";
            $params['innerHtml'] .= "<div class='avia-element-label' style='display: block;'>" . $this->config['name'] . "</div>";
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
            $output = "";
            $class = "";
            $alt = "";
            $title = "";
            $atts = shortcode_atts(
                    array(
                'text_review' => ''
                    ), $atts, $this->config['shortcode']);

            extract($atts);

            global $post;
            $post_id = $post->ID;
            $bookable_product = new WC_Product_Booking($post_id);
            $product_resources  = $bookable_product->get_resource_ids( 'edit' );
            $output_options = '';
            $first_option = '';
            foreach ( $product_resources as $resource_id ) {
                $mm_booking_location = get_post_meta($resource_id, '_wc_booking_location', true);
                $mm_booking_location_link = get_post_meta($resource_id, '_wc_booking_location_link', true);
                $mm_booking_location_name = "";
                if($mm_booking_location){
                    
                    if($mm_booking_location_link){
                        $mm_booking_location_name = '<a href="' . $mm_booking_location_link . '">' . $mm_booking_location . '</a>';
                    }
                    if(empty($first_option)){
                        $first_option = $mm_booking_location_name;
                    }
                    $output_options .= '<li data-location="' . $resource_id . '" >' . ($mm_booking_location_name ? $mm_booking_location_name : $mm_booking_location ) . '</li>';
                    
                }
            }
            ob_start();
            ?>
            <div class="hr hr-custom  avia-builder-el-6  el_after_av_heading  el_mm_av_review_star_bar  hr-center hr-icon-yes">
                <span class="hr-mm-star">
                    <?php echo do_shortcode('[wp_schema_pro_rating_shortcode]');?>
                </span>
            </div>
            <div class="mm-hr-product "><span class="mm-hr-inner"></span><span class="mm-hr-icon-orange"></span><span class="mm-hr-inner"></span></div>
            <?php
            $output = ob_get_clean();

            return $output;
        }

    }

}

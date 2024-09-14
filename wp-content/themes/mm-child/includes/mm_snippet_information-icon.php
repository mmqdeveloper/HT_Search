<?php

/**
 * MM Review Star Bar
 * Shortcode which creates a text element wrapped in a div 
 * Ben Lee 
 * - Lightbox with full size and disable lightbox for mobile and small screen
 * 
 */
if (!class_exists('mm_snippet_information')) {

    class mm_snippet_information extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM Snippet Information - Icon', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-accordion.png";
            $this->config['order'] = 100;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'mm_snippet_information';
            $this->config['tooltip'] = __('Display the "Snippet Information - Icon" for the current product', 'avia_framework');
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
                    "name" => __("Snippet Information - Icon Settings", 'avia_framework'),
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
            $params['innerHtml'] = "<img src='" . $this->config['icon'] . "' title='" . $this->config['name'] . "' style='position: unset;'/>";
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
            $out_style = '';
            $output_resource_default = "";
            foreach ( $product_resources as $key => $resource_id ) {
                // $mm_booking_location = get_post_meta($resource_id, '_wc_booking_location', true);
                // $mm_booking_location_link = get_post_meta($resource_id, '_wc_booking_location_link', true);
                
                $container_class = '';
                if($key > 0){
                    $container_class .=' mm-disable';
                }
                $mm_resource_age = get_post_meta($resource_id, '_mm_resource_age', true);
                $mm_duration = get_post_meta($resource_id, '_mm_resource_duration', true);
                $mm_duration_unit = get_post_meta($resource_id, '_mm_resource_duration_unit', true);
                $mm_booking_location = get_post_meta($resource_id, '_wc_booking_location', true);

                if($mm_resource_age){
                    $output_resource_default .= '<li class="mm-item-snippet-information' . $container_class . '" data-resource="' . $resource_id . '">
                        <div class="mm-icon-si icon-si-age"></div>
                        <div class="mm-items-content">
                            <label for="age">Age</label>  
                            <div class="mm-si-content">' . $mm_resource_age . '</div>
                        </div>
                    </li>';
                }
                if($mm_duration){
                    $output_resource_default .= '<li class="mm-item-snippet-information' . $container_class . '" data-resource="' . $resource_id . '">
                        <div class="mm-icon-si icon-si-duration"></div>
                        <div class="mm-items-content">
                            <label for="duration">Duration</label>
                            <div class="mm-si-content">' . $mm_duration . '-' . $mm_duration_unit . '</div>
                        </div>
                    </li>';
                }
                if($mm_booking_location){
                    $output_resource_default .= '<li class="mm-item-snippet-information' . $container_class . '" data-resource="' . $resource_id . '">
                        <div class="mm-icon-si icon-si-location"></div>
                        <div class="mm-items-content">
                            <label for="location">Location</label>  
                            <div class="mm-si-content">' . $mm_booking_location . '</div>
                        </div>
                    </li>';
                }
                $mm_si_number = get_post_meta($resource_id, 'snippet_information', true);
                if($mm_si_number){
                    for( $i = 0; $i < $mm_si_number; $i++ ):
                        $mm_si_icon             = get_post_meta( $resource_id, 'snippet_information_' . $i . '_icon', true );
                        $mm_si_content_default  = get_post_meta( $resource_id, 'snippet_information_' . $i . '_content_default', true );
                        $mm_si_content_title    = get_post_meta( $resource_id, 'snippet_information_' . $i . '_content_title', true );
                        $mm_si_content_des      = get_post_meta( $resource_id, 'snippet_information_' . $i . '_content_description', true );
                        if($mm_si_icon){
                            $src_text = wp_get_attachment_url( $mm_si_icon );
                            if($src_text){
                                $out_style .= '#top.mm-custom-builder #mm_bookings_snippet_information .mm-item-snippet-information .icon-si-' . $resource_id . '-' . $i . ':before {
                                    background-image: url("' .  $src_text . '");
                                }';
                            }
                        }
                        $mm_si_content = 'mm-si-content';
                        $con_class = $container_class;
                        if(strlen($mm_si_content_des) > 75){
                            $mm_si_content .= ' mm-more-content';
                            if(isset($mm_si_content_default[0]) && $mm_si_content_default[0] == 'show'){
                                $con_class .= ' mm-icon-minus';
                            }else{
                                $con_class .= ' mm-icon-dropdown';
                            }
                            if(isset($mm_si_content_default[1]) && $mm_si_content_default[1] == 'show-mobile'){
                                $con_class .= ' mm-icon-minus-mobile';
                            }
                        }
                        
                        $output_options .= '<li class="mm-item-snippet-information' . $con_class . '" data-resource="' . $resource_id . '">
                                <div class="mm-icon-si icon-si-' . $resource_id . '-' . $i . '"></div>
                                <div class="mm-items-content">
                                    <label for="' . strtolower($mm_si_content_title) . '">' . $mm_si_content_title . '</label>  
                                    <div class="' . $mm_si_content . '"><p>' . wpautop($mm_si_content_des) . '</p></div>
                                </div>
                            </li>';
                    endfor;
                }

            }
            $output_total_price = 0;
            ob_start();
            
            if ($bookable_product->has_persons() ) {
                $price = 0;
                $person_defaults = get_post_meta($post_id, 'mm_person_default',true);
                $person_types = reset($bookable_product->get_person_types());
                if($person_types){
                    $price = $person_types->get_block_cost();
                }
                // $person_min = get_post_meta( $post_id, '_wc_booking_min_persons_group', true);
                $person_default = 1;
                if (!empty($person_defaults) && !empty(unserialize($person_defaults))) {
                    $dataArray = unserialize($person_defaults);
                    if(isset($dataArray)){
                        $person_default = reset($dataArray);
                    }
                }

                $item_amount = $price * $person_default;
                $product_tag = get_the_terms($post_id, 'product_tag');
                $list_tag_id = array();
                foreach ($product_tag as $term) {
                    $list_tag_id[] = $term->term_id;
                }
                $woo_fee = array();
                $args_fee = array("post_type" => "wc_conditional_fee", "post_status" => "publish","posts_per_page"   => -1);
                $query_fee= get_posts( $args_fee );
                $woo_fee_default = 0;
                // echo "<pre>";
                // var_dump($query_fee);
                // echo "</pre>";
                foreach ($query_fee as $fee) {
                    $fees_id = $fee->ID;
                    $get_condition_array = get_post_meta( $fees_id, 'product_fees_metabox', true );
                    $fee_settings_product_cost = get_post_meta( $fees_id, 'fee_settings_product_cost', true );
                    $fee_settings_select_fee_type = get_post_meta( $fees_id, 'fee_settings_select_fee_type', true );
                    $product_fees_per_person = get_post_meta( $fees_id, 'product_fees_per_person', true );
                    $fee_settings_status = get_post_meta( $fees_id, 'fee_settings_status', true );
                    if ($fee_settings_status =='on' && !empty($get_condition_array) ) {
                        if($fee_settings_select_fee_type =='percentage'){
                            $fee_item_amount = $item_amount*($fee_settings_product_cost/100);
                        }else{
                            $fee_item_amount = $fee_settings_product_cost;
                            if($product_fees_per_person == 'on'){
                                $fee_item_amount = $fee_item_amount * $person_default;
                            }
                        }
                        $exclude_product_id= false;
                        foreach ( $get_condition_array as $key => $value ) {
                            if ( array_search( 'product', $value, true ) && $value['product_fees_conditions_is'] =='not_in' ) {
                               $exclude_product_id = true;
                                break;
                            }
                        }
                        if(!$exclude_product_id){
                            foreach ( $get_condition_array as $key => $value ) {
                                if ( array_search( 'product', $value, true ) && $value['product_fees_conditions_is'] =='is_equal_to' ) {
                                    $list_product_fee = $value['product_fees_conditions_values'];
                                    if(!empty($list_product_fee)){
                                        if(in_array($post_id, $list_product_fee)){
                                            $woo_fee_default += $fee_item_amount;
                                            $woo_fee[] = array("fee_id"=>$fees_id ,"type"=>$fee_settings_select_fee_type,"per_person"=>$product_fees_per_person,"fee"=>$fee_settings_product_cost);
                                            break;
                                        }
                                    }
                                }
                                if ( array_search( 'tag', $value, true ) && $value['product_fees_conditions_is'] =='is_equal_to' ) {
                                    $list_tag_fee = $value['product_fees_conditions_values'];
                                    $array_intersect_tag=array_intersect($list_tag_id,$list_tag_fee);
                                    if(!empty($array_intersect_tag)){
                                        $woo_fee_default += $fee_item_amount;
                                        $woo_fee[] = array("fee_id"=>$fees_id ,"type"=>$fee_settings_select_fee_type,"per_person"=>$product_fees_per_person,"fee"=>$fee_settings_product_cost);
                                        break;
                                    }
                                }
                            }
                        }

                    }
                }
                if(empty($person_default)){
                    $person_default = 1;
                }
                $price_tax = ($price * $person_default) * 0.095;
                $output_total_price = $price * $person_default + round($price_tax, 2) + round($woo_fee_default, 2); 
                
            }
            ?>
            <?php if($output_total_price){ ?>
                
                <div name="mm_bookings_total_price" id="mm_bookings_total_price" data-fee='<?php echo json_encode($woo_fee);?>'>
                    <p>Total Price with Taxes & Fees: <span class="price"><?php echo '$' . round($output_total_price) . ' USD' ;?></span></p>

                </div>
            <?php } ?>
            <?php if($output_resource_default ){ ?>
                <ul name="mm_bookings_snippet_information_default" id="mm_bookings_snippet_information_default">
                    <?php echo $output_resource_default;?>
                </ul>
            <?php } ?>
            <?php if($output_options ){ ?>
                <ul name="mm_bookings_snippet_information" id="mm_bookings_snippet_information">
                    <?php echo $output_options;?>
                </ul>
            <?php } ?>
            <?php if($out_style){ ?>
                <style>
                    <?php echo $out_style;?>
                </style>
            <?php } ?>
            <?php
            $output = ob_get_clean();

            return $output;
        }

    }

}

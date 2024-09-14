<?php
/**
 * Product Purchase Button
 * 
 * Display the "Add to cart" button for the current product
 */
if (!defined('ABSPATH')) {
    exit;
}    // Exit if accessed directly


if (!class_exists('woocommerce')) {
    add_shortcode('mm_bookingbox_product_button', 'avia_please_install_woo');
    return;
}

if (!class_exists('mm_bookingbox_product_button')) {

    class mm_bookingbox_product_button extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['self_closing'] = 'yes';

            $this->config['name'] = __('MM Booking Box', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-button.png";
            $this->config['order'] = 20;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'mm_bookingbox_product_button';
            $this->config['tooltip'] = __('Display the "Add to cart" button for the current product', 'avia_framework');
            $this->config['drag-level'] = 3;
            $this->config['tinyMCE'] = array('disable' => "true");
            $this->config['posttype'] = array('product', __('This element can only be used on single product pages', 'avia_framework'));
        }

        function popup_elements() {
            $this->elements = array(
                array(
                    "type" => "tab_container", 'nodescription' => true
                ),
                array(
                    "name" => __("Title", 'avia_framework'),
                    "desc" => '',
                    "id" => "book_title",
                    "type" => "input",
                    "std" => "BOOK YOUR TOUR",
                ),
                array(
                    "name" => __("Bookingbox option", 'avia_framework'),
                    "desc" => __("", 'avia_framework'),
                    "id" => "booking_option",
                    "type" => "select",
                    "std" => "1",
                    "subtype" => array(__('Use Woocommerce', 'avia_framework') => '1',
                        __('Use Fareharbor', 'avia_framework') => '2'
                    )
                ),
                /* array(
                  "name" => __("Fareharbox Title", 'avia_framework'),
                  "desc" => '',
                  "id" => "fareharbox_book_title",
                  "type" => "input",
                  "required" => array('booking_option', 'equals', '2'),
                  "std" => "BOOK YOUR TOUR",
                  ), */
                array(
                    "name" => __("Fareharbor Link", 'avia_framework'),
                    "desc" => '',
                    "id" => "fareharbox_link",
                    "type" => "input",
                    "required" => array('booking_option', 'equals', '2'),
                    "std" => "",
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

            $params['innerHtml'] .= "<div class='avia-flex-element'>";
            $params['innerHtml'] .= __('Display the &quot;Add to cart&quot; button including prices and variations but no product description.', 'avia_framework');
            $params['innerHtml'] .= "</div>";

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
            $meta['el_class'];
            $atts = shortcode_atts(array(
                'book_title' => 'BOOK YOUR TOUR',
                'booking_option' => '1',
                'fareharbox_link' => '',
                    ), $atts, $this->config['shortcode']);
            global $woocommerce, $product;
            if (!is_object($woocommerce) || !is_object($woocommerce->query) || empty($product) || is_admin())
                return;
            if ($atts['booking_option'] == '1') {
                /**
                 * @since WC 3.0
                 */
                $wc_structured_data = isset(WC()->structured_data) ? WC()->structured_data : null;

                /**
                 *  Remove default WC actions
                 */
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

                // produces an endless loop because $wc_structured_data uses 'content' filter and do_shortcode !!
                if (!is_null($wc_structured_data)) {
                    remove_action('woocommerce_single_product_summary', array($wc_structured_data, 'generate_product_data'), 60);
                }

                // $product = wc_get_product();
                $product_id = $product->get_id();
                $flash_sale = '';
                if (is_object_in_term($product_id, 'product_tag', 'deal')) {
                    $flash_sale = 'mm-flashsale';
                }
                $output .= "<div class='av-woo-purchase-button " . $meta['el_class'] . " ".$flash_sale."'>";
                
                /**
                 * Fix for plugin German Market that outputs the price (not a clean solution but easier to maintain). Can alos be placed in shortcode.css.
                 */
                $output .= '<style>';
                $output .= '#top .av-woo-purchase-button > div > p.price {display: none;}';
                $output .= '</style>';

                $output .= '<p class="price">' . $product->get_price_html() . '</p>';

                ob_start();
                //  fix a problem with SEO plugin
                if( function_exists( 'wc_clear_notices' ) )
                {
                    wc_clear_notices();
                }

                /**
                 * hooked by: add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
                 */
                $output .= '<p class="book-title">' . $atts['book_title'] . '</p>';
                if(!empty($flash_sale)){
                    $day_sale = '4';
                    if (is_object_in_term($product_id, 'product_tag', 'package') || is_object_in_term($product_id, 'product_tag', 'packages')) {
                        $day_sale = '14';
                    }
                    $output .= '<span class="flash-sale-description">Book a tour start date within <strong>the next '.$day_sale.' days</strong> and you will <strong>receive 5% off automatically</strong>. Book your vacation package and travel <strong>within 7 days</strong> for great discounts.</span>';
                }
                $output .= '<div class="mm-hr-product"><span class="mm-hr-inner"></span><span class="mm-hr-icon-booking"></span><span class="mm-hr-inner"></span></div>';
                do_action('woocommerce_single_product_summary');

                $output .= ob_get_clean();

                $output .= "</div>";

                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
                if (!is_null($wc_structured_data)) {
                    add_action('woocommerce_single_product_summary', array($wc_structured_data, 'generate_product_data'), 60);
                }
                wp_reset_query();
            }
            if ($atts['booking_option'] == '2') {
                $idproduct_mm = $product->get_id();
                if($atts['fareharbox_link']==''){
                    $atts['fareharbox_link'] = get_post_meta($idproduct_mm, 'enable_fareharbor_link', true);
                }
                $get_bookingbox_html = '';
                $upload_dir = wp_upload_dir();
                $file_name = $idproduct_mm.'_bookingbox_option_2.json';
                $json_file = $upload_dir['basedir'] . '/mm-bookingbox/' . $file_name;
                if (file_exists($json_file)) {
                    $file_content = file_get_contents($json_file, true);
                    $file_content = json_decode($file_content, true);
                    if(!empty($file_content)){
                        $get_bookingbox_html = $file_content;
                    }
                }
                if(!empty($get_bookingbox_html)){
                    $output.= $get_bookingbox_html;
                }else{
                ob_start();
                ?>
                <div class="booking_form_sidebar booking_box_fareharbox" >
                    <div class="mm_booking_warrap">
                        <div class="mm_booking_container">
                            <p class="book_title"><?php echo $atts['book_title']; ?></p>
                            <div class="mm-hr-product"><span class="mm-hr-inner"></span><span class="mm-hr-icon-booking"></span><span class="mm-hr-inner"></span></div>
                            <?php
                            if ($idproduct_mm == 32265 || $idproduct_mm == 32899 || $idproduct_mm == 32913 || $idproduct_mm == 32927 || $idproduct_mm == 32947 || $idproduct_mm == 32994 || $idproduct_mm == 33008 || $idproduct_mm == 33032 || $idproduct_mm == 32960) {
                                $per_type = "per person";
                            } elseif ($idproduct_mm == 27974) {
                                $per_type = "per boat";
                            } elseif ($idproduct_mm == 1120 || $idproduct_mm == 34517 || $idproduct_mm == 101441) {
                                $per_type = "per vehicle";
                            } elseif ($idproduct_mm == 28279 || $idproduct_mm == 191840) {
                                $per_type = "per group";
                            } else {
                                $per_type = "per adult";
                            }
                            $count_resource = 0;
                            if ( $product->is_type( 'booking' ) ) {
                            if ($product->has_resources() || $product->is_resource_assignment_type('customer')) {
                                $resources = $product->get_resources();
                                $resource_label = $product->get_resource_label();
                                foreach ($resources as $resource) {
                                    $count_resource++;
                                    if ($resource->get_base_cost()) {
                                        $resource_costs = $resource->get_base_cost() + $product->get_display_cost();
                                    } elseif ($resource->get_block_cost()) {
                                        $resource_costs = $resource->get_block_cost() + $product->get_display_cost();
                                    } else {
                                        $resource_costs = $product->get_display_cost();
                                    }
                                    if ($resource->get_base_cost()) {
                                        $resource_price = $resource->get_base_cost();
                                    } elseif ($resource->get_block_cost()) {
                                        $resource_price = $resource->get_block_cost();
                                    } else
                                        $resource_price = 0;
                                    ?>
                                    <div class="resource-item">
                                        <p class="title-resource"><?php echo $resource->post_title; ?><br><span>Starting at <span class="price-starting"><?php echo wc_price($resource_costs); ?></span> <?php echo $per_type; ?></span></p>
                                        <?php
                                        if ($product->has_persons()) {
                                            if ($product->has_person_types()) {
                                                ?>
                                                <ul class="tour-price">
                                                    <?php
                                                    $person_types = $product->get_person_types();
                                                    foreach ($person_types as $person_type) {
                                                        $person_title = $person_type->get_name();
                                                        $person_descrition = $person_type->get_description();
                                                        $person_basecost = $person_type->get_cost();
                                                        $person_blockcost = $person_type->get_block_cost();
                                                        if (isset($person_basecost) && $person_basecost != 0) {
                                                            $person_costs = $person_basecost;
                                                        } elseif (isset($person_blockcost) && $person_blockcost != 0) {
                                                            $person_costs = $person_blockcost;
                                                        } else {
                                                            $person_costs = 0;
                                                        }
                                                        $person_resource_price = $resource_price + $person_costs;
                                                        if ($person_resource_price != 0) {
                                                            $person_resource_price = wc_price($person_resource_price);
                                                            $tax = '+&nbsp;tax &amp; fees';
                                                        } else {
                                                            $person_resource_price = 'FREE';
                                                            $tax = '';
                                                        }
                                                        ?>
                                                        <li><span class="title"><strong><?php echo $person_title; ?></strong></br> <?php echo $person_descrition; ?></span>
                                                            <span class="price"><strong><?php echo $person_resource_price; ?></strong> <?php echo $tax; ?></span></li>
                                                        <?php
                                                    }
                                                    ?>

                                                </ul>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                            }}
                            ?>
                            <div id="tours_book_form"><aside>
                                    <div class="tours_form_warrap">
                                        <div class="booking_hps">
                                            <div id="book_red">
                                                <?php
                                                $show_booknow_link = true;
                                                if (strlen(strstr($atts['fareharbox_link'], '/script/')) > 0) {
                                                    $show_booknow_link = false;
                                                    ?>
                                                    <script src="<?php echo $atts['fareharbox_link']; ?>"></script>
                                                    <?php
                                                }

                                                ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </aside></div>
                        </div>
                    </div>
                    <?php if ($show_booknow_link) { ?>
                        <div class="wrap-btn-fareharbor"><a target="_blank" rel="nofollow"  class="btn-fareharbor" href="<?php echo $atts['fareharbox_link']; ?>">BOOK NOW</a></div>
                    <?php } ?>
                </div>

                <?php
                $output .= ob_get_clean();
                file_put_contents($json_file, json_encode($output));
            }
            }
            return $output;
        }

    }

}




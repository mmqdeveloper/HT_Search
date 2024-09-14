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
    add_shortcode('mm_bookingbox_fareharbor', 'avia_please_install_woo');
    return;
}

if (!class_exists('mm_bookingbox_fareharbor')) {

    class mm_bookingbox_fareharbor extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['self_closing'] = 'yes';

            $this->config['name'] = __('MM Fareharbor Booking Box', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-button.png";
            $this->config['order'] = 20;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'mm_bookingbox_fareharbor';
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
                    ), $atts, $this->config['shortcode']);
            global $woocommerce, $product;
            if (!is_object($woocommerce) || !is_object($woocommerce->query) || empty($product) || is_admin())
                return;

            ob_start();
            ?>
            <div class="booking_form_sidebar booking_box_fareharbox" >
                <div class="mm_booking_warrap">
                    <div class="mm_booking_container">
                        <p class="book_title"><?php echo $atts['book_title']; ?></p>
                        <div class="mm-hr-product"><span class="mm-hr-inner"></span><span class="mm-hr-icon-booking"></span><span class="mm-hr-inner"></span></div>
                        <?php
                        $idproduct_mm = $product->get_id();
                        $fareharbor_link = get_post_meta($idproduct_mm, 'enable_fareharbor_link', true);
                        ?>
                        <div id="tours_book_form"><aside>
                                <div class="tours_form_warrap">
                                    <div class="booking_hps">
                                        <div id="book_red">
                                            <?php
                                            $show_booknow_link = true;
                                            if (strlen(strstr($fareharbor_link, '/script/calendar/')) > 0) {
                                                $show_booknow_link = false;
                                                ?>
                                                <script src="<?php echo $fareharbor_link; ?>"></script>
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
                    <div class="wrap-btn-fareharbor"><a target="_blank" rel="nofollow"  class="btn-fareharbor" href="<?php echo $fareharbor_link; ?>">BOOK NOW</a></div>
                <?php } ?>
            </div>

            <?php
            $output .= ob_get_clean();

            return $output;
        }

    }

}




<?php
/**
 * Products Badge Tags
 * 
 * Display a list of Badge tags
 */
if (!defined('ABSPATH')) {
    exit;
}    // Exit if accessed directly


if (!class_exists('woocommerce')) {
    add_shortcode('av_product_certificate_tag', 'avia_please_install_woo');
    return;
}

if (!class_exists('avia_sc_product_certificate_tag')) {

    class avia_sc_product_certificate_tag extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['self_closing'] = 'yes';

            $this->config['name'] = __('Product Badge tags', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-postslider.png";
            $this->config['order'] = 15;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'av_product_certificate_tag';
            $this->config['tooltip'] = __('Display a list of Badge tags', 'avia_framework');
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
                    "name" => __("Columns", 'avia_framework'),
                    "desc" => __("How many columns should be displayed?", 'avia_framework'),
                    "id" => "columns",
                    "type" => "select",
                    "std" => "4",
                    "subtype" => array(
                        __('1 Columns', 'avia_framework') => '1',
                        __('2 Columns', 'avia_framework') => '2',
                        __('3 Columns', 'avia_framework') => '3',
                        __('4 Columns', 'avia_framework') => '4',
                        __('5 Columns', 'avia_framework') => '5',
                        __('6 Columns', 'avia_framework') => '6',
                        __('7 Columns', 'avia_framework') => '7',
                        __('8 Columns', 'avia_framework') => '8',
                        __('9 Columns', 'avia_framework') => '9',
                        __('10 Columns', 'avia_framework') => '10',
                    )),
                array(
                    "name" => __("Entry Number", 'avia_framework'),
                    "desc" => __("How many items should be displayed?", 'avia_framework'),
                    "id" => "items",
                    "type" => "select",
                    "std" => "-1",
                    "subtype" => AviaHtmlHelper::number_array(1, 100, 1, array('All' => '-1'))),
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
            global $avia_config, $woocommerce, $product;

            extract(shortcode_atts(array(
                'columns' => 4,
                'items' => '-1'
                            ), $atts));
            $custom_class = '';
            switch ($columns) {
                case 1: $columnClass = "av_one_full";
                    break;
                case 2: $columnClass = "av_one_half";
                    break;
                case 3: $columnClass = "av_one_third";
                    break;
                case 4: $columnClass = "av_one_fourth";
                    break;
                case 5: $columnClass = "av_one_fifth";
                    break;
                default : $columnClass = "av_one_fifth";
                    $custom_class = 'mm_small_padding';
            }

            $output = "";

            //	fix for seo plugins which execute the do_shortcode() function before the WooCommerce plugin is loaded
            if (!is_object($woocommerce) || !is_object($woocommerce->query) || empty($product))
                return;
            $product_id = $product->get_id();
            $terms = get_the_terms($product_id, 'certificates');
            if($terms){
                $term_gg_review = get_term_by('slug', 'reviewed', 'certificates');
                if ($term_gg_review) {
                    $has_term_gg_review = false; 
                    foreach($terms as $term) {
                        if ($term->term_id == $term_gg_review->term_id) {
                            $has_term_gg_review = true;
                        }
                    }
        
                    if ($has_term_gg_review == false) {
                        $terms[] = $term_gg_review;
                    }
                }
            }else{
                $terms = get_terms( array(
                    'slug'    => array( 
                        'bbb',
                        'bucket-list',
                        'chamber-of-commerce',
                        'hvcb-member' ),
                    'taxonomy' => 'certificates',
                ) );
            }

            ob_start();
            if ($terms && !is_wp_error($terms)) {
                $i = 0;
                $tmp = 0;
                foreach ($terms as $term) {
                    if ($term->slug == 'reviewed') {
                        continue;
                    }
                    $i++;
                    $tmp++;
                    if ($i > $items && $items != '-1') {
                        break;
                    }
                    if ($tmp == '1') {
                        $first = 'first';
                    } else
                        $first = '';

                    $term_id = $term->term_id;
                    $term_name = $term->name;
                    $term_link = get_term_link($term->slug, 'certificates');
                    $image_id = get_term_meta($term_id, 'certificate-image-id', true);
                    ?>
                    <div class="flex_column flex_column_table_cell av-equal-height-column av-align-middle av-zero-column-padding  <?php echo $columnClass . ' ' . $first; ?> " style="text-align:center">

                        <a href="<?php echo $term_link ?>" alt="<?php echo $term_name; ?>">
                            <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                        </a>
                        <?php
                        if ($term_id == '12998') {
                            echo do_shortcode('[wp_schema_pro_rating_shortcode]');
                        }
                        ?>
                    </div>
                    <?php //if ($tmp != $columns) { ?>
                    <div class="av-flex-placeholder"></div>
                    <?php
                    //}
                    if ($tmp == $columns) {
                        $tmp = 0;
                    }
                }
            }
            $output_terms = ob_get_clean();
            $style="";
            if($i>0){
                $max_width_style = $i * 180;
                $style = "style='max-width:".$max_width_style."px; margin: 0 auto'";
            }
            ob_start();
            ?>
            <div class="mm_certificate_tag">
                <div class="mm_certificate_tag_inner">
                    <div class="flex_column_table av-equal-height-column-flextable -flextable <?php echo $custom_class; ?>" <?php echo $style; ?>>
                        <?php echo $output_terms;?>
                    </div>
                </div>
            </div>

            <?php
            $output = ob_get_clean();
            return $output;
        }

    }

}




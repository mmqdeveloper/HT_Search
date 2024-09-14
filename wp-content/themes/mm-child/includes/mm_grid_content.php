<?php

/**
 * Grid
 * 
 * 
 */
if (!defined('ABSPATH')) {
    exit;
}    // Exit if accessed directly

if (!class_exists('avia_sc_mm_grid_content')) {

    class avia_sc_mm_grid_content extends aviaShortcodeTemplate {

        static $columnClass;
        static $rows;
        static $counter;
        static $columns;
        static $style;
        static $grid_style;
        static $numberItem;
        static $mmImageSize;

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['self_closing'] = 'no';

            $this->config['name'] = __('MM Grid Content', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-portfolio.png";
            $this->config['order'] = 90;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'mm_grid_content';
            $this->config['shortcode_nested'] = array('mm_grid_content_item');
            $this->config['tooltip'] = __('Creates a grid content', 'avia_framework');
            $this->config['preview'] = true;
            $this->config['disabling_allowed'] = true;
        }

        /* function extra_assets() {
          wp_enqueue_style('avia-module-icon', AviaBuilder::$path['pluginUrlRoot'] . 'avia-shortcodes/icon/icon.css', array('avia-layout'), false);
          wp_enqueue_style('avia-module-iconlist', AviaBuilder::$path['pluginUrlRoot'] . 'avia-shortcodes/iconlist/iconlist.css', array('avia-layout'), false);

          wp_enqueue_script('avia-module-iconlist', AviaBuilder::$path['pluginUrlRoot'] . 'avia-shortcodes/iconlist/iconlist.js', array('avia-shortcodes'), false, TRUE);
          } */

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
                    "name" => __("Add/Edit Grid items", 'avia_framework'),
                    "desc" => __("Here you can add, remove and edit the items of your item grid.", 'avia_framework'),
                    "type" => "modal_group",
                    "id" => "content",
                    "modal_title" => __("Edit Grid Item", 'avia_framework'),
                    "std" => array(
                        array('title' => __('Title 1', 'avia_framework'), 'content' => 'Enter content here'),
                        array('title' => __('Title 2', 'avia_framework'), 'content' => 'Enter content here'),
                        array('title' => __('Title 3', 'avia_framework'), 'content' => 'Enter content here'),
                    ),
                    'subelements' => array(
                        array(
                            "name" => __("Grid Item Title", 'avia_framework'),
                            "desc" => __("Enter the Grid item title here (Better keep it short)", 'avia_framework'),
                            "id" => "title",
                            "std" => "Grid Title",
                            "type" => "input"),
                        array(
                            "name" => __("Link?", 'avia_framework'),
                            "desc" => __("Do you want to apply  a link to the item?", 'avia_framework'),
                            "id" => "link",
                            "type" => "linkpicker",
                            "fetchTMPL" => true,
                            "std" => "",
                            "subtype" => array(
                                __('No Link', 'avia_framework') => '',
                                __('Set Manually', 'avia_framework') => 'manually',
                                __('Single Entry', 'avia_framework') => 'single',
                                __('Taxonomy Overview Page', 'avia_framework') => 'taxonomy',
                            ),
                            "std" => ""),
                        array(
                            "name" => __("Open in new window", 'avia_framework'),
                            "desc" => __("Do you want to open the link in a new window", 'avia_framework'),
                            "id" => "linktarget",
                            "required" => array('link', 'not', ''),
                            "type" => "select",
                            "std" => "no",
                            "subtype" => AviaHtmlHelper::linking_options()),
                        array("name" => __("Button Label", 'avia_framework'),
                            "desc" => __("This is the text that appears on your button.", 'avia_framework'),
                            "id" => "label",
                            "type" => "input",
                            "std" => __("Buy Now", 'avia_framework')),
                        array("name" => __("Word Before Price", 'avia_framework'),
                            "desc" => __("Input word before price (default is 'from')", 'avia_framework'),
                            "id" => "word_before_price",
                            "type" => "input",
                            "std" => ""),
                        array("name" => __("Price", 'avia_framework'),
                            "desc" => __("Input product price", 'avia_framework'),
                            "id" => "price_product",
                            "type" => "input",
                            "std" => ""),
                        array(
                            "name" => __("Choose Image", 'avia_framework'),
                            "desc" => __("Either upload a new, or choose an existing image from your media library", 'avia_framework'),
                            "id" => "src",
                            "type" => "image",
                            "fetch" => "id",
                            "title" => __("Insert Image", 'avia_framework'),
                            "button" => __("Insert", 'avia_framework'),
                            "std" => AviaBuilder::$path['imagesURL'] . "placeholder.jpg"
                        ),
                        array(
                            "name" => __("Grid Item Content", 'avia_framework'),
                            "desc" => __("Enter some content here", 'avia_framework'),
                            "id" => "content",
                            "type" => "tiny_mce",
                            "std" => __("List Content goes here", 'avia_framework'),
                        ),
                    )
                ),
                array(
                    "name" => __("Grid Columns", 'avia_framework'),
                    "desc" => __("How many columns do you want to display?", 'avia_framework'),
                    "id" => "columns",
                    "type" => "select",
                    "std" => "3",
                    "subtype" => AviaHtmlHelper::number_array(1, 5, 1)
                ),
                array(
                    "name" => __("Preview Image Size", 'avia_framework'),
                    "desc" => __("Set the image size of the preview images", 'avia_framework'),
                    "id" => "preview_mode",
                    "type" => "select",
                    "std" => "auto",
                    "subtype" => array(__('Set the preview image size automatically based on column or layout width', 'avia_framework') => 'auto', __('Choose the preview image size manually (select thumbnail size)', 'avia_framework') => 'custom')
                ),
                array(
                    "name" => __("Select custom image size", 'avia_framework'),
                    "desc" => __("Choose image size for Portfolio Grid Images", 'avia_framework') . "<br/><small>" . __("(Note: Images will be scaled to fit for the amount of columns chosen above)", 'avia_framework') . "</small>",
                    "id" => "image_size",
                    "type" => "select",
                    "required" => array('preview_mode', 'equals', 'custom'),
                    "std" => "portfolio",
                    "subtype" => AviaHelper::get_registered_image_sizes(array('logo', 'thumbnail', 'widget'))
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
                    "name" => __("Heading Font Size", 'avia_framework'),
                    "desc" => __("Set the font size for the heading, based on the device screensize.", 'avia_framework'),
                    "type" => "heading",
                    "description_class" => "av-builder-note av-neutral",
                ),
                array("name" => __("Font Size for medium sized screens (between 768px and 989px - eg: Tablet Landscape)", 'avia_framework'),
                    "id" => "av-medium-font-size-title",
                    "type" => "select",
                    "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                    "std" => ""),
                array("name" => __("Font Size for small screens (between 480px and 767px - eg: Tablet Portrait)", 'avia_framework'),
                    "id" => "av-small-font-size-title",
                    "type" => "select",
                    "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                    "std" => ""),
                array("name" => __("Font Size for very small screens (smaller than 479px - eg: Smartphone Portrait)", 'avia_framework'),
                    "id" => "av-mini-font-size-title",
                    "type" => "select",
                    "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                    "std" => ""),
                array(
                    "name" => __("Content Font Size", 'avia_framework'),
                    "desc" => __("Set the font size for the content, based on the device screensize.", 'avia_framework'),
                    "type" => "heading",
                    "description_class" => "av-builder-note av-neutral",
                ),
                array("name" => __("Font Size for medium sized screens (between 768px and 989px - eg: Tablet Landscape)", 'avia_framework'),
                    "id" => "av-medium-font-size",
                    "type" => "select",
                    "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                    "std" => ""),
                array("name" => __("Font Size for small screens (between 480px and 767px - eg: Tablet Portrait)", 'avia_framework'),
                    "id" => "av-small-font-size",
                    "type" => "select",
                    "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                    "std" => ""),
                array("name" => __("Font Size for very small screens (smaller than 479px - eg: Smartphone Portrait)", 'avia_framework'),
                    "id" => "av-mini-font-size",
                    "type" => "select",
                    "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                    "std" => ""),
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
         * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
         * Works in the same way as Editor Element
         * @param array $params this array holds the default values for $content and $args.
         * @return $params the return array usually holds an innerHtml key that holds item specific markup.
         */
        function editor_sub_element($params) {
            $template = $this->update_template("title", __("Element", 'avia_framework') . ": {{title}}");

            extract(av_backend_icon($params)); // creates $font and $display_char if the icon was passed as param "icon" and the font as "font" 

            $params['innerHtml'] = "";
            $params['innerHtml'] .= "<div class='avia_title_container'>";
            $params['innerHtml'] .= "<span {$template} >" . __("Element", 'avia_framework') . ": " . $params['args']['title'] . "</span></div>";

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
            $this->screen_options = AviaHelper::av_mobile_sizes($atts);
            extract($this->screen_options); //return $av_font_classes, $av_title_font_classes and $av_display_classes

            extract(shortcode_atts(
                            array(
                'columns' => '3',
                'preview_mode' => '',
                'image_size' => ''
                            ), $atts, $this->config['shortcode']));


            switch ($columns) {
                case 1: $columnClass = "av_one_full flex_column";
                    break;
                case 2: $columnClass = "av_one_half flex_column";
                    break;
                case 3: $columnClass = "av_one_third flex_column";
                    break;
                case 4: $columnClass = "av_one_fourth flex_column";
                    break;
            }
            $output .= "<div class='mm-grid-content avia_animate_when_almost_visible " . $meta['el_class'] . " '>";
            if ($preview_mode == 'auto') {
                $image_size = 'full';
            }
            avia_sc_mm_grid_content::$counter = 1;
            avia_sc_mm_grid_content::$rows = 1;
            avia_sc_mm_grid_content::$columnClass = $columnClass;
            avia_sc_mm_grid_content::$columns = $columns;
            //avia_sc_mm_grid_content::$style = $style;
            avia_sc_mm_grid_content::$numberItem = 1;
            avia_sc_mm_grid_content::$mmImageSize = $image_size;
            $output .= ShortcodeHelper::avia_remove_autop($content, true);

            //close unclosed wrapper containers
            if (avia_sc_mm_grid_content::$counter != 1) {
                $output .= "</div>";
            }


            $output .= "</div>";

            return $output;
        }

        function mm_grid_content_item($atts, $content = "", $shortcodename = "") {

            extract($this->screen_options); //return $av_font_classes, $av_title_font_classes and $av_display_classes
            $output = "";
            $avatar = "";
            $avatar_size = apply_filters('avf_mm_image_size', 'square', $src, $class);
            $atts = shortcode_atts(array(
                'title' => '', 
                'link' => '', 
                'src' => '', 
                'linktarget' => '', 
                'custom_markup' => '', 
                'label' => 'Buy Now',
                'price_product'=>'',
                'word_before_price' => ''
                    ), $atts, 'mm_grid_content_item');
            $class = avia_sc_mm_grid_content::$columnClass . " avia-mm-featured-row-" . avia_sc_mm_grid_content::$rows . " ";
            if (avia_sc_mm_grid_content::$counter == 1)
                $class .= "avia-first-grid-item first";
            /* if (avia_sc_mm_grid_content::$counter == avia_sc_mm_grid_content::$columns)
              $class .= "avia-last-mm-featured";
             */
            if (avia_sc_mm_grid_content::$counter == 1) {
                $output .= "<div class ='avia-mm-grid-row'>";
            }
            $number_item = avia_sc_mm_grid_content::$numberItem;

            $blank = (strpos($atts['linktarget'], '_blank') !== false || $atts['linktarget'] == 'yes') ? ' target="_blank" ' : "";
            $blank .= strpos($atts['linktarget'], 'nofollow') !== false ? ' rel="nofollow" ' : "";
            $post_id ='';
            if (!empty($atts['link'])) {
                $atts['link'] = aviaHelper::get_url($atts['link']);
                $post_id = url_to_postid( $atts['link'] );
                if (!empty($atts['link'])) {
                    $check_link = true;
                    //$linktitle = $atts['title'];
                    //$atts['title'] = "<a href='{$atts['link']}' title='" . esc_attr($linktitle) . "'{$blank}>{$linktitle}</a>";
                }
            }
            
            $thum_size = avia_sc_mm_grid_content::$mmImageSize;
            if ($thum_size == 'no scaling') {
                $thum_size = 'full';
            }
            $image = wp_get_attachment_image_src($atts['src'], $thum_size);
            $url_img = $image[0];
            $title_el = "p";
            $price = $atts['price_product'];
            if($post_id!=''){
                $thumbnail =get_the_post_thumbnail_url($post_id, $thum_size);
                if($atts['src']==''){
                    $url_img = $thumbnail;
                }
                if ( get_post_type( $post_id ) == 'product' ) {
                    $product = wc_get_product( $post_id );
                    if($price== '' ){
                        $price = '$'.$product->get_price();
                    }
                    
                }
            }
            $output .= "<div class='{$class}'>";
            if ($check_link) {
                $output .= "<a href='{$atts['link']}' title='" . esc_attr($atts['title']) . "'{$blank}>";
            }
            $output .= "<div class='mm-thumbnail'>";
            $output .= "<img src='{$url_img}' alt='" . esc_attr($atts['title']) . "'>";
            $output .= "<span class='item-title'>" . esc_attr($atts['title']) . "</span>";
            $output .= "</div>";
            $output .= "<div class='grid-item-content'>" . ShortcodeHelper::avia_apply_autop(ShortcodeHelper::avia_remove_autop($content)) . "</div>";
            $output .= "<div class='footer-content-item'><div class='wrap-price'><span>". (!empty($atts['word_before_price']) ? $atts['word_before_price'] : 'from') ."</span><span class='price'>" . esc_attr(trim(str_replace("Starts At","",$price))) . "</span></div><div class='button-name'>" . esc_attr($atts['label']) . "</div></div>";
            if ($check_link) {
                $output .= "</a>";
            }
            $output .= "</div>";
            if (avia_sc_mm_grid_content::$counter == avia_sc_mm_grid_content::$columns) {
                $output .= "</div>";
            }

            avia_sc_mm_grid_content::$counter++;
            avia_sc_mm_grid_content::$numberItem++;
            if (avia_sc_mm_grid_content::$counter > avia_sc_mm_grid_content::$columns) {
                avia_sc_mm_grid_content::$counter = 1;
                avia_sc_mm_grid_content::$rows++;
            }
            return $output;
        }

    }

}

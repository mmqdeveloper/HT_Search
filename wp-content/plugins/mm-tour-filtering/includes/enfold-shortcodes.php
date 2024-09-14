<?php
use MauiMarketing\MMTF\Shortcodes;
if (!class_exists('avia_mm_tour_search')) {

    class avia_mm_tour_search extends aviaShortcodeTemplate {

        function shortcode_insert_button() {
            $this->config['self_closing'] = 'yes'; 

            $this->config['name'] = __('MM Search', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . 'sc-postslider.png';
            $this->config['order'] = 50;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'av_mm_tour_search';
            $this->config['tooltip'] = __('Display the Tour Filtering', 'avia_framework');
            $this->config['drag-level'] = 3;
            $this->config['tinyMCE'] = array('disable' => 'true');
            
        }
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
                    "name" => __("Which Certificate Tag?", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_certificate",
                    "type" => "select",
                    "taxonomy" => "certificates",
                    "subtype" => "cat",
                    "multiple" => 6
                ),
                array(
                    "name" => __("Entry Number", 'avia_framework'),
                    "desc" => __("How many items should be displayed?", 'avia_framework'),
                    "id" => "items",
                    "type" => "select",
                    "std" => "-1",
                    "subtype" => AviaHtmlHelper::number_array(1, 100, 1, array('Default' => '-1'))
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

        function editor_element($params) {
            //$params = parent::editor_element($params);

            $params['innerHtml'] .= "<div class='avia-flex-element'>";
            $params['innerHtml'] .= __('Display the Tour Filtering.', 'avia_framework');
            $params['innerHtml'] .= '</div>';

            return $params;
        }

        function shortcode_handler($atts, $content = '', $shortcodename = '', $meta = '') {
            global $avia_config;

            $atts = shortcode_atts(array(
                'mm_tag' => '',
                'mm_certificate' => '',
                'categories' => '',
                'items' => '-1',
                    ), $atts, $this->config['shortcode']);

            extract($atts);
            $output = Shortcodes\mm_tour_search_templates($atts);
            return $output;
        }

    }

}




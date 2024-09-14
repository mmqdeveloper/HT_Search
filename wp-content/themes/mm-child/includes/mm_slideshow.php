<?php

/**
 * Slider
 * Shortcode that allows to display a simple slideshow
 */
if (!class_exists('mm_avia_sc_slider')) {

    class mm_avia_sc_slider extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM Easy Slider', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-tabs.png";
            $this->config['order'] = 85;
            $this->config['target'] = 'avia-target-insert-mm';
            $this->config['shortcode'] = 'av_slideshow_mm';
            $this->config['shortcode_nested'] = array('av_slide_mm');
            $this->config['tooltip'] = __('Display a simple slideshow element', 'avia_framework');
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
                    "type" => "modal_group",
                    "id" => "content",
                    'container_class' => "avia-element-fullwidth avia-multi-img",
                    "modal_title" => __("Edit Form Element", 'avia_framework'),
                    "add_label" => __("Add single image", 'avia_framework'),
                    "std" => array(),
                    'creator' => array(
                        "name" => __("Add Images", 'avia_framework'),
                        "desc" => __("Here you can add new Images to the slideshow.", 'avia_framework'),
                        "id" => "id",
                        "type" => "multi_image",
                        "title" => __("Add multiple Images", 'avia_framework'),
                        "button" => __("Insert Images", 'avia_framework'),
                        "std" => ""),
                    'subelements' => array(
                        array(
                            "type" => "tab_container", 'nodescription' => true
                        ),
                        array(
                            "type" => "tab",
                            "name" => __("Content", 'avia_framework'),
                            'nodescription' => true
                        ),
                        array(
                            "name" => __("Which type of slide is this?", 'avia_framework'),
                            "id" => "slide_type",
                            "type" => "select",
                            "std" => "",
                            "subtype" => array(__('Image Slide', 'avia_framework') => 'image',
                            )
                        ),
                        array(
                            "name" => __("Choose another Image", 'avia_framework'),
                            "desc" => __("Either upload a new, or choose an existing image from your media library", 'avia_framework'),
                            "id" => "id",
                            "fetch" => "id",
                            "type" => "image",
                            "required" => array('slide_type', 'is_empty_or', 'image'),
                            "title" => __("Change Image", 'avia_framework'),
                            "button" => __("Change Image", 'avia_framework'),
                            "std" => ""),
                        array(
                            "name" => __("Caption Title", 'avia_framework'),
                            "desc" => __("Enter a caption title for the slide here", 'avia_framework'),
                            "id" => "title",
                            "std" => "",
                            "type" => "input"),
                        array(
                            "name" => __("Open Link in new Window?", 'avia_framework'),
                            "desc" => __("Select here if you want to open the linked page in a new window", 'avia_framework'),
                            "id" => "link_target",
                            "type" => "select",
                            "std" => "",
                            "required" => array('link', 'not_empty_and', 'lightbox'),
                            "subtype" => AviaHtmlHelper::linking_options()),
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
                            "name" => __("Caption Title Font Size", 'avia_framework'),
                            "desc" => __("Set the font size for the element title, based on the device screensize.", 'avia_framework'),
                            "type" => "heading",
                            "description_class" => "av-builder-note av-neutral",
                        ),
                        array("name" => __("Font Size for medium sized screens", 'avia_framework'),
                            "id" => "av-medium-font-size-title",
                            "type" => "select",
                            "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                            "std" => ""),
                        array("name" => __("Font Size for small screens", 'avia_framework'),
                            "id" => "av-small-font-size-title",
                            "type" => "select",
                            "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                            "std" => ""),
                        array("name" => __("Font Size for very small screens", 'avia_framework'),
                            "id" => "av-mini-font-size-title",
                            "type" => "select",
                            "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                            "std" => ""),
                        array(
                            "name" => __("Caption Content Font Size", 'avia_framework'),
                            "desc" => __("Set the font size for the element content, based on the device screensize.", 'avia_framework'),
                            "type" => "heading",
                            "description_class" => "av-builder-note av-neutral",
                        ),
                        array("name" => __("Font Size for medium sized screens", 'avia_framework'),
                            "id" => "av-medium-font-size",
                            "type" => "select",
                            "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                            "std" => ""),
                        array("name" => __("Font Size for small screens", 'avia_framework'),
                            "id" => "av-small-font-size",
                            "type" => "select",
                            "subtype" => AviaHtmlHelper::number_array(10, 120, 1, array(__("Default", 'avia_framework') => '', __("Hidden", 'avia_framework') => 'hidden'), "px"),
                            "std" => ""),
                        array("name" => __("Font Size for very small screens", 'avia_framework'),
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
                    )
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
            return $params;
        }

        /**
         * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
         * Works in the same way as Editor Element
         * @param array $params this array holds the default values for $content and $args.
         * @return $params the return array usually holds an innerHtml key that holds item specific markup.
         */
        function editor_sub_element($params) {
            $img_template = $this->update_template("img_fakeArg", "{{img_fakeArg}}");
            $template = $this->update_template("title", "{{title}}");
            $content = $this->update_template("content", "{{content}}");
            $video = $this->update_template("video", "{{video}}");
            $thumbnail = isset($params['args']['id']) ? wp_get_attachment_image($params['args']['id']) : "";


            $params['innerHtml'] = "";
            $params['innerHtml'] .= "<div class='avia_title_container'>";
            $params['innerHtml'] .= "	<div " . $this->class_by_arguments('slide_type', $params['args']) . ">";
            $params['innerHtml'] .= "		<span class='avia_slideshow_image' {$img_template} >{$thumbnail}</span>";
            $params['innerHtml'] .= "		<div class='avia_slideshow_content'>";
            $params['innerHtml'] .= "			<h4 class='avia_title_container_inner' {$template} >" . $params['args']['title'] . "</h4>";
            $params['innerHtml'] .= "			<p class='avia_content_container' {$content}>" . stripslashes($params['content']) . "</p>";
            $params['innerHtml'] .= "			<small class='avia_video_url' {$video}>" . stripslashes($params['args']['video']) . "</small>";
            $params['innerHtml'] .= "		</div>";
            $params['innerHtml'] .= "	</div>";
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
            extract(AviaHelper::av_mobile_sizes($atts)); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

            $atts = shortcode_atts(array(
                'size' => 'full',
                'animation' => 'slide',
                'ids' => '',
                'autoplay' => 'false',
                'handle' => $shortcodename,
                'content' => ShortcodeHelper::shortcode2array($content, 1),
                'class' => $meta['el_class'] . " " . $av_display_classes,
                'custom_markup' => $meta['custom_markup'],
                    ), $atts, $this->config['shortcode']);


            $html = "";
            if (!empty($atts['content'])) {
                $html .= "<div class='carousel' data-flickity='{ 
                        &quot;cellAlign&quot;: &quot;center&quot;,
                        &quot;wrapAround&quot;: true,
                        &quot;autoPlay&quot;: false,
                        &quot;prevNextButtons&quot;:true,
                        &quot;percentPosition&quot;: true,
                        &quot;adaptiveHeight&quot;: true,
                        &quot;imagesLoaded&quot;: true,
                        &quot;dragThreshold&quot; : 0,
                        &quot;lazyLoad&quot;: 0,
                        &quot;pageDots&quot;: true,
                        &quot;rightToLeft&quot;: false }'>";

                foreach ($atts['content'] as $key => $value) {
                    $html .= "<div  class='row-slider'>";
                    $images_mm = vt_resize($value['attr']['id'], '', 1200, 600, true);
                    $html .= "<img src='" . $images_mm['url'] . "' width='" . $images_mm['width'] . "' height='" . $images_mm['height'] . "'/>";
                    if (!empty($value['attr']['title'])) {
                        $html .= "<div class='content-slider-flickity'>";
                        $html .= "<h3 class='slider-title-top'>" . $value['attr']['title'] . "</h3>";
                        $html .= "</div>";
                    }
                    $html .= "</div>";
                }
                $html .= "</div>";
            }
            return $html;
        }

    }

}

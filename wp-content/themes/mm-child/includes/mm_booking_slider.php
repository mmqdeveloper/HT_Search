<?php

/**
 * Slider
 * Shortcode that allows to display a simple slideshow
 */
if (!class_exists('avia_sc_mm_booking_slider')) {

    class avia_sc_mm_booking_slider extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('Booking Slider', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-slideshow.png";
            $this->config['order'] = 85;
            $this->config['target'] = 'avia-mm-target-insert';
            $this->config['shortcode'] = 'av_mm_booking_slider';
            $this->config['shortcode_nested'] = array('av_slide');
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
                            "name" => __("Which type of slide is this?", 'avia_framework'),
                            "id" => "slide_type",
                            "type" => "select",
                            "std" => "",
                            "subtype" => array(__('Image Slide', 'avia_framework') => 'image'
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
                            "name" => __("Price", 'avia_framework'),
                            "desc" => __("Enter Price ($)", 'avia_framework'),
                            "id" => "content",
                            "type" => "input",
                            "std" => "",
                        ),
                        array(
                            "name" => __("Apply a link to the slide?", 'avia_framework'),
                            "desc" => __("You can choose to apply the link to the whole image", 'avia_framework'),
                            "id" => "link_apply",
                            "type" => "select",
                            "std" => "",
                            "subtype" => array(
                                __('No Link for this slide', 'avia_framework') => '',
                                __('Apply Link to Image', 'avia_framework') => 'image')),
                        array(
                            "name" => __("Image Link?", 'avia_framework'),
                            "desc" => __("Where should the Image link to?", 'avia_framework'),
                            "id" => "link",
                            "required" => array('link_apply', 'equals', 'image'),
                            "type" => "linkpicker",
                            "fetchTMPL" => true,
                            "subtype" => array(
                                __('Open Image in Lightbox', 'avia_framework') => 'lightbox',
                                __('Set Manually', 'avia_framework') => 'manually',
                                __('Single Entry', 'avia_framework') => 'single',
                                __('Taxonomy Overview Page', 'avia_framework') => 'taxonomy',
                            ),
                            "std" => ""),
                        array(
                            "name" => __("Open Link in new Window?", 'avia_framework'),
                            "desc" => __("Select here if you want to open the linked page in a new window", 'avia_framework'),
                            "id" => "link_target",
                            "type" => "select",
                            "std" => "",
                            "required" => array('link', 'not_empty_and', 'lightbox'),
                            "subtype" => AviaHtmlHelper::linking_options()),
                    )
                ),
                array(
                    "name" => __("Slideshow Image Size", 'avia_framework'),
                    "desc" => __("Choose the size of the image that loads into the slideshow.", 'avia_framework'),
                    "id" => "size",
                    "type" => "select",
                    "std" => "featured",
                    "subtype" => AviaHelper::get_registered_image_sizes(array('thumbnail', 'logo', 'widget', 'slider_thumb'))
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
            $atts = shortcode_atts(array(
                'size' => 'featured',
                'animation' => 'slide',
                'ids' => '',
                'autoplay' => 'false',
                'interval' => 5,
                'control_layout' => '',
                'perma_caption' => '',
                'handle' => $shortcodename,
                'content' => ShortcodeHelper::shortcode2array($content, 1),
                'class' => $meta['el_class'],
                'custom_markup' => $meta['custom_markup'],
                'autoplay_stopper' => '',
                    ), $atts, $this->config['shortcode']);

            $slider = new mm_avia_slideshow($atts);
            return $slider->html();
        }

    }

}

















<?php

/**
 * Sidebar
 * Displays one of the registered Widget Areas of the theme
 */
if (!class_exists('avia_sc_testimonial_version_new')) {

    class avia_sc_testimonial_version_new extends aviaShortcodeTemplate {

        static $columnClass;
        static $rows;
        static $counter;
        static $columns;
        static $style;

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM Reviews', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = get_stylesheet_directory_uri() . "/assets/images/MMTestimonials24x24_bl.png";
            $this->config['order'] = 21;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'av_testimonials_version_new';
            $this->config['shortcode_nested'] = array('av_testimonial_version_new');
            $this->config['tooltip'] = __('Creates a Testimonial Grid', 'avia_framework');
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
                    "name" => __("Add/Edit Testimonial", 'avia_framework'),
                    "desc" => __("Here you can add, remove and edit your Testimonials.", 'avia_framework'),
                    "type" => "modal_group",
                    "id" => "content",
                    "modal_title" => __("Edit Testimonial", 'avia_framework'),
                    "std" => array(
                        array('name' => __('Name', 'avia_framework'), 'Subtitle' => '', 'check' => 'is_empty'),
                    ),
                    'subelements' => array(
                        array(
                            "name" => __("Title Reviews", 'avia_framework'),
                            "desc" => "Enter the title of the Person to quote",
                            "id" => "title_review",
                            "std" => "",
                            "type" => "input"),
                        array(
                            "name" => __("Image", 'avia_framework'),
                            "desc" => __("Either upload a new, or choose an existing image from your media library", 'avia_framework'),
                            "id" => "src",
                            "type" => "image",
                            "title" => __("Insert Image", 'avia_framework'),
                            "button" => __("Insert", 'avia_framework'),
                            "std" => ""),
                        array(
                            "name" => __("Name", 'avia_framework'),
                            "desc" => "Enter the Name of the Person to quote",
                            "id" => "name",
                            "std" => "",
                            "type" => "input"),
                        array(
                            "name" => __("Subtitle below name", 'avia_framework'),
                            "desc" => __("Can be used for a job description", 'avia_framework'),
                            "id" => "subtitle",
                            "std" => "",
                            "type" => "input"),
                        array(
                            "name" => __("Quote", 'avia_framework'),
                            "desc" => __("Enter the testimonial here", 'avia_framework'),
                            "id" => "content",
                            "std" => "",
                            "type" => "tiny_mce"
                        ),
                        array(
                            "name" => __("Rating Star", 'avia_framework'),
                            "desc" => __("Choose number star for testimonials", 'avia_framework'),
                            "id" => "star",
                            "type" => "select",
                            "std" => "",
                            "subtype" => array(
                                __('None', 'avia_framework') => 'none',
                                __('1 Star', 'avia_framework') => '1',
                                __('2 Stars', 'avia_framework') => '2',
                                __('3 Stars', 'avia_framework') => '3',
                                __('4 Stars', 'avia_framework') => '4',
                                __('5 Stars', 'avia_framework') => '5',
                            )
                        ),
                    )
                ),
                /*array(
                    "name" => __("Link Submit", 'avia_framework'),
                    "desc" => __("Either upload a new, or choose an existing image from your media library", 'avia_framework'),
                    "id" => "link_submit",
                    "type" => "input"),*/
                array(
                    "name" => __("Testimonial Style", 'avia_framework'),
                    "desc" => __("Here you can select how to display the testimonials. You can either create a testimonial slider or a testimonial grid with multiple columns", 'avia_framework'),
                    "id" => "style",
                    "type" => "select",
                    "std" => "grid",
                    "subtype" => array(__('Testimonial Grid', 'avia_framework') => 'grid',
                        __('Testimonial Slider (Compact)', 'avia_framework') => 'slider',
                        __('Testimonial Slider (Large)', 'avia_framework') => 'slider_large',
                    )
                ),
                array(
                    "name" => __("Testimonial Grid Columns", 'avia_framework'),
                    "desc" => __("How many columns do you want to display", 'avia_framework'),
                    "id" => "columns",
                    "required" => array('style', 'equals', 'grid'),
                    "type" => "select",
                    "std" => "2",
                    "subtype" => AviaHtmlHelper::number_array(1, 4, 1)
                ),
                array(
                    "name"  => __("Autorotation active?",'avia_framework' ),
                    "desc"  => __("Check if the slideshow should rotate by default",'avia_framework' ),
                    "id"    => "autoplay",
                    "type"  => "select",
                    "std"   => "false",
                    "required" => array('style', 'contains', 'slider'),
                    "subtype" => array(__('Yes','avia_framework' ) =>'true',__('No','avia_framework' ) =>'false')),
                array(
                    "name" => __("Slideshow autorotation duration", 'avia_framework'),
                    "desc" => __("Slideshow will rotate every X seconds", 'avia_framework'),
                    "id" => "interval",
                    "type" => "select",
                    "std" => "5",
                    "required"=> array('autoplay','equals','true'),
                    "subtype" => array('3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '15' => '15', '20' => '20', '30' => '30', '40' => '40', '60' => '60', '100' => '100')),
                array(
                    "name" => __("Choose Image", 'avia_framework'),
                    "desc" => __("Either upload a new, or choose an existing image from your media library", 'avia_framework'),
                    "id" => "caption",
                    "type" => "image",
                    "title" => __("Insert Image", 'avia_framework'),
                    "button" => __("Insert", 'avia_framework'),
                    "std" => AviaBuilder::$path['imagesURL'] . "placeholder.jpg"),
                array(
                    "name" => __("Title Caption", 'avia_framework'),
                    "desc" => __("Either upload a new, or choose an existing image from your media library", 'avia_framework'),
                    "id" => "title_caption",
                    "type" => "textarea"),
                array(
                    "name" => __("Font Colors", 'avia_framework'),
                    "desc" => __("Either use the themes default colors or apply some custom ones", 'avia_framework'),
                    "id" => "font_color",
                    "type" => "select",
                    "std" => "",
                    "subtype" => array(__('Default', 'avia_framework') => '',
                        __('Define Custom Colors', 'avia_framework') => 'custom'),
                ),
                array(
                    "name" => __("Name Font Color", 'avia_framework'),
                    "desc" => __("Select a custom font color. Leave empty to use the default", 'avia_framework'),
                    "id" => "custom_title",
                    "type" => "colorpicker",
                    "std" => "",
                    "container_class" => 'av_half av_half_first',
                    "required" => array('font_color', 'equals', 'custom')
                ),
                array(
                    "name" => __("Custom Content Font Color", 'avia_framework'),
                    "desc" => __("Select a custom font color. Leave empty to use the default", 'avia_framework'),
                    "id" => "custom_content",
                    "type" => "colorpicker",
                    "std" => "",
                    "container_class" => 'av_half',
                    "required" => array('font_color', 'equals', 'custom')
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
            $template = $this->update_template("name", __("Testimonial by", 'avia_framework') . ": {{name}}");

            $params['innerHtml'] = "";
            $params['innerHtml'] .= "<div class='avia_title_container' {$template}>" . __("Testimonial by", 'avia_framework') . ": " . $params['args']['name'] . "</div>";

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
                'style' => "grid",
                'columns' => "1",
                "autoplay" => 'false',
                "interval" => 5,
                'font_color' => '',
                'custom_title' => '',
                'custom_content' => '',
                'caption' => '',
                'title_caption' => '',
                'link_submit' => '',
                'testimonial' => '',
                'height_ttmn' => ''
                    ), $atts, $this->config['shortcode']);

            $custom_class = !empty($meta['custom_class']) ? $meta['custom_class'] : "";
            extract($atts);

            //print_r($atts);
            $this->title_styling = "";
            $this->content_styling = "";
            $this->content_class = "";
            $this->subtitle_class = "";

            if ($font_color == "custom") {
                $this->title_styling .= !empty($custom_title) ? "color:{$custom_title}; " : "";
                $this->content_styling .= !empty($custom_content) ? "color:{$custom_content}; " : "";

                if ($this->title_styling) {
                    $this->title_styling = " style='{$this->title_styling}'";
                    $this->subtitle_class = "av_opacity_variation";
                }

                if ($this->content_styling) {
                    $this->content_class = "av_inherit_color";
                    $this->content_styling = " style='{$this->content_styling}'";
                }
            }

            $output = "";

            switch ($columns) {
                case 1: $columnClass = "av_one_full flex_column no_margin";
                    break;
                case 2: $columnClass = "av_one_half flex_column no_margin";
                    break;
                case 3: $columnClass = "av_one_third flex_column no_margin";
                    break;
                case 4: $columnClass = "av_one_fourth flex_column no_margin";
                    break;
            }

            $data = AviaHelper::create_data_string(array('autoplay' => $autoplay, 'interval' => $interval, 'animation' => 'fade', 'hoverpause' => true));
            $controls = false;
            if ($style == "slider") {
                $controls = true;
                $custom_class .= " mm-testimonial-slider-compact";
            }
            if ($style == "slider_large") {
                $style = "slider";
                $custom_class .= " av-large-testimonial-slider";
                $controls = true;
            }


            $output .= '<div class="title-mm-shortcode">' . $title_caption . '</div>';
            //$output .= "<div  {$data} class='section_sld_new avia-testimonial-wrapper avia-{$style}-testimonials avia-{$style}-{$columns}-testimonials avia_animate_when_almost_visible {$custom_class}' style='background-image:url(".$caption.");'>";
            $output .= "<div  {$data} class='slide-hover-image section_sld_new avia-testimonial-wrapper  red-testimonial-wrapper avia-{$style}-testimonials avia-{$style}-{$columns}-testimonials avia_animate_when_almost_visible {$custom_class}' >";
            //$output .= '<img class="img-slider full-width" src="'.$caption.'">';
            //$logo_yelp = get_stylesheet_directory_uri()."/assets/images/logo_yelp_v1.png";
            $output .= "<div class='slider-new'>";
            avia_sc_testimonial_version_new::$counter = 1;
            avia_sc_testimonial_version_new::$rows = 1;
            avia_sc_testimonial_version_new::$columnClass = $columnClass;
            avia_sc_testimonial_version_new::$columns = $columns;
            avia_sc_testimonial_version_new::$style = $style;

            //if we got a slider we only need a single row wrpper
            if ($style != "grid")
                avia_sc_testimonial_version_new::$columns = 100000;

            $output .= ShortcodeHelper::avia_remove_autop($content, true);

            //close unclosed wrapper containers
            if (avia_sc_testimonial_version_new::$counter != 1) {
                $output .= "</section>";
            }

            if ($controls) {
                $output .= $this->slide_navigation_arrows();
            }

            $output .= "</div>";
            $output .= "</div>";

            return $output;
        }

        protected function slide_navigation_arrows() {
            $html = "";
            $html .= "<div class='avia-slideshow-arrows avia-slideshow-controls' {$this->content_styling}>";
            $html .= "<a href='#prev' class='prev-slide' " . av_icon_string('prev_big') . ">" . __('Previous', 'avia_framework') . "</a>";
            $html .= "<a href='#next' class='next-slide' " . av_icon_string('next_big') . ">" . __('Next', 'avia_framework') . "</a>";
            $html .= "</div>";
            $html .= '<div class="Adventure_button" style="width:100%; height:20px; margin-top:25px;">';
            $html .= "<div class='avia-slideshow-dots avia-slideshow-controls'>";
            $active = "active";

            for ($i = 1; $i <= avia_sc_testimonial_version_new::$counter - 1; $i++) {
                $html .= "<a href='#{$i}' class='goto-slide {$active}' ><span>{$i}</span></a>";
                $active = "";
            }
            global $avia_config;
            $color_bg = $avia_config['backend_colors']['color_set']['header_color']['bg'];
            $color_theme = $avia_config['backend_colors']['color_set']['header_color']['primary'];

            $html .= "</div>";
            /* $html .= "<div class='submit-link-adven'>";
              $html .=      '<a href="'.$link_submit.'"><input class="title-mm-link-submit-adven" style="background-color:'.$color_theme.' !important;" type="submit" value="READ MORE"></a>';
              $html .= "</div>"; */
            $html .= "</div>";
            

            return $html;
        }

        function av_testimonial_version_new($atts, $content = "", $shortcodename = "") {
            extract(shortcode_atts(array(
                'title_review' => '',
                'src' => "",
                'name' => "",
                'link_submit' => "",
                'subtitle' => "",
                'star' => '',
                'title_caption' => "",
                'link' => "",
                'custom_markup' => ''), $atts, 'av_testimonial_version_new'));


            $output = "";
            $avatar = "";
            $grid = avia_sc_testimonial_version_new::$style == 'grid' ? true : false;
            $class = avia_sc_testimonial_version_new::$columnClass . " avia-testimonial-row-" . avia_sc_testimonial_version_new::$rows . " ";
            if (avia_sc_testimonial_version_new::$counter == 1)
                $class .= "avia-first-testimonial";
            if (avia_sc_testimonial_version_new::$counter == avia_sc_testimonial_version_new::$columns)
                $class .= "avia-last-testimonial";

            if (avia_sc_testimonial_version_new::$counter == 1) {
                $output .= "<section  class ='avia-testimonial-row avia-testimonial-row-preview slider-new-ttmn'>";
            }


            //avatar size filter
            $avatar_size = apply_filters('avf_testimonials_avatar_size', 'square', $src, $class);

            //avatar
            $markup = avia_markup_helper(array('context' => 'single_image', 'echo' => false, 'custom_markup' => $custom_markup));

            //meta
            $markup_text = avia_markup_helper(array('context' => 'entry', 'echo' => false, 'custom_markup' => $custom_markup));
            $markup_name = avia_markup_helper(array('context' => 'name', 'echo' => false, 'custom_markup' => $custom_markup));
            $markup_job = avia_markup_helper(array('context' => 'job', 'echo' => false, 'custom_markup' => $custom_markup));
            $markup_job = avia_markup_helper(array('context' => 'caption', 'echo' => false, 'custom_markup' => $custom_markup));
            if (strstr($link, '@')) {
                $markup_url = avia_markup_helper(array('context' => 'email', 'echo' => false, 'custom_markup' => $custom_markup));
            } else {
                $markup_url = avia_markup_helper(array('context' => 'url', 'echo' => false, 'custom_markup' => $custom_markup));
            }

            //final output

            /* $markup = avia_markup_helper(array('context' => 'person','echo'=>false, 'custom_markup'=>$custom_markup)); */
            $output .= "<div style='min-height:280px;' class='avia-testimonial avia-testimonial-mm-preview  slider-ttmn-new {$class}' >";
            $output .= "<div class='avia-testimonial_inner testimonial_preview_mm'>";

            $output .= "<div class='avia-testimonial-content slider-name-ttmn {$this->content_class}'  {$this->content_styling} {$markup_text}>";
            if ($title_review)
                $output .= "<div class='mm_review_title'>" . $title_review . "</div>";
            $output .= ShortcodeHelper::avia_apply_autop(ShortcodeHelper::avia_remove_autop($content));
            if ($src) {
                $output .= "<div class='mm-testimonial-image' $markup><img src='" . $src . "' width='75' height='75' alt='" . $name . "' /></div>";
            }
            if ($name)
                $output .= "<strong  class='avia-testimonial-name red-testimonial-name name-class'  {$this->title_styling} {$markup_name}>{$name}</strong>";
            if ($subtitle)
                $output .= "<span  class='avia-testimonial-subtitle mm-subtitle {$this->subtitle_class}' {$this->title_styling}  {$markup_job}>{$subtitle}</span>";
            if ($star != 'none') {
                $output .= "<div class='mm_rating rating-foreground rating'>";
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $star) {
                        $gold = 'gold';
                    } else {
                        $gold = '';
                    }
                    $output .= "<i class='fa fa-star " . $gold . "'></i>";
                }
                $output .= "</div>";
            }
            $output .= "</div>";
            $output .= "</div>";
            $output .= "</div>";

            if (avia_sc_testimonial_version_new::$counter == avia_sc_testimonial_version_new::$columns) {
                $output .= "</section>";
            }

            avia_sc_testimonial_version_new::$counter++;
            if (avia_sc_testimonial_version_new::$counter > avia_sc_testimonial_version_new::$columns) {
                avia_sc_testimonial_version_new::$counter = 1;
                avia_sc_testimonial_version_new::$rows++;
            }


            return $output;
        }

    }

}
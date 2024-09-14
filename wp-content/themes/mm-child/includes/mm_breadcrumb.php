<?php

if (!class_exists('avia_sc_mm_breadcrumb')) {

    class avia_sc_mm_breadcrumb extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['version'] = '1.0';
            $this->config['self_closing'] = 'yes';
            $this->config['base_element'] = 'yes';

            $this->config['name'] = __('MM Breadcrumb', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . 'sc-text_block.png';
            $this->config['order'] = 5;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'av_mm_breadcrumb';
            $this->config['tinyMCE'] = array('disable' => 'true');
            $this->config['tooltip'] = __('Add a Breadcrumb to the template', 'avia_framework');
            //$this->config['drag-level']	= 1;
            $this->config['disabling_allowed'] = 'manually';
            $this->config['disabled'] = array(
                'condition' => ( avia_get_option('disable_blog') == 'disable_blog' ),
                'text' => __('This element is disabled in your theme options. You can enable it in Enfold &raquo; Performance', 'avia_framework')
            );
            $this->config['id_name'] = 'id';
            $this->config['id_show'] = 'yes';
            $this->config['alb_desc_id'] = 'alb_description';
        }

        function extra_assets() {
            
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
            //if the element is disabled
            if (true === $this->config['disabled']['condition']) {
                $this->elements = array(
                    array(
                        'type' => 'template',
                        'template_id' => 'element_disabled',
                        'args' => array(
                            'desc' => $this->config['disabled']['text']
                        )
                    ),
                );

                return;
            }


            $this->elements = array(
                array(
                    'type' => 'tab_container',
                    'nodescription' => true
                ),
                array(
                    "type" => "tab",
                    "name" => __("Styling", 'avia_framework'),
                    'nodescription' => true
                ),
                array(
                    "name" => __("Breadcrumb Style", 'avia_framework'),
                    "desc" => __("Select a Breadcrumb style", 'avia_framework'),
                    "id" => "style",
                    "type" => "select",
                    "std" => "",
                    "subtype" => array(__("Default Style (center)", 'avia_framework') => '', __("Left", 'avia_framework') => 'left')
                ),
                array(
                    "name" => __("Breadcrumb Color", 'avia_framework'),
                    "desc" => __("Select a Breadcrumb color", 'avia_framework'),
                    "id" => "color",
                    "type" => "select",
                    "std" => "",
                    "subtype" => array(__("Default Color", 'avia_framework') => '', __("Custom Color", 'avia_framework') => 'custom-color-heading')
                ),
                array(
                    "name" => __("Custom Font Color", 'avia_framework'),
                    "desc" => __("Select a custom font color for your Breadcrumb here", 'avia_framework'),
                    "id" => "custom_font",
                    "type" => "colorpicker",
                    "std" => "#333333",
                    "required" => array('color', 'equals', 'custom-color-heading')
                ),
                array(
                    "type" => "close_div",
                    'nodescription' => true
                ),
                array(
                    'type' => 'tab',
                    'name' => __('Advanced', 'avia_framework'),
                    'nodescription' => true
                ),
                array(
                    'type' => 'toggle_container',
                    'nodescription' => true
                ),
                array(
                    'type' => 'template',
                    'template_id' => 'screen_options_toggle',
                    'lockable' => true
                ),
                array(
                    'type' => 'template',
                    'template_id' => 'developer_options_toggle',
                    'args' => array('sc' => $this)
                ),
                array(
                    'type' => 'toggle_container_close',
                    'nodescription' => true
                ),
                array(
                    'type' => 'tab_close',
                    'nodescription' => true
                ),
                array(
                    'type' => 'template',
                    'template_id' => 'element_template_selection_tab',
                    'args' => array('sc' => $this)
                ),
                array(
                    'type' => 'tab_container_close',
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
            $params = parent::editor_element($params);
            $params['content'] = null; //remove to allow content elements

            return $params;
        }

        /**
         * Create custom stylings
         *
         * @since 4.8.4
         * @param array $args
         * @return array
         */
        protected function get_element_styles(array $args) {
            $result = parent::get_element_styles($args);

            extract($result);

            $default = $this->sync_sc_defaults_array();

            $locked = array();
            Avia_Element_Templates()->set_locked_attributes($atts, $this, $shortcodename, $default, $locked, $content);
            Avia_Element_Templates()->add_template_class($meta, $atts, $default);

            $atts = shortcode_atts($default, $atts, $this->config['shortcode']);

            $element_styling->create_callback_styles($atts);

            $classes = array(
                'av-mmbreadcrumb',
                $element_id
            );

            $element_styling->add_classes('container', $classes);
            $element_styling->add_classes_from_array('container', $meta, 'custom_class');
            $element_styling->add_responsive_classes('container', 'hide_element', $atts);

            if (function_exists('avia_blog_class_string')) {
                $element_styling->add_classes('container', avia_blog_class_string());
            }

            if (!empty($atts['custom_font']) && 'custom-color-heading' == $atts['color']) {
                $element_styling->add_styles('avia-breadcrumbs', array('color' => $atts['custom_font']));
                $element_styling->add_styles('avia-breadcrumbs-content', array('color' => $atts['custom_font']));
                $element_styling->add_styles('ahref-breadcrumbs', array('color' => $atts['custom_font']));
            }
            if (!empty($atts['style']) && 'left' == $atts['style']) {
                $element_styling->add_styles('container', array('text-align' => $atts['style']));
            }
            $selectors = array(
                'container' => ".av-mmbreadcrumb.{$element_id}",
                'avia-breadcrumbs' => ".av-mmbreadcrumb.{$element_id} .avia-breadcrumbs",
                'avia-breadcrumbs-content' => ".av-mmbreadcrumb.{$element_id} .avia-breadcrumbs > *",
                'ahref-breadcrumbs' => ".av-mmbreadcrumb.{$element_id} .avia-breadcrumbs a",
            );

            $element_styling->add_selectors($selectors);

            $result['default'] = $default;
            $result['atts'] = $atts;
            $result['content'] = $content;
            $result['meta'] = $meta;

            return $result;
        }

        /**
         * Frontend Shortcode Handler
         *
         * @param array $atts array of attributes
         * @param string $content text within enclosing form of shortcode element
         * @param string $shortcodename the shortcode found, when == callback name
         * @return string $output returns the modified html string
         */
        function shortcode_handler($atts, $content = '', $shortcodename = '', $meta = '') {
            global $post;

            $result = $this->get_element_styles(compact(array('atts', 'content', 'shortcodename', 'meta')));

            extract($result);
            extract($atts);
            $breadcrumbs = Avia_Breadcrumb_Trail()->get_trail(array('separator' => '<span class="av-icon-char" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>', 'richsnippet' => true));
            $breadcrumbs = "<div class ='mm-breadcrumbs-detail' >" . ShortcodeHelper::avia_apply_autop(ShortcodeHelper::avia_remove_autop($breadcrumbs)) . "</div>";
            $breadcrumbs = str_replace('Home', 'Hawaii Tours', $breadcrumbs);
            $style_tag = $element_styling->get_style_tag($element_id);
            $container_class = $element_styling->get_class_string('container');

            $output = '';
            $output .= $style_tag;
            $output .= "<div {$meta['custom_el_id']} class='{$container_class}'>";
            $output .= $breadcrumbs;
            $output .= '</div>';

            return $output;
        }

    }

}

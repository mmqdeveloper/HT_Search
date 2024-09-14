<?php
/**
 * Blog Posts
 * 
 * Displays Posts from your Blog
 */
if (!defined('ABSPATH')) {
    exit;
}    // Exit if accessed directly


if (!class_exists('mm_list_restaurants')) {

    class mm_list_restaurants extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['version'] = '1.0';
            $this->config['self_closing'] = 'yes';
            $this->config['base_element'] = 'yes';

            $this->config['name'] = __('List Restaurants', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . 'sc-blog.png';
            $this->config['order'] = 40;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'mm_restaurants';
            $this->config['tooltip'] = __('Displays list Restaurants', 'avia_framework');
            $this->config['preview'] = false;
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
            //load css
            //wp_enqueue_style('avia-module-blog', AviaBuilder::$path['pluginUrlRoot'] . 'avia-shortcodes/blog/blog.css', array('avia-layout'), false);
            //wp_enqueue_style('avia-module-postslider', AviaBuilder::$path['pluginUrlRoot'] . 'avia-shortcodes/postslider/postslider.css', array('avia-layout'), false);
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
                    'type' => 'tab',
                    'name' => __('Content', 'avia_framework'),
                    'nodescription' => true
                ),
                array(
                    'type' => 'template',
                    'template_id' => 'toggle_container',
                    'templates_include' => array(
                        $this->popup_key('content_blog'),
                        $this->popup_key('content_filter')
                    ),
                    'nodescription' => true
                ),
                array(
                    'type' => 'tab_close',
                    'nodescription' => true
                ),
                array(
                    'type' => 'tab',
                    'name' => __('Styling', 'avia_framework'),
                    'nodescription' => true
                ),
                array(
                    'type' => 'template',
                    'template_id' => 'toggle_container',
                    'templates_include' => array(
                        $this->popup_key('styling_appearance'),
                        $this->popup_key('styling_pagination')
                    ),
                    'nodescription' => true
                ),
                array(
                    'type' => 'tab_close',
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
                    'template_id' => 'lazy_loading_toggle',
                    'lockable' => true
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
                    'args' => array(
                        'sc' => $this
                    )
                ),
                array(
                    'type' => 'tab_container_close',
                    'nodescription' => true
                )
            );
        }

        /**
         * Create and register templates for easier maintainance
         * 
         * @since 4.6.4
         */
        protected function register_dynamic_templates() {

            /**
             * Content Tab
             * ===========
             */
            $c = array(
                array(
                    'name' => __('Restaurants Style', 'avia_framework'),
                    'desc' => __('Choose the default Restaurants layout here.', 'avia_framework'),
                    'id' => 'blog_style',
                    'type' => 'select',
                    'std' => 'single-big',
                    'lockable' => true,
                    'subtype' => array(
                        __('Grid Layout', 'avia_framework') => 'blog-grid',
                        __('List Layout - Excerpt (Title, meta information and excerpt only)', 'avia_framework') => 'bloglist-excerpt',
//												__( 'No Sidebar', 'avia_framework' )	=> 'fullsize'
                    )
                ),
                array(
                    'name' => __('Define Restaurants Grid layout', 'avia_framework'),
                    'desc' => __('Do you want to display a read more link?', 'avia_framework'),
                    'id' => 'contents',
                    'type' => 'select',
                    'std' => 'excerpt',
                    'lockable' => true,
                    'required' => array('blog_style', 'equals', 'blog-grid'),
                    'subtype' => array(
                        __('Title and Excerpt', 'avia_framework') => 'excerpt',
                        __('Title and Excerpt + Read More Link', 'avia_framework') => 'excerpt_read_more',
                        __('Only Title', 'avia_framework') => 'title',
                        __('Only Title + Read More Link', 'avia_framework') => 'title_read_more',
                        __('Only excerpt', 'avia_framework') => 'only_excerpt',
                        __('Only excerpt + Read More Link', 'avia_framework') => 'only_excerpt_read_more',
                        __('No Title and no excerpt', 'avia_framework') => 'no'
                    )
                )
            );

            if (current_theme_supports('add_avia_builder_post_type_option')) {
                $element = array(
                    'type' => 'template',
                    'template_id' => 'avia_builder_post_type_option',
                    'lockable' => true,
                    'required' => array('blog_type', 'equals', 'taxonomy'),
                );

                array_splice($c, 2, 0, array($element));
            }

            $template = array(
                array(
                    'type' => 'template',
                    'template_id' => 'toggle',
                    'title' => __('Select Entries', 'avia_framework'),
                    'content' => $c
                ),
            );

            AviaPopupTemplates()->register_dynamic_template($this->popup_key('content_blog'), $template);

            $c = array(
                array(
                    'type' => 'template',
                    'template_id' => 'date_query',
                    'lockable' => true
                ),
                array(
                    'name' => __('Offset Number', 'avia_framework'),
                    'desc' => __('The offset determines where the query begins pulling posts. Useful if you want to remove a certain number of posts because you already query them with another blog or magazine element.', 'avia_framework'),
                    'id' => 'offset',
                    'type' => 'select',
                    'std' => '0',
                    'lockable' => true,
                    'subtype' => AviaHtmlHelper::number_array(1, 100, 1, array(__('Deactivate offset', 'avia_framework') => '0', __('Do not allow duplicate posts on the entire page (set offset automatically)', 'avia_framework') => 'no_duplicates'))
                ),
                array(
                    'name' => __('Conditional display', 'avia_framework'),
                    'desc' => __('When should the element be displayed?', 'avia_framework'),
                    'id' => 'conditional',
                    'type' => 'select',
                    'std' => '',
                    'lockable' => true,
                    'subtype' => array(
                        __('Always display the element', 'avia_framework') => '',
                        __('Remove element if the user navigated away from page 1 to page 2,3,4 etc ', 'avia_framework') => 'is_subpage'
                    )
                )
            );

            $template = array(
                array(
                    'type' => 'template',
                    'template_id' => 'toggle',
                    'title' => __('Filter', 'avia_framework'),
                    'content' => $c
                ),
            );

            AviaPopupTemplates()->register_dynamic_template($this->popup_key('content_filter'), $template);

            /**
             * Styling Tab
             * ===========
             */
            $c = array(
                array(
                    'name' => __('Restaurants List Width', 'avia_framework'),
                    'desc' => __('Define the width of the list', 'avia_framework'),
                    'id' => 'bloglist_width',
                    'type' => 'select',
                    'std' => '',
                    'lockable' => true,
                    'required' => array('blog_style', 'contains', 'bloglist'),
                    'subtype' => array(
                        __('Auto', 'avia_framework') => '',
                        __('Force Fullwidth', 'avia_framework') => 'force_fullwidth'
                    )
                ),
                array(
                    'name' => __('Restaurants Grid Columns', 'avia_framework'),
                    'desc' => __('How many columns do you want to display?', 'avia_framework'),
                    'id' => 'columns',
                    'type' => 'select',
                    'std' => '3',
                    'lockable' => true,
                    'required' => array('blog_style', 'equals', 'blog-grid'),
                    'subtype' => AviaHtmlHelper::number_array(1, 5, 1)
                ),
                array(
                    'name' => __('Preview Image Size', 'avia_framework'),
                    'desc' => __('Set the image size of the preview images', 'avia_framework'),
                    'id' => 'preview_mode',
                    'type' => 'select',
                    'std' => 'auto',
                    'lockable' => true,
                    'subtype' => array(
                        __('Set the preview image size automatically based on column or layout width', 'avia_framework') => 'auto',
                        __('Choose the preview image size manually (select thumbnail size)', 'avia_framework') => 'custom'
                    )
                ),
                array(
                    'name' => __('Select custom preview image size', 'avia_framework'),
                    'desc' => __('Choose image size for Preview Image', 'avia_framework'),
                    'id' => 'image_size',
                    'type' => 'select',
                    'std' => 'portfolio',
                    'lockable' => true,
                    'required' => array('preview_mode', 'equals', 'custom'),
                    'subtype' => AviaHelper::get_registered_image_sizes(array('logo'))
                ),
                array(
                    "desc" => __("Show sidebar", 'avia_framework'),
                    "id" => "show_siderbar",
                    "std" => "",
                    'required' => array('blog_style', 'equals', 'bloglist-excerpt'),
                    "type" => "checkbox"),
            );

            $template = array(
                array(
                    'type' => 'template',
                    'template_id' => 'toggle',
                    'title' => __('Appearance', 'avia_framework'),
                    'content' => $c
                ),
            );

            AviaPopupTemplates()->register_dynamic_template($this->popup_key('styling_appearance'), $template);


            $c = array(
                array(
                    'name' => __('Post Number', 'avia_framework'),
                    'desc' => __('How many items should be displayed per page?', 'avia_framework'),
                    'id' => 'items',
                    'type' => 'select',
                    'std' => '3',
                    'lockable' => true,
                    'subtype' => AviaHtmlHelper::number_array(1, 100, 1, array('All' => '-1'))
                ),
                array(
                    'name' => __('Pagination', 'avia_framework'),
                    'desc' => __('Should a pagination be displayed? Pagination might not work as expected when there is more than one blog posts element on a page, a post or on the blog page.', 'avia_framework'),
                    'id' => 'paginate',
                    'type' => 'select',
                    'std' => 'yes',
                    'lockable' => true,
                    'subtype' => array(
                        __('yes', 'avia_framework') => 'yes',
                        __('no', 'avia_framework') => 'no',
                        __('Load more button', 'avia_framework') => 'loadmore'
                    )
                )
            );

            $template = array(
                array(
                    'type' => 'template',
                    'template_id' => 'toggle',
                    'title' => __('Pagination', 'avia_framework'),
                    'content' => $c
                ),
            );

            AviaPopupTemplates()->register_dynamic_template($this->popup_key('styling_pagination'), $template);
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
         * Frontend Shortcode Handler
         *
         * @param array $atts array of attributes
         * @param string $content text within enclosing form of shortcode element
         * @param string $shortcodename the shortcode found, when == callback name
         * @return string $output returns the modified html string
         */
        function shortcode_handler($atts, $content = '', $shortcodename = '', $meta = '') {
            global $avia_config, $more;

            $default = array(
                'blog_style' => '',
                'bloglist_width' => '',
                'columns' => 3,
                'blog_type' => 'posts',
                'items' => '16',
                'paginate' => 'yes',
                'categories' => '',
                'preview_mode' => 'auto',
                'image_size' => 'portfolio',
                'show_siderbar' => '',
                'taxonomy' => 'restaurant_island',
                'post_type' => 'restaurant',
                'contents' => 'excerpt',
                'content_length' => 'content',
                'offset' => '0',
                'conditional' => '',
                'date_filter' => '',
                'date_filter_start' => '',
                'date_filter_end' => '',
                'date_filter_format' => 'mm / dd / yy',
                'lazy_loading' => 'disabled'
            );

            $locked = array();
            Avia_Element_Templates()->set_locked_attributes($atts, $this, $shortcodename, $default, $locked);
            Avia_Element_Templates()->add_template_class($meta, $atts, $default);

            $screen_sizes = AviaHelper::av_mobile_sizes($atts); //return $av_font_classes, $av_title_font_classes and $av_display_classes 
            extract($screen_sizes);

            if (empty($atts['categories'])) {
                $atts['categories'] = '';
            }

            if (isset($atts['link']) && isset($atts['blog_type']) && $atts['blog_type'] == 'taxonomy') {
                $atts['link'] = explode(',', $atts['link'], 2);
                $atts['taxonomy'] = $atts['link'][0];

                if (!empty($atts['link'][1])) {
                    $atts['categories'] = $atts['link'][1];
                } else if (!empty($atts['taxonomy'])) {
                    $term_args = array(
                        'taxonomy' => $atts['taxonomy'],
                        'hide_empty' => true
                    );
                    /**
                     * To display private posts you need to set 'hide_empty' to false, 
                     * otherwise a category with ONLY private posts will not be returned !!
                     * 
                     * You also need to add post_status 'private' to the query params of filter avia_post_slide_query.
                     * 
                     * @since 4.4.2
                     * @added_by Günter
                     * @param array $term_args 
                     * @param array $atts 
                     * @param boolean $ajax
                     * @return array
                     */
                    $term_args = apply_filters('avf_av_blog_term_args', $term_args, $atts, $content);

                    $taxonomy_terms_obj = AviaHelper::get_terms($term_args);

                    foreach ($taxonomy_terms_obj as $taxonomy_term) {
                        $atts['categories'] .= $taxonomy_term->term_id . ',';
                    }
                }
            }

            $atts = shortcode_atts($default, $atts, $this->config['shortcode']);

            $page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
            if (!$page) {
                $page = 1;
            }

            /**
             * Skip blog queries, if element will not be displayed
             */
            if ($atts['conditional'] == 'is_subpage' && $page != 1) {
                return '';
            }
            if ($atts['blog_style'] == 'blog-grid') {
                $atts['class'] = $meta['el_class'];
                $atts['type'] = 'grid';
                $atts = array_merge($atts, $screen_sizes);

                /**
                 * @since 4.5.5
                 * @return array
                 */
                $atts = apply_filters('avf_post_slider_args', $atts, $this->config['shortcode'], $this);
                //using the post slider with inactive js will result in displaying a nice post grid
                $slider = new mm_restaurant_slider($atts);

                $old_page = null;
                $is_single = is_single();

                if ('yes' == $atts['paginate']) {
                    if ($is_single && isset($_REQUEST['av_sc_blog_page']) && is_numeric($_REQUEST['av_sc_blog_page'])) {
                        $old_page = get_query_var('paged');
                        set_query_var('paged', $_REQUEST['av_sc_blog_page']);
                    }
                }

                $slider->query_entries($atts);

                if ('yes' == $atts['paginate'] && $is_single) {
                    add_filter('avf_pagination_link_method', array($this, 'handler_pagination_link_method'), 10, 3);
                }

                $html = $slider->html();

                if ('yes' == $atts['paginate'] && $is_single) {
                    remove_filter('avf_pagination_link_method', array($this, 'handler_pagination_link_method'), 10);
                }

                if (!is_null($old_page)) {
                    if ($old_page != 0) {
                        set_query_var('paged', $old_page);
                    } else {
                        remove_query_arg('paged');
                    }
                }

                return $html;
            }

            $old_page = null;
            $is_single = is_single();

            if ('yes' == $atts['paginate']) {
                if ($is_single && isset($_REQUEST['av_sc_blog_page']) && is_numeric($_REQUEST['av_sc_blog_page'])) {
                    $old_page = get_query_var('paged');
                    set_query_var('paged', $_REQUEST['av_sc_blog_page']);
                }
            }
            $this->query_entries($atts);

            if ('yes' == $atts['paginate'] && $is_single) {
                add_filter('avf_pagination_link_method', array($this, 'handler_pagination_link_method'), 10, 3);
            }

            $avia_config['blog_style'] = $atts['blog_style'];
            $avia_config['preview_mode'] = $atts['preview_mode'];
            $avia_config['image_size'] = $atts['image_size'];
            $avia_config['blog_content'] = $atts['content_length'];
            $avia_config['remove_pagination'] = $atts['paginate'] === 'yes' ? false : true;
            $avia_config['alb_html_lazy_loading'] = $atts['lazy_loading'];

            /**
             * Force supress of pagination if element will be hidden on foillowing pages
             */
            if ($atts['conditional'] == 'is_subpage' && $page == 1) {
                $avia_config['remove_pagination'] = true;
            }

            $more = 0;

            ob_start(); //start buffering the output instead of echoing it
            //get_template_part('includes/loop', 'restaurant');
            $key_search = $_GET['key_search'];
            $key_island = $_GET['island'];
            $key_cate = $_GET['cate'];
            if ($atts['preview_mode'] == 'auto') {
                $image_size = 'portfolio';
            } else {
                $image_size = $atts['image_size'];
            }
            if (!empty($atts['show_siderbar'])) {
                ?>
                <div id="list_restaurants" class="mm-list-restaurants flex_column av_two_third  flex_column_div av-zero-column-padding first" style="border-radius:0px; ">
                    <?php
                }
                echo '<div class="mm-list-restaurants-inner">';
                get_template_part('includes/loop', 'restaurant');
                echo '</div>';
                if( empty( $avia_config['remove_pagination'] ) )
                {
                    echo "<div class='{$atts['blog_style']} restaurant-pagination'>" . restaurant_pagination( '', 'nav' ) . '</div>';
                }
                if (!empty($atts['show_siderbar'])) {
                    ?>
                </div>
                <div class="flex_column av_one_third  flex_column_div av-zero-column-padding sidebar-restaurant" style="border-radius:0px; ">
                    <div class="search-field">
                        <input type="text" id="s" name="s" value="<?php echo $key_search ?>" placeholder="Search" autocomplete="off">
                        <input type="submit" value="" id="search_restaurants" class="button avia-font-entypo-fontello">
                    </div>
                    <?php
                    $restaurant_island = get_terms(array(
                        'taxonomy' => 'restaurant_island',
                        'hide_empty' => true
                    ));

                    if (!empty($restaurant_island)) :
                        echo "<h3>Island</h3>";
                        echo "<ul class='list-restaurant-term restaurant-island'>";
                        echo "<li class='all_island ". ($key_island == 'all-island' ? ' active' : ($key_island == null ? ' active' : ''))."' data-items='". $atts['items'] ."' data-id='-1' data-island='all-island'>ALL</li>";
                        foreach ($restaurant_island as $island) {
                            echo "<li class='item_island ".mm_convert_title_to_slug($island->name) . ($key_island == $island->slug ? ' active': '') ."' data-items='". $atts['items'] ."' data-id='" . $island->term_id . "'data-island='" . $island->slug . "'>" . esc_html($island->name) . "</li>";
                        }
                        if (count($restaurant_island) > 4) {
                            echo '<span class="list-restaurant-term-more-btn">More</span>';
                        }
                        echo "</ul>";
                    endif;
                    ?>
                    <?php
                    $restaurant_categories_parent = get_terms(array(
                        'taxonomy' => 'restaurant_categories',
                        'hide_empty' => true,
                        'parent'     => 0,
                    ));

                    if (!empty($restaurant_categories_parent)) :
                        echo "<h3>Categories</h3>";
                        echo "<ul class='list-restaurant-term restaurant-categories restaurant-categories-parent'>";
                        echo "<li class='all_categories ".($key_cate == 'all-categories' ? ' active': ($key_cate == null ? ' active' : ''))."' data-id='-1' data-cate='all-categories'>ALL</li>";
                        $islands = array(
                            'oahu',
                            'maui',
                            'kauai',
                            'big island'
                        );
                        foreach ($restaurant_categories_parent as $categories_parent) {
                            $restaurant_categories_child = get_terms(array(
                                'taxonomy' => 'restaurant_categories',
                                'hide_empty' => true,
                                'parent'     => $categories_parent->term_id,
                            ));
                            $cls_island = '';
                            if (in_array(strtolower($categories_parent->name), $islands)) {
                                $cls_island = 'mm_cate_island';
                            }
                            if (!empty($restaurant_categories_child)) {
                                echo "<li class='is-parent item_cate ".$cls_island." ".($key_cate == $categories_parent->slug ? ' active': '')."' data-id='" . $categories_parent->term_id . "' data-cate='" . $categories_parent->slug . "'>" . esc_html($categories_parent->name) . "<span class='dropdown-btn-restaurant'><svg width='16' height='17' viewBox='0 0 16 17' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M2.66602 5.34497L7.99935 10.6783L13.3327 5.34497' stroke='#636363' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg></span></li>";
                                echo "<ul class='list-restaurant-term restaurant-categories restaurant-categories-child'>";
                                foreach ($restaurant_categories_child as $category_child) {
                                    echo "<li class='item_cate' data-id='" . $category_child->term_id . "' data-cate='" . $category_child->slug . "'>" . esc_html($category_child->name) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "<li class='item_cate ".$cls_island." ".($key_cate == $categories_parent->slug ? ' active': '')."' data-id='" . $categories_parent->term_id . "' data-cate='" . $categories_parent->slug . "'>" . esc_html($categories_parent->name) . "</li>";
                            }
                        }
                        // if (count($restaurant_categories_parent) > 4) {
                        //     echo '<span class="list-restaurant-term-more-btn">More</span>';
                        // }
                        echo "</ul>";
                    endif;
                    ?>
                    <?php
                    // $restaurant_tags = get_terms(array(
                    //     'taxonomy' => 'restaurant_tags',
                    //     'hide_empty' => true
                    // ));

                    // if (!empty($restaurant_tags)) :
                    //     echo "<h3>Tags</h3>";
                    //     echo "<ul class='list-restaurant-term restaurant-tags'>";
                    //     echo "<li class='all_tags active' data-id='-1'>ALL</li>";
                    //     foreach ($restaurant_tags as $tags) {
                    //         echo "<li class='item_cate' data-id='" . $tags->term_id . "'>" . esc_html($tags->name) . "</li>";
                    //     }
                    //     if (count($restaurant_tags) > 4) {
                    //         echo '<span class="list-restaurant-term-more-btn">More</span>';
                    //     }
                    //     echo "</ul>";
                    // endif;
                    ?>
                </div>
                <?php
            }
            $output = ob_get_clean();
            unset($avia_config['alb_html_lazy_loading']);
            wp_reset_query();

            if ('yes' == $atts['paginate'] && $is_single) {
                remove_filter('avf_pagination_link_method', array($this, 'handler_pagination_link_method'), 10);
            }

            if (!is_null($old_page)) {
                if ($old_page != 0) {
                    set_query_var('paged', $old_page);
                } else {
                    remove_query_arg('paged');
                }
            }

            avia_set_layout_array();

            if ($output) {
                $extraclass = function_exists('avia_blog_class_string') ? avia_blog_class_string() : '';
                $extraclass .= $atts['bloglist_width'] == 'force_fullwidth' ? ' av_force_fullwidth' : '';
                $extraclass .= !empty($meta['custom_class']) ? ' ' . $meta['custom_class'] : '';
                $markup = avia_markup_helper(array('context' => 'blog', 'echo' => false, 'custom_markup' => $meta['custom_markup']));

                $output = "<div {$meta['custom_el_id']} class='av-alb-blogposts template-blog {$extraclass} {$av_display_classes}' {$markup}>{$output}</div>";
            }

            return Av_Responsive_Images()->make_content_images_responsive($output);
        }

        /**
         * 
         * @since < 4.0
         * @param array $params
         */
        protected function query_entries(array $params) {
            global $avia_config;

            $query = array();

            if (!empty($params['categories']) && is_string($params['categories'])) {
                //get the categories
                $terms = explode(',', $params['categories']);
            }

            $page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
            if (!$page || $params['paginate'] == 'no') {
                $page = 1;
            }

            if ($params['offset'] == 'no_duplicates') {
                $params['offset'] = 0;
                $no_duplicates = true;
            }

            //wordpress 4.4 offset fix
            if ($params['offset'] == 0) {
                $params['offset'] = false;
            } else {
                //if the offset is set the paged param is ignored. therefore we need to factor in the page number
                $params['offset'] = $params['offset'] + ( ( $page - 1 ) * $params['items'] );
            }

            $date_query = array();
            if ('date_filter' == $params['date_filter']) {
                $date_query = AviaHelper::add_date_query($date_query, $params['date_filter_start'], $params['date_filter_end'], $params['date_filter_format']);
            }

            //if we find categories perform complex query, otherwise simple one
            if (isset($terms[0]) && !empty($terms[0]) && !is_null($terms[0]) && $terms[0] != 'null' && !empty($params['taxonomy'])) {
                $query = array(
                    'paged' => $page,
                    'posts_per_page' => $params['items'],
                    'offset' => $params['offset'],
                    'post__not_in' => (!empty($no_duplicates) ) ? $avia_config['posts_on_current_page'] : array(),
                    'post_type' => 'restaurant',
                    'date_query' => $date_query,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $params['taxonomy'],
                            'field' => 'id',
                            'terms' => $terms,
                            'operator' => 'IN'
                        )
                    )
                );
            } else {
                $query = array(
                    'paged' => $page,
                    'posts_per_page' => $params['items'],
                    'offset' => $params['offset'],
                    'post__not_in' => (!empty($no_duplicates) ) ? $avia_config['posts_on_current_page'] : array(),
                    'post_type' => 'restaurant',
                    'date_query' => $date_query
                );
            }

            /**
             * 
             * @since < 4.0
             * @param array $query
             * @param array $params
             * @return array
             */
            $query = apply_filters('avia_blog_post_query', $query, $params);

            $results = query_posts($query);

            // store the queried post ids in
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    $avia_config['posts_on_current_page'][] = get_the_ID();
                }
            }
        }

        /**
         * Using this element not in a page ( = is_single() ) returns a wrong pagination
         * 
         * @since 4.5.6
         * @param string $method
         * @param type $pages
         * @param type $wrapper
         * @return string
         */
        public function handler_pagination_link_method($method, $pages, $wrapper) {
            if (is_single() || ( 'get_pagenum_link' == $method )) {
                $method = 'mm_list_restaurants::add_blog_pageing';
            }

            return $method;
        }

        /**
         * Called when this element not in a page ( = is_single() ). 
         * Add our custom page parameter.
         * 
         * @since 4.5.6
         * @param int $page
         * @return string
         */
        static public function add_blog_pageing($page) {
            $link = get_pagenum_link(1);

            if ($page != 1) {
                $link = add_query_arg(array('av_sc_blog_page' => $page), $link);
            } else {
                $link = remove_query_arg('av_sc_blog_page', $link);
            }

            return $link;
        }

    }

}
if (!class_exists('mm_restaurant_slider')) {

    class mm_restaurant_slider {

        static $slide = 0;
        protected $atts;
        protected $entries;

        function __construct($atts = array()) {
            $this->atts = shortcode_atts(array('type' => 'slider', // can also be used as grid
                'style' => '', //no_margin
                'columns' => '4',
                'items' => '16',
                'taxonomy' => 'restaurant_island',
                'post_type' => 'restaurant',
                'contents' => 'excerpt',
                'preview_mode' => 'auto',
                'image_size' => 'portfolio',
                'autoplay' => 'no',
                'animation' => 'fade',
                'paginate' => 'no',
                'use_main_query_pagination' => 'no',
                'interval' => 5,
                'class' => '',
                'categories' => array(),
                'custom_query' => array(),
                'offset' => 0,
                'custom_markup' => ''
                    ), $atts, 'av_postslider');
        }

        public function html() {
            global $avia_config;

            $output = "";

            if (empty($this->entries) || empty($this->entries->posts))
                return $output;

            mm_restaurant_slider::$slide++;
            extract($this->atts);

            if ($preview_mode == 'auto')
                $image_size = 'portfolio';
            $extraClass = 'first';
            $grid = 'one_third';
            $post_loop_count = 1;
            $loop_counter = 1;
            $autoplay = $autoplay == "no" ? false : true;
            $total = $columns % 2 ? "odd" : "even";

            switch ($columns) {
                case "1": $grid = 'av_fullwidth';
                    if ($preview_mode == 'auto')
                        $image_size = 'large';
                    break;
                case "2": $grid = 'av_one_half';
                    break;
                case "3": $grid = 'av_one_third';
                    break;
                case "4": $grid = 'av_one_fourth';
                    if ($preview_mode == 'auto')
                        $image_size = 'portfolio_small';
                    break;
                case "5": $grid = 'av_one_fifth';
                    if ($preview_mode == 'auto')
                        $image_size = 'portfolio_small';
                    break;
            }


            $data = AviaHelper::create_data_string(array('autoplay' => $autoplay, 'interval' => $interval, 'animation' => $animation, 'show_slide_delay' => 90));

            $thumb_fallback = "";
            $markup = avia_markup_helper(array('context' => 'blog', 'echo' => false, 'custom_markup' => $custom_markup));
            $output .= "<div id='mm-list-restaurants' {$data} class='avia-content-slider avia-content-{$type}-active avia-content-slider" . mm_restaurant_slider::$slide . " avia-content-slider-{$total} {$class}' $markup>";
            $output .= "<div id='list_restaurants' class='avia-content-slider-inner'>";

            foreach ($this->entries->posts as $entry) {
                $the_id = $entry->ID;
                $parity = $loop_counter % 2 ? 'odd' : 'even';
                $last = $this->entries->post_count == $post_loop_count ? " post-entry-last " : "";
                $post_class = "post-entry post-entry-{$the_id} slide-entry-overview slide-loop-{$post_loop_count} slide-parity-{$parity} {$last}";
                $link = get_permalink($the_id);
                $excerpt = "";
                $title = '';
                $show_meta = !is_post_type_hierarchical($entry->post_type);
                $commentCount = get_comments_number($the_id);
                $thumbnail = get_the_post_thumbnail($the_id, $image_size);
                $format = get_post_format($the_id);
                if (empty($format))
                    $format = "standard";

                if ($thumbnail) {
                    $thumb_fallback = $thumbnail;
                    $thumb_class = "real-thumbnail";
                } else {
                    $thumbnail = "<span class=' fallback-post-type-icon' " . av_icon_string($format) . "></span><span class='slider-fallback-image'>{{thumbnail}}</span>";
                    $thumb_class = "fake-thumbnail";
                }


                $permalink = '<div class="read-more-link"><a href="' . get_permalink($the_id) . '" class="more-link">' . __('Learn more', 'avia_framework') . '</a></div>';
                $prepare_excerpt = !empty($entry->post_excerpt) ? $entry->post_excerpt : avia_backend_truncate($entry->post_content, apply_filters('avf_postgrid_excerpt_length', 60), apply_filters('avf_postgrid_excerpt_delimiter', " "), "�", true, '');

                if ($format == 'link') {
                    $current_post = array();
                    $current_post['content'] = $entry->post_content;
                    $current_post['title'] = $entry->post_title;

                    if (function_exists('avia_link_content_filter')) {
                        $current_post = avia_link_content_filter($current_post);
                    }

                    $link = $current_post['url'];
                }


                switch ($contents) {
                    case "excerpt":
                        $excerpt = $prepare_excerpt;
                        $title = $entry->post_title;
                        break;
                    case "excerpt_read_more":
                        $excerpt = $prepare_excerpt;
                        $excerpt .= $permalink;
                        $title = $entry->post_title;
                        break;
                    case "title":
                        $excerpt = '';
                        $title = $entry->post_title;
                        break;
                    case "title_read_more":
                        $excerpt = $permalink;
                        $title = $entry->post_title;
                        break;
                    case "only_excerpt":
                        $excerpt = $prepare_excerpt;
                        $title = '';
                        break;
                    case "only_excerpt_read_more":
                        $excerpt = $prepare_excerpt;
                        $excerpt .= $permalink;
                        $title = '';
                        break;
                    case "no":
                        $excerpt = '';
                        $title = '';
                        break;
                }

                if ($loop_counter == 1)
                    $output .= "<div class='slide-entry-wrap'>";

                $post_format = get_post_format($the_id) ? get_post_format($the_id) : 'standard';

                $markup = avia_markup_helper(array('context' => 'entry', 'echo' => false, 'id' => $the_id, 'custom_markup' => $custom_markup));
                $output .= "<article class='slide-entry flex_column {$style} {$post_class} {$grid} {$extraClass} {$thumb_class}' $markup>";
                $output .= $thumbnail ? "<a href='{$link}' data-rel='slide-" . mm_restaurant_slider::$slide . "' class='slide-image' title=''>{$thumbnail}</a>" : "";

                if ($post_format == "audio") {
                    $current_post = array();
                    $current_post['content'] = $entry->post_content;
                    $current_post['title'] = $entry->post_title;

                    $current_post = apply_filters('post-format-' . $post_format, $current_post);

                    if (!empty($current_post['before_content']))
                        $output .= '<div class="big-preview single-big audio-preview">' . $current_post['before_content'] . '</div>';
                }

                $output .= "<div class='slide-content'>";

                $markup = avia_markup_helper(array('context' => 'entry_title', 'echo' => false, 'id' => $the_id, 'custom_markup' => $custom_markup));
                $output .= '<header class="entry-content-header">';
                $output .= !empty($title) ? "<h3 class='slide-entry-title entry-title' $markup><a href='{$link}' title='" . esc_attr(strip_tags($title)) . "'>" . $title . "</a></h3>" : '';
                $output .= '</header>';

                $markup = avia_markup_helper(array('context' => 'entry_content', 'echo' => false, 'id' => $the_id, 'custom_markup' => $custom_markup));
                $excerpt = apply_filters('avf_post_slider_entry_excerpt', $excerpt, $prepare_excerpt, $permalink, $entry);
                $output .= !empty($excerpt) ? "<div class='slide-entry-excerpt entry-content' $markup>" . $excerpt . "</div>" : "";

                $output .= "</div>";
                $output .= '<footer class="entry-footer"></footer>';
                $output .= "</article>";

                $loop_counter++;
                $post_loop_count++;
                $extraClass = "";

                if ($loop_counter > $columns) {
                    $loop_counter = 1;
                    $extraClass = 'first';
                }

                if ($loop_counter == 1 || !empty($last)) {
                    $output .= "</div>";
                }
            }

            $output .= "</div>";

            if ($post_loop_count - 1 > $columns && $type == 'slider') {
                $output .= $this->slide_navigation_arrows();
            }

            if ($use_main_query_pagination == 'yes' && $paginate == "yes") {
                global $wp_query;
                $avia_pagination = restaurant_pagination($wp_query->max_num_pages, 'nav');
            } else if ($paginate == "yes") {
                $avia_pagination = restaurant_pagination($this->entries->max_num_pages, 'nav');
            }

            if (!empty($avia_pagination))
                $output .= "<div class='pagination-wrap pagination-slider'>{$avia_pagination}</div>";
            if($paginate == "loadmore"){
                $max_page = 0;
                $style_more = 'display:none';
                $max_page = $this->entries->max_num_pages;
                if ($max_page > 1) {
                    $style_more = '';
                }
                $data_atts = esc_attr(json_encode($this->atts));
                $output .= "<div id='load-more' class='av-masonry-pagination mm-list-restaurants-load-more av-masonry-load-more' style='visibility: visible;opacity: 1; cursor: pointer; color: #2189c1; ".$style_more."' data-page='2' data-max_page='".$max_page."' data-atts ='".$data_atts."'>Load more <div class='custom-loading-icon' style='display: none;'></div></div>";
            }

            $output .= "</div>";

            $output = str_replace('{{thumbnail}}', $thumb_fallback, $output);

            wp_reset_query();
            return $output;
        }

        protected function slide_navigation_arrows() {
            $html = "";
            $html .= "<div class='avia-slideshow-arrows avia-slideshow-controls'>";
            $html .= "<a href='#prev' class='prev-slide' " . av_icon_string('prev_big') . ">" . __('Previous', 'avia_framework') . "</a>";
            $html .= "<a href='#next' class='next-slide' " . av_icon_string('next_big') . ">" . __('Next', 'avia_framework') . "</a>";
            $html .= "</div>";

            return $html;
        }

        //fetch new entries
        public function query_entries($params = array()) {
            global $avia_config;
            if (empty($params))
                $params = $this->atts;

            if (empty($params['custom_query'])) {
                $query = array();

                if (!empty($params['categories'])) {
                    //get the portfolio categories
                    $terms = explode(',', $params['categories']);
                }
                $page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
                if (!$page || $params['paginate'] == 'no')
                    $page = 1;

                //if we find no terms for the taxonomy fetch all taxonomy terms
                if (empty($terms[0]) || is_null($terms[0]) || $terms[0] === "null") {
                    $terms = array();
                    $allTax = get_terms($params['taxonomy']);
                    foreach ($allTax as $tax) {
                        $terms[] = $tax->term_id;
                    }
                }

                if ($params['offset'] == 'no_duplicates') {
                    $params['offset'] = 0;
                    $no_duplicates = true;
                }


                $query = array('orderby' => 'date',
                    'order' => 'DESC',
                    'paged' => $page,
                    'post_type' => 'restaurant',
                    'posts_per_page' => $params['items'],
                    'offset' => $params['offset'],
                    'post__not_in' => (!empty($no_duplicates)) ? $avia_config['posts_on_current_page'] : array(),
                    'tax_query' => array(array('taxonomy' => $params['taxonomy'],
                            'field' => 'id',
                            'terms' => $terms,
                            'operator' => 'IN')));
            } else {
                $query = $params['custom_query'];
            }


            $query = apply_filters('avia_post_slide_query', $query, $params);

            $this->entries = new WP_Query($query);

            // store the queried post ids in
            if ($this->entries->have_posts()) {
                while ($this->entries->have_posts()) {
                    $this->entries->the_post();
                    $avia_config['posts_on_current_page'][] = get_the_ID();
                }
            }
        }

    }

}
if (!function_exists('mm_convert_title_to_slug')) {

    function mm_convert_title_to_slug($str, $delimiter = '-') {

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

}

add_action('wp_ajax_mm_ajax_load_more_list_restaurant', 'mm_ajax_load_more_list_restaurant');
add_action('wp_ajax_nopriv_mm_ajax_load_more_list_restaurant', 'mm_ajax_load_more_list_restaurant');
if ( ! function_exists( 'mm_ajax_load_more_list_restaurant' ) ) {
    function mm_ajax_load_more_list_restaurant() {
        $atts = $_POST['atts'];
        $page = '1';
        if(isset($_POST['page'])){
            $page = $_POST['page'] - 1;
        }
        $output= '';
        if ($atts['spreview_mode'] == 'auto')
            $image_size = 'portfolio';
        $extraClass = 'first';
        $grid = 'one_third';
        $post_loop_count = 1;
        $loop_counter = 1;
        $autoplay = $autoplay == "no" ? false : true;
        $total = $atts['columns'] % 2 ? "odd" : "even";
        $columns = $atts['columns'];
        switch ($columns) {
            case "1": $grid = 'av_fullwidth';
                if ($preview_mode == 'auto')
                    $image_size = 'large';
                break;
            case "2": $grid = 'av_one_half';
                break;
            case "3": $grid = 'av_one_third';
                break;
            case "4": $grid = 'av_one_fourth';
                if ($preview_mode == 'auto')
                    $image_size = 'portfolio_small';
                break;
            case "5": $grid = 'av_one_fifth';
                if ($preview_mode == 'auto')
                    $image_size = 'portfolio_small';
                break;
        }


        $$thumb_fallback = "";
        $query = array('orderby' => 'date',
            'order' => 'DESC',
            'paged' => $page,
            'post_type' => 'restaurant',
            'posts_per_page' => $atts['items'],
            'offset' => $atts['offset'],
        );
        //$query = apply_filters('avia_post_slide_query', $query, $params);
        $load_more_query = new WP_Query($query);

        // store the queried post ids in
        if ($load_more_query->have_posts()) {
            while ($load_more_query->have_posts()) {
                $load_more_query->the_post();
                $the_id = get_the_ID();
                $parity = $loop_counter % 2 ? 'odd' : 'even';
                $entry = get_post($the_id);
                $last = $load_more_query->post_count == $post_loop_count ? " post-entry-last " : "";
                $post_class = "post-entry post-entry-{$the_id} slide-entry-overview slide-loop-{$post_loop_count} slide-parity-{$parity} {$last}";
                $link = get_permalink($the_id);
                $excerpt = "";
                $title = '';
                $thumbnail = get_the_post_thumbnail($the_id, $image_size);
                $format = get_post_format($the_id);
                if (empty($format))
                    $format = "standard";

                if ($thumbnail) {
                    $thumb_fallback = $thumbnail;
                    $thumb_class = "real-thumbnail";
                } else {
                    $thumbnail = "<span class=' fallback-post-type-icon' " . av_icon_string($format) . "></span><span class='slider-fallback-image'>{{thumbnail}}</span>";
                    $thumb_class = "fake-thumbnail";
                }


                $permalink = '<div class="read-more-link"><a href="' . get_permalink($the_id) . '" class="more-link">' . __('Learn more', 'avia_framework') . '</a></div>';
                $prepare_excerpt = !empty($entry->post_excerpt) ? $entry->post_excerpt : avia_backend_truncate($entry->post_content, apply_filters('avf_postgrid_excerpt_length', 60), apply_filters('avf_postgrid_excerpt_delimiter', " "), "�", true, '');

                if ($format == 'link') {
                    $current_post = array();
                    $current_post['content'] = $entry->post_content;
                    $current_post['title'] = $entry->post_title;

                    if (function_exists('avia_link_content_filter')) {
                        $current_post = avia_link_content_filter($current_post);
                    }

                    $link = $current_post['url'];
                }


                switch ($atts['contents']) {
                    case "excerpt":
                        $excerpt = $prepare_excerpt;
                        $title = $entry->post_title;
                        break;
                    case "excerpt_read_more":
                        $excerpt = $prepare_excerpt;
                        $excerpt .= $permalink;
                        $title = $entry->post_title;
                        break;
                    case "title":
                        $excerpt = '';
                        $title = $entry->post_title;
                        break;
                    case "title_read_more":
                        $excerpt = $permalink;
                        $title = $entry->post_title;
                        break;
                    case "only_excerpt":
                        $excerpt = $prepare_excerpt;
                        $title = '';
                        break;
                    case "only_excerpt_read_more":
                        $excerpt = $prepare_excerpt;
                        $excerpt .= $permalink;
                        $title = '';
                        break;
                    case "no":
                        $excerpt = '';
                        $title = '';
                        break;
                }

                $post_format = get_post_format($the_id) ? get_post_format($the_id) : 'standard';

                $markup = avia_markup_helper(array('context' => 'entry', 'echo' => false, 'id' => $the_id, 'custom_markup' => $atts['custom_markup']));
                $output .= "<article class='ajax-item-restaurant slide-entry flex_column {$atts['style']} {$post_class} {$grid} {$extraClass} {$thumb_class}' $markup>";
                $output .= $thumbnail ? "<a href='{$link}' data-rel='slide-" . mm_restaurant_slider::$slide . "' class='slide-image' title=''>{$thumbnail}</a>" : "";

                if ($post_format == "audio") {
                    $current_post = array();
                    $current_post['content'] = $entry->post_content;
                    $current_post['title'] = $entry->post_title;

                    $current_post = apply_filters('post-format-' . $post_format, $current_post);

                    if (!empty($current_post['before_content']))
                        $output .= '<div class="big-preview single-big audio-preview">' . $current_post['before_content'] . '</div>';
                }

                $output .= "<div class='slide-content'>";

                $markup = avia_markup_helper(array('context' => 'entry_title', 'echo' => false, 'id' => $the_id, 'custom_markup' => $atts['custom_markup']));
                $output .= '<header class="entry-content-header">';
                $output .= !empty($title) ? "<h3 class='slide-entry-title entry-title' $markup><a href='{$link}' title='" . esc_attr(strip_tags($title)) . "'>" . $title . "</a></h3>" : '';
                $output .= '</header>';

                $markup = avia_markup_helper(array('context' => 'entry_content', 'echo' => false, 'id' => $the_id, 'custom_markup' => $atts['custom_markup']));
                $excerpt = apply_filters('avf_post_slider_entry_excerpt', $excerpt, $prepare_excerpt, $permalink, $entry);
                $output .= !empty($excerpt) ? "<div class='slide-entry-excerpt entry-content' $markup>" . $excerpt . "</div>" : "";

                $output .= "</div>";
                $output .= '<footer class="entry-footer"></footer>';
                $output .= "</article>";

                $loop_counter++;
                $post_loop_count++;
                $extraClass = "";

                if ($loop_counter > $columns) {
                    $loop_counter = 1;
                    $extraClass = 'first';
                }

            }
        }
        
        echo $output;
        die();
    }
}

// show restaurant list in badges
if (!function_exists('mm_show_list_restaurant_in_badges')) {
    function mm_show_list_restaurant_in_badges ($slug_badges) {
        $args_restaurant_badges = array(
            'post_type' => 'restaurant',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'restaurant_badges',
                    'field' => 'slug',
                    'terms' => $slug_badges,
                ),
            ),
        );

        $restaurant_with_badges = get_posts($args_restaurant_badges);
        if (!empty($restaurant_with_badges)) {
        ?>
        <div class="mm-hotel-badges-wrap">
            <h3>Restaurant</h3>
            <div class="mm-hotel-badges-wrap-inner">
            <?php
            foreach($restaurant_with_badges as $restaurant) {
                $the_id = $restaurant->ID;
                $title = $restaurant->post_title;
                $thumbnail = get_the_post_thumbnail($the_id, $image_size);
                $link = get_permalink($the_id);
                $mm_address = get_post_meta($the_id, 'mm-address', true);
                $mm_phone = get_post_meta($the_id, 'mm-phone', true);
                $mm_email = get_post_meta($the_id, 'mm-email', true);
                $mm_facebook = get_post_meta($the_id, 'mm-facebook', true);
                $mm_instagram = get_post_meta($the_id, 'mm-instagram', true);
                $mm_twitter = get_post_meta($the_id, 'mm-twitter', true);
                $mm_tripadvisor = get_post_meta($the_id, 'mm-tripadvisor', true);
                $mm_yelp = get_post_meta($the_id, 'mm-yelp', true);
                $term_island_list = get_the_terms($the_id, 'hotel_island');
                ?>
                <article class='mm-restaurant-item'>
                    <div class='item-restaurant-image'>
                        <a href='<?php echo $link; ?>' title='<?php echo $title; ?>'><?php echo $thumbnail; ?></a>
                        <?php if (!empty($term_island_list)) {
                            $show_vp_tag = false;
                            echo '<ul class="restaurant_island">';
                            foreach ( $term_island_list as $island ) {
                                if(mm_convert_title_to_slug($island->name)!='vacation-packages'){
                                    echo '<li class="item_island '.mm_convert_title_to_slug($island->name).'">'.$island->name.'</li>';
                                }else{
                                    $show_vp_tag = true;
                                }
                            }
                            echo '</ul>';
                            if($show_vp_tag){
                                echo '<ul class="restaurant_island_vp">';
                                echo '<li class="item_island vacation-packages">VACATION PACKAGES</li>';
                                echo '</ul>';
                            }
                        }
                        ?>
                    </div>
                    <div class='item-restaurant-content'>
                        <h3><a href='<?php echo $link; ?>' title='<?php echo $title; ?>'><?php echo $title; ?></a></h3>
                        <div class="restaurant-contact">
                            <?php if (!empty($mm_address)) { ?>
                                <div class="address"><span class="icon"></span> <?php echo $mm_address; ?></div>
                            <?php } ?>
                            <?php if (!empty($mm_phone)) { ?>
                                <div class="phone"><span class="icon"></span> <a href="tel:<?php echo $mm_phone; ?>"><?php echo $mm_phone; ?></a></div>
                            <?php } ?>
                            <?php if (!empty($mm_email)) { ?>
                                <div class="email"><span class="icon"></span> <a href="mailto:<?php echo $mm_email; ?>"><?php echo $mm_email; ?></a></div>
                            <?php } ?>
                        </div>
                        <div class="restaurant-description">
                        <?php echo the_excerpt(); ?>
                        </div>
                        <a href='<?php echo $link; ?>' title='<?php echo $title; ?>' class="learn_more_btn">LEARN MORE</a>
                        <div class="restaurant-social-contact">
                            <?php if (!empty($mm_facebook)) { ?>
                                <a class="facebook-icon" title="Facebook" href="<?php echo $mm_facebook; ?>" target="_blank" rel="nofollow"></a>
                            <?php } ?>
                            <?php if (!empty($mm_instagram)) { ?>
                                <a class="instagram-icon" title="Instagram" href="<?php echo $mm_instagram; ?>" target="_blank" rel="nofollow"></a>
                            <?php } ?>
                            <?php if (!empty($mm_twitter)) { ?>
                                <a class="twitter-icon" title="Twitter" href="<?php echo $mm_twitter; ?>" target="_blank" rel="nofollow"></a>
                            <?php } ?>
                            <?php if (!empty($mm_tripadvisor)) { ?>
                                <a class="tripadvisor-icon" title="TripAdvisor" href="<?php echo $mm_tripadvisor; ?>" target="_blank" rel="nofollow"></a>
                            <?php } ?>
                            <?php if (!empty($mm_yelp)) { ?>
                                <a class="yelp-icon" title="Yelp" href="<?php echo $mm_yelp; ?>" target="_blank" rel="nofollow"></a>
                            <?php } ?>
                        </div>
                    </div>
                </article>
                <?php
            }
            ?> 
            </div>
        </div>
            <?php
        }
    }
    add_action('mm_show_list_restaurant_badges_product', 'mm_show_list_restaurant_in_badges', 10, 1);
}
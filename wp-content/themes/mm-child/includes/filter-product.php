<?php
/**
 * Post/Page Content
 *
 * Element is in Beta and by default disabled. Todo: test with layerslider elements. currently throws error bc layerslider is only included if layerslider element is detected which is not the case with the post/page element
 */
if (!class_exists('avia_sc_filter_product') && class_exists('woocommerce')) {

    class avia_sc_filter_product extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM Filter Product', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-postslider.png";
            $this->config['order'] = 30;
            $this->config['target'] = 'avia-target-insert';
            $this->config['shortcode'] = 'avia_sc_filter_product';
            $this->config['tooltip'] = __('Display single of Product Entries', 'avia_framework');
            $this->config['drag-level'] = 3;
        }

        /**
         * Popup Elements
         *
         * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
         * opens a modal window that allows to edit the element properties
         *
         * @return void
         */
        function mm_get_term_product_cat($parent_id = 0, $taxonomy = 'product_cat', $prefix = '', $all_categories = []) {
            $args = array(
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
                'parent' => $parent_id,
                'orderby' => 'name',
                'order' => 'ASC',
            );
        
            $categories = get_terms($args);
        
            foreach ($categories as $category) {
                $all_categories[__($prefix . $category->name . ' (' . $category->term_id .')', 'avia_framework')] = $category->term_id;
        
                if ($category->count > 0) {
                    $child_categories = $this->mm_get_term_product_cat($category->term_id, $taxonomy, $prefix . '-', $all_categories);
                    $all_categories += $child_categories;
                }
            }
        
            return $all_categories;
        }
        function popup_elements() {
            $options_cat = [];
            $options_cat[__('All', 'avia_framework')] = 'all';
            $options_cat = $this->mm_get_term_product_cat(0, 'product_cat', '', $options_cat);

            $all_tags = get_terms(
                array(
                    'taxonomy' => 'product_tag',
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order'   => 'ASC',
                )
            );
            $options_tag = [];
            $options_tag[__('All', 'avia_framework')] = 'all';
            foreach($all_tags as $tag) {
                $options_tag[__($tag->name, 'avia_framework')] = $tag->term_id;
            }
            $all_badges = get_terms(
                array(
                    'taxonomy' => 'certificates',
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order'   => 'ASC',
                )
            );
            $options_badge = [];
            $options_badge[__('All', 'avia_framework')] = 'all';
            foreach($all_badges as $badge) {
                $options_badge[__($badge->name, 'avia_framework')] = $badge->term_id;
            }
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
                    "subtype" => $options_cat,
                    "multiple" => 6,
                    "std" => "all"
                ),
                array(
                    "name" => __("Which Tag?", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_tags",
                    "type" => "select",
                    "subtype" => $options_tag,
                    "multiple" => 6,
                    "std" => "all"
                ),
                array(
                    "name" => __("Which Badge Tag?", 'avia_framework'),
                    "desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
                    "id" => "mm_certificate",
                    "type" => "select",
                    "subtype" => $options_badge,
                    "multiple" => 6,
                    "std" => "all"
                ),
                array(
                    "name" => __("Columns", 'avia_framework'),
                    "desc" => __("How many columns should be displayed?", 'avia_framework'),
                    "id" => "columns",
                    "type" => "select",
                    "std" => "3",
                    "subtype" => array(
                        __('1 Columns', 'avia_framework') => '1',
                        __('2 Columns', 'avia_framework') => '2',
                        __('3 Columns', 'avia_framework') => '3',
                        __('4 Columns', 'avia_framework') => '4',
                        __('5 Columns', 'avia_framework') => '5',
                    )
                ),
                array(
                    "name" => __("Entry Number", 'avia_framework'),
                    "desc" => __("How many items should be displayed?", 'avia_framework'),
                    "id" => "items",
                    "type" => "select",
                    "std" => "9",
                    "subtype" => AviaHtmlHelper::number_array(1, 100, 1, array('All' => '-1'))
                ),
                array(
                    'name' => __('Show more button', 'avia_framework'),
                    'desc' => __('', 'avia_framework'),
                    'id' => 'show_more',
                    'type' => 'select',
                    'std' => '',
                    'lockable' => true,
                    'subtype' => array(
                        __('Yes', 'avia_framework') => 'yes',
                        __('No', 'avia_framework') => '',
                    )
                ),
                array(
                    "name" => __("Default display number", 'avia_framework'),
                    "desc" => __("How many items should be displayed default?", 'avia_framework'),
                    "id" => "items_default",
                    "type" => "select",
                    "std" => "6",
                    'required' => array('show_more', 'equals', 'yes'),
                    "subtype" => AviaHtmlHelper::number_array(1, 100, 1)
                ),
                array(
                    "name" => __("Show Categories Filter", 'avia_framework'),
                    "desc" => __("", 'avia_framework'),
                    "id" => "show_filter",
                    "type" => "checkbox",
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
            $params['content'] = NULL; //remove to allow content elements
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
            global $avia_config, $woocommerce,$wpdb;

            $atts = shortcode_atts(array(
                'columns' => '4',
                'items' => '16',
                'mm_tags' => '',
                'mm_certificate'=>'',
                'post_type' => 'product',
                'categories' => '',
                'show_filter' => '',
                'is_cat_primary' => 'false',
                'show_more' => '',
                'items_default' => '',
                    ), $atts, $this->config['shortcode']);

            extract($atts);
            $show_default_item = 0;
            $show_more = false;
            if (!empty($atts['show_more']) && $atts['show_more'] == 'yes') {
                  $show_default_item =  $atts['items_default'];     
                  $show_more = true;
            }
            $ids_current = get_the_ID();

            $tag_order = array(
                '1', '2', '3', '4', '5', '6', 
                'a', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 
                'b', 'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 
                'c', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6',
                'd', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6',
                'e', 'e1', 'e2', 'e3', 'e4', 'e5', 'e6',
                'f', 'f1', 'f2', 'f3', 'f4', 'f5', 'f6'
            );

            // if (!empty($atts['mm_tags']) && $atts['mm_tags'] != 'all') {
            //     $mm_tags = $atts['mm_tags'];
            //     $mm_tags = explode(",", $mm_tags);
            //     $mm_tags_arr = array();
            //     if (is_array($mm_tags)) {
            //         foreach($mm_tags as $mm_tag) {
            //             $tag = get_term_by('id', $mm_tag, 'product_tag')->slug;
            //             if ($tag) {
            //                 $mm_tags_arr[] = $tag;
            //             }
            //         }
            //     }
            //     $tag_order_query = array_merge($tag_order, $mm_tags_arr);
            // } else {
            //     $tag_order_query = $tag_order;
            // }

            $sql = "SELECT DISTINCT p.ID , pm.meta_value AS product_image
                    FROM {$wpdb->prefix}posts p
                    LEFT JOIN {$wpdb->prefix}term_relationships tr ON p.ID = tr.object_id
                    LEFT JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                    LEFT JOIN {$wpdb->prefix}terms t ON tt.term_id = t.term_id";

            if (!empty($atts['categories']) && $atts['categories'] != 'all') {
                $sql = $sql . " LEFT JOIN {$wpdb->prefix}term_relationships tr2 ON p.ID = tr2.object_id LEFT JOIN {$wpdb->prefix}term_taxonomy tt2 ON tr2.term_taxonomy_id = tt2.term_taxonomy_id";
            }
                    
            if (!empty($atts['mm_certificate']) && $atts['mm_certificate'] != 'all') {
                $sql = $sql . " LEFT JOIN {$wpdb->prefix}term_relationships tr3 ON p.ID = tr3.object_id LEFT JOIN {$wpdb->prefix}term_taxonomy tt3 ON tr3.term_taxonomy_id = tt3.term_taxonomy_id";
            }
                    
            if (!empty($atts['mm_tags']) && $atts['mm_tags'] != 'all') {
                $sql = $sql . " LEFT JOIN {$wpdb->prefix}term_relationships tr4 ON p.ID = tr4.object_id LEFT JOIN {$wpdb->prefix}term_taxonomy tt4 ON tr4.term_taxonomy_id = tt4.term_taxonomy_id";
            }
                    
            $sql = $sql . " LEFT JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id' WHERE p.post_type = 'product' AND p.post_status = 'publish' AND tt.taxonomy = 'product_tag' AND t.slug IN ('" . implode("','", $tag_order) . "')";

            if (!empty($atts['categories']) && $atts['categories'] != 'all') {
                $sql = $sql . " AND tt2.taxonomy = 'product_cat' AND tt2.term_id IN (" . $atts['categories'] . ")";
            }

            if (!empty($atts['mm_certificate']) && $atts['mm_certificate'] != 'all') {
                $sql = $sql . " AND tt3.taxonomy = 'certificates' AND tt3.term_id IN (" . $atts['mm_certificate'] . ")";
            }

            if (!empty($atts['mm_tags']) && $atts['mm_tags'] != 'all') {
                $sql = $sql . " AND tt4.taxonomy = 'product_tag' AND tt4.term_id IN (" . $atts['mm_tags'] . ")";
            }

            if (!empty($ids_current)) {
                $sql = $sql . " AND p.ID <> $ids_current";
            }

            $sql = $sql . " ORDER BY FIELD(t.slug, '" . implode("','", $tag_order) . "')";

            if (!empty($atts['items']) && $atts['items'] != '-1') {
                $sql = $sql . " LIMIT ". $atts['items'];
            }

            $products_in = $wpdb->get_col($sql);

            $result = $this->query_sort_by(array(
                'post_type'      => 'product',
                'post__in'       => $products_in,
                'posts_per_page' => $atts['items'],
                'orderby'        => 'post__in',
            ));

            $count_result = count($result);

            if ($count_result <= $atts['items_default']) {
                $show_more = false;
            }

            if ($result) {
                ob_start();
                ?>
                <div data-interval data-animation data-hoverpause='1' class='shop-filter-product template-shop avia-content-slider avia-content-grid-active avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling' >
                    <div class='avia-content-slider-inner'>
                        <ul class="products mm-filter-product" style="grid-template-columns: repeat(<?php echo $atts['columns']; ?>, 1fr);">
                            <?php
                            $i = 0;
                            foreach ($result as $products_key => $products_val) {
                                $post_id = $products_val['id'];
                                $product = wc_get_product($post_id);

                                if ($atts['is_cat_primary'] == 'true') {
                                    $cat_primary = get_post_meta( $post_id , '_yoast_wpseo_primary_product_cat', true );
                                    $cat_primary = get_term( $cat_primary );

                                    if ($cat_primary->parent != $atts['categories']) {
                                        continue;
                                    }
                                }
                                    $i++;
                                    $categories_post = get_the_terms($post_id, 'product_cat');
                                    if ($categories_post) {
                                        foreach ($categories_post as $categorie) {
                                            $all_categorie[$categorie->slug] = $categorie->name;
                                        }
                                    }
                                    $fareharbor_link = get_post_meta($post_id, 'enable_fareharbor_popup_link', true);
                                    $mm_booking_type = get_post_meta($post_id, 'mm_select_booking_type', true);
                                    $link_product = $products_val['link'];
                                    if (!empty($fareharbor_link) && $mm_booking_type =='fhpopup') {
                                        $link_product = $fareharbor_link;
                                    }
                                    $add_item_style = '';
                                    if($show_more && $i > $show_default_item){
                                        $add_item_style = 'display:none; ';
                                    }
                                    ?>
                                    <li class="<?php echo $products_val['class']; ?>" style="<?php echo $add_item_style;?>">
                                        <a href="<?php echo $link_product; ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                            <div class="thumbnail_container mm_thumbnail">
                                                <div class="mm-tag-button">
                                                    <?php
                                                    if (is_object_in_term($post_id, 'product_tag', 'likely-to-sell-out')) {
                                                        ?>
                                                        <span class="tag-like-to-sell-out">Likely to Sell Out</span>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if (is_object_in_term($post_id, 'product_tag', 'popular-tour')) {
                                                        ?>
                                                        <span class="tag-popular-tour">Popular Tour</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php echo $products_val['img']; ?>
                                                <p class="woocommerce-loop-product__title title_mm">
                                                    <?php echo $products_val['title']; ?>
                                                    <?php
                                                    $rating = 5;
                                                    $postmeta_table = $wpdb->prefix . "postmeta";
                                                    $query_rating = "
                                                        SELECT      meta_value
                                                        FROM        $postmeta_table
                                                        WHERE       `post_id` = %s AND `meta_key` LIKE '%bsf-schema-pro-rating%'
                                                    ";
                                                    $query_rating = $wpdb->prepare($query_rating, $post_id);
                                                    $results_rating = $wpdb->get_results($query_rating);
                                                    if(!empty($results_rating)){
                                                        if(isset($results_rating[0]->meta_value)){
                                                            $rating = $results_rating[0]->meta_value;
                                                        }
                                                    }
                                                    $full  = '<span class="dashicons dashicons-star-filled"></span>';
                                                    $semi  = '<span class="dashicons dashicons-star-half"></span>';
                                                    $empty = '<span class="dashicons dashicons-star-empty"></span>';

                                                    $html_rating = str_repeat( $full, floor( $rating ) );

                                                    if( $rating > floor( $rating ) ){

                                                        $html_rating .= $semi;
                                                    }

                                                    $html_rating .= str_repeat( $empty, 5 - ceil( $rating ) );
                                                    $star_rating = '<span class="mm-title-rating">'.$html_rating.'</span>';
                                                    ?>
                                                    <?php echo $star_rating; ?>
                                                </p>
                                            </div>
                                            <!--</a>-->
                                            <?php 
                                            $mm_builder_open = get_post_meta( $post_id, 'mm_builder', true );
                                            if ($mm_builder_open == 'activate'){?>
                                                <div class="inner_product_header">
                                                    <?php
                                                        $short_description = get_post_meta( $post_id, 'short_description_description', true );
                                                        if($short_description){
                                                            $description = wordwrap($short_description, 65);
                                                            $description = explode("\n", $description);
                                                            $description = $description[0] . '...';
                                                            $short_description = $description . ' <span class="more-description">More</span>';
                                                            echo '<p>' . $short_description . '</p>';
                                                        }

                                                        $number_list_items = get_post_meta($post_id, 'short_description_list_items', true);
                                                        if($number_list_items > 0){
                                                            $output_list_items = "";
                                                            for( $j = 0; $j < $number_list_items; $j++ ){
                                                                $list_items_text = get_post_meta( $post_id, 'short_description_list_items_' . $j . '_text', true );
                                                                $list_items_icon = get_post_meta( $post_id, 'short_description_list_items_' . $j . '_icon', true );
                                                                if( $list_items_text ){
                                                                    $output_list_items .= '<li>';
                                                                    if( $list_items_icon ){
                                                                        $src_text = wp_get_attachment_url( $list_items_icon );
                                                                        $alt_text = get_post_meta($list_items_icon, '_wp_attachment_image_alt', true);
                                                                        
                                                                        $output_list_items .= '<div class="av-icon-char" style="padding-right: 10px;" aria-hidden="true">';
                                                                        $output_list_items .= '<img loading="lazy" src="' . $src_text . '" alt="' . $alt_text . '" width="55" height="55">';
                                                                        $output_list_items .= '</div>';
                                                                    }
                                                                    $output_list_items .= $list_items_text;
                                                                    $output_list_items .= '</li>';
                                                                }
                                                            }
                                                            echo '<ul style="padding-top: 20px">' . $output_list_items . '</ul>';
                                                        }
                                                    ?>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="inner_product_header">
                                                    <?php
                                                    $excerpt = get_post_meta($post_id, 'description_inner', true);
                                                    $excerpt = $products_val['exc'];
                                                    if (is_front_page() || $excerpt == '') {
                                                        $excerpt = $products_val['exc'];
                                                    } else {
                                                        $excerpt = stripslashes(wpautop(trim(html_entity_decode($excerpt))));
                                                    }
                                                    $pos_array = array();
                                                    if (strlen(strstr($excerpt, '</p>')) > 0) {
                                                        $pos_array[] = strpos($excerpt, '</p>');
                                                    }
                                                    if (strlen(strstr($excerpt, '<br')) > 0) {
                                                        $pos_array[] = strpos($excerpt, '<br');
                                                    }
                                                    if (strlen(strstr($excerpt, 'av_hr')) > 0) {
                                                        $pos_array[] = strpos($excerpt, '[av_hr');
                                                    }
                                                    if(empty($pos_array)){
                                                        if (strlen(strstr($excerpt, '<ul')) > 0) {
                                                            $pos_array[] = strpos($excerpt, '<ul');
                                                        }
                                                    }
                                                    if (!empty($pos_array)) {
                                                        $pos = min($pos_array);
                                                        $description = substr($excerpt, 0, $pos);
                                                        $feature_list = substr($excerpt, $pos);
                                                        $description = wordwrap($description, 65);
                                                        $description = explode("\n", $description);
                                                        $description = $description[0] . '...';
                                                        $excerpt = $description . ' <span class="more-description">More</span> ' . $feature_list;
                                                    }
                                                    echo $excerpt;
                                                    ?>
                                                </div>
                                            <?php } ?>
                                            <div class="avia_cart_buttons single_button">
                                                <?php 
                                                    $product_tags = get_the_terms($post_id, 'product_tag'); 
                                                    $tag_deal = false;
                                                    if (is_array($product_tags)) {
                                                        foreach ($product_tags as $product_tag) {
                                                            if ($product_tag->term_id == 17378) {
                                                                $tag_deal = true;
                                                                break;
                                                            }
                                                        }
                                                    } 
                                                ?>
                                                <?php if($tag_deal) { ?>
                                                    <div class="wc-price-wrap">
                                                        <span class="wc-price mm-price-before-sale">
                                                            <span class="starting-price">from</span>
                                                            <?php
                                                            if ('gift-card' == $product->get_type()) {
                                                                $amounts = $product->get_amounts_to_be_shown();
                                                                foreach ($amounts as $value => $item) {
                                                                    $price = $item['price'];
                                                                    
                                                                    echo wc_price($price);
                                                                    break;
                                                                }
                                                            } else
                                                                $price = $product->get_price();
                                                                echo wc_price($price);
                                                            ?>
                                                        </span>
                                                <?php } ?>
                                                <span class="wc-price">
                                                    <span class="starting-price"><?php echo($tag_deal == true ? 'Now<br />from' : 'from'); ?></span>
                                                    <?php
                                                    if ('gift-card' == $product->get_type()) {
                                                        $amounts = $product->get_amounts_to_be_shown();
                                                        foreach ($amounts as $value => $item) {
                                                            $price = $item['price'];
                                                            if ($tag_deal == true) {
                                                                $price = floor($price * (1 - (5 / 100)));
                                                            }
                                                            echo wc_price($price);
                                                            break;
                                                        }
                                                    } else {
                                                        $price = $product->get_price();
                                                        if ($tag_deal == true) {
                                                            $price = floor($price * (1 - (5 / 100)));
                                                        }
                                                        echo wc_price($price);
                                                    }
                                                    ?>
                                                </span>

                                                <?php if($tag_deal) { ?>
                                                    </div>
                                                <?php } ?>

                                                <button data-quantity="1"  data-product_sku="" class="button product_type_booking add_to_cart_button">BOOK NOW</button>

                                            </div>
                                        </a>
	                                    <?php 
                                        if ( shortcode_exists('yith_wcwl_add_to_wishlist') ) {
                                            echo '[yith_wcwl_add_to_wishlist product_id="' . $products_val['id'] . '" ]'; 
                                        }?>
                                    </li>
                                    <?php
                                    if ($i >= $atts['items'] && -1 != $atts['items']) {
                                        break;
                                    }
                                }
                            ?>
                        </ul>
                        <?php
                            if ($show_more) {
                                ?>
                                <div class="avia-button-wrap avia-button-center">
                                    <a class="mm-filter-show-more avia-button   avia-icon_select-yes-left-icon avia-color-theme-color avia-size-large avia-position-center " href="#">
                                        <span class="avia_iconbox_title">SHOW MORE</span>
                                    </a>
                                </div>
                        
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
                $output = ob_get_clean();
                $out_filter = '<div class="mm_filter_product_element">';
                if ($atts['show_filter'] != '') {
                    $all_categorie = array_unique($all_categorie);
                    if (!empty($all_categorie)) {
                        $out_filter .= '<div class="sort-filter-category">';
                        $out_filter .= '<span>Categories:</span>';
                        $out_filter .= '<select name="category_id" id="category_id" >';
                        $out_filter .= '<option value="-1">Select a category</option>';
                        foreach ($all_categorie as $key => $value) {
                            $out_filter .= '<option value="product_cat-' . $key . '">' . $value . '</option>';
                        }
                        $out_filter .= '</select>';
                        $out_filter .= '</div>';
                    }
                }
                $output .= $out_filter . '</div>';
            } else {
                $output = 'No products found which match your selection.';
            }
            wp_reset_query();
            return do_shortcode($output);
        }

        function query_sort_by($args) {
            $arg_product = array();
            if (!empty($args)) {
                query_posts($args);
                if (have_posts()) {     
                    $i = 0;
                    while (have_posts()) {
                        the_post();
                        $post_id = get_the_ID();
                        $product = wc_get_product($post_id);
                        $arg_product[$i]['id'] = get_the_ID();
                        $arg_product[$i]['link'] = get_permalink();
                        $arg_product[$i]['title'] = get_the_title();
                        $arg_product[$i]['img'] = get_the_post_thumbnail($post_id, 'shop_catalog');
                        $arg_product[$i]['exc'] = get_the_excerpt();
                        $arg_product[$i]['price'] = wc_price($product->get_price());
                        $arg_product[$i]['class'] = implode(" ", get_post_class());
                        $i++;
                    }
                }
            }
            return $arg_product;
        }
    }
}
    
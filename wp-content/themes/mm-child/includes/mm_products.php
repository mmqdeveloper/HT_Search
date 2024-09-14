<?php
/**
 * Post/Page Content
 *
 * Element is in Beta and by default disabled. Todo: test with layerslider elements. currently throws error bc layerslider is only included if layerslider element is detected which is not the case with the post/page element
 */
if (!class_exists('woocommerce')) {
    add_shortcode('av_productslider', 'avia_please_install_woo');
    return;
}


if (!class_exists('avia_sc_mmproduct') && class_exists('woocommerce')) {

    class avia_sc_mmproduct extends aviaShortcodeTemplate {

        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button() {
            $this->config['name'] = __('MM Single Product', 'avia_framework');
            $this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
            $this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-comments.png";
            $this->config['order'] = 30;
            $this->config['target'] = 'avia-target-insert-mm';
            $this->config['shortcode'] = 'avia_sc_mmproduct';
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
                array("name" => __("Product ID", 'avia_framework'),
                    "desc" => __("Input Product ID", 'avia_framework'),
                    "id" => "id_product",
                    "type" => "input",
                    "std" => ""),
                /*array("name" => __("Product Price", 'avia_framework'),
                    "desc" => __("Input product price", 'avia_framework'),
                    "id" => "price_product",
                    "type" => "input",
                    "std" => ""),*/
                array(
                    "name" => __("Columns", 'avia_framework'),
                    "desc" => __("How many columns should be displayed?", 'avia_framework'),
                    "id" => "columns",
                    "type" => "select",
                    "std" => "3",
                    "subtype" => array(
                        __('1 Columns', 'avia_framework') => '1',
                    )),
                array(
                    "name" => __("Entry Number", 'avia_framework'),
                    "desc" => __("How many items should be displayed?", 'avia_framework'),
                    "id" => "items",
                    "type" => "select",
                    "std" => "9",
                    "subtype" => AviaHtmlHelper::number_array(1, 100, 1, array('All' => '-1'))),
                array(
                    "name" => __("WooCommerce Product visibility?", 'avia_framework'),
                    "desc" => __("Select the visibility of WooCommerce products. Default setting can be set at Woocommerce -&gt Settings -&gt Products -&gt Inventory -&gt Out of stock visibility", 'avia_framework'),
                    "id" => "wc_prod_visible",
                    "type" => "select",
                    "std" => "",
                    "subtype" => array(
                        __('Use default WooCommerce Setting (Settings -&gt; Products -&gt; Out of stock visibility)', 'avia_framework') => '',
                        __('Hide products out of stock', 'avia_framework') => 'hide',
                        __('Show products out of stock', 'avia_framework') => 'show')
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
            global $avia_config, $product, $wpdb, $woocommerce;

            $screen_sizes = AviaHelper::av_mobile_sizes($atts);
            $atts['class'] = $meta['el_class'];

            //fix for seo plugins which execute the do_shortcode() function before the WooCommerce plugin is loaded
            if (!is_object($woocommerce) || !is_object($woocommerce->query))
                return;

            $atts = array_merge($atts, $screen_sizes);


            if (!empty($atts['id_product'])) {
                $post_id = explode(',', $atts['id_product']);
                $args = array(
                    'posts_per_page' => -1,
                    'post__in' => '',
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'offset' => 0,
                    'post_type' => 'product',
                    'ignore_sticky_posts' => 1,
                    'post__in' => $post_id
                );
                // The Query
                $the_query = new WP_Query($args);

                // The Loop
                if ($the_query->have_posts()) {
                    ob_start();
                    ?>
                    <div data-interval data-animation data-hoverpause='1' class='template-shop avia-content-slider avia-content-grid-active avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling shop_columns_1' >
                        <div class='avia-content-slider-inner'>
                            <ul class="products mm-single-product">
                                <?php
                                while ($the_query->have_posts()) {
                                    $the_query->the_post();
                                    $fareharbor_link = get_post_meta(get_the_ID(), 'enable_fareharbor_popup_link', true);
                                    $mm_booking_type = get_post_meta(get_the_ID(), 'mm_select_booking_type', true);
                                    $link_product = get_permalink();
                                    if(!empty($fareharbor_link) && $mm_booking_type=='fhpopup'){
                                        $link_product = $fareharbor_link;
                                    }
                                    ?>
                                    <li <?php post_class(); ?>>
                                        <a href="<?php echo $link_product; ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link" style="background: #FFF">
                                            <div class="thumbnail_container mm_thumbnail">
                                                <div class="mm-tag-button">
                                                    <?php
                                                    if (is_object_in_term($post_id,'product_tag','likely-to-sell-out')) {
                                                        ?>
                                                        <span class="tag-like-to-sell-out">Likely to Sell Out</span>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if (is_object_in_term($post_id,'product_tag','popular-tour')) {
                                                        ?>
                                                        <span class="tag-popular-tour">Popular Tour</span>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php echo get_the_post_thumbnail(get_the_ID(), 'shop_catalog'); ?>
                                                <p class="woocommerce-loop-product__title title_mm">
                                                    <?php echo get_the_title(); ?>
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
                                                    <?php echo $star_rating;?>
                                                </p>
                                            </div>
                                        <!--</a>-->
                                        <?php 
                                            $mm_builder_open = get_post_meta( get_the_ID(), 'mm_builder', true );
                                            if ($mm_builder_open == 'activate'){?>
                                                <div class="inner_product_header">
                                                    <?php
                                                        $short_description = get_post_meta( get_the_ID(), 'short_description_description', true );
                                                        if($short_description){
                                                            $description = wordwrap($short_description, 65);
                                                            $description = explode("\n", $description);
                                                            $description = $description[0] . '...';
                                                            $short_description = $description . ' <span class="more-description">More</span>';
                                                            echo '<p>' . $short_description . '</p>';
                                                        }

                                                        $number_list_items = get_post_meta(get_the_ID(), 'short_description_list_items', true);
                                                        if($number_list_items > 0){
                                                            $output_list_items = "";
                                                            for( $i = 0; $i < $number_list_items; $i++ ){
                                                                $list_items_text = get_post_meta( get_the_ID(), 'short_description_list_items_' . $i . '_text', true );
                                                                $list_items_icon = get_post_meta( get_the_ID(), 'short_description_list_items_' . $i . '_icon', true );
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
                                                $excerpt_inner = get_post_meta(get_the_ID(), 'description_inner', true);
                                                $excerpt_inner = get_the_excerpt();
                                                if (is_front_page()|| $excerpt_inner=='') {
                                                    $excerpt_inner = get_the_excerpt();
                                                }else{
                                                    $excerpt_inner = stripslashes(wpautop(trim(html_entity_decode( $excerpt_inner) )));
                                                }
                                                $pos_array = array();
                                                if (strlen(strstr($excerpt_inner, '</p>')) > 0) {
                                                    $pos_array[] = strpos($excerpt_inner, '</p>');
                                                }
                                                if (strlen(strstr($excerpt_inner, '<br')) > 0) {
                                                    $pos_array[] = strpos($excerpt_inner, '<br');
                                                }
                                                if (strlen(strstr($excerpt_inner, 'av_hr')) > 0) {
                                                    $pos_array[] = strpos($excerpt_inner, '[av_hr');
                                                }
                                                if(empty($pos_array)){
                                                    if (strlen(strstr($excerpt_inner, '<ul')) > 0) {
                                                        $pos_array[] = strpos($excerpt_inner, '<ul');
                                                    }
                                                }
                                                if(!empty($pos_array)){
                                                    $pos = min($pos_array);
                                                    $description = substr($excerpt_inner,0,$pos);
                                                    $feature_list = substr($excerpt_inner,$pos);
                                                    $description = wordwrap($description, 45);
                                                    $description = explode("\n", $description);
                                                    $description = $description[0] . '...';
                                                    $excerpt_inner = $description.' <span class="more-description">More</span> '.$feature_list;
                                                }
                                               ?>
                                                <?php if (is_front_page()|| $excerpt_inner=='') { ?>
                                                    <div class="description-home">
                                                        <?php
                                                        //$excerpt = get_the_excerpt();
                                                        //$exc = !empty($excerpt) ? avia_backend_truncate($excerpt, 200, " ") : avia_backend_truncate(get_the_content(), apply_filters('avf_postgrid_excerpt_length', 200), apply_filters('avf_postgrid_excerpt_delimiter', " "), "�", true, '');
                                                        echo $excerpt_inner;
                                                        ?>
                                                    </div>
                                                    <?php
                                                } else {
                                                    
                                                    echo stripslashes(wpautop(trim(html_entity_decode( $excerpt_inner) )));
                                                }
                                                ?>
                                            </div>
                                            <?php } ?>
                                        <div class="avia_cart_buttons single_button">
                                            <!--<a rel="nofollow" href="<?php echo get_permalink(); ?>" data-quantity="1"  data-product_sku="" class="button product_type_booking add_to_cart_button">BOOK NOW</a>-->
                                          
                                            <?php
                                            /*if ($atts['price_product'] == 0) {
                                                echo "<span class='wc-price'><span class='starting-price'>Starts At </span> " . wc_price($product->get_price()) . "</span>";
                                            } else {
                                                echo "<span class='wc-price'><span class='starting-price'>Starts At </span> ";
                                                
                                                $price = explode('.', $atts['price_product']);
                
                                                
                                                $comm_price = ($price[1]) ? $price[1] : '00';
                                                echo '<span class="woocommerce-Price-amount amount mm-price-pr"><span class="custom-prc">' .get_woocommerce_currency_symbol(). number_format($price[0]) . '<sup>.' . $comm_price . '</sup></span> <span class="woocommerce-Price-currencySymbol"> '.get_woocommerce_currency().'</span></span>';

                                                echo "</span>";
                                            }*/
                                            $product = wc_get_product(get_the_ID());
                                            $product_tags = get_the_terms(get_the_ID(), 'product_tag'); 
                                            $tag_deal = false;
                                            if (is_array($product_tags)) {
                                                foreach ($product_tags as $product_tag) {
                                                    if ($product_tag->term_id == 17378) {
                                                        $tag_deal = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            if($tag_deal){
                                                echo "<div class='wc-price-wrap'>";
                                                echo "<span class='wc-price mm-price-before-sale'><span class='starting-price'>from</span> ";
                                                 $price = explode('.', $product->get_price());
                                            
                                                $comm_price = isset($price[1]) ? $price[1] : '00';

                                                $price_show = $price[0];

                                                echo '<span class="woocommerce-Price-amount amount mm-price-pr"><span class="custom-prc">' .get_woocommerce_currency_symbol(). number_format($price_show) . '<sup>.' . $comm_price . '</sup></span> <span class="woocommerce-Price-currencySymbol"> '.get_woocommerce_currency().'</span></span>';

                                                echo "</span>";
                                            }
                                            
                                            echo "<span class='wc-price'><span class='starting-price'>".($tag_deal == true ? 'Now<br />from' : 'from')."</span> ";
                                                
                                            $price = explode('.', $product->get_price());
                                            
                                            $comm_price = isset($price[1]) ? $price[1] : '00';
                                            
                                            $price_show = $price[0];

                                            if ($tag_deal == true) {
                                                $price_show = floor($price_show * (1 - (5 / 100)));
                                            }

                                            echo '<span class="woocommerce-Price-amount amount mm-price-pr"><span class="custom-prc">' .get_woocommerce_currency_symbol(). number_format($price_show) . '<sup>.' . $comm_price . '</sup></span> <span class="woocommerce-Price-currencySymbol"> '.get_woocommerce_currency().'</span></span>';

                                            echo "</span>";
                                            if($tag_deal){
                                                echo "</div>";
                                            }
                                            ?>
                                              <button data-quantity="1"  data-product_sku="" class="button product_type_booking add_to_cart_button">BOOK NOW</button>
                                        </div></a>
                                        <?php 
                                        if ( shortcode_exists('yith_wcwl_add_to_wishlist') ) {
                                            echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . get_the_ID() . '" ]'); 
                                        }?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    $output = ob_get_clean();
                    wp_reset_postdata();
                } else {
                    $output = 'No products found which match your selection.';
                }
            } else {
                $output = 'No products found which match your selection.';
            }
            return $output;
        }

    }

}
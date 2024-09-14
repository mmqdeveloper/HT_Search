<?php
global $avia_config, $more;

/*
 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
 */
get_header();


$showheader = true;
if (avia_get_option('frontpage') && $blogpage_id = avia_get_option('blogpage')) {
    if (get_post_meta($blogpage_id, 'header', true) == 'no')
        $showheader = false;
}

if ($showheader) {
    echo avia_title(array('title' => avia_which_archive()));
}

do_action('ava_after_main_title');
$s = get_search_query();
?>
<div id="header_category" class="avia-section main_color avia-section-default avia-no-shadow avia-bg-style-scroll  avia-builder-el-0  el_before_av_two_third  avia-builder-el-first  av-minimum-height av-minimum-height-custom container_wrap fullsize" style="border:none;background-repeat: no-repeat; background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/banner.jpg); background-attachment: scroll; background-position: top right; background-size:cover;" data-section-bg-repeat="no-repeat">
    <div class="container" style="height:270px">
        <main role="main" itemscope="itemscope" itemtype="https://schema.org/Blog" class="template-page content  av-content-full alpha units">
            <div class="post-entry post-entry-type-page post-entry-2764">
                <div class="entry-content-wrapper clearfix">
                    <section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
                        <div class="avia_textblock " itemprop="text">
                            <h1 class="title-header-cate" style="text-transform: none; font-weight: initial;">
                                <span style="color: #ffffff;">
                                    <strong style="font-weight: 600;">Search Results for: "<?php echo $s; ?>"</strong>
                                </span>
                            </h1>
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <!-- close content main element -->
    </div>
</div>
<div id="container_category">
    <div class="container">
        <div class="template-page content  av-content-full alpha units">
            <div class="post-category">
                <div class="category-wrapper clearfix">
                    <div class="content-category result-search">
                        <?php
                        global $wpdb;
                        $args = array(
                            //'post_type' => array( 'post', 'page', 'product' ),
                            's' => $s,
                            'posts_per_page' => -1
                        );
                        // The Query
                        $the_query = new WP_Query($args);

                        if ($the_query->have_posts()) {
                            _e("<h2 style='font-weight:bold;color:#000;margin-bottom: 20px;'>What Would You Like To Do?</h2>");
                            ?>
                            <div class="search-page-form" style="margin-bottom: 25px;" id="ss-search-page-form"><?php get_search_form(); ?></div>

                            <div data-interval data-animation data-hoverpause='1' class='ht-search-result shop-filter-product template-shop avia-content-slider avia-content-grid-active avia-content-slider1 avia-content-slider-odd  avia-builder-el-no-sibling <?php echo 'shop_columns_' . $atts['columns']; ?>' >
                                <div class='avia-content-slider-inner'>
                                    <ul class="products mm-filter-product" style="grid-template-columns: repeat(<?php echo $atts['columns']; ?>, 1fr);">
                                        <?php
                                        while ($the_query->have_posts()) {
                                            $the_query->the_post();
                                            the_post();
                                            $post_id = get_the_ID();
                                            $product = wc_get_product($post_id);
                                            $fareharbor_link = get_post_meta($post_id, 'enable_fareharbor_popup_link', true);
                                            $mm_booking_type = get_post_meta($post_id, 'mm_select_booking_type', true);
                                            $link_product = get_permalink();
                                            if (!empty($fareharbor_link) && $mm_booking_type =='fhpopup') {
                                                $link_product = $fareharbor_link;
                                            }
                                            if ($post_id) {
                                                ?>
                                                <li class="<?php echo implode(" ", get_post_class()); ?>" style="<?php echo $add_item_style;?>">
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
                                                            <?php echo get_the_post_thumbnail($post_id, 'shop_catalog'); ?>
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
                                                                if (is_front_page() || $excerpt == '') {
                                                                    $excerpt =$product->get_short_description();
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
                                                                    $pattern = '/\[av_font_icon.*?\[\/av_font_icon\]/s';
                                                                    $feature_list = preg_replace($pattern, '', $feature_list);
                                                                    $excerpt = $description . ' <span class="more-description">More</span> '.$feature_list;
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
                                                                                $price = wc_price($product->get_price());
                                                                                
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
                                                                        $price = wc_price($product->get_price());
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
                                                        echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $products_val['id'] . '" ]'); 
                                                    }?>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        } else {
                            _e("<h2 style='font-weight:bold;color:#000;margin-bottom: 20px;'>What Would You Like To Do?</h2>");
                            ?>
                            <div class="search-page-form" id="ss-search-page-form" style="margin-bottom: 25px;"><?php get_search_form(); ?></div>
                            <?php
                            $args = array(
                                'post_type' => 'product',
                                'post_status' => 'publish',
                                'orderby' => 'rand',
                                'order' => 'DESC',
                                'posts_per_page' => 6
                            );

                            $random_product = new WP_Query($args);
                            if ($random_product->have_posts()) {
                                ?>
                                <h3 class="title-keywords">The keywords you are looking for was not found.</h3>
                                <h4 class="subtitle-keywords">Don’t worry – there is always something else to do in Hawaii Tours !<br>The links above or below may help you find it.</h4>
                                <?php
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
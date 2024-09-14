<?php

namespace MauiMarketing\MMTF\Templates\TourFiltering\Product;

use MauiMarketing\MMTF\Product\Availability;
use MauiMarketing\MMTF\Templates;
use MauiMarketing\MMTF\Logs;

if( ! defined('ABSPATH') ){ die(); }
$rating = 5;
global $wpdb;
$postmeta_table = $wpdb->prefix . "postmeta";
$query = "
    SELECT      meta_value
    FROM        $postmeta_table
    WHERE       `post_id` = %s AND `meta_key` LIKE '%bsf-schema-pro-rating%'
    LIMIT 1
";
$query = $wpdb->prepare($query, $product->ID);
$results = $wpdb->get_results($query);
if(!empty($results)){
    if(isset($results[0]->meta_value)){
        $rating = $results[0]->meta_value;
    }
}
$permalink = get_permalink( (int) $product->ID );

// $galleries_id = [];
// $count_galleries = get_post_meta( $product->ID, 'galleries_gallery', true );
// if ($count_galleries) {
//     for ($i = 1; $i < $count_galleries; $i++) {
//         $galleries_id = array_merge($galleries_id, get_post_meta( $product->ID, 'galleries_gallery_' . $i . '_images', true ));
//     }
// }
// $galleries_limit = 3;

$product_classes = get_post_class( '', $product->ID );
$product_tags = get_the_terms($product->ID, 'product_tag');

$tag_deal = false;
$tag_likely_to_sell_out = false;
if (is_array($product_tags)) {
    foreach ($product_tags as $product_tag) {
        if ($product_tag->slug == 'deal') {
            $tag_deal = true;
        }
        if ($product_tag->slug == 'likely-to-sell-out') {
            $tag_likely_to_sell_out = true;
        }
    }
} 

?>

<li class="product_result <?php echo implode( ' ', $product_classes ); ?>" data-product_id="<?php echo $product->ID ?>" >
    
    <a class="product_result_image_wrapper" href="<?php echo $permalink; ?>">
    
        <div class="mmtf_product_image_slider_container">
            <?php
                $primary_product_cat = get_post_meta( $product->ID, '_yoast_wpseo_primary_product_cat', true );
                if(!empty($primary_product_cat)){
                    $product_cat = get_term( (int)$primary_product_cat, 'product_cat' );
                } else {
                    $mm_categories_product = wp_get_post_terms($product->ID, 'product_cat');
                    $product_cat = $mm_categories_product[0];
                }
            ?>
            <div class="mmtf-product-cat-pimary"><?php echo(!empty($product_cat) ? $product_cat->name : ''); ?></div>
            
            <?php if ($tag_likely_to_sell_out)  { ?>
                <div class="mmtf-product-tag-likely-to-sell-out">Likely to Sell Out</div>
            <?php } ?>

            <div class="mmtf_product_image_slider_wraper">
                <?php if( class_exists('WCPL_Product_Likes_Display') ){ ?>
                <?php       $likes->button( $product->ID ); ?>
                <?php } ?>
                
                <?php echo get_the_post_thumbnail( $product->ID, 'shop_catalog' ); ?>
                <?php 
                    // foreach($galleries_id as $key => $gallerie_id) {
                    //     if ($key == ($galleries_limit - 1)) {
                    //         break;
                    //     }
                        ?>
                            <!-- <img src="<?php //echo wp_get_attachment_image_src($gallerie_id, 'shop_catalog')[0]; ?>" /> -->
                        <?php
                    // }
                ?>
            </div>
            <?php if ($galleries_id) { ?>
                <div class="dots">
                    <?php foreach($galleries_id as $key => $gallerie_id) { ?>
                        <?php 
                            if ($key == $galleries_limit) {
                                break;
                            } 
                        ?>
                        <div class="dot"></div>
                    <?php } ?>
                </div>
                <button class="prev"></button>
                <button class="next"></button>
            <?php } ?>
        </div>

        <div class="product_result_title">
            <?php echo $product->post_title; ?>
        </div>
        
        <div class="product_result_description_wrapper">
            <!-- re-style the tour box (CATEGORY - DURATION - PICKUP AVAILABLE) -->
            <div class="product_result_description">
                <div class="product_result_description_content">
                <?php
                    echo do_shortcode('[mm_filtering_product_result_description_shortcode product_id="' . $product->ID . '"]');
                ?>
                </div>
                <?php
                    if( ! empty( $availability[ $product->ID ] ) ){
                        ?> 
                            <div class="product_result_availability_wrapper">
                        <?php
                        echo 'AVAIL';

                        if( ! empty( $_GET["date_start"] ) || ! empty( $_GET["date_end"] ) ){

                            echo ' within selected range';

                        }

                        echo ': ';
                        echo date( "F jS", strtotime( $availability[ $product->ID ][0] ) );

                        if( ( current_user_can('edit_posts') || current_user_can('manage_woocommerce') ) && count( $availability[ $product->ID ] ) > 1 ){

                            echo ' <span class="more_availability">(More)</span>';

                            echo '<div class="product_result_availability">';
                            echo    '<div style="text-align: left; padding-right: 50px;">Available:</div>';
                            echo    Availability\get_formatted_availability_dates( $availability[ $product->ID ] );
                            echo '</div>';

                        }
                        ?>
                            </div>
                        <?php
                        // Logs\debug_log( $availability[ $product->ID ], "mmtf-product.php-availability: " . $product->post_title );
                    }
                ?>
            </div>
        </div>
        
        <div class="product_result_price_wrapper">
            <div class="product_result_price">
                <?php
                    $price_origin = '$'.number_format($product->_wc_display_cost);
                    $price_sale = floor($product->_wc_display_cost * (1 - (5 / 100)));
                    if ($tag_deal) {
                        ?>
                            <span class="product_result_price_amount_origin">
                                <?php
                                    echo $price_origin;
                                ?>
                            </span>
                            <div class="product_result_price_amount">
                                <span class="product_result_price_label">from</span>
                                $<?php echo number_format($price_sale); ?>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="product_result_price_amount">
                                <span class="product_result_price_label">from</span>
                                <?php echo $price_origin; ?>
                            </div>
                        <?php
                    }
                ?>
            </div>
            <div class="product_result_rating"><?php echo Templates\get_star_rating_html( $rating ); ?></div>
        </div>
    </a>
</li>

<?php

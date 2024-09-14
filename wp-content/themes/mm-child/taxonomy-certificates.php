<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

$cate = get_queried_object();
$cateID = $cate->term_id;
?>
<header class="woocommerce-products-header certificates">
    <div class="entry-content-wrapper clearfix">
        <div class="flex_column av_one_third  flex_column_div av-zero-column-padding first  avia-builder-el-2  el_after_av_one_full  el_before_av_two_third  column-top-margin" style="border-radius:0px; ">
            <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                <h1 class="woocommerce-products-header__title page-title-certificates" style=" padding-top: 0px;"><?php woocommerce_page_title(); ?></h1>
            <?php endif; ?>

            <?php $image_id = get_term_meta($cateID, 'certificate-image-id', true); ?>
            <?php if ($image_id) { ?>
                <div id="category-image-wrapper">
                    <div class="logo-certificates">
                        <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                    </div>
                </div>
            <?php } ?>
            <?php
            $phone = get_term_meta($cateID, 'certificate_tax_phone', true);
            $address = get_term_meta($cateID, 'certificate_tax_address', true);
            $facebook = get_term_meta($cateID, 'certificate_tax_facebook', true);
            $instagram = get_term_meta($cateID, 'certificate_tax_instagram', true);
            $pinterest = get_term_meta($cateID, 'certificate_tax_pinterest', true);
            $youtube = get_term_meta($cateID, 'certificate_tax_youtube', true);
//            $twitter = get_term_meta($cateID, 'certificate_tax_twitter', true);
            if ($phone != '') {
                ?>
                <div class="certificate_contact">
                    <div style="background-color:#2189c1; border:1px solid #2189c1; color:#ffffff; " class="iconlist_icon  avia-font-mm-ht-font-icon"><span class="iconlist-char " aria-hidden="true" data-av_icon="" data-av_iconfont="mm-ht-font-icon"></span></div>
                    <div class="certificate_contact_detail"><span class="title">Phone</span><br><span><a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></span></div>
                </div>
                <?php
            }
            if ($address != '') {
                ?>
                <div class="certificate_contact">
                    <div style="background-color:#2189c1; border:1px solid #2189c1; color:#ffffff; " class="iconlist_icon  avia-font-mm-ht-font-icon"><span class="iconlist-char " aria-hidden="true" data-av_icon="" data-av_iconfont="mm-ht-font-icon"></span></div>
                    <div class="certificate_contact_detail"><span class="title">Address</span><br><span><?php echo $address; ?></span></div>
                </div>
            <?php }
            ?>
            <div class="social-contact " itemprop="text">
                <ul class="noLightbox social_bookmarks icon_count_2">
                    <?php if ($facebook != '') { ?>
                        <li class="social_bookmarks_facebook av-social-link-facebook social_icon_1"><a title="Facebook" href="<?php echo $facebook; ?>" target="_blank" rel="nofollow noopener" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"><br>
                                <span class="avia_hidden_link_text">Facebook</span><br>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($pinterest != '') { ?>
                        <li class="social_bookmarks_pinterest av-social-link-pinterest social_icon_2"><a title="Pinterest" href="<?php echo $pinterest; ?>" target="_blank" rel="nofollow noopener" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"><br>
                                <span class="avia_hidden_link_text">Pinterest</span><br>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($instagram != '') { ?>
                        <li class="social_bookmarks_instagram av-social-link-instagram"><a title="Instagram" href="<?php echo $instagram; ?>" target="_blank" rel="nofollow noopener" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"><br>
                                <span class="avia_hidden_link_text">Instagram</span><br>
                            </a>
                        </li>
                    <?php } ?>

<!--                    --><?php //if ($twitter != '') { ?>
<!--                        <li class="social_bookmarks_twitter av-social-link-twitter"><a title="Twitter" href="--><?php //echo $twitter; ?><!--" target="_blank" rel="nofollow noopener" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"><br>-->
<!--                                <span class="avia_hidden_link_text">Twitter</span><br>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
                    <?php if ($youtube != '') { ?>
                        <li class="social_bookmarks_youtube av-social-link-youtube"><a title="Youtube" href="<?php echo $youtube; ?>" target="_blank" rel="nofollow noopener" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"><br>
                                <span class="avia_hidden_link_text">Youtube</span><br>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="flex_column av_two_third  flex_column_div av-zero-column-padding   avia-builder-el-3  el_after_av_one_third  avia-builder-el-last  column-top-margin" style="border-radius:0px; ">
            <div class="des">
                <?php echo term_description(); ?>
            </div>
            <?php
            /**
             * Hook: woocommerce_archive_description.
             *
             * @hooked woocommerce_taxonomy_archive_description - 10
             * @hooked woocommerce_product_archive_description - 10
             */
            do_action('woocommerce_archive_description');
            ?>
        </div>
    </div>
</header>
<div class="entry-content-wrapper clearfix"></div>
<form id="category-select" class="category-select" action="<?php echo get_term_link($cateID); ?>" method="get" style="clear: both;">
    <!--<span><?php _e('Categories:'); ?></span>-->
    <?php
    $total_posts = 0;
    $all_categorie = array();
    $all_tag = array();
    $custom_query = new WP_Query(
            array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'certificates',
                'field' => 'term_id',
                'terms' => absint($cateID),
            ),
        ),
        'post_status' => 'publish',
        'orderby' => 'post_date',
        'order' => 'DESC'
            )
    );
    ob_start();
    if ($custom_query->have_posts()) {
        $total_posts = $custom_query->post_count;
        $i = 1;
        while ($custom_query->have_posts()) : $custom_query->the_post();
            $id = get_the_ID();
            $categories = get_the_terms($id, 'product_cat');
            if ($categories) {
                foreach ($categories as $categorie) {
                    $all_categorie[$categorie->term_id] = $categorie->name;
                }
            }
            $tags = get_the_terms($id, 'product_tag');
            if ($tags) {
                foreach ($tags as $tag) {
                    $all_tag[$tag->term_id] = $tag->name;
                }
            }
            if ($i <= '12') {
                wc_get_template_part('content', 'product');
            }
            $i++;
        endwhile;
    } else {
        echo __('No products found');
    }
    wp_reset_postdata();
    $output = ob_get_clean();
    $all_categorie = array_unique($all_categorie);
    $categorie_str = implode(",", $all_categorie);
    $all_tag = array_unique($all_tag);
    $tag_str = implode(",", $all_tag);
    $category_id = '-1';
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    }
    if (isset($_GET['tag_id'])) {
        $tag_id = $_GET['tag_id'];
    }
    /*if (!empty($all_categorie)) {
        ?>
        <select name="category_id" id="category_id" >
            <option value="-1" >Select a Category</option>
            <?php
            foreach ($all_categorie as $key => $value) {
                ?>
                <option value="<?php echo $key; ?>" <?php if ($category_id == $key) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
    }*/
    /*if (!empty($all_tag)) {
    ?>
        <select name="tag_id" id="tag_id" >
            <option value="-1" >Select a Tag</option>
            <?php
            foreach ($all_tag as $key => $value) {
                ?>
                <option value="<?php echo $key; ?>" <?php if ($tag_id == $key) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                <?php
            }
            ?>
        </select>
        <?php
    }*/
    /*if (!empty($all_categorie) || !empty($all_tag)) {
        ?>
        <button class="mm-button-filter">Filter</button>
        <?php 
    }*/
    ?>
    <div class="mm_loader_ajax" style="display: none"></div>
    <input type="hidden" name="certificate_id" value="<?php echo $cateID; ?>">
</form>
<main class="template-shop content av-content-full alpha units" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="https://schema.org/SomeProducts">
    <div class="entry-content-wrapper">
        <ul class="products columns-3">
            <?php echo $output; ?>
        </ul>
        <?php
        $max_page = 0;
        $style_more = 'display:none';
        if ($total_posts > 12) {
            $max_page = floor($total_posts / 12);
            if ($total_posts % 12 != 0) {
                $max_page = $max_page + 1;
            }
            $style_more = '';
        }
        ?>
        <div class="av-masonry-pagination mm-product-load-more av-masonry-load-more" style="visibility: visible;opacity: 1; <?php echo $style_more; ?>" id="load-more" data-page="2" data-max_page="<?php echo $max_page; ?>">Load more <div class="custom-loading-icon" style="display: none;"></div></div>

    </div>
</main>
<?php

// show hotel
do_action('mm_show_list_hotel_badges_product', $cate->slug);

// show restaurant
do_action('mm_show_list_restaurant_badges_product', $cate->slug);

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');

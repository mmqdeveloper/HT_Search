<?php

namespace MauiMarketing\MMTF\Templates\TourFiltering;

use MauiMarketing\MMTF\Product\Availability;
use MauiMarketing\MMTF\Templates;
use MauiMarketing\MMTF\Filtering;
use MauiMarketing\MMTF\Core;
use MauiMarketing\MMTF\Logs;

if ( !defined('ABSPATH') ){ die(); }

get_header();

$config = Core\config();


if( empty( $_GET["group"] ) ){
    
    $_GET["group"] = 2;
}

$current_page = ! empty( $_GET["pp"] ) ? $_GET["pp"] : 1;

$args = [];

if( $current_page > 1 ){
    
    $args = [
        'paged'          => 1,
        'posts_per_page' => $config["products_per_page"] * $current_page,
    ];
}

if (empty($_GET['mmtf_query_by'])) {
    // $upload_dir = wp_upload_dir();
    // $upload_path = $upload_dir['basedir'];
    // $cache_folder = $upload_path . '/mm_cache_result_search';
    // $name_file_cache = md5(serialize($args));
    // $file_path_cache = $cache_folder.'/'.$name_file_cache.'_not_ajax.json';
    // if (!file_exists($cache_folder)) {
    //     wp_mkdir_p($cache_folder);
    // }
    // if (file_exists($file_path_cache)) {
    //     $result_cache_html = json_decode(file_get_contents($file_path_cache), true)['html'];
    // }
    // if (empty($result_cache_html)) {
        $query = Filtering\get_filtered_products_query( $args );
        $post_count = $query->post_count;
        $found_posts = $query->found_posts;
        // $availability = Availability\get_filtered_products_availability( wp_list_pluck( $query->posts, 'ID' ) );
    // }
}

// Logs\debug_log( $query->posts, "mmtf.php-query->posts" );


$price_low  = ! empty( $_GET["min"] ) ? (int) $_GET["min"] : 0;
$price_high = ! empty( $_GET["max"] ) ? (int) $_GET["max"] : $config["max_price"];
$price_high = $price_high > $config["max_price"] ? $config["max_price"] : $price_high;
$price_high_style = $price_high == $config["max_price"] ? '' : ' style="display:none;"';

// $categories     = ! empty( $_GET["cat"] ) ? explode( ",", $_GET["cat"] ) : [];
// $certificates   = Templates\_sanitize_explode_int_get("cert");
// $tags           = Templates\_sanitize_explode_int_get("tag");

$categories_title_active    = empty( $categories    ) ? ' style="font-weight: bold;"' : '';
$certificates_title_active  = empty( $certificates  ) ? ' style="font-weight: bold;"' : '';
$tags_title_active          = empty( $tags          ) ? ' style="font-weight: bold;"' : '';

// $categories_html    = Templates\_get_taxonomies_html( "product_cat",  $categories     );
// $certificates_html  = Templates\_get_taxonomies_html( "certificates", $certificates   );
// //$tags_html          = Templates\_get_taxonomies_html( "product_tag",  $tags           );
// $tags_html = '';

// $date_start = ! empty( $_GET["date_start"] ) ? $_GET["date_start"] : "";
// $date_end   = ! empty( $_GET["date_end"]   ) ? $_GET["date_end"]   : ( $date_start ? $date_start : "" );


// $group_size  = ! empty( $_GET["group"] ) ? (int) $_GET["group"] : "";
// $group_class = $group_size && $group_size != 2 ? ' class="has_value"' : '';


// $search       = ! empty( $_GET["sr"] ) ? $_GET["sr"] : "";
// $search_class = $search ? ' class="has_value"' : '';


// $active_filters = Filtering\count_active_filters();


$primary_color = $config["primary_color"];


// if( class_exists('WCPL_Product_Likes_Display') ){
    
//     $likes = new \WCPL_Product_Likes_Display();
// }

$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>

<style>
    :root{
        --mmtf-primary-color: <?php             echo $primary_color; ?>;
        --mmtf-primary-transparent: <?php       echo $primary_color; ?>60;
        --mmtf-primary-transparent-light: <?php echo $primary_color; ?>20;
        --mmtf-primary-transparent-dark: <?php  echo $primary_color; ?>90;
    }
</style>
<script>
    var mm_price_range = {
        low  : <?php  echo $price_low; ?>,
        high : <?php  echo $price_high; ?>,
        max  : <?php  echo $config["max_price"]; ?>
    };
</script>
<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

    <div id="mmtf_top">
        
        <?php include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-filter.php' ); ?>
        
    </div>

	<div id='mmtf' class="container">
        <div id="mmtf_sidebar_overlay" class="mmtf_sidebar_overlay mmtf-hide-sidebar"></div>
        <div id="mmtf_sidebar">
        
            <?php include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-sidebar.php' ); ?>
            
        </div>

		<div id="mmtf_results">
            
            <div id="mmtf_results_header">
                <?php include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-cate-slide.php' ); ?>
                <div class="mmtf_filter_wrapper_action">
                    <div class="mmtf_filter_btn_filter mmtf-show-sidebar" id="mmtf_filter_btn_filter">
                        <img src="<?php echo \MauiMarketing\MMTF\PLUGIN_URL. 'images/settings.png' ?>" />
                        <span>Filter</span>
                    </div>
                    <div class="mmtf_filter_btn_clear_filter" id="mmtf_filter_btn_clear_filter">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="23" x="0" y="0" viewBox="0 0 512.004 512.004" xml:space="preserve" class=""><g><path d="M361.183 0c-54.059 0-99.836 36.049-114.505 85.331H53.73c-18.024 0-28.614 20.339-18.285 35.119.16.231-5.363-7.31 129.747 177.039a23.501 23.501 0 0 1 4.148 13.367v177.688c0 19.435 22.224 30.24 37.473 18.754l57.593-43.518c8.614-6.415 13.754-16.655 13.754-27.409V310.856c0-4.798 1.435-9.417 4.149-13.369l46.497-63.451c76.139 21.439 151.81-36.022 151.81-114.791C480.617 53.493 427.039 0 361.183 0zM257.991 279.919c-5.835 7.968-9.831 19.1-9.831 30.938 0 136.483.734 127.081-1.68 128.869-1.91 1.421 10.835-8.188-47.14 35.618V310.856a53.368 53.368 0 0 0-9.622-30.646c-.169-.242 4.923 6.71-120.835-164.88h172.938c-1.457 44.852 22.126 84.961 58.678 106.581zm103.192-71.428c-49.314 0-89.434-40.035-89.434-89.246 0-49.21 40.12-89.245 89.434-89.245 49.313 0 89.433 40.035 89.433 89.245.001 49.211-40.119 89.246-89.433 89.246z" fill="#000000" opacity="1" data-original="#000000" class=""></path><path d="M400.201 80.298c-5.854-5.864-15.35-5.872-21.213-.02l-17.805 17.773-17.805-17.773c-5.863-5.853-15.361-5.846-21.213.02-5.853 5.862-5.844 15.36.019 21.213l17.767 17.735-17.767 17.735c-5.863 5.853-5.872 15.351-.019 21.213 5.833 5.844 15.331 5.891 21.213.02l17.805-17.773 17.805 17.773c5.845 5.834 15.343 5.862 21.213-.02 5.853-5.862 5.844-15.36-.019-21.213l-17.767-17.735 17.767-17.735c5.863-5.853 5.872-15.351.019-21.213z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
                        <span>Clear</span>
                    </div>
                    <div id="mmtf_btn_share">
                        <div class="mmtf_btn_share_inner">
                            <svg width="24" height="24" viewBox="0 0 24 22" xmlns="http://www.w3.org/2000/svg" class="icon__3A1i" fill="#000"><path d="M6.22 7.22a.75.75 0 001.06 1.06L11 4.56v11.69a.75.75 0 001.5 0V4.56l3.72 3.72a.75.75 0 101.06-1.06l-5-5a.75.75 0 00-1.06 0l-5 5z"></path><path d="M6.25 22A3.25 3.25 0 013 18.75v-7a.75.75 0 011.5 0v7c0 .97.78 1.75 1.75 1.75h11c.97 0 1.75-.78 1.75-1.75v-7a.75.75 0 011.5 0v7c0 1.8-1.46 3.25-3.25 3.25h-11z"></path></svg>
                            <span>Share</span>
                        </div>
                        <ul id="mmtf_option_share">
                            <li class="mmtf_item-share">
                                <a rel="nofollow" id="mmtf_option_share_copy" data-current_url="<?php echo($currentURL); ?>">
                                    <i class="fa fa-clone"></i>Copy Link
                                </a>
                            </li>
                            <li class="mmtf_item-share">
                                <a rel="nofollow" target="_blank" href="<?php echo("mailto:?body=I found this on Hawaiitours and thought you'd love it: - ".$currentURL."/&subject=Check out this Experience on Hawaiitours!"); ?>" id="mmtf_option_share_email">
                                    <i class="fa fa-envelope-o"></i>Email
                                </a>
                            </li>
                            <li class="mmtf_item-share">
                                <a rel="nofollow" target="_blank" href="<?php echo("https://www.facebook.com/sharer.php?u=".$currentURL); ?>" id="mmtf_option_share_facebook">
                                    <i class="fa fa-facebook-square"></i>Facebook
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="mmtf_results_header_sortable">
                <span class="mmtf_results_header_product_found">
                    <?php
                        if (!empty($query->found_posts)) {
                            echo $query->found_posts. ' activities found';
                        }
                    ?>
                </span>
            </div>
                
            <ul id="mmtf_products_results">
                <?php 
                    // if (!empty($result_cache_html)) {
                    //     echo $result_cache_html;
                    // } else {
                        // $result_cache = '';
                        // ob_start();
                        if( $query->posts ){
                            foreach( $query->posts as $product ){ 
                                include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-product.php' );
                            }
                        }
                        // $result_cache = ob_get_contents();
                        // ob_end_clean();
                        // echo $result_cache;
                        // $data_cache = json_encode(array('html' => $result_cache));
                        // file_put_contents($file_path_cache, $data_cache);
                    // }
                ?>
            </ul>
		</div>

        <div id="mmtf_load_more" <?php echo(!empty($_GET['mmtf_query_by']) ? 'style="display:none"' : ''); ?> data-posts_per_page="" data-current_page="<?php echo esc_attr( $current_page ); ?>">Show more</div>
            
        <div id="mmtf_loading_more">Please wait, loading...</div>

	</div>

</div>
<!-- close default .container_wrap element -->

<?php 

get_footer();

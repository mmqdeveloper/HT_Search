<?php
/**
 * Ajax functions
 * 
 */

namespace MauiMarketing\MMTF\Ajax;

use MauiMarketing\MMTF\Product\Availability;
use MauiMarketing\MMTF\Filtering;
use MauiMarketing\MMTF\Logs;
use MauiMarketing\MMTF\Core;


function get_products(){
    
    $args = [];

    $params = ! empty( $_POST["params"] ) ? $_POST["params"] : [];
    
    foreach( $params as $key => $value ){
        $args[ $key ] = $value;
    }
        
    if( ! empty( $params["pp"] ) ){
        
        $args["paged"] = $params["pp"];
    }
    if( ! empty( $params["items"] ) ){
    
        $args["posts_per_page"] = $params["items"];
    }
    
    $query = Filtering\get_filtered_products_query( $args );

    
    $availability = Availability\get_filtered_products_availability( wp_list_pluck( $query->posts, 'ID' ) );
    
    
    $posts_html = "";
    
    
    if( $query->posts ){
        
        if( class_exists('WCPL_Product_Likes_Display') ){
            
            $likes = new \WCPL_Product_Likes_Display();
        }

        ob_start();
        
        foreach( $query->posts as $product ){
            
            include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-product.php' );
        }
        
        $posts_html = ob_get_contents();
        ob_end_clean();
        
    }
    
    $return = [
        "posts_html" => $posts_html,
        "post_count" => $query->post_count,
        "post_total" => $query->found_posts,
        "args" => $args,
    ];
    
    // Logs\debug_log( $return, "ajax-get_products-return" );
    
	wp_send_json_success( $return );
    
}
add_action( 'wp_ajax_'        . 'mmtf_' . 'get_products', __NAMESPACE__ . '\\' . 'get_products' );
add_action( 'wp_ajax_nopriv_' . 'mmtf_' . 'get_products', __NAMESPACE__ . '\\' . 'get_products' );

function recalculate_products(){
    
    $product_ids = ! empty( $_REQUEST["product_ids"] ) ? $_REQUEST["product_ids"] : [ "processed" => [], "todo" => [] ];
    
    $step = rand( 15, 25 );
    
    if( empty( $product_ids["processed"] ) && empty( $product_ids["todo"] ) ){
        
        $args = [
            "post_type"         => "product",
            "post_status"       => "publish",
            "posts_per_page"    => -1,
            'suppress_filters'  => true,
            'fields'            => 'ids',
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'update_menu_item_cache' => false,
        ];
        
        $query = new \WP_Query( $args );
        
        $product_ids["todo"] = $query->get_posts();
        
        // Logs\debug_log( $product_ids["todo"], "ajax-recalculate_products-product_ids-todo: " . count( $product_ids["todo"] ) );
        // Logs\debug_log( $query, "ajax-recalculate_products-query" );
        
    }
    
    if( empty( $product_ids["todo"] ) ){
        
        wp_send_json_success( $product_ids );
    }
    
    // Logs\debug_log( "processed: " . count( $product_ids["processed"] ) . PHP_EOL . "ToDo: " . count( $product_ids["todo"] ) . PHP_EOL , "ajax-recalculate_products-product_ids-counts-before" );
    
    $processing_ids = array_slice( $product_ids["todo"], 0, $step );
    
    foreach( $processing_ids as $post_id ){
        
        Availability\update_post_availability( $post_id );
        Availability\update_post_priority( $post_id );
    }
    
    
    $product_ids["todo"]      = array_slice( $product_ids["todo"], $step );
    $product_ids["processed"] = array_merge( $product_ids["processed"], $processing_ids );
    
    // Logs\debug_log( "processed: " . count( $product_ids["processed"] ) . PHP_EOL . "ToDo: " . count( $product_ids["todo"] ) . PHP_EOL , "ajax-recalculate_products-product_ids-counts-after" );
    
    // $product_ids["todo"] = [ "all" ];
    
    $return = $product_ids;
    
    // Logs\debug_log( $return, "ajax-recalculate_products-return" );
    
	wp_send_json_success( $return );
    
}
add_action( 'wp_ajax_'        . 'mmtf_' . 'recalculate_products', __NAMESPACE__ . '\\' . 'recalculate_products' );
add_action( 'wp_ajax_nopriv_' . 'mmtf_' . 'recalculate_products', __NAMESPACE__ . '\\' . 'recalculate_products' );

if (!function_exists('mm_search_get_product_not_availability')) {
    function mm_search_get_product_not_availability ($product_ids, $avaliable, $from, $end) {

        if (!is_array($product_ids)) {
            return;
        }

        $dates_from_end = array();
        $end_date = new \DateTime($end);
        $from_date = new \DateTime($from);
        while ($from_date <= $end_date) {
            $dates_from_end[] = $from_date->format('Y-m-d');
            $from_date->modify('+1 day');
        }

        $product_ids_not_avaliable = array();

        foreach($product_ids as $product_id) {
            $is_aval = false;
            $aval = $avaliable[$product_id];
            foreach($dates_from_end as $date) {
                if (in_array($date, $aval)) {
                    $is_aval = true;
                }
            }
            if ($is_aval == false) {
                $product_ids_not_avaliable[] = $product_id;
            }
        }

        return $product_ids_not_avaliable;
    }
}

// Search Ajax
function mm_search_ajax () {

    global $wpdb;

    $config = Core\config();

    $args = [];

    $list_island = array(
        'oahu',
        'maui',
        'kauai',
        'big island'
    );

    $island_checked = '';
    $products_per_page = $config["products_per_page"];

    $keyword = strtolower(sanitize_text_field($_POST["keyword"]));

    if( !empty( $keyword ) && function_exists('relevanssi_do_query') ) {
        $keyword = trim(str_replace(['tours', 'tour'], '', $keyword));
        $is_search_cat = $sa_category_filter = false;
        $sa_category = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'search'     => $keyword
        ));
        if (!empty($sa_category)) {
            if (in_array($keyword, $list_island)) {
                $_POST['island'] = $sa_category[0]->slug;
            } else {
                $cat_slug_search = array();
                foreach ($sa_category as $cat) {
                    $cat_slug_search[] = $cat->slug;
                }
                if (!empty($_POST['sa_category'])) {
                    $sa_category_filter = explode(',', $_POST['sa_category']);
                    $_POST['sa_category'] = $_POST['sa_category'].','.implode(',', $cat_slug_search);
                } else {
                    $_POST['sa_category'] = implode(',', $cat_slug_search);
                }
            }
            $is_search_cat = true;
        }

        if ($is_search_cat != true) {
            $keyword_has_island = false;
            foreach($list_island as $island) {
                if (strpos($keyword, $island) !== false) {
                    $keyword_has_island = true;
                    $keyword_skip_island = str_replace($island, '', $keyword);
                    $island_category = get_term_by('name', $island, 'product_cat');
                    $_POST['island'] = $island_category->slug;
                    $island_checked = $island_category->slug;
                    $sa_tag = get_term_by('name', $keyword_skip_island, 'product_tag');
                    if (!empty($sa_tag)) {
                        $_POST['sa_tag'] = $sa_tag->slug;
                    }
                }
            }
            if ($keyword_has_island == false) {
                $args['s'] = $keyword;
            }
        }
        if(empty($_POST['sa_category'])){
            if ($keyword ==  'oahu') {
                $_POST['sa_category'] = 'oahu';
            }
            if ($keyword ==  'big island') {
                $_POST['sa_category'] = 'big-island';
            }
            if ($keyword ==  'kauai') {
                $_POST['sa_category'] = 'kauai';
            }
            if ($keyword ==  'maui') {
                $_POST['sa_category'] = 'maui';
        }
        }
    }

    if (! empty( $_POST["island"] ) && ! empty( $_POST["sa_category"] )) {
        $slug_cat = explode(',', $_POST["sa_category"]);
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $slug_cat,
                'operator' => 'IN',
            )
        );
    } else if (! empty( $_POST["island"] ) && ! empty( $_POST["sa_tag"] )) {
        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $_POST["island"],
            ),
            array(
                'taxonomy' => 'product_tag',
                'field' => 'slug',
                'terms' => $_POST["sa_tag"],
            )
        );
    } else if( ! empty( $_POST["island"] )) {
        $taxonomy_slugs = explode( ",", $_POST["island"] );
        
        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $_POST["island"],
            )
        );
    } else if( ! empty( $_POST["sa_category"] ) ) {
        if (strpos($_POST["sa_category"], ',') !== false) {
            $slug_cat = explode(',', $_POST["sa_category"]);
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $slug_cat,
                    'operator' => 'IN',
                )
            ); 
        } else {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $_POST["sa_category"],
                )
            );  
        } 
    }

    if( ! empty( $_POST["sa_price_min"] ) ){
        
        $price_min = (int) $_POST["sa_price_min"];
        
        if( empty( $args['meta_query'] ) ){
            $meta_query_price_min = [
                "relation" => "AND",
            ];
        } else {
            $meta_query_price_min = $args['meta_query'];
        }
        
        $meta_query_price_min[] = [
            "key"       => "_wc_display_cost",
            "compare"   => ">=",
            "value"     => $price_min,
            "type"      => "NUMERIC",
        ];
        
        $args['meta_query'] = $meta_query_price_min;
        
    }
    
    if( ! empty( $_POST["sa_price_max"] ) ){
        
        $price_max = (int) $_POST["sa_price_max"];
        
        if( empty( $args['meta_query'] ) ){
            $meta_query_price_max = [
                "relation" => "AND",
            ];
        } else {
            $meta_query_price_max = $args['meta_query'];
        }
        
        $meta_query_price_max[] = [
            "key"       => "_wc_display_cost",
            "compare"   => "<=",
            "value"     => $price_max,
            "type"      => "NUMERIC",
        ];
        
        $args['meta_query'] = $meta_query_price_max;
        
    }

    if (!empty($_POST['sa_dur_min']) && !empty($_POST['sa_dur_max'])) {
        $duration_min = (int)sanitize_text_field($_POST['sa_dur_min']);
        $duration_max = (int)sanitize_text_field($_POST['sa_dur_max']);
        $duration_option = 'hour';
        
        if( empty( $args['meta_query'] ) ){
            $meta_query_dur = [
                "relation" => "AND",
            ];
        } else {
            $meta_query_dur = $args['meta_query'];
        }

        $meta_query_dur[] = [
            'key' => '_mm_duration',
            'value' => array($duration_min, $duration_max),
            'compare' => 'BETWEEN',
            'type'    => 'NUMERIC',
        ];

        $meta_query_dur[] = [
            'key' => '_mm_duration_unit',
            'value' => $duration_option,
            'compare' => '='
        ];

        $args['meta_query'] = $meta_query_dur;
    }

    if (!empty($_POST['sa_pickup'])) {
        $pickup = sanitize_text_field($_POST['sa_pickup']);
        
        if( empty( $args['meta_query'] ) ){   
            $meta_query_pk = [
                "relation" => "AND",
            ]; 
        } else {
            $meta_query_pk = $args['meta_query'];
        }

        $meta_query_pk[] = [
            'key' => '_mm_pickup',
            'value' => $pickup,
            'compare' => '='
        ];

        $args['meta_query'] = $meta_query_pk;
    }

    if (!empty($_POST['sa_time_of_day'])) {
        $time_of_day = sanitize_text_field($_POST['sa_time_of_day']);
        
        if( empty( $args['meta_query'] ) ){   
            $meta_query_tfd = [
                "relation" => "AND",
            ]; 
        } else {
            $meta_query_tfd = $args['meta_query'];
        }

        $meta_query_tfd[] = [
            'key' => '_mm_time_of_day',
            'value' => $time_of_day,
            'compare' => '='
        ];

        $args['meta_query'] = $meta_query_tfd;
    }

    if (!empty($_POST['paged'])) {
        $args['paged'] = $_POST['paged'];
    }

    if ( ! empty( $_POST["sa_date_start"] ) && ! empty( $_POST["sa_data_end"] ) ) {
        $table_name = $wpdb->prefix . 'posts';
        $query_get_product_ids = "SELECT ID FROM $table_name WHERE post_type = 'product' AND post_status = 'publish';";
        $results_product_id = $wpdb->get_col($query_get_product_ids);
        $availability_search = Availability\get_filtered_products_availability( $results_product_id );
        $product_ids_not_avaliable = mm_search_get_product_not_availability($results_product_id, $availability_search, $_POST["sa_date_start"], $_POST["sa_data_end"]);
        if (!empty($product_ids_not_avaliable)) {
            $args['post__not_in'] = $product_ids_not_avaliable;
        }
    }

    if (!empty($sa_category_filter) && !empty($is_search_cat)) {
        $products_per_page = -1;
    }

    if (!empty($products_per_page)) {
        $args['posts_per_page'] = $products_per_page;
    }

    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['basedir'];
    $cache_folder = $upload_path . '/mm_cache_result_search';
    $name_file_cache = md5(serialize($args));
    $file_path_cache = $cache_folder.'/'.$name_file_cache.'.json';
    if (!file_exists($cache_folder)) {
        wp_mkdir_p($cache_folder);
    }

    if (file_exists($file_path_cache)) {
        $content_cache = json_decode(file_get_contents($file_path_cache));
        wp_send_json_success( $content_cache );
        return;
    }

    $query_ajax = Filtering\get_filtered_products_query( $args );
    // $availability = Availability\get_filtered_products_availability( wp_list_pluck( $query_ajax->posts, 'ID' ) );

    $result = '';

    ob_start();
    if ( $query_ajax->posts ) {
        $products_id_in = array();
        foreach( $query_ajax->posts as $product ){
            if (!empty($_POST['island'])) {
                $pos_from = strpos(strtolower($product->post_title), 'from');
                if ($_POST['island'] == 'oahu') {
                    $pos_oahu = strpos(strtolower($product->post_title), 'oahu');
                    if ($pos_from !== false && $pos_oahu !== false && $pos_from < $pos_oahu) {
                        continue;
                    }
                }
                if ($_POST['island'] == 'maui') {
                    $pos_maui = strpos(strtolower($product->post_title), 'maui');
                    if ($pos_from !== false && $pos_maui !== false && $pos_from < $pos_maui) {
                        continue;
                    }
                }
                if ($_POST['island'] == 'kauai') {
                    $pos_kauai = strpos(strtolower($product->post_title), 'kauai');
                    if ($pos_from !== false && $pos_kauai !== false && $pos_from < $pos_kauai) {
                        continue;
                    }
                }
                if ($_POST['island'] == 'big-island') {
                    $pos_bigisland = strpos(strtolower($product->post_title), 'big-island');
                    if ($pos_from !== false && $pos_bigisland !== false && $pos_from < $pos_bigisland) {
                        continue;
                    }
                }
            }
            if (!empty($sa_category_filter) && !empty($is_search_cat)) {
                $products_id_in[] = $product->ID;
            } else {
                include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-product.php' );
            }
        }
        if (!empty($sa_category_filter) && !empty($is_search_cat)) {
            $args_second = array(
                'post__in' => $products_id_in,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $sa_category_filter,
                        'operator' => 'IN',
                    )
                )
            );
            $query_ajax_second = Filtering\get_filtered_products_query( $args_second );
            if ( $query_ajax_second->posts ) {
                foreach( $query_ajax_second->posts as $product ){
                    include( \MauiMarketing\MMTF\PLUGIN_DIR . 'templates/parts/mmtf-product.php' );
                }
            }
        }
    } else {
        ?>
            <div class="result_not_found">
                <?php if (!empty($search)) { ?>
                    Sorry, we couldn't find any experiences or activities that match "<strong><?php echo $search;?></strong>"
                <?php } else { ?>
                    Sorry, we couldn't find any experiences or activities
                <?php } ?>
            </div>
        <?php
    }

    $result = ob_get_contents();
    ob_end_clean();

    if (!empty($query_ajax_second)) {
        $post_found = $query_ajax_second->found_posts;
    } else {
        $post_found = $query_ajax->found_posts;
    }

    if (!empty($_POST['paged'])) {
        $show_readmore = (($query_ajax->post_count + ($products_per_page * (int)$_POST['paged'])) < $query_ajax->found_posts);
    } else {
        $show_readmore = ($query_ajax->post_count < $query_ajax->found_posts);
    }

    $repons = [
        'html' => $result,
        'args' => json_encode($args),
        'show_readmore' => $show_readmore,
        'post_found' => $post_found
    ];

    if (!empty($island_checked)) {
        $repons['island_checked'] = $island_checked;
    }

    if (!file_exists($file_path_cache)) {
        $data_cache = json_encode($repons);
        file_put_contents($file_path_cache, $data_cache);
    }

	wp_send_json_success( $repons );
}
add_action( 'wp_ajax_'        . 'mmtf_' . 'search_ajax', __NAMESPACE__ . '\\' . 'mm_search_ajax' );
add_action( 'wp_ajax_nopriv_' . 'mmtf_' . 'search_ajax', __NAMESPACE__ . '\\' . 'mm_search_ajax' );

function mmtf_load_category_filter () {
    global $wpdb;

    $all_child_categories;
    $config = Core\config();
    if (!empty($_POST['keyword'])) {
        $keyword = strtolower(sanitize_text_field($_POST["keyword"]));
        $keyword = trim(str_replace(['tours', 'tour'], '', $keyword));
        if ($keyword == 'oahu' || $keyword == 'kauai' || $keyword == 'maui' || $keyword == 'big island') {
            $_POST['island_selected'] = $keyword;
        }
    }
    if (!empty($_POST['island_selected'])) {
        $id_island = get_term_by('slug', $_POST['island_selected'], 'product_cat')->term_id;
        $args = array(
            'taxonomy' => 'product_cat',
            'parent' => $id_island,
            'hide_empty' => true,
            // 'number' => $config["limit_category_filter"],
            'meta_query' => array(
                array(
                    'key' => 'mmtf_cat_is_show_search',
                    'value' => 'true',
                    'compare' => '=',
                ),
            ),
            'meta_key' => 'mmtf_search_priority',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
        );
        $all_child_categories = get_terms($args);
    } else {
        $args = array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            // 'number' => $config["limit_category_filter"],
            'meta_query' => array(
                array(
                    'key' => 'mmtf_cat_is_show_search',
                    'value' => 'true',
                    'compare' => '=',
                ),
            ),
            'meta_key' => 'mmtf_search_priority',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
        );
        $all_child_categories = get_terms($args);
    }
    

    if ($all_child_categories) {

        $cates_slide_custom = [];

        foreach($all_child_categories as $cate_slide) {
            $cates_slide_custom[] = array(
                'id' => $cate_slide->term_id,
                'name' => $cate_slide->name,
                'slug' => $cate_slide->slug,
                'icon' => get_term_meta($cate_slide->term_id, 'mmtf_icon_search', true),
                'priority' => get_term_meta($cate_slide->term_id, 'mmtf_search_priority', true),
            );
        }

        $cates_slide_custom = Filtering\mergeCategoriesWithSameName($cates_slide_custom);

        usort($cates_slide_custom, function ($a, $b) {
            $priorityOrder = array(
                1, 2, 3, 4, 5, 6, 7, 8, 9, 10
            );

            $aPriority = $a['priority'];
            $bPriority = $b['priority'];

            if (empty($aPriority)) {
                return 1;
            } elseif (empty($bPriority)) {
                return -1;
            } else {
                $aIndex = array_search($aPriority, $priorityOrder);
                $bIndex = array_search($bPriority, $priorityOrder);
                return $aIndex - $bIndex;
            }
        }); 

        $post__not_in = null;
        if ( ! empty( $_POST["start_day"] ) && ! empty( $_POST["end_day"] ) ) {
            $table_name = $wpdb->prefix . 'posts';
            $query_get_product_ids = "SELECT ID FROM $table_name WHERE post_type = 'product' AND post_status = 'publish';";
            $results_product_id = $wpdb->get_col($query_get_product_ids);
            $availability_search = Availability\get_filtered_products_availability( $results_product_id );
            $product_ids_not_avaliable = mm_search_get_product_not_availability($results_product_id, $availability_search, $_POST["start_day"], $_POST["end_day"]);
            if (!empty($product_ids_not_avaliable)) {
                $post__not_in = $product_ids_not_avaliable;
            }
        }

        $is_category = null;
        if (!empty($_POST['keyword'])) {
            $keyword = strtolower(sanitize_text_field($_POST["keyword"]));
            $keyword = trim(str_replace(['tours', 'tour'], '', $keyword));
            if ($keyword != 'oahu' || $keyword != 'kauai' || $keyword != 'maui' || $keyword != 'big island') {
                $args_term = array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                    'number' => 1,
                    'name' => $keyword,
                    'meta_query' => array(
                        array(
                            'key' => 'mmtf_cat_is_show_search',
                            'value' => 'true',
                            'compare' => '=',
                        ),
                    ),
                );
                $is_category = get_terms($args_term);
            }
        }

        $count = 0;
        foreach($cates_slide_custom as $key => $cate_slide_custom) {
            if ($count == $config["limit_category_filter"]) {
                break;
            }
            $have_product = true;
            if (!empty($_POST['keyword'])) {
                $keyword = strtolower(sanitize_text_field($_POST["keyword"]));
                $args = array(
                    'post_type'   => 'product',
                    "post_status" => "publish",
                    'posts_per_page' => 1,
                    'sentence' => true,
                    'tax_query'   => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $cate_slide_custom['id'],
                        ),
                    )
                );

                if (!empty($is_category) && strtolower($cate_slide_custom['name']) != strtolower($is_category->name)) {
                    continue;
                } else {
                    $args['s'] = $keyword;
                }

                if (!empty($post__not_in)) {
                    $args['post__not_in'] = $post__not_in;
                }
                
                $have_product = get_posts($args);
            }
            if ($have_product) {
                ?>
                    <label for="mmtf-<?php echo($cate_slide_custom['id']); ?>">
                        <input type="radio" style="display: none;" id="mmtf-<?php echo($cate_slide_custom['id']); ?>" name="mmtf-cate-slide" value="<?php echo($cate_slide_custom['slug']); ?>" <?php echo($_POST['sa_category'] == $cate_slide_custom['slug'] ? 'checked' : ''); ?> />
                        <span class="mmtf-btn-uncheck"></span>
                        <img src="<?php echo($cate_slide_custom['icon'] ? $cate_slide_custom['icon'] : plugins_url('/mm-tour-filtering/images/icon-categorys/travel.png')); ?>" class="mmtf-cate-icon" />
                        <span class="mmtf-cate-slide-line"></span>
                        <span class="mmtf-cate-slide-text"><?php echo($cate_slide_custom['name']); ?></span>
                    </label>
                <?php
                $count++;
            }
            wp_reset_postdata();
        }
    }
    $result = ob_get_contents();
    ob_end_clean();

    $repons = [
        'html' => $result,
    ];
    wp_send_json_success( $repons );
}
add_action( 'wp_ajax_'        . 'mmtf_' . 'load_category_filter', __NAMESPACE__ . '\\' . 'mmtf_load_category_filter' );
add_action( 'wp_ajax_nopriv_' . 'mmtf_' . 'load_category_filter', __NAMESPACE__ . '\\' . 'mmtf_load_category_filter' );
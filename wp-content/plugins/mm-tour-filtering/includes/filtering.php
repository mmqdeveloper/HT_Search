<?php
/**
 * Filtering functions
 * 
 */

namespace MauiMarketing\MMTF\Filtering;

use MauiMarketing\MMTF\Core;
use MauiMarketing\MMTF\Logs;

// https://developer.wordpress.org/reference/classes/wp_query/
// https://developer.wordpress.org/reference/classes/wp_query/parse_query/
// https://developer.wordpress.org/reference/classes/wp_tax_query/__construct/
// https://developer.wordpress.org/reference/classes/wp_meta_query/
// https://developer.wordpress.org/reference/hooks/pre_get_posts/

function get_filtered_products_query( $new_args = [] ){
    $config = Core\config();
    
    $args = [
        "post_type"                 => "product",
        "post_status"               => "publish",
        "mm_custom_filtering"       => "yes",
        "posts_per_page"            => $config["products_per_page"],
        'sentence'                  => true,
        'cache_results'          => false,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'update_menu_item_cache' => false,
        'meta_key'  => 'filtering_priority',
        'orderby'   => 'meta_value_num',
        'order'     => 'ASC',
    ];

    $args = wp_parse_args( $new_args, $args );

    $query = new \WP_Query( $args );
    
    return $query;
}

function mergeCategoriesWithSameName($categories) {
    $mergedCategories = [];
    
    $tempCategories = [];
    
    foreach ($categories as $category) {
        $name = $category['name'];
        $slug = $category['slug'];
        $icon = $category['icon'];
        $priority = $category['priority'];
        $id = $category['id'];
        
        if (array_key_exists($name, $tempCategories)) {
            if ($priority > $tempCategories[$name]['priority']) {
                $tempCategories[$name]['priority'] = $priority;
                $tempCategories[$name]['id'] = $id;
            }
            $tempCategories[$name]['slug'] .= ',' . $slug;
        } else {
            $tempCategories[$name] = array(
                'slug' => $slug,
                'icon' => $icon,
                'priority' => $priority,
                'id' => $id,
            );
        }
    }
    
    foreach ($tempCategories as $name => $values) {
        $mergedCategories[] = array(
            'id' => $values['id'],
            'name' => $name,
            'slug' => $values['slug'],
            'icon' => $values['icon'],
            'priority' => $values['priority'],
        );
    }
    
    return $mergedCategories;
}

function _customize_initial_query( $query ) {

    if ($_POST['mmtf_query_by'] != 'ajax') {
    
        global $wpdb;
        
        // Logs\debug_log( $query, "Filtering-_customize_initial_query-query" );
        
        if( $query->get("mm_custom_filtering") !== "yes" ){
            
            return;
        }
        
        $availability_table = $wpdb->prefix . "daily_product_availability";
        
        
        $current_time = current_time('mysql');
        $current_time = date('Y-m-d H:i',strtotime('now'));
        
        $post__in_query = "
            SELECT      DISTINCT( product_id )
            FROM        $availability_table
            WHERE       `date` >= CAST( DATE_ADD( %s, INTERVAL `min_date` HOUR ) AS DATE )
            AND      `date` >= CAST( %s AS DATE )
        ";
        $post__in_query = $wpdb->prepare( $post__in_query, $current_time, $current_time );
        
        if( ! empty( $_GET["cert"] ) ){
            
            $taxonomy_ids = explode( ",", $_GET["cert"] );
            
            // sanitizing
            foreach( $taxonomy_ids as $index => $taxonomy_id ){
                
                $taxonomy_ids[ $index ] = (int) $taxonomy_id;
            }
            
            $tax_query = $query->get("tax_query" );
            
            if( empty( $tax_query ) ){
                
                $tax_query = [
                    "relation" => "AND",
                ];
                
            }
            
            foreach($taxonomy_ids as $taxonomy_id) {
                $tax_query[] = [
                    "taxonomy"          => "certificates",
                    "field"             => "term_taxonomy_id",
                    "terms"             => $taxonomy_id,
                    'operator' => 'IN',
                ];
            } 
            
            $query->set("tax_query", $tax_query );
            
        }
        
        if( ! empty( $_GET["tag"] ) ){
            
            $taxonomy_ids = explode( ",", $_GET["tag"] );
            
            // sanitizing
            foreach( $taxonomy_ids as $index => $taxonomy_id ){
                
                $taxonomy_ids[ $index ] = (int) $taxonomy_id;
            }
            
            $tax_query = $query->get("tax_query" );
            
            if( empty( $tax_query ) ){
                
                $tax_query = [
                    "relation" => "AND",
                ];
                
            }
            
            $tax_query[] = [
                "taxonomy"          => "product_tag",
                "field"             => "term_taxonomy_id",
                "terms"             => $taxonomy_ids,
            ];
            
            $query->set("tax_query", $tax_query );
            
        }
        
        if( ! empty( $_GET["min"] ) ){
            
            $price = (int) $_GET["min"];
            
            $meta_query = $query->get("meta_query" );
            
            if( empty( $meta_query ) ){
                
                $meta_query = [
                    "relation" => "AND",
                ];
                
            }
            
            $meta_query[] = [
                "key"       => "_wc_display_cost",
                "compare"   => ">=",
                "value"     => $price,
                "type"      => "NUMERIC",
            ];
            
            $query->set("meta_query", $meta_query );
            
        }
        
        if( ! empty( $_GET["max"] ) ){
            
            $price = (int) $_GET["max"];
            
            $meta_query = $query->get("meta_query" );
            
            if( empty( $meta_query ) ){
                
                $meta_query = [
                    "relation" => "AND",
                ];
                
            }
            
            $meta_query[] = [
                "key"       => "_wc_display_cost",
                "compare"   => "<=",
                "value"     => $price,
                "type"      => "NUMERIC",
            ];
            
            $query->set("meta_query", $meta_query );
            
        }
        
        if( ! empty( $_GET["date_start"] ) ){
            
            $post__in_query .= " AND      `date` >= %s";
            
            $post__in_query = $wpdb->prepare( $post__in_query, $_GET["date_start"] );
        }
        
        if( ! empty( $_GET["date_end"] ) ){
            
            $post__in_query .= " AND      `date` <= %s";
            
            $post__in_query = $wpdb->prepare( $post__in_query, $_GET["date_end"] );
        }
        
        if( ! empty( $_GET["group"] ) ){
            
            $group = (int) sanitize_text_field($_GET["group"]);
            
            $meta_query = $query->get("meta_query" );
            
            if( empty( $meta_query ) ){
                
                $meta_query = [
                    "relation" => "AND",
                ];
                
            }
            
            $meta_query[] = [
                "key"       => "_wc_booking_min_persons_group",
                "compare"   => "<=",
                "value"     => $group,
                "type"      => "NUMERIC",
            ];
            
            $meta_query[] = [
                "key"       => "_wc_booking_max_persons_group",
                "compare"   => ">=",
                "value"     => $group,
                "type"      => "NUMERIC",
            ];
            
            $query->set("meta_query", $meta_query );
            
        }
        
        if( ! empty( $_GET["sr"] ) ){
            $is_category = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'name'     =>  $_GET["sr"],
                            'fields'   => 'ids',
                        ));

            if (empty($is_category)) {
                $is_category = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'name'     =>  $_GET["sr"].'s',
                                'fields'   => 'ids',
                            ));
            }

            $is_key_island = false;
            $key_island = ['maui', 'oahu', 'big island', 'kauai'];
            $key_island_slug = ['maui', 'oahu', 'big-island', 'kauai'];
            
            $search_key = sanitize_text_field(strtolower(trim($_GET["sr"])));
            $has_name_island = false;
            $has_from_island = false;

            foreach($key_island as $item) {
                if (strpos($search_key, $item) !== false) {
                    $has_name_island = true;
                }
                if ($search_key == 'from ' . $item) {
                    $has_from_island = true;
                }
            }

            if ((in_array($search_key, $key_island) || $has_name_island === true) && $has_from_island == false) {
                $is_key_island = true;
                $except_key = "from " . $search_key;
                if (empty($_GET["cat"])) {
                    switch(true) {
                        case (strpos($search_key, 'maui') !== false && !strpos($search_key, 'from maui') && !strpos($search_key, 'frommaui')):
                            $_GET["cat"] = 'maui';
                            break;
                        case (strpos($search_key, 'oahu') !== false && !strpos($search_key, 'from oahu') && !strpos($search_key, 'fromoahu')):
                            $_GET["cat"] = 'oahu';
                            break;
                        case (strpos($search_key, 'kauai') !== false && !strpos($search_key, 'from kauai') && !strpos($search_key, 'fromkauai')):
                            $_GET["cat"] = 'kauai';
                            break;
                        case (strpos($search_key, 'big island') !== false && !strpos($search_key, 'from big island') && !strpos($search_key, 'frombig island') && !strpos($search_key, 'frombigisland') && !strpos($search_key, 'from bigisland')):
                            $_GET["cat"] = 'big-island';
                            break;
                        default:
                            break;
                    }
                } else {
                    $param_cat = explode(",", $_GET["cat"]);
                    foreach($param_cat as $key => $val) {
                        if (in_array($val, $key_island_slug)) {
                            unset($param_cat[$key]);
                        }
                    }
                    $param_cat[] = str_replace(' ', '-', $search_key);
                    $param_cat = implode(',', $param_cat);
                    $_GET["cat"] = $param_cat;
                }
            }

            $sql_search = '';
            if ($is_key_island) {
            $sql_search = "SELECT p.ID, p.post_title FROM $wpdb->posts p ";

            if (!empty($is_category)) {
                $sql_search .= "INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id 
                                INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id 
                                INNER JOIN wp_terms t ON tt.term_id = t.term_id ";
            }

            $sql_search .= " WHERE post_type = 'product' 
                        AND post_status = 'publish' 
                        AND (
                            (
                                post_title LIKE '$search_key' 
                                OR post_title LIKE '%". $search_key ."% ' 
                                OR post_title LIKE '%". $search_key ." ' 
                                OR post_title LIKE '". $search_key ."% ' 
                                OR post_title LIKE '% ". $search_key ."s% ' 
                                OR post_title LIKE '% ". $search_key ."s% ' 
                                OR post_title LIKE '%". $search_key ."s ' 
                                OR post_title LIKE '". $search_key ."s% ' 
                            ";

            if (strpos($search_key, 'and')) {
                $sql_search .= "OR post_title LIKE '".str_replace('and', 'or', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('and', 'or', $search_key) ." %' 
                                OR post_title LIKE '%". str_replace('and', 'or', $search_key) ."' 
                                OR post_title LIKE '". str_replace('and', 'or', $search_key) ."%' ";
            }

            if (strpos($search_key, 'or')) {
                $sql_search .= "OR post_title LIKE '".str_replace('or', 'and', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('or', 'and', $search_key) ." %' 
                                OR post_title LIKE '%". str_replace('or', 'and', $search_key) ."' 
                                OR post_title LIKE '". str_replace('or', 'and', $search_key) ."%' ";
            }

                        if (strpos($search_key, '+')) {
                $sql_search .= "OR post_title LIKE '".str_replace('+', 'and', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('+', 'and', $search_key) ." %' 
                                OR post_title LIKE '%". str_replace('+', 'and', $search_key) ."' 
                                OR post_title LIKE '". str_replace('+', 'and', $search_key) ."%' ";
            }

            if (strpos($search_key, '&')) {
                $sql_search .= "OR post_title LIKE '".str_replace('&', 'and', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('&', 'and', $search_key) ." %' 
                                OR post_title LIKE '%". str_replace('&', 'and', $search_key) ."' 
                                OR post_title LIKE '". str_replace('&', 'and', $search_key) ."%' ";
            }

            $sql_search .= ') ';

            if (!empty($is_category)) {
                $sql_search .= " OR (tt.taxonomy = 'product_cat' AND t.term_id IN (". implode(", ", $is_category) ."))";
            }

            $sql_search .= ") AND 
                            (
                                post_title NOT LIKE '". $except_key ."' 
                                OR post_title NOT LIKE '%". $except_key ."%' 
                                OR post_title NOT LIKE '%". $except_key ."' 
                                OR post_title NOT LIKE '". $except_key ."%' 
                            )";
        } else {
            $sql_search = "SELECT p.ID, p.post_title FROM $wpdb->posts p ";

            if (!empty($is_category)) {
                $sql_search .= "INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id 
                                INNER JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id 
                                INNER JOIN wp_terms t ON tt.term_id = t.term_id ";
            }

            $sql_search .= " WHERE post_type = 'product' 
                        AND post_status = 'publish' 
                        AND (
                            (
                                post_title LIKE '$search_key' 
                                OR post_title LIKE '%". $search_key ."%' 
                                OR post_title LIKE '%". $search_key ."' 
                                OR post_title LIKE '". $search_key ."%' 
                                OR post_title LIKE '% ". $search_key ."s% ' 
                                OR post_title LIKE '% ". $search_key ."s% ' 
                                OR post_title LIKE '%". $search_key ."s ' 
                                OR post_title LIKE '". $search_key ."s% ' 
                            ";
            if (strpos($search_key, 'and')) {
                $sql_search .= "OR post_title LIKE '".str_replace('and', 'or', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('and', 'or', $search_key) ."%' 
                                OR post_title LIKE '%". str_replace('and', 'or', $search_key) ."' 
                                OR post_title LIKE '". str_replace('and', 'or', $search_key) ."%' ";
            }

            if (strpos($search_key, 'or')) {
                $sql_search .= "OR post_title LIKE '".str_replace('or', 'and', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('or', 'and', $search_key) ." %' 
                                OR post_title LIKE '%". str_replace('or', 'and', $search_key) ."' 
                                OR post_title LIKE '". str_replace('or', 'and', $search_key) ."%' ";
            }

            if (strpos($search_key, '+')) {
                $sql_search .= "OR post_title LIKE '".str_replace('+', 'and', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('+', 'and', $search_key) ."%' 
                                OR post_title LIKE '%". str_replace('+', 'and', $search_key) ."' 
                                OR post_title LIKE '". str_replace('+', 'and', $search_key) ."%' ";
            }

            if (strpos($search_key, '&')) {
                $sql_search .= "OR post_title LIKE '".str_replace('&', 'and', $search_key)."' 
                                OR post_title LIKE '% ". str_replace('&', 'and', $search_key) ."% ' 
                                OR post_title LIKE '%". str_replace('&', 'and', $search_key) ."' 
                                OR post_title LIKE '". str_replace('&', 'and', $search_key) ."%'";
            }

            $sql_search .= ') ';

            if (!empty($is_category)) {
                $sql_search .= " OR (tt.taxonomy = 'product_cat' AND t.term_id IN (". implode(", ", $is_category) ."))";
            }

            $sql_search .= ")";
        }

            // $search_query = $wpdb->prepare($sql_search);
            $search_query = $wpdb->get_results( $sql_search );

            if ($has_from_island == false) {
                foreach($search_query as $key => $item) {
                    $pos_key = strpos(strtolower($item->post_title), 'from');
                    if ($pos_key) {
                        if (strpos(strtolower($item->post_title), $search_key, $pos_key)) {
                            unset($search_query[$key]);
                        }
                    }
                }
            }

            foreach($search_query as $key => $item) {
                $search_query[$key] = $item->ID;
            }
            $post__in_query = $wpdb->get_col( $post__in_query );
            if (! empty( $post__in_query ) ) {
                if (empty($search_query)) {
                    $post__in_query = [0];
                } else {
                    $post__in_query = array_intersect($post__in_query, $search_query);
                }
            } else {
                $post__in_query = $search_query;
            }
        }

        if( ! empty( $_GET["cat"] ) ){
            $island = [];
            $taxonomy_slugs = explode( ",", $_GET["cat"] );
            if (in_array('maui', $taxonomy_slugs)) {
                $island[] = 32;
                unset($taxonomy_slugs[array_search("maui", $taxonomy_slugs)]);
            }
            if (in_array('oahu', $taxonomy_slugs)) {
                $island[] = 38;
                unset($taxonomy_slugs[array_search("oahu", $taxonomy_slugs)]);
            }
            if (in_array('big-island', $taxonomy_slugs)) {
                $island[] = 36;
                unset($taxonomy_slugs[array_search("big-island", $taxonomy_slugs)]);
            }
            if (in_array('kauai', $taxonomy_slugs)) {
                $island[] = 37;
                unset($taxonomy_slugs[array_search("kauai", $taxonomy_slugs)]);
            }

            if (!empty($island)) {
                if (!is_array($post__in_query)) {
                    $post__in_query = $wpdb->get_col( $post__in_query );
                }
                if (!empty($post__in_query)) {
                    foreach($post__in_query as $key => $item) {
                        // $cat_primary = yoast_get_primary_term_id('product_cat', $item);
                        $cat_primary = get_post_meta( $item, '_yoast_wpseo_primary_product_cat', true );
                        $cat_primary = get_term( $cat_primary );
                        if ($cat_primary) {
                            if (!in_array($cat_primary->term_id, [32, 36, 37, 38])) {
                                if ($cat_primary->parent) {
                                    if (!in_array($cat_primary->parent, $island)) {
                                        unset($post__in_query[$key]);
                                    }
                                } else {
                                    if (!in_array($cat_primary->term_id, $island)) {
                                        unset($post__in_query[$key]);
                                    }
                                }
                            }
                        }   
                    }
                }
            }
                
            $tax_query = $query->get("tax_query" );
            
            if( empty( $tax_query ) ){
                
                $tax_query = [
                    "relation" => "AND",
                ];
                
            }
            
            foreach($taxonomy_slugs as $taxonomy_slug) {
                $tax_query[] = [
                    "taxonomy"          => "product_cat",
                    "field"             => "slug",
                    "terms"             => $taxonomy_slug,
                    'operator' => 'IN',
                ];
            }
            
            $query->set("tax_query", $tax_query );
            
        }

        if (!empty($_GET['dur_min']) && !empty($_GET['dur_max']) && !empty($_GET['dur_opt'])) {
            $duration_min = (int)sanitize_text_field($_GET['dur_min']);
            $duration_max = (int)sanitize_text_field($_GET['dur_max']);
            $duration_option = sanitize_text_field($_GET['dur_opt']);

            $meta_query = $query->get("meta_query" );
            
            if( empty( $meta_query ) ){
                
                $meta_query = [
                    "relation" => "AND",
                ];
                
            }

            $meta_query[] = [
                'key' => '_mm_duration',
                'value' => array($duration_min, $duration_max),
                'compare' => 'BETWEEN',
                'type'    => 'NUMERIC',
            ];

            $meta_query[] = [
                'key' => '_mm_duration_unit',
                'value' => $duration_option,
                'compare' => '='
            ];

            $query->set("meta_query", $meta_query );
        }

        if (!empty($_GET['pk'])) {
            $pickup = sanitize_text_field($_GET['pk']);

            $meta_query = $query->get("meta_query" );
            
            if( empty( $meta_query ) ){
                
                $meta_query = [
                    "relation" => "AND",
                ];
                
            }

            $meta_query[] = [
                'key' => '_mm_pickup',
                'value' => $pickup,
                'compare' => '='
            ];

            $query->set("meta_query", $meta_query );
        }
        
        // if( ! empty( $post__in_query ) ){
            // Logs\debug_log( $post__in_query, "Filtering-_customize_initial_query-post__in_query" );
            if( ! empty( $post__in_query ) ){ 
                if (is_array($post__in_query)) {
                    $include_only_products = $post__in_query;
                } else {
                    $include_only_products = $wpdb->get_col( $post__in_query );
                }
            } else {
                $include_only_products = array(0);
            }
            
            // Logs\debug_log( $include_only_products, "Filtering-_customize_initial_query-include_only_products" );
            // Logs\debug_log( count( $include_only_products ), "Filtering-_customize_initial_query-include_only_products-count" );
            
            if( ! empty( $include_only_products ) ){
                $query->set("post__in", $include_only_products );
            }
            
        // } else if () {

        // }
        
        // Logs\debug_log( $query, "Filtering-_customize_initial_query-query" );
        // Logs\debug_log( $query->request, "Filtering-_customize_initial_query-query-request" );
    }
}
// add_action( 'pre_get_posts', __NAMESPACE__ . '\\' . '_customize_initial_query' );

function count_active_filters(){
    
    $active_filters = 0;
    
    if( ! empty( $_GET["sr"] ) ){
        $active_filters++;
    }
    
    if( ! empty( $_GET["min"] ) || ! empty( $_GET["max"] ) ){
        $active_filters++;
    }
    
    if( ! empty( $_GET["date_start"] ) || ! empty( $_GET["date_end"] ) ){
        $active_filters++;
    }
    
    if( ! empty( $_GET["group"] ) && $_GET["group"] != 2 ){
        $active_filters++;
    }
    
    if( ! empty( $_GET["cat"] ) ){
        $active_filters++;
    }
    
    if( ! empty( $_GET["cert"] ) ){
        $active_filters++;
    }
    
    if( ! empty( $_GET["tag"] ) ){
        $active_filters++;
    }
    
    return $active_filters;
}

function check_sql( $sql, $query ){
    
    // Logs\debug_log( $query->request, "Filtering-check_sql-query-request: " . $query->get("mm_custom_filtering") );
    // Logs\debug_log( $query, "Filtering-check_sql-query: " . $query->get("mm_custom_filtering") );
    
    if ( $query->get("mm_custom_filtering") == 'yes' ){
        
        // Logs\debug_log( $query->request, "Filtering-check_sql-query-request: " . $query->get("mm_custom_filtering") );
    }
    
    return $sql;
}
// add_filter( 'posts_request', __NAMESPACE__ . '\\' . 'check_sql', 999, 2 );

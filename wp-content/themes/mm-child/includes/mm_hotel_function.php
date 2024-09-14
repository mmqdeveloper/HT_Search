<?php

if (!function_exists('mm_search_hotel_with_keyword')) {
    function mm_search_hotel_with_keyword ($keyword) {
        global $wpdb;
        $query = $wpdb->prepare("
            SELECT ID
            FROM {$wpdb->posts} AS p
            LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
            LEFT JOIN {$wpdb->term_relationships} AS tr ON p.ID = tr.object_id
            LEFT JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            LEFT JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
            WHERE p.post_type = 'hotel'
            AND p.post_status = 'publish'
            AND (
                LOWER(p.post_title) LIKE '%%%s%%'
                OR LOWER(p.post_name) LIKE '%%%s%%'
                OR (pm.meta_key = 'mm-address' AND LOWER(pm.meta_value) LIKE '%%%s%%')
                OR (tt.taxonomy = 'hotel_categories' AND LOWER(t.name) LIKE '%%%s%%')
                OR (tt.taxonomy = 'hotel_island' AND LOWER(t.name) LIKE '%%%s%%')
                OR (tt.taxonomy = 'hotel_tags' AND LOWER(t.name) LIKE '%%%s%%')
            )
        ", $keyword, $keyword, $keyword, $keyword, $keyword, $keyword);

        return array_values(array_unique($wpdb->get_col($query)));
    }
}

if (!function_exists('mm_hotel_get_search_absolute_results')) {
    function mm_hotel_get_search_absolute_results ($array_in) {

        $tempArray = array();

        function checkItemInAllArrays($item, $array_in) {
            foreach ($array_in as $array) {
                if (!in_array($item, $array)) {
                    return false;
                }
            }
            return true;
        }

        foreach ($array_in as $array) {
            foreach ($array as $item) {
                if (!in_array($item, $tempArray) && checkItemInAllArrays($item, $array_in)) {
                    $tempArray[] = $item;
                }
            }
        }

        return $tempArray;
    }
}

add_action('wp_ajax_mm_ajax_filter_hotel', 'mm_ajax_filter_hotel');
add_action('wp_ajax_nopriv_mm_ajax_filter_hotel', 'mm_ajax_filter_hotel');
if (!function_exists('mm_ajax_filter_hotel')) {

    function mm_ajax_filter_hotel() {
        global $wpdb;

        $search = strtolower($_POST['search']);

        $island = $_POST['island'];
        $items = $_POST['items'] ? $_POST['items'] : -1;
        $categories = $_POST['categories'];
        $tags = $_POST['tags'];
        $tax_query = array();
        ob_start();
        if ($island != '-1' && !empty($island)) {
            $tax_query[] = array(
                'taxonomy' => 'hotel_island',
                'field' => 'term_id',
                'terms' => absint($island),
            );
        }
        if ($categories != '-1' && !empty($categories)) {
            $tax_query[] = array(
                'taxonomy' => 'hotel_categories',
                'field' => 'term_id',
                'terms' => absint($categories),
            );
        }
        if ($tags != '-1' && !empty($tags)) {
            $tax_query[] = array(
                'taxonomy' => 'hotel_tags',
                'field' => 'term_id',
                'terms' => absint($tags),
            );
        }
        if (!empty($search)) {
            $post_ids = array();

            if (strpos($search, ' ') !== false) {
                $key_separation = explode(" ", $search);
                $result_list = array();
                foreach($key_separation as $key) {
                    $result_list[] = mm_search_hotel_with_keyword($key);
                }
                $post_ids = mm_hotel_get_search_absolute_results($result_list);
            } else {
                $post_ids = mm_search_hotel_with_keyword($search);
            }

            if (empty($post_ids)) {
                $post_ids[] = 0;
            }

            query_posts(
                array(
                    'post_type' => 'hotel',
                    'tax_query' => $tax_query,
                    // 's' => $search,
                    'post_status' => 'publish',
                    'posts_per_page' => $items,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post__in' => $post_ids
                )
            );
        } else {
            query_posts(
                array(
                    'post_type' => 'hotel',
                    'tax_query' => $tax_query,
                    'post_status' => 'publish',
                    'posts_per_page' => $items,
                    'orderby' => 'post_date',
                    'order' => 'DESC'
                )
            );
        }
        if (have_posts()) {
            get_template_part('includes/loop', 'hotel');
        } else {
            echo __('<p style="padding:150px 0;text-align:center;font-size:18px;">No hotels found</p>');
        }

        $output_pagination = hotel_pagination( '', 'nav' );

        wp_reset_postdata();

        $output = ob_get_clean();

        $result = array(
            'output' => $output,
            'output_pagination' => $output_pagination
        );

        echo json_encode($result);
        die();
    }

}

add_action('wp_ajax_mm_ajax_pagination_hotel', 'mm_ajax_pagination_hotel');
add_action('wp_ajax_nopriv_mm_ajax_pagination_hotel', 'mm_ajax_pagination_hotel');
if (!function_exists('mm_ajax_pagination_hotel')) {

    function mm_ajax_pagination_hotel() {
        global $wpdb;

        $search = strtolower($_POST['search']);
        $paged = $_POST['paged'];
        $island = $_POST['island'];
        $categories = $_POST['categories'];
        $tags = $_POST['tags'];
        $tax_query = array();
        ob_start();
        if ($island != '-1' && !empty($island)) {
            $tax_query[] = array(
                'taxonomy' => 'hotel_island',
                'field' => 'term_id',
                'terms' => absint($island),
            );
        }

        if ($categories != '-1' && !empty($categories)) {
            $tax_query[] = array(
                'taxonomy' => 'hotel_categories',
                'field' => 'term_id',
                'terms' => absint($categories),
            );
        }

        if ($tags != '-1' && !empty($tags)) {
            $tax_query[] = array(
                'taxonomy' => 'hotel_tags',
                'field' => 'term_id',
                'terms' => absint($tags),
            );
        }

        if (!empty($search)) {
            $post_ids = array();

            if (strpos($search, ' ') !== false) {
                $key_separation = explode(" ", $search);
                $result_list = array();
                foreach($key_separation as $key) {
                    $result_list[] = mm_search_hotel_with_keyword($key);
                }
                $post_ids = mm_hotel_get_search_absolute_results($result_list);
            } else {
                $post_ids = mm_search_hotel_with_keyword($search);
            }

            if (empty($post_ids)) {
                $post_ids[] = 0;
            }

            query_posts(
                array(
                    'post_type' => 'hotel',
                    'tax_query' => $tax_query,
                    // 's' => $search,
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'paged' => $paged,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post__in' => $post_ids
                )
            );
        } else {
            query_posts(
                array(
                    'post_type' => 'hotel',
                    'tax_query' => $tax_query,
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'paged' => $paged,
                    'orderby' => 'post_date',
                    'order' => 'DESC'
                )
            );
        }
        
        if (have_posts()) {
            get_template_part('includes/loop', 'hotel');
        } else {
            echo __('<p style="padding:150px 0;text-align:center;font-size:18px;">No hotels found</p>');
        }

        $output_pagination = hotel_pagination( '', 'nav' );

        wp_reset_postdata();

        $output = ob_get_clean();

        $result = array(
            'output' => $output,
            'output_pagination' => $output_pagination
        );

        echo json_encode($result);
        die();
    }

}

if (!function_exists('hotel_pagination')) {

    function hotel_pagination($pages = '', $wrapper = 'div', $query_arg = '', $current_page = 1) {
        global $paged, $wp_query;

        if (is_object($pages)) {
            $use_query = $pages;
            $pages = '';
        } else {
            $use_query = $wp_query;
        }

        if (!empty($query_arg)) {
            $paged = is_numeric($current_page) ? (int) $current_page : 1;
        } else if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $output = '';
        $prev = $paged - 1;
        $next = $paged + 1;
        $range = 2; // only edit this if you want to show more page-links
        $showitems = ( $range * 2 ) + 1;


        if ($pages == '') { //if the default pages are used
            //$pages = ceil(wp_count_posts($post_type)->publish / $per_page);
            $pages = $use_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }

            //factor in pagination
            if (isset($use_query->query) && !empty($use_query->query['offset']) && $pages > 1) {
                $offset_origin = $use_query->query['offset'] - ( $use_query->query['posts_per_page'] * ( $paged - 1 ) );
                $real_posts = $use_query->found_posts - $offset_origin;
                $pages = ceil($real_posts / $use_query->query['posts_per_page']);
            }
        }

        $method = is_single() ? 'avia_post_pagination_link' : 'get_pagenum_link';

        /**
         * Allows to change pagination method
         * 
         * @used_by				avia_sc_blog			10
         * 
         * @since 4.5.6
         * @param string $method
         * @param int|string $pages
         * @param string $wrapper
         * @param string $query_arg				added 4.7.6.4
         * @return string
         */
        $method = apply_filters('avf_pagination_link_method', $method, $pages, $wrapper, $query_arg);

        if (1 != $pages) {
            $output .= "<{$wrapper} class='pagination mm-pagination-hotel' data-island='all'>";
            $output .= "<span class='pagination-meta'>" . sprintf(__("Page %d of %d", 'avia_framework'), $paged, $pages) . "</span>";
            $output .= ( $paged > 1 && $showitems < $pages ) ? "<a class='pagination-prev-btn rsaquo-icon' data-paged='". $prev ."' ></a>" : '';

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems )) {
                    switch ($i) {
                        case ( $paged == $i ):
                            $class = 'current';
                            break;
                        case ( ( $paged - 1 ) == $i ):
                            $class = 'inactive previous_page';
                            break;
                        case ( ( $paged + 1 ) == $i ):
                            $class = 'inactive next_page';
                            break;
                        default:
                            $class = 'inactive';
                            break;
                    }

                    $output .= ( $paged == $i ) ? "<span class='{$class}'>{$i}</span>" : "<a data-paged='". $i ."' class='{$class}' >{$i}</a>";
                }
            }

            $output .= ( $paged < $pages && $showitems < $pages ) ? "<a class='pagination-next-btn rsaquo-icon' data-paged='". $next ."'></a>" : '';
            // $output .= ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) ? "<a href='" . avia_extended_pagination_link($method, $pages, $query_arg) . "#list_restaurants'>{$pages}</a>" : '';
            $output .= "</{$wrapper}>\n";
        }

        return apply_filters('avf_pagination_output', $output, $paged, $pages, $wrapper, $query_arg);
    }

}
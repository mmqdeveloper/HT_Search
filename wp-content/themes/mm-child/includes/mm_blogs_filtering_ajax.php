<?php

if (!function_exists('mm_blogs_custom_pagination')) {
    function mm_blogs_custom_pagination($total_posts, $posts_per_page, $current_page) {
        if ($total_posts == $posts_per_page) {
            return '';
        }

        $total_pages = ceil($total_posts / $posts_per_page);

        $output = '';        

        $output .= '<div class="mm-blogs-pagination-links">';

        if ($current_page > 1) {
            $output .= '<span data-number="'.$posts_per_page.'" data-paged="' . ($current_page - 1) . '" class="mm-blogs-pagination-num mm-blogs-pagination-prev">«</span>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            $class = ($current_page == $i) ? 'mm-blogs-pagination-current' : '';
            $output .= '<span data-number="'.$posts_per_page.'" data-paged="' . $i . '" class="mm-blogs-pagination-num ' . $class . '">' . $i . '</span>';
        }

        if ($current_page < $total_pages) {
            $output .= '<span data-number="'.$posts_per_page.'" data-paged="' . ($current_page + 1) . '" class="mm-blogs-pagination-num mm-blogs-pagination-next">»</span>';
        }

        $output .= '</div>';

        return $output;

    }
}

if (!function_exists('mm_search_blogs_with_keyword')) {
    function mm_search_blogs_with_keyword ($keyword) {
        global $wpdb;
        $query = $wpdb->prepare("
            SELECT ID
            FROM {$wpdb->posts} AS p
            LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
            LEFT JOIN {$wpdb->term_relationships} AS tr ON p.ID = tr.object_id
            LEFT JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            LEFT JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
            WHERE p.post_type = 'post'
            AND p.post_status = 'publish'
            AND (
                LOWER(p.post_title) LIKE '%%%s%%'
                OR LOWER(p.post_name) LIKE '%%%s%%'
                OR (tt.taxonomy = 'post_tag' AND LOWER(t.name) LIKE '%%%s%%')
            )
        ", $keyword, $keyword, $keyword);

        return array_values(array_unique($wpdb->get_col($query)));
    }
}

if (!function_exists('mm_blogs_get_search_absolute_results')) {
    function mm_blogs_get_search_absolute_results ($array_in) {

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


add_action('wp_ajax_mm_ajax_filter_blogs', 'mm_ajax_filter_blogs');
add_action('wp_ajax_nopriv_mm_ajax_filter_blogs', 'mm_ajax_filter_blogs');
if (!function_exists('mm_ajax_filter_blogs')) {

    function mm_ajax_filter_blogs() {
        global $wpdb;

        $search = strtolower($_POST['search']);
        $island = $_POST['island'];
        $category = $_POST['category'];
        $paged = $_POST['paged'] ? $_POST['paged'] : 1;
        $number = $_POST['number'] ? $_POST['number'] : 6;
        $tax_query = array();
        ob_start();
        if ($island != '-1' && !empty($island)) {
            $tax_query[] = array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => absint($island),
            );
        }
        if ($category != '-1' && !empty($category)) {
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => absint($category),
            );
        }
        if (!empty($search)) {
            $post_ids = array();

            if (strpos($search, ' ') !== false) {
                $key_separation = explode(" ", $search);
                $result_list = array();
                foreach($key_separation as $key) {
                    $result_list[] = mm_search_blogs_with_keyword($key);
                }
                $post_ids = mm_blogs_get_search_absolute_results($result_list);
            } else {
                $post_ids = mm_search_blogs_with_keyword($search);
            }

            if (empty($post_ids)) {
                $post_ids[] = 0;
            }

            $custom_query = new WP_Query(array(
                'post_type' => 'post',
                'tax_query' => $tax_query,
                'post_status' => 'publish',
                'posts_per_page' => $number,
                'paged' => $paged,
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post__in' => $post_ids
            ));
        } else {
            $custom_query = new WP_Query(array(
                'post_type' => 'post',
                'tax_query' => $tax_query,
                'post_status' => 'publish',
                'posts_per_page' => $number,
                'paged' => $paged,
                'orderby' => 'post_date',
                'order' => 'DESC'
            ));
        }

        $total_posts = $custom_query->found_posts;

        if ($custom_query->have_posts()) {
            while ($custom_query->have_posts()) : $custom_query->the_post();
                ?>
                    <div class="blogs-page-filtering-list-item">
                        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" alt="<?php the_title(); ?>"></a>
                        <div class="blogs-page-filtering-list-item-content">
                            <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                            <a href="<?php the_permalink(); ?>"><p><?php echo get_the_excerpt(); ?></p></a>
                            <a class="btn-blogs-view-detail" href="<?php the_permalink(); ?>">View details &rarr;</a>
                        </div>
                    </div>
                <?php
            endwhile;
        } else {
            echo __('<p style="width:100%;padding:150px 0;text-align:center;font-size:18px;">No posts found</p>');
        }

        wp_reset_postdata();

        $output = ob_get_clean();

        $output_pagination = mm_blogs_custom_pagination($total_posts, $number, $paged);

        $result = json_encode(array(
            'blogs' => $output,
            'pagination' => $output_pagination
        ));

        echo $result;
        die();
    }

}
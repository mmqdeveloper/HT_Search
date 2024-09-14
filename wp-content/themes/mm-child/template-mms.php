<?php
/*
    Template Name: MMS Search Page
*/

global $avia_config;
get_header();

?>

<section class="section_search">
    <div class="container">
        <div class="mms_row_search">
                <?php echo do_shortcode( '[mms_product_search]' ); ?>
        </div>
        <div class="mms-search-content">
            <div id="mms_search_header">
                <div id="mms_search_cate_silde">
                    <?php
                        global $wpdb;
                        $image_path_url = get_stylesheet_directory_uri() . '/module/search/images/';
                        $image_path_file = get_stylesheet_directory() . '/module/search/images/';

                        $query = "
                            SELECT DISTINCT product_categories
                            FROM wp_product_search_view
                            WHERE product_categories IS NOT NULL;
                        ";

                        $search_query = isset($_GET['mms_search']) ? sanitize_text_field($_GET['mms_search']) : '';
                        $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

                        $results = $wpdb->get_results($query, ARRAY_A);
                        $displayed_categories = array();

                        if ( ! empty($results) ) {
                            foreach ($results as $row) {
                                $categories = explode(', ', $row['product_categories']);
                                
                                foreach ($categories as $category) {
                                    $formatted_category = strtolower(str_replace(' ', '-', trim($category)));
                                    if ( !in_array($formatted_category, $displayed_categories) ) {
                                        $displayed_categories[] = $formatted_category;
                                        $image_file = $image_path_file . $formatted_category . '.svg';
                                        $image_url = $image_path_url . $formatted_category . '.svg';
                                        if (file_exists($image_file)) {
                                            echo '<div class="category" data-category="' . esc_attr($category) . '">';
                                            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category) . '">';
                                            echo '<h3>' . esc_html($category) . '</h3>';
                                            echo '</div>';
                                        } else {
                                            echo '<div class="category" data-category="' . esc_attr($category) . '">';
                                            echo '<img src="' . esc_url($image_path_url . 'default.svg') . '" alt="' . esc_attr($formatted_category) . '">';
                                            echo '<h3>' . esc_html($category) . '</h3>';
                                            echo '</div>';
                                        }
                                    }
                                } 
                            }
                        }
                    ?>
                </div>
                <div class="mms_search_filter_btn">
                </div>
            </div>

            <div id="mms_search_results" style="display: flex; flex-wrap: wrap;">
                <?php
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $search_query = isset($_GET['mms_search']) ? sanitize_text_field($_GET['mms_search']) : '';
                    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
                    // echo 'Reload: ' . $search_query . ' | Category: ' . $category;
                    $limit = 8;
                    $offset = ($page - 1) * $limit;
                    $query = "SELECT * FROM wp_product_search_view WHERE 1=1";
                    if(!empty($search_query) && !empty($category)){
                        $like_query = '%' . $wpdb->esc_like($search_query) . '%';
                        $like_category = '%' . $wpdb->esc_like($category) . '%'; 
                        $query = $wpdb->prepare(
                            "SELECT * FROM wp_product_search_view 
                             WHERE product_categories LIKE %s 
                             AND product_title LIKE %s",
                            $like_category,
                            $like_query
                        );
                    } elseif ($search_query) {
                        $like_query = '%' . $wpdb->esc_like($search_query) . '%';
                        $like_category = '%' . $wpdb->esc_like($category) . '%'; 
                        $query = $wpdb->prepare(
                            "SELECT * FROM wp_product_search_view 
                             WHERE product_categories LIKE %s 
                             OR product_title LIKE %s",
                            $like_category,
                            $like_query
                        );
                    } elseif ($category) {
                        $query .= $wpdb->prepare(" AND product_categories LIKE %s", '%' . $wpdb->esc_like($category) . '%');
                    }
                    $query .= $wpdb->prepare(" LIMIT %d OFFSET %d", $limit, $offset);

                    $results = $wpdb->get_results($query);
                    if ($results) {
                        foreach ($results as $product) {
                            ?>
                            <div class="product-result" style="width: 25%;">
                                <a href="<?php echo esc_url($product->product_url); ?>">
                                    <img src="<?php echo esc_url($product->product_image); ?>" alt="<?php echo esc_html($product->product_title); ?>">
                                    <h3><?php echo esc_html($product->product_title); ?></h3>
                                    <p>Pickup: <?php echo esc_html($product->product_pickup); ?></p>
                                    <p>Duration: <?php echo esc_html($product->product_duration . ' ' . $product->product_duration_unit); ?></p>
                                    <p>Price: <?php echo esc_html($product->product_price); ?></p>
                                    <p class="product-cat-primary"><?php echo esc_html($product->product_categories_pimary); ?></p>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No more products to show.</p>';
                    }
                ?>
            </div>
            <div id="mms_load_more" data-page="<?php echo $page; ?>">Show more</div>
        </div>

    </div>
    <div id="mms_search_loading" style="display: none;">
        <img src="/wp-content/themes/mm-child/module/search/images/default.svg" alt="Loading...">
    </div>
</section>

<?php get_footer(); ?>

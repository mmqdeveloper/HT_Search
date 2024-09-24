<?php

if (!function_exists('mms_product_search_form')) {
    function mms_product_search_form()
    {
        $search_history = isset($_COOKIE['mms_search_history']) ? json_decode(stripslashes($_COOKIE['mms_search_history']), true) : [];
        $search_query = isset($_GET['mms_search']) ? sanitize_text_field($_GET['mms_search']) : '';
        if (!is_array($search_history)) {
            $search_history = [];
        }
        ob_start();
        ?>
        <div class="mms_row_search">
            <div class="search_keyword">
                <section class="mms-search-form">
                    <form id="mms_product_search" action="/s/" method="GET">
                        <input type="text" id="mms_search" name="mms_search" placeholder="Search" autocomplete="off" value="<?php echo isset($search_query) ? esc_attr($search_query) : ''; ?>" />
                        <button type="submit">Search</button>
                    </form>

                    <?php if (!empty($search_history)) : ?>
                        <div id="mms_history" style="display: none;">
                            <div class="header-search history">
                                <h4>Recent Searches:</h4>
                                <?php if (!empty($search_history)) : ?>
                                    <button type="button" id="mms_clear_history">Clear History</button>
                                <?php endif; ?>
                            </div>
                            <ul>
                                <?php foreach ($search_history as $history) : ?>
                                    <li class="mms-item-history" data-history="<?php echo esc_html($history) ?>"> 
                                        <?php echo esc_html($history); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div id="mms_search_suggestions"></div>
                </section>
            </div>
            <div class="search_dates">
                <div class="search_dates_content">
                    <b id="mms_search_datepicker_result">Add dates</b>
                    <div id="mms_datepicker_widget" style="display: none;"></div>
                    <input type="text" id="mms_search_datepicker_date_from" name="mms_search_datepicker_date_from" placeholder="Date From">
                    <input type="text" id="mms_search_datepicker_date_to" name="mms_search_datepicker_date_to" placeholder="Date To">
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    add_shortcode('mms_product_search', 'mms_product_search_form');
}
if (!function_exists('mms_ajax_s')) {
    function mms_ajax_s()
    {
        global $wpdb;

        $image_path_url = get_stylesheet_directory_uri() . '/module/search/images/';
        $image_path_file = get_stylesheet_directory() . '/module/search/images/';

        $search_query = isset($_GET['mms_search']) ? sanitize_text_field($_GET['mms_search']) : '';
        $search_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $limit = 8;
        $offset = ($paged - 1) * $limit;
        
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view WHERE 1=1";
        if (!empty($search_query) && !empty($search_category)) {
            $like_query = '%' . $wpdb->esc_like($search_query) . '%';
            $like_category = '%' . $wpdb->esc_like($search_category) . '%';

            $query = $wpdb->prepare(
                "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view 
                WHERE product_categories LIKE %s 
                AND product_title LIKE %s 
                LIMIT %d OFFSET %d",
                $like_category,
                $like_query,
                $limit,
                $offset
            );
        } elseif ($search_query) {
            $like_query = '%' . $wpdb->esc_like($search_query) . '%';
            $like_category = '%' . $wpdb->esc_like($search_category) . '%';
            $query = $wpdb->prepare(
                "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view 
                    WHERE product_categories LIKE %s 
                    OR product_title LIKE %s
                    LIMIT %d OFFSET %d",
                $like_category,
                $like_query,
                $limit,
                $offset
            );
        } elseif ($search_category) {
            $like_category = '%' . $wpdb->esc_like($search_category) . '%'; 
            $query = $wpdb->prepare(
                "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view 
                    WHERE product_categories LIKE %s",
                $like_category,
                $limit,
                $offset
            );
        }

        $results = $wpdb->get_results($query);

        $total_query = "SELECT FOUND_ROWS()";
        $total_results = $wpdb->get_var($total_query);

        $response = [
            'products' => '',
            'categories' => '',
            'total_results' => $total_results,
            'hide_button' => count($results) < $limit,
        ];


        $categories = [];
        $products_html = '';
        if ($results) {

            foreach ($results as $product) {
                ob_start();
                include( get_stylesheet_directory() . '/module/search/templates/mms-product.php' );
                $products_html .= ob_get_clean();
                if(!empty($product->product_categories)){
                    $categories_list = explode(',', $product->product_categories);
                    foreach ($categories_list as $category) {
                        $category = trim(esc_html($category));
                        $formatted_category = strtolower(str_replace(' ', '-', trim($category)));
                        if (!in_array($formatted_category, $categories)) {
                            $categories[] = $formatted_category;
                            $image_file = $image_path_file . $formatted_category . '.svg';
                            $image_url = $image_path_url . $formatted_category . '.svg';
                            if (file_exists($image_file)) {
                                $response['categories'] .= '<div class="category" data-category="' . esc_attr($category) . '">';
                                $response['categories'] .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category) . '">';
                                $response['categories'] .= '<h3>' . esc_html($category) . '</h3>';
                                $response['categories'] .= '</div>';
                            } else {
                                $response['categories'] .= '<div class="category" data-category="' . esc_attr($category) . '">';
                                $response['categories'] .= '<img src="' . esc_url($image_path_url . 'default.svg') . '" alt="' . esc_attr($category) . '">';
                                $response['categories'] .= '<h3>' . esc_html($category) . '</h3>';
                                $response['categories'] .= '</div>';
                            }
                        }
                    }
                }
            }
            $response['products'] = $products_html;
        } else {
            $response['products'] = "<p class='product_notf'>Sorry, we couldn't find any experiences or activities</p>";
        }
        wp_send_json($response);
    }
    add_action('wp_ajax_mms_ajax_s', 'mms_ajax_s');
    add_action('wp_ajax_nopriv_mms_ajax_s', 'mms_ajax_s');
}
if (!function_exists('mms_ajax_s_suggestions')) {
    function mms_ajax_s_suggestions()
    {
        global $wpdb;
        $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
        if (strlen($query) >= 1) {
            $like_query = '%' . $wpdb->esc_like($query) . '%';
            $exact_query = $wpdb->esc_like($query);
        
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT DISTINCT product_id, product_title, product_categories
                    FROM wp_product_search_view
                    WHERE 
                        (product_title LIKE %s)
                        OR
                        (product_categories = %s)
                        LIMIT 5",
                    $like_query,
                    $exact_query
                )
            );
        } else {
            wp_die();
        }
        if ($results) {
            $valid_categories = ['Maui', 'Oahu', 'Big Island', 'Kauai'];
            $all_categories = [];
            $all_titles = [];
            foreach ($results as $row) {
                $categories = array_map('trim', explode(',', $row->product_categories));
                $filtered_categories = array_filter($categories, function($category) use ($query, $valid_categories) {
                    return stripos($category, $query) !== false && in_array($category, $valid_categories);
                });
                $all_categories = array_merge($all_categories, $filtered_categories);
            }
            $all_categories = array_unique($all_categories);
            $remaining_slots = 5;
            if (!empty($all_categories)) {
                $all_categories = array_slice($all_categories, 0, $remaining_slots);
                $remaining_slots -= count($all_categories);
                foreach ($all_categories as $category) {
                    if (!empty($category)) {
                        echo '<div class="cate s_suggestions" data-suggestions="' . esc_attr($category) . '">' . esc_html($category) . '</div>';
                    }
                }
            }
            if ($remaining_slots > 0) {
                foreach ($results as $row) {
                    if (stripos($row->product_title, $query) !== false) {
                        $all_titles[] = $row->product_title;
                    }
                    if (count($all_titles) >= $remaining_slots) {
                        break;
                    }
                }
                if (!empty($all_titles)) {
                    foreach ($all_titles as $title) {
                        if (!empty($title)) {
                            echo '<div class="title s_suggestions" data-suggestions="' . esc_attr($title) . '">' . esc_html($title) . '</div>';
                        }
                    }
                }
            }
        }
        wp_die();
    }

    add_action('wp_ajax_mms_ajax_s_suggestions', 'mms_ajax_s_suggestions');
    add_action('wp_ajax_nopriv_mms_ajax_s_suggestions', 'mms_ajax_s_suggestions');
}
if (!function_exists('mms_save_search_history')) {
    function mms_save_search_history()
    {
        if (isset($_GET['mms_search']) && !empty($_GET['mms_search'])) {
            $search_query = sanitize_text_field($_GET['mms_search']);
            $search_history = isset($_COOKIE['mms_search_history']) ? json_decode(stripslashes($_COOKIE['mms_search_history']), true) : [];

            if (!is_array($search_history)) {
                $search_history = [];
            }

            if (!in_array($search_query, $search_history)) {
                $search_history[] = $search_query;
                setcookie('mms_search_history', json_encode($search_history), time() + (86400 * 30), "/");
            }
        }
    }
    add_action('init', 'mms_save_search_history');
}
if (!function_exists('mms_clear_search_history')) {
    function mms_clear_search_history()
    {
        setcookie('mms_search_history', '', time() - 3600, "/");
        $_COOKIE['mms_search_history'] = [];

        wp_die();
    }
    add_action('wp_ajax_mms_clear_search_history', 'mms_clear_search_history');
    add_action('wp_ajax_nopriv_mms_clear_search_history', 'mms_clear_search_history');
}
if (!function_exists('mms_ajax_search_by_suggestion')) {
    function mms_ajax_search_by_suggestion()
    {
        global $wpdb;

        $image_path_url = get_stylesheet_directory_uri() . '/module/search/images/';
        $image_path_file = get_stylesheet_directory() . '/module/search/images/';

        $search_query = isset($_GET['mms_search']) ? sanitize_text_field($_GET['mms_search']) : '';
        $search_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $limit = 8;
        $offset = ($paged - 1) * $limit;

        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view WHERE 1=1";
        if (!empty($search_query) && !empty($search_category)) {
            $like_query = '%' . $wpdb->esc_like($search_query) . '%';
            $like_category = '%' . $wpdb->esc_like($search_category) . '%';

            $query = $wpdb->prepare(
                "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view 
                WHERE product_categories LIKE %s 
                AND product_title LIKE %s 
                LIMIT %d OFFSET %d",
                $like_category,
                $like_query,
                $limit,
                $offset
            );
        } elseif ($search_query) {
            $like_query = '%' . $wpdb->esc_like($search_query) . '%';
            $like_category = '%' . $wpdb->esc_like($search_category) . '%';
            $query = $wpdb->prepare(
                "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view 
                    WHERE product_categories LIKE %s 
                    OR product_title LIKE %s
                    LIMIT %d OFFSET %d",
                $like_category,
                $like_query,
                $limit,
                $offset
            );
        } elseif ($search_category) {
            $like_category = '%' . $wpdb->esc_like($search_category) . '%'; 
            $query = $wpdb->prepare(
                "SELECT SQL_CALC_FOUND_ROWS * FROM wp_product_search_view 
                    WHERE product_categories LIKE %s",
                $like_category,
                $limit,
                $offset
            );
        }

        $results = $wpdb->get_results($query);

        $total_query = "SELECT FOUND_ROWS()";
        $total_results = $wpdb->get_var($total_query);

        $response = [
            'products' => '',
            'categories' => '',
            'total_results' => $total_results,
            'hide_button' => count($results) < $limit,
        ];

        $categories = [];
        $products_html = '';
        if ($results) {

            foreach ($results as $product) {
                ob_start();
                include( get_stylesheet_directory() . '/module/search/templates/mms-product.php' );
                $products_html .= ob_get_clean();
                if(!empty($product->product_categories)){
                    $categories_list = explode(',', $product->product_categories);
                    foreach ($categories_list as $category) {
                        $category = trim(esc_html($category));
                        $formatted_category = strtolower(str_replace(' ', '-', trim($category)));
                        if (!in_array($formatted_category, $categories)) {
                            $categories[] = $formatted_category;
                            $image_file = $image_path_file . $formatted_category . '.svg';
                            $image_url = $image_path_url . $formatted_category . '.svg';
                            if (file_exists($image_file)) {
                                $response['categories'] .= '<div class="category" data-category="' . esc_attr($category) . '">';
                                $response['categories'] .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category) . '">';
                                $response['categories'] .= '<h3>' . esc_html($category) . '</h3>';
                                $response['categories'] .= '</div>';
                            } else {
                                $response['categories'] .= '<div class="category" data-category="' . esc_attr($category) . '">';
                                $response['categories'] .= '<img src="' . esc_url($image_path_url . 'default.svg') . '" alt="' . esc_attr($category) . '">';
                                $response['categories'] .= '<h3>' . esc_html($category) . '</h3>';
                                $response['categories'] .= '</div>';
                            }
                        }
                    }
                }
            }
            $response['products'] = $products_html;
        } else {
            $response['products'] = "<p class='product_notf'>Sorry, we couldn't find any experiences or activities</p>";
        }
        wp_send_json($response);
    }
    add_action('wp_ajax_mms_ajax_search_by_suggestion', 'mms_ajax_search_by_suggestion');
    add_action('wp_ajax_nopriv_mms_ajax_search_by_suggestion', 'mms_ajax_search_by_suggestion');
}
if (!function_exists('mms_ajax_search_by_history')) {
    function mms_ajax_search_by_history()
    {
        global $wpdb;

        $history = isset($_GET['history']) ? sanitize_text_field($_GET['history']) : '';
        $search_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $limit = 8;

        $ip_address = $_SERVER['REMOTE_ADDR'];
        $query = "SELECT * FROM wp_product_search_view WHERE 1=1";
        if (!empty($history) && !empty($search_category)) {
            $like_query = '%' . $wpdb->esc_like($history) . '%';
            $like_category = '%' . $wpdb->esc_like($search_category) . '%';

            $query = $wpdb->prepare(
                "SELECT * FROM wp_product_search_view 
                    WHERE product_categories LIKE %s 
                    AND product_title LIKE %s",
                $like_category,
                $like_query
            );
        } elseif ($history) {
            $like_query = '%' . $wpdb->esc_like($history) . '%';
            $like_category = '%' . $wpdb->esc_like($search_category) . '%';
            $query = $wpdb->prepare(
                "SELECT * FROM wp_product_search_view 
                    WHERE product_categories LIKE %s 
                    OR product_title LIKE %s",
                $like_category,
                $like_query
            );
        } elseif ($search_category) {
            $query .= $wpdb->prepare(" AND product_categories LIKE %s", '%' . $wpdb->esc_like($search_category) . '%');
        }

        $total_query = "SELECT COUNT(*) FROM wp_product_search_view WHERE 1=1";
        $total_results = $wpdb->get_var($total_query);
        $total_pages = ceil($total_results / $limit);

        $query .= $wpdb->prepare(" LIMIT %d, %d", ($paged - 1) * $limit, $limit);
        $results = $wpdb->get_results($query);

        if ($results) {
            foreach ($results as $product) {
                include( get_stylesheet_directory() . '/module/search/templates/mms-product.php' );
            }
        } else {
            echo "<p class='product_notf'>Sorry, we couldn't find any experiences or activities</p>";
        }

        wp_die();
    }
    add_action('wp_ajax_mms_ajax_search_by_history', 'mms_ajax_search_by_history');
    add_action('wp_ajax_nopriv_mms_ajax_search_by_history', 'mms_ajax_search_by_history');
}
if (!function_exists('mms_load_more_products')) {
    function mms_load_more_products()
    {
        global $wpdb;

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $search_query = isset($_POST['mms_search']) ? sanitize_text_field($_POST['mms_search']) : '';
        $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

        $limit = 8;
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM wp_product_search_view WHERE 1=1";
        if (!empty($search_query) && !empty($category)) {
            $like_query = '%' . $wpdb->esc_like($search_query) . '%';
            $like_category = '%' . $wpdb->esc_like($category) . '%';
            $query = $wpdb->prepare(
                "SELECT * FROM wp_product_search_view 
                WHERE product_categories LIKE %s 
                AND product_title LIKE %s 
                LIMIT %d OFFSET %d",
                $like_category,
                $like_query,
                $limit,
                $offset
            );
        } elseif (!empty($search_query)) {
            $like_query = '%' . $wpdb->esc_like($search_query) . '%';
            $query = $wpdb->prepare(
                "SELECT * FROM wp_product_search_view 
                WHERE product_title LIKE %s 
                LIMIT %d OFFSET %d",
                $like_query,
                $limit,
                $offset
            );
        } elseif (!empty($category)) {
            $like_category = '%' . $wpdb->esc_like($category) . '%';
            $query = $wpdb->prepare(
                "SELECT * FROM wp_product_search_view 
                WHERE product_categories LIKE %s 
                LIMIT %d OFFSET %d",
                $like_category,
                $limit,
                $offset
            );
        } else {
            $query = $wpdb->prepare(
                "SELECT * FROM wp_product_search_view LIMIT %d OFFSET %d",
                $limit,
                $offset
            );
        }
        $results = $wpdb->get_results($query);
        $response = new stdClass();
        $response->products = '';
        if ($results) {
            foreach ($results as $product) {
                ob_start();
                include( get_stylesheet_directory() . '/module/search/templates/mms-product.php' );
                $response->products .= ob_get_clean();
            }
        }
        $response->hide_button = count($results) < $limit;
        echo json_encode($response);
        wp_die();
    }
    add_action('wp_ajax_mms_load_more_products', 'mms_load_more_products');
    add_action('wp_ajax_nopriv_mms_load_more_products', 'mms_load_more_products');
}

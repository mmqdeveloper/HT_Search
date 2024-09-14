<?php
if (!function_exists('mm_search_form_header_mobile_autocomplate')) {
    add_action('wp_ajax_mm_search_form_header_mobile_autocomplate', 'mm_search_form_header_mobile_autocomplate');
    add_action('wp_ajax_nopriv_mm_search_form_header_mobile_autocomplate', 'mm_search_form_header_mobile_autocomplate');
    
    function mm_search_form_header_mobile_autocomplate() {
        $term = $_POST['search'];
        $results = array();
    
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            's' => $term,
            'posts_per_page' => 10
        );
    
        $query = new WP_Query($args);
    
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $results[] = array(
                    'label' => get_the_title(),
                    'image' => get_the_post_thumbnail_url(),
                );
            }
        }
    
        wp_reset_postdata();

        $html = '';

        if (count($results) > 0) {
            foreach($results as $val) {
                $html .= '<div class="mm-search-suggestions-item" data-title="'.$val['label'].'">';
                $html .= '<img src="'.$val['image'].'">';
                $html .= '<span>'.$val['label'].'</span>';
                $html .= '</div>';
            }
        }

        echo $html;
        die();
    }
}
<?php

if (!function_exists('mm_handle_export_product_fhdn')) {
    add_action( 'wp_ajax_nopriv_mm_handle_export_product_fhdn', 'mm_handle_export_product_fhdn' );
    add_action( 'wp_ajax_mm_handle_export_product_fhdn', 'mm_handle_export_product_fhdn' );
    function mm_handle_export_product_fhdn () {
        if ($_POST['mm_export_product_fhdn'] == 'export') {
            $args = array(
                'post_type'  => 'product',
                'meta_query' => array(
                    array(
                        'key'   => 'mm_select_booking_type',
                        'value' => 'fhdn',
                        'compare' => '='
                    )
                ),
                'posts_per_page' => -1
            );
        
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                $upload_dir = wp_upload_dir();
                $export_product_fhdn_dir = $upload_dir['basedir'] . '/mm_export_product_fhdn';
                if ( ! file_exists( $export_product_fhdn_dir ) ) {
                    wp_mkdir_p( $export_product_fhdn_dir );
                }
                $csv_file = $export_product_fhdn_dir.'/mm-export-fhdn-product-'.date('d-m-Y--H-i-s').'.csv';
                $csv_handler = fopen( $csv_file, 'w' );
                fputcsv( $csv_handler, array(
                    'ID Product',
                    'Status',
                    'Name',
                    'Price',
                    'Vendor',
                    'Vendor Tour Name',
                    'Vendor URL',
                    'Fareharbor Link',
                ) );
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $id = get_the_ID();
                    $status = get_post_status();
                    $name = get_the_title();
                    $price = get_post_meta($id, '_wc_display_cost', true);
                    $vendor = get_post_meta($id, 'mm_product_vendor', true);
                    $vendor_tour_name = get_post_meta($id, 'mm_vendor_tour_name', true);
                    $vendor_url = get_post_meta($id, 'mm_vendor_product', true);
                    $fareharbor_link = '';
                    $fareharbor_link = get_post_meta($id, 'content_book_booking_box_fareharbor_link', true);
                    if (empty($fareharbor_link)) {
                        $content_builder = get_post_meta($id, '_aviaLayoutBuilderCleanData', true);
                        $pattern = "/fareharbox_link='(https?:\/\/[^']+)'/";
                        $matches = array();
                        if (preg_match($pattern, $content_builder, $matches)) {
                            $fareharbor_link = $matches[1];
                        } 
                    }
                    if (empty($fareharbor_link)) {
                        $fareharbor_link = get_post_meta($id, 'enable_fareharbor_link', true);
                    }
                    fputcsv( $csv_handler, array(
                        $id,
                        $status,
                        $name,
                        $price,
                        $vendor,
                        $vendor_tour_name,
                        $vendor_url,
                        $fareharbor_link,
                    ));
                }
                fclose( $csv_handler );
                echo 'mm-export-fhdn-product-'.date('d-m-Y--H-i-s').'.csv';
                wp_reset_postdata();
            }
        }
    }
}

if (!function_exists('mm_add_submenu_page_export_product_fhdn') && !function_exists('mm_layout_export_product_fhdn')) {
    add_action('admin_menu', 'mm_add_submenu_page_export_product_fhdn');
    function mm_add_submenu_page_export_product_fhdn () {
        add_submenu_page(
            'maui-marketing-menu',
            'Export Product FHDN',
            'Export Product FHDN',
            'manage_options',
            'mm-export-product-fhdn',
            'mm_layout_export_product_fhdn'
        );
    }
    
    function mm_layout_export_product_fhdn () {
        ?>
        <div class="wrap">
            <h1>Export Product FHDN</h1>
            <form method="post" id="mm_export_product_fhdn_form" action="options.php">
                <?php submit_button('Export Product FHDN'); ?>
            </form>
        </div>
        <?php
    }
}
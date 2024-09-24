<?php
/**
 * General functions
 * 
 * They are probably unsorted and should go to some other namespace
 * 
 */

namespace MauiMarketing\SyncProductsToJSON\Functions;

 
/**
 * Returns the calendar legend
 * 
 * @param    bool    $booking    Should we output the booking colors too, default: true
 * 
 * @return   string     The HTML of the legent
 */

 // Hook into admin_menu to add a new menu item in Tools
if( !function_exists('epj_add_admin_menu') ){
    add_action('admin_menu',  __NAMESPACE__ . '\\' .'epj_add_admin_menu');

    function epj_add_admin_menu() {
        add_management_page(
            'Export Products to JSON', // Page title
            'Export Products',         // Menu title
            'manage_options',          // Request capabilities
            'export-products-to-json', // Slug of the page
            __NAMESPACE__ . '\\' . 'epj_export_products_page' // Function to display page content
        );
    }
}
if( !function_exists('epj_export_products_page') ){
    function epj_export_products_page() {
        $upload_dir = wp_upload_dir();
        $file_url = $upload_dir['baseurl'] . '/products.json';
        ?>
        <div class="wrap">
            <h1>Export Products to JSON</h1>
            <form method="post" action="">
                <input type="hidden" name="epj_export_products" value="1">
                <?php submit_button('Export Products'); ?>
            </form>
        </div>
        <?php
        if (isset($_POST['epj_export_products'])) {
            epj_export_products_to_json();
        }
    }
}
if( !function_exists('epj_export_products_to_json') ){
    function epj_export_products_to_json() {
        // Check if WooCommerce is enabled or not
        if (!class_exists('WooCommerce')) {
            wp_die('WooCommerce is not activated.');
        }
    
        // Get the product list
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_tag',
                    'field' => 'id',
                    'terms' => array(16091, 16760, 17648, 16105, 16628, 17993),
                    'operator' => 'NOT IN',
                ),
            ),
        );
    
        $products = get_posts($args);
        $data = array(
            'feed_metadata' => array(
                'shard_id' => 0,
                'total_shards_count' => 1,
                'processing_instruction' => 'PROCESS_AS_SNAPSHOT',
                'nonce' => date('YmdHi'),
            ),
            'products' => array(),
        );
        $upload_dir = wp_upload_dir();
        $jsonFilePath = $upload_dir['basedir'] . '/vendor.json'; 
        $jsonData = file_get_contents($jsonFilePath); 
        $dataArray = json_decode($jsonData, true);
    
        foreach ($products as $product) {
            $product_id = $product->ID;
            $product_obj = wc_get_product($product_id);
    
            // Get the YoastSEO Meta description
            $meta_description = get_post_meta( $product_id, '_yoast_wpseo_metadesc', true );
            
            // Get the Rating
            $rating_review = 0;
            $rating_count = 0;
            $args_schema = array(
                'posts_per_page' => -1,
                'post_type' => array('aiosrs-schema'),
                'post_status' => 'publish'
            );
            $aiosrs_schema = new \WP_Query($args_schema);
            while ($aiosrs_schema->have_posts()) {
                $aiosrs_schema->the_post();
                $aiosrs_schema_id = $aiosrs_schema->post->ID;
                $schema_review  = get_post_meta( $product_id, 'bsf-schema-pro-rating-' . $aiosrs_schema_id , true );
                $schema_count   = get_post_meta( $product_id, 'bsf-schema-pro-review-counts-' . $aiosrs_schema_id , true );
                if(!empty($schema_review) && !empty($schema_count)){
/*
                    $rating_review = $schema_review;
                    $rating_count = $schema_count;
*/
                }
            }
    
            $title = array(
                array(
                    'language_code' => 'en',
                    'text' => $product_obj->get_name(),
                )
            );
    
            $description = array(
                array(
                    'language_code' => 'en',
                    'text' => $meta_description,
                )
            );
    
            $rating = array(
                'average_value' => $rating_review,
                'rating_count' => $rating_count
            );
            $product_features = array();
            $short_description = get_post_meta( $product_id, 'short_description_description', true );
            $number_list_items = get_post_meta( $product_id, 'short_description_list_items', true);
            $product_features[] = array(
                'feature_type' => 'TEXT_FEATURE_INCLUSION',
                'value' => array(
                    'localized_texts' => array(
                        array(
                            'language_code' => 'en',
                            'text' => trim($short_description),
                        ),
                    ),
                ),
            );
            if($number_list_items > 0){
                for( $i = 0; $i < 2; $i++ ){
                    $list_items_text = get_post_meta( $product_id, 'short_description_list_items_' . $i . '_text', true );
                    $product_features[] = array(
                        'feature_type' => 'TEXT_FEATURE_HIGHLIGHT',
                        'value' => array(
                            'localized_texts' => array(
                                array(
                                    'language_code' => 'en',
                                    'text' => trim($list_items_text),
                                ),
                            )
                        ),
                    );
                }
            }
    
            // Get the Resources
            $options = array();
            $resources = $product_obj->get_resources();
            // Get categories

            // $categories = yoast_get_primary_term('product_cat', $product_id);
            // $array_categories = array();
            // if($categories){
            //     $array_categories[] = array(
            //         'label' => esc_html__($categories),
            //     );
            // }

            // $categories = get_the_terms( $product_id, 'product_cat' );
            // $array_categories = array();
            // if ($categories) {
            //     foreach ($categories as $categorie) {
            //         $array_categories[] = array(
            //             'label' => $categorie->term_id,
            //         );
            //     }
            // }
            

            $categories = get_the_terms($product_id, 'product_cat');
            $array_categories = array();
            $term_labels = array(
                'animals' => array(16706,16606,16580,2763,777,16732,16667,11176,3809,11608,17275,16658,16734,11218,16735,16157,3444),
                'beaches' => array(16715,16712,16714,11593,16667,14572,16502,17337,16546,17292,11316,11176,2395,2764,16058,16713,11705,16500,14573,11653,16472,11317,17275,16062,16658,16637,14575,16065,16626,11218,2371,2699,16055,16054,2496,16420,17565,14574,16199,16541,16744,16597,16632,11319,16157,788,3114,2591),
                'bike-tours' => array(2340,4041,4092),
                'boat-tours' => array(16199),
                'family-friendly' => array(14692,2393,14693,17482,9837,14694,15275,15276,15274,2267,2369,2747,14691,16042,16043,16738,628,628,608,1964),
                'food' => array(16716,16484,16436,16069,16616,17331),
                'history' => array(16738,587,608,16738,587),
                'nightlife' => array(16667,2393,784,9837,2267,16624,628),
                'outdoors' => array(15289,16701,16715,11593,16724,16729,16732,11360,16667,14572,16502,16745,17337,16546,17292,11316,16706,16606,16580,2763,777,2390,4092,5055,778,3809,2307,3736,2342,2764,784,785,2341,15290,16703,12073,16500,16726,11430,11608,17482,12011,14573,16747,11653,16472,11317,5056,3808,2347,5083,15291,16704,13888,16722,16727,16730,16734,16056,16059,13052,16739,16156,16622,16741,16743,17359,17539,17390,680,779,14557,14556,781,2343,14555,14554,15288,16705,16421,16708,16728,16731,16657,14575,14574,16740,16085,16199,16624,11319,541,792,2345,3444,16735,750,4237,608,3634,787,786),
                'private-tours' => array(16380,17390,16379,16377,16378,17382,17539,17359),
                'romantic' => array(16714,14701,14697,2395,2393,784,11705,9837,14702,14698,14703,14699,2371,2267,16420,14700,14696,16624,628),
                'sports' => array(15289,16729,16732,11360,16502,17337,16546,17292,11316,778,3809,2764,16058,11430,11608,12011,11653,16472,11317,16730,16734,16056,16059,16065,16626,11318,2340,779,2699,16055,16054,2496,2339,17565,16731,16735,16541,16597,16632,11319,4041,2345,3444,4304,3114,2591),
            ); 
            
            $unique_labels = array();
            
            if ($categories) {
                foreach ($categories as $categorie) {
                    $term_id = $categorie->term_id;
                    foreach ($term_labels as $label => $ids) {
                        if (in_array($term_id, $ids) && !in_array($label, $unique_labels)) {
                            $unique_labels[] = $label;
                        }
                    }
                }
            }
            
            foreach ($unique_labels as $label) {
                $array_categories[] = array('label' => $label);
            }

			$first_tour_type = null;
			
			$brand_name = get_post_meta( $product_id, 'mm_product_vendor', true);
            foreach ($dataArray as $vendor) {
                if ($vendor['vendorName'] === $brand_name) {
                    $VwplaceId = $vendor['placeId'];
                    $VphoneNumber = '+' .$vendor['phoneNumber'];
                    $Vwebsite = $vendor['website'];
                    $Vaddress = $vendor['address'];
                    $Vlanguage = $vendor['language'];
                    break; 
                }
            }


            if($resources){
                foreach ($resources as $resource) {
					if ($first_tour_type === null) {
                    $tour_type = get_post_meta($resource->ID, 'resource_tour_type', true);
                    $tour_type = strtolower($tour_type);
                    if ($tour_type === 'guided') {
					    $tour_type = 'guided-tours';
					}
	
	                    if (!empty($tour_type) && !in_array($tour_type, array_column($array_categories, 'label'))) {
	                        $array_categories[] = array('label' => $tour_type);
	                    }
	
	                    $price_options = array();
	                    if ($product_obj->has_persons()) {
	                        $person_types = $product_obj->get_person_types();
                            $person_defaults = get_post_meta($product_id, 'mm_person_default',true);
                            if($person_defaults){
                                $person_defaults = get_post_meta( $product_id, '_wc_booking_min_persons_group', true);
                            }
	                        
	                        if (!empty($person_types) && is_array($person_types)) {
	                            foreach ($person_types as $person_type) {
                                    $price = $person_type->get_block_cost();
                                    $item_amount = $price * $person_defaults;
                                    $product_tag = get_the_terms($product_id, 'product_tag');
                                    $list_tag_id = array();
                                    foreach ($product_tag as $term) {
                                        $list_tag_id[] = $term->term_id;
                                    }
                                    $woo_fee = array();
                                    $args_fee = array("post_type" => "wc_conditional_fee", "post_status" => "publish","posts_per_page"   => -1);
                                    $query_fee= get_posts( $args_fee );
                                    $woo_fee_default = 0;
                                    
                                    foreach ($query_fee as $fee) {
                                        $fees_id = $fee->ID;
                                        $get_condition_array = get_post_meta( $fees_id, 'product_fees_metabox', true );
                                        $fee_settings_product_cost = get_post_meta( $fees_id, 'fee_settings_product_cost', true );
                                        $fee_settings_select_fee_type = get_post_meta( $fees_id, 'fee_settings_select_fee_type', true );
                                        $product_fees_per_person = get_post_meta( $fees_id, 'product_fees_per_person', true );
                                        $fee_settings_status = get_post_meta( $fees_id, 'fee_settings_status', true );
                                        if ($fee_settings_status =='on' && !empty($get_condition_array) ) {
                                            if($fee_settings_select_fee_type =='percentage'){
                                                $fee_item_amount = $item_amount*($fee_settings_product_cost/100);
                                            }else{
                                                $fee_item_amount = $fee_settings_product_cost;
                                                if($product_fees_per_person == 'on'){
                                                    $fee_item_amount = $fee_item_amount * $person_defaults;
                                                }
                                            }
                                            $exclude_product_id = false;
                                            foreach ( $get_condition_array as $key => $value ) {
                                                if ( array_search( 'product', $value, true ) && $value['product_fees_conditions_is'] =='not_in' ) {
                                                $exclude_product_id = true;
                                                    break;
                                                }
                                            }
                                            if(!$exclude_product_id){
                                                foreach ( $get_condition_array as $key => $value ) {
                                                    if ( array_search( 'product', $value, true ) && $value['product_fees_conditions_is'] =='is_equal_to' ) {
                                                        $list_product_fee = $value['product_fees_conditions_values'];
                                                        if(!empty($list_product_fee)){
                                                            if(in_array($product_id, $list_product_fee)){
                                                                $woo_fee_default += $fee_item_amount;
                                                                $woo_fee[] = array("fee_id"=>$fees_id ,"type"=>$fee_settings_select_fee_type,"per_person"=>$product_fees_per_person,"fee"=>$fee_settings_product_cost);
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    if ( array_search( 'tag', $value, true ) && $value['product_fees_conditions_is'] =='is_equal_to' ) {
                                                        $list_tag_fee = $value['product_fees_conditions_values'];
                                                        $array_intersect_tag = array_intersect($list_tag_id, $list_tag_fee);
                                                        if(!empty($array_intersect_tag)){
                                                            $woo_fee_default += $fee_item_amount;
                                                            $woo_fee[] = array("fee_id"=>$fees_id ,"type"=>$fee_settings_select_fee_type,"per_person"=>$product_fees_per_person,"fee"=>$fee_settings_product_cost);
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                    
                                        }
                                    }
                                    $price_tax = $person_type->get_block_cost() * 0.095;
                                    $price_format = $price * $person_defaults + round($price_tax, 2) + round($woo_fee_default, 2); 
	                                $price_options[] = array(
	                                    'id' => $resource->ID . '-' . sanitize_title($person_type->get_name()),
	                                    'title' => $person_type->get_name() . ( !empty($person_type->get_description()) ? ' (' . $person_type->get_description() . ')' : '' ),
	                                    'price' => array(
	                                        'currency_code' => 'USD',
	                                        'units' => round($price_format)
	                                        //'units' => $get_condition_array
	                                    ),
	                                    'fees_and_taxes' =>  array(
	                                        'per_ticket_fee' => array(
	                                            'currency_code' => 'USD',
	                                            'units' => 1
	                                        ),
	                                        'per_ticket_tax' => array(
	                                            'currency_code' => 'USD',
	                                            'units' => round($price_tax)
	                                        ),
	                                    ),
	                                );
	                                break;
	                            }
	                        }
	                    }
	                    $array_place = array();
	                    $place_ids = get_post_meta($resource->ID, '_wc_place_ids', true);
	                    if(!empty($place_ids)){
	                        $list_place = explode("- ", $place_ids);
	                        foreach ($list_place as $place) {
	                            $pla = explode(": ", $place);
	                            if(!empty($pla[1])){
	                                $array_place[] = array(
	                                    'location' => array(
	                                        'location' => array(
	                                            'place_id' => trim($pla[1]),
	                                        ),
	                                    ),
	                                    'relation_type' => 'RELATION_TYPE_RELATED_NO_ADMISSION',
	                                );
	                            }
	                        }
	                        $meeting_point['location'] = array(
	                            'place_id' => $VwplaceId,
	                        );
	                        $meeting_point['description'] = array(
	                            'localized_texts' => array(
	                                array(
	                                    'language_code' => 'en',
	                                    'text' => $brand_name,
	                                )
	                            ),
	                        );
	                    }
	                    $option = array(
	                        'id' => $resource->ID,
	                        'title' => array(
	                            'localized_texts' =>  array(
	                                array(
	                                    'language_code' => 'en',
	                                    'text' => html_entity_decode($resource->post_title),
	                                )
	                            )
	                        ),
	                        'landing_page' => array(
	                            'url' => get_permalink($product_id),
	                        ),
	                        'landing_page_list_view' => array(
	                            'url' => get_permalink($product_id),
	                        ),
	                        'duration_sec' => 259200,
	                        'cancellation_policy' => array(
	                            'refund_conditions' => array(
	                                array(
	                                    'min_duration_before_start_time_sec' => 259200,
	                                    'refund_percent' => 100,
	                                )
	                            ),
	                        ),
	                        
	                        'option_categories' => $array_categories,
	                        'related_locations' => $array_place,
	                        'price_options' => $price_options,
	                        'meeting_point' => $meeting_point,
	                    );
	                    $options[] = $option;
	                    $first_tour_type = $tour_type;
                    }
                }
            }

            // Get the image URL
            $related_media = array();
            $thumbnail_id = $product_obj->get_image_id();
            $thumbnail_url = wp_get_attachment_url($thumbnail_id);
            if($thumbnail_url){
                $related_media[] = array(
                    'url' => esc_html__($thumbnail_url),
                    'type' => 'MEDIA_TYPE_PHOTO',
                );
            }
            
            $attachment_ids = $product_obj->get_gallery_image_ids();
            if ( $attachment_ids ) {
                foreach ( $attachment_ids as $attachment_id ) {
                    $image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
                    if($image_url){
                        $related_media[] = array(
                            'url' => esc_html__($image_url),
                            'type' => 'MEDIA_TYPE_PHOTO',
                            'attribution' => array(
                                'localized_texts' => array(
                                    array(
                                        'language_code' => 'en',
                                        'text' => get_bloginfo('name'),
                                    ),
                                )
                            )
                        );
                    }
                    
                }
            }
            if (strpos($brand_name, 'HTA') !== false) {
			    $brand_name = 'Hawaii Tours';
			}
            $brand_name = array(
                array(
                    'language_code' => 'en',
                    'text' => trim($brand_name),
                )
            );
            $place_info = get_post_meta(28201, 'bsf-aiosrs-local-business', true);
            $operator = array(
                'google_business_profile_name' => array(
                    'localized_texts' => array(
                        array(
                            'language_code' => 'en',
                            'text' => get_bloginfo('name'),
                        )
                    ),
                ),
                'locations' => array(
                    array(
                        'location' => array(
                            'place_info' => array(
                                'name' => $Vlanguage,
                                'phone_number' => $VphoneNumber,
                                'website_url' => $Vwebsite,
                                'unstructured_address' => $Vaddress,
                            )
                        ),
                    ),
                ),
            );
            $mm_pickup = get_post_meta($product_id, '_mm_pickup', true);
            $data['products'][] = array(
                'id' => $product_id,
                'title' => array(
                    'localized_texts' => $title,
                ),
                'description' => array(
                    'localized_texts' => $description,
                ),
                'rating'=> $rating,
                'product_features'=> $product_features,
                'options' => $options,
                'related_media' => $related_media,
                'operator' => $operator,
                'inventory_type' => 'INVENTORY_TYPE_DEFAULT',
                'confirmation_type' => 'CONFIRMATION_TYPE_INSTANT',
                'fulfillment_type'=> array(
                    'mobile' => true,
                    'print_at_home'=> false,
                    'pickup' => (!empty($mm_pickup) ? true : false )
                ),
                'brand_name' => array(
                    'localized_texts' => $brand_name,
                ),
            );
        }
        // Create JSON file
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/hawaiitours.json';
        $file_url = $upload_dir['baseurl'] . '/hawaiitours.json';
        
        file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
//         file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
    
        echo '<p>Products exported successfully. <a href="' . $file_url . '">Download JSON file</a></p>';
    }
}


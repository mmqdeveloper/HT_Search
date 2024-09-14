<?php
if (!function_exists('mm_cron_add_event_two_hour')) {

	function mm_cron_add_event_two_hour($schedules) {
		// Adds once every minute to the existing schedules.
		$schedules['mmevery2hour'] = array(
			'interval' => 2 * 60 * 60,
			'display' => __('Every 2 Hour')
		);
		return $schedules;
	}

}
add_filter('cron_schedules', 'mm_cron_add_event_two_hour');

if( !function_exists('mm_cron_add_SKU_product_function') ){
	function mm_cron_add_SKU_product_function(){
		global $wpdb;
		$prefix_tbl = $wpdb->prefix;
		$all_product = $wpdb->get_results( $wpdb->prepare( "SELECT product_id FROM {$prefix_tbl}wc_product_meta_lookup" ),ARRAY_A );

		foreach( $all_product as $key => $value ){
			foreach( $value as $key_pro => $pro_id ){

				$sku_name = 'HT-'.$pro_id;
				$check_add_sku = get_post_meta( $pro_id, 'added_sku', true );
				if( empty($check_add_sku) ){
					update_post_meta( $pro_id , '_sku', $sku_name );
					update_post_meta( $pro_id , 'added_sku', 'added' );
					$wpdb->update( $prefix_tbl.'wc_product_meta_lookup' ,
						array('sku'=> $sku_name ),
						array('product_id'=> $pro_id) );
				}

			}
		}
		//wp_mail("hungtrinhdn@gmail.com",  "BEN MM CRON SKU : data ", print_r($all_product, true));


	}

	add_action('mm_cron_add_SKU_product', 'mm_cron_add_SKU_product_function');
}

if (!wp_next_scheduled('mm_cron_add_SKU_product')) {
	wp_schedule_event(time(), 'mmevery2hour', 'mm_cron_add_SKU_product');
}


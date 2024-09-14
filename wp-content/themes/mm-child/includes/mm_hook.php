<?php
if ( ! function_exists( 'mm_bookings_date_value' ) ) {
	
	function mm_bookings_date_value() {
		return 36;
	}
	
//	add_filter( 'woocommerce_bookings_min_date_value', 'mm_bookings_date_value', 10, 4 );
}


if ( ! function_exists( 'mm_bookings_date_unit' ) ) {
	
	function mm_bookings_date_unit() {
		return 'hour';
	}
	
//	add_filter( 'woocommerce_bookings_min_date_unit', 'mm_bookings_date_unit', 10, 4 );
}


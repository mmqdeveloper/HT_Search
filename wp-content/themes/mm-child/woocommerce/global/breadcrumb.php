<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;
	$count = 0;
	$delimiter_change = ' , ';
	foreach ( $breadcrumb as $key => $crumb ) {
		$count++;
		echo $before;
		if( ! empty( $crumb[0] ) && $crumb[0] == 'IPS'  ){

			echo '<a href="' . esc_url( str_replace("/activities/ips/","/international-palm-society/",$crumb[1]) ) . '">' . esc_html( 'IPS' ) . '</a>';
			echo $after;
			echo $delimiter;
			continue;
		}

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			if( $crumb[0] == 'Packages'){
				echo '<a href="' . esc_url( str_replace("/activities/packages/","/all-inclusive-hawaii-vacations/",$crumb[1]) ) . '">' . esc_html( 'All Inclusive Packages' ) . '</a>';
				echo $after;
				echo $delimiter;
				continue;
			}
			if($key == 1){
				echo '<a href="' . esc_url( str_replace("activities/","",$crumb[1]) ) . '">' . esc_html( $crumb[0] ) . '</a>';
				echo $after;
				echo $delimiter;
				continue;
			}
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}

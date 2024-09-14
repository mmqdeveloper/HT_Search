<?php
require_once( 'functions.php' );
require_once( 'woo/woo.php' );
require_once ( 'woo/certificate_tags.php');
require_once( 'post-type/post-type.php' );
//require_once( 'test.php' );
//require_once ( 'speed/speed.php');
require_once ( 'option-email/meta-box-content-email.php' );
require_once ( 'option-email/global-option-email.php' );
require_once ( 'option-email/email-confirmation.php' );
require_once( 'frontend.php' );
require_once( 'admin/admin.php' );

if ( ! function_exists( 'mmt_module_scripts' ) ) {
	function mmt_module_scripts() {
		wp_enqueue_style( 'mmt-module-css', get_stylesheet_directory_uri() . '/module/assets/css/module.css', array(), '1.0.1', 'all' );
		wp_enqueue_script( 'mmt-module', get_stylesheet_directory_uri() . '/module/assets/js/module.js', array(), '1.2.1', true );
		wp_localize_script( 'mmt-module', 'mmt_ajax_obj', array(
			'ajaxurl'      => admin_url( 'admin-ajax.php' ),
			'site_url'     => site_url(),
			'checkout_url' => wc_get_checkout_url(),
		) );
	}
	
	add_action( 'wp_enqueue_scripts', 'mmt_module_scripts', 99, 3 );
}

if ( ! function_exists( 'mmt_woocommerce_add_to_cart' ) ) {
	
	function mmt_woocommerce_add_to_cart(
		$cart_item_key,
		$product_id,
		$quantity,
		$variation_id,
		$variation,
		$cart_item_data
	) {
		if ( ! empty( WC()->cart->cart_contents ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				if ( $item_key != $cart_item_key ) {
					//WC()->cart->remove_cart_item( $item_key );
				}
			}
		}
	}
	
	add_action( 'woocommerce_add_to_cart', 'mmt_woocommerce_add_to_cart', 10, 7 );
}

add_action( 'admin_init', 'mm_disable_autosave' );
if ( ! function_exists( 'mm_disable_autosave' ) ) {
	function mm_disable_autosave() {
	    wp_deregister_script( 'autosave' );
	}
}

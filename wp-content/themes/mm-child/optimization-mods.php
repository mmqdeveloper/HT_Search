<?php
	function _wp_mm_pre_header_hook() {
		// ob_start('_custom_ob');
		
		if (is_front_page()) {
			remove_action('wp_footer', 'av_google_maps::gmap_js_globals', 10);
		}
	}
	add_action('wp_mm_pre_header_hook', '_wp_mm_pre_header_hook');

	function dequeue_woocommerce_cart_fragments() { wp_dequeue_script('wc-cart-fragments'); }
	if (is_home() || is_front_page()) add_action('wp_enqueue_scripts', 'dequeue_woocommerce_cart_fragments', 11);
?>
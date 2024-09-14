<?php

/**
 * Product Purchase Button
 *
 * Display the "Add to cart" button for the current product
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}    // Exit if accessed directly


if ( ! class_exists( 'woocommerce' ) ) {
	add_shortcode( 'mm_bookingbox_product_button', 'avia_please_install_woo' );

	return;
}

if ( ! class_exists( 'mm_input_search_faq' ) ) {

	class mm_input_search_faq extends aviaShortcodeTemplate {

		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button() {
			$this->config['self_closing'] = 'yes';

			$this->config['name']       = __( 'MM Search FAQ', 'avia_framework' );
			$this->config['tab']        = __( 'Maui Marketing Elements', 'avia_framework' );
			$this->config['icon']       = AviaBuilder::$path['imagesURL'] . "sc-button.png";
			$this->config['order']      = 20;
			$this->config['target']     = 'avia-target-insert';
			$this->config['shortcode']  = 'mm_input_search_faq';
			$this->config['tooltip']    = __( 'Add input search FAQ', 'avia_framework' );
			$this->config['drag-level'] = 3;
			$this->config['tinyMCE']    = array( 'disable' => "true" );
			// $this->config['posttype'] = array('product', __('This element can only be used on single product pages', 'avia_framework'));
		}

		function popup_elements() {
			$this->elements = array(
				array(
					"type"          => "tab_container",
					'nodescription' => true
				),

				array(
					"type"          => "close_div",
					'nodescription' => true
				),
			);
		}

		/**
		 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
		 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
		 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
		 *
		 *
		 * @param array $params this array holds the default values for $content and $args.
		 *
		 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
		 */
		function editor_element( $params ) {
			$params['innerHtml'] = "<img src='" . $this->config['icon'] . "' title='" . $this->config['name'] . "' />";
			$params['innerHtml'] .= "<div class='avia-element-label'>" . $this->config['name'] . "</div>";

			$params['innerHtml'] .= "<div class='avia-flex-element'>";
			$params['innerHtml'] .= __( 'Display input search FAQ', 'avia_framework' );
			$params['innerHtml'] .= "</div>";

			return $params;
		}

		/**
		 * Frontend Shortcode Handler
		 *
		 * @param array $atts array of attributes
		 * @param string $content text within enclosing form of shortcode element
		 * @param string $shortcodename the shortcode found, when == callback name
		 *
		 * @return string $output returns the modified html string
		 */
		function shortcode_handler( $atts, $content = "", $shortcodename = "", $meta = "" ) {
			$html = '';
			$html .= '<div id="wrap-search-faq">';
			$html .= '<h3>Frequently Asked Questions</h3>';
			$html .= '<div class="wrap-btn">';
			$html .= '<input placeholder="Search..." type="text" name="faq_search" class="form-input">';
			$html .= '<button class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>';
			$html .= '</div>';
			$html .= '<div class="wrap-content-faq"></div>';
			$html .= '</div>';

			return $html;
		}

	}

}




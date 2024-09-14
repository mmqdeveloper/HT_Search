<?php
/**
 * Shop Options Tab
 * ================
 *
 * @since 4.8.2
 */
if( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly

global $avia_config, $avia_pages, $avia_elements;


$avia_elements[] = array(
			'slug'		=> 'shop',
			'name'		=> __( 'Header Shopping Cart Icon', 'avia_framework' ),
			'desc'		=> __( 'You can choose the appearance of the cart icon here', 'avia_framework' ),
			'id'		=> 'cart_icon',
			'type'		=> 'select',
			'std'		=> '',
			'no_first'	=> true,
			'subtype'	=> array(
								__( 'Display Floating on the side, but only once product was added to the cart', 'avia_framework' ) => '',
								__( 'Always Display floating on the side', 'avia_framework' )			=> 'always_display',
								__( 'Always Display attached to the main menu', 'avia_framework' )		=> 'always_display_menu',
								__( 'Do not show at all', 'avia_framework' )							=> 'no_cart'
							)
		);

$avia_elements[] = array(
			'slug'		=> 'shop',
			'name'		=> __( 'Single Product Added To Cart Message Box For ALB Products', 'avia_framework' ),
			'desc'		=> __( 'WooCommerce displays a message box after a product had been added to cart on single product pages. Select the behaviour on single ALB product pages.', 'avia_framework' ),
			'id'		=> 'add_to_cart_message',
			'type'		=> 'select',
			'std'		=> '',
			'no_first'	=> true,
			'subtype'	=> array(
								__( 'Do not display the message box', 'avia_framework' )		=> '',
								__( 'Display message box only on errors', 'avia_framework' )	=> 'display_errors',
								__( 'Always display message box', 'avia_framework' )			=> 'display_all'
							)
		);

$avia_elements[] = array(
			'slug'		=> 'shop',
			'name'		=> __( 'Product layout on overview pages', 'avia_framework' ),
			'desc'		=> __( 'You can choose the appearance of your products here', 'avia_framework' ),
			'id'		=> 'product_layout',
			'type'		=> 'select',
			'std'		=> '',
			'no_first'	=> true,
			'subtype'	=> array(
								__( 'Default', 'avia_framework' )								=> '',
								__( 'Default without buttons', 'avia_framework' )				=> 'no_button',
								__( 'Minimal (no borders or buttons)', 'avia_framework' )		=> 'minimal',
								__( 'Minimal Overlay with centered text', 'avia_framework' )	=> 'minimal-overlay',
							)
		);

$avia_elements[] = array(
			'slug'		=> 'shop',
			'name'		=> __( 'Product gallery', 'avia_framework' ),
			'desc'		=> __( 'You can choose the appearance of your product gallery here', 'avia_framework' ),
			'id'		=> 'product_gallery',
			'type'		=> 'select',
			'std'		=> '',
			'no_first'	=> true,
			'subtype'	=> array(
								__( 'Default enfold product gallery', 'avia_framework' )	=> '',
								__( 'WooCommerce 3.0 product gallery', 'avia_framework' )	=> 'wc_30_gallery',
							)
		);

$avia_elements[] = array(
			'slug'		=> 'shop',
			'name'		=> __( 'Main Shop Page Banner', 'avia_framework' ),
			'desc'		=> __( 'You can choose to display a parallax banner with description on the shop page', 'avia_framework' ),
			'id'		=> 'shop_banner',
			'type'		=> 'select',
			'std'		=> '',
			'no_first'	=> true,
			'subtype'	=> array(
								__( 'No, display no banner', 'avia_framework' )			=> '',
								__( 'Yes, display a banner image', 'avia_framework' )	=> 'av-active-shop-banner',
							)
		);

$avia_elements[] = array(
			'slug'		=> 'shop',
			'name'		=> __( 'Shop Banner Image', 'avia_framework' ),
			'desc'		=> __( 'Upload a large banner image which will be displayed as a background to the shop description', 'avia_framework' ),
			'id'		=> 'shop_banner_image',
			'type'		=> 'upload',
			'required'	=> array( 'shop_banner', '{contains}av-active-shop-banner' ),
			'label'		=> __( 'Use Image as banner', 'avia_framework' )
		);

$avia_elements[] = array(
			'slug'		=> 'shop',
			'name'		=> __( 'Shop Banner Image Color Overlay', 'avia_framework' ),
			'desc'		=> __( 'Set a color to display a overlay above the banner image.', 'avia_framework' ),
			'id'		=> 'shop_banner_overlay_color',
			'type'		=> 'colorpicker',
			'std'		=> '#000000',
			'required'	=> array( 'shop_banner', '{contains}av-active-shop-banner' ),
			'class'		=> 'av_2columns av_col_1'
		);

$avia_elements[] =	array(
			'slug'		=> 'shop',
			'name'		=> __( 'Overlay Opacity', 'avia_framework' ),
			'desc'		=> __( 'Select the opacity of your colored banner overlay', 'avia_framework' ),
			'id'		=> 'shop_banner_overlay_opacity',
			'type'		=> 'select',
			'std'		=> '0.5',
			'no_first'	=> true,
			'required'	=> array( 'shop_banner', '{contains}av-active-shop-banner' ),
			'class'		=> 'av_2columns av_col_2',
			'subtype'	=> array(
								'0.1'	=> '0.1',
								'0.2'	=> '0.2',
								'0.3'	=> '0.3',
								'0.4'	=> '0.4',
								'0.5'	=> '0.5',
								'0.6'	=> '0.6',
								'0.7'	=> '0.7',
								'0.8'	=> '0.8',
								'0.9'	=> '0.9',
								'1'		=> '1'
							)
		);


$avia_elements[] =	array(
			'slug'		=> 'shop',
			'name'		=> __( 'Shop Description', 'avia_framework' ),
			'desc'		=> __( 'Enter a short description or welcome note for your default Shop Page', 'avia_framework' ),
			'id'		=> 'shop_banner_message',
			'type'		=> 'textarea',
			'std'		=> '',
			'required'	=> array( 'shop_banner', '{contains}av-active-shop-banner' ),
			'class'		=> 'av_2columns av_col_1',
		);

$avia_elements[] =	array(
			'slug'		=> 'shop',
			'name'		=> __( 'Shop Description Color', 'avia_framework' ),
			'desc'		=> __( 'Select the color of your shop description', 'avia_framework' ),
			'id'		=> 'shop_banner_message_color',
			'type'		=> 'colorpicker',
			'std'		=> '#ffffff',
			'required'	=> array( 'shop_banner', '{contains}av-active-shop-banner' ),
			'class'		=> 'av_2columns av_col_2'
		);

$avia_elements[] =	array(
			'slug'		=> 'shop',
			'name'		=> __( 'Enable Banner for product category pages', 'avia_framework' ),
			'desc'		=> __( 'You can enable the shop banner for all categories as well. You can also set individual banners by editing the category', 'avia_framework' ),
			'id'		=> 'shop_banner_global',
			'type'		=> 'checkbox',
			'std'		=> false,
			'required'	=> array( 'shop_banner', '{contains}av-active-shop-banner' )
		);

/* --------------------------------------------------------
 * Custom option shop
 * -------------------------------------------------------- */

/**
* @since ????
* @param array $social_icon_array
* @return array
*/
$avia_config['social_icon_array'] = apply_filters( 'avf_social_icons_options', $avia_config['social_icon_array'] );

$avia_config['social_share_array'] = array(
	'Copy Link'		=> 'copylink',
	'Email'			=> 'email',
	'Facebook'		=> 'facebook',
	'Twitter'		=> 'twitter',
	// 'WhatsApp'		=> 'whatsapp',
	'Pinterest'		=> 'pinterest',
	// 'Reddit'		=> 'reddit',
	// 'LinkedIn'		=> 'linkedin',
	// 'Tumblr'		=> 'tumblr',
	// 'Vk'			=> 'vk',
	// 'Yelp'			=> 'yelp',
);

/**
* @since 4.8.4.1
* @param array $avia_config['social_share_array']
* @return array
*/
$avia_config['social_share_array'] = apply_filters( 'avf_social_share_array_options', $avia_config['social_share_array'] );

$avia_config['social_profile_array'] = array_diff( $avia_config['social_icon_array'], $avia_config['social_share_array'] );

$desc = __( 'Check to display', 'avia_framework' );
// $link = __( 'Link', 'avia_framework' );

if( ! empty( $avia_config['social_share_array'] ) )
{
	$avia_elements[] =	array(
				'slug'		=> 'shop',
				'name'		=> __( 'Share Links Of Your Shop Product', 'avia_framework' ),
				'desc'		=> __( 'The theme allows you to display share links to various social networks of your shop products. Check which links you want to display:', 'avia_framework' ),
				'id'		=> 'shop_social_share',
				'type'		=> 'heading',
				'nodescription'	=> true
			);

	$count = 0;
	foreach( $avia_config['social_share_array'] as $name => $id )
	{
		$classind = ( $count % 3 ) + 1;

		$avia_elements[] = array(
					'slug'	=> 'shop',
					'name' 	=> $name,
					'desc' 	=> $desc,
					'id' 	=> 'shop_share_' . $id,
					'type' 	=> 'checkbox',
					'std'	=> '',
					'class' => 'av_3col av_col_' . $classind,
				);

		$count++;
	}
}




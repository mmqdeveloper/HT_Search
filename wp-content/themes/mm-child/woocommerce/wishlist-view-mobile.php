<?php
/**
 * Wishlist page template - Modern layout
 *
 * @author YITH
 * @package YITH\Wishlist\Templates\Wishlist\View
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist                      \YITH_WCWL_Wishlist Current wishlist
 * @var $wishlist_items                array Array of items to show for current page
 * @var $is_default                    bool Whether current wishlist is default
 * @var $wishlist_token                string Current wishlist token
 * @var $wishlist_id                   int Current wishlist id
 * @var $users_wishlists               array Array of current user wishlists
 * @var $page_title                    string Page title
 * @var $pagination                    string yes/no
 * @var $per_page                      int Items per page
 * @var $current_page                  int Current page
 * @var $page_links                    array Array of page links
 * @var $is_user_owner                 bool Whether current user is wishlist owner
 * @var $show_price                    bool Whether to show price column
 * @var $show_dateadded                bool Whether to show item date of addition
 * @var $show_stock_status             bool Whether to show product stock status
 * @var $show_add_to_cart              bool Whether to show Add to Cart button
 * @var $show_remove_product           bool Whether to show Remove button
 * @var $show_price_variations         bool Whether to show price variation over time
 * @var $show_variation                bool Whether to show variation attributes when possible
 * @var $show_cb                       bool Whether to show checkbox column
 * @var $show_quantity                 bool Whether to show input quantity or not
 * @var $show_ask_estimate_button      bool Whether to show Ask an Estimate form
 * @var $show_last_column              bool Whether to show last column (calculated basing on previous flags)
 * @var $move_to_another_wishlist      bool Whether to show Move to another wishlist select
 * @var $move_to_another_wishlist_type string Whether to show a select or a popup for wishlist change
 * @var $additional_info               bool Whether to show Additional info textarea in Ask an estimate form
 * @var $price_excl_tax                bool Whether to show price excluding taxes
 * @var $enable_drag_n_drop            bool Whether to enable drag n drop feature
 * @var $repeat_remove_button          bool Whether to repeat remove button in last column
 * @var $available_multi_wishlist      bool Whether multi wishlist is enabled and available
 * @var $form_action                   string Action for the wishlist form
 * @var $no_interactions               bool
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<!-- WISHLIST GRID -->
<ul
	class="wishlist_table wishlist_view shop_table cart modern_grid responsive <?php echo $no_interactions ? 'no-interactions' : ''; ?> <?php echo $enable_drag_n_drop ? 'sortable' : ''; ?> products mm-single-product"
	data-pagination="<?php echo esc_attr( $pagination ); ?>" data-per-page="<?php echo esc_attr( $per_page ); ?>" data-page="<?php echo esc_attr( $current_page ); ?>"
	data-id="<?php echo esc_attr( $wishlist_id ); ?>" data-token="<?php echo esc_attr( $wishlist_token ); ?>">

	<?php
	if ( $wishlist && $wishlist->has_items() ) :
		foreach ( $wishlist_items as $item ) :
			/**
			 * Each of wishlist items
			 *
			 * @var $item \YITH_WCWL_Wishlist_Item
			 */
			global $product, $wpdb;

			$product = $item->get_product();

			if ( $product && $product->exists() ) :
				?>
				<li id="yith-wcwl-row-<?php echo esc_attr( $item->get_product_id() ); ?>" data-row-id="<?php echo esc_attr( $item->get_product_id() ); ?>" class="product">
					<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
						<div class="thumbnail_container mm_thumbnail">
							<div class="mm-tag-button">
								<?php
								if (is_object_in_term($item->get_product_id(), 'product_tag', 'likely-to-sell-out')) {
									?>
									<span class="tag-like-to-sell-out">Likely to Sell Out</span>
									<?php
								}
								?>
								<?php
								if (is_object_in_term($item->get_product_id(), 'product_tag', 'popular-tour')) {
									?>
									<span class="tag-popular-tour">Popular Tour</span>
									<?php
								}
								?>
							</div>
							<?php woocommerce_template_loop_product_thumbnail(); ?>
							<p class="woocommerce-loop-product__title title_mm">
								<?php echo wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ); ?>
								<?php
								$rating = 5;
								$postmeta_table = $wpdb->prefix . "postmeta";
								$query_rating = "
									SELECT      meta_value
									FROM        $postmeta_table
									WHERE       `post_id` = %s AND `meta_key` LIKE '%bsf-schema-pro-rating%'
								";
								$query_rating = $wpdb->prepare($query_rating, $item->get_product_id());
								$results_rating = $wpdb->get_results($query_rating);
								if(!empty($results_rating)){
									if(isset($results_rating[0]->meta_value)){
										$rating = $results_rating[0]->meta_value;
									}
								}
								$full  = '<span class="dashicons dashicons-star-filled"></span>';
								$semi  = '<span class="dashicons dashicons-star-half"></span>';
								$empty = '<span class="dashicons dashicons-star-empty"></span>';

								$html_rating = str_repeat( $full, floor( $rating ) );

								if( $rating > floor( $rating ) ){

									$html_rating .= $semi;
								}

								$html_rating .= str_repeat( $empty, 5 - ceil( $rating ) );
								$star_rating = '<span class="mm-title-rating">'.$html_rating.'</span>';
								?>
								<?php echo $star_rating; ?>
							</p>
						</div>
						<!--</a>-->
						<div class="inner_product_header">
							<?php
							$excerpt = get_post_meta($item->get_product_id(), 'description_inner', true);
							$excerpt = stripslashes(wpautop(trim(html_entity_decode($excerpt))));
							$pos_array = array();
							if (strlen(strstr($excerpt, '</p>')) > 0) {
								$pos_array[] = strpos($excerpt, '</p>');
							}
							if (strlen(strstr($excerpt, '<br')) > 0) {
								$pos_array[] = strpos($excerpt, '<br');
							}
							if (strlen(strstr($excerpt, 'av_hr')) > 0) {
								$pos_array[] = strpos($excerpt, '[av_hr');
							}
							if(empty($pos_array)){
								if (strlen(strstr($excerpt, '<ul')) > 0) {
									$pos_array[] = strpos($excerpt, '<ul');
								}
							}
							if (!empty($pos_array)) {
								$pos = min($pos_array);
								$description = substr($excerpt, 0, $pos);
								$feature_list = substr($excerpt, $pos);
								$description = wordwrap($description, 65);
								$description = explode("\n", $description);
								$description = $description[0] . '...';
								$excerpt = $description . ' <span class="more-description">More</span> ' .  do_shortcode($feature_list);
							}

							echo $excerpt;
							?>
						</div>
						<div class="avia_cart_buttons single_button">
							<span class="wc-price">
								<span class="starting-price">from</span>
								<?php
								if ('gift-card' == $product->get_type()) {
									$amounts = $product->get_amounts_to_be_shown();
									foreach ($amounts as $value => $item) {
										echo wc_price($item->get_price());
										break;
									}
								} else
									echo wc_price($product->get_price());
								?>
							</span>
							<button data-quantity="1"  data-product_sku="" class="button product_type_booking add_to_cart_button">BOOK NOW</button>

						</div>
					</a>
					<?php 
					if ( shortcode_exists('yith_wcwl_add_to_wishlist') ) {
						echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $item->get_product_id() . '" ]'); 
					}?>
				</li>
				<?php
			endif;
		endforeach;
	else :
		?>
		<li class="wishlist-empty">
			<?php
			/**
			 * APPLY_FILTERS: yith_wcwl_no_product_to_remove_message
			 *
			 * Filter the message shown when there are no products in the wishlist.
			 *
			 * @param string $message Message
			 *
			 * @return string
			 */
			echo esc_html( apply_filters( 'yith_wcwl_no_product_to_remove_message', __( 'No products added to the wishlist', 'yith-woocommerce-wishlist' ) ) );
			?>
		</li>
	<?php endif; ?>
</ul>

<?php if ( ! empty( $page_links ) ) : ?>
	<nav class="wishlist-pagination">
		<?php echo wp_kses_post( $page_links ); ?>
	</nav>
<?php endif; ?>

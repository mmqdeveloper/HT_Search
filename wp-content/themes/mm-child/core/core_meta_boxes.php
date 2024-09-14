<?php
//core metabox(coppy post_custom_meta_box)
function mm_speedup_remove_post_meta_box() {
	global $post_type;

    if ( is_admin() && post_type_supports( $post_type, 'custom-fields' ) && $post_type == 'shop_order' || $post_type == 'page' || $post_type == 'product' || $post_type == 'post') {
		remove_meta_box( 'postcustom', 'post', 'normal' );
		add_meta_box( 'admin-speedup-postcustom', __('MM Speedup Custom Fields'), 'mm_speedup_post_custom_meta_box', null, 'normal', 'core' );
	}
}

add_action( 'add_meta_boxes', 'mm_speedup_remove_post_meta_box' );


function mm_speedup_post_custom_meta_box( $post ) {
	?>
	<div id="postcustom">
		<div id="postcustomstuff">
			<div id="ajax-response"></div>
			<?php
			$metadata = has_meta($post->ID);
			foreach ( $metadata as $key => $value ) {
				if ( is_protected_meta( $metadata[ $key ][ 'meta_key' ], 'post' ) || ! current_user_can( 'edit_post_meta', $post->ID, $metadata[ $key ][ 'meta_key' ] ) )
					unset( $metadata[ $key ] );
			}
			list_meta( $metadata );
                        if(function_exists('mm_speedup_meta_form')){
                        mm_speedup_meta_form( $post ); }?>
			<p><?php _e('Custom fields can be used to add extra metadata to a post that you can use in your theme.'); ?></p>
		</div>
	</div>
	<?php
}





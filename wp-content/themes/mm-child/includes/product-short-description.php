<?php
// Add custom Meta box to admin products pages
add_action( 'add_meta_boxes', 'create_product_description_home_meta_box' );
function create_product_description_home_meta_box() {
    add_meta_box(
        'custom_product_description_meta_box',
        __( 'Product short description (Inner page)', 'cmb' ),
        'mm_description_content_meta_box',
        'product',
        'normal',
        'default'
    );
}

// Custom metabox content in admin product pages
function mm_description_content_meta_box( $post ){
    $product = wc_get_product($post->ID);
    $content = $product->get_meta( 'description_inner' );

    echo '<div class="product_description_inner">';

    wp_editor( stripslashes($content), 'description_inner', ['textarea_rows' => 10]);

    echo '</div>';
}

// Save WYSIWYG field value from product admin pages
add_action( 'woocommerce_admin_process_product_object', 'save_product_custom_wysiwyg_field', 10, 1 );
function save_product_custom_wysiwyg_field( $product ) {
    if (  isset( $_POST['description_inner'] ) )
         $product->update_meta_data( 'description_inner', wp_kses_post( $_POST['description_inner'] ) );
}


// Display "technical specs" content tab
function display_technical_specs_product_tab_content() {
    global $product;
    echo '<div class="wrapper-description_inner">' . $product->get_meta( 'description_inner' ) . '</div>';
}


<?php

// Add custom Meta box to admin products pages
add_action('add_meta_boxes', 'ht_custom_content_email');

function ht_custom_content_email() {
    add_meta_box(
            'ht_custom_content_email_meta_box',
            __('MM Emails', 'cmb'),
            'mm_save_product_custom_content_email_meta_box',
            'product',
            'normal',
            'default'
    );
}

// Custom metabox content in admin product pages
function mm_save_product_custom_content_email_meta_box($post) {
    $product = wc_get_product($post->ID);
    $content_header = $product->get_meta('content_header_email_meta_box');
    $content = $product->get_meta('content_email_meta_box');
    echo '<div class="product_content_email_meta_box">';
    echo '<h3>Header Email</h3>';
    wp_editor(stripslashes($content_header), 'content_header_email_meta_box', ['textarea_rows' => 10]);
    echo '<h3>Footer Email</h3>';
    wp_editor(stripslashes($content), 'content_email_meta_box', ['textarea_rows' => 10]);

    echo '</div>';
}

// Save WYSIWYG field value from product admin pages
add_action('woocommerce_admin_process_product_object', 'save_product_custom_content_email', 10, 1);

function save_product_custom_content_email($product) {
    if (isset($_POST['content_header_email_meta_box'])) {
        $product->update_meta_data('content_header_email_meta_box', wp_kses_post($_POST['content_header_email_meta_box']));
    }
    if (isset($_POST['content_email_meta_box'])) {
        $product->update_meta_data('content_email_meta_box', wp_kses_post($_POST['content_email_meta_box']));
    }
}

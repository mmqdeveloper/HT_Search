<?php

function icon_resources_meta_box() {
    add_meta_box('icon-resources', 'Image Resources', 'admin_icon_resources_output', 'bookable_resource');
    add_meta_box('get-product-resources', 'Product', 'admin_product_resources_output', 'bookable_resource');
    add_meta_box('resource-tour-type', 'Resource Tour Type', 'admin_resource_tour_type_output', 'bookable_resource');
}

add_action('add_meta_boxes', 'icon_resources_meta_box');

// Tour Type

if (!function_exists('admin_resource_tour_type_output')){
    function admin_resource_tour_type_output($post) {

        wp_nonce_field('save_resource_tour_type_nonce', 'resource_tour_type_nonce');
        ?>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="resource-type"><?php _e('Tour Type: ', 'textdomain'); ?></label>
            </th>
            <td>
                <?php
                $resource_tour_type = get_post_meta($post->ID, 'resource_tour_type', true);
                ?>
                <select name="resource_tour_type" id="resource_tour_type">
                    <option value="" <?php selected($resource_tour_type, ''); ?>><?php _e('Not Set', 'textdomain'); ?></option>
                    <option value="Self-Guided" <?php selected($resource_tour_type, 'Self-Guided'); ?>><?php _e('Self-Guided', 'textdomain'); ?></option>
                    <option value="Guided" <?php selected($resource_tour_type, 'Guided'); ?>><?php _e('Guided', 'textdomain'); ?></option>
                </select>
            </td>
        </tr>
        <?php
    }
}

if (!function_exists('save_resource_tour_type_meta')){
    function save_resource_tour_type_meta($post_id) {

        if (isset($_POST['resource_tour_type']) && isset($_POST['resource_tour_type_nonce'])) {

            if (wp_verify_nonce($_POST['resource_tour_type_nonce'], 'save_resource_tour_type_nonce')) {

                update_post_meta($post_id, 'resource_tour_type', sanitize_text_field($_POST['resource_tour_type']));
            }
        }
    }
    add_action('save_post', 'save_resource_tour_type_meta');
}

// End Tour Type

function admin_icon_resources_output($post) {
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="category-image-id"><?php _e('Image', 'mm'); ?></label>
        </th>
        <td>
            <?php $image_id = get_post_meta($post->ID, 'icon_resources', true); ?>
            <input type="hidden" id="icon_resources" name="icon_resources" value="<?php echo $image_id; ?>">
            <div id="resources-image-wrapper">
                <?php if ($image_id) { ?>
                    <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                <?php } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary mm_resources_media_button" id="mm_resources_media_button" name="mm_resources_media_button" value="<?php _e('Add Image', 'mm'); ?>" />
                <input type="button" class="button button-secondary mm_resources_media_remove" id="mm_resources_media_remove" name="mm_resources_media_remove" value="<?php _e('Remove Image', 'mm'); ?>" />
            </p>
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="category-image-id"><?php _e('Image Hover', 'mm'); ?></label>
        </th>
        <td>
            <?php $image_id_hover = get_post_meta($post->ID, 'icon_resources_hover', true); ?>
            <input type="hidden" id="icon_resources_hover" name="icon_resources_hover" value="<?php echo $image_id_hover; ?>">
            <div id="resources-image-wrapper-hover">
                <?php if ($image_id) { ?>
                    <?php echo wp_get_attachment_image($image_id_hover, 'thumbnail'); ?>
                <?php } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary mm_resources_media_button_hover" id="mm_resources_media_button_hover" name="mm_resources_media_button_hover" value="<?php _e('Add Image Hover', 'mm'); ?>" />
                <input type="button" class="button button-secondary mm_resources_media_remove_hover" id="mm_resources_media_remove_hover" name="mm_resources_media_remove_hover" value="<?php _e('Remove Image Hover', 'mm'); ?>" />
            </p>
        </td>
    </tr>
    <?php
}

function admin_product_resources_output($post) {
    global $wpdb;
    $parents      = $wpdb->get_col( $wpdb->prepare( "SELECT product_id FROM {$wpdb->prefix}wc_booking_relationships WHERE resource_id = %d ORDER BY sort_order;", $post->ID ) );
    $parent_posts = array();
    $i = 1;
    foreach ( $parents as $parent_id ) {
        if ( empty( get_the_title( $parent_id ) ) ) {
            continue;
        }

        $parent_posts[] = '<a href="' . admin_url( 'post.php?post=' . $parent_id . '&action=edit' ) . '">'.$i.'. '.get_the_title( $parent_id ) . '</a>';
        $i++;

    }
    echo $parent_posts ? wp_kses_post( implode( '<br>', $parent_posts ) ) : esc_html__( 'N/A', 'woocommerce-bookings' );
	
}

function icon_resources_save($post_id) {
    if (isset($_POST['icon_resources'])) {
        update_post_meta($post_id, 'icon_resources', $_POST['icon_resources']);
    }
    if (isset($_POST['icon_resources_hover'])) {
        update_post_meta($post_id, 'icon_resources_hover', $_POST['icon_resources_hover']);
    }
}

add_action('save_post', 'icon_resources_save');


add_action('admin_enqueue_scripts', 'load_media');
add_action('admin_footer', 'add_script');

function load_media() {
    wp_enqueue_media();
}

function add_script() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            function mm_media_upload(button_class) {
                var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                $('body').on('click', button_class, function (e) {
                    var button_id = '#' + $(this).attr('id');
                    var send_attachment_bkp = wp.media.editor.send.attachment;
                    var button = $(button_id);
                    _custom_media = true;
                    wp.media.editor.send.attachment = function (props, attachment) {
                        if (_custom_media) {
                            $('#icon_resources').val(attachment.id);
                            $('#resources-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                            $('#resources-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
                        } else {
                            return _orig_send_attachment.apply(button_id, [props, attachment]);
                        }
                    }
                    wp.media.editor.open(button);
                    return false;
                });
            }
            function mm_media_upload_hover(button_class) {
                var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                $('body').on('click', button_class, function (e) {
                    var button_id = '#' + $(this).attr('id');
                    var send_attachment_bkp = wp.media.editor.send.attachment;
                    var button = $(button_id);
                    _custom_media = true;
                    wp.media.editor.send.attachment = function (props, attachment) {
                        if (_custom_media) {
                            $('#icon_resources_hover').val(attachment.id);
                            $('#resources-image-wrapper-hover').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                            $('#resources-image-wrapper-hover .custom_media_image').attr('src', attachment.url).css('display', 'block');
                        } else {
                            return _orig_send_attachment.apply(button_id, [props, attachment]);
                        }
                    }
                    wp.media.editor.open(button);
                    return false;
                });
            }
            mm_media_upload('.mm_resources_media_button.button');
            mm_media_upload_hover('.mm_resources_media_button_hover.button');
            $('body').on('click', '.mm_resources_media_remove', function () {
                $('#icon_resources').val('');
                $('#resources-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            });
            $('body').on('click', '.mm_resources_media_remove_hover', function () {
                $('#icon_resources_hover').val('');
                $('#resources-image-wrapper-hover').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            });
            // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
            $(document).ajaxComplete(function (event, xhr, settings) {
                if (typeof settings.data !== 'undefined') {
                    var queryStringArr = settings.data.split('&');
                }else{
                    var queryStringArr = [];
                }
                if ($.inArray('action=add-tag', queryStringArr) !== -1) {
                    var xml = xhr.responseXML;
                    $response = $(xml).find('term_id').text();
                    if ($response != "") {
                        // Clear the thumb image
                        $('#resources-image-wrapper').html('');
                        $('#resources-image-wrapper-hover').html('');
                    }
                }
            });
        });
    </script>
    <?php
}

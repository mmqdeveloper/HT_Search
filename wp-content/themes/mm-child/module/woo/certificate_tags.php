<?php

function mm_add_certificate_taxonomy_certificate_tag() {

    $labels = array(
        'name' => 'Badge',
        'singular_name' => 'Badge tag',
        'menu_name' => 'Badge',
        'all_items' => 'All Badge tags',
        'parent_item' => 'Parent Badge tag',
        'parent_item_colon' => 'Parent Badge tag:',
        'new_item_name' => 'New Badge tag Name',
        'add_new_item' => 'Add New Badge tag',
        'edit_item' => 'Edit Badge tag',
        'update_item' => 'Update Badge tag',
        'separate_items_with_commas' => 'Separate Badge tag with commas',
        'search_items' => 'Search Badge tags',
        'add_or_remove_items' => 'Add or remove Badge tags',
        'choose_from_most_used' => 'Choose from the most used Badge tags',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'rewrite' => array( 'slug' => '/tours', 'with_front' => false ),
    );
    register_taxonomy('certificates', 'product', $args);
}

add_action('init', 'mm_add_certificate_taxonomy_certificate_tag', 0);

function add_certificate_tag_image_and_contact($taxonomy) {
    ?>
    <div class="form-field term-group">
        <label for="certificate-image-id">Thumbnail</label>
        <input type="hidden" id="certificate-image-id" name="certificate-image-id" class="custom_media_url" value="">
        <div id="category-image-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary certificate_tax_media_button" id="certificate_tax_media_button" name="certificate_tax_media_button" value="Add Image" />
            <input type="button" class="button button-secondary certificate_tax_media_remove" id="certificate_tax_media_remove" name="certificate_tax_media_remove" value="Remove Image" />
        </p>
    </div>
    <h3>Contact info</h3>
    <div class="form-field term-group">
        <label>Phone</label>
        <input type="text" name="certificate_tax_phone" id="certificate_tax_phone" value="">
    </div>
    <div class="form-field term-group">
        <label>Address</label>
        <input type="text" name="certificate_tax_address" id="certificate_tax_address" value="">
    </div>
    <h3>Social</h3>
    <div class="form-field term-group">
        <label>Facebook</label>
        <input type="text" name="certificate_tax_facebook" id="certificate_tax_facebook" value="">
    </div>
    <div class="form-field term-group">
        <label>Instagram</label>
        <input type="text" name="certificate_tax_instagram" id="certificate_tax_instagram" value="">
    </div>
    <div class="form-field term-group">
        <label>Pinterest</label>
        <input type="text" name="certificate_tax_pinterest" id="certificate_tax_pinterest" value="">
    </div>
    <div class="form-field term-group">
        <label>Youtube</label>
        <input type="text" name="certificate_tax_youtube" id="certificate_tax_youtube" value="">
    </div>
    <div class="form-field term-group">
        <label>Twitter</label>
        <input type="text" name="certificate_tax_twitter" id="certificate_tax_twitter" value="">
    </div>
    <?php
}

add_action('certificates_add_form_fields', 'add_certificate_tag_image_and_contact', 10, 2);

add_action('admin_footer', 'add_script_certificate_tag');

function add_script_certificate_tag() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            function certificate_media_upload(button_class) {
                var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                $('body').on('click', button_class, function (e) {
                    var button_id = '#' + $(this).attr('id');
                    var send_attachment_bkp = wp.media.editor.send.attachment;
                    var button = $(button_id);
                    _custom_media = true;
                    wp.media.editor.send.attachment = function (props, attachment) {
                        if (_custom_media) {
                            $('#certificate-image-id').val(attachment.id);
                            $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                            $('#category-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
                        } else {
                            return _orig_send_attachment.apply(button_id, [props, attachment]);
                        }
                    }
                    wp.media.editor.open(button);
                    return false;
                });
            }
            certificate_media_upload('.certificate_tax_media_button.button');
            $('body').on('click', '.certificate_tax_media_remove', function () {
                $('#certificate-image-id').val('');
                $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            });
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
                        $('#category-image-wrapper').html('');
                    }
                }
            });
        });
    </script>
    <?php
}

add_action('created_certificates', 'save_certificate_tag_image_and_contact', 10, 2);

function save_certificate_tag_image_and_contact($term_id, $tt_id) {
    if (isset($_POST['certificate-image-id']) && '' !== $_POST['certificate-image-id']) {
        $image = $_POST['certificate-image-id'];
        add_term_meta($term_id, 'certificate-image-id', $image, true);
    }
    if (isset($_POST['certificate_tax_phone']) && '' !== $_POST['certificate_tax_phone']) {
        add_term_meta($term_id, 'certificate_tax_phone', $_POST['certificate_tax_phone'], true);
    }
    if (isset($_POST['certificate_tax_address']) && '' !== $_POST['certificate_tax_address']) {
        add_term_meta($term_id, 'certificate_tax_address', $_POST['certificate_tax_address'], true);
    }
    if (isset($_POST['certificate_tax_facebook']) && '' !== $_POST['certificate_tax_facebook']) {
        add_term_meta($term_id, 'certificate_tax_facebook', $_POST['certificate_tax_facebook'], true);
    }
    if (isset($_POST['certificate_tax_instagram']) && '' !== $_POST['certificate_tax_instagram']) {
        add_term_meta($term_id, 'certificate_tax_instagram', $_POST['certificate_tax_instagram'], true);
    }
    if (isset($_POST['certificate_tax_pinterest']) && '' !== $_POST['certificate_tax_pinterest']) {
        add_term_meta($term_id, 'certificate_tax_pinterest', $_POST['certificate_tax_pinterest'], true);
    }
    if (isset($_POST['certificate_tax_youtube']) && '' !== $_POST['certificate_tax_youtube']) {
        add_term_meta($term_id, 'certificate_tax_youtube', $_POST['certificate_tax_youtube'], true);
    }
    if (isset($_POST['certificate_tax_twitter']) && '' !== $_POST['certificate_tax_twitter']) {
        add_term_meta($term_id, 'certificate_tax_twitter', $_POST['certificate_tax_twitter'], true);
    }
}

/*
 * Edit the form field
 */
add_action('certificates_edit_form_fields', 'update_certificate_tag_image_and_contact', 10, 2);

function update_certificate_tag_image_and_contact($term, $taxonomy) {
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="certificate-image-id">Thumbnail</label>
        </th>
        <td>
            <?php $image_id = get_term_meta($term->term_id, 'certificate-image-id', true); ?>
            <input type="hidden" id="certificate-image-id" name="certificate-image-id" value="<?php echo $image_id; ?>">
            <div id="category-image-wrapper">
                <?php if ($image_id) { ?>
                    <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                <?php } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary certificate_tax_media_button" id="certificate_tax_media_button" name="certificate_tax_media_button" value="Add Image" />
                <input type="button" class="button button-secondary certificate_tax_media_remove" id="certificate_tax_media_remove" name="certificate_tax_media_remove" value="Remove Image" />
            </p>
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label>Phone</label>
        </th>
        <td>
            <input type="text" id="certificate_tax_phone" name="certificate_tax_phone" value="<?php echo get_term_meta($term->term_id, 'certificate_tax_phone', true); ?>">
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label>Address</label>
        </th>
        <td>
            <input type="text" id="certificate_tax_address" name="certificate_tax_address" value="<?php echo get_term_meta($term->term_id, 'certificate_tax_address', true); ?>">
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label>Facebook</label>
        </th>
        <td>
            <input type="text" id="certificate_tax_facebook" name="certificate_tax_facebook" value="<?php echo get_term_meta($term->term_id, 'certificate_tax_facebook', true); ?>">
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label>Instagram</label>
        </th>
        <td>
            <input type="text" id="certificate_tax_instagram" name="certificate_tax_instagram" value="<?php echo get_term_meta($term->term_id, 'certificate_tax_instagram', true); ?>">
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label>Pinterest</label>
        </th>
        <td>
            <input type="text" id="certificate_tax_pinterest" name="certificate_tax_pinterest" value="<?php echo get_term_meta($term->term_id, 'certificate_tax_pinterest', true); ?>">
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label>Youtube</label>
        </th>
        <td>
            <input type="text" id="certificate_tax_youtube" name="certificate_tax_youtube" value="<?php echo get_term_meta($term->term_id, 'certificate_tax_youtube', true); ?>">
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label>Twitter</label>
        </th>
        <td>
            <input type="text" id="certificate_tax_twitter" name="certificate_tax_twitter" value="<?php echo get_term_meta($term->term_id, 'certificate_tax_twitter', true); ?>">
        </td>
    </tr>
    <?php
}

/*
 * Update the form field value
 */
add_action('edited_certificates', 'updated_certificate_tag_image_and_contact', 10, 2);

function updated_certificate_tag_image_and_contact($term_id, $tt_id) {
    if (isset($_POST['certificate-image-id']) && '' !== $_POST['certificate-image-id']) {
        $image = $_POST['certificate-image-id'];
        update_term_meta($term_id, 'certificate-image-id', $image);
    } else {
        update_term_meta($term_id, 'certificate-image-id', '');
    }
    if (isset($_POST['certificate_tax_phone'])) {
        update_term_meta($term_id, 'certificate_tax_phone', $_POST['certificate_tax_phone']);
    }
    if (isset($_POST['certificate_tax_address'])) {
        update_term_meta($term_id, 'certificate_tax_address', $_POST['certificate_tax_address']);
    }
    if (isset($_POST['certificate_tax_facebook'])) {
        update_term_meta($term_id, 'certificate_tax_facebook', $_POST['certificate_tax_facebook']);
    }
    if (isset($_POST['certificate_tax_instagram'])) {
        update_term_meta($term_id, 'certificate_tax_instagram', $_POST['certificate_tax_instagram']);
    }
    if (isset($_POST['certificate_tax_pinterest'])) {
        update_term_meta($term_id, 'certificate_tax_pinterest', $_POST['certificate_tax_pinterest']);
    }
    if (isset($_POST['certificate_tax_youtube'])) {
        update_term_meta($term_id, 'certificate_tax_youtube', $_POST['certificate_tax_youtube']);
    }
    if (isset($_POST['certificate_tax_twitter'])) {
        update_term_meta($term_id, 'certificate_tax_twitter', $_POST['certificate_tax_twitter']);
    }
}

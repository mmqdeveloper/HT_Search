<?php

/* ----------------------------------------------------//

  This page creates and calls all the function relavent to the
  cutom post meta boxes.

  //---------------------------------------------------------- */
$meta_box['restaurant'] = array(//We create an array called $meta_box and set the array key to the relevant post type
    'id' => 'listing-details', //This is the id applied to the meta box
    'title' => 'Details', //This is the title that appears on the meta box container
    'context' => 'normal', //This defines the part of the page where the edit screen section should be shown
    'priority' => 'high', //This sets the priority within the context where the boxes should show   
    'fields' => array(//Here we define all the fields we want in the meta box
        array(
            'name' => 'Address',
            'desc' => '',
            'id' => 'mm-address',
            'type' => 'text'
        ),
        array(
            'name' => 'Phone',
            'desc' => '',
            'id' => 'mm-phone',
            'type' => 'text'
        ),
        array(
            'name' => 'Email',
            'desc' => '',
            'id' => 'mm-email',
            'type' => 'text'
        ),
        array(
            'name' => 'Facebook',
            'desc' => '',
            'id' => 'mm-facebook',
            'type' => 'text'
        ),
        array(
            'name' => 'Instagram',
            'desc' => '',
            'id' => 'mm-instagram',
            'type' => 'text'
        ),
        array(
            'name' => 'Twitter',
            'desc' => '',
            'id' => 'mm-twitter',
            'type' => 'text'
        ),
        array(
            'name' => 'Tripadvisor',
            'desc' => '',
            'id' => 'mm-tripadvisor',
            'type' => 'text'
        ),
        array(
            'name' => 'Yelp',
            'desc' => '',
            'id' => 'mm-yelp',
            'type' => 'text'
        ),
    )
);
$meta_box['hotel'] = $meta_box['restaurant'];

add_action('admin_menu', 'mm_listing_add_box');

//update_option('meta_boxes', $meta_box);
//Add meta boxes to post types
if (!function_exists('mm_listing_add_box')) {

    function mm_listing_add_box() {
        global $meta_box;
        foreach ($meta_box as $post_type => $value) {
            add_meta_box($value['id'], $value['title'], 'mm_listing_format_box', $post_type, $value['context'], $value['priority']);
        }
    }

}

//Format meta boxes
if (!function_exists('mm_listing_format_box')) {

    function mm_listing_format_box() {
        global $meta_box, $post;

        echo '<input type="hidden" name="mm_listing_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
        foreach ($meta_box[$post->post_type]['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);

            $title = $field['name'];
            echo '<div class="boxes">' .
            '<div class="box-label"><label for="' . $field['id'] . '">' . $title = str_replace("_", " ", $title) . '</label></div>' .
            '<div class="box-content">';
            switch ($field['type']) {
                case 'address':
                    echo '<label for ="' . $field['id'] . '" </label>';
                    echo '<input type="text" name="' . $field['id'] . '" class="' . $field['name'] . '" id="' . $field['id'] . '" value="' . ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />' . '<br />' . $field['desc'];
                    break;
                case 'text':
                    echo '<input ' . $field['disabled'] . ' type="text" maxlength="' . $field['maxlength'] . '" name="' . $field['id'] . '" class="' . $field['name'] . '" id="' . $field['id'] . '" value="' . ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />' . '<br />' . $field['desc'];
                    break;
                case 'date':
                    echo '<input type="text" name="' . $field['id'] . '" class="datepicker  ' . $field['name'] . '" id="' . $field['id'] . '" value="' . ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />' . '<br />' . $field['desc'];
                    break;
                case 'textarea':
                    echo '<textarea ' . $field['disabled'] . ' name="' . $field['id'] . '" id="' . $field['id'] . '" class="' . $field['name'] . '" cols="60" rows="4" style="width:97%">' . ($meta ? $meta : $field['default']) . '</textarea>' . '<br />' . $field['desc'];
                    break;
                case 'select':
                    echo '<select ' . $field['disabled'] . ' name="' . $field['id'] . '" id="' . $field['id'] . '" class="' . $field['name'] . '" style="line-height: 1.2;">';
                    echo '<option value="">--Select--</option>';
                    foreach ($field['options'] as $option => $val) {
                        echo '<option value="' . $option . '" ' . ( $meta == $option ? ' selected="selected"' : '' ) . '>' . $val . '</option>';
                    }
                    echo '</select>';
                    break;
                case 'tagging':
                    echo '<input type="text" name="' . $field['id'] . '" class="' . $field['name'] . '" id="' . $field['id'] . '" value="' . ($meta ? $meta : $field['default']) . '" size="30" style="width:97%" />' . '<br />' . $field['desc'];

                    foreach ($field['options'] as $option) {
                        echo '<div class="tag-click-' . $field['id'] . '" id="' . $option . '">' . $option . ' </div>';
                    }
                    break;

                case 'radio':
                    $i = 0;
                    foreach ($field['options'] as $option) {
                        $i++;
                        echo '<label for ="' . $field['id'] . $i . '">' . $option['name'] . ' </label>';
                        echo '<input type="radio" name="' . $field['id'] . '" value="' . $option['value'] . '"' . ( $meta == $option['value'] ? ' checked="checked"' : '' ) . ' />' . $option['name'];
                    }
                    break;
                case 'checkbox':
                    echo '<div class = "checkboxSlide">';
                    echo '<input type="checkbox" class="' . $field['name'] . '" value="enabled" name="' . $field['id'] . '" id="CheckboxSlide"' . ( $meta ? ' checked="checked"' : $field['default'] ) . ' />';
                    echo '</div>';
                    break;
            }
            echo '</div> </div>';
        }

        echo '<div class="clear"> </div>';
    }

}
// Save data from meta box
if (!function_exists('mm_listing_save_data')) {

    function mm_listing_save_data($post_id) {
        global $meta_box, $post, $wpdb;

        //Verify nonce
        if (!wp_verify_nonce($_POST['mm_listing_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        //Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        //Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        foreach ($meta_box[$post->post_type]['fields'] as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];

            if ($new && $new != $old) {

                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }

    add_action('save_post', 'mm_listing_save_data');
}



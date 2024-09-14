<?php
// Meta box category
// Is show search
if (is_admin()) {
    add_action('product_cat_add_form_fields', 'mmtf_add_product_cat_field_show_search', 10, 2);
    if (!function_exists('mmtf_add_product_cat_field_show_search')) {

        function mmtf_add_product_cat_field_show_search($taxonomy) {
            ?>
                <tr class="form-field">
                    <th>
                        <label>Show search page</label>
                    </th>
                    <td>
                        <div style="margin-bottom:10px;display:flex;align-items:center;">
                            <input name="mmtf_cat_is_show_search" id="mmtf_cat_is_show_search_show" type="radio" value="true" />
                            <label for="mmtf_cat_is_show_search_show">Show</label>
                        </div>
                        <div style="margin-bottom:10px;display:flex;align-items:center;">
                            <input name="mmtf_cat_is_show_search" id="mmtf_cat_is_show_search_not_show" type="radio" value="false" />
                            <label for="mmtf_cat_is_show_search_not_show">Not show</label>
                        </div>
                    </td>
                </tr>
            <?php
        }
    }

    if (!function_exists('mmtf_product_cat_show_search')) {
        add_action('product_cat_edit_form_fields', 'mmtf_product_cat_show_search', 10, 2);
        function mmtf_product_cat_show_search($term, $taxonomy) {
            $mmtf_cat_is_show_search = get_term_meta($term->term_id, 'mmtf_cat_is_show_search', true);
            echo '<tr class="form-field">
            <th>
                <label>Show search page</label>
            </th>
            <td>
                <div style="margin-bottom: 10px;">
                    <input name="mmtf_cat_is_show_search" id="mmtf_cat_is_show_search_show" type="radio" value="true" '. ($mmtf_cat_is_show_search == 'true' ? 'checked' : '') .' />
                    <label for="mmtf_cat_is_show_search_show">Show</label>
                </div>
                <div>
                    <input name="mmtf_cat_is_show_search" id="mmtf_cat_is_show_search_not_show" type="radio" value="false" '. (($mmtf_cat_is_show_search == 'false' || empty($mmtf_cat_is_show_search)) ? 'checked' : '') .' />
                    <label for="mmtf_cat_is_show_search_not_show">Not show</label>
                </div>
            </td>
            </tr>';
        }
    }

    if (!function_exists('mmtf_product_cat_save_term_fields_is_show_search')) {
        add_action('created_product_cat', 'mmtf_product_cat_save_term_fields_is_show_search');
        add_action('edited_product_cat', 'mmtf_product_cat_save_term_fields_is_show_search');
        function mmtf_product_cat_save_term_fields_is_show_search($term_id) {
            global $pagenow;
            $is_show_search = '';
            if($pagenow != 'post.php'){
                $is_show_search = sanitize_text_field($_POST['mmtf_cat_is_show_search']);
            }
            update_term_meta($term_id, 'mmtf_cat_is_show_search', $is_show_search);
        }
    }

    // Is icon search
    add_action('product_cat_add_form_fields', 'mmtf_add_product_cat_field_icon_search', 10, 2);
    if (!function_exists('mmtf_add_product_cat_field_icon_search')) {

        function mmtf_add_product_cat_field_icon_search($taxonomy) {
            ?>
                <tr class="form-field">
                    <th>
                        <label>Icon search</label>
                    </th>
                    <td>
                        <input type="hidden" name="mmtf_icon_search" id="mmtf_icon_search" value="' . esc_attr($mmtf_icon_search) . '" size="30" />
                        <div id="mmtf_icon_search_preview" style="width:60px;height:60px;margin-bottom:10px;">
                            <img src="/wp-content/uploads/woocommerce-placeholder-450x338.png" style="width:100%;height:100%;" />
                        </div>
                        <input type="button" id="mmtf_select_icon_search" class="button" value="Select icon" style="margin-bottom:10px;" />
                    </td>
                </tr>
                <script>
                    jQuery(document).ready(function($){
                        $("#mmtf_select_icon_search").click(function() {
                            let custom_uploader = wp.media({
                                title: "Select icon",
                                button: {
                                    text: "Select icon"
                                },
                                multiple: false
                            });

                            custom_uploader.on("select", function() {
                                let attachment = custom_uploader.state().get("selection").first().toJSON();
                                $("#mmtf_icon_search").val(attachment.url);
                                $("#mmtf_icon_search_preview").html("<img src=\'" + attachment.url + "\' style=\'width:100%;height:100%;\' />");
                            });

                            custom_uploader.open();
                        });
                    });
                </script>
            <?php
        }
    }

    if (!function_exists('mmtf_product_cat_icon_search')) {
        add_action('product_cat_edit_form_fields', 'mmtf_product_cat_icon_search', 10, 2);
        function mmtf_product_cat_icon_search($term, $taxonomy) {
            $mmtf_icon_search = get_term_meta($term->term_id, 'mmtf_icon_search', true);
            echo '<tr class="form-field">
                <th>
                    <label>Icon search</label>
                </th>
                <td>
                    <input type="hidden" name="mmtf_icon_search" id="mmtf_icon_search" value="' . esc_attr($mmtf_icon_search) . '" size="30" />
                    <div id="mmtf_icon_search_preview" style="width:60px;height:60px;margin-bottom:10px;">
                        <img src="' . (esc_attr($mmtf_icon_search) ? esc_attr($mmtf_icon_search) : "/wp-content/uploads/woocommerce-placeholder-450x338.png") . '" style="width:100%;height:100%;" />
                    </div>
                    <input type="button" id="mmtf_select_icon_search" class="button" value="Select icon" />
                </td>
            </tr>';
            echo '<script>
                jQuery(document).ready(function($){
                    $("#mmtf_select_icon_search").click(function() {
                        let custom_uploader = wp.media({
                            title: "Select icon",
                            button: {
                                text: "Select icon"
                            },
                            multiple: false
                        });

                        custom_uploader.on("select", function() {
                            let attachment = custom_uploader.state().get("selection").first().toJSON();
                            $("#mmtf_icon_search").val(attachment.url);
                            $("#mmtf_icon_search_preview").html("<img src=\'" + attachment.url + "\' style=\'width:100%;height:100%;\' />");
                        });

                        custom_uploader.open();
                    });
                });
            </script>';
        }
    }

    if (!function_exists('mmtf_product_cat_save_term_fields_icon_search')) {
        add_action('created_product_cat', 'mmtf_product_cat_save_term_fields_icon_search');
        add_action('edited_product_cat', 'mmtf_product_cat_save_term_fields_icon_search');
        function mmtf_product_cat_save_term_fields_icon_search($term_id) {
            global $pagenow;
            $icon_search = '';
            if($pagenow != 'post.php'){
                $icon_search = sanitize_text_field($_POST['mmtf_icon_search']);
            }
            update_term_meta($term_id, 'mmtf_icon_search', $icon_search);
        }
    }

    // Priority
    add_action('product_cat_add_form_fields', 'mmtf_add_product_cat_field_search_priority', 10, 2);
    if (!function_exists('mmtf_add_product_cat_field_search_priority')) {

        function mmtf_add_product_cat_field_search_priority($taxonomy) {
            ?>
                <tr class="form-field" style="margin-bottom:10px;">
                    <th>
                        <label>Search priority</label>
                    </th>
                    <td>
                        <input type="text" name="mmtf_search_priority" id="mmtf_search_priority" value="" style="width: 80px;" />
                        <p class="description">Ex: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10</p>
                    </td>
                </tr>
            <?php
        }
    }

    if (!function_exists('mmtf_product_cat_search_priority')) {
        add_action('product_cat_edit_form_fields', 'mmtf_product_cat_search_priority', 10, 2);
        function mmtf_product_cat_search_priority($term, $taxonomy) {
            $mmtf_search_priority = get_term_meta($term->term_id, 'mmtf_search_priority', true);
            echo '<tr class="form-field">
                <th>
                    <label>Search priority</label>
                </th>
                <td>
                    <input type="text" name="mmtf_search_priority" id="mmtf_search_priority" value="' . esc_attr($mmtf_search_priority) . '" style="width: 80px;" />
                    <p class="description">Ex: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10</p>
                </td>
            </tr>';
        }
    }

    if (!function_exists('mmtf_product_cat_save_term_fields_search_priority')) {
        add_action('created_product_cat', 'mmtf_product_cat_save_term_fields_search_priority');
        add_action('edited_product_cat', 'mmtf_product_cat_save_term_fields_search_priority');
        function mmtf_product_cat_save_term_fields_search_priority($term_id) {
            global $pagenow;
            $search_priority = '';
            if($pagenow != 'post.php'){
                $search_priority = sanitize_text_field($_POST['mmtf_search_priority']);
            }
            update_term_meta($term_id, 'mmtf_search_priority', $search_priority);
        }
    }

    // Time of Day Field
    if (
        !function_exists('mm_add_meta_box_time_of_day_for_product' )
        &&
        !function_exists('mm_save_time_of_day_product_meta_box_data' )
    ) {
        add_action('woocommerce_product_options_general_product_data', 'mm_add_meta_box_time_of_day_for_product', 9);
        add_action('woocommerce_process_product_meta', 'mm_save_time_of_day_product_meta_box_data');
        function mm_add_meta_box_time_of_day_for_product() {
            global $post;
            $time_of_day_val = get_post_meta($post->ID, '_mm_time_of_day', true);
            woocommerce_wp_select(array(
                'id' => '_mm_time_of_day',
                'label' => 'Time of day',
                'value' => $time_of_day_val,
                'options'     => array(
                    ''        => __( 'Select time of day', 'woocommerce' ),
                    '6am-12pm'    => __('6AM - 12PM', 'woocommerce' ),
                    '12pm-5pm' => __('12PM - 5PM', 'woocommerce' ),
                    '5pm-12am' => __('5PM - 12AM', 'woocommerce' ),
                    '5am-12am' => __('5AM - 12AM', 'woocommerce' ),
                    '12am-5am' => __('12AM - 5AM', 'woocommerce' ),
                )
            ));
        }
        function mm_save_time_of_day_product_meta_box_data($post_id) {
            if (!current_user_can('edit_post', $post_id)) return;
            $time_of_day_val = sanitize_text_field($_POST['_mm_time_of_day']);
            update_post_meta($post_id, '_mm_time_of_day', $time_of_day_val);
        }    
    }
}

// assign search permission to relevanssi
add_filter( 'relevanssi_search_ok', function( $ok, $query ) {
    if (  !$query->is_admin && ! empty( $query->query_vars['s'] ) ) {
        $ok = true;
    }
    return $ok;
}, 10, 2 );
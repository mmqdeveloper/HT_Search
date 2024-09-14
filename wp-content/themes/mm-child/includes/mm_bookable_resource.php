<?php
add_action("manage_bookable_resource_posts_custom_column", "bookable_resource_custom_columns");
add_filter("manage_edit-bookable_resource_columns", "bookable_resource_edit_columns");

function bookable_resource_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Title",
        "available" => "Available Quantity",
        "image" => "Image Resources",
        "imagehv" => "Image Hover",
        "date" => "Date",
        "used" => "Used",
        "location" => "Locations",
        "vendor" => "Vendor",
        "tour_type" => "Tour Type"
    );

    return $columns;
}

function bookable_resource_custom_columns($column) {

    global $post, $wpdb;

    switch ($column) {
        case "image":
            $idimage = get_post_meta(get_the_ID(), 'icon_resources', true);
            $url = wp_get_attachment_thumb_url($idimage);
            echo '<img src="' . $url . '" style="max-width: 100px;">';
            break;
        case "imagehv":
            $idimagehv = get_post_meta(get_the_ID(), 'icon_resources_hover', true);
            $urlhv = wp_get_attachment_thumb_url($idimagehv);
            echo '<img src="' . $urlhv . '" style="max-width: 100px;">';
            break;
        case "available":
            $qty = get_post_meta(get_the_ID(), 'qty', true);
            echo $qty;
            break;
        case "used":
            $parents = $wpdb->get_col($wpdb->prepare("SELECT product_id FROM {$wpdb->prefix}wc_booking_relationships WHERE resource_id = %d ORDER BY sort_order;", $post->ID));
            $parent_posts = array();
            $i = 1;
            foreach ($parents as $parent_id) {
                if (empty(get_the_title($parent_id))) {
                    continue;
                }

                $parent_posts[] = '<a href="' . admin_url('post.php?post=' . $parent_id . '&action=edit') . '">' . $i . '. ' . get_the_title($parent_id) . '</a>';
                $i++;
            }
            echo $parent_posts ? wp_kses_post(implode('<br>', $parent_posts)) : esc_html__('N/A', 'woocommerce-bookings');
            break;
        case "location":
            $location = get_post_meta(get_the_ID(), '_wc_booking_location', true);
            echo $location;
            break;
        case "vendor":
            $vendor = get_post_meta(get_the_ID(), 'mm_resource_vendor', true);
            echo $vendor;
            break;
        case "tour_type":
            $tour_type = get_post_meta($post->ID, 'resource_tour_type', true);
            echo $tour_type;
            break;
    }
}

add_action('quick_edit_custom_box', 'hwtbr_add_quick_edit', 10, 2);

function hwtbr_add_quick_edit($column_name, $post_type) {
    if ($column_name != 'available')
        return;
    ?>
    <label>Available Quantity</label>
    <input type="hidden" name="qty_noncename" id="qty_noncename" value="" />
    <input type="number" id="quantity" name="qty" min="1" value="<?php echo get_post_meta(get_the_ID(), 'qty', true); ?>">

    <?php
}

add_action('quick_edit_custom_box', 'hwtbr_add_quick_tour_type_edit', 11, 2);

function hwtbr_add_quick_tour_type_edit($column_name, $tour_type) {
    if ($column_name != 'tour_type')
        return;
    ?>
    <label>
        <span class="title">Tour Type</span>
        <span class="input-text-wrap">
        <select name="resource_tour_type" id="resource_tour_type">
            <option value="" >Not Set</option>
            <option value="Self-Guided" >Self-Guided</option>
            <option value="Guided" >Guided</option>
        </select>
        </span>
    </label>
    <?php
}


add_action('save_post', 'qty_save_quick_edit_data');

function qty_save_quick_edit_data($post_id) {
    // verify if this is an auto save routine.         
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // Check permissions     
    if ('bookable_resource' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
    }
    // Authentication passed now we save the data       
    if (isset($_POST['qty']) && ($post->post_type != 'revision')) {
        $qty_fieldvalue = esc_attr($_POST['qty']);
        if ($qty_fieldvalue)
            update_post_meta($post_id, 'qty', $qty_fieldvalue);
        else
            delete_post_meta($post_id, 'qty');
    }
    if (isset($_POST['resource_tour_type']) && ($_POST['post_type'] != 'revision')) {
        $resource_tour_type = esc_attr($_POST['resource_tour_type']);
        update_post_meta($post_id, 'resource_tour_type', $resource_tour_type);
    }
    return $qty_fieldvalue;
}

add_action('admin_footer', 'hwt_quick_edit_javascript');

function hwt_quick_edit_javascript() {
    global $current_screen;
    if (($current_screen->post_type != 'bookable_resource'))
        return;
    ?>
    <script type="text/javascript">
        function set_qtyfield_value(fieldValue, nonce) {
            // refresh the quick menu properly
            inlineEditPost.revert();
            console.log(fieldValue);
            jQuery('#quantity').val(fieldValue);
        }
        function et_tourtype_value(tourType) {
            inlineEditPost.revert();
            jQuery('#resource_tour_type option').removeAttr('selected');
            jQuery('#resource_tour_type').val(tourType);
            jQuery('#resource_tour_type option[value="' + tourType + '"]').attr('selected', 'selected');
        }
        
    </script>
    <?php
}

add_filter('post_row_actions', 'hwt_expand_quick_edit_link', 10, 2);

function hwt_expand_quick_edit_link($actions, $post) {
    unset($actions['inline']);
    $nonce = wp_create_nonce('qty_' . $post->ID);
    $qtyfielvalue = get_post_meta($post->ID, 'qty', TRUE);
    $tour_type = get_post_meta($post->ID, 'resource_tour_type', true);
    $actions['inline hide-if-no-js'] = '<button type="button" class="button-link editinline" title="';
    $actions['inline hide-if-no-js'] .= esc_attr(__('Edit this item inline')) . '"';
    $actions['inline hide-if-no-js'] .= " onclick=\"set_qtyfield_value('{$qtyfielvalue}'); et_tourtype_value('{$tour_type}');\">";
    $actions['inline hide-if-no-js'] .= __('Quick Edit');
    $actions['inline hide-if-no-js'] .= '</button>';
    return $actions;
}

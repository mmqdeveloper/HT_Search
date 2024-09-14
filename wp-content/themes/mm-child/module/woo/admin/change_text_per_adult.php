<?php
if(!function_exists('mm_woocommerce_bookings_change_text_per_person')){
    function mm_woocommerce_bookings_change_text_per_person($resource_id) {
        global $post;
        $post_id = $post->ID;
        $per_person = '';
        $mm_change_text_per_person = get_post_meta($post_id, 'mm_change_text_per_person',true);
        $dataArray = array();
        if (!empty($mm_change_text_per_person) && !empty(unserialize($mm_change_text_per_person))) {
            $dataArray = unserialize($mm_change_text_per_person);
            if(isset($dataArray[$resource_id])){
                $per_person = $dataArray[$resource_id];
            }
        }
        $calculate_by_group = '';
        $mm_calculate_by_group = get_post_meta($post_id, 'mm_calculate_by_group',true);
        $dataArray_group = array();
        if (!empty($mm_calculate_by_group) && !empty(unserialize($mm_calculate_by_group))) {
            $dataArray_group = unserialize($mm_calculate_by_group);
            if(isset($dataArray_group[$resource_id])){
                $calculate_by_group = $dataArray_group[$resource_id];
            }
        }
        ob_start();
        ?>
        <tr>
            <td>
                <label><?php _e('Change Text Per Person', 'woocommerce-bookings'); ?>:</label>
                <input type="text" class="text_per_person" name="text_per_person[<?php echo $resource_id; ?>]" value="<?php echo $per_person;?>" />
            </td>
            <td>
                <label style=" display: inline-block; padding-top: 25px;"><?php _e('Calculate cost by per group', 'woocommerce-bookings'); ?>:</label>
                <input type="checkbox" class="calculate_by_group" name="calculate_by_group[<?php echo $resource_id; ?>]" value="yes" <?php if ($calculate_by_group == 'yes') echo "checked"; ?> style="width: auto; min-width: 15px; float: none; display: inline-block; margin-top: 25px;"/>
            </td>
            <td>
            </td>
        </tr>
        <?php
        $html = ob_get_clean();
        echo $html;
    }
}
add_action('woocommerce_bookings_after_resource_block_cost', 'mm_woocommerce_bookings_change_text_per_person', 10);

add_action('save_post', 'mm_woocommerce_bookings_save_change_text_per_person');
if (!function_exists('mm_woocommerce_bookings_save_change_text_per_person')) {

    function mm_woocommerce_bookings_save_change_text_per_person($post_id) {
        if ( get_post_type( $post_id ) == 'product' ) {
            //Check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
            if (isset($_POST['text_per_person'])) {
                update_post_meta($post_id, 'mm_change_text_per_person', serialize($_POST['text_per_person']));
            }
            if (isset($_POST['calculate_by_group'])) {
                update_post_meta($post_id, 'mm_calculate_by_group', serialize($_POST['calculate_by_group']));
            }else{
                delete_post_meta($post_id, 'mm_calculate_by_group');
            }
        }
    }

}
<?php

function mm_woocommerce_bookings_add_default_person($person_id) {
    global $post;
    $post_id = $post->ID;
    $person_default = '';
    $person_tooltip = '';
    $mm_person_default = get_post_meta($post_id, 'mm_person_default',true);
    $mm_person_tooltip = get_post_meta($post_id, 'mm_person_tooltip',true);
    $dataArray = array();
    if (!empty($mm_person_default) && !empty(unserialize($mm_person_default))) {
        $dataArray = unserialize($mm_person_default);
        if(isset($dataArray[$person_id])){
            $person_default = $dataArray[$person_id];
        }
    }
    if (!empty($mm_person_tooltip) && !empty(unserialize($mm_person_tooltip))) {
        $dataArrayt = unserialize($mm_person_tooltip);
        if(isset($dataArrayt[$person_id])){
            $person_tooltip = $dataArrayt[$person_id];
        }
    }
    $person_min_age = '';
    $person_max_age = '';
    $mm_person_age = get_post_meta($post_id, 'mm_person_age',true);
    if (!empty($mm_person_age) && !empty(unserialize($mm_person_age))) {
        $dataArray_age = unserialize($mm_person_age);
        if(isset($dataArray_age[$person_id])){
            foreach ($dataArray_age[$person_id] as $key => $person_age) {
                if($key == 'min'){
                    $person_min_age = $person_age;
                }
                if($key == 'max'){
                    $person_max_age = $person_age;
                }
            }
            
        }
    }
    ob_start();
    ?>
    <tr>
        <td>
        <label><?php _e('Tooltip', 'woocommerce-bookings'); ?>:</label>
            <input type="text" class="person_tooltip" name="person_tooltip[<?php echo $person_id; ?>]" value="<?php echo $person_tooltip;?>" />
        </td>
        <td>
        <label><?php _e('Default', 'woocommerce-bookings'); ?>:</label>
            <input type="number" class="person_default" name="person_default[<?php echo $person_id; ?>]" value="<?php echo $person_default;?>" />
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
        <label><?php _e('Min Age', 'woocommerce-bookings'); ?>:</label>
            <input type="number" class="person_age" name="person_age[<?php echo $person_id; ?>][min]" value="<?php echo $person_min_age;?>" />
        </td>
        <td>
        <label><?php _e('Max Age', 'woocommerce-bookings'); ?>:</label>
            <input type="number" class="person_age" name="person_age[<?php echo $person_id; ?>][max]" value="<?php echo $person_max_age;?>" />
        </td>
        <td>
        </td>
    </tr>
    <?php
    $html = ob_get_clean();
    echo $html;
}

add_action('woocommerce_bookings_after_person_max_column', 'mm_woocommerce_bookings_add_default_person', 10);

add_action('save_post', 'mm_woocommerce_bookings_save_default_person');
if (!function_exists('mm_woocommerce_bookings_save_default_person')) {

    function mm_woocommerce_bookings_save_default_person($post_id) {
        if ( get_post_type( $post_id ) == 'product' ) {
            //Check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
            if (isset($_POST['person_default'])) {
                update_post_meta($post_id, 'mm_person_default', serialize($_POST['person_default']));
            }
            if (isset($_POST['person_tooltip'])) {
                $person_tooltip = array();
                foreach ($_POST['person_tooltip'] as $key=>$value){
                    $person_tooltip[$key] = stripslashes($value);
                }
                update_post_meta($post_id, 'mm_person_tooltip', serialize($person_tooltip));
            }
            if (isset($_POST['person_age'])) {
                update_post_meta($post_id, 'mm_person_age', serialize($_POST['person_age']));
            }
        }
    }

}
<?php

// Check if the array is sequential or not
if (!function_exists('mm_tracking_log_is_sequential_array')) {
    function mm_tracking_log_is_sequential_array($arr) {
        if (!is_array($arr)) {
            return false;
        }
        $keys = array_keys($arr);
        return $keys === range(0, count($arr) - 1);
    }
}

// Check if the current role is in role tracking or not
if (!function_exists('mm_tracking_log_edit_check_role')) {
    function mm_tracking_log_edit_check_role ($roles_current, $roles_tracking) {
        foreach ($roles_current as $role_current) {
            foreach ($roles_tracking as $role_tracking) {
                if ($role_current == $role_tracking) {
                    return true;
                }
            }
        }
        return false;
    }
}

// Create page settings
if (!function_exists('mm_setting_tracking_log_edit')) {
    function mm_setting_tracking_log_edit() {
        add_submenu_page(
            'maui-marketing-menu',
            'MM Settings Tracking Log',
            'MM Tracking Log',
            'manage_options',
            'mm-settings-tracking-log', 
            'mm_setting_tracking_log_edit_func'
        );
    }
    add_action('admin_menu', 'mm_setting_tracking_log_edit');
}

// Layout page settings tracking log
if (!function_exists('mm_setting_tracking_log_edit_func')) {
    function mm_setting_tracking_log_edit_func() {
        global $wp_roles;

        $post_types = get_post_types(array(
            'public'   => true
        ));

        $roles = $wp_roles->roles;

        $post_type_exception = array(
            'attachment',
            'goon_group',
            'goon_filter',
            'avia_framework_post'
        );

        foreach($post_type_exception as $exception) {
            unset($post_types[$exception]);
        }

        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/configs.json";

        $json_data = file_get_contents($file_path);
        $data_decode = json_decode($json_data, true);
        
        ?>
        <style>
            .notice.notice-warning {
                display: none;
            } 
            #mm_setting_tracking_log_notification {
                margin-top: 10px;
                width: max-content;
            }
        </style>
        <div class="wrap">
            <h2 style="margin-bottom: 20px";>MM Settings Tracking Log</h2>
            <div class="mm_setting_tracking_log_wrap_checkbox">
                <form id="mm_setting_tracking_log_form">
                    <h3>Show a note popup when saving</h3>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_show_popup_note_yes" name="mm_setting_tracking_log_show_popup_note" value="yes" <?php echo(($data_decode['is_popup'] == 'yes') ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_show_popup_note_yes">Yes</label>
                    </div>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_show_popup_note_no" name="mm_setting_tracking_log_show_popup_note" value="no" <?php echo(($data_decode['is_popup'] == 'no' || empty($data_decode['is_popup'])) ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_show_popup_note_no">No</label>
                    </div>
                    <h3>Select the post type you want to tracking</h3>
                    <?php
                        if (!empty($post_types)) {
                            foreach($post_types as $key => $post_type) {
                                $post_type_object = get_post_type_object($key);
                                $post_type_name = $post_type_object->labels->name;
                                ?>
                                    <div style="margin-bottom: 10px";>
                                        <input type="checkbox" id="<?php echo $key; ?>" name="mm_setting_tracking_log_post_type" value="<?php echo $key; ?>" <?php echo(in_array($key, $data_decode['post_type']) ? 'checked' : ''); ?>>
                                        <label for="<?php echo $key; ?>"><?php echo $post_type_name; ?></label>
                                    </div>
                                <?php
                            }
                        }
                    ?>
                    <h3>Select the roles you want to tracking</h3>
                    <?php
                        if (!empty($roles)) {
                            foreach($roles as $key => $role) {
                                $role_name = $role['name'];
                                ?>
                                    <div style="margin-bottom: 10px";>
                                        <input type="checkbox" id="<?php echo $key; ?>" name="mm_setting_tracking_log_roles" value="<?php echo $key; ?>" <?php echo(in_array($key, $data_decode['roles']) ? 'checked' : ''); ?>>
                                        <label for="<?php echo $key; ?>"><?php echo $role_name; ?></label>
                                    </div>
                                <?php
                            }
                        }
                    ?>
                    <h3>Tracking product add-on</h3>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_product_addon_yes" name="mm_setting_tracking_log_product_addon" value="yes" <?php echo(($data_decode['product_add_on'] == 'yes') ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_product_addon_yes">Yes</label>
                    </div>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_product_addon_no" name="mm_setting_tracking_log_product_addon" value="no" <?php echo(($data_decode['product_add_on'] == 'no' || empty($data_decode['product_add_on'])) ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_product_addon_no">No</label>
                    </div>
                    <h3>Tracking theme options <a target="_blank" href="/wp-admin/admin.php?page=mm-tracking-view-log-theme-options">View Logs</a></h3>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_theme_options_yes" name="mm_setting_tracking_log_theme_options" value="yes" <?php echo(($data_decode['theme_options'] == 'yes') ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_theme_options_yes">Yes</label>
                    </div>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_theme_options_no" name="mm_setting_tracking_log_theme_options" value="no" <?php echo(($data_decode['theme_options'] == 'no' || empty($data_decode['theme_options'])) ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_theme_options_no">No</label>
                    </div>
                    <h3>Tracking resource</h3>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_resource_yes" name="mm_setting_tracking_log_resource" value="yes" <?php echo(($data_decode['resource'] == 'yes') ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_resource_yes">Yes</label>
                    </div>
                    <div style="margin-bottom: 10px";>
                        <input type="radio" id="mm_setting_tracking_log_resource_no" name="mm_setting_tracking_log_resource" value="no" <?php echo(($data_decode['resource'] == 'no' || empty($data_decode['resource'])) ? 'checked' : ''); ?>>
                        <label for="mm_setting_tracking_log_resource_no">No</label>
                    </div>
                    <input type="submit" class="button button-primary" value="Save">
                </form>
                <div id="mm_setting_tracking_log_notification"></div>
            </div>
        </div>
        <?php
    }
}

// Save setting tracking log
if (!function_exists('mm_save_setting_tracking_log')) {
    add_action('wp_ajax_mm_save_setting_tracking_log', 'mm_save_setting_tracking_log');
    add_action('wp_ajax_nopriv_mm_save_setting_tracking_log', 'mm_save_setting_tracking_log'); 
    function mm_save_setting_tracking_log () {
        if ($_POST['action'] == 'mm_save_setting_tracking_log') {
            $post_type_selected = $_POST['postTypeSelected'];
            $show_popup_note = $_POST['showPopupNote'];
            $roles_selected = $_POST['rolesSelected'];
            $product_add_on = $_POST['productAddon'];
            $theme_options = $_POST['themeOptions'];
            $resource = $_POST['resource'];
            $upload_dir = wp_upload_dir();
            $data = array(
                'post_type' => $post_type_selected,
                'is_popup' => $show_popup_note,
                'roles' => $roles_selected,
                'product_add_on' => $product_add_on,
                'theme_options' => $theme_options,
                'resource' => $resource
            );
        
            $directory = $upload_dir['basedir'] . '/mm_tracking_edit_log';
            if (!file_exists($directory)) {
                wp_mkdir_p($directory);
            }

            $file_path = $directory . "/configs.json";

            file_put_contents($file_path, json_encode($data));
        }
    }
}

// Save note before update
if (!function_exists('mm_save_tracking_log_note')) {
    add_action('wp_ajax_mm_save_tracking_log_note', 'mm_save_tracking_log_note');
    add_action('wp_ajax_nopriv_mm_save_tracking_log_note', 'mm_save_tracking_log_note'); 
    function mm_save_tracking_log_note () {
        if ($_POST['action'] == 'mm_save_tracking_log_note') {
            $mm_tracking_log_note = $_POST['mm_tracking_log_note'];
            $mm_tracking_log_note_id_post = $_POST['mm_tracking_log_note_id_post'];
            update_post_meta($mm_tracking_log_note_id_post, 'mm_tracking_log_note', $mm_tracking_log_note);
        }
    }
}

// Save data before change
if (!function_exists('mm_previous_save_tracking_log_data')) {
    add_action('pre_post_update', 'mm_previous_save_tracking_log_data', 10, 2);
    function mm_previous_save_tracking_log_data($post_id, $data) {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/configs.json";

        $current_user = wp_get_current_user();

        $data_decode = array();
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_decode = json_decode($json_data, true);
        }

        if (!mm_tracking_log_edit_check_role($current_user->roles, $data_decode['roles'])) {
            return;
        }

        $tracking_addon = false;
        $tracking_resource = false;

        if (get_post_type($post_id) == 'tm_global_cp' && $data_decode['product_add_on'] == 'yes') {
            $tracking_addon = true;
        }

        if (get_post_type($post_id) == 'bookable_resource' && $data_decode['resource'] == 'yes') {
            $tracking_resource = true;
        }

        if (!in_array(get_post_type($post_id), $data_decode['post_type']) && !$tracking_addon && !$tracking_resource) {
            return;
        }

        if (defined('MM_PRE_POST_UPDATE_RUNNING')) {
            return;
        }

        define('MM_PRE_POST_UPDATE_RUNNING', true);

        $previous_taxonomies = array();
        $taxonomies = get_post_taxonomies($post_id);
        foreach($taxonomies as $val) {
            $previous_taxonomies_terms = wp_get_post_terms($post_id, $val, array('fields' => 'names'));
            $previous_taxonomies[$val] = $previous_taxonomies_terms;
        }

        $previous_post = get_post($post_id, ARRAY_A);
        unset($previous_post['post_modified']);
        unset($previous_post['post_modified_gmt']);
        unset($previous_post['post_date']);

        $previous_meta = get_post_meta($post_id);
        $previous_meta_handle = array();
        if (is_array($previous_meta)) {
            foreach($previous_meta as $key => $val) {
                $previous_meta_handle[$key] = $val[0];
            }
        }

        foreach($previous_post as $key => $val) {
            $previous_meta_handle[$key] = $val;
        }

        foreach($previous_taxonomies as $key => $val) {
            $previous_meta_handle[$key] = $val;
        }

        update_post_meta($post_id, '_mm_previous_meta', $previous_meta_handle);
    }
}

// Check if the data is serialized or not
if (!function_exists('mm_tracking_log_is_serialized')) {
    function mm_tracking_log_is_serialized($data) {
        $unserialized = @unserialize($data);
        return ($unserialized !== false || $data === 'b:0;');
    }
}

if (!function_exists('mm_tracking_log_get_ip_client')) {
    function mm_tracking_log_get_ip_client () {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'Unknown';
        return $ipaddress;
    }
}

if (!function_exists('mm_tracking_log_get_os')) {
    function mm_tracking_log_get_os() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $osPlatform = "Unknown";
    
        $osArray = [
            '/windows nt 11/i'      =>  'Windows 11',
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        ];
    
        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $osPlatform = $value;
            }
        }
    
        return $osPlatform;
    }
}

if (!function_exists('mm_tracking_log_get_browser_info')) {
    function mm_tracking_log_get_browser_info () {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser        = "Unknown";
        $browser_array  = array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/edge/i'       =>  'Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );

        foreach ( $browser_array as $regex => $value ) { 
            if ( preg_match( $regex, $user_agent ) ) {
                $browser = $value;
            }
        }
        return $browser;
    }
}

// Check data before and after updating to save log
if (!function_exists('mm_tracking_log_changes')) {
    add_action('save_post', 'mm_tracking_log_changes', 10, 3);
    function mm_tracking_log_changes($post_id, $post, $update) {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/configs.json";
        $data_decode = array();
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_decode = json_decode($json_data, true);
        }

        $current_user = wp_get_current_user();

        if (!mm_tracking_log_edit_check_role($current_user->roles, $data_decode['roles'])) {
            return;
        }

        $tracking_addon = false;
        $tracking_resource = false;

        if ($post->post_type == 'tm_global_cp' && $data_decode['product_add_on'] == 'yes') {
            $tracking_addon = true;
        }

        if ($post->post_type == 'bookable_resource' && $data_decode['resource'] == 'yes') {
            $tracking_resource = true;
        }

        if (!in_array($post->post_type, $data_decode['post_type']) && !$tracking_addon && !$tracking_resource) {
            return;
        }

        if (defined('MM_PRE_POST_UPDATE_RUNNING_SAVE')) {
            return;
        }

        define('MM_PRE_POST_UPDATE_RUNNING_SAVE', true);

        $data_post_after = get_post($post_id, ARRAY_A);

        unset($data_post_after['post_modified']);
        unset($data_post_after['post_modified_gmt']);
        unset($data_post_after['post_date']);

        $data_before = get_post_meta($post_id, '_mm_previous_meta', true);

        // product builder acf
        if ($data_before['mm_builder'] == 'activate' || $tracking_resource == true) {
            foreach($data_before as $key => $val) {
                $key_acf = $data_before['_'.$key];
                if ($key_acf) {
                    unset($data_before['_'.$key]);
                    $data_before[$key_acf] = $val;
                    unset($data_before[$key]);
                }
            }
        }

        $data_after = array();

        $post_global_meta = array();

        $_wc_booking_availability = array();
        if (is_array($_POST['wc_booking_availability_type']) && count($_POST['wc_booking_availability_type']) > 0) {
            foreach($_POST['wc_booking_availability_type'] as $key => $val) {
                $_wc_booking_availability[$key] = array(
                    'type' => $_POST['wc_booking_availability_type'][$key],
                    'bookable' => $_POST['wc_booking_availability_bookable'][$key],
                    'priority' => (int)$_POST['wc_booking_availability_priority'][$key],
                    'sale_agent' => NULL,
                );
                if ($_POST['wc_booking_availability_type'][$key] == 'time') {
                    $_wc_booking_availability[$key]['from'] = $_POST['wc_booking_availability_from_time'][$key];
                    $_wc_booking_availability[$key]['to'] = $_POST['wc_booking_availability_to_time'][$key];
                }
                if ($_POST['wc_booking_availability_type'][$key] == 'date') {
                    $_wc_booking_availability[$key]['from'] = $_POST['wc_booking_availability_from_date'][$key];
                    $_wc_booking_availability[$key]['to'] = $_POST['wc_booking_availability_to_date'][$key];
                }
                if ($_POST['wc_booking_availability_type'][$key] == 'week') {
                    $_wc_booking_availability[$key]['from'] = $_POST['wc_booking_availability_from_week'][$key];
                    $_wc_booking_availability[$key]['to'] = $_POST['wc_booking_availability_to_week'][$key];
                }
                if ($_POST['wc_booking_availability_type'][$key] == 'month') {
                    $_wc_booking_availability[$key]['from'] = $_POST['wc_booking_availability_from_month'][$key];
                    $_wc_booking_availability[$key]['to'] = $_POST['wc_booking_availability_to_month'][$key];
                }
            }
            $data_after['_wc_booking_availability'] = serialize($_wc_booking_availability);
        }

        foreach($_POST['meta'] as $val) {
            $post_global_meta[$val['key']] = $val['value'];
        }

        $key_ignore = array(
            '_alb_shortcode_status_preview',
            '_sliced_log',
            '_alb_shortcode_status_content',
            '_alb_shortcode_status_clean_data',
            '_edit_last'
        );

        if (is_array($data_before)) {
            foreach($data_before as $key => $val) {
                if (in_array($key, $key_ignore)) {
                    continue;
                }
                if (!empty($_POST[$key])) {
                    $data_after[$key] = $_POST[$key];
                } else {
                    if (array_key_exists($key, $post_global_meta)) {
                        $data_after[$key] = $post_global_meta[$key];
                    }
                }
            }
        }

        foreach($data_post_after as $key => $val) {
            $data_after[$key] = $val;
        }

        $after_taxonomies = array();
        $taxonomies = get_post_taxonomies($post_id);
        foreach($taxonomies as $val) {
            $after_taxonomies_terms = wp_get_post_terms($post_id, $val, array('fields' => 'names'));
            $after_taxonomies[$val] = $after_taxonomies_terms;
        }

        foreach($after_taxonomies as $key => $val) {
            $data_after[$key] = $val;
        }

        if ($tracking_addon == true) {
            foreach($_POST as $key => $val) {
                if ($key == 'tm_meta_serialized') {
                    $data_after['tm_meta'] = serialize(json_decode(nl2br(rawurldecode(stripslashes_deep($val))), true)['tm_meta']);
                    continue;
                }
                $data_after[$key] = $val;
            }

            $tm_meta_before_unserialize = unserialize($data_before['tm_meta']);

            if (is_array($tm_meta_before_unserialize)) {
                foreach($tm_meta_before_unserialize as $key => $val) {
                    $data_before[$key] = $val;
                }
                unset($data_before['tm_meta']);
            }

            $tm_meta_after_unserialize = unserialize($data_after['tm_meta']);

            if (is_array($tm_meta_after_unserialize)) {
                foreach($tm_meta_after_unserialize as $key => $val) {
                    $data_after[$key] = $val;
                }
                unset($data_after['tm_meta']);
            }

            if (array_key_exists("tm_meta_product_tags", $data_before)) {
                $data_before['tags_input'] = $data_before['tm_meta_product_tags'];
            }

            if (array_key_exists("tm_meta_product_tags", $data_after)) {
                $data_after['tags_input'] = $data_after['tm_meta_product_tags'];
            }
        }

        // product builder acf
        if (!empty($_POST['acf'])) {
            foreach($_POST['acf'] as $key => $val) {
                if (is_array($val) && !mm_tracking_log_is_sequential_array($val)) {
                    foreach($val as $key2 => $val2) {
                        if (is_array($val2) && !mm_tracking_log_is_sequential_array($val2)) {
                            foreach($val2 as $key3 => $val3) {
                                if (is_array($val3) && !mm_tracking_log_is_sequential_array($val3)) {
                                    foreach($val3 as $key4 => $val4) {
                                        $data_after[$key4] = $val4;
                                    }
                                } else {
                                    $data_after[$key3] = $val3;
                                }
                            }
                        } else {
                            $data_after[$key2] = $val2;
                        }
                    }
                } else {
                    $data_after[$key] = $val;
                }
            }
        }

        if (!empty($_POST['acf']) && $post->post_type == 'product') {
            $key_acf_ignore = array(
                    'field_62e04401d3241',
                    'field_62e04401d3242'
                );
            foreach($key_acf_ignore as $val) {
                unset($data_before[$val]);
                unset($data_after[$val]);
            }
        }

        $changes = array();
        foreach($data_before as $key => $val) {
            $is_same = $is_changed = false;

            if ($key == '_wc_booking_availability') {
                $val_before = $val;
            } else {
                $val_before = maybe_unserialize($val);
            }
            $val_after = $data_after[$key];

            if (is_array($val_before) && is_array($val_after)) {
                $val_before = json_encode($val_before);
                $val_after = json_encode($val_after);
            } else {
                if (mm_tracking_log_is_serialized($val_before) && is_array($val_after)) {
                    $val_after = serialize($val_after);
                }
            }

            if ($key == 'mmt_section_lunch_options' || $key == 'mmt_section_addons_options') {
                if ($val_before == '[]' && $val_after == '[{"mmt-group":"radio","mmt-child":"false","mmt-id":"","mmt-title":"","inner-group":[{"mmt-label":"","mmt-price":"","mmt-description":"","mmt-parent":"","mmt-resource":""}]}]') {
                    $is_same = true;
                }
            }

            if (($val_before == 'on' || $val_before == 'yes' || $val_before == 1) && ($val_after == 'on' || $val_after == 'yes' || $val_after == 1)) {
                $is_same = true;
            }

            $val_before = stripslashes($val_before);
            $val_after = stripslashes($val_after);

            if ($val_before != $val_after) {
                $is_changed = true;
            }

            if (!array_key_exists($key, $data_after) || $is_same == true || $is_changed != true) {
                continue;
            }
           
            $changes[$key] = array(
                'before' => $val_before,
                'after' => $val_after
            );
        }

        if (!empty($changes)) {
            $product_title = $post->post_title;
            $product_permalink = get_permalink($post_id);
            $current_user = wp_get_current_user();
            $current_time = date_i18n('F d Y, h:i A', current_time('timestamp'));
            $user_info = "Unknown User";
            $note_change = get_post_meta($post_id, 'mm_tracking_log_note', true);
            $user_ip = mm_tracking_log_get_ip_client();
            $user_os = mm_tracking_log_get_os();
            $user_browser = mm_tracking_log_get_browser_info();
            if ($current_user->ID) {
                $user_info = array(
                    'time_change' => $current_time,
                    'note_change' => $note_change,
                    'user_name' => $current_user->display_name,
                    'user_role' => $current_user->roles[0],
                    'user_ip' => $user_ip,
                    'user_os' => $user_os,
                    'user_browser' => $user_browser
                );
            }

            $product_info = array(
                'product_id' => $post_id,
                'product_title' => $product_title,
                'product_link' => $product_permalink
            );

            $log_change = array();
            foreach ($changes as $key => $value) {
                $log_change[] = array(
                    'key' => $key,
                    'data_before' => $value['before'],
                    'data_after' => $value['after']
                );
            }

            $upload_dir = wp_upload_dir();
        
            $directory = $upload_dir['basedir'] . '/mm_tracking_edit_log';
            if (!file_exists($directory)) {
                wp_mkdir_p($directory);
            }

            $file_path = $directory . "/{$post_id}.json";

            if (file_exists($file_path)) {
                $json_data = file_get_contents($file_path);
                $data_file_log = json_decode($json_data, true);
                array_unshift($data_file_log, array(
                        'user_info' => $user_info,
                        'product_info' => $product_info,
                        'log_change' => $log_change
                    ));
            } else {
                $data_file_log = array(
                    array(
                        'user_info' => $user_info,
                        'product_info' => $product_info,
                        'log_change' => $log_change
                    )
                );
            }

            file_put_contents($file_path, json_encode($data_file_log));

        }

        delete_post_meta($post_id, '_mm_previous_meta');
        delete_post_meta($post_id, 'mm_tracking_log_note');
    }
}

// Added meta box displaying edited log list
if (!function_exists('mm_add_meta_box_edit_log')) {
    add_action('add_meta_boxes', 'mm_add_meta_box_edit_log');
    function mm_add_meta_box_edit_log () {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/configs.json";
        $data_decode = array();
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_decode = json_decode($json_data, true);
            $data_decode = $data_decode['post_type'];
        }
        foreach($data_decode as $postype) {
            add_meta_box(
                'mm_edit_log_meta_box',
                'MM Tracking Edit Log',
                'mm_meta_box_edit_log_callback',
                $postype,
                'normal',
                'default'
            );
        }
    }
}

// Layout show list log edit
if (!function_exists('mm_meta_box_edit_log_callback')) {
    function mm_meta_box_edit_log_callback($post) {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/mm_tracking_edit_log' . "/{$post->ID}.json";
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_array = json_decode($json_data, true);
            if ($data_array !== null) {
                foreach($data_array as $key => $data) {
                    echo '<div style="background-color:#d7cad2;padding:10px;margin-bottom:5px;border-radius:5px;">';
                    echo '<p style="margin:0;"><b>'. $data["user_info"]["user_name"] . ' (' . $data["user_info"]["user_role"] . ')</b> ' . ' [' . $data["user_info"]["time_change"] . '] <b><a target="_blank" href="/wp-admin/admin.php?page=mm_view_detail_log_edit&mm_id_log='.$post->ID.'&mm_number_order_log='.$key.'">View detail</a></b></p>';
                    echo '</div>';
                }
            } else {
                echo '<div>No changes log</div>';
            }
        } else {
            echo '<div>No changes log</div>';
        }
    }
}

// Create page to view detail log edit
if (!function_exists('mm_create_custom_page_log_detail')) {
    add_action('admin_menu', 'mm_create_custom_page_log_detail');
    function mm_create_custom_page_log_detail() {
        add_menu_page(
            'View Detail Log Edit',
            'MM Log Edit',
            'read',
            'mm_view_detail_log_edit',
            'mm_view_detail_log_edit',
            '',
            0
        );
    }
}

// Layout of page view log detailt
if (!function_exists('mm_view_detail_log_edit')) {
    function mm_view_detail_log_edit() {
        if (empty($_GET['mm_id_log'])) {
            return;
        }

        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/{$_GET['mm_id_log']}.json";

        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_decode = json_decode($json_data, true);
            $data = $data_decode[$_GET['mm_number_order_log']];
        }
        ?>
        <div class="wrap">
            <h2>View Detail Log Edit</h2>
            <?php if (!empty($data)) { ?>
                <?php 
                    $user_name = $data['user_info']['user_name'];
                    $user_role = $data['user_info']['user_role'];
                    $time = $data['user_info']['time_change'];
                    $user_ip = $data['user_info']['user_ip'];
                    $user_os = $data['user_info']['user_os'];
                    $user_browser = $data['user_info']['user_browser'];
                    $note = ($data['user_info']['note_change'] ? $data['user_info']['note_change'] : 'No notes');
                    $data_logs = $data['log_change'];
                ?>
                <div>
                    <p><b>Username:</b> <?php echo $user_name ?></p>
                    <p><b>Role:</b> <?php echo $user_role ?></p>
                    <p><b>IP:</b> <?php echo $user_ip ?></p>
                    <p><b>OS:</b> <?php echo $user_os ?></p>
                    <p><b>Browser:</b> <?php echo $user_browser ?></p>
                    <p><b>Time:</b> <?php echo $time ?></p>
                    <p><b>Note:</b> <?php echo $note ?></p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name Data</th>
                            <th>Value Data Old</th>
                            <th>Value Data New</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($data_logs as $logs) {
                                ?>
                                    <tr>
                                        <td><?php echo $logs['key']; ?></td>
                                        <td>
                                            <?php 
                                                if (is_array($logs['data_before'])) {
                                                    echo '<pre>';
                                                    print_r($logs['data_before']);
                                                    echo '</pre>';
                                                } else {
                                                    echo $logs['data_before'];
                                                }
                                             ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if (is_array($logs['data_after'])) {
                                                    echo '<pre>';
                                                    print_r($logs['data_after']);
                                                    echo '</pre>';
                                                } else {
                                                    echo $logs['data_after'];
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
        <?php
    }
}

// Show popup to save note before update
if (!function_exists('mm_tracking_edit_log_popup_note')) {
    add_action('admin_footer', 'mm_tracking_edit_log_popup_note');
    function mm_tracking_edit_log_popup_note() {
        global $pagenow, $post_type;
        if ($pagenow == 'post.php') {
            $upload_dir = wp_upload_dir();
            $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/configs.json";

            $current_user = wp_get_current_user();

            $data_decode = array();
            if (file_exists($file_path)) {
                $json_data = file_get_contents($file_path);
                $data_decode = json_decode($json_data, true);
            }

            if (mm_tracking_log_edit_check_role($current_user->roles, $data_decode['roles']) && in_array($post_type, $data_decode['post_type']) && $data_decode['is_popup'] == 'yes') {
                ?>
                    <div class="mm-tracking-edit-log-popup-note-wrap" style="display:none;" >
                        <div class="mm-tracking-edit-log-popup-note-bg"></div>
                        <form id="mm-tracking-edit-log-popup-note-form">
                            <span class="mm-tracking-edit-log-btn-close button button-primary">X</span>
                            <label for="mm-tracking-edit-log-popup-note">Note Change: </label>
                            <textarea id="mm-tracking-edit-log-popup-note" name="mm-tracking-edit-log-popup-note" placeholder="Enter your note here..." ></textarea>
                            <input type="submit" value="Add note and save" class="button button-primary">
                            <input type="hidden" id="mm-tracking-edit-log-popup-note-id-post" value="<?php echo $_GET['post']; ?>">
                            <button id="mm-tracking-edit-log-popup-note-skip" class="button button-primary">Skip note and save</button>
                            <div id="mm-tracking-edit-log-notification"></div>
                        </form>
                    </div>
                    <script>
                        const btnSave = document.querySelector('#publishing-action input[type="submit"][name="save"]');
                        const btnSkipNote = document.querySelector('#mm-tracking-edit-log-popup-note-skip');
                        const btnCloseNote = document.querySelector('.mm-tracking-edit-log-btn-close');
                        const mmTrackingEditLogPopupNoteWrap = document.querySelector('.mm-tracking-edit-log-popup-note-wrap');

                        if (btnSave && btnSkipNote && mmTrackingEditLogPopupNoteWrap) {
                            btnSave.addEventListener('click', function(event){
                                if (!mmTrackingEditLogPopupNoteWrap.classList.contains('skiped')) {
                                    event.preventDefault();
                                    mmTrackingEditLogPopupNoteWrap.style.display = 'none';
                                    // disable popup and empty notes
                                    btnSkipNote.click();
                                }
                            }) ;
                            btnSkipNote.addEventListener('click', function(event){
                                event.preventDefault();
                                mmTrackingEditLogPopupNoteWrap.classList.add('skiped');
                                mmTrackingEditLogPopupNoteWrap.style.display = 'none';
                                btnSave.click();
                            });
                            btnCloseNote.addEventListener('click', function(){
                                mmTrackingEditLogPopupNoteWrap.style.display = 'none';
                            });
                        }         

                    </script>
                <?php
            }
        }
    }
}

// Tracking Page Options Themes
if (!function_exists('mm_tracking_page_options_themes')) {
    function mm_tracking_page_options_themes ($option_new) {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/configs.json";

        $current_user = wp_get_current_user();

        $data_decode = array();
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_decode = json_decode($json_data, true);
        }

        if ($data_decode['theme_options'] != 'yes') {
            return;
        }

        $old_option = get_option('avia_options_maui_marketing_child')['avia'];
        $new_option = $option_new['avia'];
        $changed = array();
        foreach($old_option as $key => $val) {
            if (is_array($val) && is_array($new_option[$key])) {
                foreach($val as $key2 => $val2) {
                    if (is_array($val2) && is_array($new_option[$key][$key2])) {
                        foreach($val2 as $key3 => $val3) {
                            if ($val3 !== $new_option[$key][$key2][$key3]) {
                                $changed[$key] = array(
                                    'option_old' => $val2,
                                    'option_new' => $new_option[$key][$key2]
                                );
                            }
                        }
                    } else {
                        if ($val2 !== $new_option[$key][$key2]) {
                            $changed[$key] = array(
                                'option_old' => $val,
                                'option_new' => $new_option[$key]
                            );
                        }
                    }
                }
            } else {
                if ($val != $new_option[$key]) {
                    $changed[$key] = array(
                        'option_old' => $val,
                        'option_new' => $new_option[$key]
                    );
                }
            }
        }

        $file_path_theme_options = $upload_dir['basedir'] . "/mm_tracking_edit_log/theme_options.json";

        $current_user = wp_get_current_user();
        $current_time = date_i18n('F d Y, h:i A', current_time('timestamp'));
        $user_info = "Unknown User";
        if ($current_user->ID) {
            $user_info = array(
                'time_change' => $current_time,
                'user_name' => $current_user->display_name,
                'user_role' => $current_user->roles[0]
            );
        }

        if (file_exists($file_path_theme_options)) {
            $json_data_theme_options = file_get_contents($file_path_theme_options);
            $data_file_log_theme_options = json_decode($json_data_theme_options, true);
            array_unshift($data_file_log_theme_options, array(
                    'user_info' => $user_info,
                    'log_change' => $changed
                ));
        } else {
            $data_file_log_theme_options = array(
                array(
                    'user_info' => $user_info,
                    'log_change' => $changed
                )
            );
        }

        file_put_contents($file_path_theme_options, json_encode($data_file_log_theme_options));
    }
    add_action('avia_ajax_save_options_page', 'mm_tracking_page_options_themes');
}

// Create Page View Log Edit Theme Options
if (!function_exists('mm_setting_tracking_log_edit_view_log_theme_options')) {
    function mm_setting_tracking_log_edit_view_log_theme_options() {
        add_menu_page(
            'MM View Log Theme Options',
            'MM View Log Theme Options',
            'manage_options',
            'mm-tracking-view-log-theme-options',
            'mm_setting_tracking_log_edit_view_log_theme_options_func',
            '',
            0
        );
    }
    add_action('admin_menu', 'mm_setting_tracking_log_edit_view_log_theme_options');
}

if (!function_exists('mm_setting_tracking_log_edit_view_log_theme_options_func')) {
    function mm_setting_tracking_log_edit_view_log_theme_options_func() {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/mm_tracking_edit_log' . "/theme_options.json";
        ?>
        <h2>MM List Log Edit Theme Options</h2>
        <?php
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_array = json_decode($json_data, true);
            if ($data_array !== null) {
                foreach($data_array as $key => $data) {
                    echo '<div style="background-color:#d7cad2;padding:10px;margin-bottom:5px;border-radius:5px;">';
                    echo '<p style="margin:0;"><b>'. $data["user_info"]["user_name"] . ' (' . $data["user_info"]["user_role"] . ')</b> ' . ' [' . $data["user_info"]["time_change"] . '] <b><a target="_blank" href="/wp-admin/admin.php?page=mm_view_detail_log_edit_theme_options&mm_key_log='.$key.'">View detail</a></b></p>';
                    echo '</div>';
                }
            } else {
                echo '<div>No changes log</div>';
            }
        } else {
            echo '<div>No changes log</div>';
        }
    }
}

// Create Page View Log Detailt Theme Options
if (!function_exists('mm_setting_tracking_log_edit_view_log_detailt_theme_options')) {
    add_action('admin_menu', 'mm_setting_tracking_log_edit_view_log_detailt_theme_options');
    function mm_setting_tracking_log_edit_view_log_detailt_theme_options() {
        add_menu_page(
            'View Detail Log Edit Theme Options',
            'View Detail Log Edit Theme Options',
            'read',
            'mm_view_detail_log_edit_theme_options',
            'mm_setting_tracking_log_edit_view_log_detailt_theme_options_func',
            '',
            0
        );
    }
}

if (!function_exists('mm_setting_tracking_log_edit_view_log_detailt_theme_options_func')) {
    function mm_setting_tracking_log_edit_view_log_detailt_theme_options_func() {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/theme_options.json";

        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_decode = json_decode($json_data, true);
            $data = $data_decode[$_GET['mm_key_log']];
        }
        ?>
        <div class="wrap">
            <h2>View Detail Log Edit</h2>
            <?php if (!empty($data_decode)) { ?>
                <?php 
                    $user_name = $data['user_info']['user_name'];
                    $user_role = $data['user_info']['user_role'];
                    $time = $data['user_info']['time_change'];
                    $data_logs = $data['log_change'];
                ?>
                <div>
                    <p><b>User:</b> <?php echo $user_name ?> (<?php echo $user_role; ?>)</p>
                    <p><b>Time:</b> <?php echo $time ?></p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name Option</th>
                            <th>Value Option Old</th>
                            <th>Value Option New</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($data_logs as $key => $logs) {
                                ?>
                                    <tr>
                                        <td><?php echo $key; ?></td>
                                        <td>
                                            <?php 
                                                if (is_array($logs['option_old'])) {
                                                    echo '<pre>';
                                                    print_r($logs['option_old']);
                                                    echo '</pre>';
                                                } else {
                                                    echo $logs['option_old'];
                                                }
                                             ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if (is_array($logs['option_new'])) {
                                                    echo '<pre>';
                                                    print_r($logs['option_new']);
                                                    echo '</pre>';
                                                } else {
                                                    echo $logs['option_new'];
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
        <?php
    }
}

// Tracking Resource
if (!function_exists('mm_tracking_edit_log_resource_meta_box')) {
    function mm_tracking_edit_log_resource_meta_box() {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/mm_tracking_edit_log/configs.json";
        $data_decode = array();
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_decode = json_decode($json_data, true);
        }
        if ($data_decode['resource'] == 'yes') {
            add_meta_box('mm_tracking_edit_log_resource', 'MM Tracking Edit Log', 'mm_tracking_edit_log_resource', 'bookable_resource');
        }
    }
    add_action('add_meta_boxes', 'mm_tracking_edit_log_resource_meta_box');
}

if (!function_exists('mm_tracking_edit_log_resource')) {
    function mm_tracking_edit_log_resource($post) {
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/mm_tracking_edit_log' . "/{$post->ID}.json";
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $data_array = json_decode($json_data, true);
            if ($data_array !== null) {
                foreach($data_array as $key => $data) {
                    echo '<div style="background-color:#d7cad2;padding:10px;margin-bottom:5px;border-radius:5px;">';
                    echo '<p style="margin:0;"><b>'. $data["user_info"]["user_name"] . ' (' . $data["user_info"]["user_role"] . ')</b> ' . ' [' . $data["user_info"]["time_change"] . '] <b><a target="_blank" href="/wp-admin/admin.php?page=mm_view_detail_log_edit&mm_id_log='.$post->ID.'&mm_number_order_log='.$key.'">View detail</a></b></p>';
                    echo '</div>';
                }
            } else {
                echo '<div>No changes log</div>';
            }
        } else {
            echo '<div>No changes log</div>';
        }
    }
}


// Add notification lock edit global add on product
if (!function_exists('mm_add_notification_lock_edit_global_add_on_product')) {
    function mm_add_notification_lock_edit_global_add_on_product () {
        if ($_GET['page'] == 'tm-global-epo' && !empty($_GET['post'])) {
            $id_add_on = $_GET['post'];
            if ($_GET['mm-take-over-add-on'] == 1 && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'lock-post_' . $id_add_on)) {
                wp_set_post_lock($id_add_on);
            }
            if ($id_add_on) {
                $current_user_id = get_current_user_id();
                $edit_lock = get_post_meta($id_add_on, '_edit_lock', true);
                list($timestamp, $user_id) = explode(':', $edit_lock);
                $edit_url = get_edit_post_link($id_add_on, 'url');
                $user = get_userdata( $user_id );
                $lock_duration = 600;
                if ((time() - $timestamp) <= $lock_duration && $current_user_id != $user_id) {
                    echo '<div id="post-lock-dialog" class="notification-dialog-wrap">
                        <div class="notification-dialog-background"></div>
                        <div class="notification-dialog">
                            <div class="post-locked-message">
                                <p class="wp-tab-first" tabindex="0">
                                    <span class="currently-editing">'.$user->display_name.' is currently editing this post. Do you want to take over?</span><br>
                                </p>
                                <p>
                                    <a class="button" href="/wp-admin/edit.php?post_type=product&page=tm-global-epo">All Add-on Product</a>
                                    <a class="button button-primary wp-tab-last" href="'. esc_url( add_query_arg( 'mm-take-over-add-on', '1', wp_nonce_url( $edit_url, 'lock-post_' . $id_add_on ) ) ) .'">Take over</a>
                                </p>
                                </div>
                            </div>
                        </div>'; 
                } else {
                    wp_set_post_lock($id_add_on);
                }
            }
        }
    }
    add_action('admin_footer', 'mm_add_notification_lock_edit_global_add_on_product');
}
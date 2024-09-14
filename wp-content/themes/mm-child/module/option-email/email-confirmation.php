<?php
add_action('add_meta_boxes', 'mm_add_metabox_option_email_confirmation_resource');
if (!function_exists('mm_add_metabox_option_email_confirmation_resource')) {

    function mm_add_metabox_option_email_confirmation_resource() {
        add_meta_box('email-confirm-resources', 'Email Confirmation', 'mm_add_option_email_confirmation_resource', 'bookable_resource');
    }

}
if (!function_exists('mm_add_option_email_confirmation_resource')) {

    function mm_add_option_email_confirmation_resource($post) {
        $data_tag = array(
            '[order_number]' => 'Order Number',
            '[firstname]' => 'First name',
            '[lastname]' => 'Last name',
            '[phone_number]' => 'Phone Number',
            '[experience]' => 'Experience',
            '[tour_start_date]' => 'Tour Start Date',
            '[check_in_time]' => 'Check-In Time',
            '[resource_name]' => 'Resource name',
            '[booking_id]' => 'Booking ID',
            '[total_guest]' => 'Total # Guest',
            '[adult]' => 'Adult',
            '[children]' => 'Children',
            '[accommodation]' => 'Accommodation',
            '[qr_code]' => 'QR Code',
            '[ticket_number]' => 'Ticket Number',
        );
        $email_subject = get_post_meta($post->ID, 'email-confirm-subject', true);
        $email_preview = get_post_meta($post->ID, 'email-confirm-preview', true);
        $email_bcc = get_post_meta($post->ID, 'email-confirm-bcc', true);
        ?>
        <div class="mm-custom-email-confirm">
            <div class="enable_option">
                <div class="label" style="display: inline-block;">Enable Send email Confirmation</div>
                <input type="checkbox" name="mm_enable_send_email_confirm" value="yes" <?php if (get_post_meta($post->ID, 'mm_enable_send_email_confirm', true) == 'yes') echo "checked"; ?>/>
            </div>
            <div class="enable_option">
                <div class="label" style="display: inline-block;">Golive</div>
                <input type="checkbox" name="mm_golive_send_email_confirm" value="yes" <?php if (get_post_meta($post->ID, 'mm_golive_send_email_confirm', true) == 'yes') echo "checked"; ?>/>
            </div>
            <div class="order-data-tag">
                <span>
                    <?php
                    foreach ($data_tag as $key => $panel) {
                        echo sprintf(
                                '<span data-value="%1$s" title="%2$s">%1$s</span> ',
                                esc_attr($key),
                                esc_attr($panel),
                        );
                    }
                    ?>
                </span>
            </div>
            <div class="mm-email-subject">
                <p><label style="font-weight: bold;">Subject</label></p>
                <input type="text" class="mm-email-subject" name="email-confirm-subject" value="<?php echo $email_subject; ?>" style="width: 100%;">
            </div>
            <div class="mm-email-preview">
                <p><label style="font-weight: bold;">Preview text</label></p>
                <input type="text" class="mm-email-preview" name="email-confirm-preview" value="<?php echo $email_preview; ?>" style="width: 100%;">
            </div>
            <div class="mm-email-preview">
                <p><label style="font-weight: bold;">BCC:</label></p>
                <input type="text" class="mm-email-bcc" name="email-confirm-bcc" value="<?php echo $email_bcc; ?>" style="width: 100%;">
            </div>
            <div class="mm-email-content">
                <p><label style="font-weight: bold;">Content</label></p>
                <?php
                $email_confirm = get_post_meta($post->ID, 'mm_rs_email_confirm', true);
                wp_editor(stripslashes($email_confirm), 'mm_rs_email_confirm', $settings = array('textarea_name' => 'mm_rs_email_confirm'));
                ?>
            </div>
        </div>
        <?php
    }

}
add_action('save_post', 'mm_save_option_email_confirmation_resource');
if (!function_exists('mm_save_option_email_confirmation_resource')) {

    function mm_save_option_email_confirmation_resource($post_id) {
        if (get_post_type($post_id) == 'bookable_resource') {
            //Check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
            if (isset($_POST['mm_enable_send_email_confirm'])) {
                update_post_meta($post_id, 'mm_enable_send_email_confirm', $_POST['mm_enable_send_email_confirm']);
            }else{
                delete_post_meta($post_id, 'mm_enable_send_email_confirm');
            }
            if (isset($_POST['mm_golive_send_email_confirm'])) {
                update_post_meta($post_id, 'mm_golive_send_email_confirm', $_POST['mm_golive_send_email_confirm']);
            }else{
                delete_post_meta($post_id, 'mm_golive_send_email_confirm');
            }
            if (isset($_POST['email-confirm-subject'])) {
                update_post_meta($post_id, 'email-confirm-subject', wp_kses_post($_POST['email-confirm-subject']));
            }
            if (isset($_POST['email-confirm-preview'])) {
                update_post_meta($post_id, 'email-confirm-preview', wp_kses_post($_POST['email-confirm-preview']));
            }
            if (isset($_POST['email-confirm-bcc'])) {
                update_post_meta($post_id, 'email-confirm-bcc', wp_kses_post($_POST['email-confirm-bcc']));
            }else{
                delete_post_meta($post_id, 'email-confirm-bcc');
            }
            if (isset($_POST['mm_rs_email_confirm'])) {
                update_post_meta($post_id, 'mm_rs_email_confirm', wp_kses_post($_POST['mm_rs_email_confirm']));
            }
        }
    }

}
add_shortcode('mm_send_email_confirmation', 'mm_send_email_confirmation');
add_action('woocommerce_order_status_completed', 'mm_send_email_confirmation', 90);
add_action('woocommerce_order_status_processing', 'mm_send_email_confirmation', 90);
if (!function_exists('mm_send_email_confirmation')) {

    function mm_send_email_confirmation($order_id) {
        if (!$order_id)
            return;
        $order = wc_get_order($order_id);
        if (!get_post_meta($order_id, 'mm_send_email_confirm', true)) {
            $fhapi_booking = get_post_meta($order_id, 'mm_fareharbor_api_sent_data', true);
            $ponorez_booking = get_post_meta($order_id, 'mm_ponorez_api_sent_data', true);
            $gapi_booking = get_post_meta($order_id, 'mm_galaxy_api_sent_data', true);
            if (!empty($fhapi_booking) || !empty($ponorez_booking) || !empty($gapi_booking)) {
                $i=0;
                foreach ($order->get_items() as $order_item_id => $item) {
                    $i++;
                    $fh_item_booking_id = wc_get_order_item_meta($order_item_id, 'mm_fareharbor_booking_id', true);
                    $gapi_id = wc_get_order_item_meta($order_item_id,'mm_galaxyconnect_booking_id', true);
                    if (!empty($fh_item_booking_id) || !empty($gapi_id)) {
                        $transportation_addons = false;
                        $external_booking = false;
                        $fern_grotto_cruise = false;
                        if (class_exists('THEMECOMPLETE_EPO_API_base')) {
                            //$epo_class_api = THEMECOMPLETE_EPO_API_base::instance();
                            //$epo_data = $epo_class_api->get_all_options($order_id);
                            $item_meta = function_exists('wc_get_order_item_meta') ? wc_get_order_item_meta($order_item_id, '', FALSE) : $order->get_item_meta($order_item_id);
                            $has_epo = is_array($item_meta) && isset($item_meta['_tmcartepo_data']) && isset($item_meta['_tmcartepo_data'][0]) && isset($item_meta['_tm_epo']);

                            $has_fee = is_array($item_meta) && isset($item_meta['_tmcartfee_data']) && isset($item_meta['_tmcartfee_data'][0]);
                            if ($has_epo) {

                                $epos_data = maybe_unserialize($item_meta['_tmcartepo_data'][0]);
                            }
                            if ($has_fee) {

                                $epos = maybe_unserialize($item_meta['_tmcartfee_data'][0]);

                                if (isset($epos[0])) {
                                    $epos = $epos[0];
                                } else {
                                    $epos = FALSE;
                                }
                                if ($epos && is_array($epos) && !empty($epos[0])) {
                                    $epos_data = array_merge($epos_data, $epos);
                                }
                            }
                            if ($epos_data) {
                                foreach ($epos_data as $key => $value) {
                                    $meta_name = $value['name'];
                                    $meta_value = $value['value'];
                                    if ((strpos(strtolower($meta_name), 'transport') !== false || strpos(strtolower($meta_name), 'pickup') !== false || strpos(strtolower($meta_name), 'pick up') !== false || strpos(strtolower($meta_name), 'pick-up') !== false) && strpos(strtolower($meta_value), 'drive yourself') === false && strpos(strtolower($meta_value), 'drive to') === false && strpos(strtolower($meta_value), 'check-in at the activity or tour start') === false){
                                        $transportation_addons = true;
                                    }
                                    if ((strpos(strtolower($meta_name), 'where are you staying') !== false) || (strpos(strtolower($meta_name), 'hotel name') !== false) || strpos(strtolower($meta_name), 'hotel pickup') !== false || ((strpos(strtolower($meta_name), 'hotel or private residence') !== false || strpos(strtolower($meta_name), 'accommodation') !== false) && $meta_value != 'Hotel Not Listed')) {
                                        $hotel_name = $meta_value;
                                    }
                                    if ((strpos(strtolower($meta_name), 'add-on') !== false) && (strpos(strtolower($meta_value), 'aviation water tower') !== false )){
                                        $external_booking = true;
                                    }
                                    if (strpos(strtolower($meta_value), 'fern grotto cruise') !== false ){
                                        $fern_grotto_cruise = true;
                                    }
                                }
                            }
                        }
                        if (class_exists('WC_Booking_Data_Store')) {
                            $booking_ids = WC_Booking_Data_Store::get_booking_ids_from_order_item_id($order_item_id);
                            if (!empty($booking_ids)) {
                                foreach ($booking_ids as $booking_id) {
                                    $booking_mm = new WC_Booking($booking_id);
                                    $product_mm = $booking_mm->get_product();
                                    $product_id = $booking_mm->get_product_id();
                                    $hta = false;
                                    $product_tag = get_the_terms($product_id, 'product_tag');
                                    foreach ($product_tag as $term) {
                                        if ($term->name == 'HTA' || $term->name == 'HTA Oahu' || $term->name == 'HTA Maui' || $term->name == 'HTA Big Island' || $term->name == 'HTA Kauai') {
                                            $hta = true;
                                        }
                                    }
                                    if ($product_mm->has_persons()) {
                                        if ($product_mm->has_person_types()) {
                                            $person_types = $product_mm->get_person_types();
                                            $person_counts = $booking_mm->get_person_counts();
                                            $adults = 0;
                                            $children = 0;
                                            $seater_driver = 0;
                                            $seater_passenger = 0;
                                            if (!empty($person_types) && is_array($person_types)) {
                                                foreach ($person_types as $person_type) {

                                                    if (empty($person_counts[$person_type->get_id()])) {
                                                        continue;
                                                    }
                                                    $pname = $person_type->get_name();
                                                    $pname_lowercase = strtolower($pname);
                                                    $pcount = $person_counts[$person_type->get_id()];
                                                    $possenior = strpos($pname_lowercase, 'senior');
                                                    $posroom = strpos($pname_lowercase, 'room');
                                                    if (strpos($pname_lowercase, 'child') !== false || strpos($pname_lowercase, 'toddler') !== false || strpos($pname_lowercase, 'junior') !== false || strpos($pname_lowercase, 'youth') !== false || strpos($pname_lowercase, 'teen') !== false) {
                                                        $children += $pcount;
                                                    } elseif (strpos($pname_lowercase, 'infant') !== false) {
                                                        $infant = $pcount;
                                                    } elseif ($possenior !== false) {
                                                        $seniors = $pcount;
                                                    } elseif (strpos($pname_lowercase, '1 seater') !== false) {
                                                        $adults += $pcount;
                                                        $seater_passenger += 1;
                                                    } elseif (strpos($pname_lowercase, '2 seater') !== false) {
                                                        $adults += $pcount * 2;
                                                        $seater_passenger += 1;
                                                        $seater_driver += 1;
                                                    } elseif (strpos($pname_lowercase, '3 seater') !== false) {
                                                        $adults += $pcount * 3;
                                                        $seater_passenger += 1;
                                                        $seater_driver += 2;
                                                    } elseif (strpos($pname_lowercase, '4 seater') !== false) {
                                                        $adults += $pcount * 4;
                                                        $seater_passenger += 1;
                                                        $seater_driver += 3;
                                                    } elseif ($posroom == false) {
                                                        $adults += $pcount;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if ($product_mm->has_resources() || $product_mm->is_resource_assignment_type('customer')) {
                                        $booking_resource_id = $booking_mm->get_resource_id();
                                        $mm_resource_vendor = get_post_meta($booking_resource_id, 'mm_resource_vendor', true);
                                        if($mm_resource_vendor!=''){
                                            if(strpos(strtolower($mm_resource_vendor), 'hta')=== false){
                                                $hta = false;
                                            }
                                        }
                                        $mm_enable_send_email_confirm = get_post_meta($booking_resource_id, 'mm_enable_send_email_confirm', true);
                                        $golive = get_post_meta($booking_resource_id, 'mm_golive_send_email_confirm', true);
                                        $email_subject = get_post_meta($booking_resource_id, 'email-confirm-subject', true);
                                        $email_bcc = get_post_meta($booking_resource_id, 'email-confirm-bcc', true);
                                        $get_setting_email_bcc = WC_Admin_Settings::get_option('wc_settings_tab_emailconfirm_bcc_email');
                                        $email_confirm = get_post_meta($booking_resource_id, 'mm_rs_email_confirm', true);
                                        if ( $mm_enable_send_email_confirm == 'yes' && !empty($email_subject) && !empty($email_confirm) && !$transportation_addons && !$external_booking && !$fern_grotto_cruise) {
                                            $tour_date_format = strtotime($booking_mm->get_start_date());
                                            $billing_email = $order->get_billing_email();
                                            $order_number = $order->get_order_number();
                                            $firstname = $order->get_billing_first_name();
                                            $lastname = $order->get_billing_last_name();
                                            $phone_number = $order->get_billing_phone();
                                            $experience = get_the_title($product_id);
                                            $tour_start_date = date("l, F d, Y", $tour_date_format);
                                            $resource_name = get_the_title($booking_resource_id);
                                            $total_guest = array_sum($booking_mm->get_person_counts());
                                            $booking_id = $fh_item_booking_id;
                                            $qr_code = '';
                                            if(empty($booking_id)){
                                                $booking_id = $gapi_id;
                                            }
                                            $ticketnumber = wc_get_order_item_meta($order_item_id, 'mm_galaxyconnect_ticketNumber', true);
                                            if(!empty($ticketnumber)){
                                                $upload_dir = wp_upload_dir();
                                                $qr_code.='<div style="margin-bottom: 5px;margin-top: 5px;">';
                                                $ticketNumber_arr = explode(',', $ticketnumber);
                                                foreach ($ticketNumber_arr as $ticket) {
                                                    $file_ticket = $order_id.'-'.$ticket.'.png';
                                                    $file_ticket_url = $upload_dir['basedir'] . '/tickets/' . $file_ticket;
                                                    $ticket_image = $upload_dir['baseurl'] . '/tickets/' . $file_ticket;
                                                    //$file_ticket_url = MM_GALAXYCONNECT_PLUGIN_DIR . 'tickets/' . $file_ticket;
                                                    //$ticket_image = MM_GALAXYCONNECT_PLUGIN_URL . 'tickets/' . $file_ticket;
                                                    if (file_exists($file_ticket_url)) {
                                                        $qr_code.= "<a href='".$ticket_image."' download class='noLightbox' style='margin-right: 10px;'><img src='".$ticket_image."' class='ticket_number' alt='".$ticket."' style='max-width: 200px; padding: 10px; border: 1px dashed #636363;'></a>";
                                                    }
                                                }
                                                $qr_code.='</div>';
                                            }
                                            $check_in_time = '';
                                            $pickup_text = wc_get_order_item_meta($order_item_id, 'mm_fareharbor_pickup_text', true);
                                            if (!empty($pickup_text)) {
                                                preg_match('/\d{1,2}:\d{2}(?:am|pm)/', strtolower($pickup_text), $matches, PREG_OFFSET_CAPTURE);
                                                if (!empty($matches)) {
                                                    if (!empty($matches[0][0])) {
                                                        $check_in_time = 'CI '.$matches[0][0];
                                                    }
                                                }
                                            }
                                            if(empty($check_in_time)){
                                                $check_in_time = date('h:i A', $booking_mm->get_start('edit'));
                                            }
                                            $search = ['[order_number]', '[firstname]', '[lastname]', '[phone_number]', '[experience]', '[tour_start_date]', '[resource_name]', '[total_guest]', '[booking_id]', '[adult]', '[children]', '[accommodation]', '[check_in_time]','[qr_code]','[ticket_number]'];
                                            $replace = [$order_number, $firstname, $lastname, $phone_number, $experience, $tour_start_date, $resource_name, $total_guest, $booking_id, $adults, $children, $hotel_name, $check_in_time, $qr_code, $ticketnumber];
                                            $email_subject = html_entity_decode(str_replace($search,$replace,$email_subject));
                                            $email_confirm = stripslashes(wpautop(trim(html_entity_decode( str_replace($search,$replace,$email_confirm)) )));
                                            //echo $email_subject;
                                            
                                            $email_confirm = '<div id="mm-email-confirm" style="max-width:600px"><div class="mm-email-confirm-content">'.$email_confirm.'</div></div>';
                                            
                                            if($golive == 'yes'){
                                                wc_update_order_item_meta($order_item_id, 'mm_change_stage_confirmation_sent', 'yes');
                                                $site_name = get_bloginfo('name');
                                                $email = get_option('admin_email');
                                                
                                                $headers = array();
                                                $headers[] = 'From: '.$site_name.' <'.$email.'>';
                                                //$headers[] = 'BCC: customer@hawaiitours.com';
                                                $headers[] = 'BCC: hungtrinhdn@gmail.com';
                                                if(!empty($get_setting_email_bcc)){
                                                    $headers[] = 'BCC: '.$get_setting_email_bcc;
                                                }
                                                if(!empty($email_bcc)){
                                                    $bcc = explode(",", $email_bcc);
                                                    foreach ($bcc as $headers_mail_bcc) {
                                                        if($headers_mail_bcc != $get_setting_email_bcc){
                                                            $headers[] = 'BCC: '.$headers_mail_bcc;
                                                        }
                                                    }
                                                }
                                                wp_mail($billing_email,$email_subject,$email_confirm,$headers);
                                                //wp_mail("hungtrinhdn@gmail.com", $order_id . " Send email Confirmation to ".$billing_email, print_r($headers, true));

                                                /*Change Stage to confirmation sent*/
                                                $properties = array();
                                                $properties['dealstage'] = 34837105;
                                                if($hta){
                                                    $properties['pipeline'] = '11202935';
                                                    $properties['dealstage'] = 33594512;
                                                }
                                                if (count($order->get_items()) == 1 || $i == 1) {
                                                    $hubwoo_ecomm_deal_id = get_post_meta($order_id, 'hubwoo_ecomm_deal_id', true);
                                                } else {
                                                    $hubwoo_ecomm_deal_id = wc_get_order_item_meta($order_item_id, 'order_item_hubwoo_ecomm_deal_id', true);
                                                    if(empty($hubwoo_ecomm_deal_id)){
                                                        $hubwoo_ecomm_deal_id = wc_get_order_item_meta($order_item_id, 'hubwoo_ecomm_deal_id', true);
                                                    }
                                                }
                                                if(!empty($hubwoo_ecomm_deal_id)){
                                                    $access_token = get_option( 'nf_hs_access_token' );
                                                    $url = "https://api.hubapi.com/crm/v3/objects/deals/" . $hubwoo_ecomm_deal_id;
                                                    $data = array("properties" => $properties);
                                                    $data_string = json_encode($data);
                                                    $curl = curl_init();
                                                    curl_setopt_array($curl, array(
                                                        CURLOPT_URL => $url,
                                                        CURLOPT_RETURNTRANSFER => true,
                                                        CURLOPT_ENCODING => "",
                                                        CURLOPT_MAXREDIRS => 10,
                                                        CURLOPT_TIMEOUT => 30,
                                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                        CURLOPT_CUSTOMREQUEST => "PATCH",
                                                        CURLOPT_POSTFIELDS => $data_string,
                                                        CURLOPT_HTTPHEADER => array(
                                                            "accept: application/json",
                                                            "content-type: application/json",
                                                            "Authorization: Bearer " . $access_token,
                                                        ),
                                                    ));
                                                    $response = curl_exec($curl);
                                                    $err = curl_error($curl);

                                                    curl_close($curl);

                                                    if ($err) {
                                                        wp_mail("hungtrinhdn@gmail.com", $order_id . " Change stage to Confirmation Sent - error", print_r($err, true));
                                                    } else {
                                                        //echo $response;
                                                        wp_mail("hungtrinhdn@gmail.com", $order_id . " Change stage to Confirmation Sent - OK", print_r($response, true));

                                                    }
                                                }
                                            }else{
                                                wp_mail('hungtrinhdn@gmail.com',$email_subject,$email_confirm);
                                            
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                update_post_meta($order_id, 'mm_send_email_confirm', 'yes');
            }
        }
    }

}
class WC_Settings_Tab_MMEmailConfirm {

    public static function init() {
        add_filter('woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50);
        add_action('woocommerce_settings_tabs_settings_tab_emailconfirm', __CLASS__ . '::settings_tab');
        add_action('woocommerce_update_options_settings_tab_emailconfirm', __CLASS__ . '::update_settings');
        
    }
    
    public static function add_settings_tab($settings_tabs) {
        $settings_tabs['settings_tab_emailconfirm'] = __('MM Email Confirmation', 'woocommerce-settings-tab-fareharbor');
        return $settings_tabs;
    }

    public static function settings_tab() {
        woocommerce_admin_fields(self::get_settings());
    }

    public static function update_settings() {
        woocommerce_update_options(self::get_settings());
    }

    public static function get_settings() {

        $settings = array(
            'section_title' => array(
                'name' => __('MM Email Confirmation', 'mm'),
                'type' => 'title',
                'desc' => '',
                'id' => 'wc_settings_tab_emailconfirm_section_title'
            ),
            'bcc_email' => array(
                'name' => __('BCC Email', 'mm'),
                'type' => 'text',
                'desc' => __('', 'mm'),
                'id' => 'wc_settings_tab_emailconfirm_bcc_email'
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_settings_tab_emailconfirm_section_end'
            )
        );

        return apply_filters('wc_settings_tab_emailconfirm_settings', $settings);
    }

}

WC_Settings_Tab_MMEmailConfirm::init();

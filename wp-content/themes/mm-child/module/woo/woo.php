<?php
require_once( 'email.php' );
require_once( 'checkout.php' );
require_once( 'admin/custom_price.php' );
require_once( 'admin/default_person.php' );
require_once( 'admin/change_text_per_adult.php' );

add_filter('use_block_editor_for_post', '__return_false');

if (!function_exists('mmt_product_write_panel_tabs')) {

    function mmt_product_write_panel_tabs() {
        ?>
        <li class="addons_tab product_addons">
            <a href="#mmt_addons_options"> <span>Add-ons Options</span> </a>
        </li>
        <li class="addons_tab product_addons">
            <a href="#mmt_lunch_options"> <span>Meal Options</span> </a>
        </li>
        <li class="addons_tab product_addons">
            <a href="#mmt_day_options"> <span>Days Options</span> </a>
        </li>
        <li class="seasonal_option">
            <a href="#mmt_seasonal_options"> <span>Seasonal Options</span> </a>
        </li>
        <?php
    }

    add_action('woocommerce_product_write_panel_tabs', 'mmt_product_write_panel_tabs', 10, 4);
}

if (!function_exists('mmt_product_data_panels')) {

    function mmt_product_data_panels() {
        global $post;
        $idPost = $post->ID;
        $monday = get_post_meta($idPost, 'mmt_monday_price', true);
        $tuesday = get_post_meta($idPost, 'mmt_tuesday_price', true);
        $wednesday = get_post_meta($idPost, 'mmt_wednesday_price', true);
        $thursday = get_post_meta($idPost, 'mmt_thursday_price', true);
        $friday = get_post_meta($idPost, 'mmt_friday_price', true);
        $saturday = get_post_meta($idPost, 'mmt_saturday_price', true);
        $sunday = get_post_meta($idPost, 'mmt_sunday_price', true);
        $monday_label = get_post_meta($idPost, 'mmt_monday_label', true);
        $tuesday_label = get_post_meta($idPost, 'mmt_tuesday_label', true);
        $wednesday_label = get_post_meta($idPost, 'mmt_wednesday_label', true);
        $thursday_label = get_post_meta($idPost, 'mmt_thursday_label', true);
        $friday_label = get_post_meta($idPost, 'mmt_friday_label', true);
        $saturday_label = get_post_meta($idPost, 'mmt_saturday_label', true);
        $sunday_label = get_post_meta($idPost, 'mmt_sunday_label', true);
        ?>
        <div id="mmt_add_on_options">
            <div id="mmt_addons_options" class="panel woocommerce_options_panel hidden">
                <?php mmt_get_form_repeater('mmt_section_addons_options', 'Add-ons options', 'addons_options'); ?>
            </div>
            <div id="mmt_lunch_options" class="panel woocommerce_options_panel hidden">
                <?php mmt_get_form_repeater('mmt_section_lunch_options', 'Lunch options', 'lunch_options'); ?>
            </div>
            <div id="mmt_day_options" class="panel woocommerce_options_panel hidden">
                <div class="mmt_days_wrap">
                    <div class="mmt-form-field <?php echo!empty($monday) ? 'selected' : ''; ?>">
                        <?php
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_monday',
                            'wrapper_class' => 'mmt_date_field',
                            'label' => 'Monday',
                        ));
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_monday_label',
                                    'value' => $monday_label,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Title',
                                    'placeholder' => 'Monday',
                                )
                        );
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_monday_price',
                                    'value' => $monday,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Price',
                                    'placeholder' => '0.00$',
                                )
                        );
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_monday_person',
                            'wrapper_class' => 'mmt_hide',
                            'label' => 'Person',
                        ));
                        ?>
                    </div>
                    <div class="mmt-form-field <?php echo!empty($tuesday) ? 'selected' : ''; ?>">
                        <?php
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_tuesday',
                            'wrapper_class' => 'mmt_date_field',
                            'label' => 'Tuesday',
                        ));
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_tuesday_label',
                                    'value' => $tuesday_label,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Title',
                                    'placeholder' => 'Tuesday',
                                )
                        );
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_tuesday_price',
                                    'value' => $tuesday,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Price',
                                    'placeholder' => '0.00$',
                                )
                        );
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_tuesday_person',
                            'wrapper_class' => 'mmt_hide',
                            'label' => 'Person',
                        ));
                        ?>
                    </div>
                    <div class="mmt-form-field <?php echo!empty($wednesday) ? 'selected' : ''; ?>">
                        <?php
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_wednesday',
                            'wrapper_class' => 'mmt_date_field',
                            'label' => 'Wednesday',
                        ));
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_wednesday_label',
                                    'value' => $wednesday_label,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Title',
                                    'placeholder' => 'Wednesday',
                                )
                        );
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_wednesday_price',
                                    'value' => $wednesday,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Price',
                                    'placeholder' => '0.00$',
                                )
                        );
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_wednesday_person',
                            'wrapper_class' => 'mmt_hide',
                            'label' => 'Person',
                        ));
                        ?>
                    </div>
                    <div class="mmt-form-field <?php echo!empty($thursday) ? 'selected' : ''; ?>">
                        <?php
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_thursday',
                            'wrapper_class' => 'mmt_date_field',
                            'label' => 'Thursday',
                        ));
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_thursday_label',
                                    'value' => $thursday_label,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Title',
                                    'placeholder' => 'Thursday',
                                )
                        );
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_thursday_price',
                                    'value' => $thursday,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Price',
                                    'placeholder' => '0.00$',
                                )
                        );
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_thursday_person',
                            'wrapper_class' => 'mmt_hide',
                            'label' => 'Person',
                        ));
                        ?>
                    </div>
                    <div class="mmt-form-field <?php echo!empty($friday) ? 'selected' : ''; ?>">
                        <?php
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_friday',
                            'wrapper_class' => 'mmt_date_field',
                            'label' => 'Friday',
                        ));
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_friday_label',
                                    'value' => $friday_label,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Title',
                                    'placeholder' => 'Friday',
                                )
                        );
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_friday_price',
                                    'value' => $friday,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Price',
                                    'placeholder' => '0.00$',
                                )
                        );
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_friday_person',
                            'wrapper_class' => 'mmt_hide',
                            'label' => 'Person',
                        ));
                        ?>
                    </div>
                    <div class="mmt-form-field <?php echo!empty($saturday) ? 'selected' : ''; ?>">
                        <?php
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_saturday',
                            'wrapper_class' => 'mmt_date_field',
                            'label' => 'Saturday',
                        ));
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_saturday_label',
                                    'value' => $saturday_label,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Title',
                                    'placeholder' => 'Saturday',
                                )
                        );
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_saturday_price',
                                    'value' => $saturday,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Price',
                                    'placeholder' => '0.00$',
                                )
                        );
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_saturday_person',
                            'wrapper_class' => 'mmt_hide',
                            'label' => 'Person',
                        ));
                        ?>
                    </div>
                    <div class="mmt-form-field <?php echo!empty($sunday) ? 'selected' : ''; ?>">
                        <?php
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_sunday',
                            'wrapper_class' => 'mmt_date_field',
                            'label' => 'Sunday',
                        ));
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_sunday_label',
                                    'value' => $sunday_label,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Title',
                                    'placeholder' => 'Sunday',
                                )
                        );
                        woocommerce_wp_text_input(
                                array(
                                    'id' => 'mmt_sunday_price',
                                    'value' => $sunday,
                                    'type' => 'text',
                                    'wrapper_class' => 'mmt_hide',
                                    'label' => 'Price',
                                    'placeholder' => '0.00$',
                                )
                        );
                        woocommerce_wp_checkbox(array(
                            'id' => 'mmt_sunday_person',
                            'wrapper_class' => 'mmt_hide',
                            'label' => 'Person',
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div id="mmt_seasonal_options" class="panel woocommerce_options_panel hidden bookings_extension">
                <?php
                global $bookable_product;
                $product_resources = $bookable_product->get_resource_ids('edit');
                if ($product_resources) {
                    foreach ($product_resources as $resource_id) {
                        $resource = new WC_Product_Booking_Resource($resource_id);
                    }
                }
                $person_types = $bookable_product->get_person_types( 'edit' );
                ?>
                <div class="options_group">
                    <div class="table_grid">
                        <table class="widefat">
                            <thead>
                                <tr>
                                    <th class="sort" width="1%">&nbsp;</th>
                                    <th><?php _e('Range type', 'woocommerce-bookings'); ?></th>
                                    <th><?php _e('Range', 'woocommerce-bookings'); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php _e('Display cost', 'woocommerce-bookings'); ?>&nbsp;<a class="tips" data-tip="<?php _e('Enter a cost for this rule. Applied to each booking block.', 'woocommerce-bookings'); ?>">[?]</a></th>
                                    <th><?php _e('Resources', 'woocommerce-bookings'); ?>&nbsp;<a class="tips" data-tip="<?php _e('Enter resources ID. Default all resource (-1)', 'woocommerce-bookings'); ?>">[?]</a></th>
                                    <th><?php _e('Persons', 'woocommerce-bookings'); ?>&nbsp;<a class="tips" data-tip="<?php _e('Enter person ID. Default all person (-1)', 'woocommerce-bookings'); ?>">[?]</a></th>
                                    <th class="remove" width="1%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="9">
                                        <a href="#" class="button add_row" data-row="<?php
                                        ob_start();
                                        include( 'admin/seasonal_field.php' );
                                        $html = ob_get_clean();
                                        echo esc_attr($html);
                                        ?>"><?php _e('Add Range', 'woocommerce-bookings'); ?></a>
                                        <span class="description"><?php _e('All matching rules will be applied to the booking.', 'woocommerce-bookings'); ?></span>
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody id="pricing_rows">
                                <?php
                                $values = $bookable_product->get_seasonal('edit');
                                //var_dump($bookable_product);
                                if (!empty($values) && is_array($values)) {
                                    foreach ($values as $index => $pricing) {
                                        include( 'admin/seasonal_field.php' );
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
        <?php
    }

    add_action('woocommerce_product_data_panels', 'mmt_product_data_panels', 10, 4);
}

if (!function_exists('mmt_save_post')) {

    function mmt_save_post($post_id) {
        if (!isset($_POST['post_type'])) {
            return false;
        }
        if ($_POST['post_type'] != 'product') {
            return false;
        }

        $lunchOptions = $_POST['mmt_section_lunch_options'];
        $addonsOptions = $_POST['mmt_section_addons_options'];
        $lunch = mmt_check_data_repeater($lunchOptions);
        $addons = mmt_check_data_repeater($addonsOptions);
        update_post_meta($post_id, 'mmt_section_lunch_options', $lunch);
        update_post_meta($post_id, 'mmt_section_addons_options', $addons);

        if (!empty($_POST['mmt_monday']) && $_POST['mmt_monday'] == 'yes') {
            update_post_meta($post_id, 'mmt_monday', $_POST['mmt_monday']);
            update_post_meta($post_id, 'mmt_monday_price', $_POST['mmt_monday_price']);
            update_post_meta($post_id, 'mmt_monday_label', $_POST['mmt_monday_label']);
            update_post_meta($post_id, 'mmt_monday_person', $_POST['mmt_monday_person']);
        } else {
            update_post_meta($post_id, 'mmt_monday', '');
            update_post_meta($post_id, 'mmt_monday_price', '');
            update_post_meta($post_id, 'mmt_monday_person', '');
            update_post_meta($post_id, 'mmt_monday_label', '');
        }

        if (!empty($_POST['mmt_tuesday']) && $_POST['mmt_tuesday'] == 'yes') {
            update_post_meta($post_id, 'mmt_tuesday', $_POST['mmt_tuesday']);
            update_post_meta($post_id, 'mmt_tuesday_price', $_POST['mmt_tuesday_price']);
            update_post_meta($post_id, 'mmt_tuesday_label', $_POST['mmt_tuesday_label']);
            update_post_meta($post_id, 'mmt_tuesday_person', $_POST['mmt_tuesday_person']);
        } else {
            update_post_meta($post_id, 'mmt_tuesday', '');
            update_post_meta($post_id, 'mmt_tuesday_price', '');
            update_post_meta($post_id, 'mmt_tuesday_label', '');
            update_post_meta($post_id, 'mmt_tuesday_person', '');
        }

        if (!empty($_POST['mmt_wednesday']) && $_POST['mmt_wednesday'] == 'yes') {
            update_post_meta($post_id, 'mmt_wednesday', $_POST['mmt_wednesday']);
            update_post_meta($post_id, 'mmt_wednesday_price', $_POST['mmt_wednesday_price']);
            update_post_meta($post_id, 'mmt_wednesday_label', $_POST['mmt_wednesday_label']);
            update_post_meta($post_id, 'mmt_wednesday_person', $_POST['mmt_wednesday_person']);
        } else {
            update_post_meta($post_id, 'mmt_wednesday', '');
            update_post_meta($post_id, 'mmt_wednesday_price', '');
            update_post_meta($post_id, 'mmt_wednesday_label', '');
            update_post_meta($post_id, 'mmt_wednesday_person', '');
        }

        if (!empty($_POST['mmt_thursday']) && $_POST['mmt_thursday'] == 'yes') {
            update_post_meta($post_id, 'mmt_thursday', $_POST['mmt_thursday']);
            update_post_meta($post_id, 'mmt_thursday_price', $_POST['mmt_thursday_price']);
            update_post_meta($post_id, 'mmt_thursday_label', $_POST['mmt_thursday_label']);
            update_post_meta($post_id, 'mmt_thursday_person', $_POST['mmt_thursday_person']);
        } else {
            update_post_meta($post_id, 'mmt_thursday', '');
            update_post_meta($post_id, 'mmt_thursday_price', '');
            update_post_meta($post_id, 'mmt_thursday_label', '');
            update_post_meta($post_id, 'mmt_thursday_person', '');
        }

        if (!empty($_POST['mmt_friday']) && $_POST['mmt_friday'] == 'yes') {
            update_post_meta($post_id, 'mmt_friday', $_POST['mmt_friday']);
            update_post_meta($post_id, 'mmt_friday_price', $_POST['mmt_friday_price']);
            update_post_meta($post_id, 'mmt_friday_label', $_POST['mmt_friday_label']);
            update_post_meta($post_id, 'mmt_friday_person', $_POST['mmt_friday_person']);
        } else {
            update_post_meta($post_id, 'mmt_friday', '');
            update_post_meta($post_id, 'mmt_friday_price', '');
            update_post_meta($post_id, 'mmt_friday_label', '');
            update_post_meta($post_id, 'mmt_friday_person', '');
        }

        if (!empty($_POST['mmt_saturday']) && $_POST['mmt_saturday'] == 'yes') {
            update_post_meta($post_id, 'mmt_saturday', $_POST['mmt_saturday']);
            update_post_meta($post_id, 'mmt_saturday_price', $_POST['mmt_saturday_price']);
            update_post_meta($post_id, 'mmt_saturday_label', $_POST['mmt_saturday_label']);
            update_post_meta($post_id, 'mmt_saturday_person', $_POST['mmt_saturday_person']);
        } else {
            update_post_meta($post_id, 'mmt_saturday', '');
            update_post_meta($post_id, 'mmt_saturday_price', '');
            update_post_meta($post_id, 'mmt_saturday_label', '');
            update_post_meta($post_id, 'mmt_saturday_person', '');
        }

        if (!empty($_POST['mmt_sunday']) && $_POST['mmt_sunday'] == 'yes') {
            update_post_meta($post_id, 'mmt_sunday', $_POST['mmt_sunday']);
            update_post_meta($post_id, 'mmt_sunday_price', $_POST['mmt_sunday_price']);
            update_post_meta($post_id, 'mmt_sunday_label', $_POST['mmt_sunday_label']);
            update_post_meta($post_id, 'mmt_sunday_person', $_POST['mmt_sunday_person']);
        } else {
            update_post_meta($post_id, 'mmt_sunday', '');
            update_post_meta($post_id, 'mmt_sunday_price', '');
            update_post_meta($post_id, 'mmt_sunday_label', '');
            update_post_meta($post_id, 'mmt_sunday_person', '');
        }
    }

    add_action('save_post', 'mmt_save_post', 10, 4);
}


if (!function_exists('mmt_after_checkout_billing_form')) {

    function mmt_after_checkout_billing_form($checkout) {
        mmt_get_billing_form();
    }

    //add_action('woocommerce_after_checkout_billing_form', 'mmt_after_checkout_billing_form', 10, 4);
}

if (!function_exists('mmt_add_session_url_product')) {

    function mmt_add_session_url_product($cart_item_key, $productId, $quantity, $variation_id, $variation, $cart_item_data) {

        WC()->session->set('product-url', get_the_permalink($productId));

        if (!empty($_POST['mmt-check-island'])) {
            WC()->session->set('island-' . $cart_item_key, $_POST['mmt-check-island']);
        }

        return $cart_item_key;
    }

    add_action('woocommerce_add_to_cart', 'mmt_add_session_url_product', 10, 6);
}

if (!function_exists('mmt_add_session_url_product_when_remove_cart')) {

    function mmt_add_session_url_product_when_remove_cart($cart_item_key, $cart) {
        if (!empty(WC()->cart->get_cart())) {
            $items = WC()->cart->get_cart();

            foreach ($items as $item_key => $item) {
                if ($cart_item_key == $item_key) {
                    $idProduct = $item['product_id'];
                    WC()->session->set('product-url', get_the_permalink($idProduct));
                }
            }
        }
    }

    add_action('woocommerce_remove_cart_item', 'mmt_add_session_url_product_when_remove_cart', 10, 6);
}


if (!function_exists('mmt_cart_item_removed')) {

    function mmt_cart_item_removed() {

        if (WC()->cart->is_empty()) {
            WC()->session->set('product-redirect', true);
        }
    }

    //add_action("woocommerce_cart_item_removed", 'mmt_cart_item_removed', 5, 3);
}

if (!function_exists('mmt_redirection_url_product_checkout')) {

    function mmt_redirection_url_product_checkout() {
        if (isset(WC()->session)) {
            $redirect = WC()->session->get('product-redirect');
            if (!empty($redirect)) {
                $productUrl = WC()->session->get('product-url');
                if (!empty(esc_url($productUrl))) {

                    WC()->session->set('product-redirect', false);

                    wp_redirect($productUrl);
                    exit();
                }
            }
        }
        if (is_page('my-account') && !is_user_logged_in()) {
            ?>
            <style>
                #my_account {
                    display: none;
                }
            </style>
            <?php
        }
    }

    add_action("template_redirect", 'mmt_redirection_url_product_checkout', 5, 3);
}

if (!function_exists('mmt_checkout_update_order_review')) {

    function mmt_checkout_update_order_review($post_data) {

        parse_str($post_data, $post_data_repeat);
        $list = array();

        //mmt_cart_only_one_item();

        foreach ($post_data_repeat as $key => $data) {
            if (strpos($key, "mmt_repeat_") !== false) {
                $list[$key] = $data;
            }
        }
        if (!empty($_POST) && !empty($_POST['upgrade_private_reset'])) {
            
        } else {
            if (!empty($list)) {
                WC()->session->set('mmt-repeat', $list);
            } else {
                WC()->session->set('mmt-repeat', array());
            }
        }

        $dateArray = array();
        if (!empty($post_data_repeat['mmt_date_options']) && $post_data_repeat['mmt_date_options'] == 'yes') {
            $dateArray['mmt_date_options_price'] = $post_data_repeat['mmt_date_options_price'];
            $dateArray['mmt_date_name'] = $post_data_repeat['mmt_date_name'];
            $dateArray['mmt_date_options_person'] = $post_data_repeat['mmt_date_options_person'];
            WC()->session->set('mmt-date', $dateArray);
        } else {
            WC()->session->set('mmt-date', $dateArray);
        }
    }

    add_action('woocommerce_checkout_update_order_review', 'mmt_checkout_update_order_review', 10, 4);
}

if (!function_exists('mmt_before_booking_form')) {

    function mmt_before_booking_form() {
        ?>
        <input type="hidden" class="mmt-check-island" name="mmt-check-island" value="">
        <?php
    }

    add_action('woocommerce_before_booking_form', 'mmt_before_booking_form', 10, 3);
}


if (!function_exists('mmt_general_settings')) {

    function mmt_general_settings($settings) {

        $options = array(
            array(
                'title' => 'List Hotel',
                'id' => 'mmt_list_hotel',
                'css' => 'min-height:450px;',
                'type' => 'textarea',
            ),
            array(
                'type' => 'sectionend',
                'id' => 'pricing_options',
            ),
        );

        array_pop($settings);

        return array_merge($settings, $options);
    }

//  add_filter( 'woocommerce_general_settings', 'mmt_general_settings', 10, 4 );
}
if (!function_exists('mmt_add_session_fee_hotel_vp_tour')) {

    function mmt_add_session_fee_hotel_vp_tour($cart_item_key, $productId, $quantity, $variation_id, $variation, $cart_item_data) {
        $vp_hotel_tax = WC()->session->get('vp_hotel_tax');
        if(!empty($vp_hotel_tax) && (is_object_in_term($productId, 'product_tag', 'Package') || is_object_in_term($productId, 'product_tag', 'Packages'))) {
            WC()->session->set('fees_hotel_vp', $vp_hotel_tax);
            WC()->session->set('vp_hotel_tax', '');
        }
        
        return $cart_item_key;
    }

    add_action('woocommerce_add_to_cart', 'mmt_add_session_fee_hotel_vp_tour', 10, 6);
}
if (!function_exists('mmt_cart_calculate_fees')) {

    function mmt_cart_calculate_fees($cart_object) {
        $vp_hotel_tax = WC()->session->get('fees_hotel_vp');
        if(!empty($vp_hotel_tax)) {
            if ( ! empty( WC()->cart->get_cart() ) ) {
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                    if (is_object_in_term($product_id, 'product_tag', 'Package') || is_object_in_term($product_id, 'product_tag', 'Packages')) {
                        $cart_object->add_fee('Hotel Tax: ', $vp_hotel_tax, true);
                    }
                }
            }
        }
        if (mmt_is_friday_tour()) {
            $count = mmt_count_person_cart();
            $price = 10 * $count;
            if (!empty($price)) {
                $cart_object->add_fee('Friday fireworks only cruise: ', ( 10 * $count), true);
            }
        }

        $listRepeat = WC()->session->get('mmt-repeat');
        if (!empty($listRepeat)) {

            $listRepeatParent = array();
            $listRepeatChild = array();
            $listParentId = array();
            if (!empty($listRepeat)) {
                foreach ($listRepeat as $kr => $vr) {

                    if (is_array($vr)) {
                        foreach ($vr as $arrayVl) {

                            $unRepeat = unserialize(stripslashes($arrayVl));
                            if (empty($unRepeat['is_child'])) {
                                $listRepeatParent[] = $unRepeat;
                                $listParentId[] = $unRepeat['parent'];
                            } else {
                                $listRepeatChild[] = $unRepeat;
                            }
                        }
                    } else {
                        $unRepeat = unserialize(stripslashes($vr));

                        if (empty($unRepeat['is_child'])) {
                            $listRepeatParent[] = $unRepeat;
                            $listParentId[] = $unRepeat['parent'];
                        } else {
                            $listRepeatChild[] = $unRepeat;
                        }
                    }
                }
            }

            if (!empty($listRepeatParent)) {
                foreach ($listRepeatParent as $arrayRepeat) {
                    if (!empty($arrayRepeat['price'])) {
                        if (!empty($arrayRepeat['person']) && !empty($arrayRepeat['person'][0])) {
                            $price = (float) $arrayRepeat['price'] * (float) mmt_count_person_cart();
                        } else {
                            $price = (float) $arrayRepeat['price'];
                        }
                        $quantity = $listRepeat['mmt_repeat_quantity_' . mmt_convert_text_id($arrayRepeat['label'])];

                        if (!empty($quantity)) {
                            $price = (float) $quantity * (float) $price;
                            $cart_object->add_fee($arrayRepeat['title'] . ' - ' . $arrayRepeat['label'] . ': ' . $quantity, $price, true);
                        } else {
                            $cart_object->add_fee($arrayRepeat['title'] . ' - ' . $arrayRepeat['label'], $price, true);
                        }
                    }
                }
            }

            if (!empty($listRepeatChild)) {
                foreach ($listRepeatChild as $arrayRepeat) {
                    if (!empty($arrayRepeat['price']) && in_array($arrayRepeat['parent'], $listParentId)) {
                        if (!empty($arrayRepeat['person']) && !empty($arrayRepeat['person'][0])) {
                            $price = (float) $arrayRepeat['price'] * (float) mmt_count_person_cart();
                        } else {
                            $price = (float) $arrayRepeat['price'];
                        }
                        $quantity = $listRepeat['mmt_repeat_quantity_' . mmt_convert_text_id($arrayRepeat['label'])];

                        if (!empty($quantity)) {
                            $price = (float) $quantity * (float) $price;
                            $cart_object->add_fee($arrayRepeat['title'] . ' - ' . $arrayRepeat['label'] . ': ' . $quantity, $price, true);
                        } else {
                            $cart_object->add_fee($arrayRepeat['title'] . ' - ' . $arrayRepeat['label'], $price, true);
                        }
                    }
                }
            }
        }

        $date = WC()->session->get('mmt-date');

        if (!empty($date)) {
            if (!empty($date['mmt_date_options_person']) && $date['mmt_date_options_person'] == 'yes') {
                $priceDate = (float) $date['mmt_date_options_price'] * (float) mmt_count_person_cart();
            } else {
                $priceDate = (float) $date['mmt_date_options_price'];
            }

            $cart_object->add_fee($date['mmt_date_name'] . ' options ', $priceDate, true);
        }
    }

    add_action('woocommerce_cart_calculate_fees', 'mmt_cart_calculate_fees', 99, 3);
}


if (!function_exists('mmt_before_add_to_cart_button')) {

    function mmt_before_add_to_cart_button() {

        global $post;

        $productId = $post->ID;
        $lunchOptions = get_post_meta($productId, 'mmt_section_lunch_options', true);

        if (!empty($lunchOptions)) {
            $lunchOptions = unserialize($lunchOptions);
        }

        if (!empty($lunchOptions)) {

            $lunchOptions = mmt_format_list_data_repeater($lunchOptions);
            $lunchOptionsParent = $lunchOptions['parent'];
            $lunchOptionsChild = $lunchOptions['child'];
            mmt_billing_form_repeater($lunchOptionsParent, $lunchOptionsChild);
        }
    }

//  add_action( 'woocommerce_before_add_to_cart_button', 'mmt_before_add_to_cart_button', 10, 4 );
}


if (!function_exists('cpt_add_to_cart_validation')) {

    function cpt_add_to_cart_validation($passed) {
        if (!empty($_REQUEST['add-to-cart']) && $_REQUEST['add-to-cart'] == '3613' && !empty($_REQUEST['wc_bookings_field_start_date_month']) && !empty($_REQUEST['wc_bookings_field_start_date_day']) && !empty($_REQUEST['wc_bookings_field_start_date_year'])) {
            $monthR = $_REQUEST['wc_bookings_field_start_date_month'];
            $dayR = $_REQUEST['wc_bookings_field_start_date_day'];
            $yearR = $_REQUEST['wc_bookings_field_start_date_year'];
            $startDate = strtotime($monthR . '/' . $dayR . '/' . $yearR);
            $day = date('l', $startDate);
            $month = date('m', $startDate);
            if ($day == 'Wednesday') {
                if ($month == '06' || $month == '07' || $month == '08') {
                    return $passed;
                } else {
                    WC()->session->set('mmt-cart-error', 'Sorry, Wednesday is only available in June, July and August.');

                    return false;
                }
            }
        }

        return $passed;
    }

    add_filter('woocommerce_add_to_cart_validation', 'cpt_add_to_cart_validation', 10, 1);
}

if (!function_exists('cpt_before_single_product')) {

    function cpt_before_single_product() {
        $cartError = WC()->session->get('mmt-cart-error');
        if (!empty($cartError)) {
            ?>
            <div class="mmt-show-error">
                <?php echo $cartError; ?>
            </div>
            <?php
        }
        WC()->session->set('mmt-cart-error', '');
    }

    add_action('woocommerce_single_product_summary', 'cpt_before_single_product', 10, 3);
}

if (
    !function_exists('mm_add_meta_box_location_for_product' )
    &&
    !function_exists('mm_save_location_product_meta_box_data' )
) {
    add_action('woocommerce_product_options_general_product_data', 'mm_add_meta_box_location_for_product');
    add_action('woocommerce_process_product_meta', 'mm_save_location_product_meta_box_data');
    function mm_add_meta_box_location_for_product() {
        global $post;
        $location_value = get_post_meta($post->ID, '_mm_location', true);
        woocommerce_wp_text_input(array(
            'id' => '_mm_location',
            'label' => 'Location',
            'value' => $location_value,
        ));
    }
    function mm_save_location_product_meta_box_data($post_id) {
        if (!current_user_can('edit_post', $post_id)) return;
        $location_value = sanitize_text_field($_POST['_mm_location']);
        update_post_meta($post_id, '_mm_location', $location_value);
    }    
}

add_action('woocommerce_product_options_general_product_data', 'hawaiitour_add_contact_button_settings');
if (!function_exists('hawaiitour_add_contact_button_settings')) {

    function hawaiitour_add_contact_button_settings() {
        global $post;

        $product = wc_get_product($post);

        if (!$product || in_array($product->get_type(), array('variable'))) {
            return;
        }
        $mm_duration = get_post_meta($post->ID, '_mm_duration', true);
        $mm_duration_unit = get_post_meta($post->ID, '_mm_duration_unit', true);
        $mm_pickup = get_post_meta($post->ID, '_mm_pickup', true);
        
        ?>
        <div class="options_group">
            <p class="form-field">
                <label for="_mm_duration_type"><?php _e( 'Duration', 'MM' ); ?></label>
                <input type="text" name="_mm_duration" id="_mm_duration" value="<?php echo $mm_duration; ?>" style="margin-right: 7px; width: 4em;" inputmode="decimal"  step="0.01" oninput="this.value = formatDecimalInput(this.value);">
                <select name="_mm_duration_unit" id="_mm_duration_unit" class="short" style="width: auto; margin-right: 7px;">
                    <option value="day" <?php selected( $mm_duration_unit, 'day' ); ?>><?php _e( 'Day(s)', 'MM' ); ?></option>
                    <option value="hour" <?php selected( $mm_duration_unit, 'hour' ); ?>><?php _e( 'Hour(s)', 'MM' ); ?></option>
                    <option value="minute" <?php selected( $mm_duration_unit, 'minute' ); ?>><?php _e( 'Minute(s)', 'MM' ); ?></option>
                </select>
            </p>
        </div>
        <script>
            function formatDecimalInput(value) {
                value = value.replace(/[^0-9.]/g, '');

                const decimalCount = value.split('.').length - 1;
                if (decimalCount > 1) {
                value = value.slice(0, value.lastIndexOf('.'));
                }

                const parts = value.split('.');
                if (parts.length === 2) {
                value = `${parts[0]}.${parts[1].slice(0, 2)}`;
                }
                return value;
            }
            </script>
        <?php
        woocommerce_wp_select(
            array(
                'id' => '_mm_pickup',
                'value' => $mm_pickup,
                'label' => 'Pickup',
                'options' => array(
                    '' => '--select--',
                    'pickup semi-avail' => 'Pickup Semi-Avail',
                    'pickup available' => 'Pickup Available',
                ),
                'wrapper_class' => '',
                'name' => '_mm_pickup',
            )
        );
        woocommerce_wp_checkbox(array(
            'label' => __('Only Book via Phone or Contact Us', 'MM'),
            'id' => 'enable_contact_us_button',
        ));
    }

}
if (!function_exists('hawaiitour_add_contact_button_fields_save')) {
    add_action('woocommerce_process_product_meta', 'hawaiitour_add_contact_button_fields_save');

    function hawaiitour_add_contact_button_fields_save($post_id) {

        $enable_contact = $_POST['enable_contact_us_button'];
        $mm_duration = $_POST['_mm_duration'];
        $mm_duration_unit = $_POST['_mm_duration_unit'];
        $mm_pickup = $_POST['_mm_pickup'];

        update_post_meta($post_id, 'enable_contact_us_button', esc_attr($enable_contact));
        if($mm_duration){
            update_post_meta($post_id, '_mm_duration', esc_attr($mm_duration));
            update_post_meta($post_id, '_mm_duration_unit', esc_attr($mm_duration_unit));
        }
        if($mm_pickup){
            update_post_meta($post_id, '_mm_pickup', esc_attr($mm_pickup));
        }else{
            delete_post_meta($post_id,'_mm_pickup');
        }
    }
}
add_action('woocommerce_product_options_general_product_data', 'hawaiitour_add_fareharbor_link_settings');
if (!function_exists('hawaiitour_add_fareharbor_link_settings')) {

    function hawaiitour_add_fareharbor_link_settings() {
        global $post;

        $product = wc_get_product($post);

        if (!$product || in_array($product->get_type(), array('variable'))) {
            return;
        }
        $mm_change_time = get_post_meta( $post->ID, 'mm_change_time', true );
        woocommerce_wp_checkbox(
            array(
                'id' => 'mm_change_time',
                'value' => !empty($mm_change_time) ? 'yes' : '',
                'label' => __('Change time to Morning and Afternoon', 'woocommerce-bookings'),
                
            )
        );
        woocommerce_wp_text_input(array(
            'label' => __('Check In Time', 'MM'),
            'id' => 'mm_check_in_time',
            'type' => 'number',
            'placeholder' => 'Enter number minutes before Tour Start Time',
        ));
        woocommerce_wp_text_input(array(
            'label' => __('Fareharbor Popup URL', 'MM'),
            'id' => 'enable_fareharbor_popup_link',
        ));
        woocommerce_wp_text_input(array(
            'label' => __(' Fareharbor Calendar URL', 'MM'),
            'id' => 'enable_fareharbor_link',
        ));
        /*woocommerce_wp_checkbox(array(
            'label' => __('Overwrite the Global Booking Duration Settings', 'MM'),
            'id' => 'enable_overwrite_36_hours',
        ));*/
        woocommerce_wp_text_input(array(
            'label' => __('Vendor', 'MM'),
            'id' => 'mm_product_vendor',
        ));
        woocommerce_wp_text_input(array(
            'label' => __('Vendor Tour name', 'MM'),
            'id' => 'mm_vendor_tour_name',
        ));
        woocommerce_wp_text_input(array(
            'label' => __('Vendor URL', 'MM'),
            'id' => 'mm_vendor_product',
        ));
        $mm_select_booking_type = get_post_meta( $post->ID, 'mm_select_booking_type', true );
        woocommerce_wp_select( array(
            'id'      => 'mm_select_booking_type',
            'label'   => __( 'Booking Type', 'woocommerce' ),
            'options' =>  array(
                '' => 'Select Booking Type',
                'fhapi' => 'FHAPI',
                'fhdn' => 'FHDN',
                'fhpopup' => 'FH Popup',
                'woo' => 'WOO',
                'ponorezapi' => 'Ponorez API',
                'contactform' => 'Contact Form',
            ), 
            'value'   => $mm_select_booking_type,
        ) );
    }

}
add_action('woocommerce_process_product_meta', 'hawaiitour_add_fareharbor_link_fields_save');

function hawaiitour_add_fareharbor_link_fields_save($post_id) {

    $fareharbor_link = $_POST['enable_fareharbor_link'];
    update_post_meta($post_id, 'enable_fareharbor_link', esc_attr($fareharbor_link));
    $fareharbor_popup_link = $_POST['enable_fareharbor_popup_link'];
    update_post_meta($post_id, 'enable_fareharbor_popup_link', esc_attr($fareharbor_popup_link));
    //$overwrite_36_hours = $_POST['enable_overwrite_36_hours'];
    //update_post_meta($post_id, 'enable_overwrite_36_hours', esc_attr($overwrite_36_hours));
    $mm_vendor = $_POST['mm_product_vendor'];
    update_post_meta($post_id, 'mm_product_vendor', esc_attr($mm_vendor));
    $mm_vendor_tour_name = $_POST['mm_vendor_tour_name'];
    update_post_meta($post_id, 'mm_vendor_tour_name', esc_attr($mm_vendor_tour_name));
    $mm_vendor_product = $_POST['mm_vendor_product'];
    update_post_meta($post_id, 'mm_vendor_product', esc_attr($mm_vendor_product));
    
    $mm_select_booking_type = $_POST['mm_select_booking_type'];
    update_post_meta($post_id, 'mm_select_booking_type', esc_attr($mm_select_booking_type));
    $mm_change_time = $_POST['mm_change_time'];
    update_post_meta($post_id, 'mm_change_time', $mm_change_time);
    $mm_check_in_time = $_POST['mm_check_in_time'];
    update_post_meta($post_id, 'mm_check_in_time', $mm_check_in_time);
}

if (!function_exists('mm_product_detail_redirect_to_fareharbor_link')) {

    function mm_product_detail_redirect_to_fareharbor_link() {
        global $post;
        $fareharbor_link = get_post_meta($post->ID, 'enable_fareharbor_link', true);
        if (!empty($fareharbor_link)) {
            wp_redirect($fareharbor_link);
            exit;
        }
    }

    //add_action('wp_head', 'mm_product_detail_redirect_to_fareharbor_link');
}
if (!function_exists('mm_disable_reviews_tab_product')) {

    function mm_disable_reviews_tab_product() {
        remove_post_type_support('product', 'comments');
    }

}
add_action('init', 'mm_disable_reviews_tab_product');


if (!function_exists('filter_woocommerce_output_related_products_args')) {

// define the woocommerce_output_related_products_args callback 
    function filter_woocommerce_output_related_products_args($args) {
        $args = array(
            'posts_per_page' => 4,
            'columns' => 3,
            'orderby' => 'rand',
            'post_status' => 'publish',
        );
        return $args;
    }

// add the filter 
    add_filter('woocommerce_output_related_products_args', 'filter_woocommerce_output_related_products_args', 10, 1);
}

//change text button place order checkout
if (!function_exists('mm_checkout_order_button_text')) {
    add_filter('woocommerce_order_button_text', 'mm_checkout_order_button_text');

    function mm_checkout_order_button_text() {
        return __('Purchase Now', 'woocommerce');
    }

}

if (!function_exists('cart_empty_redirect_to_shop')) {

    function cart_empty_redirect_to_shop() {
        global $woocommerce;
        $classes = get_body_class();
        if (in_array('woocommerce-order-received', $classes) || in_array('woocommerce-order-pay', $classes)) {
            
        } elseif (is_page('checkout') and $woocommerce->cart->cart_contents_count == 0) {
            wp_redirect(get_permalink(wc_get_page_id('shop')));
            exit;
        }
    }

    add_action('wp_head', 'cart_empty_redirect_to_shop');
}

if (!function_exists('woo_remove_product_tabs')) {
    add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 98);

    function woo_remove_product_tabs($tabs) {
        global $product;

        if ($product->has_attributes() || $product->has_dimensions() || $product->has_weight()) {
            unset($tabs['additional_information']);
        }
        return $tabs;
    }

}
if (!function_exists('hide_coupon_field_on_checkout')) {

// hide coupon field on checkout page
    function hide_coupon_field_on_checkout($enabled) {
        if (is_checkout()) {
            $enabled = false;
        }
        return $enabled;
    }

    add_filter('woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout');
}


add_filter('wc_add_to_cart_message_html', '__return_null');

if (!function_exists('custom_prices_decimal')) {

    function custom_prices_decimal($number_format, $price, $decimals, $decimal_separator, $thousand_separator) {
        // Split the total
        $price = explode('.', $number_format);
        return '<span class="custom-prc">' . $price[0] . '<sup>.' . $price[1] . '</sup></span>';
    }

    add_filter('formatted_woocommerce_price', 'custom_prices_decimal', 10, 5);
}
add_filter('the_excerpt', 'do_shortcode');

function mm_excerpt_in_product_archives() {

    $mm_builder_open = get_post_meta( get_the_ID(), 'mm_builder', true );
    if ($mm_builder_open == 'activate'){
        $short_description = get_post_meta( get_the_ID(), 'short_description_description', true );
        if($short_description){
            $description = wordwrap($short_description, 65);
            $description = explode("\n", $description);
            $description = $description[0] . '...';
            $short_description = $description . ' <span class="more-description">More</span>';
            echo '<p>' . $short_description . '</p>';
        }

        $number_list_items = get_post_meta(get_the_ID(), 'short_description_list_items', true);
        if($number_list_items > 0){
            $output_list_items = "";
            for( $j = 0; $j < $number_list_items; $j++ ){
                $list_items_text = get_post_meta( get_the_ID(), 'short_description_list_items_' . $j . '_text', true );
                $list_items_icon = get_post_meta( get_the_ID(), 'short_description_list_items_' . $j . '_icon', true );
                if( $list_items_text ){
                    $output_list_items .= '<li>';
                    if( $list_items_icon ){
                        $src_text = wp_get_attachment_url( $list_items_icon );
                        $alt_text = get_post_meta($list_items_icon, '_wp_attachment_image_alt', true);
                        
                        $output_list_items .= '<div class="av-icon-char" style="padding-right: 10px;" aria-hidden="true">';
                        $output_list_items .= '<img loading="lazy" src="' . $src_text . '" alt="' . $alt_text . '" width="55" height="55">';
                        $output_list_items .= '</div>';
                    }
                    $output_list_items .= $list_items_text;
                    $output_list_items .= '</li>';
                }
            }
            echo '<ul style="padding-top: 20px">' . $output_list_items . '</ul>';
        }
    }else{ 
        // $excerpt = get_post_meta(get_the_ID(), 'description_inner', true);
        // if($excerpt){
        //     $excerpt = $products_val['exc'];
        //     if (is_front_page() || $excerpt == '') {
        //         $excerpt = $products_val['exc'];
        //     } else {
        //         $excerpt = stripslashes(wpautop(trim(html_entity_decode($excerpt))));
        //     }
        //     $pos_array = array();
        //     if (strlen(strstr($excerpt, '</p>')) > 0) {
        //         $pos_array[] = strpos($excerpt, '</p>');
        //     }
        //     if (strlen(strstr($excerpt, '<br')) > 0) {
        //         $pos_array[] = strpos($excerpt, '<br');
        //     }
        //     if (strlen(strstr($excerpt, 'av_hr')) > 0) {
        //         $pos_array[] = strpos($excerpt, '[av_hr');
        //     }
        //     if(empty($pos_array)){
        //         if (strlen(strstr($excerpt, '<ul')) > 0) {
        //             $pos_array[] = strpos($excerpt, '<ul');
        //         }
        //     }
        //     if (!empty($pos_array)) {
        //         $pos = min($pos_array);
        //         $description = substr($excerpt, 0, $pos);
        //         $feature_list = substr($excerpt, $pos);
        //         $description = wordwrap($description, 65);
        //         $description = explode("\n", $description);
        //         $description = $description[0] . '...';
        //         $excerpt = $description . ' <span class="more-description">More</span> ' . $feature_list;
        //     }
        //     echo $excerpt;
        // }else{
        //     $excerpt_inner = get_the_excerpt();
        //     $excerpt_inner = stripslashes(wpautop(trim(html_entity_decode( $excerpt_inner) )));
        //     $pos_array = array();
        //     if (strlen(strstr($excerpt_inner, '</p>')) > 0) {
        //         $pos_array[] = strpos($excerpt_inner, '</p>');
        //     }
        //     if (strlen(strstr($excerpt_inner, '<br')) > 0) {
        //         $pos_array[] = strpos($excerpt_inner, '<br');
        //     }
        //     if (strlen(strstr($excerpt_inner, 'av_hr')) > 0) {
        //         $pos_array[] = strpos($excerpt_inner, '[av_hr');
        //     }
        //     if(empty($pos_array)){
        //         if (strlen(strstr($excerpt_inner, '<ul')) > 0) {
        //             $pos_array[] = strpos($excerpt_inner, '<ul');
        //         }
        //     }
        //     if(!empty($pos_array)){
        //         $pos = min($pos_array);
        //         $description = substr($excerpt_inner,0,$pos);
        //         $feature_list = substr($excerpt_inner,$pos);
        //         $description = wordwrap($description, 155);
        //         $description = explode("\n", $description);
        //         $description = $description[0] . '...';
        //         $excerpt_inner = $description.' <span class="more-description">More</span> '.$feature_list;
        //     }
        //     echo do_shortcode($excerpt_inner);
        // }
        $excerpt_inner = get_the_excerpt();
        $excerpt_inner = stripslashes(wpautop(trim(html_entity_decode( $excerpt_inner) )));
        $pos_array = array();
        if (strlen(strstr($excerpt_inner, '</p>')) > 0) {
            $pos_array[] = strpos($excerpt_inner, '</p>');
        }
        if (strlen(strstr($excerpt_inner, '<br')) > 0) {
            $pos_array[] = strpos($excerpt_inner, '<br');
        }
        if (strlen(strstr($excerpt_inner, 'av_hr')) > 0) {
            $pos_array[] = strpos($excerpt_inner, '[av_hr');
        }
        if(empty($pos_array)){
            if (strlen(strstr($excerpt_inner, '<ul')) > 0) {
                $pos_array[] = strpos($excerpt_inner, '<ul');
            }
        }
        if(!empty($pos_array)){
            $pos = min($pos_array);
            $description = substr($excerpt_inner,0,$pos);
            $feature_list = substr($excerpt_inner,$pos);
            $description = wordwrap($description, 155);
            $description = explode("\n", $description);
            $description = $description[0] . '...';
            $excerpt_inner = $description.' <span class="more-description">More</span> '.$feature_list;
        }
        echo do_shortcode($excerpt_inner);
    }
}

add_action('woocommerce_after_shop_loop_item_title', 'mm_excerpt_in_product_archives', 40);

if (!function_exists('wc_custom_add_custom_fields')) {

    function wc_custom_add_custom_fields() {
        // Print a custom text field
        woocommerce_wp_text_input(array(
            'id' => '_custom_layer_slider',
            'label' => 'Layer Slider',
            'description' => 'This is a custom field, you can write here anything you want.',
            'desc_tip' => 'true',
            'placeholder' => 'Custom text'
        ));
    }

    add_action('woocommerce_product_options_general_product_data', 'wc_custom_add_custom_fields');
}

if (!function_exists('mm_woo_purchase_title_box')) {

    function mm_woo_purchase_title_box() {
        ?><h2 style="text-align:center;margin-bottom: 20px;">BOOK YOUR TOUR</h2><?php
    }

    //add_action('woocommerce_before_booking_form', 'mm_woo_purchase_title_box');
}
if (!function_exists('mm_avia_woocommerce_thumbnail')) {

    function mm_avia_woocommerce_thumbnail() {
        global $product, $wpdb;

        if (function_exists('wc_get_rating_html')) {
            $rating = wc_get_rating_html($product->get_average_rating());
        } else {
            $rating = $product->get_rating_html(); //get rating
        }

        $id = get_the_ID();
        $size = 'shop_catalog';

        echo "<div class='thumbnail_container mm_thumbnail'>";
        ?>
        <div class="mm-tag-button">
            <?php
            if (is_object_in_term($id, 'product_tag', 'likely-to-sell-out')) {
                ?>
                <span class="tag-like-to-sell-out">Likely to Sell Out</span>
                <?php
            }
            ?>
            <?php
            if (is_object_in_term($id, 'product_tag', 'popular-tour')) {
                ?>
                <span class="tag-popular-tour">Popular Tour</span>
                <?php
            }
            ?>
        </div>
        <?php
        echo avia_woocommerce_gallery_first_thumbnail($id, $size);

        if (get_the_post_thumbnail($id, $size)) {
            echo get_the_post_thumbnail($id, $size);
        } else {
            echo "<img src='https://via.placeholder.com/450'/>";
        }
        if (!empty($rating))
            echo "<span class='rating_container'>" . $rating . "</span>";
        if ($product->get_type() == 'simple')
            echo "<span class='cart-loading'></span>";
        $rating = 5;
        $postmeta_table = $wpdb->prefix . "postmeta";
        $query_rating = "
            SELECT      meta_value
            FROM        $postmeta_table
            WHERE       `post_id` = %s AND `meta_key` LIKE '%bsf-schema-pro-rating%'
        ";
        $query_rating = $wpdb->prepare($query_rating, $id);
        $results_rating = $wpdb->get_results($query_rating);
        if(!empty($results_rating)){
            if(isset($results_rating[0]->meta_value)){
                $rating = $results_rating[0]->meta_value;
            }
        }
        $full  = '<span class="dashicons dashicons-star-filled"></span>';
        $semi  = '<span class="dashicons dashicons-star-half"></span>';
        $empty = '<span class="dashicons dashicons-star-empty"></span>';

        $html_rating = str_repeat( $full, floor( $rating ) );

        if( $rating > floor( $rating ) ){

            $html_rating .= $semi;
        }

        $html_rating .= str_repeat( $empty, 5 - ceil( $rating ) );
        $star_rating = '<span class="mm-title-rating">'.$html_rating.'</span>';
        echo '<h2 class="woocommerce-loop-product__title title_mm">' . get_the_title() . $star_rating. '</h2>';
        echo "</div>";
    }

    add_action('woocommerce_before_shop_loop_item_title', 'mm_avia_woocommerce_thumbnail', 10);
}

function hw_func_add_field_hidden_checkout($checkout) {
    $total_people = $adult = $child = $junior = 0;
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $tour_id = $cart_item['product_id'];
        if ($cart_item['booking']['Adult']) {
            $adult += $cart_item['booking']['Adult'];
        }
        if ($cart_item['booking']['Child']) {
            $child += $cart_item['booking']['Child'];
        }
        if ($cart_item['booking']['Junior']) {
            $junior += $cart_item['booking']['Junior'];
        }
    }
    $total_people = $adult + $child + $junior;
    echo '<input type="hidden" name="product_id_hw" class="product_id_hw" value="' . $tour_id . '"/>';
    echo '<input type="hidden" name="qty_people" class="mm-qty-people" value="' . $total_people . '"/>';
}

add_action('woocommerce_before_checkout_billing_form', 'hw_func_add_field_hidden_checkout');

add_action('wp', 'mm_redirect_cancel_express_checkout', 1);
if (!function_exists('mm_redirect_cancel_express_checkout')) {

    function mm_redirect_cancel_express_checkout() {
        if (isset($_GET['cancel_express_checkout']) && $_GET['cancel_express_checkout'] == 'cancel') {
            wp_redirect(home_url());
            exit;
        }
    }

}

add_filter('woocommerce_cross_sells_columns', 'mm_change_cross_sells_columns', 20);

function mm_change_cross_sells_columns($columns) {
    return 3;
}

add_filter('woocommerce_cross_sells_total', 'mm_change_cross_sells_product_no', 20);

function mm_change_cross_sells_product_no($columns) {
    return 9;
}

//require_once('optimization-mods.php');

/**
 *
 *  Let the user checkout as guest even if they have an account
 *  @todo tie the order to an email
 *
 */
if (!function_exists('mm_filter_checkout_posted_data')) {

    add_filter('woocommerce_checkout_posted_data', 'mm_filter_checkout_posted_data', 10, 1);

    function mm_filter_checkout_posted_data($data) {

        $email = $data['billing_email'];

        if (email_exists($email))
            $data['createaccount'] = 0;

        return $data;
    }

}

/*
 * Use the customer's details as the "From" information for "New Order" emails in WooCommerce. 
 */

function ht_use_customer_from_address($from_email, $obj) {
    if (is_a($obj, 'WC_Email_New_Order')) {
        $address_details = $obj->object->get_address('billing');
        if (isset($address_details['email']) && '' != $address_details['email']) {

            if (strpos(strtolower($from_email), 'yahoo.com') !== false || strpos(strtolower($from_email), 'aol.com') !== false || strpos(strtolower($from_email), 'verizon.net') !== false) {
                
            } else {
                $from_email = $address_details['email'];
            }
        }
    }
    return $from_email;
}

add_filter('woocommerce_email_from_address', 'ht_use_customer_from_address', 20, 2);

function ht_use_customer_from_name($from_name, $obj) {
    if (is_a($obj, 'WC_Email_New_Order')) {
        $address_details = $obj->object->get_address('billing');
        if (isset($address_details['first_name']) && '' != $address_details['first_name']) {
            $from_name = $address_details['first_name'];
        }
        if (isset($address_details['last_name']) && '' != $address_details['last_name']) {
            $from_name .= ' ' . $address_details['last_name'];
        }
    }
    return $from_name;
}

add_filter('woocommerce_email_from_name', 'ht_use_customer_from_name', 20, 2);

if(!function_exists('mm_new_order_reply_to_admin_header')){
    function mm_new_order_reply_to_admin_header( $header, $email_id, $order ) {

        if ( $email_id === 'new_order' ){
            $email = new WC_Email($email_id);
            $header = "Content-Type: " . $email->get_content_type() . "\r\n";
            $header .= 'Reply-to: ' . get_option( 'woocommerce_email_from_name' ) . ' <' . get_option( 'woocommerce_email_from_address' ) . ">\r\n";
        }
        return $header;
    }
}
add_filter( 'woocommerce_email_headers', 'mm_new_order_reply_to_admin_header', 20, 3 );


if (!function_exists('mm_dequeue_woocommerce_cart_fragments')) {

    function mm_dequeue_woocommerce_cart_fragments() {
        if (!is_cart() && !is_checkout()) {
            wp_dequeue_script('wc-cart-fragments');
        }
    }

}
add_action('wp_enqueue_scripts', 'mm_dequeue_woocommerce_cart_fragments', 11);
add_filter('woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text');

function wcc_change_breadcrumb_home_text($defaults) {
    // Change the breadcrumb home text from 'Home' to 'Apartment'
    $defaults['home'] = 'Hawaii Tours';
    return $defaults;
}

/* Remove button cancel order */
add_filter('woocommerce_my_account_my_orders_actions', 'mm_hook_remove_my_cancel_button', 10, 2);
if (!function_exists('mm_hook_remove_my_cancel_button')) {

    function mm_hook_remove_my_cancel_button($actions, $order) {
        unset($actions['cancel']);
        return $actions;
    }

}
add_filter( 'woocommerce_cart_item_thumbnail', 'mm_ywgc_custom_cart_product_image', 11, 3 );
if (!function_exists('mm_ywgc_custom_cart_product_image')) {
    function mm_ywgc_custom_cart_product_image( $product_image, $cart_item, $cart_item_key = false ) {

        if ( ! isset( $cart_item[ 'ywgc_amount' ] ) )
            return $product_image;

        $deliminiter1 = apply_filters( 'ywgc_delimiter1_for_cart_image', 'src=' );
        $deliminiter2 = apply_filters( 'ywgc_delimiter2_for_cart_image', '"' );

        if ( ! empty( $cart_item[ 'ywgc_has_custom_design' ] ) ) {

            $design_type = $cart_item[ 'ywgc_design_type' ];

            if ( 'custom' == $design_type ) {

                $image = YITH_YWGC_SAVE_URL . "/" . $cart_item[ 'ywgc_design' ];

                $product_image = '<img width="300" height="300" src="' . $image .'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
        alt="" srcset="' . $image .' 300w, ' . $image .' 600w, ' . $image .' 100w, ' . $image .' 150w, ' . $image .' 768w, ' . $image .' 1024w"
        sizes="(max-width: 300px) 100vw, 300px" />';

            }
            else if ( 'template' == $design_type ) {
                $product_image = wp_get_attachment_image( $cart_item[ 'ywgc_design' ], 'full' );

            }
            else if ( 'custom-modal' == $design_type ) {

                $image_url = $cart_item[ 'ywgc_design' ];

                $product_image = '<img width="300" height="300" src="' . $image_url .'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
        alt="" srcset="' . $image_url .' 300w, ' . $image_url .' 600w, ' . $image_url .' 100w, ' . $image_url .' 150w, ' . $image_url .' 768w, ' . $image_url .' 1024w"
        sizes="(max-width: 300px) 100vw, 300px" />';

            }

        }
        else{

            if ( isset( $cart_item[ 'ywgc_product_as_present' ] ) && $cart_item[ 'ywgc_product_as_present' ] ){

                $image = YITH_YWGC()->get_default_header_image();

                $array_product_image = explode( $deliminiter1, $product_image );
                $array_product_image = explode( $deliminiter2, $array_product_image[1] );

                $product_image = str_replace( $array_product_image[1], $image, $product_image );

            }
            else{

                $_product = wc_get_product( $cart_item[ 'product_id' ] );

                if ( get_class( $_product ) == 'WC_Product_Gift_Card' ){

                    $image_id = get_post_thumbnail_id( $_product->get_id() );
                    $header_image_url = wp_get_attachment_url( $image_id );

                    $array_product_image = explode( $deliminiter1, $product_image );
                    $array_product_image = explode( $deliminiter2, $array_product_image[ 1 ] );

                    $product_image = str_replace( $array_product_image[1], $header_image_url, $product_image );

                }

            }

        }

        return $product_image;
    }
}
add_action( 'admin_menu', 'mm_remove_menu_woo_setting', 99);
if (!function_exists('mm_remove_menu_woo_setting')) {
    function mm_remove_menu_woo_setting() {
      global $current_user;
       
      $user_roles = $current_user->roles;
      $user_role = array_shift($user_roles);
      if($user_role != "administrator") {
        $remove_submenu = remove_submenu_page('woocommerce', 'wc-settings');
      }
    }
}

// add info Vendor resource
//add_action('edit_form_advanced', 'mm_add_snippet_information_resource');
if (!function_exists('mm_add_snippet_information_resource')) {
    function mm_add_snippet_information_resource() {
        acf_add_local_field_group(array(
            'key' => 'field_69me9ffda34fe',
            'title' => 'Snippet Information Resource',
            'fields' => array(
                array(
                    'key' => 'field_69me9ffda34f0',
                    'label' => 'List items',
                    'name' => 'snippet_information',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => ''
                    ),
                    'collapsed' => 'field_69me9ffda34f1',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add New Item',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_69me9ffda34f2',
                            'label' => 'Icon',
                            'name' => 'icon',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => ''
                            ),
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => ''
                        ),
                        array(
                            'key' => 'field_69me9ffda34f3',
                            'label' => 'Content',
                            'name' => 'content',
                            'type' => 'group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => ''
                            ),
                            'layout' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_69me9ffda34f4',
                                    'label' => 'Show Default',
                                    'name' => 'default',
                                    'type' => 'checkbox',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => ''
                                    ),
                                    'choices' => array(
                                        'show' => 'Show on Desktop',
                                        'show-mobile' => 'Show on Mobile'
                                    ),
                                    'allow_custom' => 0,
                                    'default_value' => array(),
                                    'layout' => 'vertical',
                                    'toggle' => 0,
                                    'return_format' => 'value',
                                    'save_custom' => 0
                                ),
                                array(
                                    'key' => 'field_69me9ffda34f5',
                                    'label' => 'Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => ''
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => ''
                                ),
                                array(
                                    'key' => 'field_69me9ffda34f6',
                                    'label' => 'Description',
                                    'name' => 'description',
                                    'type' => 'wysiwyg',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => 'mm-set-height',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                )
                            )
                        )
                    )
                ),
                
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'bookable_resource', 
                    ),
                ),
            ),
        ));
    }
    add_action('acf/init', 'mm_add_snippet_information_resource');
    
}
// add info Vendor resource
add_action('edit_form_advanced', 'mm_add_vendor_meta_resource');
if (!function_exists('mm_add_vendor_meta_resource')) {
    function mm_add_vendor_meta_resource() {
        global $post;
        $post_id = $post->ID;
        $screen = get_current_screen();
        if ($screen->post_type == 'bookable_resource') {
            $mm_resource_age = get_post_meta($post_id, '_mm_resource_age', true);
            $mm_resource_vendor = get_post_meta($post_id, 'mm_resource_vendor', true);
            $mm_vendor_tour_name = get_post_meta($post_id, 'mm_vendor_tour_name', true);
            $mm_vendor_product = get_post_meta($post_id, 'mm_vendor_product', true);
            $mm_duration = get_post_meta($post_id, '_mm_resource_duration', true);
            $mm_duration_unit = get_post_meta($post_id, '_mm_resource_duration_unit', true);
            $mm_resource_checkin_time = get_post_meta($post_id, 'mm_resource_checkin_time', true);

            $mm_booking_location = get_post_meta($post_id, '_wc_booking_location', true);
            $mm_booking_location_link = get_post_meta($post_id, '_wc_booking_location_link', true);
            $mm_place_ids = get_post_meta($post_id, '_wc_place_ids', true);

            $mm_booking_inclusions_default = get_post_meta($post_id, '_wc_booking_inclusions_default', true);
            $mm_booking_inclusions_content = get_post_meta($post_id, '_wc_booking_inclusions_content', true);
            $mm_booking_feature_default = get_post_meta($post_id, '_wc_booking_feature_default', true);
            $mm_booking_feature_content = get_post_meta($post_id, '_wc_booking_feature_content', true);
            $mm_resource_commission_rate = get_post_meta($post_id, 'mm_resource_commission_rate', true);
            // wp_enqueue_script('wc_bookings_writepanel_js');
            wp_nonce_field('bookable_resource_location', 'bookable_resource_location_nonce');
            ?>
           <div class="name-info-item"  style="display: flex; align-items: flex-start; padding: 15px; flex-wrap:wrap; column-gap: 50px; ">
                <div class="wrap-option">
                    <div class="" style="margin-bottom: 10px;">
                        <div class="label">Age</div>
                        <input type="text" name="_mm_resource_age" id="_mm_resource_age" value="<?php echo $mm_resource_age; ?>" placeholder="age" style="width: 100%; max-width: 455px;"/>
                    </div>
                    <div class="">
                        <div class="label"><?php _e( 'Duration', 'MM' ); ?></div>
                            <span class="form-field">
                                <input type="text" name="_mm_resource_duration" id="_mm_resource_duration" value="<?php echo $mm_duration; ?>" style="margin-right: 7px; width: 25em;" inputmode="decimal"  step="0.01" oninput="this.value = formatDecimalInput(this.value);" placeholder="duration">
                                </span>
                            <span class="form-field">
                                <select name="_mm_resource_duration_unit" id="_mm_resource_duration_unit" class="short" style="width: auto; margin-right: 7px; vertical-align: bottom;">
                                    <option value="day" <?php selected( $mm_duration_unit, 'day' ); ?>><?php _e( 'Day(s)', 'MM' ); ?></option>
                                    <option value="hour" <?php selected( $mm_duration_unit, 'hour' ); ?>><?php _e( 'Hour(s)', 'MM' ); ?></option>
                                    <option value="minute" <?php selected( $mm_duration_unit, 'minute' ); ?>><?php _e( 'Minute(s)', 'MM' ); ?></option>
                                </select>
                            </span>
                        <script>
                            function formatDecimalInput(value) {
                                value = value.replace(/[^0-9.]/g, '');
    
                                const decimalCount = value.split('.').length - 1;
                                if (decimalCount > 1) {
                                value = value.slice(0, value.lastIndexOf('.'));
                                }
    
                                const parts = value.split('.');
                                if (parts.length === 2) {
                                value = `${parts[0]}.${parts[1].slice(0, 2)}`;
                                }
                                return value;
                            }
                        </script>
                    </div>
                    <div class="" style="margin-bottom: 10px;">
                        <div class="label"><?php _e( 'Location', 'MM' ); ?></div>
                        <div class="options_group">
                            <input type="text" class="short" style="margin-right: 7px; width: 16em;" name="_wc_booking_location" id="_wc_booking_location" value="<?php echo ($mm_booking_location? $mm_booking_location : '');?>" placeholder="Location" autocomplete="off">
                            <input type="url" class="short" style="margin-right: 7px;width: 15.6em;border: 1px solid #8c8f94;" name="_wc_booking_location_link" id="_wc_booking_location_link" value="<?php echo ($mm_booking_location_link? $mm_booking_location_link : '');?>" placeholder="Link" autocomplete="off">
                        </div>
                    </div>
                    <div class="" style="margin-bottom: 10px;">
                        <div class="label">Check In Time</div>
                        <input type="number" name="mm_resource_checkin_time" value="<?php echo $mm_resource_checkin_time; ?>" placeholder="Enter number minutes before Tour Start Time" style="width: 100%; max-width: 455px;"/>
                    </div>
                    <div class="" style="margin-bottom: 10px;">
                        <div class="label">Vendor</div>
                        <input type="text" name="mm_resource_vendor" value="<?php echo $mm_resource_vendor; ?>" style="width: 100%; max-width: 455px;"/>
                    </div>
                    <div class="" style="margin-bottom: 10px;">
                        <div class="label">Vendor Tour name</div>
                        <input type="text" name="mm_vendor_tour_name" value="<?php echo $mm_vendor_tour_name; ?>" style="width: 100%; max-width: 455px;"/>
                    </div>
                    <div class="" style="margin-bottom: 10px;">
                        <div class="label">Vendor URL</div>
                        <input type="text" name="mm_vendor_product" value="<?php echo $mm_vendor_product; ?>" style="width: 100%; max-width: 455px;"/>
                    </div>
                    <div class="" style="margin-bottom: 10px;">
                        <div class="label">Commission Rate</div>
                        <input type="text" name="mm_resource_commission_rate" value="<?php echo $mm_resource_commission_rate; ?>" style="width: 100%; max-width: 455px;"/>
                    </div>
                </div>
                <div class="wrap-location">
                    <div style="display: none">
                        <input
                            id="pac-input"
                            class="controls"
                            type="text"
                            placeholder="Enter a location"
                            style="margin-top: 10px;border-radius: 0px;border: unset;box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;"
                        />
                    </div>
                    <div id="map"></div>
                    <div id="infowindow-content">
                        <span style="font-weight: 600" id="place-address"></span><span id="place-space"></span><span id="place-id"></span>
                    </div>
                    <div class="lable" style="margin-top: 12px">Place ID : <span data_productID="<?php echo get_the_ID(); ?>"></span></div>
                    
                    <textarea class="place_ids" style="width: 100%;height:125px;" name="_wc_place_ids" id="_wc_place_ids" value="<?php echo ($mm_place_ids? $mm_place_ids : '');?>"><?php echo ($mm_place_ids? $mm_place_ids : '');?></textarea>
                </div>
            </div>

            <?php
        }
    }
}
add_action('save_post', 'mm_add_vendor_meta_resource_save');
if (!function_exists('mm_add_vendor_meta_resource_save')) {

    function mm_add_vendor_meta_resource_save($post_id) {
        //Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        if (isset($_POST['mm_resource_vendor'])) {
            update_post_meta($post_id, 'mm_resource_vendor', $_POST['mm_resource_vendor']);
        }
        if (isset($_POST['mm_vendor_tour_name'])) {
            update_post_meta($post_id, 'mm_vendor_tour_name', $_POST['mm_vendor_tour_name']);
        }
        if (isset($_POST['mm_vendor_product'])) {
            update_post_meta($post_id, 'mm_vendor_product', $_POST['mm_vendor_product']);
        }
        if (isset($_POST['_mm_resource_duration'])) {
            update_post_meta($post_id, '_mm_resource_duration', $_POST['_mm_resource_duration']);
        }
        if (isset($_POST['_mm_resource_duration_unit'])) {
            update_post_meta($post_id, '_mm_resource_duration_unit', $_POST['_mm_resource_duration_unit']);
        }
        if (isset($_POST['mm_resource_checkin_time'])) {
            update_post_meta($post_id, 'mm_resource_checkin_time', $_POST['mm_resource_checkin_time']);
        }
        if (isset($_POST['_wc_booking_location'])) {
            update_post_meta($post_id, '_wc_booking_location', $_POST['_wc_booking_location']);
        }
        if (isset($_POST['_wc_booking_location_link'])) {
            update_post_meta($post_id, '_wc_booking_location_link', $_POST['_wc_booking_location_link']);
        }
        if (isset($_POST['_wc_place_ids'])) {
            update_post_meta($post_id, '_wc_place_ids', $_POST['_wc_place_ids']);
        }
        if (isset($_POST['_wc_booking_inclusions_default'])) {
            update_post_meta($post_id, '_wc_booking_inclusions_default', $_POST['_wc_booking_inclusions_default']);
        }
        if (isset($_POST['_wc_booking_inclusions_content'])) {
            update_post_meta($post_id, '_wc_booking_inclusions_content', $_POST['_wc_booking_inclusions_content']);
        }
        if (isset($_POST['_wc_booking_feature_default'])) {
            update_post_meta($post_id, '_wc_booking_feature_default', $_POST['_wc_booking_feature_default']);
        }
        if (isset($_POST['_wc_booking_feature_content'])) {
            update_post_meta($post_id, '_wc_booking_feature_content', $_POST['_wc_booking_feature_content']);
        }
        if (isset($_POST['_mm_resource_age'])) {
            update_post_meta($post_id, '_mm_resource_age', $_POST['_mm_resource_age']);
        }
        update_post_meta($post_id, 'mm_resource_commission_rate', $_POST['mm_resource_commission_rate']);
    }

}

add_filter('woocommerce_product_export_product_default_columns', 'mm_add_field_export_woo' );


if(!function_exists('mm_add_field_export_woo')){
    function mm_add_field_export_woo( $array ){
        $pos = 3;
        $val = array('permalink' => __('Permalink','woocommerce'));
        return $result = array_merge(array_slice($array, 0, $pos), $val, array_slice($array, $pos));
    }
}

if(!function_exists('mm_add_export_vendor_resource_column')){
    function mm_add_export_vendor_resource_column( $columns ) {

            $columns['vendor_resource_column'] = 'Vendor Resource';

            return $columns;
    }
}
add_filter( 'woocommerce_product_export_column_names', 'mm_add_export_vendor_resource_column' );
add_filter( 'woocommerce_product_export_product_default_columns', 'mm_add_export_vendor_resource_column' );
if(!function_exists('mm_add_export_vendor_resource_data')){
    function mm_add_export_vendor_resource_data( $value, $product ) {

        if ($product->is_type('booking')) {
            if ($product->has_resources() || $product->is_resource_assignment_type('customer')) {
                $resources = $product->get_resources();
                foreach ($resources as $resource) {
                    $resource_id = $resource->ID;
                    $resource_title = $resource->post_title;
                    $resource_vendor_name = get_post_meta($resource_id, 'mm_resource_vendor', true);
                    $resource_vendor_tour_name = get_post_meta($resource_id, 'mm_vendor_tour_name', true);
                    $resource_vendor_product = get_post_meta($resource_id, 'mm_vendor_product', true);
                    if(!empty($resource_vendor_name) || !empty($resource_vendor_tour_name) || !empty($resource_vendor_product)){
                        $value .= 'Resource: '.$resource_title.'; ';
                        $value .= 'Vendor: '.$resource_vendor_name.'; ';
                        $value .= 'Vendor Tour name: '.$resource_vendor_tour_name.'; ';
                        $value .= 'Vendor URL: '.$resource_vendor_product.'; ';
                    }
                }
            }
        }
        return $value;
    }
}
add_filter( 'woocommerce_product_export_product_column_vendor_resource_column', 'mm_add_export_vendor_resource_data', 10, 2 );

add_filter('manage_shop_order_posts_columns', 'mm_product_list_set_wc_define_columns', 12);
if (!function_exists('mm_product_list_set_wc_define_columns')) {

    function mm_product_list_set_wc_define_columns($columns) {
        $columns['mm_product'] = __('Product', 'woocommerce');
        return $columns;
    }

}//mm_hubspot_set_wc_define_columns

add_action('manage_shop_order_posts_custom_column', 'mm_product_list_order_column', 10, 2);

if (!function_exists('mm_product_list_order_column')) {

    function mm_product_list_order_column($column, $post_id) {
        if ('mm_product' !== $column) {
            return;
        }

        $order = wc_get_order($post_id);
        foreach ($order->get_items() as $order_item_id => $item) {
            $product_id = $item->get_product_id();
            echo "<p><a href='".get_the_permalink($product_id)."'>".get_the_title($product_id)."</a></p>";
        }
        
    }

}
add_filter('woocommerce_return_to_shop_text','mm_change_text_return_shop');
if (!function_exists('mm_change_text_return_shop')) {

    function mm_change_text_return_shop($text) {
        $text = 'Continue Browsing Tours, Activities & Packages';
        return $text;
    }

}
add_filter('wc_empty_cart_message','mm_change_text_empty_shop');
if (!function_exists('mm_change_text_empty_shop')) {

    function mm_change_text_empty_shop($text) {
        $text = 'You have nothing booked in your reservation';
        return $text;
    }

}
if (!function_exists('mm_custom_woocommerce_hidden_order_itemmeta')) {
    function mm_custom_woocommerce_hidden_order_itemmeta( $array ){ 
        $array[] = 'mm_product_vendor';
        $array[] = 'mm_vendor_tour_name';
        $array[] = 'mm_vendor_product';
        $array[] = 'mm_fareharbor_pickup_text';
        $array[] = 'mm_fareharbor_pickup_description';
        $array[] = 'mm_fareharbor_order_item_sync';
        $array[] = 'mm_ponorez_order_item_sync';
        $array[] = 'mm_fareharbor_order_item_vendor';
        $array[] = 'mm_fareharbor_api_confirm_url';
        $array[] = 'mm_fareharbor_api_dashboard_url';
        $array[] = 'mm_fareharbor_booking_id';
        $array[] = 'mm_ponorez_errors';
        $array[] = 'mm_fareharbor_errors';
        $array[] = 'mm_ponorez_pickup_text';
        $array[] = 'mm_ponorez_pickup_time_minutes';
        $array[] = 'mm_ponorez_transportation';
        $array[] = 'order_item_hubwoo_ecomm_deal_id';
        $array[] = 'mm_galaxyconnect_order_item_sync';
        $array[] = 'mm_galaxyconnect_booking_id';
        $array[] = 'mm_galaxyconnect_ticketNumber';
        $array[] = 'mm_change_stage_confirmation_sent';
        return $array;
    } 
} 
add_filter('woocommerce_hidden_order_itemmeta', 'mm_custom_woocommerce_hidden_order_itemmeta', 10, 1);

if(!function_exists('mm_filter_woocommerce_display_item_meta')){
    function mm_filter_woocommerce_display_item_meta ( $html, $item, $args ) {
        if ($item->get_meta( 'mm_product_vendor' ) || $item->get_meta( 'mm_vendor_tour_name' ) || $item->get_meta( 'mm_vendor_product' ) || $item->get_meta( 'mm_fareharbor_pickup_text' ) || $item->get_meta( 'mm_fareharbor_pickup_description' ) || $item->get_meta( 'mm_fareharbor_order_item_sync' ) || $item->get_meta( 'mm_fareharbor_order_item_vendor' ) || $item->get_meta( 'mm_fareharbor_api_confirm_url' ) || $item->get_meta( 'mm_fareharbor_api_dashboard_url' ) || $item->get_meta( 'mm_fareharbor_booking_id' )|| $item->get_meta( 'order_item_hubwoo_ecomm_deal_id' )|| $item->get_meta( 'mm_galaxyconnect_order_item_sync' )|| $item->get_meta( 'mm_galaxyconnect_booking_id' )|| $item->get_meta( 'mm_galaxyconnect_ticketNumber' )|| $item->get_meta( 'mm_change_stage_confirmation_sent' )) {
            $html = '';
        }

        return $html;
    }
}
add_filter( 'woocommerce_display_item_meta', 'mm_filter_woocommerce_display_item_meta', 10, 3 );

add_action('woocommerce_order_status_completed', 'mm_count_order_ips_maui_pre_tour', 1, 1);
add_action('woocommerce_order_status_processing', 'mm_count_order_ips_maui_pre_tour', 1, 1);
if (!function_exists('mm_count_order_ips_maui_pre_tour')) {

    function mm_count_order_ips_maui_pre_tour($order_id) {
        if (!$order_id)
            return;
        
        $order = wc_get_order($order_id);
        if ($order->is_paid()) {
            $bookings = WC_Booking_Data_Store::get_booking_ids_from_order_id($order_id);
            foreach ($order->get_items() as $order_item_id => $item) {
                $booking_ids = WC_Booking_Data_Store::get_booking_ids_from_order_item_id($order_item_id);
                if ($booking_ids) {
                    foreach ($booking_ids as $booking_id) {
                        $booking = get_wc_booking($booking_id);
                        $product_id = $booking->get_product_id();
                        if($product_id == '204526'){
                            $order_ips_maui = array();
                            $mm_list_order_ips_maui = get_post_meta($product_id, 'mm_list_order_ips_maui', true);
                            if(!empty($mm_list_order_ips_maui)){
                                $order_ips_maui = explode(",", $mm_list_order_ips_maui);
                                if (!in_array($order_id, $order_ips_maui)) {
                                    $order_ips_maui[] = $order_id;
                                }
                            }else{
                                $order_ips_maui[] = $order_id;
                            }
                            update_post_meta($product_id, 'mm_list_order_ips_maui', implode(",", $order_ips_maui));
                            if(count($order_ips_maui)>11){
                                update_post_meta($product_id, 'enable_contact_us_button', 'yes');
                            }
                        }
                    }
                }
            }
        }
        
    }
}
add_filter( 'password_change_email', '__return_false' );

if( !function_exists('mm_rename_downloads' ) ){
    add_filter( 'woocommerce_account_menu_items', 'mm_rename_downloads' );
    function mm_rename_downloads( $menu_links ){
        $menu_links[ 'orders' ] = 'Reservation';
        return $menu_links;
    }
}
if( !function_exists('mm_remove_my_account_links' ) ){
    add_filter( 'woocommerce_account_menu_items', 'mm_remove_my_account_links' );
    function mm_remove_my_account_links( $menu_links ){

        unset( $menu_links[ 'bookings' ] );
        return $menu_links;
    }
}
if(!function_exists('mm_custom_filter_woocommerce_cart_crosssell_ids')){
    function mm_custom_filter_woocommerce_cart_crosssell_ids( $cross_sells, $cart ) {
        // Initialize
        $cross_sells_ids_in_cart = array();
        $list_product = array(30978);
        $a1_tag = false;
        $list_product_tag = array();
        // Loop through cart items
        foreach ( $cart->get_cart() as $cart_item_key => $values ) {
            if ( $values['quantity'] > 0 ) {
                $product_id = $values['product_id'];
                $cross_sells_ids_in_cart = array_merge( $values['data']->get_cross_sell_ids(), $cross_sells_ids_in_cart );
                if (!in_array($product_id, $list_product)) {
                    $list_product[] = $product_id;
                    $product_tag = get_the_terms( $product_id, 'product_tag' );
                    foreach($product_tag as $tag) {
                        if (!in_array($tag->term_id, $list_product_tag)) {
                            $list_product_tag[] = $tag->term_id;
                        }
                    }
                }
                if (is_object_in_term($product_id,'product_tag','a1')) {
                    $a1_tag = true;
                }
            }
        }
        $tax_query = array();
        if($a1_tag){
            $tax_query[] = array(
                    'taxonomy' => 'product_tag',
                    'field' => 'slug',
                    'terms' => 'a1',
            );

        }else{
            $tax_query[] = array(
                'taxonomy' => 'product_tag',
                'field' => 'term_id',
                'terms' => $list_product_tag,
            );
        }
        //if(empty($cross_sells_ids_in_cart)){
            $args = array(
                'posts_per_page' => 9,
                'post_type' => array('product'),
                'tax_query' => $tax_query,
                'post__not_in' => $list_product,
                'orderby' => 'rand',
            );
            $post = new WP_Query($args);
            while ($post->have_posts()) {
                $post->the_post();
                $post_id = get_the_ID();
                $cross_sells_ids_in_cart[] = $post_id;
            }
            wp_reset_query();
        //}
        // Cleans up an array, comma- or space-separated list of IDs
        $cross_sells = wp_parse_id_list( $cross_sells_ids_in_cart );

        return $cross_sells;
    }
}
add_filter( 'woocommerce_cart_crosssell_ids', 'mm_custom_filter_woocommerce_cart_crosssell_ids', 10, 2 );

//add_filter( 'wcpl_product_likes_products_alternative_hook', '__return_true' );

if( !function_exists( 'mm_get_all_product_likes' ) ){
    function mm_get_all_product_likes() {
        global $wpdb;
                ob_start();
        $user_id = get_current_user_id(); // Not using get user id function from buttons class as already logged in and don't want the not logged in user ids from that function
        $products_liked = $wpdb->get_results( $wpdb->prepare( "SELECT product_id FROM {$wpdb->prefix}wcpl_product_likes WHERE user_id = %s", $user_id ) );
        $products_liked_ids = array();

        if ( !empty( $products_liked ) ) {

            foreach ( $products_liked as $product_liked ) {

                $product = wc_get_product( $product_liked->product_id );

                if ( !empty( $product ) ) {

                    if ( true == $product->is_visible() ) {

                        $products_liked_ids[] = $product_liked->product_id;

                    }

                }

            }

            echo  do_shortcode( '[products paginate="true" class="product-like"  limit="20" columns="3" ids="' . implode( ',', $products_liked_ids ) . '"]' );

        } else {

            echo esc_html( apply_filters( 'wcpl_product_likes_likes_none_text', __( 'No products liked yet.', 'wcpl-product-likes' ) ) );

        }
                return ob_get_clean();

    }
}

add_shortcode( 'all_product_likes', 'mm_get_all_product_likes' );

add_action('wp_ajax_filter_product_by_island', 'mm_filter_product_by_island_function');
add_action('wp_ajax_nopriv_filter_product_by_island', 'mm_filter_product_by_island_function');

if( !function_exists( 'mm_filter_product_by_island_function' ) ){
    function mm_filter_product_by_island_function(){
            
        $island = $_POST['name_island'];
        $result = [];

        global $wpdb;
        $user_id = get_current_user_id(); // Not using get user id function from buttons class as already logged in and don't want the not logged in user ids from that function
        $products_liked = $wpdb->get_results( $wpdb->prepare( "SELECT product_id FROM {$wpdb->prefix}wcpl_product_likes WHERE user_id = %s", $user_id ) );
        $products_liked_ids = array();

        if ( !empty( $products_liked ) ) {

            foreach ( $products_liked as $product_liked ) {

                $product = wc_get_product( $product_liked->product_id );

                if ( !empty( $product ) ) {

                    if ( true == $product->is_visible() ) {

                        $products_liked_ids[] = $product_liked->product_id;

                    }

                }

            }
            if( $island == 'all' ){
                $pro_id = implode( ',', $products_liked_ids );
                $result[] = do_shortcode( '[products  class="product-like"  limit="-1" columns="3"  ids="'.$pro_id.'" ]' );
                $result[] = $island;

                echo json_encode($result);

            }else{
                $result[] = do_shortcode( '[products  class="product-like"  limit="-1" columns="3"  category="'.$island.'" ]' );
                $result[] = implode( ',', $products_liked_ids );

                echo json_encode($result);
            }



        } else {
            echo esc_html( apply_filters( 'wcpl_product_likes_likes_none_text', __( 'No products liked yet.', 'wcpl-product-likes' ) ) );

        }
                exit;
    }
}



add_action('wp_ajax_filter_product_by_island_order_by_id', 'mm_filter_product_by_island_order_by_id_function');
add_action('wp_ajax_nopriv_filter_product_by_island_order_by_id', 'mm_filter_product_by_island_order_by_id_function');

if( !function_exists( 'mm_filter_product_by_island_order_by_id_function' ) ){
    function mm_filter_product_by_island_order_by_id_function(){
        $html_empty_product = '<div class="circle-wrapper">
        <div class="warning circle"></div>
         <div class="icon">
         <i class="fa fa-exclamation"></i>
        </div>
 
       </div>
       <span class="notice-empty-product">No products liked yet</span>';

        if( isset($_POST['list_product_id']) ){
            $arr_product_id = $_POST['list_product_id'];
            $list_product = trim(preg_replace('/\[|\]/i', '', $arr_product_id));
            if(!empty($list_product)){
                echo do_shortcode( '[products  class="product-like"  limit="-1" columns="3"  ids="'.$list_product.'" ]' );
            }else{
                echo  $html_empty_product;
                // echo '<p class="notice-empty-product">No products liked yet</p>';
            }


        }

        wp_die();
    }
}

//ajax check user login to like product
add_action('wp_ajax_check_user_login_like', 'mm_check_user_login_like_function');
add_action('wp_ajax_nopriv_check_user_login_like', 'mm_check_user_login_like_function');

if( !function_exists( 'mm_check_user_login_like_function' ) ){
    function mm_check_user_login_like_function(){
        if( !is_user_logged_in() ) {
            echo do_shortcode('[woocommerce_my_account]');
        }
        if( is_user_logged_in() ){
            echo 'logined';
        }

        wp_die();
    }
}

add_action( 'woocommerce_thankyou', 'mm_create_user_after_booking', 10, 1 );
if(!function_exists('mm_create_user_after_booking')){
    function mm_create_user_after_booking( $order_id ){
        if( ! $order_id ) return;
        if ( is_user_logged_in() ){
            $order = wc_get_order( $order_id );
            $customer_user_id = $order->get_user_id();
            $customer_user = new WP_User($customer_user_id);
            $customer_user_mail = $customer_user->user_email;
            $order_email = $order->get_billing_email();
            if($customer_user_mail != $order_email){
                $email = email_exists( $order_email );  
                $user = username_exists( $order_email );
                if ( $user == false && $email == false ) {
                    $random_password = wp_generate_password();
                    $first_name = $order->get_billing_first_name();
                    $last_name = $order->get_billing_last_name();
                    $role = 'customer';
                    $user_id = wp_insert_user(
                        array(
                            'user_email' => $order_email,
                            'user_login' => $order_email,
                            'user_pass'  => $random_password,
                            'first_name' => $first_name,
                            'last_name'  => $last_name,
                            'role'       => $role,
                        )
                    );
                    // Link past orders to this newly created customer
                    wc_update_new_customer_past_orders( $user_id );

                }
                $user_billing = get_user_by( 'email', $order_email );
                $user_billing_id = $user_billing->ID;
                update_post_meta($order_id, 'mm_customer_create_booking', $customer_user_mail);
                update_post_meta($order_id, '_customer_user', $user_billing_id);
            }
        }
    }
}
add_filter( 'woocommerce_order_number', 'mm_change_woocommerce_order_number' );
if(!function_exists('mm_change_woocommerce_order_number')){
    function mm_change_woocommerce_order_number( $order_id ) {
        $prefix = 'HT-';
        $new_order_id = $prefix . $order_id ;
        return $new_order_id;
    }
}

if (!function_exists('mm_reset_html_booking_box')) {

    function mm_reset_html_booking_box($post_id) {
        if (!isset($_POST['post_type'])) {
            return false;
        }
        if ($_POST['post_type'] != 'product' && $_POST['post_type'] != 'bookable_resource') {
            return false;
        }
        if ($_POST['post_type'] == 'product'){
            $upload_dir = wp_upload_dir();
            $file_resource = $upload_dir['basedir'] . '/mm-bookingbox/' . $post_id.'_resource.json';
            unlink($file_resource);
            $file_person = $upload_dir['basedir'] . '/mm-bookingbox/' . $post_id.'_person.json';
            unlink($file_person);
            $file_custom_bookingbox = $upload_dir['basedir'] . '/mm-bookingbox/' . $post_id.'_bookingbox_option_2.json';
            unlink($file_custom_bookingbox);
            
        }
        if ($_POST['post_type'] == 'bookable_resource'){
            global $wpdb;
            $parents = $wpdb->get_col($wpdb->prepare("SELECT product_id FROM {$wpdb->prefix}wc_booking_relationships WHERE resource_id = %d ORDER BY sort_order;", $post_id));
            foreach ($parents as $parent_id) {
                if (empty(get_the_title($parent_id))) {
                    continue;
                }
                $upload_dir = wp_upload_dir();
                $file_resource = $upload_dir['basedir'] . '/mm-bookingbox/' . $parent_id.'_resource.json';
                unlink($file_resource);
                $file_person = $upload_dir['basedir'] . '/mm-bookingbox/' . $parent_id.'_person.json';
                unlink($file_person);
                $file_custom_bookingbox = $upload_dir['basedir'] . '/mm-bookingbox/' . $parent_id.'_bookingbox_option_2.json';
                unlink($file_custom_bookingbox);

            }
        }
    }
    add_action('save_post', 'mm_reset_html_booking_box', 10, 4);
}

add_filter('woocommerce_product_get_price','mm_change_price_regular_member', 10, 2);
function mm_change_price_regular_member($price, $productd){
    if ( !is_cart() && ! is_checkout() ) {
        $price = round($price);
    }
    return $price;
}

add_filter('sliced_woocommerce_order_item_metas','mm_sliced_woocommerce_order_item_metas', 10, 1);
if(!function_exists('mm_sliced_woocommerce_order_item_metas')){
    function mm_sliced_woocommerce_order_item_metas($item_metas){
        $item_metas_new = array();
        foreach ($item_metas as $key => $value) {
            if(!is_array($value)){
                $item_metas_new[$key] = wpautop( wp_kses_post($value));
            }
        }
        return $item_metas_new;
    }
}

if(!function_exists('mm_custom_product_link_fhpopup')){
    function mm_custom_product_link_fhpopup( $the_permalink, $product ) {
        $fareharbor_link = get_post_meta($product->get_id(), 'enable_fareharbor_popup_link', true);
        $mm_booking_type = get_post_meta($product->get_id(), 'mm_select_booking_type', true);
        if(!empty($fareharbor_link) && $mm_booking_type =='fhpopup'){
            $the_permalink = $fareharbor_link;
        }

        return $the_permalink;
    }
}
add_filter( 'woocommerce_loop_product_link', 'mm_custom_product_link_fhpopup', 10, 2 );

/*Cron change date flash sale*/
add_action('mm_cron_update_date_flash_sale', 'mm_cron_update_date_flash_sale_func');
if(!function_exists('mm_cron_update_date_flash_sale_func')){
    function mm_cron_update_date_flash_sale_func(){
        wp_reset_query();
        $query = new WP_Query();
        $query_product = $query->query(
                array(
                    'post_type' => 'product',
                    'posts_per_page' => 5,
                    //'p' => 34147,
                    'post_status' => 'any',
                    'orderby' => 'date',
                    'order' => 'desc',
                    'fields' => 'ids',
                    'no_found_rows' => true,
                    'ignore_sticky_posts' => true,
                    'meta_query' => array(
                        array(
                            'key' => 'mm_change_date_flash_sale',
                            'compare' => 'NOT EXISTS',
                        ),
                        
                    ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_tag',
                            'field' => 'term_id',
                            'terms' => 17378
                        )
                    ),
                )
        );

        foreach ($query_product as $key => $product_id) {
            $product = wc_get_product($product_id);

            $offset = timezone_offset_get( new DateTimeZone( 'Pacific/Honolulu' ), new DateTime() );
            $num = ($offset >= 0 ) ? '+' : '-';
            $time_zone = $num.(abs( $offset / 3600 ));
            $time_hawaii =date('Y-m-d H:i:s',strtotime($time_zone.' hours',time()));
            $min_date = $product->get_min_date();
            $start_date = strtotime("+{$min_date['value']} {$min_date['unit']}", current_time('timestamp'));
            $time_now = strtotime($time_hawaii);
            $date_now = date('Y-m-d',$time_now);
            $end_day = date('Y-m-d', strtotime("+4day", $time_now));
            //$end_day = date('Y-m-d', strtotime("+2day", $start_date));
            if (is_object_in_term($product_id, 'product_tag', 'package') || is_object_in_term($product_id, 'product_tag', 'packages')) {
                $end_day = date('Y-m-d', strtotime("+14day", $time_now));
                if(strtotime($date_now) >= strtotime('2023-12-18') && strtotime($date_now) < strtotime('2024-01-08')){
                    $date_now = '2024-01-09';
                }
                if ((strtotime($end_day) >= strtotime('2023-12-18')) && strtotime($end_day) < strtotime('2024-01-08')) {
                    $end_day = '2023-12-17';
                }
            }
            if (is_object_in_term($product_id, 'product_tag', 'flights')){
                $end_day = date('Y-m-d', strtotime("+7day", $time_now));
            }
            /*if (is_object_in_term($product_id, 'product_tag', 'hta-oahu')){
                if($time_now < strtotime('2023-12-11')){
                    $date_now = '2023-12-10';
                    $end_day = date('Y-m-d', strtotime("+3day", strtotime($date_now)));
                }
            }*/
            $get_pricings = $product->get_pricing();
            $add_pricing = array();
            if ((strtotime($end_day) >= strtotime($date_now))){
                foreach ($get_pricings as $key => $get_pricing) {
                    if ($get_pricing['type'] == 'custom' &&  $get_pricing['percentage'] == 1 &&  $get_pricing['base_cost'] == 5) {
                        $get_pricing['from'] = $date_now;
                        $get_pricing['to'] = $end_day;
                    }
                    $add_pricing[$key] = $get_pricing;
                }
                if(empty($add_pricing)){
                    $add_pricing[] = array(
                        'type' => 'custom',
                        'percentage' => 1,
                        'base_cost' => 5,
                        'from' => $date_now,
                        'to' => $end_day,
                        'base_modifier' => 'minus'
                    );
                }
                $product->set_props(
                    array(
                        'pricing' => $add_pricing,
                    )
                );
                $product->save();
            }
            update_post_meta($product_id, 'mm_change_date_flash_sale', 'yes');
        }
    }
}

add_action('mm_cron_reset_update_date_flash_sale', 'mm_cron_reset_update_date_flash_sale_func');
if (!function_exists('mm_cron_reset_update_date_flash_sale_func')) {

    function mm_cron_reset_update_date_flash_sale_func() {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => array('product'),
            'meta_query' => array(
                array(
                    'key' => 'mm_change_date_flash_sale',
                    'value' => 'yes',
                    'compare' => '==',
                )
            ),
        );
        $post = new WP_Query($args);
        while ($post->have_posts()) {
            $post->the_post();
            $post_id = get_the_ID();
            delete_post_meta($post_id, 'mm_change_date_flash_sale');
        }
        wp_reset_query();
        $site_title = get_bloginfo('name');
        wp_mail("hungtrinhdn@gmail.com", $site_title . " Cron Change Date Flash Sale - Working", print_r(date('Y-m-d H:i'), true));

    }

}
add_action('save_post_product', 'mm_update_priority_sitemap', 10, 3);
if (!function_exists('mm_update_priority_sitemap')) {

    function mm_update_priority_sitemap($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        $product_tag = get_the_terms($post_id, 'product_tag');
        $tags = wp_list_pluck($product_tag, 'name', 'slug');
        $priority = 100;
        switch (true) {
            case!empty($tags["hta-oahu"]) : $priority = 0;
                break;
            case!empty($tags["hta-maui"]) : $priority = 0;
                break;
            case!empty($tags["hta-kauai"]) : $priority = 0;
                break;
            case!empty($tags["htabigisland"]) : $priority = 0;
                break;
            case!empty($tags["hta"]) : $priority = 0;
                break;
            case!empty($tags["1"]) : $priority = 1;
                break;
            case!empty($tags["2"]) : $priority = 2;
                break;
            case!empty($tags["3"]) : $priority = 3;
                break;
            case!empty($tags["4"]) : $priority = 4;
                break;
            case!empty($tags["5"]) : $priority = 5;
                break;
            case!empty($tags["6"]) : $priority = 6;
                break;
            case!empty($tags["a"]) : $priority = 10;
                break;
            case!empty($tags["a1"]) : $priority = 20;
                break;
            case!empty($tags["a2"]) : $priority = 30;
                break;
            case!empty($tags["a3"]) : $priority = 40;
                break;
            case!empty($tags["a4"]) : $priority = 45;
                break;
            case!empty($tags["b"]) : $priority = 50;
                break;
            case!empty($tags["b1"]) : $priority = 51;
                break;
            case!empty($tags["b2"]) : $priority = 52;
                break;
            case!empty($tags["c"]) : $priority = 60;
                break;
            case!empty($tags["c1"]) : $priority = 61;
                break;
            case!empty($tags["c2"]) : $priority = 62;
                break;
        }
        update_post_meta($post_id, 'filtering_priority_sitemap', $priority);
    }
}
add_action("template_redirect", 'mm_redirection_page_cart');
if(!function_exists('mm_redirection_page_cart')){
    function mm_redirection_page_cart(){
        global $woocommerce;
        if( is_cart()){
            if( WC()->cart->cart_contents_count == 0){
                wp_safe_redirect( get_permalink( 76 ));
            }else{
                wp_safe_redirect( get_permalink( 826 ));
            }
        }

    }
}
add_filter( 'woocommerce_add_to_cart_redirect', 'mm_redirect_checkout_with_vp_tour', 10, 2 );
if(!function_exists('mm_redirect_checkout_with_vp_tour')){
    function mm_redirect_checkout_with_vp_tour( $url, $product ) {
        if ( $product && is_a( $product, 'WC_Product' ) ) {
            $product_id = $product->get_id();
            if((is_object_in_term($product_id, 'product_tag', 'Package') || is_object_in_term($product_id, 'product_tag', 'Packages'))){
                $url = get_permalink( 826 );
            }
        }
        return $url;
    }
}

if (!function_exists('mm_add_price_before_apply_flash_sale')) {
    function mm_add_price_before_apply_flash_sale () {
        if ( is_product() ) {
            $product_id = get_the_ID();
            $is_flash_sale = has_term('Deal', 'product_tag', $product_id);
            if ($is_flash_sale) {
                $WC_Product = wc_get_product($product_id);
                if (!empty($WC_Product)) {
                    $costs = $WC_Product->get_costs();
                    $flash_sale = false;
                    $get_pricings = $WC_Product->get_pricing();
                    $day_flash_sale = []; 

                    if(!empty($get_pricings)){
                        foreach ($get_pricings as $key => $get_pricing) {
                            if ($get_pricing['type'] == 'custom' &&  $get_pricing['percentage'] == 1 &&  $get_pricing['base_cost'] == 5) {
                                $flash_sale = true;
                                $begin = new DateTime($get_pricing['from']);
                                $end = new DateTime($get_pricing['to']);
                                $end = $end->modify('+1 day');
                                $interval = DateInterval::createFromDateString('1 day');
                                $period = new DatePeriod($begin, $interval, $end);
                                foreach ($period as $dt) {
                                    $date_tmp = $dt->format("Y-m-d");
                                    $f_day = date('j', strtotime($date_tmp));
                                    $f_month = date('n', strtotime($date_tmp));
                                    $f_year = date('Y', strtotime($date_tmp));
                                    if (!empty($day_flash_sale['d'])) {
                                        $day_flash_sale['d'] = $day_flash_sale['d'].','.$f_day;
                                    } else {
                                        $day_flash_sale['d'] = $f_day;
                                    }

                                    if (!empty($day_flash_sale['m'])) {
                                        $day_flash_sale['m'] = $day_flash_sale['m'].','.$f_month;
                                    } else {
                                        $day_flash_sale['m'] = $f_month;
                                    }
                                    
                                    if (!empty($day_flash_sale['y'])) {
                                        $day_flash_sale['y'] = $day_flash_sale['y'].','.$f_year;
                                    } else {
                                        $day_flash_sale['y'] = $f_year;
                                    }
                                }
                            }
                        }
                        echo '<div id="mm-data-date-flash-sale" day-flash-sale="'.$day_flash_sale['d'].'" month-flash-sale="'.$day_flash_sale['m'].'" year-flash-sale="'.$day_flash_sale['y'].'"></div>';
                    }
                }
            }
        }
    }
    add_action('wp_footer', 'mm_add_price_before_apply_flash_sale');
}

add_action( 'woocommerce_checkout_create_order', 'mm_check_data_before_creating_order',  10, 2  );
if(!function_exists('mm_check_data_before_creating_order')){
    function mm_check_data_before_creating_order( $order, $data ) {
        if ( ! empty( WC()->cart->get_cart() ) ) {
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                $product = wc_get_product($product_id);
                if ($product->is_type('booking')) {
                    $booking_error = false;
                    if ( ! empty( $cart_item['booking'] )) {
                        if(empty($cart_item['booking']['_date'])){
                            $booking_error = true;
                        }
                        if(($product->get_display_cost() !='' && $product->get_display_cost() != 0) && isset( $cart_item['booking']['_cost'] ) && '' !== $cart_item['booking']['_cost'] ){
                            if($cart_item['booking']['_cost'] == 0){
                                $booking_error = true;
                            }
                        }
                    }else{
                        $booking_error = true;
                    }
                    if($booking_error){
                        throw new Exception( sprintf( __( 'Sorry, your session has expired. <a href="%s" class="wc-backward">Return to shop</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'shop' ) ) ) );
                    }
                }
            
            }
        }
        
    }
}
add_filter( 'booking_form_calculated_booking_cost', 'mm_hook_calculated_booking_cost', 10, 3 );
if(!function_exists('mm_hook_calculated_booking_cost')){
    function mm_hook_calculated_booking_cost($booking_cost, $booking_form, $posted ){
        //$100 discount upon full payment at the time of booking
        if ($posted['add-to-cart'] == 577863){
            if($posted['_sumo_pp_payment_type'] == 'pay_in_full'){
                $booking_cost = $booking_cost - 100;
            }
        }
        return $booking_cost;
    }
}

// Add dates and times to shopping cart 
if (!function_exists('mm_add_dates_and_time_to_shopping_cart')) {
    function mm_add_dates_and_time_to_shopping_cart ($product, $cart_item) {
        if (!empty($cart_item)) {
            $date = $cart_item['booking']['date'];
            $time = $cart_item['booking']['time'];
            if($cart_item['product_id'] == 702635){
                $time = '1:00 pm';
            }
            
            echo '<div class="mm-date-time-fly-cart">
                <div class="mm-date-time-fly-cart-row">
                    <span class="mm-icon-fly-cart mm-icon-fly-cart-calendar"></span><span> '. $date .'</span>
                </div>';
            if(!empty($time)){
                $change_time = false;
                $mm_change_time = get_post_meta( $cart_item['product_id'], 'mm_change_time', true );
                if($mm_change_time == 'yes' ){
                    $change_time = true;
                }
                if($change_time){
                    if(strpos(strtolower($time), 'am') !== false) $time = 'Morning';
                    elseif(strpos(strtolower($time), 'pm') !== false) $time = 'Afternoon';
                }
                echo '<div class="mm-date-time-fly-cart-row">
                    <span class="mm-icon-fly-cart mm-icon-fly-cart-time"></span><span>'. $time .'</span>
                </div>';
            }
            echo '</div>';
        }
    }
    add_action('woofc_below_item_name', 'mm_add_dates_and_time_to_shopping_cart', 10, 2);
}

if (!function_exists('mm_anchor_scroll_tab_to')) {
    function mm_anchor_scroll_tab_to ($atts) {
        if (!empty($atts)) {
            return '<span mm-anchor-scroll-tab-to="'.$atts['scroll_to'].'">'.$atts['text'].'</span>';
        }
    }
    add_shortcode('mm_anchor_scroll_tab_to', 'mm_anchor_scroll_tab_to');
}

add_action( 'woocommerce_before_calculate_totals', 'mm_remove_cart_items_conditionally' );
if(!function_exists('mm_remove_cart_items_conditionally')){
    function mm_remove_cart_items_conditionally( $cart ) {

        $list_product = array();
        if(count($cart->get_cart()>1)){
            foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {
                $booking_date = '';
                if(isset($cart_item['booking']['_date'])){
                    $booking_date = $cart_item['booking']['_date'];
                    if(isset($cart_item['booking']['_time'])){
                        $booking_date.=' '.$cart_item['booking']['_time'];
                    }
                    if(isset($list_product[$cart_item['product_id']]) && $list_product[$cart_item['product_id']] == $booking_date){
                        $cart->remove_cart_item( $cart_item_key );
                    }else{
                        $list_product[$cart_item['product_id']] = $booking_date;
                    }
                }

            }
        }
    }
}
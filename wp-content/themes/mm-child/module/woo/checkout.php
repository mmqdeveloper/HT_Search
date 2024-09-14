<?php

if ( ! function_exists( 'mmt_island_not_oahu' ) ) {
	
	function mmt_island_not_oahu() {
		$flag = false;
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
                            $product_id = $item['product_id'];
                            $island = WC()->session->get( 'island-' . $item_key );
                            //wp_mail('hungtrinhdn@gmail.com', 'test', print_r($island, true));
                            /*if ( $island == 'kauai' || $island == 'big-island' || $island == 'maui' || $island == 'vacation-packages' ) {
                                    $flag = true;
                            } else {

                                if($product_id!=''){
                                    $terms = get_the_terms ( $product_id, 'product_cat' );

                                    $cat_id = array();
                                    foreach ( $terms as $term ) {
                                        $cat_id[] = $term->term_id;
                                    } 
                                    if(in_array('38', $cat_id)){
                                        $flag = false;
                                    }
                                    else $flag = true;
                                }
                                else $flag = false;
                            }*/
                            if($product_id!=''){
                                $terms = get_the_terms ( $product_id, 'product_cat' );

                                $cat_id = array();
                                foreach ( $terms as $term ) {
                                    $cat_id[] = $term->term_id;
                                } 
                                if(in_array('652', $cat_id)||in_array('9803', $cat_id)||in_array('5055', $cat_id)||in_array('5056', $cat_id)||in_array('680', $cat_id)||in_array('792', $cat_id)||in_array('11608', $cat_id)){
                                    $flag = true;
                                }
                                else $flag = false;
                            }
                            else $flag = false;
                            if($product_id=='5418' || $product_id=='5595' || $product_id=='3915' || $product_id=='3613'){
                                $flag = false;
                            }
			}
		}
		
		return $flag;
	}
}

if ( ! function_exists( 'mmt_is_helicopter_fly' ) ) {
	
	function mmt_is_helicopter_fly() {
		$flag = false;
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				$productId    = $item['product_id'];
				$titleProduct = strtolower( get_the_title( $productId ) );
				$terms = get_the_terms ( $productId, 'product_cat' );
                                $cat_id = array();
                                foreach ( $terms as $term ) {
                                    $cat_id[] = $term->term_id;
                                } 
				if ( preg_match( '/\bhelicopter\b/', $titleProduct ) ) {
					$flag = true;
				} elseif(in_array('792', $cat_id)||in_array('5056', $cat_id)||in_array('680', $cat_id)||in_array('5055', $cat_id)||in_array('11608', $cat_id)){
                                    $flag = true;
                                }
			}
		}
		
		return $flag;
	}
}
if ( ! function_exists( 'mmt_is_horseback' ) ) {
	
	function mmt_is_horseback() {
		$flag = false;
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				$productId    = $item['product_id'];
				$titleProduct = strtolower( get_the_title( $productId ) );
				$terms = get_the_terms ( $productId, 'product_cat' );
                                $cat_id = array();
                                foreach ( $terms as $term ) {
                                    $cat_id[] = $term->term_id;
                                } 
				if(in_array('11608', $cat_id)){
                                    $flag = true;
                                }
			}
		}
		
		return $flag;
	}
}
if ( ! function_exists( 'mmt_checkout_fields' ) ) {
	function mmt_checkout_fields( $field ) {
		$date  = array(
			'' => 'Day'
		);
		$month = array(
			'' => 'Month'
		);
		$year  = array(
			'' => 'Year'
		);
		
		$currentYear = date( 'Y', strtotime( 'now' ) );
		for ( $d = 1 ; $d <= 31 ; $d ++ ) {
			$date[ $d ] = $d;
		}
		for ( $m = 1 ; $m <= 12 ; $m ++ ) {
			$month[ $m ] = $m;
		}
		for ( $y = $currentYear ; $y >= 1919 ; $y -- ) {
			$year[ $y ] = $y;
		}
		
		$arrayHotel = array( '' => 'Select Hotel Name' );
		$args       = array(
			'post_type'      => 'hotel',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
		);
		$the_query  = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$arrayHotel[ get_the_ID() ] = get_the_title();
			endwhile;
		endif;
		
		wp_reset_postdata();

//		$hotelOption = get_option( 'mmt_list_hotel' );
//		$hotelOption = explode( "\n", $hotelOption );
//		$arrayHotel  = array( '' => 'Select Hotel Name' );
//		if ( ! empty( $hotelOption ) && is_array( $hotelOption ) ) {
//			foreach ( $hotelOption as $hotel ) {
//				$arrayHotel[ mmt_str_convert_to_id( $hotel ) ] = mmt_str_remove_enter( $hotel );
//			}
//		}
		
//		$arrayHotel['other'] = 'Other types of Accommodation';
//
//		$field['billing']['mmt_hotel_name'] = array(
//			'type'        => 'select',
//			'label'       => 'Hotel name',
//			'placeholder' => '',
//			'required'    => true,
//			'class'       => array( 'form-row-wide mmt-hotel-name' ),
//			'clear'       => true,
//			'options'     => $arrayHotel,
//			'description' => '',
//			'priority'    => '130'
//		);
//
//		$field['billing']['mmt_other_hotel_name'] = array(
//			'type'        => 'select',
//			'label'       => 'Accommodation',
//			'placeholder' => '',
//			'required'    => true,
//			'class'       => array( 'form-row-wide mmt-other-hotel-name' ),
//			'clear'       => true,
//			'options'     => array(
//				''                 => 'Select your Accommodation',
//				'cruise-ship'      => 'Cruise Ship',
//				'air-bnd'          => 'Air Bnb',
//				'private-address'  => 'Private Address',
//				'honolulu-airport' => 'Honolulu Airport',
//			),
//			'default'     => 'cruise-ship',
//			'description' => '',
//			'priority'    => '131'
//		);
//
//		$field['billing']['mmt_hotel_cruise_ship'] = array(
//			'type'        => 'text',
//			'label'       => 'Cruise ship - Provide name',
//			'placeholder' => '',
//			'required'    => true,
//			'class'       => array( 'form-row-wide mmt-other-hotel-text' ),
//			'clear'       => true,
//			'description' => '',
//			'default'     => 'default',
//			'priority'    => '132'
//		);
//
//		$field['billing']['mmt_hotel_air_bnd']                  = array(
//			'type'        => 'text',
//			'label'       => 'Air Bnb - Provide address',
//			'placeholder' => '',
//			'required'    => true,
//			'class'       => array( 'form-row-wide mmt-other-hotel-text' ),
//			'clear'       => true,
//			'description' => '',
//			'default'     => 'default',
//			'priority'    => '133'
//		);
//		$field['billing']['mmt_hotel_private_address']          = array(
//			'type'        => 'text',
//			'label'       => 'Private address - Provide address',
//			'placeholder' => '',
//			'required'    => true,
//			'class'       => array( 'form-row-wide mmt-other-hotel-text' ),
//			'clear'       => true,
//			'description' => '',
//			'default'     => 'default',
//			'priority'    => '134'
//		);
//		$field['billing']['mmt_hotel_honolulu_airport_airline'] = array(
//			'type'        => 'text',
//			'label'       => 'Honolulu airport - Airline',
//			'placeholder' => '',
//			'required'    => true,
//			'class'       => array( 'form-row-wide mmt-other-hotel-text' ),
//			'clear'       => true,
//			'description' => '',
//			'default'     => 'default',
//			'priority'    => '135'
//		);
//		$field['billing']['mmt_hotel_honolulu_airport_flight']  = array(
//			'type'        => 'text',
//			'label'       => 'Honolulu airport - Flight',
//			'placeholder' => '',
//			'required'    => true,
//			'class'       => array( 'form-row-wide mmt-other-hotel-text' ),
//			'clear'       => true,
//			'description' => '',
//			'default'     => 'default',
//			'priority'    => '136'
//		);
		
		$count = mmt_count_person_cart();
		for ( $i = 1 ; $i <= $count ; $i ++ ) {
			
			if ( ! empty( mmt_island_not_oahu() ) ) {
				$field['billing'][ 'mmt_first_name__' . $i ]     = array(
					'type'        => 'text',
					'label'       => 'First Name Guest #' . $i,
					'placeholder' => '',
					'required'    => true,
					'class'       => array( 'form-row-wide mm-firstname mm-fullname' ),
					'clear'       => true,
					'description' => 'As it appears on your <span class="bold-photo-id">Photo ID</span>',
					'priority'    => '9999' . $i . '1'
				);
				$field['billing'][ 'mmt_last_name__' . $i ]      = array(
					'type'        => 'text',
					'label'       => 'Last Name Guest #' . $i,
					'placeholder' => '',
					'required'    => true,
					'class'       => array( 'form-row-wide mm-lastname mm-fullname' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '2'
				);
                                $field['billing'][ 'mmt_birthday__' . $i ] = array(
					'type'        => 'text',
					'label'       => 'Date of Birth Guest #' . $i,
					'placeholder' => '',
					'required'    => true,
					'class'       => array( 'form-row-wide birthday_guest_checkout' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '3'
				);
				/*$field['billing'][ 'mmt_birthday_month__' . $i ] = array(
					'type'        => 'select',
					'label'       => 'Date of Birth Guest #' . $i,
					'placeholder' => '',
					'required'    => true,
					'options'     => $month,
					'class'       => array( 'form-row-wide mmt-month mmt-birthday' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '3'
				);
				$field['billing'][ 'mmt_birthday_date__' . $i ]  = array(
					'type'        => 'select',
					'label'       => 'Date of Birth Guest #' . $i,
					'placeholder' => '',
					'required'    => true,
					'options'     => $date,
					'class'       => array( 'form-row-wide mmt-date mmt-birthday' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '4'
				);
				$field['billing'][ 'mmt_birthday_year__' . $i ]  = array(
					'type'        => 'select',
					'label'       => 'Date of Birth Guest #' . $i,
					'placeholder' => '',
					'required'    => true,
					'options'     => $year,
					'class'       => array( 'form-row-wide mmt-year mmt-birthday' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '5'
				);*/
				$field['billing'][ 'mmt_gender__' . $i ]         = array(
					'type'        => 'select',
					'label'       => 'Gender Guests #' . $i,
					'placeholder' => '',
					'required'    => true,
					'options'     => array(
						''       => 'Gender',
						'male'   => 'Male',
						'female' => 'Female',
					),
					'class'       => array( 'form-row-wide mmt-gender' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '6'
				);
			}
			
			if ( mmt_is_helicopter_fly() ) {
				$field['billing'][ 'mmt_weight__' . $i ] = array(
					'type'        => 'text',
					'label'       => 'Weight Guests #' . $i,
					'placeholder' => '',
					'required'    => true,
					'class'       => array( 'form-row-wide mmt-gender' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '7'
				);
			}
                        if ( mmt_is_horseback() ) {
				$field['billing'][ 'mmt_height__' . $i ] = array(
					'type'        => 'text',
					'label'       => 'Height Guests #' . $i,
					'placeholder' => '',
					'required'    => true,
					'class'       => array( 'form-row-wide mmt-height' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '8'
				);
                                $field['billing'][ 'mmt_riding_level__' . $i ]         = array(
					'type'        => 'select',
					'label'       => 'Riding experience level Guests #' . $i,
					'placeholder' => '',
					'required'    => true,
					'options'     => array(
						''       => 'Riding experience level',
						'First timer'   => 'First timer',
						'Beginner' => 'Beginner',
                                                'Intermediate' => 'Intermediate',
                                                'Advanced' => 'Advanced',
					),
					'class'       => array( 'form-row-wide mmt-level' ),
					'clear'       => true,
					'priority'    => '9999' . $i . '9'
				);
			}
		}
                if ( mmt_is_horseback() ) {
                    $field['billing'][ 'mmt_participant_agreement__']         = array(
                        'type'        => 'checkbox',
                        'label'       => "I agree to the 48-hour cancellation and rain-or-shine policies",
                        'placeholder' => '',
                        'required'    => true,
                        
                        'class'       => array( 'form-row-wide mmt-level' ),
                        'clear'       => true,
                        'priority'    => '9999' . $i . '10'
                    );
                }
		
		return $field;
	}
	
	//add_action( 'woocommerce_checkout_fields', 'mmt_checkout_fields', 999, 10 );
}

add_filter( 'woocommerce_available_payment_gateways', 'mm_gateway_disable_paypal_express_for_authorization_product' );
if(!function_exists('mm_gateway_disable_paypal_express_for_authorization_product')){ 
    function mm_gateway_disable_paypal_express_for_authorization_product( $available_gateways ) {
        global $wp, $woocommerce;
        $disable_paypal_express = 'no';
        $galaxy_api = false;
        if(is_wc_endpoint_url('order-pay')){
            if ( isset($wp->query_vars['order-pay']) && absint($wp->query_vars['order-pay']) > 0 ) {
                $order_id = absint($wp->query_vars['order-pay']);
                $order    = wc_get_order( $order_id );
                foreach ( $order->get_items() as  $item_key => $item_values ) {
                    $item_data = $item_values->get_data();
                    $product_id = $item_data['product_id'];
                    $product_tag = get_the_terms($product_id, 'product_tag');
                    foreach ($product_tag as $term) {
                        if ($term->name == 'Authorization') {
                            $disable_paypal_express = 'yes';
                        }
                        if ($term->name == 'Package') {
                            $vp_tour = true;
                        }
                        if ($term->name == 'GalaxyAPI') {
                            $galaxy_api = true;
                        }
                    }
                    $check_farehabor_api = get_post_meta($product_id, "mm_enable_fareharbor_api", true);
                    $disable_booking_fareharbor = get_post_meta($product_id, 'mm_disable_fareharbor_reservation', true);
                    $mm_enable_ponorez_api = get_post_meta($product_id,"mm_enable_ponorez_api", true);
                    $mm_enable_other_vendor_api = get_post_meta($product_id,"mm_enable_other_vendor_api", true);
                    $vendor = get_post_meta($product_id, 'mm_product_vendor', true);
                    $mm_resource_vendor = '';
                    if (class_exists('WC_Booking_Data_Store')) {
                        $booking_ids = WC_Booking_Data_Store::get_booking_ids_from_order_item_id($item_key);
                        if (!empty($booking_ids)) {
                            foreach ($booking_ids as $booking_id) {
                                $booking_mm = new WC_Booking($booking_id);
                                $product_mm = $booking_mm->get_product();
                                $product_id = $booking_mm->get_product_id();

                                if ($product_mm->has_resources() || $product_mm->is_resource_assignment_type('customer')) {
                                    $booking_resource_id = $booking_mm->get_resource_id();
                                    $mm_resource_vendor = get_post_meta($booking_resource_id, 'mm_resource_vendor', true);
                                }

                            }
                        }
                    }
                    if(!empty($mm_resource_vendor)){
                        $vendor = $mm_resource_vendor;
                    }
                    $hta = false;
                    if(strpos(strtolower($vendor), 'hta')!== false){
                        $hta = true;
                    }
                    if($galaxy_api || $check_farehabor_api == 'yes' || $mm_enable_ponorez_api == 'yes' || $mm_enable_other_vendor_api == 'yes' || !$hta){
                        $disable_paypal_express = 'yes';
                    }
                    
                }
            }
        }else{
	        
	        //begin empty cart
	        if(isset(WC()->cart)){
		        if ( ! empty( WC()->cart->get_cart() ) ) {
                            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item_values ) {
                            $product_tag = get_the_terms($cart_item_values['product_id'], 'product_tag');
                            foreach ($product_tag as $term) {
                                if ($term->name == 'Authorization') {
                                    $disable_paypal_express = 'yes';
                                }
                                if ($term->name == 'Package') {
                                    $vp_tour = true;
                                }
                                if ($term->name == 'GalaxyAPI') {
                                    $galaxy_api = true;
                                }
                            }
                            $check_farehabor_api = get_post_meta($cart_item_values['product_id'], "mm_enable_fareharbor_api", true);
                            $disable_booking_fareharbor = get_post_meta($cart_item_values['product_id'], 'mm_disable_fareharbor_reservation', true);
                            $mm_enable_ponorez_api = get_post_meta($cart_item_values['product_id'],"mm_enable_ponorez_api", true);
                            $mm_enable_other_vendor_api = get_post_meta($cart_item_values['product_id'],"mm_enable_other_vendor_api", true);
                            $vendor = get_post_meta($cart_item_values['product_id'], 'mm_product_vendor', true);
                            $mm_resource_vendor = '';
                            $booking_resource_id = $cart_item_values['_resource_id'];
                            if(!empty($booking_resource_id)){
                                $mm_resource_vendor = get_post_meta($booking_resource_id, 'mm_resource_vendor', true);
                            }
                            if(!empty($mm_resource_vendor)){
                                $vendor = $mm_resource_vendor;
                            }
                            $hta = false;
                            if(strpos(strtolower($vendor), 'hta')!== false){
                                $hta = true;
                            }
                            if($galaxy_api || $check_farehabor_api == 'yes' || $mm_enable_ponorez_api == 'yes' || $mm_enable_other_vendor_api == 'yes' || !$hta){
                                $disable_paypal_express = 'yes';
                            }
	
	            }
	         }//end empty cart
         }
            
        }
        if(isset($woocommerce->cart)){
            $amount = $woocommerce->cart->cart_contents_total + $woocommerce->cart->tax_total;
            if($amount>=9500){
                $disable_paypal_express = 'yes';
            }
        }
        if($disable_paypal_express == 'yes'){
            unset( $available_gateways['paypal_express'] );

        }
        $shop_manager = false;
        if (is_user_logged_in()) {
            $user_ID = get_current_user_id();
            $user = new WP_User($user_ID);
            if (!empty($user->roles) && is_array($user->roles)) {
                foreach ($user->roles as $role){
                    if ($role == 'shop_manager' || $role == "administrator") {
                        $vp_tour = true;
                        $shop_manager = true;
                    }
                }
            }
        }
        if($shop_manager){
            //unset( $available_gateways['paypal_express'] );
            //unset( $available_gateways['stripe'] );
        }
        if(!$shop_manager){
            unset( $available_gateways['sliced-invoices'] );
        }
        if(!$vp_tour){
            unset( $available_gateways['cheque'] );
        }
        
        return $available_gateways;
    }
}
function mm_disable_woocommerce_email_recipient_shop_manager( $recipient, $order, $email ) { 
    if ( ! $order || ! is_a( $order, 'WC_Order' ) ) return $recipient;
    $order_id  = $order->get_id(); 
    $user_ID = $order->get_user_id();
    $user = new WP_User($user_ID);
    $shop_manager = false;
    if (!empty($user->roles) && is_array($user->roles)) {
        foreach ($user->roles as $role){
            if ($role == 'shop_manager' || $role == "administrator") {
                $shop_manager = true;
            }
        }
    }
    if($shop_manager){
        $recipient = '';
        update_post_meta($order_id, 'mm_shop_manager_order', 'yes');
    }

    return $recipient;
}
//add_filter( 'woocommerce_email_recipient_new_order', 'mm_filter_woocommerce_email_recipient', 10, 3 );
add_filter( 'woocommerce_email_recipient_customer_on_hold_order', 'mm_disable_woocommerce_email_recipient_shop_manager', 10, 3 );
add_filter( 'woocommerce_email_recipient_customer_processing_order', 'mm_disable_woocommerce_email_recipient_shop_manager', 10, 3 );
add_filter( 'woocommerce_email_recipient_customer_pending_order', 'mm_disable_woocommerce_email_recipient_shop_manager', 10, 3 );
add_filter( 'woocommerce_email_recipient_customer_completed_order', 'mm_disable_woocommerce_email_recipient_shop_manager', 10, 3 );

add_action( 'woocommerce_review_order_before_submit', 'mm_add_checkbox_booking_api', 10 );
function mm_add_checkbox_booking_api() {
   $shop_manager = false;
    if (is_user_logged_in()) {
        $user_ID = get_current_user_id();
        $user = new WP_User($user_ID);
        if (!empty($user->roles) && is_array($user->roles)) {
            foreach ($user->roles as $role){
                if ($role == 'shop_manager' || $role == "administrator") {
                    $shop_manager = true;
                }
            }
        }
    }
    if($shop_manager == true){
    	woocommerce_form_field( 'checkbox_booking_api', array( // CSS ID
            'type'          => 'checkbox',
            'class'         => array('form-row checkbox_booking_api'), // CSS Class
            'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
            'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
            'required'      => false, // Mandatory or Optional
            'label'         => 'Create a new booking via API',
         ));
         echo '<input type="hidden" class="input-hidden" name="sale_agent_booking" id="sale_agent_booking" value="yes">';
         woocommerce_form_field( 'checkbox_service_revenue', array( // CSS ID
            'type'          => 'checkbox',
            'class'         => array('form-row checkbox_service_revenue'), // CSS Class
            'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
            'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
            'required'      => false, // Mandatory or Optional
            'label'         => 'Move the Sale Amount to the Service Revenue field (vacation package bookings)',
         ));
    }
        
}
add_action( 'woocommerce_checkout_update_order_meta', 'mm_save_sale_agent_checkout_hidden_field', 10, 1 );
function mm_save_sale_agent_checkout_hidden_field( $order_id ){
    if ( ! empty( $_POST['sale_agent_booking'] ) ){
        update_post_meta( $order_id, 'sale_agent_booking', sanitize_text_field( $_POST['sale_agent_booking'] ) );
    }
    if ( ! empty( $_POST['checkbox_booking_api'] ) ){
        update_post_meta( $order_id, 'checkbox_booking_api', sanitize_text_field( $_POST['checkbox_booking_api'] ) );
    }
    if ( ! empty( $_POST['checkbox_service_revenue'] ) ){
        update_post_meta( $order_id, 'checkbox_service_revenue', sanitize_text_field( $_POST['checkbox_service_revenue'] ) );
    }
}
add_action( 'woocommerce_thankyou', 'mm_change_order_status_sale_agent_booking', 10, 1 );
function mm_change_order_status_sale_agent_booking( $order_id ){
    if( ! $order_id ) return;

    $order = wc_get_order( $order_id );
    $sale_agent_booking = get_post_meta( $order_id, 'sale_agent_booking', true);
    if($sale_agent_booking == 'yes'){
        if( $order->get_status() == 'on-hold' ){
            $order->update_status( 'completed' );
        }
    }
}
add_filter( 'default_checkout_billing_address_1', 'mm_change_default_checkout_billing_address' );
if(!function_exists('mm_change_default_checkout_billing_address')){
    function mm_change_default_checkout_billing_address() {
        $shop_manager = false;
        if (is_user_logged_in()) {
            $user_ID = get_current_user_id();
            $user = new WP_User($user_ID);
            $customer = new WC_Customer( $user_ID );
            $billing_address_1  = $customer->get_billing_address_1();
            if (!empty($user->roles) && is_array($user->roles)) {
                foreach ($user->roles as $role){
                    if ($role == 'shop_manager' || $role == "administrator") {
                        $shop_manager = true;
                    }
                }
            }
        }
        if($shop_manager){
            if(empty($billing_address_1)){
                $billing_address_1 = '---';
            }
            return $billing_address_1; 
        }
    }
}
add_filter('body_class','mm_add_class_role_to_body');
function mm_add_class_role_to_body($classes) {
    if (is_user_logged_in()) {
        $current_user = new WP_User(get_current_user_id());
        $user_role = array_shift($current_user->roles);
        $classes[] = 'mm-role-'. $user_role;
    }
    return $classes;
}

add_filter( 'woocommerce_checkout_fields' , 'mm_remove_company_name' );
if(!function_exists('mm_remove_company_name')){
    function mm_remove_company_name( $fields ) {
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_address_2']);
        return $fields;
    }
}
//remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
if(!function_exists('mm_enable_woocommerce_coupons_sale_agent')){
    function mm_enable_woocommerce_coupons_sale_agent( $enabled ) {
        $shop_manager = false;
        if (is_user_logged_in()) {
            $user_ID = get_current_user_id();
            $user = new WP_User($user_ID);
            $customer = new WC_Customer( $user_ID );
            $billing_address_1  = $customer->get_billing_address_1();
            if (!empty($user->roles) && is_array($user->roles)) {
                foreach ($user->roles as $role){
                    if ($role == 'shop_manager' || $role == "administrator") {
                        $shop_manager = true;
                    }
                }
            }
        }
        if($shop_manager){
            return $enabled;
        }else{
            return false;
        }
    }
}
//add_filter( 'woocommerce_coupons_enabled', 'mm_enable_woocommerce_coupons_sale_agent' ); 

if(!function_exists('mm_add_credit_card_gateway_icons')){
function mm_add_credit_card_gateway_icons( $icon_string, $gateway_id ) {

    if ( 'stripe' === $gateway_id ) {

    $icon_string  =  ' <div class="payment-stripe-icon"><img class="stripe-visa-icon stripe-icon" src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/visa.svg" alt="Visa" /> ' ;
    $icon_string .= ' <img class="stripe-mastercard-icon stripe-icon" src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/mastercard.svg" alt="mastercard" /> ' ;
    $icon_string .= ' <img class="stripe-amex-icon stripe-icon" src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/amex.svg" alt="amex" /> ' ;
    $icon_string .= ' <img class="stripe-discover-icon stripe-icon" src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/discover.svg" alt="Discover" /> ' ;
    $icon_string .= ' <img class="stripe-diners-icon stripe-icon" src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/diners.svg" alt="diners" /> ' ;
    $icon_string .= ' <img class="stripe-jcb-icon stripe-icon" src="' . WC_STRIPE_PLUGIN_URL . '/assets/images/jcb.svg" alt="jcb" /> </div>' ;

    }
    return $icon_string;
    }
}
add_filter( 'woocommerce_gateway_icon', 'mm_add_credit_card_gateway_icons', 10, 2 );

add_filter('woocommerce_checkout_fields', 'mm_override_phone_checkout_fields');
if(!function_exists('mm_override_phone_checkout_fields')){
    function mm_override_phone_checkout_fields($fields){
       $fields['billing']['billing_phone']['label'] = 'Mobile phone';
       return $fields;
    }
}
if(!function_exists('mm_filter_woocommerce_get_item_data')){
    function mm_filter_woocommerce_get_item_data( $item_data, $cart_item ) { 
        if (!empty($cart_item['booking']['_persons'])) {
            $product_id = $cart_item['product_id'];
            $_product = wc_get_product($product_id);
            $person_types = $_product->get_person_types();
            
            foreach ($item_data as $key => $item_data_value) {
                foreach ($person_types as $person) {
                    if(isset($cart_item['booking']['_persons'][$person->get_id()]) ){
                        if($item_data_value['name'] == $person->post_title && $item_data_value['value'] == $cart_item['booking']['_persons'][$person->get_id()]){
                            unset($item_data[$key]);
                        }
                    }
                }
            }
            
        }
        
        return $item_data; 
    } 
}
add_filter( 'woocommerce_get_item_data', 'mm_filter_woocommerce_get_item_data', 90, 2 );

add_filter('woocommerce_checkout_fields', 'mm_custom_required_billing_fields', 1000, 1);
if(!function_exists('mm_custom_required_billing_fields')){
    function mm_custom_required_billing_fields( $fields ) {
        if (is_user_logged_in()) {
            $user_ID = get_current_user_id();
            $user = new WP_User($user_ID);
            if (!empty($user->roles) && is_array($user->roles)) {
                foreach ($user->roles as $role){
                    if ($role == 'shop_manager' || $role == "administrator") {
                        $fields['billing']['billing_country']['required'] = false;
                        $fields['billing']['billing_city']['required'] = false;
                        $fields['billing']['billing_state']['required'] = false;
                        $fields['billing']['billing_country']['label_class'] = 'mm_remove_required';
                        $fields['billing']['billing_city']['label_class'] = 'mm_remove_required';
                        $fields['billing']['billing_state']['label_class'] = 'mm_remove_required';
                    }
                }
            }
        }
        return $fields;
    }
}
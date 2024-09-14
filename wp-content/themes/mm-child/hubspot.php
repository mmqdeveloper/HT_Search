<?php

//Ben 
 
add_filter('hubwoo_map_new_properties','mm_hubwoo_map_new_properties', 10, 2 );

function mm_hubwoo_map_new_properties($properties,$contactid){
     //Products

    //Ben Test
        /**  
        * Integrate with Woo Booking 
        * @autho Ben Lee
        * @date 25-Feb-2021
        */ 
        //Order ID
        $order_statuses = get_option( 'hubwoo-selected-order-status', array() );

        if ( empty( $order_statuses ) ) {

            $order_statuses = array_keys( wc_get_order_statuses() );
        }

        $query = new WP_Query();

        $customer_orders = $query->query(
            array(
                'post_type'           => 'shop_order',
                'posts_per_page'      => -1,
                'post_status'         => $order_statuses,
                'orderby'             => 'date',
                'order'               => 'desc',
                'fields'              => 'ids',
                'no_found_rows'       => true,
                'ignore_sticky_posts' => true,
                'meta_query'          => array(
                    array(
                        'key'   => '_customer_user',
                        'value' => $contactid,
                    ),
                ),
            )
        );
        $last_order_id      = ! empty( $customer_orders ) && is_array( $customer_orders ) ? $customer_orders[0] : '';

        $order_url = '';
        if($last_order_id>0){
            $order_url  = get_site_url().'/wp-admin/post.php?post='.$last_order_id.'&action=edit';
        }

        $booking_ids_mm = array();
            //Get Tour Date
        $tour_date_mm ='';
        $start_time_mm = '';
        $label_mm ='';
        $tour_start_from_mm = '';
        $adults = 0; 
        $children = 0;
        $seniors = 0;

        if(class_exists( 'WC_Booking_Data_Store') && $last_order_id){
           $booking_ids_mm = WC_Booking_Data_Store::get_booking_ids_from_order_id( $last_order_id );
            //Check all bookings
            foreach ( $booking_ids_mm as $booking_id ) {
                if(class_exists( 'WC_Booking' )&& $booking_id > 0){
                    $booking_mm = new WC_Booking( $booking_id );
                    $product_mm = $booking_mm->get_product();
                    $resource_mm = $booking_mm->get_resource();
                    $label_mm = $product_mm && is_callable(array($product_mm, 'get_resource_label')) && $product_mm->get_resource_label() ? $product_mm->get_resource_label() : __('Type', 'woocommerce-bookings');
                    //Tour Date
                    $tour_date_mm = date("l, F d, Y", strtotime($booking_mm->get_start_date()));
                    if (date("l, F d, Y", strtotime($booking_mm->get_start_date())) != date("l, F d, Y", strtotime($booking_mm->get_end_date()))) {
                        $tour_date_mm .= ' - ' . date("l, F d, Y", strtotime($booking_mm->get_end_date()));
                    }
                    //Start time
                    $get_all_day_mm = $booking_mm->get_all_day('edit');
                    if ($get_all_day_mm) {
                        $start_time_mm = '';
                    } else {
                        $start_time_mm = date('h:i A', $booking_mm->get_start('edit'));
                    }
                    //Tour Start From
                    if($resource_mm){
                       $tour_start_from_mm = $resource_mm->get_name();
                    }
                    //
                    if ($product_mm->has_persons()) {
                        if ($product_mm->has_person_types()) {
                            $person_types = $product_mm->get_person_types();
                            $person_counts = $booking_mm->get_person_counts();

                            if (!empty($person_types) && is_array($person_types)) {
                                foreach ($person_types as $person_type) {

                                    if (empty($person_counts[$person_type->get_id()])) {
                                        continue;
                                    }
                                    $pname =  $person_type->get_name();
                                    $pname_lowercase = strtolower($pname);
                                    $pcount = $person_counts[$person_type->get_id()];
                                    $posadult = strpos($pname_lowercase, 'adult');
                                    $poschild = strpos($pname_lowercase, 'child');
                                    $possenior = strpos($pname_lowercase, 'senior');
                                    if ($posadult !== false) {
                                        $adults  = $pcount;
                                    }
                                    if ($poschild!==false) {
                                        $children  = $pcount;
                                    }
                                    if ($possenior!== false) {
                                        $seniors  = $pcount;
                                    }
                                }
                            }
                        } else {
                            $adults = array_sum($booking->get_person_counts());
                        }
                    }
                }//booking
             }
    }
   $properties[] = array(
                'property' => 'order_url',
                'value'    => $order_url,
        );
    $payment_method  = '';
    $customer_notes = '';
    $customer_info = '';
    $hotel_name = '';
    if($last_order_id>0){
      $order = wc_get_order( $last_order_id );
      $payment_method = $order->get_payment_method_title();
      $customer_notes = $order->get_customer_note();
      //Product Extra
       if(class_exists('THEMECOMPLETE_EPO_API_base')){
          $epo_class_api =  THEMECOMPLETE_EPO_API_base::instance();
          $epo_data = $epo_class_api->get_all_options($last_order_id);
          foreach ($epo_data as $pokey => $povalue) {
              # code...
            //
            //wp_mail("hungtrinhdn@gmail.com", "HT DEV EPO Data Key", print_r($pokey,true));
            //wp_mail("hungtrinhdn@gmail.com", "HT DEV EPO Data Value", print_r($povalue,true));
            foreach ($povalue as $key => $value) {
                # code...
                 $item_name = $value['name'];
                 $item_value = $value['value'];
                 $item_name_lowercase = strtolower($item_name);
                 $item_name_customer = strpos($item_name_lowercase, 'customer info');
                 if ($item_name_customer !== false) {
                      $customer_info = $item_value;
                 }
                 $item_name_hotel = strpos($item_name_lowercase, 'hotel name');
                 if ($item_name_hotel !== false) {
                      $hotel_name = $item_value;
                 }

                //wp_mail("hungtrinhdn@gmail.com", "HT DEV EPO Data Item Key", print_r($key,true));
                //wp_mail("hungtrinhdn@gmail.com", "HT DEV EPO Data Item Value", print_r($value,true));

     
            }
        }//for each
      }//EPO class
       
    }//last order id

    $properties[] = array(
                    'property' => 'payment_method',
                    'value'    => $payment_method,
            ); 
    $properties[] = array(
                    'property' => 'tour_date',
                    'value'    => $tour_date_mm,
            ); 
    $properties[] = array(
                    'property' => 'start_time',
                    'value'    => $start_time_mm,
            ); 
    $properties[] = array(
                    'property' => 'tour_starting_from',
                    'value'    => $tour_start_from_mm,
            ); 


    $properties[] = array(
                    'property' => 'hotel_name',
                    'value'    => $hotel_name,
            ); 
   
    $properties[] = array(
                    'property' => 'adults',
                    'value'    => $adults,
            ); 
   
    $properties[] = array(
                    'property' => 'children',
                    'value'    => $children,
            ); 
   
    $properties[] = array(
                    'property' => 'seniors',
                    'value'    => $seniors,
            ); 
    $properties[] = array(
                    'property' => 'customer_notes',
                    'value'    => $customer_notes,
            ); 
    $properties[] = array(
                    'property' => 'customer_info',
                    'value'    => $customer_info,
            ); 
    $vehicle_type = '';
    $properties[] = array(
                    'property' => 'vehicle_type',
                    'value'    => $vehicle_type,
            ); 
    $insurance_add_on = "";
    $properties[] = array(
                    'property' => 'insurance_add_on',
                    'value'    => $insurance_add_on,
            ); 
    $transport = '';
    $properties[] = array(
                    'property' => 'transport',
                    'value'    => $transport,
            ); 

    //wp_mail("hungtrinhdn@gmail.com", "HT LIVE mm_hubwoo_map_new_properties", print_r($properties,true));  

  return $properties;
}

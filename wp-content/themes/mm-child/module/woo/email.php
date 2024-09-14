<?php

if ( ! function_exists( 'mmt_checkout_update_order_meta' ) ) {
	function mmt_checkout_update_order_meta( $orderId, $postData ) {
		
		$hotelName = $postData['mmt_hotel_name'];
		if ( $hotelName == 'other' ) {
			$otherHotelName = $postData['mmt_other_hotel_name'];
			if ( $otherHotelName == 'cruise-ship' ) {
				$hotelCruiseShip = $postData['mmt_hotel_cruise_ship'];
				update_post_meta( $orderId, 'mmt_hotel_cruise_ship', $hotelCruiseShip );
			} elseif ( $otherHotelName == 'air-bnd' ) {
				$hotelAirBnd = $postData['mmt_hotel_air_bnd'];
				update_post_meta( $orderId, 'mmt_hotel_air_bnd', $hotelAirBnd );
			} elseif ( $otherHotelName == 'private-address' ) {
				$hotelPrivateAddress = $postData['mmt_hotel_private_address'];
				update_post_meta( $orderId, 'mmt_hotel_private_address', $hotelPrivateAddress );
			} elseif ( $otherHotelName == 'honolulu-airport' ) {
				$hotelHonoluluAirportAirline = $postData['mmt_hotel_honolulu_airport_airline'];
				$hotelHonoluluAirportFlight  = $postData['mmt_hotel_honolulu_airport_flight'];
				update_post_meta( $orderId, 'mmt_hotel_honolulu_airport_airline', $hotelHonoluluAirportAirline );
				update_post_meta( $orderId, 'mmt_hotel_honolulu_airport_flight', $hotelHonoluluAirportFlight );
				
			}
			update_post_meta( $orderId, 'mmt_other_hotel_name', $otherHotelName );
		}
		
		update_post_meta( $orderId, 'mmt_hotel_name', $hotelName );
		
		$listUpdate     = array();
		$checkoutFields = WC()->checkout->checkout_fields;
		if ( ! empty( $checkoutFields['billing'] ) ) {
			$billings     = $checkoutFields['billing'];
			$billingsKey  = array_keys( $billings );
			$count        = mmt_count_person_order( $orderId, false );
			$listKey      = mmt_list_key_billing();
			$birthDayList = array( 'mmt_birthday_month__', 'mmt_birthday_date__', 'mmt_birthday_year__' );
			$birthDay     = array();
			/*for ( $x = 1 ; $x <= $count ; $x ++ ) {
				$fullData = array();
				foreach ( $birthDayList as $list ) {
					if ( in_array( $list . $x, $billingsKey ) ) {
						$fullData[] = $postData[ $list . $x ];
					}
				}
				$birthDay[ $x ] = implode( '/', $fullData );
			}*/
			
			for ( $i = 1 ; $i <= $count ; $i ++ ) {
				foreach ( $listKey as $key => $list ) {
					if ( in_array( $key . $i, $billingsKey ) ) {
						$listUpdate[ $key . $i ] = $postData[ $key . $i ];
					}
				}
				/*if ( ! empty( $birthDay[ $i ] ) ) {
					$listUpdate[ 'mmt_birthday__' . $i ] = $birthDay[ $i ];
				}*/
			}
			
		}
		
		if ( ! empty( $listUpdate ) ) {
			foreach ( $listUpdate as $key => $update ) {
				update_post_meta( $orderId, $key, $update );
			}
		}
		
		$listRepeat = WC()->session->get( 'mmt-repeat' );
		
		$quantityArray = array();
		foreach ( $listRepeat as $key => $data ) {
			if ( strpos( $key, "mmt_repeat_quantity_" ) !== false ) {
				$quantityArray[ $key ] = $data;
			}
		}
		
		if ( ! empty( $listRepeat ) ) {
			$listRepeatParent = array();
			$listRepeatChild  = array();
			if ( ! empty( $listRepeat ) ) {
				foreach ( $listRepeat as $kr => $vr ) {
					
					if ( is_array( $vr ) ) {
						foreach ( $vr as $arrayVl ) {
							
							$unRepeat = unserialize( stripslashes( $arrayVl ) );
							if ( empty( $unRepeat['is_child'] ) ) {
								$listRepeatParent[] = $unRepeat;
							} else {
								$listRepeatChild[] = $unRepeat;
							}
						}
					} else {
						$unRepeat = unserialize( stripslashes( $vr ) );
						if ( empty( $unRepeat['is_child'] ) ) {
							$listRepeatParent[] = $unRepeat;
						} else {
							$listRepeatChild[] = $unRepeat;
						}
					}
				}
			}
			
			if ( ! empty( $listRepeatParent ) ) {
				update_post_meta( $orderId, 'mmt_order_repeat_parent', serialize( array_filter( $listRepeatParent ) ) );
			}
			if ( ! empty( $listRepeatChild ) ) {
				update_post_meta( $orderId, 'mmt_order_repeat_child', serialize( array_filter( $listRepeatChild ) ) );
			}
			if ( ! empty( $quantityArray ) ) {
				update_post_meta( $orderId, 'mmt_order_repeat_quantity', serialize( $quantityArray ) );
			}
		}
		
		$date = WC()->session->get( 'mmt-date' );
		
		if ( ! empty( $date ) ) {
			$dateArray = array(
				'mmt_date_options_price'  => $date['mmt_date_options_price'],
				'mmt_date_name'           => $date['mmt_date_name'],
				'mmt_date_options_person' => $date['mmt_date_options_person'],
			);
			update_post_meta( $orderId, 'mmt_order_date', serialize( $dateArray ) );
		}
	}
	
	add_action( 'woocommerce_checkout_update_order_meta', 'mmt_checkout_update_order_meta', 10, 3 );
}

if ( ! function_exists( 'mmt_order_data_billing' ) ) {
	function mmt_order_data_billing( $order ) {
		
		if ( isset( $_GET['debug'] ) && ! empty( $_GET['debug'] ) ) {
//			$repeatParent = get_post_meta( $order->get_id(), 'mmt_order_repeat_parent', true );
//			$repeatParent = unserialize( stripslashes( $repeatParent ) );
//			echo '<pre>';
//			print_r( $repeatParent );
//			echo '</pre>';
//			update_post_meta( $order->get_id(),'mmt_order_repeat_parent', serialize($repeatParent));
		}
		
		$repeatParent   = get_post_meta( $order->get_id(), 'mmt_order_repeat_parent', true );
		$repeatChild    = get_post_meta( $order->get_id(), 'mmt_order_repeat_child', true );
		$repeatQuantity = get_post_meta( $order->get_id(), 'mmt_order_repeat_quantity', true );
		$date           = get_post_meta( $order->get_id(), 'mmt_order_date', true );
		$quantityList   = false;
		if ( ! empty( $repeatQuantity ) && is_array( unserialize( stripslashes( $repeatQuantity ) ) ) ) {
			$quantityList = unserialize( stripslashes( $repeatQuantity ) );
		}
		if ( ! empty( $repeatParent ) && is_array( unserialize( stripslashes( $repeatParent ) ) ) ) {
			$arrayParent = unserialize( stripslashes( $repeatParent ) );
			
			foreach ( array_filter( $arrayParent ) as $parent ) {
				?>
                <div class="mmt-order-parent" style="margin-bottom: 15px;">
                    <div style="margin-bottom: 5px;">
                        <strong><h4><?php echo $parent['title']; ?>:</h4></strong>
                    </div>
                    <span style="text-transform: capitalize;">- <?php echo $parent['label']; ?>
						<?php
						if ( ! empty( $quantityList ) ) {
							echo ': ' . $quantityList[ 'mmt_repeat_quantity_' . mmt_convert_text_id( $parent['label'] ) ];
						}
						?>
                    </span>
					<?php
					if ( ! empty( $repeatChild ) && is_array( unserialize( stripslashes( $repeatChild ) ) ) ) {
						$arrayChild = unserialize( stripslashes( $repeatChild ) );
						foreach ( $arrayChild as $child ) {
							if ( $parent['parent'] == $child['parent'] ) {
								?>
                                <div class="mmt-order-child" style="margin-left: 25px;">
                                    <span style="text-transform: capitalize;">+ <?php echo $child['label']; ?>
	                                    <?php
	                                    if ( ! empty( $quantityList ) ) {
		                                    echo ': ' . $quantityList[ 'mmt_repeat_quantity_' . mmt_convert_text_id( $child['label'] ) ];
	                                    }
	                                    ?>
                                    </span>
                                </div>
								<?php
							}
						}
					}
					?>
                </div>
				<?php
			}
			
		}
		
		$hotelName = get_post_meta( $order->get_id(), 'mmt_hotel_name', true );
		if ( ! empty( $hotelName ) ) {
			?>
            <div style="margin-bottom: 5px;">
                <strong><h4>Addition Hotel:</h4></strong>
                <p><span style="font-weight: bold">Hotel name:</span>
					<?php
					if ( $hotelName == 'other' ) {
						echo mmt_str_to_text_uc_word( $hotelName );
					} else {
						global $wpdb;
						$result = $wpdb->get_results( "SELECT `post_title` FROM  $wpdb->posts WHERE `post_type` = 'hotel' AND `ID` = {$hotelName}", ARRAY_A );
						if ( ! empty( $result[0] ) ) {
							echo $result['0']['post_title'];
						}
					}
					?>
                </p>
				<?php
				if ( $hotelName == 'other' ) {
					$otherHotelName = get_post_meta( $order->get_id(), 'mmt_other_hotel_name', true );
					?>
                    <p><span style="font-weight: bold">Other hotel name:</span> <?php echo mmt_str_to_text_uc_word( $otherHotelName ); ?></p>
					<?php
					if ( $otherHotelName == 'cruise-ship' ) {
						$hotelCruiseShip = get_post_meta( $order->get_id(), 'mmt_hotel_cruise_ship', true );
						?>
                        <p><span style="font-weight: bold">Cruise ship - Provide name:</span> <?php echo $hotelCruiseShip; ?></p>
						<?php
					} elseif ( $otherHotelName == 'air-bnd' ) {
						$hotelAirBnd = get_post_meta( $order->get_id(), 'mmt_hotel_air_bnd', true );
						?>
                        <p><span style="font-weight: bold">Air Bnb - Provide address:</span> <?php echo $hotelAirBnd; ?></p>
						<?php
					} elseif ( $otherHotelName == 'private-address' ) {
						$hotelPrivateAddress = get_post_meta( $order->get_id(), 'mmt_hotel_private_address', true );
						?>
                        <p><span style="font-weight: bold">Private address - Provide address:</span> <?php echo $hotelPrivateAddress; ?></p>
						<?php
					} elseif ( $otherHotelName == 'honolulu-airport' ) {
						$hotelHonoluluAirportAirline = get_post_meta( $order->get_id(), 'mmt_hotel_honolulu_airport_airline', true );
						$hotelHonoluluAirportFlight  = get_post_meta( $order->get_id(), 'mmt_hotel_honolulu_airport_flight', true );
						?>
                        <p><span style="font-weight: bold">Honolulu airport - Airline:</span> <?php echo $hotelHonoluluAirportAirline; ?></p>
                        
                        <p><span style="font-weight: bold">Honolulu airport - Flight:</span> <?php echo $hotelHonoluluAirportFlight; ?></p>
						<?php
					}
				}
				?>
            </div>
			<?php
		}
		
		$count   = mmt_count_person_order( $order, true );
		$listKey = mmt_list_key_billing();
		if ( ! empty( $count ) ) {
			$flag = false;
			for ( $i = 1 ; $i <= $count ; $i ++ ) {
				foreach ( $listKey as $key => $name ) {
					$key   = $key . $i;
					$value = get_post_meta( $order->get_id(), $key, true );
					if ( ! empty( $value ) ) {
						$flag = true;
						break;
					}
				}
			}
			if ( $flag ) {
				?>
                <div style="margin-bottom: 5px;">
                    <strong><h4>Addition Guests:</h4></strong>
					<?php
					for ( $i = 1 ; $i <= $count ; $i ++ ) {
						?>
                        <div style="margin-bottom: 5px;">
							<?php
							foreach ( $listKey as $key => $name ) {
								$key   = $key . $i;
								$value = get_post_meta( $order->get_id(), $key, true );
								if ( ! empty( $value ) ) {
									?>
                                    <p><span style="font-weight: bold"><?php echo $name . $i; ?>:</span> <?php echo $value; ?></p>
									<?php
								}
							}
							?>
                        </div>
						<?php
					}
					?>
                </div>
				<?php
			}
		}
		
		if ( ! empty( $date ) && ! empty( unserialize( stripslashes( $date ) ) ) ) {
			$dateArray = unserialize( stripslashes( $date ) );
			?>
            <div style="margin-bottom: 5px;">
                <strong><h4>Date options:</h4></strong>
                <div style="margin-bottom: 5px;">
                    <p><span style="font-weight: bold"><?php echo $dateArray['mmt_date_name']; ?></span></p>
                </div>
            </div>
			<?php
		}
	}
	
	add_action( 'woocommerce_order_details_after_order_table', 'mmt_order_data_billing', 99, 3 );
	add_action( 'woocommerce_email_order_meta', 'mmt_order_data_billing', 99, 5 );
	add_action( 'woocommerce_admin_order_data_after_shipping_address', 'mmt_order_data_billing', 99, 5 );
}

if ( ! function_exists( 'mmt_pre_payment_complete' ) ) {
	function mmt_pre_payment_complete() {
		if ( WC()->session ) {
			WC()->session->set( 'mmt-repeat', array() );
		}
	}
	
	add_action( 'woocommerce_pre_payment_complete', 'mmt_pre_payment_complete', 10, 3 );
}

//add_filter( 'woocommerce_email_headers', 'mm_add_email_customer_woocommerce_email_headers', 10, 3 );
if ( ! function_exists( 'mm_add_email_customer_woocommerce_email_headers' ) ) {
    function mm_add_email_customer_woocommerce_email_headers( $header, $email_id, $email_for_obj ) {
        if (strpos($email_id, 'customer') !== false) {
            $header .= 'Bcc: customer@hawaiitours.com' . "\r\n";
        }
        return $header;
    }
}
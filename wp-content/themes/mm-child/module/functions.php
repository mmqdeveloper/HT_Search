<?php

if ( ! function_exists( 'mmt_get_value_from_query_string' ) ) {
	function mmt_get_value_from_query_string( $query_string, $key ) {
		$value = false;
		
		if ( is_string( $query_string ) && is_string( $key ) ) {
			$data   = urldecode( $query_string );
			$params = is_string( $data ) ? explode( "&", $data ) : array();
			
			foreach ( $params as $param ) {
				$param_data = is_string( $param ) ? explode( "=", $param ) : array();
				
				if ( isset( $param_data[0] ) && $param_data[0] === $key ) {
					$value = isset( $param_data[1] ) ? $param_data[1] : '';
				}
			}
		}
		
		return $value;
	}
}

if ( ! function_exists( 'mmt_list_id_cart' ) ) {
	function mmt_list_id_cart() {
		$idProduct = array();
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				$idProduct[] = $item['product_id'];
			}
		}
		
		return $idProduct;
	}
}

if ( ! function_exists( 'mmt_count_person_cart' ) ) {
	function mmt_count_person_cart() {
		$count = 0;
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				$persons = $item['booking']['_persons'];
				if ( ! empty( $persons ) ) {
					foreach ( $persons as $countValue ) {
						$count += $countValue;
					}
				}
			}
		}
		
		return $count;
	}
}

if ( ! function_exists( 'mmt_count_person_order' ) ) {
	function mmt_count_person_order( $order, $isOrder = false ) {
		$count = 0;
		if ( empty( $isOrder ) ) {
			$order = wc_get_order( $order );
		}
		if ( empty( $order ) ) {
			return $count;
		}
		$lineItem = $order->get_data()['line_items'];
		if ( ! empty( $lineItem ) && is_array( $lineItem ) ) {
			foreach ( $lineItem as $key => $value ) {
				$bookingIds = WC_Booking_Data_Store::get_booking_ids_from_order_item_id( $key );
				if ( ! empty( $bookingIds ) && is_array( $bookingIds ) ) {
					foreach ( $bookingIds as $bookingId ) {
						$booking      = new WC_Booking( $bookingId );
						$personCounts = $booking->get_person_counts();
						if ( ! empty( $personCounts ) && is_array( $personCounts ) ) {
							foreach ( $personCounts as $person ) {
								$count += $person;
							}
						}
					}
				}
			}
		}
		
		
		return $count;
	}
}

if ( ! function_exists( 'mmt_list_key_billing' ) ) {
	function mmt_list_key_billing() {
		return array(
			'mmt_first_name__' => 'First Name Guest #',
			'mmt_last_name__'  => 'Last Name Guest #',
			'mmt_birthday__'   => 'Date of Birth Guest #',
			'mmt_gender__'     => 'Gender Guests #',
			'mmt_weight__'     => 'Weight Guests #',
                        'mmt_height__'     => 'Height Guests #',
                        'mmt_riding_level__'     => 'Riding experience level Guests #'
		);
	}
}

if ( ! function_exists( 'mmt_list_upgrade_cart' ) ) {
	function mmt_list_upgrade_cart() {
		$idProduct = array();
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				$productId = $item['product_id'];
				$product   = get_post_meta( $productId, 'upgrade_product', true );
				if ( ! empty( $product ) && ! empty( unserialize( $product ) ) && is_array( unserialize( $product ) ) ) {
					$idProduct = unserialize( $product );
				}
			}
		}
		
		return $idProduct;
	}
}

if ( ! function_exists( 'mmt_get_list_product' ) ) {
	function mmt_get_list_product() {
		global $post;
		$args        = array(
			'post_status'    => array( 'publish', 'private' ),
			'post_type'      => 'product',
			'posts_per_page' => - 1,
			'post__not_in'   => array( $post->ID )
		
		);
		$listProduct = array();
		
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$listProduct[ get_the_ID() ] = get_the_title();
			endwhile;
		endif;
		
		wp_reset_postdata();
		
		return $listProduct;
	}
}

if ( ! function_exists( 'mmt_cart_only_one_item' ) ) {
	function mmt_cart_only_one_item() {
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			if ( count( $items ) > 1 ) {
				$x = 0;
				foreach ( $items as $item_key => $item ) {
					if ( ! empty( $x ) ) {
						WC()->cart->remove_cart_item( $item_key );
					}
					$x ++;
				}
			}
		}
	}
}


if ( ! function_exists( 'mmt_str_convert_to_id' ) ) {
	
	function mmt_str_convert_to_id( $str ) {
		$str = strtolower( $str );
		$str = str_replace( ';', '', $str );
		$str = str_replace( '"', '', $str );
		$str = str_replace( ' ', '-', $str );
		$str = str_replace( ',', '', $str );
		$str = str_replace( "'", '', $str );
		$str = str_replace( "\n", '', $str );
		$str = str_replace( "\r", '', $str );
		$str = str_replace( '<br/>', '-', $str );
		
		return $str;
	}
}

if ( ! function_exists( 'mmt_str_remove_enter' ) ) {
	
	function mmt_str_remove_enter( $str ) {
		$str = str_replace( "\n", '', $str );
		$str = str_replace( "\r", '', $str );
		$str = str_replace( '<br/>', '-', $str );
		
		return $str;
	}
}

if ( ! function_exists( 'mmt_str_to_text_uc_word' ) ) {
	
	function mmt_str_to_text_uc_word( $str ) {
		$str = str_replace( '-', ' ', $str );
		$str = ucwords( $str );
		
		return $str;
	}
}

if ( ! function_exists( 'mmt_is_friday_tour' ) ) {
	function mmt_is_friday_tour() {
		$isFriday = false;
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				$productId   = $item['product_id'];
				$cartBooking = $item['booking']['_start_date'];
				$date        = date( 'l', $cartBooking );
				if ( $productId == '3874' && $date == 'Friday' ) {
//				if ( $productId == '3884' && $date == 'Friday' ) {
					$isFriday = true;
				}
			}
		}
		
		return $isFriday;
	}
}


if ( ! function_exists( 'mmt_get_form_repeater' ) ) {
	function mmt_get_form_repeater( $sectionId, $title, $repeater ) {
		global $post;
		$id        = $post->ID;
		$dataArray = array();
		$data      = get_post_meta( $id, $sectionId, true );
		if ( ! empty( $data ) && ! empty( unserialize( $data ) ) ) {
			$dataArray = unserialize( $data );
		}
		?>
        <div class="mmt-section <?php echo $sectionId; ?>">
            <div class="mmt-section-title"><?php echo $title; ?></div>
            <div class="options_group mmt-on-load" style="display: none;">
                <button type="button" class="button mmt-onload-js">New <?php echo $title; ?></button>
            </div>
            <div class="options_group mmt-add-on-panel mmt-repeater-list <?php echo empty( $dataArray ) ? 'mmt-repeater-hide' : ''; ?>">
                <div data-repeater-list="<?php echo $sectionId; ?>" class="outer mmt-outer-wrap">
                    <div data-repeater-item class="outer">
                        <div class="mmt-header">
                            <div class="mmt-header-filed">
                                <div class="mmt-field">
                                    <div class="mmt-text">
                                        <span>Type - </span>
                                    </div>
                                    <select name="mmt-group">
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="label">Label</option>
                                    </select>
                                </div>
                                <div class="mmt-field">
                                    <div class="label">Child:</div>
                                    <select name="mmt-child">
                                        <option value="false">False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mmt-header-filed">
                                <div class="mmt-field">
                                    <span class="label">ID <span style="color: red;">*</span>: </span> <input type="text" name="mmt-id" value=""/>
                                </div>
                                <div class="mmt-field">
                                    <span class="label">Title <span style="color: red;">*</span>: </span> <input type="text" name="mmt-title" value=""/>
                                </div>
                            </div>
                            <div class="mmt-header-right">
                                <div class="mmt-header-arrow">
                                    Collapse / Expand
                                </div>
                                <input data-repeater-delete type="button" value="Remove" class="button"/>
                            </div>
                        </div>
                        <div class="inner-repeater mmt-body">
                            <div data-repeater-list="inner-group" class="inner mmt-body-inner">
                                <div data-repeater-item class="mmt-item-inner">
                                    <div class="mmt-item-wrap">
                                        <div class="mmt-field mmt-field-label">
                                            <div class="label">Label</div>
                                            <input type="text" name="mmt-label" value=""/>
                                        </div>
                                        <div class="mmt-field mmt-field-price">
                                            <div class="label">Price</div>
                                            <input type="text" name="mmt-price" value="" placeholder="0.00"/>
                                        </div>
                                        <div class="mmt-field mmt-field-person">
                                            <div class="label">Person</div>
                                            <input type="checkbox" name="mmt-person" value="true"/>
                                        </div>
                                        <div class="mmt-field mmt-field-description">
                                            <div class="label">Description</div>
                                            <textarea name="mmt-description"></textarea>
                                        </div>
                                        <div class="mmt-field mmt-field-left left-50 mmt-field-default">
                                            <div class="label">Checked</div>
                                            <input type="checkbox" name="mmt-checked" value="true"/>
                                        </div>
                                        <div class="mmt-field mmt-field-right mmt-field-parent">
                                            <div class="label">Parent ID</div>
                                            <input type="text" name="mmt-parent" value=""/>
                                        </div>
                                        <div class="mmt-field mmt-field-default">
                                            <div class="label">Resource</div>
                                            <input type="text" name="mmt-resource" value=""/>
                                        </div>
                                        <div class="mmt-field mmt-field-default">
                                            <div class="label">Select quantity</div>
                                            <input type="checkbox" name="mmt-quantity" value="true"/>
                                        </div>
                                    </div>
                                    <input data-repeater-delete type="button" value="X" class="inner button mmt-remove-item"/>
                                </div>
                            </div>
                            <div class="mmt-add-item">
                                <input data-repeater-create type="button" value="New Option" class="inner button"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mmt-add-new-option">
                    <input data-repeater-create type="button" value="New Fields" class="outer button"/>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            (function ($) {
                "use strict";

                jQuery(document).on('ready', function () {

                    var section_form_repeater = $('.<?php echo $sectionId; ?>'),
                        repeaterWrap_section_form_repeater = section_form_repeater.find('.mmt-repeater-list');

                    if (section_form_repeater.find('.mmt-repeater-hide').length) {
                        repeaterWrap_section_form_repeater.hide();
                        section_form_repeater.find('.mmt-on-load').show();
                    } else {
                        repeaterWrap_section_form_repeater.show();
                        section_form_repeater.find('.mmt-on-load').hide();
                    }

                    $(document.body).on('click', '.mmt-onload-js', function () {
                        $(this).parents('.mmt-section').find('.mmt-repeater-hide').show();
                        $(this).parent().remove();
                    });

                    var <?php echo $repeater; ?> =
                    repeaterWrap_section_form_repeater.repeater({
                        isFirstItemUndeletable: false,
                        defaultValues: {
                            'mmt-group': 'radio',
                            'mmt-child': 'false',
                        },
                        show: function () {
                            $(this).slideDown();
                        },
                        hide: function (deleteElement) {
                            if (confirm('Are you sure you want to delete this element?')) {
                                $(this).slideUp(deleteElement);
                            }
                        },
                        repeaters: [{
                            isFirstItemUndeletable: false,
                            selector: '.inner-repeater',
                            defaultValues: {
                                'mmt-child': 'false',
                            },
                            show: function () {
                                $(this).slideDown();
                            },
                            hide: function (deleteElement) {
                                $(this).slideUp(deleteElement);
                            }
                        }]
                    });
					<?php
					if ( ! empty( $dataArray ) ) {
					echo $repeater; ?>.
                    setList(<?php echo json_encode( $dataArray ); ?>);
					<?php
					}
					?>
                });
            })(jQuery);
        </script>

       		<?php
	}
}

if ( ! function_exists( 'mmt_get_form_lunch_repeater' ) ) {
	function mmt_get_form_lunch_repeater( $sectionId, $title, $repeater ) {
		global $post;
		$id        = $post->ID;
		$dataArray = array();
		$data      = get_post_meta( $id, $sectionId, true );
		if ( ! empty( $data ) && ! empty( unserialize( $data ) ) ) {
			$dataArray = unserialize( $data );
		}
		?>
        <div class="mmt-section <?php echo $sectionId; ?>">
            <div class="mmt-section-title"><?php echo $title; ?></div>
            <div class="options_group mmt-on-load" style="display: none;">
                <button type="button" class="button mmt-onload-js">New <?php echo $title; ?></button>
            </div>
            <div class="options_group mmt-add-on-panel mmt-repeater-list <?php echo empty( $dataArray ) ? 'mmt-repeater-hide' : ''; ?>">
                <div data-repeater-list="<?php echo $sectionId; ?>" class="outer mmt-outer-wrap">
                    <div data-repeater-item class="outer">
                        <div class="mmt-header">
                            <div class="mmt-header-filed">
                                <div class="mmt-field">
                                    <div class="mmt-text">
                                        <span>Type - </span>
                                    </div>
                                    <select name="mmt-group">
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="label">Label</option>
                                    </select>
                                </div>
                                <div class="mmt-field">
                                    <div class="label">Child:</div>
                                    <select name="mmt-child">
                                        <option value="false">False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mmt-header-filed">
                                <div class="mmt-field">
                                    <span class="label">ID <span style="color: red;">*</span>: </span> <input type="text" name="mmt-id" value=""/>
                                </div>
                                <div class="mmt-field">
                                    <span class="label">Title <span style="color: red;">*</span>: </span> <input type="text" name="mmt-title" value=""/>
                                </div>
                            </div>
                            <div class="mmt-header-right">
                                <div class="mmt-header-arrow">
                                    Collapse / Expand
                                </div>
                                <input data-repeater-delete type="button" value="Remove" class="button"/>
                            </div>
                        </div>
                        <div class="inner-repeater mmt-body">
                            <div data-repeater-list="inner-group" class="inner mmt-body-inner">
                                <div data-repeater-item class="mmt-item-inner">
                                    <div class="mmt-item-wrap">
                                        <div class="mmt-field mmt-field-label">
                                            <div class="label">Label</div>
                                            <input type="text" name="mmt-label" value=""/>
                                        </div>
                                        <div class="mmt-field mmt-field-price">
                                            <div class="label">Price</div>
                                            <input type="text" name="mmt-price" value="" placeholder="0.00"/>
                                        </div>
                                        <div class="mmt-field mmt-field-person">
                                            <div class="label">Person</div>
                                            <input type="checkbox" name="mmt-person" value="true"/>
                                        </div>
                                        <div class="mmt-field mmt-field-description">
                                            <div class="label">Description</div>
                                            <textarea name="mmt-description"></textarea>
                                        </div>
                                        <div class="mmt-field mmt-field-left left-50 mmt-field-default">
                                            <div class="label">Checked</div>
                                            <input type="checkbox" name="mmt-checked" value="true"/>
                                        </div>
                                        <div class="mmt-field mmt-field-left mmt-field-default">
                                            <div class="label">Select quantity</div>
                                            <input type="checkbox" name="mmt-quantity" value="true"/>
                                        </div>
                                        <div class="mmt-field mmt-field-right mmt-field-parent">
                                            <div class="label">Parent ID</div>
                                            <input type="text" name="mmt-parent" value=""/>
                                        </div>
                                        <div class="mmt-field mmt-field-default">
                                            <div class="label">Resource</div>
                                            <input type="text" name="mmt-resource" value=""/>
                                        </div>
                                    </div>
                                    <input data-repeater-delete type="button" value="X" class="inner button mmt-remove-item"/>
                                </div>
                            </div>
                            <div class="mmt-add-item">
                                <input data-repeater-create type="button" value="New Option" class="inner button"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mmt-add-new-option">
                    <input data-repeater-create type="button" value="New Fields" class="outer button"/>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            (function ($) {
                "use strict";

                jQuery(document).on('ready', function () {

                    var section_lunch = $('.<?php echo $sectionId; ?>'),
                        repeaterWrap_lunch = section_lunch.find('.mmt-repeater-list');

                    if (section_lunch.find('.mmt-repeater-hide').length) {
                        repeaterWrap_lunch.hide();
                        section_lunch.find('.mmt-on-load').show();
                    } else {
                        repeaterWrap_lunch.show();
                        section_lunch.find('.mmt-on-load').hide();
                    }

                    $(document.body).on('click', '.mmt-onload-js', function () {
                        $(this).parents('.mmt-section').find('.mmt-repeater-hide').show();
                        $(this).parent().remove();
                    }); 

                    var <?php echo $repeater; ?> =
                    repeaterWrap_lunch.repeater({
                        isFirstItemUndeletable: false,
                        defaultValues: {
                            'mmt-group': 'radio',
                            'mmt-child': 'false',
                        },
                        show: function () {
                            $(this).slideDown();
                        },
                        hide: function (deleteElement) {
                            if (confirm('Are you sure you want to delete this element?')) {
                                $(this).slideUp(deleteElement);
                            }
                        },
                        repeaters: [{
                            isFirstItemUndeletable: false,
                            selector: '.inner-repeater',
                            defaultValues: {
                                'mmt-child': 'false',
                            },
                            show: function () {
                                $(this).slideDown();
                            },
                            hide: function (deleteElement) {
                                $(this).slideUp(deleteElement);
                            }
                        }]
                    });
					<?php
					if ( ! empty( $dataArray ) ) {
					echo $repeater; ?>.
                    setList(<?php echo json_encode( $dataArray ); ?>);
					<?php
					}
					?>
                });
            })(jQuery);
        </script>

       		<?php
	}
}

if ( ! function_exists( 'mmt_check_data_repeater' ) ) {
	function mmt_check_data_repeater( $data ) {
		if ( empty( $data ) || ! is_array( $data ) ) {
			return array();
		}
		
		if ( count( $data ) <= 1 && empty( $data[0]['mmt-id'] ) ) {
			return array();
		}
		
		return serialize( $data );
		
	}
}

if ( ! function_exists( 'mmt_format_list_data_repeater' ) ) {
	function mmt_format_list_data_repeater( $data ) {
		
		$dataParent = array();
		$dataChild  = array();
		foreach ( $data as $item ) {
			if ( ! empty( $item['mmt-id'] ) ) {
				if ( $item['mmt-child'] === 'true' ) {
					$dataChild[ mmt_convert_text_id( $item['mmt-id'] ) ] = $item;
				} else {
					$dataParent[ mmt_convert_text_id( $item['mmt-id'] ) ] = $item;
				}
			}
		}
		
		return array(
			'parent' => $dataParent,
			'child'  => $dataChild,
		);
	}
}


if ( ! function_exists( 'mmt_convert_text_id' ) ) {
	function mmt_convert_text_id( $text ) {
		$text = strtolower( $text );
		$text = str_replace( ' ', '_', $text );
		$text = str_replace( ';', '_', $text );
		$text = str_replace( '  ', '_', $text );
		$text = str_replace( '(', '_', $text );
		$text = str_replace( ')', '_', $text );
		$text = str_replace( '.', '_', $text );
		$text = str_replace( '-', '_', $text );
		$text = str_replace( ',', '_', $text );
		$text = str_replace( '/', '_', $text );
		$text = str_replace( '|', '_', $text );
		$text = str_replace( '=', '_', $text );
		$text = str_replace( '+', '_', $text );
		$text = str_replace( '$', '_', $text );
		
		return $text;
	}
}

if ( ! function_exists( 'mmt_billing_form_repeater' ) ) {
	
	function mmt_billing_form_repeater( $listParent, $listChild ) {
		if ( empty( $listParent ) ) {
			return false;
		}
		
		$carSession = WC()->session->get( 'mmt-repeat' );
		$carDefault = WC()->session->get( 'cart-default' );
		$items_cart = WC()->cart->get_cart();
                $items_year = '';
                foreach ($items_cart as $item_key => $item) {
                    $items_year = $item["booking"]["_year"];
                }
		if ( is_array( $listParent ) ) {
			foreach ( $listParent as $parent ) {
				if ( ! empty( $parent['mmt-group'] ) && $parent['mmt-group'] == 'label' ) {
					?>
                    <div class="mmt-repeater-wrap mmt-repeater-label">
                        <div class="mmt-filed-label">
							<?php echo ! empty( $parent['mmt-title'] ) ? $parent['mmt-title'] : ''; ?>
                        </div>
                    </div>
					<?php
				} else {
					if ( ! empty( $carSession[ 'mmt_repeat_' . mmt_convert_text_id( $parent['mmt-id'] ) ] ) ) {
						
						$listSession = $carSession[ 'mmt_repeat_' . mmt_convert_text_id( $parent['mmt-id'] ) ];
						if ( is_array( $listSession ) ) {
							foreach ( $listSession as $sessionItem ) {
								$sessionParentData[] = unserialize( $sessionItem )['parent'];
							}
						} else {
							$sessionParentData[] = unserialize( $listSession )['parent'];
						}
						
						$style = 'style="display: block;"';
					} else {
						$sessionParentData = array();
						$style             = '';
					}
					$parentGroupType = $parent['mmt-group'] == 'checkbox' ? '[]' : '';
					$idProductInCart = mmt_list_id_cart();
					$upgradePrivate  = 1120;
					$isPrivate       = false;
					if ( in_array( $upgradePrivate, $idProductInCart ) ) {
						$isPrivate = 'is_private';
					}
					?>
                    <div class="mmt-upgrade-list mmt-repeater-wrap <?php echo $isPrivate; ?> mmt-product-id-<?php echo mmt_list_id_cart()[0]; ?>">
                        <div class="upgrade-title">
							<?php echo $parent['mmt-title']; ?>
                            <div class="upgrade-reset" <?php echo $style; ?>>x</div>
                        </div>
                        <div class="mmt-repeater-item">
							<?php
							if ( ! empty( $parent['inner-group'] ) && is_array( $parent['inner-group'] ) ) {
								$x = 0;
								foreach ( $parent['inner-group'] as $inner ) {
                                                                    if($items_year > 2019 && mmt_list_id_cart()[0]=='3129'){
                                                                        if($inner['mmt-label']=='Round trip transportation from Waikiki ($20 per person)'){
                                                                            $inner['mmt-label'] = 'Round trip transportation from Waikiki ($25 per person)';
                                                                            $inner['mmt-price'] = '25';
                                                                        }
                                                                    }
									$valueInner = serialize( array(
										'title'    => $parent['mmt-title'],
										'label'    => $inner['mmt-label'],
										'price'    => $inner['mmt-price'],
										'person'   => $inner['mmt-person'],
										'resource' => $inner['mmt-resource'],
										'parent'   => mmt_convert_text_id( $inner['mmt-label'] ),
										'is_child' => false,
									) );
									$checkInner = '';
									if ( ! empty( $sessionParentData ) ) {
										if ( in_array( mmt_convert_text_id( $inner['mmt-label'] ), $sessionParentData ) ) {
											$checkInner = 'checked="checked"';
										}
									} elseif ( ! empty( $carDefault ) && ! empty( $carDefault['_resource_id'] ) ) {
										$checkInner = checked( $carDefault['_resource_id'], $inner['mmt-resource'], false );
									} elseif ( ! empty( $inner['mmt-checked'] ) && ! empty( $inner['mmt-checked'][0] ) && $inner['mmt-checked'][0] == 'true' ) {
										$checkInner = 'checked="checked"';
									}
									$quantityCheck = false;
									if ( ! empty( $inner['mmt-quantity'][0] ) && $inner['mmt-quantity'][0] == 'true' ) {
										$quantityCheck = true;
									}
									?>
                                    <div class="mmt-upgrade mmt-item-<?php echo $x; ?> <?php echo $quantityCheck ? 'mmt-quantity-wrap' : ''; ?>">
                                        <label class="mmt-upgrade-label" <?php echo $quantityCheck ? 'for="mmt_repeat_child_' . mmt_convert_text_id( $inner['mmt-label'] ) . '"' : ''; ?>>
                                            
                                            <input class="mmt-input-repeat" <?php echo $checkInner; ?> value='<?php echo $valueInner; ?>' id="mmt_repeat_<?php echo mmt_convert_text_id( $inner['mmt-label'] ); ?>" type="<?php echo $parent['mmt-group']; ?>" name="mmt_repeat_<?php echo mmt_convert_text_id( $parent['mmt-id'] ); ?><?php echo $parentGroupType; ?>">
                                            
                                            <span class="mmt-label"><?php echo $inner['mmt-label']; ?></span>
											
											<?php
											if ( ! empty( $inner['mmt-quantity'][0] ) && $inner['mmt-quantity'][0] == 'true' ) {
												$quantity = $carSession[ 'mmt_repeat_quantity_' . mmt_convert_text_id( $inner['mmt-label'] ) ];
												?>
                                                <span class="mmt-quantity-select">
                                                    <span class="mmt-quantity-count">
                                                        <span class="mmt-button-qty" data-quantity="minus">
                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                        </span>
                                                        <input type="number" value="<?php echo ! empty( $quantity ) ? $quantity : '0' ?>" step="1" min="0" max="50" name="mmt_repeat_quantity_<?php echo mmt_convert_text_id( $inner['mmt-label'] ); ?>"/>
                                                        <span class="mmt-button-qty" data-quantity="plus">
                                                             <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </span>
                                                    </span>
                                                </span>
												<?php
											}
											if ( ! empty( $inner['mmt-parent'] ) ) {
												$innerParent = $listChild[ $inner['mmt-parent'] ];
												if ( ! empty( $innerParent ) && ! empty( $innerParent['inner-group'] ) && is_array( $innerParent['inner-group'] ) ) {
													
													$listSessionChild = $carSession[ 'mmt_repeat_child_' . mmt_convert_text_id( $parent['mmt-id'] ) ];
													
													if ( ! empty( $listSessionChild ) ) {
														
														if ( is_array( $listSessionChild ) ) {
															foreach ( $listSessionChild as $sessionItemChild ) {
																$sessionParentDataChild[] = unserialize( $sessionItemChild )['checked'];
															}
														} else {
															$sessionParentDataChild[] = unserialize( $listSessionChild )['checked'];
															
														}
													} else {
														$sessionParentDataChild = array();
													}
													
													?>
                                                    <div class="mmt-repeater-item-child">
														<?php
														foreach ( $innerParent['inner-group'] as $innerChild ) {
															$valueInnerChild = serialize( array(
																'title'    => $parent['mmt-title'],
																'label'    => $innerChild['mmt-label'],
																'price'    => $innerChild['mmt-price'],
																'person'   => $inner['mmt-price'],
																'resource' => $innerChild['mmt-resource'],
																'parent'   => mmt_convert_text_id( $inner['mmt-label'] ),
																'checked'  => mmt_convert_text_id( $innerChild['mmt-label'] ),
																'is_child' => true,
															) );
															$childGroupType  = $innerParent['mmt-group'] == 'checkbox' ? '[]' : '';
															$checkInnerChild = '';
															
															if ( ! empty( $sessionParentDataChild ) ) {
																if ( in_array( mmt_convert_text_id( $innerChild['mmt-label'] ), $sessionParentDataChild ) ) {
																	$checkInnerChild = 'checked="checked"';
																}
															} elseif ( ! empty( $carDefault ) && ! empty( $carDefault['_resource_id'] ) ) {
																$checkInnerChild = checked( $carDefault['_resource_id'], $innerChild['mmt-resource'], false );
															} elseif ( ! empty( $innerChild['mmt-checked'] ) && ! empty( $innerChild['mmt-checked'][0] ) && $innerChild['mmt-checked'][0] == 'true' ) {
																$checkInnerChild = 'checked="checked"';
															}
															
															$quantityChildCheck = false;
															if ( ! empty( $inner['mmt-quantity'][0] ) && $inner['mmt-quantity'][0] == 'true' ) {
																$quantityChildCheck = true;
															}
															?>
                                                            <div class="mmt-upgrade <?php echo $quantityChildCheck ? 'mmt-quantity-wrap' : ''; ?>">
                                                                <label class="mmt-upgrade-label" <?php echo $quantityChildCheck ? 'for="mmt_repeat_child_' . mmt_convert_text_id( $innerChild['mmt-label'] ) . '"' : ''; ?> >
                                                                    
                                                                    <input class="mmt-input-repeat" <?php echo $checkInnerChild; ?> value='<?php echo $valueInnerChild; ?>' id="mmt_repeat_child_<?php echo mmt_convert_text_id( $innerChild['mmt-label'] ); ?>" type="<?php echo $innerParent['mmt-group']; ?>" name="mmt_repeat_child_<?php echo mmt_convert_text_id( $parent['mmt-id'] ); ?><?php echo $childGroupType; ?>">
                                                                    
                                                                    <span class="mmt-label"><?php echo $innerChild['mmt-label']; ?></span>
																	
																	<?php
																	if ( ! empty( $innerChild['mmt-quantity'][0] ) && $innerChild['mmt-quantity'][0] == 'true' ) {
																		$quantityChild = $carSession[ 'mmt_repeat_quantity_' . mmt_convert_text_id( $innerChild['mmt-label'] ) ];
																		?>
                                                                        <span class="mmt-quantity-select">
<!--                                                                            <span class="mmt-quantity-label">Qty: </span>-->
                                                                            <span class="mmt-quantity-count">
                                                                                <span class="mmt-button-qty" data-quantity="minus">
                                                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                                                </span>
                                                                                <input type="number" value="<?php echo ! empty( $quantityChild ) ? $quantityChild : '0' ?>" step="1" min="0" max="50" name="mmt_repeat_quantity_<?php echo mmt_convert_text_id( $innerChild['mmt-label'] ); ?>"/>
                                                                                <span class="mmt-button-qty" data-quantity="plus">
                                                                                     <i class="fa fa-plus" aria-hidden="true"></i>
                                                                                </span>
                                                                            </span>
                                                                        </span>
																		<?php
																	}
																	?>
                                                                </label>
																<?php
																if ( ! empty( $innerChild['mmt-description'] ) ) {
																	?>
                                                                    <div class="mmt-tooltip">
                                                                        <i class="fa fa-info-circle"></i>
                                                                        <div class="mmt-tooltip-content">
																			<?php echo $innerChild['mmt-description']; ?>
                                                                        </div>
                                                                    </div>
																	<?php
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
											?>
                                        </label>
										<?php
										if ( ! empty( $inner['mmt-description'] ) ) {
											?>
                                            <div class="mmt-tooltip">
                                                <i class="fa fa-info-circle"></i>
                                                <div class="mmt-tooltip-content">
													<?php echo $inner['mmt-description']; ?>
                                                </div>
                                            </div>
											<?php
										}
										?>
                                    </div>
									<?php
									$x ++;
								}
							}
							?>
                        </div>
                    </div>
					<?php
				}
			}
		}
	}
}

if ( ! function_exists( 'mmt_get_billing_form' ) ) {
	function mmt_get_billing_form() {
		$lunchOptions  = array();
		$addonsOptions = array();
		$date          = '';
                $label_day = '';
		$price         = 0;
		$person        = 'no';
		if ( ! empty( WC()->cart->cart_contents ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				
//				if ( $item['product_id'] == '11773' && ! empty( $item['booking']['_time'] ) && $item['booking']['_time'] == '12:00' ) {
//					?>
<!--                    <input type="hidden" class="mmt-condition" value="11773-time-1200"/>-->
<!--					--><?php
//				}
				
				$productId   = $item['product_id'];
				$cartBooking = $item['booking']['_start_date'];
				$date        = date( 'l', $cartBooking );
				switch ( $date ) {
					case 'Monday':
						$day    = get_post_meta( $productId, 'mmt_monday', true );
						$price  = get_post_meta( $productId, 'mmt_monday_price', true );
						$person = get_post_meta( $productId, 'mmt_monday_person', true );
						$label_day = get_post_meta( $productId, 'mmt_monday_label', true );
						break;
					case 'Tuesday':
						$day    = get_post_meta( $productId, 'mmt_tuesday', true );
						$price  = get_post_meta( $productId, 'mmt_tuesday_price', true );
						$person = get_post_meta( $productId, 'mmt_tuesday_person', true );
						$label_day = get_post_meta( $productId, 'mmt_tuesday_label', true );
						break;
					case 'Wednesday':
						$day    = get_post_meta( $productId, 'mmt_wednesday', true );
						$price  = get_post_meta( $productId, 'mmt_wednesday_price', true );
						$person = get_post_meta( $productId, 'mmt_wednesday_person', true );
						$label_day = get_post_meta( $productId, 'mmt_wednesday_label', true );
						break;
					case 'Thursday':
						$day    = get_post_meta( $productId, 'mmt_thursday', true );
						$price  = get_post_meta( $productId, 'mmt_thursday_price', true );
						$person = get_post_meta( $productId, 'mmt_thursday_person', true );
						$label_day = get_post_meta( $productId, 'mmt_thursday_label', true );
						break;
					case 'Friday':
						$day    = get_post_meta( $productId, 'mmt_friday', true );
						$price  = get_post_meta( $productId, 'mmt_friday_price', true );
						$person = get_post_meta( $productId, 'mmt_friday_person', true );
						$label_day = get_post_meta( $productId, 'mmt_friday_label', true );
						break;
					case 'Saturday':
						$day    = get_post_meta( $productId, 'mmt_saturday', true );
						$price  = get_post_meta( $productId, 'mmt_saturday_price', true );
						$person = get_post_meta( $productId, 'mmt_saturday_person', true );
						$label_day = get_post_meta( $productId, 'mmt_saturday_label', true );
						break;
					case 'Sunday':
						$day    = get_post_meta( $productId, 'mmt_sunday', true );
						$price  = get_post_meta( $productId, 'mmt_sunday_price', true );
						$person = get_post_meta( $productId, 'mmt_sunday_person', true );
						$label_day = get_post_meta( $productId, 'mmt_sunday_label', true );
						break;
				}
				
				$lunchOptions  = get_post_meta( $productId, 'mmt_section_lunch_options', true );
				$addonsOptions = get_post_meta( $productId, 'mmt_section_addons_options', true );
				
				if ( ! empty( $lunchOptions ) ) {
					$lunchOptions = unserialize( $lunchOptions );
				}
				if ( ! empty( $addonsOptions ) ) {
					$addonsOptions = unserialize( $addonsOptions );
				}
			}
		}
		?>
        <div class="mmt-upgrade-wrap">
			<?php
			if ( ! empty( $addonsOptions ) ) {
				$addonsOptions       = mmt_format_list_data_repeater( $addonsOptions );
				$addonsOptionsParent = $addonsOptions['parent'];
				$addonsOptionsChild  = $addonsOptions['child'];
				mmt_billing_form_repeater( $addonsOptionsParent, $addonsOptionsChild );
			}
			if ( ! empty( $lunchOptions ) ) {
				$lunchOptions       = mmt_format_list_data_repeater( $lunchOptions );
				$lunchOptionsParent = $lunchOptions['parent'];
				$lunchOptionsChild  = $lunchOptions['child'];
				mmt_billing_form_repeater( $lunchOptionsParent, $lunchOptionsChild );
			}
			if ( ! empty( $day ) && $day == 'yes' ) {
				?>
                <div class="mmt-upgrade-list mmt-repeater-wrap">
                    <div class="upgrade-title">
                        Date options
                        <div class="upgrade-reset">x</div>
                    </div>
                    <div class="mmt-upgrade mmt-repeater-item">
                        <label class="mmt-upgrade-label" for="mmt_date_options">
                            
                            <input id="mmt_date_options" type="radio" value="yes" name="mmt_date_options">
                            
                            <input type="hidden" value="<?php echo $price; ?>" name="mmt_date_options_price">
                            
                            <input type="hidden" value="<?php if($label_day!='') echo $label_day; else echo $date; ?>" name="mmt_date_name">
                            
                            <input type="hidden" value="<?php echo $person; ?>" name="mmt_date_options_person">
                            
                            <span><?php if($label_day!='') echo $label_day; else echo $date; ?></span>
                        
                        </label>
                    </div>
                </div>
				<?php
			}
			?>
        </div>
		<?php
	}
}


if ( ! function_exists( 'mmt_check_upgrade_product' ) ) {
	
	function mmt_check_upgrade_product( $upgradeProduct ) {
		$cartUpgradeProduct = WC()->session->get( 'mmt-repeat' );
		$carDefault         = WC()->session->get( 'cart-default' );
		$resource           = '';
		$cartProperty       = mmt_get_cart_property();
		
		foreach ( $cartUpgradeProduct as $cart ) {
			$array = unserialize( $cart );
			
			if ( ! empty( $array['resource'] ) ) {
				$resource = $array['resource'];
			}
		}
		
		if ( empty( $resource ) ) {
			$resource = $carDefault['_resource_id'];
		}
		
		if ( is_array( $upgradeProduct ) ) {
			foreach ( $upgradeProduct as $id ) {
				$total = mmt_get_cost_resource( $id, $resource );
				if ( (int) $total >= (int) $cartProperty['total'] ) {
					return true;
				}
			}
		}
		
		return false;
	}
}


if ( ! function_exists( 'mmt_get_cart_property' ) ) {
	function mmt_get_cart_property() {
		$cart  = array();
		$items = array();
		if ( ! empty( WC()->cart->get_cart() ) ) {
			$items = WC()->cart->get_cart();
			
			foreach ( $items as $item_key => $item ) {
				$productId   = $item['product_id'];
				$booking     = $item['data'];
				$cartBooking = $item['booking'];
				$bkResource  = $cartBooking['_resource_id'];
				$bkPersons   = $cartBooking['_persons'];
				$bkCost      = $cartBooking['_cost'];
				$cost        = $booking->get_display_cost();
				$baseCosts   = $booking->get_resource_base_costs();
				$personTypes = $booking->get_person_types();
				$personList  = array();
				if ( ! empty( $personTypes ) && is_array( $personTypes ) ) {
					foreach ( $personTypes as $key => $person ) {
						$personList[ $key ] = $person->get_cost();
					}
				}
				$cart['product_id']  = $productId;
				$cart['resource_id'] = $bkResource;
				$cart['person']      = $bkPersons;
				$cart['person_cart'] = array_values( $bkPersons );
				$cart['cost']        = $cost;
				$cart['base_cost']   = $baseCosts;
				$cart['person_list'] = $personList;
				$cart['total']       = $bkCost;
			}
		}
		
		return apply_filters( 'mmt_get_cart_property', $cart, $items );
	}
}


if ( ! function_exists( 'mmt_get_cost_resource' ) ) {
	function mmt_get_cost_resource( $productId, $resource ) {
		$product = wc_get_product( $productId );
		$x       = 0;
		$total   = 0;
		$ugCost  = 0;
		if ( ! empty( $product ) ) {
			$cartProperty       = mmt_get_cart_property();
			$productBaseCost    = $product->get_resource_base_costs();
			$productPersonTypes = $product->get_person_types();
			
			if ( ! empty( $productBaseCost[ $resource ] ) ) {
				$ugCost = $productBaseCost[ $resource ];
			}
			
			if ( ! empty( $productPersonTypes ) && is_array( $productPersonTypes ) ) {
				foreach ( $productPersonTypes as $key => $person ) {
					
					$total += ( ( ( float) $person->get_cost() + ( float) $ugCost ) * ( float ) $cartProperty['person_cart'][ $x ] );
					$x ++;
				}
			}
		}
		
		return $total;
	}
}
if ( ! function_exists( 'mm_check_is_helicopter_fly' ) ) {
    function mm_check_is_helicopter_fly($product_id) {
        $flag = false;
        $productId    = $product_id;
        $titleProduct = strtolower( get_the_title( $productId ) );
        $terms = get_the_terms ( $productId, 'product_cat' );
        $cat_id = array();
        foreach ( $terms as $term ) {
            $cat_id[] = $term->term_id;
        } 
        if ( preg_match( '/\bhelicopter\b/', $titleProduct ) or preg_match( '/\bhaleakala\b/', $titleProduct ) ) {
                $flag = true;
        } elseif(in_array('792', $cat_id)||in_array('5056', $cat_id)||in_array('680', $cat_id)||in_array('5055', $cat_id)||in_array('11608', $cat_id)
                ||$productId == 9736  ||$productId == 3575 ||$productId == 3565 ||$productId == 6028||$productId == 3894 ||$productId == 3889
                ||$productId == 88537 ||$productId == 27411||$productId == 26793||$productId == 3708||$productId == 19710||$productId == 3738
        ){
            $flag = true;
        }
        return $flag;
    }
}
if ( ! function_exists( 'mm_check_is_biking_tour' ) ) {
    function mm_check_is_biking_tour($product_id) {
        $flag = false;
        $productId    = $product_id;
        $terms = get_the_terms ( $productId, 'product_tag' );
        $cat_id = array();
        foreach ( $terms as $term ) {
            if($term->term_id == 794){
                $flag = true;
            }
        } 
        
        return $flag;
    }
}
if ( ! function_exists( 'mm_check_is_horseback' ) ) {
	
    function mm_check_is_horseback($product_id) {
        $flag = false;
        $productId    = $product_id;
        $titleProduct = strtolower( get_the_title( $productId ) );
        $terms = get_the_terms ( $productId, 'product_cat' );
        $cat_id = array();
        foreach ( $terms as $term ) {
            $cat_id[] = $term->term_id;
        } 
        if(in_array('11608', $cat_id) || in_array('3809', $cat_id) || in_array('16056', $cat_id) || in_array('3444', $cat_id)){
            $flag = true;
        }
        return $flag;
    }
}
if ( ! function_exists( 'mm_check_is_zipline_tour' ) ) {
	
    function mm_check_is_zipline_tour($product_id) {
        $flag = false;
        $productId    = $product_id;
        $titleProduct = strtolower( get_the_title( $productId ) );
        $terms = get_the_terms ( $productId, 'product_cat' );
        $cat_id = array();
        foreach ( $terms as $term ) {
            $cat_id[] = $term->term_id;
        } 
        if(in_array('2341', $cat_id) || in_array('5083', $cat_id) || in_array('2339', $cat_id) || in_array('786', $cat_id)){
            $flag = true;
        }
        return $flag;
    }
}
if ( ! function_exists( 'mm_check_is_avt_tour' ) ) {
	
    function mm_check_is_avt_tour($product_id) {
        $flag = false;
        $productId    = $product_id;
        $terms = get_the_terms ( $productId, 'product_tag' );
        $tag_id = array();
        foreach ( $terms as $term ) {
            $tag_id[] = $term->term_id;
        } 
        if(in_array('757', $tag_id) || in_array('16160', $tag_id) || in_array('16161', $tag_id)){
            $flag = true;
        }
        return $flag;
    }
}
add_action('wp_ajax_mm_ajax_load_certificate_tag', 'mm_ajax_load_certificate_tag');
add_action('wp_ajax_nopriv_mm_ajax_load_certificate_tag', 'mm_ajax_load_certificate_tag');
if ( ! function_exists( 'mm_ajax_load_certificate_tag' ) ) {
    function mm_ajax_load_certificate_tag() {
        $category_id = $_POST['category_id'];
        $certificate_id = $_POST['certificate_id'];
        $tag_id = $_POST['tag_id'];
        $page = '1';
        if(isset($_POST['page'])){
            $page = $_POST['page'] - 1;
        }
        ob_start();
        if($category_id!='-1' && $category_id!=''){
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => absint($category_id),
            );
        }
        if($tag_id!='-1' && $tag_id !=''){
            $tax_query[] = array(
                'taxonomy' => 'product_tag',
                'field'    => 'term_id',
                'terms'    => absint($tag_id),
            );
        }
        $tax_query[] = array(
            'taxonomy' => 'certificates',
            'field'    => 'term_id',
            'terms'    => absint($certificate_id),
        );
        
        if(isset($_POST['change_category'])){
            echo '<ul class="products columns-3">';
        }
        $args = array(
            'post_type' => 'product',
            'tax_query' => $tax_query,
            'post_status' => 'publish',
            'paged' => $page,
            'posts_per_page' => 12,
            'orderby' => 'post_date',
            'order' => 'DESC'
        );
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) {
            $max_page = $loop->max_num_pages;
            while ( $loop->have_posts() ) : $loop->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
        } else {
            echo __( 'No products found' );
        }
        wp_reset_postdata();
        if(isset($_POST['change_category'])){
            $style_more = 'display:none';
            if($max_page>=2){
                $style_more ='';
            }
            echo '</ul>';
            ?>
            <div class="av-masonry-pagination mm-product-load-more av-masonry-load-more" style="visibility: visible;opacity: 1; <?php echo $style_more; ?>" id="load-more" data-page="2" data-max_page="<?php echo $max_page; ?>">Load more <div class="custom-loading-icon" style="display: none;"></div></div>
            <?php
        }  
        $output = ob_get_clean();
        
        echo $output;
        die();
    }
}
add_filter( 'default_checkout_billing_country', 'mm_change_default_checkout_country' );
add_filter( 'default_checkout_billing_state', 'mm_change_default_checkout_state' );
if ( ! function_exists( 'mm_change_default_checkout_country' ) ) {
    function mm_change_default_checkout_country() {
      return 'US'; 
    }
}
if ( ! function_exists( 'mm_change_default_checkout_state' ) ) {
    function mm_change_default_checkout_state() {
      return 'US'; 
    }
}


add_action('product_tag_add_form_fields', 'add_product_tag_field_minimun_block', 10, 2);
if (!function_exists('add_product_tag_field_minimun_block')) {

    function add_product_tag_field_minimun_block($taxonomy) {
        ?>
        <div id="content">
            <p class="form-field">
                <label for="_wc_booking_min_date"><?php _e('Minimum block bookable', 'woocommerce-bookings'); ?></label>
                <input type="number" name="_wc_booking_min_date" id="_wc_booking_min_date" value="" step="1" min="0" style="margin-right: 7px; width: 4em;">
                <select name="_wc_booking_min_date_unit" id="_wc_booking_min_date_unit" class="short" style="margin-right: 7px;">
                    <option value="month"><?php _e('Month(s)', 'woocommerce-bookings'); ?></option>
                    <option value="week"><?php _e('Week(s)', 'woocommerce-bookings'); ?></option>
                    <option value="day"><?php _e('Day(s)', 'woocommerce-bookings'); ?></option>
                    <option value="hour"><?php _e('Hour(s)', 'woocommerce-bookings'); ?></option>
                </select> <?php _e('into the future', 'woocommerce-bookings'); ?>
            </p>
            <p class="form-field">
        <?php esc_html_e('Priority', 'woocommerce-bookings'); ?>&nbsp;<a class="tips" data-tip="<?php echo esc_attr(get_wc_booking_priority_explanation()); ?>">[?]</a>
                <input type="number" name="_wc_booking_min_date_priority" value="10" placeholder="10" />
            </p>
        </div>
        <?php
    }

}
add_action('product_tag_edit_form_fields', 'product_tag_edit_term_fields_minimun_block', 10, 2);

function product_tag_edit_term_fields_minimun_block($term, $taxonomy) {

    $min_date = get_term_meta($term->term_id, 'tag_min_date', true);
    $min_date_unit = get_term_meta($term->term_id, 'tag_min_date_unit', true);
    $min_date_priority = get_term_meta($term->term_id, 'tag_min_date_priority', true);
    if ($min_date_priority == '')
        $min_date_priority = 10;
    echo '<tr class="form-field">
	<th>
		<label for="_wc_booking_min_date">Minimum block bookable</label>
	</th>
	<td>
		<input name="_wc_booking_min_date" id="_wc_booking_min_date" step="1" min="0" type="number" value="' . $min_date . '" style="max-width: 200px;" />
		<select name="_wc_booking_min_date_unit" id="_wc_booking_min_date_unit" class="short" style="margin-right: 7px;">
                    <option value="month" ' . selected($min_date_unit, 'month') . '>Month(s)</option>
                    <option value="week" ' . selected($min_date_unit, 'week') . '>Week(s)</option>
                    <option value="day" ' . selected($min_date_unit, 'day') . '>Day(s)</option>
                    <option value="hour" ' . selected($min_date_unit, 'hour') . '>Hour(s)</option>
                </select>
	</td>
        </tr><tr>
        <th>
		<label for="_wc_booking_min_date_priority">Priority</label>
	</th>
	<td>
		<input name="_wc_booking_min_date_priority" id="_wc_booking_min_date_priority" type="number" value="' . $min_date_priority . '" style="max-width: 200px;"/>
		
	</td>
	</tr>';
}

add_action('created_product_tag', 'product_tag_save_term_fields_minimun_block');
add_action('edited_product_tag', 'product_tag_save_term_fields_minimun_block');

function product_tag_save_term_fields_minimun_block($term_id) {
    global $pagenow;
    $tag_min_date = '';
    $tag_min_date_unit = '';
    $tag_min_date_priority = '';
    if($pagenow != 'post.php'){
        $tag_min_date = sanitize_text_field($_POST['_wc_booking_min_date']);
        $tag_min_date_unit = sanitize_text_field($_POST['_wc_booking_min_date_unit']);
        $tag_min_date_priority = sanitize_text_field($_POST['_wc_booking_min_date_priority']);
        
    }
    update_term_meta($term_id, 'tag_min_date', $tag_min_date);
    update_term_meta($term_id, 'tag_min_date_unit', $tag_min_date_unit);
    update_term_meta($term_id, 'tag_min_date_priority', $tag_min_date_priority);
}

if (!function_exists('product_get_global_minimum_block_bookable')) {

    function product_get_global_minimum_block_bookable($product_id) {
        $minium_block = get_option('wc_global_minium_block_booking_availability');
        $min_date = $minium_block['min_date'];
        $min_date_unit = $minium_block['min_date_unit'];
        $tmp_priority = 10;
        $terms_tag = get_the_terms($product_id, 'product_tag');
        foreach ($terms_tag as $term_tag) {
            $min_date_priority = get_term_meta($term_tag->term_id, 'tag_min_date_priority', true);
            $min_date_tag = get_term_meta($term_tag->term_id, 'tag_min_date', true);
            $min_date_tag_unit = get_term_meta($term_tag->term_id, 'tag_min_date_unit', true);

            if ($min_date_priority <= $tmp_priority && $min_date_tag != '' && $min_date_tag_unit != '') {
                $tmp_priority = $min_date_priority;
                $min_date = $min_date_tag;
                $min_date_unit = $min_date_tag_unit;
            }
        }
        if ($min_date) {
            $unit = strtolower(substr($min_date_unit, 0, 1));

            if (in_array($unit, array('d', 'w', 'y', 'm'))) {
                $js_string = "+{$min_date}{$unit}";
            } elseif ('h' === $unit) {

                // if less than 24 hours are entered, we determine if the time falls in today or tomorrow.
                // if more than 24 hours are entered, we determine how many days should be marked off
                if (24 > $min_date) {
                    $current_d = date('d', current_time('timestamp'));
                    $min_d = date('d', strtotime("+{$min_date} hour", current_time('timestamp')));
                    $js_string = '+' . ( $current_d == $min_d ? 0 : 1 ) . 'd';
                } else {
                    $min_d = (int) ( $min_date / 24 );
                    $js_string = '+' . $min_d . 'd';
                }
            }
        }
        return $js_string;
    }

}
if (!function_exists('product_get_rule_block_bookable_days')) {

    function product_get_rule_block_bookable_days($availability_rules) {
        $block_rule = array();
        if(!empty($availability_rules) ){
            foreach ($availability_rules as $availability_rules_type) {
                if (!empty($availability_rules_type)) {
                    foreach ($availability_rules_type as $value_type) {
                        if ($value_type['priority'] <= 1) {
                            if (!empty($value_type['resource_id'])) {
                                $resource_id = $value_type['resource_id'];
                            } else {
                                $resource_id = 0;
                            }
                            if ($value_type['type'] == 'custom' && !empty($value_type['range'])) {
                                foreach ($value_type['range'] as $key => $value_range) {
                                    if (!empty($value_range)) {
                                        $year_block = $key;
                                        foreach ($value_range as $key_month => $value_month) {
                                            $month_block = $key_month;
                                            if (!empty($value_month)) {
                                                foreach ($value_month as $key_day => $value_day) {
                                                    $day_block = $key_day;
                                                    if ($value_day == false) {
                                                        $block_rule[$year_block . '-' . $month_block . '-' . $day_block][$resource_id] = 'custom';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if ($value_type['type'] == 'days') {
                                foreach ($value_type['range'] as $key => $value_range) {
                                    $block_rule[$key][$resource_id] = 'days';
                                }
                            }
                        }
                    }
                }
            }
        }
        return $block_rule;
    }

}

add_filter( 'ninja_forms_submit_data', 'mm_waitlist_ninja_forms_submit_data' );

function mm_waitlist_ninja_forms_submit_data( $form_data ) {   
    if($form_data['id']==14){
        $first_name = '';
        $last_name = '';
        $email = '';
        $phone = '';
        $tour_date = '';
        $deal_name_key = '';
        $customer_info_key = '';
        $travel_date_key = '';
        foreach( $form_data[ 'fields' ] as $key => $field ) { 
            if($field['key'] =='firstname_1614085781972'){
                $first_name = $field[ 'value' ];
            }
            if($field['key'] =='lastname_1614085785121'){
                $last_name = $field[ 'value' ];
            }
            if($field['key'] =='email'){
                $email = $field[ 'value' ];
            }
            if($field['key'] =='phone_1619080739269'){
                $phone = $field[ 'value' ];
            }
            if($field['key'] =='tour_date'){
                $tour_date = $field[ 'value' ];
            }
            if($field['key'] =='deal_name_1619608543892'){
            	$deal_name_key = $key;
            }
            if($field['key'] =='customer_info_1619608381878'){
            	$customer_info_key = $key;
            }
            if($field['key'] =='travel_date_1643103322212'){
            	$travel_date_key = $key;
            }
        }
        if(!empty($deal_name_key)){
        	$form_data['fields'][$deal_name_key]['value'] = $last_name.' - '.$form_data['fields'][$deal_name_key]['value'];
        }
        if(!empty($customer_info_key)){
        	$form_data['fields'][$customer_info_key]['value'] = $first_name.' '.$last_name.'
'.$email.'
'.$phone;
        }
        if(!empty($travel_date_key)){
            $form_data['fields'][$travel_date_key]['value'] =  date('Y-m-d',strtotime($tour_date));
        }
        
        $form_settings = $form_data[ 'settings' ]; // Form settings.

        $extra_data = $form_data[ 'extra' ]; // Extra data included with the submission.
    }
    return $form_data;
}
if (!function_exists('mm_add_action_woocommerce_product_duplicate_before_save')) {
    function mm_add_action_woocommerce_product_duplicate_before_save( $duplicate, $product ) { 
        $duplicate_id = $duplicate->get_id();
        $args_schema = array(
            'posts_per_page' => -1,
            'post_type' => array('aiosrs-schema'),
            'post_status' => 'publish'
        );
        $aiosrs_schema = new WP_Query($args_schema);
        while ($aiosrs_schema->have_posts()) {
            $aiosrs_schema->the_post();
            $aiosrs_schema_id = $aiosrs_schema->post->ID;
            if ( metadata_exists( 'post', $duplicate_id, 'bsf-schema-pro-review-counts-' . $aiosrs_schema_id ) ) {
                //reset rating
                update_post_meta($duplicate_id, 'bsf-schema-pro-review-counts-' . $aiosrs_schema_id, 30);
            }

        }
    }; 
}         
// add the action 
add_action( 'woocommerce_product_duplicate', 'mm_add_action_woocommerce_product_duplicate_before_save', 10, 2 );

if(!function_exists('mm_custom_avf_post_css_create_file')){
    function mm_custom_avf_post_css_create_file( $create )
    {
        return false;
    }
}
add_filter( 'avf_post_css_create_file', 'mm_custom_avf_post_css_create_file', 10, 1 );

add_action('wp_ajax_check_product_tag', 'mm_check_product_tag_function');
add_action('wp_ajax_nopriv_check_product_tag', 'mm_check_product_tag_function');

function mm_check_product_tag_function(){
	$wh_meta_title = get_term_meta(16691, 'wh_meta_title', true);
	if( isset($_POST['product_id']) ){
		$product_id = $_POST['product_id'];
		if ( is_object_in_term( $product_id , 'product_tag', 'ticket-notice' ) && !empty($wh_meta_title) ) :
			echo $wh_meta_title;
		else :
			echo '';
		endif;
	}
	wp_die();
}

add_action('product_tag_add_form_fields', 'mm_taxonomy_add_new_meta_field', 10, 1);
add_action('product_tag_edit_form_fields', 'mm_taxonomy_edit_meta_field', 10, 1);


if( !function_exists( 'mm_taxonomy_add_new_meta_field' ) ){
	function mm_taxonomy_add_new_meta_field() {
		?>
        <div class="form-field">
            <label for="wh_meta_title"><?php _e('Notice ticket', 'wh'); ?></label>
            <textarea  rows="10" cols="50" name="wh_meta_title" id="wh_meta_title"></textarea>
        </div>

		<?php
	}
}


if( !function_exists( 'mm_taxonomy_edit_meta_field' ) ){
	function mm_taxonomy_edit_meta_field($term) {

		//getting term ID
		$term_id = $term->term_id;

		// retrieve the existing value(s) for this meta field.
		$wh_meta_title = get_term_meta($term_id, 'wh_meta_title', true);

		?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="wh_meta_title"><?php _e('Notice ticket', 'wh'); ?></label></th>
            <td>

                <textarea  rows="10" cols="50" name="wh_meta_title" id="wh_meta_title"><?php echo esc_attr($wh_meta_title) ? esc_attr($wh_meta_title) :'';?></textarea>

            </td>
        </tr>

		<?php
	}
}

add_action('edited_product_tag', 'mm_save_taxonomy_custom_meta', 10, 1);
add_action('create_product_tag', 'mm_save_taxonomy_custom_meta', 10, 1);
// Save extra taxonomy fields callback function.

if( !function_exists( 'mm_save_taxonomy_custom_meta' ) ){
	function mm_save_taxonomy_custom_meta($term_id) {
		$wh_meta_title = filter_input(INPUT_POST, 'wh_meta_title');
		update_term_meta($term_id, 'wh_meta_title', $wh_meta_title);
	}
}

if(  !function_exists( 'mm_register_custom_menus' ) ){
    function mm_register_custom_menus() {
        register_nav_menus(
            array(
              'mm-menu-cart' => __( 'Cart-Checkout Menu' ),
            )
        );
    }
}
add_action( 'init', 'mm_register_custom_menus' );

add_filter( 'wp_nav_menu_items', 'mm_custom_avia_append_burger_menu', 9998, 2 );
//add_filter( 'avf_fallback_menu_items', 'mm_custom_avia_append_burger_menu', 9998, 2 );
function mm_custom_avia_append_burger_menu ( $items , $args )
{
    global $avia_config;

    $location = ( is_object( $args ) && isset( $args->theme_location ) ) ? $args->theme_location : '';
    $original_location = isset( $avia_config['current_menu_location_output'] ) ? $avia_config['current_menu_location_output'] : '';

    /**
     * Allow compatibility with plugins that change menu or third party plugins to manpulate the location
     *
     * @used_by Enfold config-menu-exchange\config.php			10
     * @since 4.1.3
     */
    $location = apply_filters( 'avf_append_burger_menu_location', $location, $original_location, $items , $args );
    
    if( ( is_object( $args ) && ( $location == 'mm-menu-cart' ) ) )
    {
        $class = avia_get_option('burger_size');

        $items .= '<li class="av-burger-menu-main menu-item-avia-special ' . $class . '">
                                <a href="#" aria-label="' . esc_attr( __( 'Menu', 'avia_framework' ) ) . '" aria-hidden="false">
                                                <span class="av-hamburger av-hamburger--spin av-js-hamburger">
                                                        <span class="av-hamburger-box">
                                                  <span class="av-hamburger-inner"></span>
                                                  <strong>' . __( 'Menu', 'avia_framework' ) . '</strong>
                                                        </span>
                                                </span>
                                                <span class="avia_hidden_link_text">' . esc_html( __( 'Menu', 'avia_framework' ) ) . '</span>
                                        </a>
                           </li>';
    }
    return $items;
}

//ajax search faq

add_action('wp_ajax_mm_search_faq_sc', 'mm_search_faq_function');
add_action('wp_ajax_nopriv_mm_search_faq_sc', 'mm_search_faq_function');

function mm_search_faq_function(){
	if( !empty( $_POST['key_faq_search'] ) ){
		$keySearch =  $_POST['key_faq_search'];
		$args = array(
			'post_type' => 'mmfaq',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'order' => 'DESC',
			'orderby' => 'title',
			's' => $keySearch,
		);

		$the_query = new WP_Query( $args );

		// The Loop
		ob_start();
		$arr_title = [];
		if ( $the_query->have_posts() ) :

			?>
            <div class="accordion-items">
				<?php
				while ( $the_query->have_posts() ) : $the_query->the_post();
					?>
                    <div class="item-arrcordian">
                        <div class="accordion-heading"><?php echo the_title(); ?></div>
                        <div class="accordion-content"><?php echo get_the_content(); ?></div>
                    </div>

				<?php

					// Do Stuff
				endwhile;
				?>
            </div>
            <a href="#" id="loadMore">Load More</a>
		<?php
		endif;
		// Reset Post Data
		wp_reset_postdata();
		$output = ob_get_clean();
		echo !empty($output) ? $output : '<h3 style="text-align: center;" class="warning">FAQ not found !</h3>';



	}else{
		echo '<h3 style="text-align: center;" class="warning">FAQ not found !</h3>';
	}
	wp_die();
}
if ( ! function_exists( 'mm_custom_yith_ywgc_preset_image_size' ) ) {
    function mm_custom_yith_ywgc_preset_image_size( $size ) {
        $size = 'thumbnail';
        return $size;
    }
    add_filter( 'yith_ywgc_preset_image_size', 'mm_custom_yith_ywgc_preset_image_size', 99, 1 );
}

if (!function_exists('mm_clear_cached_data_sitemap_page')) {
    add_action( 'save_post', 'mm_clear_cached_data_sitemap_page', 10, 1 );
    function mm_clear_cached_data_sitemap_page( $post_ID ) {
        if ($post_ID == 32408) {
            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['basedir'] . '/data_shortcode_sitemap/data_shortcode_sitemap.json';
            if (file_exists($target_dir)) {
                file_put_contents($target_dir, '');
            }
        }
        // if ( is_product() ){
        //     $upload_dir = wp_upload_dir();
        //     $blocks_hour_minutes_dir = $upload_dir['basedir'] . '/mm-product-data/mm-blocks-hour-minutes/';
        //     $json_file_path = $blocks_hour_minutes_dir . 'block-' . $post_id . '.json';
        //     if ( file_exists( $json_file_path ) ) {
        //         unlink($json_file_path);
        //     }
        // }
    }
    add_action('mm_clear_cached_page_sitemap', 'mm_clear_cached_data_sitemap_page', 10 , 1);
}
/*
if(!function_exists('mm_save_html_content_activities_page')){
    function mm_save_html_content_activities_page ( $content ) {
        if ( is_page(32408) ) {
            $get_content_html = '';
            $date = new DateTime("now", new DateTimeZone('Pacific/Honolulu') );
            $date_Now = $date->format('Y-m-d');
            $mm_time_cache = get_post_meta(32408, 'mm_time_cache', true);
            $upload_dir = wp_upload_dir();
            $file_name = 'activities_page.json';
            $json_file = $upload_dir['basedir'] . '/mm-bookingbox/' . $file_name;
            if (file_exists($json_file)) {
                $file_content = file_get_contents($json_file, true);
                $file_content = json_decode($file_content, true);
                $get_content_html = $file_content;
            }
            if($date_Now !=$mm_time_cache){
                $get_content_html = '';
            }
            if(!empty($get_content_html)){
                $content = $get_content_html;
            }else{
                $add_file_content = do_shortcode($content);
                file_put_contents($json_file, json_encode($add_file_content));
                update_post_meta(32408, 'mm_time_cache', $date_Now);
            }
            return $content;
        }

        return $content;
    }
}
add_filter( 'the_content', 'mm_save_html_content_activities_page', 0);
*/

if ( ! function_exists( 'mm_view_wp_registered_sidebars' ) ) {
    function mm_view_wp_registered_sidebars() {
        $footer_columns = avia_get_option( 'footer_columns', '5' );
    
        for ($i = 1; $i <= $footer_columns; $i++)
        {
            register_sidebar(array(
                'name' => 'Footer - column'.$i,
                'before_widget' => '<section id="%1$s" class="widget clearfix %2$s">',
                'after_widget' => '<span class="seperator extralight-border"></span></section>',
                'before_title' => '<h6 class="widgettitle">',
                'after_title' => '</h6>',
                'id'=>'av_footer_'.$i
            ));
        }
    }
    
    add_action('wp_head', 'mm_view_wp_registered_sidebars');
}


if ( ! function_exists( 'ht_custom_avf_theme_options_pages' ) ) {
    function ht_custom_avf_theme_options_pages($avia_pages) {
        $avia_pages['shop']["include"] = dirname(__FILE__) . '/admin/option_tabs/avia_shop.php';
        return $avia_pages;
    }
    
    add_filter( 'avf_theme_options_pages', 'ht_custom_avf_theme_options_pages', 10, 1);
}


if (!function_exists('mm_check_current_product')) {
	
	add_filter('wc_epo_disable', 'mm_check_current_product');
    
    function mm_check_current_product () {
        $post_id = get_the_ID();
        if (!empty($post_id)) {
            static $mm_check_current_product_count = 0;
            static $mm_check_current_product = 0;
            if ($mm_check_current_product_count > 0) {
                if (empty($mm_check_current_product)) {
                    $mm_check_current_product = $post_id;
                    return true;
                } else {
                    if ($mm_check_current_product != $post_id) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                $mm_check_current_product = $post_id;
                $mm_check_current_product_count++;
                return false;
            }
        } else {
            return false;
        }
    }
}


if( !function_exists('mm_name_display_mm_pickup') ){
    function mm_name_display_mm_pickup($columns) {
        $columns['pickup'] = 'Pickup';
        return $columns;
    }
    add_filter('manage_product_posts_columns', 'mm_name_display_mm_pickup', 10, 1);
}

if( !function_exists('mm_display_mm_pickup') ){
    // Display contents of custom column
    function mm_display_mm_pickup($column_name, $post_id) {
        if ($column_name === 'pickup') {
            $mm_pickup = get_post_meta($post_id, '_mm_pickup', true);
            if($mm_pickup){
                $output = '';
                switch ($mm_pickup) {
                    case 'pickup semi-avail':
                        $output = 'Pickup Semi-Avail';
                        break;
                    case 'pickup available':
                        $output = 'Pickup Available';
                        break;
                }
                echo $output;
            }
        }
    }
    add_action('manage_product_posts_custom_column', 'mm_display_mm_pickup', 10, 2);
}

add_action('restrict_manage_posts', 'mm_filter_mm_pickup');
if( !function_exists('mm_filter_mm_pickup') ){
    function mm_filter_mm_pickup(){
        global $typenow;
        
        if($typenow == 'product'){
            $mm_pickup = array(
                'pickup semi-avail' => 'Pickup Semi-Avail',
                'pickup available' => 'Pickup Available'
            );
            
            $get_mm_pickup = $_GET["mm_pickup"];

            echo "<select name='mm_pickup'>";
            echo "<option value=''>All Pickup</option>";
            foreach ($mm_pickup as $key => $value){
                if ( isset($get_mm_pickup) && $get_mm_pickup === $key ){
                    $selected = 'selected';
                }else{
                    $selected= '';
                }
                echo "<option value='" . $key . "' " . $selected . " >" . $value . "</option>";
            }
            echo "</select>";
        }
    }

}


if( !function_exists( 'mm_filter_product_mm_pickup_admin' ) ){

    if( isset( $_GET["mm_pickup"]) && $_GET["mm_pickup"] !== ''  ){
        add_filter('parse_query', 'mm_filter_product_mm_pickup_admin');
    }
    
    function mm_filter_product_mm_pickup_admin($query){
        global $pagenow, $typenow;
        if( $pagenow == "edit.php" && $typenow == "product" ){
            $qv = &$query->query_vars;
            if( isset( $_GET["mm_pickup"] ) ){
                if($_GET["mm_pickup"] == 'pickup semi-avail' || $_GET["mm_pickup"] == 'pickup available'){
                    $qv['meta_query'][] = array(
                        'key' => '_mm_pickup',
                        'value' => $_GET["mm_pickup"],
                        'compare' => '==',
                    );
                }else{
                    $qv['meta_query'][] = array(
                        'relation' => 'OR',
                        array(
                            'key' => '_mm_pickup',
                            'value' => '',
                            'compare' => '==',
                        ),
                        array(
                            'key' => '_mm_pickup',
                            'compare' => 'NOT EXISTS',
                        ),
                    );
                    
                }
            }

        }
    }
}

// Disable WordPress' automatic image scaling feature
add_filter( 'big_image_size_threshold', '__return_false' );

/*Fly Cart*/
//add_filter('woofc_cart_menu', 'mm_woofc_cart_menu', 20, 4);
if(!function_exists('mm_woofc_cart_menu')){
    function mm_woofc_cart_menu($cart_menu, $count, $subtotal, $icon) {
        if ( $count<= 0 ) {
            return '';
        }
        $cart_menu = '<li class="' . apply_filters( 'woofc_cart_menu_class', 'menu-item woofc-menu-item menu-item-type-woofc' ) . '"><a href="' . wc_get_checkout_url() . '"><span class="woofc-menu-item-inner" data-count="' . esc_attr( $count ) . '"><i class="' . esc_attr( $icon ) . '"></i> </span></a></li>';

        return $cart_menu;
    }
}

if( ! function_exists( 'av_builder_meta_box_elements_content' ) )
{
	/**
	 * Adjust element content to reflect main option settings
	 * e.g. with sdding page as footer feature we need to adjust select box content of footer settings
	 *
	 * @since 4.2.7
	 * @added_by Günter
	 * @param array $elements
	 * @return array
	 */
	function av_builder_meta_box_elements_content( array $elements )
	{

		$footer_options	= avia_get_option( 'display_widgets_socket', 'all' );

		if( false !== strpos( $footer_options, 'page' ) )
		{
			$desc = __( 'Display the footer page?', 'avia_framework' );
			$subtype = array(
							__( 'Default Layout - set in', 'avia_framework' ) . ' ' . THEMENAME. ' > ' . __( 'Footer', 'avia_framework' )	=> '',
							__( 'Use selected page to display as footer and socket', 'avia_framework' )		=> 'page_in_footer_socket',
							__( 'Use selected page to display as footer (no socket)', 'avia_framework' )	=> 'page_in_footer',
							__( 'Don\'t display the socket & page', 'avia_framework' )						=> 'nofooterarea'
						);
		}
		else
		{
			$desc = __( 'Display the footer widgets?', 'avia_framework' );
			$subtype = array(
							__( 'Default Layout - set in', 'avia_framework' ) . ' ' . THEMENAME . ' > ' . __( 'Footer', 'avia_framework' ) => '',
							__( 'Display the footer widgets & socket', 'avia_framework' )					=> 'all',
							__( 'Display only the footer widgets (no socket)', 'avia_framework' )			=> 'nosocket',
							__( 'Display only the socket (no footer widgets)', 'avia_framework' )			=> 'nofooterwidgets',
                            __( 'Display only the footer landing page', 'avia_framework' )			        => 'landingpage',
							__( 'Don\'t display the socket & footer widgets', 'avia_framework' )			=> 'nofooterarea'
						);
		}

		foreach( $elements as &$element )
		{
			if( 'footer' == $element['id'] )
			{
				$element['desc'] = $desc;
				$element['subtype'] = $subtype;
			}
			if( 'header_transparency' == $element['id'] )
			{
				$element['subtype'] = array(
                    __( 'No transparency', 'avia_framework')				=> '',
                    __( 'Transparent Header', 'avia_framework')				=> 'header_transparent',
                    __( 'Transparent Header with border', 'avia_framework')	=> 'header_transparent header_with_border',
                    __( 'Transparent & Glassy Header', 'avia_framework')	=> 'header_transparent header_glassy ',
                    __( 'Header is invisible and appears once the users scrolls down', 'avia_framework') => 'header_transparent header_scrolldown ',
                    __( 'Hide Header on this page', 'avia_framework' )		=> 'header_transparent header_hidden ',
                    __( 'Header on Vacation Packages page', 'avia_framework' )	=> 'header_vacation_packages',
                );
			}
		}

		return $elements;
	}

	add_filter( 'avf_builder_elements', 'av_builder_meta_box_elements_content', 1999, 1 );
}

// Disable validate on Confirmation page
add_filter( 'woocommerce_order_email_verification_required', '__return_false' );

add_action('woocommerce_checkout_process', 'mm_validate_email_field_checkout_process');
if(!function_exists('mm_validate_email_field_checkout_process')){
    function mm_validate_email_field_checkout_process(){
        if(!empty($_POST['billing_email'])){
            if(!mm_isValidEmail($_POST['billing_email'])){
                wc_add_notice( __( 'Please enter a valid email address!' ), 'error' );
            }
        }
    }
}

add_filter('ninja_forms_submit_data', 'mm_validate_email_field_ninja_forms_submit_data');
if(!function_exists('mm_validate_email_field_ninja_forms_submit_data')){
    function mm_validate_email_field_ninja_forms_submit_data($form_data)
    {
        if(!empty($form_data['fields'])){
            foreach ($form_data['fields'] as $key => $value) {
                $field_id = $key;
                if(strpos(strtolower($value['key']), 'email')!== false && !empty($value['value'])){
                    if(!mm_isValidEmail($value['value'])){
                        $form_data['errors']['fields'][$field_id] = 'Please enter a valid email address!';
                    }
                }
            }
        }
        return $form_data;
    }
}
if(!function_exists('mm_isValidEmail')){
    function mm_isValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        //Get host name from email and check if it is valid
        $email_host = array_slice(explode("@", $email), -1)[0];

        // Check if valid IP (v4 or v6). If it is we can't do a DNS lookup
        if (!filter_var($email_host,FILTER_VALIDATE_IP, [
            'flags' => FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
        ])) {
            $email_host = idn_to_ascii($email_host.'.');

            //Check for MX pointers in DNS (if there are no MX pointers the domain cannot receive emails)
            if (!checkdnsrr($email_host, "MX")) {
                return false;
            }
        }

        return true;
    }
}

add_action( 'init', 'mm_disable_embed_route', 99 );
if(!function_exists('mm_disable_embed_route')){
    function mm_disable_embed_route(){

            // Remove the REST API endpoint.
            //remove_action( 'rest_api_init', 'wp_oembed_register_route' );

            // Remove oEmbed discovery links.
            remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

            // Remove all embeds rewrite rules.
            /*add_filter( 'rewrite_rules_array', function ( $rules ){

                    foreach( $rules as $rule => $rewrite ){
                            if( false !== strpos( $rewrite, 'embed=true' ) ){
                                    unset( $rules[$rule] );
                            }
                    }

                    return $rules;
            } );*/
    }
}
if(!function_exists('mm_remove_post_state')){
    add_filter('display_post_states','mm_remove_post_state',999,2);
    function mm_remove_post_state( $post_states, $post ) {
        if("! has_blocks( $post->ID )") {
            unset($post_states['wp_editor']);
        }
        if("!= Avia_Builder()->get_alb_builder_status($post->ID)") {
            unset($post_states['avia_alb']);
        }
        return $post_states;
    }
}

// if(!function_exists('mm_uap_filter_insert_visit')){
//     add_filter('uap_filter_insert_visit','mm_uap_filter_insert_visit', 10, 5); 
//     function mm_uap_filter_insert_visit( $stop, $affiliate_id, $referral_id, $url, $ip ) {
//         if($affiliate_id){
// 		    $to = 'lam@mauimarketing.com';
// 	        $subject = 'Hawaiitours Debug : v1.0.2';
// 	        $body = print_r($affiliate_id . "|" . $referral_id . "|" . $url,true);
// 	        $headers = array('Content-Type: text/html; charset=UTF-8');
// 	        wp_mail( $to, $subject, $body, $headers );
// 	    }
//         if (str_contains($url, 'utm_campaign=ht_gads') || str_contains($url, 'utm_campaign=HT_GAds')) {
//             $affiliate_id = 0;
//             $referral_id = 0;
//             $stop = true;
//         }
//         return $stop;
//     }
// }

// if(!function_exists('mm_init_affiliate_id_value')){
//     //add_filter('uap_init_affiliate_id_value', 'mm_init_affiliate_id_value', 10, 2);
//     function mm_init_affiliate_id_value($valuenull, $current_url){
//         $to = 'lam@mauimarketing.com';
//         $subject = 'Hawaiitours Debug : v1.0.1';
//         $body = print_r($current_url,true);
//         $headers = array('Content-Type: text/html; charset=UTF-8');
//         wp_mail( $to, $subject, $body, $headers );
//         return $current_url;
//     }
// }


if(!function_exists('mm_pys_send_server_event')){
    add_action('init', 'mm_pys_send_server_event', 10, 1);
    function mm_pys_send_server_event($serverEvents){
        // $items = $data_layer['ecommerce']['items'];
        // $net_income = 0;
        // foreach ($items as $key => $item) {
        //     $mm_resource_commission_rate = get_post_meta($item['id'], 'mm_product_commission_rate', true);
        //     $net_income += ($item['price'] * $mm_resource_commission_rate) / 100;
        // }
        // $data_layer['ecommerce']['net_income'] = $net_income;
        $mm_resource_commission_rate = get_post_meta(3127, 'mm_product_commission_rate', true);
        // echo "<pre>";
        // var_dump($mm_resource_commission_rate );
        // echo "</pre>";


    }
}

if(!function_exists('mm_gtm4wp_purchase_datalayer')){
    add_filter('gtm4wp_purchase_datalayer','mm_gtm4wp_purchase_datalayer', 10, 1); 
    function mm_gtm4wp_purchase_datalayer( $data_layer ) {
        /*
            net_income = revenue - (revenue - commission)
        */
        $items = $data_layer['ecommerce']['items'];
        $net_income = 0;
        foreach ($items as $key => $item) {
            $mm_resource_commission_rate = get_post_meta($item['id'], 'mm_product_commission_rate', true);
            if($mm_resource_commission_rate){
                $net_income += ($item['price'] * $mm_resource_commission_rate) / 100;
            }else{
                $net_income += $item['price'];
            }
        }
        $data_layer['ecommerce']['net_income'] = $net_income;
        return $data_layer;
    }
}

if(!function_exists('mm_gtm4wp_woocommerce_datalayer_on_pageload')){
    add_filter('gtm4wp_woocommerce_datalayer_on_pageload','mm_gtm4wp_woocommerce_datalayer_on_pageload', 10, 1); 
    function mm_gtm4wp_woocommerce_datalayer_on_pageload( $data_layer ) {
        $items = $data_layer['ecommerce']['items'];
        foreach ($items as $key => $item) {
            $item['quantity'] = 1;
        }
        return $data_layer;
    }
}


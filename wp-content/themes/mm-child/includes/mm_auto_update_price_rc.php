<?php
if ( ! function_exists( 'mm_auto_update_price_rc' ) ) {
	function mm_auto_update_price_rc() {
		$output = "";
		global $woocommerce, $product;
		$idproduct_mm = $product->get_id();
		ob_start();
		?>
        <div class="mm-table-price-container">
			<?php
			if ( $idproduct_mm == 32265 || $idproduct_mm == 32899 || $idproduct_mm == 32913 || $idproduct_mm == 32927 || $idproduct_mm == 32947 || $idproduct_mm == 32994 || $idproduct_mm == 33008 || $idproduct_mm == 33032 || $idproduct_mm == 32960 ) {
				$per_type = "per person";
			} elseif ( $idproduct_mm == 27974 ) {
				$per_type = "per boat";
			} elseif ( $idproduct_mm == 1120 || $idproduct_mm == 34517 || $idproduct_mm == 101441 ) {
				$per_type = "per vehicle";
			} elseif ( $idproduct_mm == 28279 ) {
				$per_type = "per group";
			} else {
				$per_type = "per adult";
			}
			$count_resource = 0;
			if ( $product->is_type( 'booking' ) ) {
				if ( $product->has_resources() || $product->is_resource_assignment_type( 'customer' ) ) {
					$resources      = $product->get_resources();
					$resource_label = $product->get_resource_label();
					foreach ( $resources as $resource ) {
						$count_resource ++;
						if ( $resource->get_base_cost() ) {
							$resource_costs = $resource->get_base_cost() + $product->get_display_cost();
						} elseif ( $resource->get_block_cost() ) {
							$resource_costs = $resource->get_block_cost() + $product->get_display_cost();
						} else {
							$resource_costs = $product->get_display_cost();
						}
						if ( $resource->get_base_cost() ) {
							$resource_price = $resource->get_base_cost();
						} elseif ( $resource->get_block_cost() ) {
							$resource_price = $resource->get_block_cost();
						} else {
							$resource_price = 0;
						}
						?>
                        <div class="wrap-resource-item">
                            <p class="title-resource">
								<?php echo $resource->post_title; ?>
                            </p>
							<?php
							if ( $product->has_persons() ) {
								if ( $product->has_person_types() ) {
									?>
                                    <table class="table-detail-resource">
										<?php
										$person_types = $product->get_person_types();
										foreach ( $person_types as $person_type ) {
											$person_title     = $person_type->get_name();
											$person_basecost  = $person_type->get_cost();
											$person_blockcost = $person_type->get_block_cost();
											$person_description = $person_type->get_description();
											if ( isset( $person_basecost ) && $person_basecost != 0 ) {
												$person_costs = $person_basecost;
											} elseif ( isset( $person_blockcost ) && $person_blockcost != 0 ) {
												$person_costs = $person_blockcost;
											} else {
												$person_costs = 0;
											}
											if($idproduct_mm == 11261){
												if($resource->ID == 374267 || $resource->ID == 374075 || $resource->ID == 374076 || $resource->ID == 374077){
													if($person_type->get_id() == 11262 || $person_type->get_id() == 374914 || $person_type->get_id() == 374915){
														continue;
													}
												}else{
													if($person_type->get_id() == 11262 || $person_type->get_id() == 465420){
														continue;
													}
												}
											}
											if($idproduct_mm == 19254){
												if($resource->ID == 477235) {
													if($person_type->get_id() == 19256) {
														continue;
													}
												}
											}
                                                                                        if($idproduct_mm == 19254){
                                                                                            if($resource->ID == 332372) {
                                                                                                if($person_type->get_id() == 585239 || $person_type->get_id() == 585241) {
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            if($resource->ID == 477235) {
                                                                                                if($person_type->get_id() == 19255 || $person_type->get_id() == 19256 || $person_type->get_id() == 477265) {
                                                                                                    continue;
                                                                                                }
                                                                                            }
											}
                                                                                        if($idproduct_mm == 194886){
                                                                                            if($resource->ID == 194924) {
                                                                                                if($person_type->get_id() == 589100 || $person_type->get_id() == 589111 || $person_type->get_id() == 589101 || $person_type->get_id() == 589112) {
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            if($resource->ID == 27443) {
                                                                                                if($person_type->get_id() == 194887 || $person_type->get_id() == 194921 || $person_type->get_id() == 194922) {
                                                                                                    continue;
                                                                                                }
                                                                                            }
											}
                                                                                        if($idproduct_mm == 5946){
                                                                                            if($resource->ID == 374689 || $resource->ID == 374680) {
                                                                                                if($person_type->get_id() == 5947) {
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 374922 || $person_type->get_id() == 374923){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 151954){
                                                                                            if($resource->ID == 635628 || $resource->ID == 635629) {
                                                                                                if($person_type->get_id() == 635643){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 635642){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 80080){
                                                                                            if($resource->ID == 545191) {
                                                                                                if($person_type->get_id() == 638232 || $person_type->get_id() == 638233){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 473875 || $person_type->get_id() == 473876){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 86230){
                                                                                            if($resource->ID == 126477 || $resource->ID == 116549) {
                                                                                                if($person_type->get_id() == 639973 || $person_type->get_id() == 639975 || $person_type->get_id() == 639977){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 279855){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 6576){
                                                                                            if($resource->ID == 116488 || $resource->ID == 116487 || $resource->ID == 116489) {
                                                                                                if($person_type->get_id() == 660639){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() != 660639){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 164539){
                                                                                            if($resource->ID == 164384) {
                                                                                                if($person_type->get_id() != 164540){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 28279){
                                                                                            if($resource->ID == 28301 || $resource->ID == 28302) {
                                                                                                if($person_type->get_id() != 28280){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 28280){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 5480){
                                                                                            if($resource->ID == 130951) {
                                                                                                if($person_type->get_id() != 144920){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 144920){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 218407){
                                                                                            if($resource->ID == 221429) {
                                                                                                if($person_type->get_id() != 218408){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 218408){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 215905){
                                                                                            if($resource->ID == 215918) {
                                                                                                if($person_type->get_id() != 215906){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 215906){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
                                                                                        if($idproduct_mm == 360130){
                                                                                            if($resource->ID == 743604) {
                                                                                                if($person_type->get_id() != 743606){
                                                                                                    continue;
                                                                                                }
                                                                                            }else{
                                                                                                if($person_type->get_id() == 743606){
                                                                                                    continue;
                                                                                                }
                                                                                            }
                                                                                            
											}
											$person_resource_price = $resource_price + $person_costs;
											$mm_custom_price = get_post_meta($idproduct_mm, 'mm_custom_price', true);
											$dataArray = array();
											$custom_price = '';
											if (!empty($mm_custom_price) && !empty(unserialize($mm_custom_price))) {
												$dataArray = unserialize($mm_custom_price);
											}
											if (!empty($dataArray)){
												foreach ($dataArray as $key => $items) {
													if($items['resource'] == $resource->ID && $items['person'] == $person_type->get_id() && $items['price'] != ''){
														$person_resource_price = $items['price'];
													}
												}
											}
											if ( $person_resource_price != 0 ) {
												$person_resource_price = wc_price( round($person_resource_price) );
											} else {
												$person_resource_price = 'FREE';
											}
											?>
                                            <tr>
                                                <td><?php echo $person_title; ?><span style="display: block;"><?php echo $person_description; ?></span></td>
                                                <td><?php echo $person_resource_price; ?></td>
                                            </tr>
											<?php
										}
										?>

                                    </table>
									<?php
								}
							}
							?>
                        </div>
						<?php

					}
				}
			}
			?>
        </div>
		<?php
		$output .= ob_get_clean();
		return $output;
	}

}
add_shortcode('mm_auto_update_price','mm_auto_update_price_rc');

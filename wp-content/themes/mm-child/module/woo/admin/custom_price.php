<?php
if (!function_exists('mm_add_custom_price_tab_action')) {
	function mm_add_custom_price_tab_action( $original_tabs) {

		$new_tab['custom_price_panel'] = array(
			'label'		=> __( 'Custom price', 'woocommerce' ),
			'target'	=> 'custom_price_panel',
			'class'  => array(
					'show_if_booking'
				),
		);
		$insert_at_position = 13; 
		$tabs = array_slice( $original_tabs, 0, $insert_at_position, true ); 
		$tabs = array_merge( $tabs, $new_tab ); 
		$tabs = array_merge( $tabs, array_slice( $original_tabs, $insert_at_position, null, true ) ); 

		return $tabs;

	}
}
add_filter( 'woocommerce_product_data_tabs', 'mm_add_custom_price_tab_action', 90, 1 );


add_action('woocommerce_product_data_panels', 'mm_add_custom_price_tab_panel');
if (!function_exists('mm_add_custom_price_tab_panel')) {

    function mm_add_custom_price_tab_panel() {
        global $post, $bookable_product;
        $post_id = $post->ID;
        ?>
        <div id="custom_price_panel" class="panel woocommerce_options_panel">
            
            <div class="options_group">
                <?php
                $product_resources = $bookable_product->get_resource_ids('edit');
                if ($product_resources) {
                    foreach ($product_resources as $resource_id) {
                        $resource = new WC_Product_Booking_Resource($resource_id);
                    }
                }
				$person_types = $bookable_product->get_person_types( 'edit' );
				
                $mm_custom_price = get_post_meta($post_id, 'mm_custom_price', true);
                $dataArray = array();
                if (!empty($mm_custom_price) && !empty(unserialize($mm_custom_price))) {
                    $dataArray = unserialize($mm_custom_price);
                }
                if (!empty($dataArray)) {
                    $i = 0;
                    foreach ($dataArray as $item) {
                        if (!empty($item['price']) || !empty($item['person'])) {
                            ?>
                            <div class="mm-custom-item" data-item="<?php echo $i; ?>">
                                
                                <div class="mm-custom-field">
                                    <div class="label">Person</div>
									<?php if ( $person_types ) { ?>
										<select id="person" name="mm_custom_price[<?php echo $i; ?>][person]">
											<option value="">Select Person</option>
											<?php 
											foreach ( $person_types as $person_type ) {
												?>
                                                <option value="<?php echo esc_attr( $person_type->get_id() ); ?>" <?php if ($item['person'] == esc_attr( $person_type->get_id() )) echo "selected"; ?>><?php echo esc_attr( $person_type->get_name( 'edit' ) ); ?></option>
                                                <?php
											}?>
											</select>
									<?php } ?>
                                    
                                </div>
                                <div class="mm-custom-field">
                                    <div class="label">Resource</div>
                                    <select id="resource" name="mm_custom_price[<?php echo $i; ?>][resource]">
                                        <option value="">Select Resource</option>
                                        <?php
                                        if ($product_resources) {
                                            foreach ($product_resources as $resource_id) {
                                                $resource = new WC_Product_Booking_Resource($resource_id);
                                                ?>
                                                <option value="<?php echo $resource_id; ?>" <?php if ($item['resource'] == $resource_id) echo "selected"; ?>><?php echo $resource->get_name(); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
								<div class="mm-custom-field">
                                    <div class="label">Price</div>
                                    <input type="text" name="mm_custom_price[<?php echo $i; ?>][price]" value="<?php echo $item['price']; ?>"/>
                                </div>
                                <div class="mm-custom-field mm-custom-field-delete">
                                    <input type="button" value="X" class="inner button remove-custom-price">
                                </div>
                            </div>
                            <?php
                            $check_data = true;
                            $i++;
                        }
                    }
                }
                if (!$check_data) {
                    ?>
                    <div class="mm-custom-item" data-item="0">
                        
                        <div class="mm-custom-field">
                            <div class="label">Person</div>
                            <?php if ( $person_types ) { ?>
								<select id="person" name="mm_custom_price[0][person]">
									<option value="">Select Person</option>
									<?php 
									foreach ( $person_types as $person_type ) {
										?>
										<option value="<?php echo esc_attr( $person_type->get_id() ); ?>" ><?php echo esc_attr( $person_type->get_name( 'edit' ) ); ?></option>
										<?php
									}?>
								</select>
							<?php } ?>
                        </div>
                        <div class="mm-custom-field">
                            <div class="label">Resource</div>
                            <select id="resource" name="mm_custom_price[0][resource]">
                                <option value="">Select Resource</option>
                                <?php
                                if ($product_resources) {
                                    foreach ($product_resources as $resource_id) {
                                        $resource = new WC_Product_Booking_Resource($resource_id);
                                        ?>
                                        <option value="<?php echo $resource_id; ?>"><?php echo $resource->get_name(); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
						<div class="mm-custom-field">
                            <div class="label">Price</div>
                            <input type="text" name="mm_custom_price[0][price]" value=""/>
                        </div>
                        <div class="mm-custom-field mm-custom-field-delete">
							<input type="button" value="X" class="inner button remove-custom-price">
						</div>
                    </div>
                <?php } ?>

            </div>
            <div>
                <input type="button" value="New Fields" class="add-new-custom-price button">
            </div>
        </div>
        <?php
    }

}

add_action('woocommerce_process_product_meta', 'mm_add_custom_price_fields_save');
if (!function_exists('mm_add_custom_price_fields_save')) {

    function mm_add_custom_price_fields_save($post_id) {
        //Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        $mm_custom_price = $_POST['mm_custom_price'];
        if (empty($mm_custom_price) || !is_array($mm_custom_price)) {
            $mm_custom_price = '';
        }
        if (is_array($mm_custom_price) && count($mm_custom_price) <= 1 && empty($mm_custom_price[0]['price']) && empty($mm_custom_price[0]['person'])) {
            $mm_custom_price = '';
        } else
            $mm_custom_price = serialize($mm_custom_price);
        update_post_meta($post_id, 'mm_custom_price', $mm_custom_price);
        
    }

}
if (!function_exists('mm_add_custom_price_admin_enqueue')) {

    function mm_add_custom_price_admin_enqueue() {
        wp_enqueue_style('mm_custom_price_css', get_stylesheet_directory_uri() . '/module/assets/admin/css/custom_price.css', array(), '1.0.5', 'all');
        wp_enqueue_script('mm_custom_price_js', get_stylesheet_directory_uri() . '/module/assets/admin/js/custom_price.js', array('jquery'), '1.0.1', true);
    }

    add_action('admin_enqueue_scripts', 'mm_add_custom_price_admin_enqueue');
}

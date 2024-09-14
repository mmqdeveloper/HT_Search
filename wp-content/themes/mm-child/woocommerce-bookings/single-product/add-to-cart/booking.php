<?php
/**
 * Booking product add to cart
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce;

if (!$product->is_purchasable()) {
    return;
}

do_action('woocommerce_before_add_to_cart_form');

$enable_contact_us_button = get_post_meta($product->get_id(), 'enable_contact_us_button', true);
if ( $enable_contact_us_button == 'yes' ) {
    $addClassEnableCU = "enable-contact-us-button";
} else {
    $addClassEnableCU = "";
}

$rth_cruise_note = "";
if(is_object_in_term($product->get_id(), 'product_tag', 'rth-cruise-note')) {
    $rth_cruise_note = 'rth-cruise-note';
}
?>
<noscript><?php _e('Your browser must support JavaScript in order to make a booking.', 'woocommerce-bookings'); ?></noscript>

<form class="cart" method="post" enctype='multipart/form-data'>

    <div id="wc-bookings-booking-form" class="wc-bookings-booking-form <?php echo $addClassEnableCU; ?>" data-cruise-tag="<?php echo $rth_cruise_note ?>">

        <?php do_action('woocommerce_before_booking_form');
        ?>
        <?php $booking_form->output(); ?>
        <?php
            $terms = get_the_terms ( $product->get_id(), 'product_cat' );
            $vp_tour ='';
            $air_kauai = false;
            $air_maui = false;
            $flights = false;
            $helicopters = false;
            $customer_info = false;
            $customer_info_full = false;
            $customer_info_not_weight = false;
            $customer_info_not_height = false;
            $collapse_open ='mm-collapse-open';
            foreach ( $terms as $term ) {
                if($term->term_id == 9803){
                    $vp_tour ='vacation_packages_tour';
                    $collapse_open = '';
                    break;
                }
            } 
            $product_tag = get_the_terms($product->get_id(), 'product_tag');
            foreach ($product_tag as $tag) {
                if ($tag->name == 'Air Kauai') {
                    $air_kauai = true;
                }
                if ($tag->name == 'Air Maui') {
                    $air_maui = true;
                }
                if ($tag->name == 'Flights') {
                    $flights = true;
                    $helicopters = true;
                }
                if ($tag->name == 'Helicopters'){
                    $helicopters = true;
                }
                if ($tag->name == 'Customer Info'){
                    $customer_info = true;
                }
                if ($tag->name == 'Customer Info Full'){
                    $customer_info_full = true;
                }
                if ($tag->name == 'Customer Info Not Weight'){
                    $customer_info_not_weight = true;
                }
                if ($tag->name == 'Customer Info Not Height'){
                    $customer_info_not_height = true;
                }
            }
            $product_id = $product->get_id();
            $tooltip = '';
            if($helicopters){
                $tooltip = 'Please fill in your Full Name as it appears on your GOVT ID - Passport or License Names';
            }
            if(!empty($tooltip)){
                $tooltip = '<span class="mm-guestinfo-tooltip"><span class="tooltip-content">'.$tooltip.'</span></span>';
            }
            $guest_title = 'Guest Info';
            if(!empty($vp_tour)){ 
                $guest_title = 'Guest Information';
                $tooltip = '<span class="mm-guestinfo-tooltip"><span class="tooltip-content">Please enter the information exactly as it appears on your ID.</span></span>';
            }
        ?>
        <div class="customer-info-field <?php echo $vp_tour; ?>" style="display: none">
            <div class="customer-info-item <?php echo $collapse_open; ?>" data-item="1">
                <h3 class="mm-collapse-title"><span class="item">1</span><span class="item-th">st</span> <?php echo $guest_title; ?> <?php echo $tooltip; ?><span class="mm-collapse-arrow"></span></h3>
                <div class="mm-collapse-content">
                        
                	<?php if($air_kauai || $air_maui){?>
            		<p class="form-row form-row-wid">
                        <label style="display:none">Full Name Guest #<span class="item">1</span></label>
                        <input type="text" class="input-text first_name" name="mmt_first_name[]" placeholder="Full Name" value="" >
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                        <span class="mm-input-tooltip" <?php if($helicopters){ echo 'style="display:none;"';} ?>>
                            <span class="av-icon-char" style="font-size:20px;line-height:20px;" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                            <span class="mm-tooltip-content">As it appears on your <span class="bold-photo-id">Photo ID</span></span>
                        </span>
                        
                    </p>
                	<?php }else{?>
                    <p class="form-row form-row-wid">
                        <label style="display:none">First Name Guest #<span class="item">1</span></label>
                        <input type="text" class="input-text first_name" name="mmt_first_name[]" placeholder="First Name" value="" >
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                        <span class="mm-input-tooltip" <?php if($helicopters || !empty($vp_tour)){ echo 'style="display:none;"';} ?>>
                            <span class="av-icon-char" style="font-size:20px;line-height:20px;" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                            <span class="mm-tooltip-content">As it appears on your <span class="bold-photo-id">Photo ID</span></span>
                        </span>
                        
                    </p>
                    <p class="form-row form-row-wid">
                        <label style="display:none">Last Name Guest #<span class="item">1</span></label>
                        <input type="text" class="input-text last_name" name="mmt_last_name[]" placeholder="Last Name" value="" >
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                    </p>
                	<?php }?>
                    <?php if ((!in_array($product_id, array(3708,35159,41465,3904,3915,190641,190695,19710,3962)) && !$air_kauai && !$air_maui) || $product_id=='189826') { ?>
                    <p class="form-row form-row-wid birthday_guest_checkout">
                        <?php if(!empty($vp_tour)){ ?>
                            <label style="font-weight: inherit;">Date of Birth Guest #<span class="item">1</span> <span class="mm-guestinfo-tooltip"><span class="tooltip-content">Enter the date of birth as it appears on your ID.</span></span></label>
                        <?php }else{?>
                            <label >Date of Birth Guest #<span class="item">1</span></label>
                        <?php }?>
                        <!--<input type="text" class="input-text birthday" name="mmt_birthday[]" autocomplete="off" placeholder="Date of Birth" value="" >-->
                        <select name="mmt_birthday_month[]" class="select birthday_month" data-placeholder="Month">
                            <option value="">Month</option>
                            <?php 
                                for ($i = 1; $i <= 12; $i++) {
                                    ?>
                                    <option value="<?php echo sprintf("%02d", $i);?>"><?php echo sprintf("%02d", $i);?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <select name="mmt_birthday_day[]" class="select birthday_day" data-placeholder="Day">
                            <option value="">Day</option>
                            <?php 
                                for ($i = 1; $i <= 31; $i++) {
                                    ?>
                                    <option value="<?php echo sprintf("%02d", $i);?>"><?php echo sprintf("%02d", $i);?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <select name="mmt_birthday_year[]" class="select birthday_year" data-placeholder="Year">
                            <option value="">Year</option>
                            <?php 
                                $currentYear = date( 'Y', strtotime( 'now' ) );
                                $end_year = $currentYear - 100;
                                for ($i = $currentYear; $i >= $end_year; $i--) {
                                    ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                        <?php if ($product->get_id() == 6307) {?>
                        <span class="mm-weight-note" style="width: 100%;display: inline-block;">Minimum age: 8yrs <br>Maximum age: 70yrs</span>
                        <?php }?>
                        <?php if ($product->get_id() == 24053) {?>
                        <span class="mm-weight-note" style="width: 100%;display: inline-block;">Minimum age: 21yrs</span>
                        <?php }?>
                    </p>
                    <?php if (!in_array($product_id, array(24053,3738,3708,19710,3962)) && !$air_kauai && !$air_maui) {?>
                    <p class="form-row form-row-wid row-select-option">
                        <label style="display:none">Gender Guest #<span class="item">1</span></label>
                        <select name="mmt_gender[]" class="select gender" >
                            <option value="" selected="selected">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                    </p>
                    <?php }?>
                    <?php }?>
                    <?php  if($product->get_id() == 3904){?>
                    <p class="form-row form-row-wid row-select-option">
                        <label style="display:none">Meal Option Guest #<span class="item">1</span></label>
                        <select name="mmt_meal[]" class="select meal" >
                            <option value="" selected="selected">Meal Option</option>
                            <option value="Coconut and Yoghurt Stoneground Muesli and seasonal fresh fruit">Coconut and Yoghurt Stoneground Muesli and seasonal fresh fruit</option>
                            <option value="Plantation Breakfast">Plantation Breakfast</option>
                            <option value="Macadamia Nut Pancakes">Macadamia Nut Pancakes</option>
                        </select>
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                    </p>
                    <?php }?>
                    <?php  if($product->get_id() == 5946){?>
                    <p class="form-row form-row-wid row-select-option">
                        <label style="display:none">Meal Option Guest #<span class="item">1</span></label>
                        <select name="mmt_meal[]" class="select meal" >
                            <option value="" selected="selected">Sandwich Order</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Ham">Ham</option>
                            <option value="Peanut Butter & Jelly">Peanut Butter & Jelly</option>
                            <option value="Veggie Burger">Veggie Burger</option>
                            <option value="Gluten Free Turkey">Gluten Free Turkey</option>
                            <option value="Gluten Free Ham">Gluten Free Ham</option>
                            <option value="Gluten Free Veggie Burger">Gluten Free Veggie Burger</option>
                        </select>
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                    </p>
                    <?php }?>
                    <?php  if($product->get_id() == 3915){?>
                    <p class="form-row form-row-wid row-select-option">
                        <label style="display:none">Meal Option Guest #<span class="item">1</span></label>
                        <select name="mmt_meal[]" class="select meal" >
                            <option value="" selected="selected">Meal Option</option>
                            <option value="Huli Huli Chicken (GF/DF)">Huli Huli Chicken (GF/DF)</option>
                            <option value="Vegan Thai Coconut Veggie Tofu Curry">Vegan Thai Coconut Veggie Tofu Curry</option>
                        </select>
                        <label generated="true" class="error hidden" style="">This field is required.</label>
                    </p>
                    <?php }?>
                    <?php
                    //if (mm_check_is_horseback($product->get_id()) == false && ($product->get_id() != 5090 && $product->get_id() != 190641 && $product->get_id() != 190695 && $product->get_id() != 6008 && $product->get_id() != 24053 && (mm_check_is_avt_tour($product->get_id()) ||mm_check_is_helicopter_fly($product->get_id()) || mm_check_is_biking_tour($product->get_id()) || $product->get_id() == 6285 || mm_check_is_zipline_tour($product->get_id()) || $flights || $customer_info_full || $customer_info_not_height || $customer_info_not_weight))) {
                    if (mm_check_is_horseback($product->get_id()) == false && ($product->get_id() != 5090 && $product->get_id() != 190641 && $product->get_id() != 190695 && $product->get_id() != 6008 && $product->get_id() != 24053 && ( $customer_info_full || $customer_info_not_height || $customer_info_not_weight))) {
                        ?>
                    <?php if(!$customer_info_not_weight){ ?>
                    <p class="form-row form-row-wid">
                            <label style="display:none">Weight Guest #<span class="item">1</span> </label>
                            <input type="number" step="any" class="input-text mmt_weight" name="mmt_weight[]" placeholder="Weight" value=""  >
                            <span class="mm-unit">lbs</span>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                    <?php }?>
                        <?php if (!$customer_info_not_height && !in_array($product_id, array(3738,3708,19710,3962)) && !$air_kauai && !$air_maui) {?>
                        <p class="form-row form-row-wid heigth-options">
                            <label style="display:none">Height Guest #<span class="item">1</span> </label>
                            <input type="text" class="input-text mmt_height" name="mmt_height[]" placeholder="Height" value="" >
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                    <?php }?>
                    <?php } ?>
                    <?php
                    if ($product->get_id() == 6307) {
                        ?>
                        <p class="form-row form-row-wid">
                            <label style="display:none">Weight Guest #<span class="item">1</span> </label>
                            <input type="number" step="any" class="input-text mmt_weight" name="mmt_weight[]" placeholder="Weight" value=""  >
                            <span class="mm-unit">lbs</span>
                            <span class="mm-weight-note">Weight limit 200 pounds</span>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                    <?php } ?>

                    <?php
                    if ($product->get_id() == 360669) {
                        ?>
                        <p class="form-row form-row-wid">
                            <label style="display:none">Weight Guest #<span class="item">1</span> </label>
                            <input type="number" step="any" class="input-text mmt_weight mm-vailidate-weight-customer-info" name="mmt_weight[]" placeholder="Weight" value="" max="300" >
                            <span class="mm-unit">lbs</span>
                            <span class="mm-weight-note">Weight limit for participants is 300 lbs.</span>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                    <?php } ?>
                    
                    <?php
                    if (mm_check_is_horseback($product->get_id())) {
                        ?>
                        <?php if(!$customer_info_not_weight){ ?>
                        <p class="form-row form-row-wid">
                            <label style="display:none">Weight Guest #<span class="item">1</span> </label>
                            <input type="number" step="any" class="input-text mmt_weight" name="mmt_weight[]" placeholder="Weight" value=""  >
                            <span class="mm-unit">lbs</span>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                        <?php }?>
                        <?php if(!$customer_info_not_height){ ?>
                        <p class="form-row form-row-wid">
                            <label style="display:none">Height Guest #<span class="item">1</span> </label>
                            <input type="text" class="input-text mmt_height" name="mmt_height[]" placeholder="Height" value="" >
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                        <?php }?>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Riding Experience Level Guest #<span class="item">1</span></label>
                            <select name="mmt_riding_level[]" class="select " >
                                <option value="" selected="selected">Riding Experience Level</option>
                                <option value="First timer">First Timer</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </p>
                    <?php } ?>
                    <?php  if($product->get_id() == 204526){?>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Meal Option Guest #<span class="item">1</span></label>
                            <select name="mmt_meal[]" class="select meal" >
                                <option value="" selected="selected">Meal Option</option>
                                <option value="Hand Line 'Ahi">Hand Line 'Ahi</option>
                                <option value="Ko'ala Half Chicken">Ko'ala Half Chicken</option>
                                <option value="Chef's Laulau">Chef's Laulau</option>
                                <option value="Pasta in Peanut Sauce">Pasta in Peanut Sauce</option>
                            </select>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Picnic Lunch Option Guest #<span class="item">1</span></label>
                            <select name="mmt_meal[]" class="select meal" >
                                <option value="" selected="selected">Picnic Lunch Option</option>
                                <option value="Falafel Sandwich">Falafel Sandwich</option>
                                <option value="Chicken Shawarma Sandwich">Chicken Shawarma Sandwich</option>
                            </select>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                    <?php }?>
                    <?php
                    if ($product->get_id() == 194724 || $product->get_id() == 204526 ) {
                        ?>
                        <p class="form-row form-row-wid">
                            <label style="display:none">Additional Notes or Requests Guest #<span class="item">1</span> </label>
                            <textarea class="input-text mmt_notes" name="mmt_notes[]" placeholder="Additional Notes or Requests" style="max-height: 120px;"></textarea>
                            <span class="mm-input-tooltip">
                                <span class="av-icon-char" style="font-size:20px;line-height:20px;" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                                <span class="mm-tooltip-content" style="width: 150px;">Food Allergies</span>
                            </span>
                        </p>
                    <?php } ?>
                    <?php
                    if ($product->get_id() == 190641 || $product->get_id() == 190695) {
                        ?>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Height Guest #<span class="item">1</span></label>
                            <select name="mmt_height[]" class="select " >
                                <option value="" selected="selected">Height</option>
                                <option value="Under 4'">Under 4'</option>
                                <option value="4' 1&quot;">4' 1"</option>
                                <option value="4' 2&quot;">4' 2"</option>
                                <option value="4' 3&quot;">4' 3"</option>
                                <option value="4' 4&quot;">4' 4"</option>
                                <option value="4' 5&quot;">4' 5"</option>
                                <option value="4' 6&quot;">4' 6"</option>
                                <option value="4' 7&quot;">4' 7"</option>
                                <option value="4' 8&quot;">4' 8"</option>
                                <option value="4' 9&quot;">4' 9"</option>
                                <option value="4' 10&quot;">4' 10"</option>
                                <option value="4' 11&quot;">4' 11"</option>
                                <option value="5'">5'</option>
                                <option value="5' 1&quot;">5' 1"</option>
                                <option value="5' 2&quot;">5' 2"</option>
                                <option value="5' 3&quot;">5' 3"</option>
                                <option value="5' 4&quot;">5' 4"</option>
                                <option value="5' 5&quot;">5' 5"</option>
                                <option value="5' 6&quot;">5' 6"</option>
                                <option value="5' 7&quot;">5' 7"</option>
                                <option value="5' 8&quot;">5' 8"</option>
                                <option value="5' 9&quot;">5' 9"</option>
                                <option value="5' 10&quot;">5' 10"</option>
                                <option value="5' 11&quot;">5' 11"</option>
                                <option value="6'">6'</option>
                                <option value="6' 1&quot;">6' 1"</option>
                                <option value="6' 2&quot;">6' 2"</option>
                                <option value="6' 3&quot;">6' 3"</option>
                                <option value="6' 4&quot;">6' 4"</option>
                                <option value="6' 5&quot;">6' 5"</option>
                                <option value="6' 6&quot;">6' 6"</option>
                                <option value="6' 7&quot;">6' 7"</option>
                                <option value="6' 8&quot;">6' 8"</option>
                                <option value="6' 9&quot;">6' 9"</option>
                                <option value="6' 10&quot;">6' 10"</option>
                                <option value="6' 11&quot;">6' 11"</option>
                                <option value="7'">7'</option>
                                <option value="Over 7'">Over 7'</option>
                            </select>
                        </p>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Experience on a bike Guest #<span class="item">1</span></label>
                            <select name="mmt_experience_bike[]" class="select required-field" >
                                <option value="" selected="selected">Experience on a bike</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                                <option value="Expert">Expert</option>
                            </select>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Helmet Size Guest #<span class="item">1</span></label>
                            <select name="mmt_helmet_size[]" class="select " >
                                <option value="" selected="selected">Helmet Size</option>
                                <option value="Small 48-53 cm diameter">Small 48-53 cm diameter</option>
                                <option value="Medium  50-54 cm diameter">Medium  50-54 cm diameter</option>
                                <option value="Large  55-63 cm diameter">Large  55-63 cm diameter</option>
                            </select>
                        </p>
                    <?php } ?>
                    <?php
                    if ($product->get_id() == 190695) {
                        ?>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Vegetarian option Guest #<span class="item">1</span></label>
                            <select name="mmt_helmet_size[]" class="select " >
                                <option value="" selected="selected">Do you need a vegetarian option?</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </p>
                    <?php } ?> 
                    <?php  if($product->get_id() == 6008){?>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Sandwich Order Guest #<span class="item">1</span></label>
                            <select name="mmt_meal[]" class="select meal" >
                                <option value="" selected="selected">Sandwich Order</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Ham">Ham</option>
                                <option value="Peanut Butter & Jelly">Peanut Butter & Jelly</option>
                                <option value="Veggie Burger">Veggie Burger</option>
                                <option value="Gluten Free Turkey">Gluten Free Turkey</option>
                                <option value="Gluten Free Ham">Gluten Free Ham</option>
                                <option value="Gluten Free Veggie Burger">Gluten Free Veggie Burger</option>
                            </select>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                        <p class="form-row form-row-wid row-select-option">
                            <label style="display:none">Jacket Size Guest #<span class="item">1</span></label>
                            <select name="mmt_meal[]" class="select meal" >
                                <option value="" selected="selected">Jacket Size</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </select>
                            <label generated="true" class="error hidden" style="">This field is required.</label>
                        </p>
                    <?php }?>    
                </div>
            </div>
        </div>
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>
        <div class="clearfix"></div>
        <?php
        $coupon_code = $woocommerce->session->get('deferred_url_coupons');
        $coupon_appli = $woocommerce->session->get('applied_coupons');
        if(!empty($coupon_appli)){
            $coupon_code =$coupon_appli;
        }
        $discount_apply ='';
        if (!empty($coupon_code)) {
            foreach ($coupon_code as $id => $code) {
                $coupon = new \WC_Coupon($code['code']);
                if(!empty($coupon_appli)){
                    $coupon = new \WC_Coupon($code);
                }
                $get_code = $coupon->get_code('');
                $get_amount = $coupon->get_amount('');
                $get_discount_type = $coupon->get_discount_type('');
                $product_apply = $coupon->is_valid_for_product($product);
                $get_individual_use = $coupon->get_individual_use('');
                $you_save = '';
                switch ($get_discount_type) {
                    case 'percent':
                        $you_save = $get_amount . '%';
                        break;
                    case 'booking_person':
                        $you_save = get_woocommerce_currency_symbol() . $get_amount . ' Per Person';
                        break;
                    default:
                        $you_save = get_woocommerce_currency_symbol() . $get_amount;
                        break;
                }
                if($get_individual_use==1&&$product_apply==1){
                    $discount_apply='';
                }
                if ($product_apply==1) {
                    //$discount_apply.='<div class="mm_discount_apply">Code applied: <span class="coupon_name">'.$get_code.'</span>. You save '.$you_save.' on checkout.</div>';
                    $discount_apply.='<div class="mm_discount_apply">"<span class="coupon_name">'.$get_code.'</span>" Coupon Applied. Click Book Now To See Your Savings</div>';
                }
            }
        }
        
        echo $discount_apply;
        ?>
        <div style="display: none" class="mm-notice-booking-box">
            <img src="https://www.hawaiitours.com/wp-content/uploads/2023/11/alert-circle-2.svg" alt="notice-icon">
            <p>Sales are final for tours starting within the next 72 hours.
                Please double-check your info before checking out.</p>
        </div>
        <div class="wc-bookings-booking-cost" style="display:block"><span class="text-abs">Your online price:</span> <strong class="booking-costs-new"><span class="woocommerce-Price-amount amount "> <span class="woocommerce-Price-currencySymbol"><?php global  $woocommerce;   echo get_woocommerce_currency_symbol(); ?></span>0</span> USD</strong></div>

    </div>   
      
    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr(is_callable(array($product, 'get_id')) ? $product->get_id() : $product->id ); ?>" class="wc-booking-product-id" />
    <div class="book-now-widget">
        <?php
        $seasonal_option = $product->get_seasonal();
        if(!empty($seasonal_option)) echo '<input type="hidden" name="seasonal_option" class="seasonal_option" data-seasonal="'.esc_attr( json_encode( $seasonal_option ) ).'">';
        ?>
        <?php 
        $enable_contact_us_button = get_post_meta($product->get_id(), 'enable_contact_us_button', true);
        if($enable_contact_us_button == 'yes'){
        ?>
        <div class="product-button-call"><a target="_blank" href="/contact-us/" class="mmt-button">Contact Us</a> <span class="mmt-phone-text">OR</span> <a class="mmt-button click-for-waitlist no-scroll" href="#click-for-waitlist">Join Wait List</a></div>
        <?php } else{?>
        <button type="submit" class="wc-bookings-booking-form-button single_add_to_cart_button button alt disabled" disabled>BOOK NOW</button>
        <?php }?>
    </div>
    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    <div class="mmt-button-waitlist" style="display: none">
        <a href="#click-for-waitlist" class="click-for-waitlist mmt-button no-scroll">JOIN WAIT LIST</a>
    </div>
    <div id="click-for-waitlist" class="mfp-hide">
        <?php echo do_shortcode( '[ninja_form id=14]' ); ?>
    </div>
    <div class="current-time-book" style="display: none !important;"><?php echo  date( 'Y-m-d H:i', current_time( 'timestamp' ) ); ?></div>
</form>
<?php 
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
$check_farehabor_api = get_post_meta($product->get_id(),"mm_enable_fareharbor_api", true);
$disable_booking_fareharbor = get_post_meta($product->get_id(), 'mm_disable_fareharbor_reservation', true);
if($check_farehabor_api == 'yes' && $disable_booking_fareharbor != 'yes'){
    $fhapi_booking = true;
}
$mm_enable_ponorez_api = get_post_meta($product->get_id(),"mm_enable_ponorez_api", true);
$mm_disable_ponorez_reservation = get_post_meta($product->get_id(), 'mm_disable_ponorez_reservation', true);
if($mm_enable_ponorez_api == 'yes' && $mm_disable_ponorez_reservation != 'yes'){
    $ponorez_API_booking = true;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var formSubmit = $('#booking-box .cart');
        setTimeout(function(){
            $(document).on('change', '#booking-box .cart .customer-info-field .input-text', function() {
                var first_name    = $.trim($(this).val());
                if ( first_name == '' ) {
                    $(this).closest('.form-row').find('.error').removeClass('hidden');
                    $(this).addClass('has-error');
                } else {
                    $(this).closest('.form-row').find('.error').addClass('hidden');
                    $(this).removeClass('has-error');
                }
                if($(this).closest('.form-row').hasClass('error-min-weight') && first_name != ''){
                    $(this).closest('.form-row').removeClass('error-min-weight');
                }
            });
            $(document).on('change', '#booking-box .cart .customer-info-field select', function() {
                var mmt_gender    = $.trim($(this).val());
                if ( mmt_gender == '' ) {
                    $(this).next('.error').removeClass('hidden');
                    $(this).addClass('has-error');

                } else {
                    $(this).next('.error').addClass('hidden');
                    $(this).removeClass('has-error');
                }
            });
        }, 500);

        if (formSubmit.length) {
            setTimeout(function(){
                $("#booking-box .cart .wc-bookings-booking-form-button").on('click', function(e) {
                    e.preventDefault();
                    var tour_id = $('.wc-booking-product-id').val();
                    var resource_id = $('#wc_bookings_field_resource').val();
                    if(tour_id==3685 && resource_id == 3992){
                        $(this).attr('disabled', true);
                        $(this).addClass('add-to-cart-load');
                        $('<span class="loader"></span>').appendTo(this);
                        $('#booking-box .cart')[0].submit();
                    }
                    $('.customer-info-field:not(.vacation_packages_tour) .customer-info-item').each(function () {
                        var tour_id = $('.wc-booking-product-id').val();
                        var resource_id = $('#wc_bookings_field_resource').val();
                        var info_item = $(this).data('item');
                        if($(this).closest('.customer-info-field').hasClass('mm-hide-field-with-logic')){
                            return false;
                        }
                        if(info_item == 2 && tour_id == 194724 && resource_id ==201022){
                            return false;
                        }
                        if(tour_id == 3920 && resource_id ==117742){
                            return false;
                        }
                        if(tour_id == 5946 && resource_id ==117611){
                            return false;
                        }
                        if(tour_id == 522148 && resource_id ==522209){
                            return false;
                        }
                        if(tour_id == 216760 && resource_id ==222479){
                            return false;
                        }
                        if(tour_id == 190141 && (resource_id ==194152 || resource_id ==194150 || resource_id ==194151 || resource_id ==194149 || resource_id ==190417)){
                            return false;
                        }
                        var first_name    = $.trim($(this).find('.input-text.first_name').val());
                        var last_name    = $.trim($(this).find('.input-text.last_name').val());
                        var birthday    = $.trim($(this).find('.input-text.birthday').val());
                        var mmt_gender    = $.trim($(this).find('select.gender').val());

                        if ( first_name == '' ) {
                            $(this).addClass('mm-collapse-open');
                            $(this).find('.input-text.first_name').next('.error').removeClass('hidden');
                            $(this).find('.input-text.first_name').addClass('has-error');
                        } else {
                            $(this).find('.input-text.first_name').next('.error').addClass('hidden');
                            $(this).find('.input-text.first_name').removeClass('has-error');
                        }
                        if($('.customer-info-field .input-text.last_name').length){
	                        if ( last_name == '' ) {
	                            $(this).find('.input-text.last_name').next('.error').removeClass('hidden');
	                            $(this).find('.input-text.last_name').addClass('has-error');

	                        } else {
	                            $(this).find('.input-text.last_name').next('.error').addClass('hidden');
	                            $(this).find('.input-text.last_name').removeClass('has-error');
	                        }
	                    }
                        if($('.customer-info-field .input-text.birthday').length){
                            if ( birthday == '' ) {
                                $(this).find('.input-text.birthday').next('.error').removeClass('hidden');
                                $(this).find('.input-text.birthday').addClass('has-error');

                            } else {
                                $(this).find('.input-text.birthday').next('.error').addClass('hidden');
                                $(this).find('.input-text.birthday').removeClass('has-error');
                            }
                        }
                        if($('.customer-info-field select.birthday_month').length){
                            var m    = $.trim($(this).find('select.birthday_month').val());
                            if ( m == '' ) {
                                $(this).find('select.birthday_month').next('.error').removeClass('hidden');
                                $(this).find('select.birthday_month').addClass('has-error');

                            } else {
                                $(this).find('select.birthday_month').next('.error').addClass('hidden');
                                $(this).find('select.birthday_month').removeClass('has-error');
                            }
                        }
                        if($('.customer-info-field select.birthday_day').length){
                            var d    = $.trim($(this).find('select.birthday_day').val());
                            if ( d == '' ) {
                                $(this).find('select.birthday_day').next('.error').removeClass('hidden');
                                $(this).find('select.birthday_day').addClass('has-error');

                            } else {
                                $(this).find('select.birthday_day').next('.error').addClass('hidden');
                                $(this).find('select.birthday_day').removeClass('has-error');
                            }
                        }
                        if($('.customer-info-field select.birthday_year').length){
                            var y    = $.trim($(this).find('select.birthday_year').val());
                            if ( y == '' ) {
                                $(this).find('select.birthday_year').next('.error').removeClass('hidden');
                                $(this).find('select.birthday_year').addClass('has-error');

                            } else {
                                $(this).find('select.birthday_year').next('.error').addClass('hidden');
                                $(this).find('select.birthday_year').removeClass('has-error');
                            }
                        }
                        if($('.customer-info-field select.gender').length){
                            if ( mmt_gender == '' ) {
                                $(this).find('select.gender').next('.error').removeClass('hidden');
                                $(this).find('select.gender').addClass('has-error');

                            } else {
                                $(this).find('select.gender').next('.error').addClass('hidden');
                                $(this).find('select.gender').removeClass('has-error');
                            }
                        }
                        if($('.customer-info-field .input-text.mmt_weight').length){
                            var mmt_weight    = $.trim($(this).find('.input-text.mmt_weight').val());
                            if ( mmt_weight == '') {
                                $(this).find('.input-text.mmt_weight').closest('.form-row').find('.error').removeClass('hidden');
                                $(this).find('.input-text.mmt_weight').closest('.form-row').find('.error').text('This field is required.');
                                $(this).find('.input-text.mmt_weight').closest('.form-row').removeClass('error-min-weight');
                                $(this).find('.input-text.mmt_weight').addClass('has-error');

                            }else if(mmt_weight <= 0) {
                                $(this).find('.input-text.mmt_weight').closest('.form-row').find('.error').removeClass('hidden');
                                $(this).find('.input-text.mmt_weight').closest('.form-row').addClass('error-min-weight');
                                $(this).find('.input-text.mmt_weight').closest('.form-row').find('.error').text('This field should not be able to input the negative number, it should just allow from 0 to positive number');
                                $(this).find('.input-text.mmt_weight').addClass('has-error');

                            } else {
                                $(this).find('.input-text.mmt_weight').closest('.form-row').find('.error').addClass('hidden');
                                $(this).find('.input-text.mmt_weight').removeClass('has-error');
                                $(this).find('.input-text.mmt_weight').closest('.form-row').removeClass('error-min-weight');
                            }
                        }
                        if($('.customer-info-field .input-text.mmt_height').length){
                            var mmt_height    = $.trim($(this).find('.input-text.mmt_height').val());
                            if ( mmt_height == '' ) {
                                $(this).find('.input-text.mmt_height').next('.error').removeClass('hidden');
                                $(this).find('.input-text.mmt_height').addClass('has-error');

                            } else {
                                $(this).find('.input-text.mmt_height').next('.error').addClass('hidden');
                                $(this).find('.input-text.mmt_height').removeClass('has-error');
                            }
                        }
                        if($('.customer-info-field select.meal').length){
                            var mmt_meal    = $.trim($(this).find('select.meal').val());
                            if ( mmt_meal == '' ) {
                                $(this).find('select.meal').next('.error').removeClass('hidden');
                                $(this).find('select.meal').addClass('has-error');

                            } else {
                                $(this).find('select.meal').next('.error').addClass('hidden');
                                $(this).find('select.meal').removeClass('has-error');
                            }
                        }
                        if($('.customer-info-field .required-field').length){
                            $('.customer-info-field .required-field').each(function () {
                                var mmt_required_field    = $.trim($(this).val());
                                if ( mmt_required_field == '' ) {
                                    $(this).next('.error').removeClass('hidden');
                                    $(this).addClass('has-error');

                                } else {
                                    $(this).next('.error').addClass('hidden');
                                    $(this).removeClass('has-error');
                                }
                            });
                            
                        }
                        if($('.single.postid-6307').length){
                            var weight = $.trim($(this).find('.input-text.mmt_weight').val());
                            if ( weight == '' || weight > 200) {
                                $(this).find('.input-text.mmt_weight').next('.error').removeClass('hidden');
                                $(this).find('.input-text.mmt_weight').addClass('has-error');
                            } else {
                                $(this).find('.input-text.mmt_weight').next('.error').addClass('hidden');
                                $(this).find('.input-text.mmt_weight').removeClass('has-error');
                            }
                            if(birthday!=''){
                                var now = new Date();
                                var past = new Date(birthday);
                                var nowYear = now.getFullYear();
                                var pastYear = past.getFullYear();
                                var age = nowYear - pastYear;
                                if(age < 8 || age > 70){
                                    $(this).find('.input-text.birthday').next('.error').removeClass('hidden');
                                    $(this).find('.input-text.birthday').addClass('has-error');
                                }
                            }
                            
                        }

                    });
                    var has_class_input = $('.customer-info-field .customer-info-item').find('.input-text').hasClass('has-error');
                    var has_class_gender = $('.customer-info-field .customer-info-item').find('select').hasClass('has-error');
                    if(tour_id == 5946 && resource_id ==117611){
                        has_class_input = false;
                    }
                    if(tour_id == 190141 && (resource_id ==194152 || resource_id ==194150 || resource_id ==194151 || resource_id ==194149 || resource_id ==190417)){
                        has_class_input = false;
                    }
                    if(tour_id == 216760 && resource_id ==222479){
                        has_class_input = false;
                        has_class_gender = false;
                    }
                    if(tour_id == 3920 && resource_id ==117742){
                        has_class_input = false;
                        has_class_gender = false;
                    }
                    if($('.customer-info-field').hasClass('mm-hide-field-with-logic')){
                        has_class_input = false;
                        has_class_gender = false;
                    }
                    if ( ! has_class_input && ! has_class_gender ) {
                        $(this).attr('disabled', true);
                        $(this).addClass('add-to-cart-load');
                        $('<span class="loader"></span>').appendTo(this);
                        $('#booking-box .cart')[0].submit();
                    }

                });
            }, 500);
        }

        //18 - 36h show contact and phone.
        function getActualFullDate() {
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth()+1;
            var year = d.getFullYear();
            var h = d.getHours();
            var m = d.getMinutes();
            var s = d.getSeconds();
            return  year + "-" + month + "-" + day + " " + h + ":" + m;
        }

        <?php if(!$shop_manager && !$fhapi_booking && !$ponorez_API_booking){?>
        setTimeout(function(){
            $("#wc-bookings-booking-form .form-field.form-field-wide.form_field-time, #wc-bookings-booking-form .wc-bookings-date-picker-date-fields").change(function () {
                var pickupTime = $("#wc-bookings-booking-form #wc_bookings_field_start_date").val();
                var mm_day   = $("#wc-bookings-booking-form .wc-bookings-date-picker-date-fields .booking_date_day").val();
                var mm_month = $("#wc-bookings-booking-form .wc-bookings-date-picker-date-fields .booking_date_month").val();
                var mm_year  = $("#wc-bookings-booking-form .wc-bookings-date-picker-date-fields .booking_date_year").val();
                if ( pickupTime != '' && $("#wc-bookings-booking-form #wc_bookings_field_start_date").length && !$(".enable-contact-us-button").length ) {

                    var mm_date_select = new Date(mm_year + "-" + mm_month + "-" + mm_day + " " + pickupTime);
                    // var current_date = new Date(getActualFullDate());
                    var current_date = new Date($('#wc-bookings-booking-form .current-time-book').text());
                    // console.log(current_date);
                    var result_time = mm_date_select - current_date;
                    //console.log(result_time);
                    var total_date = result_time/1000/60/60;
                    // console.log(total_date);
                    /*if ( total_date <= 36 && total_date >= 18 ) {
                        $('#wc-bookings-booking-form .wc-bookings-booking-form-button').addClass('hide-book');
                        $('#wc-bookings-booking-form .product-button-call').remove();
                        $('#wc-bookings-booking-form .wc-bookings-booking-form-button').after('<div class="product-button-call"><a href="/contact-us/" class="mmt-button">Contact Us</a> <span class="mmt-phone-text">OR</span> <a class="mmt-button click-for-waitlist" href="#click-for-waitlist">Join Wait List</a></div>');
                        $('#wc-bookings-booking-form').removeClass('hide-contact-phone');
                    } else if ( total_date < 18 ) {
                        $('#wc-bookings-booking-form .wc-bookings-booking-form-button').addClass('disabled');
                        $('#wc-bookings-booking-form .wc-bookings-booking-form-button').hide();
                        $('#wc-bookings-booking-form .product-button-call').remove();
                        $('#wc-bookings-booking-form').addClass('hide-contact-phone');

                    } else {
                        $('#wc-bookings-booking-form .wc-bookings-booking-form-button').removeClass('disabled');
                        $('#wc-bookings-booking-form .wc-bookings-booking-form-button').show();
                        $('#wc-bookings-booking-form .product-button-call').remove();
                        $('#wc-bookings-booking-form .wc-bookings-booking-form-button').removeClass('hide-book');
                        $('#wc-bookings-booking-form').removeClass('hide-contact-phone');
                    }*/
                }
            });
        },500);
        //End 18 - 36h show contact and phone.
        <?php } ?>
    });
</script>
<style>
    .hide-book {display: none !important;} #wc-bookings-booking-form.hide-contact-phone .mmt-button-call{display: none;}
    /*#nf-field-246-wrap,#nf-field-247-wrap,#nf-field-248-wrap,#nf-field-249-wrap{display: none;}*/
</style>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>

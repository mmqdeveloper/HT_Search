<?php
wp_enqueue_script('wc-bookings-date-picker');
wp_enqueue_script('wc-bookings-time-picker');
extract($field);

$month_before_day = strpos(__('F j, Y'), 'F') < strpos(__('F j, Y'), 'j');
global $product;
// Product Checking
$booking_id = get_the_ID();

$cruise_date = $_GET['cruise-date'];
$cruise_date_day = $cruise_date_month = $cruise_date_year = "";
if(!empty($cruise_date)) {
    $cruise_date = str_replace("-", '', $cruise_date);
    $cruise_date_day = substr($cruise_date, 2,2);
    $cruise_date_month = substr($cruise_date, 0,2);
    $cruise_date_year = substr($cruise_date, 4);
}

//booking your save
$WC_Product = wc_get_product($booking_id);
$costs = $WC_Product->get_costs();
$comma = ',';
if (isset($costs)) {
    foreach ($costs as $rule_key => $rule) {
	    if(!empty($rule[1]) && is_array($rule[1])){
		    $rules = $rule[1];
		    $year_booking = array_keys($rules);
        }
        foreach ($year_booking as $key_year => $value_year) {
	        if(!empty($rules[$value_year]) && is_array($rules[$value_year])){
		        $month_booking = array_keys($rules[$value_year]);
            }
            foreach ($month_booking as $key_month => $value_month) {
	            if(!empty($rules[$value_year][$value_month]) && is_array($rules[$value_year][$value_month])){
		            $day_booking = array_keys($rules[$value_year][$value_month]);
                }
                $value_month = (int)$value_month - 1;
                if (is_array($day_booking) || is_object($day_booking)){
                    foreach ($day_booking as $key_date => $value_date) {
                        $notes = ($rules[$value_year][$value_month + 1][$value_date]['notes']) ? $rules[$value_year][$value_month + 1][$value_date]['notes'] : '';
                        if (empty($rules[$value_year][$value_month + 1][$value_date]['notes'])) {
                            $color_notes = 'transparent';
                        } else {
                            $color_notes = ($rules[$value_year][$value_month + 1][$value_date]['color_notes']) ? $rules[$value_year][$value_month + 1][$value_date]['color_notes'] : '#243078';
                        }
                        $bg_color_date .= '#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-' . $value_date . '[data-month="' . $value_month . '"][data-year="' . $value_year . '"] a' . $comma;
                        $after_date .= '#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-' . $value_date . '[data-month="' . $value_month . '"][data-year="' . $value_year . '"] a:after' . $comma;
                        $before_date .= '#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-' . $value_date . '[data-month="' . $value_month . '"][data-year="' . $value_year . '"] a:before' . $comma;
                        $date_hover_after .= '#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-' . $value_date . '[data-month="' . $value_month . '"][data-year="' . $value_year . '"]:hover > a:after' . $comma;
                        $date_hover_before .= '#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-' . $value_date . '[data-month="' . $value_month . '"][data-year="' . $value_year . '"]:hover > a:before' . $comma;
                        $after_date_content .= '#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-' . $value_date . '[data-month="' . $value_month . '"][data-year="' . $value_year . '"] a:after{content:"' . $notes . '";background:' . $color_notes . ' !important;}';
                        $before_date_color .= '#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-' . $value_date . '[data-month="' . $value_month . '"][data-year="' . $value_year . '"] a:before{border-top:10px solid ' . $color_notes . ' !important;}';
                    }
                }
            }
        }
    }
    $flash_sale = false;
    $get_pricings = $WC_Product->get_pricing();
    $add_pricing = array();
    $flash_sale_style = '';
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
                    $f_month = date('n', strtotime($date_tmp)) - 1;
                    $f_year = date('Y', strtotime($date_tmp));
                    $flash_sale_style.='#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-'.$f_day.'[data-month="'.$f_month.'"][data-year="'.$f_year.'"] a{background: rgba(218, 9, 9, 1) !important;} ';
                    $flash_sale_style.='#top .wc-bookings-date-picker .ui-datepicker td.bookable.data-date-'.$f_day.'[data-month="'.$f_month.'"][data-year="'.$f_year.'"] a.ui-state-active{background: rgba(178, 5, 5, 1) !important;}';
                }
            }
        }
    }
    ?>
    <style>
    <?php
    echo $after_date_content;
    echo $before_date_color;
    ?>
    <?php
    echo rtrim($bg_color_date, ',');
    ?>{
            background: #ff8519 !important; 
            position:relative;
        }
    <?php
    echo rtrim($after_date, ',');
    ?>{
            position: absolute;
            top: -50px;
            left: -59px;
            background: #243078;
            color: #fff;
            border-radius: 5px;
            min-height: 30px;
            padding: 5px;
            z-index: 9;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            visibility: hidden;
            line-height: 1.2;
            width: 200px;
        }
    <?php
    echo rtrim($before_date, ',');
    ?>{
            content: '';
            position: absolute;
            top: -10px;
            visibility:hidden;
            left: 15px;
            width: 0; 
            height: 0; 
            z-index:9;
            opacity:1;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid #243078;
        }
    <?php
    echo rtrim($date_hover_after, ',') . ',' . rtrim($date_hover_before, ',');
    ?>{
            visibility:visible;
        }   
        <?php echo $flash_sale_style; ?>
    </style>



    <?php
}
?>
<div class="mmt-flex-box">
    <div class="mmt-date-time-wrap">
        <div class="container-datetime clearfix">
            <fieldset class="wc-bookings-date-picker <?php echo implode(' ', $class); ?>">
                <div class='ht-choose-date'>
                    <legend>
                        <small class="wc-bookings-date-picker-choose-date">
                            <?php _e('Date', 'woocommerce-bookings'); ?><br>            

                        </small>
                    </legend>
                    <div class="wc-bookings-date-picker-date-fields">
                        <?php
                        // woocommerce_bookings_mdy_format filter to choose between month/day/year and day/month/year format
                        if ($month_before_day && apply_filters('woocommerce_bookings_mdy_format', true)) :
                            ?>
                            <label>
                                <input value="<?=$cruise_date_month?>" type="text" name="<?php echo $name; ?>_month" placeholder="<?php _e('mm', 'woocommerce-bookings'); ?>" size="2" class="required_for_calculation booking_date_month" />

                            </label> / <label>
                                <input value="<?=$cruise_date_day?>" type="text" name="<?php echo $name; ?>_day" placeholder="<?php _e('dd', 'woocommerce-bookings'); ?>" size="2" class="required_for_calculation booking_date_day" />

                            </label>
                        <?php else : ?>
                            <label>
                                <input value="<?=$cruise_date_month?>" type="text" name="<?php echo $name; ?>_day" placeholder="<?php _e('dd', 'woocommerce-bookings'); ?>" size="2" class="required_for_calculation booking_date_day" />

                            </label> / <label>
                                <input value="<?=$cruise_date_day?>" type="text" name="<?php echo $name; ?>_month" placeholder="<?php _e('mm', 'woocommerce-bookings'); ?>" size="2" class="required_for_calculation booking_date_month" />

                            </label>
                        <?php endif; ?>
                        / <label>
                            <input type="text" value="<?php echo ($cruise_date_year) ? $cruise_date_year : date('Y'); ?>" name="<?php echo $name; ?>_year" placeholder="<?php _e('YYYY', 'woocommerce-bookings'); ?>" size="4" class="required_for_calculation booking_date_year" />

                        </label>
                    </div>
                    <img class="wc-icon-calendar" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/calendar-ht.svg' ?>" alt="icon calendar"/>
                    <img class="icon-check" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/chevron-down.svg' ?>" alt="icon check"/>
                </div>

                <?php
                $strToTimeNow = current_time( 'timestamp' ); 
                $max = $product->get_max_date();
                $custom_max_date = strtotime("+{$max['value']} {$max['unit']}", current_time( 'timestamp' ));
                $custom_max_date = date("Y,m,d", $custom_max_date);
                
                //$minium_block = product_get_global_minimum_block_bookable($booking_id);
                $block_rule = product_get_rule_block_bookable_days($availability_rules);
                
                //$min_date_js = !empty($minium_block) ? $minium_block : $min_date_js;
                $convert_min_date_js = str_replace("d","day",$min_date_js);
                $convert_min_date_js = str_replace("w","week",$convert_min_date_js);
                $convert_min_date_js = str_replace("h","hour",$convert_min_date_js);
                $convert_min_date_js = str_replace("m","month",$convert_min_date_js);
                
                $custom_min_date = strtotime($convert_min_date_js, $strToTimeNow);
                $custom_min_date = date("Y-m-d", $custom_min_date);
                $curent_date = date("Y-m-d",$strToTimeNow);
                
                //Min date 36hours
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
                $check_farehabor_api = get_post_meta($booking_id,"mm_enable_fareharbor_api", true);
                $disable_booking_fareharbor = get_post_meta($booking_id, 'mm_disable_fareharbor_reservation', true);
                if($check_farehabor_api == 'yes' && $disable_booking_fareharbor != 'yes'){
                    $fhapi_booking = true;
                }
                $mm_enable_ponorez_api = get_post_meta($booking_id,"mm_enable_ponorez_api", true);
                $mm_disable_ponorez_reservation = get_post_meta($booking_id, 'mm_disable_ponorez_reservation', true);
                if($mm_enable_ponorez_api == 'yes' && $mm_disable_ponorez_reservation != 'yes'){
                    $ponorez_API_booking = true;
                }
                if(!$shop_manager && !$fhapi_booking && !$ponorez_API_booking){
                    $current_date_timestamp = strtotime( '+2day', current_time( 'timestamp' ) );
                    if(strtotime($custom_min_date) < $current_date_timestamp){
                        //$custom_min_date = date("Y-m-d",$current_date_timestamp);
                    }
                }
                if(!empty($min_date_js) && $min_date_js != '+0d'){
                    if ($product->has_resources()) {
                        $default_interval = 'hour' === $product->get_duration_unit() ? $product->get_duration() * 60 : $product->get_duration();
                        $intervals = array($default_interval, $default_interval);
                        $custom_check_date_time = strtotime($convert_min_date_js, $strToTimeNow);
                        //$custom_da = strtotime("midnight", $custom_da);
                        $from_date_min = $custom_check_date_time;
                        $to_date_min = strtotime("tomorrow", $custom_check_date_time) - 1;
                        $resources = $product->get_resources();
                        foreach ($resources as $resource) {
                            $resource_id = $resource->get_id();
                            $blocks = $product->get_blocks_in_range($from_date_min,$to_date_min, '', $resource_id);   
                            $available_blocks = wc_bookings_get_time_slots($product, $blocks, array(), $resource_id, $from_date_min, $to_date_min);
                            if(empty($available_blocks)){
                                $year_block = date("Y",$custom_check_date_time);
                                $month_block = date("m",$custom_check_date_time);
                                $day_block = date("d",$custom_check_date_time);
                                if(empty($availability_rules)){
                                    $availability_rules = array();
                                }
                                $availability_rules[$resource_id][] = array(
                                    'type' => 'custom',
                                    'range' => array(
                                        $year_block => array(
                                            (int)$month_block => array(
                                                (int)$day_block => false,
                                            ),
                                        ),
                                    ),
                                    'priority' => 8,
                                    'level' => 'resource',
                                    'order' => (rand(10,100)),
                                    'resource_id' => $resource_id,
                                );
                            }
                        }
                    }
                }
                
                ?>
                <div class="mm-calendar-absolute <?php if($flash_sale) echo 'mm-calendar-flashsale'; ?>">
                    <div class="back-choose-date" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back</div>
                    <div class="picker" style="display:none;" data-mmt-current-time="<?php echo esc_attr($strToTimeNow); ?>" data-display="<?php echo $display; ?>" data-availability="<?php echo esc_attr(json_encode($availability_rules)); ?>" data-default-availability="<?php echo $default_availability ? 'true' : 'false'; ?>" data-rule-booked-days="<?php echo esc_attr(json_encode($block_rule)); ?>" data-fully-booked-days="<?php echo esc_attr(json_encode($fully_booked_days)); ?>" data-partially-booked-days="<?php echo esc_attr(json_encode($partially_booked_days)); ?>" data-restricted-days="<?php echo esc_attr(json_encode($restricted_days)); ?>" data-min_date="<?php echo $min_date_js; ?>" data-min_date_js="<?php echo $custom_min_date; ?>" data-max_date="<?php echo $max_date_js; ?>" data-max_date_js="<?php echo $custom_max_date; ?>" data-default_date="<?php echo esc_attr($default_date); ?>" data-current_date="<?php echo $curent_date;?>"></div>
                    <ul class="mm-calendar-visible">
                        <?php if($flash_sale){?>
                        <li class="mm-available-flashsale"><span class="color-calendar"></span>Flash sale</li>
                        <?php }?>
                        <li class="mm-available"><span class="color-calendar"></span>Available</li>
                        <li class="mm-discounted"><a href="#click-for-waitlist" class="click-for-waitlist no-scroll"><span class="color-calendar"></span>Join Wait List</a></li>
                        <li class="mm-not-available"><span class="color-calendar"></span>Not Available</li>
                    </ul>
                </div>

            </fieldset>
            <div class="form-field form-field-wide form_field-time ">
                <div class="wc-content-time">
                    <label class="<?php echo $name; ?>" for="<?php echo $name; ?>"><?php _e('Time', 'woocommerce-bookings'); ?></label>
                    <img class="icon-hour" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/clock_ht.svg' ?>" alt="icon hour"/>
                    <img class="icon-check" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/chevron-down.svg' ?>" alt="icon check"/>
                    <p class="pickup-time">Choose a date to see available times.</p>
                </div>
                <ul class="block-picker"></ul> 
                <input type="hidden" class="required_for_calculation" name="<?php echo $name; ?>_time" id="<?php echo $name; ?>" />
            </div>
            <?php
            echo "</div>";
            echo "<div class='mm-time-picker-wrapper'>";
            echo "<ul id='mm-time-picker'>";
            echo $block_html;
            echo "</ul>";
            echo "</div>";
            echo "</div>";
            if (!$product->has_resources()) {
                echo '<div class="mm-you-save" style="display:none;">You Save: <strong style="float:right;">';
                echo '<span class="woocommerce-Price-amount amount">';
                echo '<span class="custom-prc">$<span class="price-you-save"></span></span>';
                echo '</span>';
                echo '</strong>';
                echo '</div>';
            }
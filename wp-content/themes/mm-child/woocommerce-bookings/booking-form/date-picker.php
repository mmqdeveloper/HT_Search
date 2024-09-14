<?php
wp_enqueue_script('wc-bookings-date-picker');
extract($field);

$month_before_day = strpos(__('F j, Y'), 'F') < strpos(__('F j, Y'), 'j');

$cruise_date = $_GET['cruise-date'];
$cruise_date_day = $cruise_date_month = $cruise_date_year = "";
if(!empty($cruise_date)) {
    $cruise_date = str_replace("-", '', $cruise_date);
    $cruise_date_day = substr($cruise_date, 2,2);
    $cruise_date_month = substr($cruise_date, 0,2);
    $cruise_date_year = substr($cruise_date, 4);
}

$product_id = get_the_ID();
$WC_Product = wc_get_product($product_id);
$costs = $WC_Product->get_costs();
$comma = ',';
foreach ($costs as $rule_key => $rule) {
    if(!empty($rule[1]) && is_array($rule[1])):
        $rules = $rule[1];
        $year_booking = array_keys($rules);
    endif;
    foreach ($year_booking as $key_year => $value_year) {
	    if(!empty($rules[$value_year]) && is_array($rules[$value_year]) ):
          $month_booking = array_keys($rules[$value_year]);
	    endif;
        foreach ($month_booking as $key_month => $value_month) {
	        if(!empty($rules[$value_year][$value_month]) && is_array($rules[$value_year][$value_month])):
            $day_booking = array_keys($rules[$value_year][$value_month]);
	        endif;
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
<div class="mm-tab-wrap clearfix pearl-harbol-date">
    <fieldset class="wc-bookings-date-picker wc-bookings-date-picker-<?php echo esc_attr($product_type); ?> <?php echo implode(' ', $class); ?>">
        <div class="bookings-date-1">
            <legend>
                <small class="wc-bookings-date-picker-choose-date"><?php _e('Date', 'woocommerce-bookings'); ?><br>            
                </small>

            </legend>
            <img class="wc-icon-calendar" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-calendar-v2.png' ?>" alt="icon calendar"/>
            <img class="icon-check" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/chevron-down.svg' ?>" alt="icon check"/>
            <div class="wc-bookings-date-picker-date-fields">
                <?php if ('customer' == $duration_type && $is_range_picker_enabled) : ?>
                    <span><?php echo esc_html(apply_filters('woocommerce_bookings_date_picker_start_label', __('Start', 'woocommerce-bookings'))); ?>:</span><br />
                <?php endif; ?>

                <?php
                // woocommerce_bookings_mdy_format filter to choose between month/day/year and day/month/year format
                if ($month_before_day && apply_filters('woocommerce_bookings_mdy_format', true)) :
                    ?>
                    <label>               
                        <input value="<?=$cruise_date_month?>" type="text" name="<?php echo $name; ?>_month" placeholder="<?php _e('M', 'woocommerce-bookings'); ?>" size="2" class="booking_date_month" />
                    </label> / <label>
                        <input value="<?=$cruise_date_day?>" type="text" name="<?php echo $name; ?>_day" placeholder="<?php _e('D', 'woocommerce-bookings'); ?>" size="2" class="booking_date_day" />
                    </label>
                <?php else : ?>
                    <label>
                        <input value="<?=$cruise_date_month?>" type="text" name="<?php echo $name; ?>_month" placeholder="<?php _e('M', 'woocommerce-bookings'); ?>" size="2" class="booking_date_month" />
                    </label> / <label>
                        <input value="<?=$cruise_date_day?>" type="text" name="<?php echo $name; ?>_day" placeholder="<?php _e('D', 'woocommerce-bookings'); ?>" size="2" class="booking_date_day" />
                    </label>
                <?php endif; ?> / <label>
                    <input type="text"  value="<?php echo ($cruise_date_year) ? $cruise_date_year : date('Y'); ?>" name="<?php echo $name; ?>_year" placeholder="<?php _e('YYYY', 'woocommerce-bookings'); ?>" size="4" class="booking_date_year" />
                </label>
            </div>

            <?php if ('customer' == $duration_type && $is_range_picker_enabled) : ?>
                <div class="wc-bookings-date-picker-date-fields">
                    <span><?php echo esc_html(apply_filters('woocommerce_bookings_date_picker_end_label', __('End', 'woocommerce-bookings'))); ?>:</span><br />
                    <?php if ($month_before_day) : ?>
                        <label>
                            <input type="text" name="<?php echo $name; ?>_to_month" placeholder="<?php _e('mm', 'woocommerce-bookings'); ?>" size="2" class="booking_to_date_month" />                    
                            <span class="mm-month"></span>
                        </label> / <label>
                            <span class="mm-day"></span>
                            <input type="text" name="<?php echo $name; ?>_to_day" placeholder="<?php _e('dd', 'woocommerce-bookings'); ?>" size="2" class="booking_to_date_day" />                    
                        </label>
                    <?php else : ?>
                        <label>
                            <span class="mm-day"></span>
                            <input type="text" name="<?php echo $name; ?>_to_day" placeholder="<?php _e('dd', 'woocommerce-bookings'); ?>" size="2" class="booking_to_date_day" />                    
                        </label> / <label>
                            <span class="mm-month"></span>
                            <input type="text" name="<?php echo $name; ?>_to_month" placeholder="<?php _e('mm', 'woocommerce-bookings'); ?>" size="2" class="booking_to_date_month" />                    
                        </label>
                    <?php endif; ?> / <label>
                        <span class="mm-year"></span>
                        <input type="text" value="<?php echo date('Y'); ?>" name="<?php echo $name; ?>_to_year" placeholder="<?php _e('YYYY', 'woocommerce-bookings'); ?>" size="4" class="booking_to_date_year" />               
                    </label>
                </div>
            <?php endif; ?>
        </div>
        <div class="bookings-date-2"></div>
        <div class="mm-calendar-absolute <?php if($flash_sale) echo 'mm-calendar-flashsale'; ?>">
            <div class="back-choose-date" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back</div>
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
            $strToTimeNow = current_time( 'timestamp' );  
            $max = $WC_Product->get_max_date();
            $custom_max_date = strtotime("+{$max['value']} {$max['unit']}", $strToTimeNow);
            $custom_max_date = date("Y,m,d", $custom_max_date);
            
            //$minium_block = product_get_global_minimum_block_bookable($product_id);
            $block_rule = array();
            if(function_exists('product_get_rule_block_bookable_days')){
                $block_rule = product_get_rule_block_bookable_days($availability_rules);
            }
            //$min_date_js = !empty($minium_block) ? $minium_block : $min_date_js;
            $convert_min_date_js = str_replace("d","day",$min_date_js);
            $convert_min_date_js = str_replace("w","week",$convert_min_date_js);
            $convert_min_date_js = str_replace("h","hour",$convert_min_date_js);
            $convert_min_date_js = str_replace("m","month",$convert_min_date_js);
            
            $custom_min_date = strtotime($convert_min_date_js, $strToTimeNow);
            $custom_min_date = date("Y-m-d", $custom_min_date);
            $curent_date = date("Y-m-d", $strToTimeNow);
            if($product_id == 15551 && !$shop_manager){
                if(date('Hi',$strToTimeNow)>1000){
                    $custom_min_date = date("Y-m-d",strtotime( '+1day', $strToTimeNow ));
                }
            }
            ?>
            <div class="picker" data-mmt-current-time="<?php echo esc_attr($strToTimeNow); ?>" data-display="<?php echo $display; ?>" data-duration-unit="<?php echo esc_attr($duration_unit); ?>" data-availability="<?php echo esc_attr(json_encode($availability_rules)); ?>" data-rule-booked-days="<?php echo esc_attr(json_encode($block_rule)); ?>" data-default-availability="<?php echo $default_availability ? 'true' : 'false'; ?>" data-fully-booked-days="<?php echo esc_attr(json_encode($fully_booked_days)); ?>" data-partially-booked-days="<?php echo esc_attr(json_encode($partially_booked_days)); ?>" data-buffer-days="<?php echo esc_attr(json_encode($buffer_days)); ?>" data-restricted-days="<?php echo esc_attr(json_encode($restricted_days)); ?>" data-min_date="<?php echo $min_date_js; ?>" data-min_date_js="<?php echo $custom_min_date; ?>" data-max_date="<?php echo $max_date_js; ?>" data-max_date_js="<?php echo $custom_max_date; ?>" data-default_date="<?php echo esc_attr($default_date); ?>"  data-current_date="<?php echo $curent_date;?>" data-is_range_picker_enabled="<?php echo $is_range_picker_enabled ? 1 : 0; ?>"></div>
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
    <script>
        jQuery(document).ready(function ($) {
            $(".picker").css("display", "none");

        });

    </script>
</div>
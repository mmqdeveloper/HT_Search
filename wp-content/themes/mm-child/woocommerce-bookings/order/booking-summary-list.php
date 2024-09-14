<?php
/**
 * The template for displaying the list of bookings in the summary for customers. 
 * It is used in:
 * - templates/order/booking-display.php
 * - templates/order/admin/booking-display.php
 * It will display in four places: 
 * - After checkout, 
 * - In the order confirmation email, and 
 * - When customer reviews order in My Account > Orders,
 * - When reviewing a customer order in the admin area. 
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-bookings/order/booking-summary-list.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @version 1.10.7
 * @since   1.10.7
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$get_all_day = $booking->get_all_day('edit');
if ($get_all_day) {
    $start_time = '';
} else {
    $start_time = date('h:i A', $booking->get_start('edit'));
}
if( !empty($product )){
	$id = $product->get_id();
	/*if($id == 44871){
		if($start_time =='09:30 AM') $start_time = 'Morning';
        elseif($start_time =='13:30 PM') $start_time = 'Afternoon';
	}*/
    $change_time = false;
    /*$product_tag = get_the_terms($product->get_id(), 'product_tag');
    foreach ($product_tag as $term) {
        if ($term->name == 'Air Kauai' || $term->name == 'Air Maui') {
            $change_time = true;
            break;
        }
    }
    if ($product->has_resources() || $product->is_resource_assignment_type('customer')) {
        $booking_resource_id = $booking->get_resource_id();
        if($product->get_id() == 3967 && $booking_resource_id == 190708){
            $change_time = true;
        }
    }
    $mm_change_time = get_post_meta( $id, 'mm_change_time', true );
    if($mm_change_time == 'yes' || $id== 209308 || $id== 209284 || $id== 200514 || $id== 198994 || $id== 200545 || $id== 199393 || $id== 199380 || $id== 190422 || $id== 192152 || $id== 208319 || $id== 356001 || $id== 356033){
        $change_time = true;
    }*/
    $mm_change_time = get_post_meta( $id, 'mm_change_time', true );
    if($mm_change_time == 'yes'){
        $change_time = true;
    }
    if($change_time){
        if(strpos(strtolower($start_time), 'am') !== false) $start_time = 'Morning';
        elseif(strpos(strtolower($start_time), 'pm') !== false) $start_time = 'Afternoon';
    }
}

?>
<ul class="wc-booking-summary-list your-booking-information">
    <?php
    $tour_date = date("l, F d, Y", strtotime($booking->get_start_date()));
    if (date("l, F d, Y", strtotime($booking->get_start_date())) != date("l, F d, Y", strtotime($booking->get_end_date()))) {
        //$tour_date .= ' - ' . date("l, F d, Y", strtotime($booking->get_end_date()));
    }  
    ?>
    <!--		<li class="test">Tour Date: --><?php //echo esc_html( apply_filters( 'wc_bookings_summary_list_date', $booking_date, $booking->get_start(), $booking->get_end() ) ); ?><!--</li>-->
    <li class="test" style="font-weight:600;color:#000;max-width:max-content;flex:1;">Tour Date:<br/><?php echo $tour_date; ?></li>
    <?php if ($start_time != '') { ?>
        <li class="test" style="font-weight:600;color:#000;max-width:max-content;flex:1;">Start time:<br/><?php echo $start_time; ?></li>
    <?php } ?>
    <span class="booking-date" style="display:none"><?php echo date("Y-m-d", strtotime(esc_html(apply_filters('wc_bookings_summary_list_date', $booking_date, $booking->get_start(), $booking->get_end())))); ?></span>
    <?php if ($resource) : ?>
        <li style="font-weight:600;color:#000;max-width:max-content;flex:1;"><?php echo $label.': <br/>'.$resource->get_name(); ?></li>
    <?php endif; ?>
 
    <?php
    if(!empty($product)){
	    if ($product->has_persons()) {
		    if ($product->has_person_types()) {
			    $person_types = $product->get_person_types();
			    $person_counts = $booking->get_person_counts();

			    if (!empty($person_types) && is_array($person_types)) {
				    foreach ($person_types as $person_type) {

					    if (empty($person_counts[$person_type->get_id()])) {
						    continue;
					    }
					    ?>
                        <li class="number-person" style="font-weight:600;color:#000;max-width:max-content;flex:1;" ><?php echo $person_type->get_name().':<br />'.$person_counts[$person_type->get_id()]; ?></li>
					    <?php
				    }
			    }
		    } else {
			    ?>
                <li class="number-person" style="font-weight:600;color:#000;max-width:max-content;flex:1;"><?php echo 'Persons:<br/>'.array_sum($booking->get_person_counts()); ?></li>
			    <?php
		    }
	    }
    }

    ?>
</ul>
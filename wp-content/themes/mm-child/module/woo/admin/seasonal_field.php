<?php
if (!defined('ABSPATH')) {
    exit;
}

$intervals = array();

$intervals['months'] = array(
    '1' => __('January', 'woocommerce-bookings'),
    '2' => __('February', 'woocommerce-bookings'),
    '3' => __('March', 'woocommerce-bookings'),
    '4' => __('April', 'woocommerce-bookings'),
    '5' => __('May', 'woocommerce-bookings'),
    '6' => __('June', 'woocommerce-bookings'),
    '7' => __('July', 'woocommerce-bookings'),
    '8' => __('August', 'woocommerce-bookings'),
    '9' => __('September', 'woocommerce-bookings'),
    '10' => __('October', 'woocommerce-bookings'),
    '11' => __('November', 'woocommerce-bookings'),
    '12' => __('December', 'woocommerce-bookings'),
);

$intervals['days'] = array(
    '1' => __('Monday', 'woocommerce-bookings'),
    '2' => __('Tuesday', 'woocommerce-bookings'),
    '3' => __('Wednesday', 'woocommerce-bookings'),
    '4' => __('Thursday', 'woocommerce-bookings'),
    '5' => __('Friday', 'woocommerce-bookings'),
    '6' => __('Saturday', 'woocommerce-bookings'),
    '7' => __('Sunday', 'woocommerce-bookings'),
);

for ($i = 1; $i <= 52; $i ++) {
    $intervals['weeks'][$i] = sprintf(__('Week %s', 'woocommerce-bookings'), $i);
}

if (!isset($pricing['type'])) {
    $pricing['type'] = 'custom';
}
if (!isset($pricing['modifier'])) {
    $pricing['modifier'] = '';
}
if (!isset($pricing['base_modifier'])) {
    $pricing['base_modifier'] = '';
}
if (!isset($pricing['base_cost'])) {
    $pricing['base_cost'] = '';
}
if (!isset($pricing['percentage'])) {
    $pricing['percentage'] = '';
}
if (!isset($pricing['id_resource'])) {
    $pricing['id_resource'] = '';
}
if (!isset($pricing['notes'])) {
    $pricing['notes'] = '';
}
if (!isset($pricing['color_notes'])) {
    $pricing['color_notes'] = '';
}
// In the loop of saved items an index is supplied, but we need one for the
// add new cost range button so we can replace it when adding and index on the front end.
$index = isset($index) ? $index : 'bookings_cost_js_index_replace';
?>
<tr>
    <td class="sort">&nbsp;</td>
    <td>
        <div class="select wc_booking_pricing_type">
            <select name="wc_booking_seasonal_type[<?php echo esc_attr($index); ?>]">
                <option value="custom" <?php selected($pricing['type'], 'custom'); ?>><?php _e('Date range', 'woocommerce-bookings'); ?></option>
                <option value="months" <?php selected($pricing['type'], 'months'); ?>><?php _e('Range of months', 'woocommerce-bookings'); ?></option>
                <option value="days" <?php selected($pricing['type'], 'days'); ?>><?php _e('Range of days', 'woocommerce-bookings'); ?></option>

            </select>
        </div>
    </td>
    <td style="border-right:0;">
        <div class="bookings-datetime-select-from">
            <div class="select from_day_of_week">
                <select name="wc_booking_seasonal_from_day_of_week[<?php echo esc_attr($index); ?>]">
                    <?php foreach ($intervals['days'] as $key => $label) : ?>
                        <option value="<?php echo $key; ?>" <?php selected(isset($pricing['from']) && $pricing['from'] == $key, true) ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="select from_month">
                <select name="wc_booking_seasonal_from_month[<?php echo esc_attr($index); ?>]">
                    <?php foreach ($intervals['months'] as $key => $label) : ?>
                        <option value="<?php echo $key; ?>" <?php selected(isset($pricing['from']) && $pricing['from'] == $key, true) ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="select from_week">
                <select name="wc_booking_seasonal_from_week[<?php echo esc_attr($index); ?>]">
                    <?php foreach ($intervals['weeks'] as $key => $label) : ?>
                        <option value="<?php echo $key; ?>" <?php selected(isset($pricing['from']) && $pricing['from'] == $key, true) ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="from_date">
                <?php
                $from_date = '';
                if ('custom' === $pricing['type'] && !empty($pricing['from'])) {
                    $from_date = $pricing['from'];
                } else if ('time:range' === $pricing['type'] && !empty($pricing['from_date'])) {
                    $from_date = $pricing['from_date'];
                }
                ?>
                <input type="text" class="date-picker" name="wc_booking_seasonal_from_date[<?php echo esc_attr($index); ?>]" value="<?php echo esc_attr($from_date); ?>" />
            </div>

            <div class="from_time">
                <input type="time" class="time-picker" name="wc_booking_seasonal_from_time[<?php echo esc_attr($index); ?>]" value="<?php if (strrpos($pricing['type'], 'time') === 0 && !empty($pricing['from'])) echo $pricing['from'] ?>" placeholder="HH:MM" />
            </div>

            <div class="from">
                <input type="number" step="1" name="wc_booking_seasonal_from[<?php echo esc_attr($index); ?>]" value="<?php if (!empty($pricing['from']) && is_numeric($pricing['from'])) echo $pricing['from'] ?>" />
            </div>
        </div>
    </td>
    <td style="border-right:0;" width="25px;" class="bookings-to-label-row">
        <p><?php _e('to', 'woocommerce-bookings'); ?></p>
        <p class="bookings-datetimerange-second-label"><?php _e('to', 'woocommerce-bookings'); ?></p>
    </td>
    <td>
        <div class="bookings-datetime-select-to">
            <div class="select to_day_of_week">
                <select name="wc_booking_seasonal_to_day_of_week[<?php echo esc_attr($index); ?>]">
                    <?php foreach ($intervals['days'] as $key => $label) : ?>
                        <option value="<?php echo $key; ?>" <?php selected(isset($pricing['to']) && $pricing['to'] == $key, true) ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="select to_month">
                <select name="wc_booking_seasonal_to_month[<?php echo esc_attr($index); ?>]">
                    <?php foreach ($intervals['months'] as $key => $label) : ?>
                        <option value="<?php echo $key; ?>" <?php selected(isset($pricing['to']) && $pricing['to'] == $key, true) ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="select to_week">
                <select name="wc_booking_seasonal_to_week[<?php echo esc_attr($index); ?>]">
                    <?php foreach ($intervals['weeks'] as $key => $label) : ?>
                        <option value="<?php echo $key; ?>" <?php selected(isset($pricing['to']) && $pricing['to'] == $key, true) ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="to_date">
                <?php
                $to_date = '';
                if ('custom' === $pricing['type'] && !empty($pricing['to'])) {
                    $to_date = $pricing['to'];
                } else if ('time:range' === $pricing['type'] && !empty($pricing['to_date'])) {
                    $to_date = $pricing['to_date'];
                }
                ?>
                <input type="text" class="date-picker" name="wc_booking_seasonal_to_date[<?php echo esc_attr($index); ?>]" value="<?php echo esc_attr($to_date); ?>" />
            </div>

            <div class="to_time">
                <input type="time" class="time-picker" name="wc_booking_seasonal_to_time[<?php echo esc_attr($index); ?>]" value="<?php if (strrpos($pricing['type'], 'time') === 0 && !empty($pricing['to'])) echo $pricing['to']; ?>" placeholder="HH:MM" />
            </div>

            <div class="to">
                <input type="number" step="1" name="wc_booking_seasonal_to[<?php echo esc_attr($index); ?>]" value="<?php if (!empty($pricing['to']) && is_numeric($pricing['to'])) echo $pricing['to'] ?>" />
            </div>
        </div>
    </td>

    <td>
        <input type="number" step="0.01" name="wc_booking_seasonal_cost[<?php echo esc_attr($index); ?>]" value="<?php if (!empty($pricing['cost'])) echo $pricing['cost']; ?>" placeholder="0" />
        <?php do_action('woocommerce_bookings_after_booking_pricing_cost', $pricing, $post->ID); ?>
    </td>
    <td>
        <select id="resource" name="mm_resource_id[<?php echo esc_attr($index); ?>]">
            <option value="">Select Resource</option>
            <?php
            if ($product_resources) {
                foreach ($product_resources as $resource_id) {
                    $resource = new WC_Product_Booking_Resource($resource_id);
                    ?>
                    <option value="<?php echo $resource_id; ?>" <?php if ($pricing['mm_resource_id'] == $resource_id) echo "selected"; ?>><?php echo $resource->get_name(); ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </td>
    <td>
        <?php if ($person_types) { ?>
            <select id="person" name="mm_person_id[<?php echo esc_attr($index); ?>]">
                <option value="">Select Person</option>
                <?php
                foreach ($person_types as $person_type) {
                    ?>
                    <option value="<?php echo esc_attr($person_type->get_id()); ?>" <?php if ($pricing['mm_person_id'] == esc_attr($person_type->get_id())) echo "selected"; ?>><?php echo esc_attr($person_type->get_name('edit')); ?></option>
                <?php }
                ?>
            </select>
        <?php } ?>

    </td>
    <td class="remove">&nbsp;</td>
</tr>

<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 7.8.0
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!$order = wc_get_order($order_id)) {
    return;
}

$order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads = $order->get_downloadable_items();
$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();

if ($show_downloads) {
    wc_get_template('order/order-downloads.php', array('downloads' => $downloads, 'show_title' => true));
}
?>
<section class="woocommerce-order-details">
    <?php do_action('woocommerce_order_details_before_order_table', $order); ?>
    <div class="mm-woocommerce-order-details">

        <?php
        do_action('woocommerce_order_details_before_order_table_items', $order);

        foreach ($order_items as $item_id => $item) {
            $product = $item->get_product();

            wc_get_template('order/order-details-item.php', array(
                'order' => $order,
                'item_id' => $item_id,
                'item' => $item,
                'show_purchase_note' => $show_purchase_note,
                'purchase_note' => $product ? $product->get_purchase_note() : '',
                'product' => $product,
            ));
        }

        do_action('woocommerce_order_details_after_order_table_items', $order);
        ?>
    </div>
<!--	<h3 style="padding: 40px 0px;"><span class="confirm underline">Billing</span> address</h3>-->
    <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
</section>

<?php
if ($show_customer_details) {
    wc_get_template('order/order-details-customer.php', array('order' => $order));
}

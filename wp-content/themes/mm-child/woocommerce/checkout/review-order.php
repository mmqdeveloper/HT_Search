<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version      5.2.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<table class="shop_table woocommerce-checkout-review-order-table">
    <thead>
        <tr>
            <th class="product-remove">&nbsp;</th>
            <th class="product-name"><?php _e('Experiences', 'woocommerce'); ?></th>
            <th class="product-total"><?php _e('Total', 'woocommerce'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        do_action('woocommerce_review_order_before_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                ?>
                <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    <td>
                        <div class="product-name">
                            <span>
                                <?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;'; ?>
                                <?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times; %s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); ?>
                            </span>
                            <dl class="tc-epo-metadata variation">
                                <dt class="variation-BookingDate"></dt>
                                <dd class="variation-BookingDate"><p><?php echo $cart_item['booking']['date']; ?></p></dd>
                                <?php if($_product->get_id() == 702635){ $cart_item['booking']['time'] = '1:00 pm';}?>
                                <?php if(isset($cart_item['booking']['time']) && !empty($cart_item['booking']['time'])){ ?> 
                                <?php
                                $start_time = $cart_item['booking']['time'];
                                $mm_change_time = get_post_meta( $_product->get_id(), 'mm_change_time', true );
                                if($mm_change_time == 'yes' ){
                                    $change_time = true;
                                }
                                if($change_time){
                                    if(strpos(strtolower($start_time), 'am') !== false) $start_time = 'Morning';
                                    elseif(strpos(strtolower($start_time), 'pm') !== false) $start_time = 'Afternoon';
                                }
                                ?>
                                <dt class="variation-BookingTime"></dt>
                                <dd class="variation-BookingTime"><p><?php echo $start_time; ?></p></dd>
                                <?php }?>
                                <?php if (!empty($cart_item['booking']['_persons'])) {
                                    $person_types = $_product->get_person_types();
                                    foreach ($person_types as $person) {
                                        if(isset($cart_item['booking']['_persons'][$person->get_id()]) ){
                                    ?>
                                <dt class="variation-Adult"></dt>
                                <dd class="variation-Adult"><p><?php echo $cart_item['booking']['_persons'][$person->get_id()]; ?> <?php echo $person->post_title;?></p></dd>
                                <?php 
                                
                                        }
                                    }
                                }
                                ?>
                                </dl>
                        </div>
                        <div class="product-remove" style=" max-width: 200px;">
                        <?php
                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                            if ( ! $product_permalink ) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                            } else {
                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                            }
                        ?>
                        <?php
                            /*echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                __( 'Remove this item', 'woocommerce' ),
                                esc_attr( $product_id ),
                                esc_attr( $_product->get_sku() )
                            ), $cart_item_key );*/
                        ?>
                        </div>
                        <?php
                        $html_cs = '';
                        $cruise_info = false;
                        $item_data = apply_filters( 'woocommerce_get_item_data', array(), $cart_item );
                        foreach ( $item_data as $key => $data ) {
                            if ( $data['name'] == 'Destination' || $data['name'] == 'Cruise Ship Name'|| $data['name'] == 'Arrival Date' || $data['name'] == 'Arrival Time') {
                                $cruise_info = true;
                                $html_cs .= '<p>' . $data['value'] .'</p>';
                            }
                        }
                        if ($cruise_info) {
                            echo '<div class="checkout-cruise-info"><p>Cruise Ship Info</p>' . $html_cs . '</div>';
                        }
                        ?>
                        <div class="product-sumary">
                            <label class="mm-toggle-sumary" for="mm-toggle-sumary_<?php echo $cart_item_key; ?>" data-hidetext="Hide order summary" data-showtext="Show order summary">Show order summary</label>
                            <input type="checkbox" id="mm-toggle-sumary_<?php echo $cart_item_key; ?>" style="display: none;" />
                            <?php
                                echo wc_get_formatted_cart_item_data($cart_item); 
                            ?>

                            <?php 
                                $has_show_warning = false;
                                $product_tags = wp_get_post_terms($_product->get_id(), 'product_tag');
                                if (!empty($product_tags) && !is_wp_error($product_tags)) {
                                    foreach ($product_tags as $product_tag) {
                                        if (strtolower(trim($product_tag->name)) == strtolower(trim('PickUp Disclaimer at Checkout'))) {
                                            $has_show_warning = true;
                                            break;
                                        }
                                    }
                                }
                                if ($has_show_warning == true) {
                            ?>
                                <div class="mm-message-pickup-disclaimer">
                                    <span>Please note that your pick-up location may differ from your hotel but is within a 5-minute walking distance.</span>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </td>
                </tr>
                <?php
            }
        }

        do_action('woocommerce_review_order_after_cart_contents');
        ?>
    </tbody>
    <tfoot>

        <tr class="cart-subtotal">
            <td><?php _e('Subtotal', 'woocommerce'); ?> <?php wc_cart_totals_subtotal_html(); ?></td>
        </tr>

        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                <td><?php wc_cart_totals_coupon_label($coupon); ?> <?php wc_cart_totals_coupon_html($coupon); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

            <?php do_action('woocommerce_review_order_before_shipping'); ?>

            <?php wc_cart_totals_shipping_html(); ?>

            <?php do_action('woocommerce_review_order_after_shipping'); ?>

        <?php endif; ?>

        <?php foreach (WC()->cart->get_fees() as $fee) :

            $number = substr($fee->name,  0, strlen($fee->name)-1);
            $class_name = str_replace(" ","",$number);
            ?>
            <tr class="fee">
                <td><a href="javascript:;" id="<?php echo $fee->id; ?>" class="remove <?php echo strtolower($class_name); ?>" aria-label="Remove this item" data-product_id="" data-product_sku="">�</a><?php echo esc_html($fee->name); ?><?php wc_cart_totals_fee_html($fee); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (wc_tax_enabled() && 'excl' === WC()->cart->get_tax_price_display_mode()) : ?>
            <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
                <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                    <tr class="tax-rate tax-rate-<?php echo sanitize_title($code); ?>">
                        <td><?php echo esc_html($tax->label); ?> <?php echo wp_kses_post($tax->formatted_amount); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="tax-total">
                    <td><?php echo esc_html(WC()->countries->tax_or_vat()); ?> <?php wc_cart_totals_taxes_total_html(); ?></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>

        <?php do_action('woocommerce_review_order_before_order_total'); ?>

        <tr class="order-total">
            <td><?php _e('Total', 'woocommerce'); ?> <?php wc_cart_totals_order_total_html(); ?></td>
        </tr>

        <?php do_action('woocommerce_review_order_after_order_total'); ?>

    </tfoot>

</table>


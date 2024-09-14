<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 7.0.1
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!wc_coupons_enabled()) {
    return;
}
?>
<div class="mm_coupon_form">
    <?php
    if (empty(WC()->cart->applied_coupons)) {
        $icon = '<img src="'.get_stylesheet_directory_uri() .'/assets/images/icon-coupon.svg" class="material-icons ywgc_woocommerce_message_icon" style=" max-width: 24px; margin-right: 6px;float: left" alt=" coupon icon">';
    
        $info_message = apply_filters('woocommerce_checkout_coupon_message', __('Have a coupon?', 'woocommerce') . ' <a href="#" class="showcoupon">' . __('Click here to enter your code', 'woocommerce') . '</a>');
        wc_print_notice($icon.$info_message, 'notice');
    }
    ?>

    <form class="checkout_coupon" method="post" style="display:none">

        <p class="form-row form-row-first">
            <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" id="coupon_code" value="" />
        </p>

        <p class="form-row form-row-last">
            <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
        </p>

        <div class="clear"></div>
    </form>
</div>
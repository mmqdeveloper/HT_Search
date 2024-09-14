<?php

/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
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
 * @version     3.3.0
 */
if (!defined('ABSPATH')) {
    exit;
}

global $product;
$product_tags = get_the_terms(get_the_ID(), 'product_tag'); 
$tag_deal = false;
if (is_array($product_tags)) {
    foreach ($product_tags as $product_tag) {
        if ($product_tag->term_id == 17378) {
            $tag_deal = true;
            break;
        }
    }
}
?>
<?php if($tag_deal == true){ ?>
    <div class="wc-price-wrap">
        <span class="wc-price mm-price-before-sale">
            <span class="starting-price">from</span>
            <?php
                if ('gift-card' == $product->get_type()) {
                $amounts = $product->get_amounts_to_be_shown();
                foreach ($amounts as $value => $item) {
                    echo wc_price($item['price']);
                    break;
                }
            } else
                echo wc_price($product->get_price());
            ?>
        </span>
<?php }?>
<span class="wc-price">
    <span class="starting-price"><? echo($tag_deal == true ? 'Now<br />from' : 'from'); ?></span>
    <?php
    if ('gift-card' == $product->get_type()) {
        $amounts = $product->get_amounts_to_be_shown();
        foreach ($amounts as $value => $item) {
            $price = $item['price'];
            if ($tag_deal == true) {
                $price = floor($price * (1 - (5 / 100)));
            }
            echo wc_price($price);
            break;
        }
    } else{
        $price = $product->get_price();
        if ($tag_deal == true) {
            $price = floor($price * (1 - (5 / 100)));
        }
        echo wc_price($price);
    }
    ?>
</span>

<?php if($tag_deal == true){ ?>
    </div>
<?php } ?>

<?php
$product_url = esc_url($product->add_to_cart_url());
$fareharbor_link = get_post_meta($product->get_id(), 'enable_fareharbor_popup_link', true);
$mm_booking_type = get_post_meta($product->get_id(), 'mm_select_booking_type', true);
if(!empty($fareharbor_link) && $mm_booking_type =='fhpopup'){
    $product_url = $fareharbor_link;
}
//echo "<span class='wc-price'>" . wc_price($product->get_price()) . "</span>";
echo apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">BOOK NOW</a>', $product_url, esc_attr(isset($quantity) ? $quantity : 1 ), esc_attr($product->get_id()), esc_attr($product->get_sku()), esc_attr(isset($class) ? $class : 'button' ), esc_html($product->add_to_cart_text()), esc_attr($product->get_price())
                //echo $product->get_price();
        ), $product);


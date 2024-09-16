<?php
if (!empty($product)) {
?>
 <div class="product-result">
    <a class="mmsp_result_wrapper" href="<?php echo esc_url($product->product_url); ?>">
        <div class="mmsp_image">
        <img class="image" src="<?php echo esc_url($product->product_image); ?>" alt="<?php echo esc_html($product->product_title); ?>">
        </div>
        <h3 class="mmsp_title"><?php echo esc_html($product->product_title); ?></h3>
        <div class="mmsp_piclup_dura">
            <?php  if(!empty($product->product_pickup)) { ?>
                <div class="mmsp_pickup"><?php echo esc_html($product->product_pickup); ?></div>
            <?php } ?>
            <?php  if(!empty($product->product_pickup)) { ?>
                <div class="mmsp_duration"><?php echo esc_html($product->product_duration . ' ' . $product->product_duration_unit); ?></div>
            <?php } ?>
            </div>
        <div class="mmsp_price_rating">
        <div class="mmsp_price"><span class="mmsp_price_label">from</span>$<?php echo number_format($product->product_price); ?></div>
        <div class="mmsp_rating"><span class="dashicons dashicons-star-filled"></span>5.0</div>
        </div>
        <div class="mmsp_cate_pimary"><?php echo esc_html($product->product_categories_pimary); ?></div>
    </a>
</div>
<?php
}

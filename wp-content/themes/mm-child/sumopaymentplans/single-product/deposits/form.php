<div class="<?php echo $class; ?>" id="<?php echo SUMO_PP_PLUGIN_PREFIX . 'payment_type_fields'; ?>" <?php echo $hide_if_variation ? 'style="display:none;"' : ''; ?>>
    <p>
        <?php if ('yes' !== $product_props['force_deposit']) { ?>
            <label class="ht_deposit_payment_type">
                <input type="radio" value="pay_in_full" name="<?php echo SUMO_PP_PLUGIN_PREFIX . 'payment_type'; ?>" checked="checked"/>
                <?php echo '<span>' . $pay_in_full_label . '</span>'; ?>
            </label>
        <?php } ?>
        <label class="ht_deposit_payment_type">
            <input type="radio" value="pay-in-deposit" name="<?php echo SUMO_PP_PLUGIN_PREFIX . 'payment_type'; ?>" <?php echo 'yes' === $product_props['force_deposit'] ? 'checked="checked"' : ''; ?>/>
            <?php echo '<span>' . $pay_a_deposit_amount_label . '</span>'; ?>
            <?php
            if ( 'percent-of-product-price' === $product_props[ 'deposit_price_type' ] ) {
                $fixed_deposit_percent =  $product_props[ 'apply_global_settings' ] ? floatval( get_option( SUMO_PP_PLUGIN_PREFIX . 'fixed_deposit_percent', '50' ) ) : floatval( get_post_meta( $product_props[ 'product_id' ], SUMO_PP_PLUGIN_PREFIX . 'fixed_deposit_percent', true ) );
            ?>
            <input type="hidden" value="<?php echo $fixed_deposit_percent; ?>" name="ht_deposit_percentage" class="ht_deposit_percentage"/>    
            <?php } ?>
            
        </label>
        <?php do_action('sumopaymentplans_after_deposit_field_label', $product_props); ?>
    </p>
    <div id="<?php echo SUMO_PP_PLUGIN_PREFIX . 'amount_to_choose'; ?>" <?php echo 'yes' === $product_props['force_deposit'] ? '' : 'style="display: none;"'; ?>>
        <?php if ('user-defined' === $product_props['deposit_type']) { ?>
            <p>
                <label for="<?php echo SUMO_PP_PLUGIN_PREFIX . 'deposited_amount'; ?>">
                    <?php
                    printf(__('Enter your Deposit Amount between %s and %s', SUMO_PP_PLUGIN_TEXT_DOMAIN), wc_price($min_deposit_price), wc_price($max_deposit_price));
                    ?>
                </label>
                <input type="number" min="<?php echo floatval($min_deposit_price); ?>" max="<?php echo floatval($max_deposit_price); ?>" step="0.01" class="input-text" name="<?php echo SUMO_PP_PLUGIN_PREFIX . 'deposited_amount'; ?>"/>
            </p>
        <?php } else { ?>
            <p>
                <?php echo wc_price($fixed_deposit_price); ?>
                <input type="hidden" value="<?php echo $fixed_deposit_price; ?>" name="<?php echo SUMO_PP_PLUGIN_PREFIX . 'deposited_amount'; ?>"/>
            </p>
        <?php } ?>
    </div>
</div>
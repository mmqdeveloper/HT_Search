<table class="<?php echo SUMO_PP_PLUGIN_PREFIX . 'payment_plans' ; ?>">
    <?php
    foreach( $plans as $col => $plan ) {
        $plan = ( array ) $plan ;
        ?>
        <tr>
            <?php
            foreach( $plan as $row => $plan_id ) {
                $plan_props = _sumo_pp()->plan->get_props( $plan_id ) ;

                _sumo_pp_get_template( 'single-product/payment-plans/plan.php' , array(
                    'product_props'                  => $product_props ,
                    'plan_props'                     => $plan_props ,
                    'product'                        => $product ,
                    'is_default'                     => 0 === $col && 0 === $row ,
                    'activate_payments'              => $activate_payments ,
                    'display_add_to_cart_plan_link'  => $display_add_to_cart_plan_link ,
                    'added_to_cart_plan_redirect_to' => $added_to_cart_plan_redirect_to ,
                    'total_payable'                  => _sumo_pp()->product->get_prop( 'total_payable' , array( 'props' => $product_props , 'plan_props' => $plan_props ) ) ,
                ) ) ;
            }
            ?>
        </tr>
        <?php
    }
    ?>
    <input type="hidden" value="1" name="mm_plan_total_guest" class="mm_plan_total_guest"/> 
</table>
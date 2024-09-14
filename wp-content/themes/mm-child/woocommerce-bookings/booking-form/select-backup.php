<?php
extract($field);
?>
    <p class="<?php echo $name; ?>"><?php echo $label; ?></p>
        
    <div class="mmt-select-wrap">
    
    <div class="form-field form-field-wide field_resource <?php echo implode(' ', $class); ?>">
        <select name="<?php echo $name; ?>" id="<?php echo $name; ?>">
            <option value=""></option>
        
            <?php
            $count_resource = 0;
            foreach ($options as $key => $value) :
                $count_resource++;
                ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php endforeach; ?>
        </select>
        <i class="fa fa-angle-down" aria-hidden="true" ></i>
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/check.png' ?>" alt='icon check' class='icon-check'>
        <p class="tour-island"><?php echo $label; ?></p>
    </div>
    <?php
    //if ($class[0] == 'wc_booking_field_vehicles') {
        //echo "</div>"; 
    //}
    ?>
    <ul class="list-costs-island <?php echo 'number_resource_' . $count_resource; ?> clearfix">
        <?php foreach ($options as $key => $value) : ?>
            <?php
            $data_cost = '';
            foreach ($cost_resource as $k => $v) :
                $data_cost = $cost_resource[$key];
                break;
            endforeach;
            ?>
            <li data-fields="<?php echo $key; ?>" data-island="<?php echo $value; ?>" data-cost ="<?php echo $data_cost ? $data_cost : 0; ?>">
                <div class="item-resource-content">
                    <?php
                    $idproduct_mm=get_the_ID();
                    $image_id = get_post_meta($key, 'icon_resources', true);
                    $image_id_hover = get_post_meta($key, 'icon_resources_hover', true);
                    $image_url = wp_get_attachment_url($image_id);
                    $image_url_hover = wp_get_attachment_url($image_id_hover);
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    $image_alt_hover = get_post_meta($image_id_hover, '_wp_attachment_image_alt', true);
                    echo "<img src='" . $image_url . "' alt='" . $image_alt . "' class='img-island'/>";
                    echo "<img src='" . $image_url_hover . "' alt='" . $image_alt_hover . "' class='img-island-hover'/>";
                    ?>
                    <div class="ht-price-option">
                        <p class="island-name"><?php echo $value; ?></p>
                        <?php $island_name = $value; ?>
                        <span class="starting-text">Starting at </span>
                        <p class="plus-price">
                            <?php
                            foreach ($cost as $keys => $value) :
                                echo wc_price($cost[$key]);
                                break;
                            endforeach;
                            ?>
                        </p>
                        <small>
	                        <?php
	                        echo $idproduct_mm == 6665 ? 'per kayak' : 'per adult';
	                        ?>
                        </small>
                    </div>  
                </div>              
            </li>
        <?php endforeach; ?>
    </ul>
    </div>

<div class="mm-you-save" style="display:none;">You Save: <strong style="float:right;">
        <span class="woocommerce-Price-amount amount">
            <span class="custom-prc">$<span class="price-you-save"></span></span>
        </span>
    </strong>
</div>
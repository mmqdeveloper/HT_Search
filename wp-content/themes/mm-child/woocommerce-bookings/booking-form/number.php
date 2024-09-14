<?php
extract($field);
global $product;
$person_id = str_replace("wc_bookings_field_persons_", "", $name);
$upload_dir = wp_upload_dir();
$file_name = get_the_ID().'_person.json';
$json_file = $upload_dir['basedir'] . '/mm-bookingbox/' . $file_name;
$person_html = '';
$file_content = '';
if (file_exists($json_file)) {
    $file_content = file_get_contents($json_file, true);
    $file_content = json_decode($file_content, true);
    if(isset($file_content[$person_id])){
        $person_html = $file_content[$person_id];
        
    }
}
if(!empty($person_html)){
    echo $person_html;
}else{
    ob_start();

$person_types = $product->get_person_types();
$i = 0;
foreach ($person_types as $person_type) {
    $i++;
}
if (isset($base_costs) && $base_costs != 0) {
    $costs = $base_costs;
} elseif (isset($block_costs) && $block_costs != 0) {
    $costs = $block_costs;
} else {
    $costs = 0.00;
}
$costs = round($costs);
$costs_args = explode('.', $costs);
$costs_args[1] = ($costs_args[1]) ? $costs_args[1] : '00';
$terms = get_the_terms ( get_the_ID(), 'product_cat' );
foreach ( $terms as $term ) {
     $cat_id = $term->term_id;
     if($cat_id=='9803'){
         $product_packages = true;
     }
}
$terms_tag = get_the_terms ( get_the_ID(), 'product_tag' );
foreach ( $terms_tag as $term_tag ) {
     $tag_id = $term_tag->term_id;
     if($tag_id=='16409'){
         $product_packages = true;
     }
}
$class_custom = '';
$hide_price_person = '';
if($product_packages){
    if($label == 'Persons' || $label == 'Room'){
        $class_custom = 'mm_bookings_field_persons_'.$label;
    }
    if($label == 'Guests' || $label == 'Golfers' || $label == 'Non Golfers'){
        $class_custom = 'mm_bookings_field_persons_Persons';
        if($label == 'Golfers'){
            $class_custom .=' persons_golfers';
        }
    }
    $hide_price_person = 'style="display:none;"';
    if(get_the_ID() == 483244){
        $hide_price_person = '';
    }
}

$person_default = $min;
$mm_person_default = get_post_meta(get_the_ID(), 'mm_person_default',true);
$mm_person_tooltip = get_post_meta(get_the_ID(), 'mm_person_tooltip',true);
$dataArray = array();
if (!empty($mm_person_default) && !empty(unserialize($mm_person_default))) {
    $dataArray = unserialize($mm_person_default);
    if(isset($dataArray[$person_id]) && $dataArray[$person_id]!=''){
        $person_default = $dataArray[$person_id];
    }
}
$tooltipArray = array();
if (!empty($mm_person_tooltip) && !empty(unserialize($mm_person_tooltip))) {
    $tooltipArray = unserialize($mm_person_tooltip);
    if(isset($tooltipArray[$person_id]) && $tooltipArray[$person_id]!=''){
        $person_tooltip = $tooltipArray[$person_id];
    }
}
$person_min_age = '';
$person_max_age = '';
$mm_person_age = get_post_meta(get_the_ID(), 'mm_person_age',true);
if (!empty($mm_person_age) && !empty(unserialize($mm_person_age))) {
    $dataArray_age = unserialize($mm_person_age);
    if(isset($dataArray_age[$person_id])){
        foreach ($dataArray_age[$person_id] as $key => $person_age) {
            if($key == 'min'){
                $person_min_age = $person_age;
            }
            if($key == 'max'){
                $person_max_age = $person_age;
            }
        }
    }
}
if($name == 'wc_bookings_field_duration' && get_the_ID() == 577863){
    $person_default = 5;
}    
?>
<div class="form-field form-field-wide form_field_person <?php echo "form_number_field_" . $i; ?> <?php echo "form_person_" . $order; ?> <?php echo implode(' ', $class); ?>" data-id ="<?php echo $person_id; ?>">
    <div class="content-person">
        <select 
            name="<?php echo $name; ?>"
            id="<?php echo $name; ?>" 
            class="<?php echo $class_custom; ?> mm-bookings-field-select"
            max="<?php echo ( isset($max) ? $max : "") ; ?>" 
            min="<?php echo ( isset($min) ? $min : "") ; ?>" 
            <?php echo ( isset($max) && $max == 0  ? 'disabled' : "") ; ?>
            data-min_age="<?php echo $person_min_age; ?>"
            data-max_age="<?php echo $person_max_age; ?>"
            data-default="<?php echo $person_default;?>"
            >
            <?php
            
            $irun = ( isset($min) ) ? $min : 0;
            $iend = ( isset($max) ) ? $max : 0;
            if($iend > 0){
                for($irun; $irun <= $iend; $irun++ ){
                    ?>
                    <option value="<?php echo $irun;?>" <?php if($person_default == $irun) echo 'selected="selected"'; ?>><?php echo $irun;?></option>
                    <?php
                }
            }
             ?>
        
        </select>
    </div>
    <label for="<?php echo $name; ?>" class="label-content-person">
        <div class="mm-content-person">
            <span class="person-name">
                <?php
                if($label == 'Duration'){
                    echo 'Nights';
                }
                else echo $label; ?>
                <?php if(!empty($person_tooltip) ) { ?>
                    <span class="person-description-tooltip">
                        <span class="person-description"><?php echo $person_tooltip; ?></span>
                    </span>
                <?php } ?>
            </span>
            <?php
            if(!empty($after) ){?>
                <span class="person-description" style="display:block"><?php echo $after; ?></span>
            <?php }?>
        </div>
        <span class="price-person" data-cost-person="<?php echo $costs; ?>" <?php echo $hide_price_person; ?>>
            <span class="woocommerce-Price-amount amount">
                <span><?php echo get_woocommerce_currency_symbol();?></span>
                    <span class="custom-prc"><?php echo number_format($costs_args[0]); ?><sup><?php echo '.' . $costs_args[1]; ?></sup></span>
                    
            </span>
        </span>
    </label>
     <?php
    // if ($label == 'Guests' && !$product_packages) {
    //     echo '<p class="txt-number-group">HOW MANY IN YOUR GROUP</p>';
    // }
    ?>
    
</div>
<?php
    $output .= ob_get_clean();
    echo $output;
    if (!empty($file_content)) {
        $output_person = $file_content;
        
    }else{
        $output_person = array();
    }
    $output_person[$person_id] = $output;
    file_put_contents($json_file, json_encode($output_person));
}
    

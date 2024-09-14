<?php
extract($field);
$get_resource_html = '';
$upload_dir = wp_upload_dir();
$file_name = get_the_ID().'_resource.json';
$json_file = $upload_dir['basedir'] . '/mm-bookingbox/' . $file_name;
if (file_exists($json_file)) {
    $file_content = file_get_contents($json_file, true);
    $file_content = json_decode($file_content, true);
    $get_resource_html = $file_content;
}
if(!empty($get_resource_html)){
    echo $get_resource_html;
}else{
ob_start();
?>
    <p class="<?php echo $name; ?>"><?php echo $label; ?></p>
        
    <div class="mmt-select-wrap">
    <?php 
    $mm_custom_price = get_post_meta(get_the_ID(), 'mm_custom_price', true);
    $dataArray_price = array();
    if (!empty($mm_custom_price) && !empty(unserialize($mm_custom_price))) {
        $dataArray_price = unserialize($mm_custom_price);
    }
    ?>
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
        <!-- <img src="<?php //echo get_stylesheet_directory_uri() . '/assets/images/chevron-down.svg' ?>" alt='icon check' class='icon-check'> -->
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
                $data_cost = round($cost_resource[$key]);
                break;
            endforeach;
            $custom_price = array();
            if (!empty($dataArray_price)){
                foreach ($dataArray_price as $itemkey => $items) {
                    if($items['resource'] == $key && $items['price'] != ''){
                        $custom_price[$items['person']] = round($items['price']);
                        
                    }
                }
            }
            ?>
            <li data-fields="<?php echo $key; ?>" data-island='<?php echo htmlentities($value, ENT_QUOTES); ?>' data-cost ="<?php echo $data_cost ? $data_cost : 0; ?>" data-customprice ="<?php echo esc_attr(json_encode($custom_price)); ?>">
                <div class="item-resource-content">
                    <?php
                    $image_id = get_post_meta($key, 'icon_resources', true);
                    $image_id_hover = get_post_meta($key, 'icon_resources_hover', true);
                    $image_url = wp_get_attachment_url($image_id);
                    $image_url_hover = wp_get_attachment_url($image_id_hover);
                    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    $image_alt_hover = get_post_meta($image_id_hover, '_wp_attachment_image_alt', true);
                    if(!empty($image_id)) {
                        echo "<img src='" . $image_url . "' alt='" . $image_alt . "' class='img-island'/>";
                        echo "<img src='" . $image_url_hover . "' alt='" . $image_alt_hover . "' class='img-island-hover'/>";
                    }
                    ?>
                    <div class="ht-price-option">
                        <p class="island-name"><?php echo $value; ?></p>
                        <?php $island_name = $value; ?>
                        <span class="starting-text">Starting at </span>
                        <p class="plus-price">
                            <?php
                            foreach ($cost as $keys => $value) :
                                echo wc_price(round($cost[$key]));
                                break;
                            endforeach;
                            ?>
                        </p>
                        <small>
                                <?php
                                $idproduct_mm=get_the_ID();
                                $terms_tag = get_the_terms ($idproduct_mm, 'product_tag' );
                                foreach ( $terms_tag as $term_tag ) {
                                     $tag_id = $term_tag->term_id;
                                     if($tag_id=='16409'){
                                         $product_packages = true;
                                     }
                                }
                                $per_person = '';
                                $mm_change_text_per_person = get_post_meta($idproduct_mm, 'mm_change_text_per_person',true);
                                $dataArray = array();
                                if (!empty($mm_change_text_per_person) && !empty(unserialize($mm_change_text_per_person))) {
                                    $dataArray = unserialize($mm_change_text_per_person);
                                    if(isset($dataArray[$key])){
                                        $per_person = $dataArray[$key];
                                    }
                                }   
                                if(!empty($per_person)){
                                    echo $per_person;
                                }
                                elseif($idproduct_mm==32265 || $idproduct_mm==32899 || $idproduct_mm==32913 || $idproduct_mm==32927 || $idproduct_mm==32947 || $idproduct_mm==32994|| $idproduct_mm==33008|| $idproduct_mm==33032|| $idproduct_mm==32960 || $idproduct_mm==194724 || $product_packages)
                                {
                                        echo "per person";
                                }
                                elseif($idproduct_mm==27974)
                                {
                                        echo "per boat";
                                }
                                elseif($idproduct_mm==360130 || $idproduct_mm==1120 || $idproduct_mm==34517 || $idproduct_mm == 101441 || $idproduct_mm==234090 || $idproduct_mm==165337 || $idproduct_mm==164794 || $idproduct_mm==239676 || $idproduct_mm==218397 || $idproduct_mm==190606 || $idproduct_mm==29453 || $idproduct_mm==476562 || $idproduct_mm==476647 || $idproduct_mm==528043)
                                {
                                        echo "per vehicle";
                                }
                                elseif($idproduct_mm==222937 || $idproduct_mm==213557 || $idproduct_mm==220560 || $idproduct_mm==28279 || $idproduct_mm==223327 || $idproduct_mm==225270 || $idproduct_mm==225286 || $idproduct_mm==220490 || $idproduct_mm==213557)
                                {
	                                echo "per group of 4";
                                }
                                elseif($idproduct_mm==28279 || $idproduct_mm==190141 || $idproduct_mm==191840 || $idproduct_mm==184379 || $idproduct_mm==217814 || $idproduct_mm==217922 || ($idproduct_mm==218317 && $key == 218387) || $idproduct_mm==200514 || $idproduct_mm==200530 || $idproduct_mm==190067 || ($idproduct_mm==359863 && ($key == 372921 || $key == 372923)) || $key == 372949 || $key == 374689 || $key == 374680 || $idproduct_mm==360050)
                                {
                                        echo "per group";
                                }elseif($idproduct_mm == 49729){
                                    echo "for the first two guests";
                                }elseif($idproduct_mm == 215905){
                                    echo "per charter (Up to 3 guests)";
                                }
                                elseif($idproduct_mm == 6665){
	                                echo "per kayak";
                                }elseif($idproduct_mm == 18101){
	                                echo "per piece";
                                }
                                elseif($idproduct_mm == 431240 || $idproduct_mm == 476436){
	                                echo "per hour";
                                }
                                else
                                {
                                        echo "per adult";
                                }
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
<?php
    $output .= ob_get_clean();
    echo $output;
    file_put_contents($json_file, json_encode($output));
}
    
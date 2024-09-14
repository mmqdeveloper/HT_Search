<?php
    use MauiMarketing\MMTF\Filtering;
    use MauiMarketing\MMTF\Core;

    $config = Core\config();

    $args = array();

    $all_child_categories;
    if (!empty($_GET['island'])) {
        $slug_island = get_term_by('slug', $_GET['island'], 'product_cat')->term_id;
        $args = array(
            'taxonomy' => 'product_cat',
            'parent' => $slug_island,
            'hide_empty' => true,
            // 'number' => $config["limit_category_filter"],
            'meta_query' => array(
                array(
                    'key' => 'mmtf_cat_is_show_search',
                    'value' => 'true',
                    'compare' => '=',
                ),
            ),
            'meta_key' => 'mmtf_search_priority',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
        );
        $all_child_categories = get_terms($args);
    } else {
        $args = array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            // 'number' => $config["limit_category_filter"],
            'meta_query' => array(
                array(
                    'key' => 'mmtf_cat_is_show_search',
                    'value' => 'true',
                    'compare' => '=',
                ),
            ),
            'meta_key' => 'mmtf_search_priority',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
        );
        $all_child_categories = get_terms($args);
    }

    $cates_slide_custom = [];

    foreach($all_child_categories as $cate_slide) {
        $cates_slide_custom[] = array(
            'id' => $cate_slide->term_id,
            'name' => $cate_slide->name,
            'slug' => $cate_slide->slug,
            'icon' => get_term_meta($cate_slide->term_id, 'mmtf_icon_search', true),
            'priority' => get_term_meta($cate_slide->term_id, 'mmtf_search_priority', true),
        );
    }

    $cates_slide_custom = Filtering\mergeCategoriesWithSameName($cates_slide_custom);

    usort($cates_slide_custom, function ($a, $b) {
        $priorityOrder = array(
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            // 'A', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6', 
            // 'B', 'B1', 'B2', 'B3', 'B4', 'B5', 'B6',
            // 'C', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6',
            // 'D', 'D1', 'D2', 'D3', 'D4', 'D5', 'D6',
        );

        $aPriority = $a['priority'];
        $bPriority = $b['priority'];

        if (empty($aPriority)) {
            return 1;
        } elseif (empty($bPriority)) {
            return -1;
        } else {
            $aIndex = array_search($aPriority, $priorityOrder);
            $bIndex = array_search($bPriority, $priorityOrder);
            return $aIndex - $bIndex;
        }
    });
?>

<div id="mmtf-cate-slide-container">
    <div id="mmtf-cate-slide-wrap">
        <?php
            foreach($cates_slide_custom as $key => $cate_slide_custom) {
                if ($key == $config["limit_category_filter"]) {
                    break;
                }
                // $have_product = true;
                // if (!empty($_GET['keyword'])) {
                //     $keyword = strtolower(sanitize_text_field($_GET["keyword"]));
                //     $args = array(
                //         'post_type'   => 'product',
                //         'posts_per_page' => 1,
                //         'tax_query'   => array(
                //             array(
                //                 'taxonomy' => 'product_cat',
                //                 'field'    => 'id',
                //                 'terms'    => $cate_slide_custom['id'],
                //             ),
                //         )
                //     );

                //     $is_category = null;

                //     if ($keyword != 'oahu' || $keyword != 'kauai' || $keyword != 'maui' || $keyword != 'big island') {
                //         $is_category = get_term_by('name', $keyword, 'product_cat');
                //     }
                    
                //     if (!empty($is_category) && $cate_slide_custom['name'] != $is_category->name) {
                //         continue;
                //     } else {
                //         $args['s'] = $keyword;
                //     }
                    
                //     $have_product = get_posts($args);
                // }
                // if ($have_product) {
                    ?>
                        <label for="mmtf-<?php echo($cate_slide_custom['id']); ?>">
                            <input type="radio" style="display: none;" id="mmtf-<?php echo($cate_slide_custom['id']); ?>" name="mmtf-cate-slide" value="<?php echo($cate_slide_custom['slug']); ?>" <?php echo($_GET['sa_category'] == $cate_slide_custom['slug'] ? 'checked' : ''); ?> />
                            <span class="mmtf-btn-uncheck"></span>
                            <img src="<?php echo($cate_slide_custom['icon'] ? $cate_slide_custom['icon'] : plugins_url('/mm-tour-filtering/images/icon-categorys/travel.png')); ?>" class="mmtf-cate-icon" />
                            <span class="mmtf-cate-slide-line"></span>
                            <span class="mmtf-cate-slide-text"><?php echo($cate_slide_custom['name']); ?></span>
                        </label>
                    <?php
                // }
                // wp_reset_postdata();
            }
        ?>
    </div>
    <button id="mmtf-prevBtn"></button>
    <button id="mmtf-nextBtn"></button>
</div>
<?php

if (!function_exists('mm_certificate_default_vp_page')) {
    function mm_certificate_default_vp_page () {
        $desired_slugs = array( 
                        'certified-sustainable',
                        'hawaii-expert',
                        'most-popular',
                        'romantic',
                        'travel-insurance-plus',
                        'tripadvisor-excellence' );

        $terms = get_terms( array(
                    'slug'    => $desired_slugs,
                    'taxonomy' => 'certificates',
                    'orderby'  => 'slug'
                ) );

        $sorted_terms = array();

        if ($terms && !is_wp_error($terms)) {
            foreach ($desired_slugs as $slug) {
                foreach ($terms as $term) {
                    if ($term->slug === $slug) {
                        $sorted_terms[] = $term;
                        break;
                    }
                }
            }
        }

        ob_start();
        if ($sorted_terms) {
            $i = 0;
            $tmp = 0;
            foreach ($sorted_terms as $term) {
                $i++;
                $tmp++;
                if ($tmp == '1') {
                    $first = 'first';
                } else
                    $first = '';

                $term_id = $term->term_id;
                $term_name = $term->name;
                $term_link = get_term_link($term->slug, 'certificates');
                $image_id = get_term_meta($term_id, 'certificate-image-id', true);
                ?>
                <div class="flex_column flex_column_table_cell av-equal-height-column av-align-middle av-zero-column-padding  <?php echo $columnClass . ' ' . $first; ?> " style="text-align:center">

                    <a href="<?php echo $term_link ?>" alt="<?php echo $term_name; ?>">
                        <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                    </a>
                    <?php
                    if ($term_id == '12998') {
                        echo do_shortcode('[wp_schema_pro_rating_shortcode]');
                    }
                    ?>
                </div>
                <?php //if ($tmp != $columns) { ?>
                <div class="av-flex-placeholder"></div>
                <?php
                //}
                if ($tmp == $columns) {
                    $tmp = 0;
                }
            }
        }
        $output_terms = ob_get_clean();
        $style="";
        if($i>0){
            $max_width_style = $i * 180;
            $style = "style='max-width:".$max_width_style."px; margin: 0 auto'";
        }
        ob_start();
        ?>
        <div class="mm_certificate_tag">
            <div class="mm_certificate_tag_inner">
                <div class="flex_column_table av-equal-height-column-flextable -flextable" <?php echo $style; ?>>
                    <?php echo $output_terms;?>
                </div>
            </div>
        </div>

        <?php
        $output = ob_get_clean();
        return $output;
    }
    add_shortcode('mm_certificate_default_vp_page', 'mm_certificate_default_vp_page');
}

// Footer VP
if (!function_exists('mm_register_custom_sidebar_footer_vp')) {
    function mm_register_custom_sidebar_footer_vp() {
        register_sidebar(array(
            'name'          => 'Section Footer VP',
            'id'            => 'section-footer-vp',
            'description'   => 'Section Footer VP',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
        register_sidebar(array(
            'name'          => 'Footer VP Column 1',
            'id'            => 'footer-vp-column-1',
            'description'   => 'Footer VP Column 1',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
        register_sidebar(array(
            'name'          => 'Footer VP Column 2',
            'id'            => 'footer-vp-column-2',
            'description'   => 'Footer VP Column 2',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
        register_sidebar(array(
            'name'          => 'Footer VP Column 3',
            'id'            => 'footer-vp-column-3',
            'description'   => 'Footer VP Column 3',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
}
add_action('widgets_init', 'mm_register_custom_sidebar_footer_vp');
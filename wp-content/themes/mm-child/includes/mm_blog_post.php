<?php

function mm_blog_post() {
    $paged = 1;
    $query_blog = new WP_Query(array(
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'post_type' => 'post',
    ));

    ob_start();

    if ($query_blog->have_posts()) :
        ?>
        <div class="content-blog">
            <?php
            while ($query_blog->have_posts()) :
                $query_blog->the_post();
                $post_id = get_the_ID();
                $cat = get_the_category();
                $category_id = $cat[0]->cat_ID;
                $name_cat = $cat[0]->name;
                $excerpt = get_the_excerpt();
                $exc = !empty($excerpt) ? avia_backend_truncate($excerpt, 150, " ") : avia_backend_truncate(get_the_content(), apply_filters('avf_postgrid_excerpt_length', 150), apply_filters('avf_postgrid_excerpt_delimiter', " "), "…", true, '');
                ?>
                <div class="blog-item left">
                    <div class="img-thumb-blog">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('large');
                            }
                            ?>	                        
                        </a>
                    </div>
                    <div class="content-post-blog">
                        <a class="link-blog" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <h3 class="title-blog"><?php the_title(); ?></h3>
                        </a>
                        <p class="content-excerpt">
                             <?php echo $exc; ?>
                        </p>
                        <div class="blog__read-more"><a class="read__more" href="<?php the_permalink(); ?>">READ MORE</a></div>
                    </div>
                </div>

                <?php
            endwhile;
            ?>
        </div>
        <?php
    endif;
    wp_reset_query();
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

add_shortcode('mm_blog_post', 'mm_blog_post');


//----------------------------------------------
add_shortcode('search_form_mm', 'mm_search_form');

function mm_search_form() {
    $url = get_site_url();
    ob_start();
    ?>
    <div class="s_mm_sidebar">
        <form role="search" method="get" id="searchform" class="searchform mm_search" action="<?php echo $url ?>">
            <input type="text" value="" name="s" id="s" placeholder="Search for..." />
        </form>
    </div>
    <?php
    wp_reset_query();
    return ob_get_clean();
}

//-------------------------------------------------
add_shortcode('toggle_tab_mm', 'toggle_tab_mm_cc');

function toggle_tab_mm_cc() {
    $args = array(
        'show_option_all' => '',
        'orderby' => 'name',
        'order' => 'ASC',
        'style' => 'list',
        'show_count' => 0,
        'hide_empty' => 1,
        'use_desc_for_title' => 1,
        'child_of' => 0,
        'feed' => '',
        'feed_type' => '',
        'feed_image' => '',
        'exclude' => '',
        'exclude_tree' => '',
        'include' => '',
        'hierarchical' => 1,
        'title_li' => __('<h4>Categories</h4>'),
        'show_option_none' => __(''),
        'number' => null,
        'echo' => 1,
        'depth' => 0,
        'current_category' => 0,
        'pad_counts' => 0,
        'taxonomy' => 'category',
        'walker' => null
    );

    ob_start();
    ?>
    <div class="blog-toggle_cat">
    <?php wp_list_categories($args); ?>
    </div>
    <?php
    wp_reset_query();
    return ob_get_clean();
}


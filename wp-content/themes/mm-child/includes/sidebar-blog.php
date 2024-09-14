<?php
add_shortcode('booking_tours_sidebar', 'booking_tours_list_sidebar');

function booking_tours_list_sidebar($atts, $content) {
    ob_start();
    extract(shortcode_atts(array(
        'limit' => '',
        'paging' => '',
        'title' => ''
                    ), $atts));

    $args = array(
        'order' => 'DESC',
        'orderby' => 'date',
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 3
    );

    $the_query = new WP_Query($args);
    $book_now = 1;
    ?>
    <div id="mm_list_tour_red"> 
        <h4 class="title_tours"><?php echo $title; ?></h4>
        <?php
        while ($the_query->have_posts()) : $the_query->the_post();

            $post_id = get_the_ID();
            
            ?>
            <div class="book_sidebar"> 
                <div class="item_booking booking_<?php echo $post_id; ?>">
                    <div class="bt_booking_sidebar">
                        <div class="booking_sidebar_content">
                            <div class="view">
                                <?php
                                $url = wp_get_attachment_url(get_post_thumbnail_id($post_id));
                                echo '<img class="img_booking" src="' . $url . '" />';
                                ?>
                                <div class="title_booking"><?php echo get_the_title(); ?></div>                                
                                <div class="warrap_bt">
                                    <div class="bt_detail_sidebar"><a href="<?php echo the_permalink(); ?>" class="btn_detail_sidebar">READ MORE</a></div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
// end of the loop.  
        ?>
    </div>
    <script>
        jQuery(document).ready(function () {
            jQuery('.btn_book').click(function () {
                var post_id = jQuery(this).attr('data');
                jQuery('.booking_' + post_id + ' .bt_booking_sidebar').hide();
                jQuery('.booking_' + post_id + ' .item_form_booking').show();
            });
        });
    </script>
    <?php
    wp_reset_query();
    return ob_get_clean();
}

add_shortcode('toggle_popular_mm', 'toggle_popular_mm_cc');

function toggle_popular_mm_cc() {
    ob_start();
    ?>
    <div class="blog-toggle_popular">
        <h4>Most popular</h4>
        <ul>
            <?php
            global $post;
            $args = array('posts_per_page' => -1, 'offset' => 1, 'category' => 0);

            $myposts = get_posts($args);
            foreach ($myposts as $post) : setup_postdata($post);
                ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
            <?php endforeach;
            wp_reset_postdata();
            ?>

        </ul>
    </div>
    <?php
    wp_reset_query();
    return ob_get_clean();
}

<?php
if (!defined('ABSPATH')) {
    exit;
}    // Exit if accessed directly


global $avia_config;
$image_size = !empty($avia_config['image_size']) ? $avia_config['image_size'] : 'portfolio';
if (have_posts()) :
    $post_loop_count = 1;
    while (have_posts()) : the_post();
        $the_id = get_the_ID();
        $title = get_the_title($the_id);
        $parity = $post_loop_count % 2 ? 'odd' : 'even';
        $post_class = 'post-entry-' . $the_id . ' post-loop-' . $post_loop_count . ' post-parity-' . $parity . ' ';
        $thumbnail = get_the_post_thumbnail($the_id, $image_size);
        $link = get_permalink($the_id);
        $mm_address = get_post_meta($the_id, 'mm-address', true);
        $mm_phone = get_post_meta($the_id, 'mm-phone', true);
        $mm_email = get_post_meta($the_id, 'mm-email', true);
        $mm_facebook = get_post_meta($the_id, 'mm-facebook', true);
        $mm_instagram = get_post_meta($the_id, 'mm-instagram', true);
        $mm_twitter = get_post_meta($the_id, 'mm-twitter', true);
        $mm_tripadvisor = get_post_meta($the_id, 'mm-tripadvisor', true);
        $mm_yelp = get_post_meta($the_id, 'mm-yelp', true);
        $term_island_list = get_the_terms($the_id, 'restaurant_island');
        ?>
        <article class='mm-restaurant-item <?php echo implode(' ', get_post_class('post-entry post-entry-type-standard ' . $post_class . ' ' . $with_slider)); ?>' <?php echo avia_markup_helper(array('context' => 'entry', 'echo' => false)); ?> >
            <div class='item-restaurant-image'>
                <a href='<?php echo $link; ?>' title='<?php echo $title; ?>'><?php echo $thumbnail; ?></a>
                <?php if (!empty($term_island_list)) {
                    $show_vp_tag = false;
                    echo '<ul class="restaurant_island">';
                    foreach ( $term_island_list as $island ) {
                        if(mm_convert_title_to_slug($island->name)!='vacation-packages'){
                            echo '<li class="item_island '.mm_convert_title_to_slug($island->name).'">'.$island->name.'</li>';
                        }else{
                            $show_vp_tag = true;
                        }
                    }
                    echo '</ul>';
                    if($show_vp_tag){
                        echo '<ul class="restaurant_island_vp">';
                        echo '<li class="item_island vacation-packages">VACATION PACKAGES</li>';
                        echo '</ul>';
                    }
                }
                ?>
            </div>
            <div class='item-restaurant-content'>
                <h3><a href='<?php echo $link; ?>' title='<?php echo $title; ?>'><?php echo $title; ?></a></h3>
                <div class="restaurant-contact">
                    <?php if (!empty($mm_address)) { ?>
                        <div class="address"><span class="icon"></span> <?php echo $mm_address; ?></div>
                    <?php } ?>
                    <?php if (!empty($mm_phone)) { ?>
                        <div class="phone"><span class="icon"></span> <a href="tel:<?php echo $mm_phone; ?>"><?php echo $mm_phone; ?></a></div>
                    <?php } ?>
                    <?php if (!empty($mm_email)) { ?>
                        <div class="email"><span class="icon"></span> <a href="mailto:<?php echo $mm_email; ?>"><?php echo $mm_email; ?></a></div>
                    <?php } ?>
                </div>
                <div class="restaurant-description">
        <?php echo the_excerpt(); ?>
                </div>
                <div class="restaurant-social-contact">
                    <?php if (!empty($mm_facebook)) { ?>
                        <a class="facebook-icon" title="Facebook" href="<?php echo $mm_facebook; ?>" target="_blank" rel="nofollow"></a>
                    <?php } ?>
                    <?php if (!empty($mm_instagram)) { ?>
                        <a class="instagram-icon" title="Instagram" href="<?php echo $mm_instagram; ?>" target="_blank" rel="nofollow"></a>
                    <?php } ?>
                    <?php if (!empty($mm_twitter)) { ?>
                        <a class="twitter-icon" title="Twitter" href="<?php echo $mm_twitter; ?>" target="_blank" rel="nofollow"></a>
                    <?php } ?>
                    <?php if (!empty($mm_tripadvisor)) { ?>
                        <a class="tripadvisor-icon" title="TripAdvisor" href="<?php echo $mm_tripadvisor; ?>" target="_blank" rel="nofollow"></a>
                    <?php } ?>
                    <?php if (!empty($mm_yelp)) { ?>
                        <a class="yelp-icon" title="Yelp" href="<?php echo $mm_yelp; ?>" target="_blank" rel="nofollow"></a>
                    <?php } ?>
                </div>
                <a href='<?php echo $link; ?>' title='<?php echo $title; ?>' class="learn_more_btn">LEARN MORE</a>
            </div>
        </article>
        <?php
        $post_loop_count++;
    endwhile;
                endif;
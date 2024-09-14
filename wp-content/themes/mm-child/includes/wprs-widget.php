<?php
/*
  WARNING: This file is part of the core WPRichSnippets plugin. DO NOT edit
  this file under any circumstances.
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function WPRS_Widget_Register_User() {
    register_widget('WPRS_Widget_User');
}

add_action('widgets_init', 'WPRS_Widget_Register_User');

class WPRS_Widget_User extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_wprs_user', 'description' => __('Display latest Rich Snippets posts with thumbnails', 'wprs'));
        parent::__construct('wprs-widget-user', __('User Rich Snippets Entries', 'wprs'), $widget_ops);
        $this->alt_option_name = 'widget_wprs_user';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance) {

        global $wprs_prefix;
    
        $cache = wp_cache_get('wprs_widget_posts_user', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args); 

        $title = (!empty($instance['title']) ) ? $instance['title'] : __('Recent Reviews', 'wprs');
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $number = (!empty($instance['number']) ) ? absint($instance['number']) : 5;
        $order = ( isset($instance['order']) ) ? 'meta_value_num' : 'date';
        $cat = ( isset($instance['cat']) ) ? $instance['cat'] : '';
        $ptype = ( isset($instance['ptype']) ) ? $instance['ptype'] : 'post';

        // set cat based on category page
        if (isset($instance['cat_check']) && is_category()) {
            $catName = single_cat_title("", false);
            $catID = get_cat_ID($catName);
            $cat = $catID;
        }
        $count = 0;

        $r = new WP_Query(array(
            'post_type' => $ptype,
            'posts_per_page' => $number,
            'no_found_rows' => true,
            'cat' => $cat,
            'post_status' => 'publish',
            'meta_key' => $wprs_prefix . 'user_rating',
            'ignore_sticky_posts' => true,
            'orderby' => $order,
            'order' => 'DESC',
        ));
        //wp_mail('jobnavajo@gmail.com', 'Test DBx QR', $r->request);

        if ($r->have_posts()) :
            ?>
            <?php echo $before_widget; ?>
            <?php if ($title) echo $before_title . $title . $after_title; ?>



            <?php while ($r->have_posts()) : $r->the_post(); ?>

                <?php
                $count = $count + 1;
                // get post id
                $postid = get_the_ID();
                // get custom vaules
                $custom = get_post_custom();

                if (wprs_is_enabled($postid)) {


                    if ((isset($custom[$wprs_prefix . 'item_name'][0]))) {
                        $rating_name = $custom[$wprs_prefix . 'item_name'][0];
                    } else {
                        $rating_name = '';
                    } // get title

                    if ((isset($custom[$wprs_prefix . 'item_description'][0]))) {
                        $review_summary = $custom[$wprs_prefix . 'item_description'][0];
                    } else {
                        $review_summary = '';
                    } // get review summary, @since 1.0.0
                    // author rating
                    $rating = $custom[$wprs_prefix . 'user_rating'][0]; // get rating
                    $rating_star = $rating * 20; // calculate rating
                    $rating_display = str_replace('.', '', $rating);
                    $show_rating = '<span class="sr-only">' . __('Rated', 'wprs') . ' ' . $rating . ' ' . __('stars', 'wprs') . '</span>';
                    $show_rating .= '<span class="rating r-' . $rating_display . '" title="' . __('Rated', 'wprs') . ': ' . $rating . '"></span>';

                    // get permalink and title
                    $permalink = get_permalink();
                    $title = esc_attr(get_the_title() ? get_the_title() : get_the_ID());

                    // start display item
                    echo '<div class="wprs_container">';
                    echo '<div class="row">';
                    echo '<div class="widget_review_item_img">';


                    if ($instance['screenshot']) {
                        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
                        $image = wprs_review_media_extend($postid, 320, 180);
                        echo $image;
                        echo '</div>';

                        echo '<div class="col-xs-6 col-sm-6 col-md-6">';
                        echo '<p>';
                        echo '<a href="' . $permalink . '" title="' . $title . '">';
                        if ($rating_name)
                            echo $rating_name;
                        else
                            echo get_the_ID(); echo '</a>';
                        echo '<br>';
                        echo $show_rating;
                        echo '</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="col-xs-12 col-sm-12 col-md-12">';
                        echo '<p>';
                        echo '<a href="' . $permalink . '" title="' . $title . '">';
                        if ($rating_name)
                            echo $rating_name;
                        else
                            echo get_the_ID(); echo '</a>';
                        echo '<br>';
                        echo $show_rating;
                        echo '</p>';
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    // end display item  
                    // summary
                    if (isset($instance['summary'])) {
                        echo '<div class="widget_review_item_img">';
                        echo '<p>' . $review_summary . '</p>';
                        echo '</div>';
                    }
                    // end display review summary   
                }
            endwhile;
            //wp_mail('jobnavajo@gmail.com', 'Test', $count);
            // display after widget
            echo $after_widget;

            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('wprs_widget_posts_user', $cache, 'widget');
    }

    function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['ptype'] = strip_tags($new_instance['ptype']);
        $instance['cat'] = strip_tags($new_instance['cat']);
        $instance['cat_check'] = $new_instance['cat_check'];
        $instance['number'] = (int) $new_instance['number'];
        $instance['screenshot'] = $new_instance['screenshot'];
        $instance['summary'] = $new_instance['summary'];
        $instance['order'] = $new_instance['order'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_recent_entries']))
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {

        wp_cache_delete('wprs_widget_posts_user', 'widget');
    }

    function form($instance) {

        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $ptype = isset($instance['ptype']) ? esc_attr($instance['ptype']) : 'post';
        $cat = isset($instance['cat']) ? esc_attr($instance['cat']) : '';
        $cat_check = isset($instance['cat_check']) ? (bool) $instance['cat_check'] : false;
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $screenshot = isset($instance['screenshot']) ? (bool) $instance['screenshot'] : false;
        $summary = isset($instance['summary']) ? (bool) $instance['summary'] : false;
        $order = isset($instance['order']) ? (bool) $instance['order'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wprs') . ':'; ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
                    <?php // add cpt list @since 1.0.0  ?>
            <label for="<?php echo $this->get_field_id('ptype'); ?>"><select id="<?php echo $this->get_field_id('ptype'); ?>" name="<?php echo $this->get_field_name('ptype'); ?>" >
                    <option value=""> - <?php echo __('Select Post Type', 'wprs'); ?> - </option>
        <?php
        // get custom post types
        $post_types = wprs_get_post_types();
        if (!empty($post_types)) {
            foreach ((array) $post_types as $post_type) {
                ?>
                            <option value="<?php echo $post_type; ?>" <?php if (isset($instance['ptype']) && $instance['ptype'] == $post_type) {
                    echo 'selected="selected"';
                } ?>><?php echo $post_type; ?></option>
            <?php }
        } ?>
                </select></label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"></label>
        <?php wp_dropdown_categories(array('name' => $this->get_field_name('cat'), 'show_option_all' => '- ' . __('All categories', 'wprs') . ' -', 'hide_empty' => 1, 'hierarchical' => 1, 'selected' => $cat)); ?>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('cat_check'); ?>"><?php _e('Category based?', 'wprs'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked($cat_check); ?> id="<?php echo $this->get_field_id('cat_check'); ?>" name="<?php echo $this->get_field_name('cat_check'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of entries to show', 'wprs') . ':'; ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
        </p>


        <p>
            <label for="<?php echo $this->get_field_id('screenshot'); ?>"><?php _e('Display Screenshot?', 'wprs'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked($screenshot); ?> id="<?php echo $this->get_field_id('screenshot'); ?>" name="<?php echo $this->get_field_name('screenshot'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('summary'); ?>"><?php _e('Display summary?', 'wprs'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked($summary); ?> id="<?php echo $this->get_field_id('summary'); ?>" name="<?php echo $this->get_field_name('summary'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order by best rating?', 'wprs'); ?></label>
            <input type="checkbox" class="checkbox" <?php checked($order); ?> id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" />
        </p>

        <?php
    }

}

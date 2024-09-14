<?php

if (!function_exists('mmt_restaurant_post_type')) {

    function mmt_restaurant_post_type() {
        $labels = array(
            'name' => esc_html__('Restaurant', 'hawaii'),
            'singular_name' => esc_html__('Restaurant', 'hawaii'),
            'all_items' => esc_html__('All Restaurant', 'hawaii'),
            'add_new' => esc_html__('Add New', 'hawaii'),
            'add_new_item' => esc_html__('Add New Restaurant', 'hawaii'),
            'edit_item' => esc_html__('Edit Restaurant', 'hawaii'),
            'new_item' => esc_html__('New Restaurant', 'hawaii'),
            'view_item' => esc_html__('View Restaurant', 'hawaii'),
            'search_items' => esc_html__('Search Restaurant', 'hawaii'),
            'not_found' => esc_html__('No Restaurant found', 'hawaii'),
            'not_found_in_trash' => esc_html__('No Restaurant found in Trash', 'hawaii'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'menu_icon' => 'dashicons-admin-multisite',
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'rewrite' => array('slug' => 'restaurants', 'with_front' => true),
            'supports' => array('title', 'editor','excerpt', 'thumbnail','author'),
        );

        register_post_type('restaurant', $args);
    }

    add_action('init', 'mmt_restaurant_post_type', 10, 3);
}

if (!function_exists('mm_add_columns_restaurant_tags')) {
	function mm_add_columns_restaurant_tags($columns) {
		$columns['restaurant_tags'] = 'Tags';
		return $columns;
	}
	add_filter('manage_restaurant_posts_columns', 'mm_add_columns_restaurant_tags');
}

if (!function_exists('mm_show_restaurant_tag_in_columns')) {
	function mm_show_restaurant_tag_in_columns($column, $post_id) {
		if ($column === 'restaurant_tags') {
			$terms = get_the_terms($post_id, 'restaurant_tags');
			if ($terms && !is_wp_error($terms)) {
				$tag_links = array();
				foreach ($terms as $term) {
					$tag_links[] = '<a href="'.admin_url('edit.php?restaurant_tags='.$term->slug).'&post_type=restaurant">'.$term->name.'</a>';
				}
				echo implode(', ', $tag_links);
			} else {
				echo '<p style="white-space:nowrap;">No tags</p>';
			}
		}
	}
	add_action('manage_restaurant_posts_custom_column', 'mm_show_restaurant_tag_in_columns', 10, 2);
}

if (!function_exists('mm_add_columns_restaurants_badges')) {
	function mm_add_columns_restaurants_badges($columns) {
		$columns['restaurant_badges'] = 'Badges';
		return $columns;
	}
	add_filter('manage_restaurant_posts_columns', 'mm_add_columns_restaurants_badges');
}

if (!function_exists('mm_show_restaurant_badges_in_columns')) {
	function mm_show_restaurant_badges_in_columns($column, $post_id) {
		if ($column === 'restaurant_badges') {
			$terms = get_the_terms($post_id, 'restaurant_badges');
			if ($terms && !is_wp_error($terms)) {
				$tag_links = array();
				foreach ($terms as $term) {
					$tag_links[] = '<a href="'.admin_url('edit.php?restaurant_badges='.$term->slug).'&post_type=restaurant">'.$term->name.'</a>';
				}
				echo implode(', ', $tag_links);
			} else {
				echo '<p style="white-space:nowrap;">No badges</p>';
			}
		}
	}
	add_action('manage_restaurant_posts_custom_column', 'mm_show_restaurant_badges_in_columns', 10, 2);
}

if (!function_exists('mm_filter_tags_restaurant')) {
	function mm_filter_tags_restaurant() {
		global $typenow;
		if ($typenow == 'restaurant') {
			$taxonomy = 'restaurant_tags';
			$terms = get_terms($taxonomy);
			if ($terms) {
				echo "<select name='$taxonomy' id='$taxonomy' class='postform'>";
				echo "<option value=''>Show All Tags</option>";
				foreach ($terms as $term) {
					echo '<option value=' . $term->slug, $_GET[$taxonomy] == $term->slug ? ' selected="selected"' : '', '>' . $term->name . '</option>';
				}
				echo "</select>";
			}
		}
	}
	add_action('restrict_manage_posts', 'mm_filter_tags_restaurant');
}

if (!function_exists('mm_filter_badges_restaurant')) {
	function mm_filter_badges_restaurant() {
		global $typenow;
		if ($typenow == 'restaurant') {
			$taxonomy = 'restaurant_badges';
			$terms = get_terms($taxonomy);
			if ($terms) {
				echo "<select name='$taxonomy' id='$taxonomy' class='postform'>";
				echo "<option value=''>Show All badges</option>";
				foreach ($terms as $term) {
					echo '<option value=' . $term->slug, $_GET[$taxonomy] == $term->slug ? ' selected="selected"' : '', '>' . $term->name . '</option>';
				}
				echo "</select>";
			}
		}
	}
	add_action('restrict_manage_posts', 'mm_filter_badges_restaurant');
}

if (!function_exists('mm_sort_restaurant_category_fomart_parent_child')) {
	function mm_sort_restaurant_category_fomart_parent_child($args, $post_id = null) {
		if ($post_id && get_post_type($post_id) == 'restaurant') {
			if (!empty($args['taxonomy']) && $args['taxonomy'] == 'restaurant_categories') {
				$args['checked_ontop'] = false;
			}
		}
		return $args;
	}
	add_filter('wp_terms_checklist_args', 'mm_sort_restaurant_category_fomart_parent_child', 10, 2);
}
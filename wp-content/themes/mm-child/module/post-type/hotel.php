<?php

if ( ! function_exists( 'mmt_hotel_post_type' ) ) {
	
	function mmt_hotel_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Hotel', 'hawaii' ),
			'singular_name'      => esc_html__( 'Hotel', 'hawaii' ),
			'all_items'          => esc_html__( 'All Hotel', 'hawaii' ),
			'add_new'            => esc_html__( 'Add New', 'hawaii' ),
			'add_new_item'       => esc_html__( 'Add New Hotel', 'hawaii' ),
			'edit_item'          => esc_html__( 'Edit Hotel', 'hawaii' ),
			'new_item'           => esc_html__( 'New Hotel', 'hawaii' ),
			'view_item'          => esc_html__( 'View Hotel', 'hawaii' ),
			'search_items'       => esc_html__( 'Search Hotel', 'hawaii' ),
			'not_found'          => esc_html__( 'No Hotel found', 'hawaii' ),
			'not_found_in_trash' => esc_html__( 'No Hotel found in Trash', 'hawaii' ),
			'parent_item_colon'  => ''
		);
		
		$args = array(
			'labels'             => $labels,
			'menu_icon'          => 'dashicons-admin-multisite',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => false,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'menu_position'      => null,
			'rewrite'            => array( 'slug' => 'hotels', 'with_front' => true ),
			'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
		);
		
		register_post_type( 'hotel', $args );
	}
	
	add_action( 'init', 'mmt_hotel_post_type', 10, 3 );
}

if (!function_exists('mm_add_columns_hotels_tags')) {
	function mm_add_columns_hotels_tags($columns) {
		$columns['hotel_tags'] = 'Tags';
		return $columns;
	}
	add_filter('manage_hotel_posts_columns', 'mm_add_columns_hotels_tags');
}

if (!function_exists('mm_show_hotel_tag_in_columns')) {
	function mm_show_hotel_tag_in_columns($column, $post_id) {
		if ($column === 'hotel_tags') {
			$terms = get_the_terms($post_id, 'hotel_tags');
			if ($terms && !is_wp_error($terms)) {
				$tag_links = array();
				foreach ($terms as $term) {
					$tag_links[] = '<a target="_blank" href="'.admin_url('edit.php?hotel_tags='.$term->slug).'&post_type=hotel">'.$term->name.'</a>';
				}
				echo implode(', ', $tag_links);
			} else {
				echo '<p style="white-space:nowrap;">No tags</p>';
			}
		}
	}
	add_action('manage_hotel_posts_custom_column', 'mm_show_hotel_tag_in_columns', 10, 2);
}

if (!function_exists('mm_add_columns_hotels_badges')) {
	function mm_add_columns_hotels_badges($columns) {
		$columns['hotel_badges'] = 'Badges';
		return $columns;
	}
	add_filter('manage_hotel_posts_columns', 'mm_add_columns_hotels_badges');
}

if (!function_exists('mm_show_hotel_badges_in_columns')) {
	function mm_show_hotel_badges_in_columns($column, $post_id) {
		if ($column === 'hotel_badges') {
			$terms = get_the_terms($post_id, 'hotel_badges');
			if ($terms && !is_wp_error($terms)) {
				$tag_links = array();
				foreach ($terms as $term) {
					$tag_links[] = '<a target="_blank" href="'.admin_url('edit.php?hotel_badges='.$term->slug).'&post_type=hotel">'.$term->name.'</a>';
				}
				echo implode(', ', $tag_links);
			} else {
				echo '<p style="white-space:nowrap;">No badges</p>';
			}
		}
	}
	add_action('manage_hotel_posts_custom_column', 'mm_show_hotel_badges_in_columns', 10, 2);
}

if (!function_exists('mm_filter_tags_hotel')) {
	function mm_filter_tags_hotel() {
		global $typenow;
		if ($typenow == 'hotel') {
			$taxonomy = 'hotel_tags';
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
	add_action('restrict_manage_posts', 'mm_filter_tags_hotel');
}

if (!function_exists('mm_filter_badges_hotel')) {
	function mm_filter_badges_hotel() {
		global $typenow;
		if ($typenow == 'hotel') {
			$taxonomy = 'hotel_badges';
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
	add_action('restrict_manage_posts', 'mm_filter_badges_hotel');
}

if (!function_exists('mm_sort_hotel_category_fomart_parent_child')) {
	function mm_sort_hotel_category_fomart_parent_child($args, $post_id = null) {
		if ($post_id && get_post_type($post_id) == 'hotel') {
			if (!empty($args['taxonomy']) && $args['taxonomy'] == 'hotel_categories') {
				$args['checked_ontop'] = false;
			}
		}
		return $args;
	}
	add_filter('wp_terms_checklist_args', 'mm_sort_hotel_category_fomart_parent_child', 10, 2);
}
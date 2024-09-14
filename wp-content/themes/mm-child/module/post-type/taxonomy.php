<?php

add_action('init', 'mm_restaurant_taxonomies');
if (!function_exists('mm_restaurant_taxonomies')) {

    function mm_restaurant_taxonomies() { // We want to be able to sort our plugin items by our terms and keep them seperate from pages/posts.
        register_taxonomy('restaurant_island', array('restaurant'), array(
            'labels' => array(
                'name' => _x('Island', 'taxonomy general name'),
                'singular_name' => 'Island',
                'search_items' => 'Search Island',
                'popular_items' => 'Popular Island',
                'all_items' => 'All Island',
                'parent_item' => __('Parent Island'),
                'parent_item_colon' => __('Parent Island:'),
                'edit_item' => __('Edit Island'),
                'update_item' => __('Update Island'),
                'add_new_item' => __('Add New Island'),
                'new_item_name' => __('New Island'),
                'separate_items_with_commas' => __('Separate Island with commas'),
                'add_or_remove_items' => __('Add or Remove Island'),
                'choose_from_most_used' => __('Choose from the most used Island'),
                'menu_name' => __('Island'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'restaurant_island'),
            'public' => false
                )
        );
        register_taxonomy('restaurant_categories', array('restaurant'), array(
            'labels' => array(
                'name' => _x('Categories', 'taxonomy general name'),
                'singular_name' => 'Categories',
                'search_items' => 'Search Categories',
                'popular_items' => 'Popular Categories',
                'all_items' => 'All Categories',
                'parent_item' => __('Parent Categories'),
                'parent_item_colon' => __('Parent Categories:'),
                'edit_item' => __('Edit Categories'),
                'update_item' => __('Update Categories'),
                'add_new_item' => __('Add New Categories'),
                'new_item_name' => __('New Categories'),
                'separate_items_with_commas' => __('Separate Categories with commas'),
                'add_or_remove_items' => __('Add or Remove Categories'),
                'choose_from_most_used' => __('Choose from the most used Categories'),
                'menu_name' => __('Categories'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'restaurant_categories'),
            'public' => false
                )
        );
        register_taxonomy('restaurant_tags', array('restaurant'), array(
            'labels' => array(
                'name' => _x('Tags', 'taxonomy general name'),
                'singular_name' => 'Tags',
                'search_items' => 'Search Tags',
                'popular_items' => 'Popular Tags',
                'all_items' => 'All Tags',
                'parent_item' => __('Parent Tags'),
                'parent_item_colon' => __('Parent Tags:'),
                'edit_item' => __('Edit Tags'),
                'update_item' => __('Update Tags'),
                'add_new_item' => __('Add New Tags'),
                'new_item_name' => __('New Tags'),
                'separate_items_with_commas' => __('Separate Tags with commas'),
                'add_or_remove_items' => __('Add or Remove Tags'),
                'choose_from_most_used' => __('Choose from the most used Tags'),
                'menu_name' => __('Tags'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'restaurant_tags'),
            'public' => false
            )
        );
        register_taxonomy('restaurant_badges', array('restaurant'), array(
            'labels' => array(
                'name' => _x('Badges', 'taxonomy general name'),
                'singular_name' => 'Badges',
                'search_items' => 'Search Badges',
                'popular_items' => 'Popular Badges',
                'all_items' => 'All Badges',
                'parent_item' => __('Parent Badges'),
                'parent_item_colon' => __('Parent Badges:'),
                'edit_item' => __('Edit Badges'),
                'update_item' => __('Update Badges'),
                'add_new_item' => __('Add New Badges'),
                'new_item_name' => __('New Badges'),
                'separate_items_with_commas' => __('Separate Badges with commas'),
                'add_or_remove_items' => __('Add or Remove Badges'),
                'choose_from_most_used' => __('Choose from the most used Badges'),
                'menu_name' => __('Badges'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'restaurant_badges'),
            'public' => false
            )
        );
    }

}


add_action('init', 'mm_hotel_taxonomies');
if (!function_exists('mm_hotel_taxonomies')) {

    function mm_hotel_taxonomies() { 
        register_taxonomy('hotel_island', array('hotel'), array(
            'labels' => array(
                'name' => _x('Island', 'taxonomy general name'),
                'singular_name' => 'Island',
                'search_items' => 'Search Island',
                'popular_items' => 'Popular Island',
                'all_items' => 'All Island',
                'parent_item' => __('Parent Island'),
                'parent_item_colon' => __('Parent Island:'),
                'edit_item' => __('Edit Island'),
                'update_item' => __('Update Island'),
                'add_new_item' => __('Add New Island'),
                'new_item_name' => __('New Island'),
                'separate_items_with_commas' => __('Separate Island with commas'),
                'add_or_remove_items' => __('Add or Remove Island'),
                'choose_from_most_used' => __('Choose from the most used Island'),
                'menu_name' => __('Island'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'hotel_island'),
            'public' => false
                )
        );
        register_taxonomy('hotel_categories', array('hotel'), array(
            'labels' => array(
                'name' => _x('Categories', 'taxonomy general name'),
                'singular_name' => 'Categories',
                'search_items' => 'Search Categories',
                'popular_items' => 'Popular Categories',
                'all_items' => 'All Categories',
                'parent_item' => __('Parent Categories'),
                'parent_item_colon' => __('Parent Categories:'),
                'edit_item' => __('Edit Categories'),
                'update_item' => __('Update Categories'),
                'add_new_item' => __('Add New Categories'),
                'new_item_name' => __('New Categories'),
                'separate_items_with_commas' => __('Separate Categories with commas'),
                'add_or_remove_items' => __('Add or Remove Categories'),
                'choose_from_most_used' => __('Choose from the most used Categories'),
                'menu_name' => __('Categories'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'hotel_categories'),
            'public' => false
                )
        );
        register_taxonomy('hotel_tags', array('hotel'), array(
            'labels' => array(
                'name' => _x('Tags', 'taxonomy general name'),
                'singular_name' => 'Tags',
                'search_items' => 'Search Tags',
                'popular_items' => 'Popular Tags',
                'all_items' => 'All Tags',
                'parent_item' => __('Parent Tags'),
                'parent_item_colon' => __('Parent Tags:'),
                'edit_item' => __('Edit Tags'),
                'update_item' => __('Update Tags'),
                'add_new_item' => __('Add New Tags'),
                'new_item_name' => __('New Tags'),
                'separate_items_with_commas' => __('Separate Tags with commas'),
                'add_or_remove_items' => __('Add or Remove Tags'),
                'choose_from_most_used' => __('Choose from the most used Tags'),
                'menu_name' => __('Tags'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'hotel_tags'),
            'public' => false
            )
        );
        register_taxonomy('hotel_badges', array('hotel'), array(
            'labels' => array(
                'name' => _x('Badges', 'taxonomy general name'),
                'singular_name' => 'Badges',
                'search_items' => 'Search Badges',
                'popular_items' => 'Popular Badges',
                'all_items' => 'All Badges',
                'parent_item' => __('Parent Badges'),
                'parent_item_colon' => __('Parent Badges:'),
                'edit_item' => __('Edit Badges'),
                'update_item' => __('Update Badges'),
                'add_new_item' => __('Add New Badges'),
                'new_item_name' => __('New Badges'),
                'separate_items_with_commas' => __('Separate Badges with commas'),
                'add_or_remove_items' => __('Add or Remove Badges'),
                'choose_from_most_used' => __('Choose from the most used Badges'),
                'menu_name' => __('Badges'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'hotel_badges'),
            'public' => false
            )
        );
    }

}

add_action('init', 'mm_cruise_taxonomies');
if (!function_exists('mm_cruise_taxonomies')) {

    function mm_cruise_taxonomies() {
        register_taxonomy('cruise_ship_operator', array('cruise'), array(
                'labels' => array(
                    'name' => _x('Operator', 'taxonomy general name'),
                    'singular_name' => 'Operator',
                    'search_items' => 'Search Operator',
                    'popular_items' => 'Popular Operator',
                    'all_items' => 'All Operator',
                    'parent_item' => __('Parent Operator'),
                    'parent_item_colon' => __('Parent Operator:'),
                    'edit_item' => __('Edit Operator'),
                    'update_item' => __('Update Operator'),
                    'add_new_item' => __('Add New Operator'),
                    'new_item_name' => __('New Operator'),
                    'separate_items_with_commas' => __('Separate Operator with commas'),
                    'add_or_remove_items' => __('Add or Remove Operator'),
                    'choose_from_most_used' => __('Choose from the most used Operator'),
                    'menu_name' => __('Operator'),
                ),
                'hierarchical' => true,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'cruise_ship_operator'),
                'public' => false
            )
        );
    }

}
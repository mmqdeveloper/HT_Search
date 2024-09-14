<?php
/**
 * Sidebar
 * Displays one of the registered Widget Areas of the theme
 */

if (!function_exists('mm_blogs_custom_pagination')) {
    function mm_blogs_custom_pagination($total_posts, $posts_per_page, $current_page) {
        if ($total_posts <= $posts_per_page) {
            return '';
        }

        $total_pages = ceil($total_posts / $posts_per_page);

        $output = '';        

        $output .= '<div class="mm-blogs-pagination-links">';

        if ($current_page > 1) {
            $output .= '<span data-number="'.$posts_per_page.'" data-paged="' . ($current_page - 1) . '" class="mm-blogs-pagination-num mm-blogs-pagination-prev">«</span>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            $class = ($current_page == $i) ? 'mm-blogs-pagination-current' : '';
            $output .= '<span data-number="'.$posts_per_page.'" data-paged="' . $i . '" class="mm-blogs-pagination-num ' . $class . '">' . $i . '</span>';
        }

        if ($current_page < $total_pages) {
            $output .= '<span data-number="'.$posts_per_page.'" data-paged="' . ($current_page + 1) . '" class="mm-blogs-pagination-num mm-blogs-pagination-next">»</span>';
        }

        $output .= '</div>';

        return $output;

    }
}

if ( !class_exists( 'avia_sc_blog_filter' ) )
{
	class mm_avia_sc_blog_filter extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']		= __('MM Blog Posts Filter', 'avia_framework' );
				$this->config['tab']		= __('Maui Marketing Elements', 'avia_framework' );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-blog.png";
				$this->config['order']		= 40;
				$this->config['target']		= 'mm-avia-target-insert';
				$this->config['shortcode'] 	= 'mm_av_blog_filter';
				$this->config['tooltip'] 	= __('Displays Posts from your Blog', 'avia_framework' );
			} 

			/**
			 * Popup Elements
			 *
			 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
			 * opens a modal window that allows to edit the element properties
			 *
			 * @return void
			 */
			function popup_elements()
			{

				$this->elements = array(
					array(
						"name" 	=> __("Post Number", 'avia_framework' ),
						"desc" 	=> __("How many items should be displayed per page?", 'avia_framework' ),
						"id" 	=> "items",
						"type" 	=> "select",
						"std" 	=> "6",
						"subtype" => AviaHtmlHelper::number_array(1,100,1, array('All'=>'-1'))),

                    array(
                        "name" 	=> __("Pagination", 'avia_framework' ),
                        "desc" 	=> __("Pagination of blogs", 'avia_framework' ),
                        "id" 	=> "pagination",
                        "type" 	=> "select",
                        "std" 	=> "0",
                        "subtype" => array(
							__("Yes", 'avia_framework' ) => 'yes',
							__("No", 'avia_framework' ) => 'no'
						),
					)
				);
			}

			/**
			 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
			 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
			 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
			 *
			 *
			 * @param array $params this array holds the default values for $content and $args.
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_element($params)
			{
				$params['innerHtml'] = "<img src='".$this->config['icon']."' title='".$this->config['name']."' />";
				$params['innerHtml'].= "<div class='avia-element-label'>".$this->config['name']."</div>";
				$params['content'] 	 = NULL; //remove to allow content elements

				return $params;
			}

			/**
			 * Frontend Shortcode Handler
			 *
			 * @param array $atts array of attributes
			 * @param string $content text within enclosing form of shortcode element
			 * @param string $shortcodename the shortcode found, when == callback name
			 * @return string $output returns the modified html string
			 */
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
			{
				global $avia_config, $more;
				$atts = shortcode_atts(array('items' 		=> '6',
			                                 'pagination' 	=> 'yes'
			                                 ), $atts, $this->config['shortcode']);
				ob_start();
				?>
                    <div class="blogs-page-filtering">
                        <div class="blogs-page-filtering-wrap">
                            <div class="blogs-page-filtering-list">
                                <div class="blogs-page-filtering-list-inner">
                                    <?php
                                        $custom_query = new WP_Query(array(
                                                'post_type' => 'post',
                                                'post_status' => 'publish',
                                                'posts_per_page' => $atts['items'],
                                                'orderby' => 'post_date',
                                                'order' => 'DESC'
                                            ));
                                        if ($custom_query->have_posts()) {
                                            while ($custom_query->have_posts()) : $custom_query->the_post();
                                                ?>
                                                    <div class="blogs-page-filtering-list-item">
                                                        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" alt="<?php the_title(); ?>"></a>
                                                        <div class="blogs-page-filtering-list-item-content">
                                                            <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                                            <a href="<?php the_permalink(); ?>"><p><?php echo get_the_excerpt(); ?></p></a>
                                                            <a class="btn-blogs-view-detail" href="<?php the_permalink(); ?>">View details &rarr;</a>
                                                        </div>
                                                    </div>
                                                <?php
                                            endwhile;
                                        } else {
                                            echo __('<p style="padding:150px 0;text-align:center;font-size:18px;">No posts found</p>');
                                        }
                                    ?>
                                </div>
                                <?php
                                    if ($custom_query->max_num_pages > 1) {
                                        echo '<div class="mm-blogs-pagination">';
                                        echo mm_blogs_custom_pagination($custom_query->found_posts, $atts['items'], 1);
                                        echo '</div>';
                                    }
                                    wp_reset_postdata();
                                ?>
                            </div>
                            <div class="blogs-page-filtering-sidebar">
                                <div class="search-field">
                                    <input type="text" id="s" name="s" value="" placeholder="Search" autocomplete="off">
                                    <input type="submit" value="" id="search_blogs" class="button avia-font-entypo-fontello">
                                </div>
                                <h3>Island</h3>
                                <ul class="blogs-island">
                                    <li class="all_island active" data-id="-1">ALL</li>
                                    <li class="item_island big-island" data-id="16172">BIG ISLAND</li>
                                    <li class="item_island kauai" data-id="16659">KAUAI</li>
                                    <li class="item_island maui" data-id="16136">MAUI</li>
                                    <li class="item_island oahu" data-id="17296">OAHU</li>
                                </ul>
                                <h3>Category</h3>
                                <?php 
                                    $categorys = get_terms(array(
                                        'taxonomy' => 'category',
                                        'hide_empty' => true
                                    ));
                                ?>
                                <ul class="blogs-categorys">
                                    <li class="all_category active" data-id="-1">ALL</li>
                                    <?php foreach($categorys as $category) : ?>
                                        <li class="item_category big-island" data-id="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="blogs-filter-most-popular on-desktop">
                                    <?php 
                                        $args_blogs_most_popular = array(
                                            'post_type' => 'post',
                                            'post_status' => 'publish',
                                            'posts_per_page' => -1,
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'post_tag',
                                                    'field' => 'id',
                                                    'terms' => array(17776),
                                                ),
                                            ),
                                        );

                                        $the_query_blogs_most_popular = new WP_Query($args_blogs_most_popular);

                                        if ($the_query_blogs_most_popular->have_posts()) {
                                            ?>
                                                <h3>Most Popular Blogs</h3>
                                            <?php
                                            while ($the_query_blogs_most_popular->have_posts()) : $the_query_blogs_most_popular->the_post();
                                                ?>
                                                    <div class="blogs-page-filtering-list-item">
                                                        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" alt="<?php the_title(); ?>"></a>
                                                        <div class="blogs-page-filtering-list-item-content">
                                                            <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                                            <a href="<?php the_permalink(); ?>">Read more &rarr;</a>
                                                        </div>
                                                    </div>
                                                <?php
                                            endwhile;
                                        } 
                                    ?>
                                </div>
                            </div>
                            <div class="blogs-filter-most-popular on-mobile">
                                <?php 
                                    if ($the_query_blogs_most_popular->have_posts()) {
                                        ?>
                                            <h3>MORE TO POPULAR</h3>                                                                                                
                                        <?php
                                        while ($the_query_blogs_most_popular->have_posts()) : $the_query_blogs_most_popular->the_post();
                                            ?>
                                                <div class="blogs-page-filtering-list-item">
                                                    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title(); ?>"></a>
                                                    <div class="blogs-page-filtering-list-item-content">
                                                        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                                        <a href="<?php the_permalink(); ?>">Read more &rarr;</a>
                                                    </div>
                                                </div>
                                            <?php
                                        endwhile;
                                    }
                                    wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                <?php

				$output = ob_get_clean();
				avia_set_layout_array();

				return $output;
			}

	}
}
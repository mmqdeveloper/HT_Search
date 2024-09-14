<?php
/**
 * Sidebar
 * Displays one of the registered Widget Areas of the theme
 */

if ( !class_exists( 'avia_sc_blog' ) )
{
	class mm_avia_sc_blog extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']		= __('MM Blog Posts', 'avia_framework' );
				$this->config['tab']		= __('Maui Marketing Elements', 'avia_framework' );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-blog.png";
				$this->config['order']		= 40;
				$this->config['target']		= 'mm-avia-target-insert';
				$this->config['shortcode'] 	= 'mm_av_blog';
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
				$categorys_terms = get_terms(array(
					'taxonomy' => 'category',
					'hide_empty' => false,
				));
				$category_list = array();
				$category_list[__('All',  'avia_framework' )] = '-1';
				foreach($categorys_terms as $val) {
					$category_list[__($val->name,  'avia_framework' )] = $val->term_id;
				}
				$tags_terms = get_terms(array(
					'taxonomy' => 'post_tag',
					'hide_empty' => false,
				));
				$tags_list = array();
				$tags_list[__('All',  'avia_framework' )] = '-1';
				foreach($tags_terms as $val) {
					$tags_list[__($val->name,  'avia_framework' )] = $val->term_id;
				}
				$this->elements = array(
                    array(
                        "name" 	=> __("Categorys", 'avia_framework' ),
                        "desc" 	=> __("Select which entries should be displayed by selecting a categorys", 'avia_framework' ),
                        "id" 	=> "entries_category",
                        "type" 	=> "select",
						"std" 	=> "-1",
                        "subtype"  => $category_list,
                        "multiple"	=> 10
                    ),

					array(
                        "name" 	=> __("Tags", 'avia_framework' ),
                        "desc" 	=> __("Select which entries should be displayed by selecting a tags", 'avia_framework' ),
                        "id" 	=> "entries_tag",
                        "type" 	=> "select",
						"std" 	=> "-1",
                        "subtype"  => $tags_list,
                        "multiple"	=> 10
                    ),

					array(
						"name" 	=> __("Post Number", 'avia_framework' ),
						"desc" 	=> __("How many items should be displayed per page?", 'avia_framework' ),
						"id" 	=> "items",
						"type" 	=> "select",
						"std" 	=> "-1",
						"subtype" => AviaHtmlHelper::number_array(1,100,1, array('All'=>'-1'))),

                    array(
                        "name" 	=> __("Blogs Style", 'avia_framework' ),
                        "desc" 	=> __("Choose the blog display style you want", 'avia_framework' ),
                        "id" 	=> "blogs_style",
                        "type" 	=> "select",
                        "std" 	=> "grid",
                        "subtype" => array(
							__("Grid", 'avia_framework' ) => 'grid',
							__("Slider", 'avia_framework' ) => 'slider'
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
				$atts = shortcode_atts(array('items' 		=> '16',
			                                 'entries_category' => '',
											 'entries_tag' 	=> '',
											 'blogs_style' 	=> '',
			                                 ), $atts, $this->config['shortcode']);
				ob_start();

				$tax_query = array(
					'relation' => 'AND',
				);
				if (!empty($atts['entries_category']) && $atts['entries_category'] != '-1') {
					$tax_query_cat = explode(",", $atts['entries_category']);  
					$tax_query[] = array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $tax_query_cat
					);
				}

				if (!empty($atts['entries_tag']) && $atts['entries_tag'] != '-1') {
					$tax_query_tag = explode(",", $atts['entries_tag']);  
					$tax_query[] = array(
						'taxonomy' => 'post_tag',
						'field'    => 'term_id',
						'terms'    => $tax_query_tag
					);
				}

				$post_id_exception = array(get_the_ID());

				$query_attrs = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => $atts['items'],
					'orderby' => 'date',
					'order' => 'DESC',
					'tax_query' => $tax_query
				);

				if ($post_id_exception) {
					$query_attrs['post__not_in'] = $post_id_exception;
				}
				$query = new WP_Query($query_attrs);

				$count_result_query = $query->post_count;

				$query_arr = array();

				while ($query->have_posts()) {
					$query->the_post();
					$post_id_exception[] = get_the_ID();
					$query_data = array(
						'excerpt' =>  get_the_excerpt(),
						'link' => get_the_permalink(),
						'thumbnail' => get_the_post_thumbnail(get_the_ID(), 'large'),
						'title' => get_the_title()
					);
					$query_arr[] = $query_data;
				}

				wp_reset_postdata();
				wp_reset_query(); 

				if (count($query_arr) < 3) {
					$post_per_page = 3 - count($query_arr);

					$query_attrs_additional = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => $post_per_page,
						'orderby' => 'date',
						'order' => 'DESC'
					);

					if ($post_id_exception) {
						$query_attrs_additional['post__not_in'] = $post_id_exception;
					}

					$query_additional = new WP_Query($query_attrs_additional);
					$query_arr_additional = array();
					while ($query_additional->have_posts()) {
						$query_additional->the_post();
						$query_data_additional = array(
							'excerpt' =>  get_the_excerpt(),
							'link' => get_the_permalink(),
							'thumbnail' => get_the_post_thumbnail(get_the_ID(), 'large'),
							'title' => get_the_title()
						);
						$query_arr_additional[] = $query_data_additional;
					}
					wp_reset_postdata();
					wp_reset_query(); 
					$query_arr = array_merge($query_arr, $query_arr_additional);
				}
				
				?>
					<div class="content-category">
				<?php
					foreach($query_arr as $blog) {
						$excerpt = $blog['excerpt'];
						?>
							<div class="category-item">
								<div class="img-thumb-category">
									<a href="<?php echo $blog['link']; ?>">
										<?php 
											echo $blog['thumbnail'];
										?>	
									</a>
								</div>
								<div class="content-post-cate">
									<a href="<?php echo $blog['link']; ?>" title="<?php echo $blog['title_attribute']; ?>">
										<h3 class="title-post-cate"><?php echo $blog['title']; ?></h3>
									</a>
									<div class="sub-content-post-cate">
										<a href="<?php the_permalink();?>">
											<p class="content-post">
												<?php echo $excerpt; ?>
											</p>
										</a>
									</div>
									<a class="link-cate" href="<?php echo $blog['link']; ?>">View details &rarr;</a>
								</div>
							</div>
						<?php
					}
				?>
					</div>
				<?php

				$output = ob_get_clean();
				
				avia_set_layout_array();

				$is_slider = '';

				if ($atts['blogs_style'] == 'slider') {
					$is_slider = 'mm-blogs-slider';
				}

				if($output)
				{
					$output = "<div id='container_category' class='mm-blogs-post blogs-page ".$is_slider."'>{$output}</div>";
				}

				return $output;
			}

	}
}
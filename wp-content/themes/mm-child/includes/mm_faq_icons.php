<?php
/**
 * MM Faq Icons Shortcode
 *
 * Creates a list with nice icons beside
 */
if (!class_exists('mm_avia_sc_faq_icons') && class_exists('woocommerce')) {

	class mm_avia_sc_faq_icons extends aviaShortcodeTemplate {

		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button() {
			$this->config['name'] = __('MM FAQ Icons', 'avia_framework');
			$this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
			$this->config['icon'] = AviaBuilder::$path['imagesURL'] . "sc-accordion.png";
			$this->config['order'] = 40;
			$this->config['target'] = 'avia-target-insert';
			$this->config['shortcode'] = 'avia_sc_mm_faq_icons';
			$this->config['tooltip'] = __('Maui Marketing MM Faq', 'avia_framework');
			//$this->config['drag-level'] = 3;
		}

		/**
		 * Popup Elements
		 *
		 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
		 * opens a modal window that allows to edit the element properties
		 *
		 * @return void
		 */
		function popup_elements() {
			$this->elements = array(
				array(
					"type" => "tab_container", 'nodescription' => true
				),
				array(
					"type" => "tab",
					"name" => __("Content", 'avia_framework'),
					'nodescription' => true
				),
				array(
					"name" => __("Which Category?", 'avia_framework'),
					"desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
					"id" => "categories",
					"type" => "select",
					"taxonomy" => "categories",
					"subtype" => "cat",
					"multiple" => 6
				),
				array(
					"desc" => __("Skip Category?", 'avia_framework'),
					"id" => "hide-categories",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox",
				),
				array(
					"name" => __("Which Tag?", 'avia_framework'),
					"desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
					"id" => "mm_tag",
					"type" => "select",
					"taxonomy" => "mmfaq_tag",
					"subtype" => "cat",
					"multiple" => 6
				),
				array(
					"desc" => __("Skip Tag ?", 'avia_framework'),
					"id" => "hide-tag",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox",
				),
				array(
					"name" => __("Sort By Tag Name", 'avia_framework'),
					"desc" => __("Click Which Tag? above to order by Tag", 'avia_framework'),
					"id" => "sort_tag_name",
					"type" => "input",
					"subtype" => "",
				),
				array(
					"name" => __("Sort By Tag", 'avia_framework'),
					"desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
					"id" => "sort_tag",
					"type" => "hidden",
					"subtype" => "",
				),
				array(
					"name" 	=> __("Behavior", 'avia_framework' ),
					"desc" 	=> __("Should only one toggle be active at a time and the others be hidden or can multiple toggles be open at the same time?", 'avia_framework' ),
					"id" 	=> "mode",
					"type" 	=> "select",
					"std" 	=> "accordion",
					"subtype" => array( __('Only one toggle open at a time (Accordion Mode)', 'avia_framework' ) =>'accordion', __("Multiple toggles open allowed (Toggle Mode)", 'avia_framework' ) => 'toggle')
				),
				array(
					"name" 	=> __("Style Layout", 'avia_framework' ),
					"desc" 	=> __("Select the style for the icon located above, to the left, to the right of the text .", 'avia_framework' ),
					"id" 	=> "stylelayout",
					"type" 	=> "select",
					"std" 	=> "layoutleft",
					"subtype" => array(
						__("Layout Default", 'avia_framework' ) => 'layoutdefault',
						__('Icon Above Layout', 'avia_framework' ) =>'layoutabove',
						__("Icon Left Layout", 'avia_framework' ) => 'layoutleft',
						__("Icon Right Layout", 'avia_framework' ) => 'layoutright'),

				),
				array(
					"name" 	=> __("Featured Layout", 'avia_framework' ),
					"desc" 	=> __("Select the style for the image featured", 'avia_framework' ),
					"id" 	=> "featuredimg",
					"type" 	=> "select",
					"std" 	=> "nofeaturedimg",
					"subtype" => array( __('No selected', 'avia_framework' ) =>'nofeaturedimg', __("Layout featured", 'avia_framework' ) => 'yesselected')
				),
				array(
					"type" => "close_div",
					'nodescription' => true
				),
				array(
					"type" => "tab",
					"name" => __("Screen Options", 'avia_framework'),
					'nodescription' => true
				),
				array(
					"name" => __("Element Visibility", 'avia_framework'),
					"desc" => __("Set the visibility for this element, based on the device screensize.", 'avia_framework'),
					"type" => "heading",
					"description_class" => "av-builder-note av-neutral",
				),
				array(
					"desc" => __("Hide on large screens (wider than 990px - eg: Desktop)", 'avia_framework'),
					"id" => "av-desktop-hide",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox"),
				array(
					"desc" => __("Hide on medium sized screens (between 768px and 989px - eg: Tablet Landscape)", 'avia_framework'),
					"id" => "av-medium-hide",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox"),
				array(
					"desc" => __("Hide on small screens (between 480px and 767px - eg: Tablet Portrait)", 'avia_framework'),
					"id" => "av-small-hide",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox"),
				array(
					"desc" => __("Hide on very small screens (smaller than 479px - eg: Smartphone Portrait)", 'avia_framework'),
					"id" => "av-mini-hide",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox"),
				array(
					"type" => "close_div",
					'nodescription' => true
				),
				array(
					"type" => "close_div",
					'nodescription' => true
				),
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
		function editor_element($params) {
			$params['innerHtml'] = "<img src='" . $this->config['icon'] . "' title='" . $this->config['name'] . "' />";
			$params['innerHtml'] .= "<div class='avia-element-label'>" . $this->config['name'] . "</div>";
			$params['content'] = NULL; //remove to allow content elements
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
		function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "") {
			global $avia_config;

			$atts = shortcode_atts(array(
				'mm_tag' => '',
				'taxonomy' => 'categories',
				'post_type' => 'mmfaq',
				'sort_tag' => '',
				'categories' => '',
				'hide-categories' => '',
				'hide-tag' => '',
				'stylelayout' => '',
				'featuredimg' => '',
				'mode' => '',
			), $atts, $this->config['shortcode']);

			extract($atts);

			if($mode == 'accordion') $addClass = 'toggle_close_all ';

			if (!empty($atts['hide-categories'])) {
				$atts['categories'] = NULL;
			}

			if (!empty($atts['categories'])) {
				//get the product categories
				$terms = explode(',', $atts['categories']);
			}
			$ids_current = get_the_ID();
			//if we find no terms for the taxonomy fetch all taxonomy terms
			if (empty($terms[0]) || is_null($terms[0]) || $terms[0] === "null") {
				$terms = array();
				$allTax = get_terms($atts['taxonomy']);
				foreach ($allTax as $tax) {
					$terms[] = $tax->term_id;
				}
			}

			if (!empty($atts['hide-tag'])) {
				$atts['sort_tag'] = NULL;
			}

			if (!empty($atts['sort_tag'])) {
				//get the product categories
				$id_tag_sort = explode(',', $atts['sort_tag']);
			}
			if (empty($id_tag_sort[0]) || is_null($id_tag_sort[0]) || $id_tag_sort[0] === "null") {
				$tags = array();
				$allTag = get_terms('mmfaq_tag');
				foreach ($allTag as $itemtag) {
					$tags[] = $itemtag->term_id;
				}
			}
			if (!empty($terms)) {
				$term_arr = array(
					'taxonomy' => $atts['taxonomy'],
					'field' => 'id',
					'terms' => $terms,
				);
			}
			if (!empty($id_tag_sort)) {
				$id_tag_sort_arr = array(
					'taxonomy' => 'mmfaq_tag',
					'field' => 'id',
					'terms' => $id_tag_sort,
				);
			} else {
				$id_tag_sort_arr = array(
					'taxonomy' => 'mmfaq_tag',
					'field' => 'id',
					'terms' => $tags,
				);
			}
			$tax_query_featured = array(
				'relation' => 'AND',
				$term_arr,
				$id_tag_sort_arr,
				array(
					'taxonomy' => 'categories',
					'field' => 'name',
					'terms' => 'featured',
				),
			);

			$args_featured = array(
				'post_type' => 'mmfaq',
				'post_status' => 'publish',
				'order' => 'ASC',
				'offset' => 0,
				'posts_per_page' => -1,
				'tax_query' => $tax_query_featured
			);
			$args_featureds = $this->query_sort_by($args_featured);

			$result = array();
			if ($args_featureds) {
				$result = array_merge($result, $args_featureds);
			}

			if ($id_tag_sort) {
				foreach ($id_tag_sort as $key => $value) {
					if (!empty($terms)) {
						$relation = 'AND';
					} else {
						$relation = 'OR';
					}
					$tax_query = array(
						'relation' => $relation,
						array(
							'taxonomy' => $atts['taxonomy'],
							'field' => 'id',
							'terms' => $terms,
						),
						array(
							'taxonomy' => 'mmfaq_tag',
							'field' => 'id',
							'terms' => $value,
						)
					);
					$args = array(
						'post_type' => 'mmfaq',
						'post_status' => 'publish',
						'order' => 'ASC',
						'offset' => 0,
						'posts_per_page' => -1,
						'tax_query' => $tax_query,
					);
					$args_mmfaq = $this->query_sort_by($args);

					if ($args_mmfaq) {
						$result = array_merge($result, $args_mmfaq);
					}
				}

			} else {
				if (!empty($terms) && !empty($tags)) {
					$relation = 'AND';
				} else {
					$relation = 'OR';
				}

				if (!empty($terms) || !empty($tags)) {
					$tax_query[] = array(
						'relation' => $relation,
						array(
							'taxonomy' => $atts['taxonomy'],
							'field' => 'id',
							'terms' => $terms,
						),
						array(
							'taxonomy' => 'mmfaq_tag',
							'field' => 'id',
							'terms' => $tags,
						)
					);
				}
				$args = array(
					'post_type' => 'mmfaq',
					'post_status' => 'publish',
					'order' => 'ASC',
					'offset' => 0,
					'posts_per_page' => -1,
					'tax_query' => $tax_query,
				);

				$args_mmfaq = $this->query_sort_by($args);

				if ($args_mmfaq) {
					$result = array_merge($result, $args_mmfaq);
				}
			}

			$unique = array_map('unserialize', array_unique(array_map('serialize', $result)));

			// The Loop
			if ($unique) {
				ob_start();
				$ordericon=$atts['stylelayout'];
				$hasfeatured=$atts['featuredimg'];
				if($ordericon=="layoutleft")
				{

					$odico="left";

				}
                elseif($ordericon=="layoutright")
				{
					$odico="right";
				}
                elseif($ordericon=="layoutdefault")
				{
					$odico="layoutdefault";
				}
				else{
					$odico="above";
				}
				if($hasfeatured=="yesselected")
				{
					$odico="noicon";
				}

				if( $odico == "layoutdefault") {
					?>
                    <div class="togglecontainer  <?php echo $addClass .' '. $meta['el_class']; ?>">
						<?php
						$i = 1;
						foreach ( $unique as $mmfaq_key => $mmfaq_val ) {
							?>
                            <section class="av_toggle_section <?php echo (!empty( $mmfaq_val["class"] ) ? $mmfaq_val["class"] : "");?>" itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
                                <div class="single_toggle" data-tags="{All} ">
                                    <p data-fake-id="#toggle-id-<?php echo $i; ?>" class="toggler" itemprop="headline"><?php echo (!empty( $mmfaq_val["title"] ) ? $mmfaq_val["title"] : "");?>
                                        <span class="toggle_icon">
                                    <span class="vert_icon"></span>
                                    <span class="hor_icon"></span>
                                </span>
                                    </p>
                                    <div id="toggle-id-<?php echo $i; ?>-container" class="toggle_wrap" style="">
                                        <div class="toggle_content invers-color " itemprop="text">
                                            <p><?php echo (!empty( $mmfaq_val["content"] ) ? $mmfaq_val["content"] : "");?></p>
                                        </div>
                                    </div>
                                </div>
                            </section>
							<?php
							$i++;
						}

						?>

                    </div>
					<?php
				} else {
					?>

                    <ul class="avia-icon-list avia-icon-list-<?php echo $odico; ?> faq-icon-style-<?php echo $hasfeatured; ?> avia-icon-faq-list av-iconlist-big avia_animate_when_almost_visible avia_start_animation mmfaqicon-list">
						<?php

						$i = 1;
						foreach ( $unique as $mmfaq_key => $mmfaq_val ) {
							$image = wp_get_attachment_image_src( get_post_thumbnail_id($mmfaq_val["id"]), 'single-post-thumbnail' );
							?>

                            <li class="avia_start_animation <?php echo (!empty( $mmfaq_val["class"] ) ? $mmfaq_val["class"] : "");?> avia-icon-faq-list-<?php echo $mmfaq_val["id"]; ?>">
								<?php

								if($hasfeatured=="yesselected")
								{
									?>
                                    <div class="img-featured-faqitem">
                                        <img src="<?php echo $image[0]; ?>">
                                    </div>
									<?php
								}
								else
								{
									$charico=get_post_meta($mmfaq_val["id"],"mmfaqused_icon",true);
									if($charico=="")
									{
										$charico="ue81d";
									}

									$attricon=av_icon($charico,'entypo-fontello');
									?>
                                    <div class="iconlist_icon  avia-font-entypo-fontello"><span class="iconlist-char " <?php echo $attricon; ?>></span></div>
									<?php
								}
								?>
                                <article class="article-icon-entry " itemscope="itemscope" itemtype="https://schema.org/CreativeWork">
                                    <div class="iconlist_content_wrap">
                                        <header class="entry-content-header">
                                            <h4 class="av_iconlist_title iconlist_title  " itemprop="headline"><?php echo (!empty( $mmfaq_val["title"] ) ? $mmfaq_val["title"] : "");?></h4></header>
                                        <div class="iconlist_content  " itemprop="text">
											<?php echo (!empty( $mmfaq_val["content"] ) ? $mmfaq_val["content"] : "");?>
                                        </div>
                                    </div>
                                    <footer class="entry-footer"></footer>
                                </article>
                                <div class="iconlist-timeline"></div>
                            </li>

							<?php

						}

						?>
                    </ul>
					<?php
				}

				$output = ob_get_clean();
			} else {
				$output = 'No MM FAQ found which match your selection.';
			}
			return $output;
		}

		function query_sort_by($args) {

			if (!empty($args)) {

				query_posts($args);

				if (have_posts()) {

					$arg_mmfaq = array();

					$i = 0;
					while (have_posts()) {
						the_post();
						$post_id = get_the_ID();
						$arg_mmfaq[$i]['id'] = get_the_ID();
						$arg_mmfaq[$i]['title'] = get_the_title();
						$arg_mmfaq[$i]['content'] = get_the_content();
						$arg_mmfaq[$i]['class'] = implode(" ", get_post_class());
						$i++;
					}
				}

			}
			return $arg_mmfaq;
		}

	}

}

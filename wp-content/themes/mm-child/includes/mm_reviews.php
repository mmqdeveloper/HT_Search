<?php
/**
 * Textblock
 *
 * Shortcode which creates a text element wrapped in a div
 */
if (!defined('ABSPATH')) {exit;} // Exit if accessed directly

if (!class_exists('mm_avia_reviews')) {
	class mm_avia_reviews extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		public function shortcode_insert_button()
		{
			$this->config['version'] = '1.0';
			$this->config['self_closing'] = 'no';
			$this->config['base_element'] = 'yes';

			$this->config['name'] = __('MM Reviews Tab', 'avia_framework');
			$this->config['tab'] = __('Maui Marketing Elements', 'avia_framework');
			$this->config['icon'] = AviaBuilder::$path['imagesURL'] . 'sc-text_block.png';
			$this->config['order'] = 100;
			$this->config['target'] = 'avia-target-insert';
			$this->config['shortcode'] = 'mm_av_reviews';
			$this->config['tinyMCE'] = array('disable' => true);
			$this->config['tooltip'] = __('Creates a simple text block', 'avia_framework');
			$this->config['preview'] = 'large';
			$this->config['id_name'] = 'id';
			$this->config['id_show'] = 'yes';
		}

		/**
		 * Popup Elements
		 *
		 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
		 * opens a modal window that allows to edit the element properties
		 *
		 * @return void
		 */
		public function popup_elements()
		{

			$this->elements = array(

				array(
					'type' => 'tab_container',
					'nodescription' => true,
				),

				array(
					'type' => 'tab',
					'name' => __('Option', 'avia_framework'),
					'nodescription' => true,
				),
				array(
					"name" => __("Which Category?", 'avia_framework'),
					"desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
					"id" => "categories",
					"type" => "select",
					"post_type" => "review",
					"taxonomy" => "categories_review",
					"subtype" => "cat",
					"multiple" => 6,
				),
				array(
					"name" => __("Which Tag?", 'avia_framework'),
					"desc" => __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework'),
					"id" => "tags",
					"type" => "select",
					"post_type" => "review",
					"taxonomy" => "tag_review",
					"subtype" => "cat",
					"multiple" => 6,
				),
				array(
					"name" => __("Which template?", 'avia_framework'),
					"desc" => __("Select which entries should be displayed by selecting a template", 'avia_framework'),
					"id" => "template",
					"type" => "select",
					"std" => "accordion",
					"subtype" => array(
						__('Slider', 'avia_framework') => '1',
						__("Tab", 'avia_framework') => '2',
					),

				),
				array(
					"name" => __("Entry Number", 'avia_framework'),
					"desc" => __("How many items should be displayed?", 'avia_framework'),
					"id" => "items",
					"type" => "select",
					"std" => "3",
					"subtype" => AviaHtmlHelper::number_array(1, 100, 1, array(
						'All' => '-1'
					))
				),
				array(
					"desc" => __("Skip Logo ?", 'avia_framework'),
					"id" => "hide-logo",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox",
				),
				array(
					"desc" => __("Skip Image Author ?", 'avia_framework'),
					"id" => "hide-author",
					"std" => "",
					"container_class" => 'av-multi-checkbox',
					"type" => "checkbox",
				),



				array(
					'type' => 'tab_close',
					'nodescription' => true,
				),

				array(
					'type' => 'tab_container_close',
					'nodescription' => true,
				),

			);

		}

		/**
		 * Create and register templates for easier maintainance
		 *
		 * @since 4.6.4
		 */
		protected function register_dynamic_templates()
		{
			/**
			 * Styling Tab
			 * ===========
			 */

			$c = array(
				array(
					'type' => 'template',
					'template_id' => 'font_sizes_icon_switcher',
					'lockable' => true,
					'subtype' => array(
						'default' => AviaHtmlHelper::number_array(8, 40, 1, array(__('Use Default', 'avia_framework') => ''), 'px'),
						'medium' => AviaHtmlHelper::number_array(8, 40, 1, array(__('Use Default', 'avia_framework') => '', __('Hidden', 'avia_framework') => 'hidden'), 'px'),
						'small' => AviaHtmlHelper::number_array(8, 40, 1, array(__('Use Default', 'avia_framework') => '', __('Hidden', 'avia_framework') => 'hidden'), 'px'),
						'mini' => AviaHtmlHelper::number_array(8, 40, 1, array(__('Use Default', 'avia_framework') => '', __('Hidden', 'avia_framework') => 'hidden'), 'px'),
					),
				),

			);

			$template = array(
				array(
					'type' => 'template',
					'template_id' => 'toggle',
					'title' => __('Font Size', 'avia_framework'),
					'content' => $c,
				),
			);

			AviaPopupTemplates()->register_dynamic_template($this->popup_key('styling_font_sizes'), $template);

			$c = array(
				array(
					'name' => __('Font Colors', 'avia_framework'),
					'desc' => __('Either use the themes default colors or apply some custom ones', 'avia_framework'),
					'id' => 'font_color',
					'type' => 'select',
					'std' => '',
					'lockable' => true,
					'subtype' => array(
						__('Default', 'avia_framework') => '',
						__('Define Custom Colors', 'avia_framework') => 'custom',
					),
				),

				array(
					'name' => __('Custom Font Color', 'avia_framework'),
					'desc' => __('Select a custom font color. Leave empty to use the default', 'avia_framework'),
					'id' => 'color',
					'type' => 'colorpicker',
					'std' => '',
					'lockable' => true,
					'required' => array('font_color', 'equals', 'custom'),
				),
			);

			$template = array(
				array(
					'type' => 'template',
					'template_id' => 'toggle',
					'title' => __('Font Colors', 'avia_framework'),
					'content' => $c,
				),
			);

			AviaPopupTemplates()->register_dynamic_template($this->popup_key('styling_font_colors'), $template);

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
		public function editor_element($params)
		{
			$params['innerHtml'] = "<img src='" . $this->config['icon'] . "' title='" . $this->config['name'] . "' />";
			$params['innerHtml'] .= "<div class='avia-element-label'>" . $this->config['name'] . "</div>";
			$params['content'] = null; //remove to allow content elements
			return $params;
		}

		/**
		 * Create custom stylings
		 *
		 * @since 4.8.7
		 * @param array $args
		 * @return array
		 */
		protected function get_element_styles(array $args)
		{
			$result = parent::get_element_styles($args);

			extract($result);

			$default = array(
				'font_color' => '',
				'color' => '',
				'size' => '',
			);

			$default = $this->sync_sc_defaults_array($default, 'no_modal_item', 'no_content');

			$locked = array();
			Avia_Element_Templates()->set_locked_attributes($atts, $this, $shortcodename, $default, $locked, $content);
			Avia_Element_Templates()->add_template_class($meta, $atts, $default);

			$atts = shortcode_atts($default, $atts, $this->config['shortcode']);

			$element_styling->create_callback_styles($atts);

			$classes = array(
				'av_textblock_section',
				$element_id,
			);

			$element_styling->add_classes('section', $classes);
			$element_styling->add_responsive_classes('container', 'hide_element', $atts);
			$element_styling->add_responsive_font_sizes('container', 'size', $atts, $this);

			$classes = array(
				'avia_textblock',
			);

			$element_styling->add_classes('container', $classes);
			$element_styling->add_classes_from_array('container', $meta, 'custom_class');
			$element_styling->add_classes_from_array('container', $atts, 'template_class');

			if ($atts['textblock_styling'] != '') {
				$element_styling->add_classes('container', 'av_multi_colums');
			}

			if ('custom' == $atts['font_color']) {
				$element_styling->add_classes('container', 'av_inherit_color');
				$element_styling->add_styles('container', array('color' => $atts['color']));
			}

			$element_styling->add_callback_styles('container', array('textblock_styling'));

			//    add columns media queries
			$element_styling->add_callback_media_queries('container', array('textblock_styling'));
			$element_styling->add_callback_media_queries('container-p', array('textblock_styling_first_p'));

			$selectors = array(
				'container' => "#top .av_textblock_section.{$element_id} .avia_textblock",
				'container-p' => ".av_textblock_section.{$element_id} .avia_textblock.av_multi_colums > p:first-child",
			);

			$element_styling->add_selectors($selectors);

			$result['default'] = $default;
			$result['atts'] = $atts;
			$result['content'] = $content;
			$result['element_styling'] = $element_styling;

			return $result;
		}


		public function mm_get_review_fc($term_cat,$term_tag,$hide_logo,$hide_author,$limit){
			if (!empty($term_cat) && !empty($term_tag)) {
				$relation = 'AND';
			} else {
				$relation = 'OR';
			}

			if (!empty($term_cat) || !empty($term_tag)) {
				$tax_query[] = array(
					'relation' => $relation,
					array(
						'taxonomy' => 'categories_review',
						'field' => 'id',
						'terms' => $term_cat,
					),
					array(
						'taxonomy' => 'tag_review',
						'field' => 'id',
						'terms' => $term_tag,
					)
				);
			}
			ob_start();
			?>
			<div class="review-container">
				<div class="img-top">
					<img class="avia_image" src="<?php echo REVIEW_PLUGIN_URL; ?>assets/images/quote-icon-review.png" alt="quote icon review" title="quote-icon-review">
				</div>
				<div class="wrap-review" >
					<?php
					$args = array(
						'post_type' => 'review',
						'post_status' => 'publish',
						'posts_per_page' => $limit,
						'tax_query' => $tax_query
					);
					$the_query = new WP_Query( $args );

					if ( $the_query->have_posts() ) :

						while ( $the_query->have_posts() ) : $the_query->the_post();?>
							<div class="review-block">
								<h4 class="review-title"><?php echo the_title(); ?></h4>
								<p class="review-content"><?php echo get_the_content(); ?></p>
								<div class="wrap-info-bottom">
							<?php if( empty( $hide_author ) ):  ?>
                                <div class="name-author">
                                    <?php if(!empty( get_the_post_thumbnail_url(get_the_ID(),'full') )) : ?>
                                        <img src="<?php echo  get_the_post_thumbnail_url(get_the_ID(),'full'); ?>">

                                   <?php endif; ?>
                                    <p><?php echo get_post_meta(get_the_ID(),'review_author', true ); ?></p>

                                </div>
							<?php endif; ?>
							<?php if( empty( $hide_logo ) ):  ?>
                                <div class="img-logo">
										<?php echo wp_get_attachment_image( get_post_meta( get_the_ID(), '_listing_image_id', true ), 'post-thumbnail' );?>
                                </div>
							<?php endif; ?>
								</div>

							</div>
						<?php endwhile;

						wp_reset_postdata();


					endif;
					?>
				</div>
			</div>
			<?php
			$result = ob_get_contents();
			ob_get_clean();
			return $result;

		}



		public function mm_get_tab_review_fc($term_cat,$term_tag){
			global $post;
			if (!empty($term_cat) && !empty($term_tag)) {
				$relation = 'AND';
			} else {
				$relation = 'OR';
			}

			if (!empty($term_cat) || !empty($term_tag)) {
				$tax_query[] = array(
					'relation' => $relation,
					array(
						'taxonomy' => 'categories_review',
						'field' => 'id',
						'terms' => $term_cat,
					),
					array(
						'taxonomy' => 'tag_review',
						'field' => 'id',
						'terms' => $term_tag,
					)
				);
			}
			ob_start();
			?>
            <div class="tabs-rv">
                <ul id="tabs-nav-rv">
                    <li><div class="hidden-a"></div><a href="#google-rv"><img class="av-tab-section-image" src="<?php echo REVIEW_PLUGIN_URL; ?>assets/images/google-logo-svg.svg" alt="quote icon review" title="quote-icon-review"></a></li>
                    <li><div class="hidden-a"></div><a href="#facebook-rv"><img class="av-tab-section-image" src="<?php echo REVIEW_PLUGIN_URL; ?>assets/images/facebook-logo-blue-svg.svg" alt="quote icon review" title="quote-icon-review"></a></li>
                    <li><div class="hidden-a"></div><a href="#yelp-rv"><img class="av-tab-section-image" src="<?php echo REVIEW_PLUGIN_URL; ?>assets/images/yelp_logo_svg.svg" alt="quote icon review" title="quote-icon-review"></a></li>
                </ul>
                <div id="tabs-content-rv">
                    <div id="google-rv" class="tab-content-rv">
						<?php
						$args = array(
							'post_type' => 'review',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_key' => 'review_social',
							'meta_value' => 'google',
							'tax_query' => $tax_query


						);
						$the_query = new WP_Query( $args );

						if ( $the_query->have_posts() ) :

							while ( $the_query->have_posts() ) : $the_query->the_post();?>
                                <div class="review-block">
                                    <div class="info-block">
                                        <div class="ava-cus">
                                            <div class="wrap-st-av">
                                                <img class = "avatar" src="<?php echo  get_the_post_thumbnail_url(get_the_ID(),'full') ? get_the_post_thumbnail_url(get_the_ID(),'full') :  mm_random_url_image() ; ?>" alt="Tara Marksberry">
                                                <div class="iconstart-list">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info-cus">
                                            <h4><?php echo get_post_meta($post->ID,'review_author', true );  ?></h4>
                                            <div class="wrap-date">
                                                <p class="yelpico">
                                                    <img src="<?php echo REVIEW_PLUGIN_URL; ?>assets/images/google-logo-svg.svg" alt="quote icon review" title="quote-icon-review">
                                                    <span class="date"><?php echo get_post_meta($post->ID,'review_date', true );  ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-block">
                                        <p class="review-content"><?php echo get_the_content(); ?></p>
                                    </div>

                                </div>
							<?php endwhile;

							wp_reset_postdata();
						endif;
						?>
                    </div>
                    <div id="facebook-rv" class="tab-content-rv">
						<?php
						$args = array(
							'post_type' => 'review',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_key' => 'review_social',
							'meta_value' => 'facebook',
							'tax_query' => $tax_query


						);
						$the_query = new WP_Query( $args );

						if ( $the_query->have_posts() ) :

							while ( $the_query->have_posts() ) : $the_query->the_post();?>
                                <div class="review-block">
                                    <div class="info-block">
                                        <div class="ava-cus">
                                            <div class="wrap-st-av">
                                                <img class = "avatar" src="<?php echo  get_the_post_thumbnail_url(get_the_ID(),'full') ? get_the_post_thumbnail_url(get_the_ID(),'full') :  mm_random_url_image() ; ?>" alt="Tara Marksberry">
                                                <div class="iconstart-list">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info-cus">
                                            <h4><?php echo get_post_meta($post->ID,'review_author', true );  ?></h4>
                                            <div class="wrap-date">
                                                <p class="yelpico">
                                                    <img src="<?php echo REVIEW_PLUGIN_URL; ?>assets/images/facebook-logo-blue-svg.svg" alt="quote icon review" title="quote-icon-review">
                                                    <span class="date"><?php echo get_post_meta($post->ID,'review_date', true );  ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-block">
                                        <p class="review-content"><?php echo get_the_content(); ?></p>
                                    </div>

                                </div>
							<?php endwhile;

							wp_reset_postdata();
						endif;
						?>
                    </div>
                    <div id="yelp-rv" class="tab-content-rv">
						<?php
						$args = array(
							'post_type' => 'review',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'meta_key' => 'review_social',
							'meta_value' => 'yelp',
							'tax_query' => $tax_query


						);
						$the_query = new WP_Query( $args );

						if ( $the_query->have_posts() ) :

							while ( $the_query->have_posts() ) : $the_query->the_post();?>
                                <div class="review-block">
                                    <div class="info-block">
                                        <div class="ava-cus">
                                            <div class="wrap-st-av">
                                                <img class = "avatar" src="<?php echo  get_the_post_thumbnail_url(get_the_ID(),'full') ? get_the_post_thumbnail_url(get_the_ID(),'full') :  mm_random_url_image() ; ?>" alt="Tara Marksberry">
                                                <div class="iconstart-list">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info-cus">
                                            <h4><?php echo get_post_meta($post->ID,'review_author', true );  ?></h4>
                                            <div class="wrap-date">
                                                <p class="yelpico">
                                                    <img src="<?php echo REVIEW_PLUGIN_URL; ?>assets/images/yelp_logo_svg.svg" alt="quote icon review" title="quote-icon-review">
                                                    <span class="date"><?php echo get_post_meta($post->ID,'review_date', true );  ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-block">
                                        <p class="review-content"><?php echo get_the_content(); ?></p>
                                    </div>

                                </div>
							<?php endwhile;

							wp_reset_postdata();
						endif;
						?>
                    </div>
                </div>
            </div>

			<?php
			$result = ob_get_contents();
			ob_get_clean();
			return $result;
		}


		/**
		 * Frontend Shortcode Handler
		 *
		 * @param array $atts array of attributes
		 * @param string $content text within enclosing form of shortcode element
		 * @param string $shortcodename the shortcode found, when == callback name
		 * @return string $output returns the modified html string
		 */
		public function shortcode_handler($atts, $content = '', $shortcodename = '', $meta = '')
		{

			if($atts['template'] == '1'){
				return $this->mm_get_review_fc($atts['categories'],$atts['tags'],$atts['hide-logo'],$atts['hide-author'],$atts['items']);
			}else{
				return $this->mm_get_tab_review_fc($atts['categories'],$atts['tags']);
			}

		}
	}
}

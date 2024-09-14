<?php

	global $avia_config, $more;

	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */
	 get_header();
	
		
		$showheader = true;
		if(avia_get_option('frontpage') && $blogpage_id = avia_get_option('blogpage'))
		{
			if(get_post_meta($blogpage_id, 'header', true) == 'no') $showheader = false;
		}
		
	 	if($showheader)
	 	{
			echo avia_title(array('title' => avia_which_archive()));
		}
		
		do_action( 'ava_after_main_title' );
	?>
		<div id="main" data-scroll-offset="88">
			<div id="header_category" class="avia-section main_color avia-section-default avia-no-shadow avia-bg-style-scroll  avia-builder-el-0  el_before_av_two_third  avia-builder-el-first  av-minimum-height av-minimum-height-custom container_wrap fullsize" data-section-bg-repeat="no-repeat">
			   <div class="container" style="height:350px">
				  <main role="main" itemscope="itemscope" itemtype="https://schema.org/Blog" class="template-page content  av-content-full alpha units">
					 <div class="post-entry post-entry-type-page post-entry-2764">
						<div class="entry-content-wrapper clearfix">
						   <section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/BlogPosting" itemprop="blogPost">
							  <div class="avia_textblock " itemprop="text">
								 <h1 class="title-header-cate" style="text-transform: none; font-weight: initial;">
									<span style="color: #ffffff;">
										<strong style="font-family: Exo2-Medium; font-weight: 100;">BLOG</strong>
									</span>
								</h1>
							  </div>
						   </section>
						</div>
					 </div>
				  </main>
				  <!-- close content main element -->
			   </div>
			</div>
			<div id="container_category">
				<div class="container">
					<div class="template-page content  av-content-full alpha units">
					   <div class="post-category">
							<div class="category-wrapper clearfix">
								<div class="content-category">
								<?php 
								global $wp_query;
								$query_ob = $wp_query->queried_object; 
								$taxonomies = $query_ob->taxonomy;
								$slug = $query_ob->slug;
								
								$arr = array(
										'post_status' => 'publish',
										'posts_per_page' => -1,
										'orderby' => 'date',
										'order' => 'DESC',
										'post_type' => 'post'
								);
								if(!empty($slug)){
									$arr['tax_query'] =   array(
											'relation' => 'AND',
											array(
												'taxonomy' => $taxonomies,
												'field'    => 'slug',
												'terms'    => $slug,
											)
									);
								}
								$cate_query = new WP_Query($arr);

								if ( $cate_query->have_posts() ) :

										
										while ( $cate_query->have_posts() ) :
											$cate_query->the_post();
											$post_id = get_the_ID();
											$posttags = get_the_tags();
											$name_tag = $posttags[0]->name;
											$tag_id = $posttags[0]->term_id;
											$excerpt = get_the_excerpt();
											$exc = !empty($excerpt) ? avia_backend_truncate($excerpt,150," ") : avia_backend_truncate(get_the_content(), apply_filters( 'avf_postgrid_excerpt_length' , 150) , apply_filters( 'avf_postgrid_excerpt_delimiter' , " "), "…", true, '');
											?>
												<div class="category-item left">
													<div class="img-thumb-category">
													<?php if ( has_post_thumbnail() ) {
															the_post_thumbnail('large');
														}
														?>	
														<div class="cate__read-more"><a class="read__more" href="<?php the_permalink();?>">READ MORE</a></div>
														<span class="entry-date"><?php echo get_the_date(); ?></span>
													</div>
													<div class="content-post-cate">
														<a class="link-post-cate" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>">
															<h3 class="title-post-cate"><?php the_title(); ?></h3>
														</a>
														<div class="sub-content-post-cate">
															<p class="content-post">
																<?php echo $exc; ?>
															</p>
														</div>
													</div>
													<div class="category-title">
														<a class="link-cate" href="<?php echo get_tag_link($tag_id); ?>"><span class="name-cat"><?php echo $name_tag; ?></span></a>
													</div>
												</div>

												<?php
											endwhile;
											
								endif;
								wp_reset_query();
								?>
								</div>
								<div class="cate-sidebar">
									<div class="cate-sidebar-wrap">
										<?php
											echo do_shortcode('[search_form_mm]');
											echo do_shortcode('[toggle_tab_mm]');
											echo do_shortcode('[toggle_popular_mm]');
											echo do_shortcode('[booking_tours_sidebar]');
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>




<?php get_footer(); ?>

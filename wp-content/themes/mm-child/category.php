<?php

	global $avia_config, $more;

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
		<div id="container_category" class="blogs-page">
			<div class="container">
				<div class="template-page content  av-content-full alpha units">
					<div class="post-category">
						<div class="category-wrapper clearfix">
							<?php echo do_shortcode('[av_mm_breadcrumb]'); ?>
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
									$cat = get_the_category();
									$category_id = $cat[0]->cat_ID;
									$name_cat = $cat[0]->name;
									$excerpt = get_the_excerpt();
									$exc = !empty($excerpt) ? avia_backend_truncate($excerpt,150," ") : avia_backend_truncate(get_the_content(), apply_filters( 'avf_postgrid_excerpt_length' , 150) , apply_filters( 'avf_postgrid_excerpt_delimiter' , " "), "�", true, '');
									?>
										<div class="category-item left">
											<div class="img-thumb-category">
												<a href="<?php the_permalink();?>">
													<?php 
														if ( has_post_thumbnail() ) {
															the_post_thumbnail('large');
														}
													?>	
												</a>
											</div>
											<div class="content-post-cate">
												<a class="link-post-cate" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>">
													<h3 class="title-post-cate"><?php the_title(); ?></h3>
												</a>
												<div class="sub-content-post-cate">
													<a href="<?php the_permalink();?>">
														<p class="content-post">
															<?php echo $exc; ?>
														</p>
													</a>
												</div>
												<a class="link-cate" href="<?php the_permalink();?>">View details &rarr;</a>
											</div>
										</div>

									<?php
								endwhile;
								?>
									<div class="blogs-page-btn-see-more">See more</div>
								<?php
							endif;
							wp_reset_query();
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php get_footer(); ?>
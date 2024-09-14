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
										<strong style="font-family: Exo2-Medium; font-weight: 100;">LEARN MORE ABOUT THE HAWAIIAN ISLANDS</strong>
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
			<div id="container_category" class="blogs-page">
				<div class="container">
                    <h2 class="blogs-page-heading">EXPLORE AND GET UPDATES FROM HAWAII</h2>
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
                                                    <?php 
                                                        if ( has_post_thumbnail() ) {
                                                            the_post_thumbnail('large');
                                                        }
                                                    ?>	
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
            <div class="blogs-page-exlore-us-now">
                <div class="container">
                    <p>READY TO EXPLORE HAWAII?</p>
                    <a href="#">EXLORE US NOW</a>
                </div>
            </div>
            <div class="blogs-page-filtering">
                <div class="container">
                    <h2 class="blogs-page-heading">MORE TO POPULAR</h2>
                    <div class="blogs-page-filtering-wrap">
                        <div class="blogs-page-filtering-list">
                            <div class="blogs-page-filtering-list-inner">
                                <?php
                                    query_posts(
                                        array(
                                            'post_type' => 'post',
                                            'post_status' => 'publish',
                                            'posts_per_page' => 6,
                                            'orderby' => 'post_date',
                                            'order' => 'DESC'
                                        )
                                    );
                                    if (have_posts()) {
                                        while (have_posts()) : the_post();
                                            ?>
                                                <div class="blogs-page-filtering-list-item">
                                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title(); ?>">
                                                    <div class="blogs-page-filtering-list-item-content">
                                                        <h3><?php the_title(); ?></h3>
                                                        <a href="<?php the_permalink(); ?>">Read more &rarr;</a>
                                                    </div>
                                                </div>
                                            <?php
                                        endwhile;
                                    } else {
                                        echo __('<p style="padding:150px 0;text-align:center;font-size:18px;">No posts found</p>');
                                    }
                                    wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                        <div class="blogs-page-filtering-sidebar">
                            <div class="search-field">
                                <input type="text" id="s" name="s" value="" placeholder="Search" autocomplete="off">
                                <input type="submit" value="" id="search_blogs" class="button avia-font-entypo-fontello">
                            </div>
                            <h3>Island</h3>
                            <ul class="blogs-categorys">
                                <li class="all_island active" data-items="3" data-id="-1">ALL</li>
                                <li class="item_island big-island" data-items="3" data-id="16172">BIG ISLAND</li>
                                <li class="item_island kauai" data-items="3" data-id="16659">KAUAI</li>
                                <li class="item_island maui" data-items="3" data-id="16136">MAUI</li>
                                <li class="item_island oahu" data-items="3" data-id="17296">OAHU</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>




<?php get_footer(); ?>

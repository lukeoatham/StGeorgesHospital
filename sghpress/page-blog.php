<?php
/* Template name: Blog page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">

				
					<div class="span9" id='content'>
						<?php if ( is_front_page() ) { ?>
							<h2><?php the_title(); ?></h2>
						<?php } else { ?>	
							<h1><?php the_title(); ?></h1>
						<?php } ?>				
					
							<?php the_content(); ?>
							
							<?php
							
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$customquery = new WP_Query('category_name=blog&paged='.$paged);
								
							if ( $customquery->have_posts() ) {
				
								while ( $customquery->have_posts() ) {
									$customquery->the_post();
									echo "<div class='featured_story clearfix'>";
									if ( has_post_thumbnail( $post->ID ) ) {
										the_post_thumbnail('thumbnail',"class=alignleft");
									}	
									
									echo "<h2><a href='" .get_permalink() . "'>" . get_the_title() . "</a></h2>";
									echo "<span class='newsdatelist'>".date('d F Y',strtotime($post->post_date))."</span>";
									the_excerpt();
									echo "</div>";
								}
							}
							
							wp_reset_query();
							
							?>
					
						
						<?php if (  $customquery->max_num_pages > 1 ) : ?>
							<?php if (function_exists(wp_pagenavi)) : ?>
								<?php wp_pagenavi(array('query' => $customquery)); ?>
	 						<?php else : ?>
								<?php next_posts_link('&larr; Older items', $customquery->max_num_pages); ?>
								<?php previous_posts_link('Newer items &rarr;', $customquery->max_num_pages); ?>						
							<?php endif; ?>
						<?php endif; ?>
	
				
					</div>
					
					<div class="span3" id='secondarynav'>
				
					<?php if ( is_active_sidebar( 'news-landing-widget-area' ) ) : ?>
		
					<?php dynamic_sidebar( 'news-landing-widget-area' ); ?>
			
					<?php endif; ?>
						
					
					</div>

					
				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
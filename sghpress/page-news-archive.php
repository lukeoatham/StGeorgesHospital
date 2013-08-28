<?php
/* Template name: News archive page */

get_header();
$newstype = $_GET['type'];
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


				<div class="row-fluid">

					<div class="span3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>

					<?php if ( is_active_sidebar( 'news-landing-widget-area' ) ) : ?>
		
					<?php dynamic_sidebar( 'news-landing-widget-area' ); ?>
			
					<?php endif; ?>

						
					</div>

				
					<div class="span6" id='content'>
						<?php if ( is_front_page() ) { ?>
							<h2><?php the_title(); ?></h2>
						<?php } else { ?>	
							<h1><?php the_title(); ?></h1>
						<?php } ?>				
					
							<?php the_content(); ?>

							<?php
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							if(function_exists('genarate_ajax_pagination') ) {
								$cquery=array(
								"post_type" => "newsitem",
								"posts_per_page" => 20,
								);
							} else {
								$cquery=array(
								"post_type" => "newsitem",
								"posts_per_page" => 20,
								"paged"=>$paged,
								);
							}								
							$customquery = new WP_Query($cquery);
									while ($customquery->have_posts()) : $customquery->the_post();
								   get_template_part( 'loop', 'newstwitter' );
							       endwhile;
							       
								   if(function_exists('genarate_ajax_pagination')) {
							        genarate_ajax_pagination('Load more news', 'blue', 'loop-newstwitter', $cquery); 
							        } else {
	        						if (  $customquery->max_num_pages > 1 ) {
										if (function_exists('wp_pagenavi')) {
											wp_pagenavi(array('query' => $customquery)); 
												} else {
												next_posts_link('&larr; Older items', $customquery->max_num_pages); 
												previous_posts_link('Newer items &rarr;', $customquery->max_num_pages); 	
											}
									}
									wp_reset_query();								
									}
																       
							?>
					</div>
					<div class="span3">
						<h3>Events</h3>
						<p></p>
						
						<h3>Gazette</h3>
					</div>
				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
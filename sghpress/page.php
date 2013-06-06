<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); 
global $biotpress_options;
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="threecol" iid='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
					</div>

					<div class="sixcol" id='content'>

						<?php if ( ! is_front_page() ) { ?>
							<h1><?php the_title(); ?></h1>
						<?php } ?>				
														
							<?php the_content(); ?>
	

							<?php if ( (comments_open() || have_comments()) && $biotpress_options['radio_commentlayout_input'] == "traditional") : ?>
								<div id='comments'>
									<?php comments_template( '', true ); ?>
								</div>						
							<?php endif; ?>
	
					</div>

					<div class="threecol last clearfix" id='sidebar'>
					<?php 

					the_post_thumbnail('medium');
					
					?>
						<ul class="xoxo">

							<?php if ( (comments_open() || have_comments()) && $biotpress_options['radio_commentlayout_input'] == "sidebar") : ?>
							<li>
		
								<div id='comments'>
									<?php comments_template( '', true ); ?>
								</div>
							
							</li>
							<?php endif; ?>
							
						<?php dynamic_sidebar('inside-sidebar-widget-area');  ?>
						</ul>
						
					</div>

				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
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

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="col-lg-3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
					</div>

					<div class="col-lg-6" id='content'>

						<?php if ( ! is_front_page() ) { ?>
							<h1><?php the_title(); ?></h1>
						<?php } ?>				
														
							<?php the_content(); ?>
	

	
					</div>

					<div class="col-lg-3" id='sidebar'>
					<?php 

					the_post_thumbnail('medium');
					
					?>
						
					</div>

				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
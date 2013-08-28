<?php
/* Template name: Wide page */

get_header(); 

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">

					<div class="span3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
					</div>

					<div class="span9" id='content'>

						<?php if ( ! is_front_page() ) { ?>
							<h1><?php the_title(); ?></h1>
						<?php } ?>				
														
							<?php the_content(); ?>
	

	
					</div>


				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
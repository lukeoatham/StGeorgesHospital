<?php
/**
 * The Template for displaying all single treatment posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
	
	$mainid=$post->ID;
?>

		<div class="row-fluid">

				<div class="span8" id='content'>
					<h1><?php the_title(); ?></h1>

					<?php 
					
					$cimage = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'alignleft'));
					echo $cimage;
					the_content(); ?>

						<div id='comments'>
							<?php comments_template( '', true ); ?>
						</div>						
				
				</div>
				
				<div class="span4" id='sidebar'>
					
						<ul class="xoxo">

							<?php if (is_home() || is_front_page()) : ?>
								<?php dynamic_sidebar( 'home-sidebar-widget-area' ); ?>
							<?php else : ?>
								<?php dynamic_sidebar( 'inside-sidebar-widget-area' ); ?>
							<?php endif; ?>
						</ul>
	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
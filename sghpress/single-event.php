<?php
/**
 * The Template for displaying all single event posts.
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
					<div class="span3" id='secondarynav'>
					
				
							<?php renderLeftNav(); ?>
						
						
					</div>
				<div class="span6 newsContent" id='content'>
					<div id="mobhead">
						<h1><?php the_title() ; ?></h1>
					</div>

					<?php 
					
					$rows = get_post_meta($post->ID,'event_start_date',true);
					echo "<h3>".date('j M Y H:i',strtotime($rows))." - ".get_post_meta($post->ID,'event_end_time',true)."</h3>";
					
					the_content(); ?>

						<div id='comments'>
							<?php comments_template( '', true ); ?>
						</div>						
				
				</div>
				
				<div class="span3 newsContent" id='sidebar'>
<?php					$cimage = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'alignleft'));
					echo $cimage;
				?>
					
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
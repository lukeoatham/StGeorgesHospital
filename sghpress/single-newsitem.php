<?php
/**
 * The Template for displaying all news posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
	
	$mainid=$post->ID;
?>
		<div class="row-fluid visible-phone" id="sideNav">
			<div class="span3" id='secondarynav'>
					
				
							<?php renderLeftNav(); ?>
						
						
					</div>
		</div>
		<div class="row-fluid">

				<div class="span8" id='content'>
					<h1><?php the_title(); ?></h1>

					<p class='postmeta'><?php twentyten_posted_on(); ?></p>

					<?php the_content(); ?>

						<div id='comments'>
							<?php comments_template( '', true ); ?>
						</div>						
									
				</div>
				
				<div class="span4" id='sidebar'>
					<?php

						echo get_the_post_thumbnail($post->ID,'newsubhead');
								
						echo "<span class='caption'>".get_post_thumbnail_caption()."</span>";

			echo "<div id='newsposts'><hr>";
			$category = get_the_category(); 
			$recentitems = new WP_Query('post_type=newsitem&posts_per_page=5');			
			echo "<h2>Recently published</h2>";

			if ($recentitems->post_count==0 || ($recentitems->post_count==1 && $mainid==$post->ID)){
				echo "<p>Nothing to show yet.</p>";
			}

			if ( $recentitems->have_posts() ) while ( $recentitems->have_posts() ) : $recentitems->the_post(); 
				if ($mainid!=$post->ID) {
					$thistitle = get_the_title($ID);
					$thisURL=get_permalink($ID);
					echo "<div class='sidebox'>";
					echo "<h3><a href='{$thisURL}'>".$thistitle."</a></h3>";
					$thisdate= $post->post_date;
					$thisdate=date("j M Y",strtotime($thisdate));
					echo "<i class='icon-calendar'></i>".$thisdate;
					the_excerpt();
					echo "</div>";
				}
			endwhile; 
?>

							
				</div>
		</div>
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
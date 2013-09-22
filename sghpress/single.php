<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
<div class="row-fluid visible-phone">
			<div class="span3" id="secondarynav">
				<?php renderLeftNav(); ?>
			</div>
		</div>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
	
	$mainid=$post->ID;
?>
		
		<div class="row-fluid">

				<div class="span8" id='content'>
					<h1><?php the_title(); ?></h1>

					<p class='postmeta'><?php twentyten_posted_on(); ?></p>

					<?php the_content(); ?>

					<?php if ( (comments_open() || have_comments()) ) : ?>
						<div id='comments'>
							<?php comments_template( '', true ); ?>
						</div>						
					<?php endif; ?>
				
				
				</div>
				
				<div class="span4" id='sidebar'>
					<?php
										if ( has_post_thumbnail( $post->ID ) ) {
								$img = get_the_post_thumbnail($post->ID,'large') ;
								echo $img;
								
						} 

echo "<div id='newsposts'><br><hr><br>";
			$category = get_the_category(); 
			$recentitems = new WP_Query('category_name='.$category[0]->cat_name.'&posts_per_page=5');			
			echo "<h2>Recently published</h2>";

			if ($recentitems->post_count==0 || ($recentitems->post_count==1 && $mainid==$post->ID)){
				echo "<p>Nothing to show yet.</p>";
			}

			if ( $recentitems->have_posts() ) while ( $recentitems->have_posts() ) : $recentitems->the_post(); 
				if ($mainid!=$post->ID) {
					$thistitle = get_the_title($ID);
					$thisURL=get_permalink($ID);
					echo "<div class='newsitem'>";
					echo "<p><h3><a href='{$thisURL}'>".$thistitle."</a></h3><p>";
					$thisdate= $post->post_date;
					$thisdate=date("j M Y",strtotime($thisdate));
					echo "<span class='conference_date'>".$thisdate;
					echo "</div><div class='clearfix'></div><hr class='light' />";
				}
			endwhile; 
?>

							
				</div>
		</div>
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
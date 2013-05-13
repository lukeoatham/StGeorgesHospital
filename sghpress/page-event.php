<?php
/* Template name: Events page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="eightcol">
					<?php
					$courses = new WP_Query('post_type=events&posts_per_page=10');
					
					while ($events->have_posts()) {
				$events->the_post();
				$x = get_the_title();
				echo "<a href='".$post->guid."'>".$x."</a><br>";
				}

					
					?>
					</div>
					
					<div class="fourcol last">
					<div class="toptasks">
		
					</div>		
					</div>

				<hr>


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
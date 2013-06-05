<?php
/* Template name: Services page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">
					<div class="threecol" iid='secondarynav'>

				<?php 
				//list all services
						
						$allservices = get_posts(
							array(
							"post_type" => "service",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"post_parent" => 0
							)
						);
						
					foreach ($allservices as $service){
						echo "<a href='".$service->guid."'>".$service->post_title."</a><br>";
					} ?>
						
					</div>
					
					<div class="eightcol last">

					<?php 

					
					
					the_content(); 

						
					?>
					
					</div>
					


		


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
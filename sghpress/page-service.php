<?php
/* Template name: Services page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">
					<div class="ninecol" iid='secondarynav'>


				<?php 

					the_content(); ?>
					
<div id="sectionnav">
<ul>
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
						echo "<li class='page_item'><a href='".$service->guid."'>".$service->post_title."</a></li>";
					} 
?>
</ul>	
</div>						
					</div>
					
					<div class="threecol last">

					<?php 

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					


		


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
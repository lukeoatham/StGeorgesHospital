<?php
/* Template name: Clinicians page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="eightcol">
					<?php
					$clinicians = new WP_Query(
					array(
					"post_type"=>"people",
					"posts_per_page"=>10,
					"orderby"=>"meta_value",
					"order"=>"ASC",
					"meta_key"=>"last_name",
					"tax_query"=>array(array(
					"taxonomy"=>"people-types",
					"field"=>"slug",
					"terms"=>"clinician"
					))
					));	
					
					while ($clinicians->have_posts()) {
				$clinicians->the_post();
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
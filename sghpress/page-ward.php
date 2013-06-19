<?php
/* Template name: Wards page */

get_header();

$hospsite = $_GET['hospsite'];
if (!$hospsite){
	$hospsite="st-georges";
}
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">
					<div class="ninecol" iid='secondarynav'>


					
					<p><br><a href="/patients-and-visitors/our-wards/?hospsite=st-georges">St George's</a> | <a href="/patients-and-visitors/our-wards/?hospsite=queen-marys">Queen Mary's</a></p>

				<?php 

					the_content(); ?>

					
<div id="sectionnav">
<ul>
<?php
				//list all wards
						$wards = new WP_query(
							array(
							"post_type" => "ward",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"tax_query"=> array(array(
							"taxonomy"=>"sites",
							"terms"=>$hospsite,
							"field"=>"slug"
							)
							)
							)
						);

						//check each element in the array to see if it matches this service
						while ($wards->have_posts()) {
							$wards->the_post();
									echo "<div class='clearfix'>";
									echo "<h3><a href='".$post->guid."'>".$post->post_title."</a></h3>";
									echo "</div>";
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
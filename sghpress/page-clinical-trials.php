<?php
/* Template name: Clinical trials page */

get_header();

$hospsite = $_GET['hospsite'];
$paged = $_GET['paged'];
if (!$hospsite){
	$hospsite="st-georges";
}
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
					<div class="span3" id="secondarynav">
						<?php renderLeftNav(); ?>
					</div>
				
					<div class="span9">

					<h1><?php the_title() ; ?></h1>
				<?php the_content(); ?>
					



					
<ul class="nav nav-list">
<?php
				//list all wards
						$wards = new WP_query(
							array(
							"post_type" => "clinical-trials",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"paged"=>$paged,
							)
						);

						//check each element in the array to see if it matches this service
						while ($wards->have_posts()) {
							$wards->the_post();
									echo "<li><a href='".$post->guid."'>".$post->post_title."</a></li>";
								}
?>
</ul>	
					
					</div>
					
					<div class="span3">

					<?php 

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					

				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
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
				
					<div class="span9  <?php
					
					$parent = array_reverse(get_post_ancestors($post->ID));
					$first_parent = get_page($parent[0]);
					$parentSplit = split("-", $first_parent->post_name);
					$parentName = strtolower($parentSplit[0]);
					$lastLetter = substr($parentName, -1);
					if($lastLetter == "s" && $parentName != "news"){
						$parentName = substr($parentName, 0, (strlen($parentName) -1));
					}
 					echo $parentName."Content";
					
					?>" id="content">

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
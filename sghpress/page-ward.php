<?php
/* Template name: Wards page */

get_header();

$hospsite = $_GET['hospsite'];
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">
					<div class="ninecol" iid='secondarynav'>


				<?php 

					the_content(); ?>
					
<div id="sectionnav">
<ul>
<?php
				//list all services
						
						//find all locations for the chosen site
						
						$locations = get_posts(
							array(
							"post_type" => "location",
							"posts_per_page" => -1,
							"tax_query"=> array(array(
							"taxonomy"=>"sites",
							"terms"=>$hospsite,
							"field"=>"id"
							))
							)
						);
						$locarray = array();
						foreach ($locations as $location){
							$locarray[] = $location->ID;
						}
							//print_r($locarray);
						
						//find all the services for the found locations
						
						

						$wards = get_posts(
							array(
							"post_type" => "ward",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							)
						);


						foreach ($wards as $ward) {
							setup_postdata($ward); 
						//get array of services for this clinician	
						$locations=get_post_meta($ward->ID, 'location',false);

						//check each element in the array to see if it matches this service
						foreach ($locations as $location){ 
							print_r($location);
							foreach ($locarray as $loc) {		
								if ( $loc == $location) {
									echo "<div class='clearfix'><hr>";
									echo "<h3><a href='".$ward->guid."'>".$ward->post_title."</a></h3>";
									echo "</div>";
								}
							}
						}
					}


						
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
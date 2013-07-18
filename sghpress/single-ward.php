<?php
/**
 * The Template for displaying all single treatment posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
	
	$mainid=$post->ID;
?>

		<div class="row-fluid">
		
						<div class="span3" id='secondarynav'>

										
							<div class="menu-primary-navigation-container"><ul id="nav" class="menu"><li class="patient menu-item menu-item-type-post_type menu-item-object-page page_item page-item-7  current_section"><a href="/patients-and-visitors//">Patients and visitors</a><ul class="children"><li class="page_item page-item-230 current-menu-item current_page_item"><a href="/patients-and-visitors/our-wards/">Our wards</a></li>
</ul></div>						
												
					</div>	

				<div class="span6" id='content'>
					<h1><?php the_title(); ?></h1>

					<?php 
					
					the_content(); 
					
					
					//display contact information
					$contactnumber = get_post_meta($post->ID, 'telephone', true);
					if ($contactnumber){
						// display location details 
						echo "<div class='well'>";
						echo "<h3>Contact number</h3>";
						echo wpautop($contactnumber);
						echo "</div>";
					}

					
					$servicelocations = get_post_meta($post->ID, 'location', true);
					foreach ($servicelocations as $servicelocation){
						// display location details 
						echo "<div class='well'>";
						echo "<h3>Location</h3>";
						$location = get_post($servicelocation);
						echo $location->post_title;
						$longitude = get_post_meta($servicelocation,'longitude',true);
						$latitude = get_post_meta($servicelocation,'latitude',true);
						$loc = $latitude.",".$longitude;
						echo "<div class='google_map' style='background-image: url(\"https://maps.googleapis.com/maps/api/staticmap?center=".$loc."&amp;zoom=19&amp;size=320x320&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:blue|label:|".$loc."\")'>";
					echo "<img src='https://maps.googleapis.com/maps/api/staticmap?center=".$loc."&amp;zoom=19&amp;size=320x320&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:blue|label:|' alt='Venue map' /></div>";

						echo "</div>";
					}

						echo "<div class='well'>";
						echo "<h3>Key information</h3>";

						echo "<p><strong>Visiting times: </strong>";
						echo get_post_meta($post->ID, 'visiting_times', true);
						echo "</p>";

						echo "<p><strong>Protected meal times: </strong>";
						echo get_post_meta($post->ID, 'protected_meal_times', true);
						echo "</p>";
						
						echo "<p><strong>Maximum number of visitors: </strong>";
						echo get_post_meta($post->ID, 'maximum_number_of_visitors', true);
						echo "</p>";

						
						if ( get_post_meta($post->ID, 'children_visitors_allowed', true)  == 0 ) {
						echo "<p><strong>Children visitors are not allowed</strong>"; 
						} else {
						echo "<p><strong>Children visitors are allowed</strong>"; 
						}
						echo "</p>";
						
						$matrons = get_post_meta($post->ID, 'matron', true);
						foreach ($matrons as $matron){
							// display location details 
							echo "<p><strong>Matron: </strong>";
							$m = get_post($matron);
							echo "<a href='".$m->guid."'>";
							echo $m->post_title;
							echo "</a></p>";
						}

						$sisters = get_post_meta($post->ID, 'sister_in_charge', true);
						foreach ($sisters as $sister){
							// display location details 
							echo "<p><strong>Sister in charge: </strong>";
							$s = get_post($sister);
							echo "<a href='".$s->guid."'>";
							echo $s->post_title;
							echo "</a></p>";
						}
						
						echo "<p><strong>Number of beds: </strong>";
						echo get_post_meta($post->ID, 'number_of_beds', true);
						echo "</p>";

						if ( get_post_meta($post->ID, 'payg', true)  == 0 ) {
							echo "<p><strong>No TV</strong>"; 
						} else {
							echo "<p><strong>Pay as you go TV is available</strong>"; 
						}
						echo "</p>";

						if ( get_post_meta($post->ID, 'mobiles_and_laptops', true)  == 0 ) {
							echo "<p><strong>No mobiles or laptops allowed</strong>"; 
						} else {
							echo "<p><strong>Mobile and laptops are allowed</strong>"; 
						}
						echo "</p>";

						if ( get_post_meta($post->ID, 'wifi', true)  == 0 ) {
							echo "<p><strong>No WiFi</strong>"; 
						} else {
							echo "<p><strong>WiFi is available</strong>"; 
						}
						echo "</p>";
						echo "</div>";

					//display facilities information
					$facilities = get_post_meta($post->ID, 'facilities', true);
					if ($facilities){
						// display location details 
						echo "<div class='well'>";
						echo "<h3>Other facilities</h3>";
						echo wpautop($facilities);
						echo "</div>";
					}


					
					?>

				
				</div>
				
				<div class="span3" id='sidebar'>
<?php	
//display services associated with this ward
				
				$services = get_posts(
					array(
					"post_type"=>"service",
					"posts_per_page"=>-1,
					"orderby"=>"name",
					"order"=>"ASC",
					));	

					//run through each service to check if assigned to this ward
					
					foreach ($services as $service) {
					setup_postdata($service); 
						//get array of services for this ward	
						$servicesposts=get_post_meta($service->ID, 'wards',false);

						//check each element in the array to see if it matches this service
						foreach ($servicesposts as $servicespost){ 

							if ( in_array($mainid, $servicespost) ){
								if (!$donetitle){
									echo "<div class='well'><h3>Services</h3><ul class='nav nav-list'>";
									$donetitle=true;
								}
								echo "<li><a href='".$service->guid."'>".sghpress_custom_title($service->post_title)."</a></li>";

							}
						}
					}
					echo "</ul></div>";
	?>				
	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
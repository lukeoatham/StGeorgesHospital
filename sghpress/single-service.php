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

		<div class="row">
					<div class="threecol" iid='secondarynav'>

						<?php
						echo "<a href='/services/a-z/'>Services A-Z</a><br>";

						$parentpost = $post->post_parent; 
						if ($post->post_parent != 0) {
							$parentservice = get_post($parentpost);
							//print_r($parentservice);
						echo "<a href='".$parentservice->guid."'>".$parentservice->post_title."</a><br>";	
						}
						echo "<a href='".$post->guid."'>".$post->post_title."</a><br>";	
						
						$allservices = get_posts(
						array(
						"post_type" => "service",
						"posts_per_page" => -1,
						"orderby" => "post_title",
						"order" => "ASC",
						"post_parent" => $mainid
						)
					);
						
					foreach ($allservices as $service){
						echo "<a href='".$service->guid."'>".$service->post_title."</a><br>";
					}	 ?>
						
					</div>
				<div class="sixcol" id='content'>
					<h1><?php the_title(); ?></h1>

					<?php 
					//display contact information
					$contactnumber = get_post_meta($post->ID, 'contact_number', true);
					if ($contactnumber){
						// display location details 
						echo "<div class='message'>";
						echo "<h3>Contact number</h3>";
						echo wpautop($contactnumber);
						echo "</div>";
					}
					
					//display location information
					$servicelocations = get_post_meta($post->ID, 'location', true);
					foreach ($servicelocations as $servicelocation){
						// display location details 
						echo "<div class='message'>";
						echo "<h3>Location</h3>";
						$location = get_post($servicelocation);
						echo $location->post_title;
						$longitude = get_post_meta($servicelocation,'longitude',true);
						$latitude = get_post_meta($servicelocation,'$latitude',true);
						$loc = $latitude.",".$longitude;
						echo "<div class='google_map' style='background-image: url(\"https://maps.googleapis.com/maps/api/staticmap?center=".$loc."&amp;zoom=14&amp;size=640x640&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:blue|label:|".$loc."\")'>";
					echo "<img src='https://maps.googleapis.com/maps/api/staticmap?center=".$loc."&amp;zoom=14&amp;size=640x640&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:blue|label:|' alt='Venue map' /></div>";

						echo "</div>";
					}
										
					the_content(); 
						
					$moreinformation = get_post_meta($post->ID, 'more_information', true);
					if ($moreinformation !=''){
						// display more information 
						echo wpautop($moreinformation);
					}	
						
					?>


				
				</div>
				
				<div class="threecol last" id='sidebar'>
				
				<?php the_post_thumbnail('medium'); 
				
				//display clinicians associated with this service
				
				$clinicians = get_posts(
						array(
						"post_type" => "clinician",
						"posts_per_page" => -1,
						"orderby" => "post_title",
						"order" => "ASC",
						)
					);

					//run through each clinician to check if assigned to this service
					
					foreach ($clinicians as $clinician) {
					setup_postdata($clinician); 
						//get array of services for this clinician	
						$clinicianservices=get_post_meta($clinician->ID, 'service-relationship',false);

						//check each element in the array to see if it matches this service
						foreach ($clinicianservices as $clinicianservice){ 

							if ( in_array($mainid, $clinicianservice) ){
								if (!$donetitle){
									echo "<h3>Clinicians</h3>";
									$donetitle=true;
								}
								echo "<div class='clearfix'><hr>";
								echo "<h3><a href='".$clinician->guid."'>".$clinician->post_title."</a></h3>";
								echo get_the_post_thumbnail($clinician->ID,'clinicianthumb', array("class"=>"alignleft")); 
								$protitle= get_post_meta($clinician->ID,'professional_title',true);
								echo 
								"<p><a href='".$clinician->guid."'>".$protitle."</a></p></div>";

							}
						}
					}
					?>
						<ul class="xoxo">

							<?php if (is_home() || is_front_page()) : ?>
								<?php dynamic_sidebar( 'home-sidebar-widget-area' ); ?>
							<?php else : ?>
								<?php dynamic_sidebar( 'inside-sidebar-widget-area' ); ?>
							<?php endif; ?>
						</ul>
	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
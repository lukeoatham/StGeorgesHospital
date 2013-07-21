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
	global $mainid;
	$mainid=$post->ID;
?>

		<div class="row-fluid">
					<div class="span3" id='secondarynav'>
					
						<?php global $post; if ( (postHasChildren() || postHasChildren($post->post_parent)) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
						<?php
						//save current post 
						$temppost = $post;
						
						 // Find connected posts via Posts to Posts plugin
								$connected = new WP_Query( array(
								  'connected_type' => 'services_to_posts',
								  'connected_items' => get_queried_object(),
								  'nopaging' => true,
								) );
																											
								// Display connected posts
								if ( $connected->have_posts() ) {
									
									while ( $connected->have_posts() ) {
										$connected->the_post();
										$relatedposts .= "<li class='page-item'><a href='".get_permalink()."'>".get_the_title()." <i class='icon-share'></i></a></li>\n";
									}								
								}
																
								if ($relatedposts) {
								
									echo "<div class='menu'><ul class='service menu'>
												<ul class='children'>" . $relatedposts . "</ul></ul></div>";
								}
								//reinstate current post
								$post=$temppost;
								?>
					</div>
				<div class="span6" id='content'>
					<h1><?php the_title(); ?></h1>

					<?php 
					//display contact information
					$contactnumber = get_post_meta($post->ID, 'contact_number', true);
					if ($contactnumber){
						echo "<div class='well'>";
						echo "<h3>Contact number</h3>";
						echo wpautop($contactnumber);
						echo "</div>";
					}

					//display opening hours information
					$openinghours = get_post_meta($post->ID, 'opening_hours', true);
					if ($openinghours){
						echo "<div class='well'>";
						echo "<h3>Opening hours</h3>";
						echo wpautop($openinghours);
						echo "</div>";
					}
					
					//display location information
					$servicelocations = get_post_meta($post->ID, 'location', true);
					foreach ($servicelocations as $servicelocation){
						echo "<div class='well'>";
						echo "<h3>Location</h3>";
						$location = get_post($servicelocation);
						echo $location->post_title;
						$longitude = get_post_meta($servicelocation,'longitude',true);
						$latitude = get_post_meta($servicelocation,'latitude',true);
						$loc = $latitude.",".$longitude;
						
						?>
						
						<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
						<script>
							var map;
							function initialize() {
								var mapOptions = {
									zoom: 18,
									center: new google.maps.LatLng(<?php echo $loc; ?>),
									mapTypeId: google.maps.MapTypeId.ROADMAP
								};
								map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
								
								var marker = new google.maps.Marker({
									position: new google.maps.LatLng(<?php echo $loc; ?>),
									map: map,
									title: '<?php echo $location->post_title; ?>',
									animation: google.maps.Animation.DROP
								});
							}

							google.maps.event.addDomListener(window, 'load', initialize);
						</script>
						
						<div id="map-canvas" class="google_map"></div>
						
						<?php
						

						echo "</div>";
					}
										
					the_content(); 

					$treatments = get_post_meta($post->ID, 'treatments', true);
					if ($treatments !=''){
						echo wpautop($treatments); 					}	

					$team = get_post_meta($post->ID, 'team_profile', true);
					if ($team !=''){
						echo wpautop($team);
					}						

					$video = get_post_meta($post->ID, 'video', true);
					if ($video !=''){
						echo wpautop($video);
					}								

					$leaflets = get_post_meta($post->ID, 'leaflets', true);
					if ($leaflets !=''){
						echo "<h3>Leaflets</h3><ul id='leaflets'>";
						foreach ($leaflets as $leaflet){
						$attachlink = wp_get_attachment_url($leaflet);
							echo "<li><a href='".$attachlink."'>";
							echo get_the_title($leaflet);
							echo "</a></li>";
						}
						echo "</ul>";

					}	
						
					$moreinformation = get_post_meta($post->ID, 'more_information', true);
					if ($moreinformation !=''){
						echo wpautop($moreinformation);
					}	
						
					?>


				
				</div>
				
				<div class="span3" id='sidebar'>
				
				<?php the_post_thumbnail('medium'); 
				
				//display clinicians associated with this service
				
				$clinicians = get_posts(
					array(
					"post_type"=>"people",
					"posts_per_page"=>-1,
					"orderby"=>"meta_value",
					"order"=>"ASC",
					"meta_key"=>"last_name",
					"tax_query"=>array(array(
					"taxonomy"=>"people-types",
					"field"=>"slug",
					"terms"=>"clinician"
					))
					));	

					//run through each clinician to check if assigned to this service
					
					foreach ($clinicians as $clinician) {
					setup_postdata($clinician); 
						$clinicianservices=get_post_meta($clinician->ID, 'service-relationship',false);

						foreach ($clinicianservices as $clinicianservice){ 

							if ( in_array($mainid, $clinicianservice) ){
								if (!$donetitle){
									echo "<div class='sidebox'><h3>Clinicians</h3><ul>";
									$donetitle=true;
								}
								echo "<li><a href='".$clinician->guid."'>".$clinician->post_title."</a></li>";
							}
						}
					}
					if ($donetitle){
						echo "</ul></div>";
					}

					$wards=get_post_meta($post->ID, 'wards',true);
					if ($wards){
						$donetitle=false;
						foreach ($wards as $ward){
							if (!$donetitle){
								echo "<div class='sidebox'><h3>Wards</h3><ul>";
								$donetitle=true;
							}
							$w = get_post($ward);
							echo "<li><a href='".$w->guid."'>".$w->post_title."</a></li>";
						}
						echo "</ul></div>";
					}
						
					
				$referrals = get_posts(
					array(
					"post_type"=>"attachment",
					"posts_per_page"=>-1,
					"tax_query"=>array(array(
					"taxonomy"=>"category",
					"field"=>"slug",
					"terms"=>"referral-forms"
					))
					));	

					//run through each referrals to check if assigned to this service
					$donetitle=false;					
					foreach ($referrals as $referral) {
						setup_postdata($referral); 
						$referralservices=get_post_meta($referral->ID, 'service-relationship',false); //print_r($referralservices);
						foreach ($referralservices as $referralservice){ 

							if ( in_array($mainid, $referralservice) ){
								if (!$donetitle){
									echo "<div class='sidebox'><h3>Referral forms</h3><ul>";
									$donetitle=true;
								}
								//print_r($referralservice)	;
								$referrallink = get_attachment_link($referral->ID);
								echo "<li><a href='".$referrallink."'>".$referral->post_title."</a></li>";
							}
						}
					}
					if ($donetitle){
						echo "</ul></div>";
					}
					
					$linksbox = get_post_meta($post->ID, 'links_box', true);
					if ($linksbox){
						echo "<div class='sidebox'>";
						echo wpautop($linksbox);
						echo "</div>";
					}
								
								

						
							?>	

	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
<?php
/**
 * The Template for displaying all single location posts.
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
					
						<?php renderLeftNav(); ?>
											
				</div>
				<div class="span6" id='content'>
					<div id="mobhead">
						<h1><?php the_title() ; ?></h1>
					</div>

					<?php 
					
					//display location information
						$longitude = get_post_meta($post->ID,'longitude',true);
						$latitude = get_post_meta($post->ID,'latitude',true);
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
									
					the_content(); 
						
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
									echo "<div class='well'><h3>Clinicians</h3><ul>";
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
								echo "<div class='well'><h3>Wards</h3><ul>";
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
									echo "<div class='well'><h3>Referral forms</h3><ul>";
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
						echo "<div class='well'>";
						echo wpautop($linksbox);
						echo "</div>";
					}
								
								

						
							?>	

	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
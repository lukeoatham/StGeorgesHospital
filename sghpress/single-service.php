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
	<?php 
		$wpLink = get_permalink($post->ID);
		$siteURL = "http://".$_SERVER["HTTP_HOST"]."".$_SERVER["REQUEST_URI"];
		if($wpLink == $siteURL ){
	
	 ?>

		<div class="row-fluid">
					<div class="span3" id='secondarynav'>
					
						<?php global $post;
						
						 renderLeftNav(); 
								?>
					</div>
				<div class="span6 serviceContent" id='content'>
					<div id="mobhead">
						<h1><?php the_title() ; ?></h1>
					</div>

					<?php 
					
					//check the various sidebar boxes
					$contactnumber = get_post_meta($post->ID, 'contact_number', true);
					$openinghours = get_post_meta($post->ID, 'opening_hours', true);
					$servicelocations = get_field('service_locations'); //print_r($servicelocations);
					$treatments = get_post_meta($post->ID, 'treatments', true);
					$team = get_post_meta($post->ID, 'team_profile', true);
					$video = get_post_meta($post->ID, 'video', true);
					$leaflets = get_post_meta($post->ID, 'leaflets', true);
					$moreinformation = get_post_meta($post->ID, 'more_information', true);
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
					$wards=get_post_meta($post->ID, 'wards',true);
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
					$referralDetails = get_post_meta($post->ID,'service_referrals', true);
					$linksbox = get_post_meta($post->ID, 'links_box', true);
					
					
					
					// turn the clinician results into an array we can parse later (and check against)
					$clinicianObjects = array();
					foreach ($clinicians as $clinician) {
					//var_dump($clinician);
					//setup_postdata($clinician); 
						$clinicianservices=get_post_meta($clinician->ID, 'service-relationship',false);
						foreach ($clinicianservices as $clinicianservice){ 
							if ( in_array($mainid, $clinicianservice) ){
								$clinicianObject = array();
								$clinicianObject["guid"] = $clinician->guid;
								$clinicianObject["post_title"] = $clinician->post_title;
								array_push($clinicianObjects, $clinicianObject);
							}
						}
					}
					
					
					
					//run through each referrals to check if assigned to this service
					$referralObjects = array();				
					foreach ($referrals as $referral) {
						//setup_postdata($referral); 
						$referralservices=get_post_meta($referral->ID, 'service-relationship',false); //print_r($referralservices);
						foreach ($referralservices as $referralservice){ 

							if ( in_array($mainid, $referralservice) ){
								$referralObject = array();
								$referralObject["referrallink"] = get_attachment_link($referral->ID);
								$referralObject["referral_title"] = $referral->post_title;
								array_push($referralObjects, $referralObject);
							}
						}
					}
					
					

					
					?>
					<h4 class="visible-phone">On this page:</h4>
					<ul class="visible-phone content-list">
						<li><a href="#mcontent">Main content</a></li>
						<?php
							if($contactnumber){
								echo '<li><a href="#contactnumber">Contact details</a></li>';
							}
							if($openinghours){
								echo '<li><a href="#openinghours">Opening hours</a></li>';
							}
							if($servicelocations){
								echo '<li><a href="#servicelocations">Locations</a></li>';
							}
							if($treatments != ''){
								echo '<li><a href="#treatments">Treatments</a></li>';
							}
							if($team != ''){
								echo '<li><a href="#team">Staff members</a></li>';
							}
							if($leaflets != ''){
								echo '<li><a href="#leaflets">Patient information leaflets</a></li>';
							}
							if(count($clinicianObjects) > 0){
								echo '<li><a href="#clinicians">Clinicians</a></li>';
							}
							if($wards){
								echo '<li><a href="#wards">Wards</a></li>';
							}
							if(count($referralObjects) > 0){
								echo '<li><a href="#referralforms">Referral forms</a></li>';
							}
						?>
					</ul>
					<?php
					
					echo "<div id='mcontent'>";
					the_content(); 
					echo "</div>";
					
					//display contact information
					if ($contactnumber){
						echo "<div class='sidebox' id='contactnumber'>";
						echo "<h3 class='sideboxhead'>Contact details</h3>";
						echo wpautop($contactnumber);
						echo "</div>";
					}

					//display opening hours information
					if ($openinghours){
						echo "<div class='sidebox' id='openinghours'>";
						echo "<h3 class='sideboxhead'>Opening hours</h3>";
						echo wpautop($openinghours);
						echo "</div>";
					}
					
					//display location information
					$k=0;
					if(count($servicelocations) > 0){
						echo "<div class='sidebox' id='servicelocations'>";
						if(count($servicelocations) > 1){
							echo "<h3 class='sideboxhead'>Locations</h3>";
						}else{
							echo "<h3 class='sideboxhead'>Location</h3>";
						}
						echo "<div id=\"map-canvas\" class=\"google_map\"></div>";
						if(count($servicelocations) > 1){
							echo "<ul class=\"inline\">";
								$j = 0;
								foreach ($servicelocations as $servicelocation){
									echo "<li><a href=\"#\" id=\"site".$j."\" class=\"btn btn-link btn-large\">".$servicelocation["service_site"]->name."</a></li>";
									$j++;
								}
								echo "<li><a href=\"#\" id=\"allSitesZoom\" class=\"btn btn-link btn-large\">Show all sites</a></li>";
								echo "</ul>";
						}
						?>
						
						<script>
							var markers = new Array();
							<?php
								foreach ($servicelocations as $servicelocation){
									?>
									var marker<?php echo $k; ?> = new Object();
									
									<?php
									$floor = $servicelocation['service_floor'];
									$floorTitle = "";
									switch ($floor) {
										case 5:
											$floorTitle .= "5th floor ";
											break;
										case 4:
											$floorTitle .= "4th floor ";
											break;
										case 3:
											$floorTitle .= "3rd floor ";
											break;
										case 2:
											$floorTitle .= "2nd floor ";
						        			break;
										case 1:
											$floorTitle .= "1st floor ";
											break;
										case 'G':
											$floorTitle .= "Ground floor ";
											break;
										case 'B':
											$floorTitle .= "Basement floor ";
											break;
									}
										
									if ($servicelocation['service_wing']->name){	
										$floorTitle .= ", ".$servicelocation['service_wing']->name.", ";
									}
									
									
									$floorTitle .= $servicelocation['service_site']->name;
									
									?>
									
									marker<?php echo $k; ?>.locationName = "<?php echo $floorTitle; ?>";
									marker<?php echo $k; ?>.siteName = "<?php echo $servicelocation['service_site']->name; ?>";
									
									<?php	
									//echo "<a href='/contact-and-find-us/find-us/sites/?site=".$servicelocation['service_site']->slug."'>".$servicelocation['service_site']->name."</a></p>";
									
									$loc='';
									$loc = $servicelocation['service_long_lat'];
									if ($loc):
										?>
											marker<?php echo $k; ?>.locationLL = "<?php echo $loc; ?>";
											
										<?php
										endif;
									?>
										markers.push(marker<?php echo $k; ?>);
									<?php
										$k++;
										
								}
								?>

							var map;
							function initialize() {
								var mapOptions = {
									mapTypeId: google.maps.MapTypeId.ROADMAP
								};
								
								map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
								<?php
								$k = 0;
								foreach ($servicelocations as $servicelocation){
								?>
								
								var mapButton<?php echo $k; ?> = document.getElementById("site<?php echo $k; ?>");
								
								<?php
								$k++;
								}
								?>
								
								var allSitesButton = document.getElementById("allSitesZoom");
								
								var markerBounds = new google.maps.LatLngBounds();
								
								for(var i = 0; i < markers.length; i++){
									var LL = markers[i].locationLL.split(",");
									var markerLLforBounds = new google.maps.LatLng(LL[0], LL[1]);
									markerBounds.extend(markerLLforBounds);
								}
								
								
								
									<?php
									$k = 0;
									foreach ($servicelocations as $servicelocation){
									?>
										var LL = markers[<?php echo $k; ?>].locationLL.split(",");
										var siteMarker<?php echo $k; ?> = new google.maps.Marker({
											position: new google.maps.LatLng(LL[0], LL[1]),
											map: map,
											title: markers[<?php echo $k; ?>].locationName,
											animation: google.maps.Animation.DROP
										});
										
										var siteInfoWindow<?php echo $k; ?> = new google.maps.InfoWindow({
											content: markers[<?php echo $k; ?>].siteName
										});
										
										siteInfoWindow<?php echo $k; ?>.open(map, siteMarker<?php echo $k; ?>);
									
									<?php
									$k++;
									}
									?>
								if(markers.length > 1){
									map.fitBounds(markerBounds);
									map.panBy(0,-40);
								}else{
									map.setCenter(siteMarker0.getPosition());
									map.setZoom(17);
								}
								
							
								<?php 
								$k = 0;
								foreach ($servicelocations as $servicelocation){
								?>
									google.maps.event.addListener(siteMarker<?php echo $k; ?>, 'click', function(){
										map.setZoom(17);
										map.setCenter(siteMarker<?php echo $k; ?>.getPosition());
										siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].locationName);
										siteInfoWindow<?php echo $k; ?>.open(map, siteMarker<?php echo $k; ?>);
									});
									
									
									google.maps.event.addDomListener(mapButton<?php echo $k; ?>, 'click', function(e){
										e.preventDefault();
										map.setZoom(17);
										map.setCenter(siteMarker<?php echo $k; ?>.getPosition());
										siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].locationName);
										siteInfoWindow<?php echo $k; ?>.open(map, siteMarker<?php echo $k; ?>);
									});
									
									

								<?php
								$k++;
								}
								?>
								
								
								google.maps.event.addDomListener(allSitesButton, 'click', function(e){
										e.preventDefault();
										map.fitBounds(markerBounds);
										<?php 
											$k = 0;
											foreach ($servicelocations as $servicelocation){
										?>
											siteInfoWindow<?php echo $k; ?>.open(map, siteMarker<?php echo $k; ?>);
										<?php
											$k++;
											}
										?>
									});

								
								google.maps.event.addListener(map, 'zoom_changed', function(){
										var zoomLevel = map.getZoom();
										if(zoomLevel < 14){
										<?php 
											$k = 0;
											foreach ($servicelocations as $servicelocation){
										?>
											siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].siteName);
										<?php
											$k++;
											}
										?>
										}else{
											<?php 
											$k = 0;
											foreach ($servicelocations as $servicelocation){
										?>
											siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].locationName);
										<?php
											$k++;
											}
										?>
										}
									});
								
								
							}
							
							function loadScript(){
								var script = document.createElement('script');
								script.type = "text/javascript";
								script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize";
								document.body.appendChild(script);
							}
							
							window.onload = loadScript;
							
							//google.maps.event.addDomListener(window, 'load', initialize);
						</script>
						<?php
						
						
						echo "</div>";
							
					}
					

										
					
					
					if ($treatments !=''){
						echo "<div class='sidebox' id='treatments'><h3 class='sideboxhead'>Treatments</h3>";
						echo wpautop($treatments); 					
						echo "</div>";
					}	
					
					if ($team !=''){
						echo "<div class='sidebox' id='team'><h3 class='sideboxhead'>Key staff</h3>";
						echo wpautop($team);
						echo "</div>";
					}						

					
					if ($video !=''){
						echo wpautop($video);
					}								

					
					if ($leaflets !=''){
						echo "<h3 id='leaflets'>Leaflets</h3><ul>";
						foreach ($leaflets as $leaflet){
						$attachlink = wp_get_attachment_url($leaflet);
							echo "<li><a href='".$attachlink."'>";
							echo get_the_title($leaflet);
							echo "</a></li>";
						}
						echo "</ul>";

					}	

					if ($referralDetails){
						echo "<div class='sidebox' id='referralforms'><h3 class='sideboxhead'>Referrals</h3>";
						echo wpautop($referralDetails);
						echo "</div>";
					}
						
					
					if ($moreinformation !=''){
						echo wpautop($moreinformation);
					}	
						
					?>


				
				</div>
				
				<div class="span3 serviceContent" id='sidebar'>
				
				<?php 
					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium');
					if($thumbnail[0]){
					?>
					
					<script type="text/javascript" defer="defer">
						$(document).ready(function(){
							if($(".visible-phone").css("display") != "none"){
								$("#mobhead").addClass("active");
								$("#mobhead").css("background-image","url('<?php echo $thumbnail[0]; ?>')");
								
								$("body").animate({
                            	scrollTop: ($("#mobhead").offset().top)
                                }, "slow");
								
							}else{
								$("#sidebar").prepend('<img src="<?php echo $thumbnail[0]; ?>">');
							}
							
							
							
						});
					</script>
					<noscript>
						<img src="<?php echo $thumbnail[0]; ?>">
					</noscript>
				
				<?php
				}
					foreach ($clinicianObjects as $clinObj){ 
						if (!$donetitle){
							echo "<div class='sidebox' id='clinicians'><h3 class='sideboxhead'>Clinicians</h3><ul>";
							$donetitle=true;
						}
						echo "<li><a href='".$clinObj["guid"]."'>".$clinObj["post_title"]."</a></li>";
					}
					if ($donetitle){
						echo "</ul></div>";
					}

					
					if ($wards){
						$donetitle=false;
						foreach ($wards as $ward){
							if (!$donetitle){
								echo "<div class='sidebox' id='wards'><h3 class='sideboxhead'>Wards</h3><ul>";
								$donetitle=true;
							}
							$w = get_post($ward);
							echo "<li><a href='".$w->guid."'>".$w->post_title."</a></li>";
						}
						echo "</ul></div>";
					}
						
					
				

					//run through each referrals to check if assigned to this service
					$donetitle=false;					
					foreach ($referralObjects as $referral) {
						if (!$donetitle){
							echo "<div class='sidebox' id='referralforms'><h3 class='sideboxhead'>Referral forms</h3><ul>";
							$donetitle=true;
						}
						echo "<li><a href='".$referral["referrallink"]."'>".$referral["referral_title"]."</a></li>";
					}
					if ($donetitle){
						echo "</ul></div>";
					}
					
					
					if ($linksbox){
						echo "<div class='sidebox'>";
						echo wpautop($linksbox);
						echo "</div>";
					}
								
								
				}
						
							?>	

	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>

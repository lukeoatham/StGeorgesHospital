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
		if ($_SERVER["HTTPS"]) {
			$protocol = "https://";
		} else {
			$protocol = "http://";
		}

		$siteURL = $protocol.$_SERVER["HTTP_HOST"]."".$_SERVER["REQUEST_URI"];
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
					foreach ((array)$clinicians as $clinician) {
					//var_dump($clinician);
					//setup_postdata($clinician); 
						$clinicianservices=get_post_meta($clinician->ID, 'service-relationship',false); 
						foreach ((array)$clinicianservices as $clinicianservice){ 
							if (@in_array($mainid, $clinicianservice) ){
								$clinicianObject = array();
								$clinicianObject["guid"] = $clinician->guid;
								$clinicianObject["post_title"] = $clinician->post_title;
								array_push($clinicianObjects, $clinicianObject);
							}
						}
					}
					
					
					
					//run through each referrals to check if assigned to this service
					$referralObjects = array();				
					foreach ((array)$referrals as $referral) {
						//setup_postdata($referral); 
						$referralservices=get_post_meta($referral->ID, 'service-relationship',false); //print_r($referralservices);
						foreach ((array)$referralservices as $referralservice){ 

							if (@in_array($mainid, $referralservice) ){
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
					$sitesArray = array();
					$sameSiteMode = false;
					foreach ((array)$servicelocations as $servicelocation){
						$keyToUse = $servicelocation["service_site"]->name;
						if($sitesArray[$keyToUse]){
							$sameSiteMode = true;
							array_push($sitesArray[$keyToUse], $servicelocation);
						}else{
							$sitesArray[$keyToUse] = array();
							array_push($sitesArray[$keyToUse], $servicelocation);
						}
					}
					
					
					if(count($servicelocations) > 0){
						echo "<div class='sidebox' id='servicelocations'>";
						if(count($servicelocations) > 1){
							echo "<h3 class='sideboxhead'>Locations</h3>";
						}else{
							echo "<h3 class='sideboxhead'>Location</h3>";
						}
						echo "<div id=\"map-canvas\" class=\"google_map\"></div>";
						echo "<div class=\"btn-group btn-group-vertical span6\">";
						if(count($servicelocations) > 1){
								$j = 0;
								$printedSites = array();
								foreach ((array)$sitesArray as $key => $val){
									if($sameSiteMode){
										if(!in_array($key, $printedSites)){
											echo "<h4 class=\"siteHeading\">".$key."</h4>";
											array_push($key, $printedSites);
										}
										foreach((array)$sitesArray[$key] as $serv){
											if($serv["service_wing"]->name){
												echo "<button id=\"site".$j."\" class=\"btn btn-link\">".$serv["service_wing"]->name."</button>";
											}else{
												echo "<button id=\"site".$j."\" class=\"btn btn-link\">".$serv["service_site"]->name."</button>";
											}
											$j++;
										}
										
									}else{
										echo "<button id=\"site".$j."\" class=\"btn btn-link\">".$servicelocation["service_site"]->name."</button>";
										$j++;
									}
								}
								if($sameSiteMode){
									echo "<h4 class=\"siteHeading\">Show all sites</h4>";
								}
								echo "<button id=\"allSitesZoom\" class=\"btn btn-link\">Show all sites</button>";
								
						}
						echo "</div>";
						?>
						<div id="startDest" class="span4">
							<div class="input-append">
								<input type="text" id="postcode" aria-labelledby="PostcodeSearchLabel" />
								<button class="btn dirButton" type="submit" id="dirBut">
								<script type="text/javascript">
									var imageURL = "<?php echo get_stylesheet_directory_uri(); ?>/images/search";
									if (Modernizr.svg){
										jQuery(".dirButton").html("<img src=\"" + imageURL + ".svg\" alt=\"Search\">");
									}else{
										jQuery(".dirButton").html("<img src=\"" + imageURL + ".gif\" alt=\"Search\">");
									}
									</script>
									<noscript><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search.gif" alt="Search"></noscript>
								</button>
						</div>
						<p class="dirs"><strong>Get directions</strong><br>
						<small>Enter your postcode into the box above for directions</small></p>
						<p id="map_error" class="alert" style="display: none;"><strong>No routes found</strong> The location entered couldn't be found, please check for typo or try a broader search.</p>
						<p id="tech_error" class="alert alert-error" style="display: none;"><strong>Technical error</strong> There's been a problem with the Google Map. Please <a href="mailto:communications@stgeorges.nhs.uk?subject=Google%20Maps%20Error%">email the communications team</a> and let them know.</p>
						</div>
						<div class="clearfix"></div>
						<div id="advanced" style="display: none;">
							<h4>Travel mode</h4>
							<select id="travelMode" onchange="calcRoute();">
								<option value="DRIVING" selected>Driving</option>
								<option value="WALKING">Walking</option>
								<option value="BICYCLING">Bicycling</option>
								<option value="TRANSIT">Public transport</option>
							</select>
						</div>
						<div id="directions-panel"></div>
						<script>
							var markers = new Array();
							<?php
								foreach ((array)$sitesArray as $key => $val){
									foreach((array)$sitesArray[$key] as $serv){
									?>
									var marker<?php echo $k; ?> = new Object();
									
									<?php
									$floor = $serv['service_floor'];
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
										
									if ($serv['service_wing']->name){	
										$floorTitle .= ", ".$serv['service_wing']->name.", ";
									}
									
									
									$floorTitle .= $serv['service_site']->name;
									
									?>
									
									marker<?php echo $k; ?>.locationName = "<?php echo $floorTitle; ?>";
									marker<?php echo $k; ?>.siteName = "<?php echo $serv['service_site']->name; ?>";
									
									<?php	
									//echo "<a href='/contact-and-find-us/find-us/sites/?site=".$servicelocation['service_site']->slug."'>".$servicelocation['service_site']->name."</a></p>";
									
									$loc='';
									$loc = $serv['service_long_lat'];
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
								}
								?>

							var map;
							var directionsDisplay;
							var activeMarker = "";
							var directionsService;
							
							function initialize() {
								directionsDisplay = new google.maps.DirectionsRenderer();
								directionsService = new google.maps.DirectionsService();
								var mapOptions = {
									mapTypeId: google.maps.MapTypeId.ROADMAP
								};
								
								map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
								
								
								directionsDisplay.setMap(map);
								directionsDisplay.setPanel(document.getElementById("directions-panel"));
								
								<?php
								$k = 0;
								foreach ((array)$sitesArray as $key => $val){
									foreach((array)$sitesArray[$key] as $serv){
								?>
								<?php if(count($servicelocations) > 1){ ?>
									var mapButton<?php echo $k; ?> = document.getElementById("site<?php echo $k; ?>");
								<?php } ?>
								<?php
								$k++;
								}
								}
								?>
								
								<?php if(count($servicelocations) > 1){ ?>
									var allSitesButton = document.getElementById("allSitesZoom");
								<?php } ?>
								var startDest = document.getElementById("startDest");
								var postcodeBox = document.getElementById("postcode");
								var dirbut = document.getElementById("dirBut");
								
								var markerBounds = new google.maps.LatLngBounds();
								
								for(var i = 0; i < markers.length; i++){
									var LL = markers[i].locationLL.split(",");
									var markerLLforBounds = new google.maps.LatLng(LL[0], LL[1]);
									markerBounds.extend(markerLLforBounds);
								}
								
								
								
									<?php
									$k = 0;
									foreach ((array)$sitesArray as $key => $val){
										foreach((array)$sitesArray[$key] as $serv){
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
									}
									?>
								if(markers.length > 1){
									map.fitBounds(markerBounds);
									map.panBy(0,-40);
									activeMarker = siteMarker0.getPosition();
								}else{
									map.setCenter(siteMarker0.getPosition());
									map.setZoom(17);
									activeMarker = siteMarker0.getPosition();
								}
								
							
								<?php 
								$k = 0;
								foreach ((array)$sitesArray as $key => $val){
									foreach((array)$sitesArray[$key] as $serv){
								?>
									google.maps.event.addListener(siteMarker<?php echo $k; ?>, 'click', function(){
										map.setZoom(17);
										map.setCenter(siteMarker<?php echo $k; ?>.getPosition());
										siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].locationName);
										siteInfoWindow<?php echo $k; ?>.open(map, siteMarker<?php echo $k; ?>);
										activeMarker = siteMarker<?php echo $k; ?>.getPosition();
										if(postcodeBox.value != ""){
											calcRoute();
										}
									});
									
									<?php if(count($servicelocations) > 1){ ?>
									google.maps.event.addDomListener(mapButton<?php echo $k; ?>, 'click', function(e){
										e.preventDefault();
										map.setZoom(17);
										map.setCenter(siteMarker<?php echo $k; ?>.getPosition());
										siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].locationName);
										siteInfoWindow<?php echo $k; ?>.open(map, siteMarker<?php echo $k; ?>);
										activeMarker = siteMarker<?php echo $k; ?>.getPosition();
										if(postcodeBox.value != ""){
											calcRoute();
										}
									});
									<?php } ?>
									

								<?php
								$k++;
								}
								}
								?>
								
								
								<?php if(count($servicelocations) > 1){ ?>
									google.maps.event.addDomListener(allSitesButton, 'click', function(e){
										e.preventDefault();
										if(markers.length > 1){
											map.fitBounds(markerBounds);
											activeMarker = siteMarker0.getPosition();
										}else{
											map.setCenter(siteMarker0.getPosition());
											map.setZoom(17);
											activeMarker = siteMarker0.getPosition();
										}										<?php 
											$k = 0;
											foreach ((array)$sitesArray as $key => $val){
												foreach((array)$sitesArray[$key] as $serv){
										?>
											siteInfoWindow<?php echo $k; ?>.open(map, siteMarker<?php echo $k; ?>);
										<?php
											$k++;
											}
											}
										?>
									});
								<?php } ?>
								
								google.maps.event.addListener(map, 'zoom_changed', function(){
										var zoomLevel = map.getZoom();
										if(zoomLevel < 14){
										<?php 
											$k = 0;
											foreach ((array)$sitesArray as $key => $val){
												foreach((array)$sitesArray[$key] as $serv){		?>
											siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].siteName);
										<?php
											$k++;
											}
											}
										?>
										}else{
											<?php 
											$k = 0;
											foreach ((array)$sitesArray as $key => $val){
												foreach((array)$sitesArray[$key] as $serv){
										?>
											siteInfoWindow<?php echo $k; ?>.setContent(markers[<?php echo $k; ?>].locationName);
										<?php
											$k++;
											}
											}
										?>
										}
									});
									
								google.maps.event.addDomListener(dirbut, 'click', function(e){
									calcRoute();
								});
									
								
								
								
							}
							
							
							function calcRoute(){
								var start = document.getElementById("postcode").value;
								var travelMode = document.getElementById("travelMode").value;
								var end = activeMarker;
								var request = {
									origin: start,
									destination: end,
									travelMode: google.maps.TravelMode[travelMode]
								};
								directionsService.route(request, function(response, status){
									if(status == google.maps.DirectionsStatus.OK){
										document.getElementById("map_error").style.display = "none";
										document.getElementById("tech_error").style.display = "none";
										document.getElementById("advanced").style.display = "block";
										document.getElementById("directions-panel").style.display = "block";
										directionsDisplay.setDirections(response);
									}
									if(status == google.maps.DirectionsStatus.INVALID_REQUEST || status == google.maps.DirectionsStatus.NOT_FOUND || status == google.maps.DirectionsStatus.ZERO_RESULTS){
										//Do something to tell the user that their request returned no results and to use their postcode
										document.getElementById("map_error").style.display = "block";
										document.getElementById("tech_error").style.display = "none";
										document.getElementById("advanced").style.display = "none";
										document.getElementById("directions-panel").style.display = "none";
									}
									if(status == google.maps.DirectionsStatus.OVER_QUERY_LIMIT || status == google.maps.DirectionsStatus.REQUEST_DENIED || status == google.maps.DirectionsStatus.UNKNOWN_ERROR){
										// Do something to tell the user that their was a technical fault and to send and email
										document.getElementById("map_error").style.display = "none";
										document.getElementById("tech_error").style.display = "block";
										document.getElementById("advanced").style.display = "none";
										document.getElementById("directions-panel").style.display = "none";
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
							
						</script>
						<?php
						
						
						echo "</div>";
							
					}
					

					echo "<div class=\"clearfix\"></div>";				
					
					
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
						foreach ((array)$leaflets as $leaflet){
						$attachlink = wp_get_attachment_url($leaflet);
							echo "<li class='no-bullet'><a href='".$attachlink."'>";
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
					foreach ((array)$clinicianObjects as $clinObj){ 
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
						foreach ((array)$wards as $ward){
							if (!$donetitle){
								echo "<div class='sidebox' id='wards'><h3 class='sideboxhead'>Wards</h3><ul>";
								$donetitle=true;
							}
							$w = get_post($ward);
							echo "<li><a href='".$w->guid."'>".$w->post_title."</a></li>";
						}
						echo "</ul></div>";
					}
						
					
					$relatedpages = get_post_meta ($post->ID, 'related_pages', true);
					if ($relatedpages){
						echo "<h3>Related pages</h3><ul>";
						foreach ((array)$relatedpages as $rp){
							$rptitle = get_the_title($rp);
							$rppost = get_post($rp);
							$rpperm = get_permalink($rp);
							echo "<li><a href='".$rpperm."'>".$rptitle."</a></li>";
						}
						echo "</ul>";
					}
					

					//run through each referrals to check if assigned to this service
					$donetitle=false;					
					foreach ((array)$referralObjects as $referral) {
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
				<h3>Further information for GPs</h3>
				<ul>
				<li><a href="https://www.stgeorges.nhs.uk/gps-and-clinicians/services/outpatient-service-directory/">Outpatient service delivery</a></li>
				</ul>
	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>

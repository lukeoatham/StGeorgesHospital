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
					
					
<div class="menu-primary-navigation-container">
<ul id="nav" class="menu">
						<?php
						//build the left hand navigation based on the current page

						$navarray = array();
						$currentpost = get_post($post->ID);
						
						while (true){
							//iteratively get the post's parent until we reach the top of the hierarchy
							
							$post_parent = $currentpost->post_parent; 
							
							if ($post_parent!=0){	//if found a parent

								$navarray[] = $post_parent;
								$currentpost = get_post($post_parent);
								continue; //loop round again
							}
							break; //we're done with the parents
						};
						$navarray = array_reverse($navarray);
						$navarray[] = $mainid;	//set current page in the nav array
						//get children pages
						$allservices = get_posts( 
						array(
						"post_type" => "service",
						"posts_per_page" => -1,
						"orderby" => "title",
						"order" => "ASC",
						"post_parent" => $mainid
						)
					);
						
					foreach ($allservices as $service){ //fill the nav array with the child pages
						$navarray[] = $service->ID;
//						echo "<li class='service menu-item menu-item-type-post_type menu-item-object-page'><a href='".$service->guid."'>".sghpress_custom_title($service->post_title)."</a></li>";
					}	 
					echo "<li class='service menu-item menu-item-type-post_type menu-item-object-page'><a href='/services/a-z/'>&laquo; Services A-Z</a></li>"; //top level menu item
					$subs=false;
					foreach ($navarray as $nav){ //loop through nav array outputting menu options as appropriate (parent, current or child)
						$currentpost = get_post($nav);
						if ($nav == $mainid){
						 	$subs = true;
						 	echo "<li class='service menu-item-type-post_type menu-item-object-page current-menu-item page-item'>"; //current page
						} elseif ($subs) {
							echo "<li class='page-item'>"; //child page
						} else {
							echo "<li class='service menu-item menu-item-type-post_type menu-item-object-page'>"; //parent page
						}
						echo "<a href='".$currentpost->guid."'>".$currentpost->post_title."</a></li>";
					}					
					?>
</ul>	
</div>
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
						echo "<div class='google_map' style='background-image: url(\"https://maps.googleapis.com/maps/api/staticmap?center=".$loc."&amp;zoom=19&amp;size=640x320&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:blue|label:|".$loc."\")'>";
					echo "<img src='https://maps.googleapis.com/maps/api/staticmap?center=".$loc."&amp;zoom=19&amp;size=640x320&amp;maptype=roadmap&amp;sensor=false&amp;markers=color:blue|label:|' alt='Venue map' /></div>";

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
									echo "<h3>Clinicians</h3><ul>";
									$donetitle=true;
								}
								echo "<li><a href='".$clinician->guid."'>".$clinician->post_title."</a></li>";
							}
						}
					}
					echo "</ul>";
					
					$wards=get_post_meta($post->ID, 'wards',true);
					if ($wards){
						$donetitle=false;
						foreach ($wards as $ward){
							if (!$donetitle){
								echo "<h3>Wards</h3><ul>";
								$donetitle=true;
							}
							$w = get_post($ward);
							echo "<li><a href='".$w->guid."'>".$w->post_title."</a></li>";
						}
						echo "</ul>";
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
									echo "<h3>Referral forms</h3><ul>";
									$donetitle=true;
								}
								//print_r($referralservice)	;
								$referrallink = get_attachment_link($referral->ID);
								echo "<li><a href='".$referrallink."'>".$referral->post_title."</a></li>";
							}
						}
					}
					echo "</ul>";

					?>
	<?php
							
								// Find connected posts via Posts to Posts plugin
								$connected = new WP_Query( array(
								  'connected_type' => 'services_to_posts',
								  'connected_items' => get_queried_object(),
								  'nopaging' => true,
								) );
											
								//print_r($connected);
																
								// Display connected posts
								if ( $connected->have_posts() ) {
									
									while ( $connected->have_posts() ) {
										$connected->the_post();
										$relatedposts .= "<li><a href='".get_permalink()."'>".get_the_title()."</a></li>\n";
									}								
								}
																
								if ($relatedposts) {
								
									echo "<ul class='xoxo'>
											<li class='widget-container'>
												<div id='related'><h3 class='widget-title'>Related services</h3><ul class='relatedposts'>" . $relatedposts . "</ul></div>
											</li>
										</ul>";
								}
								

						
							?>	

	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
<?php
/* Template name: Sites page */

get_header();

$r = $_SERVER['REQUEST_URI']; 
$r = explode('/', $r);
$site=$r[2];

wp_redirect( home_url()."/contact-and-find-us/find-us/sites/?site=".$r[2],301 ); exit;
 ?>

<?php 
	if ( have_posts() )
		the_post();

	
//	echo $post->post_name;
?>

				<div class="row-fluid">
				
				<div class="span3" id='secondarynav'>

										
							<?php // renderLeftNav() ?>
												
					</div>	
				
					<div class="span9 <?php
					
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

<?php	$showsite =  get_term_by( 'slug', $site, 'sites' );
	//print_r($showsite);
	echo "<h1>".$showsite->name."</h1>"; 
	
	$siteid = $showsite->term_id;
	
	
	global $wpdb;
    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_address'";
    
    $site_meta = $wpdb->get_results( $q );		
    $siteData = explode("|",wpautop($site_meta[0]->option_value));

    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_contact'";
    $site_meta = $wpdb->get_results( $q );
    $siteTel = wpautop($site_meta[0]->option_value);

    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_long_lat'";
    $site_meta = $wpdb->get_results( $q );	
    $loc = $site_meta[0]->option_value;
    $loc = substr($loc,strpos($loc,"|")+1,strlen($loc));

    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_service_information'";
    $site_meta = $wpdb->get_results( $q );
    $siteService = wpautop($site_meta[0]->option_value);

    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_travel_information'";
    $site_meta = $wpdb->get_results( $q );
    $siteTravel = wpautop($site_meta[0]->option_value);
    
    
?>

			<div class="row-fluid">
				<?php if ($loc): ?>
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
									title: '<?php echo "title"; ?>',
									animation: google.maps.Animation.DROP
								});
							}

							google.maps.event.addDomListener(window, 'load', initialize);
						</script>
						
						<div id="map-canvas" class="google_map pull-right span7"></div>
						<?php endif; ?>
					<h4>Address</h4>
					<address>
					<?php echo $siteData[0];  ?>
					</address>
					<h4>Contact details</h4>
					<?php  echo $siteTel; 
					if ($siteService):	
					?>
					<h4>Service information</h4>
					<?php  echo $siteService; 
					endif;
					if ($siteTravel):
					?>
					<h4>Travel information</h4>
					<?php  echo $siteTravel; 
					endif;
					?>
			
				
				<?php echo wpautop($showsite->description);?>
			</div>
						

					
					</div>
					
					<div class="span3">

					<?php 

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					

				</div>
					
				



<?php get_footer(); ?>
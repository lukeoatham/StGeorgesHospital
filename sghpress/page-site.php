<?php
/* Template name: Sites page */

get_header();

$site = $_GET['site'];
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
				
				<div class="span3" id='secondarynav'>

										
							<?php renderLeftNav() ?>
												
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

<?php if (!$site){ // LIST ALL SITES 
?>
					<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
					
					<?php //display filter terms
						$sites = get_terms('sites',array("hide_empty"=>false)); 
						foreach ($sites as $s){
							echo "<div class=\"media\">";
							
							
							global $wpdb;
							$q = "select option_value from wp_options where option_name = 'sites_".$s->term_id."_site_featured_image'";
							$site_meta = $wpdb->get_results( $q );
							$siteFIid = $site_meta[0]->option_value;
							
							
							$q = "select option_value from wp_options where option_name = 'sites_".$s->term_id."_site_address'";
    
							 $site_meta = $wpdb->get_results( $q );		
							 $siteData = explode("|",wpautop($site_meta[0]->option_value));

							 $q = "select option_value from wp_options where option_name = 'sites_".$s->term_id."_site_contact'";
							 $site_meta = $wpdb->get_results( $q );
							 $siteTel = wpautop($site_meta[0]->option_value);
							
							
							$postThumb = wp_get_attachment_image_src($siteFIid, array(75,75));
							
							if(!$postThumb){
								$postThumb = "/wp-content/themes/sghpress/images/1x1.png";
							}else{
								$postThumb = $postThumb[0];
							}
							
							echo "<div class=\"media-object pull-left\"><a href='/contact-and-find-us/find-us/sites/?site=".$s->slug."'><img src=\"".$postThumb."\" class=\"service-thumbnail\"></a></div>";
							
							echo "<div class=\"media-body\"><h4><a href=\"/contact-and-find-us/find-us/sites/?site=".$s->slug."\">".$s->name."</a></h4>";
							
							echo "<div class=\"row-fluid\">";
							
							echo "<div class=\"span3\">".str_replace("<p>","<p><strong>Address:</strong><br>",$siteData[0])."</div>";
							
							echo "<div class=\"span5\">".preg_replace("/<p>/","<p><strong>Tel:</strong><br>",$siteTel, 1)."</div>";
							
							echo "</div>";
							
							echo "</div>";
							
							echo "</div>";
						}
				 ?>
					</ul>

<?php } else { //LIST SINGLE SITE

	$showsite =  get_term_by( 'slug', $site, 'sites' );
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
						
<?php } ?>
					
					</div>
					
					<div class="span3">

					<?php 

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					

				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
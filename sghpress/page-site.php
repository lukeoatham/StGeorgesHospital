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
				
					<div class="span9">

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
							
							
							$postThumb = wp_get_attachment_image_src($siteFIid, array(75,75));
							
							if(!$postThumb){
								$postThumb = "http://placehold.it/75x75";
							}else{
								$postThumb = $postThumb[0];
							}
							
							echo "<div class=\"media-object pull-left\"><a href='/contact-and-find-us/find-us/sites/?site=".$s->slug."'><img src=\"".$postThumb."\" class=\"service-thumbnail\"></a></div>";
							
							echo "<div class=\"media-body\"><h4><a href=\"/contact-and-find-us/find-us/sites/?site=".$s->slug."\">".$s->name."</a></h4></div>";
							
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
    
    
?>

			<div class="row-fluid">
				<div class="span4">
					<h4>Address</h4>
					<address>
					<?php echo $siteData[0];  ?>
					</address>
					<h4>Contact details</h4>
					<?php  echo $siteTel; ?>
				</div>
				<div class="span1"></div>
				<div class="span7">
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
						
						<div id="map-canvas" class="google_map span11"></div>

				</div>
			</div>
			
			<div class="row-fluid">
	
				<?php echo $showsite->description;?>
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
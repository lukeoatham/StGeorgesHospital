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
				
					<div class="span6">

<?php if (!$site){ // LIST ALL SITES 
?>
					<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
					
					<ul class="nav">
					<?php //display filter terms
						$sites = get_terms('sites',array("hide_empty"=>false)); 
						foreach ($sites as $s){
							echo "<li><a href='/contact-and-find-us/find-us/sites/?site=".$s->slug."'>".$s->name."</a></li>";
						}
				 ?>
					</ul>

<?php } else { //LIST SINGLE SITE

	$showsite =  get_term_by( 'slug', $site, 'sites' );
	//print_r($showsite);
	echo "<h1>".$showsite->name."</h1>"; 
	
	//Retrieve meta fields from options table for each field
	
	echo "<p>".$showsite->description."</p>";
	
	$siteid = $showsite->term_id;
	
    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_address'";
    global $wpdb;
    $site_meta = $wpdb->get_results( $q );		
    echo wpautop($site_meta[0]->option_value);

    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_contact'";
    global $wpdb;
    $site_meta = $wpdb->get_results( $q );		
    echo wpautop($site_meta[0]->option_value);

    $q = "select option_value from wp_options where option_name = 'sites_".$siteid."_site_long_lat'";
    global $wpdb;
    $site_meta = $wpdb->get_results( $q );	
    $loc = $site_meta[0]->option_value;
    $loc = substr($loc,strpos($loc,"|")+1,strlen($loc));


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
									title: '<?php echo "title"; ?>',
									animation: google.maps.Animation.DROP
								});
							}

							google.maps.event.addDomListener(window, 'load', initialize);
						</script>
						
						<div id="map-canvas" class="google_map"></div>

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
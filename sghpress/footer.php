<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?>
</div>
			<div id="ourvalues" class="row-fluid">
				<div class="container-fluid">
					<div class="span8">
						<?php dynamic_sidebar( 'values-widget-area1' ); ?>
					</div>
					<div class="span4">
						<?php dynamic_sidebar( 'values-widget-area2' ); ?>
					</div>
				</div>
			</div>
		
			<div class="row-fluid" id='footer'>
				<div class="container-fluid">
					<div class="navbar navbar-inverse navbar-fixed-bottom">
								<?php dynamic_sidebar( 'footer-sponsor-area' ); ?>				
					</div>
				</div>

				<div class="container-fluid">
					<div class="span5">
						<h3>News</h3>
						<?php
							$customquery = new WP_Query(array(
							"post_type" => "newsitem",
							"posts_per_page" => 5,
							)

							);
								
							if ( $customquery->have_posts() ) {
								$k=0; //counter to check first 2
								while ( $customquery->have_posts() ) {
									$customquery->the_post();
									$k++;
									echo "<div class='media'>";?>
										    <?php
									if ( has_post_thumbnail( $post->ID ) && $k<3 ) {
										    echo "<a class='pull-left' href=".get_permalink().">";
										    //$mediaimage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'clinicianthumb');
										    //echo "<img class='media-object' src='".$mediaimage[0]."'>";
										    the_post_thumbnail('clinicianthumb');
											echo "</a>";
	    									}
	    									?>
										<?php 
										echo "<div class='media-body'><strong><a href='" .get_permalink() . "'>" . get_the_title() . "</a></strong>";
										if ($k<3){
										the_excerpt();
										}
?></div></div>
<?php

								}
							}
							
							wp_reset_query();

						?>
					</div>
					<div class="span4">
						<h3>All services A-Z</h3> 
				<div class="input-append">
				  <label for="selectf3">Jump to:</label>
				  <select id="selectf3" >
				<?php  
					$allservices = get_posts(
							array(
							"post_type" => "service",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"post_parent" => 0
							)
						);
						echo "<option value=''>Choose a service</option>"; 
					foreach ($allservices as $service){
						echo  '<option ';
						
						echo ' value="'.$service->guid.'">'.$service->post_title.' </option>';
					}
					?>
					  </select>
					  <button class="btn" type="button" onclick="goToPage('selectf3')">Go</button>
					</div>					

		
					<script>
					function goToPage( id ) {
					
					  var node = document.getElementById( id );
					  
					  // Check to see if valid node and if node is a SELECT form control
					  
					  if( node &&
					    node.tagName == "SELECT" ) {
					
					    // Go to web page defined by the VALUE attribute of the OPTION element
					
					    window.location.href = node.options[node.selectedIndex].value;
					    
					  } // endif
					  
					}
					</script>	
					
					<h3>Find a local health centre</h3> 
						<div class="input-append">
						  <select id="selectf4" >
						<?php  
							$allservices = get_terms("sites",
									array(
									"orderby" => "name",
									"order" => "ASC",
									"hide_empty"=>false
									)
								);
								echo "<option value=''>Choose a health centre</option>"; 
							foreach ($allservices as $service){// print_r($service);
					  		    $themeid = $service->term_id;
					  		    $q = "select option_value from wp_options where option_name = 'sites_".$themeid."_site_type'";
					  		    global $wpdb;
					  		    $theme_term = $wpdb->get_results( $q );					
								if ($theme_term[0]->option_value == "Health Centre"){
									echo  '<option ';
									echo ' value="/contact-and-find-us/find-us/sites/?site='.$service->slug.'">'.$service->name.' </option>';
								}
							}
							
							?>
							  </select>
							  <button class="btn" type="button" onclick="goToPage('selectf4')">Go</button>
							</div>	

							<?php dynamic_sidebar( 'footer-widget-area2' ); ?>
							
							
					</div>
					<div class="span3">
						<h3>Do it online</h3>
							<?php
					$defaults = array(
					'menu'            => 'do-it-online',
					'container'       => 'div',
					'menu_class'      => 'menu',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'           => 0,
				);
				
				wp_nav_menu( $defaults );
				?>
					</div>
				</div>
			</div>

		
		<div id="backToTop" class="visible-phone">
			<a href="#mobhead">^</a>
		</div>
			

<!--  other analytics code -->

<?php
	global $SGH_options;
	echo $SGH_options['analyticscode'];
?>
<!--  end other analytics code -->
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.cookie.js"></script>
<script type='text/javascript'>
    jQuery(document).ready(function(){
        //jQuery("#primarynav").Touchdown();
        
       // add dynamic classes for IE8 first-child support
 		//jQuery('#menu-header-links li').first().addClass('first-link');
 		//jQuery('#menu-footer-links li').first().addClass('first-link');
 		//jQuery('#primarynav li').first().addClass('first-link');
 		//jQuery('#sectionnav ul li').first().addClass('first-link');
 		
 		// add dynamic classes for IE8 last-child support
 		jQuery('#menu-header-links li').last().addClass('last-link');
 		jQuery('#menu-footer-links li').last().addClass('last-link');
 		jQuery('#primarynav li').last().addClass('last-link');
 		
 		//Bit to set persistant mobile side nav
 		jQuery("label[for='mobileNav']").click(function(){
 		var cookieSet = jQuery.cookie("sgh_mobile_nav");
	 		if(cookieSet){
	 			if(cookieSet != "null"){
		 			jQuery.cookie("sgh_mobile_nav", null, {path:"/"});
	 			}else{
		 			jQuery.cookie("sgh_mobile_nav", "true",{path:"/"});	
		 		}
	 		}else{
		 		jQuery.cookie("sgh_mobile_nav", "true",{path:"/"});	
	 		}
 		});
    });
    
    markDocumentLinks();
	gaTrackDownloadableFiles();

</script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.hammer.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var checkon = jQuery("#content").hammer();
	var checkoff = jQuery("#secondarynav").hammer();
	// the whole area
	
	checkon.on("swipeleft", function(ev){
		if(jQuery('#mobileNav').is(':checked')){
			jQuery("#mobileNav").prop('checked', false);
			jQuery.cookie("sgh_mobile_nav", null, {path:"/"});
		}
	});
	
	checkoff.on("swipeleft", function(ev){
		if(jQuery('#mobileNav').is(':checked')){
			jQuery("#mobileNav").prop('checked', false);
			jQuery.cookie("sgh_mobile_nav", null, {path:"/"});
		}
	});
	
	
	/*checkon.on("pinchin", function(ev){
		jQuery("#content").css({
			"font-size": function( index, value ) {
				console.log("font is" + value);
				return parseFloat( value ) + 1;
			}
		});
	});
	
	checkon.on("pinchout", function(ev){
		jQuery("#content").css({
			"font-size": function( index, value ) {
				console.log("font is" + value);
				return parseFloat( value ) - 1;
			}
		});
	});*/
	
	
	checkon.on("swiperight", function(ev) {
		//$(this).highlight();
		jQuery("#mobileNav").prop('checked', true);
		jQuery.cookie("sgh_mobile_nav", "true",{path:"/"});
	});
</script>
<?php
	wp_footer();
?>


<div class="visible-phone"></div>
</body>
</html>
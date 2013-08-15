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

		<div id="ourvalues" class="row">
		<div class="container-fluid">
			<div class="col-lg-8">
			<?php dynamic_sidebar( 'values-widget-area1' ); ?>
			</div>
			<div class="col-lg-4">
			<?php dynamic_sidebar( 'values-widget-area2' ); ?>
			</div>
		</div>
		</div>
		
			<div class="row" id='footer'>
				<div class="container-fluid">
				<div class="col-lg-12 pull-right">
							<?php dynamic_sidebar( 'footer-sponsor-area' ); ?>				
				</div>
				</div>

				<div class="container-fluid">
					<div class="col-lg-3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area1' ); ?>
						</ul>
					</div>
					<div class="col-lg-3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area2' ); ?>
						</ul>
					</div>
					<div class="col-lg-3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area3' ); ?>
						</ul>
					</div>
					<div class="col-lg-3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area4' ); ?>
						</ul>
					</div>
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
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
			<div id="ourvalues" class="row-fluid" role="contentinfo">
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
					<div class="navbar navbar-inverse">
								<?php dynamic_sidebar( 'footer-sponsor-area' ); ?>				
					</div>
				</div>

				<div class="container-fluid">
				
					<div class="span6">
							<div class="footerfeedback">
<?php 							dynamic_sidebar( 'footer-widget-feedback' ); ?>
							</div>

					</div>

					<div class="span3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area1' ); ?>
						</ul>
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area2' ); ?>
						</ul>
					</div>
					<div class="span3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area3' ); ?>
						</ul>
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area4' ); ?>
						</ul>
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
	 		
	 		
	 		//aria stuff for menu
	 		if(jQuery("#mobileNav").attr("aria-checked") == "false"){
	 			jQuery("#mobileNav").attr("aria-hidden", "false").attr("aria-checked", "true").prop("checked", true);
	 			jQuery("label[for='mobileNav']").attr("aria-pressed", "true");
	 		}else{
		 		jQuery("#mobileNav").attr("aria-hidden", "true").attr("aria-checked", "false").prop("checked", false);
	 			jQuery("label[for='mobileNav']").attr("aria-pressed", "false");
	 		}
 		});
 		
 		
 		if(jQuery(".visible-phone").css("display") != "none"){
 			//Aria for mobile
 			//as we're on mobile we make sure the first item the user navigates over is a message explaining the accessibility features
			jQuery("<div style=\"display: none;\">mobile accessibility </div>").attr("aria-hidden", "false").attr("aria-label", "This mobile website uses a slide in navigation system, meaning that the navigation isn't visible at all times. This may cause issues with your mobile device's accessibility features but we've taken every step to ensure you can use this mobile website. If do have issues please use request the desktop version of the site if your device supports it").insertBefore("#mobileNav");
			
		}else{
			// Aria for desktop
			//Current leftnav has all sections as needed for mobile
			jQuery("#secondarynav #nav .current_section").clone().appendTo(".menu-primary-navigation-container");
			// once cloned the current section nav into the leftnav then we no longer need all the options so delete it
			jQuery("#secondarynav #nav").remove();
			
			//variable to store the number of ancestors we're currently displaying
			var sectionTitle = "";
			
			//Do a test to see if we have a level 1 item, if not level 0 and if not both then on main section
			if(jQuery(".menu-primary-navigation-container .level-1").length){
				// We have a level 1 so we're 3 levels deep in the navigation, change the section title to reflect this and label the parent pages 
				sectionTitle = jQuery(".menu-primary-navigation-container .level-1").justtext() + " section navigation";
				jQuery(".menu-primary-navigation-container .level-1:not(.current_page_item)").attr("aria-label", "Up one level to " + jQuery(".menu-primary-navigation-container .level-1").justtext() + " page").attr("role", "link");
				if(jQuery(".menu-primary-navigation-container .level-1.current_page_item").length){
					jQuery(".menu-primary-navigation-container .level-0").attr("aria-label", "Up one level to " + jQuery(".menu-primary-navigation-container .level-0").justtext() + " page").attr("role", "link");
				}else{
					jQuery(".menu-primary-navigation-container .level-0").attr("aria-label", "Up two levels to " + jQuery(".menu-primary-navigation-container .level-0").justtext() + " page").attr("role", "link");
				}
				// move the items out of the children navigation so screen reader know that the current navigation list is for this section
				jQuery(".menu-primary-navigation-container .level-0").insertBefore(".menu-primary-navigation-container .children");
				jQuery(".menu-primary-navigation-container .level-1").insertBefore(".menu-primary-navigation-container .children");
			}else if(jQuery(".menu-primary-navigation-container .level-0").length){
				// We have a level 0 so we're 2 levels deep, change the section title to reflect this and label the parent page
				sectionTitle = jQuery(".menu-primary-navigation-container .level-0").justtext() + " section navigation";
				jQuery(".menu-primary-navigation-container .level-0:not(.current_page_item)").attr("aria-label", "Up one level to " + jQuery(".menu-primary-navigation-container .level-0").justtext() + " page").attr("role", "link");
				// move the items out of the children navigation so screen reader know that the current navigation list is for this section
				jQuery(".menu-primary-navigation-container .level-0").insertBefore(".menu-primary-navigation-container .children");
			}else{
				// We have neither so we're on the root section navigation, no need to label parents so just change section title
				sectionTitle = jQuery(".menu-primary-navigation-container .current_section").justtext() + " section navigation";
			}
			
			
			// make the current section 'header' a link and if it's not the current selected page we tell the user it's the top level page for the whole section
			jQuery(".menu-primary-navigation-container .current_section.current_page_item").attr("role", "link");
			jQuery(".menu-primary-navigation-container .current_section:not(.current_page_item)").attr("role", "navigation");
			//now make sure all the other menu it's are links
			jQuery(".menu-primary-navigation-container .current_section>ul li:not(.current_page_item)").attr("role", "link");
			//for the selected page we make sure the user knows this is the selected item
			jQuery(".menu-primary-navigation-container li.current_page_item").attr("role", "presentation").attr("aria-selected", "true");
			//make sure that the section navigation is correctly labelled so the user is aware of where they are
			jQuery(".menu-primary-navigation-container .current_section .children").attr("aria-label", sectionTitle);
			
		}
    });
    
    markDocumentLinks();
	gaTrackDownloadableFiles();
	
	jQuery.fn.justtext = function(){
		 return jQuery(this)[0].childNodes[0].innerText;	
	};

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
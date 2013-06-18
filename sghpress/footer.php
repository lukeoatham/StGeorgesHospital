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

			
		</div><!-- container -->
			<div class="row" id='footer'>

				<div class='container'>
				
					<div class="eightcol">
	
						<ul class="xoxo">
							<?php dynamic_sidebar( 'left-footer-widget-area' ); ?>
						</ul>
											
					</div>
				
					<div class="fourcol last">
	
						<ul class="xoxo">
							<?php dynamic_sidebar( 'right-footer-widget-area' ); ?>
						</ul>
											
					</div>
				
				</div>
				

			</div>
			
			

<!--  other analytics code -->

<?php
	global $SGH_options;
	echo $SGH_options['analyticscode'];
?>
<!--  end other analytics code -->

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
    });
    
    markDocumentLinks();
	gaTrackDownloadableFiles();

</script>

<?php
	wp_footer();
?>



</body>
</html>
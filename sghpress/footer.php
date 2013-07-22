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
				<div class="span12 pull-right">
				
				<a href="http://www.mitie.com"><img class="pull-right" src="/wp-content/themes/sghpress/images/mitie.gif" alt="Sponsored by MITIE"></a>
				</div>
				<div class="container-fluid">
					<div class="span3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area1' ); ?>
						</ul>
					</div>
					<div class="span3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area2' ); ?>
						</ul>
					</div>
					<div class="span3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area3' ); ?>
						</ul>
					</div>
					<div class="span3">
						<ul class="xoxo">
							<?php dynamic_sidebar( 'footer-widget-area4' ); ?>
						</ul>
					</div>
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
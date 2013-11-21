<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

				<div class="visible-phone">
					<div class="span3" id="secondarynav">
						<?php renderLeftNav(); ?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12" id="content">

				<h1><?php _e( 'Not found', 'twentyten' ); ?></h1>

				<p>We've just launched our new website and some pages have been moved around.
				</p>
				<p><strong>What you are looking for may still be on the site.</strong> Please try searching or using the menu.</p><br>
				<p class='aligncenter'><?php get_search_form(); ?></p><br>

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

					</div>

				</div>

<?php get_footer(); ?>
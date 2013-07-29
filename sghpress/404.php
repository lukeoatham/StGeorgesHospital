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

				<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'twentyten' ); ?></p>
				<p class='aligncenter'><?php get_search_form(); ?></p>

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

					</div>

				</div>

<?php get_footer(); ?>
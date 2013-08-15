<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
<div class="row visible-phone">
			<div class="col-lg-3" id="secondarynav">
				<?php renderLeftNav(); ?>
			</div>
		</div>
				<div class="row">
					<div class="col-lg-9" id="content">
				<h1><?php
					printf( __( 'Tagged: %s', 'twentyten' ), '' . single_tag_title( '', false ) . '' );
				?></h1>

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>

					</div>

					<div class="col-lg-3" id='sidebar'>

						<ul class="xoxo">
							<?php if (is_home() || is_front_page()) : ?>
								<?php dynamic_sidebar( 'home-sidebar-widget-area' ); ?>
							<?php else : ?>
								<?php dynamic_sidebar( 'inside-sidebar-widget-area' ); ?>
							<?php endif; ?>
						</ul>

					</div>

				</div>
<?php get_footer(); ?>
<?php
/**
 * The template for displaying attachments.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<div class="row-fluid">
			
			
					
				<div class="span3" id='secondarynav'>

										
							<?php renderLeftNav() ?>
												
					</div>	
				
					<div class="span9" id="content">

					<h2><?php the_title(); ?></h2>
					
					
					
					<ul>
<?php if ( wp_attachment_is_image() ) :
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 image attachment in a gallery

	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image attachment, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}

?>
						<li><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
							$attachment_size = apply_filters( 'twentyten_attachment_size', 900 );
							echo wp_get_attachment_image( $post->ID, array( $attachment_size, 9999 ) ); // filterable image width with, essentially, no limit for image height.
						?></a></li>

<?php else : ?>
						<li><a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo get_the_title(); ?></a></li>
<?php endif; ?>
						<?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?>

<?php
echo "</ul><h4>Notes</h4>"; 
 the_content( __( 'Continue reading &rarr;', 'twentyten' ) ); ?>


					</div>

				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
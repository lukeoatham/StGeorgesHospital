<?php
/* Template name: Services page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="eightcol">
					<?php the_content(); 
					$args = array(
	'show_option_all'    => '',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'style'              => 'list',
	'show_count'         => 0,
	'hide_empty'         => 1,
	'use_desc_for_title' => 1,
	'child_of'           => 0,
	'feed'               => '',
	'feed_type'          => '',
	'feed_image'         => '',
	'exclude'            => '',
	'exclude_tree'       => '',
	'include'            => '',
	'hierarchical'       => 1,
	'title_li'           => __( 'Services' ),
	'show_option_none'   => __('No services'),
	'number'             => null,
	'echo'               => 1,
	'depth'              => 0,
	'current_category'   => 0,
	'pad_counts'         => 0,
	'taxonomy'           => 'service',
	'walker'             => null
);
						wp_list_categories( $args );
						
					?>
					
					</div>
					
					<div class="fourcol last">
					<div class="toptasks">
		
					</div>		
					</div>

				<hr>


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
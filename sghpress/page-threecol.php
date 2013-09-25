<?php
/* Template name: Three-column page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="fourcol col1">

						<ul class="xoxo">
						<?php dynamic_sidebar('col1-widget-area');  ?>
						</ul>

					</div>

					<div class="fourcol col2 <?php
					
					$parent = array_reverse(get_post_ancestors($post->ID));
					$first_parent = get_page($parent[0]);
					$parentSplit = split("-", $first_parent->post_name);
					$parentName = strtolower($parentSplit[0]);
					$lastLetter = substr($parentName, -1);
					if($lastLetter == "s" && $parentName != "news"){
						$parentName = substr($parentName, 0, (strlen($parentName) -1));
					}
 					echo $parentName."Content";
					
					?>" id='content'>

						<?php if ( ! is_front_page() ) { ?>
							<h1><?php the_title(); ?></h1>
						<?php } ?>				
							
							<?php the_content(); ?>
	
					</div>

					<div class="fourcol col3 last clearfix" id='sidebar'>

							<?php if (comments_open() || have_comments()) : ?>
							<li>
		
								<div id='comments'>
									<?php comments_template( '', true ); ?>
								</div>
							
							</li>
							<?php endif; ?>
							
							<ul class="xoxo">
							<?php if (is_home() || is_front_page()) : ?>
								<?php dynamic_sidebar( 'home-sidebar-widget-area' ); ?>
							<?php else : ?>
								<?php dynamic_sidebar( 'inside-sidebar-widget-area' ); ?>
							<?php endif; ?>
						</ul>
						
					</div>

				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
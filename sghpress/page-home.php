<?php
/* Template name: Home page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
				
				<?php if ( is_active_sidebar( 'emergency_message' ) ) : ?>

							<div class="alert alert-block">
								<button type="button" class="close" data-dismiss="alert">&times;</button>

									<?php dynamic_sidebar( 'emergency_message' ); ?>
							
							</div>

						<?php endif; ?>

					<?php the_content(); 
					
							$customquery = new WP_Query('post_type=news&posts_per_page=5');
								
							if ( $customquery->have_posts() ) {
								$k=0;
								echo '<ul class="thumbnails">';
								while ( $customquery->have_posts() ) {
									$customquery->the_post();
									$k++;
									$title = get_the_title();
									if ($k==1){
										$image = get_the_post_thumbnail($customquery->ID,'newsheadline');
//										print_r($customquery);
										echo '<li class="span6"><a href="/news/'.$post->post_name.'">'.$image.'</a><a href="/news/'.$post->post_name.'"><h3>'.$title.'</h3></a>';
										echo '<p>'.substr($post->post_excerpt,0,140).'&hellip;</p>'; 	
										echo '</li>';
									}
									else {
										$image = get_the_post_thumbnail($customquery->ID,'newssubhead');
										echo '<li class="span3"><a href="/news/'.$post->post_name.'">'.$image.'</a><a href="/news/'.$post->post_name.'"><h4>'.$title.'</h4></a>';
//										echo '<p>'.substr($post->post_excerpt,0,70).'&hellip;</p>'; 	
										echo '</li>';
									}
									}
									}
									echo '</ul>';
									?>

				</div>
				
					<div class="row-fluid">
					<div class="span12" id="services">
					<div class="row-fluid">
					<div class="span6">

					<h3>Services</h3>
					<h4>Most active</h4>
					<?php
					$defaults = array(
					'menu'            => 'top-tasks',
					'container'       => 'div',
					'menu_class'      => 'menu',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'           => 0,
				);
				
				wp_nav_menu( $defaults );
									?>	
				</div>
				<div class="span6">
				<h4>All services: A-Z </h4> 
				<div class="input-append">
				  <label for="select2">Jump to:</label>
				  <select id="select2" >
				<?php  
					$allservices = get_posts(
							array(
							"post_type" => "service",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"post_parent" => 0
							)
						);
						
					foreach ($allservices as $service){
						echo  '<option ';
						if ($service->post_title == "Emergency") echo " selected=selected ";
						echo ' value="'.$service->guid.'">'.$service->post_title.' </option>';
					}
					?>
					  </select>
					  <button class="btn" type="button" onclick="goToPage('select2')">Go</button>
					</div>					

		
<script>
function goToPage( id ) {

  var node = document.getElementById( id );
  
  // Check to see if valid node and if node is a SELECT form control
  
  if( node &&
    node.tagName == "SELECT" ) {

    // Go to web page defined by the VALUE attribute of the OPTION element

    window.location.href = node.options[node.selectedIndex].value;
    
  } // endif
  
  
}
</script>					</div>		
						</div>
					</div>
					<div class="row-fluid">
					&nbsp; 
					</div>
<!--//find us row -->
					<div class="row-fluid">
						<div class="span3">
						<?php if ( is_active_sidebar( 'find-us-1-area' ) ) : ?>

						<?php dynamic_sidebar( 'find-us-1-area' ); ?>
							
						<?php endif; ?>

						</div>
						<div class="span3">
						<?php if ( is_active_sidebar( 'find-us-2-area' ) ) : ?>

						<?php dynamic_sidebar( 'find-us-2-area' ); ?>
							
						<?php endif; ?>
						</div>
						<div class="span3">
						<?php if ( is_active_sidebar( 'find-us-3-area' ) ) : ?>

						<?php dynamic_sidebar( 'find-us-3-area' ); ?>
							
						<?php endif; ?>
						</div>

						<div class="span3" id="doitonline">
							<h3>Do it online</h3>
							<ul>
							<li><a href='#'>Change an appointment</a></li>
							<li><a href='#'>Get results</a></li>
							<li><a href='#'>Another patient service</a></li>
							<li><a href='#'>A popular enquiry</a></li>
							<li><a href='#'>Frequent page visit</a></li>
							</ul>
						</div>
					</div>
					<br>
<!--//promo row -->				
					<div class="row-fluid">
						<div class="span4">
						<?php if ( is_active_sidebar( 'promo-1-area' ) ) : ?>

						<?php dynamic_sidebar( 'promo-1-area' ); ?>
							
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'promo-3-area' ) ) : ?>

						<?php dynamic_sidebar( 'promo-3-area' ); ?>
							
						<?php endif; ?>

						</div>
						<div class="span4">
						<?php if ( is_active_sidebar( 'promo-2-area' ) ) : ?>

						<?php dynamic_sidebar( 'promo-2-area' ); ?>
							
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'promo-4-area' ) ) : ?>

						<?php dynamic_sidebar( 'promo-4-area' ); ?>
							
						<?php endif; ?>
						</div>
						<div class="span4">
						<?php if ( is_active_sidebar( 'social-media-area' ) ) : ?>

						<?php dynamic_sidebar( 'social-media-area' ); ?>
							
						<?php endif; ?>

						</div>
						

					</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
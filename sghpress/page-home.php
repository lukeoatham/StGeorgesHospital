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

					<?php the_content(); ?>
<ul class="thumbnails">
<li class="span6"><a href="#" class="thumbnail"><img src="/wp-content/uploads/2013/06/sgh1.png" alt=""></a><h3>Primary story headline</h3><p>Teaser text introducing the news story. Can go onto two lines.</p></li>
<li class="span3"><a href="#" class="thumbnail"><img src="/wp-content/uploads/2013/06/sgh2.png" alt=""></a><h4>Secondary story headline</h4></li>
<li class="span3"><a href="#" class="thumbnail"><img src="/wp-content/uploads/2013/06/sgh3.png" alt=""></a><h4>Secondary story headline</h4></li>
<li class="span3"><a href="#" class="thumbnail"><img src="/wp-content/uploads/2013/06/sgh4.png" alt=""></a><h4>Campaign feature story headline</h4></li>
<li class="span3"><a href="#" class="thumbnail"><img src="/wp-content/uploads/2013/06/sgh5.png" alt=""></a><h4>Campaign story headline</h4></li>
</ul>

				</div>
				
					<div class="row-fluid">
					<div class="span8" id="services">
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
				<p>
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
						echo  '<option value="'.$service->guid.'">'.$service->post_title.' </option>';
					}
					?>
					  </select>
					  <input type="button" value="Go" onclick="goToPage('select2')"/>
					</p>					

		
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
						<div class="span4" id="doitonline">
							<h3>Do it online</h3>
							<ul>
							<li><a href='#'>Change an appointment</a></li>
							<li><a href='#'>Get rest results</a></li>
							<li><a href='#'>Another patient service</a></li>
							<li><a href='#'>A popular enquiry</a></li>
							<li><a href='#'>Frequent page visit</a></li>
							</ul>
						</div>
						<div class="span4">							
						<h2>Find us</h2>
						</div>

					</div>
					

<?php endwhile; ?>

<?php get_footer(); ?>
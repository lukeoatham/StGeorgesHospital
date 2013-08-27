<?php
/* Template name: Home page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id='secondarynav'>
					
						<?php 
						
						global $post;
						renderLeftNav();
						
						?>
					</div>
				<div class="row-fluid" id="homethumbs">
				


					<?php the_content(); 
					
					
					$telephone = get_post_meta($post->ID,"main_telephone",true);
					$promorows = get_field('promo_boxes');

					$featurerows = get_field('feature_news_boxes');
					if($featurerows)
//					print_r($rows);
					{
						$k=0;
						echo '<div class="thumbnails">';
						foreach($featurerows as $row)
						{
						global $post;
						$post= $row;
						setup_postdata( $post ); 
						//the_title();
							$k++;
							$title = get_the_title();
							if ($k==1){
								$image = get_the_post_thumbnail($post->ID,'newsheadline');
								echo '<div class="span6"><a href="'.$post->guid.'">'.$image.'</a><a href="'.$post->guid.'"><h3>'.$title.'</h3></a>';
								echo '<p>'.substr($post->post_excerpt,0,140).'&hellip;</p>'; 	
								echo '</div>';
							}
							else {
							if ($k==2){echo "<div class='span6'><div class='row-fluid'>";}
							if ($k==4){echo "</div><div class='row-fluid'>";}
							
								$image = get_the_post_thumbnail($customquery->ID,'newssubhead');
								echo '<div class="span6"><a href="'.$post->guid.'">'.$image.'</a><a href="'.$post->guid.'"><h4>'.$title.'</h4></a>';
								echo '</div>';
							if ($k==5){echo "</div>";}
							}
						}
									?>
						<li class="span6" id="doitonline">
							<h3>Do it online</h3>
							<?php
					$defaults = array(
					'menu'            => 'do-it-online',
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
<?php					echo '</div>';
					}
?>
				</div>

					<div class="row-fluid">
					<div class="span12" id="services">
					<div class="span5">
					<h3 id="homeservices">Services</h3>					<h4>Most active services</h4>
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
				<div class="span4">
				<h4>All services A-Z </h4> 
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
						if ($service->post_title == "Neurosciences") echo " selected=selected ";
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
</script>					
					</div>	
					<div class="span3">
					<h4>Telephone <br><?php echo $telephone; ?></h4>
					</div>	
					</div>
					</div>
					<div class="row-fluid">
					<h3>Find us</h3>
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
						<div class="span3" id="findlocal">
						<h4>Find a local health centre </h4> 
						<div class="input-append">
						  <select id="select3" >
						<?php  
							$allservices = get_terms("sites",
									array(
									"orderby" => "name",
									"order" => "ASC",
									"hide_empty"=>false
									)
								);
								
							foreach ($allservices as $service){// print_r($service);
					  		    $themeid = $service->term_id;
					  		    $q = "select option_value from wp_options where option_name = 'sites_".$themeid."_site_type'";
					  		    global $wpdb;
					  		    $theme_term = $wpdb->get_results( $q );					
								if ($theme_term[0]->option_value == "Health Centre"){
									echo  '<option ';
									echo ' value="/contact-and-find-us/find-us/sites/?site='.$service->slug.'">'.$service->name.' </option>';
								}
							}
							
							
							
							?>
							  </select>
							  <button class="btn" type="button" onclick="goToPage('select3')">Go</button>
							</div>			
		
							</div></div>
							<br>
<!--//promo row -->				
					<div class="row-fluid">
					
<?php					
					if($promorows)
					{
						$k=0;
						foreach($promorows as $row)
						{
							$k++;
							global $post;
							$post= $row;
							setup_postdata( $post ); 
							$title = get_the_title();							
							$image = get_the_post_thumbnail($post->ID,'promo');
							if ($k==1 || $k==3) echo '<div class="span4">';
							echo '<a href="'.$post->guid.'">'.$image.'</a><a href="'.$post->guid.'">'.'<h3>'.$title.'</h3></a>';
							echo '<p>'.substr($post->post_excerpt,0,140).'&hellip;</p>'; 	
							if ($k==2 || $k==4) echo '</div>';
						}
					}
?>

					
					
						<div class="span4">
						
						<?php if ( is_active_sidebar( 'sponsor-advert' ) ) : ?>

								<?php dynamic_sidebar( 'sponsor-advert' ); ?>
									
						<?php endif; ?>
						
						<?php if ( is_active_sidebar( 'social-media-area' ) ) : ?>

						<?php dynamic_sidebar( 'social-media-area' ); ?>
							
						<?php endif; ?>

						</div>
						

					</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
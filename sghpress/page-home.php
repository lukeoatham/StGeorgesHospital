<?php
/* Template name: Home page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="sevencol">
					<?php the_content(); ?>
					<h2>Carousel</h2>
					St George’s Healthcare provides diagnosis, surgery and chemotherapy for all types of cancer as well as palliative care (care to improve quality of life) and follow-up clinics. It also plays a key part in cancer prevention, offering screening services and treatment for pre-cancer stages. Radiotherapy (using x-rays or other forms of radiation as treatment) for patients is provided at the Royal Marsden Hospital with which St George’s Healthcare is a Joint Cancer Centre. There is close liaison with primary healthcare teams and local hospices to provide seamless care for cancer patients. A 24-hour on-call oncology and palliative care service is available.
					</div>
					
					<div class="fivecol last">
						<h2>News</h2>
						St George’s Healthcare provides diagnosis, surgery and chemotherapy for all types of cancer as well as palliative care (care to improve quality of life) and follow-up clinics. It also plays a key part in cancer prevention, offering screening services and treatment for pre-cancer stages. Radiotherapy (using x-rays or other forms of radiation as treatment) for patients is provided at the Royal Marsden Hospital with which St George’s Healthcare is a Joint Cancer Centre. There is close liaison with primary healthcare teams and local hospices to provide seamless care for cancer patients. A 24-hour on-call oncology and palliative care service is available.
						
					<div class="message">
					<h3>Services</h3>
					<h4>Most popular</h4>
					<?php
					$defaults = array(
	'theme_location'  => '',
	'menu'            => 'top-tasks',
	'container'       => 'div',
	'container_class' => '',
	'container_id'    => '',
	'menu_class'      => 'menu',
	'menu_id'         => '',
	'echo'            => true,
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'depth'           => 0,
	'walker'          => ''
);

wp_nav_menu( $defaults );




					?>	

<p> 
  <label for="select2">Jump to: </label>
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
</script>
					</div>	
						
					</div>

				</div>
				

<?php endwhile; ?>

<?php get_footer(); ?>
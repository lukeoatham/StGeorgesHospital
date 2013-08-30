<?php
/* Template name: Course booking page */

get_header(); 

$coursetitle = $_GET['course_title'];
$courselevel = $_GET['course_level'];
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
					<div class="span3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
					</div>
					<div class="span9">
					
						<p>Please use the form below to book a place on the <?php echo urldecode($coursetitle); ?> course.</p>
						<?php 
						
						$params = "";
						
						if($courselevel && $coursetitle){
							$params = array();
						}else{
							$params = null;
						}
						if($coursetitle){
							$params["course_title"] = urldecode($coursetitle);
						}
						if($courselevel){
							$params["course_level"] = urldecode($courselevel);
						}
						
						gravity_form('Course booking', $display_title=true, $display_description=true, $display_inactive=false, $field_values=$params, $ajax=false, 12); ?>
					
					</div>				
				</div>

					
					
<?php endwhile; ?>

<?php get_footer(); ?>
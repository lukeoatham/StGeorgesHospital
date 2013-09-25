<?php
/**
 * The Template for displaying all single treatment posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
	
	$mainid=$post->ID;
?>

		<div class="row-fluid">


<div class="span3" id='secondarynav'>

							<?php renderLeftNav(); 
								
								
								
								
								$incat = false;
								$cats=get_the_terms($id, 'people-types');
								foreach ($cats as $cat){
									if ( $cat->slug == "clinician" ){
										$incat = true;
									}
								}
							?>
										
												
												
					</div>	
				<div class="span6 <?php
				
				if($incat){
					echo "serviceContent";
				}else{
					echo "aboutContent";
				}
				
				?>" id='content'>
					<div id="mobhead">
					<h1><?php the_title(); 
					echo " <span class='small'>".get_post_meta($post->ID, 'job_title', true)."</span>"; ?></h1></div>
					
					<?php 

					
					the_content(); 
					echo "<div class='sidebox'><h3>Contact</h3>";
					$email = get_post_meta($post->ID, 'people_email', true);
					if ($email !=''){
						echo "<p><strong>Email: </strong><a href='mailto:".$email."'>".$email."</a></p>";
					}	

					$telephone = get_post_meta($post->ID, 'people_telephone', true);
					if ($telephone !=''){
						echo "<p><strong>Telephone: </strong>".$telephone."</p>";
					}	

					
					
					if ( $incat ) { //if this person is categorised as a clinician then display additional fields
					
					$secretary = get_post_meta($post->ID, 'secretary_name', true);
					if ($secretary !=''){
						echo "<p><strong>Secretary: </strong>".$secretary."</p>";
					}	

					$secretaryemail = get_post_meta($post->ID, 'secretary_email', true);
					if ($secretaryemail !=''){
						echo "<p><strong>Secretary email: </strong><a href='mailto:".$secretaryemail."'>".$secretaryemail."</a></p>";
					}	

					$secretarytelephone = get_post_meta($post->ID, 'secretary_telephone', true);
					if ($secretarytelephone !=''){
						echo "<p><strong>Secretary telephone: </strong>".$secretarytelephone."</p>";
					}	
					
					echo "</div>";
					}
					if ( $incat ) { //if this person is categorised as a clinician then display additional fields

					$clinicalinterests = get_post_meta($post->ID, 'clinical_interests', true);
					if ($clinicalinterests !=''){
						echo "<div class='sidebox'><h3>Clinical interests</h3>";
						echo wpautop($clinicalinterests)."</div>";
					}	
					
					$proprofile = get_post_meta($post->ID, 'professional_profile', true);
					if ($proprofile !=''){
						echo "<div class='sidebox'><h3>Professional profile</h3>";
						echo wpautop($proprofile)."</div>";
					}	

					$other = get_post_meta($post->ID, 'other', true);
					if ($other !=''){
						echo wpautop($other);
					}	
					
					}
					?>

				
				</div>
				
				<div class="span3" id='sidebar'>
<?php					$cimage = get_the_post_thumbnail($post->ID, 'large');
						if($cimage){
							echo "<p>".$cimage."<br>";
							echo the_title()."</p>";
						}
						$clinicianservices=get_post_meta($post->ID, 'service-relationship',true);
						if ($clinicianservices){
							echo "<div class='sidebox'><h3>Services</h3><ul>";
							//check each element in the array to see if it matches this service
							foreach ($clinicianservices as $clinicianservice){ 
								$thisservice = get_post($clinicianservice);
								echo "<li><a href='".$thisservice->guid."'>".$thisservice->post_title."</a></li>";
							}
							echo "</ul></div>";
						}
	?>				
	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
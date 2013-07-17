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

										
							<div class="menu-primary-navigation-container">
							
							<ul id="nav" class="menu">
						<li class="service menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current_section"><a href="/services/">Services</a>
						<ul class='children'>
						<li class="page_item level-0 page-item-232"><a href="/services/clinician-directory/">Clinician directory</a></li>
						<li class="page_item level-2"><a><?php the_title(); ?></a></li>

</ul></div>						
												
					</div>	
				<div class="span6" id='content'>
					<h1><?php the_title(); 
					echo " <span class='small'>".get_post_meta($post->ID, 'job_title', true)."</span>"; ?></h1>
					
					<?php 

					
					the_content(); 
					echo "<h3>Contact</h3>";
					$email = get_post_meta($post->ID, 'people_email', true);
					if ($email !=''){
						echo "<p><strong>Email: </strong><a href='mailto:".$email."'>".$email."</a></p>";
					}	

					$telephone = get_post_meta($post->ID, 'people_telephone', true);
					if ($telephone !=''){
						echo "<p><strong>Telephone: </strong>".$telephone."</p>";
					}	
					$incat = false;
					$cats=get_the_terms($id, 'people-types');
					foreach ($cats as $cat){
						if ( $cat->slug == "clinician" ){
							$incat = true;
						}
					}
					
					if ( $incat ) { //if this person is categorised as a clinician then display additional fields
					
					$secretary = get_post_meta($post->ID, 'secretary_name', true);
					if ($telephone !=''){
						echo "<p><strong>Secretary: </strong>".$secretary."</p>";
					}	

					$secretaryemail = get_post_meta($post->ID, 'secretary_email', true);
					if ($email !=''){
						echo "<p><strong>Secretary email: </strong><a href='mailto:".$secretaryemail."'>".$secretaryemail."</a></p>";
					}	

					$secretarytelephone = get_post_meta($post->ID, 'secretary_telephone', true);
					if ($secretarytelephone !=''){
						echo "<p><strong>Secretary telephone: </strong>".$secretarytelephone."</p>";
					}	

					$clinicalinterests = get_post_meta($post->ID, 'clinical_interests', true);
					if ($clinicalinterests !=''){
						echo "<h3>Clinical interests</h3>";
						echo wpautop($clinicalinterests);
					}	
					
					$proprofile = get_post_meta($post->ID, 'professional_profile', true);
					if ($proprofile !=''){
						echo "<h3>Professional profile</h3>";
						echo wpautop($proprofile);
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
					echo $cimage;
						$clinicianservices=get_post_meta($post->ID, 'service-relationship',true);
						if ($clinicianservices){
							echo "<h3>Services</h3><ul>";
							//check each element in the array to see if it matches this service
							foreach ($clinicianservices as $clinicianservice){ 
								$thisservice = get_post($clinicianservice);
								echo "<li><a href='".$thisservice->guid."'>".$thisservice->post_title."</a></li>";
							}
							echo "</ul>";
						}
	?>				
	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
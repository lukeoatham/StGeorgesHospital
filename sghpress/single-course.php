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

										
							<div class="menu-primary-navigation-container"><ul id="nav" class="menu">
<li class="education menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current_section"><a href="/education-and-research/">Education & research</a>
	<ul class="children">
	<li class="ancestor level-0"><a href="/education-and-research/education/">Education</a></li>
	<li class="page_item level-1"><a href="/education-and-research/education/courses/">Courses</a></li>
	</ul>
<li class="page_item level-2"><a><?php the_title(); ?></a></li>
</li>
</ul></div>						
												
					</div>
				<div class="span6" id='content'>
					<h1><?php the_title(); ?></h1>

					<?php 
										 $posttags = get_the_tags();
						$foundtags=false;	
						$tagstr="";
					if ($posttags) {
					  	foreach($posttags as $tag) {
					  			$foundtags=true;
					  			$tagurl = $tag->slug;
						    	$tagstr=$tagstr."
						    	<a href='/tag/{$tagurl}'><span class='label label-info'>" . str_replace(' ', '&nbsp;' , $tag->name) ."</span></a>";
				  	}
				  	}
					  	if ($foundtags){
						  	echo "<p><i class='icon-tags'></i> Tags: ".$tagstr."</p>";
					  	
					}

					the_content(); 
 
// display repeater fields for dates
 
$rows = get_field('dates');
if($rows)
{
	echo '<strong>Dates</strong><ul>';
 
	foreach($rows as $row)
	{
		echo '<li>' . date('j M Y',strtotime($row['course_date'])) . ', ' . $row['start_time'] . ' to ' . $row['end_time'] . '</li>';
	}
 
	echo '</ul>';
}
					echo "<strong>Course leader</strong>: ";
					$tempfield = get_post_meta($post->ID,'course_leader') ;  //print_r($course_leader[0][0]);
					$tempfield = get_post($tempfield[0][0]);
					echo "<a href='".$tempfield->guid."'>".$tempfield->post_title."</a>";
					echo "<br><strong>CPD points</strong>: ";
					$tempfield = get_post_meta($post->ID,'cpd_points') ;  //print_r($course_leader[0][0]);
					echo $tempfield[0];
					echo "<br><strong>Reviews</strong>:<br> ";
					$tempfield = get_post_meta($post->ID,'reviews') ;  //print_r($course_leader[0][0]);
					echo wpautop($tempfield[0]);
					echo "<strong>Cost</strong>: ";
					$tempfield = get_post_meta($post->ID,'cost') ;  //print_r($course_leader[0][0]);
					echo $tempfield[0];
					echo "<br><strong>Venue</strong>: ";
					$tempfield = get_post_meta($post->ID,'venue') ;  //print_r($course_leader[0][0]);
					echo wpautop($tempfield[0]);
					echo "<strong>Target audience</strong>: ";
					$tempfield = get_post_meta($post->ID,'target_audience') ;  //print_r($course_leader[0][0]);
					echo wpautop($tempfield[0]);
					$tempfield = get_post_meta($post->ID,'more_information') ;  //print_r($course_leader[0][0]);
					echo wpautop($tempfield[0]);
 ?>
						<div id='comments'>
							<?php comments_template( '', true ); ?>
						</div>						
				
				</div>
				
				<div class="span3" id='sidebar'>
					
<?php					the_post_thumbnail($post->ID, 'medium');
//					echo $cimage;
?>
	
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
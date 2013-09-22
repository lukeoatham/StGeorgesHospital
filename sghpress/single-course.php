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
					
				
							<?php renderLeftNav(); ?>
						
						
					</div>
				<div class="span6" id='content'>
				<p class="pull-right"><a href="course-enquiry/?course_title=<?php echo urlencode(the_title()); ?>&course_level=<?php echo urlencode(get_post_meta($post->ID,'target_audience')); /*removed [0] here */?>" class="btn-large btn-info">Book a place</a></p>
					<div id="mobhead">
						<h1><?php the_title() ; ?></h1>
					</div>
					
					
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
				</div>
				
				<div class="span3" id='sidebar'>
					<p>
<?php					the_post_thumbnail($post->ID, 'medium');
//					echo $cimage;
?></p>
				
				</div>
	
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
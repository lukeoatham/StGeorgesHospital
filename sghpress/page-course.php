<?php
/* Template name: Courses page */

get_header(); 

$coursetype = $_GET['coursetype'];
$paged = $_GET['$paged'];
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
					<div class="span3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
					</div>
					<div class="span9">
					
					<ul class="nav nav-pills">
					<?php //display filter terms
				 
				 $coursetypes = get_terms('course-types'); 
				 foreach ($coursetypes as $ct){
					 
					 echo "<li";
					 if ($ct->slug == $coursetype) echo " class='active'";
					 echo "><a href='/education-and-research/education/courses/?coursetype=".$ct->slug."'>".$ct->name."</a></li>";
				 }
					 echo "<li";
					 if (!$coursetype) echo " class='active'";
					 echo "><a href='/education-and-research/education/courses/'>All</a></li>";
				 
				 ?>
					
					
					</ul>

					
					<?php
					if ($coursetype){
						$courses = new WP_query(
							array(
							"post_type" => "course",
							"posts_per_page" => 10,
							"orderby" => "title",
							"paged"=>$paged,
							"order" => "ASC",
							"tax_query"=> array(array(
							"taxonomy"=>"course-types",
							"terms"=>$coursetype,
							"field"=>"slug"
							)
							)
							)
						);
					} else {
					$courses = new WP_Query('post_type=course&posts_per_page=10&paged='.$paged);
					}

					while ($courses->have_posts()) {
				$courses->the_post();
				echo "<div class='media'>";?>
										    <?php
									if ( has_post_thumbnail( $post->ID ) ) {
										    echo "<a class='pull-left' href=".get_permalink().">";
										    $mediaimage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'thumbnail');
										    echo "<img class='media-object' src='".$mediaimage[0]."'>";
											echo "</a>";
	    									}
	    									?>
										<?php 
										echo "<div class='media-body'><h2 class='media-heading'><a href='" .get_permalink() . "'>" . get_the_title() . "</a></h2>";
	
										the_excerpt();
	?>
<p>
										
									
									<?php if (get_comments_number($ID)>0) : ?>
									<i class="icon-comment"></i> <a href="<?php comments_link(); ?>"> 
									<?php echo get_comments_number($ID); 
										if (get_comments_number($ID) == 1) {
										echo " Comment"; 
										} else {
										echo  " Comments"; 
										}
										echo "</a>";
									endif;	
									?>
									<?php $posttags = get_the_tags();
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
										  	echo " <i class='icon-tags'></i> Tags: ".$tagstr;
									  	
									}

?>									 </p></div></div>
<?php

								}
							
							
							wp_reset_query();
							
							?>

					</div>



				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
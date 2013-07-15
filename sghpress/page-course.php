<?php
/* Template name: Courses page */

get_header(); 

$coursetype = $_GET['coursetype'];
$paged = $_GET['$paged'];
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">

					<div class="span8">
					
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
				$x = get_the_title();
				echo "<a href='".$post->guid."'>".$x."</a><br>";
				}

					
					?>
					</div>
					
					<div class="span4">
	
					</div>


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
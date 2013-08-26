<?php
/* Template name: Jobs page */

get_header(); 

$coursetype = $_GET['coursetype'];
$paged = $_GET['$paged'];

$url = "http://www.jobs.nhs.uk/extsearch?client_id=121185&infonly=1";
$xml = simplexml_load_file($url);
$htmlToReturn = "";

$specialties = array();
	
foreach($xml->vacancy_details as $vacancy){
	//Make variables for each object
	$vID = $vacancy->id;
	$vRef = $vacancy->job_reference;
	$vTitle = $vacancy->job_title;
	$vDesc = $vacancy->job_description;
	$vType = $vacancy->job_type;
	$vSpecialty = $vacancy->job_specialty;
	$vSalary = $vacancy->job_salary;
	$vLocation = $vacancy->job_location;
	$vclose = $vacancy->job_closedate;
	$vPost = $vacancy->job_postdate;
	$vURL = $vacancy->job_url;
	
	//add specialty to the array
	if(!in_array(strtolower($vSpecialty), $specialties)){
		array_push($specialties, strtolower($vSpecialty));
	}	
		
	//build the html to return	
	$htmlToReturn .= "<div class=\"row\">";
	$htmlToReturn .= "<h3><a href=\"".$vURL."\">".$vTitle."</a></h3>";
	$htmlToReturn .= "<p>".$vDesc."</p>";
	$htmlToReturn .= "<dl class=\"dl-horizontal\">";
	$htmlToReturn .= "<dt>Job Type</dt><dd>".$vType."</dd>";
	$htmlToReturn .= "<dt>Salary</dt><dd>".$vSalary."</dd>";
	$htmlToReturn .= "<dt>Close date</dt><dd>".$vclose."</dd>";
	$htmlToReturn .= "</dl>";
	$htmlToReturn .= "<p><a href=\"".$vURL."\" class=\"btn btn-info pull-right\">Apply now</a></p>";
	$htmlToReturn .= "</div>";
}

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<div class="row-fluid">
		<div class="span3" id='secondarynav'>	
			<?php renderLeftNav(); ?>		
		</div>
		<div class="span9">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<!-- <ul class="nav nav-pills">
			<?php 
			/*foreach($specialties as $spec){
				echo "<li><a href=\"#\">".$spec."</a></li>";
			}*/
			
			?>
			</ul> -->
			<?php echo $htmlToReturn; ?>
		</div>
		</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
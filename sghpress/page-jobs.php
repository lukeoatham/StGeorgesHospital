<?php
/* Template name: Jobs page */

get_header(); 

$GETtype = $_GET["type"];
$GETlocation = $_GET["loc"];

$url = "http://www.jobs.nhs.uk/extsearch?client_id=121185&infonly=1";
$xml = simplexml_load_file($url);
$htmlToReturn = "";

$specialties = array();
$types = array();
$locations = array();	

$status = $xml->status->number_of_jobs_found;
$jobsadded = 0;
	
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
	
	if(!in_array(strtolower($vType), $types)){
		array_push($types, strtolower($vType));
	}
	
	if(!in_array(strtolower($vLocation), $locations)){
		array_push($locations, strtolower($vLocation));
	}
	
	$hidder = "";
	
	if($GETtype && $GETtype != "all"){
		if(str_replace(" ", "", strtolower($vType)) != $GETtype){
			$hidder = " style=\"display: none;\"";
		}
	}
	
	if($GETlocation && $GETlocation != "all" && $hidder != ""){
		if(str_replace(" ", "", strtolower($vLocation)) != $GETlocation){
			$hidder = " style=\"display: none;\"";
		}
	}
	
	//build the html to return	
	$htmlToReturn .= "<div".$hidder." class=\"row job ".str_replace(" ", "", strtolower($vType))." ".str_replace(" ", "", strtolower($vLocation))."\">";
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
			<div class="well">
				<h4>Filter results</h4>
				<dl class="dl-horizontal">
					<dt>Job type</dt>
					<dd>
						<ul class="nav nav-pills">
							<li<?php if($GETtype == "all" || !$GETtype){ echo " class=\"active\"";} ?>><a href="?type=all<?php if($GETlocation){echo "&loc=".$GETlocation;} ?>" data-option="all" class="type">All</a></li>
							<?php 
								foreach($types as $type){
									$typeActive = "";
									$locURL = "";
									if(str_replace(" ", "", $type) == $GETtype){
										$typeActive = " class=\"active\"";
									}else{
										$typeActive = "";
									}
									if($GETlocation){
										$locURL = "&loc=".$GETlocation;
									}
									echo "<li".$typeActive."><a href=\"?type=".str_replace(" ", "", $type).$locURL."\"  data-option=\"".str_replace(" ", "", $type)."\" class=\"type\">".ucfirst($type)."</a></li>";
								}
							?>
						</ul>
					</dd>
					<dt>Location</dt>
					<dd>
						<ul class="nav nav-pills">
							<li<?php if($GETlocation == "all" || !$GETlocation){ echo " class=\"active\"";} ?>><a href="?loc=all<?php if($GETtype){ echo "&type=".$GETtype;} ?>" data-option="all" class="location">All</a></li>
							<?php
								foreach($locations as $location){
									$locationActive = "";
									if(str_replace(" ", "", $location) == $GETlocation){
										$locationActive = " class=\"active\"";
									}else{
										$locationActive = "";
									}
									if($GETtype){
										$typeURL = "&type=".$GETtype;
									}
									echo "<li".$locationActive."><a href=\"?loc=".str_replace(" ", "", $location).$typeURL."\" data-option=\"".str_replace(" ", "", $location)."\" class=\"location\">".ucfirst($location)."</a></li>";
								}
							?>
						</ul>
					</dd>
				</dl>
			</div>
			<?php echo $htmlToReturn; ?>
		</div>
		</div>
					
				

<?php endwhile; ?>

<script type="text/javascript">
	var currentType = "<?php if($GETtype){ echo $GETtype;}else{echo "all";}; ?>";
	var currentLocation = "<?php if($GETlocation){ echo $GETlocation;}else{echo "all";}; ?>";
	
	$(".type").click(function(e){
		e.preventDefault();
		$(".type").parent("li").removeClass("active");
		$(this).parent("li").addClass("active");
		var typeOfJob = $(this).attr("data-option");
		currentType = typeOfJob;
		$(".job").hide();
		if(typeOfJob != "all"){
			if(currentLocation == "all"){
				$("."+typeOfJob).show();
			}else{
				$("."+typeOfJob+"."+currentLocation).show();
			}
		}else{
			if(currentLocation == "all"){
				$(".job").show();
			}else{
				$("."+currentLocation).show();
			}
		}
		console.log("type:" + currentType+ " location:" + currentLocation);
	});
	$(".location").click(function(e){
		e.preventDefault();
		$(".location").parent("li").removeClass("active");
		$(this).parent("li").addClass("active");
		var locationOfJob = $(this).attr("data-option");
		currentLocation = locationOfJob;
		$(".job").hide();
		if(locationOfJob != "all"){
			if(currentType == "all"){
				$("."+locationOfJob).show();
			}else{
				$("."+currentType+"."+locationOfJob).show();
			}
		}else{
			if(currentType == "all"){
				$(".job").show();
			}else{
				$("."+currentType).show();
			}
		}
		console.log("type:" + currentType+ " location:" + currentLocation);
	});
</script>

<?php get_footer(); ?>
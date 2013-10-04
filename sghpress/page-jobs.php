<?php
/* Template name: Jobs page */
get_header(); 

$GETtype = $_GET["type"];
$GETsort = $_GET["sort"];
$GETkeyword = $_GET["keyword"];
$GETpay = $_GET["pay"];
$GETnew = $_GET["new"];

$GETs = array();

if($GETtype){
	$GETs["type"]= $GETtype;
}

if($GETsort){
	$GETs["sort"] = $GETsort;
}

if($GETkeyword){
	$GETs["keyword"] = $GETkeyword;
}

if($GETpay){
	$GETs["pay"] = $GETpay;
}

if($GETnew){
	$GETs["new"] = $GETnew;
}


$url = "http://www.jobs.nhs.uk/extsearch?client_id=121185&infonly=1";

switch($GETs["sort"]){
	case "recent":
		$url .= "&sort_order=D";
		break;
	case "high":
		$url .= "&sort_order=S";
		break;
	case "low":
		$url .= "&sort_order=S";
		break;
}

/*switch($GETs["type"]){
	case "all":
		$url .= "&jobtype=E";
		break;
	case "permanent":
		$url .= "&jobtype=P";
		break;
	case "fixedtermtemporary":
		$url .= "&jobtype=F";
		break;
	case "temporary":
		$url .= "&jobtype=T";
		break;
	case "bank":
		$url .= "&jobtype=B";
		break;
	case "honorary":
		$url .= "&jobtype=H";
		break;
	case "locum":
		$url .= "&jobtype=L";
		break;
	case "voluntary":
		$url .= "&jobtype=V";
		break;
}
*/

switch($GETs["pay"]){
	case "A02":
		$url .= "&reqd_salary_lower=A02";
		break;
	case "A03":
		$url .= "&reqd_salary_lower=A03";
		break;
	case "A04":
		$url .= "&reqd_salary_lower=A04";
		break;
	case "A05":
		$url .= "&reqd_salary_lower=A05";
		break;
	case "A06":
		$url .= "&reqd_salary_lower=A06";
		break;
	case "A07":
		$url .= "&reqd_salary_lower=A07";
		break;
	case "A08":
		$url .= "&reqd_salary_lower=A08";
		break;
	case "A09":
		$url .= "&reqd_salary_lower=A09";
		break;
	case "A10":
		$url .= "&reqd_salary_lower=A10";
		break;
	case "H02":
		$url .= "&reqd_salary_lower=H02";
		break;
	case "H03":
		$url .= "&reqd_salary_lower=H03";
		break;
	case "H04":
		$url .= "&reqd_salary_lower=H04";
		break;
	case "H05":
		$url .= "&reqd_salary_lower=H05";
		break;
	case "H06":
		$url .= "&reqd_salary_lower=H06";
		break;
	case "H07":
		$url .= "&reqd_salary_lower=H07";
		break;
	case "H08":
		$url .= "&reqd_salary_lower=H08";
		break;
	case "H09":
		$url .= "&reqd_salary_lower=H09";
		break;
	case "H10":
		$url .= "&reqd_salary_lower=H10";
		break;
	case "1":
		$url .= "&pay_scheme=AC&pay_band=1";
		break;
	case "2":
		$url .= "&pay_scheme=AC&pay_band=2";
		break;
	case "3":
		$url .= "&pay_scheme=AC&pay_band=3";
		break;
	case "4":
		$url .= "&pay_scheme=AC&pay_band=4";
		break;
	case "5":
		$url .= "&pay_scheme=AC&pay_band=5";
		break;
	case "6":
		$url .= "&pay_scheme=AC&pay_band=6";
		break;
	case "7":
		$url .= "&pay_scheme=AC&pay_band=7";
		break;
	case "8a":
		$url .= "&pay_scheme=AC&pay_band=8a";
		break;
	case "8b":
		$url .= "&pay_scheme=AC&pay_band=8b";
		break;
	case "8c":
		$url .= "&pay_scheme=AC&pay_band=8c";
		break;
	case "8d":
		$url .= "&pay_scheme=AC&pay_band=8d";
		break;
	case "9":
		$url .= "&pay_scheme=AC&pay_band=9";
		break;
	case "CN":
		$url .= "&pay_scheme=MD&pay_band=CN";
		break;
	case "AS":
		$url .= "&pay_scheme=MD&pay_band=AS";
		break;
	case "SG":
		$url .= "&pay_scheme=MD&pay_band=SG";
		break;
	case "SR":
		$url .= "&pay_scheme=MD&pay_band=SR";
		break;
	case "SM":
		$url .= "&pay_scheme=SM";
		break;
}

if($GETs["keyword"] && $GETs["keyword"] != ""){
	$url .= "&skill_keywords=".urlencode($GETs["keyword"])."&skill_match=ALL";
}

if($GETs["new"]){
	$url .= "&suitable_for_newly_qualified=Y";
}

$xml = simplexml_load_file($url);

$htmlToReturn = "";

$vacancies = array();
//$specialties = array();
$types = array();
//$locations = array();	

$status = $xml->status->number_of_jobs_found;
$jobsadded = 0;
if($status != 0){
	
	foreach($xml->vacancy_details as $vacancy){
		//Make variables for each object
		$jobsadded++;
		$vacObj = array();
		$vacObj["id"] = $vacancy->id;
		$vacObj["ref"] = $vacancy->job_reference;
		$vacObj["title"] = $vacancy->job_title;
		$vacObj["desc"] = $vacancy->job_description;
		$vacObj["type"] = $vacancy->job_type;
		$vacObj["specialty"] = $vacancy->job_specialty;
		$vacObj["salary"] = $vacancy->job_salary;
		$vacObj["location"] = $vacancy->job_location;
		$vacObj["close"] = $vacancy->job_closedate;
		$vacObj["post"] = $vacancy->job_postdate;
		$vacObj["url"] = $vacancy->job_url;
	
	
		if(!in_array(str_replace(" ", "", strtolower($vacObj["type"])), $types)){
			array_push($types,str_replace(" ", "", strtolower($vacObj["type"])));
		}
	
		array_push($vacancies, $vacObj);
	
	}
	
	if($GETs["sort"] == "low"){
		$vacancies = array_reverse($vacancies);
	}
	
	foreach($vacancies as $vac){
		$hidder = "";
		if($GETs["type"] && $GETs["type"] != "all"){
			if(str_replace(" ", "", strtolower($vac["type"])) != $GETs["type"]){
				$hidder = " style=\"display: none;\"";
			}
		}
	
	
		//build the html to return	
		$htmlToReturn .= "<div".$hidder." class=\"row job ".str_replace(" ", "", strtolower($vac["type"]))."\">";
		$htmlToReturn .= "<h3><a href=\"".$vac["url"]."\">".$vac["title"]."</a></h3>";
		$htmlToReturn .= "<p class=\"jobDesc\">".$vac["desc"]."</p>";
		$htmlToReturn .= "<dl class=\"dl-horizontal\">";
		$htmlToReturn .= "<dt>Job Type</dt><dd>".$vac["type"]."</dd>";
		$htmlToReturn .= "<dt>Salary</dt><dd>".$vac["salary"]."</dd>";
		$htmlToReturn .= "<dt>Close date</dt><dd>".$vac["close"]."</dd>";
		$htmlToReturn .= "</dl>";
		$htmlToReturn .= "<p class=\"applyButton\"><a href=\"".$vac["url"]."\" class=\"btn btn-info pull-right\">Apply now</a></p>";
		$htmlToReturn .= "</div>"; 
	}
}else{
	$htmlToReturn .= "<h3>No results found</h3><p>We currently don't have any positions in the criteria your searched for. Please broaden your search criteria and try again.</p>";
}


?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<div class="row-fluid">
		<div class="span3" id='secondarynav'>	
			<?php renderLeftNav(); ?>		
		</div>
		<div class="span9 <?php
					
					$parent = array_reverse(get_post_ancestors($post->ID));
					$first_parent = get_page($parent[0]);
					$parentSplit = split("-", $first_parent->post_name);
					$parentName = strtolower($parentSplit[0]);
					$lastLetter = substr($parentName, -1);
					if($lastLetter == "s" && $parentName != "news"){
						$parentName = substr($parentName, 0, (strlen($parentName) -1));
					}
 					echo $parentName."Content";
					
					?>" id="content">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<div class="searchResults"></div>
			<div class="well jobsFilter">
				<h4>Filter results</h4>
				<form class="form-search" action="" method="GET">
				<dl class="dl-horizontal">
				<dt>Keyword search</dt>
				<dd>
					<input type="text" class="input-xlarge search-query" id="keywordSearch" name="keyword"<?php 
					if($GETs["keyword"] && $GETs["keyword"] != ""){
						echo " value=\"".$GETs["keyword"]."\"";
					}
					 ?>>
					<button type="submit" class="btn" id="keywordSearchSubmit">Search</button>
					<?php 
						foreach($GETs as $key => $val){
							if($key != "keyword" && $key != "pay"){
								echo "<input type=\"hidden\" name=\"".$key."\" value=\"".$val."\"/>";
							}
						}
				 ?>
				</dd>
					<dt>Job type</dt>
					<?php 
						$allTypes = array("permanent","fixedtermtemporary","temporary","bank","honorary","locum","voluntary");
						$GETcounter = 0; 
						$typeURL = get_permalink($post->ID);
						foreach($GETs as $key => $val){
							if($key != "type"){
								if($GETcounter != 0){
									$typeURL .= "&";
								}else{
									$typeURL .= "?";
								}
								$typeURL .= $key."=".$val;
								$GETcounter++;
							}
						}
					
						if($GETcounter != 0){
							$typeURL .= "&";
						}else{
							$typeURL .= "?";
						}
					?>
					<dd>
						<div class="btn-group">
							<a href="<?php echo $typeURL; ?>type=all" id="all" class="btn typeButton<?php if($GETs["type"] == "all" || (!$GETs["type"])){echo " active";}?>">All</a>
							<?php 
							foreach($types as $type){
								echo "<a href=\"".$typeURL."type=".$type."\" id=\"".$type."\" class=\"btn typeButton";
								/*if(!in_array($type, $types)){
									echo " disabled";
								}*/
								if($GETs["type"] == $type){
									echo " active";
								}
								if($type != "fixedtermtemporary"){
									echo "\">".ucfirst($type)."</a>";
								}else{
									echo "\">Fixed term temporary</a>";
								}
							}	
							?>
						</div>
					</dd>
					<dt>Sort by</dt>
					<?php
					$GETcounter = 0; 
					$sortURL = get_permalink($post->ID);
					foreach($GETs as $key => $val){
						if($key != "sort"){
							if($GETcounter != 0){
								$sortURL .= "&";
							}else{
								$sortURL .= "?";
							}
							$sortURL .= $key."=".$val;
							$GETcounter++;
						}
					}
					
					if($GETcounter != 0){
						$sortURL .= "&";
					}else{
						$sortURL .= "?";
					}

					
					 ?>
					<dd>
						<div class="btn-group">
							<a href="<?php echo $sortURL; ?>sort=recent" id="recent" class="btn sortButton<?php if($GETs["sort"] == "recent" || (!$GETs["sort"])){ echo " active"; }?>">Most recent first</a>
							<a href="<?php echo $sortURL; ?>sort=high" id="high" class="btn sortButton<?php if($GETs["sort"] == "high"){ echo " active"; }?>">Highest paid first</a>
							<a href="<?php echo $sortURL; ?>sort=low" id="low" class="btn sortButton<?php if($GETs["sort"] == "low"){ echo " active"; }?>">Lowest paid first</a>
  						</div>
					</dd>
					<dt>Pay/Salary/Band</dt>
					<dd>
						<select name="pay" class="input-xlarge" id="pay">
							<option value="any"<?php if($GETs["pay"] == "any" || (!$GETs["pay"])){ echo " selected"; }?>>All</option>
							<optgroup label="Salary range">
								<option value="A02"<?php if($GETs["pay"] == "A02"){ echo " selected"; }?>>at least &pound;10,000 a year</option>
								<option value="A03"<?php if($GETs["pay"] == "A03"){ echo " selected"; }?>>at least &pound;20,000 a year</option>
								<option value="A04"<?php if($GETs["pay"] == "A04"){ echo " selected"; }?>>at least &pound;30,000 a year</option>
								<option value="A05"<?php if($GETs["pay"] == "A05"){ echo " selected"; }?>>at least &pound;40,000 a year</option>
								<option value="A06"<?php if($GETs["pay"] == "A06"){ echo " selected"; }?>>at least &pound;50,000 a year</option>
								<option value="A07"<?php if($GETs["pay"] == "A07"){ echo " selected"; }?>>at least &pound;60,000 a year</option>
								<option value="A08"<?php if($GETs["pay"] == "A08"){ echo " selected"; }?>>at least &pound;70,000 a year</option>
								<option value="A09"<?php if($GETs["pay"] == "A09"){ echo " selected"; }?>>at least &pound;80,000 a year</option>
								<option value="A10"<?php if($GETs["pay"] == "A10"){ echo " selected"; }?>>at least &pound;90,000 a year</option>
							</optgroup>
							<optgroup label="Hourly rate">
								<option value="H02"<?php if($GETs["pay"] == "H02"){ echo " selected"; }?>>at least &pound;5 an hour</option>
								<option value="H03"<?php if($GETs["pay"] == "H03"){ echo " selected"; }?>>at least &pound;10 an hour</option>
								<option value="H04"<?php if($GETs["pay"] == "H04"){ echo " selected"; }?>>at least &pound;20 an hour</option>
								<option value="H05"<?php if($GETs["pay"] == "H05"){ echo " selected"; }?>>at least &pound;30 an hour</option>
								<option value="H06"<?php if($GETs["pay"] == "H06"){ echo " selected"; }?>>at least &pound;40 an hour</option>
								<option value="H07"<?php if($GETs["pay"] == "H07"){ echo " selected"; }?>>at least &pound;50 an hour</option>
								<option value="H08"<?php if($GETs["pay"] == "H08"){ echo " selected"; }?>>at least &pound;60 an hour</option>
								<option value="H09"<?php if($GETs["pay"] == "H09"){ echo " selected"; }?>>at least &pound;70 an hour</option>
								<option value="H10"<?php if($GETs["pay"] == "H10"){ echo " selected"; }?>>at least &pound;80 an hour</option>
							</optgroup>
							<optgroup label="Agenda for Change pay band">
								<option value="1"<?php if($GETs["pay"] == "1"){ echo " selected"; }?>>Band 1</option>
								<option value="2"<?php if($GETs["pay"] == "2"){ echo " selected"; }?>>Band 2</option>
								<option value="3"<?php if($GETs["pay"] == "3"){ echo " selected"; }?>>Band 3</option>
								<option value="4"<?php if($GETs["pay"] == "4"){ echo " selected"; }?>>Band 4</option>
								<option value="5"<?php if($GETs["pay"] == "5"){ echo " selected"; }?>>Band 5</option>
								<option value="6"<?php if($GETs["pay"] == "6"){ echo " selected"; }?>>Band 6</option>
								<option value="7"<?php if($GETs["pay"] == "7"){ echo " selected"; }?>>Band 7</option>
								<option value="8a"<?php if($GETs["pay"] == "8a"){ echo " selected"; }?>>Band 8a</option>
								<option value="8b"<?php if($GETs["pay"] == "8b"){ echo " selected"; }?>>Band 8b</option>
								<option value="8c"<?php if($GETs["pay"] == "8c"){ echo " selected"; }?>>Band 8c</option>
								<option value="8d"<?php if($GETs["pay"] == "8d"){ echo " selected"; }?>>Band 8d</option>
								<option value="9"<?php if($GETs["pay"] == "9"){ echo " selected"; }?>>Band 9</option>
							</optgroup>
							<optgroup label="Medical and Dental positions">
								<option value="CN"<?php if($GETs["pay"] == "CN"){ echo " selected"; }?>>Consultant</option>
								<option value="AS"<?php if($GETs["pay"] == "AS"){ echo " selected"; }?>>Associate Specialist</option>
								<option value="SG"<?php if($GETs["pay"] == "SG"){ echo " selected"; }?>>Staff Group</option>
								<option value="SR"<?php if($GETs["pay"] == "SR"){ echo " selected"; }?>>Senior Registrar</option>
							</optgroup>
							<optgroup label="Senior Management">
								<option value="SM"<?php if($GETs["pay"] == "SM"){ echo " selected"; }?>>Senior Management positions</option>
							</optgroup>
						</select>
						<button type="submit" id="paySubmit" class="btn">Apply</button>
					</dd>
					</form>
					<!--<dt>Newly qualified?</dt>
					<dd>
					<?php
					$GETcounter = 0; 
					$newURL = get_permalink($post->ID);
					foreach($GETs as $key => $val){
						if($key != "new"){
							if($GETcounter != 0){
								$newURL .= "&";
							}else{
								$newURL .= "?";
							}
							$newURL .= $key."=".$val;
							$GETcounter++;
						}
					}
					
					if($GETs["new"] != "true"){
						if($GETcounter != 0){
							$newURL .= "&";
						}else{
							$newURL .= "?";
						}
					}

					
					 ?>
						<p>
						 <?php
						 	if($GETs["new"] != "true"){?>
						 		<a href="<?php echo $newURL; ?>new=true" id="newSubmit" class="btn true">Show posts suitable for newly qualified staff</a>
						<?php }else{
						 ?>
						 		<a href="<?php echo $newURL; ?>" id="newSubmit" class="btn false"><i class="icon-remove"></i> Show all posts</a>
						 <?php
						 }
						 ?>
						</p>
					</dd>-->
				</dl>
				<p><span id="jobsFound"><?php echo $jobsadded; ?> jobs found </span><a href="<?php the_permalink($post->ID); ?>" id="resetSearch" class="btn btn-danger pull-right"><i class="icon-remove icon-white"></i> Reset search</a><br></p>
			</div>
			<div id="jobsListing">
			<?php echo $htmlToReturn; ?>
			</div>
		</div>
		</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
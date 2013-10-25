<?php
/* Template name: Services page */

get_header(); 

$hospsite = $_GET['site'];



if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

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
						<h1><?php the_title() ; ?></h1>
					<div class="row-fluid">

<?php
					$gtermsa = new WP_Query('post_type=service&posts_per_page=-1&orderby=title&order=ASC&post_status=publish');
					
					$servs = array();
					$sites = array();
					// do a for loop, check dict for key which is first letter of service name
					
					foreach($gtermsa->posts as $serv){
						$servObj = array();
						$key = strtolower(substr($serv->post_title, 0, 1));
						$servObj["title"] = $serv->post_title;
						$servObj["link"] = $serv->guid;
						$servObj["id"] = $serv->ID;
						$sSites = get_the_terms($serv->ID, 'sites');
						
						
						
						if($sSites){
							$servObj["sites"] = array();
							foreach($sSites as $k => $val){
								$siteType = get_option("sites_". $val->term_id . "_site_type");
								if($siteType != "Hospital"){
									if(!$sites["csw"]){
										$sites["csw"] = "Community Services";
									}
									array_push($servObj["sites"], "csw");
									
								}else{
									if(!$sites[$val->slug]){
										$sites[$val->slug] = $val->name;
									}
									array_push($servObj["sites"], $val->slug);
								}
								
							}
						}
						
						// if we're filtering by site then only add to array if available at that site
						if($hospsite){
							if(in_array($hospsite, $servObj["sites"])){
								//if has letter append to array, else create new key
								if($servs[$key]){
									array_push($servs[$key], $servObj);
								}else{
									$servs[$key] = array();
									array_push($servs[$key], $servObj);
								}
							}
						}else{
							//if has letter append to array, else create new key
							if($servs[$key]){
								array_push($servs[$key], $servObj);
							}else{
								$servs[$key] = array();
								array_push($servs[$key], $servObj);
							}
						}
					}		
					
					
					?>	
					
						<h2>Filter services</h2>
						<h3>Site</h3>
						<ul class="nav site-pills nav-pills">
							<li class="active"><a href="#" data-toggle="tab" id="allSites">All sites</a></li>
							<?php	foreach($sites as $siteKey => $siteVal){
								echo "<li><a href=\"/services/a-z/?site=".$siteKey."\" class=\"site\">".$siteVal."</a></li>";
							}?>
						</ul>
						<h3>Service</h3>
						<ul class="nav letter-pills nav-pills">
							<li class="active"><a href="#" data-toggle="tab" id="allServs">All services</a></li>
							<?php
								foreach($servs as $key => $servLetter){
									echo "<li><a href=\"#tab".$key."\" data-toggle=\"tab\" class=\"serviceTab\">".strtoupper($key)."</a></li>";
								}
							?>
						</ul>
						<div class="tab-content" id="service-tabs">
							<?php
							
							foreach($servs as $key => $value){
								echo "<div class=\"tab-pane active\" id=\"tab".$key."\">";
								
								echo "<h3>".strtoupper($key)."</h3>";								
								foreach($value as $serv){
									if($serv["sites"]){
										$sites = "";
										foreach($serv["sites"] as $servSite){
											if($sites != ""){
												$sites .= " ";
											}
											$sites .= $servSite;
										}
									}
									echo "<div class=\"media ".$sites."\">";
									
									$postThumb = wp_get_attachment_image_src(get_post_thumbnail_id($serv["id"]), array(75,75), false);
									
									if(!$postThumb){
										$postThumb = "http://placehold.it/75x75";
									}else{
										$postThumb = $postThumb[0];
									}
									
									echo "<a href=\"".$serv["link"]."\" class=\"pull-left\"><img src=\"".$postThumb."\" class=\"media-object service-thumbnail\"></a>";
									
									echo "<div class=\"media-body\">";
									
									echo "<h4><a href=\"".$serv["link"]."\">".$serv["title"]."</a></h4>";
									
									echo pippin_excerpt_by_id($serv["id"], 20);
									
									//echo "<p>".get_post_meta($serv["id"], "contact_details", true)."</p>";
									
									echo "</div>";
									
									echo "</div>";
								}
								echo "</div>";
								
							}
							
							?>
							<div id="none-found">Sorry no results were found for your query</div>
						</div>
					</div>
					
					<script type="text/javascript">
						var selectedSite = "all";
						var selectedLetter = "all";
						$("#none-found").hide();
						
						$('#allServs').click(function (e) {
							//e.preventDefault();
							selectedLetter = "all";
							$(".letter-pills li").removeClass("active");
							$("#allServs").addClass('active');
							$("#none-found").hide();
							$(".tab-pane").each(function(i, t){
								if(selectedSite != "all"){
									$(this).children(".media").hide();
									$(this).children("."+selectedSite).show();
									if($(this).children("." + selectedSite).length == 0){
										$(this).hide();
									}
								}else{
									$(this).show();
									$(this).children(".media").show();
								}
								$(this).addClass('active');
							});
						});
						
						$("#allSites").click(function(e){
							selectedSite = "all";
							$(".site-pills li").removeClass("active");
							$(this).addClass("active");
							$(".letter-pills li").show();
							$("#none-found").hide();
							if(selectedLetter != "all"){
								$(".tab-pane").hide();
								$(".tab-pane .media").hide();
								$("#tab"+selectedLetter).show();
								$("#tab" + selectedLetter + " .media").show();
							}else{
								$(".tab-pane").show();
								$(".tab-pane .media").show();
							}
						});
						
						$(".site").click(function(e){
							e.preventDefault();
							var selectSite = $(this).attr("href");
							selectedSite = selectSite.replace("/services/a-z/?site=", "");
							$(".site-pills li").removeClass("active");
							$(this).parent("li").addClass("active");
							$(".tab-pane .media").hide();
							if(selectedLetter != "all"){
								$(".tab-pane").hide();
								$(".tab-pane .media").hide();
								$("#tab"+selectedLetter).show();
								$("#tab"+selectedLetter+ " ."+selectedSite).show();
								if($("#tab"+selectedLetter+ " ."+selectedSite).length == 0){
									$("#tab"+selectedLetter).hide();
									$("#none-found").show();
								}else{
									$("#none-found").hide();
								}
								$(".letter-pills li").show();
								$(".tab-pane").each(function(i,t){
									if($(this).children("." + selectedSite).length == 0){
										var letterToHide = $(this).attr("id");
										$(".letter-pills li a[href='#" + letterToHide + "']").parent("li").hide();
									}
								});
							}else{
								$(".tab-pane").show();
								$("#none-found").hide();
								$(".tab-pane .media").hide();
								$(".tab-pane ."+selectedSite).show();
								$(".letter-pills li").show();
								$(".tab-pane").each(function(i,t){
									if($(this).children("." + selectedSite).length == 0){
										$(this).hide();
										var letterToHide = $(this).attr("id");
										$(".letter-pills li a[href='#" + letterToHide + "']").parent("li").hide();
									}
								});
							}
						});
						
						$('.serviceTab').click(function (e) {
							e.preventDefault();
							selectedLetter = $(this).attr("href").replace("#tab", "");
							console.log("l:"+selectedLetter+" s:"+selectedSite);
							$(".tab-pane").hide();
							$(".tab-pane .media").hide();
							if(selectedSite != "all"){
								$("#tab"+selectedLetter+" .media").hide();
								$("#tab"+selectedLetter+" ."+selectedSite).show();
								$("#tab"+selectedLetter).show();
								
							}else{
								$("#tab"+selectedLetter+" .media").show();
								$("#tab"+selectedLetter).show();
							}
							
							
						});

					</script>			
					
					
					</div> 
					</div>

					<div class="span3">
&nbsp;
					<?php 
					$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium');;
					if($thumbnail[0]){
					?>
					
					<script type="text/javascript" defer="defer">
						$(document).ready(function(){
							if($(".visible-phone").css("display") != "none"){
								$("#mobhead").css("background-image","url('<?php echo $thumbnail[0]; ?>')");
								$("#mobhead").addClass("active");
							}else{
								$("#sidebar").prepend('<img src="<?php echo $thumbnail[0]; ?>">');
							}
						});
					</script>
					<noscript>
						<img src="<?php echo $thumbnail; ?>">
					</noscript>
					
					<?php } ?>
					</div>
					


		


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
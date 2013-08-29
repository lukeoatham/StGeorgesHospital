<?php
/* Template name: Clinicians page */

get_header(); 

if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


				<div class="row-fluid">
				<div class="span3" id='secondarynav'>
				
					<?php renderLeftNav(); ?>
				
				</div>
				<div class="span9">
					<h1><?php the_title() ; ?></h1>
					
					<?php
					
					$gterms = new WP_Query(
					array(
					"post_type"=>"people",
					"posts_per_page"=>-1,
					"orderby"=>"meta_value",
					"order"=>"ASC",
					"meta_key"=>"last_name",
					"tax_query"=>array(array(
					"taxonomy"=>"people-types",
					"field"=>"slug",
					"terms"=>"clinician"
					)),					
					"meta_query"=>array(array(
					"key"=>"show",
					"value"=>'1',

					
					))
					));	
					
					$services = array();
					$items = array();
					foreach($gterms->posts as $item){
						$itemObj = array();
						$itemObj["surname"] = get_post_meta($item->ID, "last_name", true);
						$itemObj["forename"] = get_post_meta($item->ID,"first_name", true);
						$itemObj["prof_title"] = get_post_meta($item->ID, "professional_title", true);
						$itemObj["title"] = $item->post_title;
						$itemObj["link"] = $item->guid;
						$itemObj["id"] = $item->ID;
						$key = strtolower(substr($itemObj["surname"], 0, 1));
						
						//var_dump(get_post_meta($item->ID, "service-relationship"));
						
						$itemService = get_post_meta($item->ID, "service-relationship");
						
						$itemObj["services"] = array();
						
						foreach($itemService as $serviceArray){
							foreach($serviceArray as $service){
								array_push($itemObj["services"], $service);
							}
						}
						
						
						
						//if has letter append to array, else create new key
						if($items[$key]){
							array_push($items[$key], $itemObj);
						}else{
							$items[$key] = array();
							array_push($items[$key], $itemObj);
						}
					}
					
			
					?>
					
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li><a href="#" data-toggle="tab" id="allItems" class="active">All clinicians</a></li>
							<?php
							
							foreach($items as $key => $itemLetter){
								echo "<li><a href=\"#tab".$key."\" data-toggle=\"tab\" class=\"azTab\">".strtoupper($key)."</a></li>";
							}
							
							/*foreach($sites as $siteKey => $siteVal){
								echo "<li><a href=\"/services/a-z/?site=".$siteKey."\" class=\"site\">".$siteVal."</a></li>";
							}*/
							
							
							?>
						</ul>
					
						<div class="tab-content" id="service-tabs">
							<?php
							
							foreach($items as $key => $value){
								echo "<div class=\"tab-pane active\" id=\"tab".$key."\">";
								
								echo "<h3>".strtoupper($key)."</h3>";
								
								foreach($value as $item){
									/*if($item["sites"]){
										$sites = "";
										foreach($serv["sites"] as $servSite){
											if($sites != ""){
												$sites .= " ";
											}
											$sites .= $servSite;
										}
									}*/
									echo "<div class=\"media\">";
									
									$postThumb = wp_get_attachment_image_src(get_post_thumbnail_id($item["id"]), array(75,75), false);
									
									if(!$postThumb){
										$postThumb = "http://placehold.it/75x75";
									}else{
										$postThumb = $postThumb[0];
									}
									
									$displayname = $item["prof_title"]." ".$item["forename"]." ".$item["surname"];
									
									echo "<a href=\"".$item["link"]."\" class=\"pull-left\"><img src=\"".$postThumb."\" class=\"media-object service-thumbnail\"></a>";
									
									echo "<div class=\"media-body\">";
									
									echo "<h4><a href=\"".$item["link"]."\">".$displayname."</a></h4>";
									
									if($item["services"]){
										echo "<ul>";
										foreach($item["services"] as $service){
											echo "<li>".get_the_title($service)."</li>";
										}
										echo "</ul>";
									}
									
									//echo pippin_excerpt_by_id($item["id"], 20);
									
									//echo "<p>".get_post_meta($serv["id"], "contact_details", true)."</p>";
									
									echo "</div>";
									
									echo "</div>";
								}
								echo "</div>";
								
							}
							
							?>
						</div>
					</div>
					
					<script type="text/javascript">
						$('#allItems').click(function (e) {
							//e.preventDefault();
							$("#allItems").addClass('active');
							$(".tab-content .media").show();
							$(".tab-pane").each(function(i, t){
								$(".azTab").removeClass("active");
								$(this).addClass('active');
							});
						});
						
						/*$(".site").click(function(e){
							e.preventDefault();
							var selectedSite = $(this).attr("href");
							selectedSite = selectedSite.replace("/services/a-z/?site=", "");
							$(".site").parent("li").removeClass("active");
							$(this).parent("li").addClass("active");
							$(".tab-content .media").hide();
							$(".tab-pane").each(function(i, t){
								$(".serviceTab").removeClass("active");
								$(this).addClass('active');
								
								console.log($(this).children("." + selectedSite).length);
								
								if($(this).children("." + selectedSite).length == 0){
									$(this).removeClass('active');
								}
							});
							$("." + selectedSite).show();
						});*/
						
						$('.azTab').click(function (e) {
							e.preventDefault();
							$(".tab-content .media").show();
							$(".tab-pane").each(function(i, t){
								$(".azTab").removeClass("active");
								$(this).removeClass('active');
							});
							$(this).tab('show');
						});

					</script>	

				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
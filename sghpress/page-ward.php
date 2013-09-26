<?php
/* Template name: Wards page */

get_header();

$hospsite = $_GET['hospsite'];
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
				
				<div class="span3" id='secondarynav'>

										
							<?php renderLeftNav() ?>
												
					</div>	
				
					<div class="span6 <?php
					
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
				<?php the_content(); ?>
					
					
					
					<?php //get all ward results, sort into associative array ready for parsing later on in page 
						
						$wards = new WP_query(
							array(
							"post_type" => "ward",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC"
						));
							
						$sites = array();

						foreach($wards->posts as $ward){
							$wardObj = array();
							$wardObj["title"] = $ward->post_title;
							$wardObj["link"] = $ward->guid;
							$wardObj["id"] = $ward->ID;
							$wSites = get_the_terms($ward->ID, 'sites');
						
							if($wSites){
								foreach($wSites as $k => $val){
									$key = $val->slug;
									if($sites[$key]){
										array_push($sites[$key], $wardObj);
									}else{
										$sites[$key] = array();
										$sites[$key]["fullname"] = $val->name;
										array_push($sites[$key], $wardObj);
									}
								}
							}
						}
						
						
					?>
					
				
					
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#" data-toggle="tab" id="allServs">All sites</a></li>
					
					
					
							<?php //display filter terms
					
							foreach($sites as $key => $value){
								echo "<li><a href=\"#tab".$key."\" data-toggle=\"tab\" class=\"serviceTab\">".$sites[$key]["fullname"]."</a></li>";
							} 
				 
							?>
					
					
						</ul>

						<div class="tab-content" id="service-tabs">
							<?php
							
							foreach($sites as $key => $value){
								echo "<div class=\"tab-pane active\" id=\"tab".$key."\">";
								
								echo "<h3>".$sites[$key]["fullname"]."</h3>";
								
								foreach($value as $serv){
									echo "<div class=\"media\">";
									
									$postThumb = wp_get_attachment_image_src(get_post_thumbnail_id($serv["id"]), array(75,75), false);
									
									if(!$postThumb){
										$postThumb = "http://placehold.it/75x75";
									}else{
										$postThumb = $postThumb[0];
									}
									
									echo "<a href=\"".$serv["link"]."\" class=\"pull-left\"><img src=\"".$postThumb."\" class=\"media-object service-thumbnail\"></a>";
									
									echo "<div class=\"media-body\">";
									
									echo "<h4><a href=\"".$serv["link"]."\">".$serv["title"]."</a></h4>";
									
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
						$('#allServs').click(function (e) {
							//e.preventDefault();
							$("#allServs").addClass('active');
							$(".tab-content .media").show();
							$(".tab-pane").each(function(i, t){
								$(".serviceTab").removeClass("active");
								$(this).addClass('active');
							});
						});
						
						$('.serviceTab').click(function (e) {
							e.preventDefault();
							$(".tab-content .media").show();
							
						});
					</script>
					
									
					<div class="span3">

					<?php 

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					

				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
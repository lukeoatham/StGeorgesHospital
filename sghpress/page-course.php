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
					
					
					
					<?php
					
					if ($coursetype){
						$gterms = new WP_query(
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
						$gterms = new WP_Query('post_type=course&posts_per_page=10&paged='.$paged);
					}
					
					$items = array();
					
					$coursetypes = get_terms('course-types'); 
					foreach ($coursetypes as $ct){
						$items[$ct->name] = array();
					}
					
					
					
					foreach($gterms->posts as $item){
						$itemObj = array();
						$itemObj["title"] = $item->post_title;
						$itemObj["link"] = $item->guid;
						$itemObj["id"] = $item->ID;
						$itemObj["thumbnail"] = wp_get_attachment_image_src(get_post_thumbnail_id($item->ID),'thumbnail',false);//removed [0] 
						$posttags = get_the_tags($item->ID);
						$custom = (get_post_custom($item->ID));	
						$itemObj["price"] = $custom["cost"][0];
						$itemObj["cpd"] = $custom["cpd_points"][0];
						$itemObj["location"] = $custom["venue"][0];
						$itemObj["audience"] =  $custom["target_audience"][0];
						$tagstr="";
						if ($posttags) {
							foreach($posttags as $tag) {
								$tagurl = $tag->slug;
								$tagstr=$tagstr."<a href='/tag/{$tagurl}'><span class='label label-info'>" . str_replace(' ', '&nbsp;' , $tag->name) ."</span></a>";
							}
							if($tagstr != ""){
								$itemObj["tags"] = $tagstr;
							}
						}
					
						$courseType = wp_get_post_terms($item->ID, 'course-types');
						
						$key = $courseType[0]->name;
						
						
						//if has letter append to array, else create new key
						if($items[$key]){
							array_push($items[$key], $itemObj);
						}else{
							$items[$key] = array();
							array_push($items[$key], $itemObj);
						}
					}
					
					?>
					
					<?php
						if(count(array_keys($items)) > 1){
					?>
					<div class="tabbable">
					
					
						<ul class="nav nav-tabs">
							<li class="active"><a href="#" data-toggle="tab" id="allItems">All courses</a></li>
							<?php
								foreach($items as $key => $itemLetter){
									$activator = "";
									if(count($itemLetter) < 1 ){
										echo "<li class=\"disabled\"><a>".ucfirst($key)."</a></li>";
	
									}else{
										echo "<li><a href=\"#tab".strtolower(str_replace(" ","",$key))."\" data-toggle=\"tab\" class=\"azTab\">".ucfirst($key)."</a></li>";
									}
								}
							
							?>
						</ul>
					<?php
					
					}
					
					?>
					
					<div class="tab-content" id="service-tabs">
							<?php
							
							foreach($items as $key => $value){
								$activator = "";
								if(count($value) > 0 ){
									$activator = " active";
								}
							
								echo "<div class=\"tab-pane".$activator."\" id=\"tab".strtolower(str_replace(" ","",$key))."\">";
								
								echo "<h3>".ucfirst($key)."</h3>";
								
								foreach($value as $item){
									echo "<div class=\"media\">";
									
									
									if(!$item["thumbnail"]){
										// $postThumb = "http://placehold.it/150x150";
									}else{
										$postThumb = $item["thumbnail"][0];
									}
									
									echo "<a href=\"".$item["link"]."\" class=\"pull-left\"><img src=\"".$postThumb."\" class=\"media-object course-thumbnail\"></a>";
									
									echo "<div class=\"media-body\">";
									
									echo "<h4><a href=\"".$item["link"]."\">".$item["title"]."</a></h4>";
									
									
									
									echo pippin_excerpt_by_id($item["id"], 20);
									
									echo "<ul class=\"inline\">";
									
									if($item["tags"]){
										echo "<li><i class='icon-tags'></i> <strong>Tags:</strong> ".$item["tags"]."</li>";
									}
									
									if($item["price"] != ""){
										echo "<li><strong>Price:</strong> ".$item["price"]."</li>";
									}
									
									if($item["cpd"] != ""){
										echo "<li><strong>CPD points:</strong> ".$item["cpd"]."</li>";
									}
									
									if($item["location"] != ""){
										echo "<li><strong>Location:</strong> ".$item["location"]."</li>";
									}
									
									if($item["audience"] != ""){
										echo "<li><strong>Audience:</strong> ".$item["audience"]."</li>";
									}
									
									echo "</ul>";
									
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
							$("#allItems").addClass('active');
							$(".tab-content .media").show();
							$(".tab-pane").each(function(i, t){
								$(".azTab").removeClass("active");
								$(this).addClass('active');
								
								if($(this).children(".media").length == 0){
									$(this).removeClass('active');
								}
							});
						});
						
						
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
				</div>

					
					
<?php endwhile; ?>

<?php get_footer(); ?>
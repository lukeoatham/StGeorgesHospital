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
						$itemObj["thumbnail"] = wp_get_attachment_image_src(get_post_thumbnail_id($item->ID),'thumbnail')[0];
						$posttags = get_the_tags($item->ID);	
						$tagstr="";
						if ($posttags) {
							foreach($posttags as $tag) {
								$tagurl = $tag->slug;
								$tagstr=$tagstr."<a href='/tag/{$tagurl}'><span class='label label-info'>" . str_replace(' ', '&nbsp;' , $tag->name) ."</span></a>";
							}
							$itemObj["tags"] = $tagstr;
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
										$postThumb = "http://placehold.it/150x150";
									}else{
										$postThumb = $item["thumbnail"];
									}
									
									echo "<a href=\"".$item["link"]."\" class=\"pull-left\"><img src=\"".$postThumb."\" class=\"media-object course-thumbnail\"></a>";
									
									echo "<div class=\"media-body\">";
									
									echo "<h4><a href=\"".$item["link"]."\">".$item["title"]."</a></h4>";
									
									
									
									echo pippin_excerpt_by_id($item["id"], 20);
									
									if($item["tags"]){
										echo " <i class='icon-tags'></i> Tags: ".$item["tags"];
									}
									
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

					
					
<?php endwhile; ?>

<?php get_footer(); ?>
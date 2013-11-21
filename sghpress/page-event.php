<?php
/* Template name: Events page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php
	$cdir=$_GET['cdir'];
	$beforeOrAfter = ">=";

	if(!$cdir){
		$timetravel = "<div class='pastevents'><a href='".home_url( '/' )."events/?cdir=b".$cdir."'>&laquo; Past events</a></div>";
	}else{
		$timetravel = "<div class='pastevents'><a href='".home_url( '/' )."events/'>Upcoming events &raquo;</a></div>";
		 $beforeOrAfter = "<=";
	}

?>			
				<div class="row-fluid">
					<div class="span3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
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
					
					?>" id='content'>
							
					<?php 
						echo "<h1>";
						if (!$cdir) {
							echo "Events";
						} else { 
							echo "Past events" ;
						}
						echo "</h1>";
							
							
						$cat_id = $_GET['cat'] ? $_GET['cat'] : 0;
						
												
						$tdate= getdate();
						$tdate = $tdate['year']."-".$tdate['mon']."-".$tdate['mday'];
						$tday = date( 'd' , strtotime($tdate) );
						$tmonth = date( 'm' , strtotime($tdate) );
						$tyear= date( 'Y' , strtotime($tdate) );
						$sdate=$tyear."-".$tmonth."-".$tday." 00:00";
							
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
							
						$cquery = array(
							'post_type' => 'event',
							'posts_per_page' => 10,
							'meta_query' => array(
							array(
								'key' => 'event_start_date',
								'value' => $sdate,
								'compare' => $beforeOrAfter,
								'type' => 'DATE' )
							),   
							'orderby' => 'meta_value',
							'meta_key' => 'event_start_date',
							'order' => 'ASC',
							'paged' => $paged
						);
			
						if($cat_id){
							$cquery['tax_query'] = array(array('taxonomy'=>'event-types','field'=>'slug','terms'=>$cat_id));
						}
			
						$customquery = new WP_Query($cquery);
						
						
						$events = array();
						$eventTypes = array();
						
						foreach($customquery->posts as $event){
							$eventObj = array();
							$eventObj["title"] = $event->post_title;
							$eventObj["link"] = $event->guid;
							$eventObj["id"] = $event->ID;
							
						
							$eType = get_the_terms($event->ID, 'event-types');
							
							if($eType){
								$eventObj["types"] = "";
								foreach($eType as $k => $val){
									if(!$eventTypes[$val->slug]){
										$eventTypes[$val->slug] = $val->name;
									}
									$eventObj["types"] .= " ".$val->slug;
								}
							}
							
							
							
							
							$eventDate = get_post_meta($event->ID, 'event_start_date', true);
							$eventObj["date"] = $eventDate;
							$key = date( 'F' , strtotime($eventDate) )."-".date("Y", strtotime($eventDate));
							
							if($events[$key]){
								array_push($events[$key], $eventObj);
							}else{
								$events[$key] = array();
								array_push($events[$key], $eventObj);
							}
						}
						
						
						?>
						<?php the_content(); ?>
							
						<div class="tabbable">
						
						<?php
							if(count(array_keys($eventTypes)) > 1){
						?>
						
						<ul class="nav nav-tabs">
							<li<?php if(!$cat_id){ echo " class=\"active\""; }?>><a href="#" data-toggle="tab" id="allTypes">All</a></li>
							<?php
								foreach($eventTypes as $key => $servLetter){
									$activeType = "";
									if($cat_id && $cat_id == $key){
										$activeType = " class=\"active\"";
									}
									echo "<li".$activeType."><a href=\"/news/events/?cat=".$key."\" data-toggle=\"tab\" class=\"site\">".$servLetter."</a></li>";
								}
							
							?>
						</ul>
						
						<?php
						
						}
						
						?>
						
						<div class="tab-content" id="service-tabs">
							<?php	
							
							
							if(empty($events)){
									echo "<p>No events currently scheduled.</p>";
							}else{
								echo $timetravel;
							}
							
							foreach($events as $key => $value){
								echo "<div class=\"tab-pane active\" id=\"tab".$key."\">";
								echo "<h3>".str_replace("-", " ", $key)."</h3>";
								foreach($value as $serv){
									echo "<div class=\"media".$serv["types"]."\">";
									
									$postThumb = wp_get_attachment_image_src(get_post_thumbnail_id($serv["id"]), array(150,150), false);
									
									if(!$postThumb){
										$postThumb = "/wp-content/themes/sghpress/images/1x1.png";
									}else{
										$postThumb = $postThumb[0];
									}
									
									echo "<a href=\"".$serv["link"]."\" class=\"pull-left\"><img src=\"".$postThumb."\" class=\"media-object item-thumbnail\"></a>";
									
									echo "<div class=\"media-body\">";
									
									echo "<h4><a href=\"".$serv["link"]."\">".$serv["title"]."</a></h4>";
									echo "<strong>".date('l jS F Y',strtotime($serv["date"]))."</strong>";
									
									echo pippin_excerpt_by_id($serv["id"], 20);
									
									
									
									echo "</div>";
									
									echo "</div>";
								}
								echo "</div>";	
							}
							
							
							
							echo $timetravel;
							?>
					
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
						
						$(".site").click(function(e){
							e.preventDefault();
							var selectedSite = $(this).attr("href");
							selectedSite = selectedSite.replace("/news/events/?cat=", "");
							$(".nav-tabs li").removeClass("active");
							$(this).parent("li").addClass("active");
							$(".tab-content .media").hide();
							$(".tab-pane").each(function(i, t){
								$(".serviceTab").removeClass("active");
								$(this).addClass('active');
								if($(this).children("." + selectedSite).length == 0){
									$(this).removeClass('active');
								}
							});
							$("." + selectedSite).show();
						});
						
						$('.serviceTab').click(function (e) {
							e.preventDefault();
							$(".tab-content .media").show();
							
						});

					</script>	
					
					
					
					
					
						
						<?php if (  $customquery->max_num_pages > 1 ) : ?>
							<?php if (function_exists(wp_pagenavi)) : ?>
								<?php wp_pagenavi(array('query' => $customquery)); ?>
	 						<?php else : ?>
								<?php next_posts_link('&larr; Older items', $customquery->max_num_pages); ?>
								<?php previous_posts_link('Newer items &rarr;', $customquery->max_num_pages); ?>						
							<?php endif; ?>
						<?php endif; ?>
						</div>
						</div>
					</div>
					<div class="span3">
					
					
								
					
					</div>
					
				</div>

<?php endwhile; ?>



<?php get_footer(); ?>
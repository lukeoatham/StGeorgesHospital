<?php
/* Template name: Services page */

get_header(); 

$hospsite = $_GET['hospsite'];
$show = $_GET['show'];

if ($show=="ALL"){
	$show='';
}

if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
<div class="span3" id='secondarynav'>

										<?php renderLeftNav(); ?>				
												
					</div>				
					<div class="span9">
					<div id="mobhead">
						<h1><?php the_title() ; ?></h1>
					</div>
					<div class="row-fluid">
						<form action="/">
						<div class="input-append">
						  <input class="span12" name="s" id="appendedInputButton" type="text">
						  <button class="btn" type="button">Search services</button>
						  <input type="hidden" value="service" name="post_type">
						</div>
						</form>

<?php

					//get all services
					/*"tax_query"=> array(array(
							"taxonomy"=>"sites",
							"terms"=>$hospsite,
							"field"=>"slug"
							)*/
							
							
					//$querystr = "
								//SELECT wpostmeta.post_id, wpostmeta.meta_key
								//FROM $wpdb->posts wposts INNER JOIN $wpdb->postmeta wpostmeta ON wposts.ID = wpostmeta.post_id WHERE wposts.ID = ".$mainid;
								
					/*$querystr = "SELECT * FROM $wpdb->postmeta wpostmeta WHERE meta_key = 'service-relationship' AND meta_value LIKE '%$mainid%'"; <- gets all things from post meta that have the service id: SPITS OUT REVISIONS OF CONTENT!
					
					$pageposts = $wpdb->get_results($querystr, OBJECT);
					
					foreach($pageposts as $clin){
						echo "<a href=\"".get_permalink($clin->post_id)."\">".get_the_title($clin->post_id)."</a>";
					}
					
					var_dump($pageposts);*/
					$gtermsa = new WP_Query('post_type=service&posts_per_page=-1&orderby=name&order=ASC');
					
					$servs = array();
					$sites = array();
					// do a for loop, check dict for key which is first letter of service name
					
					foreach($gtermsa->posts as $serv){
						$servObj = array();
						$key = strtolower(substr($serv->post_title, 0, 1));
						$servObj["title"] = $serv->post_title;
						$servObj["link"] = $serv->guid;
						$sSites = get_the_terms($serv->ID, 'sites');
						//var_dump($sSites);
						if($sSites){
							$servObj["sites"] = array();
							foreach($sSites as $k => $val){
								if(!$sites[$val->slug]){
									$sites[$val->slug] = $val->name;
								}
								array_push($servObj["sites"], $val->slug);
							}
						}
						//if has letter append to array, else create new key
						if($servs[$key]){
							array_push($servs[$key], $servObj);
						}else{
							
							$servs[$key] = array();
							array_push($servs[$key], $servObj);
						}
						
					}
					
					
					
					
					


					/*$letters = range('A','Z');
					
					foreach($letters as $l) {
						
						$letterlink[$l] = "<li class='atoz disabled {$l}'><a href='#'>".$l."</a></li>";
					}	*/			
					
					?>	
					
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li><a href="#" data-toggle="tab" id="allServs">All services</a></li>
							<?php
							
							foreach($servs as $key => $servLetter){
								echo "<li><a href=\"#".$key."\" data-toggle=\"tab\" class=\"serviceTab\">".strtoupper($key)."</a></li>";
							}
							
							foreach($sites as $siteKey => $siteVal){
								echo "<li><a href=\"#".$siteKey."\" class=\"site\">".$siteVal."</a></li>";
							}
							
							?>
						</ul>
						
						
						<div class="tab-content">
							<?php
							
							foreach($servs as $key => $value){
								echo "<div class=\"tab-pane\" id=\"".$key."\">";
								
								echo "<ul>";
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
									echo "<li class='".$sites."'><a href=\"".$serv["link"]."\">".$serv["title"]."</a></li>";
								}
								echo "</ul>";
								echo "</div>";
								
							}
							
							?>
						</div>
					</div>
					
					<script type="text/javascript">
						$(document).ready(function(){
							$("#allServs").addClass('active');
							$(".tab-pane").each(function(i, t){
								$(".serviceTab").removeClass("active");
								$(this).addClass('active');
							});
						});
					
						$('#allServs').click(function (e) {
							//e.preventDefault();
							$("#allServs").addClass('active');
							$(".tab-content li").show();
							$(".tab-pane").each(function(i, t){
								$(".serviceTab").removeClass("active");
								$(this).addClass('active');
							});
						});
						
						$(".site").click(function(e){
							e.preventDefault();
							var selectedSite = $(this).attr("href");
							selectedSite = selectedSite.replace("#", "");
							$(this).addClass("active");
							$(".tab-content li").hide();
							$(".tab-pane").each(function(i, t){
								$(".serviceTab").removeClass("active");
								$(this).addClass('active');
							});
							$("." + selectedSite).show();
						});
						
						$('.serviceTab').click(function (e) {
							e.preventDefault();
							$(".tab-content li").show();
							$(this).tab('show');
						});

					</script>			
					
					<!-- <div class="pagination">
					<ul>
					<li class='atoz<?php if ($show=='ALL' || $show=='') echo ' active'; ?>'><a href='?show=ALL&amp;hospsite=<?php echo $hospsite; ?>'>All services</a></li>
					<?php
					
					$gterms = new WP_Query('post_type=service&posts_per_page=-1&orderby=name&order=ASC');
					
					$counter = 0;
							
					if ( $gterms->have_posts() ) while ( $gterms->have_posts() ) : $gterms->the_post(); ?>
																	
					<?php 
						
						$title = get_the_title();
						$thisletter = strtoupper(substr($title,0,1));	
													
						$hasentries[$thisletter] = $hasentries[$thisletter] + 1;
						
						if (!$_REQUEST['show'] || (strtoupper($thisletter) == strtoupper($_REQUEST['show']) ) ) {
							
							$html .= "\r\r<div class='letterinfo'>\r<h3>".get_the_title()."</h3><div>" . wpautop(get_the_content()) . "</div></div>";
							
							$counter++;
																														
						}
						
						$activeletter = ($show == strtoupper($thisletter)) ? "active" : null;

						$letterlink[$thisletter] = ($hasentries[$thisletter] > 0) ? "<li class='atoz {$thisletter} {$activeletter}'><a href='?show=".$thisletter."&amp;hospsite=".$hospsite."'>".$thisletter."</a></li>" : "<li class='atoz  emptyletter {$thisletter} {$activeletter}'><a href='#'>".$thisletter."</a></li>";
					
					?>
							
						
					<?php endwhile; ?>
					
					<?php 
						//print_r($letterlink); 
						echo @implode("",$letterlink); 
					
					
					if ($show==''){
						$show="ALL";
					}
			
					?>
					</ul>
					</div>
					

					<ul class="nav nav-pills">
<?php //display filter terms
				 
				 $sites = get_terms('sites'); 
				 foreach ($sites as $site){
					 
					 echo "<li";
					 if ($site->slug == $hospsite) echo " class='active'";
					 echo "><a href='/services/a-z/?hospsite=".$site->slug."&show=".$show."'>".$site->name."</a></li>";
				 }
					 echo "<li";
					 if (!$hospsite) echo " class='active'";
					 echo "><a href='/services/a-z/?show=".$show."'>All</a></li>";
				 
				 ?>
					</ul>
		<?php 
							the_content(); ?>

					

<ul class="nav nav-list">
<?php
					if ($show=='ALL'){
						$show="";
					}

				//list all services
						if ($hospsite){
						$allservices = get_posts(
							array(
							"post_type" => "service",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"tax_query"=> array(array(
							"taxonomy"=>"sites",
							"terms"=>$hospsite,
							"field"=>"slug"
							)
							)							
							)
						);
						} else {
						$allservices = get_posts(
							array(
							"post_type" => "service",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							)
						);							
							
						}
						
					foreach ($allservices as $service){
						if (($show && strtoupper(substr($service->post_title, 0,1)) == strtoupper($show)) || !$show ){
							echo "<li class='page_item'><a href='".$service->guid."'>".sghpress_custom_title($service->post_title)."</a></li>";
						}
					} 
?>
</ul>	-->
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
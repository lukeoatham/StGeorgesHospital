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

					$letters = range('A','Z');
					
					foreach($letters as $l) {
						
						$letterlink[$l] = "<li class='atoz disabled {$l}'><a href='#'>".$l."</a></li>";
					}				
					
					?>				
					
					<div class="pagination">
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
</ul>	
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
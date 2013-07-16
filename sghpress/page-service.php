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

										
							<div class="menu-primary-navigation-container"><ul id="nav" class="menu"><li class="service menu-item menu-item-type-post_type menu-item-object-page page_item page-item-7  current_section"><a href="http://sgh.helpfulclients.com/services/">Services</a><ul class="children"><li class="page_item page-item-230 current-menu-item current_page_item"><a href="http://sgh.helpfulclients.com/services/a-z/">Services A-Z</a></li>
<li class="page_item page-item-232"><a href="http://sgh.helpfulclients.com/services/clinician-directory/">Clinician directory</a></li>
<li class="page_item page-item-234"><a href="http://sgh.helpfulclients.com/services/private-patients/">Private patients</a></li>
</ul></div>						
												
					</div>				
					<div class="span9">
					<h1><?php the_title() ; ?></h1>
					<div class="row-fluid">

<?php

					$letters = range('A','Z');
					
					foreach($letters as $l) {
						
						$letterlink[$l] = "<li class='atoz disabled {$l}'><a href='#'>".$l."</a></li>";
					}				
					
					?>				
					
					<div class="pagination span12">
					<ul>
					<li class='atoz<?php if ($show=='ALL' || $show=='') echo ' active'; ?>'><a href='?show=ALL&amp;hospsite=<?php echo $hospsite; ?>'>All services</a></li>
					<?php
					
					$gterms = new WP_Query('post_type=service&post_parent=0&posts_per_page=-1&orderby=name&order=ASC');
					
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
					
					</div>
					<ul class="nav nav-pills span12">
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

					

<ul class="nav nav-list span12">
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
							"post_parent" => 0,
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
							"post_parent" => 0,
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

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					


		


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
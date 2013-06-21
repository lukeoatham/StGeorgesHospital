<?php
/* Template name: Services page */

get_header(); 

$hospsite = $_GET['hospsite'];
$show = $_GET['show'];

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">
					<div class="ninecol" iid='secondarynav'>
<style>
/* A to Z listings */
#atozlist h3 {
	cursor:pointer; 
	background: url("images/state.gif") no-repeat 0% 4px; 
	display:block; 
	padding-left: 24px;
}  

#atozlist h3.active {
	background-position: 0% -85px;
}

.atozlisting {
	clear: left;
	padding: 0.5em 0;
}

.atozlisting ul {
	margin-left: 1em;
}

.atozlisting ul li {
	list-style: none !important;
}

.atoz {
	float: left;
	background: white;
	padding: 0.5em;
	margin: 0.2em;
	padding: 0.5em 0.5em;
	font-size: 1em !important;
	width: 1.25em;
	text-align: center;
}

.atoz a {
	text-decoration: none;
	display: block;
}

.emptyletter {
	background: #ddd !important;
	color: #aaa;
}

.activeletter {
	background: #333 !important;
}

.activeletter a {
	color: #fff !important;
}

.letterinfo h3 {
	font-size: 0.9em;
}
</style>
<?php
					if ($_REQUEST['show'] === null) $_REQUEST['show'] = "A";

					$letters = range('A','Z');
					
					foreach($letters as $l) {
						
						$letterlink[$l] = "<p class='atoz emptyletter {$l}'>".$l."</p>";
					}				
					
					?>				
					
					<div id='atozlist' class="atozlisting" data-collapse="accordion">
					
					<div class='clearfix'>
					<p class='atoz'><a href='?show=&hospsite=<?php echo $hospsite; ?>'>All</a></p>
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
									
									$activeletter = ($_REQUEST['show'] == strtoupper($thisletter)) ? "activeletter" : null;

									$letterlink[$thisletter] = ($hasentries[$thisletter] > 0) ? "<p class='atoz {$thisletter} {$activeletter}'><a href='?show=".$thisletter."&hospsite=".$hospsite."'>".$thisletter."</a></p>" : "<p class='atoz {$thisletter} {$activeletter}'>".$thisletter."</p>";
								
								?>
							
						
					<?php endwhile; ?>
					
					<?php 
						//print_r($letterlink); 
						echo @implode("",$letterlink); 
					?>
					
					</div>
		
					<p><br><a href="/services/a-z/?show=<?php echo $show; ?>">All services</a> | <a href="/services/a-z/?hospsite=st-georges&show=<?php echo $show; ?>">St George's</a> | <a href="/services/a-z/?hospsite=queen-marys&show=<?php echo $show; ?>">Queen Mary's</a></p>
		<?php 
							the_content(); ?>
					
<div id="sectionnavx">
<ul>
<?php
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
					
					<div class="threecol last">

					<?php 

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					


		


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
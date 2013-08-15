<?php
/* Template name: Clinicians page */

get_header(); 

$show = $_GET['show'];
if (!$show){
	$show="A";
}
if ($show=="ALL"){
	$show='';
}

?>



<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


				<div class="row-fluid">
				<div class="span3" id='secondarynav'>
				
					<?php renderLeftNav(); ?>
				
				</div>
				<div class="span9">
					<h1><?php the_title() ; ?></h1>
					
<?php
					$letters = range('A','Z');
					
					foreach($letters as $l) {
						
						$letterlink[$l] = "<li class='atoz disabled {$l}'><a href='#'>".$l."</a></li>";
					}				
					
					?>				
					
					<div class="pagination">
					<ul>
					<li class='atoz<?php if ($show=='ALL' || $show=='') echo ' active'; ?>'><a href='?show=ALL&amp;hospsite=<?php echo $hospsite; ?>'>All clinicians</a></li>					
					<?php
					
					$gterms = new WP_Query(array(
					"post_type"=>"people",
					"posts_per_page"=>-1,
					"meta_key"=>"show",
					"meta_value"=>"1",
					"tax_query"=>array(array(
					"taxonomy"=>"people-types",
					"field"=>"slug",
					"terms"=>"clinician"
					)),					
					));	
					
					$counter = 0;
							
					if ( $gterms->have_posts() ) while ( $gterms->have_posts() ) : $gterms->the_post(); ?>
																	
								<?php 
//			    add_post_meta($post->ID, 'show', 1, TRUE);
//				sleep (0.5);
									$title = get_the_title();
									$lastname = get_post_meta($post->ID,'last_name',TRUE);
									$thisletter = strtoupper(substr($lastname	,0,1));	
																
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
					?>					
					</ul>
					</div>

					

					<ul class="nav nav-list">
					<?php
					$clinicians = new WP_Query(
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
					
					while ($clinicians->have_posts()) {
				$clinicians->the_post();
				

				$displayname = get_post_meta($post->ID,'last_name',TRUE).", ".get_post_meta($post->ID,'professional_title',TRUE)." ".get_post_meta($post->ID,'first_name',TRUE);
					if (($show && strtoupper(substr(get_post_meta($post->ID,'last_name',TRUE), 0,1)) == strtoupper($show)) || !$show ){
						echo "<li><a href='".$post->guid."'>".$displayname."</a></li>";
					}
				}

					
					?>
					</ul>
					</div>
					


				<hr>


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
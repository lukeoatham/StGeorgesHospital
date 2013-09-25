<?php
/* Template name: Services page alt */

get_header(); 

$hospsite = $_GET['site'];



if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
<div class="span3" id='secondarynav'>

										<?php renderLeftNav(); ?>				
												
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
					<div id="mobhead">
						<h1><?php the_title() ; ?></h1>
					</div>
					
					<div class="row-fluid">
<?php
						// get sites
					$taxsites = get_terms('sites',array('orderby'=>'slug'));
					//print_r($taxsites);

					echo "<div class=\"tabbable\">";						

					  echo "<ul class=\"nav nav-tabs\">";
					  						$tk=0;

					  foreach ($taxsites as $ts){ 
						$tk++;

						  echo "<li";
						  if ($tk==1) echo " class='active'";
						  echo " class='sitetab'><a href='#".$ts->slug."' data-toggle='tab'>".$ts->name."</a></li>";
						  }
					  echo "</ul>";
					  
  						echo "<div class=\"tab-content\">";

						//for each site
					  foreach ($taxsites as $ts){
							//start a new tab
							echo "<div class=\"tab-pane";
							if ($ts->slug=='01-st-georges') echo " active";
							echo "\" id=\"".$ts->slug."\">";
							echo "<p><strong>Main service areas</strong></p>";
								//list top level services
							$terms = $ts->slug;
							$args = array(
								'tax_query' => array(
									array(
										'taxonomy' => 'sites',
										'field' => 'slug',
										'terms' => $terms,
									)
								)
								);
							$q = array(
							"post_type"=>"service",
							"post_parent"=>0,
							"posts_per_page"=>-1,
							"post_status"=>"publish",
							"orderby"=>"title",
							"order"=>"ASC",
							"tax_query"=>array(array(
								"taxonomy"=>"sites",
								"field"=>"slug",
								"terms"=>$terms
							))
							);

							$siteservices = get_posts($q);
								$ssk=0;
								foreach ($siteservices as $ss){
									$ssk++;
									if ($ssk==4) $ssk=1;
									if ($ssk==1) {
										echo "<div class='row-fluid container'>";
									}
										$cleantitle = sghpress_custom_title($ss->post_title);
										echo "<div class='span4'><a href='".$ss->guid."' class=''>".$cleantitle."</a><br><br></div>";
									if ($ssk==3) {
										echo "</div>";
									}
								}
								if ($ssk<3) {
									echo "</div>";							
								}
													echo "<p><strong>A-Z services at ".$ts->name."</strong></p>";

							echo "</div>";//end tab

						}							
						

						echo "</div>";//end tab content (each site)

					echo "</div>"; //end tabbable
						
?>

	

						</div>
					</div>
							
					
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
							
								$("#sidebar").prepend('<img src="<?php echo $thumbnail[0]; ?>">');
							
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
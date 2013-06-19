<?php
/* Template name: Services page */

get_header(); 

$hospsite = $_GET['hospsite'];
if (!$hospsite){
	$hospsite="st-georges";
}
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">
					<div class="ninecol" iid='secondarynav'>


		
					<p><br><a href="/services/a-z/?hospsite=st-georges">St George's</a> | <a href="/services/a-z/?hospsite=queen-marys">Queen Mary's</a></p>
		<?php 
							the_content(); ?>
					
<div id="sectionnavx">
<ul>
<?php
				//list all services
						
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
						
					foreach ($allservices as $service){
						echo "<li class='page_item'><a href='".$service->guid."'>".sghpress_custom_title($service->post_title)."</a></li>";
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
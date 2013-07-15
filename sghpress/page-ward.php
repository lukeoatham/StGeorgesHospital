<?php
/* Template name: Wards page */

get_header();

$hospsite = $_GET['hospsite'];
$paged = $_GET['paged'];
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row-fluid">
				
				<div class="span3" id='secondarynav'>

										
							<div class="menu-primary-navigation-container"><ul id="nav" class="menu"><li class="patient menu-item menu-item-type-post_type menu-item-object-page page_item page-item-7  current_section"><a href="http://sgh.helpfulclients.com/patients-and-visitors//">Patients and visitors</a><ul class="children"><li class="page_item page-item-230 current-menu-item current_page_item"><a href="http://sgh.helpfulclients.com/patients-and-visitors/our-wards/">Our wards</a></li>
</ul></div>						
												
					</div>	
				
					<div class="span6">

					<h1><?php the_title() ; ?></h1>
				<?php the_content(); ?>
					
					<ul class="nav nav-pills">
					<?php //display filter terms
				 
				 $blogtypes = get_terms('sites'); 
				 foreach ($blogtypes as $blogtype){
					 
					 echo "<li";
					 if ($blogtype->slug == $hospsite) echo " class='active'";
					 echo "><a href='/patients-and-visitors/our-wards/?hospsite=".$blogtype->slug."'>".$blogtype->name."</a></li>";
				 }
					 echo "<li";
					 if (!$hospsite) echo " class='active'";
					 echo "><a href='/patients-and-visitors/our-wards/'>All</a></li>";
				 
				 ?>
					
					
					</ul>



					
<ul class="nav nav-list">
<?php
				//list all wards
				if ($hospsite){
						$wards = new WP_query(
							array(
							"post_type" => "ward",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"paged"=>$paged,
							"tax_query"=> array(array(
							"taxonomy"=>"sites",
							"terms"=>$hospsite,
							"field"=>"slug"
							)
							)
							)
						);
						} else {
							$wards = new WP_query(
							array(
							"post_type" => "ward",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"paged"=>$paged
							));

						}

						//check each element in the array to see if it matches this service
						while ($wards->have_posts()) {
							$wards->the_post();
									echo "<li><a href='".$post->guid."'>".$post->post_title."</a></li>";
								}
?>
</ul>	
					
					</div>
					
					<div class="span3">

					<?php 

					the_post_thumbnail('medium');
					
					?>
					
					</div>
					

				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
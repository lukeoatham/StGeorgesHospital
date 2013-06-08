<?php
/* Template name: Clinicians page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="threecol">

						<h3>Filter</h3>
	<form action="/services/clinician-directory/">			
  <label for="service">Service</label>
  <select id="service" name="services" >
<?php  
	$showservice = $_GET['services'];
	if ($showservice==''){
	$showservice='all';
	}
	$allservices = get_posts(
							array(
							"post_type" => "service",
							"posts_per_page" => -1,
							"orderby" => "title",
							"order" => "ASC",
							"post_parent" => 0,
							"post_status"=>"publish"
							)
						);
						echo  '<option value="all">All services</option>';
						
					foreach ($allservices as $service){
						echo  '<option ';
						if ($service->ID==$showservice){
							echo "selected=selected ";
						}  
						echo 'value="'.$service->ID.'">'.$service->post_title.' </option>';
					}
?>
  </select>
  <input type="submit" value="Go" />
	</form>
			
					
						

					</div>

					<div class="ninecol last">
					<?php
					
					if ($showservice=='all'){					
					$clinicians = new WP_Query(array(
					'post_type'=>'clinician',
					'posts_per_page'=>-1,
					'orderby'=>'meta_value',
					'meta_key'=>'last_name',
					'order'=>'ASC')
					);
					} else {
					$clinicians = new WP_Query(array(
					'post_type'=>'clinician',
					'posts_per_page'=>-1,
					'orderby'=>'meta_value',
					'meta_key'=>'last_name',
					'order'=>'ASC',
					'meta_query'=>array(array(
					'key'=>'service-relationship',
					'value'=>$showservice,
					
					))
					)
					);
					}
					while ($clinicians->have_posts()) {
				$clinicians->the_post();
				$x = get_the_title();
				echo "<a href='".$post->guid."'>".$x."</a><br>";
				}

					
					?>
					</div>
				


				</div>
					
				

<?php endwhile; ?>

<?php get_footer(); ?>
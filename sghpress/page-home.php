<?php
/* Template name: Home page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="row">

					<div class="eightcol">
					<?php the_content(); ?>
					</div>
					
					<div class="fourcol last">
					<div class="toptasks">
						<ul class="xoxo">
								<?php dynamic_sidebar( 'top-tasks-widget-area' ); ?>
						</ul>			
					</div>		
					</div>

				<hr>


				</div>
				
<br>
				<div class="row">


<?php
query_posts('post_type=any&tag=promo');
				$cs_counter = 0;
				$max_cs_items = 3;
				
				if ( have_posts() ) {
				
					while ( have_posts() && ($cs_counter <= $max_cs_items) ) {
						the_post();
						
						if ( has_post_thumbnail( $post->ID ) ) {
								$img = get_the_post_thumbnail($post->ID,'medium') ;
						} 
						
						if ($img != "none") {
							$img_chunk = "{$img}";
						} else {
							$img_chunk = "";
						}
						$cs_counter++;
						$titlesnippet = (strlen(get_the_title())>200) ? substr(get_the_title(),0,200)."&hellip;" : get_the_title();
						$snippet = (strlen(get_the_excerpt())>150) ? substr(get_the_excerpt(),0,150)."&hellip;" : get_the_excerpt();
						$plink = get_permalink();
						echo "<div class='fourcol";
						if ($cs_counter==3) {echo ' last';}
						echo "'>";
						echo "<div class = 'feature-block'>";
						echo "			
							  <h3><a href='".$plink."'>".$titlesnippet."</a></h3>
							<a href='".$plink."'>".$img_chunk."</a>
							  <p>".$snippet."</p>
							  <div class='morelinkgrey'><a href='".$plink."'>More</a></div>
							  
							  </div>
							  </div>
						";

					}

					
				}
				
				wp_reset_query();
?>

				</div>


				
	<div class="row">
			<br>
			<hr>
			<br>	
	<div class="eightcol">
	<h2>News</h2>
<?php
query_posts('post_type=post&posts_per_page=2');
				$cs_counter = 0;
				$max_cs_items = 2;
				
				if ( have_posts() ) {
				
					while ( have_posts() && ($cs_counter <= $max_cs_items) ) {
						the_post();
						$img='none';
						if ( has_post_thumbnail( $post->ID ) ) {
								$img = get_the_post_thumbnail($post->ID,'thumbnail',array('class'=>'alignleft')) ;
						} 
						
						if ($img != "none") {
							$img_chunk = "{$img}";
						} else {
							$img_chunk = "";
						}
						$cs_counter++;
						$titlesnippet = (strlen(get_the_title())>200) ? substr(get_the_title(),0,200)."&hellip;" : get_the_title();
						$snippet = (strlen(get_the_excerpt())>150) ? substr(get_the_excerpt(),0,150)."&hellip;" : get_the_excerpt();
						$plink = get_permalink();
						echo "<div class='news_story clearfix";
						if ($cs_counter==3) {echo ' last';}
						echo "'>";
						echo "<div class = 'feature-block'>";
						echo "			
							<a href='".$plink."'>".$img_chunk."</a>
							  <h3><a href='".$plink."'>".$titlesnippet."</a></h3>
							  <p>".$snippet."</p>
							  <div class='morelinkgrey'><a href='".$plink."'>More</a></div>
							  
							  </div>
							  </div>
						";

					}

					
				}
				
				wp_reset_query();
?>	
	
	</div>
	
	<div class="fourcol last">
								<?php dynamic_sidebar( 'tout-box-widget-area' ); ?>
		
	</div>

	
	</div>				
				

<?php endwhile; ?>

<?php get_footer(); ?>
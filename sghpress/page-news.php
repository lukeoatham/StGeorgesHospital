<?php
/* Template name: News page */

get_header();
$newstype = $_GET['type'];
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


				<div class="row-fluid">

					<div class="span3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>

					<?php if ( is_active_sidebar( 'news-landing-widget-area' ) ) : ?>
		
					<?php dynamic_sidebar( 'news-landing-widget-area' ); ?>
			
					<?php endif; ?>

						
					</div>

				
					<div class="span6" id='content'>
						<?php if ( is_front_page() ) { ?>
							<h2><?php the_title(); ?></h2>
						<?php } else { ?>	
							<h1><?php the_title(); ?></h1>
						<?php } ?>				
					
							<?php the_content(); ?>

							<?php
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							if(function_exists('genarate_ajax_pagination') ) {
								$cquery=array(
								"post_type" => "newsitem",
								"posts_per_page" => 20,
								);
							} else {
								$cquery=array(
								"post_type" => "newsitem",
								"posts_per_page" => 20,
								"paged"=>$paged,
								);
							}								
							$customquery = new WP_Query($cquery);
									while ($customquery->have_posts()) : $customquery->the_post();
								   get_template_part( 'loop', 'newstwitter' );
							       endwhile;
							       
								   if(function_exists('genarate_ajax_pagination')) {
							        genarate_ajax_pagination('Load more news', 'blue', 'loop-newstwitter', $cquery); 
							        } else {
	        						if (  $customquery->max_num_pages > 1 ) {
										if (function_exists('wp_pagenavi')) {
											wp_pagenavi(array('query' => $customquery)); 
												} else {
												next_posts_link('&larr; Older items', $customquery->max_num_pages); 
												previous_posts_link('Newer items &rarr;', $customquery->max_num_pages); 	
											}
									}
									wp_reset_query();								
									}
																       
							?>
					</div>
					<div class="span3">
						<h3>Events</h3>
						<?php
						$tdate= getdate();
							$tdate = $tdate['year']."-".$tdate['mon']."-".$tdate['mday'];
							$tday = date( 'd' , strtotime($tdate) );
							$tmonth = date( 'm' , strtotime($tdate) );
							$tyear= date( 'Y' , strtotime($tdate) );
							$sdate=$tyear."-".$tmonth."-".$tday." 00:00";
						
						$equery = array(
					'post_type' => 'event',
					'posts_per_page' => 3,
				   'meta_query' => array(
			       array(
		           		'key' => 'event_start_date',
		        	   'value' => $sdate,
		    	       'compare' => '>=',
		    	       'type' => 'DATE' )
		    	        ),   
				    'orderby' => 'meta_value',
				    'meta_key' => 'event_start_date',
				    'order' => 'ASC',
				    'paged' => $paged
					);
					
					$eventquery = new WP_Query($equery);
							
							if (!$eventquery->have_posts()){
								echo "<p>Nothing to show.</p>";
							}
							
								
							if ( $eventquery->have_posts() ) {
				
								while ( $eventquery->have_posts() ) {
									$eventquery->the_post();
								echo "<div class='media'>";
									
									
									 the_post_thumbnail(array(50,50),array('class'=>'pull-left'));
									echo "<div class='media-body'>";
									echo "<a href='" .get_permalink() . "'>" . get_the_title() . "</a></h2>";
									$thisdate =  get_post_meta($post->ID,'event_start_date',true); //print_r($thisdate);
									$thisyear = substr($thisdate[0], 0, 4); 
									$thismonth = substr($thisdate[0], 4, 2); 
									$thisday = substr($thisdate[0], 6, 2); 
									echo "<br><strong>".date('j M Y',strtotime($thisdate))."</strong>";
									echo "</div>
									</div>";
								}
								
							} else {
								echo "No forthcoming events.";
							}
							
						?>
						<br>
						<p><a href-"/news/events/">More events</a></p>
						
						<h3>Gazette</h3>
						
						<?php  
							
							$docs = get_posts(
		array(
		"post_type" => "attachment",
		"posts_per_page" => 3,
		"orderby"=>"title",
		"order"=>"DESC",
		"tax_query" => array(array(
			"taxonomy" => "category",
			"terms" => 'gazette',
			"field" => "slug"
			)
			),
	));
	$taxname =  get_term_by( "slug", $doccat, "category" ) ;
	$output .= "<ul class='showbullets'>";
	foreach((array)$docs as $c) {
		$output .= "<li><a href='".wp_get_attachment_url($c->ID)."'>".get_the_title($c->ID)."</a></li>";
	}
	$output .= "</ul>";
	echo "<div class='htpeoplepageblock'>" . $output . "</div>";

							
						?>
						<a href="/about/publications/the-gazette/">Older Gazettes</a>
					</div>
				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
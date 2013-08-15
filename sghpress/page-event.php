<?php
/* Template name: Events page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php
	$cdir=$_GET['cdir'];
	$eventcat = $_GET['cat'];

			//setup future/past button
			if ($theme==""){
				if ($cdir=="b"){
					$timetravel = "<div class='futureevents'><a href='".home_url( '/' )."events/?cdir=f'>Future events &raquo;</a></div>";
				}
				else
				{
					$timetravel = "<div class='pastevents'><a href='".home_url( '/' )."events/?cdir=b'>&laquo; Past events</a></div>";
				}
			} else {
				if ($cdir=="b"){
					$timetravel = "<div class='futureevents'><a href='".home_url( '/' )."events/?cdir=f&theme=".$theme."'>Future events &raquo;</a></div>";
				}
					else
				{
					$timetravel = "<div class='pastevents'><a href='".home_url( '/' )."events/?cdir=b&theme=".$theme."'>&laquo; Past events</a></div>";
				}																
			}
			
?>			
				<div class="row">
					<div class="col-lg-3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
						<?php endif; ?>
						
					</div>

				
					<div class="col-lg-6" id='content'>
							<?php 
							echo "<h1>";
							if ($cdir!='b') {
								echo "Events";
							} else { 
							echo "Past events" ;
							}

							$pub = get_terms( 'event-types', 'orderby=count&hide_empty=0' );
							//print_r($pub);
							$cat_id = $_GET['cat'] ? $_GET['cat'] : 0;
							$cat_desc = get_term($cat_id, 'event-type');
							foreach ($pub as $sc) {
								if ($cat_id == $sc->term_id) { echo ' - '.$sc->name; } 
							}
							echo "</h1>";
							?>
							

<ul class="nav nav-pills">

    <li<?php if (!$cat_id) { echo ' class="active"'; } ?>><a href="<?php echo home_url( '/' ); ?>about/events/<?php if ($cdir=='b'){echo '?cdir=b';} ?>">All events</a></li>
<?php
	foreach ($pub as $sc) {
	//print_r($sc);
	$cat_desc = get_term($sc, 'event-type');
	?>
    <li<?php if ($cat_id == $sc->term_id ) { echo ' class="active"'; } ?>><a href="<?php echo home_url( '/' ); ?>events/?cat=<?php echo $sc->term_id; if ($cdir=='b'){echo '&cdir=b';} ?>"><?php echo $sc->name; ?></a></li>

<?php
	}
?>
</ul>
					
							<?php the_content(); ?>
							
							<?php
							echo "<br>".$timetravel;							
							$tdate= getdate();
							$tdate = $tdate['year']."-".$tdate['mon']."-".$tdate['mday'];
							$tday = date( 'd' , strtotime($tdate) );
							$tmonth = date( 'm' , strtotime($tdate) );
							$tyear= date( 'Y' , strtotime($tdate) );
							$sdate=$tyear."-".$tmonth."-".$tday." 00:00";


							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if ($cat_id!=0){ // show individual theme conferences
				if ($cdir=="b"){  //past events

				$cquery = array(

				    'tax_query' => array(
				        array(
				            'taxonomy' => 'event-types',
				            'field' => 'term_id',
				            'terms' => $cat_id,
					       ),
					    ),
	
				   'meta_query' => array(
							       array(
						           		'key' => 'event_start_date',
						        	   'value' => $sdate,
						    	       'compare' => '<=',
						    	       'type' => 'DATE' )  
					    	        ),   
								    'orderby' => 'meta_value',
								    'meta_key' => 'event_start_date',
								    'order' => 'DESC',
								    'post_type' => 'event',
									'posts_per_page' => 10,
								    'paged' => $paged												
								)
								;
				}
				else { //future events, single theme
					$cquery = array(

				    'tax_query' => array(
				        array(
				            'taxonomy' => 'event-types',
				            'field' => 'term_id',
				            'terms' => $cat_id,
					       ),
					    ),	

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
								    'post_type' => 'event',
									'posts_per_page' => 10,
								    'paged' => $paged												
								)
								;

				}	
				}else { //all themes
			if ($cdir=="b"){ //past events
			$cquery = array(
					'post_type' => 'event',
					'posts_per_page' => 10,
				   'meta_query' => array(
			       array(
		           		'key' => 'event_start_date',
		        	   'value' => $sdate,
		    	       'compare' => '<=',
		    	       'type' => 'DATE' )
		    	        ),   
				    'orderby' => 'meta_value',
				    'meta_key' => 'event_start_date',
				    'order' => 'DESC',
				    'paged' => $paged
					);
			}
			else { // future events, all themes
			$cquery = array(
					'post_type' => 'event',
					'posts_per_page' => 10,
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
			
			}
			}
			//print_r($cquery);
							$customquery = new WP_Query($cquery);
							
							if (!$customquery->have_posts()){
								echo "<p>Nothing to show.</p>";
							}
							
								
							if ( $customquery->have_posts() ) {
				
								while ( $customquery->have_posts() ) {
									$customquery->the_post();
								echo "<div class='featured_story clearfix'>";
									if ( has_post_thumbnail( $post->ID ) ) {
										the_post_thumbnail('thumbnail',"class=alignleft");
									}	
									
									echo "<h2><a href='" .get_permalink() . "'>" . get_the_title() . "</a></h2>";
									//$thisdate = date('d F',get_post_meta($post->ID,'start_date'));
									$thisdate =  get_post_meta($post->ID,'event_start_date',true); //print_r($thisdate);
									$thisyear = substr($thisdate[0], 0, 4); 
									$thismonth = substr($thisdate[0], 4, 2); 
									$thisday = substr($thisdate[0], 6, 2); 
//									$thisdate = $thisyear."-".$thismonth."-".$thisday;
									echo "<strong>".date('j M Y',strtotime($thisdate))."</strong>";
									the_excerpt();
									echo "</div><div class='clearfix'></div>";
								}
							}
							
							wp_reset_query();
							
							echo $timetravel;
							?>
					
						
						<?php if (  $customquery->max_num_pages > 1 ) : ?>
							<?php if (function_exists(wp_pagenavi)) : ?>
								<?php wp_pagenavi(array('query' => $customquery)); ?>
	 						<?php else : ?>
								<?php next_posts_link('&larr; Older items', $customquery->max_num_pages); ?>
								<?php previous_posts_link('Newer items &rarr;', $customquery->max_num_pages); ?>						
							<?php endif; ?>
						<?php endif; ?>
	
				
					</div>
					<div class="col-lg-3">
					
					
								
					
					</div>
					
				</div>

<?php endwhile; ?>



<?php get_footer(); ?>
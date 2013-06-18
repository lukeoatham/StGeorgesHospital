<?php
/* Template name: Events page */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php
	$cdir=$_GET['cdir'];


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

				
					<div class="ninecol" id='content'>
							<?php 
							echo "<h1>";
							if ($cdir!='b') {
								echo "Events";
							} else { 
							echo "Past events" ;
							}

							$pub = get_terms( 'event-type', 'orderby=count&hide_empty=0' );
							//print_r($pub);
							$cat_id = $_GET['cat'] ? $_GET['cat'] : 0;
							$cat_desc = get_term($cat_id, 'event-type');
							foreach ($pub as $sc) {
								if ($cat_id == $sc->term_id) { echo ' - '.$cat_desc->name; } 
							}
							echo "</h1>";
							?>
							
<div id="tabmenu" >
<ul>

    <li class="menu_item<?php if ($cat_id == 0) { echo ' current_menu_item'; } ?>"><a href="<?php echo home_url( '/' ); ?>events/">All events</a></li>
<?php
	foreach ($pub	 as $sc) {
	$cat_desc = get_term($sc, 'event-type');\
	?>
    <li class="menu_item<?php if ($cat_id == $sc->term_id ) { echo ' current_menu_item'; } ?>"><a href="<?php echo home_url( '/' ); ?>events/?cat=<?php echo $sc->term_id; if ($cdir=='b'){echo '&cdir=b';}?>"><?php echo $cat_desc->name; ?></a></li>
<?php
	}
?>
</ul>
</div><div class="clearfix"></div>
					
							<?php the_content(); ?>
							
							<?php
							echo "<br>".$timetravel;							
							$tdate= getdate();
							$tdate = $tdate['year']."-".$tdate['mon']."-".$tdate['mday'];
							$tday = date( 'd' , strtotime($tdate) );
							$tmonth = date( 'm' , strtotime($tdate) );
							$tyear= date( 'Y' , strtotime($tdate) );
							$sdate=$tyear."-".$tmonth."-".$tday;


							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if ($cat_id!=0){ // show individual theme conferences
				if ($cdir=="b"){

				$cquery = array(
/*
				    'tax_query' => array(
				        array(
				            'taxonomy' => 'event-type',
				            'field' => 'term_id',
				            'terms' => $cat_id,
					       ),
					    ),
*/	
				   'meta_query' => array(
							       array(
						           		'key' => 'start_date',
						        	   'value' => $sdate,
						    	       'compare' => '<=',
						    	       'type' => 'DATE' )  
					    	        ),   
								    'orderby' => 'meta_value',
								    'meta_key' => 'start_date',
								    'order' => 'DESC',
								    'post_type' => 'events',
									'posts_per_page' => 10,
								    'paged' => $paged												
								)
								;
				}
				else {
					$cquery = array(
/*
				    'tax_query' => array(
				        array(
				            'taxonomy' => 'event-type',
				            'field' => 'term_id',
				            'terms' => $cat_id,
					       ),
					    ),	
*/
				   'meta_query' => array(
							       array(
						           		'key' => 'start_date',
						        	   'value' => $sdate,
						    	       'compare' => '>=',
						    	       'type' => 'DATE' ) 
					    	        ),   
								    'orderby' => 'meta_value',
								    'meta_key' => 'start_date',
								    'order' => 'ASC',
								    'post_type' => 'events',
									'posts_per_page' => 10,
								    'paged' => $paged												
								)
								;

				}	
				}else {
			if ($cdir=="b"){
			$cquery = array(
					'post_type' => 'events',
					'posts_per_page' => 10,
				   'meta_query' => array(
			       array(
		           		'key' => 'start_date',
		        	   'value' => $sdate,
		    	       'compare' => '<=',
		    	       'type' => 'DATE' )
		    	        ),   
				    'orderby' => 'meta_value',
				    'meta_key' => 'start_date',
				    'order' => 'DESC',
				    'paged' => $paged
					);
			}
			else {
			$cquery = array(
					'post_type' => 'events',
					'posts_per_page' => 10,
				   'meta_query' => array(
			       array(
		           		'key' => 'start_date',
		        	   'value' => $sdate,
		    	       'compare' => '>=',
		    	       'type' => 'DATE' )
		    	        ),   
				    'orderby' => 'meta_value',
				    'meta_key' => 'start_date',
				    'order' => 'ASC',
				    'paged' => $paged
					);
			
			}
			}
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
									$thisdate =  get_post_meta($post->ID,'start_date');
									$thisyear = substr($thisdate[0], 0, 4); 
									$thismonth = substr($thisdate[0], 4, 2); 
									$thisday = substr($thisdate[0], 6, 2); 
									$thisdate = $thisyear."-".$thismonth."-".$thisday;
									echo "<strong>".date('d F Y', strtotime($thisdate,TRUE))."</strong>";
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
<div class="threecol last">

<?php			
 $thisurl = $_SERVER['REQUEST_URI'];
 $x = explode('/',$_SERVER['REQUEST_URI']); 
 $cx = count($x) -1 ;
 $mainarea = home_url($x[1])."/"; 
	$menu_name = 'primary';
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		echo '<div id="homenav">';
		echo '<ul id="menu-' . $menu_name . '">';
		foreach ( (array) $menu_items as $key => $menu_item ) {
		    $title = $menu_item->title;
		    $url = $menu_item->url;
		    if (network_site_url($thisurl) != $url ){
				echo '<li class=\'page_item\'><a href="' . $url . '">' . $title . '</a></li>';
			} else {
				echo '<li class=\'page_item current_page_item\'><a href="' . $url . '">' . $title . '</a></li>';
			}
		}
		echo "</ul></div>";
	}
?>
			

</div>
					
				</div>

<?php endwhile; ?>



<?php get_footer(); ?>
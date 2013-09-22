<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php 

		if ( ! have_posts() ) { 
				echo "<h1>";
				_e( 'Not Found', 'twentyten' );
				echo "</h1>";
				echo "<p>";
				_e( 'Apologies, there are no results. .', 'helpfulstrap' );
				echo "</p>";
				get_search_form(); 
				}		
		?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<?php if (function_exists(wp_pagenavi)) : ?>
		<?php wp_pagenavi(); ?>
	<?php else : ?>
		<?php next_posts_link('&larr; Older items', $wp_query->max_num_pages); ?>
		<?php previous_posts_link('Newer items &rarr;', $wp_query->max_num_pages); ?>						
	<?php endif; ?>
<?php endif; ?>		
<?php while ( have_posts() ) : the_post(); 
	$image_url = get_the_post_thumbnail($ID, 'thumbnail', array('class' => 'alignright'));


									echo "<div class='wellx'><hr>
										<div class='media'>";?>
										    <?php
											if ( has_post_thumbnail( $post->ID ) ) {
												    echo "<a class='pull-left' href='".get_permalink()."'>";
												    the_post_thumbnail('thumbnail');
													echo "</a>";
			    							}

										echo "<div class='media-body'><h2 class='media-heading'>";
										//if (get_post_type() == 'people') echo "<i class='icon-user'></i>";
										echo "<a href='" .get_permalink() . "'>" . get_the_title() . "</a></h2>";
										echo "<p>";
									
										$context='';

										if ($post->post_type=='people') { $context = "People"; }
										if ($post->post_type=='course') {$context = "Courses";}
										if ($post->post_type=='page') {
											$currentpost = get_post($post->ID);
											while (true){
												//iteratively get the post's parent until we reach the top of the hierarchy
												$post_parent = $currentpost->post_parent; 
//													echo " parent ".$post_parent;
												if ($post_parent!=0){	//if found a parent
													$currentpost = get_post($post_parent);
													continue; //loop round again
												}
												break; //we're done with the parents
											};
											$ptitle = get_the_title($currentpost->ID);
											echo "<strong>".$ptitle."</strong>";
											
										}
										if ($post->post_type=='newsitem') {$context = "News &amp; events";}
										if ($post->post_type=='event') {$context = "Events";}
										$terms = get_the_terms( $post->ID, 'sites' );
										$serviceterms='';
										foreach ($terms as $tm){
											$serviceterms.=$tm->name.", ";
										}
										$serviceterms=substr($serviceterms, 0, strlen($serviceterms)-2);
										if ($post->post_type=='service') { $context = "Services at ".$serviceterms;}
										if ($post->post_type=='ward') {$context = "Wards";}
										
										echo "<strong>".$context."</strong>";
										
										if (get_post_type() == 'newsitem') :?>
											| <i class="icon-calendar"></i> <?php 
											echo date('j M Y',strtotime($post->post_date));
										endif;

										if ( (get_post_type() == 'page') || (get_post_type() == 'service') || (get_post_type() == 'ward') ) :?>
											| <i class="icon-calendar"></i> <?php 
											echo "Updated ".date('j M Y',strtotime($post->post_modified));
										endif;
										
										if(get_post_type() == 'people'){
											$itemService = get_post_meta($post->ID, "service-relationship");
											$clinicianservice = "";
											foreach($itemService as $serviceArray){
												foreach($serviceArray as $service){
													if($clinicianservice != ""){ $clinicianservice .= ", "; }
													$clinicianservice .= get_the_title($service);
												}
											}
											if($clinicianservice != ""){
												echo " | <strong>".$clinicianservice."</strong>";
											}
										}

										
									if (get_comments_number($ID)>0) : ?>
									| <i class="icon-comment"></i> <a href="<?php comments_link(); ?>"> 
									<?php echo get_comments_number($ID); 
										if (get_comments_number($ID) == 1) {
										echo " Comment"; 
										} else {
										echo  " Comments"; 
										}
										echo "</a>";
									endif;	
									?>
									<?php $posttags = get_the_tags();
										$foundtags=false;	
										$tagstr="";
									if ($posttags) {
									  	foreach($posttags as $tag) {
									  			$foundtags=true;
									  			$tagurl = $tag->slug;
										    	$tagstr=$tagstr."
										    	<a href='/tag/{$tagurl}'><span class='label label-info'>" . str_replace(' ', '&nbsp;' , $tag->name) ."</span></a>";
											}
								  	}
									  	if ($foundtags){
										  	echo "| <i class='icon-tags'></i> Tags: ".$tagstr;
									  	
										  	}														
	
										the_excerpt();
	?>




								 </p>
									</div></div></div>


	
	<?php comments_template( '', true ); ?>

<?php endwhile; // End the loop. Whew. ?>
<hr>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<?php if (function_exists(wp_pagenavi)) : ?>
		<?php wp_pagenavi(); ?>
	<?php else : ?>
		<?php next_posts_link('&larr; Older items', $wp_query->max_num_pages); ?>
		<?php previous_posts_link('Newer items &rarr;', $wp_query->max_num_pages); ?>						
	<?php endif; ?>
<?php endif; ?>

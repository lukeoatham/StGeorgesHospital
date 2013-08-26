<?php
/* Template name: Press releases */

get_header();
 ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


				<div class="row-fluid">

					<div class="span3" id='secondarynav'>

						<?php global $post; if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ) : ?>
				
							<?php renderLeftNav(); ?>
						
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
						$customquery = new WP_query(
							array(
							"post_type" => "newsitem",
							"posts_per_page" => 20,
							"paged"=>$paged,
							"tax_query"=> array(array(
							"taxonomy"=>"news-type",
							"terms"=>'press-releases',
							"field"=>"slug"
							)
							)
							)
						);
								
							if ( $customquery->have_posts() ) {
				
								while ( $customquery->have_posts() ) {
									$customquery->the_post();

									echo "<div class='wellx'><hr>
										<div class='media'>";?>
										    <?php
									if ( has_post_thumbnail( $post->ID ) ) {
										    echo "<a class='pull-left' href=".get_permalink().">";
										    $mediaimage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'thumbnail');
										    echo "<img class='media-object' src='".$mediaimage[0]."'>";
											echo "</a>";
	    									}
	    									?>
										<?php 
										echo "<div class='media-body'><h2 class='media-heading'><a href='" .get_permalink() . "'>" . get_the_title() . "</a></h2>";
	
										the_excerpt();
	?>
<p>
										<i class="icon-calendar"></i> <?php 
										echo date('j M Y',strtotime($post->post_date));
										
									?>
									<?php if (get_comments_number($ID)>0) : ?>
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
?>									 </p></div></div></div>
<?php
								}
							} else {
								echo "Nothing newsworthy here.";
							}
							wp_reset_query();
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
					<div class="span3">

					<?php if ( is_active_sidebar( 'news-landing-widget-area' ) ) : ?>
		
					<?php dynamic_sidebar( 'news-landing-widget-area' ); ?>
			
					<?php endif; ?>
						
					
					</div>

					
				</div>

<?php endwhile; ?>

<?php get_footer(); ?>
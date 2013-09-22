<?php
/**
 * The Template for displaying all news posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
	
	$mainid=$post->ID;
?>
		
		<div class="row-fluid">
			<div class="span3" id='secondarynav'>
					
				
							<?php renderLeftNav(); ?>
						
						
			</div>
				<div class="span5" id='content'>
					<div id="mobhead">
						<h1><?php the_title() ; ?></h1>
					</div>

					<p class='postmeta'><?php 
						echo "Published: ".date('j M Y',strtotime($post->post_date));
					 ?></p>

					<?php the_content(); 
						
						$notes = get_field('notes_to_editors');
						if ($notes){
						echo "<h3>Notes to editors</h3>";
						echo wpautop($notes);
						}
					?>

						<div id='comments'>
							<?php comments_template( '', true ); ?>
						</div>						
									
				</div>
				
				<div class="span4" id='sidebar'>
					<?php

						echo get_the_post_thumbnail($post->ID,'newsubhead');
								
						echo "<span class='caption'>".get_post_thumbnail_caption()."</span>";
						$session_speaker = get_the_author_meta('ID'); 
						$newscats = get_the_terms($post->ID,'news-type');
						$foundblog = false;
						foreach ($newscats as $c){
							if ($c->slug=='blog-posts'){
								echo '<div class="row"><hr>';
								echo '<div class="avatar96">';
								echo "<a class='pull-left' href='/news/blog/'>";
								echo get_avatar($session_speaker,96) . '</a></div>';
								echo '<div class="">';
								echo "<a class='pull-left' href='/news/blog/'>";
								echo get_the_author_meta("display_name", $session_speaker);
								echo "</a><br> ";
								echo get_the_author_meta("description", $session_speaker);
								echo '</div>';
								echo '</div>';
							}
						}

						//}
						
						
						$posttags = get_the_tags();
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
										  	echo "<hr><p><i class='icon-tags'></i> Tags: ".$tagstr."</p>";
									  	
										  	}?>
										  	<hr>
										  		<?php dynamic_sidebar( 'newsitem-contact' ); ?>										  
										  	<hr>
										  	
										  	<h2>Share this story</h2>
										  	<p><a href="https://twitter.com/share?via=StGeorgesTrust&url=<?php echo urlencode("http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>&related=stgeorgesceo" class="twitter-share-button" data-lang="en">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></p>

										  	<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode("http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>&amp;width=200&amp;height=46&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;send=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:46px;" allowTransparency="true"></iframe><br>
										  	
										  	<!-- Place this tag where you want the +1 button to render. -->
										  	<div class="g-plusone" data-size="medium"></div>

										  	<!-- Place this tag after the last +1 button tag. -->
										  	<script type="text/javascript">
											  	window.___gcfg = {lang: 'en-GB'};

											  	(function() {
												  	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
												  	po.src = 'https://apis.google.com/js/plusone.js';
												  	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
												})();
											</script>
										  	<p><a href="mailto:?subject=<?php the_title(); ?>&body=<?php echo urlencode("http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]); ?>">Email this story</a></p>
										  	<p>&nbsp;</p>
										  	<?php

			echo "<div id='newsposts'><hr>";
			$category = wp_get_post_terms( $post->ID, 'news-type'); $thiscat = $category[0]->slug;
			$recentitems = new WP_Query(array(
			'post_type' => 'newsitem',
			'posts_per_page' => 5,
			'tax_query' => array(array(
				'taxonomy' => 'news-type',
				'field' => 'slug',
				'terms' => $thiscat
				))
			));			
			echo "<h2>Recently published</h2>";

			if ($recentitems->post_count==0 || ($recentitems->post_count==1 && $mainid==$post->ID)){
				echo "<p>Nothing to show yet.</p>";
			}


			if ( $recentitems->have_posts() ) while ( $recentitems->have_posts() ) : $recentitems->the_post(); 
				if ($mainid!=$post->ID) {
					$thistitle = get_the_title($ID);
					$thisURL=get_permalink($ID);
					echo "<div class='sidebox'>";
					echo "<h3><a href='{$thisURL}'>".$thistitle."</a></h3>";
					$thisdate= $post->post_date;
					$thisdate=date("j M Y",strtotime($thisdate));
					echo "<i class='icon-calendar'></i>".$thisdate;
					the_excerpt();
					echo "</div>";
				}
			endwhile; 
?>

							
				</div>
		</div>
	</div>


<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
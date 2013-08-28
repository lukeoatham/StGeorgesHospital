<?
global $post;
									echo "<hr>
										<div class='media'>";?>
										    <?php
									if ( has_post_thumbnail( $post->ID ) ) {
										    echo "<a class='pull-left' href='".get_permalink()."'>";
										    the_post_thumbnail('thumbnail');
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
										    	<a class='label label-info' href='/tag/{$tagurl}'><span>" . str_replace(' ', '&nbsp;' , $tag->name) ."</span></a>";
								  	}
								  	}
									  	if ($foundtags){
										  	echo "| <i class='icon-tags'></i> Tags: ".$tagstr;
									  	
									}

?>									 </p></div></div>
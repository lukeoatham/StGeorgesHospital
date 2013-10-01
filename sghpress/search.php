<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
					<div class="visible-phone">
						<div class="span3" id='secondarynav'>
						
							<?php renderLeftNav(); ?>
						
						</div>
					</div>
				<div class="row-fluid">
					<div class="span8 newsContent" id='content'>

<?php if ( have_posts() ) : ?>
				<h1><?php printf( __( 'Search results for: %s', 'twentyten' ), '' . get_search_query() . '' ); ?></h1>
				<?php
				if ($wp_query->found_posts>1){
				echo "<p class='conference_date'>Found ".$wp_query->found_posts." results</p>";
				}
				?>
				
				<p class="visible-phone"><a href="#advanced" class="btn btn-large btn-info">Advanced search</a></p>
				
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
					<h2><?php _e( 'Nothing found', 'twentyten' ); ?></h2>
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
					<p>
						<?php
$q = $_GET['s'];
 if (function_exists('relevanssi_didyoumean')) { relevanssi_didyoumean(get_search_query(), "<p>Did you mean: ", "?</p>", 5);
}
?>

<form role="search" method="get" id="searchformnf" action="<?php echo home_url( '/' ); ?>">
    <div><label class="screen-reader-text hiddentext" for="snf">Search for:</label>
        <input type="text" value="<?php echo $q; ?>" name="s" id="snf" accesskey='4' />
        <input type="submit" id="searchsubmitnf" value="Search" />
    </div>
</form>
					</p>
					

<?php endif; ?>

					<?php if (  $items->max_num_pages > 1 ) : ?>
						<?php if (function_exists(wp_pagenavi)) : ?>
							<?php wp_pagenavi(array('query' => $items)); ?>
 						<?php else : ?>
							<?php next_posts_link('&larr; Older items', $items->max_num_pages); ?>
							<?php previous_posts_link('Newer items &rarr;', $items->max_num_pages); ?>						
						<?php endif; ?>
					<?php endif; ?>

					</div>

					<div class="span4 searchContent" id='sidebar'>
						<div class="well">
							<h3 id="advanced">Advanced search</h3>
							<form role="search" method="get" action="<?php echo home_url('/'); ?>">
								<input type="hidden" name="s" value=<?php echo $_GET['s']; ?>>
								<h4>Filter by content type</h4>
								<?php
								$ptargs = array('_builtin' => false, 'public' => true);
								$postTypes = get_post_types($ptargs, 'objects');
								$checkbox = "";
								foreach($postTypes as $pt){
									if($pt->rewrite["slug"] != "spot"){
										$checkbox .= '<input type="checkbox" name="type[]" value="'. $pt->rewrite["slug"] .'"';
										
										if(in_array($pt->rewrite["slug"], $wp_query->query_vars["type"])){ 
											$checkbox .= "checked=\"checked\"";
										}
										
										$checkbox .= '> <span class="labelForCheck">'. $pt->labels->search_items .'</span><br>';
									}
								}
								echo $checkbox;
								?>
								<br>
								<button type="btn" class="btn btn-success">Refine search</button>
							</form>
						</div>
						<ul class="xoxo">
							<?php dynamic_sidebar( 'inside-sidebar-widget-area' ); ?>
						</ul>
					</div>
				</div>


<?php get_footer(); ?>

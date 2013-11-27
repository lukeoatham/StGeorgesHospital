<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

require_once ( get_stylesheet_directory() . '/theme-options.php'  );

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;


/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
	add_custom_image_header( '', 'twentyten_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/starkers.png',
			'thumbnail_url' => '%s/images/headers/starkers-thumbnail.png',
			/* translators: header image description */
			'description' => __( 'Starkers', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Makes some changes to the <title> tag, by filtering the output of wp_title().
 *
 * If we have a site description and we're viewing the home page or a blog posts
 * page (when using a static front page), then we will add the site description.
 *
 * If we're viewing a search result, then we're going to recreate the title entirely.
 * We're going to add page numbers to all titles as well, to the middle of a search
 * result title and the end of all other titles.
 *
 * The site title also gets added to all titles.
 *
 * @since Twenty Ten 1.0
 *
 * @param string $title Title generated by wp_title()
 * @param string $separator The separator passed to wp_title(). Twenty Ten uses a
 * 	vertical bar, "|", as a separator in header.php.
 * @return string The new title, ready for the <title> tag.
 */
function twentyten_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search for %s', 'twentyten' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), $paged );
		// Add the site name to the end:
		//$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );
	
	global $post;
	$pt = $post->post_type;

	if ($pt == "newsitem"  ) {
		$title .= " news" ;
	}
	else if ($pt == "service"  ) {
		$title .= " services" ;
	}
	else if ($pt == "people"  ) {
		$title .= " clinicians" ;
	}
	else if ($pt == "ward"  ) {
		$title .= " wards" ;
	}
	else if ($pt == "events"  ) {
		$title .= " events" ;
	}
	else if ($pt == "course"  ) {
		$title .= " courses" ;
	}
	else if ($pt == "blog"  ) {
		$title .= " blog" ;
	}
	else if ($pt == "page"  ) {
		if ($_GET['site']){
			$sitetax = get_term_by('slug',$_GET['site'],'sites',ARRAY_A);
			$title = $sitetax['name'] . " contacts, address and travel information ";
		}
	} 
	else {
		$title .= " ".$pt;
	}


	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'twentyten_filter_wp_title', 10, 2 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {

	register_sidebar( array(

		'name' => __( 'Top tasks', 'twentyten' ),
		'id' => 'top-tasks-widget-area',
		'description' => __( 'The top tasks widget area on the homepage', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Utilities', 'twentyten' ),
		'id' => 'utilities-widget-area',
		'description' => __( 'The utilities widget area on the header', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Find us box 1', 'twentyten' ),
		'id' => 'find-us-1-area',
		'description' => __( 'Homepage map area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => __( 'Find us box 2', 'twentyten' ),
		'id' => 'find-us-2-area',
		'description' => __( 'Box for St George\' address', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => __( 'Find us box 3', 'twentyten' ),
		'id' => 'find-us-3-area',
		'description' => __( 'Box for Queen Mary\'s address', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => __( 'Social media area', 'twentyten' ),
		'id' => 'social-media-area',
		'description' => __( 'Homepage social media area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'News landing', 'twentyten' ),
		'id' => 'news-landing-widget-area',
		'description' => __( 'The sidebar widget area on news landing page', 'twentyten' ),
		'before_widget' => '<div class="newsarchive">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => __( 'Inside sidebar', 'twentyten' ),
		'id' => 'inside-sidebar-widget-area',
		'description' => __( 'The sidebar widget area on inside pages', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => __( 'Values area 1', 'twentyten' ),
		'id' => 'values-widget-area1',
		'description' => __( 'Values widget area 1', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Values area 2', 'twentyten' ),
		'id' => 'values-widget-area2',
		'description' => __( 'Values widget area 2', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Sponsor', 'twentyten' ),
		'id' => 'footer-sponsor-area',
		'description' => __( 'Footer sponsor area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Footer1', 'twentyten' ),
		'id' => 'footer-widget-area1',
		'description' => __( 'Footer widget area 1', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer2', 'twentyten' ),
		'id' => 'footer-widget-area2',
		'description' => __( 'Footer widget area 2', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer3', 'twentyten' ),
		'id' => 'footer-widget-area3',
		'description' => __( 'Footer widget area 3', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer4', 'twentyten' ),
		'id' => 'footer-widget-area4',
		'description' => __( 'Footer widget area 4', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Feedback', 'twentyten' ),
		'id' => 'footer-widget-feedback',
		'description' => __( 'Footer feedback area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Emergency', 'twentyten' ),
		'id' => 'emergency_message',
		'description' => __( 'Emergency message area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Sponsor advert', 'twentyten' ),
		'id' => 'sponsor-advert',
		'description' => __( 'Sponsor advert area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'newsitem-contact', 'twentyten' ),
		'id' => 'newsitem-contact-area',
		'description' => __( 'News item Contact us area', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );

}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Published:</span> %2$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'In: %1$s. Tags: %2$s', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'In: %1$s.', 'twentyten' );
	} else {
		$posted_in = __( '', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

function remove_themeoptions_menu() { // needed to hide TwentyTen options 
	global $submenu;

	foreach($submenu['themes.php'] as $k => $m) {
		if ($m[2] == "custom-background" || $m[2] == "custom-header") {
			unset($submenu['themes.php'][$k]);
		}
	}	
}

add_action('admin_head', 'remove_themeoptions_menu');

function ht_custom_excerpt_more( $output ) {
	return preg_replace('/<a[^>]+>Continue reading.*?<\/a>/i','',$output);
}
add_filter( 'get_the_excerpt', 'ht_custom_excerpt_more', 20 );


function custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// simple shortcode to render sitemap

// [showsitemap content="pages"]
function showsitemap_func( $atts ) {
	extract( shortcode_atts( array(
		'content' => 'pages'
	), $atts ) );

	if ($content == "pages") {
		$html = wp_list_pages('echo=0&title_li=');
	} elseif ($content == "categories") {
		$cats = wp_list_categories("echo=0&title_li=");
		$html = $cats;
	} elseif ($content == "tags") {	
		$tags = get_tags( array('orderby' => 'count', 'number' => '50', 'order' => 'DESC') );
		foreach ( (array) $tags as $tag ) {
			$html .= '<li><a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . ' (' . $tag->count . ') </a></li>';
		}
	} else {
		$posts = get_posts('numberposts=-1&post_status=published');		
		foreach((array)$posts as $p) {
			$html .= "<li><a href='{$p->guid}'>{$p->post_title}</a></li>";
		}
	}
	$html = "<ul class='sitemaplist'>" . $html . "</ul>";
	return $html;
	
}
add_shortcode( 'showsitemap', 'showsitemap_func' );


function renderLeftNav($outputcontent="TRUE") {
	global $post;
	$temppost = $post;
	
	$connected = new WP_Query( array(
		'connected_type' => 'services_to_posts',
		'connected_items' => get_queried_object(),
		'nopaging' => true,
	) );
		
	$relatedposts='';
	// Display connected posts
	if ( $connected->have_posts() ) {
		while ( $connected->have_posts() ) {
			$connected->the_post();
			$relatedposts .= "<li class='page-item'><a href='".get_permalink()."'>".get_the_title()." <i class='icon-share'></i></a></li>\n";
		}								
	}
	
	//reinstate current post
	global $post;
	$post=$temppost;
	setup_postdata($post);

	if(is_single()){
		$singleURLs = explode("/", get_single_template());
		$singleURL = end($singleURLs);
		$postSection = "";
		$postSectionID = 0;
		$postID = $post->ID;
		$postType = $post->post_type;
		$before = array();
		$mainid = $post->ID;
		
	
		
				
		if($postType == "ward"){
			$postSection = "patient";
			$postSectionID = 9;
			array_push($before, 186);
		}
		
		if($postType == "event"){
			$postSection = "news";
			$postSectionID = 93;
			array_push($before, 286);
		}
		
		
		if ($postType == "service") {
			//Iterate through the top level items - Primary Nav with a walker uncomment line below if including service A-Z page
			$postSection = "service";
			$postSectionID = 7;
			//array_push($before, 230);
		}
		
		if($postType == "course"){
			$postSection = "education";
			$postSectionID = 35;
			array_push($before, 237);
			array_push($before, 241);
		}
		
		if($postType == "people"){
			$postSection = "service";
			$postSectionID = 7;
			array_push($before, 232);
		}
		
		if($postType == "newsitem"){
			$postSection = "news";
			$postSectionID = 93;
			$eType = get_the_terms($postID, 'news-type');
			foreach($eType as $k => $val){
				if($val->slug == "press-releases"){
					array_push($before, 3545);
				}
				if($val->slug == "blog-posts"){
					array_push($before, 3543);
				}
			}
		
		}
		
			// REDEV
			// create containing elements
			$postMenu = "<div class=\"menu-primary-navigation-container\">";
			$postMenu .= "<ul id=\"nav\" class=\"menu\">";
			// grab menu items + go through them
			$postMenuItems = wp_get_nav_menu_items("Primary navigation");
			foreach((array)$postMenuItems as $key => $menu_item){
				// if the menu item is the current section do some stuff, if not then make it visible to mobiles only
				if($menu_item->object_id == $postSectionID){
					$postMenu .= "<li id=\"menu-item-".$menu_item->id."\" class=\"".$menu_item->classes[0]." current_section\"><a href=\"".$menu_item->url."\">".$menu_item->title."</a>";
					//Construct any child navigation
					$postMenu .= "<ul class=\"children\" role=\"navigation\">";
					$navarray = array();
					$currentpost = get_post($postID);
					while (true){
						//iteratively get the post's parent until we reach the top of the hierarchy
						$post_parent = $currentpost->post_parent; 
						if ($post_parent!=0){	//if found a parent
							$navarray[] = $post_parent;
							$currentpost = get_post($post_parent);
							continue; //loop round again
						}
						break; //we're done with the parents
					};
			
					$navarray = array_reverse($navarray);
					$ancestorNav = count($navarray) + 1;
					//is the current page at the end of the branch?
					$currentpost = get_post($mainid);
						
					if (postHasChildren($mainid)){
						//echo "has children";
						$menuid = $mainid;
						$navarray[] = $mainid;	//set current page in the nav array
						$navarray[] = -1;	//set marker for children styling
					} else {
						//echo "end of the branch";
						$menuid = $currentpost->post_parent;
						$navarray[] = -1;	//set marker in array for subsequent children styling
					}
					
					if($menuid != 0){
						$allNavParams = array(
							"post_type" => $postType,
							"posts_per_page" => -1,
							"orderby" => "menu_order title",
							"order" => "ASC",
							"post_parent" => $menuid
						);
					}
			
					$allnavItems = get_posts($allNavParams);
			
					$subnavString = "";
						
					foreach ($allnavItems as $navItem){ //fill the nav array with the child pages
						$navarray[] = $navItem->ID;
					}	 
			
					$ancestorCount = 0;
					foreach($before as $beforeItem){
						$subnavString .= "<li class='level-".$ancestorCount."'><a href='".get_permalink($beforeItem)."'>".get_the_title($beforeItem)."</a></li>"; //top level menu item
						$ancestorCount++;
					}
			
					$subs=false;
					if($postType == "people" || count($navarray) == 1){
						$subnavString .= "<li class='current_page_item'><a href=\"".get_permalink($postID)."\">".get_the_title($postID)."</a></li>";
						if ($relatedposts) {
							$subnavString .= $relatedposts;
							}
					}else{
						foreach ($navarray as $nav){ //loop through nav array outputting menu options as appropriate (parent, current or child)
							if ($nav == -1) {
								$subs=true;
								continue;
							}
							$currentpost = get_post($nav);
							if ($nav == $mainid){
								if(postHasChildren($mainid)){
									$subnavString .= "<li class='current_page_item level-".$ancestorNav."'>";
								}else{
									$subnavString .= "<li class='current_page_item'>"; //current page
								}
							} elseif ($subs) {
								$subnavString .= "<li class='page-item'>"; //child page
							} else {
								$subnavString .= "<li class='page_item level-".$ancestorCount."'>"; //parent page
								$ancestorCount++;
							}
							$subnavString .=  "<a href='".$currentpost->guid."'>".$currentpost->post_title."</a></li>";
						}
						if ($relatedposts) {
							$subnavString .= $relatedposts;
						}
					}
					$postMenu .= $subnavString;
					$postMenu .= "</ul></li>";
				}else{
					$postMenu .= "<li id=\"menu-item-".$menu_item->id."\" class=\"".$menu_item->classes[0]." visible-phone\"><a href=\"".$menu_item->url."\">".$menu_item->title."</a></li>";
				}
			}
			$postMenu .= "</ul>";
			$postMenu .= "</div>";
			echo $postMenu;
			
			
			
			
			
	}else{
		//Iterate through the top level items - Primary Nav with a walker
		if(!(pageHasChildren($post->ID)) && $post->post_parent == 0 && (!is_front_page() && !is_404() && !is_search() )){
			$navParams = array(
				'theme_location' => 'primary',
				'menu_id' => 'nav'
				);
			wp_nav_menu($navParams);
		}else{
		
			$navParams = array(
				'theme_location' => 'primary',
				'menu_id' => 'nav',
				'walker' => new mobileNav_walker($post)
				);
			wp_nav_menu($navParams);
		}
	}
	
	
}

function pageHasChildren($id="") {

	global $post;
	
	if ($id) {
		$children = get_pages('child_of='.$id);	
	} else {
		$children = get_pages('child_of='.$post->ID);
	}

	if (count($children) != 0) {
		return true;
	} else {
		return false;
	}
}

function postHasChildren($id="") {

	global $post;
	
	if ($id) {
		$children = get_posts('post_type=service&post_parent='.$id);	
	} else {
		$children = get_posts('post_type=service&post_parent='.$post->ID);
	}

	if (count($children) != 0) {
		return true;
	} else {
		return false;
	}
}

// check jQuery is available

function enqueueThemeScripts() {
	 wp_enqueue_script( 'jquery' );
	 wp_enqueue_script( 'jquery-ui' );
	
	 wp_register_script( 'jquery-touchdown', get_stylesheet_directory_uri() . "/js/jquery.touchdown.js");
	 wp_enqueue_script( 'jquery-touchdown' );

	 wp_register_script( 'jquery-collapse', get_stylesheet_directory_uri() . "/js/jquery.collapse.js");
	 wp_enqueue_script( 'jquery-collapse' );
	 
	 wp_register_script( 'ht-scripts', get_stylesheet_directory_uri() . "/js/ht-scripts.js");
	 wp_enqueue_script( 'ht-scripts' );

	 wp_enqueue_script( 'thickbox' ); // in case we want to do popup layer surveys or alerts... 
}
add_action('wp_enqueue_scripts','enqueueThemeScripts');

// listing page thumbnail sizes, e.g. home page

add_image_size( "clinicianthumb", "72", "72", true );
add_image_size( "newsheadline", "536", "356", true );
add_image_size( "newssubhead", "254", "169", true );
add_image_size( "promo", "348", "240", true );



function sghpress_custom_title( $output ) {
	if (!is_admin()) {
//		$newtitle = str_replace("[", "(", $output);
//		$newtitle = str_replace("]", ")", $newtitle);		
//		return $newtitle;
		return trim(preg_replace('/\[.*\]/i','',$output));
	} else {
		return $output;
	}
}
add_filter( 'the_title', 'sghpress_custom_title' );

// Custom nav walker to make it awesome on mobile while keeping it awesome on desktop
class mobileNav_walker extends Walker_Nav_Menu{
	var $currentPost;
	
	function __construct($currentPost){
		$this->currentPostID = $currentPost->ID;
		$this->currentPostAncestors = array_reverse($currentPost->ancestors);
		$this->currentPostParent = end($this->currentPostAncestors);
		$this->sectionID = (end($currentPost->ancestors) ? end($currentPost->ancestors) : $this->currentPostID);
		$this->postType = $currentPost->post_type;
	}

	function start_el(&$output, $item, $depth, $args){
		global $wp_query;
		
		$currentSection = false;
		
		if($item->object_id == $this->currentPostID || $item->object_id == $this->sectionID && $this->sectionID != 0){
			$currentSection = true;
		}
		
		
		$class_names = $value = '';  
  
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;  
        
        if($currentSection){
	        array_push($classes, "current_section");
        }else{
	        array_push($classes, "visible-phone");
        }
  
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );  
        $class_names = ' class="'. esc_attr( $class_names ) . '"';
		
		$output .= '<li'.$class_names.'>';
		
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';  
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';  
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';  
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';  
        $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
		
		$item_output = $args->before;  
        $item_output .= '<a'. $attributes .'>'; 
        $link_title = $item->title;
        $link_title = str_replace("<br>", " ", $link_title);
        $item_output .= $args->link_before .$link_title;  
        $item_output .= $description.$args->link_after;  
        $item_output .= '</a>';  
        $item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
		if($currentSection){
			
			$output .= '<ul class="children" role="navigation">';
			
				$ancestors = 0;
				//See if the page has ancestors
				if(!empty($this->currentPostAncestors)){
					foreach($this->currentPostAncestors as $ancestor){
						if($ancestor != $this->sectionID && $ancestor != $this->currentPostID){
							$output .= '<li class="ancestor level-'.$ancestors.'"><a href="'.get_permalink($ancestor).'">'.get_the_title($ancestor).'</a></li>';
							$ancestors++;
						}
					}
				}
				//See if the page is a section page itself
				if($this->currentPostID == $this->sectionID){
					$subpages = wp_list_pages("echo=0&title_li=&depth=1&child_of=".$this->currentPostID);
				}else{
					//Figure out the level of the page	
					$currentLevel = ((count($this->currentPostAncestors)-1) != 0 ? " level-".(count($this->currentPostAncestors)-1) : "");
					if(pageHasChildren($this->currentPostID)){
						$currentLevel = " level-" . $ancestors;
						$output .= '<li class="current_page_item'.$currentLevel.'"><a href="'.get_permalink($this->currentPostID).'">'.get_the_title($this->currentPostID).'</a></li>';
					}
					//If the page has kids then we want to show them else show the page in it's parent's list of kids
					if(pageHasChildren($this->currentPostID)){
						$subpages = wp_list_pages("echo=0&title_li=&depth=1&child_of=".$this->currentPostID);
					}else{
						$subpages = wp_list_pages("echo=0&title_li=&depth=1&child_of=".$this->currentPostParent);
					}
				}
				if (strlen($subpages)>0 && !is_search() ) {
					$output .= "{$subpages}";
				}
				if($this->postType == "attachment"){
					$output .= "<li class=\"current_page_item\"><a href=\"#\">".get_the_title()."</a></li>";
				}
			$output .= '</ul>';
		}
	}
}


// support Posts to Posts plugin linking of Pages/Posts to other Pages/Posts

function ht_connection_types() {
	// Make sure the Posts 2 Posts plugin is active.
	if ( !function_exists( 'p2p_register_connection_type' ) )
		return;

	p2p_register_connection_type( array(
		'name' => 'services_to_pages',
		'from' => 'service',
		'to' => 'page',
		'reciprocal' => true
	));
	p2p_register_connection_type( array(
		'name' => 'services_to_posts',
		'from' => 'service',
		'to' => 'service',
		'reciprocal' => true
	));

}
add_action( 'wp_loaded', 'ht_connection_types' );

function wpse28145_add_custom_types( $query ) {
    if( is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {

        // this gets all post types:
        $post_types = get_post_types();

        // alternately, you can add just specific post types using this line instead of the above:
        // $post_types = array( 'post', 'your_custom_type' );


        $query->set( 'post_type', $post_types );
        return $query;
    }
}
add_filter( 'pre_get_posts', 'wpse28145_add_custom_types' );

function get_post_thumbnail_caption() {
	if ( $thumb = get_post_thumbnail_id() )
		return get_post( $thumb )->post_excerpt;
}

//ensures authors are visible for custom post types
function add_pagination_to_author_page_query_string($query_string){
    if (isset($query_string['author_name'])) $query_string['post_type'] = array('newsitem');
    return $query_string;
}
add_filter('request', 'add_pagination_to_author_page_query_string');



function pippin_excerpt_by_id($post, $length = 10, $tags = '<a><em><strong>', $extra = ' . . .') {
 
	if(is_int($post)) {
		// get the post object of the passed ID
		$post = get_post($post);
	} elseif(!is_object($post)) {
		return false;
	}
 
	if(has_excerpt($post->ID)) {
		$the_excerpt = $post->post_excerpt;
		return apply_filters('the_content', $the_excerpt);
	} else {
		$the_excerpt = $post->post_content;
	}
 
	$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
	$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
	$excerpt_waste = array_pop($the_excerpt);
	$the_excerpt = implode($the_excerpt);
	$the_excerpt .= $extra;
 
	return apply_filters('the_content', $the_excerpt);
}

add_filter('query_vars', 'advanced_search_qvs');
function advanced_search_qvs($qv){
	$qv[] = 'type';
	//$qv[] = 'cat';
	return $qv;
}

add_action('pre_get_posts', 'type_to_array');

function type_to_array($query){
	if(!is_admin() && $query->is_main_query()){
		if($query->is_search){
			if(isset($_GET['type'])){
				$newType = array();
				foreach($_GET['type'] as $type){
					$newType[]= $type;
				}
				$query->set('post_type', $newType);
			}
			
			/*if(isset($_GET['cat'])){
				$query->set('category_name', $_GET['cat']);
			}*/
		}
	}
}

// remove comment feeds and next & prev links etc
remove_action('wp_head', 'feed_links_extra', 3 );
remove_action('wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Custom nav walker to make it awesome on mobile while keeping it awesome on desktop
class accessibleNav_walker extends Walker_Nav_Menu{

	function start_el(&$output, $item, $depth, $args){
		
		$class_names = $value = '';  
  
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;  
  
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );  
        $class_names = ' class="'. esc_attr( $class_names ) . '"';
		
		$output .= '<li'.$class_names.'>';
		
		$link_title = $item->title;
        $link_title = str_replace("<br>", " ", $link_title);
		
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';  
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';  
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';  
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
        $attributes .= 'role="link" aria-label="'.$link_title.'"'; 
        $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
		
		$item_output = $args->before;  
        $item_output .= '<a'. $attributes .'>'; 
        
        $item_output .= $args->link_before .$link_title;  
        $item_output .= $description.$args->link_after;  
        $item_output .= '</a>';  
        $item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

function myfeed_request($qv) {
	if (isset($qv['feed'])) {
		$qv['post_type'] = array('newsitem','service','event','course','ward','page');
		if ($_GET['post_type']=='newsitem'){
			$qv['post_type'] = 'newsitem';
		}
		if ($_GET['post_type']=='service'){
			$qv['post_type'] = 'service';
		}
		if ($_GET['post_type']=='event'){
			$qv['post_type'] = 'event';
		}
		if ($_GET['post_type']=='course'){
			$qv['post_type'] = 'course';
		}
		if ($_GET['post_type']=='ward'){
			$qv['post_type'] = 'ward';
		}
		
		}
	return $qv;
}
add_filter('request', 'myfeed_request');
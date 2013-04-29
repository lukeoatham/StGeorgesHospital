<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 * We filter the output of wp_title() a bit -- see
		 * twentyten_filter_wp_title() in functions.php.
		 */
		wp_title( '|', true, 'right' );
	
		?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- 1140px Grid styles for IE -->
	<!--[if lte IE 9]><link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/ie.css" type="text/css" media="screen" /><![endif]-->
	
	<!-- The 1140px Grid - http://cssgrid.net/ -->
	<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/1140.css" type="text/css" media="screen" />

	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<?php include(get_stylesheet_directory() . "/theme-styles-css.php"); ?>

	<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_stylesheet_directory_uri(); ?>/print.css" />

	<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/ht-scripts.js"></script>

	<!-- IE7 adaptations -->
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/ie7/IE8.js"></script>
			
		<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
	
		wp_head();

		global $biotpress_options;
		$biotpress_options = get_option('biotpress_theme_options');
		
		?>
		
		<style type='text/css'>
			<?php
				echo $biotpress_options['customcss'];
			?>;
		</style>

</head>

<body <?php body_class(); ?>>

<!--[if IE 6]> 
<div class='ie6'>
<![endif]--> 
<!--[if IE 7]> 
<div class='ie7'>
<![endif]--> 
<!--[if IE 8]> 
<div class='ie8'>
<![endif]--> 
<!--[if IE 9]> 
<div class='ie9'>
<![endif]--> 

				<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<a href="#maincontent" class='hiddentext' title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a>


					<div class="container">


				<div id='header' class="row">
						

						<div id='masthead' class="eightcol">
							
							<div id='mainlogo'>
<h1 class='orgname'><a href='/'><?php echo get_bloginfo('name');?></a></h1>
							</div>

							<div id="primarynav" role="navigation" class="gradient">
								<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
								<?php wp_nav_menu( array( 'menu_id' => 'primarynavmenu', 'theme_location' => 'primary' ) ); ?>
							</div>

							<script type="text/javascript">dropdown('primarynavmenu', 'hover', 250);</script>


								  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
									<a href="#maincontent" class='hiddentext' accesskey='s' title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a>
		
	
						</div>
						
						<div class="fourcol last">
							<div id='searchblock'>
								<?php get_search_form(true); ?>
							</div>
							<div id="utilities">	
							<ul>
								<?php dynamic_sidebar( 'utilities-widget-area' ); ?>
							</ul>
							</div>
						</div>
						
				</div>
<br>
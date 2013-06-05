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
<!--[if lt IE 7 ]><html class="ie ie6 no-js" lang="en-US"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7 no-js" lang="en-US"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8 no-js" lang="en-US"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html lang="en-US"><!--<![endif]-->
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

	<!-- webfont loading: -->
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,700' rel='stylesheet' type='text/css'>
	
	<!-- 1140px Grid styles for IE -->
	<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/ie.css" type="text/css" media="screen" />
	<![endif]-->
	
	<!-- The 1140px Grid - http://cssgrid.net/ -->
	<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/1140.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?><?php echo "?" . time();?>" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_stylesheet_directory_uri(); ?>/print.css<?php echo "?" . time();?>" />

	<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/ht-scripts.js"></script>

	<!-- [if lte IE 8]>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/ie7/IE8.js"></script>
	<![endif]-->

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
			
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
	?>

</head>

<body <?php body_class($parentpageclass); ?>>

		 <?php // include(get_stylesheet_directory() . "/sidebar-cookiebar.php"); ?>

			<div class="container">								

				<div id='header' class="row">
					

						<div id='masthead' class="eightcol">
							
<!--							<p id='mainlogo'>
								<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
									<img src="<?php echo get_stylesheet_directory_uri();?>/images/wordpress.png" alt="<?php echo get_bloginfo('name');?>"  />
								</a>
						</p>
-->								
							<p id='strapline'>
								<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
									<?php echo get_bloginfo( 'name' ); ?>
								</a>
							</p>
						</div>
						
						<div id='searchblock' class="fourcol last">
							
								<?php get_search_form(true); ?>
														<div id="utilities">	
							<ul>
								<?php dynamic_sidebar( 'utilities-widget-area' ); ?>
							</ul>
						</div>
						
					</div>
						
						<div id='navigation' class="row">
							<div class="twelvecol last">
								<div class='menu-header'>
								
								  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
									<a href="#maincontent" class='hiddentext' accesskey='s' title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a>
		
								<div id="primarynav" role="navigation" class="touchdown-list">
									<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
									<?php 
										wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
								</div>
								</div>						
							</div>
						</div>
				
				</div>
				
				<div class="row">
					<div class="twelvecol last">
							<div class='breadcrumbs'>
							<?php if(function_exists('bcn_display') && !is_front_page()) {
								bcn_display();
							}?>
							</div>
							
    				</div>
				</div>
				




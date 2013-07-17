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

	<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_stylesheet_directory_uri(); ?>/print.css" />
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="/wp-content/themes/sghpress/js/bootstrap.js"></script>

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
<input type="checkbox" name="mobileNav" id="mobileNav" checked />
			<div class="container-fluid" id="mobMove">
			<div class="row-fluid">
				<ul class="topLinks">
					<li><a href="#">Telephone: 020 8275 4521</a></li>
					<li><a href="#">This is a link</a></li>
					<li><a href="#">This is also a link</a></li>
				</ul>
			</div>								
			<div class="row-fluid">
				<div id='header' class="row">
					<div id='masthead'>
						
						<p id='mainlogo'>
							<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="St George's Healthcare NHS Trust">
							</a>
						</p>
						
						<div id='searchblock'>
									<?php get_search_form(true); ?>
									<!-- label to control checbox -->
									<label id="mobileMenuButton" for="mobileNav" onclick>
										<h6>Menu</h6>
									</label>
									<!-- end label to control checkbox -->
						</div>							
					</div>
						
					<div id='navigation' class="row">
						<div class="span12">
							<div class='menu-header'>
								
								  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
									<a href="#maincontent" class='hiddentext' accesskey='s' title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a>
		
								<div id="primarynav" role="navigation" class="touchdown-list eightcol">
									<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
									<?php 
										wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
								</div>
							</div>						
						</div>
					</div>
				
				</div>
				<!-- label to display the content when bringing in side menu -->
					<label id="contentOverlay" for="mobileNav"></label>
				<!-- end label for side menu -->
				
				<!-- start navigation for sidebar -->
				<div class="sideNav">
				<ul>
				<?php
				
				global $post;
				
				
					//Renders the left nav of pages with left navs
				if($post->ID == $item->object_id || $post->post_parent == $item->object_id || in_array($item->object_id, $post->ancestors)){
				//if ( (pageHasChildren() || pageHasChildren($post->post_parent)) && (!is_front_page() && !is_404() && !is_search() ) ){
					if(!is_front_page() && !is_404() && !is_search()){
						echo('<li class="subSideNav">');
						renderLeftNav();
						echo('</li>');
					}
				}
				?>
				</ul>
				</div>
				
				<!-- end navigation for sidebar -->
			</div>
			<?php if( function_exists('bcn_display') && (!is_front_page() && !is_home() ) ) : ?>
				<div class="row-fluid">
					<div class="span12">
							<div class='breadcrumb'>
								<?php bcn_display(); ?>
							</div>
    				</div>
				</div>
			<?php endif; ?>
			
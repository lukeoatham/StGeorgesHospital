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
session_start();
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

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_stylesheet_directory_uri(); ?>/print.css" />
    <script src="//code.jquery.com/jquery.js" type="text/javascript"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/modernizr.js" type="text/javascript"></script>
    
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12302224-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>  
    

    
		<?php
		
		
		
		
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */


		if (is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>

</head>
<body <?php body_class($parentpageclass); 

	if(!is_single()){
		// If the page isn't single then we set the body as the start of the page for mobile
		echo 'id="mobhead"';
	}
?> >
	<input type="checkbox" role="checkbox" name="mobileNav" id="mobileNav" <?php
		// This checkbox shows and hides the mobile menu, it uses a cookie to keep things persistant
		if($_COOKIE["sgh_mobile_nav"] && $_COOKIE["sgh_mobile_nav"] != "null"){
			echo "checked=\"checked\"";
			echo "aria-checked=\"true\"";
		}else{
			echo "aria-checked=\"false\"";
		}
	?> />
	
	<div class="container-fluid" id="mobMove">
		<div class="row-fluid quick-links">
			<?php dynamic_sidebar( 'utilities-widget-area' ); ?>
		</div>								
		<div class="row-fluid header" role="banner">
			<div id='header' class="row">
				<div id='masthead'>
					<p id='mainlogo'>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" role="link" aria-labelledby="mainLogoLabel">
							<script type="text/javascript">
								var imageURL = "<?php echo get_stylesheet_directory_uri(); ?>/images/logo";
								if (Modernizr.svg){
									jQuery("#mainlogo a").html("<img src=\"" + imageURL + ".svg\" alt=\"St George's Healthcare NHS Trust\" role=\"presentation\">");
								}else{
									jQuery("#mainlogo a").html("<img src=\"" + imageURL + ".gif\" alt=\"St George's Healthcare NHS Trust\" role=\"presentation\">");
								}
							</script>
							<noscript><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.gif" alt="St George's Healthcare NHS Trust"></noscript>
							</a>
							<span class="hiddentext" id="mainLogoLabel">Go to Homepage</span>
						</p>
						
						<div id='searchblock'>
									<?php get_search_form(true); ?>
									<!-- label to control checbox -->
									<label id="mobileMenuButton" for="mobileNav" tabindex="0" role="button" <?php
		// This checkbox shows and hides the mobile menu, it uses a cookie to keep things persistant
		if($_COOKIE["sgh_mobile_nav"] && $_COOKIE["sgh_mobile_nav"] != "null"){
			echo "aria-pressed=\"true\"";
		}else{
			echo "aria-pressed=\"false\"";
		}
	?>å
 aria-controls="mobileNav">
										Menu
									</label>
									<!-- end label to control checkbox -->
						</div>							
					</div>
					<div id='navigation' class="row">
						<div class="span12">
							<div class='menu-header'>
								  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
									<a href="#content" class='hiddentext' accesskey='s' title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a>
								<div id="primarynav" class="eightcol">
									<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
									<?php 
										wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'items_wrap' => '<ul role="navigation" tabindex="2" aria-label="Top level navigation">%3$s</ul>', 'walker' => new accessibleNav_walker() ) ); ?>
								</div>
							</div>						
						</div>
					</div>
				
				</div>
				<!-- label to display the content when bringing in side menu -->
					<label id="contentOverlay" for="mobileNav" tabindex="0" aria-hidden="false" role="button" <?php
		// This checkbox shows and hides the mobile menu, it uses a cookie to keep things persistant
		if($_COOKIE["sgh_mobile_nav"] && $_COOKIE["sgh_mobile_nav"] != "null"){
			echo "aria-pressed=\"true\"";
		}else{
			echo "aria-pressed=\"false\"";
		}
	?> aria-controls="mobileNav"></label>
				<!-- end label for side menu -->
				
			</div>
			
			<?php if ( is_active_sidebar( 'emergency_message' ) ) : ?>
					<?php 
					//set session variable to hide emergency bar if manually closed
					if ( $_GET['msgclose'] == true) : 
						$_SESSION['emergencymsg']='closed';
					endif; 

					if (!$_SESSION['emergencymsg']) : 
					?>
						<div class="alert alert-block">
							<button class="pull-right"><a href="?msgclose=true">&times;</a></button>
							<?php dynamic_sidebar( 'emergency_message' ); ?>
						</div>
				<?php endif; ?>
			<?php endif; ?>
		
			<?php if( function_exists('bcn_display') && (!is_front_page() && !is_home() ) ) : ?>
				<div class="row-fluid breadcrumbs" aria-hidden="true">
					<div class="span12">
							<div class='breadcrumb'>
								<?php bcn_display(); ?>
							</div>
    				</div>
				</div>
			<?php endif; ?>
			
<?php

/*
Plugin Name: HT Site listing
Plugin URI: http://www.helpfultechnology.com
Description: Create simple listings of sites
Author: Luke Oatham
Version: 0.1
Author URI: http://www.helpfultechnology.com
*/

function ht_sites_shortcode($atts,$content){
    //get any attributes that may have been passed; override defaults
    $opts=shortcode_atts( array(
        'type' => '',
        ), $atts );

	$sitetype = ($opts['type']) ;
	$output .= "<ul class='nav'>";

	$sites = get_terms('sites',array("hide_empty"=>false)); 

	foreach ($sites as $s){
		global $wpdb;
		$q = "select option_value from wp_options where option_name = 'sites_".$s->term_taxonomy_id."_site_type'";
		$stype = $wpdb->get_results($q, "ARRAY_A" );
		foreach ($stype as $scomp){
		$comp = $scomp['option_value'];
		if ($sitetype==$comp){ 
			$output .= "<li><a href='/contact-and-find-us/find-us/sites/?site=".$s->slug."'>".$s->name."</a></li>";
		} 
		}
		if ($sitetype==''){	
			$output .= "<li><a href='/contact-and-find-us/find-us/sites/?site=".$s->slug."'>".$s->name."</a></li>";
		}

	}
	
	$output .= "</ul>";
	$html = "<div class='htpeoplepageblock'>" . $output . "</div>";

    return $html;
}

add_shortcode("sites", "ht_sites_shortcode");



?>
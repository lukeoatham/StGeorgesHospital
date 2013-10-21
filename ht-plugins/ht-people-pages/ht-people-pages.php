<?php

/*
Plugin Name: HT People Pages
Plugin URI: http://www.helpfultechnology.com
Description: Create simple listings of people based on a category
Author: Luke Oatham
Version: 0.1
Author URI: http://www.helpfultechnology.com
*/

function hp_peoplepages_shortcode($atts,$content){
    //get any attributes that may have been passed; override defaults
    $opts=shortcode_atts( array(
        'team' => '',
        ), $atts );

	global $wp_query;
	$team = ($opts['team']) ;
	
	$people = get_posts(
		array(
		"post_type" => "people",
		"posts_per_page" => -1,
		"tax_query" => array(array(
			"taxonomy" => "people-types",
			"terms" => $team,
			"field" => "slug"
			)
			),
			"meta_query"=>array(array(
			"key"=>"show",
			"value"=>'1',
			"compare"=>"="
			))			
	));
	$taxname =  get_term_by( "slug", $team, "people-types" ) ;
	$output .= "<h2>".$taxname->name."</h2>";
	$output .= "<ul>";
	foreach((array)$people as $c) {
		$jt = get_post_meta($c->ID,'job_title');
		$output .= "<li><a href='".get_permalink($c->ID)."'>".get_the_title($c->ID)." - ".$jt[0]."</a></li>";
	}
	$output .= "</ul>";
	$html = "<div class='htpeoplepageblock'>" . $output . "</div>";

    return $html;
}

add_shortcode("peoplepages", "hp_peoplepages_shortcode");

?>
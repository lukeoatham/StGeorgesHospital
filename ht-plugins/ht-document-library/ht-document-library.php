<?php

/*
Plugin Name: HT Document Library
Plugin URI: http://www.helpfultechnology.com
Description: Create simple listings of document categories
Author: Luke Oatham
Version: 0.1
Author URI: http://www.helpfultechnology.com
*/

function ht_documentlibrary_shortcode($atts,$content){
    //get any attributes that may have been passed; override defaults
    $opts=shortcode_atts( array(
        'cat' => '',
        'sort'=> '',
        'count'=> '',        
        ), $atts );

	global $wp_query;
	$doccat = ($opts['cat']) ;
	$docsort = ($opts['sort']) ;
	$doccount = ($opts['count']) ;

	if ( $docsort=='' ) { $docsort='ASC'; }
	if ( $doccount=='' ) { $doccount=-1; }

	$docs = get_posts(
		array(
		"post_type" => "attachment",
		"posts_per_page" => $doccount,
		"orderby"=>"title",
		"order"=>$docsort,
		"tax_query" => array(array(
			"taxonomy" => "category",
			"terms" => $doccat,
			"field" => "slug"
			)
			),
	));
	$taxname =  get_term_by( "slug", $doccat, "category" ) ;
	$output .= "<ul>";
	foreach((array)$docs as $c) {
		$output .= "<li><a href='".get_permalink($c->ID)."'>".get_the_title($c->ID)."</a></li>";
	}
	$output .= "</ul>";
	$html = "<div class='htpeoplepageblock'>" . $output . "</div>";

    return $html;
}

add_shortcode("documentlibrary", "ht_documentlibrary_shortcode");



?>
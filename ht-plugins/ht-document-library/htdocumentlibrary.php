<?php
/*
Plugin Name: htdocumentlibrary
Plugin URI: http://wphardcore.com
Description: A simple user interface for Gallery shortcode
Version: 0.1
Author: Gary Cao
Author URI: http://garyc40.com
*/

if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );

class htdocumentlibrary
{
	function __construct() {
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}
	
	function action_admin_init() {
		// only hook up these filters if we're in the admin panel, and the current user has permission
		// to edit posts and pages
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
		}
	}
	
	function filter_mce_button( $buttons ) {
		// add a separation before our button, here our button's id is "htdocumentlibrary_button"
		array_push( $buttons, '|', 'htdocumentlibrary_button' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['htdocumentlibrary'] = plugin_dir_url( __FILE__ ) . 'htdocumentlibrary_plugin.js';
		return $plugins;
	}
}

$htdocumentlibrary = new htdocumentlibrary();
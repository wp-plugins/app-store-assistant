<?php 
/*
Plugin Name: App Store Assistant
Version: 5.0
Plugin URI: http://TheiPhoneAppsList.com/
Description: Adds shortcodes to display ATOM feed or individual item information from Apple's App Stores or iTunes.
Author: Scott Immerman
Author URI: http://SEALsystems.net/
*/

/**
Copyright 2013 Scott Immerman

*/
define( 'ASA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ASA_PLUGIN_INCLUDES_PATH', plugin_dir_path( __FILE__ )."includes/" );
define( 'ASA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ASA_MAIN_FILE', plugin_dir_path( __FILE__ )."app-store-assistant.php" );
// --------------------------------------------------------------------------------------
// ------------------ FUNCTIONS ---------------------------------------------------------
// --------------------------------------------------------------------------------------
require_once(ASA_PLUGIN_PATH.'/includes/app-store-functions.php');
require_once(ASA_PLUGIN_PATH.'/includes/simplepie.inc');
require_once(ASA_PLUGIN_PATH.'/includes/app-store-admin_functions.php');

// ------------------------------------------------------------------------
// REQUIRE MINIMUM VERSION OF WORDPRESS:                                               
// ------------------------------------------------------------------------
add_action( 'admin_init', 'requires_wordpress_version' );
// ------------------------------------------------------------------------
// REGISTER HOOKS & CALLBACK FUNCTIONS:
// ------------------------------------------------------------------------
add_action('wp_print_styles', 'appStore_page_add_stylesheet');
add_action( 'wp_head', 'appStore_css_hook' );

register_activation_hook(__FILE__, 'appStore_add_defaults');
register_uninstall_hook(__FILE__, 'appStore_delete_plugin_options');
add_action('admin_init', 'appStore_init' );
add_action('admin_menu', 'appStore_add_options_page');
add_filter('plugin_action_links', 'appStore_plugin_action_links', 10, 2 );
add_action('admin_print_styles', 'appStore_admin_page_add_stylesheet');
add_action('admin_enqueue_scripts', 'appStore_load_js_files');

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'ce_excerpt_filter');
add_filter('get_the_excerpt','do_shortcode');

// ------------------------------------------------------------------------
// REGISTER SHORTCODES, ADD EDITOR BUTTONS
// ------------------------------------------------------------------------
add_shortcode("asaf_atomfeed", "appStore_atomfeed_handler");
add_shortcode("ios_app_list", "appStore_list_handler");
add_shortcode('ios_app', 'appStore_app_handler');
add_shortcode('ios_app_link', 'appStore_app_link_handler');
add_shortcode('itunes_store', 'iTunesStore_handler');
add_shortcode('ibooks_store', 'iBooksStore_handler');
add_shortcode('mac_app', 'appStore_app_handler');
add_shortcode('mac_app_link', 'appStore_app_link_handler');
add_shortcode('appStore_IDsearch', 'idsearch_app_handler');
add_action('init', 'add_asa_mce_button');
add_filter( 'tiny_mce_version', 'appStore_refresh_mce');
// ------------------------------------------------------------------------
// Setup for Localization
// ------------------------------------------------------------------------
add_action('init', 'asa_load_translation_file');


// ------------------------------------------------------------------------
// DEFINE Apple App Store URL
// ------------------------------------------------------------------------
define('ASA_APPSTORE_URL', 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsLookup?country='.appStore_setting('store_country').'&id=');


?>
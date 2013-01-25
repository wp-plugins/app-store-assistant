<?php 
/*
Plugin Name: App Store Assistant
Version: 5.6.2
Text Domain: appStoreAssistant
Plugin URI: http://TheiPhoneAppsList.com/
Description: Adds shortcodes to display ATOM feed or individual item information from Apple's App Stores or iTunes. Now works with Amazon.com Affiliate Program.
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
require_once(ASA_PLUGIN_PATH.'/includes/app-store-amazon_functions.php');
require_once(ASA_PLUGIN_PATH.'/includes/sha256.inc.php');

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
add_action('admin_enqueue_scripts', 'appStore_load_admin_js_files');
add_action('wp_enqueue_scripts', 'appStore_load_js_files');

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'appStore_excerpt_filter');
add_filter('get_the_excerpt','do_shortcode');

//add_filter( 'post_thumbnail_html', 'appStore_post_thumbnail_html', 10, 3 );
//add_filter( 'post_thumbnail_html', 'appStore_post_thumbnail_html');
//add_filter( 'get_the_post_thumbnail', 'appStore_get_the_post_thumbnail', 10, 3 );


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
add_shortcode('amazon_item', 'appStore_amazon_handler');
add_action('init', 'add_asa_mce_button');
add_filter( 'tiny_mce_version', 'appStore_refresh_mce');
// ------------------------------------------------------------------------
// Setup for Localization
// ------------------------------------------------------------------------
add_action('init', 'asa_load_translation_file');


// ------------------------------------------------------------------------
// DEFINE Apple App Store URL & CACHE directory
// ------------------------------------------------------------------------
define('ASA_APPSTORE_URL', 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsLookup?country='.appStore_setting('store_country').'&id=');
$upload_dir = wp_upload_dir();
define('CACHE_DIRECTORY',$upload_dir['basedir'] . '/appstoreassistant_cache/');
define('CACHE_DIRECTORY_URL',$upload_dir['baseurl'] . '/appstoreassistant_cache/');

// ------------------------------------------------------------------------
// Setup Widget
// ------------------------------------------------------------------------



class ASA_Widget1 extends WP_Widget {
	function ASA_Widget1() {
		parent::WP_Widget( false, $name = 'ASA Top 5 iOS' );
	}

	function widget( $args, $instance ) {
		extract( $args );
		//Widget Title
		$title = apply_filters( 'widget_title', $instance['title'] );
		if(!$title) $title = __('Top 5 iOS Apps');
		echo $before_widget;
		if ($title) echo $before_title . $title . $after_title;
		
		//ATOM Feed URL
		$atomurl = apply_filters( 'widget_atomurl', $instance['atomurl'] );
		if(empty($atomurl)) {
			_e( 'Missing atomurl in tag. Replace <strong>id</strong> with <strong>atomurl</strong>.',appStoreAssistant);
			return;
		}
		$last = $atomurl[strlen($atomurl)-1];
		if($last != "/") $AddSlash = "/";
		$RSS_Feed = $atomurl.$AddSlash."xml";
		$appStore_option = "appStore_rssfeed_".hash('md2', $RSS_Feed);
		$feedData = get_option($appStore_option);
		if (!empty($feedData)) {
			$appIDs = $feedData;
		} else {
			$appIDs = appStore_getIDs_from_feed($RSS_Feed);
			update_option($appStore_option, $appIDs);
		}		
		array_splice($appIDs, 5);
	
		echo '<div class="asaWidget1"><ul>';
		foreach($appIDs as $appID) {	
			if($appID == "" || !is_numeric($appID)) return;
			$app = appStore_get_data($appID);
			$appURL = getAffiliateURL($app->trackViewUrl);
	//echo "------$asin-----[<pre>".print_r($app,true)."</pre>]-------------";

			
			if($app) {
				echo "<li>";
				echo '<a href="'.$appURL.'">';
				echo '<img src="'.$app->artworkUrl60.'" alt="'.$app->title.'" align="left" width="40"/>';
				echo '</a>';
				echo '<h4>'.$app->trackName.'</h4>';
				echo "<p>";
				echo '<a href="'.$appURL.'">';
				echo $app->formattedPrice;
				echo '</a>';
				echo "</p>";
				echo "</li>";

			/*
				if(stristr($mode, 'itunes')) {
					echo iTunesStore_page_output($app,$more_info_text,"external",$code);
				} else {
					echo appStore_page_output($app,$more_info_text,"external",$code);
				}
			*/
			} else {
				echo "No valid data for app id";
				//wp_die('No valid data for app id: ' . $id);
			}
		}
		echo "</ul></div>";

		echo $after_widget;
	}

  function update( $new_instance, $old_instance ) {
    return $new_instance;
  }

  function form( $instance ) {
    $title = esc_attr( $instance['title'] );
    $atomurl = esc_attr( $instance['atomurl'] );
    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
      </label>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'atomurl' ); ?>"><?php _e( 'ATOM Feed:' ); ?>
      <input class="widefat" id="<?php echo $this->get_field_id( 'atomurl' ); ?>" name="<?php echo $this->get_field_name( 'atomurl' ); ?>" type="text" value="<?php echo $atomurl; ?>" />
      </label>
    </p>
    <?php
  }
}

add_action( 'widgets_init', 'ASA_Widget1Init' );
function ASA_Widget1Init() {
  register_widget( 'ASA_Widget1' );
}

?>
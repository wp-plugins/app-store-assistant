<?php 
/*
Plugin Name: App Store Assistant
Version: 2.5
Plugin URI: http://SEALsystems.net/
Description: Adds shortcodes to display ATOM feed or individual app information from Apple's App Store.
Author: Scott Immerman
Author URI: http://SEALsystems.net/
*/

/**
Copyright 2012 Scott Immerman

*/
require_once('simplepie.inc');
define('ASA_APPSTORE_URL', 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsLookup?id=');

include_once("appStore-admin.php");

add_shortcode("ios_asaf_atomfeed", "appStore_atomfeed_handler");
add_shortcode('ios_app', 'appStore_app_handler');
add_shortcode('mac_app', 'appStore_app_handler');
add_action('wp_print_styles', 'appStore_page_add_stylesheet');


function appStore_app_handler( $atts,$content=null, $code="" ) {
	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'more_info_text' => 'continued...'
	), $atts ) );
	
	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;	
	
	//Get the App Data
	$app = appStore_get_data($id);
	if($app)
		return appStore_page_output($app,$more_info_text,"internal",$code);
	else
		wp_die('No valid data for app id: ' . $id);
}



function appStore_atomfeed_handler($atts, $content = null, $code="") {
	
	// Get ATOM URL and more_info_text from shortcode	
	extract( shortcode_atts( array(
		'atomurl' => '',
		'more_info_text' => 'open in The App Store...'
	), $atts ) );
	$last = $atomurl[strlen($atomurl)-1];
	if($last != "/") $AddSlash = "/";
	$RSS_Feed = $atomurl.$AddSlash."xml";
	
	//Check to see if feed is available cached
	$appStore_option = "appStore_rssfeed_".hash('md2', $RSS_Feed);
	$feedData = get_option($appStore_option);

	if (!empty($feedData)) {
		$appIDs = $feedData;
	} else {
		// Get Array of AppIDs for ATOM Feed
		$appIDs = appStore_getIDs_from_feed($RSS_Feed);
		update_option($appStore_option, $appIDs);
	}	

	//Pair down array to number of apps preference
	array_splice($appIDs, appStore_setting('qty_of_apps'));
	
	//Load App data
	foreach($appIDs as $appID) {
		if($appID == "" || !is_numeric($appID)) return;
		$app = appStore_get_data($appID);
		if($app)
			echo appStore_page_output($app,$more_info_text,"external",$code);
		else
			wp_die('No valid data for app id: ' . $id);
		}
	return; 
}


// ------------START OF MAIN FUNCTIONS-----------------
function appStore_page_output($app, $more_info_text,$mode="internal",$platform="ios_app") {

	// Start capturing output so the text in the post comes first.
	ob_start();

	//Check to see if the app is free, or under a dollar
	if($app->price == 0) {
		$TheAppPrice = "Free!";
	} elseif($app->price < 1)  {
		$TheAppPrice = number_format($app->price,2)*100;
		$TheAppPrice .="&cent;";
	} else {
		$TheAppPrice = "$".$app->price."";
	}

	$appURL = appStore_setting('affiliatecode');
	$appURL .= urlencode(urlencode($app->trackViewUrl.'&partnerId='.appStore_setting('affiliatepartnerid')));

	// App Artwork
	$artwork_url = $app->artworkUrl100;
	if(appStore_setting('cache_images_locally') == '1') {
		$upload_dir = wp_upload_dir();
		$artwork_url = $upload_dir['baseurl'] . '/appStore/' . $app->trackId . '/' . basename($app->artworkUrl100);
	}

	//App Category
	$appCategory = $app->genres;
	$appCategoryList = implode(', ', $appCategory);
	
	//App Rating
	if ($app->averageUserRating > 0 && $app->averageUserRating <=10) {
		$appRating = $app->averageUserRating * 20;
	}else {
		$appRating = 0;
	}		
?>
<div class="appStore-wrapper">
	<hr>
	<div id="appStore-icon-container" style="width: <?php echo appStore_setting('icon_size'); ?>px;height: <?php echo appStore_setting('icon_size'); ?>px;">
		<a href="<? echo $appURL; ?>" ><img class="appStore-icon" src="<?php echo $artwork_url; ?>" width="<?php echo appStore_setting('icon_size'); ?>" height="<?php echo appStore_setting('icon_size'); ?>" /></a>
	</div>
	<h1 class="appStore-title"><?php echo $app->trackName;?></h1>
	<span class="appStore-version">Version: <?php echo $app->version; ?></span></br>
	<span class="appStore-categories">
	<?php
		if(count($appCategory) == 1) {
			echo "Category: ";
			echo $appCategory[0];
		} elseif (count($appCategory) > 1) {
			echo "Categories: ";
			echo $appCategoryList;
		}
	?>
	</span>
	<?php if(isset($app->userRatingCount)) { ?>
		<div class="appStore-rating">
			<span class="appStore-rating_bar" title="Rating <?PHP echo $app->averageUserRating; ?> stars">
				<span style="width:<?PHP echo $appRating; ?>%"></span>
			</span> by <?php echo $app->userRatingCount; ?> users.
		</div>
	<?php } ?>
	<div style="clear:left;">&nbsp;</div>

	<div class="appStore-purchase">
		<a type="button" href="<? echo $appURL; ?>" value="" class="appStore-Button BuyButton"><?PHP echo $TheAppPrice; ?> - View in App Store</a></br>
	</div>
<?php
	if (is_single()) {
		echo '	<div class="appStore-description">';
		echo nl2br($app->description);
		echo '</br>';
		echo '<div class="appStore-badge"><a href="'.$appURL.'" >';
		echo '<img src="http://ax.phobos.apple.com.edgesuite.net/images/web/linkmaker/badge_appstore-lrg.gif" alt="App Store" style="border: 0;"/></a></div>';

		echo '</div>';

		// Display iPhone Screenshots

		if(count($app->screenshotUrls) > 0) {
			echo '	<div class="appStore-screenshots-iphone">';
			echo '		<h2>';
			if($platform=="mac_app") echo "Mac ";
			if($platform=="ios_app") echo "iPhone ";
			echo 'Screenshots:</h2>';
			echo '		<ul class="appStore-screenshots">';
			foreach($app->screenshotUrls as $ssurl) {
				$ssurl = str_replace(".png", ".320x480-75.jpg", $ssurl);
	
				if(appStore_setting('cache_images_locally') == '1') {
					$upload_dir = wp_upload_dir();
					$ssurl = $upload_dir['baseurl'] . '/appStore/' . $app->trackId . '/' . basename($ssurl);
				}
	
				echo '<li class="appStore-screenshot"><a href="';
				echo $ssurl . '" alt="Full Size Screenshot" rel="lightbox['.$appIDcode.']"><img src="';
				echo $ssurl . '" width="' . appStore_setting('ss_size') . '" /></a></li>';
			}
			echo '		</ul>';
			echo '</div>';
			echo '	<div style="clear:left;">&nbsp;</div>';
		}


		// Display iPad Screenshots

		if(count($app->ipadScreenshotUrls) > 0) {

			echo '	<div class="appStore-screenshots-iPad">';
			echo '		<h2>iPad Screenshots:</h2>';
			echo '		<ul class="appStore-screenshots">';
			foreach($app->ipadScreenshotUrls as $ssurl) {	
				if(appStore_setting('cache_images_locally') == '1') {
					$upload_dir = wp_upload_dir();
					$ssurl = $upload_dir['baseurl'] . '/appStore/' . $app->trackId . '/' . basename($ssurl);
				}
	
				echo '<li class="appStore-screenshot"><a href="';
				echo $ssurl . '" alt="Full Size Screenshot" rel="lightbox['.$appIDcode.'iPad]"><img src="';
				echo $ssurl . '" width="' . appStore_setting('ss_size') . '" /></a></li>';
			}
			echo '		</ul>';
			echo '</div>';
		}

		echo '	<div style="clear:left;">&nbsp;</div>';
		echo '	<div class="appStore-purchase-center">';
		echo '		<a type="button" href="'.$appURL.'" value="" class="appStore-Button BuyButton">'.$TheAppPrice.' - View in App Store</a></br>';
		echo '	</div>';
		
	} else {
		$smallDescription = shortenDescription($app->description);
		echo '	<div class="appStore-description">';
		echo nl2br($smallDescription);
		if($mode=="internal") {
			echo ' - <a href="'.get_permalink().'" value="">continued&hellip;</a>';
			echo '	<div style="clear:left;">&nbsp;</div>';
			echo '<div class="appStore-FullDescButton"><a type="button" href="'.get_permalink().'" value="" class="appStore-Button FullDescriptionButton">Show Full Description & Screenshots</a></div>';
		} else {
			echo ' - <a href="'.$appURL.'" value="">'.$more_info_text.'</a>';		
		}
		echo '  </div>';
	}		
	echo '	<div style="clear:left;">&nbsp;</div>';
	echo '	</div>';
	//echo '	<div style="clear:left;">&nbsp;</div>';
	$return = ob_get_contents();
	ob_end_clean();	
	return $return;
}

function appStore_get_data( $id ) {
	//Check to see if we have a cached version of the JSON.
	$appStore_options = get_option('appStore_appData_' . $id, '');		
	if($appStore_options == '' || $appStore_options['next_check'] < time()) {	
		$appStore_options_data = appStore_page_get_json($id);
		$appStore_options = array('next_check' => time() + appStore_setting('cache_time_select_box'), 'app_data' => $appStore_options_data);
		update_option('appStore_appData_' . $id, $appStore_options);
		if(appStore_setting('cache_images_locally') == '1') appStore_save_images_locally($appStore_options['app_data']);
	}	
	return $appStore_options['app_data'];
}


function appStore_getIDs_from_feed($atomurl) {
	$last = $atomurl[strlen($atomurl)-1];
	if($last != "/") $AddSlash = "/";
	$urlEnd = 'xml';
	$RSS_Feed = $atomurl.$AddSlash.$urlEnd;
	$feed = new SimplePie();
	$feed->set_feed_url($RSS_Feed);
	$feed->init();
	$feed->handle_content_type();
	foreach ($feed->get_items() as $item):
		$appID =  $item->get_id();
		$pattern = '(id[0-9]+)';
		preg_match($pattern, $appID, $matches, PREG_OFFSET_CAPTURE, 3);
		$appIDs[] = substr($matches[0][0], 2);		
	endforeach;
	return $appIDs;
}

function appStore_page_add_stylesheet() {
	wp_register_style('appStore-styles', plugins_url( 'appStore-styles.css', __FILE__ ));
	wp_enqueue_style( 'appStore-styles');
}

function appStore_page_get_json($id) {
	if(function_exists('file_get_contents') && ini_get('allow_url_fopen'))
		$json_data  = appStore_page_get_json_via_fopen($id);
	else if(function_exists('curl_exec'))
		$json_data = appStore_page_get_json_via_curl($id);
	else
		wp_die('<h1>You must have either file_get_contents() or curl_exec() enabled on your web server. Please contact your hosting provider.</h1>');		
	if($json_data->resultCount == 0) {
		wp_die('<h1>Apple returned no app with that app ID.<br />Please check your app ID.</h1>');
	}
	return $json_data->results[0];
}

function appStore_page_get_json_via_fopen($id) {
	return json_decode(appStore_fopenme(ASA_APPSTORE_URL . $id));
}

function appStore_page_get_json_via_curl($id) {
	return json_decode(appStore_curlme(ASA_APPSTORE_URL . $id));
}

function appStore_fopenme ($url) {
	return @file_get_contents($url);
}

function appStore_curlme ($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    curl_close($ch);
	return $output;
}

function appStore_fopen_or_curl($url) {
	if(function_exists('file_get_contents') && ini_get('allow_url_fopen'))
		return appStore_fopenme($url);
	else if(function_exists('curl_exec'))
		return appStore_curlme($url);
	else
		wp_die('<h1>You must have either file_get_contents() or curl_exec() enabled on your web server. Please contact your hosting provider.</h1>');
}

function appStore_save_images_locally($app) {
	$upload_dir = wp_upload_dir();
	if(!is_writeable($upload_dir['basedir'])) {
		//Uploads dir isn't writeable. bummer.
		appStore_set_setting('cache_images_locally', '0');
		return;
	} else {
		//Loop through screenshots and the app icons and cache everything
		if(!is_dir($upload_dir['basedir'] . '/appStore/' . $app->trackId)) {
			if(!mkdir($upload_dir['basedir'] . '/appStore/' . $app->trackId, 0755, true)) {
				appStore_set_setting('cache_images_locally', '0');
				return;	
			}
		}
		$urls_to_cache = array();
		$urls_to_cache[] = $app->artworkUrl60;
		$urls_to_cache[] = $app->artworkUrl100;
		$urls_to_cache[] = $app->artworkUrl512;
		
		foreach($app->screenshotUrls as $ssurl) {
			$ssurl2 = str_replace(".png", ".320x480-75.jpg", $ssurl);
			$urls_to_cache[] = $ssurl;
			$urls_to_cache[] = $ssurl2;
		}
		if($app->ipadScreenshotUrls) {
			foreach($app->ipadScreenshotUrls as $ssurl) {
				$ssurl2 = str_replace(".png", ".320x480-75.jpg", $ssurl);
				$urls_to_cache[] = $ssurl;
				$urls_to_cache[] = $ssurl2;
			}
		}

		foreach($urls_to_cache as $url) {
			$content = appStore_fopen_or_curl($url);
			
			if($fp = fopen($upload_dir['basedir'] . '/appStore/' . $app->trackId . '/' . basename($url), "w+")) {
				fwrite($fp, $content);
				fclose($fp);
			} else {
				//Couldnt write the file. Permissions must be wrong.
				appStore_set_setting('cache_images_locally', '0');
				return;
			}
		}
	}
}


$appStore_settings = array();
function appStore_setting($name) {
	global $appStore_settings;
	
	$appStore_settings = get_option('appStore_options');
	if(!$appStore_settings) {
		appStore_add_defaults();
		$appStore_settings = get_option('appStore_options');
	}	
	return $appStore_settings[$name];
}

function appStore_set_setting($name, $value) {
	global $appStore_settings;
	
	$appStore_settings = get_option('appStore_options');
	if(!$appStore_settings) {
		appStore_add_defaults();
		$appStore_settings = get_option('appStore_options');
	}
	$appStore_settings[$name] = $value;
}

function shortenDescription($string){
     $string = substr($string,0,appStore_setting('max_description'));
     $string = substr($string,0,strrpos($string," "));
     return $string;
}

// ------------ END OF FUNCTIONS-----------------

?>
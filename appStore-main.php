<?php 
/*
Plugin Name: App Store Assistant
Version: 4.7.1
Plugin URI: http://TheiPhoneAppsList.com/
Description: Adds shortcodes to display ATOM feed or individual item information from Apple's App Stores or iTunes.
Author: Scott Immerman
Author URI: http://SEALsystems.net/
*/

/**
Copyright 2012 Scott Immerman

*/
require_once('simplepie.inc');
add_action('wp_print_styles', 'appStore_page_add_stylesheet');
add_action( 'wp_head', 'appStore_css_hook' );

include_once("appStore-admin.php");

define('ASA_APPSTORE_URL', 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsLookup?country='.appStore_setting('store_country').'&id=');

add_shortcode("ios_asaf_atomfeed", "appStore_atomfeed_handler"); // Legacy shortcode for older installs
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
add_filter( 'tiny_mce_version', 'my_refresh_mce');

// +++++ Add ios_app button to TinyMCE
function add_asa_mce_button() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
   if ( get_user_option('rich_editing') == 'true') {
     add_filter('mce_external_plugins', 'add_asa_mce_tinymce_plugin');
     add_filter('mce_buttons', 'register_asa_mce_button');
   }
}

function register_asa_mce_button($buttons) {
   array_push($buttons, "|", "ios_app", "itunes_store","mac_app", "asaf_atomfeed");
   return $buttons;
}

function add_asa_mce_tinymce_plugin($plugin_array) {
   $plugin_array['asa_mce'] = plugins_url( 'js_functions/editor_plugin.js', __FILE__ );
   return $plugin_array;
}

function my_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}

// ----- End of Add ASA buttons to TinyMCE
function appStore_css_hook( ) {

	$emptyStar = plugins_url( 'images/star-rating-'.appStore_setting('empty_star_color').'.png', __FILE__ );
	$fullStar = plugins_url( 'images/star-rating-'.appStore_setting('full_star_color').'.png', __FILE__ );
?>
 
<style type='text/css'>
/* This site uses App Store Assistant version <?php echo plugin_get_version() ?> */

.appStore-rating_bar {
	display:inline-block;
	/* width of the background picture * 5 */
	width: 155px;
	text-align:left;
	/* This is the picture of a single empty star */
	background: url(<?php echo $emptyStar; ?>) 0 0 repeat-x;
}

.appStore-rating_bar span {
	display:inherit;
	/* height of the background picture */
	height: 31px;
	/* This is the picture of a single full star */
	background: url(<?php echo $fullStar; ?>) 0 0 repeat-x;
}

.appStore-Button {
	padding: 5px 20px 5px 20px;
	-moz-box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	-webkit-box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	<?php
	if(appStore_setting('hide_button_background') != "yes") { ?>
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79BBFF), color-stop(1, #378DE5) );
	background:-moz-linear-gradient( center top, #79BBFF 5%, #378DE5 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79BBFF', endColorstr='#378DE5');
	background-color:#79BBFF;
	<?php } ?>
	-moz-border-radius:<?php echo appStore_setting('button_corner_radius') ?>px;
	-webkit-border-radius:<?php echo appStore_setting('button_corner_radius') ?>px;
	border-radius:<?php echo appStore_setting('button_corner_radius') ?>px;
	border:<?php echo appStore_setting('button_border_width') ?>px solid #<?php echo appStore_setting('color_buttonBorder') ?>;
	display:inline-block;
	color:#<?php echo appStore_setting('color_buttonText') ?>;
	font-family:Trebuchet MS;
	font-size:16px;
	font-weight:bold;
	padding:4px 8px;
	text-decoration:none;
	text-shadow:1px 1px 0px #<?php echo appStore_setting('color_buttonTextShadow') ?>;
	margin-top: 8px;

}

.appStore-Button:hover {
	<?php if(appStore_setting('hide_button_background_hover') != "yes") { ?>
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #<?php echo appStore_setting('color_buttonHoverStart') ?>), color-stop(1, #<?php echo appStore_setting('color_buttonHoverStop') ?>) );
	background:-moz-linear-gradient( center top, #<?php echo appStore_setting('color_buttonHoverStart') ?> 5%, #<?php echo appStore_setting('color_buttonHoverStop') ?> 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#<?php echo appStore_setting('color_buttonHoverStart') ?>', endColorstr='#<?php echo appStore_setting('color_buttonHoverStop') ?>');
	background-color:#<?php echo appStore_setting('color_buttonHoverStart') ?>;
	<?php } ?>
	color: #<?php echo appStore_setting('color_buttonHoverText') ?>;
	text-decoration:none;
}

.iTunesStore-Button {
	padding: 5px 20px 5px 20px;
	-moz-box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	-webkit-box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	<?php
	if(appStore_setting('hide_button_background') != "yes") { ?>
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79BBFF), color-stop(1, #378DE5) );
	background:-moz-linear-gradient( center top, #79BBFF 5%, #378DE5 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#79BBFF', endColorstr='#378DE5');
	background-color:#79BBFF;
	<?php } ?>
	-moz-border-radius:<?php echo appStore_setting('button_corner_radius') ?>px;
	-webkit-border-radius:<?php echo appStore_setting('button_corner_radius') ?>px;
	border-radius:<?php echo appStore_setting('button_corner_radius') ?>px;
	border:<?php echo appStore_setting('button_border_width') ?>px solid #<?php echo appStore_setting('color_buttonBorder') ?>;
	display:inline-block;
	color:#<?php echo appStore_setting('color_buttonText') ?>;
	font-family:Trebuchet MS;
	font-size:16px;
	font-weight:bold;
	padding:4px 8px;
	text-decoration:none;
	text-shadow:1px 1px 0px #<?php echo appStore_setting('color_buttonTextShadow') ?>;
	margin-top: 8px;

}

.iTunesStore-Button:hover {
	<?php if(appStore_setting('hide_button_background_hover') != "yes") { ?>
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #<?php echo appStore_setting('color_buttonHoverStart') ?>), color-stop(1, #<?php echo appStore_setting('color_buttonHoverStop') ?>) );
	background:-moz-linear-gradient( center top, #<?php echo appStore_setting('color_buttonHoverStart') ?> 5%, #<?php echo appStore_setting('color_buttonHoverStop') ?> 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#<?php echo appStore_setting('color_buttonHoverStart') ?>', endColorstr='#<?php echo appStore_setting('color_buttonHoverStop') ?>');
	background-color:#<?php echo appStore_setting('color_buttonHoverStart') ?>;
	<?php } ?>
	color: #<?php echo appStore_setting('color_buttonHoverText') ?>;
	text-decoration:none;
}
</style>
<?php
}
function plugin_get_version() {
	if ( ! function_exists( 'get_plugins' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

function format_price($unformattedPrice) {

	
	//Check to see if the app is free, or under a dollar
	if($unformattedPrice == 0) {
		$thePrice = "Free!";
	} elseif($unformattedPrice < 1 && appStore_setting('currency_format')=="USD")  {
		$thePrice = number_format($unformattedPrice,2)*100;
		$thePrice .="&cent;";
	} else {
		switch (appStore_setting('currency_format')) {
			case "USD":
				$thePrice = "$".$unformattedPrice."";
				break;
			case "GBP":
				$thePrice = "&pound;".$unformattedPrice."";
				break;
			case "EUR":
				$thePrice = "&euro;".$unformattedPrice."";
				break;
			case "NOK":
				$thePrice = $unformattedPrice." kr ";
				break;
			case "SEK":
				$thePrice = $unformattedPrice." kr ";
				break;
			case "JPY":
				$thePrice = $unformattedPrice." &yen; ";
				break;
		}
	}

	return $thePrice;
}


function idsearch_app_handler($atts,$content=null, $code="") {
	GLOBAL $masterList,$checkForDuplicates;

	if (!empty($_POST)) {
		switch ($_POST['type']) {
    	case "iPhone":
			$Searchtype = "iPhone/iPod Software";
			$shortCodeStart = "[ios_app";
			$iCK = " checked";
			$entity = "software";
			break;
    	case "iOS":
			$Searchtype = "All iOS Software";
			$shortCodeStart = "[ios_app";
			$iOSCK = " checked";
			$entity = "software";
			break;
    	case "iPad":
			$Searchtype = "iPad Software";
			$shortCodeStart = "[ios_app";
			$iPCK = " checked";
			$entity = "iPadSoftware";
			break;
    	case "Mac":
			$Searchtype = "Macintosh Software";
			$shortCodeStart = "[mac_app";
			$entity = "macSoftware";
			$mCK = " checked";
			break;
		default:
			$Searchtype = "iPhone/iPod Software";
			$iCK = " checked";
			$shortCodeStart = "[ios_app";		
			$entity = "software";
		}
		$SearchTerm = $_POST['appname'];
	} else {
		$SearchTerm = "";
		$iOSCK = " checked";
	}

	echo '<div id="searchForm" class="searchForm">';
		echo '<form action="'.get_permalink( $post->ID ).'" method="POST">';
		echo '<b>App Name:</b> <input type="search" name="appname" id="appname" value="'.$SearchTerm.'" size="30"> <button class="appStore-search-find" name="Find Apps" type="submit" value="Find Apps">Find Apps</button><br />';
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="iOS"'.$iOSCK.'> All iOS';
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="Mac"'.$mCK.'> Mac';
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="iPhone"'.$iCK.'> Just iPhone/iPod';
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="iPad"'.$iPCK.'> Just iPad';
		//echo '&nbsp;&nbsp;&nbsp;<button class="appStore-search-find" name="Find Apps" type="submit" value="Find Apps">Find Apps</button>';
		//echo '</button>';
		echo '</form>';
	echo '</div>';
	if (!empty($_POST)) {

		$checkForDuplicates[] = "000000000"; //Setup array for later use
		$listOfApps = getSearchResultsFromApple($entity);
		buildListOfFoundApps($listOfApps,"1",$shortCodeStart);
		if($_POST['type'] == "iOS") {
			$biggerListOfApps = getSearchResultsFromApple("iPadSoftware");
			buildListOfFoundApps($biggerListOfApps,"2",$shortCodeStart);
		}
		if(is_array($masterList)){
		echo "<h2>$Searchtype</h2>";
			echo '<div class="appStore-search-appsList">';
				echo '<ul>';
				ksort($masterList);
				foreach ($masterList as $appRow) {
					echo $appRow;
				}
				echo '</ul>';
			echo "</div>";
		} else {
			echo "<h2>No $Searchtype Results Found!</h2>";
		}
		
		echo '<div style="clear:left;">&nbsp;</div>';
	}
}

function buildListOfFoundApps($listOfApps,$startKey,$shortCodeStart){
	GLOBAL $masterList,$checkForDuplicates;
	$i = $startKey;
	foreach ($listOfApps as $appData) {
		$masterList[$i] = "";
		if (!array_search($appData->trackId, $checkForDuplicates)) {
			$TheAppPrice = format_price($appData->price);
						
			$Categories = implode(", ", $appData->genres);
					
			$masterList[$i] .= "<li class='appStore-search-result' ";
			$masterList[$i] .= "style='background-image:url(\"".$appData->artworkUrl60."\")'>";
			$masterList[$i] .= "<p>";
			$masterList[$i] .= "<span class='appStore-search-title'>".$appData->trackName."</span>";
			$masterList[$i] .= " (".$appData->version.")<br />";
			
			$masterList[$i] .= " by ".$appData->artistName."/".$appData->sellerName."<br />";
			$masterList[$i] .= " [".$TheAppPrice."] ";
			$masterList[$i] .= "<b> [".$Categories."]</b> ";
			if($startKey == "2") $masterList[$i] .= "<b> [iPad Only]</b>";
			$masterList[$i] .= "<br /><br />";
			$masterList[$i] .= '<input id="id'.$appData->trackId.'" type="text" size="28" value="';
			$masterList[$i] .= $shortCodeStart;
			$masterList[$i] .= ' id=&quot;'.$appData->trackId.'&quot;]';
			$masterList[$i] .= '">';
			$masterList[$i] .= "</p>";
			$masterList[$i] .= '</li>';
		}
		
		$checkForDuplicates[] = $appData->trackId;
		$i = $i + 2;
	}
}



function getSearchResultsFromApple($entity){

	$url  = "https://itunes.apple.com/search?term=";
	$url .= urlencode($_POST['appname'])."&country=us&entity=$entity";
	$contents = file_get_contents($url); 
	$contents = utf8_encode($contents); 
	$foundApps = json_decode($contents);
	$listOfApps = $foundApps->results;
	return $listOfApps;

}
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
	if($app) {
		return appStore_page_output($app,$more_info_text,"internal",$code);
	} else {
		echo "";
		//wp_die('No valid data for app id: ' . $id);
	}
}

function appStore_app_link_handler( $atts,$content=null, $code="") {
	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'text' => ''
	), $atts ) );

	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;	

	//Get the App Data
	$app = appStore_get_data($id);
	if($app) {
		$appURL = getAffiliateURL($app->trackViewUrl);
		if ($text == '') $text = $app->trackName;
		$appURL = '<a href="'.$appURL.'">'.$text.'</a>';
		return $appURL;
	} else {
		echo "";
		//wp_die('No valid data for app id: ' . $id);
	}
}


function iTunesStore_handler( $atts,$content=null, $code="" ) {
	// Get iTunes ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'more_info_text' => 'continued...'
	), $atts ) );
	
	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;	
	
	//Get the Music Data
	$iTunesItem = appStore_get_data($id);
	if($iTunesItem)
		return iTunesStore_page_output($iTunesItem,$more_info_text,"internal",$code);
	else
		wp_die('No valid data for iTunes id: ' . $id);
}

function iBooksStore_handler( $atts,$content=null, $code="" ) {
	// Get iBooks ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'more_info_text' => 'continued...'
	), $atts ) );
	
	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;	
	
	//Get the Book Data
	return true;
}

function appStore_list_handler($atts, $content = null, $code="") {
	
	// Get ATOM URL and more_info_text from shortcode	
	extract( shortcode_atts( array(
		'ids' => '',
		'debug' => 'false',
		'mode' => 'iOS',
		'more_info_text' => 'open in The App Store...'
	), $atts ) );
	if(empty($ids)) {
		echo 'Missing list of IDs.';
		return;
	}
	
	//echo "[$debug]";
	//if($debug=="true") echo "[$appID][".print_r($app)."]";
	
		$appIDs = explode(",",$ids);
		$AppListing = "";
	//echo "-----------[".print_r($appIDs,true)."]-------------";

	//Pair down array to number of apps preference
	array_splice($appIDs, appStore_setting('qty_of_apps'));
	
	//Load App data
	foreach($appIDs as $appID) {
	
		if($appID == "" || !is_numeric($appID)) return;
		$app = appStore_get_data($appID);
		if($app) {
			if(stristr($mode, 'itunes')) {
				$AppListing .= iTunesStore_page_output($app,$more_info_text,"external",$code);
			} else {
				$AppListing .= appStore_page_output($app,$more_info_text,"external",$code);
			}
		} else {
			$AppListing .= "";
			//wp_die('No valid data for app id: ' . $id);
		}
	}
	return $AppListing; 
}

function appStore_atomfeed_handler($atts, $content = null, $code="") {
	
	// Get ATOM URL and more_info_text from shortcode	
	extract( shortcode_atts( array(
		'atomurl' => '',
		'debug' => 'false',
		'mode' => 'iOS',
		'more_info_text' => 'open in The App Store...'
	), $atts ) );
	if(empty($atomurl)) {
		echo 'Missing atomurl in tag. Replace <b>id</b> with <b>atomurl</b>.';
		return;
	}
	
	//echo "[$debug]";
	//if($debug=="true") echo "[$appID][".print_r($app)."]";
	
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
		if($app) {
			if(stristr($mode, 'itunes')) {
				echo iTunesStore_page_output($app,$more_info_text,"external",$code);
			} else {
				echo appStore_page_output($app,$more_info_text,"external",$code);
			}
		} else {
			echo "";
			//wp_die('No valid data for app id: ' . $id);
		}
	}
	return; 
}

// ------------START OF MAIN FUNCTIONS-----------------
function iTunesStore_page_output($iTunesItem, $more_info_text,$mode="internal",$platform="music_store") {
	GLOBAL $is_iphone;
	// Start capturing output so the text in the post comes first.
	ob_start();
	
	switch ($iTunesItem->wrapperType) {
    	case "collection":
			$unformattedPrice = $iTunesItem->collectionPrice;
			if($iTunesItem->collectionID) $iTunesID = $iTunesItem->collectionID;
			if($iTunesItem->collectionId) $iTunesID = $iTunesItem->collectionId;
			$iTunesName = $iTunesItem->collectionName;
			$isExplicit = $iTunesItem->collectionExplicitness;
			$trackCount = $iTunesItem->trackCount;
			$iTunesKind = $iTunesItem->collectionType;
			$iTunesURL = $iTunesItem->collectionViewUrl;
			break;
    	case "track":
			$unformattedPrice = $iTunesItem->trackPrice;
			$iTunesID = $iTunesItem->trackId;
			$iTunesName = $iTunesItem->trackName;
			$fromAlbum = $iTunesItem->collectionName;
			$isExplicit = $iTunesItem->trackExplicitness;
			$trackTime = $iTunesItem->trackTimeMillis;
			$iTunesKind = $iTunesItem->kind;
			$iTunesURL = $iTunesItem->trackViewUrl;
			break;
    	case "audiobook":
			$unformattedPrice = $iTunesItem->collectionPrice;
			$iTunesID = $iTunesItem->collectionId;
			$iTunesName = $iTunesItem->collectionName;
			$isExplicit = $iTunesItem->collectionExplicitness;
			$iTunesURL = $iTunesItem->collectionViewUrl;
			break;
	}
	$iTunesCategory = $iTunesItem->primaryGenreName;
	$artistName = $iTunesItem->artistName;
	$releaseDate = date( 'F j, Y', strtotime($iTunesItem->releaseDate));
	$contentAdvisoryRating = $iTunesItem->contentAdvisoryRating;
	
	$artistType = "Artist";
	$cavType = "Explicit";
	$trackType = "Track Count";
	switch ($iTunesItem->kind) {
    	case "song":
			$artistType = "Artist";
			break;
    	case "feature-movie":
			$artistType = "Director";
 			$cavType = "Rated";
 			$description = $iTunesItem->longDescription;
			break;
    	case "tv-episode":
			$artistType = "Series";
 			$cavType = "Rated";
 			$description = $iTunesItem->longDescription;
			break;
	}

	switch ($iTunesItem->collectionType) {
    	case "TV Season":
			$trackType = "Episodes";
			$artistType = "Series";
 			$cavType = "Rated";
 			$description = $iTunesItem->longDescription;
			break;
	}
	
	$iTunesPrice = format_price($unformattedPrice);
	
	// iTunes Artwork
	switch (appStore_setting('itunesicon_to_use')) {
    	case "30":
			$artwork_url = $iTunesItem->artworkUrl30;
			break;
    	case "60":
			$artwork_url = $iTunesItem->artworkUrl60;
			break;
    	case "100":
			$artwork_url = $iTunesItem->artworkUrl100;
			break;
	}
	if(appStore_setting('cache_images_locally') == '1') {
		$upload_dir = wp_upload_dir();
		$artwork_url = $upload_dir['baseurl'] . '/appstoreassistant_cache/' . $iTunesID . '/' . basename($artwork_url);
	}
	$originalImageSize = getimagesize("$artwork_url");
	$adjustIcon = appStore_setting('itunesicon_size_adjust')/100;
	if($is_iphone) $adjustIcon = appStore_setting('itunesicon_iOS_size_adjust')/100;
	$newImageWidth = $originalImageSize[0] * $adjustIcon;
	$newImageHeight = $originalImageSize[1] * $adjustIcon;

	if(appStore_setting('itunesicon_size_adjust_type') == 'pixels') {
		$newIconSize = appStore_setting('itunesicon_size_max');
		if($is_iphone) $newIconSize = appStore_setting('itunesicon_iOS_size_max');
		$newImageWidth = $newIconSize;
		$newImageHeight = $newIconSize;
	}

	$iTunesURL = getAffiliateURL($iTunesURL);
	
	if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
		$buttonText = $iTunesPrice." ";
	} else {
		$buttonText = $iTunesPrice." - View in iTunes";
	}

	
?>
<div class="appStore-wrapper">
	<hr>
	<div id="iTunesStore-icon-container">
		<a href="<?php echo $iTunesURL; ?>" ><img class="iTunesStore-icon" src="<?php echo $artwork_url; ?>" width="<?php echo $newImageWidth; ?>" height="<?php echo $newImageHeight; ?>" /></a>
		<div class="iTunesStore-purchase">
			<a type="button" href="<?php echo $iTunesURL; ?>" value="" class="iTunesStore-Button BuyButton"><?PHP echo $buttonText; ?></a></br>
		</div>

	</div>
	<?php
	
	if ((appStore_setting('displayitunestitle') == "yes" AND !empty($iTunesName)) OR $mode != "internal") {
		echo '<h1 class="iTunesStore-title">'.$iTunesName.'</h1>';
	}
	if (appStore_setting('displayitunestrackcount') == "yes" AND !empty($trackCount)) {
		echo '<span class="iTunesStore-trackcount">'.$trackType.': '.$trackCount.'</span></br>';
	}
	if (appStore_setting('displayitunesartistname') == "yes" AND !empty($artistName)) {
		echo '<span class="iTunesStore-artistname">'.$artistType.': '.$artistName.'</span></br>';
	}
	if (appStore_setting('displayfromalbum') == "yes" AND !empty($fromAlbum)) {
		echo '<span class="iTunesStore-fromalbum">From: '.$fromAlbum.'</span></br>';
	}
	if (appStore_setting('displayitunesgenre') == "yes" AND !empty($iTunesCategory)) {
		echo '<span class="iTunesStore-genre">Genre: '.$iTunesCategory.'</span></br>';
	}
	if (appStore_setting('displayadvisoryrating') == "yes" AND !empty($contentAdvisoryRating)) {
		echo '<span class="iTunesStore-advisoryrating">'.$cavType.': '.$contentAdvisoryRating.'</span></br>';
	}	
	if (appStore_setting('displayitunesreleasedate') == "yes" AND !empty($releaseDate)) {
		echo '<span class="iTunesStore-releasedate">Released: '.$releaseDate.'</span></br>';
	}

	if (appStore_setting('displayitunesexplicitwarning') == "yes" AND $isExplicit == "explicit") {
		echo '<span class="iTunesStore-explicitwarning"><img src="'.plugins_url( 'images/parental_advisory_explicit_content-big.gif' , __FILE__ ).'" width="112" height="67" alt="Explicit Lyrics" /></span><br />';// 450x268
	}
	if (appStore_setting('displayitunesdescription') == "yes" AND !empty($description)) {	
		echo '	<div class="iTunesStore-description">';
		echo nl2br($description);
		echo '</br></div>';
	}
	
	 ?>
	<div style="clear:left;">&nbsp;</div>
</div>
<?php

	if($_SERVER['REMOTE_ADDR'] == "98.148.220.0") {
		echo "<hr>";
		echo "<pre>";echo print_r($iTunesItem, true);echo "</pre>";
	}
	$return = ob_get_contents();
	ob_end_clean();	
	return $return;
}

function appStore_page_output($app, $more_info_text,$mode="internal",$platform="ios_app") {
	GLOBAL $is_iphone;

	// Start capturing output so the text in the post comes first.
	ob_start();


	$TheAppPrice = format_price($app->price);

	$appURL = getAffiliateURL($app->trackViewUrl);

	// App Artwork
	switch (appStore_setting('appstoreicon_to_use')) {
    	case "60":
			$artwork_url = $app->artworkUrl60;
			break;
    	case "512":
			$artwork_url = $app->artworkUrl512;
			break;
	}
	if(appStore_setting('cache_images_locally') == '1') {
		$upload_dir = wp_upload_dir();
		$artwork_url = $upload_dir['baseurl'] . '/appstoreassistant_cache/' . $app->trackId . '/' . basename($artwork_url);
	}
	$originalImageSize = getimagesize("$artwork_url");
	
	$adjustIcon = appStore_setting('appicon_size_adjust')/100;
	if($is_iphone) $adjustIcon = appStore_setting('appicon_iOS_size_adjust')/100;
	$newImageWidth = $originalImageSize[0] * $adjustIcon;
	$newImageHeight = $originalImageSize[1] * $adjustIcon;
	
	if(appStore_setting('appstoreicon_size_adjust_type') == 'pixels') {
		$newIconSize = appStore_setting('appicon_size_max');
		if($is_iphone) $newIconSize = appStore_setting('appicon_iOS_size_max');
		$newImageWidth = $newIconSize;
		$newImageHeight = $newIconSize;
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
	
	$AppFeatures = $app->features;
	
	if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
		$buttonText = $TheAppPrice." ";
	} else {
		$buttonText = $TheAppPrice." - View in App Store ";
	}

	$smallDescription = shortenDescription($app->description);

?>
<div class="appStore-wrapper">
	<hr>
	<div id="appStore-icon-container">
		<a href="<?php echo $appURL; ?>" target="_blank"><img class="appStore-icon" src="<?php echo $artwork_url; ?>" width="<?php echo $newImageWidth; ?>" height="<?php echo $newImageHeight; ?>" /></a>
		<div class="appStore-purchase">
			<a type="button" href="<?php echo $appURL; ?>" value="" class="appStore-Button BuyButton" target="_blank"><?PHP echo $buttonText; ?></a></br>
		</div>

	</div>
	<div class="appStore-addDetails">
	<?php
	if ((appStore_setting('displayapptitle') == "yes" AND !empty($app->trackName)) OR $mode != "internal") {
		echo '<h1 class="appStore-title">'.$app->trackName.'</h1>';
	}
	if (appStore_setting('displayversion') == "yes" AND !empty($app->version)) {
		echo '<span class="appStore-version">Version: '.$app->version.'</span></br>';
	}
	
	if ($app->artistName == $app->sellerName) {
		if ((appStore_setting('displaydevelopername') == "yes" OR appStore_setting('displaysellername') == "yes") AND !empty($app->artistName)) {
			echo '<span class="appStore-developername">Created &amp; Sold by: '.$app->artistName.'</span></br>';
		}
	} else {
		if (appStore_setting('displaydevelopername') == "yes" AND !empty($app->artistName)) {
			echo '<span class="appStore-developername">Created by: '.$app->artistName.'</span></br>';
		}
		if (appStore_setting('displaysellername') == "yes" AND !empty($app->sellerName)) {
			echo '<span class="appStore-sellername">Sold by: '.$app->sellerName.'</span></br>';
		}
	}	
	
	
	if (appStore_setting('displayreleasedate') == "yes" AND !empty($app->releaseDate)) {
		echo '<span class="appStore-releasedate">Released: '.date( 'F j, Y', strtotime($app->releaseDate) ).'</span></br>';
	}
	if (appStore_setting('displayfilesize') == "yes" AND !empty($app->fileSizeBytes)) {
		echo '<span class="appStore-filesize">File Size: '.filesizeinfo($app->fileSizeBytes).'</span></br>';
	}

	if (appStore_setting('displayuniversal') == "yes" AND $AppFeatures[0] == "iosUniversal") {
		echo '<span class="appStore-universal"><img src="'.plugins_url( 'images/fat-binary-badge-web.png' , __FILE__ ).'" width="14" height="14" alt="gamecenter" /> This app is designed for both iPhone and iPad</span><br />';
	}

	if (appStore_setting('displayadvisoryrating') == "yes" AND !empty($app->contentAdvisoryRating)) {
		echo '<span class="appStore-advisoryrating">Age Rating: '.$app->contentAdvisoryRating.'</span></br>';
	}
	if (appStore_setting('displaycategories') == "yes" AND !empty($appCategory)) {
		echo '<span class="appStore-categories">';
		if(count($appCategory) == 1) {
			echo "Category: ";
			echo $appCategory[0];
		} elseif (count($appCategory) > 1) {
			echo "Categories: ";
			echo $appCategoryList;
		}
		echo '</span>';
	}
	
	displayAppStoreRating($appRating,$app->averageUserRating,$app->userRatingCount);
		
	if (appStore_setting('displaygamecenterenabled') == "yes" AND $app->isGameCenterEnabled == 1) {
		echo '<img src="'.plugins_url( 'images/gamecenter.jpg' , __FILE__ ).'" width="88" height="92" alt="gamecenter" />';
	}

	 ?>
	</div>
	<div style="clear:left;">&nbsp;</div>
<?php
	if (is_single()) {
		echo '	<div class="appStore-description">';
		if (appStore_setting('use_shortDesc_on_single') == "yes") {
			echo nl2br($smallDescription);
		} else {
			echo nl2br($app->description);
		}
		echo '</br>';
		echo '<div class="appStore-badge"><a href="'.$appURL.'" >';
		echo '<img src="'.plugins_url( 'images/badge_appstore-lrg.gif' , __FILE__ ).'" alt="App Store" style="border: 0;"/></a></div>';
		// Original image from http://ax.phobos.apple.com.edgesuite.net/images/web/linkmaker/badge_appstore-lrg.gif
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
					$ssurl = $upload_dir['baseurl'] . '/appstoreassistant_cache/' . $app->trackId . '/' . basename($ssurl);
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
					$ssurl = $upload_dir['baseurl'] . '/appstoreassistant_cache/' . $app->trackId . '/' . basename($ssurl);
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
		echo '	<div class="appStore-description">';
		if (appStore_setting('use_shortDesc_on_multiple') == "yes") {
			echo nl2br($smallDescription);
			echo ' - <a href="'.get_permalink().'" value="">continued&hellip;</a>';
			$FullDescriptionButtonText = "Show Full Description & Screenshots";
		} else {
			echo nl2br($app->description);
			$FullDescriptionButtonText = "Show Screenshots";
		}
		if($mode=="internal") {
			echo '	<div style="clear:left;">&nbsp;</div>';
			echo '<div class="appStore-FullDescButton"><a type="button" href="'.get_permalink().'" value="" class="appStore-Button FullDescriptionButton">'.$FullDescriptionButtonText.'</a></div>';
		} else {
			echo ' - <a href="'.$appURL.'" value="">'.$more_info_text.'</a>';		
		}
		echo '  </div>';
	}		
	echo '	<div style="clear:left;">&nbsp;</div>';
	
	if (appStore_setting('displaysupporteddevices') == "yes" AND is_array($app->supportedDevices)) {
		echo '<span class="appStore-supporteddevices">Supported Devices: '.implode(", ", $app->supportedDevices)."</span><br />";
	}
	echo '	</div>';
	
	$return = ob_get_contents();
	ob_end_clean();	
	return $return;
}

function displayAppStoreRating($appRating,$averageRating,$ratingCount) {
	if(isset($ratingCount) AND appStore_setting('displaystarrating') == "yes") {
		echo '<div class="appStore-rating">';
		echo '	<span class="appStore-rating_bar" title="Rating '.$averageRating.' stars">';
		echo '	<span style="width:'.$appRating.'%"></span>';
		echo '	</span> by '.$ratingCount.' users.';
		echo '</div>';
	}

}


function getAffiliateURL($iTunesURL){
	switch (appStore_setting('affiliatepartnerid')) {
    case 30:
        $AffiliateURL = appStore_setting('affiliatecode');
		if (strpos($iTunesURL, '?') !== false) {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'&partnerId=30'));
		} else {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'?partnerId=30'));
		}
        break;
    case 2003:
          $AffiliateURL = "http://clk.tradedoubler.com/click?p=".appStore_setting('tdprogramID')."&a=".appStore_setting('tdwebsiteID')."&url=";
		if (strpos($iTunesURL, '?') !== false) {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'&partnerId=2003'));
		} else {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'?partnerId=2003'));
		}
        break;
    case 1002:
        $AffiliateURL = appStore_setting('dgmwrapper');
		if (strpos($iTunesURL, '?') !== false) {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'&partnerId=1002'));
		} else {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'?partnerId=1002'));
		}
       break;
    default:
        $AffiliateURL = "http://click.linksynergy.com/fs-bin/stat?id=uiuOb3Yu7Hg&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=";
		if (strpos($iTunesURL, '?') !== false) {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'&partnerId=30'));
		} else {
			$AffiliateURL .= urlencode(urlencode($iTunesURL.'?partnerId=30'));
		}
	}

	return $AffiliateURL;
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
		return null;
		//wp_die('<h1>Apple returned no app with that app ID.<br />Please check your app ID.</h1>');
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

	$appID = $app->trackId;
	if($app->wrapperType == "audiobook") $appID = $app->collectionId;
	if($app->wrapperType == "collection") $appID = $app->collectionId;

	$upload_dir = wp_upload_dir();
	if(!is_writeable($upload_dir['basedir'])) {
		//Uploads dir isn't writeable. bummer.
		appStore_set_setting('cache_images_locally', '0');
		return;
	} else {
		//Loop through screenshots and the app icons and cache everything
		if(!is_dir($upload_dir['basedir'] . '/appstoreassistant_cache/' . $appID)) {
			if(!mkdir($upload_dir['basedir'] . '/appstoreassistant_cache/' . $appID, 0755, true)) {
				appStore_set_setting('cache_images_locally', '0');
				return;	
			}
		}
		$urls_to_cache = array();
		if($app->artworkUrl30) $urls_to_cache[] = $app->artworkUrl30;
		if($app->artworkUrl60) $urls_to_cache[] = $app->artworkUrl60;
		if($app->artworkUrl100) $urls_to_cache[] = $app->artworkUrl100;
		if($app->artworkUrl512) $urls_to_cache[] = $app->artworkUrl512;
		
		if($app->screenshotUrls) {
			foreach($app->screenshotUrls as $ssurl) {
				$ssurl2 = str_replace(".png", ".320x480-75.jpg", $ssurl);
				$urls_to_cache[] = $ssurl;
				$urls_to_cache[] = $ssurl2;
			}
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
			
			if($fp = fopen($upload_dir['basedir'] . '/appstoreassistant_cache/' . $appID . '/' . basename($url), "w+")) {
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

function filesizeinfo($fs) { 
	$bytes = array('KB', 'KB', 'MB', 'GB', 'TB'); 
	// values are always displayed in at least 1 kilobyte: 
	if ($fs <= 999) $fs = 1; 
	for ($i = 0; $fs > 999; $i++) { 
		$fs /= 1024; 
	}
	
	return ceil($fs)." ".$bytes[$i]; 
} 

// ------------ END OF FUNCTIONS-----------------
?>
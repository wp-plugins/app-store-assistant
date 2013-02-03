<?php
// --------------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_uninstall_hook(__FILE__, 'appStore_delete_plugin_options')
// --------------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE USER DEACTIVATES AND DELETES THE PLUGIN. IT SIMPLY DELETES
// THE PLUGIN OPTIONS DB ENTRY (WHICH IS AN ARRAY STORING ALL THE PLUGIN OPTIONS).
// --------------------------------------------------------------------------------------
function appStore_delete_plugin_options() {
	delete_option('appStore_options');
}
// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_activation_hook(__FILE__, 'appStore_add_defaults')
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE PLUGIN IS ACTIVATED. IF THERE ARE NO THEME OPTIONS
// CURRENTLY SET, OR THE USER HAS SELECTED THE CHECKBOX TO RESET OPTIONS TO THEIR
// DEFAULTS THEN THE OPTIONS ARE SET/RESET.
//
// OTHERWISE, THE PLUGIN OPTIONS REMAIN UNCHANGED.
// ------------------------------------------------------------------------------
function appStore_add_defaults() {
	$tmp = get_option('appStore_options');

	$appStore_defaults = array(
		"max_description" => "400",
		"excerpt_max_chars" => "55",
		"excerpt_moreinfo_text" => "More Info",
		"excerpt_moreinfo_link" => "button",
		"use_shortDesc_on_single" => "no",
		"excerpt_generator" => "wordpress",
		"featured_image_generator" => "wordpress",
		"use_shortDesc_on_multiple" => "yes",
		"shortDesc_fullDesc_text" => "Show Full Description & Screenshots",
		"shortDesc_screenshot_text" => "Show Screenshots",
		"shortDesc_link" => "button",
		"smaller_buy_button_iOS" => "yes",
		"qty_of_apps" => "10",
		"ss_size" => "120",
		"currency_format" => "USD",
		"store_badge_language" => "US-UK",
		"appStore_store_badge_type" => "available",
		"iTunes_store_badge_type" => "available",
		"store_country" => "US",
	
		"full_star_color" => "blue",
		"empty_star_color" => "clear",
		"color_buttonStart" => "79bbff",
		"color_buttonStop" => "378de5",
		"color_buttonText" => "fcfc00",
		"color_buttonTextShadow" => "39618a",
		"color_buttonShadow" => "bbdaf7",
		"color_buttonBorder" => "84bbf3",
		"color_buttonHoverStart" => "378de5",
		"color_buttonHoverStop" => "79bbff",
		"color_buttonHoverText" => "C9C9FF",
		"hide_button_background" => "no",
		"hide_button_background_hover" => "no",
		"button_corner_radius" => "10",
		"button_border_width" => "3",
	
		"displayapptitle" => "no",
		"displayversion" => "yes",
		"displayadvisoryrating" => "yes",
		"displaycategories" => "yes",
		"displayfilesize" => "no",
		"displaystarrating" => "yes",
		"displaydevelopername" => "yes",
		"displaysellername" => "yes",
		"displaygamecenterenabled" => "yes",
		"displayuniversal" => "yes",
		"displaysupporteddevices" => "no",
		"displaysupporteddeviceIcons" => "yes",
		"displayreleasedate" => "no",
		"displayscreenshots" => "yes",
		"displayexcerptthumbnail" => "yes",
		"displayexcerptreadmore" => "no",
		"appstoreicon_to_use" => "512",
		"appstoreicon_size_adjust_type" => "percent",
		"appicon_size_adjust" => "25",
		"appicon_iOS_size_adjust" => "12",
		"appicon_size_max" => "128",
		"appicon_iOS_size_max" => "64",

		"displayitunestitle" => "yes",
		"displayitunestrackcount" => "yes",
		"displayitunesartistname" => "yes",
		"displayitunesfromalbum" => "yes",
		"displayitunesgenre" => "yes",
		"displayitunesreleasedate" => "yes",
		"displayitunesdescription" => "yes",
		"displayitunesexplicitwarning" => "yes",
		"itunesicon_size_adjust_type" => "percent",
		"itunesicon_to_use" => "100",
		"itunesicon_size_adjust" => "100",		
		"itunesicon_iOS_size_adjust" => "50",		
		"itunesicon_size_max" => "100",
		"itunesicon_iOS_size_max" => "50",

		"amazon_productimage_maxwidth" => "200",
		"amazon_productimage_size" => "medium",
		"AWS_PARTNER_DOMAIN" => "com",
		"AWS_API_KEY" => "",
		"AWS_API_SECRET_KEY" => "",
		"AWS_ASSOCIATE_TAG" => "",


		"cache_time_select_box" => (24*60*60),
		"cache_images_locally" => "1",

		"affiliatepartnerid" => "999",
		"affiliatecode" => "http://click.linksynergy.com/fs-bin/stat?id=uiuOb3Yu7Hg&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=",
		"affiliatetoken" => "uiuOb3Yu7Hg",
		"tdwebsiteID" => "",
		"tdprogramID" => "23708",
		"dgmwrapper" => "",

		"ResetCheckOne" => "NoWay",
		"ResetCheckTwo" => "NoWay",
		"ResetCheckThree" => "NoWay",

		"ResetCacheOne" => "NoWay",
		"ResetCacheTwo" => "NoWay",

		"versionInstalled" => "5.0"
		);
		update_option('appStore_options', $appStore_defaults);
}
// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_init', 'appStore_init' )
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_init' HOOK FIRES, AND REGISTERS YOUR PLUGIN
// SETTING WITH THE WORDPRESS SETTINGS API. YOU WON'T BE ABLE TO USE THE SETTINGS
// API UNTIL YOU DO.
// ------------------------------------------------------------------------------

// Init plugin options to white list our options
function appStore_init(){
	$settings = get_option('appStore_options');
	if(!$settings) appStore_add_defaults();
	register_setting( 'appStore_plugin_options', 'appStore_options', 'appStore_validate_options' );
	wp_enqueue_script('jquery-ui-core');//enables UI
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic' );
}
// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_menu', 'appStore_add_options_page');
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_menu' HOOK FIRES, AND ADDS A NEW OPTIONS
// PAGE FOR YOUR PLUGIN TO THE SETTINGS MENU.
// ------------------------------------------------------------------------------

// Add menu page
function appStore_add_options_page() {
	add_options_page('AppStore Assistant', 'AppStore Assistant', 'manage_options', ASA_MAIN_FILE, 'appStore_render_form');
	add_menu_page( 'AppStore Assistant', 'AppStore Asst', 'manage_options', ASA_MAIN_FILE, 'appStore_render_form', plugins_url( 'images/app-store-logo.png', ASA_MAIN_FILE ) );

	add_menu_page( 'Find Apps', 'Find App ID', 'edit_posts', "appStore_IDsearch", 'appStore_search_form', plugins_url( 'images/app-store-logo.png', ASA_MAIN_FILE ) );

}
function createPostFromAppID($appShortCode,$appTitle) {
	global $current_user;
	get_currentuserinfo();
	
	$my_post = array(
		'post_title' => $appTitle,
		'post_content' => $appShortCode,
		'post_author' => $current_user->ID,
		'post_status' => 'publish',
		'post_type' => 'post',
	);
	$PostReturn = wp_insert_post( $my_post );
	echo '<div class="updated settings-error">';
	if($PostReturn) {
		echo "<h3>Your POST has been created for <b>$appTitle</b>!</h3>";
		echo '<a href="post.php?post='.$PostReturn.'&amp;action=edit">Click here to edit the new post.</a>';
	} else {
		echo "There was an error creating your post for <b>$appTitle</b>!";
	}
	echo "<br /><br /></div>";
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
			$masterList[$i] .= '<form action="admin.php?page=appStore_IDsearch" method="POST"><p>';
			$masterList[$i] .= "<span class='appStore-search-title'>".$appData->trackName."</span>";
			$masterList[$i] .= " (".$appData->version.")<br />";
			
			$masterList[$i] .= " by ".$appData->artistName."/".$appData->sellerName."<br />";
			$masterList[$i] .= " [".$TheAppPrice."] ";
			$masterList[$i] .= "<b> [".$Categories."]</b> ";
			if($startKey == "2") $masterList[$i] .= "<b> [".__('iPad only',appStoreAssistant)."]</b>";
			$masterList[$i] .= "<br /><br />";
			$masterList[$i] .= '<input id="id'.$appData->trackId.'" type="text" size="28" value="';
			$masterList[$i] .= $shortCodeStart;
			$masterList[$i] .= ' id=&quot;'.$appData->trackId.'&quot;]';
			$masterList[$i] .= '">';
			$masterList[$i] .= '<input type="hidden" name="shortcode" value="';
			$masterList[$i] .= $shortCodeStart;
			$masterList[$i] .= ' id=&quot;'.$appData->trackId.'&quot; more_info_text=&quot;open in App Store...&quot;]"';
			$masterList[$i] .= '>';
			$masterList[$i] .= '<input type="hidden" name="postTitle" value="'.$appData->trackName.'">';
			$masterList[$i] .= '<input type="hidden" name="createPost" value="true">';
			$masterList[$i] .= '<button class="appStore-search-find" name="Create Post for this app" type="submit" value="Create Post for this app">Create Post for this app</button>';
			$masterList[$i] .= "</p></form>";
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

function appStore_search_form() {
	GLOBAL $masterList,$checkForDuplicates;
	echo '<div class="icon32" id="icon-tools"><br></div>';
	echo '<h2>Find an App ID from the App Store or Mac App Store</h2>';
	echo '<p>This will generate a shortcode that you can paste into your POST.</p>';

	if (!empty($_POST)) {
		switch ($_POST['type']) {
    	case "iPhone":
			$Searchtype = __("iPhone/iPod Software",appStoreAssistant);
			$shortCodeStart = "[ios_app";
			$iCK = " checked";
			$entity = "software";
			break;
    	case "iOS":
			$Searchtype = __("All iOS Software",appStoreAssistant);
			$shortCodeStart = "[ios_app";
			$iOSCK = " checked";
			$entity = "software";
			break;
    	case "iPad":
			$Searchtype = __("iPad Software",appStoreAssistant);
			$shortCodeStart = "[ios_app";
			$iPCK = " checked";
			$entity = "iPadSoftware";
			break;
    	case "Mac":
			$Searchtype = __("Macintosh Software",appStoreAssistant);
			$shortCodeStart = "[mac_app";
			$entity = "macSoftware";
			$mCK = " checked";
			break;
		default:
			$Searchtype = __("iPhone/iPod Software",appStoreAssistant);
			$iCK = " checked";
			$shortCodeStart = "[ios_app";		
			$entity = "software";
		}
		$SearchTerm = $_POST['appname'];
		
		if(!empty($_POST['createPost'])) {
	
			createPostFromAppID($_POST['shortcode'],$_POST['postTitle']);
	
		}
	} else {
		$SearchTerm = "";
		$iOSCK = " checked";
	}
	echo '<div id="searchForm" class="searchForm">';
		echo '<form action="admin.php?page=appStore_IDsearch" method="POST">';
		echo '<b>'.__('App Name',appStoreAssistant).':</b> ';
		
		$string = __('Find Apps',appStoreAssistant);		
		echo '<input type="search" name="appname" id="appname" value="'.$SearchTerm.'" size="30"> <button class="appStore-search-find" name="'.$string.'" type="submit" value="'.$string.'">'.$string.'</button><br />';
			
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="iOS"'.$iOSCK.'> '.__("All iOS",appStoreAssistant).'';
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="Mac"'.$mCK.'> '.__("Mac",appStoreAssistant).'';
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="iPhone"'.$iCK.'> '.__("Just iPhone/iPod",appStoreAssistant).'';
		echo '&nbsp;&nbsp;&nbsp;<input type="radio" name="type" value="iPad"'.$iPCK.'> '.__("Just iPad",appStoreAssistant).'';
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
			$string = sprintf( __('No %d Results Found!', 'plugin-domain'), $Searchtype );
		
			echo "<h2>$string</h2>";
		}
		
		echo '<div style="clear:left;">&nbsp;</div>';
	}

}

function appStore_render_form() {
	global $pagenow;
	$options = get_option('appStore_options');
	
	if($options['ResetCheckOne']=="DoIt" && $options['ResetCheckTwo']=="DoIt" && $options['ResetCheckThree']=="DoIt") {
		appStore_add_defaults();
		$OptionsReset = true;
		$options = get_option('appStore_options');
		appStoreShowMessage("All settings have been reset to their defaults!",true);
	}


	if($options['ResetCacheOne']=="DoIt" && $options['ResetCacheTwo']=="DoIt") {
		appStoreClearAppCache();		
		$options = get_option('appStore_options');
		$options["ResetCacheOne"] = "NoWay";
		$options["ResetCacheTwo"] = "NoWay";		
		update_option('appStore_options', $options);	
		appStoreShowMessage("The App data cache has been cleared!",true);
	}

	
	echo '<!-- Display Plugin Icon, Header, and Description -->';
	echo '<div class="icon32" id="icon-options-general"><br></div>';
	echo '<h2>AppStore Assistant Page Settings</h2>';
	echo '<p>Below is a collection of controls you can use to customize the App Store Assistant plugin.</p>';
	$upload_dir = wp_upload_dir();
	$appStore_cacheFolder = $upload_dir['basedir'] . '/appstoreassistant_cache';

	echo "<ol>";
	if(@is_dir($upload_dir['basedir'])) {
		if(!@is_writable(stripslashes($upload_dir['basedir']))) {
			echo '<li><font color="red">';
			echo "The Uploads folder is not WRITABLE. Please CHMOD the folder  ";
			echo '<font color="blue"><b>'.WP_CONTENT_DIR."/uploads/</b>".'</font>';
			echo " to '777'.<br />";
			echo "Images will not load without this folder, if you have \"Cache Images Locally\" turned on.";
			echo '</font>';
			echo '</li>';
		} else {
			if(!is_dir($upload_dir['basedir'] . '/appstoreassistant_cache/' . $appID)) {
				if(!mkdir($upload_dir['basedir'] . '/appstoreassistant_cache/' . $appID, 0755, true)) {
					appStore_set_setting('cache_images_locally', '0');
				} else {
					echo '<li><font color="green">';
					echo "The Cache folder ";
					echo '<b>'.WP_CONTENT_DIR."/uploads/appstoreassistant_cache</b>";
					echo " has been created successfully!";
					echo '</font>';
					echo '</li>';
				}
			}
		}
	} else {
		echo '<li><font color="red">';
		echo "The Cache folder does NOT exist. Please create ";
		echo '<font color="blue">'.WP_CONTENT_DIR."/uploads".'</font>';
		echo " folder and CHMOD it to '777'.<br />";
		echo "Images will not load without this folder, if you have \"Cache Images Locally\" turned on.";
		echo '</font>';
		echo '</li>';
	}

	if(@is_dir($appStore_cacheFolder)) {
		if(!@is_writable(stripslashes($appStore_cacheFolder))) {
			echo '<li><font color="red">';
			echo "The Cache folder is not WRITABLE. Please CHMOD the folder  ";
			echo '<font color="blue"><b>'.WP_CONTENT_DIR."/uploads/appstoreassistant_cache</b>".'</font>';
			echo " to '777'.<br />";
			echo "Images will not load without this folder, if you have \"Cache Images Locally\" turned on.";
			echo '</font>';
			echo '</li>';
		}
	} else {
		echo '<li><font color="red">';
		echo "The Cache folder does NOT exist. Please create ";
		echo '<font color="blue">'."<b>'appstoreassistant_cache'</b>".'</font>';
		echo " folder in ";
		echo '<font color="blue">'.WP_CONTENT_DIR."/uploads".'</font>';
		echo " folder and CHMOD it to '777'.<br />";
		echo "Images will not load without this folder, if you have \"Cache Images Locally\" turned on.";
		echo '</font>';
		echo '</li>';
	}
	if ( isset ( $_GET['tab'] ) ) appStore_admin_tabs($_GET['tab']);
	else appStore_admin_tabs('generaloptions');

	echo '<form method="post" action="options.php">';
	settings_fields('appStore_plugin_options');
	
	//wp_nonce_field( "appStore-settings-page" );
	
	//echo "[-----------$pagenow------------]<br />[-----------".$_GET['page']."------------]<br />";
	
	if ( ($pagenow == 'options-general.php' || $pagenow == 'admin.php') && $_GET['page'] == 'app-store-assistant/app-store-assistant.php' ){
		//echo $_GET['tab'];
		if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
		else $tab = 'generaloptions';
		switch ( $tab ){
			case 'generaloptions' :
				$appStoreOptionsPage = "options_general.php";
				break;
			case 'visual' :
				$appStoreOptionsPage = "options_visual.php";
				break;
			case 'appstore' :
				$appStoreOptionsPage = "options_appstore.php";
				break;
			case 'itunes' :
				$appStoreOptionsPage = "options_itunes.php";
				break;
			case 'amazon' :
				$appStoreOptionsPage = "options_amazon.php";
				break;
			case 'cache' :
				$appStoreOptionsPage = "options_cache.php";
				break;
			case 'affiliate' :
				if ($options['affiliatepartnerid'] == "999") $appStoreOptionsPage = "options_affiliate.php";
				if ($options['affiliatepartnerid'] == "30") $appStoreOptionsPage = "options_affiliate_linkshare.php";
				if ($options['affiliatepartnerid'] == "2003") $appStoreOptionsPage = "options_affiliate_td.php";
				if ($options['affiliatepartnerid'] == "1002") $appStoreOptionsPage = "options_affiliate_dgm.php";
				break;
			case 'help' :
				$appStoreOptionsPage = "options_help.php";
				break;
			case 'reset' :
				$appStoreOptionsPage = "options_reset.php";
				break;
		}
		require_once(ASA_PLUGIN_INCLUDES_PATH."options_pages/$appStoreOptionsPage");
	}

	echo '<p class="submit">';
	echo '<input type="submit" class="button-primary" value="';
	_e('Save Changes');
	echo '" />';
	echo '</p>';
	echo '</form>';
	
	require_once(ASA_PLUGIN_INCLUDES_PATH."donateform.inc");
	
}

function appStore_admin_tabs( $current = 'generaloptions' ) {
	$options = get_option('appStore_options');

	$tabs_start = array( 'generaloptions' => 'General', 'visual' => 'Visual Elements', 'appstore' => 'App Store', 'itunes' => 'iTunes Store', 'amazon' => 'Amazon.com', 'cache' => 'Cache', 'help' => 'Help' );
	
	switch ( $options['affiliatepartnerid'] ){
	  case '999' :
		$tabs_middle = array ('affiliate' => 'LinkShare');
	  break;
	  case '30' :
		$tabs_middle = array ('affiliate' => 'LinkShare');
	  break;
	  case '2003' :
		$tabs_middle = array ('affiliate' => 'TradeDoubler');
	  break;
	  case '1002' :
		$tabs_middle = array ('affiliate' => 'DGM');
	  break;
	}
	$tabs_end = array ('reset' => 'Reset' );
	if ($options['affiliatepartnerid'] == "999") {
		$tabs = array_merge($tabs_start, $tabs_end);
	} else {
		$tabs = array_merge($tabs_start,$tabs_middle, $tabs_end);
	}
	echo '<h2 class="nav-tab-wrapper">';
	foreach( $tabs as $tab => $name ){
	   $class = ( $tab == $current ) ? ' nav-tab-active' : '';
	   echo "<a class='nav-tab$class' href='?page=app-store-assistant/app-store-assistant.php&tab=$tab'>$name</a>";
	}
	echo '</h2>';
}


function requires_wordpress_version() {
	global $wp_version;
	$plugin = plugin_basename( ASA_MAIN_FILE );
	$plugin_data = get_plugin_data( ASA_MAIN_FILE, false );

	if ( version_compare($wp_version, "3.3", "<" ) ) {
		if( is_plugin_active($plugin) ) {
			deactivate_plugins( $plugin );
			wp_die( "'".$plugin_data['Name']."' requires WordPress 3.3 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>." );
		}
	}
}

// Display a Settings link on the main Plugins page
function appStore_plugin_action_links( $links, $file ) {

	if ( $file == plugin_basename( ASA_MAIN_FILE ) ) {
		$appStore_links = '<a href="'.get_admin_url().'options-general.php?page=app-store-assistant/app-store-assistant.php">'.__('Settings').'</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $appStore_links );
	}

	return $links;
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function appStore_validate_options($input) {
	//echo "-----------------------<br /><pre>";echo print_r($input, true);echo "</pre><br />-----------------------<br />";
	$options = get_option('appStore_options');
	if(isset($input['checkboxedoptions'])) {
		$checkboxedoptions = explode(",", $input['checkboxedoptions']);
		foreach($checkboxedoptions as $checkboxedoption) {
			$options[$checkboxedoption] = "no";
		}
	}
	foreach( $input as $optionName => $optionValue ){
		$options[$optionName] = $optionValue;
	}
	return $options;
}

function appStore_load_admin_js_files() {
 	wp_enqueue_script('jquerymenusstart', plugins_url('js_functions/jquerymenusstart.js',ASA_MAIN_FILE), null, null, true);
	wp_enqueue_script('jscolor', plugins_url('js_functions/jscolor/jscolor.js',ASA_MAIN_FILE), null, null, true);
}

function appStore_admin_page_add_stylesheet() {
	wp_register_style('appStore-admin-styles', plugins_url( 'css/appStore-admin.css', ASA_MAIN_FILE ));
	wp_enqueue_style( 'appStore-admin-styles');
}

function appStoreClearAppCache() {
	global $wpdb;
	$upload_dir = wp_upload_dir();

	//Clear AppStore Cache
	$options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'appStore_appData_%'");
	if ( is_null($options) ) return false;
	foreach( $options as $option ) {
		delete_option( $option->option_name );
 	} 

	//Clear Amazon Cache
	$options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'appStore_amazonData_%'");
	if ( is_null($options) ) return false;
	foreach( $options as $option ) {
		delete_option( $option->option_name );
 	}
 	
 	//Remove Cache Directory
	rrmdir(CACHE_DIRECTORY);
}

function rrmdir($dir) { 
	if (is_dir($dir)) { 
		$objects = scandir($dir); 
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") { 
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
			} 
		} 
		reset($objects); 
		rmdir($dir); 
	}
} 

function appStoreShowMessage($message, $errormsg = false)
{
	if ($errormsg) {
		echo '<div id="message" class="error">';
	}
	else {
		echo '<div id="message" class="updated fade">';
	}

	echo "<p><strong>$message</strong></p></div>";
}


//Setting Field Functions

function setting_string_fn() {
	$options = get_option('plugin_options');
	echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
}

function  setting_dropdown_fn() {
	$options = get_option('plugin_options');
	$items = array("Red", "Green", "Blue", "Orange", "White", "Violet", "Yellow");
	echo "<select id='drop_down1' name='plugin_options[dropdown1]'>";
	foreach($items as $item) {
		$selected = ($options['dropdown1']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
}
function setting_textarea_fn() {
	$options = get_option('plugin_options');
	echo "<textarea id='plugin_textarea_string' name='plugin_options[text_area]' rows='7' cols='50' type='textarea'>{$options['text_area']}</textarea>";
}
function setting_pass_fn() {
	$options = get_option('plugin_options');
	echo "<input id='plugin_text_pass' name='plugin_options[pass_string]' size='40' type='password' value='{$options['pass_string']}' />";
}
function setting_chk1_fn() {
	$options = get_option('plugin_options');
	if($options['chkbox1']) { $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='plugin_chk1' name='plugin_options[chkbox1]' type='checkbox' />";
}
function setting_radio_fn() {
	$options = get_option('plugin_options');
	$items = array("Square", "Triangle", "Circle");
	foreach($items as $item) {
		$checked = ($options['option_set1']==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='plugin_options[option_set1]' type='radio' /> $item</label><br />";
	}
}
?>
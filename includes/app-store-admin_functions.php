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
	$appStore_savedOptions = get_option('appStore_options');

	$appStore_defaults = array(
		"max_description" => "400",
		"excerpt_max_chars" => "55",
		"excerpt_moreinfo_text" => "More Info",
		"excerpt_moreinfo_link" => "button",
		"use_shortDesc_on_single" => "no",
		"open_links_externally" => "no",
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
	
		"newPost_status" => "draft",
		"newPost_addCategories" => "yes",
		"newPost_createCategories" => "yes",
		"newPost_defaultText" => "Read More...",
		"newPost_defaultTextShow" => "no",
	
		"displayapptitle" => "no",
		"displayappdescription" => "yes",
		"displayappbadge" => "yes",
		"displayappicon" => "yes",
		"displayappiconbuybutton" => "yes",

		"displayversion" => "yes",
		"displaydevelopername" => "yes",
		"displaysellername" => "yes",
		"displayreleasedate" => "no",
		"displayfilesize" => "no",
		"displayuniversal" => "yes",
		"displaycategories" => "yes",
		"displayadvisoryrating" => "yes",

		"displaygamecenterenabled" => "yes",
		"displayappbuybutton" => "yes",
		"displaystarrating" => "yes",
		"displayscreenshots" => "yes",
		"displaysupporteddevices" => "no",
		"displaysupporteddeviceIcons" => "yes",

		"displaympapptitle" => "no",
		"displaympappdescription" => "yes",
		"displaympappbadge" => "yes",
		"displaympappicon" => "yes",
		"displaympappiconbuybutton" => "yes",

		"displaympversion" => "yes",
		"displaympdevelopername" => "yes",
		"displaympsellername" => "yes",
		"displaympreleasedate" => "no",
		"displaympfilesize" => "no",
		"displaympuniversal" => "yes",
		"displaympcategories" => "yes",
		"displaympadvisoryrating" => "yes",

		"displaympgamecenterenabled" => "yes",
		"displaympappbuybutton" => "yes",
		"displaympstarrating" => "yes",
		"displaympscreenshots" => "yes",
		"displaympsupporteddevices" => "no",
		"displaympsupporteddeviceIcons" => "yes",

		"displayexcerptthumbnail" => "yes",
		"displayexcerptreadmore" => "no",
		"displayappdetailsaslist" => "yes",
		
		"displayappdetailsasliststyle" => "bw",
		"appstoreicon_to_use" => "512",
		"appstoreicon_size_adjust_type" => "percent",
		"appicon_size_adjust" => "25",
		"appicon_iOS_size_adjust" => "12",
		"appicon_size_max" => "128",
		"appicon_iOS_size_max" => "64",

		"appDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appGCIcon,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating",
		"appMPDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appGCIcon,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating",

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
		"amazon_textlink_default" => "View on Amazon.com",
		"amazon_textlink_price_default" => "Available from Amazon.com for",

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
		
		"RemoveCachedItem" => "NoWay",
		"RemoveCachedItemID" => "",
		"RemoveCachedItemASIN" => "",

		"displayLinkToFooter" => "yes",
		"versionInstalled" => "5"
		);
	$PostedValues = $_REQUEST;
	$appStore_options = $appStore_savedOptions;
	
	
	// Changes values from form
	if($PostedValues['action'] == "update" && is_array($PostedValues['appStore_options'])) {
		foreach ($appStore_defaults as $defaultName => $defaultValue) {
			$settingsValue = $PostedValues['appStore_options'][$defaultName];
			if($settingsValue != "") {
				$appStore_options[$defaultName] = $settingsValue;
			}
		}
	} else {
	//Check for empty settings
		foreach ($appStore_defaults as $defaultName => $defaultValue) {
			$settingsValue = $appStore_savedOptions[$defaultName];
			if($settingsValue == "") {
				$appStore_options[$defaultName] = $defaultValue;
			}
		}
	}
	
	//echo "-----UPDATE------[<pre>".print_r($PostedValues,true)."</pre>]-------------";
	update_option('appStore_options', $appStore_options);
}

// Init plugin options to white list our options
function appStore_init(){
	$settings = get_option('appStore_options');
	appStore_add_defaults(); // Also checks for new settings that haven't been set before
	register_setting( 'appStore_plugin_options', 'appStore_options', 'appStore_validate_options' );
}

function appStore_add_admin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs' );
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-core');//enables UI
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script('farbtastic' );
 	wp_enqueue_script('jquerymenusstart', plugins_url('js_functions/jquerymenusstart.js',ASA_MAIN_FILE), null, null, true);
	wp_enqueue_script('jscolor', plugins_url('js_functions/jscolor/jscolor.js',ASA_MAIN_FILE), null, null, true);
}

function appStore_add_admin_stylesheets() {
	wp_register_style('appStore-admin-styles', plugins_url( 'css/appStore-admin.css', ASA_MAIN_FILE ));
	wp_enqueue_style( 'appStore-admin-styles');
}

// Add menus
function appStore_add_options_page() {
	//add_options_page('AppStore Assistant', 'AppStore Assistant', 'manage_options', ASA_MAIN_FILE, 'appStore_sm_general');
	add_menu_page( 'AppStore Assistant', 'AppStore Asst', 'manage_options', 'appStore_sm_general', 'appStore_displayAdminOptionsPage', plugins_url( 'images/app-store-logo.png', ASA_MAIN_FILE ) );
	add_submenu_page( 'appStore_sm_general', 'General Settings', 'General', 'manage_options', 'appStore_sm_general', 'appStore_displayAdminOptionsPage');
	add_submenu_page( 'appStore_sm_general', 'Visual Settings', 'Visual', 'manage_options', 'appStore_sm_visual', 'appStore_displayAdminOptionsPage');
	add_submenu_page( 'appStore_sm_general', 'App Store Settings', 'App Store', 'manage_options', 'appStore_sm_appstore', 'appStore_displayAdminOptionsPage');
	add_submenu_page( 'appStore_sm_general', 'iTunes Store Settings', 'iTunes Store', 'manage_options', 'appStore_sm_itunes', 'appStore_displayAdminOptionsPage');
	add_submenu_page( 'appStore_sm_general', 'Amazon.com Settings', 'Amazon.com', 'manage_options', 'appStore_sm_amazon', 'appStore_displayAdminOptionsPage');
	add_submenu_page( 'appStore_sm_general', 'Utilities', 'Utilities', 'manage_options', 'appStore_sm_utilities', 'appStore_displayAdminOptionsPage');
	add_submenu_page( 'appStore_sm_general', 'Affiliate', 'Affiliate Programs', 'manage_options', 'appStore_sm_affiliate', 'appStore_displayAdminOptionsPage');
	add_submenu_page( 'appStore_sm_general', 'Help', 'Help', 'manage_options', 'appStore_sm_help', 'appStore_displayAdminOptionsPage');

	add_menu_page( 'New Apps', 'New App Post', 'edit_posts', "appStore_IDsearch", 'appStore_search_form', plugins_url( 'images/new-app-post.png', ASA_MAIN_FILE ) );
}

function appStore_displayAdminOptionsPage() {
	global $requestedPage;
	$upload_dir = wp_upload_dir();
	$options = get_option('appStore_options');
	$affiliatepartnerid = $options['affiliatepartnerid'];
	$requestedPage = $_REQUEST['page'];
	$settingsUpdated = $_REQUEST['settings-updated'];
	
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	if ( isset ( $_GET['tab'] ) ) {
		$currentTab = $_GET['tab'];
	} else {
		$currentTab = "defaultTab";
	}
	switch ( $requestedPage ){
		case 'appStore_sm_general' :
			$appStoreOptionsTitle = __("General Settings",appStoreAssistant);
			$appStoreOptionsPage = "options_general_$currentTab.php";
			break;
		case 'appStore_sm_visual' :
			$appStoreOptionsTitle = __("Visual Settings",appStoreAssistant);
			$appStoreOptionsPage = "options_visual_$currentTab.php";
			break;
		case 'appStore_sm_appstore' :
			$appStoreOptionsTitle = __("iOS & Mac App Store Settings",appStoreAssistant);
			$appStoreOptionsPage = "options_appstore_$currentTab.php";
			break;
		case 'appStore_sm_itunes' :
			$appStoreOptionsTitle = __("iTunes Store Settings",appStoreAssistant);
			$appStoreOptionsPage = "options_itunes_$currentTab.php";
			break;
		case 'appStore_sm_amazon' :
			$appStoreOptionsTitle = __("Amazon.com Settings",appStoreAssistant);
			$appStoreOptionsPage = "options_amazon_$currentTab.php";
			break;
		case 'appStore_sm_utilities' :
			$appStoreOptionsTitle = __("Utilities",appStoreAssistant);
			$appStoreOptionsPage = "options_utils_$currentTab.php";
			break;
		case 'appStore_sm_help' :
			$appStoreOptionsTitle = __("Help Page",appStoreAssistant);
			$appStoreOptionsPage = "options_help_$currentTab.php";
			break;
		case 'appStore_sm_affiliate' :
			$appStoreOptionsTitle = __("Affiliate Program",appStoreAssistant);
			$appStoreOptionsPage = "options_affiliate_$currentTab.php";
			break;
	}
	
	if($options['ResetCheckOne']=="DoIt" && $options['ResetCheckTwo']=="DoIt" && $options['ResetCheckThree']=="DoIt") {
		appStore_add_defaults();
		$OptionsReset = true;
		$options = get_option('appStore_options');
		appStore_ShowMessage("All settings have been reset to their defaults!",true);
	}

	if($options['AddFeaturedImages']=="DoIt" ) {
		$options["AddFeaturedImages"] = "NoWay";		
		update_option('appStore_options', $options);	

		$MyResults = appStore_get_shortcode_posts();
		$postCounter = 1;
		foreach($MyResults as $MyResult) {
			//echo $postCounter.') ------------------------------<br />';
			appStore_addFeaturedImage($MyResult);
			$postCounter++;
		}
		$options = get_option('appStore_options');
		appStore_ShowMessage("We did it!",true);
	}

	if($options['RemoveCachedItem']=="DoIt" ) {
		$appIDtoRemove = $options["RemoveCachedItemID"];
		$asinToRemove = $options["RemoveCachedItemASIN"];
		$options["RemoveCachedItem"] = "NoWay";		
		$options["RemoveCachedItemID"] = "";		
		$options["RemoveCachedItemASIN"] = "";		
		update_option('appStore_options', $options);	

		$returnMessage = appStore_ClearSpecificItemCache($appIDtoRemove,$asinToRemove);		
		appStore_ShowMessage($returnMessage,true);
	}

	if($options['ResetCacheOne']=="DoIt" && $options['ResetCacheTwo']=="DoIt") {
		appStore_ClearAppCache();		
		$options = get_option('appStore_options');
		$options["ResetCacheOne"] = "NoWay";
		$options["ResetCacheTwo"] = "NoWay";		
		update_option('appStore_options', $options);	
		appStore_ShowMessage("The App data cache has been cleared!",true);
	}

	
	
	echo '<!-- Display Plugin Icon, Header, and Description -->';
	echo '<div class="asa_admin_icon">';
	echo "<h2>AppStore Assistant $appStoreOptionsTitle</h2></div>";
	echo '<p>Below is a collection of controls you can use to customize the App Store Assistant plugin.</p>';
	//echo "<hr>--------------------".appStore_setting('validated')."----------------------<hr>";
	appStore_checkCacheFolder();
	if($settingsUpdated) appStore_ShowMessage(__("Settings Updated!",appStoreAssistant),true);
	appStore_displayAdminTabs($requestedPage,$currentTab,$affiliatepartnerid);
	echo '<form method="post" action="options.php">';
	settings_fields('appStore_plugin_options');
	require_once(ASA_PLUGIN_INCLUDES_PATH."options_pages/$appStoreOptionsPage");
	echo '<p class="submit">';
	echo '<input type="submit" class="button-primary" value="';
	_e('Save Changes');
	echo '" />';
	echo '</p>';
	echo '</form>';

	require_once(ASA_PLUGIN_INCLUDES_PATH."donateform.inc");
	return;
}

function appStore_displayAdminTabs( $tabSet,$currentTab = 'defaultTab',$affiliatepartnerid ) {
	global $requestedPage;
	switch ( $tabSet ){
	  case 'appStore_sm_general' :
		$tabs_array = array ('defaultTab' => 'Descriptions','excerpts' => 'Excerpts','createpost' => 'Create Posts','miscellaneous' => 'Miscellaneous');
	  break;
	  case 'appStore_sm_visual' :
		$tabs_array = array ('defaultTab' => 'Stars','buybutton' => 'Buy Button','miscellaneous' => 'Miscellaneous');
	  break;
	  case 'appStore_sm_appstore' :
		$tabs_array = array ('defaultTab' => 'Single Post','multipost' => 'Multiple Post','appicon' => 'App Icon','graphics' => 'App Store Graphics');
	  break;
	  case 'appStore_sm_itunes' :
		//$tabs_array = array ('defaultTab' => 'Single Post','multipost' => 'Multiple Post','graphics' => 'App Store Graphics');
		$tabs_array = array ('defaultTab' => 'Single Post','graphics' => 'App Store Graphics');
	  break;
	  case 'appStore_sm_amazon' :
		$tabs_array = array ('defaultTab' => 'Product Images','linktext' => 'Text Link Defaults');
	  break;
	  case 'appStore_sm_utilities' :
		$tabs_array = array ('defaultTab' => 'Add Featured Images','clearitem' => 'Clear an Item','clearcache' => 'Clear Cache','reset' => 'Reset Defaults');
	  break;
	  case 'appStore_sm_help' :
		$tabs_array = array ('defaultTab' => 'Getting Started','shortcodes' => 'Shortcodes','editor' => 'Post Editor');
	  break;
	  case 'appStore_sm_affiliate' :
		$tabs_start = array ('defaultTab' => 'Amazon.com');
		switch ( $affiliatepartnerid ){
		  case '999' :
			//$tabs_end = array ('affiliate' => 'LinkShare');
		  break;
		  case '30' :
			$tabs_end = array ('linkshare' => 'LinkShare');
		  break;
		  case '2003' :
			$tabs_end = array ('td' => 'TradeDoubler');
		  break;
		  case '1002' :
			$tabs_end = array ('dgm' => 'DGM');
		  break;
		}
		if(is_array($tabs_end)) {
			$tabs_array = array_merge($tabs_start, $tabs_end);
		} else {
			$tabs_array = $tabs_start;
		}
	  break;
	}


	echo '<h2 class="nav-tab-wrapper">';
	foreach( $tabs_array as $tab => $name ){
	   $class = ( $tab == $currentTab ) ? ' nav-tab-active' : '';
	   echo "<a class='nav-tab$class' href='?page=$requestedPage&tab=$tab'>$name</a>";
	}
	echo '</h2>';



}
function appStore_createPostFromAppID($appShortCode,$appTitle,$appCategories,$appID) {
	global $current_user;
	get_currentuserinfo();
	
	if(appStore_setting('newPost_status')=="") {
		$postStatus = "draft";
	} else {
		$postStatus = appStore_setting('newPost_status');
	}
	
	
	$my_post = array(
		'post_title' => $appTitle,
		'post_content' => $appShortCode,
		'post_author' => $current_user->ID,
		'post_status' => $postStatus,
		'post_type' => 'post',
	);
	
	$newPostID = wp_insert_post( $my_post );
	echo "Creating Post...<br />";
	if(appStore_setting('newPost_addCategories')=="yes") {
		$appCategories = explode(",",$appCategories);
		foreach($appCategories as $appCategory) {
		
			$term_id = term_exists( $appCategory, 'category' );
			if(is_array($term_id)) {
				$postCategories[] = $term_id['term_id'];
				$postCategoriesList[] = $appCategory;
			} elseif(appStore_setting('newPost_addCategories')=="yes") {				
				$postCategoriesList[] = $appCategory.' <font color="red">(NEW)</font>';
				$newCategoryID = wp_create_category($appCategory);
				if($newCategoryID) $postCategories[] = $newCategoryID;
			}
		}
		wp_set_post_terms( $newPostID, $postCategories, 'category',false);	
	}
	echo "Caching App data...<br />";

	appStore_get_data( $appID );
	echo "Saving Default Featured Image...<br />";
	
	$filename = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl100.png";
	$wp_filetype = wp_check_filetype(basename($filename), null ); 
	$wp_upload_dir = wp_upload_dir();
	$attachment = array(
		'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ), 
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attachment_id = wp_insert_attachment( $attachment, $filename, $newPostID );
	update_post_meta($newPostID, '_thumbnail_id', $attachment_id);
	
	echo '<div class="updated settings-error">';
	if($newPostID) {
		echo "<h3>Your $postStatus POST has been created for <b>$appTitle</b>!</h3>";
		echo '<a href="post.php?post='.$newPostID.'&amp;action=edit">Click here to edit the new post.</a><br><br>';
		if(is_array($postCategoriesList)) {
			echo "In the following categories:<br />";
			foreach($postCategoriesList as $category) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $category <br />";
		}
		
		
	} else {
		echo "There was an error creating your post for <b>$appTitle</b>!";
	}
	echo "<br /><br /></div>";
}

function appStore_buildListOfFoundApps($listOfApps,$startKey,$shortCodeStart){
	GLOBAL $masterList,$checkForDuplicates;
	$i = $startKey;
	foreach ($listOfApps as $appData) {
		$masterList[$i] = "";
		if (!array_search($appData->trackId, $checkForDuplicates)) {
			$TheAppPrice = format_price($appData->price);
						
			$Categories = implode(", ", $appData->genres);
			$CategoriesNS = implode(",", $appData->genres);
			
			$theShortCode = $shortCodeStart.' id=&quot;'.$appData->trackId.'&quot;';
			if(appStore_setting('newPost_defaultTextShow') == "yes") $theShortCode .= ' more_info_text=&quot;'.appStore_setting('newPost_defaultText').'&quot;';
			$theShortCode .= ']';
			
			
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
			$masterList[$i] .= '<input id="id'.$appData->trackId.'" type="text" name="shortcode" size="48" value="';
			$masterList[$i] .= $theShortCode;

			$masterList[$i] .= '">';
			//$masterList[$i] .= '<input type="hidden" name="shortcode" value="';
			//$masterList[$i] .= $theShortCode;
			//$masterList[$i] .= '">';
			$masterList[$i] .= '<input type="hidden" name="postTitle" value="'.$appData->trackName.'">';
			$masterList[$i] .= '<input type="hidden" name="appID" value="'.$appData->trackId.'">';
			$masterList[$i] .= '<input type="hidden" name="postCategories" value="'.$CategoriesNS.'">';
			$masterList[$i] .= '<input type="hidden" name="createPost" value="true">';
			$masterList[$i] .= '<br /><button class="appStore-search-find" name="Create Post for this app" type="submit" value="Create Post for this app">Create Post for this app</button>';
			$masterList[$i] .= "</p></form>";
			$masterList[$i] .= '</li>';
		}
		
		$checkForDuplicates[] = $appData->trackId;
		$i = $i + 2;
	}
}

function appStore_getSearchResultsFromApple($entity){

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
	echo '<h2>Find an App from the App Store or Mac App Store</h2>';
	echo '<p>This will generate a shortcode that you can paste into your POST. You will also have the option to <b>auto-create a post</b> which will include a Featured Image, App Title, Shortcode and Categories. After creation, you will be given a link to edit the post.</p>';

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
	
			appStore_createPostFromAppID($_POST['shortcode'],$_POST['postTitle'],$_POST['postCategories'],$_POST['appID']);
	
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
		$listOfApps = appStore_getSearchResultsFromApple($entity);
		appStore_buildListOfFoundApps($listOfApps,"1",$shortCodeStart);
		if($_POST['type'] == "iOS") {
			$biggerListOfApps = appStore_getSearchResultsFromApple("iPadSoftware");
			appStore_buildListOfFoundApps($biggerListOfApps,"2",$shortCodeStart);
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

//------------------------------TEST-----------------------------------------------
function wpse49871_shortcode_query_filter( $where ){
    global $wpdb;

    // Lets be on the safe side, escape and such.
    $new_where = $wpdb->prepare( 
         "%s AND %s LIKE %s"
        ,$where
        ,"{$wpdb->posts}.post_content"
        // If you know the exact ID, then just insert it in here.
        ,like_escape( '%_zzz%' )
    );

    return $new_where;
}
function appStore_get_shortcode_posts() {
    add_filter( 'posts_where', 'appStore_shortcode_query_filter' );
    $posts = get_posts( array('posts_per_page'  => 550
        // Do your query in here. See "Taxonomy Query" args above for example [,'meta_key'=>'-_thumbnail_id']
    ) );

    // Don't need it anymore after this run
    remove_filter( 'posts_where', 'appStore_shortcode_query_filter' );

    return $posts;
}
//------------------------------TEST-----------------------------------------------

function appStore_addFeaturedImage ($postData) {
	$newPostID = $postData->ID;
	if(!$newPostID) {
		echo '<font color="red">Skipping</font>: No Post ID Found<br />';
		return;
	} else {
		//echo "Post ID Found<br />";
	}
	
	if(has_post_thumbnail( $newPostID )) {
		//$returnData = '<font color="orange">Skipping</font> ('.$newPostID.'): Post Already has Featured Image<br />';
		return;
	} else {
		echo "<hr>No Featured Image Found<br />";
	}
	
	$appIDs = preg_match_all('/_app\ id=\"([^\"]*?)\"/', $postData->post_content, $app_matches);
	$iTunesIDs = preg_match_all('/itunes_store\ id=\"([^\"]*?)\"/', $postData->post_content, $iTunes_matches);
	$amazonIDs = preg_match_all('/amazon_item\ asin=\"([^\"]*?)\"/', $postData->post_content, $amazon_matches);
	//echo $postData->post_content."<br />";
	if(!$appIDs && !$amazonIDs && !$iTunesIDs) {
		echo '<font color="red">Skipping</font>: No App IDs or Amazon ASINs found for post ('.$newPostID.')<br />';
		return;
	}
	
	$postTitle = $postData->post_title;
	if(!$postTitle) {
		echo '<font color="red">Error</font>: No Post Title Found for post ('.$newPostID.')<br />';
		return;
	} else {
		echo 'Post Title Found ('.$postTitle.')<br />';
	}

	$shortcodeData = "";

	if($appIDs || $iTunesIDs) {
	
		if($iTunesIDs) $matchesToCheck = $iTunes_matches;
		if($appIDs) $matchesToCheck = $app_matches;
	
		echo "App IDs Found<br />";
		foreach ($matchesToCheck[1] as $shortcodeID) {
			$shortcodeData[] = $shortcodeID;
		}
		$appID = $shortcodeData[0];
		
		echo "First App ID Found (".$appID.")<br />";	
		if(!appStore_get_data( $appID )) {
			echo '<font color="red">Error</font>: Could Not Cache Data for App ID '.$appID.'<br />';
			return;
		} else {
			echo 'Caching App data for ('.$newPostID.') - '.$postTitle.'...<br />';
		}

		$filename = false;
		$firstChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl100.png";
		$secondChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl100.jpg";
		$thirdChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl512.png";
		$fourthChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl512.jpg";
		$fifthChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl60.png";

		if (file_exists($fifthChoice)) $filename = $fifthChoice;
		if (file_exists($fourthChoice)) $filename = $fourthChoice;
		if (file_exists($thirdChoice)) $filename = $thirdChoice;
		if (file_exists($secondChoice)) $filename = $secondChoice;
		if (file_exists($firstChoice)) $filename = $firstChoice;



	} elseif($amazonIDs) {
		echo "Amazon ASINs Found<br />";
		foreach ($amazon_matches[1] as $shortcodeID) {
			$shortcodeData[] = $shortcodeID;
		}
		$asin = $shortcodeData[0];
		echo "First Amazon ASIN Found ($asin)<br />";

		$filename = false;
		$firstChoice = CACHE_DIRECTORY."Amazon/".$asin."/MediumImage.jpg";
		$secondChoice = CACHE_DIRECTORY."Amazon/".$asin."/SmallImage.jpg";

		if (file_exists($secondChoice)) $filename = $secondChoice;
		if (file_exists($firstChoice)) $filename = $firstChoice;

	} else {
		echo '<font color="red">Error</font>: Could Not Process Featured Image URL for Post ('.$newPostID.')<br />';

	}
	
	

	if(!$filename) {
		echo '<font color="red">Error</font>: No Thumbnails found for App ID '.$appID.'<br /> - - Images may be missing or in the wrong format.';
		return;
	} else {
		echo "Thumbnails Found<br />";
		echo "$filename<br />";
	}

	$wp_filetype = wp_check_filetype(basename($filename), null ); 
	$wp_upload_dir = wp_upload_dir();
	$attachment = array(
		'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ), 
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attachment_id = wp_insert_attachment( $attachment, $filename, $newPostID );
	echo "Created Attachment ID: $attachment_id <br />";
	update_post_meta($newPostID, '_thumbnail_id', $attachment_id);

	echo "<hr>";
	return;
}

function appStore_checkCacheFolder() {
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
	echo '</ol>';
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
		$appStore_links = '<a href="'.get_admin_url().'admin.php?page=appStore_sm_general">'.__('Settings').'</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $appStore_links );
	}

	return $links;
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function appStore_validate_options($input) {
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
	
	
	$options['validated'] = "You Betcha! - ".date('r');
	return $options;
}


function appStore_ClearSpecificItemCache($appIDtoRemove,$asinToRemove) {
	global $wpdb;
	$upload_dir = wp_upload_dir();
	//Clear AppStore Cache
	$appID_option = "appStore_appData_".$appIDtoRemove;
	$asin_option = "appStore_amazonData_".$asinToRemove;
	$returnMessage = "Processing IDs.<br />";
		
	if(strlen($appID_option) > 22){
		if( get_option($appID_option)) {
			$returnMessage .= "App ID $appIDtoRemove Found.<br />";
			if(delete_option( $appID_option)) $returnMessage .= "App ID Cache data cleared.<br />";
			rrmdir(CACHE_DIRECTORY."AppStore/".$appIDtoRemove);
			$returnMessage .= "App ID Cache folder deleted.<br />";
		} else {
			$returnMessage .= "App ID $appIDtoRemove Not Found.<br />";
		}
	}
		
	if(strlen($asin_option) > 26){
		if(get_option($asin_option)) {
			$returnMessage .= "Amazon ASIN $asinToRemove Found.<br />";
			if(delete_option( $asin_option)) $returnMessage .= "Amazon ASIN Cache data cleared.<br />";
			rrmdir(CACHE_DIRECTORY."Amazon/".$asinToRemove);
			$returnMessage .= "Amazon ASIN Cache folder deleted.<br />";
		} else {
			$returnMessage .= "Amazon ASIN $asinToRemove Not Found.<br />";
		}
	}	

	return $returnMessage;
}



function appStore_ClearAppCache() {
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

function appStore_ShowMessage($message, $errormsg = false)
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
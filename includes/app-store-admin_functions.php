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
		"use_shortDesc_on_atomfeed" => "no",
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
	
		"PrePositionNumber" => "# ",
		"PostPositionNumber" => ") ",
	
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
		"displayappreleasenotes" => "yes",
		"displayappdetailssection" => "yes",
		"displayappbadge" => "yes",
		"displayappicon" => "yes",
		"displayappinapppurwarning" => "yes",
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
		"displaysupporteddevicesType" => "Normal",

		"displaympapptitle" => "no",
		"displaympappdescription" => "yes",
		"displaympappreleasenotes" => "yes",
		"displaympappdetailssection" => "yes",
		"displaympappbadge" => "yes",
		"displaympappicon" => "yes",
		"displaympinapppurwarning" => "yes",
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
		"displaympsupporteddeviceType" => "Normal",

		"displayATOMapptitle" => "no",
		"displayATOMappPositionNumber" => "no",
		"displayATOMappdescription" => "yes",
		"displayATOMappreleasenotes" => "yes",
		"displayATOMappdetailssection" => "yes",
		"displayATOMappbadge" => "yes",
		"displayATOMappicon" => "yes",
		"displayATOMappinapppurwarning" => "yes",
		"displayATOMappiconbuybutton" => "yes",

		"displayATOMversion" => "yes",
		"displayATOMdevelopername" => "yes",
		"displayATOMsellername" => "yes",
		"displayATOMreleasedate" => "no",
		"displayATOMfilesize" => "no",
		"displayATOMuniversal" => "yes",
		"displayATOMcategories" => "yes",
		"displayATOMadvisoryrating" => "yes",

		"displayATOMgamecenterenabled" => "yes",
		"displayATOMappbuybutton" => "yes",
		"displayATOMstarrating" => "yes",
		"displayATOMscreenshots" => "yes",
		"displayATOMsupporteddevices" => "no",
		"displayATOMsupporteddeviceType" => "Normal",

		"displayexcerptthumbnail" => "yes",
		"displayexcerptreadmore" => "no",
		"displayappdetailsaslist" => "yes",
		
		"displayappdetailsasliststyle" => "bw",

		"appicon_size_featured" => "256",
		"appicon_size_ios" => "256",
		"appicon_size_lists" => "128",
		"appicon_size_widget" => "64",
		"appicon_size_posts" => "128",
		"appicon_size_element" => "200",
		
		"appDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating,appStoreDetail_appGCIcon",
		"appMPDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating,appStoreDetail_appGCIcon",
		"appATOMDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appBadge,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appDetails,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating,appStoreDetail_appGCIcon",

		"displayitunestitle" => "yes",
		"displayitunestrackcount" => "yes",
		"displayitunesartistname" => "yes",
		"displayitunesfromalbum" => "yes",
		"displayitunesgenre" => "yes",
		"displayitunesreleasedate" => "yes",
		"displayitunesdescription" => "yes",
		"displayitunesexplicitwarning" => "yes",

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
		
		"ResetFIOne" => "NoWay",
		"ResetFITwo" => "NoWay",

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
	update_option('appStore_FI_maxItemsToProcess', "100");
}

// Init plugin options to white list our options
function appStore_init(){
	$settings = get_option('appStore_options');
	appStore_add_defaults(); // Also checks for new settings that haven't been set before
	register_setting( 'appStore_plugin_options', 'appStore_options', 'appStore_validate_options' );
}

function appStore_add_admin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');//enables UI
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_style( 'farbtastic');
	wp_enqueue_script('farbtastic');
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
		appStore_ShowMessage("All settings have been reset to their defaults!",false);
	}

	if($options['AddFeaturedImages']=="DoIt" ) {
		$options["AddFeaturedImages"] = "NoWay";		
		update_option('appStore_options', $options);	
		if(appStore_setting('cache_images_locally') != '1') {
			$options = get_option('appStore_options');
			appStore_ShowMessage("Cache MUST be ENABLED for this function to work!",true);
		} else {

			$MyResults = appStore_get_shortcode_posts();
			$postCounter = 1;
			foreach($MyResults as $MyResult) {
				//echo $postCounter.') ------------------------------<br />';
				appStore_addFeaturedImage($MyResult);
				$postCounter++;
			}
		$options = get_option('appStore_options');
		appStore_ShowMessage("We did it!",false);
		}
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

	if($options['ResetFIOne']=="DoIt" && $options['ResetFITwo']=="DoIt") {
		$options = get_option('appStore_options');
		$options["ResetFIOne"] = "NoWay";
		$options["ResetFITwo"] = "NoWay";		
		update_option('appStore_options', $options);	
		appStore_ClearFeaturedImages();		
	}
	
	
	echo '<!-- Display Plugin Icon, Header, and Description -->';
	echo '<div class="asa_admin_icon">';
	echo "<h2>AppStore Assistant $appStoreOptionsTitle</h2></div>";
	echo '<p>'.__('Below is a collection of controls you can use to customize the App Store Assistant plugin',appStoreAssistant).'.</p>';
	//echo "<hr>--------------------".appStore_setting('validated')."----------------------<hr>";
	appStore_checkCacheFolder();
	if($settingsUpdated) appStore_ShowMessage(__("Settings Updated!",appStoreAssistant),false);
	appStore_displayAdminTabs($requestedPage,$currentTab,$affiliatepartnerid);
	echo '<form method="post" action="options.php">';
	settings_fields('appStore_plugin_options');
	require_once(ASA_PLUGIN_INCLUDES_PATH."options_pages/$appStoreOptionsPage");
	echo '<p class="submit">';
	echo '<input type="submit" class="button-primary" value="';
	_e('Save Changes',appStoreAssistant);
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
		$tabs_array = array ('defaultTab' => 'Ratings','imagesizes' => 'Image Sizes','buybutton' => 'Buy Button','miscellaneous' => 'Miscellaneous');
	  break;
	  case 'appStore_sm_appstore' :
		$tabs_array = array ('defaultTab' => 'Single Post','multipost' => 'Multiple Posts','atomfeed' => 'List/Atom Feed','graphics' => 'App Store Graphics');
	  break;
	  case 'appStore_sm_itunes' :
		//$tabs_array = array ('defaultTab' => 'Single Post','multipost' => 'Multiple Post','graphics' => 'App Store Graphics');
		$tabs_array = array ('defaultTab' => 'Single Post','graphics' => 'iTunes Store Graphics');
	  break;
	  case 'appStore_sm_amazon' :
		$tabs_array = array ('defaultTab' => 'Text Link Defaults');
	  break;
	  case 'appStore_sm_utilities' :
		$tabs_array = array ('defaultTab' => 'Add Featured Images','clearitem' => 'Clear an Item','clearcache' => 'Clear Cache','reset_featured' => 'Reset Featured','reset' => 'Reset Defaults');
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
		  case '2013' :
			$tabs_end = array ('phg' => 'PHG');
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
	_e("Creating Post...",appStoreAssistant)."<br />";
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
	_e( "Caching App data...",appStoreAssistant)."<br />";

	appStore_get_data( $appID );
	_e( "Saving Default Featured Image...",appStoreAssistant)."<br />";
	
	$filename = appStore_getBestIcon($appID);
	
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
		echo "<h3>";
		_e("Your",appStoreAssistant);
		echo ' '.$postStatus.' ';
		_e("POST has been created for",appStoreAssistant);
		echo " <b>$appTitle</b>!</h3>";
		echo '<a href="post.php?post='.$newPostID.'&amp;action=edit">';
		_e('Click here to edit the new post',appStoreAssistant);
		echo '.</a><br><br>';
		if(is_array($postCategoriesList)) {
			_e( "In the following categories",appStoreAssistant).":<br />";
			foreach($postCategoriesList as $category) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $category <br />";
		}
		
		
	} else {
		_e( "There was an error creating your post for",appStoreAssistant)." <b>$appTitle</b>!";
	}
	echo "<br /><br /></div>";
}

function appStore_CreateListOfAppsUsedInPosts() {
	$MyResults = appStore_get_shortcode_posts();
	$postCounter = 1;
	$arrayOfIDs['iOS'][] = "000000000";
	$arrayOfIDs['iTunes'][] = "000000000";
	$arrayOfIDs['Amazon'][] = "000000000";

	foreach($MyResults as $MyResult) {
		$appIDs = preg_match_all('/_app\ id=\"([^\"]*?)\"/', $MyResult->post_content, $app_matches);
		$iTunesIDs = preg_match_all('/itunes_store\ id=\"([^\"]*?)\"/', $MyResult->post_content, $iTunes_matches);
		$amazonIDs = preg_match_all('/amazon_item\ asin=\"([^\"]*?)\"/', $MyResult->post_content, $amazon_matches);


		if($app_matches[1][0] != "") $arrayOfIDs['iOS'][] = $app_matches[1][0];
		if($iTunes_matches[1][0] != "") $arrayOfIDs['iTunes'][] = $iTunes_matches[1][0];
		if($amazon_matches[1][0] != "") $arrayOfIDs['Amazon'][] = $amazon_matches[1][0];

	
		//appStore_addFeaturedImage($MyResult);
		$postCounter++;
	}
	//echo "<hr>------RESULT-----[<pre>".print_r($arrayOfIDs,true)."</pre>]-------------<hr>";
	return $arrayOfIDs;
}


function appStore_buildListOfFoundApps($listOfApps,$startKey,$shortCodeStart,$type){
	GLOBAL $masterList,$checkForDuplicates;
	$i = $startKey;
	$listOfAlreadyAddedIDs = appStore_CreateListOfAppsUsedInPosts();
	$listOfAlreadyAddediOSIDs = $listOfAlreadyAddedIDs['iOS'];
	foreach ($listOfApps as $appData) {
		$masterList[$i] = "";
		$count = count(get_object_vars($appData));
		if (!array_search($appData->trackId, $checkForDuplicates) && $count > 10) {
			$TheAppPrice = appStore_format_price($appData->price);
			
			if(is_array($appData->genres)) {
				$Categories = implode(", ", $appData->genres);
				$CategoriesNS = implode(",", $appData->genres);
			} else {
				$Categories = "Unknown";
				$CategoriesNS = "Unknown";
			}				
			
			$theShortCode = $shortCodeStart.' id=&quot;'.$appData->trackId.'&quot;';
			if(appStore_setting('newPost_defaultTextShow') == "yes") $theShortCode .= ' more_info_text=&quot;'.appStore_setting('newPost_defaultText').'&quot;';
			$theShortCode .= ']';
			
			
			$masterList[$i] .= "<li class='appStore-search-result' ";
			$masterList[$i] .= "style='background-image:url(\"".$appData->artworkUrl60."\")'>";
			$masterList[$i] .= '<form action="admin.php?page=appStore_IDsearch" method="POST"><p>';
			$masterList[$i] .= "<span class='appStore-search-title'>";
			$masterList[$i] .= $appData->trackName;
			$masterList[$i] .= "</span>";
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
			$masterList[$i] .= '<input type="hidden" name="type" value="'.$type.'">';
			$masterList[$i] .= '<input type="hidden" name="createPost" value="true">';
			if (is_array($listOfAlreadyAddediOSIDs)) {
				if (in_array($appData->trackId, $listOfAlreadyAddediOSIDs)) {
					$masterList[$i] .= '<br /><font color="red"><b>'.__("You have already added this app.").'</b></font>';
				} else {
					$masterList[$i] .= '<br /><button class="appStore-search-find" name="Create Post for this app" type="submit" value="Create Post for this app">Create Post for this app</button>';
				}
			}
			$masterList[$i] .= "</p></form>";
			$masterList[$i] .= '</li>'."\r\n<!-- App -->\r\n";
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
	echo '<h2>'.__('Find an App from the App Store or Mac App Store',appStoreAssistant).'</h2>';
	echo '<p>'.__('This will generate a shortcode that you can paste into your POST. You will also have the option to <b>auto-create a post</b> which will include a Featured Image, App Title, Shortcode and Categories. After creation, you will be given a link to edit the post.',appStoreAssistant).'</p>';

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
		appStore_buildListOfFoundApps($listOfApps,"1",$shortCodeStart,$_POST['type']);
		if($_POST['type'] == "iOS") {
			$biggerListOfApps = appStore_getSearchResultsFromApple("iPadSoftware");
			appStore_buildListOfFoundApps($biggerListOfApps,"2",$shortCodeStart,$_POST['type']);
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
    $posts = get_posts( array(	'posts_per_page'  => 550,
    							'post_status' => 'any'

    ) );

    remove_filter( 'posts_where', 'appStore_shortcode_query_filter' );

    return $posts;
}

function appStore_get_shortcode_posts_featuredImages() {
	$MaxItemsToProcess = get_option('appStore_FI_maxItemsToProcess');
	$currentPostsList = get_option('appStore_appData_PostsList');
	$useSavedList = False;
	if(is_array($currentPostsList)) {
		$useSavedList = True;
		if (count($currentPostsList) < 1) {
			$useSavedList = False;
		}
	}
	$postsList = "";
	if($useSavedList) {
		$postsList = $currentPostsList;
	}else{
		add_filter( 'posts_where', 'appStore_shortcode_query_filter' );
		$posts = get_posts( array('posts_per_page'  => 1550,'meta_key' => '_thumbnail_id','post_status' => 'any' ) );
		//$posts = get_posts( array('meta_key' => '_thumbnail_id','post_status' => 'any' ) );
		remove_filter( 'posts_where', 'appStore_shortcode_query_filter' );
		foreach($posts as $MyResult) {
				$postsList[] = $MyResult->ID;
		}
		
		$ItemsLeft = count($postsList);
		$RoundsLeft = round($ItemsLeft/$MaxItemsToProcess)+1;
		update_option('appStore_FI_RoundsLeft', $RoundsLeft);

		
		
	}
	$postsList= array_values($postsList);
    return $postsList;
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
		echo "<hr>".__('No Featured Image Found',appStoreAssistant)."<br />";
	}
	
	$appIDs = preg_match_all('/_app\ id=\"([^\"]*?)\"/', $postData->post_content, $app_matches);
	$applinks = preg_match_all('/_app\ link=\"([^\"]*?)\"/', $postData->post_content, $applink_matches);
	$iTunesIDs = preg_match_all('/itunes_store\ id=\"([^\"]*?)\"/', $postData->post_content, $iTunes_matches);
	$amazonIDs = preg_match_all('/amazon_item\ asin=\"([^\"]*?)\"/', $postData->post_content, $amazon_matches);
	//echo $postData->post_content."<br />";
	if(!$appIDs && !$amazonIDs && !$iTunesIDs && !$applinks) {
		echo '<font color="red">Skipping</font>: '.__('No App IDs or Amazon ASINs found for post',appStoreAssistant).' ('.$newPostID.')<br />';
		return;
	}
	
	$postTitle = $postData->post_title;
	if(!$postTitle) {
		echo '<font color="red">Error</font>: '.__('No Post Title Found for post',appStoreAssistant).' ('.$newPostID.')<br />';
		return;
	} else {
		echo __('Post Title Found',appStoreAssistant).' ('.$postTitle.')<br />';
	}

	$shortcodeData = "";

	if($appIDs || $iTunesIDs || $applinks) {
	
		if($iTunesIDs) {
			$matchesToCheck = $iTunes_matches;
			echo __("iTunes IDs Found",appStoreAssistant)."<br />";
			foreach ($matchesToCheck[1] as $shortcodeID) {
				$shortcodeData[] = $shortcodeID;
			}
		}
		if($applinks) {
			$matchesToCheck = $applink_matches;
			echo __("App ID via Link Found",appStoreAssistant)."<br />";
			foreach ($matchesToCheck[1] as $link) {
				$pattern = '(id[0-9]+)';
				preg_match($pattern, $link, $matches, PREG_OFFSET_CAPTURE, 3);
				$appIDs = substr($matches[0][0], 2);		
				$shortcodeData[] = $appIDs;
			}
		}
		if($appIDs) {
			$matchesToCheck = $app_matches;
			echo __("App IDs Found",appStoreAssistant)."<br />";
			foreach ($matchesToCheck[1] as $shortcodeID) {
				$shortcodeData[] = $shortcodeID;
			}
		}
		$appID = $shortcodeData[0];
		
		echo __("First App ID Found",appStoreAssistant)." ($appID)<br />";
		
		$app_data=appStore_get_data( $appID );
		if(!is_array($app_data) && !is_object($app_data)) {
			echo '<font color="red">Error</font>: '.__('Could Not Cache Data for App ID',appStoreAssistant).' '.$appID.'<br />';
			return;
		} else {
			echo __('Caching App data for',appStoreAssistant).' ('.$newPostID.') - '.$postTitle.'...<br />';
		}
		$filename = $app->imageFeatured_path;

	} elseif($amazonIDs) {
		echo __("Amazon ASINs Found",appStoreAssistant)."<br />";
		foreach ($amazon_matches[1] as $shortcodeID) {
			$shortcodeData[] = $shortcodeID;
		}
		$asin = $shortcodeData[0];
		echo __("First Amazon ASIN Found",appStoreAssistant)." ($asin)<br />";
		$AmazonProductData = appStore_get_amazonData($asin);
		$filename = CACHE_DIRECTORY.$AmazonProductData['imageFeatured'];
		
	} else {
		echo '<font color="red">Error</font>: '.__('Could Not Process Featured Image URL for Post',appStoreAssistant).' ('.$newPostID.')<br />';

	}
	
	

	if(!$filename) {
		echo '<font color="red">Error</font>: '.__('No Thumbnails found for App ID',appStoreAssistant).' '.$appID.'<br /> - - '.__('Images may be missing or in the wrong format.',appStoreAssistant);
		return;
	} else {
		_e( "Thumbnails Found",appStoreAssistant);
		echo "<br />$filename<br />";
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
			_e( "The Uploads folder is not WRITABLE. Please CHMOD the folder  ",appStoreAssistant);
			echo '<font color="blue"><b>'.WP_CONTENT_DIR."/uploads/</b>".'</font>';
			echo " to '777'.<br />";
			_e( 'Images will not load without this folder, if you have "Cache Images Locally" turned on.',appStoreAssistant);
			echo '</font>';
			echo '</li>';
		} else {
			if(!is_dir($upload_dir['basedir'] . '/appstoreassistant_cache/' . $appID)) {
				if(!mkdir($upload_dir['basedir'] . '/appstoreassistant_cache/' . $appID, 0755, true)) {
					appStore_set_setting('cache_images_locally', '0');
				} else {
					echo '<li><font color="green">';
					_e( "The Cache folder ",appStoreAssistant);
					echo '<b>'.WP_CONTENT_DIR."/uploads/appstoreassistant_cache</b>";
					_e( " has been created successfully!",appStoreAssistant);
					echo '</font>';
					echo '</li>';
				}
			}
		}
	} else {
		echo '<li><font color="red">';
		_e( "The Cache folder does NOT exist. Please create ",appStoreAssistant);
		echo '<font color="blue">'.WP_CONTENT_DIR."/uploads".'</font>';
		_e(" folder and CHMOD it to '777'",appStoreAssistant).".<br />";
		_e('Images will not load without this folder, if you have "Cache Images Locally" turned on.',appStoreAssistant);
		echo '</font>';
		echo '</li>';
	}

	if(@is_dir($appStore_cacheFolder)) {
		if(!@is_writable(stripslashes($appStore_cacheFolder))) {
			echo '<li><font color="red">';
			_e( "The Cache folder is not WRITABLE. Please CHMOD the folder",appStoreAssistant)."  ";
			echo '<font color="blue"><b>'.WP_CONTENT_DIR."/uploads/appstoreassistant_cache</b>".'</font>';
			echo " to '777'.<br />";
			_e('Images will not load without this folder, if you have "Cache Images Locally" turned on.',appStoreAssistant);
			echo '</font>';
			echo '</li>';
		}
	} else {
		echo '<li><font color="red">';
		_e( "The Cache folder does NOT exist. Please create ",appStoreAssistant);
		echo '<font color="blue">'."<b>'appstoreassistant_cache'</b>".'</font>';
		_e( " folder in ",appStoreAssistant);
		echo '<font color="blue">'.WP_CONTENT_DIR."/uploads".'</font>';
		_e( " folder and CHMOD it to '777'",appStoreAssistant).".<br />";
		_e('Images will not load without this folder, if you have "Cache Images Locally" turned on.',appStoreAssistant);
		echo '</font>';
		echo '</li>';
	}
	echo '</ol>';
}



function requires_wordpress_version() {
	global $wp_version;
	$plugin = plugin_basename( ASA_MAIN_FILE );
	$plugin_data = get_plugin_data( ASA_MAIN_FILE, false );

	if ( version_compare($wp_version, "3.6", "<" ) ) {
		if( is_plugin_active($plugin) ) {
			deactivate_plugins( $plugin );
			wp_die( "'".$plugin_data['Name']."' requires WordPress 3.6 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />(Older installations please use version 6.2.1)<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>." );
		}
	}
}

// Display a Settings link on the main Plugins page
function appStore_plugin_action_links( $links, $file ) {

	if ( $file == plugin_basename( ASA_MAIN_FILE ) ) {
		$appStore_links = '<a href="'.get_admin_url().'admin.php?page=appStore_sm_general">'.__('Settings',appStoreAssistant).'</a>';
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

	if(isset($input['textboxoptions'])) {
		$textboxoptions = explode(",", $input['textboxoptions']);
		foreach($textboxoptions as $textboxoption) {
			$options[$textboxoption] = "EMP";
		}
	}
	
	
	
	
	foreach( $input as $optionName => $optionValue ){
		if($optionValue != "") $options[$optionName] = $optionValue;
	}	
	
	//print_r($options);
	
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

function appStore_ClearFeaturedImages() {
	$MaxItemsToProcess = get_option('appStore_FI_maxItemsToProcess');
	$currentPostsList = appStore_get_shortcode_posts_featuredImages();
	$ItemsLeft = count($currentPostsList);
	$RoundsLeft = round($ItemsLeft/$MaxItemsToProcess)+1;
	
	
		if($RoundsLeft == 0) {
			appStore_ShowMessage("The Featured Images have been updated!",true);
		} else {
			appStore_ShowMessage("You will need to run this step $RoundsLeft more times!",true);
		}
		
		
		
		echo "There are $ItemsLeft Posts with featured Images to change.<br />";
		$postCounter = 1;
		foreach($currentPostsList as $key => $PostID) {
			echo "[$key] $PostID <br>";
			
			
			unset($currentPostsList[$key]);
			$postCounter ++;
			if($postCounter >$MaxItemsToProcess) break;
		}
		//echo "-------".count($currentPostsList)."-------".print_r($currentPostsList,true)."<hr>";

		//echo "[WERE HERE]";
		$currentPostsList= array_values($currentPostsList);
		//echo "-------".count($currentPostsList)."-------".print_r($currentPostsList,true)."<hr>";

		update_option('appStore_appData_PostsList', $currentPostsList);	
		
		//print_r($MyResults);
		return;
		foreach($MyResults as $MyResult) {
			$postID = $MyResult->ID;
			$post_thumbnail_id = get_post_thumbnail_id($postID );
			$url = wp_get_attachment_thumb_url( $post_thumbnail_id );
			$data = preg_match("~/appstoreassistant_cache/AppStore/([0-9]+)/~", $url, $matches);
			$newCheck = preg_match("~featured~", $url, $featuredmatches);
			$appID = $matches[1];
			if($appID == "" || !is_numeric($appID)) {
				echo '<font color="red">';
				echo $postCounter."- ++++++++++++SKIPPING:CUSTOM Featured Image - $url ($postID)($post_thumbnail_id)($appID)";
				echo "</font><hr>";
			} elseif($featuredmatches[0] == "featured") {	
				echo '<font color="blue">';
				echo $postCounter."- ++++++++++++SKIPPING: Already updated Feature Image - $url ($postID)($post_thumbnail_id)($appID)";
				echo "</font><hr>";
			} else {
				$app_data = appStore_get_data( $appID );
				if($app_data->kind == "software") {
					$newFileExtension = $app_data->artworkUrl512_ext;
					$newFeaturedImageURL = $app_data->imageFeatured_cached;
					$newFeaturedImagePath = $app_data->imageFeatured_path;
					echo '<font color="green">';
					echo $postCounter."- ($postID)($post_thumbnail_id)($appID)<br />";
					echo "- Old Featured Image - $url<br />";
					echo "- New Featured Image - $newFeaturedImageURL<br />";
					//print_r($app_data);
					echo "</font><hr>";
					
					$wp_filetype = wp_check_filetype($newFeaturedImagePath, null );
					$mime_type = $wp_filetype[type];
					$attachment = array(
									'post_mime_type' => $wp_filetype['type'],
									'post_title' => preg_replace('/\.[^.]+$/', '', basename($newFeaturedImagePath)),
									'post_name' => preg_replace('/\.[^.]+$/', '', basename($newFeaturedImagePath)),
									'post_content' => '',
									'post_parent' => $postID,
									'post_excerpt' => $thumb_credit,
									'post_status' => 'inherit'
									);
					$attachment_id = wp_insert_attachment($attachment, $newFeaturedImagePath, $postID);
					if($attachment_id != 0) {
						$attachment_data = wp_generate_attachment_metadata($attachment_id, $newFeaturedImagePath);
						wp_update_attachment_metadata($attachment_id, $attach_data);
						update_post_meta($postID, '_thumbnail_id', $attachment_id);
					}
				}
			}
			$postCounter++;
		}
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

	//Clear ATOM Feed Cache
	$options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'appStore_rssfeed_%'");
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
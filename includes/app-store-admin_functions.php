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
	$phgCampaignvalue = "v".preg_replace("/[^0-9]/",'',plugin_get_version())."_".$_SERVER['SERVER_NAME'];
	$phgCampaignvalue = preg_replace("/[^A-Za-z0-9_\.]/", '', $phgCampaignvalue);
	$phgCampaignvalue = substr($phgCampaignvalue,0,42);

	$appStore_defaults = array(
		"max_description" => "400",
		"max_description_rss" => "400",
		"rss_showIcon" => "yes",
		"rss_showShortDescription" => "yes",
		"enable_lightbox" => "yes",
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
		"color_buttonShadow" => "7a8da1",
		"color_buttonBorder" => "84bbf3",
		"color_buttonHoverStart" => "378de5",
		"color_buttonHoverStop" => "79bbff",
		"color_buttonHoverText" => "C9C9FF",
		"hide_button_background" => "no",
		"hide_button_background_hover" => "no",
		"button_corner_radius" => "16",
		"button_border_width" => "1",
	
		"newPost_status" => "draft",
		"newPost_addCategories" => "yes",
		"newPost_createCategories" => "yes",
		"newPost_defaultText" => "Read More...",
		"newPost_defaultTextShow" => "no",
	
		"displayapptitle" => "HIDE",
		"displayappdescription" => "NORM_TITLE",
		"displayappreleasenotes" => "NORM_TITLE",
		"displayappdetailssection" => "NORM_TITLE",
		"displayscreenshots" => "NORM_TITLE",
		"displaysupporteddevices" => "HIDE",

		"displayappicon" => "NORM_NOTITLE",
		"displayappiconbuybutton" => "NORM_NOTITLE",
		"displayappbadge" => "NORM_NOTITLE",
		"displaygamecenterenabled" => "NORM_NOTITLE",
		"displayappbuybutton" => "NORM_NOTITLE",
		"displaystarrating" => "NORM_NOTITLE",

		"displayversion" => "INLINE",
		"displaydevelopername" => "INLINE",
		"displaysellername" => "INLINE",
		"displayreleasedate" => "HIDE",
		"displayfilesize" => "HIDE",
		"displayprice" => "HIDE",
		"displayuniversal" => "INLINE",
		"displayadvisoryrating" => "INLINE",
		"displayappinapppurwarning" => "INLINE",
		"displaycategories" => "INLINE",

		"displaysupporteddevicesType" => "Normal",

		"displaympapptitle" => "HIDE",
		"displaympappdescription" => "NORM_TITLE",
		"displaympappreleasenotes" => "NORM_TITLE",
		"displaympappdetailssection" => "NORM_TITLE",
		"displaympscreenshots" => "NORM_TITLE",
		"displaympsupporteddevices" => "HIDE",

		"displaympappicon" => "NORM_NOTITLE",
		"displaympappiconbuybutton" => "NORM_NOTITLE",
		"displaympappbadge" => "NORM_NOTITLE",
		"displaympgamecenterenabled" => "NORM_NOTITLE",
		"displaympappbuybutton" => "NORM_NOTITLE",
		"displaympstarrating" => "NORM_NOTITLE",

		"displaympversion" => "INLINE",
		"displaympdevelopername" => "INLINE",
		"displaympsellername" => "INLINE",
		"displaympreleasedate" => "HIDE",
		"displaympfilesize" => "HIDE",
		"displaympprice" => "HIDE",
		"displaympuniversal" => "INLINE",
		"displaympadvisoryrating" => "INLINE",
		"displaympappinapppurwarning" => "INLINE",
		"displaympcategories" => "INLINE",

		"displaympsupporteddevicesType" => "Normal",

		"displayATOMapptitle" => "HIDE",
		"displayATOMappdescription" => "NORM_TITLE",
		"displayATOMappreleasenotes" => "NORM_TITLE",
		"displayATOMappdetailssection" => "NORM_TITLE",
		"displayATOMscreenshots" => "NORM_TITLE",
		"displayATOMsupporteddevices" => "HIDE",

		"displayATOMappicon" => "NORM_NOTITLE",
		"displayATOMappiconbuybutton" => "NORM_NOTITLE",
		"displayATOMappbadge" => "NORM_NOTITLE",
		"displayATOMgamecenterenabled" => "NORM_NOTITLE",
		"displayATOMappbuybutton" => "NORM_NOTITLE",
		"displayATOMstarrating" => "NORM_NOTITLE",

		"displayATOMversion" => "INLINE",
		"displayATOMdevelopername" => "INLINE",
		"displayATOMsellername" => "INLINE",
		"displayATOMreleasedate" => "HIDE",
		"displayATOMfilesize" => "HIDE",
		"displayATOMprice" => "HIDE",
		"displayATOMuniversal" => "INLINE",
		"displayATOMadvisoryrating" => "INLINE",
		"displayATOMappinapppurwarning" => "INLINE",
		"displayATOMcategories" => "INLINE",

		"displayATOMsupporteddevicesType" => "Normal",
		"displayATOMappPositionNumber" => "no",

		"displayexcerptthumbnail" => "yes",
		"displayexcerptreadmore" => "no",
		"displayappdetailsaslist" => "yes",
		
		"displayappdetailsasliststyle" => "bw",

		"appicon_size_featured" => "256",
		"appicon_size_ios" => "256",
		"appicon_size_lists" => "128",
		"appicon_size_widget" => "32",
		"appicon_size_posts" => "128",
		"appicon_size_element" => "200",
		"appicon_size_rss" => "128",
		
		"appDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating,appStoreDetail_appGCIcon,appStoreDetail_appIconBuyButton",
		"appMPDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating,appStoreDetail_appGCIcon,appStoreDetail_appIconBuyButton",
		"appATOMDetailsOrder" => "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appBadge,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appDetails,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating,appStoreDetail_appGCIcon,appStoreDetail_appIconBuyButton",

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
		"PHGaffiliateID" => "11l3KC",
		"phgCampaignvalue" => $phgCampaignvalue,	
		"tdwebsiteID" => "",
		"tdprogramID" => "24369",

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
		
		"displayLinkToFooter" => "no",
		"versionInstalled" => "6.5"
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
	wp_enqueue_script('jquery-ui-core');//enables UI
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_style( 'farbtastic');
	wp_enqueue_script('farbtastic');
 	wp_enqueue_script('jquerymenusstart', plugins_url('js_functions/jquerymenusstart.js',ASA_MAIN_FILE), null, null, true);
	wp_enqueue_script('jscolor', plugins_url('js_functions/jscolor/jscolor.js',ASA_MAIN_FILE), null, null, true);
	//Used for Rebuilding Featured Images Progress Bar
	wp_enqueue_script( 'jquery-ui-progressbar', plugins_url( 'js_functions/jquery-ui/jquery.ui.progressbar.min.1.7.2.js', ASA_MAIN_FILE ), array( 'jquery-ui-core' ), '1.7.2' );
	wp_enqueue_style( 'jquery-ui-appStore', plugins_url( 'js_functions/jquery-ui/redmond/jquery-ui-1.7.2.custom.css', ASA_MAIN_FILE ), array(), '1.7.2' );
	
	
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
				if($postCounter >20) break; //DEBUG
			}
		$options = get_option('appStore_options');
		appStore_ShowMessage("We did it!",false);
		}
	}

	if($options['RemoveCachedItem']=="DoIt" ) {
		$appIDtoRemove = $options["RemoveCachedItemID"];
		$asinToRemove = $options["RemoveCachedItemASIN"];
		$options["RemoveCachedItem"] = "NoWay";		
		$options["RemoveCachedItemID"] = "EMPTY";		
		$options["RemoveCachedItemASIN"] = "EMPTY";		
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
		$tabs_array = array ('defaultTab' => 'Main', 'descriptions' => 'Descriptions','excerpts' => 'Excerpts','createpost' => 'Create Posts','miscellaneous' => 'Miscellaneous');
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
		$tabs_array = array ('defaultTab' => 'Rebuild Featured Images','clearitem' => 'Clear an Item','clearcache' => 'Clear Cache','remove_featured' => 'Remove Featured','reset' => 'Reset Defaults');
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
		  case '2003' :
			$tabs_end = array ('td' => 'TradeDoubler');
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
	   if($requestedPage == "appStore_sm_utilities" && $tab == "defaultTab") {
		   echo "<a class='nav-tab$class' href='?page=asa-rebuild-featuredimages'>$name</a>";
	   } else {
		   echo "<a class='nav-tab$class' href='?page=$requestedPage&tab=$tab'>$name</a>";
		}
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
	_e("Creating Post...",appStoreAssistant); echo "<br />";
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
	_e( "Caching App data...",appStoreAssistant); echo "<br />";

	$appData = appStore_get_data( $appID );
	_e( "Finding Default Featured Image...",appStoreAssistant); echo "<br />";

	$filename = $appData->imageFeatured_path;
	_e( "Saving Default Featured Image... $filename",appStoreAssistant); echo "<br />";
	$wp_filetype = wp_check_filetype(basename($filename), null ); 
	$wp_upload_dir = wp_upload_dir();
	if (!is_writable($wp_upload_dir['path'])) {
		echo 'Error: <b>'.$wp_upload_dir['path'].'</b> must be writable!!!';
		return;
	}
	
	$attachment = array(
		'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ), 
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => 'Featured Image '.$newPostID,
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
	//echo $url; //Debug
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
			$shortCodeStart = "[asa_item";
			$iCK = " checked";
			$entity = "software";
			break;
    	case "iOS":
			$Searchtype = __("All iOS Software",appStoreAssistant);
			$shortCodeStart = "[asa_item";
			$iOSCK = " checked";
			$entity = "software";
			break;
    	case "iPad":
			$Searchtype = __("iPad Software",appStoreAssistant);
			$shortCodeStart = "[asa_item";
			$iPCK = " checked";
			$entity = "iPadSoftware";
			break;
    	case "Mac":
			$Searchtype = __("Macintosh Software",appStoreAssistant);
			$shortCodeStart = "[asa_item";
			$entity = "macSoftware";
			$mCK = " checked";
			break;
		default:
			$Searchtype = __("iPhone/iPod Software",appStoreAssistant);
			$iCK = " checked";
			$shortCodeStart = "[asa_item";		
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
	
	$postContent = $postData->post_content;
	//$postContent = '[asa_item id="443987910" more_info_text="Read More..."]  ';
	
	$appOldIDs = preg_match_all('/_app\ id=\"([^\"]*?)\"/', $postContent, $appOld_matches);
	$appIDs = preg_match_all('/asa_item\ id=\"([^\"]*?)\"/', $postContent, $app_matches);
	$applinks = preg_match_all('/_app\ link=\"([^\"]*?)\"/', $postContent, $applink_matches);
	$iTunesIDs = preg_match_all('/itunes_store\ id=\"([^\"]*?)\"/', $postContent, $iTunes_matches);
	$amazonIDs = preg_match_all('/amazon_item\ asin=\"([^\"]*?)\"/', $postContent, $amazon_matches);
	//echo $postData->post_content."<br />";
	
	if(!$appIDs && !$amazonIDs && !$iTunesIDs && !$applinks && !$appOldIDs) {
		echo '<font color="red">Skipping</font>: '.__('No App IDs or Amazon ASINs found for post',appStoreAssistant).' ('.$newPostID.')<br />';
		//print_r($app_matches); //DEBUG
		echo "[$appIDs][".$postContent."]";
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

	if($appIDs || $iTunesIDs || $applinks || $appOldIDs) {
	
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
		if($appOldIDs) {
			$matchesToCheck = $appOld_matches;
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
		$filename = $app_data->imageFeatured_path;
		//echo "[[[[".print_r($app_data,true)."]]]]]";
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
		_e( "Featured Image Found",appStoreAssistant);
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
	$returnMessage = "Processing IDs<br />";
		
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

	$args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent' => null ); 
	$attachments = (array) get_posts( $args );

	foreach($attachments as $key => $attachmentData) {
		$postID = $attachmentData->ID;
		$validFI = FALSE;
		if(preg_match('/featured-image/i',$attachmentData->post_name,$matches)) $validFI = TRUE;
		if(preg_match('/appstoreassistant_cache/i',$attachmentData->guid,$matches)) $validFI = TRUE;
		if(preg_match('/asaArtwork_/i',$attachmentData->guid,$matches)) $validFI = TRUE;
		if(preg_match('/artworkUrl/i',$attachmentData->post_title,$matches)) $validFI = TRUE;
		if(preg_match('/artworkOriginal_/i',$attachmentData->post_title,$matches)) $validFI = TRUE;
		if(preg_match('/artworkUrl/i',$attachmentData->post_name,$matches)) $validFI = TRUE;
		
		if($validFI) {
			echo "DEBUG: [$key] VALID for Post ID:".$postID."<br />";
			if(wp_delete_post($postID)) {
				echo "[$key] Featured Imaged ID:$postID has been moved to trash.<br />";
			} else {
				echo "[$key] Error removing Featured Imaged ID:$postID!<br />";
			}
		} else {
			echo "DEBUG: [$key] NOT an ASA generated Featured Image (".$postID.")<br /> - - - - - ".$attachmentData->post_title."</ br> - - - - - ".$attachmentData->post_name."</ br>";
		}
	}
	return;

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





















// Rebuild Featured Images
class RebuildFeaturedImages {
	var $menu_id;

	// Plugin initialization
	function RebuildFeaturedImages() {
		add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );
		add_action( 'wp_ajax_rebuildfeatured', array( &$this, 'ajax_process_image' ) );
	}

	// Register the admin page
	function add_admin_menu() {
		add_submenu_page( 'appStore_sm_utilities', 'Rebuild ASA Featured Images', 'Rebuild Featured', 'manage_options', 'asa-rebuild-featuredimages', array(&$this, 'rebuildfi_interface'));
	}
	// The user interface plus thumbnail regenerator
	function rebuildfi_interface() {
		global $wpdb,$requestedPage;
		?>

		<div id="message" class="updated fade" style="display:none"></div>
		<div class="wrap regenthumbs">
		<?php
		echo '<!-- Display Plugin Icon, Header, and Description -->';
		echo '<div class="asa_admin_icon">';
		echo "<h2>AppStore Assistant $appStoreOptionsTitle</h2></div>";
		echo '<p>'.__('Below is a collection of controls you can use to customize the App Store Assistant plugin',appStoreAssistant).'.</p>';
		$requestedPage = 'appStore_sm_utilities';

		appStore_displayAdminTabs('appStore_sm_utilities','defaultTab','');


		// If the button was clicked
		if ( ! empty( $_POST['asa-rebuild-featuredimages'] ) || ! empty( $_REQUEST['ids'] ) ) {
			// Form nonce check
			check_admin_referer( 'asa-rebuild-featuredimages' );

			// Create the list of image IDs
			if ( ! empty( $_REQUEST['ids'] ) ) {
				$images = array_map( 'intval', explode( ',', trim( $_REQUEST['ids'], ',' ) ) );
				$ids = implode( ',', $images );
			} else {
				// Directly querying the database is normally frowned upon, but all
				// of the API functions will return the full post objects which will
				// suck up lots of memory. This is best, just not as future proof.
				if ( ! $images = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type = 'post' ORDER BY ID DESC" ) ) {
					echo '	<p>' . sprintf( __( "Unable to find any posts. Are you sure <a href='%s'>some exist</a>?", 'appStoreAssistant' ), admin_url( 'upload.php?post_mime_type=image' ) ) . "</p></div>";
					return;
				}

				// Generate the list of IDs
				$ids = array();
				foreach ( $images as $image )
					$ids[] = $image->ID;
				$ids = implode( ',', $ids );
			}

			echo '	<p>' . __( "Please be patient while the Featured Images for ASA Posts are rebuilt. This can take a while, depending on the speed of this server or if you have lots of posts. Do not navigate away from this page until the process is complete.", 'appStoreAssistant' ) . '</p>';

			$count = count( $images );

			$text_goback = ( ! empty( $_GET['goback'] ) ) ? sprintf( __( 'To go back to the previous page, <a href="%s">click here</a>.', 'appStoreAssistant' ), 'javascript:history.go(-1)' ) : '<br><br>'.sprintf( __( 'To Start Over and try rebuilding again <a href="%4$s">click here</a>. %5$s', 'appStoreAssistant' ), "' + rt_successes + '", "' + rt_totaltime + '", "' + rt_errors + '", esc_url( wp_nonce_url( admin_url( 'admin.php?page=asa-rebuild-featuredimages' ), 'asa-rebuild-featuredimages' ) ) . "' + rt_failedlist + '", $text_goback );;
			$text_failures = sprintf( __( 'All done! %1$s Featured Images were successfully created in %2$s seconds and there were %3$s posts that do not have ASA shortcodes. <br><br>If you think some of the posts that we did not find any ASA Shortcodes for really had them, then try rebuilding again by <a href="%4$s">clicking here</a>. This probably will not do anything, but you can try just incase of a network issue. %5$s', 'appStoreAssistant' ), "' + rt_successes + '", "' + rt_totaltime + '", "' + rt_errors + '", esc_url( wp_nonce_url( admin_url( 'admin.php?page=asa-rebuild-featuredimages' ), 'asa-rebuild-featuredimages' ) . '&ids=' ) . "' + rt_failedlist + '", $text_goback );
			$text_nofailures = sprintf( __( 'All done! %1$s Featured Images were successfully rebuild in %2$s seconds and there were 0 failures. %3$s', 'appStoreAssistant' ), "' + rt_successes + '", "' + rt_totaltime + '", $text_goback );
?>
	<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'appStoreAssistant' ) ?></em></p></noscript>

	<div id="rebuildfi-bar" style="position:relative;height:25px;">
		<div id="rebuildfi-bar-percent" style="position:absolute;left:50%;top:50%;width:300px;margin-left:-150px;height:25px;margin-top:-9px;font-weight:bold;text-align:center;"></div>
	</div>

	<p><input type="button" class="button hide-if-no-js" name="rebuildfi-stop" id="rebuildfi-stop" value="<?php _e( 'Abort Resizing Images', 'appStoreAssistant' ) ?>" /></p>

	<h3 class="title"><?php _e( 'Debugging Information', 'appStoreAssistant' ) ?></h3>

	<p>
		<?php printf( __( 'Total Posts: %s', 'appStoreAssistant' ), $count ); ?><br />
		<?php printf( __( 'Posts with Featured Images: %s', 'appStoreAssistant' ), '<span id="rebuildfi-debug-successcount">0</span>' ); ?><br />
		<?php printf( __( 'Posts without ASA shortcodes: %s', 'appStoreAssistant' ), '<span id="rebuildfi-debug-failurecount">0</span>' ); ?>
	</p>

	<ol id="rebuildfi-debuglist">
		<li style="display:none"></li>
	</ol>

	<script type="text/javascript">
	// <![CDATA[
		jQuery(document).ready(function($){
			var i;
			var rt_images = [<?php echo $ids; ?>];
			var rt_total = rt_images.length;
			var rt_count = 1;
			var rt_percent = 0;
			var rt_successes = 0;
			var rt_errors = 0;
			var rt_failedlist = '';
			var rt_resulttext = '';
			var rt_timestart = new Date().getTime();
			var rt_timeend = 0;
			var rt_totaltime = 0;
			var rt_continue = true;

			// Create the progress bar
			$("#rebuildfi-bar").progressbar();
			$("#rebuildfi-bar-percent").html( "0%" );

			// Stop button
			$("#rebuildfi-stop").click(function() {
				rt_continue = false;
				$('#rebuildfi-stop').val("<?php echo $this->esc_quotes( __( 'Stopping...', 'appStoreAssistant' ) ); ?>");
			});

			// Clear out the empty list element that's there for HTML validation purposes
			$("#rebuildfi-debuglist li").remove();

			// Called after each resize. Updates debug information and the progress bar.
			function RebuildFIUpdateStatus( id, success, response ) {
				$("#rebuildfi-bar").progressbar( "value", ( rt_count / rt_total ) * 100 );
				$("#rebuildfi-bar-percent").html( Math.round( ( rt_count / rt_total ) * 1000 ) / 10 + "%" );
				rt_count = rt_count + 1;

				if ( success ) {
					rt_successes = rt_successes + 1;
					$("#rebuildfi-debug-successcount").html(rt_successes);
					$("#rebuildfi-debuglist").append("<li>" + response.success + "</li>");
				}
				else {
					rt_errors = rt_errors + 1;
					rt_failedlist = rt_failedlist + ',' + id;
					$("#rebuildfi-debug-failurecount").html(rt_errors);
					$("#rebuildfi-debuglist").append("<li>" + response.error + "</li>");
				}
			}

			// Called when all images have been processed. Shows the results and cleans up.
			function RebuildFIFinishUp() {
				rt_timeend = new Date().getTime();
				rt_totaltime = Math.round( ( rt_timeend - rt_timestart ) / 1000 );

				$('#rebuildfi-stop').hide();

				if ( rt_errors > 0 ) {
					rt_resulttext = '<?php echo $text_failures; ?>';
				} else {
					rt_resulttext = '<?php echo $text_nofailures; ?>';
				}

				$("#message").html("<p><strong>" + rt_resulttext + "</strong></p>");
				$("#message").show();
			}

			// Regenerate a specified image via AJAX
			function RebuildFI( id ) {
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: { action: "rebuildfeatured", id: id },
					success: function( response ) {
						if ( response !== Object( response ) || ( typeof response.success === "undefined" && typeof response.error === "undefined" ) ) {
							response = new Object;
							response.success = false;
							response.error = "<?php printf( esc_js( __( 'The rebuild request was abnormally terminated (ID %s). This is likely due to the image exceeding available memory or some other type of fatal error.', 'appStoreAssistant' ) ), '" + id + "' ); ?>";
						}

						if ( response.success ) {
							RebuildFIUpdateStatus( id, true, response );
						}
						else {
							RebuildFIUpdateStatus( id, false, response );
						}

						if ( rt_images.length && rt_continue ) {
							RebuildFI( rt_images.shift() );
						}
						else {
							RebuildFIFinishUp();
						}
					},
					error: function( response ) {
						RebuildFIUpdateStatus( id, false, response );

						if ( rt_images.length && rt_continue ) {
							RebuildFI( rt_images.shift() );
						}
						else {
							RebuildFIFinishUp();
						}
					}
				});
			}

			RebuildFI( rt_images.shift() );
		});
	// ]]>
	</script>
<?php
		}

		// No button click? Display the form.
		else {
?>
	<form method="post" action="">
<?php wp_nonce_field('asa-rebuild-featuredimages') ?>

	<p><?php printf( __( "Use this utility to rebuild Featured Images for posts that have ASA Shortcodes. This is useful if you've changed of the Featured Image dimensions on the <a href='%s'> settings page</a>. Old thumbnails will be kept to avoid any broken images due to hard-coded URLs.", 'appStoreAssistant' ), admin_url( 'admin.php?page=appStore_sm_visual&tab=imagesizes' ) ); ?></p>

	<p><?php _e( "Featured Image rebuilding is NOT reversible, but you can just change your Featured Image dimensions back to the old values and then re-run this utility.", 'appStoreAssistant' ); ?></p>

<p>This feature will first check for any posts that use the <b>Mac App Store</b>, <b>iOS App Store</b> or <b>Amazon.com</b> shortcodes. It will then check for a Featured Image. If no image is assigned to that post it will then assign a Featured Image based on the icon or product image.</p>
<p>The size of the image can be set in the respective store's settings.</p>

<p class="asa_admin_warning">(Cache MUST be ENABLED for this function to work!. See <b><a href="<?php echo admin_url()."admin.php?page=appStore_sm_general&tab=miscellaneous"; ?>">General -> Miscellaneous section</a></b>.)</p>
	<p><?php _e( 'To begin, just press the button below.', 'appStoreAssistant '); ?></p>

	<p><input type="submit" class="button hide-if-no-js" name="asa-rebuild-featuredimages" id="asa-rebuild-featuredimages" value="<?php _e( 'Rebuild All Featured Images for Posts with ASA Shortcodes', 'appStoreAssistant' ) ?>" /></p>

	<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'appStoreAssistant' ) ?></em></p></noscript>

	</form>
<?php
		} // End if button
?>
</div>

<?php
	}


	// Process a single image ID (this is an AJAX handler)
	function ajax_process_image() {
		@error_reporting( 0 ); // Don't break the JSON result

		header( 'Content-type: application/json' );

		$id = (int) $_REQUEST['id'];
		$postData = get_post( $id );
		//if ( ! current_user_can( $this->capability ) )
			//$this->die_json_error_msg( $postData->ID, __( "Your user account doesn't have permission to process Featured Images.", 'appStoreAssistant' ) );		
		
		$postContent = $postData->post_content;
		$thePostName = $postData->post_title;

		if(has_post_thumbnail($id)) {
			$featuredImageURL = wp_get_attachment_url(get_post_thumbnail_id( $id ));
			if(preg_match('/appstoreassistant_cache|artworkOriginal|artworkUrl/',$featuredImageURL,$matches)) {
				if(delete_post_meta($id, '_thumbnail_id')) {
					//Featured Image Removed
				} else {
					die( json_encode( array( 'error' => sprintf( __( '<span class="errormsg">Error: Cannot remove old Featured Image for <b>"%s"</b> (%s)</span>', 'appStoreAssistant' ),$featuredImageURL,$id ) ) ) );
				}
			} else {
				die( json_encode( array( 'error' => sprintf( __( '<span class="passivemsg">Skipping: Already has non ASA Featured Image for <b>"%s"</b> (<a href="post.php?post=%s&action=edit">%s</a>)</span>', 'appStoreAssistant' ),$thePostName,$id,$id ) ) ) );
			}
		}
		
		
		
		$asaIDs = array();
		$amazonIDs = array();
		if(preg_match('/asa_item\ id="/i', $postContent, $matches) || preg_match('/_app\ id="/i', $postContent, $matches) || preg_match('/_app_elements\ id="/i', $postContent, $matches)|| preg_match('/itunes_store\ id="/i', $postContent, $matches)) {
			$pattern = '/id="([0-9]+)/i';
			preg_match($pattern, $postContent, $matches, PREG_OFFSET_CAPTURE, 5);
			$asaIDs[] = $matches[1][0];
		}
		if(preg_match('/amazon_item\ asin="/i', $postContent, $matches) || preg_match('/amazon_item_link\ asin="/i', $postContent, $matches) ) {
			$pattern = '/asin="([a-zA-Z0-9]+)/i';
			preg_match($pattern, $postContent, $matches, PREG_OFFSET_CAPTURE, 5);
			$amazonIDs[] = $matches[1][0];
		}
		if(preg_match('/asa_item\ link="/i', $postContent, $matches) || preg_match('/_app\ link="/i', $postContent, $matches)) {
			$pattern = '/id([0-9]+)/i';
			preg_match($pattern, $postContent, $matches, PREG_OFFSET_CAPTURE, 3);
			$asaIDs[] = $matches[1][0];
		}
		$idsFound = count($asaIDs) + count($amazonIDs);

		if($idsFound < 1 ) die( json_encode( array( 'error' => sprintf( __( '<span class="passivemsg">Skipping: No App IDs or Amazon ASINs found for post %s. (<a href="post.php?post=%s&action=edit">%s</a>)</span>', 'appStoreAssistant' ), esc_html( $thePostName ),$id,$id ) ) ) );
		@set_time_limit( 900 ); // 5 minutes per image should be PLENTY
		//Resizing goes here
		
		if(!$thePostName) die( json_encode( array( 'error' => sprintf( __( '<span class="errormsg">Skipping: No Post Title found for post ID (<a href="post.php?post=%s&action=edit">%s</a>)</span>', 'appStoreAssistant' ),$id,$id ) ) ) );
		
		//////DELETE OLD FEATURED IMAGES
		$logFile = CACHE_DIRECTORY."FI_Reset_Log.txt";
	
		
		if(count($asaIDs) > 0) { // Process asaIDs
			$appID = $asaIDs[0];
			$appData = appStore_get_data( $appID );
			//$filename = $appData->imageFeatured_path;
			// New code Starts here
			$thumb_url = $appData->imageFeatured_cached;
			$desc = 'Featured Image '.$id."-".date("U");
			//$logEntry .= "----Filename:$thumb_url\r\r";
			//$logEntry .= "----FileArray:".print_r($appData,true)."\r\r";
			//file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
			
			if ( ! empty($thumb_url) ) {
            	$tmp = download_url( $thumb_url );
				preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
				$file_array['name'] = "FI_".$appID."_".basename($thumb_url);
				$file_array['tmp_name'] = $tmp;
				if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
				}
				// do the validation and storage stuff
				$thumbid = media_handle_sideload( $file_array, $id, $desc );
				// If error storing permanently, unlink
				if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);
					die( json_encode( array( 'error' => sprintf( __( '<span class="errormsg">Error: storing permanently, unlink.</span>', 'appStoreAssistant' ),$wp_upload_dir['path'] ) ) ) );
				}
			}
        	set_post_thumbnail( $id, $thumbid );			
			die( json_encode( array( 'success' => sprintf( __( '<span class="successmsg">Updated Apple Featured Image for: "<b>%s</b>" (%s)</span>', 'appStoreAssistant' ), esc_html( $thePostName ),$id ) ) ) );
		}
		
		
		
		if(count($amazonIDs) > 0) { // Process amazonIDs
			$amazonItem = appStore_get_amazonData($amazonIDs[0]);
			// New code Starts here
			$thumb_url = $amazonItem['imageFeatured_cached'];
			$desc = 'Featured Image '.$id."-".date("U");
			$logEntry .= "----Filename:$thumb_url\r\r";
			$logEntry .= "----FileArray:".print_r($amazonItem,true)."\r\r";
			file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
			if ( ! empty($thumb_url) ) {
            	$tmp = download_url( $thumb_url );
				preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $thumb_url, $matches);
				$file_array['name'] = "FI_".$amazonIDs[0]."_".basename($thumb_url);
				$file_array['tmp_name'] = $tmp;
				if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
				}
				// do the validation and storage stuff
				$thumbid = media_handle_sideload( $file_array, $id, $desc );
				// If error storing permanently, unlink
				if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);
					die( json_encode( array( 'error' => sprintf( __( '<span class="errormsg">Error: storing permanently, unlink.</span>', 'appStoreAssistant' ),$wp_upload_dir['path'] ) ) ) );
				}
			}
        	set_post_thumbnail( $id, $thumbid );			
		
			die( json_encode( array( 'success' => sprintf( __( '<span class="successmsg">Updated Amazon Featured Image for: "<b>%s</b>" (%s)</span>', 'appStoreAssistant' ), esc_html( $amazonItem['Title'] ),$id ) ) ) );
		
		}

		die( json_encode( array( 'error' => sprintf( __( 'Test Code: %s. :%s', 'appStoreAssistant' ), esc_html( $postContent ),print_r($applinks[1],true) ) ) ) );
		/*
		if ( ! $image || 'attachment' != $image->post_type || 'image/' != substr( $image->post_mime_type, 0, 6 ) )
			die( json_encode( array( 'error' => sprintf( __( 'Failed resize: %s is an invalid image ID.', 'appStoreAssistant' ), esc_html( $_REQUEST['id'] ) ) ) ) );
		*/


		$fullsizepath = get_attached_file( $image->ID );

		if ( false === $fullsizepath || ! file_exists( $fullsizepath ) )
			$this->die_json_error_msg( $image->ID, sprintf( __( 'The originally uploaded image file cannot be found at %s', 'appStoreAssistant' ), '<code>' . esc_html( $fullsizepath ) . '</code>' ) );
		
		$thePostID = $image->ID;
		$thePostName = $image->post_content;
		
		
		
		//$metadata = wp_generate_attachment_metadata( $image->ID, $fullsizepath );
		$metadata = true;
		if ( is_wp_error( $metadata ) )
			$this->die_json_error_msg( $image->ID, $metadata->get_error_message() );
		if ( empty( $metadata ) )
			$this->die_json_error_msg( $image->ID, __( 'Unknown failure reason.', 'appStoreAssistant' ) );

		// If this fails, then it just means that nothing was changed (old value == new value)
		//wp_update_attachment_metadata( $image->ID, $metadata );

		die( json_encode( array( 'success' => sprintf( __( '&quot;%1$s&quot; (ID %2$s) was successfully resized in %3$s seconds.', 'appStoreAssistant' ), esc_html( $thePostName ), $image->ID, timer_stop() ) ) ) );
	}


	// Helper to make a JSON error message
	function die_json_error_msg( $id, $message ) {
		die( json_encode( array( 'error' => sprintf( __( '&quot;%1$s&quot; (ID %2$s) failed to resize. The error message was: %3$s', 'appStoreAssistant' ), esc_html( get_the_title( $id ) ), $id, $message ) ) ) );
	}


	// Helper function to escape quotes in strings for use in Javascript
	function esc_quotes( $string ) {
		return str_replace( '"', '\"', $string );
	}
}

// Start up this plugin
add_action( 'init', 'RebuildFeaturedImages' );
function RebuildFeaturedImages() {
	global $RebuildFeaturedImages;
	$RebuildFeaturedImages = new RebuildFeaturedImages();
}



?>
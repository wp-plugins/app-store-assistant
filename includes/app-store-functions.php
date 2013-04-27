<?php
function appStore_add_scripts() {
	wp_enqueue_script('lightbox', plugins_url('js_functions/lightbox/js/lightbox.js',ASA_MAIN_FILE), null, null, true);
}

function appStore_add_stylesheets() {
	wp_register_style('appStore-styles', plugins_url( 'css/appStore-styles.css', ASA_MAIN_FILE ));
	wp_enqueue_style( 'appStore-styles');
	wp_register_style('appStore-googlefont','http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600');
	wp_enqueue_style( 'appStore-googlefont');
	wp_register_style('lightbox-styles', plugins_url( 'js_functions/lightbox/css/lightbox.css', ASA_MAIN_FILE ));
	wp_enqueue_style( 'lightbox-styles');
}

function appStore_addLinkToFooter () {
	if (appStore_setting('displayLinkToFooter') != "no") {
		echo '<p style="padding-left: 20px;">Assisted by <a href="http://theiphoneappslist.com/index.php?v='.urlencode(plugin_get_version())."&ac=".urlencode(appStore_setting('affiliatepartnerid')).'&link='.urlencode(get_permalink()).'">App Store Assistant</a></p>';
    }
}

function appStore_admin_bar_render() {
	// Is the user sufficiently leveled, or has the bar been disabled?
	if (!is_super_admin() || !is_admin_bar_showing() )
		return;
 
	// Good to go, lets do this!
	add_action('admin_bar_menu', 'appStore_admin_bar_links', 500);
	//add_action('admin_bar_menu', 'appStore_remove_default_links', 500);
}

function appStore_admin_bar_links() {
	global $wp_admin_bar;
	
	// Links to add, in the form: 'Label' => 'URL'
	$links = array(
		'iPhone App Site' => 'http://theiphoneappslist.com/',
		'Mac App Site' => 'http://themacappslist.com/'
	);
	
	// Add the Parent link.
	$wp_admin_bar->add_menu( array(
		'title' => '+ New App Post',
		'href' => 'admin.php?page=appStore_IDsearch',
		'parent' => false
	));
	
	/**
	 * Add the submenu links.
	foreach ($links as $label => $url) {
		$wp_admin_bar->add_menu( array(
			'title' => $label,
			'href' => $url,
			'parent' => 'stats',
			'meta' => array('target' => '_blank') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
		));
	}
	 */

}

function asa_load_translation_file() {
	// relative path to WP_PLUGIN_DIR where the translation files will sit:
	$plugin_path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	load_plugin_textdomain( 'appStoreAssistant', false, $plugin_path );
}

function appStore_get_the_post_thumbnail( $post_id = null, $size = 'post-thumbnail', $attr = '' ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$size = apply_filters( 'post_thumbnail_size', $size );
	if ( $post_thumbnail_id ) {
		do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size ); // for "Just In Time" filtering of all of wp_get_attachment_image()'s filters
		if ( in_the_loop() )
			update_post_thumbnail_cache();
		$html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr );
		do_action( 'end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
	} else {
		$html = '';
	}
	
	$errorImage = plugins_url( 'images/CautionIcon.png' , ASA_MAIN_FILE );
	$html = '<img src="$errorImage" alt="FAKE THUMBNAIL 1" />';

	
	
	//$html = "<!-   HERE IT IS ->";
	return apply_filters( 'post_thumbnail_html', $html, $post_id, $post_thumbnail_id, $size, $attr );
}

function appStore_post_thumbnail_html( $html) {
	// was  appStore_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) 


	$errorImage = plugins_url( 'images/CautionIcon.png' , ASA_MAIN_FILE );
	$html = '<img src="'.$errorImage.'" alt="FAKE THUMBNAIL 2" />';
	return $html;
	/*
		echo "------------------------[BREAK POINT]------------------------------";

	if (appStore_setting('excerpt_generator')=="asa") {
		$appIconDesc = appStore_get_icon_desc();
		$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">';
		$html .= '<img src="'.$appIconDesc['appIcon_url'].'" alt="<# some text #>" />';	
		$html .= '</a>';
		return $html;
	} else {
	
		$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
		$post_thumbnail_id = get_post_thumbnail_id( $post_id );
		$size = apply_filters( 'post_thumbnail_size', $size );
		if ( $post_thumbnail_id ) {
			do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size ); // for "Just In Time" filtering of all of wp_get_attachment_image()'s filters
			if ( in_the_loop() )
				update_post_thumbnail_cache();
			$html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr );
			do_action( 'end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
		} else {
			$html = '';
		}
		return apply_filters( 'post_thumbnail_html', $html, $post_id, $post_thumbnail_id, $size, $attr );
	
	}
	*/
}

function appStore_get_icon_desc($shortcodeData) {

	switch ($shortcodeData['shortcode']) {
	case "ios_app":
		$id = $shortcodeData['atts']['id'];	
		if($id == "" || !is_numeric($id))return;	
		$app = appStore_get_data($id);
		$appFullDescription = $app->description;
		$appIcon_url = $app->artworkUrl60;
		break;
	case "amazon_item":
		$asin = $shortcodeData['atts']['asin'];	
		if($asin == "")return;	
		$amazonProduct = appStore_get_amazonData($asin);
		$appFullDescription = $amazonProduct['Description'];
		$appIcon_url = $amazonProduct['SmallImage'];
		break;
	case "mac_app":
		$id = $shortcodeData['atts']['id'];	
		if($id == "" || !is_numeric($id))return;	
		$app = appStore_get_data($id);
		$appFullDescription = $app->description;
		$appIcon_url = $app->artworkUrl60;
		break;
	case "itunes_store":
		$id = $shortcodeData['atts']['id'];	
		if($id == "" || !is_numeric($id))return;	
		$iTunesItem = appStore_get_data($id);
		$appFullDescription = $iTunesItem->longDescription;
		$appIcon_url = $iTunesItem->artworkUrl60;
		break;
	case "iTunes_list":
		$appFullDescription = __('A List of music from iTunes',appStoreAssistant);
		$appIcon_url = plugins_url( 'images/MusicList.png', ASA_MAIN_FILE );
		break;
	case "ios_app_list":
		$appFullDescription = __('A List of Apps',appStoreAssistant);
		$appIcon_url = plugins_url( 'images/Apps.jpg', ASA_MAIN_FILE );
		break;
	}

	$appData['appFullDescription'] = $appFullDescription;
	$appData['appIcon_url'] = $appIcon_url;
	return $appData;
}

function appStore_excerpt_filter($text, $excerpt="") {
	global $post;
	$originalPost = $post;
	$postContent = substr($post->post_content,1, 400);
	$originalExcerpt = esc_attr( get_post_field( 'post_excerpt', $post_id ) );
	$postTitle = esc_attr( get_post_field( 'post_title', $post_id ) );

	$shortcodeData = getShortcodeDataFromPost();	

	// Create More Info text
	if (appStore_setting('displayexcerptreadmore')=="yes") {
		$shortCodeMoreInfoText = $shortcodeData['atts']['more_info_text'];	
		if(!$shortCodeMoreInfoText == "") {
			$readMoreText = $shortCodeMoreInfoText;
		} else {
			$readMoreText = appStore_setting('excerpt_moreinfo_text');
		}
		$readMoreLink = ' <a href="'.esc_url( get_permalink() ).'">';
		$readMoreLink .= $readMoreText;
		$readMoreLink .= '</a>';
		if (appStore_setting('excerpt_moreinfo_link') == "button") {
			$readMoreLink = ''; // '<div style="clear:left;">&nbsp;</div>';
			$readMoreLink .= '<div class="appStore-moreinfo_button">';
			$readMoreLink .= '<a type="button" href="'.esc_url( get_permalink() ).'" value="App Store Buy Button" class="appStore-MoreInfoButton">';
			$readMoreLink .= $readMoreText.'</a></div>';
		}
	} else {
		$readMoreLink = "";
	}
	
	$appIconDesc = appStore_get_icon_desc($shortcodeData);

	if(appStore_setting('displayexcerptthumbnail')=="yes") {
		$displayIcon = '<a href="'.get_permalink( $post_id ).'" title="'.$postTitle.'">';
		$displayIcon .= '<img src="'.$appIconDesc['appIcon_url'].'" alt="'.$postTitle.'" width ="60" align="left" class="appStore_ThumbIcon" />';	
		$displayIcon .= '</a>';
	} else {
		$displayIcon ="";
	}

	if(strlen($originalExcerpt) >20 ) {
		$appShortDescription = $displayIcon.$originalExcerpt." ".$readMoreLink;
	} else {	
		//Get the App Data
		$appShortDescription = $displayIcon;
		$appShortDescription .= substr($appIconDesc['appFullDescription'],0, appStore_setting('excerpt_max_chars'));
		$appShortDescription .= '&hellip;'.$readMoreLink;
	}
	return $appShortDescription;
}

function getShortcodeDataFromPost(){
	global $post;
	$postContent = substr($post->post_content,1, 400);
	$shortcodes = array("ios_app", "itunes_store","ibooks_store","mac_app","amazon_item");
	foreach ($shortcodes as $shortcode) {
		if (stristr($postContent, $shortcode) !== FALSE) {
			$shortcodeData['shortcode'] = $shortcode;
		}
	}
	// Get Attributes
	$data = preg_match_all('/([a-zA-Z_]+)=\"([^\"]*?)\"/', $postContent, $matches);
	foreach ($matches[1] as $shortcodeKey=>$shortcode) {
		$shortcodeData['atts'][$shortcode] = $matches[2][$shortcodeKey];
	}
	/*
	example array:
			[shortcode] => ios_app
			[atts] => Array
				(
					[id] => 411784735
					[more_info_text] => More Info Text from Oscars post!!!...
				)
	*/
		
	return $shortcodeData;
}

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
   $plugin_array['asa_mce'] = plugins_url( 'js_functions/editor_plugin.js', ASA_MAIN_FILE );
   return $plugin_array;
}

function appStore_refresh_mce($ver) {
	$ver += 3;
	return $ver;
}

// ----- End of Add ASA buttons to TinyMCE
function appStore_css_hook() {

	$emptyStar = plugins_url( 'images/star-rating-'.appStore_setting('empty_star_color').'.png', ASA_MAIN_FILE );
	$fullStar = plugins_url( 'images/star-rating-'.appStore_setting('full_star_color').'.png', ASA_MAIN_FILE );
?>
 
<style type='text/css'>
/* This site uses App Store Assistant version <?php echo plugin_get_version()." - ".appStore_setting('affiliatepartnerid'); ?> */

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
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #<?php echo appStore_setting('color_buttonStart') ?>), color-stop(1, #<?php echo appStore_setting('color_buttonStop') ?>) );
	background:-moz-linear-gradient( center top, #<?php echo appStore_setting('color_buttonStart') ?> 5%, #<?php echo appStore_setting('color_buttonStop') ?> 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#<?php echo appStore_setting('color_buttonStart') ?>', endColorstr='#<?php echo appStore_setting('color_buttonStop') ?>');
	background-color:#<?php echo appStore_setting('color_buttonStart') ?>;
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


.appStore-MoreInfoButton {
	padding: 2px 10px 2px 10px;
	-moz-box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	-webkit-box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	box-shadow:inset 0px 1px 0px 0px #<?php echo appStore_setting('color_buttonShadow') ?>;
	<?php
	if(appStore_setting('hide_button_background') != "yes") { ?>
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #<?php echo appStore_setting('color_buttonStart') ?>), color-stop(1, #<?php echo appStore_setting('color_buttonStop') ?>) );
	background:-moz-linear-gradient( center top, #<?php echo appStore_setting('color_buttonStart') ?> 5%, #<?php echo appStore_setting('color_buttonStop') ?> 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#<?php echo appStore_setting('color_buttonStart') ?>', endColorstr='#<?php echo appStore_setting('color_buttonStop') ?>');
	background-color:#<?php echo appStore_setting('color_buttonStart') ?>;
	<?php } ?>
	-moz-border-radius:7px;
	-webkit-border-radius:7px;
	border-radius:7px;
	display:inline-block;
	color:#<?php echo appStore_setting('color_buttonText') ?>;
	font-family:Trebuchet MS;
	font-size:12px;
	font-weight:normal;
	text-decoration:none;
	text-shadow:1px 1px 0px #<?php echo appStore_setting('color_buttonTextShadow') ?>;
	margin-top: 4px;

}
.appStore-MoreInfoButton:hover {
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
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #<?php echo appStore_setting('color_buttonStart') ?>), color-stop(1, #<?php echo appStore_setting('color_buttonStop') ?>) );
	background:-moz-linear-gradient( center top, #<?php echo appStore_setting('color_buttonStart') ?> 5%, #<?php echo appStore_setting('color_buttonStop') ?> 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#<?php echo appStore_setting('color_buttonStart') ?>', endColorstr='#<?php echo appStore_setting('color_buttonStop') ?>');
	background-color:#<?php echo appStore_setting('color_buttonStart') ?>;
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
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( ASA_MAIN_FILE ) ) );
	$plugin_file = basename( ( ASA_MAIN_FILE ) );
	return $plugin_folder[$plugin_file]['Version'];
}

function format_price($unformattedPrice) {
	//Check to see if the app is free, or under a dollar
	if($unformattedPrice == 0) {
		$thePrice = __("Free!",appStoreAssistant);
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
		return __("This app is no longer available.")." (id:$id)";
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
		$appURL = '<a href="'.$appURL.'"';
		if(appStore_setting('open_links_externally') == "yes") $appURL .= ' target="_blank"';
		$appURL .= '>'.$text.'</a>';
		return $appURL;
	} else {
		return "Error Processing App ID: $id";
		//wp_die('No valid data for app id: ' . $id);
	}
}

function appStore_app_element_handler($atts,$content=null, $code="",$platform="ios_app") {
	GLOBAL $is_iphone;

	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'elements' => ''
	), $atts ) );
	$elements = preg_replace("/[^a-zA-Z,]+/", "", $elements);
	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;	

	//Get the App Data
	$app = appStore_get_data($id);

	$app->TheAppPrice = format_price($app->price);
	$app->appURL = getAffiliateURL($app->trackViewUrl);
	if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
		$app->buttonText = $app->TheAppPrice." ";
	} else {
		$app->buttonText = $app->TheAppPrice." - ".__("View in App Store",appStoreAssistant)." ";
	}
	$app->mode = $mode;
	$app->more_info_text = $more_info_text;
	$app->platform = $platform;
	$element = "";
	$appElements_available = explode(",","appName,appIcon,appDescription,appBadge,appDetails,appGCIcon,appScreenshots,appDeviceList,appBuyButton,appRating,appPrice,appBadgeSm,appReleaseNotes");
	if($app) {
			$appElements = explode(",", $elements);
			$appElements = array_filter($appElements, 'strlen');
			foreach($appElements as $appElement) {
			
				if (in_array($appElement, $appElements_available)) {
					$displayFunction = "displayAppStore_".$appElement;				
					$element .= " ".$displayFunction($app,true)." ";
				} else {
					$element = "<h1>Invalid Element attribute: $appElement </h1>";
				}
			}
			return $element;
	
	} else {
		return "Error Processing App ID: $id";
		//wp_die('No valid data for app id: ' . $id);
	}
}

function iTunesStore_link_handler( $atts,$content=null, $code="") {
	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'text' => ''
	), $atts ) );

	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;
	$iTunesItem = appStore_get_data($id);
	if($iTunesItem) {
	
		switch ($iTunesItem->wrapperType) {
			case "collection":
				$iTunesName = $iTunesItem->collectionName;
				$iTunesURL = getAffiliateURL($iTunesItem->collectionViewUrl);
				break;
			case "track":
				$iTunesName = $iTunesItem->trackName;
				$iTunesURL = getAffiliateURL($iTunesItem->trackViewUrl);
				break;
			case "audiobook":
				$iTunesName = $iTunesItem->collectionName;
				$iTunesURL = getAffiliateURL($iTunesItem->collectionViewUrl);
				break;
		}
		if ($text == '') $text = $iTunesName;
		$iTunesURL = '<a href="'.$iTunesURL.'" target="_blank">'.$text.'</a>';
		return $iTunesURL;
	} else {
		return "Error Processing iTunes ID: $id";
	}	
}

function iTunesStore_handler( $atts,$content=null, $code="" ) {
	// Get iTunes ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'more_info_text' => 'continued...'
	), $atts ) );
	
	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id)) return;	
	
	//Get the Music Data
	$iTunesItem = appStore_get_data($id);
	if($iTunesItem) {
		return iTunesStore_page_output($iTunesItem,$more_info_text,"internal",$code);
	} else {
		wp_die('No valid data for iTunes id: ' . $id);
	}
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
		_e("Missing list of IDs.",appStoreAssistant);
		return;
	}
	
	//echo "[$debug]";
	//if($debug=="true") echo "[$appID][".print_r($app)."]";
	
		$appIDs = explode(",",$ids);
		$AppListing = "";

	//Pair down array to number of apps preference
	array_splice($appIDs, appStore_setting('qty_of_apps'));
	
	//Load App data
	foreach($appIDs as $appID) {
	
		if($appID == "" || !is_numeric($appID)) return;
		$app = appStore_get_data($appID);
		if($app) {
			if(stristr($mode, 'itunes')) {
				$AppListing .= iTunesStore_page_output($app,$more_info_text,"list",$code);
			} else {
				$AppListing .= appStore_page_output($app,$more_info_text,"list",$code);
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
		'more_info_text' => __('open in The App Store...',appStoreAssistant)
	), $atts ) );
	if(empty($atomurl)) {
		_e( 'Missing atomurl in tag. Replace <strong>id</strong> with <strong>atomurl</strong>.',appStoreAssistant);
		return;
	}
	$mode = strtolower($mode);
	if ($mode == "itunes") {
		$platform = "itunes";
	} else {
		$platform = $mode.'_app';
	}
	
	$last = $atomurl[strlen($atomurl)-1];
	if($last != "/") $AddSlash = "/";
	$RSS_Feed = $atomurl.$AddSlash."xml";
	
	//Check to see if feed is available cached
	$appStore_feedID = "appStore_rssfeed_".hash('md2', $RSS_Feed);
	$appStore_feedOptions = get_option($appStore_feedID, '');		
	
	if($appStore_feedOptions == '' || $appStore_feedOptions['next_check'] < time()) {
		$STAT = "REBUILT CACHE";
		// Get Array of AppIDs for ATOM Feed
		$appIDs = appStore_getIDs_from_feed($RSS_Feed);
		$appStore_feedOptions = array('next_check' => time() + appStore_setting('cache_time_select_box'), 'feedURL' => $RSS_Feed, 'appIDs' => $appIDs);
		update_option($appStore_feedID, $appStore_feedOptions);
	} else {
		$STAT = "From CACHE";
		$appIDs = $appStore_feedOptions['appIDs'];
	}

	//Pair down array to number of apps preference
	array_splice($appIDs, appStore_setting('qty_of_apps'));

	//Load App data
	$appListDisplay = '';
	foreach($appIDs as $appID) {
		//$appListDisplay .= "<hr><<<<<<<[$appID]>>>>>>><br />";
		if($appID == "" || !is_numeric($appID)) return;
		$app = appStore_get_data($appID);
		if($app) {
			if(stristr($mode, 'itunes')) {
				$appListDisplay .= iTunesStore_page_output($app,$more_info_text,"list",$platform).'<hr>';
			} else {
				if(gettype($app) =="object") $appListDisplay .= appStore_page_output($app,$more_info_text,"list",$platform).'<hr>';
			}
		} else {
			$appListDisplay .= "Error Processing iTunes ID: $appID";
		}
	}
	return $appListDisplay; 
}

// ------------START OF MAIN FUNCTIONS-----------------
function iTunesStore_page_output($iTunesItem, $more_info_text,$mode="internal",$platform="itunes") {
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
	
	$artistType = __("Artist",appStoreAssistant);
	$cavType = __("Explicit",appStoreAssistant);
	$trackType = __("Track Count",appStoreAssistant);
	switch ($iTunesItem->kind) {
    	case "song":
			$artistType = __("Artist",appStoreAssistant);
			break;
    	case "feature-movie":
			$artistType = __("Director",appStoreAssistant);
 			$cavType = __("Rated",appStoreAssistant);
 			$description = $iTunesItem->longDescription;
			break;
    	case "tv-episode":
			$artistType = __("Series",appStoreAssistant);
 			$cavType = __("Rated",appStoreAssistant);
 			$description = $iTunesItem->longDescription;
			break;
	}

	switch ($iTunesItem->collectionType) {
    	case "TV Season":
			$trackType = __("Episodes",appStoreAssistant);
			$artistType = __("Series",appStoreAssistant);
 			$cavType = __("Rated",appStoreAssistant);
 			$description = $iTunesItem->longDescription;
			break;
	}
	
	$iTunesPrice = format_price($unformattedPrice);

	// iTunes Artwork
	$artwork_url = CACHE_DIRECTORY_URL.$iTunesItem->imagePosts;
	if($is_iphone) CACHE_DIRECTORY_URL.$iTunesItem->imageiOS;

	$iTunesURL = getAffiliateURL($iTunesURL);
	
	if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
		$buttonText = $iTunesPrice." ";
	} else {
		$buttonText = $iTunesPrice." - ".__("View in iTunes",appStoreAssistant);
	}

	
?>
<div class="appStore-wrapper">
	<hr>
	<div id="iTunesStore-icon-container">
		<a href="<?php echo $iTunesURL; ?>" ><img class="iTunesStore-icon" src="<?php echo $artwork_url; ?>" width="<?php echo $newImageWidth; ?>" height="<?php echo $newImageHeight; ?>" /></a>
		<div class="iTunesStore-purchase">
			<a type="button" href="<?php echo $iTunesURL; ?>" value="iTunes Buy Button" class="iTunesStore-Button BuyButton"><?PHP echo $buttonText; ?></a><br />
		</div>

	</div>
	<?php
	
	if ((appStore_setting('displayitunestitle') == "yes" AND !empty($iTunesName)) OR $mode != "internal") {
		echo '<span class="iTunesStore-title">'.$iTunesName.'</span><br />';
	}
	if (appStore_setting('displayitunestrackcount') == "yes" AND !empty($trackCount)) {
		echo '<span class="iTunesStore-trackcount">'.$trackType.': '.$trackCount.'</span><br />';
	}
	if (appStore_setting('displayitunesartistname') == "yes" AND !empty($artistName)) {
		echo '<span class="iTunesStore-artistname">'.$artistType.': '.$artistName.'</span><br />';
	}
	if (appStore_setting('displayfromalbum') == "yes" AND !empty($fromAlbum)) {
		echo '<span class="iTunesStore-fromalbum">'.__("From",appStoreAssistant).': '.$fromAlbum.'</span><br />';
	}
	if (appStore_setting('displayitunesgenre') == "yes" AND !empty($iTunesCategory)) {
		echo '<span class="iTunesStore-genre">'.__("Genre",appStoreAssistant).': '.$iTunesCategory.'</span><br />';
	}
	if (appStore_setting('displayadvisoryrating') == "yes" AND !empty($contentAdvisoryRating)) {
		echo '<span class="iTunesStore-advisoryrating">'.$cavType.': '.$contentAdvisoryRating.'</span><br />';
	}	
	if (appStore_setting('displayitunesreleasedate') == "yes" AND !empty($releaseDate)) {
		echo '<span class="iTunesStore-releasedate">'.__("Released",appStoreAssistant).': '.$releaseDate.'</span><br />';
	}

	if (appStore_setting('displayitunesexplicitwarning') == "yes" AND $isExplicit == "explicit") {
		echo '<span class="iTunesStore-explicitwarning"><img src="'.plugins_url( 'images/parental_advisory_explicit_content-big.gif' , ASA_MAIN_FILE ).'" width="112" height="67" alt="Explicit Lyrics" /></span><br />';// 450x268
	}
	if (appStore_setting('displayitunesdescription') == "yes" AND !empty($description)) {	
		echo '	<div class="iTunesStore-description">';
		echo nl2br($description);
		echo '<br /></div>';
	}
		echo '<br />';

		echo '<div class="appStore-badge"><a href="'.$iTunesURL.'" >';
		$badgeImage = 'images/Badges/';
		if(appStore_setting('iTunes_store_badge_type') == "download") {
			$badgeImage .= "Download_on_iTunes_Badge_";
		} else {
			$badgeImage .= "Available_on_iTunes_Badge_";
		}
		if(appStore_setting('store_badge_language')) {
			$badgeImage .= appStore_setting('store_badge_language');
		} else {
			$badgeImage .= "US-UK";
		}
		$badgeImage .= "_110x40.png";
		echo '<img src="'.plugins_url( $badgeImage , ASA_MAIN_FILE ).'" alt="App Store" style="border: 0;" /></a>';
		echo '</div>';
	 ?>
	<div style="clear:left;">&nbsp;</div>
</div>
<?php

	$return = ob_get_contents();
	ob_end_clean();	
	return $return;
}

function appStore_page_output($app, $more_info_text,$mode="internal",$platform="ios_app") {
	GLOBAL $is_iphone;	
	
	$app->TheAppPrice = format_price($app->price);
	$app->appURL = getAffiliateURL($app->trackViewUrl);
	if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
		$app->buttonText = $app->TheAppPrice." ";
	} else {
		$app->buttonText = $app->TheAppPrice." - ".__("View in App Store",appStoreAssistant)." ";
	}
	$app->mode = $mode;
	$app->more_info_text = $more_info_text;
	$app->platform = $platform;

	$appDetailsOrder = explode(",", appStore_setting('appDetailsOrder'));
	$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');

	$tagOutput = '<div class="appStore-wrapper">';
		foreach($appDetailsOrder as $appDetailOrder) {
			$displayFunction = "displayAppStore".substr($appDetailOrder, 14);
			$tagOutput .= $displayFunction($app);
		}
	$tagOutput .= '	</div><!-- END of appStore-wrapper -->';

	return $tagOutput;
}

function displayAppStore_appName ($app,$elementOnly=false) {

	if(!empty($app->trackName)) {
		if($elementOnly) {
			$element = $app->trackName;
			return $element;
		}
		if ($app->mode == "list" && appStore_setting('displayATOMapptitle') == "yes") {
			$element = '<h1>'.$app->trackName.'</h1>';
			return $element;
		}


		if ((is_single() && appStore_setting('displayapptitle') == "yes") || (!is_single() && appStore_setting('displaympapptitle') == "yes")) {
			$element = '<span class="appStore-title">'.$app->trackName.'</span><br />';
			return $element;
		}
	}
}

function displayAppStore_appScreenshots($app,$elementOnly=false) {
	$appIDcode = $app->trackId;
		$element = '';
		// Display iPhone Screenshots
		if((is_single() && appStore_setting('displayscreenshots') == "yes") || $elementOnly || (!is_single() && appStore_setting('displaympscreenshots') == "yes") || ($app->mode == "list" && appStore_setting('displayATOMscreenshots') == "yes")) {
			if(count($app->screenshotUrls) > 0) {
				if (!$elementOnly) $element .= '	<div class="appStore-screenshots-iphone">';
				$element .= '		<h2>';
				if($app->platform=="mac_app") $element .= __("Mac",appStoreAssistant);
				if($app->platform=="ios_app") $element .= __("iPhone",appStoreAssistant);
				$element .= ' '.__("Screenshots",appStoreAssistant);
				$element .= ':</h2>';
				$element .= '		<ul class="appStore-screenshots">';
				foreach($app->screenshotUrls as $ssurl) {
	
					$element .= '<li class="appStore-screenshot"><a href="';
					$element .= CACHE_DIRECTORY_URL.$ssurl . '" rel="lightbox['.$appIDcode.']"><img src="';
					$element .= CACHE_DIRECTORY_URL.$ssurl . '" width="' . appStore_setting('ss_size') . '" alt="Screenshot" /></a></li>';
				}
				$element .= '		</ul>';
				if (!$elementOnly) $element .= '</div>	<div style="clear:left;">&nbsp;</div>';
			}

			// Display iPad Screenshots
			if(count($app->ipadScreenshotUrls) > 0) {

				if (!$elementOnly) $element .= '	<div class="appStore-screenshots-iPad">';
				$element .= '		<h2>'.__("iPad",appStoreAssistant).' '.__("Screenshots",appStoreAssistant).':</h2>';
				$element .= '		<ul class="appStore-screenshots">';
				foreach($app->ipadScreenshotUrls as $ssurl) {	
	
					$element .= '<li class="appStore-screenshot"><a href="';
					$element .= CACHE_DIRECTORY_URL.$ssurl . '" rel="lightbox['.$appIDcode.'iPad]"><img src="';
					$element .= CACHE_DIRECTORY_URL.$ssurl . '" width="' . appStore_setting('ss_size') . '" alt="Screenshot" /></a></li>';
				}
				$element .= '		</ul>';
				if (!$elementOnly) $element .= '</div>';
			}
		}
		//if (!$elementOnly) $element .= '	<div style="clear:left;">&nbsp;</div>';
		return $element;
}

function displayAppStore_appBadge($app,$elementOnly=false) {
	if((is_single() && appStore_setting('displayappbadge') == "yes") || (!is_single() && appStore_setting('displaympappbadge') == "yes") || ($app->mode == "list" && appStore_setting('displayATOMappbadge') == "yes")) $showBadge = true;
	
	
	// Create URL
	$appLink = '<a href="'.$app->appURL.'"';
	if(appStore_setting('open_links_externally') == "yes") $appLink .= ' target="_blank"';
	$appLink .= '>';

	// Create Badge img Tag
	$badgeImage = 'images/Badges/';
	if(appStore_setting('appStore_store_badge_type') == "download") {
		$badgeImage .= "Download_on_the_";
	} else {
		$badgeImage .= "Available_on_the_";
	}
	if($app->platform=="mac_app") $badgeImage .= "Mac_App_Store_Badge_";
	if($app->platform=="ios_app") $badgeImage .= "App_Store_Badge_";

	if(appStore_setting('store_badge_language')) {
		$badgeImage .= appStore_setting('store_badge_language');
	} else {
		$badgeImage .= "US-UK";
	}
	if($app->platform=="mac_app") $badgeImage .= "_165x40.png";
	if($app->platform=="ios_app") $badgeImage .= "_135x40.png";
	$badgeImgTag = '<img src="'.plugins_url( $badgeImage , ASA_MAIN_FILE ).'" alt="App Store" style="border: 0;" />';

	if($elementOnly) {
		$element = $appLink.$badgeImgTag.'</a>';
		return $element;
	}
	
	if ($showBadge){
		$element = '<div class="appStore-badge">'.$appLink.$badgeImgTag.'</a></div>';
		return $element;
	}
	return '';
}

function displayAppStore_appBadgeSm($app,$elementOnly=false) {
	if((is_single() && appStore_setting('displayappbadge') == "yes") || (!is_single() && appStore_setting('displaympappbadge') == "yes") || ($app->mode == "list" && appStore_setting('displayATOMappbadge') == "yes")) $showBadge = true;

	$appLink = '<a href="'.$app->appURL.'"';
	if(appStore_setting('open_links_externally') == "yes") $appLink .= ' target="_blank"';
	$appLink .= '>';
	$badgeImage = 'images/Badges/badge_appstore-sm.gif';
	$badgeImgTag = '<img src="'.plugins_url( $badgeImage , ASA_MAIN_FILE ).'" width="61" height="15" alt="App Store" style="border: 0;" /></a>';

	if($elementOnly) {
		$element =  $appLink.$badgeImgTag;
		return $element;
	}

	if ($showBadge) {
		$element = '<div class="appStore-badge">'.$appLink.$badgeImgTag.'</div>';
		return $element;	
	}
	return '';
}

function displayAppStore_appDescription($app,$elementOnly=false) {
	$smallDescription = shortenDescription($app->description);
	if($elementOnly) {
		$element = nl2br($app->description);
		return $element;
	}
	
	$ReadMore_Button_fullDesc = '<div class="appStore-FullDescButton">';
	$ReadMore_Button_fullDesc .= '<a type="button" href="'.get_permalink().'" value="App Store Buy Button" class="appStore-Button FullDescriptionButton">';
	$ReadMore_Button_fullDesc .= appStore_setting('shortDesc_fullDesc_text').'</a></div>';
	
	$ReadMore_Button_screenshot = '<div class="appStore-FullDescButton">';
	$ReadMore_Button_screenshot .= '<a type="button" href="'.get_permalink().'" value="App Store Buy Button" class="appStore-Button FullDescriptionButton">';
	$ReadMore_Button_screenshot .= appStore_setting('shortDesc_screenshot_text').'</a></div>';
	
	$ReadMore_Link_fullDesc = ' - <a href="'.get_permalink().'" value="">'.appStore_setting('shortDesc_fullDesc_text').'</a>';
	$ReadMore_Link_screenshot = ' - <a href="'.get_permalink().'" value="">'.appStore_setting('shortDesc_screenshot_text').'</a>';
	
	
	if ($app->mode == "list") {
		if (appStore_setting('use_shortDesc_on_atomfeed') == "yes") {
			$element .= nl2br($smallDescription);
		} else {
			$element .= nl2br($app->description);
		}
		return $element;
	}
	
	if (is_single() && appStore_setting('displayappdescription') == "yes") {
		$element = '	<div class="appStore-description">'."\r";
		if (appStore_setting('use_shortDesc_on_single') == "yes") {
			$element .= nl2br($smallDescription);
		} else {
			$element .= nl2br($app->description);
		}
		$element .= '<br />';
		$element .= '  </div>';
		$element .= '	<div style="clear:left;">&nbsp;</div>';
		return $element;
	} elseif (appStore_setting('displaympappdescription') == "yes") {
		$element = '	<div class="appStore-description">'."\r";
		if (appStore_setting('use_shortDesc_on_multiple') == "yes") {
			$element .= nl2br($smallDescription);
			if (appStore_setting('shortDesc_link') == "text") $element .= $ReadMore_Link_fullDesc;
		} else {
			$element .= nl2br($app->description);
			if (appStore_setting('shortDesc_link') == "text") $element .= $ReadMore_Link_screenshot;		
		}
		if($app->mode=="internal") {
			if (appStore_setting('shortDesc_link') == "button") {
				$element .= $ReadMore_Button_fullDesc;
			} else {
				$element .= ' '.__('or',appStoreAssistant).' <a href="'.$app->appURL.'" value="">'.$app->more_info_text.'</a>';		
			}
		}
		$element .= '  </div>';
		$element .= '	<div style="clear:left;">&nbsp;</div>';
		return $element;
	}		
}

function displayAppStore_appReleaseNotes($app,$elementOnly=false) {
	if(!empty($app->releaseNotes)) {
		$releaseNotes = nl2br($app->releaseNotes);
		if($elementOnly) return $releaseNotes;
	
		if ((is_single() && appStore_setting('displayappreleasenotes') == "yes") || (!is_single() && appStore_setting('displaympappreleasenotes') == "yes") || ($app->mode == "list" && appStore_setting('displayATOMappreleasenotes') == "yes")) {
			$element = '	<div class="appStore-description">'."\r";
			$element .= '<b>'.__('Release notes',appStoreAssistant).':</b><br />';
			$element .= $releaseNotes;
			$element .= '<br />';
			$element .= '  </div>';
			return $element;
		}
	}
}

function displayAppStore_appBuyButton($app,$elementOnly=false) {
	if(	(is_single() && appStore_setting('displayappbuybutton') == "yes") ||
		(!is_single() && appStore_setting('displaympappbuybutton') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMappbuybutton') == "yes")) $showButton = true;

	$appLink = '<a type="button" href="'.$app->appURL.'" value="App Store Buy Button" class="appStore-Button BuyButton"';
	if(appStore_setting('open_links_externally') == "yes") $appLink .= ' target="_blank"';
	$appLink .= '>'.$app->TheAppPrice;
	$appLink .= ' - '.__("View in App Store",appStoreAssistant);
	$appLink .= '</a>';
 
	if($elementOnly) {
		$element = $appLink;
		return $element;
	}

	if ($showButton) {
		$element = '	<div class="appStore-purchase-center">';
		$element .= $appLink.'<br />';
		$element .= '	</div>';
		return $element;
	
	}
}

function displayAppStore_appPrice($app,$elementOnly=false) {
		$element = $app->TheAppPrice;
		return $element;
}

function displayAppStore_appDeviceList($app,$elementOnly=false){
	if(	(is_single() && appStore_setting('displaysupporteddevices') == "yes") ||
		(!is_single() && appStore_setting('displaympsupporteddevices') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMsupporteddevices') == "yes")) $showsupporteddevices = true;
	if(	(is_single() && appStore_setting('displaysupporteddevicesMinimal') == "yes") ||
		(!is_single() && appStore_setting('displaympsupporteddevicesMinimal') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMsupporteddevicesMinimal') == "yes")) $showsupporteddevicesMinimal = true;
	if(	(is_single() && appStore_setting('displaysupporteddeviceIcons') == "yes") ||
		(!is_single() && appStore_setting('displaympsupporteddeviceIcons') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMsupporteddeviceIcons') == "yes")) $showsupporteddeviceIcons = true;

	$iDevices = array(	"all" => array ("name" => "All iOS Devices", "icon" => "all"),
						"iPadWifi" => array ("name" => "iPad Wifi", "icon" => "iPadWifi"),
						"iPad2Wifi" => array ("name" => "iPad 2 WiFi", "icon" => "iPad2Wifi"),
						"iPad23G" => array ("name" => "iPad 2 3G", "icon" => "iPad23G"),
						"iPadThirdGen" => array ("name" => "iPad 3", "icon" => "iPadThirdGen"),
						"iPadThirdGen4G" => array ("name" => "iPad 3 4G", "icon" => "iPadThirdGen4G"),
						"iPadFourthGen" => array ("name" => "iPad 4", "icon" => "iPadFourthGen"),
						"iPadFourthGen4G" => array ("name" => "iPad 4 4G", "icon" => "iPadFourthGen4G"),
						"iPadMini" => array ("name" => "iPad mini", "icon" => "iPadMini"),
						"iPadMini4G" => array ("name" => "iPad mini 4G", "icon" => "iPadMini4G"),
						"iPhone-3G" => array ("name" => "iPad 3G", "icon" => "iPhone-3G"),
						"iPhone-3GS" => array ("name" => "iPad 3GS", "icon" => "iPhone-3GS"),
						"iPhone4" => array ("name" => "iPhone 4", "icon" => "iPhone4"),
						"iPhone4S" => array ("name" => "iPhone 4S", "icon" => "iPhone4S"),
						"iPhone5" => array ("name" => "iPhone 5", "icon" => "iPhone5"),
						"iPhone5S" => array ("name" => "iPhone 5S", "icon" => "NewDevice"),
						"iPhone6" => array ("name" => "iPhone 5", "icon" => "NewDevice"),
						"iPhone6S" => array ("name" => "iPhone 5S", "icon" => "NewDevice"),
						"iPodTouchourthGen" => array ("name" => "iPod Touch 4th Gen", "icon" => "iPodTouchourthGen"),
						"iPodTouchFifthGen" => array ("name" => "iPod Touch 5th Gen", "icon" => "iPodTouchFifthGen")
						);
	// print_r($iDevices);
	if (is_array($app->supportedDevices)) {
		$SupportedDevices = $app->supportedDevices;
		$allDevices = appStore_substr_in_array("all", $SupportedDevices);
		foreach ($iDevices as $iDevice => $iDeviceDetail):
			if(in_array($iDevice, $SupportedDevices)) {
				$iDeviceList[] = $iDeviceDetail['name'];
				$iDeviceListIcons[] = $iDeviceDetail['icon'];
				
			}
		endforeach;
		$element = ''; 

		if (!$elementOnly && ($showsupporteddeviceIcons || $showsupporteddevicesMinimal)) {
			$element .= '	<div class="supporteddevices">';
			$element .= '		<h2>';
			$element .= ' '.__("Supported Devices",appStoreAssistant);
			$element .= '		</h2>';
		}

		if ($showsupporteddevices) {
			$element .= '<span class="appStore-supporteddevices">';
			$element .= __('Supported Devices',appStoreAssistant).': ';
			$element .=  implode(", ", $iDeviceList);
			//$element .=  implode(", ", $SupportedDevices);
			$element .= "</span><br />";
		}

		if ($showsupporteddevicesMinimal) {
			if (appStore_substr_in_array("iPad", $SupportedDevices) || $allDevices) {
				$element .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPad.png' , ASA_MAIN_FILE ).'" height="82" width="56" alt="iPad" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
			if (appStore_substr_in_array("iPadMini", $SupportedDevices) || $allDevices) {
				$element .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPadmini.png' , ASA_MAIN_FILE ).'" height="82" width="39" alt="iPad mini" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
			if (appStore_substr_in_array("iPhone", $SupportedDevices) || $allDevices) {
				$element .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPhone.png' , ASA_MAIN_FILE ).'" height="82" width="23" alt="iPhone" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
			if (appStore_substr_in_array("iPodTouch", $SupportedDevices) || $allDevices) {
				$element .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPod.png' , ASA_MAIN_FILE ).'" height="82" width="23" alt="iPod" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
		}

		if ($showsupporteddeviceIcons) {
			$element .= '<br />';
			switch (appStore_setting('displayappdetailsasliststyle')) {
			case "color":
				$list_icon_folder = "iDevices";
				$list_icon_height = "64";
				break;
			default:
				$list_icon_folder = "iDevicesBW";
				$list_icon_height = "82";
				break;
			}
			foreach ($iDeviceListIcons as $iDeviceIcon):
				$element .= '<img src="'.plugins_url( 'images/'.$list_icon_folder.'/'.$iDeviceIcon.'.png' , ASA_MAIN_FILE ).'" height="'.$list_icon_height.'" alt="'.$iDeviceIcon.'" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';					
			endforeach;
		}
		if (!$elementOnly && ($showsupporteddeviceIcons || $showsupporteddevicesMinimal)) $element .= '	</div>';

		return $element;
	}
}

function appStore_substr_in_array($needle,$haystack){
 
  $found = ARRAY();
 
	// cast to array 
    $needle = (ARRAY) $needle;
 
    // map with preg_quote 
    $needle = ARRAY_MAP('preg_quote', $needle);
 
    // loop over  array to get the search pattern 
    FOREACH ($needle AS $pattern)
    {
        IF (COUNT($found = PREG_GREP("/$pattern/", $haystack)) > 0) {
        	RETURN $found;
        }
    }
 
    // if not found 
    RETURN FALSE;
}

function displayAppStore_appDetails($app,$elementOnly=false) {

	if(	(is_single() && appStore_setting('displayversion') == "yes") ||
		(!is_single() && appStore_setting('displaympversion') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMversion') == "yes")) $showversion = true;
	if(	(is_single() && appStore_setting('displaydevelopername') == "yes") ||
		(!is_single() && appStore_setting('displaympdevelopername') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMdevelopername') == "yes")) $showdevelopername = true;
	if(	(is_single() && appStore_setting('displaysellername') == "yes") ||
		(!is_single() && appStore_setting('displaympsellername') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMsellername') == "yes")) $showsellername = true;
	if(	(is_single() && appStore_setting('displayreleasedate') == "yes") ||
		(!is_single() && appStore_setting('displaympreleasedate') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMreleasedate') == "yes")) $showreleasedate = true;
	if(	(is_single() && appStore_setting('displayfilesize') == "yes") ||
		(!is_single() && appStore_setting('displaympfilesize') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMfilesize') == "yes")) $showfilesize = true;
	if(	(is_single() && appStore_setting('displayuniversal') == "yes") ||
		(!is_single() && appStore_setting('displaympuniversal') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMuniversal') == "yes")) $showuniversal = true;
	if(	(is_single() && appStore_setting('displayadvisoryrating') == "yes") ||
		(!is_single() && appStore_setting('displaympadvisoryrating') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMadvisoryrating') == "yes")) $showadvisoryrating = true;
	if(	(is_single() && appStore_setting('displaycategories') == "yes") ||
		(!is_single() && appStore_setting('displaympcategories') == "yes") ||
		($app->mode == "list" && appStore_setting('displayATOMcategories') == "yes")) $showcategories = true;

	//App Category
	$appCategory = $app->genres;
	$appCategoryPrime = $app->primaryGenreName;
	$appCategoryList = implode(', ', $appCategory);
	$AppFeatures = $app->features;
	$element = ''; 
	if (!$elementOnly) $element .= '<div class="appStore-addDetails">'."\r";
	$element .=  '<ul class="appStore-addDetails">'."\r";
	
	if ($showversion AND !empty($app->version)) {
		$element .=  '<li class="appStore-version">'.__("Version",appStoreAssistant).': '.$app->version.'</li>'."\r";
	}
	
	if ($app->artistName == $app->sellerName) {
		if (($showdevelopername OR $showsellername) AND !empty($app->artistName)) {
			$element .=  '<li class="appStore-developername">'.__("Created & Sold by",appStoreAssistant).': '.$app->artistName.'</li>'."\r";
		}
	} else {
		if ($showdevelopername AND !empty($app->artistName)) {
			$element .=  '<li class="appStore-developername">'.__("Created by",appStoreAssistant).': '.$app->artistName.'</li>'."\r";
		}
		if ($showsellername AND !empty($app->sellerName)) {
			$element .=  '<li class="appStore-sellername">'.__("Sold by",appStoreAssistant).': '.$app->sellerName.'</li>'."\r";
		}
	}
	
	if ($showreleasedate AND !empty($app->releaseDate)) {
		$element .=  '<li class="appStore-releasedate">'.__("Released",appStoreAssistant).': '.date( 'F j, Y', strtotime($app->releaseDate) ).'</li>'."\r";
	}
	if ($showfilesize AND !empty($app->fileSizeBytes)) {
		$element .=  '<li class="appStore-filesize">'.__("File Size",appStoreAssistant).': '.filesizeinfo($app->fileSizeBytes).'</li>'."\r";
	}
	if ($showuniversal AND $AppFeatures[0] == "iosUniversal") {
		$element .=  '<li class="appStore-universal"><img src="'.plugins_url( 'images/fat-binary-badge-web.png' , ASA_MAIN_FILE ).'" width="14" height="14" alt="universal" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" /> '.__("This app is designed for both iPhone and iPad",appStoreAssistant).'</li>'."\r";
	}

	if ($showadvisoryrating AND !empty($app->contentAdvisoryRating)) {
		$element .=  '<li class="appStore-advisoryrating">'.__("Age Rating",appStoreAssistant).': '.$app->contentAdvisoryRating.'</li>'."\r";
	}
	if ($showcategories AND !empty($appCategory)) {
		$wordForCategories = sprintf( _n('Category', 'Categories', count($appCategory), appStoreAssistant), count($appCategory) );
		$element .=  '<li class="appStore-categories">'.$wordForCategories.": ";
		if(count($appCategory) == 1) {
			$element .=  $appCategory[0];
		} elseif (count($appCategory) > 1) {
			$element .=  $appCategoryList;
		}
		$element .=  '</li>'."\r";
	}
	 $element .=  '</ul>';
	 if (!$elementOnly) $element .=  '</div>';
	 return $element;

}

function displayAppStore_appGCIcon($app,$elementOnly=false){
	if($app->isGameCenterEnabled == 1) {
		if ((is_single() && appStore_setting('displaygamecenterenabled') == "yes") || $elementOnly || (!is_single() && appStore_setting('displaympgamecenterenabled') == "yes") || ($app->mode == "list" && appStore_setting('displayATOMgamecenterenabled') == "yes")) {
			$element = '<img src="'.plugins_url( 'images/gamecenter.jpg' , ASA_MAIN_FILE ).'" width="88" height="92" alt="gamecenter" />';
		}
	}

	return $element;
}

function displayAppStore_appRating($app,$elementOnly=false) {
	$averageRating = $app->averageUserRating;
	$ratingCount = $app->userRatingCount;
	//App Rating
	if ($app->averageUserRating > 0 && $app->averageUserRating <=10) {
		$appRating = $app->averageUserRating * 20;
	}else {
		$appRating = 0;
	}
	if(isset($ratingCount)) {
		if((is_single() && appStore_setting('displaystarrating') == "yes") || $elementOnly || (!is_single() && appStore_setting('displaympstarrating') == "yes") || ($app->mode == "list" && appStore_setting('displayATOMstarrating') == "yes")) {
			$element = '<div class="appStore-rating">';
			$element .= '	<span class="appStore-rating_bar" title="Rating '.$averageRating.' stars">';
			$element .= '	<span style="width:'.$appRating.'%"></span>';
			$string = sprintf( __('by %d users', appStoreAssistant), $ratingCount );
			$element .= "	</span> $string.";
			$element .= '</div>';
		}
	}
	return $element;
}

function displayAppStore_appIcon ($app,$elementOnly=false){
	GLOBAL $is_iphone;
	
	// App Artwork
	$artwork_url_start = CACHE_DIRECTORY_URL;
	
	if($elementOnly) {
		$imageTag = $app->imageElements;
		if($is_iphone) $imageTag = $app->imageiOS;
		$element = '<a href="'.$app->appURL.'" target="_blank"><img class="appStore-icon" src="'.$artwork_url_start.$imageTag.'" alt="'.$app->trackName.'" /></a>';
		return $element;
	}
	
	
	if ($app->mode == "list" && appStore_setting('displayATOMappicon') == "yes") {
		$imageTag = $app->imageLists;
		if($is_iphone) $imageTag = $app->imageiOS;

		$element = '<div id="appStore-icon-container">';
		$element .= '<a href="'.$app->appURL.'" target="_blank"><img src="'.$artwork_url_start.$imageTag.'"  alt="'.$app->trackName.'" /></a><br />';
		if (appStore_setting('displayATOMappiconbuybutton') == "yes") {
			$element .= '	<div class="appStore-purchase-center">';
			$element .= '	<a type="button" href="'.$app->appURL.'" value="App Store Buy Button" class="appStore-Button BuyButton" target="_blank">'.$app->TheAppPrice.'</a><br />';
			$element .= '	</div>';
		}
		$element .= '</div>';
	}
	
	if ((is_single() && appStore_setting('displayappicon') == "yes") || (!is_single() && appStore_setting('displaympappicon') == "yes")) {
		$imageTag = $app->imagePosts;;
		if($is_iphone) $imageTag = $app->imageiOS;
		$element = '<div id="appStore-icon-container">';
		$element .= '<a href="'.$app->appURL.'" target="_blank">';
		$element .= '<img src="'.$artwork_url_start.$imageTag.'" />';
		$element .= '</a>';
		if ((is_single() && appStore_setting('displayappiconbuybutton') == "yes") || (!is_single() && appStore_setting('displaympappiconbuybutton') == "yes")) {
			$element .= '<br /><a type="button" href="'.$app->appURL.'" value="App Store Buy Button" class="appStore-Button BuyButton" target="_blank">';
			$element .= ''.$app->TheAppPrice.'</a>';
		}
		$element .= '';
		$element .= '</div>';
	}
	return $element;
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
		
		if(!is_array($appStore_options_data) && !is_object($appStore_options_data)) return false;

		if(appStore_setting('cache_images_locally') == '1') {
			$appStore_options_data = appStore_save_images_locally($appStore_options_data);
		}
		
		$appStore_options = array('next_check' => time() + appStore_setting('cache_time_select_box'), 'app_data' => $appStore_options_data);
		update_option('appStore_appData_' . $id, $appStore_options);
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
function appStore_getBestIcon($appID) {
	$filename = false;
	$firstChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl512.png";
	$secondChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl512.jpg";
	$thirdChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl100.png";
	$fourthChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl100.jpg";
	$fifthChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl60.png";
	$sixthChoice = CACHE_DIRECTORY."AppStore/".$appID."/artworkUrl60.jpg";
	$lastChoice = dirname( plugin_basename( __FILE__ ) )."/images/CautionIcon.png";

	if (file_exists($firstChoice)) {
		$filename = $firstChoice;
	} elseif(file_exists($secondChoice)) {
		$filename = $secondChoice;
	} elseif(file_exists($thirdChoice)) {
		$filename = $thirdChoice;
	} elseif(file_exists($fourthChoice)) {
		$filename = $fourthChoice;
	} elseif(file_exists($fifthChoice)) {
		$filename = $fifthChoice;
	} elseif(file_exists($sixthChoice)) {
		$filename = $sixthChoice;
	} elseif(file_exists($lastChoice)) {
		$filename = $lastChoice;
	}
	return $filename;
}

function appStore_save_images_locally($app) {
	$appID = $app->trackId;

	if($app->wrapperType == "audiobook") $appID = $app->collectionId;
	if($app->wrapperType == "collection") $appID = $app->collectionId;

	if(!is_writeable(CACHE_DIRECTORY)) {
		//Uploads dir isn't writeable. bummer.
		appStore_set_setting('cache_images_locally', '0');
		return;
	} else {
		//Loop through screenshots and the app icons and cache everything
		if(!is_dir(CACHE_DIRECTORY."AppStore/" . $appID)) {
			if(!mkdir(CACHE_DIRECTORY."AppStore/" . $appID, 0755, true)) {
				appStore_set_setting('cache_images_locally', '0');
				return;	
			}
		}
		$urls_to_cache = array();
		if($app->artworkUrl30) $urls_to_cache['artworkUrl30'] = $app->artworkUrl30;
		if($app->artworkUrl60) $urls_to_cache['artworkUrl60'] = $app->artworkUrl60;
		if($app->artworkUrl100) $urls_to_cache['artworkUrl100'] = $app->artworkUrl100;
		if($app->artworkUrl512) $urls_to_cache['artworkUrl512'] = $app->artworkUrl512;

		foreach($urls_to_cache as $urlname=>$url) {
			$content = appStore_fopen_or_curl($url);
			$info = pathinfo(basename($url));
			$Newpath = CACHE_DIRECTORY ."AppStore/". $appID . '/' . $urlname.".".$info['extension'];
			//$Newurl = CACHE_DIRECTORY_URL ."AppStore/". $appID . '/' . $urlname.".".$info['extension'];
			$Newurl = "AppStore/". $appID . '/' . $urlname.".".$info['extension'];
			if($fp = fopen($Newpath, "w+")) {
				fwrite($fp, $content);
				fclose($fp);
				$app->$urlname = $Newurl;
				//$urlExtensionName = $urlname."_ext";
				//$app->$urlExtensionName = $info['extension'];
			} else {
				//Couldnt write the file. Permissions must be wrong.
				appStore_set_setting('cache_images_locally', '0');
				return;
			}
		}
		
		$bestFilePath = appStore_getBestIcon($appID);
		$bestFilePathParts = pathinfo($bestFilePath);
		$bestFileName = $bestFilePathParts['filename'];
		$bestFileExt = $bestFilePathParts['extension'];		
		$editor = wp_get_image_editor( $bestFilePath );
 		$size = $editor->get_size();
 		
 		if(appStore_setting('appicon_size_featured') < $size['width']) {
 			$newSize = appStore_setting('appicon_size_featured');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'featured', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);
			$app->imageFeatured = "AppStore/$appID/".$bestFileName."-featured.".$bestFileExt;
		} else {
			$app->imageFeatured = "AppStore/$appID/$bestFileName.$bestFileExt";
		}

 		if(appStore_setting('appicon_size_ios') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_ios');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'ios', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imageiOS = "AppStore/$appID/".$bestFileName."-ios.".$bestFileExt;
		} else {
			$app->imageiOS = "AppStore/$appID/$bestFileName.$bestFileExt";
		}

 		if(appStore_setting('appicon_size_lists') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_lists');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'list', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imageLists = "AppStore/$appID/".$bestFileName."-list.".$bestFileExt;
		} else {
			$app->imageLists = "AppStore/$appID/$bestFileName.$bestFileExt";
		}

 		if(appStore_setting('appicon_size_posts') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_posts');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'post', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imagePosts = "AppStore/$appID/".$bestFileName."-post.".$bestFileExt;
		} else {
			$app->imagePosts = "AppStore/$appID/$bestFileName.$bestFileExt";
		}

 		if(appStore_setting('appicon_size_element') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_element');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'element', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imageElements = "AppStore/$appID/".$bestFileName."-element.".$bestFileExt;
		} else {
			$app->imageElements = "AppStore/$appID/$bestFileName.$bestFileExt";
		}

		

		if($app->screenshotUrls) {
			foreach($app->screenshotUrls as $ssid=>$ssurl) {
				$content = appStore_fopen_or_curl($ssurl);
				$info = pathinfo(basename($ssurl));
				$Newname = "ios_ss_".$ssid.".".$info['extension'];
				$Newpath = CACHE_DIRECTORY ."AppStore/". $appID . '/' . $Newname;
				//$Newurl = CACHE_DIRECTORY_URL ."AppStore/". $appID . '/' . $Newname;
				$Newurl = "AppStore/". $appID . '/' . $Newname;
			
				if($fp = fopen($Newpath, "w+")) {
					fwrite($fp, $content);
					fclose($fp);
					if($info['extension'] == "jpg" || $info['extension'] == "png" || $info['extension'] == "jpeg") 					$screenshotUrls[] = $Newurl;
				} else {
					//Couldnt write the file. Permissions must be wrong.
					appStore_set_setting('cache_images_locally', '0');
					return;
				}
			}
			$app->screenshotUrls = $screenshotUrls;

		}
		
		if($app->ipadScreenshotUrls) {
			foreach($app->ipadScreenshotUrls as $ssid=>$ssurl) {
				$content = appStore_fopen_or_curl($ssurl);
				$info = pathinfo(basename($ssurl));
				$Newname = "ipad_ss_".$ssid.".".$info['extension'];
				$Newpath = CACHE_DIRECTORY ."AppStore/". $appID . '/' . $Newname;
				$Newurl = "AppStore/". $appID . '/' . $Newname;
			
				if($fp = fopen($Newpath, "w+")) {
					fwrite($fp, $content);
					fclose($fp);
					if($info['extension'] == "jpg" || $info['extension'] == "png" || $info['extension'] == "jpeg") $iPadScreenshotUrls[] = $Newurl;
				} else {
					//Couldnt write the file. Permissions must be wrong.
					appStore_set_setting('cache_images_locally', '0');
					return;
				}
			}
			$app->ipadScreenshotUrls = $iPadScreenshotUrls;
	
		}		
	}
	return $app;
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
?>
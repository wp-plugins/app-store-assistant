<?php
function appStore_load_js_files() {
	wp_enqueue_script('lightbox', plugins_url('js_functions/lightbox/js/lightbox.js',ASA_MAIN_FILE), null, null, true);
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

	
	
	$html = "<!-   HERE IT IS ->";
	return apply_filters( 'post_thumbnail_html', $html, $post_id, $post_thumbnail_id, $size, $attr );
}

function appStore_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {



	$errorImage = plugins_url( 'images/CautionIcon.png' , ASA_MAIN_FILE );
	$html = '<img src="$errorImage" alt="FAKE THUMBNAIL" />';
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
		$appFullDescription = __('A List of music from iTunes');
		$appIcon_url = plugins_url( 'images/MusicList.png', ASA_MAIN_FILE );
		break;
	case "ios_app_list":
		$appFullDescription = __('A List of Apps');
		$appIcon_url = plugins_url( 'images/Apps.jpg', ASA_MAIN_FILE );
		break;
	}

	$appData['appFullDescription'] = $appFullDescription;
	$appData['appIcon_url'] = $appIcon_url;
	return $appData;
}


function appStore_excerpt_filter($text, $excerpt="") {
	global $post;
	if (appStore_setting('excerpt_generator')=="asa") {
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
				$readMoreLink .= '<a type="button" href="'.esc_url( get_permalink() ).'" value="" class="appStore-MoreInfoButton">';
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

	} else {

		if ($excerpt) return $excerpt;

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
		return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	
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
function appStore_css_hook( ) {

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

<?php
	$newIconSize = appStore_setting('appicon_size_adjust')."%";
	if($is_iphone) $newIconSize = appStore_setting('appicon_iOS_size_adjust')."%";
	
	if(appStore_setting('appstoreicon_size_adjust_type') == 'pixels') {
		$newIconSize = appStore_setting('appicon_size_max')."px";
		if($is_iphone) $newIconSize = appStore_setting('appicon_iOS_size_max')."px";
	}



?>



img.appStore-icon{
	float: right;
	max-width:<?php echo $newIconSize; ?>;
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
		_e( 'Missing atomurl in tag. Replace <strong>id</strong> with <strong>atomurl</strong>.',appStoreAssistant);
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
		$buttonText = $iTunesPrice." - ".__("View in iTunes",appStoreAssistant);
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
		echo '<span class="iTunesStore-title">'.$iTunesName.'</span></br>';
	}
	if (appStore_setting('displayitunestrackcount') == "yes" AND !empty($trackCount)) {
		echo '<span class="iTunesStore-trackcount">'.$trackType.': '.$trackCount.'</span></br>';
	}
	if (appStore_setting('displayitunesartistname') == "yes" AND !empty($artistName)) {
		echo '<span class="iTunesStore-artistname">'.$artistType.': '.$artistName.'</span></br>';
	}
	if (appStore_setting('displayfromalbum') == "yes" AND !empty($fromAlbum)) {
		echo '<span class="iTunesStore-fromalbum">'.__("From",appStoreAssistant).': '.$fromAlbum.'</span></br>';
	}
	if (appStore_setting('displayitunesgenre') == "yes" AND !empty($iTunesCategory)) {
		echo '<span class="iTunesStore-genre">'.__("Genre",appStoreAssistant).': '.$iTunesCategory.'</span></br>';
	}
	if (appStore_setting('displayadvisoryrating') == "yes" AND !empty($contentAdvisoryRating)) {
		echo '<span class="iTunesStore-advisoryrating">'.$cavType.': '.$contentAdvisoryRating.'</span></br>';
	}	
	if (appStore_setting('displayitunesreleasedate') == "yes" AND !empty($releaseDate)) {
		echo '<span class="iTunesStore-releasedate">'.__("Released",appStoreAssistant).': '.$releaseDate.'</span></br>';
	}

	if (appStore_setting('displayitunesexplicitwarning') == "yes" AND $isExplicit == "explicit") {
		echo '<span class="iTunesStore-explicitwarning"><img src="'.plugins_url( 'images/parental_advisory_explicit_content-big.gif' , ASA_MAIN_FILE ).'" width="112" height="67" alt="Explicit Lyrics" /></span><br />';// 450x268
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
		$buttonText = $TheAppPrice." - ".__("View in App Store",appStoreAssistant)." ";
	}

	$smallDescription = shortenDescription($app->description);

?>
<div class="appStore-wrapper">
	<hr>
	<div id="appStore-icon-container">
		<a href="<?php echo $appURL; ?>" target="_blank"><img class="appStore-icon" src="<?php echo $artwork_url; ?>" /></a>
		<div class="appStore-purchase">
			<a type="button" href="<?php echo $appURL; ?>" value="" class="appStore-Button BuyButton" target="_blank"><?PHP echo $buttonText; ?></a></br>
		</div>

	</div>
	<div class="appStore-addDetails">
	<?php
	if ((appStore_setting('displayapptitle') == "yes" AND !empty($app->trackName)) OR $mode != "internal") {
		echo '<span class="appStore-title">'.$app->trackName.'</span></br>';
	}
	if (appStore_setting('displayversion') == "yes" AND !empty($app->version)) {
		echo '<span class="appStore-version">'.__("Version",appStoreAssistant).': '.$app->version.'</span></br>';
	}
	
	if ($app->artistName == $app->sellerName) {
		if ((appStore_setting('displaydevelopername') == "yes" OR appStore_setting('displaysellername') == "yes") AND !empty($app->artistName)) {
			echo '<span class="appStore-developername">'.__("Created & Sold by",appStoreAssistant).': '.$app->artistName.'</span></br>';
		}
	} else {
		if (appStore_setting('displaydevelopername') == "yes" AND !empty($app->artistName)) {
			echo '<span class="appStore-developername">'.__("Created by",appStoreAssistant).': '.$app->artistName.'</span></br>';
		}
		if (appStore_setting('displaysellername') == "yes" AND !empty($app->sellerName)) {
			echo '<span class="appStore-sellername">'.__("Sold by",appStoreAssistant).': '.$app->sellerName.'</span></br>';
		}
	}	
	
	
	if (appStore_setting('displayreleasedate') == "yes" AND !empty($app->releaseDate)) {
		echo '<span class="appStore-releasedate">'.__("Released",appStoreAssistant).': '.date( 'F j, Y', strtotime($app->releaseDate) ).'</span></br>';
	}
	if (appStore_setting('displayfilesize') == "yes" AND !empty($app->fileSizeBytes)) {
		echo '<span class="appStore-filesize">'.__("File Size",appStoreAssistant).': '.filesizeinfo($app->fileSizeBytes).'</span></br>';
	}

	if (appStore_setting('displayuniversal') == "yes" AND $AppFeatures[0] == "iosUniversal") {
		echo '<span class="appStore-universal"><img src="'.plugins_url( 'images/fat-binary-badge-web.png' , ASA_MAIN_FILE ).'" width="14" height="14" alt="gamecenter" /> '.__("This app is designed for both iPhone and iPad",appStoreAssistant).'</span><br />';
	}

	if (appStore_setting('displayadvisoryrating') == "yes" AND !empty($app->contentAdvisoryRating)) {
		echo '<span class="appStore-advisoryrating">'.__("Age Rating",appStoreAssistant).': '.$app->contentAdvisoryRating.'</span></br>';
	}
	if (appStore_setting('displaycategories') == "yes" AND !empty($appCategory)) {
		$wordForCategories = sprintf( _n('Category', 'Categories', count($appCategory), appStoreAssistant), count($appCategory) );
		echo '<span class="appStore-categories">'.$wordForCategories.": ";
		if(count($appCategory) == 1) {
			echo $appCategory[0];
		} elseif (count($appCategory) > 1) {
			echo $appCategoryList;
		}
		echo '</span>';
	}
	
	displayAppStoreRating($appRating,$app->averageUserRating,$app->userRatingCount);
		
	if (appStore_setting('displaygamecenterenabled') == "yes" AND $app->isGameCenterEnabled == 1) {
		echo '<img src="'.plugins_url( 'images/gamecenter.jpg' , ASA_MAIN_FILE ).'" width="88" height="92" alt="gamecenter" />';
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
		echo '<img src="'.plugins_url( 'images/badge_appstore-lrg.gif' , ASA_MAIN_FILE ).'" alt="App Store" style="border: 0;"/></a></div>';
		// Original image from http://ax.phobos.apple.com.edgesuite.net/images/web/linkmaker/badge_appstore-lrg.gif
		echo '</div>';

		// Display iPhone Screenshots
		if(appStore_setting('displayscreenshots') == "yes") {
			if(count($app->screenshotUrls) > 0) {
				echo '	<div class="appStore-screenshots-iphone">';
				echo '		<h2>';
				if($platform=="mac_app") _e("Mac",appStoreAssistant);
				if($platform=="ios_app") _e("iPhone",appStoreAssistant);
				echo ' '.__("Screenshots",appStoreAssistant);
				echo ':</h2>';
				echo '		<ul class="appStore-screenshots">';
				foreach($app->screenshotUrls as $ssurl) {
	
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
				echo '		<h2>'.__("iPad",appStoreAssistant).' '.__("Screenshots",appStoreAssistant).':</h2>';
				echo '		<ul class="appStore-screenshots">';
				foreach($app->ipadScreenshotUrls as $ssurl) {	
	
					echo '<li class="appStore-screenshot"><a href="';
					echo $ssurl . '" alt="Full Size Screenshot" rel="lightbox['.$appIDcode.'iPad]"><img src="';
					echo $ssurl . '" width="' . appStore_setting('ss_size') . '" /></a></li>';
				}
				echo '		</ul>';
				echo '</div>';
			}
		}
		echo '	<div style="clear:left;">&nbsp;</div>';
		echo '	<div class="appStore-purchase-center">';
		echo '		<a type="button" href="'.$appURL.'" value="" class="appStore-Button BuyButton">'.$TheAppPrice.' - ';
		_e("View in App Store",appStoreAssistant);
		echo '</a></br>';
		echo '	</div>';
		
	} else {
		echo '	<div class="appStore-description">';
		if (appStore_setting('use_shortDesc_on_multiple') == "yes") {
			echo nl2br($smallDescription);
			$FullDescriptionButtonText = appStore_setting('shortDesc_fullDesc_text');
			if (appStore_setting('shortDesc_link') == "text") echo ' - <a href="'.get_permalink().'" value="">'.$FullDescriptionButtonText.'</a>';
		} else {
			echo nl2br($app->description);
			$FullDescriptionButtonText = appStore_setting('shortDesc_screenshot_text');
			if (appStore_setting('shortDesc_link') == "text") echo ' - <a href="'.get_permalink().'" value="">'.$FullDescriptionButtonText.'</a>';		}
		if($mode=="internal") {
			echo '	<div style="clear:left;">&nbsp;</div>';
			if (appStore_setting('shortDesc_link') == "button") echo '<div class="appStore-FullDescButton"><a type="button" href="'.get_permalink().'" value="" class="appStore-Button FullDescriptionButton">'.$FullDescriptionButtonText.'</a></div>';
		} else {
			echo ' '.__('or',appStoreAssistant).' <a href="'.$appURL.'" value="">'.$more_info_text.'</a>';		
		}
		echo '  </div>';
	}		
	echo '	<div style="clear:left;">&nbsp;</div>';
	
	if (is_array($app->supportedDevices)) {
		$SupportedDecices = $app->supportedDevices;
		sort($SupportedDecices);
		if (appStore_setting('displaysupporteddevices') == "yes") {
			echo '<span class="appStore-supporteddevices">';
			_e('Supported Devices');
			echo ': '.implode(", ", $SupportedDecices)."</span><br />";
		}
		if (appStore_setting('displaysupporteddeviceIcons') == "yes") {
			$SupportedDecices = $app->supportedDevices;
			sort($SupportedDecices);
			foreach ($SupportedDecices as $device):
				echo '<img src="'.plugins_url( 'images/iDevices/'.$device.'.png' , ASA_MAIN_FILE ).'" height="64" alt="'.$device.'" />';					
			endforeach;
		}	
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
		$string = sprintf( __('by %d users', appStoreAssistant), $ratingCount );
		echo "	</span> $string.";
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

function appStore_page_add_stylesheet() {
	wp_register_style('appStore-styles', plugins_url( 'css/appStore-styles.css', ASA_MAIN_FILE ));
	wp_enqueue_style( 'appStore-styles');
	wp_register_style('lightbox-styles', plugins_url( 'js_functions/lightbox/css/lightbox.css', ASA_MAIN_FILE ));
	wp_enqueue_style( 'lightbox-styles');
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
			$Newurl = CACHE_DIRECTORY_URL ."AppStore/". $appID . '/' . $urlname.".".$info['extension'];
			if($fp = fopen($Newpath, "w+")) {
				fwrite($fp, $content);
				fclose($fp);
				$app->$urlname = $Newurl;
			} else {
				//Couldnt write the file. Permissions must be wrong.
				appStore_set_setting('cache_images_locally', '0');
				return;
			}
		}

		if($app->screenshotUrls) {
			foreach($app->screenshotUrls as $ssid=>$ssurl) {
				$content = appStore_fopen_or_curl($ssurl);
				$info = pathinfo(basename($ssurl));
				$Newname = "ios_ss_".$ssid.".".$info['extension'];
				$Newpath = CACHE_DIRECTORY ."AppStore/". $appID . '/' . $Newname;
				$Newurl = CACHE_DIRECTORY_URL ."AppStore/". $appID . '/' . $Newname;
			
				if($fp = fopen($Newpath, "w+")) {
					fwrite($fp, $content);
					fclose($fp);
					$screenshotUrls[] = $Newurl;
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
				$Newurl = CACHE_DIRECTORY_URL ."AppStore/". $appID . '/' . $Newname;
			
				if($fp = fopen($Newpath, "w+")) {
					fwrite($fp, $content);
					fclose($fp);
					$iPadScreenshotUrls[] = $Newurl;
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
<?php
function appStore_add_scripts() {
	wp_enqueue_script('lightbox', plugins_url('js_functions/lightbox/js/lightbox.js',ASA_MAIN_FILE), null, null, true);
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');//enables UI
	wp_enqueue_script('jquery-ui-accordion');
}

function appStore_add_stylesheets() {
	wp_register_style('appStore-styles', plugins_url( 'css/appStore-styles.css', ASA_MAIN_FILE ));
	wp_enqueue_style( 'appStore-styles');
	wp_register_style('appStore-jquery-accordian', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
	wp_enqueue_style( 'appStore-jquery-accordian');
	wp_register_style('appStore-googlefont', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600');
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
   array_push($buttons, "|", "asa_app", "itunes_store", "asaf_atomfeed");
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

	$emptyStar = plugins_url( 'images/rating/star-rating-'.appStore_setting('empty_star_color').'.png', ASA_MAIN_FILE );
	$fullStar = plugins_url( 'images/rating/star-rating-'.appStore_setting('full_star_color').'.png', ASA_MAIN_FILE );
?>
 
<style type='text/css'>
/* This site uses App Store Assistant version <?php echo plugin_get_version()." - ".appStore_setting('affiliatepartnerid'); ?> */

.appStore-rating_bar
{
	display: inline-block;
	/* width of the background picture * 5 */
	width: 155px;
	text-align: left;
	/* This is the picture of a single empty star */
	background: url(<?php echo $emptyStar; ?>) 0 0 repeat-x;
	vertical-align: middle;
}
.appStore-rating_bar_text {
	vertical-align: middle;
	font-size: 21px;
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

function appStore_format_price($unformattedPrice) {
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

function appStore_handler_item ( $atts,$content=null, $code="" ) {
	// Get App ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'link' => '',
		'more_info_text' => 'continued...'
	), $atts ) );
	
	if(!empty($link)) {
		$pattern = '(id[0-9]+)';
		preg_match($pattern, $link, $matches, PREG_OFFSET_CAPTURE, 3);
		$appIDs[] = substr($matches[0][0], 2);		
		$id = $appIDs[0];
	}
	
	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;	
	
	//Get the App Data
	$app = appStore_get_data($id);

	if($app) {
		return appStore_renderItem($app,$more_info_text,"SingleApp",$code);
	} else {
		return __("This item is no longer available.")." (id:$id)";
		//wp_die('No valid data for app id: ' . $id);
	}
}

function appStore_handler_itemLink( $atts,$content=null, $code="") {
	// Get item ID and more_info_text from shortcode
	extract( shortcode_atts( array(
		'id' => '',
		'text' => ''
	), $atts ) );

	//Don't do anything if the ID is blank or non-numeric
	if($id == "" || !is_numeric($id))return;	

	//Get the App Data
	$item = appStore_get_data($id);
	if($item) {
	
		switch ($item->wrapperType) {
			case "collection":
				$itemName = $item->collectionName;
				$itemURL = getAffiliateURL($item->collectionViewUrl);
				break;
			case "track":
				$itemName = $item->trackName;
				$itemURL = getAffiliateURL($item->trackViewUrl);
				break;
			case "audiobook":
				$itemName = $item->collectionName;
				$itemURL = getAffiliateURL($item->collectionViewUrl);
				break;
			case "software":
				$itemName = $item->trackName;
				$itemURL = getAffiliateURL($item->trackViewUrl);
				break;
		}
		if ($text == '') $text = $itemName;
		$itemURL_Display = '<a href="'.$itemURL.'"';
		if(appStore_setting('open_links_externally') == "yes") $itemURL_Display .= ' target="_blank"';
		$itemURL_Display .= '>'.$text.'</a>';
		return $itemURL_Display;
	} else {
		return "Error Processing App ID: $id";
		//wp_die('No valid data for app id: ' . $id);
	}
}

function appStore_handler_app_element($atts,$content=null, $code="",$platform="ios_app") {
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

	$app->TheAppPrice = appStore_format_price($app->price);
	$app->appURL = getAffiliateURL($app->trackViewUrl);
	if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
		$app->buttonText = $app->TheAppPrice." ";
	} else {
		$app->buttonText = $app->TheAppPrice." - ".__("View in App Store",appStoreAssistant)." ";
	}
	$app->mode = $mode;
	$app->more_info_text = $more_info_text;
	if($app->kind == 'mac-software') $platform = 'mac_app';
	$app->platform = $platform;
	$element = "";
	$appElements_available = explode(",","appName,appIcon,appDescription,appBadge,appDetails,appGCIcon,appScreenshots,appDeviceList,appBuyButton,appRating,appPrice,appBadgeSm,appReleaseNotes");
	if($app) {
			$appElements = explode(",", $elements);
			$appElements = array_filter($appElements, 'strlen');
			foreach($appElements as $appElement) {
			
				if (in_array($appElement, $appElements_available)) {
					$displayFunction = "displayAppStore_".$appElement;
					$app->mode = "SingleApp";			
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

function appStore_handler_list($atts, $content = null, $code="") {
	// Get ATOM URL and more_info_text from shortcode	
	extract( shortcode_atts( array(
		'ids' => '',
		'debug' => 'false',
		'more_info_text' => 'open in The Store...'
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
			$AppListing .= appStore_renderItem($app,$more_info_text,"ListOfApps");
		} else {
			$AppListing .= "";
			//wp_die('No valid data for app id: ' . $id);
		}
	}
	return $AppListing; 
}

function appStore_handler_feed($atts, $content = null, $code="") {
	
	// Get ATOM URL and more_info_text from shortcode	
	extract( shortcode_atts( array(
		'atomurl' => '',
		'debug' => 'false',
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
	$originalatomurl = $atomurl;

	if(substr($atomurl,-7,7) == "rss.xml" || substr($atomurl,-8,8) == "rss.xml/") {
		if(substr($atomurl,-8,8) == "rss.xml/") $atomurl = substr($atomurl,0,-1);
	} else {
		$last = $atomurl[strlen($atomurl)-1];
		if($last != "/" && substr($atomurl,-3) != "xml") $AddSlash .= "/";
		if (substr($atomurl,-4) != "/xml") $atomurl .= "/xml";
	}
	// Should not end in /    Good: https://itunes.apple.com/us/rss/toppaidmacapps/limit=25/xml
	// Should not end in /    Good: https://itunes.apple.com/WebObjects/MZStore.woa/wpa/MRSS/newreleases/sf=143441/limit=10/rss.xml
	
	//$overridecache = true;
		
	//Check to see if feed is available cached
	$appStore_feedID = "appStore_rssfeed_".hash('md2', $atomurl);
	$appStore_feedOptions = get_option($appStore_feedID, '');		
	
	if($appStore_feedOptions == '' || $appStore_feedOptions['next_check'] < time() || $overridecache) {
		$STAT = "REBUILT CACHE";
		// Get Array of AppIDs for ATOM Feed
		$appIDs = appStore_getIDs_from_feed($atomurl);
		$appStore_feedOptions = array('next_check' => time() + appStore_setting('cache_time_select_box'), 'feedURL' => $atomurl, 'appIDs' => $appIDs);
		update_option($appStore_feedID, $appStore_feedOptions);
	} else {
		$STAT = "From CACHE";
		$appIDs = $appStore_feedOptions['appIDs'];
	}

	if(is_array($appIDs)) {

		//Pair down array to number of apps preference
		array_splice($appIDs, appStore_setting('qty_of_apps'));
		//Load App data
		$appListDisplay = '';
		$appPositionNumber = 1;
		foreach($appIDs as $appID) {
			//$appListDisplay .= "<hr><<<<<<<[$appID]>>>>>>><br />";
			if($appID == "" || !is_numeric($appID)) return "This list is currently empty.";
			$app = appStore_get_data($appID);

			$app->PositionNumber = $appPositionNumber;
			$appPositionNumber ++;
			if($app) {
				$appListDisplay .= appStore_renderItem($app,$more_info_text,"ListOfApps").'<hr>';
			} else {
				$appListDisplay .= "Error Processing Item ID: $appID";
			}
		}
	} else {
		$appListDisplay = "Sorry, no data for $atomurl [$originalatomurl]. Please check and make sure the URL is correct. For additional URLs, please visit the <a href=\"https://rss.itunes.apple.com/us/\">iTunes RSS Generator</a>. This may be a temporary issue.";
	}
	
	return $appListDisplay; 
}

function appStore_renderItem($itemInfo,$more_info_text="View in Store...",$mode="SingleApp") {
	GLOBAL $is_iphone;	
	$itemType = $itemInfo->wrapperType."_".$itemInfo->kind."_".$itemInfo->collectionType;
	//echo  "<hr><<<<<<<++[".$itemType."]++>>>>>>><hr>"; //Debug
	//echo '---------------'.print_r($itemInfo,true).'---------------';//Debug

	switch ($itemType) {
    	case "software_mac-software_":
			$itemOutput = __("Mac Software",appStoreAssistant);
			$platform = 'mac_app';
			$itemStore = "AppStore";
			break;
    	case "software_software_":
			$itemOutput = __("iOS Software",appStoreAssistant);
			$platform = 'ios_app';
			$itemStore = "AppStore";
			break;
    	case "track_music-video_":
			$itemOutput = __("Music Video",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->trackPrice;
			$iTunesID = $itemInfo->trackId;
			$iTunesName = $itemInfo->trackName;
			$fromAlbum = $itemInfo->collectionName;
			$isExplicit = $itemInfo->trackExplicitness;
			$trackTime = $itemInfo->trackTimeMillis;
			$iTunesKind = $itemInfo->kind;
			$iTunesURL = $itemInfo->trackViewUrl;
			$artistType = __("Artist",appStoreAssistant);
			$cavType = __("Explicit",appStoreAssistant);
			$trackType = __("Track Count",appStoreAssistant);
			break;
    	case "track_song_":
			$itemOutput = __("Song",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->trackPrice;
			$iTunesID = $itemInfo->trackId;
			$iTunesName = $itemInfo->trackName;
			$fromAlbum = $itemInfo->collectionName;
			$isExplicit = $itemInfo->trackExplicitness;
			$trackTime = $itemInfo->trackTimeMillis;
			$iTunesKind = $itemInfo->kind;
			$iTunesURL = $itemInfo->trackViewUrl;
			$artistType = __("Artist",appStoreAssistant);
			$cavType = __("Explicit",appStoreAssistant);
			$trackType = __("Track Count",appStoreAssistant);
			break;
    	case "collection__Album":
			$itemOutput = __("Music Album",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->collectionPrice;
			if($itemInfo->collectionID) $iTunesID = $itemInfo->collectionID;
			if($itemInfo->collectionId) $iTunesID = $itemInfo->collectionId;
			$iTunesName = $itemInfo->collectionName;
			$isExplicit = $itemInfo->collectionExplicitness;
			$trackCount = $itemInfo->trackCount;
			$iTunesKind = $itemInfo->collectionType;
			$iTunesCopyright = $itemInfo->copyright;
			$iTunesURL = $itemInfo->collectionViewUrl;
			$artistType = __("Artist",appStoreAssistant);
			$cavType = __("Explicit",appStoreAssistant);
			$trackType = __("Track Count",appStoreAssistant);
			break;
    	case "track_feature-movie_":
			$itemOutput = __("Movie",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->trackPrice;
			$iTunesID = $itemInfo->trackId;
			$iTunesName = $itemInfo->trackName;
			$fromAlbum = $itemInfo->collectionName;
			$isExplicit = $itemInfo->trackExplicitness;
			$trackTime = $itemInfo->trackTimeMillis;
			$iTunesKind = $itemInfo->kind;
			$iTunesURL = $itemInfo->trackViewUrl;
			$artistType = __("Director",appStoreAssistant);
 			$cavType = __("Rated",appStoreAssistant);
			$trackType = __("Track Count",appStoreAssistant);
 			$description = $itemInfo->longDescription;
			break;
    	case "track_tv-episode_":
			$itemOutput = __("TV Episode",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->trackPrice;
			$iTunesID = $itemInfo->trackId;
			$iTunesName = $itemInfo->artistName.": ".$itemInfo->trackName;
			$fromAlbum = $itemInfo->collectionName;
			$isExplicit = $itemInfo->trackExplicitness;
			$trackTime = $itemInfo->trackTimeMillis;
			$iTunesKind = $itemInfo->kind;
			$iTunesURL = $itemInfo->trackViewUrl;
			$artistType = __("Series",appStoreAssistant);
 			$cavType = __("Rated",appStoreAssistant);
 			$description = $itemInfo->longDescription;
			break;
    	case "collection__TV Season":
			$itemOutput = __("TV Season",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->collectionPrice;
			if($itemInfo->collectionID) $iTunesID = $itemInfo->collectionID;
			if($itemInfo->collectionId) $iTunesID = $itemInfo->collectionId;
			$iTunesName = $itemInfo->collectionName;
			$isExplicit = $itemInfo->collectionExplicitness;
			$trackCount = $itemInfo->trackCount;
			$iTunesKind = $itemInfo->collectionType;
			$iTunesURL = $itemInfo->collectionViewUrl;
			$iTunesCopyright = $itemInfo->copyright;
			$trackType = __("Episodes",appStoreAssistant);
			$artistType = __("Series",appStoreAssistant);
 			$cavType = __("Rated",appStoreAssistant);
			$trackType = __("Track Count",appStoreAssistant);
 			$description = $itemInfo->longDescription;
			break;
    	case "_ebook_":
			$itemOutput = __("eBook",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$artistType = __("Author",appStoreAssistant);
			$iTunesName = $itemInfo->trackName;
			$iTunesURL = $itemInfo->trackViewUrl;
			$iTunesID = $itemInfo->trackId;
			$unformattedPrice = $itemInfo->price;
 			$description = $itemInfo->description;
			break;
    	case "audiobook__":
			$itemOutput = __("AudioBook",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->collectionPrice;
			$iTunesID = $itemInfo->collectionId;
			$iTunesName = $itemInfo->collectionName;
			$isExplicit = $itemInfo->collectionExplicitness;
			$iTunesURL = $itemInfo->collectionViewUrl;
			$iTunesCopyright = $itemInfo->copyright;
 			$description = $itemInfo->description;
			$artistType = __("Author",appStoreAssistant);
			break;
    	case "track_podcast_":
			$itemOutput = __("Podcast",appStoreAssistant);
			$itemStore = "iTunes";
			$itemTemplate = "iTunesMain";
			$unformattedPrice = $itemInfo->trackPrice;
			$iTunesID = $itemInfo->trackId;
			$iTunesName = $itemInfo->trackName;
			$fromAlbum = $itemInfo->collectionName;
			$isExplicit = $itemInfo->trackExplicitness;
			$trackTime = $itemInfo->trackTimeMillis;
			$iTunesKind = $itemInfo->kind;
			$iTunesURL = $itemInfo->trackViewUrl;
			$artistType = __("Produced by",appStoreAssistant);
			break;
		default:
			$itemOutput = __("Unknown Item Type!!",appStoreAssistant)." - $itemType";
			$itemStore = "Unknown";
			$itemTemplate = "iTunesMain";
		
	}
	
	switch ($itemStore) {
    	case "iTunes":
			$iTunesCategory = $itemInfo->primaryGenreName;
			$artistName = $itemInfo->artistName;
			$releaseDate = date( 'F j, Y', strtotime($itemInfo->releaseDate));
			$contentAdvisoryRating = $itemInfo->contentAdvisoryRating;
			//$itemOutput = "<!-- \r".print_r($itemInfo,true)."\r -->";
			$itemOutput = "";
			// iTunes Artwork
			if(appStore_setting('cache_images_locally') == '1') {
				$artwork_url = $itemInfo->imagePosts_cached;
				if($is_iphone) $artwork_url = $itemInfo->imageiOS_cached;
			} else {
				$artwork_url = $itemInfo->imagePosts;
				if($is_iphone) $artwork_url = $itemInfo->imageiOS;
			}

			$iTunesURL = getAffiliateURL($iTunesURL);
	
			if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
				$buttonText = appStore_format_price($unformattedPrice)." ";
			} else {
				$buttonText = appStore_format_price($unformattedPrice);
				//$buttonText = appStore_format_price($unformattedPrice)." - ".__("View in iTunes",appStoreAssistant);
			}
			$itemOutput .= '<div class="appStore-wrapper">';
			//$itemOutput .= '<hr>';
			$itemOutput .= '<div id="iTunesStore-icon-container">';
			$itemOutput .= '<a href="'.$iTunesURL.'" >';
			$itemOutput .= '<img class="iTunesStore-icon" src="'.$artwork_url.'" width="'.$newImageWidth.'" height="'.$newImageHeight.'" /></a>';
			$itemOutput .= '<div class="iTunesStore-purchase">';
			$itemOutput .= '<a type="button" href="'.$iTunesURL.'" value="iTunes Buy Button" class="iTunesStore-Button BuyButton">';
			$itemOutput .= $buttonText.'</a><br />';
			$itemOutput .= '</div>';
			$itemOutput .= '</div>';


			if ((appStore_setting('displayitunestitle') == "yes" AND !empty($iTunesName)) OR $mode != "internal") {
				$itemOutput .= '<span class="iTunesStore-title">';
				if ($mode == "ListOfApps" && appStore_setting('displayATOMappPositionNumber') == "yes" && $itemInfo->PositionNumber > 0) {
					if(appStore_setting('PrePositionNumber') != "EMP") $itemOutput .= appStore_setting('PrePositionNumber');
					$itemOutput .= $itemInfo->PositionNumber;
					if(appStore_setting('PostPositionNumber') != "EMP") $itemOutput .= appStore_setting('PostPositionNumber');
					$itemOutput .= $iTunesName;
				} else {
					$itemOutput .= $iTunesName;
				}
				$itemOutput .= '</span><br /><br />';
			}
			if (appStore_setting('displayitunestrackcount') == "yes" AND !empty($trackCount)) {
				$itemOutput .= '<span class="iTunesStore-trackcount">'.$trackType.': '.$trackCount.'</span><br />';
			}
			if (appStore_setting('displayitunesartistname') == "yes" AND !empty($artistName)) {
				$itemOutput .= '<span class="iTunesStore-artistname">'.$artistType.': '.$artistName.'</span><br />';
			}
			if (appStore_setting('displayfromalbum') == "yes" AND !empty($fromAlbum)) {
				$itemOutput .= '<span class="iTunesStore-fromalbum">'.__("From",appStoreAssistant).': '.$fromAlbum.'</span><br />';
			}
			if (appStore_setting('displayitunesgenre') == "yes" AND !empty($iTunesCategory)) {
				$itemOutput .= '<span class="iTunesStore-genre">'.__("Genre",appStoreAssistant).': '.$iTunesCategory.'</span><br />';
			}
			if (appStore_setting('displayadvisoryrating') == "yes" AND !empty($contentAdvisoryRating)) {
				$itemOutput .= '<span class="iTunesStore-advisoryrating">'.$cavType.': '.$contentAdvisoryRating.'</span><br />';
			}	
			if (appStore_setting('displayitunesreleasedate') == "yes" AND !empty($releaseDate)) {
				$itemOutput .= '<span class="iTunesStore-releasedate">'.__("Released",appStoreAssistant).': '.$releaseDate.'</span><br />';
			}
			if (true AND !empty($iTunesCopyright)) {
				$itemOutput .= '<span class="iTunesStore-copyright">'.$iTunesCopyright.'</span><br />';
			}

			if (appStore_setting('displayitunesexplicitwarning') == "yes" AND $isExplicit == "explicit") {
				$itemOutput .= '<br /><span class="iTunesStore-explicitwarning"><img src="'.plugins_url( 'images/parental_advisory_explicit_content-big.gif' , ASA_MAIN_FILE ).'" width="112" height="67" alt="Explicit Lyrics" /></span><br />';// 450x268
			}
			if (appStore_setting('displayitunesdescription') == "yes" AND !empty($description)) {	
				$itemOutput .= '	<div class="iTunesStore-description">';
				$itemOutput .= nl2br($description);
				$itemOutput .= '<br /></div>';
			}
			$itemOutput .= '<br />';

			$itemOutput .= '<div class="appStore-badge"><a href="'.$iTunesURL.'" >';
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
			$itemOutput .= '<img src="'.plugins_url( $badgeImage , ASA_MAIN_FILE ).'" alt="App Store" style="border: 0;" /></a>';
			$itemOutput .= '</div>';
			$itemOutput .= '<div style="clear:left;">&nbsp;</div>';
			$itemOutput .= '</div>';
			break;
    	case "AppStore":
			$itemInfo->TheAppPrice = appStore_format_price($itemInfo->price);
			$itemInfo->appURL = getAffiliateURL($itemInfo->trackViewUrl);
			if(appStore_setting('smaller_buy_button_iOS') == "yes" && $is_iphone) {
				$itemInfo->buttonText = $itemInfo->TheAppPrice." ";
			} else {
				$itemInfo->buttonText = $itemInfo->TheAppPrice." - ".__("View in App Store",appStoreAssistant)." ";
			}
			$itemInfo->more_info_text = $more_info_text;
			$itemInfo->platform = $platform;
			$itemInfo->mode = $mode;
			if(is_single()) $mode .= "_one";
			//Get List of Elements and their order
			switch ($mode) {
				case "SingleApp_one":
					$appDetailsOrder = explode(",", appStore_setting('appDetailsOrder'));
					break;
				case "SingleApp":
					$appDetailsOrder = explode(",", appStore_setting('appMPDetailsOrder'));
					break;
				case "ListOfApps":
					$appDetailsOrder = explode(",", appStore_setting('appATOMDetailsOrder'));
					break;
				case "ListOfApps_one":
					$appDetailsOrder = explode(",", appStore_setting('appATOMDetailsOrder'));
					break;
				default:
					$appDetailsOrder = explode(",", appStore_setting('appDetailsOrder'));
				}
			$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');

			//Create listing for App
			$itemOutput = '<div class="appStore-wrapper">';
			foreach($appDetailsOrder as $appDetailOrder) {
				$displayFunction = "displayAppStore".substr($appDetailOrder, 14);
				$itemOutput .= $displayFunction($itemInfo);
			}
			$itemOutput .= '	</div><!-- END of appStore-wrapper -->';
			break;
		default:
			$itemOutput = "<b>$itemOutput</b>";
			//$itemOutput .= "<hr>".print_r($itemInfo,true)."<hr>";
		
	}
	return $itemOutput;
}

function displayAppStore_appName ($app,$elementOnly=false) {
	if(!empty($app->trackName)) {
		$trackName = $app->trackName;
		if($elementOnly) return $trackName;

		if ($app->mode == "ListOfApps" && appStore_setting('displayATOMappPositionNumber') == "yes" && $app->PositionNumber > 0) {
			$trackName = "";
			if(appStore_setting('PrePositionNumber') != "EMP") $trackName .= appStore_setting('PrePositionNumber');
			$trackName .= $app->PositionNumber;
			if(appStore_setting('PostPositionNumber') != "EMP") $trackName .= appStore_setting('PostPositionNumber');
			$trackName .= $app->trackName;
		}
		switch ($app->mode) {
			case "SingleApp":
				if(is_single()) {
					if (appStore_setting('displayapptitle') == "no") return;
					$displayMode = 'notitle';
				} else {
					if (appStore_setting('displaympapptitle') == "no") return;
					$displayMode = 'notitle';
				}
				break;
			case "ListOfApps":
				if (appStore_setting('displayATOMapptitle') == "no") return;
				$displayMode = 'headline';
				break;
			}
		$element = getAccordionCode ($trackName,"appStore-title",$displayMode,"App Name ");
		return $element;		
	}
}

function displayAppStore_appScreenshots($app,$elementOnly=false) {
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayscreenshots') == "no") return '';
				$displayMode = appStore_setting('displayscreenshots');
			} else {
				if (appStore_setting('displaympappdetailssection') == "no") return '';
				$displayMode = appStore_setting('displaympappdetailssection');
			}
			break;
		case "ListOfApps":
				if (appStore_setting('displayATOMappdetailssection') == "no") return '';
				$displayMode = appStore_setting('displayATOMappdetailssection');
			break;
	}
	
	// Get iPhone Screenshots
	$iPhoneScreenShots = $app->screenshotUrls;
	if(appStore_setting('cache_images_locally') == '1') $iPhoneScreenShots = $app->screenshotUrls_cached;
	
	if(count($iPhoneScreenShots) > 0) {
		
			if($app->platform == "mac_app") $title_iPhone = __("Mac Screenshots",appStoreAssistant);
			if($app->platform == "ios_app") $title_iPhone = __("iPhone Screenshots",appStoreAssistant);
			
			// appStore-screenshots-iphone
			$elementLoop_iPhone = '		<ul class="appStore-screenshots">';
			foreach($iPhoneScreenShots as $ssurl) {

				$elementLoop_iPhone .= '<li class="appStore-screenshot"><a href="';
				$elementLoop_iPhone .= $ssurl . '" rel="lightbox['.$appIDcode.']"><img src="';
				$elementLoop_iPhone .= $ssurl . '" width="' . appStore_setting('ss_size') . '" alt="Screenshot" /></a></li>';
			}
		$elementLoop_iPhone .= '		</ul>';
		$valid_Screenshots_iPhone = true;
	}

	// Get iPad Screenshots
	$iPadScreenShots = $app->ipadScreenshotUrls;
	if(appStore_setting('cache_images_locally') == '1') $iPadScreenShots = $app->ipadScreenshotUrls_cached;
	if(count($iPadScreenShots) > 0) {

		$title_iPad = __("iPad Screenshots",appStoreAssistant);

		//appStore-screenshots-iPad
		$elementLoop_iPad = '		<ul class="appStore-screenshots">';
		foreach($iPadScreenShots as $ssurl) {	

			$elementLoop_iPad .= '<li class="appStore-screenshot"><a href="';
			$elementLoop_iPad .= $ssurl . '" rel="lightbox['.$appIDcode.'iPad]"><img src="';
			$elementLoop_iPad .= $ssurl . '" width="' . appStore_setting('ss_size') . '" alt="Screenshot" /></a></li>';
		}
		$elementLoop_iPad .= '		</ul>';
		$valid_Screenshots_iPad = true;
	}


	if($valid_Screenshots_iPad || $valid_Screenshots_iPhone) {
		$element = "";
		if ($elementOnly) {
			if($valid_Screenshots_iPhone) $element .= "<h3>$title_iPhone</h3>".$elementLoop_iPhone;
			if($valid_Screenshots_iPad) $element .= "<h3>$title_iPad</h3>".$elementLoop_iPad;
			return $element;
		}
		
		if($valid_Screenshots_iPhone) $element .= getAccordionCode ($elementLoop_iPhone, "appStore-screenshots-iphone", $displayMode,$title_iPhone);
		if($valid_Screenshots_iPad) $element .= getAccordionCode ($elementLoop_iPad, "appStore-screenshots-ipad", $displayMode,$title_iPad);
		return $element;
	}
}

function displayAppStore_appBadge($app,$elementOnly=false) {

	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayappbadge') == "no") return;
			} else {
				if (appStore_setting('displaympappbadge') == "no") return;
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMappbadge') == "no") return;
			break;
	}

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
	
	$element = '<div class="appStore-badge">'.$appLink.$badgeImgTag.'</a></div>';
	return $element;
}

function displayAppStore_appBadgeSm($app,$elementOnly=false) {
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayappbadge') == "no") return;
			} else {
				if (appStore_setting('displaympappbadge') == "no") return;
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMappbadge') == "no") return;
			break;
	}

	$appLink = '<a href="'.$app->appURL.'"';
	if(appStore_setting('open_links_externally') == "yes") $appLink .= ' target="_blank"';
	$appLink .= '>';
	$badgeImage = 'images/Badges/badge_appstore-sm.gif';
	$badgeImgTag = '<img src="'.plugins_url( $badgeImage , ASA_MAIN_FILE ).'" width="61" height="15" alt="App Store" style="border: 0;" /></a>';

	if($elementOnly) {
		$element =  $appLink.$badgeImgTag;
		return $element;
	}

	$element = '<div class="appStore-badge">'.$appLink.$badgeImgTag.'</div>';
	return $element;	
}

function getAccordionCode ($DisplayElement,$cssClass,$accState, $SectionTitle="Section") {
	$baseCSSClass = "accordion-$cssClass";
	$AccordionCode = "";
	if ($accState == "open" || $accState == "closed") {
		$cssClass = $cssClass.'-'.rand();
		$AccordionCode = "<script>\r";
		$AccordionCode .= "jQuery(function() {\r";
		$AccordionCode .= '	jQuery( "#accordion-';
		$AccordionCode .= $cssClass;
		$AccordionCode .= '" ).accordion({ heightStyle: "content",collapsible: true';
		if($accState == "closed") $AccordionCode .= ',active: 2';
		$AccordionCode .= ' });'."\r";
		$AccordionCode .= '});'."\r";
		$AccordionCode .= "</script>\r";
		$AccordionCode .= '<div style="clear:left;">&nbsp;</div>';
		$AccordionCode .= '<div class="'.$baseCSSClass.'">';
		$AccordionCode .= '<div id="accordion-'.$cssClass.'">';
		$AccordionCode .= "<h3>$SectionTitle</h3>";
		$AccordionCode .= '<div class="'.$cssClass.'">';
		$AccordionCode .=  $DisplayElement;
		$AccordionCode .= '</div></div></div>';

	} elseif($accState == "yes") {
		$AccordionCode = '<div style="clear:left;">&nbsp;</div>';
		$AccordionCode .= '<h3>'.$SectionTitle.':</h3>';
		$AccordionCode .= '<div class="'.$cssClass.'">';
		$AccordionCode .=  $DisplayElement;
		$AccordionCode .= '</div>';
	} elseif($accState == "notitle") {
		$AccordionCode = '<br />';
		$AccordionCode .= '<span class="'.$cssClass.'">';
		$AccordionCode .=  $DisplayElement;
		$AccordionCode .= '</span><br />';
	} elseif($accState == "headline") {
		$AccordionCode = '<h1>';
		$AccordionCode .=  $DisplayElement;
		$AccordionCode .= '</h1>';
	}
	return $AccordionCode;
}


function displayAppStore_appDescription($app,$elementOnly=false) {
	if(empty($app->description)) return '';
	$smallDescription = nl2br(appStore_shortenDescription($app->description));
	$fullDescription = nl2br($app->description);
	
	$element = "";
	if($elementOnly) return $fullDescription;

	switch (appStore_setting('shortDesc_link')) {
		case "text":
			$ReadMore_fullDesc = ' - <a href="'.get_permalink().'" value="">'.appStore_setting('shortDesc_fullDesc_text').'</a>';
			$ReadMore_screenshot = ' - <a href="'.get_permalink().'" value="">'.appStore_setting('shortDesc_screenshot_text').'</a>';
			break;
		case "button":
			$ReadMore_fullDesc = '<div class="appStore-FullDescButton">';
			$ReadMore_fullDesc .= '<a type="button" href="'.get_permalink().'" value="App Store Buy Button" class="appStore-Button FullDescriptionButton">';
			$ReadMore_fullDesc .= appStore_setting('shortDesc_fullDesc_text').'</a></div>';
	
			$ReadMore_screenshot = '<div class="appStore-FullDescButton">';
			$ReadMore_screenshot .= '<a type="button" href="'.get_permalink().'" value="App Store Buy Button" class="appStore-Button FullDescriptionButton">';
			$ReadMore_screenshot .= appStore_setting('shortDesc_screenshot_text').'</a></div>';
			break;
		case "hide":
			$ReadMore_fullDesc = '';
			$ReadMore_screenshot = '';
			break;
	}

	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayappdescription') == "no") return '';
				if (appStore_setting('use_shortDesc_on_single') == "yes") {
					$element .= $smallDescription."&hellip;";
				} else {
					$element .= $fullDescription;
				}
				$displayMode = appStore_setting('displayappdescription');
			} else {
				if (appStore_setting('displaympappdescription') == "no") return '';
				if (appStore_setting('use_shortDesc_on_multiple') == "yes") {
					$element .= $smallDescription;
					$element .= $ReadMore_fullDesc;
				} else {
					$element .= $fullDescription;
					$element .= $ReadMore_screenshot;
				}
				$displayMode = appStore_setting('displaympappdescription');
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMappdescription') == "no") return '';
			if (appStore_setting('use_shortDesc_on_atomfeed') == "yes") {
				$element .= nl2br($smallDescription);
			} else {
				$element .= nl2br($app->description);
			}
			$displayMode = appStore_setting('displayATOMappdescription');
			break;
	}
	$element = getAccordionCode ($element,"appStore-description",$displayMode,"Description ");
	return $element;		
}

function displayAppStore_appReleaseNotes($app,$elementOnly=false) {
	if(empty($app->releaseNotes)) return '';
	$releaseNotes = nl2br($app->releaseNotes);
	$element = "";
	if($elementOnly) return $releaseNotes;

	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayappreleasenotes') == "no") return '';
				$displayMode = appStore_setting('displayappreleasenotes');
			} else {
				if (appStore_setting('displaympappreleasenotes') == "no") return '';
				$displayMode = appStore_setting('displaympappreleasenotes');
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMappreleasenotes') == "no") return '';
			$displayMode = appStore_setting('displayATOMappreleasenotes');
			break;
	}
	$element = getAccordionCode ($releaseNotes,"appStore-releasenotes",$displayMode,__('Release Notes',appStoreAssistant));
	return $element;		
}

function displayAppStore_appBuyButton($app,$elementOnly=false) {
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayappbuybutton') == "no") return;
			} else {
				if (appStore_setting('displaympappbuybutton') == "no") return;
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMappbuybutton') == "no") return;
			break;
	}

	$appLink = '<a type="button" href="'.$app->appURL.'" value="App Store Buy Button" class="appStore-Button BuyButton"';
	if(appStore_setting('open_links_externally') == "yes") $appLink .= ' target="_blank"';
	$appLink .= '>'.$app->TheAppPrice;
	$appLink .= ' - '.__("View in App Store",appStoreAssistant);
	$appLink .= '</a>';
 
	if($elementOnly) return $appLink;
	$element = '<div style="clear:left;">&nbsp;</div>	<div class="appStore-purchase-center">';
	$element .= $appLink.'<br />';
	$element .= '	</div>';
	return $element;
}

function displayAppStore_appPrice($app,$elementOnly=false) {
		$element = $app->TheAppPrice;
		return $element;
}

function displayAppStore_appDeviceList($app,$elementOnly=false){
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displaysupporteddevices') == "no") return '';
				$displayMode = appStore_setting('displaysupporteddevices');
			} else {
				if (appStore_setting('displaympsupporteddevices') == "no") return '';
				$displayMode = appStore_setting('displaympsupporteddevices');
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMsupporteddevices') == "no") return '';
			$displayMode = appStore_setting('displayATOMsupporteddevices');
			break;
	}
	$displayType = appStore_setting('displaysupporteddevicesType');
	
	// List all iDevices here
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
						"iPhone5s" => array ("name" => "iPhone 5s", "icon" => "iPhone5s"),
						"iPhone5c" => array ("name" => "iPhone 5c", "icon" => "iPhone5c"),
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
	} else {
		return "";
	}
	
	
	switch ($displayType){
		case 'List' :
			$SupportedDevicesElement =  implode(", ", $iDeviceList);
			break;
		case 'Minimal' :
			if (appStore_substr_in_array("iPad", $SupportedDevices) || $allDevices) {
				$SupportedDevicesElement .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPad.png' , ASA_MAIN_FILE ).'" height="82" width="56" alt="iPad" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
			if (appStore_substr_in_array("iPadMini", $SupportedDevices) || $allDevices) {
				$SupportedDevicesElement .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPadmini.png' , ASA_MAIN_FILE ).'" height="82" width="39" alt="iPad mini" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
			if (appStore_substr_in_array("iPhone", $SupportedDevices) || $allDevices) {
				$SupportedDevicesElement .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPhone.png' , ASA_MAIN_FILE ).'" height="82" width="23" alt="iPhone" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
			if (appStore_substr_in_array("iPodTouch", $SupportedDevices) || $allDevices) {
				$SupportedDevicesElement .= '<img src="'.plugins_url( 'images/iDevicesGeneric/iPod.png' , ASA_MAIN_FILE ).'" height="82" width="23" alt="iPod" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';
			}
			break;
		case 'Normal' :
			if (appStore_setting('displayappdetailsasliststyle') == "color") {
				$list_icon_folder = "iDevices";
				$list_icon_height = "64";
			} else {
				$list_icon_folder = "iDevicesBW";
				$list_icon_height = "82";
			}
			foreach ($iDeviceListIcons as $iDeviceIcon):
				$SupportedDevicesElement .= '<img src="'.plugins_url( 'images/'.$list_icon_folder.'/'.$iDeviceIcon.'.png' , ASA_MAIN_FILE ).'" height="'.$list_icon_height.'" alt="'.$iDeviceIcon.'" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" />';					
			endforeach;
			break;
	}
	
	if ($elementOnly) return $SupportedDevicesElement;
	$element = getAccordionCode ($SupportedDevicesElement,"appStore-supportedDevices",$displayMode,__('Supported Devices',appStoreAssistant));
	return $element;		
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

	$elementVersion = '';
	if (!empty($app->version)) {
		$elementVersion =  '<li class="appStore-version">'.__("Version",appStoreAssistant).': '.$app->version.'</li>';
	}
	$elementDeveloper = '';
	$elementSellerName = '';
	if (($app->artistName == $app->sellerName) AND !empty($app->artistName)) {
			$elementDeveloper =  '<li class="appStore-developername">'.__("Created & Sold by",appStoreAssistant).': '.$app->artistName.'</li>';
	} else {
		if (!empty($app->artistName)) {
			$elementDeveloper =  '<li class="appStore-developername">'.__("Created by",appStoreAssistant).': '.$app->artistName.'</li>';
		}
		if (!empty($app->sellerName)) {
			$elementSellerName =  '<li class="appStore-sellername">'.__("Sold by",appStoreAssistant).': '.$app->sellerName.'</li>';
		}
	}
	$elementReleaseDate = '';
	if (!empty($app->releaseDate)) {
		$elementReleaseDate =  '<li class="appStore-releasedate">'.__("Released",appStoreAssistant).': '.date( 'F j, Y', strtotime($app->releaseDate) ).'</li>';
	}
	$elementFileSize = '';
	if (!empty($app->fileSizeBytes)) {
		$elementFileSize =  '<li class="appStore-filesize">'.__("File Size",appStoreAssistant).': '.size_format($app->fileSizeBytes).'</li>';
	}
	$elementUniversal = '';
	if ($AppFeatures[0] == "iosUniversal") {
		$elementUniversal =  '<li class="appStore-universal"><img src="'.plugins_url( 'images/fat-binary-badge-web.png' , ASA_MAIN_FILE ).'" width="14" height="14" alt="universal" style="border: 0px; padding: 0px; background-color: Transparent;-webkit-box-shadow:none;box-shadow:none;-moz-box-shadow:none;" /> '.__("This app is designed for both iPhone and iPad",appStoreAssistant).'</li>';
	}
	$elementAdvisoryRating = '';
	if (!empty($app->contentAdvisoryRating)) {
		$elementAdvisoryRating =  '<li class="appStore-advisoryrating">'.__("Age Rating",appStoreAssistant).': '.$app->contentAdvisoryRating.'</li>';
	}
	$elementCategories = '';
	$appCategory = $app->genres;
	$appCategoryPrime = $app->primaryGenreName;
	if(is_array($appCategory)) $appCategoryList = implode(', ', $appCategory);
	if (!empty($appCategory)) {
		$wordForCategories = sprintf( _n('Category', 'Categories', count($appCategory), appStoreAssistant), count($appCategory) );
		$elementCategories .=  '<li class="appStore-categories">'.$wordForCategories.": ";
		if(count($appCategory) == 1) {
			$elementCategories .=  $appCategory[0];
		} elseif (count($appCategory) > 1) {
			$elementCategories .=  $appCategoryList;
		}
		$elementCategories .=  '</li>';
	}
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayappdetailssection') == "no") return '';
				if (appStore_setting('displayversion') == "yes") $detailsList[] = $elementVersion;
				if (appStore_setting('displaydevelopername') == "yes") $detailsList[] = $elementDeveloper;
				if (appStore_setting('displaysellername') == "yes") $detailsList[] = $elementSellerName;
				if (appStore_setting('displayreleasedate') == "yes") $detailsList[] = $elementReleaseDate;
				if (appStore_setting('displayfilesize') == "yes") $detailsList[] = $elementFileSize;
				if (appStore_setting('displayuniversal') == "yes") $detailsList[] = $elementUniversal;
				if (appStore_setting('displayadvisoryrating') == "yes") $detailsList[] = $elementAdvisoryRating;
				if (appStore_setting('displaycategories') == "yes") $detailsList[] = $elementCategories;
				$displayMode = appStore_setting('displayappdetailssection');
			} else {
				if (appStore_setting('displaympappdetailssection') == "no") return '';
				if (appStore_setting('displaympversion') == "yes") $detailsList[] = $elementVersion;
				if (appStore_setting('displaympdevelopername') == "yes") $detailsList[] = $elementDeveloper;
				if (appStore_setting('displaympsellername') == "yes") $detailsList[] = $elementSellerName;
				if (appStore_setting('displaympreleasedate') == "yes") $detailsList[] = $elementReleaseDate;
				if (appStore_setting('displaympfilesize') == "yes") $detailsList[] = $elementFileSize;
				if (appStore_setting('displaympuniversal') == "yes") $detailsList[] = $elementUniversal;
				if (appStore_setting('displaympadvisoryrating') == "yes") $detailsList[] = $elementAdvisoryRating;
				if (appStore_setting('displaympcategories') == "yes") $detailsList[] = $elementCategories;
				$displayMode = appStore_setting('displaympappdetailssection');
			}
			break;
		case "ListOfApps":
				if (appStore_setting('displayATOMappdetailssection') == "no") return '';
				if (appStore_setting('displayATOMversion') == "yes") $detailsList[] = $elementVersion;
				if (appStore_setting('displayATOMdevelopername') == "yes") $detailsList[] = $elementDeveloper;
				if (appStore_setting('displayATOMsellername') == "yes") $detailsList[] = $elementSellerName;
				if (appStore_setting('displayATOMreleasedate') == "yes") $detailsList[] = $elementReleaseDate;
				if (appStore_setting('displayATOMfilesize') == "yes") $detailsList[] = $elementFileSize;
				if (appStore_setting('displayATOMuniversal') == "yes") $detailsList[] = $elementUniversal;
				if (appStore_setting('displayATOMadvisoryrating') == "yes") $detailsList[] = $elementAdvisoryRating;
				if (appStore_setting('displayATOMcategories') == "yes") $detailsList[] = $elementCategories;
				$displayMode = appStore_setting('displayATOMappdetailssection');
			break;
	}
		
	$element .=  '<ul class="appStore-addDetails">'."\r";
	foreach ($detailsList as $item):
		$element .= $item."\r";
	endforeach;
	$element .=  '</ul>';
	
	if ($elementOnly) return $element;
	
	$element = getAccordionCode ($element,"appStore-appDetails",$displayMode,__('App Details',appStoreAssistant));
	return $element;		

}

function displayAppStore_appGCIcon($app,$elementOnly=false){
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displaygamecenterenabled') == "no") return;
			} else {
				if (appStore_setting('displaympgamecenterenabled') == "no") return;
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMgamecenterenabled') == "no") return;
			break;
	}
	$element = '';
	if($app->isGameCenterEnabled == 1) {
		$element = '<div style="clear:left;">&nbsp;</div><div class="appStore-gamecenter">';
		$element .= '<img class="appStore-gamecentericon" src="'.plugins_url( 'images/gamecenter.png' , ASA_MAIN_FILE ).'" width="88" height="92" alt="gamecenter" />';
		$element .= __('Game Center',appStoreAssistant);
		$element .= '</div>';





	}
	return $element;
}

function displayAppStore_appRating($app,$elementOnly=false) {
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displaystarrating') == "no") return;
			} else {
				if (appStore_setting('displaympstarrating') == "no") return;
			}
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMstarrating') == "no") return;
			break;
	}

	$averageRating = $app->averageUserRating;
	$ratingCount = $app->userRatingCount;
	//App Rating
	if ($averageRating > 0 && $averageRating <=10) {
		$appRating = $averageRating * 20;
	}else {
		$appRating = 0;
	}

	if(isset($ratingCount)) {
		$element = '<div style="clear:left;">&nbsp;</div><div class="appStore-rating">';
		$element .= '	<span class="appStore-rating_bar" title="Rating '.$averageRating.' stars">';
		$element .= '	<span style="width:'.$appRating.'%"></span>';
		$string = sprintf( __('by %d users', appStoreAssistant), $ratingCount );
		$element .= '	</span><span class="appStore-rating_bar_text"> '.$string."</span>";
		$element .= '</div>';
	}
	return $element;
}

function displayAppStore_appIcon ($app,$elementOnly=false){
	GLOBAL $is_iphone;
	// App Artwork	
	if($elementOnly) {
		if(appStore_setting('cache_images_locally') == '1') {
			$imageTag = $itemInfo->imageElements_cached;
			if($is_iphone) $imageTag = $itemInfo->imageiOS_cached;
		} else {
			$imageTag = $itemInfo->imageElements;
			if($is_iphone) $imageTag = $itemInfo->imageiOS;
		}		
		$element = '<a href="'.$app->appURL.'" target="_blank"><img class="appStore-icon" src="'.$imageTag.'" alt="'.$app->trackName.'" /></a>';
		return $element;
	}
	
	switch ($app->mode) {
		case "SingleApp":
			if(is_single()) {
				if (appStore_setting('displayappicon') == "no") return;
			} else {
				if (appStore_setting('displaympappicon') == "no") return;
			}
			if(appStore_setting('cache_images_locally') == '1') {
				$imageTag = $itemInfo->imagePosts_cached;
				if($is_iphone) $imageTag = $itemInfo->imageiOS_cached;
			} else {
				$imageTag = $itemInfo->imagePosts;
				if($is_iphone) $imageTag = $itemInfo->imageiOS;
			}		
			$element = '<div id="appStore-icon-container">';
			$element .= '<a href="'.$app->appURL.'" target="_blank">';
			$element .= '<img src="'.$imageTag.'" />';
			$element .= '</a>';
			if ((appStore_setting('displayappiconbuybutton') == "yes") || (appStore_setting('displaympappiconbuybutton') == "yes")) {
				$element .= '<br /><a type="button" href="'.$app->appURL.'" value="App Store Buy Button" class="appStore-Button BuyButton" target="_blank">';
				$element .= ''.$app->TheAppPrice.'</a>';
			}
			$element .= '';
			$element .= '</div>';
			$element .= '	<div style="clear:left;">&nbsp;</div>';
			break;
		case "ListOfApps":
			if (appStore_setting('displayATOMappicon') == "no") return;
			if(appStore_setting('cache_images_locally') == '1') {
				$imageTag = $itemInfo->imageLists_cached;
				if($is_iphone) $imageTag = $itemInfo->imageiOS_cached;
			} else {
				$imageTag = $itemInfo->imageLists;
				if($is_iphone) $imageTag = $itemInfo->imageiOS;
			}		
			$element = '<div id="appStore-icon-container-left">';
			$element .= '<a href="'.$app->appURL.'" target="_blank"><img src="'.$imageTag.'"  alt="'.$app->trackName.'" /></a><br />';
			if (appStore_setting('displayATOMappiconbuybutton') == "yes") {
				$element .= '	<div class="appStore-purchase-center">';
				$element .= '	<a type="button" href="'.$app->appURL.'" value="App Store Buy Button" class="appStore-Button BuyButton" target="_blank">'.$app->TheAppPrice.'</a><br />';
				$element .= '	</div>';
			}
			$element .= '</div>';
			$element .= '	<div style="clear:right;">&nbsp;</div>';
			break;
	}
	return $element;		

}

function getAffiliateURL($itemURL){
	switch (appStore_setting('affiliatepartnerid')) {
    case 2013:
        $PHGaffiliateID = appStore_setting('PHGaffiliateID');
        $phgCampaignvalue = appStore_setting('phgCampaignvalue');
		$phgCampaignvalue = substr($phgCampaignvalue,0,45);
		$AffiliateURL = $itemURL;
		if (strpos($itemURL, '?') !== false) {
			$AffiliateURL .= '&at='.$PHGaffiliateID;
		} else {
			$AffiliateURL .= '?at='.$PHGaffiliateID;
		}
		if (!empty($phgCampaignvalue)) $AffiliateURL .= '&ct='.urlencode($phgCampaignvalue);
        break;
    case 2003:
          $AffiliateURL = "http://clk.tradedoubler.com/click?p=".appStore_setting('tdprogramID')."&a=".appStore_setting('tdwebsiteID')."&url=";
		if (strpos($itemURL, '?') !== false) {
			$AffiliateURL .= urlencode($itemURL.'&partnerId=2003');
		} else {
			$AffiliateURL .= urlencode($itemURL.'?partnerId=2003');
		}
        break;
    default:
		$phgCampaignvalue = "v".preg_replace("/[^0-9]/",'',plugin_get_version())."_".$_SERVER['SERVER_NAME'];
		$phgCampaignvalue = preg_replace("/[^A-Za-z0-9_\.]/", '', $phgCampaignvalue);
		$phgCampaignvalue = substr($phgCampaignvalue,0,42);


		$AffiliateURL = $itemURL;
		if (strpos($itemURL, '?') !== false) {
			$AffiliateURL .= '&at=11l3KC&ct='.$phgCampaignvalue;
		} else {
			$AffiliateURL .= '?at=11l3KC&ct='.$phgCampaignvalue;
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

		$appStore_options_data = appStore_process_imagedata($appStore_options_data);
		
		$appStore_options = array('next_check' => time() + appStore_setting('cache_time_select_box'), 'app_data' => $appStore_options_data);
		update_option('appStore_appData_' . $id, $appStore_options);
	}	
	return $appStore_options['app_data'];
}

function appStore_cache_seconds($seconds) {
	return appStore_setting('cache_time_select_box');
}

function appStore_getIDs_from_feed($atomurl) {

	/*
	add_filter( 'wp_feed_cache_transient_lifetime' , 'appStore_cache_seconds' );
	$rss = fetch_feed($atomurl);
	remove_filter( 'wp_feed_cache_transient_lifetime' , 'appStore_cache_seconds' );
	if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
		// Figure out how many total items there are, but limit it to appStore_setting('qty_of_apps'). 
		$maxitems = $rss->get_item_quantity( appStore_setting('qty_of_apps') );
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items( 0, $maxitems );
	endif;
	*/
	require_once ( ABSPATH . WPINC . '/class-feed.php' );
	$feed = new SimplePie();
	$feed->set_feed_url($atomurl);
	$feed->set_cache_duration(appStore_setting('appStore_cache_seconds'));
	$feed->set_cache_location(CACHE_DIRECTORY."/");
	$feed->get_item_quantity( appStore_setting('qty_of_apps') );
	$feed->enable_order_by_date(false);
	$feed->init();
	$feed->handle_content_type();

	$max = $feed->get_item_quantity();
	for ($x = 0; $x < $max; $x++):
		$item = $feed->get_item($x);
		$idLine = $item->get_id();
		$appID = "";
		if(preg_match("/id([0-9]{6,})\\?i=([0-9]{6,})/u", $idLine)) {
			preg_match("/\\?i=([0-9]{6,})/u", $idLine,$appID);
		} else {
			preg_match("/id([0-9]{6,})/u", $idLine,$appID);		
		}
		$appIDs[] = $appID[1];		
	endfor;
		
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

function appStore_process_imagedata($app) {
	$appID = $app->trackId;

	if($app->wrapperType == "audiobook") $appID = $app->collectionId;
	if($app->wrapperType == "collection") $appID = $app->collectionId;

	//Save Non-Cached Images incase of problem
	$app->screenshotUrls_cached = $app->screenshotUrls;
	$app->ipadScreenshotUrls_cached = $app->ipadScreenshotUrls;
	$app->artworkUrl30_cached = $app->artworkUrl30;
	$app->artworkUrl60_cached = $app->artworkUrl60;
	$app->artworkUrl100_cached = $app->artworkUrl100;
	$app->artworkUrl512_cached = $app->artworkUrl512;
	if($app->artworkUrl30) $bestImage = $app->artworkUrl30;
	if($app->artworkUrl60) $bestImage = $app->artworkUrl60;
	if($app->artworkUrl100) $bestImage = $app->artworkUrl100;
	if($app->artworkUrl512) $bestImage = $app->artworkUrl512;
	$app->imageFeatured = $bestImage;
	$app->imageFeatured_cached = $bestImage;
	$app->imageiOS = $bestImage;
	$app->imageiOS_cached = $bestImage;
	$app->imageWidget = $bestImage;
	$app->imageWidget_cached = $bestImage;
	$app->imageLists = $bestImage;
	$app->imageLists_cached = $bestImage;
	$app->imagePosts = $bestImage;
	$app->imagePosts_cached = $bestImage;
	$app->imageElements = $bestImage;
	$app->imageElements_cached = $bestImage;
	
	
	if(!is_writeable(CACHE_DIRECTORY)) {
		//Uploads dir isn't writeable. bummer.
		appStore_set_setting('cache_images_locally', '0');
		return;
	} elseif(appStore_setting('cache_images_locally') == '1') {
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
			//$Newurl = "AppStore/". $appID . '/' . $urlname.".".$info['extension'];
			if($fp = fopen($Newpath, "w+")) {
				fwrite($fp, $content);
				fclose($fp);
				$settingName = $urlname."_cached";
				$app->$settingName = $Newurl;
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
			$app->imageFeatured_cached = CACHE_DIRECTORY_URL."AppStore/$appID/".$bestFileName."-featured.".$bestFileExt;
			$app->imageFeatured_path = CACHE_DIRECTORY."AppStore/$appID/".$bestFileName."-featured.".$bestFileExt;
		} else {
			$app->imageFeatured_cached = CACHE_DIRECTORY_URL."AppStore/$appID/$bestFileName.$bestFileExt";
			$app->imageFeatured_path = CACHE_DIRECTORY."AppStore/$appID/$bestFileName.$bestFileExt";
		}

 		if(appStore_setting('appicon_size_ios') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_ios');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'ios', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imageiOS_cached = CACHE_DIRECTORY_URL."AppStore/$appID/".$bestFileName."-ios.".$bestFileExt;
		} else {
			$app->imageiOS_cached = CACHE_DIRECTORY_URL."AppStore/$appID/$bestFileName.$bestFileExt";
		}


 		if(appStore_setting('appicon_size_widget') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_widget');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'widget', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imageWidget_cached = CACHE_DIRECTORY_URL."AppStore/$appID/".$bestFileName."-widget.".$bestFileExt;
		} else {
			$app->imageWidget_cached = CACHE_DIRECTORY_URL."AppStore/$appID/$bestFileName.$bestFileExt";
		}


 		if(appStore_setting('appicon_size_lists') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_lists');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'list', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imageLists_cached = CACHE_DIRECTORY_URL."AppStore/$appID/".$bestFileName."-list.".$bestFileExt;
		} else {
			$app->imageLists_cached = CACHE_DIRECTORY_URL."AppStore/$appID/$bestFileName.$bestFileExt";
		}

 		if(appStore_setting('appicon_size_posts') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_posts');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'post', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imagePosts_cached = CACHE_DIRECTORY_URL."AppStore/$appID/".$bestFileName."-post.".$bestFileExt;
		} else {
			$app->imagePosts_cached = CACHE_DIRECTORY_URL."AppStore/$appID/$bestFileName.$bestFileExt";
		}

 		if(appStore_setting('appicon_size_element') < $size['width']) {
			$editor = wp_get_image_editor( $bestFilePath );
 			$newSize = appStore_setting('appicon_size_element');
			$editor->resize( $newSize, $newSize, true );
			$filename = $editor->generate_filename( 'element', CACHE_DIRECTORY ."AppStore/". $appID . '/', NULL );
			$new_image_info = $editor->save($filename);		
			$app->imageElements_cached = CACHE_DIRECTORY_URL."AppStore/$appID/".$bestFileName."-element.".$bestFileExt;
		} else {
			$app->imageElements_cached = CACHE_DIRECTORY_URL."AppStore/$appID/$bestFileName.$bestFileExt";
		}		

		if($app->screenshotUrls) {
			foreach($app->screenshotUrls as $ssid=>$ssurl) {
				$content = appStore_fopen_or_curl($ssurl);
				$info = pathinfo(basename($ssurl));
				$Newname = "ios_ss_".$ssid.".".$info['extension'];
				$Newpath = CACHE_DIRECTORY ."AppStore/". $appID . '/' . $Newname;
				$Newurl = CACHE_DIRECTORY_URL ."AppStore/". $appID . '/' . $Newname;
				//$Newurl = "AppStore/". $appID . '/' . $Newname;
			
				if($fp = fopen($Newpath, "w+")) {
					fwrite($fp, $content);
					fclose($fp);
					if($info['extension'] == "jpg" || $info['extension'] == "png" || $info['extension'] == "jpeg") $screenshotUrls[] = $Newurl;
				} else {
					//Couldnt write the file. Permissions must be wrong.
					appStore_set_setting('cache_images_locally', '0');
					return;
				}
			}
			$app->screenshotUrls_cached = $screenshotUrls;

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
					if($info['extension'] == "jpg" || $info['extension'] == "png" || $info['extension'] == "jpeg") $iPadScreenshotUrls[] = $Newurl;
				} else {
					//Couldnt write the file. Permissions must be wrong.
					appStore_set_setting('cache_images_locally', '0');
					return;
				}
			}
			$app->ipadScreenshotUrls_cached = $iPadScreenshotUrls;
	
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

function appStore_shortenDescription($string){
     $string = substr($string,0,appStore_setting('max_description'));
     $string = substr($string,0,strrpos($string," "));
     return $string;
}
?>
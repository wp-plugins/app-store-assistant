<?php

// Set-up Action and Filter Hooks
register_activation_hook(__FILE__, 'appStore_add_defaults');
register_uninstall_hook(__FILE__, 'appStore_delete_plugin_options');
add_action('admin_init', 'appStore_init' );
add_action('admin_menu', 'appStore_add_options_page');
add_filter('plugin_action_links', 'appStore_plugin_action_links', 10, 2 );
add_action('admin_print_styles', 'appStore_admin_page_add_stylesheet');
add_action('admin_enqueue_scripts', 'load_js_files');

// Delete options table entries ONLY when plugin deactivated AND deleted
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

// Define default option settings

function appStore_add_defaults($ResetOptions = false) {
	$appStore_defaults = array(
		"max_description" => "400",
		"use_shortDesc_on_single" => "no",
		"use_shortDesc_on_multiple" => "yes",
		"smaller_buy_button_iOS" => "yes",
		"qty_of_apps" => "10",
		"ss_size" => "120",
		"currency_format" => "US",
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
		"displayreleasedate" => "no",
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

		"versionInstalled" => "4.5.1"
		);
	$tmp = get_option('appStore_options');
    if(!$tmp || !is_array($tmp) || $ResetOptions) {
		delete_option('appStore_options');
		update_option('appStore_options', $appStore_defaults);
	}
}

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

// Add menu page
function appStore_add_options_page() {
	add_options_page('AppStore Assistant', 'AppStore Assistant', 'manage_options', __FILE__, 'appStore_render_form');
}

// Render the Plugin options form
function appStore_render_form() {
	$options = get_option('appStore_options');
	if($options['ResetCheckOne']=="DoIt" && $options['ResetCheckTwo']=="DoIt" && $options['ResetCheckThree']=="DoIt") {
		appStore_add_defaults(true);
		$OptionsReset = true;
		$options = get_option('appStore_options');
		showMessage("All settings have been reset to their defaults!",true);
	}

	if($options['ResetCacheOne']=="DoIt" && $options['ResetCacheTwo']=="DoIt") {
		clearAppCache();
		update_option('ResetCacheOne', "NoWay");
		update_option('ResetCacheTwo', "NoWay");

		showMessage("The App data cache has been cleared!",true);
	}

	?>
	<div class="wrap">
		
		<div class="icon32" id="icon-options-general"><br /></div>
		<h2>AppStore Assistant Page Options</h2>
		
		<form method="post" action="options.php">
			<?php settings_fields('appStore_plugin_options'); ?>
			<?php if ($OptionsReset) 	echo '<h1><font color="red">All Options have been reset to defaults!</font></h1>'; ?>
<div class="tabs">
    <ul>
        <li><a href="#fragment-1"><span>General Options</span></a></li>
        <li><a href="#fragment-2"><span>Visual Elements</span></a></li>
        <li><a href="#fragment-3"><span>App Store Options</span></a></li>
        <li><a href="#fragment-4"><span>iTunes Store Options</span></a></li>
        <li><a href="#fragment-5"><span>Cache Options</span></a></li>
        <li><a href="#fragment-6"><span>Affiliate Networks</span></a></li>
        <li><a href="#fragment-7"><span>Reset</span></a></li>
    </ul>
    <div id="fragment-1">
    
    <h2 class="asa_admin">Short Description</h2>
		<div class="asa_admin">
		Max Length: <input type="text" size="4" name="appStore_options[max_description]" value="<?php echo $options['max_description']; ?>" maxlength="4" /> characters<br />
		<input type="checkbox" name="appStore_options[use_shortDesc_on_single]" value="yes" <?php if ($options['use_shortDesc_on_single'] == "yes") echo 'checked'; ?> /> Use on Single Post<br />
		<input type="checkbox" name="appStore_options[use_shortDesc_on_multiple]" value="yes" <?php if ($options['use_shortDesc_on_multiple'] == "yes") echo 'checked'; ?> /> Use on Multiple Post Page<br />
		</div>
    <h2 class="asa_admin">Localization</h2>
		<div class="asa_admin">
	
		Currency Type: <select name='appStore_options[currency_format]'>
					<option value="USD" <?php if ($options['currency_format'] == "USD") echo 'selected'; ?>>US ($ and &cent;)</option>
					<option value="EUR" <?php if ($options['currency_format'] == "EUR") echo 'selected'; ?>>Euro (&euro;)</option>
					<option value="GBP" <?php if ($options['currency_format'] == "GBP") echo 'selected'; ?>>United Kingdom Pound (&pound;)</option>
					<option value="NOK" <?php if ($options['currency_format'] == "NOK") echo 'selected'; ?>>Norway Krone (kr)</option>
					<option value="SEK" <?php if ($options['currency_format'] == "SEK") echo 'selected'; ?>>Sweden Krona (kr)</option>
					<option value="JPY" <?php if ($options['currency_format'] == "JPY") echo 'selected'; ?>>Japan Yen &yen;</option>
				</select><br />
		Show results from this country's store: <select name='appStore_options[store_country]'>
					<option value="US" <?php if ($options['store_country'] == "US") echo 'selected'; ?>>iTunes US</option>
					<option value="AT" <?php if ($options['store_country'] == "AT") echo 'selected'; ?>>iTunes AT</option>
					<option value="BE" <?php if ($options['store_country'] == "BE") echo 'selected'; ?>>iTunes BE</option>
					<option value="CH" <?php if ($options['store_country'] == "CH") echo 'selected'; ?>>iTunes CH</option>
					<option value="DE" <?php if ($options['store_country'] == "DE") echo 'selected'; ?>>iTunes DE</option>
					<option value="DK" <?php if ($options['store_country'] == "DK") echo 'selected'; ?>>iTunes DK</option>
					<option value="ES" <?php if ($options['store_country'] == "ES") echo 'selected'; ?>>iTunes ES</option>
					<option value="FI" <?php if ($options['store_country'] == "FI") echo 'selected'; ?>>iTunes FI</option>
					<option value="FR" <?php if ($options['store_country'] == "FR") echo 'selected'; ?>>iTunes FR</option>
					<option value="GB" <?php if ($options['store_country'] == "GB") echo 'selected'; ?>>iTunes GB</option>
					<option value="IE" <?php if ($options['store_country'] == "IE") echo 'selected'; ?>>iTunes IE</option>
					<option value="IT" <?php if ($options['store_country'] == "IT") echo 'selected'; ?>>iTunes IT</option>
					<option value="NL" <?php if ($options['store_country'] == "NL") echo 'selected'; ?>>iTunes NL</option>
					<option value="NO" <?php if ($options['store_country'] == "NO") echo 'selected'; ?>>iTunes NO</option>
					<option value="SE" <?php if ($options['store_country'] == "SE") echo 'selected'; ?>>iTunes SE</option>
				</select><br />
		<small>(Cached app data must be cleared for change to take effect. See <b>Reset</b> tab.)</small>
		</div>
	<h2 class="asa_admin">Miscellaneous</h2>
		<div class="asa_admin">
	
		<input type="checkbox" name="appStore_options[smaller_buy_button_iOS]" value="yes" <?php if ($options['smaller_buy_button_iOS'] == "yes") echo 'checked'; ?> /> Show a smaller Buy Button in iOS browsers<br /><br />
		Display <input type="text" size="3" name="appStore_options[qty_of_apps]" value="<?php echo $options['qty_of_apps']; ?>" maxlength="3" /> apps from ATOM feed<br /><br />
		Screenshot Width: <input type="text" size="3" maxlength="3" name="appStore_options[ss_size]" value="<?php echo $options['ss_size']; ?>" />px<br />
		<small>(in px. Height is automatic.)</small>
		</div>
	

    </div>
    <div id="fragment-2">
    	<?php
    	$starColors = array("clear", "black", "blue","bronze","faded","gold","green","grey","orange","pink","purple","red");
    	?>
    	<h2 class="asa_admin">Full Star:</h2>
		<?php
    	foreach ($starColors as $starColor) {
    		echo '<input type="radio" ';
    		echo 'name="appStore_options[full_star_color]" ';
    		echo 'value="'.$starColor.'"';
    		if ($options['full_star_color'] == $starColor) echo 'checked';
    		echo ' />';
    		echo '<img src="';
    		echo plugins_url( 'images/star-rating-'.$starColor.'.png', __FILE__ );
    		echo '" alt="'.$starColor.' Star" />';
    		echo '&nbsp;&nbsp;&nbsp;';    	
		}
		?>
		<h2 class="asa_admin">Empty Star:</h2>
		<?php
    	foreach ($starColors as $starColor) {
    		echo '<input type="radio" ';
    		echo 'name="appStore_options[empty_star_color]" ';
    		echo 'value="'.$starColor.'"';
    		if ($options['empty_star_color'] == $starColor) echo 'checked';
    		echo ' />';
    		echo '<img src="';
    		echo plugins_url( 'images/star-rating-'.$starColor.'.png', __FILE__ );
    		echo '" alt="'.$starColor.' Star" />';
    		echo '&nbsp;&nbsp;&nbsp;';    	
		}
		?>
		

	<h2 class="asa_admin">Colors</h2>
		<div class="asa_admin">     
<?php
	//define your color pickers
	$colorPickers = array(
		array('ID' => 'color_buttonStart', 'label' => 'Button Background Gradient Start'),
		array('ID' => 'color_buttonStop', 'label' => 'Button Background Gradient Stop'),
		array('ID' => 'color_buttonText', 'label' => 'Button Text'),
		array('ID' => 'color_buttonTextShadow', 'label' => 'Button Text Shadow'),
		array('ID' => 'color_buttonShadow', 'label' => 'Button Shadow'),
		array('ID' => 'color_buttonBorder', 'label' => 'Button Border'),
		array('ID' => 'color_buttonHoverStart', 'label' => 'Button Background Gradient Start (Hover)'),
		array('ID' => 'color_buttonHoverStop', 'label' => 'Button Background Gradient Stop (Hover)'),
		array('ID' => 'color_buttonHoverText', 'label' => 'Button Text (Hover)'),
	);

	foreach($colorPickers as $colorPicker) {
		echo "<div>\r";
		echo '<label for="'.$colorPicker['ID'].'">'.$colorPicker['label'].'</label>'."\r";
		echo '<input type="text" class="color" id="'.$colorPicker['ID'].'" ';
		echo 'value="'.$options[$colorPicker['ID']].'" ';
		echo 'name="appStore_options['.$colorPicker['ID'].']" size="6" />'."\r";
		echo '<div id="'.$colorPicker['ID'].'_color"></div>'."\r";
		echo '</div>'."\r";
	} ?>
		</div>
    </div>
    <div id="fragment-3">
		<h2 class="asa_admin">Show in Post body:</h2>
			<div class="asa_admin">
		<?php
    	$appStoreProperties = array(
    		array('ID' => "displayapptitle", 'label' => "App Name"),
    		array('ID' => "displayversion", 'label' => "App Version"),
    		array('ID' => "displayadvisoryrating", 'label' => "Advisory Rating"),
    		array('ID' => "displaycategories", 'label' => "App Categories"),
    		array('ID' => "displayfilesize", 'label' => "File Size"),
    		array('ID' => "displaystarrating", 'label' => "App Star Rating"),
    		array('ID' => "displaydevelopername", 'label' => "Developer Name"),
    		array('ID' => "displaysellername", 'label' => "Seller Name"),
    		array('ID' => "displaygamecenterenabled", 'label' => "Game Center Enabled icon"),
    		array('ID' => "displayuniversal", 'label' => "Universal App icon"),
    		array('ID' => "displaysupporteddevices", 'label' => "Supported Devices list"),
    		array('ID' => "displayreleasedate", 'label' => "Date Released"),
    	);
		foreach($appStoreProperties as $appStoreProperty) {
			echo '<input type="checkbox" name="appStore_options[';
			echo $appStoreProperty['ID'];
			echo ']" value="yes"';
			if ($options[$appStoreProperty['ID']] == "yes") echo ' checked';
			echo ' /> '.$appStoreProperty['label']."<br />\r";
		}
		?>
		</div>
		<h2 class="asa_admin">App Icon Size:</h2>
		<div class="asa_admin">
		Icon to start with: <input type="radio" name="appStore_options[appstoreicon_to_use]" value="60" <?php if ($options['appstoreicon_to_use'] == "60") echo 'checked'; ?> /> Small Icon (60px)&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="appStore_options[appstoreicon_to_use]" value="512" <?php if ($options['appstoreicon_to_use'] == "512") echo 'checked'; ?> /> Large Icon (512px or 1024px)<br /><br />
		
		<table class="asa_admin_table">
		<tr>
			<th><input type="radio" name="appStore_options[appstoreicon_size_adjust_type]" value="percent" <?php if ($options['appstoreicon_size_adjust_type'] == "percent") echo 'checked'; ?> /> Adjust by percentage</th>
			<th><input type="radio" name="appStore_options[appstoreicon_size_adjust_type]" value="pixels" <?php if ($options['appstoreicon_size_adjust_type'] == "pixels") echo 'checked'; ?> /> Adjust to max pixels</th>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[appicon_size_adjust]" value="<?php echo $options['appicon_size_adjust']; ?>" />%</td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[appicon_size_max]" value="<?php echo $options['appicon_size_max']; ?>" />px</td>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[appicon_iOS_size_adjust]" value="<?php echo $options['appicon_iOS_size_adjust']; ?>" />%<br /><small>(iOS browsers)</small></td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[appicon_iOS_size_max]" value="<?php echo $options['appicon_iOS_size_max']; ?>" />px<br /><small>(iOS browsers)</small></td>
		</tr>
		</table>		
		</div>
		
		
    </div>
    <div id="fragment-4">
   		<h2 class="asa_admin">Show in Post body:</h2>
   		<div class="asa_admin">
  		<?php
    	$iTunesStoreProperties = array(
    		array('ID' => "displayitunestitle", 'label' => "Music Title"),
    		array('ID' => "displayitunestrackcount", 'label' => "Track Count"),
    		array('ID' => "displayitunesartistname", 'label' => "Artist Name"),
    		array('ID' => "displayitunesfromalbum", 'label' => "From Album&hellip;"),
    		array('ID' => "displayitunesgenre", 'label' => "Genre"),
    		array('ID' => "displayitunesreleasedate", 'label' => "Release Date"),
    		array('ID' => "displayitunesdescription", 'label' => "Description"),
    		array('ID' => "displayitunesexplicitwarning", 'label' => "Explicit Lyrics Bagde"),
    	);
		foreach($iTunesStoreProperties as $iTunesStoreProperty) {
			echo '<input type="checkbox" name="appStore_options[';
			echo $iTunesStoreProperty['ID'];
			echo ']" value="yes"';
			if ($options[$iTunesStoreProperty['ID']] == "yes") echo ' checked';
			echo ' /> '.$iTunesStoreProperty['label']."<br />\r";
		}
		?>
		</div>
		<h2 class="asa_admin">App Icon Size:</h2>
		<div class="asa_admin">
		Icon to start with: <input type="radio" name="appStore_options[itunesicon_to_use]" value="30" <?php if ($options['itunesicon_to_use'] == "30") echo 'checked'; ?> /> 30px 
		<input type="radio" name="appStore_options[itunesicon_to_use]" value="60" <?php if ($options['itunesicon_to_use'] == "60") echo 'checked'; ?> /> 60px 
		<input type="radio" name="appStore_options[itunesicon_to_use]" value="100" <?php if ($options['itunesicon_to_use'] == "100") echo 'checked'; ?> /> 100px
		<br /><br />
		
		<table class="asa_admin_table">
		<tr>
			<th><input type="radio" name="appStore_options[itunesicon_size_adjust_type]" value="percent" <?php if ($options['itunesicon_size_adjust_type'] == "percent") echo 'checked'; ?> /> Adjust by percentage</th>
			<th><input type="radio" name="appStore_options[itunesicon_size_adjust_type]" value="pixels" <?php if ($options['itunesicon_size_adjust_type'] == "pixels") echo 'checked'; ?> /> Adjust to max pixels</th>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[itunesicon_size_adjust]" value="<?php echo $options['itunesicon_size_adjust']; ?>" />%</td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[itunesicon_size_max]" value="<?php echo $options['itunesicon_size_max']; ?>" />px</td>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[itunesicon_iOS_size_adjust]" value="<?php echo $options['itunesicon_iOS_size_adjust']; ?>" />%<br /><small>(iOS browsers)</small></td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[itunesicon_iOS_size_max]" value="<?php echo $options['itunesicon_iOS_size_max']; ?>" />px<br /><small>(iOS browsers)</small></td>
		</tr>
		</table>		
		</div>
		
		
		
	</div>    
    <div id="fragment-5">
    	<h2 class="asa_admin">Data cache time:</h2>
    	<div class="asa_admin">
    	<select name='appStore_options[cache_time_select_box]'>
				
					<?php $cache_intervals = array(
												'Don\'t cache'=>0,
												'1 minute'=>1*60,
												'5 minutes'=>5*60,
												'10 minutes'=>10*60,
												'30 minutes'=>30*60,
												'1 hour'=>1*60*60,
												'6 hours'=>6*60*60,
												'12 hours'=>12*60*60,
												'24 hours'=>24*60*60,
												'1 Week'=>24*60*60*7,
												'1 Month'=>24*60*60*7*30,
												'1 Year'=>24*60*60*7*30*365
											);
					
					foreach ($cache_intervals as $key => $value) {
						echo '<option value="' . $value . '" ' . selected($value, $options['cache_time_select_box']) . '>' . $key . '</option>';
					}						
					?>							
				</select>
				<span style="color:#666666;margin-left:2px;">This option determines how long before the plugin requests new data from Apple's servers. You can clear the cached app data via the Reset tab.</span>
		</div>		
		<h2 class="asa_admin">Cache images locally:</h2>
		<div class="asa_admin">
		<!-- First checkbox button -->
						<label><input name="appStore_options[cache_images_locally]" type="checkbox" value="1" <?php if (isset($options['cache_images_locally'])) { checked('1', $options['cache_images_locally']); } ?> /> Load icons, screenshots, etc. locally instead of using Apple's CDN server.</label><br /><small>Your wp-content/uploads/ directory MUST be writeable for this option to have any effect.</small>
		</div>
				
    </div>
    <div id="fragment-6">
        <table class="form-table">
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">Affiliate Networks</th>
				</tr>
				<tr>
					<th scope="row">Affiliate Network:<br /></th>
					<td colspan="2">
					<select name="appStore_options[affiliatepartnerid]">
					<option value="999" <?php if ($options['affiliatepartnerid'] == "999") echo 'selected'; ?>>None</option>
					<option value="30" <?php if ($options['affiliatepartnerid'] == "30") echo 'selected'; ?>>LinkShare</option>
					<option value="2003" <?php if ($options['affiliatepartnerid'] == "2003") echo 'selected'; ?>>TradeDoubler</option>
					<option value="1002" <?php if ($options['affiliatepartnerid'] == "1002") echo 'selected'; ?>>DGM</option>
					</select>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">LinkShare Settings</th>
				</tr>

				<tr>
					<td scope="row"></td><td colspan="2"><p>1.  The easiest way to get your LinkShare Wrapper is to first get an example link to use as a guideline. You can do this by logging into your LinkShare dashboard and navigating to the Link Maker tool. Once there, make sure the country pop-up menu matches the affiliate program you just came through. Next, search for anything you like, click one of the results, and take the chunk of HTML that is given to you in step 3. It should look similar to this: </p>
<p><code>&lt;a href=&quot;http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30&quot; target=&quot;itunes_store&quot;&gt;&lt;img height=&quot;15&quot; width=&quot;61&quot; alt=&quot;Pearl Jam - Backspacer - Just Breathe&quot; src=&quot;http://ax.phobos.apple.com.edgesuite.net/images/badgeitunes61x15dark.gif&quot; /&gt;&lt;/a&gt;</code></p>
<p>2. From your chunk of HTML, grab the actual link in the HREF tag. For example: </p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30</code></p>
<p>3. From the actual link, you now need to cut out the "wrapper." This is the part of the affiliate link that stays the same. This can be identified as everything in the beginning of link up through the <code>RD_PARM1=</code>. For example: </p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=</code></p>
<hr>
<p>When using LinkShare, the affiliate token is siteID. This value is your 11-character encrypted ID that exists as the "id" value in any other LinkShare built link. The easiest way to find this value is to build a sample link using the Link Maker tool as defined in steps 1 and 2 earlier in the Affiliate Encoding for LinkShare section. For example, the siteID for an account that generated the following link would be: CBIMl*gYY/8.</p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30</code></p>
				</td>
				</tr>
				<tr>
					<th scope="row">LinkShare Wrapper:</th>
					<td colspan="2">
						<input type="text" size="80" name="appStore_options[affiliatecode]" value="<?php echo $options['affiliatecode']; ?>" />
					</td>
				</tr>
				<th scope="row">LinkShare Affiliate Token:</th>
					<td colspan="2">
						<input type="text" size="11" name="appStore_options[affiliatetoken]" value="<?php echo $options['affiliatetoken']; ?>" maxlength="11" />
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">TradeDoubler Settings</th>
				</tr>
				<tr>
					<td scope="row"></td><td colspan="2"><p>TradeDoubler offers the iTunes and App Store Affiliate Program as separate programs in 14 different countries. You need to be accepted into at least one country to be able to link in Europe. If you need to link to several EU countries for which you don't yet have an affiliate account, you can enable this directly on the TradeDoubler portal (Settings -> Site Information -> My Countries).</p><p>To create an affiliate tracking link for TradeDoubler (Europe), you will need your program ID and website ID. These can be found on the TradeDoubler affiliate dashboard (Under "Settings" then "Site information").</p>
					</td>
				</tr>
				<tr>
				<th scope="row">TradeDoubler websiteID:</th>
					<td colspan="2">
						<input type="text" size="20" name="appStore_options[tdwebsiteID]" value="<?php echo $options['tdwebsiteID']; ?>"/>
					</td>
				</tr>
				<tr>
					<th scope="row">TradeDoubler Program ID:<br /></th>
					<td colspan="2">
					<select name="appStore_options[tdprogramID]">
					<option value="24380" <?php if ($options['tdprogramID'] == "24380") echo 'selected'; ?>>iTunes AT</option>
					<option value="24379" <?php if ($options['tdprogramID'] == "24379") echo 'selected'; ?>>iTunes BE</option>
					<option value="24372" <?php if ($options['tdprogramID'] == "24372") echo 'selected'; ?>>iTunes CH</option>
					<option value="23761" <?php if ($options['tdprogramID'] == "23761") echo 'selected'; ?>>iTunes DE</option>
					<option value="24375" <?php if ($options['tdprogramID'] == "24375") echo 'selected'; ?>>iTunes DK</option>
					<option value="24364" <?php if ($options['tdprogramID'] == "24364") echo 'selected'; ?>>iTunes ES</option>
					<option value="24366" <?php if ($options['tdprogramID'] == "24366") echo 'selected'; ?>>iTunes FI</option>
					<option value="23753" <?php if ($options['tdprogramID'] == "23753") echo 'selected'; ?>>iTunes FR</option>
					<option value="23708" <?php if ($options['tdprogramID'] == "23708") echo 'selected'; ?>>iTunes GB</option>
					<option value="24367" <?php if ($options['tdprogramID'] == "24367") echo 'selected'; ?>>iTunes IE</option>
					<option value="24373" <?php if ($options['tdprogramID'] == "24373") echo 'selected'; ?>>iTunes IT</option>
					<option value="24371" <?php if ($options['tdprogramID'] == "24371") echo 'selected'; ?>>iTunes NL</option>
					<option value="24369" <?php if ($options['tdprogramID'] == "24369") echo 'selected'; ?>>iTunes NO</option>
					<option value="23762" <?php if ($options['tdprogramID'] == "23762") echo 'selected'; ?>>iTunes SE</option>
					</select>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">DGM Settings</th>
				</tr>
				<tr>
					<td scope="row"></td><td colspan="2"><p>Following these steps will allow you to create an affiliate link for the Australia or New Zealand program. Before you begin, it is important to make sure you have been approved for these accounts and have access to them. </p>
<p>1.  The easiest way to start building your affiliate links is to first get an example. You can do this by logging into your DGM dashboard and navigating to the Link Maker tool. Once there, make sure the country pop-up menu matches the affiliate program you just came through. Next, search for anything you like, click one of the results, and take the chunk of HTML that is then given to you. It should look similar to this: </p>
<p><code>&lt;a href=&quot;http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=http%3A%2F%2Fitunes.apple.com%2Fau%2Falbum%2Fthe-fixer%2Fid327780123%3Fi%3D327780135%26uo%3D6%26partnerId%3D1002&quot; target=&quot;itunes_store&quot;&gt;&lt;img height=&quot;15&quot; width=&quot;61&quot; alt=&quot;Pearl Jam - Backspacer - The Fixer&quot; src=&quot;http://ax.phobos.apple.com.edgesuite.net/images/badgeitunes61x15dark.gif&quot; /&gt;&lt;/a&gt;</code></p>
<p>2. From your chunk of HTML, grab the actual link in the HREF tag. For example: </p>
<p><code>http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=http%3A%2F%2Fitunes.apple.com%2Fau%2Falbum%2Fthe-fixer%2Fid327780123%3Fi%3D327780135%26uo%3D6%26partnerId%3D1002</code></p>
<p>3. From the actual link, you now need to cut out the "wrapper." This is the part of the affiliate link that stays the same. This can be identified as everything in the link up through the "<code>t=</code>". For example: </p>
<p><code>http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=</code></p>
					</td>
				</tr>
				<tr>
				<th scope="row">DGM wrapper:</th>
					<td colspan="2">
						<input type="text" size="50" name="appStore_options[dgmwrapper]" value="<?php echo $options['dgmwrapper']; ?>"/>
					</td>
				</tr>
			</table>
    </div>
	<div id="fragment-7">
		<h2 class="asa_admin">Reset All Settings to Defaults:</h2>
		<div class="asa_admin">
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCheckOne]" /> I want to reset all settings to their defaults.<br /><br />
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCheckTwo]" /> I know this will not save any of my changes.<br /><br />
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCheckThree]" /> I wont get mad when all my changes are lost.<br /><br />
		</div>
		<h2 class="asa_admin">Reset cached App data:</h2>
		<div class="asa_admin">
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCacheOne]" /> I want to reset all cached app data.<br /><br />
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCacheTwo]" /> I know this will slow down my site as it rebuilds.
		</div>
	</div>
   
</div>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	
    <hr>
    
    <div class="asa_admin_donate">
		<h3 class="hndle"><span><strong class="red">Like this plugin?</strong></span></h3>
		<div class="inside">
			<p><strong>Want to help make it better? All donations are used to improve this plugin, so donate now!</strong></p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick" /> <input type="hidden" name="hosted_button_id" value="8RDJYGJSNF9LY" /> <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="PayPal - The safer, easier way to pay online!" /> <img src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" alt="" width="1" height="1" border="0" /></form>
<p>Or you could:</p><ul><li><a href="http://wordpress.org/extend/plugins/app-store-assistant/">Rate the plugin 5★ on WordPress.org</a></li></ul>
		</div>
	</div>	
	
<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function appStore_validate_options($input) {
	return $input;
}

function clearAppCache() {
	global $wpdb;
	$options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'appStore_appData_%'");
	//print_r($options);
	if ( is_null($options) ) return false;
	foreach( $options as $option ) {
		delete_option( $option->option_name );
		//echo $option->option_name."\r\n"; 
 	} 

}

function showMessage($message, $errormsg = false)
{
	if ($errormsg) {
		echo '<div id="message" class="error">';
	}
	else {
		echo '<div id="message" class="updated fade">';
	}

	echo "<p><strong>$message</strong></p></div>";
}

// Display a Settings link on the main Plugins page
function appStore_plugin_action_links( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) ) {
		$appStore_links = '<a href="'.get_admin_url().'options-general.php?page=plugin-options-starter-kit/plugin-options-starter-kit.php">'.__('Settings').'</a>';
		// make the 'Settings' link appear first
		array_unshift( $links, $appStore_links );
	}
	return $links;
}

function load_js_files() {
 	wp_enqueue_script('jquerymenusstart', plugins_url('/js_functions/jquerymenusstart.js',__FILE__), null, null, true);
	wp_enqueue_script('jscolor', plugins_url('/js_functions/jscolor/jscolor.js',__FILE__), null, null, true);
}

function appStore_admin_page_add_stylesheet() {
	wp_register_style('appStore-admin-styles', plugins_url( 'appStore-admin.css', __FILE__ ));
	wp_enqueue_style( 'appStore-admin-styles');
}

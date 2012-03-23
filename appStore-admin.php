<?php

// Set-up Action and Filter Hooks
register_activation_hook(__FILE__, 'appStore_add_defaults');
register_uninstall_hook(__FILE__, 'appStore_delete_plugin_options');
add_action('admin_init', 'appStore_init' );
add_action('admin_menu', 'appStore_add_options_page');
add_filter( 'plugin_action_links', 'appStore_plugin_action_links', 10, 2 );

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
function appStore_add_defaults() {
	$tmp = get_option('appStore_options');
    if(!$tmp || !is_array($tmp)) {
		delete_option('appStore_options');
		$arr = array(	"affiliatecode" => "http://click.linksynergy.com/fs-bin/stat?id=uiuOb3Yu7Hg&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=",
						"affiliatetoken" => "uiuOb3Yu7Hg",
						"affiliatepartnerid" => "30",
						"tdwebsiteID" => "",
						"tdprogramID" => "23708",
						"dgmwrapper" => "",
						"displaystarrating" => "yes",
						"displayadvisoryrating" => "yes",
						"displaycategories" => "yes",
						"displayversion" => "yes",
						"displaydevelopername" => "yes",
						"displaysellername" => "yes",
						"displaygamecenterenabled" => "yes",
						"displayuniversal" => "yes",
						"displayreleasedate" => "yes",
						"displaysupporteddevices" => "yes",
						"displayfilesize" => "yes",
						"displayapptitle" => "yes",
						"max_description" => "300",
						"qty_of_apps" => "10",
						"icon_size" => "128",
						"ss_size" => "120",
						"cache_time_select_box" => (24*60*60),
						"cache_images_locally" => "1"
		);
		update_option('appStore_options', $arr);
	}
}


// Init plugin options to white list our options
function appStore_init(){

	$settings = get_option('appStore_options');

	if(!$settings) appStore_add_defaults();
	register_setting( 'appStore_plugin_options', 'appStore_options', 'appStore_validate_options' );
}

// Add menu page
function appStore_add_options_page() {
	add_options_page('AppStore Assistant', 'AppStore Assistant', 'manage_options', __FILE__, 'appStore_render_form');
}

// Render the Plugin options form
function appStore_render_form() {
	?>
	<div class="wrap">
		
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>AppStore Assistant Page Options</h2>

		<form method="post" action="options.php">
			<?php settings_fields('appStore_plugin_options'); ?>
			<?php $options = get_option('appStore_options'); ?>

			<table class="form-table">
				<tr>
					<th scope="row" colspan="2" style="background-color: #B3B3B3;font-weight: bold;">Affiliate Networks</th>
				</tr>
				<tr>
					<th scope="row">Affiliate Network:<br /></th>
					<td>
					<select name="appStore_options[affiliatepartnerid]">
					<option value="999" <?php if ($options['affiliatepartnerid'] == "999") echo 'selected'; ?>>None</option>
					<option value="30" <?php if ($options['affiliatepartnerid'] == "30") echo 'selected'; ?>>LinkShare</option>
					<option value="2003" <?php if ($options['affiliatepartnerid'] == "2003") echo 'selected'; ?>>TradeDoubler</option>
					<option value="1002" <?php if ($options['affiliatepartnerid'] == "1002") echo 'selected'; ?>>DGM</option>
					</select>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2" style="background-color: #B3B3B3;font-weight: bold;">LinkShare Settings</th>
				</tr>

				<tr>
					<td scope="row"></td><td><p>1.  The easiest way to get your LinkShare Wrapper is to first get an example link to use as a guideline. You can do this by logging into your LinkShare dashboard and navigating to the Link Maker tool. Once there, make sure the country pop-up menu matches the affiliate program you just came through. Next, search for anything you like, click one of the results, and take the chunk of HTML that is given to you in step 3. It should look similar to this: </p>
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
					<td>
						<input type="text" size="80" name="appStore_options[affiliatecode]" value="<?php echo $options['affiliatecode']; ?>" />
					</td>
				</tr>
				<th scope="row">LinkShare Affiliate Token:</th>
					<td>
						<input type="text" size="11" name="appStore_options[affiliatetoken]" value="<?php echo $options['affiliatetoken']; ?>" maxlength="11" />
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2" style="background-color: #B3B3B3;font-weight: bold;">TradeDoubler Settings</th>
				</tr>
				<tr>
					<td scope="row"></td><td><p>TradeDoubler offers the iTunes and App Store Affiliate Program as separate programs in 14 different countries. You need to be accepted into at least one country to be able to link in Europe. If you need to link to several EU countries for which you don't yet have an affiliate account, you can enable this directly on the TradeDoubler portal (Settings -> Site Information -> My Countries).</p><p>To create an affiliate tracking link for TradeDoubler (Europe), you will need your program ID and website ID. These can be found on the TradeDoubler affiliate dashboard (Under "Settings" then "Site information").</p>
					</td>
				</tr>
				<tr>
				<th scope="row">TradeDoubler websiteID:</th>
					<td>
						<input type="text" size="20" name="appStore_options[tdwebsiteID]" value="<?php echo $options['tdwebsiteID']; ?>"/>
					</td>
				</tr>
				<tr>
					<th scope="row">TradeDoubler Program ID:<br /></th>
					<td>
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
					<th scope="row" colspan="2" style="background-color: #B3B3B3;font-weight: bold;">DGM Settings</th>
				</tr>
				<tr>
					<td scope="row"></td><td><p>Following these steps will allow you to create an affiliate link for the Australia or New Zealand program. Before you begin, it is important to make sure you have been approved for these accounts and have access to them. </p>
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
					<td>
						<input type="text" size="20" name="appStore_options[dgmwrapper]" value="<?php echo $options['dgmwrapper']; ?>"/>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2" style="background-color: #B3B3B3;font-weight: bold;">Display Options</th>
				</tr>
				<tr>
					<th scope="row">Show in Post body:</th>
					<td><input type="checkbox" name="appStore_options[displayapptitle]" value="yes" <?php if ($options['displayapptitle'] == "yes") echo 'checked'; ?> /> App Name<br>
					<input type="checkbox" name="appStore_options[displayversion]" value="yes" <?php if ($options['displayversion'] == "yes") echo 'checked'; ?> /> App Version<br>
					<input type="checkbox" name="appStore_options[displayadvisoryrating]" value="yes" <?php if ($options['displayadvisoryrating'] == "yes") echo 'checked'; ?> /> Advisory Rating<br>
					<input type="checkbox" name="appStore_options[displaycategories]" value="yes" <?php if ($options['displaycategories'] == "yes") echo 'checked'; ?> /> App Categories<br>
					<input type="checkbox" name="appStore_options[displayfilesize]" value="yes" <?php if ($options['displayfilesize'] == "yes") echo 'checked'; ?> /> File Size<br>
					<input type="checkbox" name="appStore_options[displaystarrating]" value="yes" <?php if ($options['displaystarrating'] == "yes") echo 'checked'; ?> /> App Star Rating<br>
					<input type="checkbox" name="appStore_options[displaydevelopername]" value="yes" <?php if ($options['displaydevelopername'] == "yes") echo 'checked'; ?> /> Developer Name<br>
					<input type="checkbox" name="appStore_options[displaysellername]" value="yes" <?php if ($options['displaysellername'] == "yes") echo 'checked'; ?> /> Seller Name<br>
					<input type="checkbox" name="appStore_options[displaygamecenterenabled]" value="yes" <?php if ($options['displaygamecenterenabled'] == "yes") echo 'checked'; ?> /> Game Center Enabled icon<br>
					<input type="checkbox" name="appStore_options[displayuniversal]" value="yes" <?php if ($options['displayuniversal'] == "yes") echo 'checked'; ?> /> Universal App icon<br>
					<input type="checkbox" name="appStore_options[displaysupporteddevices]" value="yes" <?php if ($options['displaysupporteddevices'] == "yes") echo 'checked'; ?> /> Supported Devices list<br>
					<input type="checkbox" name="appStore_options[displayreleasedate]" value="yes" <?php if ($options['displayreleasedate'] == "yes") echo 'checked'; ?> /> Date Released<br>
					</td>
				</tr>







				<tr>
					<th scope="row">Max Short Description Length:<br /><small>For "My Picks" list pages.</small></th>
					<td>
						<input type="text" size="4" name="appStore_options[max_description]" value="<?php echo $options['max_description']; ?>" maxlength="4" />
					</td>
				</tr>
				<tr>
					<th scope="row">How many apps to display from ATOM feed:</th>
					<td>
						<input type="text" size="3" name="appStore_options[qty_of_apps]" value="<?php echo $options['qty_of_apps']; ?>" maxlength="3" />
					</td>
				</tr>

				<tr>
					<th scope="row">App Icon Width/Height:<br /><small>(in px.)</small></th>
					<td>
						<input type="text" size="10" name="appStore_options[icon_size]" value="<?php echo $options['icon_size']; ?>" />
					</td>
				</tr>

				<tr>
					<th scope="row">Screenshot Width:<br /><small>(in px. Height is automatic.)</small></th>
					<td>
						<input type="text" size="10" name="appStore_options[ss_size]" value="<?php echo $options['ss_size']; ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="2" style="background-color: #B3B3B3;font-weight: bold;">Cache Options</th>
				</tr>

				<tr>
					<th scope="row">Data cache time:</th>
					<td>
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
						<span style="color:#666666;margin-left:2px;">This option determines how long before the plugin requests new data from Apple's servers.</span>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">Cache images locally:</th>
					<td>
						<!-- First checkbox button -->
						<label><input name="appStore_options[cache_images_locally]" type="checkbox" value="1" <?php if (isset($options['cache_images_locally'])) { checked('1', $options['cache_images_locally']); } ?> /> Yes</label><br />
						<span style="color:#666666;margin-left:2px;">Load icons, screenshots, etc. locally instead of using Apple's CDN server. Your wp-content/uploads/ directory MUST be writeable for this option to have any effect.</span>
					</td>
				</tr>

			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function appStore_validate_options($input) {
	return $input;
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
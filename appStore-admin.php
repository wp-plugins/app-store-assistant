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
		$arr = array(	"affiliatecode" => "apple.com",
						"affiliatepartnerid" => "30",
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
					<th scope="row">Affiliate click-tracking URL:<br /><small>(ex: http://click.linksynergy.com/fs-bin/stat?id=aaaaaaaaaa&offerid=112345&type=3&subid=0&tmpid=1234&RD_PARM1=)</small></th>
					<td>
						<input type="text" size="80" name="appStore_options[affiliatecode]" value="<?php echo $options['affiliatecode']; ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">Affiliate Link Partner ID:<br /><small>(ex: 30)</small></th>
					<td>
						<input type="text" size="10" name="appStore_options[affiliatepartnerid]" value="<?php echo $options['affiliatepartnerid']; ?>" />
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
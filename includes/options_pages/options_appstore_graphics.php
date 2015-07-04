<table class="asa_form-table">
<tr valign="top">
<th scope="row"><label><?php _e('App Stores Badge Verbage', 'appStoreAssistant' ); ?></label></th>
<td><select name='appStore_options[appStore_store_badge_type]'>
	<option value="download" <?php if ($options['appStore_store_badge_type'] == "download") echo 'selected'; ?>><?php _e('Download on the App Store', 'appStoreAssistant' ); ?></option>
	
</select></td>
</tr>

<tr valign="top">
<th scope="row"><label><?php _e('App Stores Badge Size', 'appStoreAssistant' ); ?></label></th>
<td><select name='appStore_options[appStore_store_badge_size]'>
	<option value=".5" <?php if ($options['appStore_store_badge_size'] == ".5") echo 'selected'; ?>>Half</option>
	<option value="1" <?php if ($options['appStore_store_badge_size'] == "1") echo 'selected'; ?>>Full Size</option>
	<option value="1.5" <?php if ($options['appStore_store_badge_size'] == "1.5") echo 'selected'; ?>>1.5x</option>
	<option value="2" <?php if ($options['appStore_store_badge_size'] == "2") echo 'selected'; ?>>2x</option>
	<option value="2.5" <?php if ($options['appStore_store_badge_size'] == "2.5") echo 'selected'; ?>>2.5x</option>
	
</select> * Full Size is 135px x 40px</td>
</tr>


<tr valign="top">
<th scope="row"><label><?php _e('iDevice "Supported Devices" icon style', 'appStoreAssistant' ); ?></label></th>
<td><?php
		echo '<select name="appStore_options[displayappdetailsasliststyle]">';
		echo '<option value="bw" ';
		if ($options['displayappdetailsasliststyle'] == "bw") echo 'selected';
		echo '>'.__('Greyscale Icons', 'appStoreAssistant' ).'</option>';
		echo '<option value="color" ';
		if ($options['displayappdetailsasliststyle'] == "color") echo 'selected';
		echo '>'.__('Color Icons', 'appStoreAssistant' ).'</option>';
		echo '</select>';
	?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label><?php _e('iDevice "Supported Devices" sorting', 'appStoreAssistant' ); ?></label></th>
<td><?php
		echo '<select name="appStore_options[displayappdetailsaslistssort]">';
		echo '<option value="releasedate" ';
		if ($options['displayappdetailsaslistssort'] == "releasedate") echo 'selected';
		echo '>'.__('iDevice Release Date (Old to New)', 'appStoreAssistant' ).'</option>';
		echo '<option value="releasedate_reversed" ';
		if ($options['displayappdetailsaslistssort'] == "releasedate_reversed") echo 'selected';
		echo '>'.__('iDevice Release Date (New to Old)', 'appStoreAssistant' ).'</option>';
		echo '<option value="alphabetically" ';
		if ($options['displayappdetailsaslistssort'] == "alphabetically") echo 'selected';
		echo '>'.__('Alphabetically', 'appStoreAssistant' ).'</option>';
		echo '<option value="alphabetically_reversed" ';
		if ($options['displayappdetailsaslistssort'] == "alphabetically_reversed") echo 'selected';
		echo '>'.__('Reversed Alphabetically', 'appStoreAssistant' ).'</option>';
		echo '</select>';
	?>
</td>
</tr>



<tr valign="top">
<th scope="row" nobr><label><?php _e('Supported Devices Single Post', 'appStoreAssistant' ); ?></label></th>
<td><?php
		echo '<select name="appStore_options[displaysupporteddevicesType]">';
		echo '<option value="List" ';
		if ($options['displaysupporteddevicesType'] == "List") echo 'selected';
		echo '>'.__('Text List', 'appStoreAssistant' ).'</option>';
		echo '<option value="Minimal" ';
		if ($options['displaysupporteddevicesType'] == "Minimal") echo 'selected';
		echo '>'.__('Minimal Icons', 'appStoreAssistant' ).'</option>';
		echo '<option value="Normal" ';
		if ($options['displaysupporteddevicesType'] == "Normal") echo 'selected';
		echo '>'.__('Normal Icons', 'appStoreAssistant' ).'</option>';
		echo '</select>';
	?></td>
</tr>
<tr valign="top">
<th scope="row"><label><?php _e('Supported Devices Multiple Posts', 'appStoreAssistant' ); ?></label></th>
<td><?php
		echo '<select name="appStore_options[displaympsupporteddevicesType]">';
		echo '<option value="List" ';
		if ($options['displaympsupporteddevicesType'] == "List") echo 'selected';
		echo '>'.__('Text List', 'appStoreAssistant' ).'</option>';
		echo '<option value="Minimal" ';
		if ($options['displaympsupporteddevicesType'] == "Minimal") echo 'selected';
		echo '>'.__('Minimal Icons', 'appStoreAssistant' ).'</option>';
		echo '<option value="Normal" ';
		if ($options['displaympsupporteddevicesType'] == "Normal") echo 'selected';
		echo '>'.__('Normal Icons', 'appStoreAssistant' ).'</option>';
		echo '</select>';
	?>
</td>
</tr>
</table>
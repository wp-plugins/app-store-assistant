<table class="form-table">
<tr valign="top">
<th scope="row"><label>App Stores Badge Verbage</label></th>
<td><select name='appStore_options[appStore_store_badge_type]'>
	<option value="available" <?php if ($options['appStore_store_badge_type'] == "available") echo 'selected'; ?>>Available on the App Store</option>
	<option value="download" <?php if ($options['appStore_store_badge_type'] == "download") echo 'selected'; ?>>Download on the App Store</option>
</select></td>
</tr>
<tr valign="top">
<th scope="row"><label>iDevice List icon style</label></th>
<td><?php
		echo '<select name="appStore_options[displayappdetailsasliststyle]">';
		echo '<option value="bw" ';
		if ($options['displayappdetailsasliststyle'] == "bw") echo 'selected';
		echo '>B&W Icons</option>';
		echo '<option value="color" ';
		if ($options['displayappdetailsasliststyle'] == "color") echo 'selected';
		echo '>Color Icons</option>';
		echo '</select>';
	?>
</td>
</tr>

<tr valign="top">
<th scope="row" nobr><label>Supported&nbsp;Devices&nbsp;Single&nbsp;Post</label></th>
<td><?php
		echo '<select name="appStore_options[displaysupporteddevicesType]">';
		echo '<option value="List" ';
		if ($options['displaysupporteddevicesType'] == "List") echo 'selected';
		echo '>Text List</option>';
		echo '<option value="Minimal" ';
		if ($options['displaysupporteddevicesType'] == "Minimal") echo 'selected';
		echo '>Minimal Icons</option>';
		echo '<option value="Normal" ';
		if ($options['displaysupporteddevicesType'] == "Normal") echo 'selected';
		echo '>Normal Icons</option>';
		echo '</select>';
	?></td>
</tr>
<tr valign="top">
<th scope="row"><label>Supported&nbsp;Devices&nbsp;Multiple&nbsp;Posts</label></th>
<td><?php
		echo '<select name="appStore_options[displaympsupporteddevicesType]">';
		echo '<option value="List" ';
		if ($options['displaympsupporteddevicesType'] == "List") echo 'selected';
		echo '>Text List</option>';
		echo '<option value="Minimal" ';
		if ($options['displaympsupporteddevicesType'] == "Minimal") echo 'selected';
		echo '>Minimal Icons</option>';
		echo '<option value="Normal" ';
		if ($options['displaympsupporteddevicesType'] == "Normal") echo 'selected';
		echo '>Normal Icons</option>';
		echo '</select>';
	?>
</td>
</tr>



</table>
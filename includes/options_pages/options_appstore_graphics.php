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
<td><input type="radio" name="appStore_options[displayappdetailsasliststyle]" value="bw" <?php if ($options['displayappdetailsasliststyle'] == "bw") echo 'checked'; ?> /> B&W<br />
<input type="radio" name="appStore_options[displayappdetailsasliststyle]" value="color" <?php if ($options['displayappdetailsasliststyle'] == "color") echo 'checked'; ?> /> Color
</td>
</tr>
</table>
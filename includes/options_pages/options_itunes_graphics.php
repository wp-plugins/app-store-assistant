<h2 class="asa_admin">iTunes Store Badge</h2>
<table class="form-table">
<tr valign="top">
<th scope="row"><label>iTunes Store Badge Verbage</label></th>
<td><select name='appStore_options[iTunes_store_badge_type]'>
	<option value="available" <?php if ($options['iTunes_store_badge_type'] == "available") echo 'selected'; ?>>Available on iTunes</option>
	<option value="download" <?php if ($options['iTunes_store_badge_type'] == "download") echo 'selected'; ?>>Download on iTunes</option>
</select></td>
</tr>
</table>	

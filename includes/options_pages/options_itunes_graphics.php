<h2 class="asa_admin"><?php _e('iTunes Store Badge', 'appStoreAssistant' ); ?></h2>
<table class="asa_form-table">
<tr valign="top">
<th scope="row"><label><?php _e('iTunes Store Badge Verbage', 'appStoreAssistant' ); ?></label></th>
<td><select name='appStore_options[iTunes_store_badge_type]'>
	<option value="available" <?php if ($options['iTunes_store_badge_type'] == "getit") echo 'selected'; ?>><?php _e('Get it on iTunes', 'appStoreAssistant' ); ?></option>
</select></td>
</tr>
<tr valign="top">
<th scope="row"><label><?php _e('iTunes Stores Badge Size', 'appStoreAssistant' ); ?></label></th>
<td><select name='iTunes_options[iTunes_store_badge_size]'>
	<option value=".5" <?php if ($options['iTunes_store_badge_size'] == ".5") echo 'selected'; ?>>Half</option>
	<option value="1" <?php if ($options['iTunes_store_badge_size'] == "1") echo 'selected'; ?>>Full Size</option>
	<option value="1.5" <?php if ($options['iTunes_store_badge_size'] == "1.5") echo 'selected'; ?>>1.5x</option>
	<option value="2" <?php if ($options['iTunes_store_badge_size'] == "2") echo 'selected'; ?>>2x</option>
	<option value="2.5" <?php if ($options['iTunes_store_badge_size'] == "2.5") echo 'selected'; ?>>2.5x</option>
	
</select> * Full Size is 135px x 40px</td>
</tr>

</table>	

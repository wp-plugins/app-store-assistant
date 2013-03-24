<table class="form-table">
<tr valign="top">
<th scope="row"><label>Icon to start with</label></th>
<td><input type="radio" name="appStore_options[appstoreicon_to_use]" value="60" <?php if ($options['appstoreicon_to_use'] == "60") echo 'checked'; ?> /> Small Icon (60px)<br />
<input type="radio" name="appStore_options[appstoreicon_to_use]" value="512" <?php if ($options['appstoreicon_to_use'] == "512") echo 'checked'; ?> /> Large Icon (512px or 1024px)</td></tr></table>
<hr>
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

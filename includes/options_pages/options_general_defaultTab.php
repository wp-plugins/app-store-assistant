<input type="hidden" name="appStore_options[checkboxedoptions]" value="use_shortDesc_on_single,use_shortDesc_on_multiple" />
<h2 class="asa_admin">Short Description</h2>
		
<table class="form-table">
<tr valign="top">
<th scope="row"><label>Short Description</label></th>
<td><input type="text" size="4" name="appStore_options[max_description]" value="<?php echo $options['max_description']; ?>" maxlength="4" />  Max characters<br />
<input type="checkbox" name="appStore_options[use_shortDesc_on_single]" value="yes" <?php if ($options['use_shortDesc_on_single'] == "yes") echo 'checked'; ?> /> Use on Single Post<br />
<input type="checkbox" name="appStore_options[use_shortDesc_on_multiple]" value="yes" <?php if ($options['use_shortDesc_on_multiple'] == "yes") echo 'checked'; ?> /> Use on Multiple Post Page
</td>
</tr>
<tr valign="top">
<th scope="row"><label>Read More link</label></th>
<td><input type="radio" name="appStore_options[shortDesc_link]" value="button" <?php if ($options['shortDesc_link'] == "button") echo 'checked'; ?> /> show as button<br />
<input type="radio" name="appStore_options[shortDesc_link]" value="text" <?php if ($options['shortDesc_link'] == "text") echo 'checked'; ?> /> show as text</td>
</tr>
<tr valign="top">
<th scope="row"><label>Default Text</label></th>
<td><input type="text" size="20" name="appStore_options[shortDesc_screenshot_text]" value="<?php echo $options['shortDesc_screenshot_text']; ?>" maxlength="30" /> "Show Screenshots"<br />
<input type="text" size="35" name="appStore_options[shortDesc_fullDesc_text]" value="<?php echo $options['shortDesc_fullDesc_text']; ?>" maxlength="45" /> "Show Full Description"</td>
</tr>
</table>	

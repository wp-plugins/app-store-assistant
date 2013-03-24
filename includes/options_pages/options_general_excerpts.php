<input type="hidden" name="appStore_options[checkboxedoptions]" value="displayexcerptthumbnail,displayexcerptreadmore" />

<table class="form-table">
<tr valign="top">
<th scope="row"><label>Excerpt Generator</label></th>
<td><input type="radio" name="appStore_options[excerpt_generator]" value="wordpress" <?php if ($options['excerpt_generator'] == "wordpress") echo 'checked'; ?> /> WordPress<br />
<input type="radio" name="appStore_options[excerpt_generator]" value="asa" <?php if ($options['excerpt_generator'] == "asa") echo 'checked'; ?> /> App Store Assistent<br />
	<p class="asa_admin_warning">This feature may negatively affect your theme. Most themes do not expect an image in the excerpt.</p></td>
</tr>
<tr valign="top">
<th scope="row"><label>Max Length</label></th>
<td><input type="text" size="4" name="appStore_options[excerpt_max_chars]" value="<?php echo $options['excerpt_max_chars']; ?>" maxlength="4" /> characters</td>
</tr>
<tr valign="top">
<th scope="row"><label>Show</label></th>
<td><input type="checkbox" name="appStore_options[displayexcerptthumbnail]" value="yes" <?php if ($options['displayexcerptthumbnail'] == "yes") echo 'checked'; ?> /> App Icon in excerpt<br />
<input type="checkbox" name="appStore_options[displayexcerptreadmore]" value="yes" <?php if ($options['displayexcerptreadmore'] == "yes") echo 'checked'; ?> /> "More Info" link at end of excerpt<br />
<input type="radio" name="appStore_options[excerpt_moreinfo_link]" value="button" <?php if ($options['excerpt_moreinfo_link'] == "button") echo 'checked'; ?> /> More Info button<br />
<input type="radio" name="appStore_options[excerpt_moreinfo_link]" value="text" <?php if ($options['excerpt_moreinfo_link'] == "text") echo 'checked'; ?> /> More Info text link
</td>
</tr>
<tr valign="top">
<th scope="row"><label>Default Link Text</label></th>
<td><input type="text" size="15" name="appStore_options[excerpt_moreinfo_text]" value="<?php echo $options['excerpt_moreinfo_text']; ?>" maxlength="30" /> "More Info"
</td>
</tr>
</table>
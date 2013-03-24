<table class="form-table">
<tr valign="top">
<th scope="row"><label>Product Image Size</label></th>
<td><select name='appStore_options[amazon_productimage_size]'>
		<option value="small" <?php if ($options['amazon_productimage_size'] == "small") echo 'selected'; ?>>Small</option>
		<option value="medium" <?php if ($options['amazon_productimage_size'] == "medium") echo 'selected'; ?>>Medium</option>
		<option value="large" <?php if ($options['amazon_productimage_size'] == "large") echo 'selected'; ?>>Large</option>
	</select> (Large Images not always available)</td></tr>
<tr valign="top">
<th scope="row"><label>Max Width</label></th>
<td><input type="text" size="4" name="appStore_options[amazon_productimage_maxwidth]" value="<?php echo $options['amazon_productimage_maxwidth']; ?>"/></td></tr>
</table>
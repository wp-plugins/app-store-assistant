<p>The sizes below set the Maximum size for an image. Most iOS and Mac app icons will be exactly the sizes you set, but most iTunes images only come in smaller sizes. Product images from amazon.com vary in size.</p>

<p class="asa_admin_warning">(Cached app data must be cleared for change to take effect. See <b><a href="<?php echo admin_url()."admin.php?page=appStore_sm_utilities&tab=clearcache"; ?>">Utilities -> Clear Cache</a></b>.)</p>

<table class="form-table">
<tr valign="top">
<th scope="row"><label>Image size for Featured Image</label></th>
<td><input type="text" size="4" name="appStore_options[appicon_size_featured]" value="<?php echo $options['appicon_size_featured']; ?>" />px</td></tr>
<tr valign="top">
<th scope="row"><label>Image size for iOS Browsers</label></th>
<td><input type="text" size="4" name="appStore_options[appicon_size_ios]" value="<?php echo $options['appicon_size_ios']; ?>" />px</td></tr>
<tr valign="top">
<th scope="row"><label>Image size for Lists</label></th>
<td><input type="text" size="4" name="appStore_options[appicon_size_lists]" value="<?php echo $options['appicon_size_lists']; ?>" />px</td></tr>
<tr valign="top">
<th scope="row"><label>Image size for Posts</label></th>
<td><input type="text" size="4" name="appStore_options[appicon_size_posts]" value="<?php echo $options['appicon_size_posts']; ?>" />px</td></tr>
<tr valign="top">
<th scope="row"><label>Image size for Elements</label></th>
<td><input type="text" size="4" name="appStore_options[appicon_size_element]" value="<?php echo $options['appicon_size_element']; ?>" />px</td></tr>
<tr valign="top">
<th scope="row"><label>Image size for Widgets</label></th>
<td><input type="text" size="4" name="appStore_options[appicon_size_widget]" value="<?php echo $options['appicon_size_widget']; ?>" />px</td></tr>

</table>
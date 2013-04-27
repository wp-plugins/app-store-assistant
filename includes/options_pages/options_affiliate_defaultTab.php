<p class="asa_admin_warning"><b>This feature is currently in beta...</b></p>
<p class="asa_admin_explain">Amazon.com requires you have your own AWS Public and Private Keys. You can get the keys by signing up at <a href="http://aws-portal.amazon.com/gp/aws/developer/account/index.html">http://aws-portal.amazon.com/gp/aws/developer/account/index.html</a>.</p>
		
<table class="form-table">
<tr valign="top">
<th scope="row"><label>Access Key ID</label></th>
<td><input type="text" size="50" name="appStore_options[AWS_API_KEY]" value="<?php echo $options['AWS_API_KEY']; ?>"/></td>
</tr>
<tr valign="top">
<th scope="row"><label>Secret Access Key</label></th>
<td><input type="text" size="50" name="appStore_options[AWS_API_SECRET_KEY]" value="<?php echo $options['AWS_API_SECRET_KEY']; ?>"/></td>
</tr>
<tr valign="top">
<th scope="row"><label>Amazon.com Affiliate Code</label></th>
<td><input type="text" size="20" maxsize="50" name="appStore_options[AWS_ASSOCIATE_TAG]" value="<?php echo $options['AWS_ASSOCIATE_TAG']; ?>"/> <small>(optional)</small></td>
</tr>
<tr valign="top">
<th scope="row"><label>Your Amazon Locale (Region)</label></th>
<td><select name='appStore_options[AWS_PARTNER_DOMAIN]'>
	<option value="com" <?php if ($options['AWS_PARTNER_DOMAIN'] == "com") echo 'selected'; ?>>US (default)</option>
	<option value="ca" <?php if ($options['AWS_PARTNER_DOMAIN'] == "ca") echo 'selected'; ?>>Canada</option>
	<option value="co.uk" <?php if ($options['AWS_PARTNER_DOMAIN'] == "co.uk") echo 'selected'; ?>>United Kingdom</option>
	<option value="de" <?php if ($options['AWS_PARTNER_DOMAIN'] == "de") echo 'selected'; ?>>Germany</option>
	<option value="com">Klingon Homeworld</option>
	<option value="fr" <?php if ($options['AWS_PARTNER_DOMAIN'] == "fr") echo 'selected'; ?>>France</option>
	<option value="jp" <?php if ($options['AWS_PARTNER_DOMAIN'] == "jp") echo 'selected'; ?>>Japan Yen</option>
</select></td>
</tr>
</table>	

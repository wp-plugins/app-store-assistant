<h2 class="asa_admin">Amazon.com Settings:</h2>
		<div class="asa_admin">
		<p><b>This feature is currently in beta...<b></p>
		<p>Amazon.com requires you have your own AWS Public and Private Keys. You can get the keys by signing up at <a href="http://aws-portal.amazon.com/gp/aws/developer/account/index.html">http://aws-portal.amazon.com/gp/aws/developer/account/index.html</a>.</p>
		Access Key ID: <input type="text" size="50" name="appStore_options[AWS_API_KEY]" value="<?php echo $options['AWS_API_KEY']; ?>"/><br />
		Secret Access Key: <input type="text" size="50" name="appStore_options[AWS_API_SECRET_KEY]" value="<?php echo $options['AWS_API_SECRET_KEY']; ?>"/><br />
		Amazon.com Affiliate Code: <input type="text" size="50" name="appStore_options[AWS_ASSOCIATE_TAG]" value="<?php echo $options['AWS_ASSOCIATE_TAG']; ?>"/><br />
		
		
		Your Amazon Locale (Region): <select name='appStore_options[AWS_PARTNER_DOMAIN]'>
					<option value="com" <?php if ($options['AWS_PARTNER_DOMAIN'] == "com") echo 'selected'; ?>>US (default)</option>
					<option value="ca" <?php if ($options['AWS_PARTNER_DOMAIN'] == "ca") echo 'selected'; ?>>Canada</option>
					<option value="co.uk" <?php if ($options['AWS_PARTNER_DOMAIN'] == "co.uk") echo 'selected'; ?>>United Kingdom</option>
					<option value="de" <?php if ($options['AWS_PARTNER_DOMAIN'] == "de") echo 'selected'; ?>>Germany</option>
					<option value="com">Klingon Homeworld</option>
					<option value="fr" <?php if ($options['AWS_PARTNER_DOMAIN'] == "fr") echo 'selected'; ?>>France</option>
					<option value="jp" <?php if ($options['AWS_PARTNER_DOMAIN'] == "jp") echo 'selected'; ?>>Japan Yen</option>
				</select><hr>
		Product Image Size: <select name='appStore_options[amazon_productimage_size]'>
					<option value="small" <?php if ($options['amazon_productimage_size'] == "small") echo 'selected'; ?>>Small</option>
					<option value="medium" <?php if ($options['amazon_productimage_size'] == "medium") echo 'selected'; ?>>Medium</option>
					<option value="large" <?php if ($options['amazon_productimage_size'] == "large") echo 'selected'; ?>>Large</option>
				</select> (Large Images not always available)<br />
		Product Image Max Width: <input type="text" size="4" name="appStore_options[amazon_productimage_maxwidth]" value="<?php echo $options['amazon_productimage_maxwidth']; ?>"/>



		</div>
		
		
		
		
		
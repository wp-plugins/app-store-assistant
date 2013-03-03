<input type="hidden" name="appStore_options[checkboxedoptions]" value="use_shortDesc_on_single,use_shortDesc_on_multiple,displayexcerptthumbnail,displayexcerptreadmore,newPost_addCategories,cache_images_locally,newPost_defaultTextShow" />		<h2 class="asa_admin">Short Description</h2>
	<div class="asa_admin">
		
		<div class="asa_admin_element">Max Length of Short Description: <input type="text" size="4" name="appStore_options[max_description]" value="<?php echo $options['max_description']; ?>" maxlength="4" /> characters</div>
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[use_shortDesc_on_single]" value="yes" <?php if ($options['use_shortDesc_on_single'] == "yes") echo 'checked'; ?> /> Use Short Description on Single Post</div>
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[use_shortDesc_on_multiple]" value="yes" <?php if ($options['use_shortDesc_on_multiple'] == "yes") echo 'checked'; ?> /> Use Short Description on Multiple Post Page<br /></div>
		
		
		<div class="asa_admin_element">Show "Read More" link as:&nbsp;&nbsp;<input type="radio" name="appStore_options[shortDesc_link]" value="button" <?php if ($options['shortDesc_link'] == "button") echo 'checked'; ?> /> Button&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="appStore_options[shortDesc_link]" value="text" <?php if ($options['shortDesc_link'] == "text") echo 'checked'; ?> /> Text</div>

		
		
		<div class="asa_admin_element">Default "Show Screenshots" Text: <input type="text" size="20" name="appStore_options[shortDesc_screenshot_text]" value="<?php echo $options['shortDesc_screenshot_text']; ?>" maxlength="30" /></div>
		<div class="asa_admin_element">Default "Show Full Description" Text: <input type="text" size="35" name="appStore_options[shortDesc_fullDesc_text]" value="<?php echo $options['shortDesc_fullDesc_text']; ?>" maxlength="45" /></div>

	</div>
<h2 class="asa_admin">Excerpts</h2>
	<div class="asa_admin">
	<div class="asa_admin_element">Excerpt Generator:&nbsp;&nbsp;<input type="radio" name="appStore_options[excerpt_generator]" value="wordpress" <?php if ($options['excerpt_generator'] == "wordpress") echo 'checked'; ?> /> WordPress&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="appStore_options[excerpt_generator]" value="asa" <?php if ($options['excerpt_generator'] == "asa") echo 'checked'; ?> /> App Store Assistent<br />
	<p class="asa_admin_warning">This feature may negatively affect your theme. Most themes do not expect an image in the excerpt.</p>
	</div>
		
		
		<hr>
		
		<div class="asa_admin_element">Max Length of Auto Excerpt: <input type="text" size="4" name="appStore_options[excerpt_max_chars]" value="<?php echo $options['excerpt_max_chars']; ?>" maxlength="4" /> characters<br /></div>
		
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[displayexcerptthumbnail]" value="yes" <?php if ($options['displayexcerptthumbnail'] == "yes") echo 'checked'; ?> /> Show App Icon in excerpt</div>
		
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[displayexcerptreadmore]" value="yes" <?php if ($options['displayexcerptreadmore'] == "yes") echo 'checked'; ?> /> Show "More Info" link at end of excerpt</div>
		<div class="asa_admin_element">Default More Info Text: <input type="text" size="15" name="appStore_options[excerpt_moreinfo_text]" value="<?php echo $options['excerpt_moreinfo_text']; ?>" maxlength="30" /></div>
		<div class="asa_admin_element">Show "More Info" link as:&nbsp;&nbsp;<input type="radio" name="appStore_options[excerpt_moreinfo_link]" value="button" <?php if ($options['excerpt_moreinfo_link'] == "button") echo 'checked'; ?> /> Button&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="appStore_options[excerpt_moreinfo_link]" value="text" <?php if ($options['excerpt_moreinfo_link'] == "text") echo 'checked'; ?> /> Text</div>
</div>

<h2 class="asa_admin">Create Post from App ID</h2>
	<div class="asa_admin">
	<div class="asa_admin_element">Create New posts as:&nbsp;&nbsp;<input type="radio" name="appStore_options[newPost_status]" value="draft" <?php if ($options['newPost_status'] == "draft") echo 'checked'; ?> /> Draft&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="appStore_options[newPost_status]" value="publish" <?php if ($options['newPost_status'] == "publish") echo 'checked'; ?> /> Publish&nbsp;&nbsp;&nbsp;&nbsp; 
	<input type="radio" name="appStore_options[newPost_status]" value="pending" <?php if ($options['newPost_status'] == "pending") echo 'checked'; ?> /> Pending</div>

	<div class="asa_admin_element"><input type="checkbox" name="appStore_options[newPost_addCategories]" value="yes" <?php if ($options['newPost_addCategories'] == "yes") echo 'checked'; ?> /> Add App Store categories to post</div>

	<div class="asa_admin_element"><input type="checkbox" name="appStore_options[newPost_createCategories]" value="yes" <?php if ($options['newPost_createCategories'] == "yes") echo 'checked'; ?> /> Create categories if they don't adread exist</div>

	<div class="asa_admin_element"><input type="checkbox" name="appStore_options[newPost_defaultTextShow]" value="yes" <?php if ($options['newPost_defaultTextShow'] == "yes") echo 'checked'; ?> /> Add "more_info_text" attribute to shortcode</div>
	<div class="asa_admin_element">Default More Info Text: <input type="text" size="15" name="appStore_options[newPost_defaultText]" value="<?php echo $options['newPost_defaultText']; ?>" maxlength="30" /></div>

</div>

<?php /*
<h2 class="asa_admin">Featured Image</h2>
	<div class="asa_admin">
		<div class="asa_admin_element">Featured Image Generator:&nbsp;&nbsp;<input type="radio" name="appStore_options[featured_image_generator]" value="wordpress" <?php if ($options['featured_image_generator'] == "wordpress") echo 'checked'; ?> /> WordPress&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="appStore_options[featured_image_generator]" value="asa" <?php if ($options['featured_image_generator'] == "asa") echo 'checked'; ?> /> App Store Assistent<br />
		<p class="asa_admin_warning">This feature may negatively affect your theme. Most themes do not expect an image in the excerpt.</p>
		</div>
		
		<hr>
	</div>		
*/
?>	
<h2 class="asa_admin">Localization</h2>
	<div class="asa_admin">
		<div class="asa_admin_element">Currency Type: <select name='appStore_options[currency_format]'>
			<option value="USD" <?php if ($options['currency_format'] == "USD") echo 'selected'; ?>>US ($ and &cent;)</option>
			<option value="EUR" <?php if ($options['currency_format'] == "EUR") echo 'selected'; ?>>Euro (&euro;)</option>
			<option value="GBP" <?php if ($options['currency_format'] == "GBP") echo 'selected'; ?>>United Kingdom Pound (&pound;)</option>
			<option value="NOK" <?php if ($options['currency_format'] == "NOK") echo 'selected'; ?>>Norway Krone (kr)</option>
			<option value="SEK" <?php if ($options['currency_format'] == "SEK") echo 'selected'; ?>>Sweden Krona (kr)</option>
			<option value="JPY" <?php if ($options['currency_format'] == "JPY") echo 'selected'; ?>>Japan Yen &yen;</option>
		</select></div>
		<div class="asa_admin_element">Show results from this country's store: <select name='appStore_options[store_country]'>
				<?php
					$storeCountries = array("US","AT","BE","CH","DE","DK","ES","FI","FR","GB","IE","IT","NL","NO","SE");
					foreach($storeCountries as $storeCountry) {
						echo '<option value="'.$storeCountry.'" ';
						if ($options['store_country'] == $storeCountry) echo 'selected'; 
						echo '>iTunes '.$storeCountry.'</option>'."\r\n";
					
					}
				?>
				</select><br />
				<p class="asa_admin_warning">(Cached app data must be cleared for change to take effect. See <b>Reset</b> tab.)</p>
		</div>
		<div class="asa_admin_element">iTunes/App Stores Badge Language: <select name='appStore_options[store_badge_language]'>
			<option value="US-UK" <?php if ($options['store_badge_language'] == "US-UK") echo 'selected'; ?>>English</option>
			<option value="CZ" <?php if ($options['store_badge_language'] == "CZ") echo 'selected'; ?>>Čeština</option>
			<option value="DE" <?php if ($options['store_badge_language'] == "DE") echo 'selected'; ?>>Deutsch</option>
			<option value="ES" <?php if ($options['store_badge_language'] == "ES") echo 'selected'; ?>>Español</option>
			<option value="ESLA_MX" <?php if ($options['store_badge_language'] == "ESLA_MX") echo 'selected'; ?>>Español Latino</option>
			<option value="FR" <?php if ($options['store_badge_language'] == "FR") echo 'selected'; ?>>Français</option>
			<option value="IT" <?php if ($options['store_badge_language'] == "IT") echo 'selected'; ?>>Italiano</option>
			<option value="NO" <?php if ($options['store_badge_language'] == "NO") echo 'selected'; ?>>Norsk</option>
			<option value="PL" <?php if ($options['store_badge_language'] == "PL") echo 'selected'; ?>>Polski</option>
			<option value="RU" <?php if ($options['store_badge_language'] == "RU") echo 'selected'; ?>>Pусский</option>
			<option value="FI" <?php if ($options['store_badge_language'] == "FI") echo 'selected'; ?>>Suomi</option>
			<option value="SE" <?php if ($options['store_badge_language'] == "SE") echo 'selected'; ?>>Svenska</option>
			<option value="FI" <?php if ($options['store_badge_language'] == "FI") echo 'selected'; ?>>Tagalog</option>
			<option value="AR" <?php if ($options['store_badge_language'] == "AR") echo 'selected'; ?>>العربية</option>
			<option value="KR" <?php if ($options['store_badge_language'] == "KR") echo 'selected'; ?>>한국어</option>
			<option value="JP" <?php if ($options['store_badge_language'] == "JP") echo 'selected'; ?>>日本語</option>
			<option value="CN" <?php if ($options['store_badge_language'] == "CN") echo 'selected'; ?>>简体中文</option>
			<option value="HK_TW" <?php if ($options['store_badge_language'] == "HK_TW") echo 'selected'; ?>>繁體中文</option>
		</select></div>
	</div>
		
<h2 class="asa_admin">Cache Settings</h2>
   	<div class="asa_admin">
    	<div class="asa_admin_element">Data cache time: <select name='appStore_options[cache_time_select_box]'>
			<?php $cache_intervals = array(
										'Don\'t cache'=>0,
										'1 minute'=>1*60,
										'5 minutes'=>5*60,
										'10 minutes'=>10*60,
										'30 minutes'=>30*60,
										'1 hour'=>1*60*60,
										'6 hours'=>6*60*60,
										'12 hours'=>12*60*60,
										'24 hours'=>24*60*60,
										'1 Week'=>24*60*60*7,
										'1 Month'=>24*60*60*7*30,
										'1 Year'=>24*60*60*7*30*365
									);
			
			foreach ($cache_intervals as $key => $value) {
				echo '<option value="' . $value . '" ' . selected($value, $options['cache_time_select_box']) . '>' . $key . '</option>';
			}?></select><br />
		<p class="asa_admin_explain">This option determines how long before the plugin requests new data from Apple's servers. You can clear the cached app data via the Reset tab.</p>
		</div>
		<div class="asa_admin_element">Cache images locally: <input name="appStore_options[cache_images_locally]" type="checkbox" value="1" <?php if (isset($options['cache_images_locally'])) { checked('1', $options['cache_images_locally']); } ?> /><br />
			<p class="asa_admin_explain">This will load icons, screenshots, etc. from this server instead of using Apple's CDN server.<br />The <b><?php echo $upload_dir['basedir']; ?></b> directory MUST be writeable for this option to have any effect.</p>
		</div>
	</div>
		
<h2 class="asa_admin">Miscellaneous</h2>
	<div class="asa_admin">
		
		<div class="asa_admin_element">Display <input type="text" size="3" name="appStore_options[qty_of_apps]" value="<?php echo $options['qty_of_apps']; ?>" maxlength="3" /> apps from ATOM feed</div>
		<div class="asa_admin_element">Affiliate Network: <select name="appStore_options[affiliatepartnerid]">
					<option value="999" <?php if ($options['affiliatepartnerid'] == "999") echo 'selected'; ?>>None</option>
					<option value="30" <?php if ($options['affiliatepartnerid'] == "30") echo 'selected'; ?>>LinkShare</option>
					<option value="2003" <?php if ($options['affiliatepartnerid'] == "2003") echo 'selected'; ?>>TradeDoubler</option>
					<option value="1002" <?php if ($options['affiliatepartnerid'] == "1002") echo 'selected'; ?>>DGM</option>
					</select></div>
	</div>
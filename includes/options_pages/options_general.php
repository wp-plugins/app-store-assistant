	<h2 class="asa_admin">Short Description</h2>
		<div class="asa_admin">
		<input type="hidden" name="appStore_options[checkboxedoptions]" value="use_shortDesc_on_single,use_shortDesc_on_multiple,displayexcerptthumbnail,displayexcerptreadmore" />
		Max Length of Short Description: <input type="text" size="4" name="appStore_options[max_description]" value="<?php echo $options['max_description']; ?>" maxlength="4" /> characters<br />
		<input type="checkbox" name="appStore_options[use_shortDesc_on_single]" value="yes" <?php if ($options['use_shortDesc_on_single'] == "yes") echo 'checked'; ?> /> Use Short Description on Single Post<br />
		<input type="checkbox" name="appStore_options[use_shortDesc_on_multiple]" value="yes" <?php if ($options['use_shortDesc_on_multiple'] == "yes") echo 'checked'; ?> /> Use Short Description on Multiple Post Page<br /><br />
		
		
	Show "Read More" link as:&nbsp;&nbsp;<input type="radio" name="appStore_options[shortDesc_link]" value="button" <?php if ($options['shortDesc_link'] == "button") echo 'checked'; ?> /> Button&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="appStore_options[shortDesc_link]" value="text" <?php if ($options['shortDesc_link'] == "text") echo 'checked'; ?> /> Text<br />

		
		
		Default "Show Screenshots" Text: <input type="text" size="20" name="appStore_options[shortDesc_screenshot_text]" value="<?php echo $options['shortDesc_screenshot_text']; ?>" maxlength="30" /><br />
		Default "Show Full Description" Text: <input type="text" size="35" name="appStore_options[shortDesc_fullDesc_text]" value="<?php echo $options['shortDesc_fullDesc_text']; ?>" maxlength="45" /><br />

</div>
	<h2 class="asa_admin">Excerpts</h2>
		<div class="asa_admin">
	Excerpt Generator:&nbsp;&nbsp;<input type="radio" name="appStore_options[excerpt_generator]" value="wordpress" <?php if ($options['excerpt_generator'] == "wordpress") echo 'checked'; ?> /> WordPress&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="appStore_options[excerpt_generator]" value="asa" <?php if ($options['excerpt_generator'] == "asa") echo 'checked'; ?> /> App Store Assistent<br />
		<small style="color:red;">This feature may negatively affect your theme. Most themes do not expect an image in the excerpt. </small>
		
		<hr>
		
		Max Length of Auto Excerpt: <input type="text" size="4" name="appStore_options[excerpt_max_chars]" value="<?php echo $options['excerpt_max_chars']; ?>" maxlength="4" /> characters<br /><br />
		
		
		<input type="checkbox" name="appStore_options[displayexcerptthumbnail]" value="yes" <?php if ($options['displayexcerptthumbnail'] == "yes") echo 'checked'; ?> /> Show App Icon in excerpt<br /><br />
		
		
<input type="checkbox" name="appStore_options[displayexcerptreadmore]" value="yes" <?php if ($options['displayexcerptreadmore'] == "yes") echo 'checked'; ?> /> Show "More Info" link at end of excerpt<br />
		Default More Info Text: <input type="text" size="15" name="appStore_options[excerpt_moreinfo_text]" value="<?php echo $options['excerpt_moreinfo_text']; ?>" maxlength="30" /><br />
		Show "More Info" link as:&nbsp;&nbsp;<input type="radio" name="appStore_options[excerpt_moreinfo_link]" value="button" <?php if ($options['excerpt_moreinfo_link'] == "button") echo 'checked'; ?> /> Button&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="appStore_options[excerpt_moreinfo_link]" value="text" <?php if ($options['excerpt_moreinfo_link'] == "text") echo 'checked'; ?> /> Text<br />
		</div>
		
	<h2 class="asa_admin">Featured Image</h2>
		<div class="asa_admin">
	Featured Image Generator:&nbsp;&nbsp;<input type="radio" name="appStore_options[featured_image_generator]" value="wordpress" <?php if ($options['featured_image_generator'] == "wordpress") echo 'checked'; ?> /> WordPress&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="appStore_options[featured_image_generator]" value="asa" <?php if ($options['featured_image_generator'] == "asa") echo 'checked'; ?> /> App Store Assistent<br />
		<small style="color:red;">This feature may negatively affect your theme. Most themes do not expect an image in the excerpt. </small>
		
		<hr>



</div>		
		
		
		
		
		
		
		
		
		
    <h2 class="asa_admin">Localization</h2>
		<div class="asa_admin">
	
		Currency Type: <select name='appStore_options[currency_format]'>
					<option value="USD" <?php if ($options['currency_format'] == "USD") echo 'selected'; ?>>US ($ and &cent;)</option>
					<option value="EUR" <?php if ($options['currency_format'] == "EUR") echo 'selected'; ?>>Euro (&euro;)</option>
					<option value="GBP" <?php if ($options['currency_format'] == "GBP") echo 'selected'; ?>>United Kingdom Pound (&pound;)</option>
					<option value="NOK" <?php if ($options['currency_format'] == "NOK") echo 'selected'; ?>>Norway Krone (kr)</option>
					<option value="SEK" <?php if ($options['currency_format'] == "SEK") echo 'selected'; ?>>Sweden Krona (kr)</option>
					<option value="JPY" <?php if ($options['currency_format'] == "JPY") echo 'selected'; ?>>Japan Yen &yen;</option>
				</select><br />
		Show results from this country's store: <select name='appStore_options[store_country]'>
				<?php
					$storeCountries = array("US","AT","BE","CH","DE","DK","ES","FI","FR","GB","IE","IT","NL","NO","SE");
					foreach($storeCountries as $storeCountry) {
						echo '<option value="'.$storeCountry.'" ';
						if ($options['store_country'] == $storeCountry) echo 'selected'; 
						echo '>iTunes '.$storeCountry.'</option>'."\r\n";
					
					}
				?>
				</select><br />
		<small>(Cached app data must be cleared for change to take effect. See <b>Reset</b> tab.)</small>
		</div>
	<h2 class="asa_admin">Miscellaneous</h2>
		<div class="asa_admin">
		
		<ul type="square" class="asa_optionslist">
		<li>Display <input type="text" size="3" name="appStore_options[qty_of_apps]" value="<?php echo $options['qty_of_apps']; ?>" maxlength="3" /> apps from ATOM feed</li>
		
		<li>Affiliate Network: <select name="appStore_options[affiliatepartnerid]">
					<option value="999" <?php if ($options['affiliatepartnerid'] == "999") echo 'selected'; ?>>None</option>
					<option value="30" <?php if ($options['affiliatepartnerid'] == "30") echo 'selected'; ?>>LinkShare</option>
					<option value="2003" <?php if ($options['affiliatepartnerid'] == "2003") echo 'selected'; ?>>TradeDoubler</option>
					<option value="1002" <?php if ($options['affiliatepartnerid'] == "1002") echo 'selected'; ?>>DGM</option>
					</select></li>
		</ul>
		</div>
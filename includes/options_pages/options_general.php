	<h2 class="asa_admin">Short Description</h2>
		<div class="asa_admin">
		<input type="hidden" name="appStore_options[checkboxedoptions]" value="use_shortDesc_on_single,use_shortDesc_on_multiple,smaller_buy_button_iOS" />
		Max Length: <input type="text" size="4" name="appStore_options[max_description]" value="<?php echo $options['max_description']; ?>" maxlength="4" /> characters<br />
		<input type="checkbox" name="appStore_options[use_shortDesc_on_single]" value="yes" <?php if ($options['use_shortDesc_on_single'] == "yes") echo 'checked'; ?> /> Use on Single Post<br />
		<input type="checkbox" name="appStore_options[use_shortDesc_on_multiple]" value="yes" <?php if ($options['use_shortDesc_on_multiple'] == "yes") echo 'checked'; ?> /> Use on Multiple Post Page<br />
		Max Length for Auto Excerpt: <input type="text" size="4" name="appStore_options[excerpt_max_description]" value="<?php echo $options['excerpt_max_description']; ?>" maxlength="4" /> characters<br />
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
		<li><input type="checkbox" name="appStore_options[smaller_buy_button_iOS]" value="yes" <?php if ($options['smaller_buy_button_iOS'] == "yes") echo 'checked'; ?> /> Show a smaller Buy Button in iOS browsers</li>
		<li>Display <input type="text" size="3" name="appStore_options[qty_of_apps]" value="<?php echo $options['qty_of_apps']; ?>" maxlength="3" /> apps from ATOM feed</li>
		<li>Screenshot Width: <input type="text" size="3" maxlength="3" name="appStore_options[ss_size]" value="<?php echo $options['ss_size']; ?>" />px<br />
		<small>(in px. Height is automatic.)</small></li>
		
		<li>Affiliate Network: <select name="appStore_options[affiliatepartnerid]">
					<option value="999" <?php if ($options['affiliatepartnerid'] == "999") echo 'selected'; ?>>None</option>
					<option value="30" <?php if ($options['affiliatepartnerid'] == "30") echo 'selected'; ?>>LinkShare</option>
					<option value="2003" <?php if ($options['affiliatepartnerid'] == "2003") echo 'selected'; ?>>TradeDoubler</option>
					<option value="1002" <?php if ($options['affiliatepartnerid'] == "1002") echo 'selected'; ?>>DGM</option>
					</select></li>
		</ul>
		</div>
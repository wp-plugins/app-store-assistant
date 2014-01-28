<input type="hidden" name="appStore_options[checkboxedoptions]" value="displayLinkToFooter,cache_images_locally" />

<h2 class="asa_admin">Setup</h2>
	<div class="asa_admin">
		<div class="asa_admin_element">
		
	<section>
	  <h3>Show link to plugin site in footer</h3>
	  	<div class="checkboxOne">
	  		<input type="checkbox" value="yes" id="checkboxOneInput" name="appStore_options[displayLinkToFooter]" <?php if ($options['displayLinkToFooter'] == "yes") echo 'checked'; ?> />
		  	<label for="checkboxOneInput"></label>
	  	</div>
	</section>
		
<p class="asa_admin_warning">By selecting the above box, a link will be placed at the bottom of your WordPress site giving credit to this plugin. This link will contain the page that it is displayed on and the version number of the plugin. When the link is clicked it will share this information with our server. The information will allow us to better understand how the plugin is being used and to make further improvements. This is completely optional, and the plug-in will work just fine even if you don't select this option. but we ask that you do select it. If you reset your settings it will be off by default.</p>
		<p>An Example link for this site would be <?php echo 'http://theiphoneappslist.com/index.php?v='.urlencode(plugin_get_version())."&ac=".urlencode(appStore_setting('affiliatepartnerid')).'&link='.urlencode(site_url()); ?></p></div>
	</div>
	
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
				<p class="asa_admin_warning">(Cached app data must be cleared for change to take effect. See <b><a href="<?php echo admin_url()."admin.php?page=appStore_sm_utilities&tab=clearcache"; ?>">Utilities -> Clear Cache</a></b>.)</p>
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
		<div class="asa_admin_element">
			<section>
			  <h3>Cache images locally</h3>
				<div class="checkboxTwo">
					<input type="checkbox" value="1" id="checkboxTwoInput" name="appStore_options[cache_images_locally]" <?php if ($options['cache_images_locally'] == "1") echo 'checked'; ?> />
					<label for="checkboxTwoInput"></label>
				</div>
			</section>
			<p class="asa_admin_explain">This will load icons, screenshots, etc. from this server instead of using Apple's CDN server.<br />The <b><?php echo $upload_dir['basedir']; ?></b> directory MUST be writeable for this option to have any effect.</p>
			<p class="asa_admin_warning">(Cached app data must be cleared for change to take effect. See <b><a href="<?php echo admin_url()."admin.php?page=appStore_sm_utilities&tab=clearcache"; ?>">Utilities -> Clear Cache</a></b>.)</p>

		</div>
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
		<p class="asa_admin_explain">This option determines how long before the plugin requests new data from Apple's servers. You can clear the cached app data via the Utilities section.</p>
		</div>
	</div>
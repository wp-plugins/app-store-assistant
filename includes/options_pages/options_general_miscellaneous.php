<input type="hidden" name="appStore_options[checkboxedoptions]" value="open_links_externally,rss_showIcon,rss_showShortDescription,enable_lightbox" />



<h2 class="asa_admin">Site's RSS/ATOM Feed</h2>
	<div class="asa_admin">
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[rss_showIcon]" value="yes" <?php if ($options['rss_showIcon'] == "yes") echo 'checked'; ?> /> Add Item icon to feed</div>
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[rss_showShortDescription]" value="yes" <?php if ($options['rss_showShortDescription'] == "yes") echo 'checked'; ?> /> Add Item short description to feed</div>

	</div>






		
<h2 class="asa_admin">Other</h2>
	<div class="asa_admin">
		<div class="asa_admin_element">Affiliate Network: <select name="appStore_options[affiliatepartnerid]">
			<option value="999" <?php if ($options['affiliatepartnerid'] == "999") echo 'selected'; ?>>None</option>
			<option value="2013" <?php if ($options['affiliatepartnerid'] == "2013") echo 'selected'; ?>>PHG</option>
			<option value="2003" <?php if ($options['affiliatepartnerid'] == "2003") echo 'selected'; ?>>TradeDoubler</option>
			</select>
		</div>
		
		
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[enable_lightbox]" value="yes" <?php if ($options['enable_lightbox'] == "yes") echo 'checked'; ?> /> Enable <a href="http://lokeshdhakar.com/projects/lightbox2/" target="_blank">Lightbox</a> </div>
		<div class="asa_admin_element"><input type="checkbox" name="appStore_options[open_links_externally]" value="yes" <?php if ($options['open_links_externally'] == "yes") echo 'checked'; ?> /> Open links in new window</div>
	</div>
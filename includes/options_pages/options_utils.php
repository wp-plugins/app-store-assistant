<input type="hidden" name="appStore_options[checkboxedoptions]" value="ResetCheckOne,ResetCheckTwo,ResetCheckThree,ResetCacheOne,ResetCacheTwo" />
<h2 class="asa_admin">Add Featured Images to Posts</h2>
	<div class="asa_admin">		
		<p>This feature will first check for any posts that use the <b>ios_app</b> or <b>mac_app</b> shortcodes. It will then check for a Featued Image. If no images is assigned to that post it will then take the large icon and make it a Featured Image.</p>

	<input type="checkbox" value="DoIt" name="appStore_options[AddFeaturedImages]" /> Checking this box and clicking Save below will start the process.<br /><br />

		
	</div>	
<h2 class="asa_admin">Clear a specific items cached data</h2>
	<div class="asa_admin">		
		<p>If you are having trouble with a specific item such as the image not loading or it is showing the wrong price or info, then you can have the system refresh the data. Just enter the ASIN or App ID below.</p>

	<input type="checkbox" value="DoIt" name="appStore_options[RemoveCachedItem]" /> I want to remove the cached data for the item listed below.<br /><br />
App or iTunes ID: <input type="text" size="15" name="appStore_options[RemoveCachedItemID]" value="" /><br />
Amazon.com ASIN: <input type="text" size="15" name="appStore_options[RemoveCachedItemASIN]" value="" /><br /><br />
		
	</div>	
<h2 class="asa_admin">Reset All Settings to Defaults</h2>
		<div class="asa_admin">
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCheckOne]" /> I want to reset all settings to their defaults.<br /><br />
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCheckTwo]" /> I know this will not save any of my changes.<br /><br />
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCheckThree]" /> I wont get mad when all my changes are lost.<br /><br />
		</div>
<h2 class="asa_admin">Reset cached App data</h2>
		<div class="asa_admin">
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCacheOne]" /> I want to reset all cached app data.<br /><br />
		<input type="checkbox" value="DoIt" name="appStore_options[ResetCacheTwo]" /> I know this will slow down my site as it rebuilds.
		</div>
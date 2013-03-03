<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width: 25em; }
#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
#sortable li span { position: absolute; margin-left: -1.3em; }
</style>
<script>

jQuery(function() {
	jQuery( "#sortable" ).sortable({
        stop : function(event, ui){
          //alert(jQuery(this).sortable('serialize'));
          var ordering = jQuery(this).sortable('toArray').toString();
          document.getElementById("app_elements_order").value = ordering;
          //alert(ordering);
        }
    });
	jQuery( "#sortable" ).disableSelection();
});
</script>
		<h2 class="asa_admin">Show in Post body</h2>
			<div class="asa_admin">
		<?php
    	$appStoreProperties = array(
     		array('ID' => "-----", 'label' => "Elements"),
    		array('ID' => "displayapptitle", 'label' => "App Name"),
    		array('ID' => "displayappdescription", 'label' => "App Description"),
    		array('ID' => "displayappicon", 'label' => "App Icon"),
    		array('ID' => "displayappiconbuybutton", 'label' => "App Icon's buy button"),
     		array('ID' => "-----", 'label' => "Details"),
  	 		array('ID' => "displayversion", 'label' => "App Version"),
     		array('ID' => "displaydevelopername", 'label' => "Developer Name"),
    		array('ID' => "displaysellername", 'label' => "Seller Name"),
  			array('ID' => "displayreleasedate", 'label' => "Date Released"),
     		array('ID' => "displayfilesize", 'label' => "File Size"),
     		array('ID' => "displayuniversal", 'label' => "Universal App icon"),
 			array('ID' => "displayadvisoryrating", 'label' => "Advisory Rating"),
   			array('ID' => "displaycategories", 'label' => "App Categories"),
     		array('ID' => "-----", 'label' => "Additional Elements"),
     		array('ID' => "displaygamecenterenabled", 'label' => "Game Center Enabled icon"),
    		array('ID' => "displaystarrating", 'label' => "App Star Rating"),
     		array('ID' => "displayscreenshots", 'label' => "Screen Shots"),
    		array('ID' => "displaysupporteddevices", 'label' => "Supported Devices list"),
     		array('ID' => "displaysupporteddeviceIcons", 'label' => "Supported Device Icons")
    	);
    	
 		$hiddenlist = array();

		foreach($appStoreProperties as $appStoreProperty) {
			if($appStoreProperty['ID'] == "-----") {
				echo "<b> - ".$appStoreProperty['label']."</b><br />";
			} else {
				array_push($hiddenlist, $appStoreProperty['ID']);
				echo '<input type="checkbox" name="appStore_options[';
				echo $appStoreProperty['ID'];
				echo ']" value="yes"';
				if ($options[$appStoreProperty['ID']] == "yes") echo ' checked';
				echo ' /> '.$appStoreProperty['label']."<br />\r";
			}
		}
		
		$hiddenlistcsv = implode(',', $hiddenlist);
		echo '<input type="hidden" name="appStore_options[checkboxedoptions]" value="'.$hiddenlistcsv.'" />'
		
		?>
		</div>
		
		
		
<?php
    	$appStoreProperties = array(
    		"appStoreDetail_appName" => "App Name",
    		"appStoreDetail_appIcon" => "App Icon",
    		"appStoreDetail_appDescription" => "App Description",
    		"appStoreDetail_appDetails" => "App Details",
    		"appStoreDetail_appRating" => "App Star Rating",
    		"appStoreDetail_appScreenshots" => "Screen Shots",
    		"appStoreDetail_appGCIcon" => "Game Center Enabled icon",
    		"appStoreDetail_appDeviceList" => "Supported Devices List",
   			"appStoreDetail_appBuyButton" => "App Buy Button"
   			);

		$appDetailsOrder = explode(",", appStore_setting('appDetailsOrder'));
		$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
		
		if(count($appDetailsOrder) != 9) {
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_DefaultList = "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appDetails,appStoreDetail_appGCIcon,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating";
			$appDetailsOrder = explode(",",$appElements_DefaultList);
			$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_StartList = $appElements_DefaultList;
		} else {
		
			$appElements_StartList = appStore_setting('appDetailsOrder');
		}
?>		
		
		
		<h2 class="asa_admin">Order of Post Elements</h2>
			<div class="asa_admin">
			Drag the elements into the order you would like them displayed<br />
<ul id="sortable">
<?php

		foreach($appDetailsOrder as $appDetailOrder) {
			echo '<li id="';
			echo $appDetailOrder;
			echo '" class="ui-state-default">';
			echo '<img src="'.plugins_url( 'images/adminDetails/'.$appDetailOrder, ASA_MAIN_FILE ) .'" alt="'.$appDetailOrder.'" align="middle" /> ';
			echo ' &nbsp;&nbsp;&nbsp;'.$appStoreProperties[$appDetailOrder]."</li>\r";
		}
?>
</ul>
<input type="hidden" id="app_elements_order" name="appStore_options[appDetailsOrder]" value="<?php echo $appElements_StartList; ?>" />
<div style="clear:both;"></div>
	
		
		
		
		
		
		</div>
		<h2 class="asa_admin">App Icon Size</h2>
		<div class="asa_admin">
		Icon to start with: <input type="radio" name="appStore_options[appstoreicon_to_use]" value="60" <?php if ($options['appstoreicon_to_use'] == "60") echo 'checked'; ?> /> Small Icon (60px)&nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="radio" name="appStore_options[appstoreicon_to_use]" value="512" <?php if ($options['appstoreicon_to_use'] == "512") echo 'checked'; ?> /> Large Icon (512px or 1024px)<br /><br />
		
		<table class="asa_admin_table">
		<tr>
			<th><input type="radio" name="appStore_options[appstoreicon_size_adjust_type]" value="percent" <?php if ($options['appstoreicon_size_adjust_type'] == "percent") echo 'checked'; ?> /> Adjust by percentage</th>
			<th><input type="radio" name="appStore_options[appstoreicon_size_adjust_type]" value="pixels" <?php if ($options['appstoreicon_size_adjust_type'] == "pixels") echo 'checked'; ?> /> Adjust to max pixels</th>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[appicon_size_adjust]" value="<?php echo $options['appicon_size_adjust']; ?>" />%</td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[appicon_size_max]" value="<?php echo $options['appicon_size_max']; ?>" />px</td>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[appicon_iOS_size_adjust]" value="<?php echo $options['appicon_iOS_size_adjust']; ?>" />%<br /><small>(iOS browsers)</small></td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[appicon_iOS_size_max]" value="<?php echo $options['appicon_iOS_size_max']; ?>" />px<br /><small>(iOS browsers)</small></td>
		</tr>
		</table>		
		</div>
		<h2 class="asa_admin">App Store Badge</h2>
		<div class="asa_admin">
				App Stores Badge Verbage: <select name='appStore_options[appStore_store_badge_type]'>
					<option value="available" <?php if ($options['appStore_store_badge_type'] == "available") echo 'selected'; ?>>Available on the App Store</option>
					<option value="download" <?php if ($options['appStore_store_badge_type'] == "download") echo 'selected'; ?>>Download on the App Store</option>
				</select><br />




</div>
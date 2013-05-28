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
<h2 class="asa_admin">Show the following elements in each section of a page with Multiple Posts</h2>
<div class="asa_admin">
		<?php
    	$appStoreSections = array(
     		array('ID' => "-----", 'label' => "Main Elements"),
    		array('ID' => "displaympapptitle", 'label' => "App Name"),
    		array('ID' => "displaympappdescription", 'label' => "App Description"),
    		array('ID' => "displaympappreleasenotes", 'label' => "App Release Notes"),
    		array('ID' => "displaympappbadge", 'label' => "App Store Badge"),
    		array('ID' => "displaympappicon", 'label' => "App Icon"),
    		array('ID' => "displaympappiconbuybutton", 'label' => "App Icon's buy button"),
    		array('ID' => "displaympappdetailssection", 'label' => "Details Section"),
     		array('ID' => "-----", 'label' => "Additional Elements"),
     		array('ID' => "displaympgamecenterenabled", 'label' => "Game Center Enabled icon"),
    		array('ID' => "displaympappbuybutton", 'label' => "App Buy Button"),
    		array('ID' => "displaympstarrating", 'label' => "App Star Rating"),
     		array('ID' => "displaympscreenshots", 'label' => "Screen Shots"),
    		array('ID' => "displaympsupporteddevices", 'label' => "Supported Devices list"),
    		array('ID' => "displaympsupporteddevicesMinimal", 'label' => "Supported Devices Minimal Icons"),
     		array('ID' => "displaympsupporteddeviceIcons", 'label' => "Supported Device Icons")
    	);
    	$appStoreDetails = array(
     		array('ID' => "-----", 'label' => "Details Elements"),
  	 		array('ID' => "displaympversion", 'label' => "App Version"),
     		array('ID' => "displaympdevelopername", 'label' => "Developer Name"),
    		array('ID' => "displaympsellername", 'label' => "Seller Name"),
  			array('ID' => "displaympreleasedate", 'label' => "Date Released"),
     		array('ID' => "displaympfilesize", 'label' => "File Size"),
     		array('ID' => "displaympuniversal", 'label' => "Universal App icon"),
 			array('ID' => "displaympadvisoryrating", 'label' => "Advisory Rating"),
 			array('ID' => "displaympappinapppurwarning", 'label' => "Offers In-App Purchases warning (When Available)"),
   			array('ID' => "displaympcategories", 'label' => "App Categories"),
    	);  	
 		echo '<div class="appStore_datagrid">';
		echo '<table><thead><tr><th>Hide</th><th>Regular</th><th>Open</th><th>Closed</th><th>Element</th></tr></thead><tbody>';
		foreach($appStoreSections as $appStoreProperty) {
			if($appStoreProperty['ID'] == "-----") {
				echo '<tr class="alt"><td colspan="5">';
				echo "- ".$appStoreProperty['label']." -";
				echo '</tr>';
			} else {
				echo '<tr><td>';
				echo '<input type="radio" name="appStore_options[';
				echo $appStoreProperty['ID'];
				echo ']" value="no"';
				if ($options[$appStoreProperty['ID']] == "no") echo ' checked';
				echo ' />';
				echo '</td><td>';
				echo '<input type="radio" name="appStore_options[';
				echo $appStoreProperty['ID'];
				echo ']" value="yes"';
				if ($options[$appStoreProperty['ID']] == "yes") echo ' checked';
				echo ' />';
				echo '</td><td>';
				echo '<input type="radio" name="appStore_options[';
				echo $appStoreProperty['ID'];
				echo ']" value="open"';
				if ($options[$appStoreProperty['ID']] == "open") echo ' checked';
				echo ' />';
				echo '</td><td>';
				echo '<input type="radio" name="appStore_options[';
				echo $appStoreProperty['ID'];
				echo ']" value="closed"';
				if ($options[$appStoreProperty['ID']] == "closed") echo ' checked';
				echo ' />';
				echo '</td><td class="alt">';
				echo $appStoreProperty['label']."</td></tr>\r";
			}
		}
		foreach($appStoreDetails as $appStoreProperty) {
			if($appStoreProperty['ID'] == "-----") {
				echo '<tr class="alt"><td colspan="5">';
				echo "- ".$appStoreProperty['label']." -";
				echo '</tr>';
			} else {
				echo '<tr><td>';
				echo '<input type="radio" name="appStore_options[';
				echo $appStoreProperty['ID'];
				echo ']" value="no"';
				if ($options[$appStoreProperty['ID']] == "no") echo ' checked';
				echo ' />';
				echo '</td><td>';
				echo '<input type="radio" name="appStore_options[';
				echo $appStoreProperty['ID'];
				echo ']" value="yes"';
				if ($options[$appStoreProperty['ID']] == "yes") echo ' checked';
				echo ' />';
				echo '</td><td>';
				echo '</td><td>';
				echo '</td><td class="alt">';
				echo $appStoreProperty['label']."</td></tr>\r";
			}
		}
		echo '</tbody></table></div>';
		
		?>
<b>Hide</b>: Do not show the element.<br />
<b>Regular</b>: Show the element in regular text display.<br />
<b>Open</b>: Show the element in an Accordion (starting off open).<br />
<b>Closed</b>: Show the element in an Accordion (starting off closed).<br />
	
</div>
<?php
    	$appStoreProperties = array(
    		"appStoreDetail_appName" => "App Name",
    		"appStoreDetail_appIcon" => "App Icon",
    		"appStoreDetail_appDescription" => "App Description",
    		"appStoreDetail_appReleaseNotes" => "App ReleaseNotes",
    		"appStoreDetail_appBadge" => "App Store Badge",
    		"appStoreDetail_appDetails" => "App Details",
    		"appStoreDetail_appRating" => "App Star Rating",
    		"appStoreDetail_appScreenshots" => "Screen Shots",
    		"appStoreDetail_appGCIcon" => "Game Center Enabled icon",
    		"appStoreDetail_appDeviceList" => "Supported Devices List",
   			"appStoreDetail_appBuyButton" => "App Buy Button"
   			);

		$appDetailsOrder = explode(",", appStore_setting('appMPDetailsOrder'));
		$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
		
		if(count($appDetailsOrder) != 11) {
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_DefaultList = "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appGCIcon,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating";
			$appDetailsOrder = explode(",",$appElements_DefaultList);
			$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_StartList = $appElements_DefaultList;
		} else {
		
			$appElements_StartList = appStore_setting('appMPDetailsOrder');
		}
?>		
		
		
<h2 class="asa_admin">Order of Elements</h2>
	<div class="asa_admin">
		Drag the elements into the order you would like them displayed<br />
<ul id="sortable">
<?php

	foreach($appDetailsOrder as $appDetailOrder) {
		echo '<li id="';
		echo $appDetailOrder;
		echo '" class="ui-state-default">';
		echo '<img src="'.plugins_url( 'images/adminDetails/'.$appDetailOrder, ASA_MAIN_FILE ) .'.png" alt="'.$appDetailOrder.'" align="middle" /> ';
		echo ' &nbsp;&nbsp;&nbsp;'.$appStoreProperties[$appDetailOrder]."</li>\r";
	}
?>
</ul>
<input type="hidden" id="app_elements_order" name="appStore_options[appMPDetailsOrder]" value="<?php echo $appElements_StartList; ?>" />
<div style="clear:both;"></div>
</div>

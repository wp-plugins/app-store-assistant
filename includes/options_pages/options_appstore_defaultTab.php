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
<?PHP
appStore_CreateListOfAppsUsedInPosts();
?>

<h2 class="asa_admin">Show the following elements in the body of a Single Post</h2>
<div class="asa_admin">
		<?php
    	$appStoreSections = array(
     		array('ID' => "-----", 'label' => "Collapsible Elements"),
    		array('ID' => "displayappdescription", 'label' => "App Description"),
    		array('ID' => "displayappreleasenotes", 'label' => "App Release Notes"),
    		array('ID' => "displayappdetailssection", 'label' => "Details Section"),
      		array('ID' => "displayscreenshots", 'label' => "Screen Shots"),
    		array('ID' => "displaysupporteddevices", 'label' => "Supported Devices list"),
    		array('ID' => "displaysupporteddevicesMinimal", 'label' => "Supported Devices Minimal Icons"),
     		array('ID' => "displaysupporteddeviceIcons", 'label' => "Supported Device Icons")
    	);
    	$appStoreDetails = array(
    		array('ID' => "-----", 'label' => "Single Elements"),
    		array('ID' => "displayapptitle", 'label' => "App Name"),
    		array('ID' => "displayappicon", 'label' => "App Icon"),
    		array('ID' => "displayappiconbuybutton", 'label' => "App Icon's buy button"),
    		array('ID' => "displayappbadge", 'label' => "App Store Badge"),
     		array('ID' => "displaygamecenterenabled", 'label' => "Game Center Enabled icon"),
    		array('ID' => "displayappbuybutton", 'label' => "App Buy Button"),
    		array('ID' => "displaystarrating", 'label' => "App Star Rating"),
     		array('ID' => "-----", 'label' => "Details Elements"),
  	 		array('ID' => "displayversion", 'label' => "App Version"),
     		array('ID' => "displaydevelopername", 'label' => "Developer Name"),
    		array('ID' => "displaysellername", 'label' => "Seller Name"),
  			array('ID' => "displayreleasedate", 'label' => "Date Released"),
     		array('ID' => "displayfilesize", 'label' => "File Size"),
     		array('ID' => "displayuniversal", 'label' => "Universal App icon"),
 			array('ID' => "displayadvisoryrating", 'label' => "Advisory Rating"),
 			array('ID' => "displayappinapppurwarning", 'label' => "Offers In-App Purchases warning (When Available)"),
   			array('ID' => "displaycategories", 'label' => "App Categories"),
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

		$appDetailsOrder = explode(",", appStore_setting('appDetailsOrder'));
		$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
		
		if(count($appDetailsOrder) != 11) {
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_DefaultList = "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appGCIcon,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating";
			$appDetailsOrder = explode(",",$appElements_DefaultList);
			$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_StartList = $appElements_DefaultList;
		} else {
		
			$appElements_StartList = appStore_setting('appDetailsOrder');
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
<input type="hidden" id="app_elements_order" name="appStore_options[appDetailsOrder]" value="<?php echo $appElements_StartList; ?>" />
<div style="clear:both;"></div>
</div>

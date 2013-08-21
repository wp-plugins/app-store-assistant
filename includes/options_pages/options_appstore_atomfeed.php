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
<h2 class="asa_admin">Show the following elements in each section of a page with an ATOM Feed</h2>
<div class="asa_admin">
		<?php
    	$appStoreSections = array(
     		array('ID' => "-----", 'label' => "Collapsible Elements"),
    		array('ID' => "displayATOMappdescription", 'label' => "App Description"),
    		array('ID' => "displayATOMappreleasenotes", 'label' => "App Release Notes"),
    		array('ID' => "displayATOMappdetailssection", 'label' => "Details Section"),
      		array('ID' => "displayATOMscreenshots", 'label' => "Screen Shots"),
    	);
    	$appStoreDetails = array(
    		array('ID' => "-----", 'label' => "Single Elements"),
    		array('ID' => "displayATOMapptitle", 'label' => "App Name"),
    		array('ID' => "displayATOMappPositionNumber", 'label' => "App Position Number"),
    		array('ID' => "displayATOMappicon", 'label' => "App Icon"),
    		array('ID' => "displayATOMappiconbuybutton", 'label' => "App Icon's buy button"),
    		array('ID' => "displayATOMappbadge", 'label' => "App Store Badge"),
     		array('ID' => "displayATOMgamecenterenabled", 'label' => "Game Center Enabled icon"),
    		array('ID' => "displayATOMappbuybutton", 'label' => "App Buy Button"),
    		array('ID' => "displayATOMstarrating", 'label' => "App Star Rating"),
     		array('ID' => "-----", 'label' => "Details Elements"),
  	 		array('ID' => "displayATOMversion", 'label' => "App Version"),
     		array('ID' => "displayATOMdevelopername", 'label' => "Developer Name"),
    		array('ID' => "displayATOMsellername", 'label' => "Seller Name"),
  			array('ID' => "displayATOMreleasedate", 'label' => "Date Released"),
     		array('ID' => "displayATOMfilesize", 'label' => "File Size"),
     		array('ID' => "displayATOMuniversal", 'label' => "Universal App icon"),
 			array('ID' => "displayATOMadvisoryrating", 'label' => "Advisory Rating"),
 			array('ID' => "displayATOMappinapppurwarning", 'label' => "Offers In-App Purchases warning (When Available)"),
   			array('ID' => "displayATOMcategories", 'label' => "App Categories"),
    	);  	
 		echo '<div class="appStore_datagrid">';
		echo '<table><thead><tr><th>Hide</th><th>Regular</th><th>No Title</th><th>Open</th><th>Closed</th><th>Element</th></tr></thead><tbody>';
		foreach($appStoreSections as $appStoreProperty) {
			if($appStoreProperty['ID'] == "-----") {
				echo '<tr class="alt"><td colspan="6">';
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
				echo ']" value="notitle"';
				if ($options[$appStoreProperty['ID']] == "notitle") echo ' checked';
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
		
		echo '<tr><td>';
		echo '<input type="radio" name="appStore_options[displayATOMsupporteddevices]" value="no"';
		if ($options['displayATOMsupporteddevices'] == "no") echo ' checked';
		echo ' />';
		echo '</td><td>';
		echo '<input type="radio" name="appStore_options[displayATOMsupporteddevices]" value="yes"';
		if ($options['displayATOMsupporteddevices'] == "yes") echo ' checked';
		echo ' />';
		echo '</td><td>';
		echo '<input type="radio" name="appStore_options[displayATOMsupporteddevices]" value="notitle"';
		if ($options['displayATOMsupporteddevices'] == "notitle") echo ' checked';
		echo ' />';
		echo '</td><td>';
		echo '<input type="radio" name="appStore_options[displayATOMsupporteddevices]" value="open"';
		if ($options['displayATOMsupporteddevices'] == "open") echo ' checked';
		echo ' />';
		echo '</td><td>';
		echo '<input type="radio" name="appStore_options[displayATOMsupporteddevices]" value="closed"';
		if ($options['displayATOMsupporteddevices'] == "closed") echo ' checked';
		echo ' />';
		echo '</td><td class="alt">Supported Devices: Mode: ';
		echo '<select name="appStore_options[displayATOMsupporteddevicesType]">';
		echo '<option value="List" ';
		if ($options['displayATOMsupporteddevicesType'] == "List") echo 'selected';
		echo '>Text List</option>';
		echo '<option value="Minimal" ';
		if ($options['displayATOMsupporteddevicesType'] == "Minimal") echo 'selected';
		echo '>Minimal Icons</option>';
		echo '<option value="Normal" ';
		if ($options['displayATOMsupporteddevicesType'] == "Normal") echo 'selected';
		echo '>Normal Icons</option>';
		echo '</select>';
		echo "</td></tr>\r";

		foreach($appStoreDetails as $appStoreProperty) {
			if($appStoreProperty['ID'] == "-----") {
				echo '<tr class="alt"><td colspan="6">';
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
				echo '</td><td>';
				echo '</td><td class="alt">';
				echo $appStoreProperty['label']."</td></tr>\r";
			}
		}
		echo '</tbody></table></div>';
		
		?>
<b>Hide</b>: Do not show the element.<br />
<b>Regular</b>: Show the element in regular text display.<br />
<b>No Title</b>: Same as Regular except the title is omitted. (Handy for themes that remove formatting.)<br />
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

		$appDetailsOrder = explode(",", appStore_setting('appATOMDetailsOrder'));
		$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
		
		if(count($appDetailsOrder) != 11) {
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_DefaultList = "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appGCIcon,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating";
			$appDetailsOrder = explode(",",$appElements_DefaultList);
			$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_StartList = $appElements_DefaultList;
		} else {
		
			$appElements_StartList = appStore_setting('appATOMDetailsOrder');
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
<input type="hidden" id="app_elements_order" name="appStore_options[appATOMDetailsOrder]" value="<?php echo $appElements_StartList; ?>" />
<div style="clear:both;"></div>
</div>

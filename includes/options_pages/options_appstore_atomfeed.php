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
    		array('ID' => "displayATOMapptitle", 'label' => "App Name"),
    		array('ID' => "displayATOMappdescription", 'label' => "App Description"),
    		array('ID' => "displayATOMappreleasenotes", 'label' => "App Release Notes"),
    		array('ID' => "displayATOMappbadge", 'label' => "App Store Badge"),
    		array('ID' => "displayATOMappicon", 'label' => "App Icon"),
    		array('ID' => "displayATOMappiconbuybutton", 'label' => "App Icon's buy button"),
     		array('ID' => "-----", 'label' => "Details"),
  	 		array('ID' => "displayATOMversion", 'label' => "App Version"),
     		array('ID' => "displayATOMdevelopername", 'label' => "Developer Name"),
    		array('ID' => "displayATOMsellername", 'label' => "Seller Name"),
  			array('ID' => "displayATOMreleasedate", 'label' => "Date Released"),
     		array('ID' => "displayATOMfilesize", 'label' => "File Size"),
     		array('ID' => "displayATOMuniversal", 'label' => "Universal App icon"),
 			array('ID' => "displayATOMadvisoryrating", 'label' => "Advisory Rating"),
 			array('ID' => "displayATOMappinapppurwarning", 'label' => "Offers In-App Purchases warning (When Available)"),
   			array('ID' => "displayATOMcategories", 'label' => "App Categories"),
     		array('ID' => "-----", 'label' => "Additional Elements"),
     		array('ID' => "displayATOMgamecenterenabled", 'label' => "Game Center Enabled icon"),
    		array('ID' => "displayATOMappbuybutton", 'label' => "App Buy Button"),
    		array('ID' => "displayATOMstarrating", 'label' => "App Star Rating"),
     		array('ID' => "displayATOMscreenshots", 'label' => "Screen Shots"),
    		array('ID' => "displayATOMsupporteddevices", 'label' => "Supported Devices list"),
     		array('ID' => "displayATOMsupporteddeviceIcons", 'label' => "Supported Device Icons")
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
		
		
<h2 class="asa_admin">Order of Post Elements</h2>
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

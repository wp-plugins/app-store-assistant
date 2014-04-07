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
    	$appStoreElements = array(
     		array('ID' => "-----", 'label' => "Single Elements"),
     		array('ID' => "displayapptitle", 'label' => "App Name", 'modes' => "HIDE,NORM_NOTITLE,INLINE_NOTITLE"),
    		array('ID' => "displayappicon", 'label' => "App Icon", 'modes' => "HIDE,NORM_NOTITLE,INLINE_NOTITLE"),
     		array('ID' => "displayappiconbuybutton", 'label' => "App Icon w/ buy button", 'modes' => "HIDE,NORM_NOTITLE,INLINE_NOTITLE"),
			array('ID' => "displaystarrating", 'label' => "App Star Rating", 'modes' => "HIDE,NORM_TITLE,NORM_NOTITLE,INLINE_TITLE,INLINE_NOTITLE"),
			array('ID' => "displayappdescription", 'label' => "App Description", 'modes' => "HIDE,NORM_TITLE,NORM_NOTITLE,INLINE_TITLE,INLINE_NOTITLE,CLOSED,OPEN"),
    		array('ID' => "displayappreleasenotes", 'label' => "App Release Notes", 'modes' => "HIDE,NORM_TITLE,NORM_NOTITLE,INLINE_TITLE,INLINE_NOTITLE,CLOSED,OPEN"),
    		array('ID' => "displayappdetailssection", 'label' => "Details Section", 'modes' => "HIDE,NORM_TITLE,NORM_NOTITLE,CLOSED,OPEN"),
      		array('ID' => "displayscreenshots", 'label' => "Screen Shots", 'modes' => "HIDE,NORM_TITLE,NORM_NOTITLE,CLOSED,OPEN"),
      		array('ID' => "displaysupporteddevices", 'label' => "Supported Devices", 'modes' => "HIDE,NORM_TITLE,NORM_NOTITLE,INLINE_TITLE,INLINE_NOTITLE,CLOSED,OPEN"),
    		array('ID' => "displayappbadge", 'label' => "App Store Badge", 'modes' => "HIDE,NORM_NOTITLE,INLINE_NOTITLE"),
     		array('ID' => "displaygamecenterenabled", 'label' => "Game Center Enabled icon", 'modes' => "HIDE,NORM_TITLE,NORM_NOTITLE,INLINE_NOTITLE"),
    		array('ID' => "displayappbuybutton", 'label' => "App Buy Button", 'modes' => "HIDE,NORM_NOTITLE,INLINE_NOTITLE"),
     		array('ID' => "-----", 'label' => "Details Elements", 'modes' => ""),
  	 		array('ID' => "displayversion", 'label' => "App Version", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
     		array('ID' => "displaydevelopername", 'label' => "Developer Name", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
    		array('ID' => "displaysellername", 'label' => "Seller Name", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
  			array('ID' => "displayreleasedate", 'label' => "Date Released", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
  			array('ID' => "displayprice", 'label' => "Price", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
     		array('ID' => "displayfilesize", 'label' => "File Size", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
     		array('ID' => "displayuniversal", 'label' => "Universal App icon", 'modes' => "HIDE,INLINE_NOTITLE"),
 			array('ID' => "displayadvisoryrating", 'label' => "Advisory Rating", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
 			array('ID' => "displayappinapppurwarning", 'label' => "Offers In-App Purchases*", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE"),
   			array('ID' => "displaycategories", 'label' => "App Categories", 'modes' => "HIDE,INLINE_TITLE,INLINE_NOTITLE")
    	);  	
 		echo '<div class="appStore_datagrid">';
		echo '<table><thead><tr><th>Element</th><th>Mode</th></tr></thead><tbody>';
		foreach($appStoreElements as $appStoreElement) {
			if($appStoreElement['ID'] == "-----") {
				echo '<tr class="alt"><td colspan="2">';
				echo "- ".$appStoreElement['label']." -";
				echo '</tr>';
			} else {
				echo "<tr>\r";
				echo '<td style="text-align:right"><b>'.$appStoreElement['label'].'</b></td>';
				echo '<td style="text-align:right">';
				echo '<select name="appStore_options[';
				echo $appStoreElement['ID'];
				echo ']">';
				$AllowedModes = explode(",", $appStoreElement['modes']);
				if(in_array("HIDE", $AllowedModes)) {
					echo '<option value="HIDE" ';
					if ($options[$appStoreElement['ID']] == "HIDE" || $options[$appStoreElement['ID']] == "no") echo 'selected';
					echo '>Hide Element</option>';
				}
				if(in_array("NORM_TITLE", $AllowedModes)) {
					echo '<option value="NORM_TITLE" ';
					if ($options[$appStoreElement['ID']] == "NORM_TITLE" || $options[$appStoreElement['ID']] == "yes") echo 'selected';
					echo '>Normal</option>';
				}
				if(in_array("NORM_NOTITLE", $AllowedModes)) {
					echo '<option value="NORM_NOTITLE" ';
					if ($options[$appStoreElement['ID']] == "NORM_NOTITLE" || $options[$appStoreElement['ID']] == "notitle" || $options[$appStoreElement['ID']] == "yes") echo 'selected';
					echo '>Normal No Title</option>';
				}
				if(in_array("INLINE_TITLE", $AllowedModes)) {
					echo '<option value="INLINE_TITLE" ';
					if ($options[$appStoreElement['ID']] == "INLINE_TITLE") echo 'selected';
					echo '>Inline</option>';
				}
				if(in_array("INLINE_NOTITLE", $AllowedModes)) {
					echo '<option value="INLINE_NOTITLE" ';
					if ($options[$appStoreElement['ID']] == "INLINE_NOTITLE") echo 'selected';
					echo '>Inline No Title</option>';
				}
				if(in_array("CLOSED", $AllowedModes)) {
					echo '<option value="CLOSED" ';
					if ($options[$appStoreElement['ID']] == "CLOSED" || $options[$appStoreElement['ID']] == "closed") echo 'selected';
					echo '>Accordion Closed</option>';
				}
				if(in_array("OPEN", $AllowedModes)) {
					echo '<option value="OPEN" ';
					if ($options[$appStoreElement['ID']] == "OPEN" || $options[$appStoreElement['ID']] == "open") echo 'selected';
					echo '>Accordion Open</option>';
				}
				echo "</select></td></tr>\r";
			}
		}
		

		echo '</tbody></table></div>';
		
		?>
		
<b>Hide Element</b>: Do Not Display this element<br />
<b>Normal</b>: Display Element Title in H3 tag and Separate Element<br />
<b>Normal No Title</b>: Same as Normal except the title is omitted. (Handy for themes that remove formatting)<br />
<b>Inline</b>: Displays Section Title: Description (No new line or Header tag)<br />
<b>Inline No Title</b>: Same as Inline except the title is omitted<br />
<b>Accordion Closed</b>: Show the element in an Accordion (starting off closed)<br />
<b>Accordion Open</b>: Show the element in an Accordion (starting off open)<br />
<hr>
<b>*</b>: Displays this warning when available).<br />
	
</div>
<?php
    	$appStoreProperties = array(
    		"appStoreDetail_appName" => "App Name",
    		"appStoreDetail_appIcon" => "App Icon",
    		"appStoreDetail_appIconBuyButton" => "App Icon w/ Buy Button",
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
			echo "<!--RUNNING -----".print_r($appStoreProperties,true)."-- -->";

		$appDetailsOrder = explode(",", appStore_setting('appDetailsOrder'));
		$appDetailsOrder = array_filter($appDetailsOrder, 'strlen');
		
		if(count($appDetailsOrder) != 12) {
			//echo "-----".count($appDetailsOrder)."------[<pre>".print_r($appDetailsOrder,true)."</pre>]-------------";
			$appElements_DefaultList = "appStoreDetail_appName,appStoreDetail_appIcon,appStoreDetail_appDescription,appStoreDetail_appReleaseNotes,appStoreDetail_appBadge,appStoreDetail_appDetails,appStoreDetail_appGCIcon,appStoreDetail_appScreenshots,appStoreDetail_appDeviceList,appStoreDetail_appBuyButton,appStoreDetail_appRating,appStoreDetail_appIconBuyButton";
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

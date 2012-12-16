		<h2 class="asa_admin">Show in Post body:</h2>
			<div class="asa_admin">
		<?php
    	$appStoreProperties = array(
    		array('ID' => "displayapptitle", 'label' => "App Name"),
    		array('ID' => "displayversion", 'label' => "App Version"),
    		array('ID' => "displayscreenshots", 'label' => "Screen Shots"),
    		array('ID' => "displayadvisoryrating", 'label' => "Advisory Rating"),
    		array('ID' => "displaycategories", 'label' => "App Categories"),
    		array('ID' => "displayfilesize", 'label' => "File Size"),
    		array('ID' => "displaystarrating", 'label' => "App Star Rating"),
    		array('ID' => "displaydevelopername", 'label' => "Developer Name"),
    		array('ID' => "displaysellername", 'label' => "Seller Name"),
    		array('ID' => "displaygamecenterenabled", 'label' => "Game Center Enabled icon"),
    		array('ID' => "displayuniversal", 'label' => "Universal App icon"),
    		array('ID' => "displaysupporteddevices", 'label' => "Supported Devices list"),
    		array('ID' => "displayreleasedate", 'label' => "Date Released"),
    	);
    	
    	//$hiddenlist = '<input type="hidden" name="appStore_options[checkboxedoptions]" value="hide_button_background,hide_button_background_hover" />';
		$hiddenlist = array();

		foreach($appStoreProperties as $appStoreProperty) {
			array_push($hiddenlist, $appStoreProperty['ID']);
			echo '<input type="checkbox" name="appStore_options[';
			echo $appStoreProperty['ID'];
			echo ']" value="yes"';
			if ($options[$appStoreProperty['ID']] == "yes") echo ' checked';
			echo ' /> '.$appStoreProperty['label']."<br />\r";
		}
		
		$hiddenlistcsv = implode(',', $hiddenlist);
		echo '<input type="hidden" name="appStore_options[checkboxedoptions]" value="'.$hiddenlistcsv.'" />'
		
		?>
		</div>
		<h2 class="asa_admin">App Icon Size:</h2>
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
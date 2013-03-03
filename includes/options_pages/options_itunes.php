<h2 class="asa_admin">Show in Post body</h2>
   	<div class="asa_admin">
  		<?php
    	$iTunesStoreProperties = array(
    		array('ID' => "displayitunestitle", 'label' => "Music Title"),
    		array('ID' => "displayitunestrackcount", 'label' => "Track Count"),
    		array('ID' => "displayitunesartistname", 'label' => "Artist Name"),
    		array('ID' => "displayitunesfromalbum", 'label' => "From Album&hellip;"),
    		array('ID' => "displayitunesgenre", 'label' => "Genre"),
    		array('ID' => "displayitunesreleasedate", 'label' => "Release Date"),
    		array('ID' => "displayitunesdescription", 'label' => "Description"),
    		array('ID' => "displayitunesexplicitwarning", 'label' => "Explicit Lyrics Bagde"),
    	);
		$hiddenlist = array();

		foreach($iTunesStoreProperties as $iTunesStoreProperty) {
			array_push($hiddenlist, $iTunesStoreProperty['ID']);
			echo '<input type="checkbox" name="appStore_options[';
			echo $iTunesStoreProperty['ID'];
			echo ']" value="yes"';
			if ($options[$iTunesStoreProperty['ID']] == "yes") echo ' checked';
			echo ' /> '.$iTunesStoreProperty['label']."<br />\r";
		}
		$hiddenlistcsv = implode(', ', $hiddenlist);
		echo '<input type="hidden" name="appStore_options[checkboxedoptions]" value="'.$hiddenlistcsv.'" />'
		?>
		</div>
		<h2 class="asa_admin">Item Image Size</h2>
		<div class="asa_admin">
		Image Size to start with: <input type="radio" name="appStore_options[itunesicon_to_use]" value="30" <?php if ($options['itunesicon_to_use'] == "30") echo 'checked'; ?> /> 30px 
		<input type="radio" name="appStore_options[itunesicon_to_use]" value="60" <?php if ($options['itunesicon_to_use'] == "60") echo 'checked'; ?> /> 60px 
		<input type="radio" name="appStore_options[itunesicon_to_use]" value="100" <?php if ($options['itunesicon_to_use'] == "100") echo 'checked'; ?> /> 100px
		<br /><br />
		
		<table class="asa_admin_table">
		<tr>
			<th><input type="radio" name="appStore_options[itunesicon_size_adjust_type]" value="percent" <?php if ($options['itunesicon_size_adjust_type'] == "percent") echo 'checked'; ?> /> Adjust by percentage</th>
			<th><input type="radio" name="appStore_options[itunesicon_size_adjust_type]" value="pixels" <?php if ($options['itunesicon_size_adjust_type'] == "pixels") echo 'checked'; ?> /> Adjust to max pixels</th>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[itunesicon_size_adjust]" value="<?php echo $options['itunesicon_size_adjust']; ?>" />%</td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[itunesicon_size_max]" value="<?php echo $options['itunesicon_size_max']; ?>" />px</td>
		</tr>
		<tr>
			<td>Adjust <input type="text" size="3" name="appStore_options[itunesicon_iOS_size_adjust]" value="<?php echo $options['itunesicon_iOS_size_adjust']; ?>" />%<br /><small>(iOS browsers)</small></td>
			<td>Adjust to <input type="text" size="4" name="appStore_options[itunesicon_iOS_size_max]" value="<?php echo $options['itunesicon_iOS_size_max']; ?>" />px<br /><small>(iOS browsers)</small></td>
		</tr>
		</table>		
		</div>
<h2 class="asa_admin">iTunes Store Badge</h2>
	<div class="asa_admin">
		iTunes Store Badge Verbage: <select name='appStore_options[iTunes_store_badge_type]'>
		<option value="available" <?php if ($options['iTunes_store_badge_type'] == "available") echo 'selected'; ?>>Available on the App Store</option>
		<option value="download" <?php if ($options['iTunes_store_badge_type'] == "download") echo 'selected'; ?>>Download on the App Store</option>
		</select><br />
	</div>
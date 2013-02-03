<?php
    	$starColors = array("clear", "black", "blue","bronze","faded","gold","green","grey","orange","pink","purple","red");
    	?>
		<input type="hidden" name="appStore_options[checkboxedoptions]" value="hide_button_background,hide_button_background_hover,smaller_buy_button_iOS" />

    	<h2 class="asa_admin">Full Star:</h2>
		<?php
    	foreach ($starColors as $starColor) {
    		echo '<input type="radio" ';
    		echo 'name="appStore_options[full_star_color]" ';
    		echo 'value="'.$starColor.'"';
    		if ($options['full_star_color'] == $starColor) echo 'checked';
    		echo ' />';
    		echo '<img src="';
    		echo plugins_url( 'images/star-rating-'.$starColor.'.png', ASA_MAIN_FILE );
    		echo '" alt="'.$starColor.' Star" />';
    		echo '&nbsp;&nbsp;&nbsp;';    	
		}
		?>
		<h2 class="asa_admin">Empty Star:</h2>
		<?php
    	foreach ($starColors as $starColor) {
    		echo '<input type="radio" ';
    		echo 'name="appStore_options[empty_star_color]" ';
    		echo 'value="'.$starColor.'"';
    		if ($options['empty_star_color'] == $starColor) echo 'checked';
    		echo ' />';
    		echo '<img src="';
    		echo plugins_url( 'images/star-rating-'.$starColor.'.png', ASA_MAIN_FILE );
    		echo '" alt="'.$starColor.' Star" />';
    		echo '&nbsp;&nbsp;&nbsp;';    	
		}
		?>
		

	<h2 class="asa_admin">Buy Button Style</h2>
		<div class="asa_admin">     
<?php
	//define your color pickers
	$colorPickers = array(
		array('ID' => 'color_buttonStart', 'label' => 'Button Background Gradient Start'),
		array('ID' => 'color_buttonStop', 'label' => 'Button Background Gradient Stop'),
		array('ID' => 'color_buttonText', 'label' => 'Button Text'),
		array('ID' => 'color_buttonTextShadow', 'label' => 'Button Text Shadow'),
		array('ID' => 'color_buttonShadow', 'label' => 'Button Shadow'),
		array('ID' => 'color_buttonBorder', 'label' => 'Button Border'),
		array('ID' => 'color_buttonHoverStart', 'label' => 'Button Background Gradient Start (Hover)'),
		array('ID' => 'color_buttonHoverStop', 'label' => 'Button Background Gradient Stop (Hover)'),
		array('ID' => 'color_buttonHoverText', 'label' => 'Button Text (Hover)'),
	);

	foreach($colorPickers as $colorPicker) {
		echo "<div>\r";
		echo '<input type="text" class="color" id="'.$colorPicker['ID'].'" ';
		echo 'value="'.$options[$colorPicker['ID']].'" ';
		echo 'name="appStore_options['.$colorPicker['ID'].']" size="6" />'."\r";
		echo '<label for="'.$colorPicker['ID'].'">'.$colorPicker['label'].'</label>'."\r";
		echo '<div id="'.$colorPicker['ID'].'_color"></div>'."\r";
		echo '</div>'."\r";
	}
	
		echo "<br />\r";
		echo '<input type="checkbox" name="appStore_options[hide_button_background]" value="yes"';
		if ($options[hide_button_background] == "yes") echo ' checked';
		echo ' /> Transparent Button Background'."\r";
		echo "<br />\r";
		echo '<input type="checkbox" name="appStore_options[hide_button_background_hover]" value="yes"';
		if ($options[hide_button_background_hover] == "yes") echo ' checked';
		echo ' /> Transparent Button Background (Hover)'."\r";
	
		echo "<br />\r";
		echo 'Button Corner Radius: <input type="text" size="3" name="appStore_options[button_corner_radius]" value="'.$options['button_corner_radius'].'" />px';
		echo "<br />\r";
		echo 'Button Border Width: <input type="text" size="2" name="appStore_options[button_border_width]" value="'.$options['button_border_width'].'" />px';
	
	 ?>
	
		</div>
		
<h2 class="asa_admin">Miscellaneous</h2>
		<div class="asa_admin">
		
		<ul type="square" class="asa_optionslist">
		
		<li><input type="checkbox" name="appStore_options[smaller_buy_button_iOS]" value="yes" <?php if ($options['smaller_buy_button_iOS'] == "yes") echo 'checked'; ?> /> Show a smaller Buy Button in iOS browsers</li>

		<li>Screenshot Width: <input type="text" size="3" maxlength="3" name="appStore_options[ss_size]" value="<?php echo $options['ss_size']; ?>" />px<br />
		<small>(in px. Height is automatic.)</small></li>
		
		</ul>
		</div>
<input type="hidden" name="appStore_options[checkboxedoptions]" value="hide_button_background,hide_button_background_hover,smaller_buy_button_iOS" />

<table class="form-table">
<tr valign="top">
<th scope="row"><label>Button Colors</label></th>
<td><?php
	//define your color pickers
	$colorPickers = array(
		array('ID' => 'color_buttonStart', 'label' => 'Background Gradient Start'),
		array('ID' => 'color_buttonStop', 'label' => 'Background Gradient Stop'),
		array('ID' => 'color_buttonText', 'label' => 'Text'),
		array('ID' => 'color_buttonTextShadow', 'label' => 'Text Shadow'),
		array('ID' => 'color_buttonShadow', 'label' => 'Shadow'),
		array('ID' => 'color_buttonBorder', 'label' => 'Border'),
		array('ID' => 'color_buttonHoverStart', 'label' => 'Background Gradient Start (Hover)'),
		array('ID' => 'color_buttonHoverStop', 'label' => 'Background Gradient Stop (Hover)'),
		array('ID' => 'color_buttonHoverText', 'label' => 'Text (Hover)'),
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
?>	
</td></tr>
<tr valign="top">
<th scope="row"><label>Button Background</label></th>
<td><?php
	echo '<input type="checkbox" name="appStore_options[hide_button_background]" value="yes"';
	if ($options[hide_button_background] == "yes") echo ' checked';
	echo ' /> Transparent Background'."\r";
	echo "<br />\r";
	echo '<input type="checkbox" name="appStore_options[hide_button_background_hover]" value="yes"';
	if ($options[hide_button_background_hover] == "yes") echo ' checked';
	echo ' /> Transparent Background (Hover)'."\r";
?></td></tr>
<tr valign="top">
<th scope="row"><label>Button Border</label></th>
<td><?php
	echo 'Corner Radius: <input type="text" size="3" name="appStore_options[button_corner_radius]" value="'.$options['button_corner_radius'].'" />px';
	echo "<br />\r";
	echo 'Border Width: <input type="text" size="2" name="appStore_options[button_border_width]" value="'.$options['button_border_width'].'" />px';
?></td>
</tr>
<tr valign="top">
<th scope="row"><label>iOS Button</label></th>
<td><input type="checkbox" name="appStore_options[smaller_buy_button_iOS]" value="yes" <?php if ($options['smaller_buy_button_iOS'] == "yes") echo 'checked'; ?> /> Show a smaller Buy Button in iOS browsers
</td>
</tr>

</table>	


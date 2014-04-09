<input type="hidden" name="appStore_options[textboxoptions]" value="PrePositionNumber,PostPositionNumber,displayATOMappPositionNumber" />


<h2 class="asa_admin">Screenshots</h2>
	<div class="asa_admin">
		<div class="asa_admin_element"><label>Screenshot Width</label><input type="text" size="3" maxlength="3" name="appStore_options[ss_size]" value="<?php echo $options['ss_size']; ?>" />px<br />
	<p class="asa_admin_explain">(in px. Height is automatic.)</p>
		</div>
	</div>

<h2 class="asa_admin">ATOM/RSS Feeds</h2>
	<div class="asa_admin">
		<div class="asa_admin_element">Display <input type="text" size="3" name="appStore_options[qty_of_apps]" value="<?php echo $options['qty_of_apps']; ?>" maxlength="3" /> apps from ATOM feed</div>
		<div class="asa_admin_element">Character(s) Before Position Number <input type="text" size="3" name="appStore_options[PrePositionNumber]" value="<?php if ($options['PrePositionNumber'] != "EMP") echo $options['PrePositionNumber']; ?>" maxlength="3" /></div>
		<div class="asa_admin_element">Character(s) After Position Number <input type="text" size="3" name="appStore_options[PostPositionNumber]" value="<?php if ($options['PostPositionNumber'] != "EMP") echo $options['PostPositionNumber']; ?>" maxlength="3" /></div>

	<div class="asa_admin_element">Display Position Number in lists <input type="checkbox" name="appStore_options[displayATOMappPositionNumber]" value="yes" <?php if ($options['displayATOMappPositionNumber'] == "yes") echo 'checked'; ?> /></div>

	</div>


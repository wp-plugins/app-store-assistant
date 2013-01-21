<input type="hidden" name="appStore_options[checkboxedoptions]" value="cache_images_locally" />
  	<h2 class="asa_admin">Data cache time:</h2>
    	<div class="asa_admin">
    	<select name='appStore_options[cache_time_select_box]'>
				
					<?php $cache_intervals = array(
												'Don\'t cache'=>0,
												'1 minute'=>1*60,
												'5 minutes'=>5*60,
												'10 minutes'=>10*60,
												'30 minutes'=>30*60,
												'1 hour'=>1*60*60,
												'6 hours'=>6*60*60,
												'12 hours'=>12*60*60,
												'24 hours'=>24*60*60,
												'1 Week'=>24*60*60*7,
												'1 Month'=>24*60*60*7*30,
												'1 Year'=>24*60*60*7*30*365
											);
					
					foreach ($cache_intervals as $key => $value) {
						echo '<option value="' . $value . '" ' . selected($value, $options['cache_time_select_box']) . '>' . $key . '</option>';
					}						
					?>							
				</select>
				<span style="color:#666666;margin-left:2px;">This option determines how long before the plugin requests new data from Apple's servers. You can clear the cached app data via the Reset tab.</span>
		</div>		
		<h2 class="asa_admin">Cache images locally:</h2>
		<div class="asa_admin">
		<!-- First checkbox button -->
						<label><input name="appStore_options[cache_images_locally]" type="checkbox" value="1" <?php if (isset($options['cache_images_locally'])) { checked('1', $options['cache_images_locally']); } ?> /> Load icons, screenshots, etc. locally instead of using Apple's CDN server.</label><br /><small>The <b><?php echo $upload_dir['basedir']; ?></b> directory MUST be writeable for this option to have any effect.</small>
		</div>
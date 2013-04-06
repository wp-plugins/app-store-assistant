<?php
    	$starColors = array("clear", "black", "blue","bronze","faded","gold","green","grey","orange","pink","purple","red");
    	?>

    	<h2 class="asa_admin">Full Star</h2>
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
		<h2 class="asa_admin">Empty Star</h2>
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
		

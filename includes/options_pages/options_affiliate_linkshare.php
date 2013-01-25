		<h2 class="asa_admin">LinkShare Settings:</h2>
			<div class="asa_admin">

<p>1.  The easiest way to get your LinkShare Wrapper is to first get an example link to use as a guideline. You can do this by logging into your LinkShare dashboard and navigating to the Link Maker tool. Once there, make sure the country pop-up menu matches the affiliate program you just came through. Next, search for anything you like, click one of the results, and take the chunk of HTML that is given to you in step 3. It should look similar to this: </p>
<p><code>&lt;a href=&quot;http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30&quot; target=&quot;itunes_store&quot;&gt;&lt;img height=&quot;15&quot; width=&quot;61&quot; alt=&quot;Pearl Jam - Backspacer - Just Breathe&quot; src=&quot;http://ax.phobos.apple.com.edgesuite.net/images/badgeitunes61x15dark.gif&quot; /&gt;&lt;/a&gt;</code></p>
<p>2. From your chunk of HTML, grab the actual link in the HREF tag. For example: </p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30</code></p>
<p>3. From the actual link, you now need to cut out the "wrapper." This is the part of the affiliate link that stays the same. This can be identified as everything in the beginning of link up through the <code>RD_PARM1=</code>. For example: </p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=</code></p>
<hr>
<p>When using LinkShare, the affiliate token is siteID. This value is your 11-character encrypted ID that exists as the "id" value in any other LinkShare built link. The easiest way to find this value is to build a sample link using the Link Maker tool as defined in steps 1 and 2 earlier in the Affiliate Encoding for LinkShare section. For example, the siteID for an account that generated the following link would be: CBIMl*gYY/8.</p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30</code></p>

LinkShare Wrapper: <input type="text" size="80" name="appStore_options[affiliatecode]" value="<?php echo $options['affiliatecode']; ?>" /><br />

LinkShare Affiliate Token: <input type="text" size="11" name="appStore_options[affiliatetoken]" value="<?php echo $options['affiliatetoken']; ?>" maxlength="11" />
		</div>
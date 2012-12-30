      <table class="form-table">
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">Affiliate Networks</th>
				</tr>
				<tr>
					<th scope="row">Affiliate Network:<br /></th>
					<td colspan="2">
					<select name="appStore_options[affiliatepartnerid]">
					<option value="999" <?php if ($options['affiliatepartnerid'] == "999") echo 'selected'; ?>>None</option>
					<option value="30" <?php if ($options['affiliatepartnerid'] == "30") echo 'selected'; ?>>LinkShare</option>
					<option value="2003" <?php if ($options['affiliatepartnerid'] == "2003") echo 'selected'; ?>>TradeDoubler</option>
					<option value="1002" <?php if ($options['affiliatepartnerid'] == "1002") echo 'selected'; ?>>DGM</option>
					</select>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">LinkShare Settings</th>
				</tr>

				<tr>
					<td scope="row"></td><td colspan="2"><p>1.  The easiest way to get your LinkShare Wrapper is to first get an example link to use as a guideline. You can do this by logging into your LinkShare dashboard and navigating to the Link Maker tool. Once there, make sure the country pop-up menu matches the affiliate program you just came through. Next, search for anything you like, click one of the results, and take the chunk of HTML that is given to you in step 3. It should look similar to this: </p>
<p><code>&lt;a href=&quot;http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30&quot; target=&quot;itunes_store&quot;&gt;&lt;img height=&quot;15&quot; width=&quot;61&quot; alt=&quot;Pearl Jam - Backspacer - Just Breathe&quot; src=&quot;http://ax.phobos.apple.com.edgesuite.net/images/badgeitunes61x15dark.gif&quot; /&gt;&lt;/a&gt;</code></p>
<p>2. From your chunk of HTML, grab the actual link in the HREF tag. For example: </p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30</code></p>
<p>3. From the actual link, you now need to cut out the "wrapper." This is the part of the affiliate link that stays the same. This can be identified as everything in the beginning of link up through the <code>RD_PARM1=</code>. For example: </p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&amp;offerid=146261&amp;type=3&amp;subid=0&amp;tmpid=1826&amp;RD_PARM1=</code></p>
<hr>
<p>When using LinkShare, the affiliate token is siteID. This value is your 11-character encrypted ID that exists as the "id" value in any other LinkShare built link. The easiest way to find this value is to build a sample link using the Link Maker tool as defined in steps 1 and 2 earlier in the Affiliate Encoding for LinkShare section. For example, the siteID for an account that generated the following link would be: CBIMl*gYY/8.</p>
<p><code>http://click.linksynergy.com/fs-bin/stat?id=CBIMl*gYY/8&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=http%253A%252F%252Fitunes.apple.com%252Fus%252Falbum%252Fjust-breathe%252Fid329520595%253Fi%253D329520674%2526uo%253D6%2526partnerId%253D30</code></p>
				</td>
				</tr>
				<tr>
					<th scope="row">LinkShare Wrapper:</th>
					<td colspan="2">
						<input type="text" size="80" name="appStore_options[affiliatecode]" value="<?php echo $options['affiliatecode']; ?>" />
					</td>
				</tr>
				<th scope="row">LinkShare Affiliate Token:</th>
					<td colspan="2">
						<input type="text" size="11" name="appStore_options[affiliatetoken]" value="<?php echo $options['affiliatetoken']; ?>" maxlength="11" />
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">TradeDoubler Settings</th>
				</tr>
				<tr>
					<td scope="row"></td><td colspan="2"><p>TradeDoubler offers the iTunes and App Store Affiliate Program as separate programs in 14 different countries. You need to be accepted into at least one country to be able to link in Europe. If you need to link to several EU countries for which you don't yet have an affiliate account, you can enable this directly on the TradeDoubler portal (Settings -> Site Information -> My Countries).</p><p>To create an affiliate tracking link for TradeDoubler (Europe), you will need your program ID and website ID. These can be found on the TradeDoubler affiliate dashboard (Under "Settings" then "Site information").</p>
					</td>
				</tr>
				<tr>
				<th scope="row">TradeDoubler websiteID:</th>
					<td colspan="2">
						<input type="text" size="20" name="appStore_options[tdwebsiteID]" value="<?php echo $options['tdwebsiteID']; ?>"/>
					</td>
				</tr>
				<tr>
					<th scope="row">TradeDoubler Program ID:<br /></th>
					<td colspan="2">
					<select name="appStore_options[tdprogramID]">
					<option value="24380" <?php if ($options['tdprogramID'] == "24380") echo 'selected'; ?>>iTunes AT</option>
					<option value="24379" <?php if ($options['tdprogramID'] == "24379") echo 'selected'; ?>>iTunes BE</option>
					<option value="24372" <?php if ($options['tdprogramID'] == "24372") echo 'selected'; ?>>iTunes CH</option>
					<option value="23761" <?php if ($options['tdprogramID'] == "23761") echo 'selected'; ?>>iTunes DE</option>
					<option value="24375" <?php if ($options['tdprogramID'] == "24375") echo 'selected'; ?>>iTunes DK</option>
					<option value="24364" <?php if ($options['tdprogramID'] == "24364") echo 'selected'; ?>>iTunes ES</option>
					<option value="24366" <?php if ($options['tdprogramID'] == "24366") echo 'selected'; ?>>iTunes FI</option>
					<option value="23753" <?php if ($options['tdprogramID'] == "23753") echo 'selected'; ?>>iTunes FR</option>
					<option value="23708" <?php if ($options['tdprogramID'] == "23708") echo 'selected'; ?>>iTunes GB</option>
					<option value="24367" <?php if ($options['tdprogramID'] == "24367") echo 'selected'; ?>>iTunes IE</option>
					<option value="24373" <?php if ($options['tdprogramID'] == "24373") echo 'selected'; ?>>iTunes IT</option>
					<option value="24371" <?php if ($options['tdprogramID'] == "24371") echo 'selected'; ?>>iTunes NL</option>
					<option value="24369" <?php if ($options['tdprogramID'] == "24369") echo 'selected'; ?>>iTunes NO</option>
					<option value="23762" <?php if ($options['tdprogramID'] == "23762") echo 'selected'; ?>>iTunes SE</option>
					</select>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="background-color: #B3B3B3;font-weight: bold;">DGM Settings</th>
				</tr>
				<tr>
					<td scope="row"></td><td colspan="2"><p>Following these steps will allow you to create an affiliate link for the Australia or New Zealand program. Before you begin, it is important to make sure you have been approved for these accounts and have access to them. </p>
<p>1.  The easiest way to start building your affiliate links is to first get an example. You can do this by logging into your DGM dashboard and navigating to the Link Maker tool. Once there, make sure the country pop-up menu matches the affiliate program you just came through. Next, search for anything you like, click one of the results, and take the chunk of HTML that is then given to you. It should look similar to this: </p>
<p><code>&lt;a href=&quot;http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=http%3A%2F%2Fitunes.apple.com%2Fau%2Falbum%2Fthe-fixer%2Fid327780123%3Fi%3D327780135%26uo%3D6%26partnerId%3D1002&quot; target=&quot;itunes_store&quot;&gt;&lt;img height=&quot;15&quot; width=&quot;61&quot; alt=&quot;Pearl Jam - Backspacer - The Fixer&quot; src=&quot;http://ax.phobos.apple.com.edgesuite.net/images/badgeitunes61x15dark.gif&quot; /&gt;&lt;/a&gt;</code></p>
<p>2. From your chunk of HTML, grab the actual link in the HREF tag. For example: </p>
<p><code>http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=http%3A%2F%2Fitunes.apple.com%2Fau%2Falbum%2Fthe-fixer%2Fid327780123%3Fi%3D327780135%26uo%3D6%26partnerId%3D1002</code></p>
<p>3. From the actual link, you now need to cut out the "wrapper." This is the part of the affiliate link that stays the same. This can be identified as everything in the link up through the "<code>t=</code>". For example: </p>
<p><code>http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=</code></p>
					</td>
				</tr>
				<tr>
				<th scope="row">DGM wrapper:</th>
					<td colspan="2">
						<input type="text" size="50" name="appStore_options[dgmwrapper]" value="<?php echo $options['dgmwrapper']; ?>"/>
					</td>
				</tr>
			</table>
		<h2 class="asa_admin">DGM Settings:</h2>
			<div class="asa_admin">

		<p>Following these steps will allow you to create an affiliate link for the Australia or New Zealand program. Before you begin, it is important to make sure you have been approved for these accounts and have access to them. </p>
<p>1.  The easiest way to start building your affiliate links is to first get an example. You can do this by logging into your DGM dashboard and navigating to the Link Maker tool. Once there, make sure the country pop-up menu matches the affiliate program you just came through. Next, search for anything you like, click one of the results, and take the chunk of HTML that is then given to you. It should look similar to this: </p>
<p><code>&lt;a href=&quot;http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=http%3A%2F%2Fitunes.apple.com%2Fau%2Falbum%2Fthe-fixer%2Fid327780123%3Fi%3D327780135%26uo%3D6%26partnerId%3D1002&quot; target=&quot;itunes_store&quot;&gt;&lt;img height=&quot;15&quot; width=&quot;61&quot; alt=&quot;Pearl Jam - Backspacer - The Fixer&quot; src=&quot;http://ax.phobos.apple.com.edgesuite.net/images/badgeitunes61x15dark.gif&quot; /&gt;&lt;/a&gt;</code></p>
<p>2. From your chunk of HTML, grab the actual link in the HREF tag. For example: </p>
<p><code>http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=http%3A%2F%2Fitunes.apple.com%2Fau%2Falbum%2Fthe-fixer%2Fid327780123%3Fi%3D327780135%26uo%3D6%26partnerId%3D1002</code></p>
<p>3. From the actual link, you now need to cut out the "wrapper." This is the part of the affiliate link that stays the same. This can be identified as everything in the link up through the "<code>t=</code>". For example: </p>
<p><code>http://www.s2d6.com/x/?x=c&amp;z=s&amp;v=1530946&amp;t=</code></p>

DGM wrapper: <input type="text" size="50" name="appStore_options[dgmwrapper]" value="<?php echo $options['dgmwrapper']; ?>"/>
		</div>

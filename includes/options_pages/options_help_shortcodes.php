<h2>Shortcodes</h2>

<h3 class="asa_admin">Display a single item:</h3>

<div class="asa_help">
<ul>
<li>[ios_app id="568903335" more_info_text="More Info on this App..."]<p>Displays a single iOS app</p>
	<ul>
	<li>id: The iOS app's App Store ID<p>This can be found in the copied link from the iTunes App Store.<br />For example: <i>https://itunes.apple.com/us/app/1password/id<b>568903335</b>?mt=8</i></p></li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
<li>[mac_app id="443987910" more_info_text="More Info on this Mac App..."]<p>Displays a single Mac app</p>
	<ul>
	<li>id: The Mac App Store ID<p>This can be found in the copied link from the App Store.<br />For example: <i>https://itunes.apple.com/us/app/1password-password-manager/id<b>443987910</b>?mt=12</i></p></li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
<li>[itunes_store id="62101268" more_info_text="More Info on this iTunes item..."]<p>Displays a single item from the iTunes Store</p>
	<ul>
	<li>id: The iTunes Store ID<p>This can be found in the copied link from the iTunes Store.<br />For example: <i>https://itunes.apple.com/us/album/aliens-original-motion-picture/id<b>62101268</b></i><br />Works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos</p></li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
<li>[amazon_item asin="B001KNH8VU" more_info_text="More Info on this item from Amazon.com..."]<p>Displays a single item from Amazon.com</p>
	<ul>
	<li>asin: The Amazon Standard Identification Number is a 10-character alphanumeric unique identifier assigned by Amazon.com<p>Found in the URL from Amazon.com<br />For example: <i>http://www.amazon.com/dp/<b>B001KNH8VU</b>/?tag=047-20</i></p></li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
</ul>

<h3 class="asa_admin">Display several items from a ATOM/RSS Feed:</h3>
	
<ul>
<li>[asaf_atomfeed atomurl="http://iTunes.apple.com/us/rss/toppaidmacapps/limit=25" mode="iOS" more_info_text="open in App Store..."]<p>Displays the items from the ATOM feed in a formatted view</p>
	<ul>
	<li>atomurl: feed URL supplied by Apple RSS Generator<p>These feeds can be generated here: <i>http://itunes.apple.com/rss</i>.</p></li>
	<li>mode: [iOS, Mac or iTunes]</li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>

<li>[ios_app_list ids="568903335,62101268,443987910,568903335" more_info_text="open in App Store..." mode="iOS"]<p>Displays Several iOS apps on a single page or post</p>
	<ul>
	<li>ids: Comma separated list iOS app's App Store IDs<p>These can be found in the copied link from the iTunes or Mac App Stores.<br />iOS App example: <i>https://itunes.apple.com/us/app/1password/id<b>568903335</b>?mt=8</i><br />iTunes example: <i>https://itunes.apple.com/us/album/aliens-original-motion-picture/id<b>62101268</b></i><br />Mac App example: <i>https://itunes.apple.com/us/app/1password-password-manager/id<b>443987910</b>?mt=12</i></p></li>
	<li>mode: [iOS, Mac, Mixed or iTunes]<p>Mixed displays both iOS and Mac apps</p></li>
	<li>more_info_text: Button text</li>
	</ul>
</li>
</ul>

<h3 class="asa_admin">Display just a html link to an item:</h3>

<ul>
	<li>[ios_app_link id="568903335" text="App Name"]<p>Displays a text only link to the iOS App</p>
	<ul>
	<li>id: The iOS app's App Store ID<p>This can be found in the copied link from the iTunes App Store.<br />For example: <i>https://itunes.apple.com/us/app/1password/id<b>568903335</b>?mt=8</i></p></li>
	<li>text: Link text (optional)<p>If no text is specified, the item name will be displayed.</p></li>
	</ul>
</li>
<li>[mac_app_link id="443987910" text="App Name"]<p>Displays a text only link to the Mac App</p>
	<ul>
	<li>id: The Mac App Store ID<p>This can be found in the copied link from the App Store.<br />For example: <i>https://itunes.apple.com/us/app/1password-password-manager/id<b>443987910</b>?mt=12</i></p></li>
	<li>text: Link text (optional)<p>If no text is specified, the item name will be displayed.</p></li>
	</ul>
</li>
<li>[itunes_store_link id="62101268" text="iTunes Item Name"]<p>Displays a text only link to the iTunes Item</p>
	<ul>
	<li>id: The iTunes Store ID<p>This can be found in the copied link from the iTunes Store.<br />For example: <i>https://itunes.apple.com/us/album/aliens-original-motion-picture/id<b>62101268</b></i><br />Works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos</p></li>
	<li>text: Link text (optional)<p>If no text is specified, the item name will be displayed.</p></li>
	</ul>
</li>
<li>[amazon_item_link asin="B005F02DA0" linktext="Star Wars Ep. 7" textmode="linktext" mode="text" showprice="yes"]<p>Displays the link as a button or text with the Link Text to the Amazon Item</p>
	<ul>
	<li>asin: The Amazon Standard Identification Number is a 10-character alphanumeric unique identifier assigned by Amazon.com<p>Found in the URL from Amazon.com, for example: <i>http://www.amazon.com/dp/<b>B001KNH8VU</b>/?tag=047-20</i></p></li>
	<li>linktext: Link text (optional)<p>This will be used for the link if textmode=linktext</p></li>
	<li>showprice: (optional)<p>If this is set to yes, the price will be shown after the link text</p></li>
	<li>textmode: [<b>linktext</b>, itemname, defaulttext]
		<p>
		<b>linktext</b> displays the text specified in linktext<br />
		<b>defaulttext</b> displays the text specified in Amazon.com settings<br />
		<b>itemname</b> displays the item name
		</p>
	</li>
	<li>mode: [<b>text</b>, button or both]
		<p>
		<b>text</b> displays a text link<br />
		<b>button</b> displays graphical button for the link<br />
		<b>both</b> displays both text and a button.<br />
		</p>
	</li>
	</ul>
</li>
</ul>

<h3 class="asa_admin">Display elements from an item:</h3>

<ul>
	<li>[ios_app_link id="568903335" elements="App Name"]<p>Displays a text only link to the iOS App</p>
	<ul>
	<li>id: The iOS app's App Store ID<p>This can be found in the copied link from the iTunes App Store.<br />For example: <i>https://itunes.apple.com/us/app/1password/id<b>568903335</b>?mt=8</i></p></li>
	<li>elements: One or more of the following items:<br />
	
<ul>
<li>appName</li>
<li>appIcon</li>
<li>appDescription</li>
<li>appBadge</li>
<li>appDetails</li>
<li>appGCIcon</li>
<li>appScreenshots</li>
<li>appDeviceList</li>
<li>appBuyButton</li>
<li>appRating</li>
<li>appPrice</li>
</ul>
	
	</p></li>
	</ul>
</li>
</ul></div>


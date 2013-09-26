<h2>Item IDs</h2>
<h3 class="asa_admin">iOS App ID:</h3>
<i>https://itunes.apple.com/us/app/1password/id<b>568903335</b>?mt=8</i><br />
Works with iOS Apps or Apple TV Apps
<h3 class="asa_admin">iTunes Item:</h3>
<i>https://itunes.apple.com/us/album/aliens-original-motion-picture/id<b>62101268</b></i><br />
Works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons, AudioBooks, eBooks and Music Videos
<h3 class="asa_admin">Mac App ID:</h3>
<i>https://itunes.apple.com/us/app/1password-password-manager/id<b>443987910</b>?mt=12</i><br />
Works with Mac Apps
<h3 class="asa_admin">Amazon.com ASIN:</h3>
The Amazon Standard Identification Number is a 10-character alphanumeric unique identifier assigned by Amazon.com<p>Found in the URL from Amazon.com<br />For example: <i>http://www.amazon.com/dp/<b>B001KNH8VU</b>/?tag=047-20</i></p>

<hr>
<h2>Shortcodes</h2>

<h3 class="asa_admin">Display a single item:</h3>

<div class="asa_help">
<ul>
<li>[asa_item id="568903335" more_info_text="More Info on this App..."]<p>Displays a single Mac/iOS app or iTunes item</p>
	<ul>
	<li>id: The Items Store ID<</li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
<li>[amazon_item asin="B001KNH8VU" more_info_text="More Info on this item from Amazon.com..."]<p>Displays a single item from Amazon.com</p>
	<ul>
	<li>asin: The Amazon Standard Identification Number</li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
<li>[asa_item link="https://itunes.apple.com/us/app/1password/id568903335?mt=8" more_info_text="More Info on this App..."]<p>Displays a single Mac/iOS app or iTunes item using a link*</p>
	<ul>
	<li>link: The items full URL</li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
*(You will still need to run the Add Featured Images Function, if you want the Featured Image.)<br /><br />
</ul>


<h3 class="asa_admin">Display several items from a ATOM/RSS Feed:</h3>
	
<ul>
<li>[asaf_atomfeed atomurl="http://iTunes.apple.com/us/rss/toppaidmacapps/limit=25" more_info_text="open in App Store..."]<p>Displays the items from the ATOM feed in a formatted view</p>
	<ul>
	<li>atomurl: feed URL supplied by Apple RSS Generator<p>These feeds can be generated here: <i>https://rss.itunes.apple.com/</i>.</p></li>
	<li>more_info_text: Excerpt "more info" link text (optional)</li>
	</ul>
</li>
</ul>


<h3 class="asa_admin">Display several items from a list of IDs:</h3>
	
<ul>

<li>[asa_list ids="568903335,62101268,443987910,568903335" more_info_text="open in Store..."]<p>Displays Several apps or iTunes items on a single page or post</p>
	<ul>
	<li>ids: Comma separated list Mac App, iOS App's or iTunes IDs</li>
	<li>more_info_text: Button text</li>
	</ul>
</li>
</ul>

<h3 class="asa_admin">Display just a html link to an item:</h3>

<ul>
	<li>[asa_link id="568903335" text="App Name"]<p>Displays a text only link to the App or iTunes item</p>
	<ul>
	<li>id: The app or items's ID</li>
	</ul>
</li>
<li>[amazon_item_link asin="B005F02DA0" linktext="Star Wars Ep. 7" textmode="linktext" mode="text" showprice="yes"]<p>Displays the link as a button or text with the Link Text to the Amazon Item</p>
	<ul>
	<li>asin: The Amazon Standard Identification Number</li>
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
	<li>[asa_elements id="568903335" elements="appName"]<p>Displays the element or elements for the iOS or Mac App</p>
	<ul>
	<li>id: The iOS,  Mac app or iTunes item's ID</li>
	<li>elements: One or more of the following items:<br />
	
<ul>
<li>appName</li>
<li>appIcon</li>
<li>appDescription</li>
<li>appReleaseNotes</li>
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


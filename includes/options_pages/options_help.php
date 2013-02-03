<h2 class="asa_admin">Shortcodes:</h2>

<h3 class="asa_admin">Display a single item:</h3>

<div class="asa_help">
<ul>
<li>[ios_app id="123456789" more_info_text="More Info on this App..."]<br />
	<ul>
	<li>Displays a single iOS app</li>
	<li>id: The iOS app's App Store ID</li>
	<li>more_info_text: Excerpt "more info" link text</li>
	</ul>
</li>
<li>[mac_app id="123456789" more_info_text="More Info on this Mac App..."]<br />
	<ul>
	<li>Displays a single Mac app</li>
	<li>id: The Mac App Store ID</li>
	<li>more_info_text: Excerpt "more info" link text</li>
	</ul>
</li>
<li>[itunes_store id="123456789" more_info_text="More Info on this iTunes item..."]<br />
	<ul>
	<li>Displays a single item from the iTunes Store</li>
	<li>id: The iTunes Store ID (works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos)</li>
	<li>more_info_text: Excerpt "more info" link text</li>
	</ul>
</li>
<li>[amazon_item asin="B005F02DA0" more_info_text="More Info on this item from Amazon.com..."]<br />
	<ul>
	<li>Displays a single item from Amazon.com</li>
	<li>id: The iTunes Store ID (works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos)</li>
	<li>more_info_text: Excerpt "more info" link text</li>
	</ul>
</li>
</ul>

<h3 class="asa_admin">Display several items from a ATOM/RSS Feed:</h3>
	
<ul>
<li>[asaf_atomfeed atomurl="http://iTunes.apple.com/us/rss/toppaidmacapps/limit=25" mode="iOS" more_info_text="open in App Store..."]<br />
	<ul>
	<li>Displays the items from the ATOm feed in a formatted view</li>
	<li>atomurl: feed URL supplied by Apple RSS Generator</li>
	<li>mode: [iOS, Mac or iTunes]</li>
	<li>more_info_text: Excerpt "more info" link text</li>
	</ul>
</li>


<li>[ios_app_list ids="123456789,123456789,123456789,123456789" more_info_text="open in App Store..." mode="iOS"]<br />
	<ul>
	<li>Displays Several iOS apps on a single page or post</li>
	<li>ids: Comma separated list iOS app's App Store IDs</li>
	<li>mode: [iOS, Mac, Mixed or iTunes] (Mixed displays both iOS and Mac apps)</li>
	<li>more_info_text: Button text</li>
	</ul>
</li>
</ul>

<h3 class="asa_admin">Display just a html link to an item:</h3>


<ul>
	<li>[ios_app_link id="123456789" text="App Name"]<br />
	<ul>
	<li>Displays a text only link to the iOS App</li>
	<li>id: The iOS app's App Store ID</li>
	<li>text: Link text</li>
	</ul>
</li>
<li>[mac_app_link id="123456789" text="App Name"]<br />
	<ul>
	<li>Displays a text only link to the Mac App</li>
	<li>id: The Mac App Store ID</li>
	<li>text: Link text</li>
	</ul>
</li>
<li>[amazon_item_link asin="B005F02DA0" text="Item Name" mode="text"]<br />
	<ul>
	<li>Displays a text only link to the Amazon Item</li>
	<li>asin: The Amazon Store ID (Found in the URL from Amazon.com)</li>
	<li>text: Link text</li>
	<li>mode: [<b>text</b>,button,textPrice,both,bothPrice] Displays the link as a button or text with the Link Text. <b>textPrice</b> displays "Available from Amazon.com for" ending with the price or "View on Amazon.com" if there is no price. <b>both</b> displays both text and a button. <b>bothPrice</b> displays both text with price and a button.</li>
	</ul>
</li>
</ul>

</div>


=== App Store Assistant ===
Contributors: sealsystems 
Donate link:http://theiphoneappslist.com/donate/
TTags: iOS, App Store, iTunes, apps, appstore, iphone, ipad, mac, LinkShare, linksynergy, TradeDoubler, DGM, music
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 4.5.1

The App Store Assistent adds 5 shortcodes to display an ATOM feed or the detail of an item from Apple's App or iTunes Stores. Affiliate ready.

== Description ==

This Wordpress plugin displays a list of iOS or Mac apps from an ATOM feed (http://itunes.apple.com/rss) or the detail for Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos or Apps via the item's ID. It also converts the items's link to use your affiliate program. The App Store Assistant plugin adds 4 shortcodes to display an ATOM feed or the detail of an item from Apple's App Store or the iTunes Store. It also has the ability to use an affiliate program to earn commissions on click-throughs. Demo at http://TheiPhoneAppsList.com or http://TheMacAppsList.com

Works with the LinkShare/Linksynergy, TradeDoubler and DGM Affiliate Programs.

You can also add a shortcode to a Private page and have your own quick search function. Searches for iOS or Mac apps. Displays the shortcode already filled out.

You can also Donate to fund the development of this plugin at <http://theiphoneappslist.com/donate/>

Please let us know of any features you would like added or bugs that need squashing in the Wordpress fourms <http://wordpress.org/tags/app-store-assistant?forum_id=10>


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Change your preferences under Settings
4. Optional: Donate to fund the development of this plugin at <http://theiphoneappslist.com/donate/>

== Available Shortcodes ==

[asaf_atomfeed atomurl="http://itunes.apple.com/us/rss/toppaidmacapps/limit=25" more_info_text="open in App Store..."]

[ios_app id="123456789" more_info_text="open in App Store..."] (where "123456789" is the iOS app's App Store ID)

[mac_app id="123456789" more_info_text="open in Mac App Store..."] (where "123456789" is the Mac App Store ID)

[itunes_store id="123456789" more_info_text="open in iTunes..."] (where "123456789" is the iTunes Store ID) works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos

[appStore_IDsearch] Add this short code to a Private page/post in Wordpress to have your own quick search function. Searches for iPhone/iPod, iPad or Mac apps. Displays Name, Price, Developer, Categories and a copyable shortcode already filled out.

== Screenshots ==

1. Options Page for changing Visual Elements
2. Options Page for changing some of the text elements on the App Store detail
3. Single item from a page of multiple apps
4. ATOM Feed listing

== Changelog ==

= 4.5.1 =
* Added ability to choose which country's store results to display
* Add feature to delete App information cache

= 4.5 =
* Added Currency options (US $, Euro &euro; Norway Krone, Sweden Krona, Japan Yen and UK &pound;)
* Fixed issue with older PHP installations. [Thanks Robert]

= 4.4.3 =
* Fixed issue with RSS Feed button in editor. It was inserting "id" instead of "atomurl". [Thanks Fredrik]
* Added error handling for incorrect tag format.

= 4.4.2 =
* Fixed issue with new Ratings bar images not being displayed
* Added ability to use Full or Short description on Single Post page [Thanks Costin]
* Added ability to use Full or Short description on Multiple Post pages [Thanks Costin]
* Moved App Store bag to local image folder to reduce page load time
* Added ability to reset all options to defaults.
* Changed "More Info" button to better reflect new description options

= 4.4.1 =
* Added 12 additional styles to Ratings bar
* Added ability to customize button colors (Text, Shadows, Gradients etc.)
* Fixed issue with jQuery conflict on Admin pages
* Removed dependancy on specific version of jQuery
* Fixed issue with DMG affiliate code
* Removed legacy code
* Optimized some code
* Added Screenshots

= 4.3.2 =
* Added ability to ID Search for iPhone/iPod OR iPad apps [was just iOS]
* Updated ID Search for Mac apps [API change]
* Added title to ID Search based on selected type of search
* Fixed ID Search form to keep app type selection after search
* Adjusted box size for shortcode in ID Serach Results for easier copying
* CSS changes in ID Search Results

= 4.3.1 =
* Fixed issue with empty Main Stylesheet [Was blank in 4.3]
* Added better CSS/Layout for ID Search
* Added Developer/Seller name to ID Search results
* Cleaned some code for more efficient processing

= 4.3 =
* Redesigned Settings page for easier setup [Major update]
* Added Categories display to ID Search results

= 4.2.4 =
* Added CSS div to details section for compatibility with Google Fonts Plugin

= 4.2.3 =
* Fixed issue where if Apple RSS feed returned an invalid App ID, feed would not display fully.

= 4.2.2 =
* Added donation link to description

= 4.2.1 =
* Fixed Issue with search styles

= 4.2 =
* Added shortcode to have a private search page

= 4.1 =
* Added a button to insert shortcode for iTunes Store
* Added a button to insert shortcode for App Store
* Added a button to insert shortcode for Mac App Store
* Added a button to insert shortcode for Apple ATOM feed

= 4.0 =
* Added a new shortcode for iTunes Store
* Added ability to display Music Albums, Songs and Music Videos
* Added ability to display Movies, Short Films
* Added ability to display TV Episodes and Seasons
* Added choice of App icon size and % adjust
* Added choice of iTunes icon size and % adjust
* Can choose different size icons when viewed on iPhone
* Smaller buy button choice for viewing on iPhone (less text)
* Fixed iTunes Serach API error issue where "collectionId" is used in Albums rather than specified "collectionID"

= 3.0.2 =
* Very minor CSS changes
* Added additional CSS tags
* Fixed Description
* Cleanup of PHP & HTML code (no functional changes)

= 3.0.1 =
* Change text "Rating" to "Age Rating" for Age Advisory
* Change background color for app icons div to transparent

= 3.0 =
* Added Affiliate Network support for TradeDoubler and DGM
* Fixed Affiliate Network support for LinkShare
* Added Affiliate Network partnerId pulldown menu in preferences
* Can now be used with out belonging to the Affiliate program (We do strongly suggest you join though, you should be earning this commission.)
* Added options to display various app details
	-Title
	-Version
	-Developer Name
	-Seller Name
	-Date Released
	-File Size
	-Universal App
	-Age Advisory
	-Categories
	-Star Rating
	-Game Center Enabled icon
	-Supported Devices list

= 2.6 =
* Fixed issue where Mac app icons were cut off in CSS
* Fixed Button Margins
* Made "Show Full Description" button smaller
* Softened buttons
* Made CSS easier to edit for buttons

= 2.5 =
* Bug Fix

= 2.4 =
* Fixed issue if Apple returned an invalid image link
* Added additional CSS entries for customization

= 2.3 =
* Initial public release on Wordpress.org

= 2.2 =
* Initial addition to svn
* Changed screenshot title to Mac or iPhone depending on shortcode

= 2.0 =
* Fixed issues with CSS
* Updated to use Affiliate links
* Added separate support shortcode for Mac App Store
* Added preference for Linkshare affiliate code

= 1.7 =
* Fixed icon sizing issue

= 1.0 =
* Internal release

== Upgrade Notice ==

None.

== Note ==

The App Store Assistant can cache the data from your application in the Wordpress database for a preset number of hours. App icons and screenshots are cached on your server.

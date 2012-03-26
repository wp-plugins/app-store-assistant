=== App Store Assistant ===
Contributors: sealsystems 
Donate link:http://theiphoneappslist.com/donate/
TTags: iOS, App Store, iTunes, apps, appstore, iphone, ipad, mac, LinkShare, linksynergy, TradeDoubler, DGM, music
Requires at least: 3.3
Tested up to: 3.3.1
Stable tag: 4.0

The App Store Assistent adds 4 shortcodes to display an ATOM feed or the detail of an item from Apple's App or iTunes Stores. Affiliate ready.

== Description ==

This Wordpress plugin displays a list of iOS or Mac apps from an ATOM feed (http://itunes.apple.com/rss) or the detail for Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos or Apps via the item's ID. It also converts the items's link to use your affiliate program. It adds 4 shortcodes to display an ATOM feed or the detail of an item from Apple's App Store or the iTunes Store. It also has the ability to use an affiliate program to earn commissions on click-throughs. Demo at http://TheiPhoneAppsList.com or http://TheMacAppsList.com

Works with the LinkShare/Linksynergy, TradeDoubler and DGM Affiliate Programs.


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Available Shortcodes ==

[asaf_atomfeed atomurl="http://itunes.apple.com/us/rss/toppaidmacapps/limit=25" more_info_text="open in App Store..."]

[ios_app id="123456789" more_info_text="open in App Store..."] (where "123456789" is the iOS app's App Store ID)

[mac_app id="123456789" more_info_text="open in Mac App Store..."] (where "123456789" is the Mac App Store ID)

[itunes_store id="123456789" more_info_text="open in iTunes..."] (where "123456789" is the iTunes Store ID) works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos

== Changelog ==

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

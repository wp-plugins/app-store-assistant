=== App Store Assistant ===
Contributors: sealsystems 
Donate link:http://theiphoneappslist.com/donate/
TTags: iOS, App Store, iTunes, apps, appstore, iphone, ipad, mac, LinkShare, linksynergy, TradeDoubler, DGM
Requires at least: 3.3
Tested up to: 3.3
Stable tag: 3.0

The App Store Assistent adds 3 shortcodes to display an ATOM feed or the detail of an app from Apple's App Store. Affiliate program ready.

== Description ==

This Wordpress plugin displays a list of iOS or Mac apps from an ATOM feed (http://itunes.apple.com/rss) or the detail for the app via the app's ID. It also converts the app's link to use your affiliate program. It adds 3 shortcodes to display an ATOM feed or the detail of an app from Apple's App Store. It also has the ability to use an affiliate program to earn commissions on click-throughs. Demo at http://TheiPhoneAppsList.com or http://TheMacAppsList.com


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Available Shortcodes ==

[ios_asaf_atomfeed atomurl="http://itunes.apple.com/us/rss/toppaidmacapps/limit=25" more_info_text="open in App Store..."]

[ios_app id="123456789" more_info_text="open in App Store..."] (where "123456789" is the iOS app's App Store ID)

[mac_app id="123456789" more_info_text="open in Mac App Store..."] (where "123456789" is the Mac App Store ID)


== Changelog ==

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
	-Advisory
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

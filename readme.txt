=== App Store Assistant ===
Contributors: seali
Tags: iOS, App Store, iTunes, apps, appstore, iphone, ipad, mac
Requires at least: 3.3
Tested up to: 3.3
Stable tag: 2.4

Adds a shortcodes to display atom feed or an app detail from Apple's App Store.

== Description ==

This Wordpress plugin displays a list of iOS or Mac apps from an ATOM feed (http://itunes.apple.com/rss) or the detail for the app via the app's ID.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Available Shortcodes ==

[ios_asaf_atomfeed atomurl="http://itunes.apple.com/us/rss/toppaidmacapps/limit=25" more_info_text="open in App Store..."]

[ios_app id="123456789" more_info_text="open in App Store..."] (where "123456789" is the iOS app's App Store ID)

[mac_app id="123456789" more_info_text="open in Mac App Store..."] (where "123456789" is the Mac App Store ID)


== Changelog ==

= 2.5 =
* 

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

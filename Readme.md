# App Store Assistant

This Wordpress plugin displays a list of iOS or Mac apps from an ATOM feed (http://itunes.apple.com/rss) or the detail for the app via the app's ID.


# How to use:

* Upload the plugin folder to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress
* Use one of these shortcodes on your page or post
* [asaf_atomfeed atomurl="http://itunes.apple.com/us/rss/toppaidmacapps/limit=25" more_info_text="open in App Store..."]
* [ios_app id="123456789" more_info_text="open in App Store..."] (where "123456789" is the iOS app's App Store ID)
* [mac_app id="123456789" more_info_text="open in Mac App Store..."] (where "123456789" is the Mac App Store ID)
* [itunes_store id="123456789" more_info_text="open in iTunes..."] (where "123456789" is the iTunes Store ID) works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos

# Note:

The App Store Assistant can cache the data from your application in the Wordpress database for a preset number of hours. App icons and screenshots are cached on your server
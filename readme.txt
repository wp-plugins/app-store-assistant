=== App Store Assistant ===
Contributors: sealsystems 
Donate link:http://theiphoneappslist.com/donate/
TTags: iOS, App Store, iTunes, apps, appstore, iPhone, iPad, mac, LinkShare, linksynergy, TradeDoubler, DGM, music, amazon
Requires at least: 3.3
Tested up to: 3.5
Stable tag: 5.5

The App Store Assistent adds 8 shortcodes to display the detail of an item or an ATOM feed from Apple's App Store, iTunes Stores or Amazon.com. Affiliate ready.

== Description ==

The App Store Assistant Wordpress plugin displays a list of iOS Apps, Mac apps or iTunes content from an ATOM feed (http://itunes.apple.com/rss) or the detail for iPhone/iPod Apps, Mac Apps, iPad Apps, Songs, Albums, Movies, Short Films, TV Episodes, or Seasons and Music Videos via the item's ID. optionally it will also converts the items's link to use your affiliate program. It now also allows items from Amazon.com to be displayed. Demo at http://TheiPhoneAppsList.com or http://TheMacAppsList.com

Works with the LinkShare/Linksynergy, TradeDoubler, Amazon Affiliates or DGM Affiliate Programs.

-----[Amazon.com functionality is a beta release. Use with caution!!!]-----

There is now a built-in quick search function. It searches for iOS or Mac apps. Displays the shortcode already filled out, and with the click of a button, creates a new POST alread titles with the appropriate shortcode already entered.

You can also Donate to fund the development of this plugin at <http://theiphoneappslist.com/donate/>

Please let us know of any features you would like added or bugs that need squashing in the Wordpress fourms <http://wordpress.org/support/plugin/app-store-assistant>

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Change your preferences under Settings
4. Add a shortcode to your page/post. It is recommended to only use one shortcode per page/post.
5. Optional: Donate to fund the development of this plugin at <http://theiphoneappslist.com/donate/>

== Available Shortcodes ==

* [asaf_atomfeed atomurl="http://itunes.apple.com/us/rss/toppaidmacapps/limit=25" mode="iOS" more_info_text="open in App Store..."]
	* Displays the items from the ATOm feed in a formatted view
	* atomurl: feed URL supplied by Apple RSS Generator
	* mode: [iOS, Mac or iTunes]
	* more_info_text: Button text

* [ios_app id="123456789" more_info_text="open in App Store..."]
	* Displays a single iOS app
	* id: The iOS app's App Store ID
	* more_info_text: Button text

* [ios_app_list ids="123456789,123456789,123456789,123456789" more_info_text="open in App Store..." mode="iOS"]
	* Displays Several iOS apps on a single page or post
	* ids: Comma separated list iOS app's App Store IDs
	* mode: [iOS, Mac, Mixed or iTunes] (Mixed displays both iOS and Mac apps)
	* more_info_text: Button text

* [ios_app_link id="123456789" text="App Name"]
	* Displays a text only link to the iOS App
	* id: The iOS app's App Store ID
	* text: Link text

* [mac_app id="123456789" more_info_text="open in Mac App Store..."]
	* Displays a single Mac app
	* id: The Mac App Store ID
	* more_info_text: Button text

* [mac_app_link id="123456789" text="App Name"]
	* Displays a text only link to the Mac App
	* id: The Mac App Store ID
	* text: Link text

* [itunes_store id="123456789" more_info_text="open in iTunes..."]
	* Displays a single item from the iTunes Store
	* id: The iTunes Store ID (works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos)
	
* [amazon_item asin="" more_info_text="open via Amazon.com..."]
	* Displays a single item from Amazon.com
	* id: The iTunes Store ID (works with Songs, Albums, Movies, Short Films, TV Episodes, Seasons and Music Videos)

== Screenshots ==

1. Settings Page for changing Visual Elements
2. Settings Page for changing some of the text elements on the App Store detail
3. Single item from a page of multiple apps
4. ATOM Feed listing
5. General Settings
6. Shortcode buttons on editor toolbar
7. The Search Screen

== Changelog ==
= 5.5 =
* Added Amazon.com beta feature

= 5.1 =
* Fixed issue with WordPress not recognizing manual excerpt

= 5.0.1 =
* Added some WP 3.5 API coolness
* New App Store Search Screen in Settings
	* Search for an App ID with copyable shordcode
	* Auto-Create a post from App Store Search form
	* Moved the appStore_IDsearch to the Settings section
* Added ability to turn off screenshots [Thanks jack89ita]
* Added screenshot of buttons on toolbar [Thanks crazymikesapps]
* Now ready for Localization
* Now creates an Auto Except if no manual excerpt exists
* Rewritten and optimized
	* Settings section
	* Removed ios_asaf_atomfeed shortcode
	* Removed appStore_IDsearch shortcode
	* Major cleanup of codebase
	* Now checks for writable image cache folder
	* Removes cached files and database entries when cache is cleared
* Fixed error with currency set to US instead of USD
* Fixed issue with TinyMCE being re-declared in some themes
* Added App Store Asst menu on Admin screen

= 5.0 =
* See Version 5.0.1

= 4.7.1 =
* HTTPS is now supported for Search and Lookup requests to Apple via their updated Search API.

= 4.7 =
* Added new shortcode [ios_app_list] (Use this shortcode if you are listing **multiple apps** on one page/post.) [Thanks Rodney]
* AppStore links now open in a new window/tab [Thanks bluesteel124]
* Fixed AppStore Badge URL (was missing .gif extension)
* Fixed CSS for iTunes buy buttons
* Cleaned up and corrected readme.txt

= 4.6.1 =
* Added additional CSS configuration for buttons
	* Transparent backgounds
	* Gradient Backgrounds
	* Button Corner Radius
	* Button Border Width

= 4.6 =
* Added two new shortcodes to display an affiliate link anywhere in a post [Thanks pwlk]

= 4.5.4 =
* Fixed cache clearing code
* Updated Screenshots

= 4.5.3 =
* Fixed issue with iTunes RSS feeds [Thanks Fredrik]
* Added "asaf_atomfeed" shortcode option for iTunes or iOS ATOM feeds
* Changed RSS shortcode button in editor to reflect new option

= 4.5.2 =
* Added new search functions for "[appStore_IDsearch]" shortcode
* Improved search results for "[appStore_IDsearch]" shortcode
* Apple now includes some 1024 x 1024 iOS icons and we have added code to handle this
* Added option to choose adjust icon size by percentage or set max pixel size
* Updated CSS for admin page to improve readability
* Reorganized and cleaned up admin page

= 4.5.1 =
* Added ability to choose which country's store results to display
* Add feature to delete App information cache

= 4.5 =
* Added Currency options:
	* US $
	* Euro &euro;
	* Norway Krone
	* Sweden Krona
	* Japan Yen
	* UK &pound;
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
* Added ability to customize button colors
	* Text
	* Shadows
	* Gradients etc.
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
* Added a button to insert shortcode for
	* iTunes Store
	* App Store
	* Mac App Store
	* Apple ATOM feed

= 4.0 =
* Added a new shortcode for iTunes Store
* Added ability to display:
	* Music Albums, Songs and Music Videos
	* Movies, Short Films
	* TV Episodes and Seasons
* Added choice of:
	* App icon size and % adjust
	* iTunes icon size and % adjust
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
	* Title
	* Version
	* Developer Name
	* Seller Name
	* Date Released
	* File Size
	* Universal App
	* Age Advisory
	* Categories
	* Star Rating
	* Game Center Enabled icon
	* Supported Devices list

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

In Version 5.0 the shortcodes appStore_IDsearch and ios_asaf_atomfeed have been deprecated. The functionality of appStore_IDsearch has been moved to the Settings page.

== Note ==

The App Store Assistant can cache the data from your application in the Wordpress database for a preset number of hours. App icons and screenshots are cached on your server.

== Frequently Asked Questions ==

= Whoa, some of my links don't work when I have multiple shortcodes on one page/post? =
Each shortcode is designed to be used just once on a page/post. If you want to have multiple items listed on one page, than I would suggest using the [ios_app_list] shortcode. You can have a comma separated list of items to be displayed.

= I really like the plugin, can I donate to the project? =
Why, thank you for asking, of course you can. Just click the donate link. <http://theiphoneappslist.com/donate/>

== License ==

This file is part of App Store Assistant.

App Store Assistant is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

App Store Assistant is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with App Store Assistant. If not, see <http://www.gnu.org/licenses/>.

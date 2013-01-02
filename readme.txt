=== App Store Assistant ===
Contributors: sealsystems 
Donate link:http://theiphoneappslist.com/donate/
Tags: iOS, App Store, iTunes, apps, appstore, iPhone, iPad, mac, LinkShare, linksynergy, TradeDoubler, DGM, music, amazon
Requires at least: 3.3
Tested up to: 3.5
Stable tag: 5.5.2
License: GPLv3 or later

Lets you display the detail of an item or an ATOM feed from Apple's App Store, iTunes Stores or Amazon.com. Affiliate ready.

== Description ==

The App Store Assistant Wordpress plugin displays a list of iOS Apps, Mac apps or iTunes content from an ATOM feed (http://iTunes.apple.com/rss) or the detail for iPhone/iPod Apps, Mac Apps, iPad Apps, Songs, Albums, Movies, Short Films, TV Episodes, or Seasons and Music Videos via the item's ID. optionally it will also converts the items's link to use your affiliate program. It now also allows items from Amazon.com to be displayed. Demo at http://TheiPhoneAppsList.com or http://TheMacAppsList.com

**Features**

* Displays detailed item information from
	* Apple App Store
	* Mac App Store
	* Amazon.com
	* iTunes Store
		* Songs
		* Albums
		* Movies
		* Short Films
		* TV Episodes or Seasons
		* Music Videos
* Multi-country support
* I18n aka Localization is supported via POT file
* Earn Money with Affiliate Programs
	* LinkShare/Linksynergy
	* TradeDoubler
	* Amazon Affiliates
	* DGM
* Find an App ID fast with the Quick search in the Admin area
* Customizable
	* Choose from different Star rating colors
	* Button colors and style
	* Choose which detail elements to display
	* Adjust App Icon image size
* Cache detail and images locally for quicker page load times
* Use custom Excerpts or let App Store Assistant auto-create an excerpt

*-----[Amazon.com functionality is a beta release. **Use this feature with caution!!!**]-----*

There is now a built-in quick search function. It searches for iOS or Mac apps. Displays the shortcode already filled out, and with the click of a button, creates a new POST already titled with the appropriate shortcode already entered.

You can also Donate to fund the development of this plugin at <http://theiphoneappslist.com/donate/>

Please let us know of any features you would like added or bugs that need squashing in the Wordpress forums <http://wordpress.org/support/plugin/app-store-assistant>

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Change your preferences under Settings
4. Add a shortcode to your page/post. It is recommended to only use one shortcode per page/post.
5. Optional: Donate to fund the development of this plugin at <http://theiphoneappslist.com/donate/>

== Available Shortcodes ==

* [asaf_atomfeed atomurl="http://iTunes.apple.com/us/rss/toppaidmacapps/limit=25" mode="iOS" more_info_text="open in App Store..."]
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
= 5.5.2 =
* Added: Many CSS tags for Amazon.com section
* Fixed: In App list mode, icon was appering above description
* Fixed: In Music list mode, icon was appering above description
* Fixed: Some amazon.com item's use a description from Editorial Review, which can have odd characters. It now tries to translate them.
* Changed: Some options have been moved to make more sense

= 5.5.1 =
* Added: Now displays icons for Supported Devices or List of Supported Devices
* Added: Localization items for Amazon.com section
* Fixed: Debug information was showing

= 5.5 =
* Added: Amazon.com beta feature

= 5.1 =
* Fixed: Issue with WordPress not recognizing manualy entered excerpts

= 5.0.1 =
* Added: Some WP 3.5 API coolness
* Added: New App Store Search Screen in Settings
	* Search for an App ID with copyable shortcode
	* Auto-Create a post from App Store Search form
	* Moved the appStore_IDsearch to the Settings section
* Added: You can now turn off screenshots [Thanks jack89ita]
* Added: Screenshot of buttons on toolbar [Thanks crazymikesapps]
* Added: Now ready for Localization
* Added: Now creates an Auto Except if no manual excerpt exists
* Added: App Store Asst menu on Admin screen
* Updated: Rewritten and optimized
	* Settings section
	* Removed ios_asaf_atomfeed shortcode
	* Removed appStore_IDsearch shortcode
	* Major cleanup of codebase
	* Now checks for writable image cache folder
	* Removes cached files and database entries when cache is cleared
* Fixed: Error with currency set to US instead of USD
* Fixed: TinyMCE was being re-declared in some themes

= 5.0 =
* See Version 5.0.1

= 4.7.1 =
* HTTPS is now supported for Search and Lookup requests to Apple via their updated Search API.

= 4.7 =
* Added: New shortcode [ios_app_list] (Use this shortcode if you are listing **multiple apps** on one page/post.) [Thanks Rodney]
* Added: AppStore links now open in a new window/tab [Thanks bluesteel124]
* Fixed: AppStore Badge URL (was missing .gif extension)
* Fixed: CSS for iTunes buy buttons
* Updated: Cleaned up and corrected readme.txt

= 4.6.1 =
* Added: Additional CSS configuration for buttons
	* Transparent backgrounds
	* Gradient Backgrounds
	* Button Corner Radius
	* Button Border Width

= 4.6 =
* Added: Two new shortcodes to display an affiliate link anywhere in a post [Thanks pwlk]

= 4.5.4 =
* Fixed: Cache clearing code
* Updated: Screenshots

= 4.5.3 =
* Added: Shortcode "asaf_atomfeed" to display iTunes or iOS ATOM feeds
* Fixed: Issue with iTunes RSS feeds [Thanks Fredrik]
* Changed: RSS shortcode button in editor to reflect new shortcode

= 4.5.2 =
* Added: New search functions for "[appStore_IDsearch]" shortcode
* Updated: Improved search results for "[appStore_IDsearch]" shortcode
* Added: Apple now includes some 1024 x 1024 iOS icons and we have added code to handle this
* Added: Option to choose adjust icon size by percentage or set max pixel size
* Updated: CSS for admin page changed to improve readability
* Updated: Reorganized and cleaned up admin page

= 4.5.1 =
* Added: Ability to choose which country's store results to display
* Added: Feature to delete App information cache

= 4.5 =
* Added: New Currency options:
	* US $
	* Euro &euro;
	* Norway Krone
	* Sweden Krona
	* Japan Yen
	* UK &pound;
* Fixed: Issue with older PHP installations. [Thanks Robert]

= 4.4.3 =
* Added: Error handling for incorrect tag format
* Fixed: Issue with RSS Feed button in editor. It was inserting "id" instead of "atomurl". [Thanks Fredrik]

= 4.4.2 =
* Added: Ability to use Full or Short description on Single Post page [Thanks Costin]
* Added: Ability to use Full or Short description on Multiple Post pages [Thanks Costin]
* Added: Ability to reset all options to defaults.
* Fixed: Issue with new Ratings bar images not being displayed
* Changed: Moved App Store badge to local image folder to reduce page load time
* Changed: "More Info" button now better reflects new description options

= 4.4.1 =
* Added: 12 additional styles to Ratings bar
* Added: Ability to customize button colors
	* Text
	* Shadows
	* Gradients etc.
* Fixed: Issue with jQuery conflict on Admin pages
* Fixed: Issue with DMG affiliate code
* Updated: Removed dependency on specific version of jQuery
* Updated: Removed legacy code
* Updated: Optimized some code
* Added: Screenshots

= 4.3.2 =
* Added: Ability to ID Search for iPhone/iPod OR iPad apps [was just iOS]
* Added: Title to ID Search based on selected type of search
* Updated: ID Search for Mac apps [API change]
* Updated: Adjusted box size for shortcode in ID Search Results for easier copying
* Updated: CSS changes in ID Search Results
* Fixed: ID Search form to keep app type selection after search

= 4.3.1 =
* Added: Better CSS/Layout for ID Search
* Added: Developer/Seller name to ID Search results
* Fixed: issue with empty Main Stylesheet [Was blank in 4.3]
* Updated: Cleaned some code for more efficient processing

= 4.3 =
* Updated: Redesigned Settings page for easier setup [Major update]
* Added: Categories display to ID Search results

= 4.2.4 =
* Added: CSS div to details section for compatibility with Google Fonts Plugin

= 4.2.3 =
* Fixed: Issue where if Apple RSS feed returned an invalid App ID, feed would not display fully.

= 4.2.2 =
* Added: Donation link to description

= 4.2.1 =
* Fixed: Issue with search styles

= 4.2 =
* Added: Shortcode to have a private search page

= 4.1 =
* Added: A button to insert shortcode for
	* iTunes Store
	* App Store
	* Mac App Store
	* Apple ATOM feed

= 4.0 =
* Added: A new shortcode for iTunes Store
* Added: Ability to display:
	* Music Albums, Songs and Music Videos
	* Movies, Short Films
	* TV Episodes and Seasons
* Added: Choice of:
	* App icon size and % adjust
	* iTunes icon size and % adjust
* Added: Can choose different size icons when viewed on iPhone
* Added: Smaller buy button choice for viewing on iPhone (less text)
* Fixed: iTunes Search API error issue where "collectionId" is used in Albums rather than specified "collectionID"

= 3.0.2 =
* Updated: Very minor CSS changes
* Added: Additional CSS tags
* Updated: Description
* Updated: Cleanup of PHP & HTML code (no functional changes)

= 3.0.1 =
* Updated: Change text "Rating" to "Age Rating" for Age Advisory
* Changed: Change background color for app icons div to transparent

= 3.0 =
* Added: Affiliate Network support for TradeDoubler and DGM
* Fixed: Affiliate Network support for LinkShare
* Added: Affiliate Network partnerId pulldown menu in preferences
* Changed: Can now be used with out belonging to the Affiliate program (We do strongly suggest you join though, you should be earning this commission.)
* Added: Options to display, or not, various app details
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
* Fixed: Issue where Mac app icons were cut off in CSS
* Fixed: Button Margins
* Changed: Made "Show Full Description" button smaller
* Changed: Softened buttons
* Updated: Made CSS easier to edit for buttons

= 2.5 =
* Fixed: Minor Bug Fix

= 2.4 =
* Fixed: Issue if Apple returned an invalid image link
* Added: Additional CSS entries for customization

= 2.3 =
* Initial public release on Wordpress.org

= 2.2 =
* Initial addition to svn
* Changed: screenshot title to Mac or iPhone depending on shortcode

= 2.0 =
* Fixed: Issues with CSS
* Updated: Now uses Affiliate links
* Added: Separate support shortcode for Mac App Store
* Added: Preference for Linkshare affiliate code

= 1.7 =
* Fixed: Icon sizing issue

= 1.0 =
* Internal release

== Upgrade Notice ==

In Version 5.0 the shortcodes appStore_IDsearch and ios_asaf_atomfeed have been deprecated. The functionality of appStore_IDsearch has been moved to the Settings page. You should change the shortcode from ios_asaf_atomfeed to *asaf_atomfeed*.

== Note ==

The App Store Assistant can cache the data from your application in the Wordpress database for a preset number of hours. App icons and screenshots are cached on your server.

== Frequently Asked Questions ==

= Whoa, some of my links don't work when I have multiple shortcodes on one page/post? =
Each shortcode is designed to be used just once on a page/post. If you want to have multiple items listed on one page, than I would suggest using the [ios_app_list] shortcode. You can have a comma separated list of items to be displayed.

= I really like the plugin, can I donate to the project? =
Why, thank you for asking, of course you can. Just click the [donate link](http://theiphoneappslist.com/donate/ "Donate"). <http://theiphoneappslist.com/donate/>

== License ==

This file is part of App Store Assistant.

App Store Assistant is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

App Store Assistant is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with App Store Assistant. If not, see <http://www.gnu.org/licenses/>.

=== App Store Assistant ===
Contributors: sealsystems 
Donate link:http://theiphoneappslist.com/donate/
Tags: iOS, App Store, iTunes, apps, appstore, iPhone, iPad, mac, LinkShare, linksynergy, TradeDoubler, DGM, music, amazon
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 6.1.0
License: GPLv3 or later

Lets you display the detail of an item or an ATOM feed from Apple's App Store, iTunes Stores or Amazon.com. Affiliate ready.

== Description ==

The App Store Assistant Wordpress plugin displays a list of iOS Apps, Mac apps or iTunes content from an ATOM feed (http://iTunes.apple.com/rss) or the detail for iPhone/iPod Apps, Mac Apps, iPad Apps, Songs, Albums, Movies, Short Films, TV Episodes, or Seasons and Music Videos via the item's ID. optionally it will also converts the items's link to use your affiliate program. It now also allows items from Amazon.com to be displayed. Demo at http://TheiPhoneAppsList.com or http://TheMacAppsList.com

**Features**

* Find an App ID fast with the "New App Post" button in the Admin area
	* Auto-creates new POST or Shortcode
	* Adds App Title
	* Choose from Draft, Publish or Pending
	* Auto creates Featured Image from app icon
	* Adds App Categories to Post
	* Can auto create Categories based on App Categories
* Displays detailed item information or links
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
* Arrange the order of App elements via drag and drop
* You can now display individual item elements via new shortcode
* Multi-country support
* I18n aka Localization is supported via POT file
* Earn Money with Affiliate Programs
	* LinkShare/Linksynergy
	* TradeDoubler
	* Amazon Affiliates
	* DGM
* Customizable
	* Choose from different Star rating colors
	* Button colors and style
	* Choose which detail elements to display and their order
	* Adjust App Icon image size
* Cache detail and images locally for quicker page load times
* Remove the whole cache or individual items
* Widget to show ATOM/RSS Feed of Apps
* Use custom Excerpts or let App Store Assistant auto-create an excerpt
* Tested with over 300 Themes
* Screenshot Lightbox support

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

* [ios_app]: Displays a single iOS app
* [mac_app]: Displays a single Mac app
* [itunes_store]: Displays a single item from the iTunes Store
* [amazon_item]: Displays a single item from Amazon.com
* [asaf_atomfeed]: Displays the items from the ATOm feed in a formatted view with the modes iOS, Mac or iTunes
* [ios_app_list]: Displays Several iOS apps on a single page or post with the modes iOS, Mac, Mixed or iTunes
* [ios_app_link]: Displays a text only link to the iOS App
* [ios_app_elements]: Displays any single element of the iOS Apps details
* [mac_app_link]: Displays a text only link to the Mac App
* [itunes_store_link]: Displays a text only link to the iTunes item
* [amazon_item_link]: Displays a button or text only link to the Amazon Item with the modes text,button or textPrice]. The mode "textPrice" displays "Available from Amazon.com for" ending with price or "View on Amazon.com" if there is no price."

*Full help for shortcodes is displayed in the settings area.*

== Screenshots ==

1. Settings Page for changing Visual Elements
2. Settings Page for changing some of the text elements on the App Store detail
3. Single item from a page of multiple apps
4. ATOM Feed listing
5. General Settings
6. Shortcode buttons on editor toolbar
7. The Search Screen

== Changelog ==

= 6.1.0 =
* Added: When using the New App Post feature it lets you know if you already added the app. [Thanks AslanDoma]
* Changed: Completly rebuilt Image handling. Now much faster and more efficient.
* Added: Option to resize all featured images
* Added: Option to reset all featured images to new size. Won't affect custom Featured Images
* Changed: Icons and Featured Images are now resized in cache for faster loading [Thanks snurnberg]
* Added: You can now specify exact sizes for Icons and Featured Images
* Added: Choose different sizes for Featured Images, Images in posts, lists and on iOS devices
* Added: Screenshots now available on List pages
* Added: You can now specify different elements to display on Single Posts vs Multiple posts and List pages
* Changed: Better handling if an app is no longer available in the app store
* Changed: App Icon uses smaller button, now fits with more themes
* Changed: App Icon display code Simplified
* Changed: Updates now show as a yellow background, and errors as red, in the settings panels
* Removed: Extraneous App Icon CSS
* Fixed: Supported Devices was displayed even when deselected in the options [Thanks aszabo]
* Fixed: Extraneous <a> tag in Small Badge tag
* Changed: Now clears ATOM feed cache when clearing Caches
* Fixed: Cache directory for SimplePie
* Changed: Rebuilt ATOM Feed cacheing system
* Fixed: Extraneous <div> tag, was throwing off some themes
* Fixed: Issue with price button button not respecting preference setting
* Fixed: Amazon.com is now using png and jpg files for product images [Thanks TesterGP]

= 6.0.6 =
* Fixed: Extraneous <div> tag, was throwing off some themes

= 6.0.5 =
* Fixed: Was not displaying Minimal iDevice icons if the app was listing "all" as the supported devices [Thanks snurnberg]
* Added: Missing icons for original iPad Wifi, iPhone 3G & 3GS.
* Added: iDevice icons are now sorted for aesthetic design

= 6.0.4 =
* Added: Link in Admin Bar to create new post from a found App
* Added: Choose which elements show on a App List (ATOM feed or App List)
* Added: Release Notes are now available as an element or part of a post
* Added: "Offers In-App Purchases" warning (When Available)
* Added: You can now use the short description on ATOM Feed displays
* Added: "Supported Devices Minimal Icons" now just shows iPad, iPod, iPhone or iPad mini icons [Thanks snurnberg]
* Changed: App Titles in ATOM Feed displays now uses your Themes H2 style
* Fixed: Renamed a couple badges for the ES Localization that we incorrectly tagged
* Fixed: Icon not showing on ATOM Feed display
* Fixed: Icons added for New iDevices
* Changed: Device list now uses descriptive text rather than device code
* Changed: Device list uses new output method for better compatibility with themes

= 6.0.3 =
* Added: New smaller App Store badge element "appBadgeSm" for the ios_app_elements shortcode [Thanks beakernet]
* Fixed: An issue ios_app_elements that had spaces in the elements list
* Fixed: An issue ios_app_elements that multiple elements (introduced in 6.0.1)
* Fixed: Had a "z" in the button name [Thanks beakernet]
* Fixed: Issue with href tag ending. Fixed for HTML5 compatibility
* Fixed: Issue with empty Value attribute in href tag. Fixed for HTML5 compatibility
* Fixed: Two images were missing from the enlarged screenshots overlay. [Thanks snurnberg]

= 6.0.2 =
* Fixed: An issue where the ios_app_elements shortcode was returning data out of order  [Thanks beakernet]

= 6.0.0 =
* Added: You can now display individual elements via new shortcode "ios_app_elements" [Thanks beakernet & snurnberg]
* Changed: New Simplified Settings Pages
* Changed: Accordian display of description etc
* Changed: Placement of App Store/iTunes badges now separate from description. [Thanks snurnberg]
* Added: You now have the option to have link open in a new window [Thanks beakernet]
* Fixed: The buy button for an iTunes item now render using the custom color selections [Thanks beakernet]
* Fixed: Issue with iTunes store Post body elements prefs not saving. [Thanks beakernet]
* Changed: New icons for iDevice types [Thanks snurnberg]
* Changed: Optimized code 
* Fixed: iTunes Store Badge Verbage in settings

= 5.7.2 =
* Fixed: Issue with images not showing in sort view of Admin section [Thanks snurnberg]

= 5.7.1 =
* Added: OPTIONALLY display "App Icon's buy button" [Thanks snurnberg]
* Added: OPTIONALLY display the Apps description [Thanks snurnberg]
* Changed: You can now edit the shortcode before creating a new post
* Fixed: Sorting of App Elements did not save on some Wordpress setups (broken by JetPack v2.2)
* Fixed: Compatibility issue with JetPack running shortcode twice
* Fixed: Issue with "New App Post" creating longer than necessary shortcode

= 5.7.0 =
* Added: You can now rearrange the order of App elements via drag and drop
* Added: Now saves Featured Image from app icon when using "New App Post" to create post
* Added: New Setting for posts created from "New App Post" [Draft, Publish or Pending]
* Added: New feature to add Featured Images to posts that do not have a Featured Image assigned
* Added: Option to add App Store categories to posts created from "New App Post"
* Added: Option to create new categories, if needed, to posts created from "New App Post"
* Added: Now lists categories and newly created categories upon new post creation
* Added: New option to not display App Icon in post
* Added: You can now clear individual items from the Data cache and Cache folders
* Changed: Now checks for new settings that haven't been set before as sets then them to default (useful on updates)
* Changed: "Find App ID" is now "New App Post"
* Updated: Now caches App data and images upon creation of post when using "New App Post"
* Fixed: Device and "Universal App" icons were showing border in some themes
* Fixed: Does not load excerpt handler if turned off in settings
* Changed: New options for the amazon_item_link shortcode (see help section)
* Changed: Reset page has been changed to Utilities
* Changed: Cache options have been moved to General

= 5.6.6 =
* Added: Short code to display a link to an iTunes item
* Changed: Cleaned up the Shortcode help section and added more descriptive text

= 5.6.5 =
* Added: Shortcode help section to Settings area
* Added: Shortcode to display a link to an Amazon.com items
* Added: amazon_item_link shortcode mode for displaying price after item text
* Added: amazon_item_link shortcode mode for displaying separate text if item price is unavailable
* Added: amazon_item_link shortcode mode for displaying any combination of text and button
* Updated: More text has been added to Localization items for Amazon.com section
* Fixed: Amazon Links now open in a new Window

= 5.6.4 =
*Fixed: See Version 5.6.5 

= 5.6.3 =
* Added: Choose the language of the iTunes/App Store Badges (See General->Localization)
* Added: Choose the text of the iTunes/App Store Badges (See App Store or iTunes Store)
* Added: New icons for iTunes and App Store badges as per new Apple Guidelines
* Changed: Corrected text in iTunes settings section
* Changed: A few default CSS values based on requests

= 5.6.2 =
* Fixed: Buy Button Background Gradient Start does not change the color. [Thanks Jeroen]

= 5.6.1 =
* Added: More options for "More Info" links and buttons
* Removed: Option to use Custom Featured Image generator, conflicted with too many themes
* Added: Option to use WordPress or Custom Excerpt generator
* Updated: New shortcode descriptions for "More Info" text
* Fixed: "More Info" link is now customizable globally or for each shortcode
* Fixed: Issue with excerpt not working with certain themes (see new setting on general tab)
* Fixed: Issue with Featured Image not showing when defined 

= 5.6 =
* Added: Widget to show ATOM Feeds of Apps
* Added: Lightbox for display of Screenshots
* Added: Cacheing of Amazon Product data and images
* Added: Sends Featured Image to Themes that request it (handy for related posts)
* Added: option to show thumbnail as app icon or small product image in excerpt
* Added: option to show "Read More" link in excerpt
* Updated: Amazon Product code to better handle foreign characters
* Added: thumbnail support for iTunes products
* Changed: Unified Cache directory with sub folders for each type of store
* Changed: Optimized Cacheing system
* Changed: Optimized image storing
* Now Tested with over 300 Themes

= 5.5.2 =
* Added: Many CSS tags for Amazon.com section
* Fixed: In App list mode, icon was appearing above description
* Fixed: In Music list mode, icon was appearing above description
* Fixed: Some amazon.com item's use a description from Editorial Review, which can have odd characters. It now tries to translate them.
* Changed: Some options have been moved to make more sense

= 5.5.1 =
* Added: Now displays icons for Supported Devices or List of Supported Devices
* Added: Localization items for Amazon.com section
* Fixed: Debug information was showing

= 5.5 =
* Added: Amazon.com beta feature

= 5.1 =
* Fixed: Issue with WordPress not recognizing manually entered excerpts

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
* Added: Ability to reset all settings to defaults.
* Fixed: Issue with new Ratings bar images not being displayed
* Changed: Moved App Store badge to local image folder to reduce page load time
* Changed: "More Info" button now better reflects new description settings

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
* Added: Settings to display, or not, various app details
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

In Version 5.6 the Cacheing system has been replaced. It is recommended that you clear the caches before upgrading.

In Version 6.0.6 the Image system has been replaced. It is recommended that you clear the caches AFTER upgrading.

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

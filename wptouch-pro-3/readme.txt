=== Plugin Name ===
Requires at least: 3.4
Stable tag: 3.0.8

== Changelog ==

= Version 3.0.8 (August 5th, 2013) =

* Added: Ability to point to wptouch-data directory location from wp-config.php
* Added: Comment moderation notice text when comments require moderation to be displayed
* Fixed: An issue that could prevent YouTube videos without http in the url from re-sizing
* Fixed: Classic Redux - Menu drop-down issues on some Android devices
* Fixed: CMS - blog post titles overflow issue in non-WebKit browsers
* Fixed: CMS - featured slider not appearing in RTL
* Fixed: Switch link not appearing in Chrome on iOS (all themes)
* Fixed: Incompatibility with WordPressSEO by Yoast

= Version 3.0.7 (July 23rd, 2013) =

* Fixed: Possible XSS security issue

= Version 3.0.6 (July 12th, 2013) =

* Fixed: Search input in themes causing zoom on some devices
* Fixed: Issues with Google ads on Android devices causing blank pages
* Fixed: Issues with ads in Simple, CMS & Classic Redux themes
* Fixed: Viewport width issues on some Android devices
* Fixed: Web-App Mode features displaying outside of Web-App Mode
* Fixed: Better audio, video handling in Web-App Mode
* Fixed: An issue which could cause CLassic to show on tablet browsers w/o Tablet support enabled
* Changed: Social links in the footer now open in a new window

= Version 3.0.5 (July 5th, 2013) =

* Added: Support for new WordTwit free version in Classic Redux
* Added: New AJAX setting for desktop switch link
* Fixed: Issues with WordTwit Pro & Classic Redux theme
* Fixed: Issue with click-to-call links
* Fixed: Removed space from "Search" text in Classic theme
* Fixed: Custom menu items can now be opened in a new window
* Fixed: Issue with insecure content on https content pages
* Fixed: Pinterest link in social links
* Fixed: Issue with WPtouch nextpage functionality affecting desktop themes
* Fixed: RTL text display in featured slider titles
* Fixed: Issue with security nonce failure for desktop switch link
* Fixed: Issue with Manage WP update mechanism
* Fixed: Problem with object caching and WPtouch Pro due to autoload in settings
* Fixed: Issue with duplicate content in <title> tag when using WordPress SEO
* Fixed: Issues with search post and page results
* Changed: Small fix for date display in blog
* Changed: Prevented copied and child themes from being deleted if they're active
* Changed: Better tablet support & detection for Classic theme (now catches more Android tablets and Windows 10 touch tablets)

= Version 3.0.4 (May 30th, 2013) =

* Fixed: Viewport issues on Android devices
* Fixed: WPtouch Pro not showing for Lumia 920, other touch Windows Phone devices
* Added: Ability to select a page to show custom latest posts

= Version 3.0.3 (May 27th, 2013) =

* Added: Classic - Setting to turn off page titles
* Added: Setting to disable removal of featured slider posts from blog listings
* Added: Hebrew language
* Fixed: Issues with parent links in drop-down menus
* Fixed: Simple - Multi-page navigation appearing twice
* Changed: Enabled user-scaling by default in browsers, disabled in Web-App Mode
* Changed: Viewport to help Android devices that have issues with the user-scalable attribute

= Version 3.0.2 (May 22nd, 2013) =

* Added: Classic - Setting to disable post date
* Added: Classic - New post thumbnail options, post thumbnails on archive pages
* Added: Classic - Drop-down option to show 'Menu' text instead of icon
* Added: Simple - 3D menu (Advanced setting)
* Added: Vimeo, Pinterest, LinkedIn & RSS to footer social links
* Added: Hungarian translation
* Added: Slide transition speed (Advanced setting) for featured slider
* Added: Silk mode user agent for Kindles
* Added: Setting to leave administration panel untranslated even though themes are translated
* Added: Menu setting to change parent menu item to be a link or toggle children
* Added: Better display of slider images
* Fixed: Classic - An issue where the menu would not be shown if tab-bar was turned off
* Fixed: Simple - issue with ads in the header
* Fixed: Issue with WPtouch Pro showing for Windows desktop touch devices
* Fixed: Issue with Featured slider and missing entries on archive pages and feeds
* Fixed: Issue with WPtouch Pro news in overview not loading
* Fixed: Issue with junk characters in email subject line when sharing a post with unicode content
* Fixed: Issue with multipage links on single post pages
* Fixed: Issue regarding licensing in secondary multisite sites
* Fixed: Issue with Web-App Mode, persistent links
* Fixed: Issue that caused comment counts in the WP admin panel to be shown as '0'
* Fixed: Issue with ads in theme headers
* Fixed: Issue with custom post types not showing on the blog listings page
* Changed: Classic - date, author post settings now respected on single posts as well
* Changed: Classic - comments icon and number now hidden for posts with no comments, or comments disabled
* Changed: CMS - minor usability improvements from customer feedback
* Changed: Added translatable text for Post and Page text in search results
* Changed: Updated FontAwesome module to 3.1.1
* Changed: Improved menu parent/child behaviour in drop-down menus
* Changed: Improved RTL styling in themes
* Changed: Desktop switch-to-mobile links are now output using Javascript and AJAX - resolves desktop caching issues
* Changed: Network activated plugins are now listed in the compatibility section of WPtouch Pro

= Version 3.0.1 (May 8th, 2013) =

* Added: Search option in Simple theme
* Added: Failure case for when an icon-set doesn't properly install
* Added: Setting in CMS theme to enable/disable category slider
* Added: Internal image resizing for large Site Logo images
* Added: Advanced setting to adjust the target for the mobile switch link
* Fixed: Bugs with Simple theme header area
* Fixed: Removed whitespace from Google adsense settings
* Fixed: Debug warnings in notification code
* Fixed: Issue with using page IDs for Featured Slider
* Fixed: Issue with Classic Redux menu items display on tablets
* Fixed: Issue where clicking "Preview Mode" in notification center made reading the setting difficult
* Changed: Modified upgrade logic on the plugins page
* Changed: Minor text changes for consistency in admin settings
* Changed: Category slider in CMS now filters categories excluded via Foundation settings

= Version 3.0 (May 2nd, 2013) =

* Initial release

= Version 3.0GM (May 1st, 2013 ) =

* BraveNewCode internal Gold Master release

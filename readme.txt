=== Unbox Copyright ===
Contributors:      Bridget Wessel
Tags:              block
Tested up to:      6.7.2
Stable tag:        1.3.15
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

WordPress Block to set up a copyright line with auto updating year and Site Title pulled from Settings -> General

Useful in Block Themes to add a copyright line in your footer template part. Add the block and enter a copyright line. If you want the year to auto update, replace the year in your copyright line with [current year]. If you want to use the Site's Name, found in Settings -> General in your copyright line, replace the site title with [site title]. Both replacements will auto update when either change.

== Installation ==

1. Download the latest release. (See "Releases" in right sidebar of Plugin's GitHub repo. Download the zip file attached to the latest release.)
2. Go to your WordPress site and navigate to Plugins -> Add New.
3. Click "Upload Plugin" and select the zip file you downloaded.
4. Activate the plugin through the 'Plugins' screen in WordPress
5. Add the block where you want your copyright line to appear.
6. Enter your copyright line.
7. If you want the year to auto update, replace the year in your copyright line with [current year]. If you want to use the Site's Title, found in Settings -> General in your copyright line, replace the site title with [site title]. Both replacements will auto update when either change.
8. Plugin will auto update from GitHub when a new release is made.


== Frequently Asked Questions ==

= What are the codes that replace the current year and site title? =

[current year] and [site title]. Example:
Copyright ©[current year] [site title]. All Rights Reserved.

== Dev NOTES ==
I'm unable to get the block to allow typography settings besides font size and line height. It seems to be a limitation of WordPress. Put the block in a group and set font settings on the group.


== Changelog ==

= 1.3.15 =
* Date: 9/15/2025
* npm audit fix update, and npx npm-check-updates -u --dep dev

= 1.3.14 =
* Date: 6/26/2025
* Updated @wordpress/scripts, and npx npm-check-updates -u --dep dev

= 1.3.13 =
* Date: 6/25/2025
* Moved Update to separate update plugin

= 1.3.12 =
* Date: 6/25/2025
* Working on separte update plugin

= 1.3.11 =
* Date: 6/3/2025
* Updated security vulnerability in tar-fs npm script

= 1.3.10 =
* Date: 5/2/2025
* Moved label to sidebar block settings so easier to style block in template and can copy example.

= 1.3.9 =
* Date: 4/30/2025
* Added label with shortcodes to add to string so can see example after starting to enter value.

= 1.3.8 =
* Change Date: 2/18/2025
* Got right update checker working.

= 1.3.7 =
* Change Date: 2/18/2025
* Added vendor to plugin files

= 1.3.5 =
* Change Date: 2/17/2025
* Changed version number to 1.3.5 to see if it will auto update from GitHub. Also increased WP and PHP requirements to 6.7.2 and 7.4 respectively.

= 1.3.4 =
* Change Date: 1/31/2025
* Testing increasing version number to 1.3.4 to see if it will auto update from GitHub.

= 1.3.3 =
* Change Date: 1/30/2025
* Testing increasing version number to 1.3.3 to see if it will auto update from GitHub.

= 1.3.2 =
* Change Date: 1/30/2025
* Testing increasing version number to 1.3.2 to see if it will auto update from GitHub.

= 1.3.1 =
* Change Date: 1/30/2025
* Fixed issue where release was not updating automatically from GitHub.

= 1.3 =
* Change Date: 1/30/2025
* Added GitHub Actions to create a release with zip file ready to upload to WordPress site.

= 1.2 =
* Change Date: 1/30/2025
* Added center alignment option to paragraph containing copyright line. 
* Added Auto Update Checker to check for updates, and update plugin automatically from GitHub.

= 1.0 =
* Release

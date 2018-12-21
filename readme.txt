=== Application Passwords .htaccess Fix ===
Contributors: salzano
Tags: application passwords, rest API, htaccess, PHP_AUTH_USER
Requires at least: 3.0.1
Tested up to: 5.0.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Some servers, like those running PHP on fast-cgi need a custom flavor of the content WordPress adds to .htaccess in order for the Application Passwords to operate correctly. This plugin makes & persists that change during .htaccess rewrites.

== Description ==

Manual edits to .htaccess are lost when a user or any other plugin makes a change to WordPress' rewrite rules or permalinks, so this plugin makes sure a customization survives those flushes of the rewrite rules. The Application Passwords plugin requires the use of Basic Authentication headers, and some servers do not provide this functionality. George Stefanis, the author of Application Passwords, [describes a workaround](https://github.com/georgestephanis/application-passwords/wiki/Basic-Authorization-Header----Missing). This plugin simply automates this workaround.

== Installation ==

1. Upload the `application-passwords-htaccess-fix` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= Who needs this plugin? =

Users of Application Passwords who see a warning message near the Application Passwords section of user profiles, and users who have implemented the workaround described in that warning but have noticed that the workaround does not persist after the re-saving of permalinks or flushing of rewrite rules.


== Changelog ==

= 1.0.0 =
* First build
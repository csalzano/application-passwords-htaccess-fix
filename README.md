# Application Passwords .htaccess Fix

This is a WordPress plugin designed to augment the functionality of the [Application Passwords plugin](https://github.com/georgestephanis/application-passwords).

## What this does

Some servers, like those running PHP on fast-cgi need a custom flavor of the content WordPress adds to .htaccess in order for the [Application Passwords plugin](https://github.com/georgestephanis/application-passwords) to operate correctly. This plugin makes & persists that change during .htaccess rewrites.

Manual edits to .htaccess are lost when a user or any other plugin makes a change to WordPress' rewrite rules or permalinks, so this plugin makes sure a customization survives those flushes of the rewrite rules. The Application Passwords plugin requires the use of Basic Authentication headers, and some servers do not provide this functionality. George Stephanis, the author of Application Passwords, [describes a workaround](https://github.com/georgestephanis/application-passwords/wiki/Basic-Authorization-Header----Missing). This plugin simply automates this workaround.

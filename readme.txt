=== Advanced Custom Fields: Google Font Selector Field ===
Contributors: danielpataki
Tags: acf, fonts, google
Requires at least: 3.5
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A field for Advanced Custom Fields which allows users to select Google fonts with advanced options

== Description ==

This plugin allows you to create a Google font selector field with different options. The plugin also creates the font request in the theme header. Font variants and charsets can be selected separately to make font loading more flexible and optimized.

Font options added to any options page will always be enqueues. Any fonts added to post pages will only be enqueued when that specific post is displayed.

This ACF field type is compatible with *ACF 4* and *ACF 5*.

== Installation ==

= Installation =

1. Copy the `acf-google_font_selector` folder into your `wp-content/plugins` folder
2. Activate the Google Font Selector plugin via the plugins admin page
3. Create a new field via ACF and select the Google Font Selector type
4. Please refer to the description for more info regarding the field type settings

= Usage =

Once installed the list of Google Fonts will be retrieved from a static file included in the plugin. If you would like the list to be pulled from the Google API you will need to define your API key. You can do this in the theme's function file for example.

`define( 'ACFGFS_API_KEY', 'your_google_api_key' );`

 It's super easy to get an API key, just head on over to the [Google API Console](http://cloud.google.com/console), create a new project and get a browser api key.


The `ACFGFS_REFRESH` constant can also be defined, it controls how frequently the plugin checks the Google API for updates. The value is in seconds, 86400 would be a day. The default is set to 3 days.

`define( 'ACFGFS_REFRESH', 259200 );`

If you would like to disable the automatic enqueueing of fonts you can use the `ACFGFS_NOENQUEUE` constant. The fonts are only enqueued automatically when this constant is not defined. Define the constant to disable enqueueing.

`define( 'ACFGFS_NOENQUEUE', true );`

== Screenshots ==

1. ACF control for field creation
2. The user-facing font settings

== Changelog ==

= 2.2.1 =
* Updated for WordPress 4.1

= 2.2 =
* Much more efficient font enqueueing
* Separated out common functions: ie: code is better :)

= 2.1 =

* Font requests are now merged properly
* Added field checks and syncing

= 2.0 =

* Complete rewrite, fonts will need to be set up again
* Font loading is now much better and selectable
* Dropped ACF 3 support
* Added ACF 5 support

= 1.0 =

* Initial Release.

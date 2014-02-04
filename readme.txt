=== Advanced Custom Fields: Google Font Selector Field ===
Contributors: danielpataki
Tags: acf, fonts, google
Requires at least: 3.4
Tested up to: 3.8.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A field for Advanced Custom Fields which allows users to select Google fonts with advanced options

== Description ==

The plugin allows you to create a Google font selector field with different options. The plugin also created the font request in the theme header (unless disabled). Font variants and charsets can be selected separately to make font loading more flexible and optimized.

= Compatibility =

This add-on will work with:

* version 4 and up
* version 3 and bellow

== Installation ==

This add-on can be treated as both a WP plugin and a theme include.

= Plugin =
1. Copy the 'acf-google_font_selector' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

= Include =
1.	Copy the 'acf-google_font_selector' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.	Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-google_font_selector.php file)

`
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	include_once('acf-google_font_selector/acf-google_font_selector.php');
}
`

== Changelog ==

= 1.0 =
* Initial Release.

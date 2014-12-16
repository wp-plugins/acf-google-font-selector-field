# ACF Google Font Selector Field

A plugin which extends Advanced Custom Fields for WordPress to allow users to select Google Fonts.

-----------------------

### Description

Welcome to the Google font selector for Advanced custom fields. For information about the base plugin which is required for the role selector to work, take a look at [ACF on Github](https://github.com/elliotcondon/acf) or the official [ACF Homepage](http://www.advancedcustomfields.com/).

The plugin allows you to create a Google font selector field with different options. The plugin also created the font request in the theme header (unless disabled). Font variants and charsets can be selected separately to make font loading more flexible and optimized.

### Compatibility

This ACF field type is compatible with:
* ACF 5
* ACF 4

### Installation

1. Copy the `acf-google_font_selector` folder into your `wp-content/plugins` folder
2. Activate the Google Font Selector plugin via the plugins admin page
3. Create a new field via ACF and select the Google Font Selector type
4. Please refer to the description for more info regarding the field type settings

### Usage

Once installed the list of Google Fonts will be retrieved from a static file included in the plugin. If you would like the list to be pulled from the Google API you will need to define your API key. You can do this in the theme's function file for example.

```php
define( 'ACFGFS_API_KEY', 'your_google_api_key' );
```

 It's super easy to get an API key, just head on over to the [Google API Console](http://cloud.google.com/console), create a new project and get a browser api key.


The `ACFGFS_REFRESH` constant can also be defined, it controls how frequently the plugin checks the Google API for updates. The value is in seconds, 86400 would be a day. The default is set to 3 days.

```php
define( 'ACFGFS_REFRESH', 259200 );
```


### Changelog

= 2.2.1 =
* Updated for WordPress 4.1

= 2.2 =
* Much more efficient font enqueueing
* Separated out common functions: ie: code is better :)

= 2.1 =
* Font requesrs are now merged properly
* Added field checks and syncing

= 2.0 =
* Complete rewrite, fonts will need to be set up again
* Font loading is now much better and selectable
* Dropped ACF 3 support
* Added ACF 5 support

= 1.0 =
* Initial Release.

-----------------------

* Readme : https://github.com/danielpataki/acf-role_selector/blob/master/readme.txt
* WordPress repository: http://wordpress.org/plugins/acf-role-selector-field/

-----------------------

Special thanks to [Elliot Condon](http://elliotcondon.com) for making the wonderful [ACF plugin](advancedcustomfields.com) in the first place.

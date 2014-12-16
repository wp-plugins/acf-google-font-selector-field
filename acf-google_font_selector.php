<?php

/*
Plugin Name: Advanced Custom Fields: Google Font Selector
Plugin URI: https://github.com/danielpataki/acf-google_font_selector
Description: A field for Advanced Custom Fields which allows users to select Google fonts with advanced options
Version: 2.2.1
Author: Daniel Pataki
Author URI: http://danielpataki.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// Load Text Domain
load_plugin_textdomain( 'acf-google_font_selector', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );

// Include Google Font Class
include( 'classes/Bonsai_WP_Google_Fonts/Bonsai_WP_Google_Fonts.php' );

/**
 * Include Common Functions
 */
include_once('acf-google_font_selector-common.php');


/**
 * Include Field Type For ACF5
 */
function include_field_types_google_font_selector( $version ) {
	include_once('acf-google_font_selector-v5.php');
}
// Action To Include Field Type For ACF5
add_action('acf/include_field_types', 'include_field_types_google_font_selector');

/**
 * Include Field Type For ACF4
 */
function register_fields_google_font_selector() {
	include_once('acf-google_font_selector-v4.php');
}
// Action To Include Field Type For ACF4
add_action('acf/register_fields', 'register_fields_google_font_selector');

?>

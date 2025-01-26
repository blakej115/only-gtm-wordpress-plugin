<?php
/*
Plugin Name: Only GTM
Plugin URI: https://wordpress.org/plugins/only-gtm/
Description: A simple plugin to add Google Tag Manager to your site.
Version: 1.0.0
Author: Blake Jones
Author URI: https://blakejones.dev/
License: GPLv2 or later
*/

if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly.
}

// Require the files with our classes
require_once 'settings.php';
require_once 'gtm.php';

// Call our classes, one runs in the admin, and the other on the front-end
if ( is_admin() ) {
    $only_gtm_settings = new OnlyGTMSettings();
} else {
	$only_gtm = new OnlyGTM();
}

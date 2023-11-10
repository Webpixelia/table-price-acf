<?php
/*
Plugin Name: Table Price ACF
Plugin URI: https://webpixelia.com/
Description: Add custom table price plan with ACF Field
Author: Jonathan Dhermand
Version: 4.0.3
Author URI: https://www.webpixelia.com/
License: GPLv2
Text Domain: table-price-acf
Domain Path: /languages/
*/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( __( 'You can\'t access this page', 'table-price-acf' ) );
}

if ( ! defined( 'TABLE_PRICE_ACF_VERSION' ) ) {
	define( 'TABLE_PRICE_ACF_VERSION', '4.0.3' );
	define( 'TABLE_PRICE_ACF_FILE', __FILE__ );
	define( 'TABLE_PRICE_ACF_PATH', dirname( TABLE_PRICE_ACF_FILE ) );
	define( 'TABLE_PRICE_ACF_INCLUDES', TABLE_PRICE_ACF_PATH . '/includes' );
	define( 'TABLE_PRICE_ACF_TEMPLATES', TABLE_PRICE_ACF_PATH . '/templates' );
	define( 'TABLE_PRICE_ACF_URL', plugin_dir_URL( TABLE_PRICE_ACF_FILE ) );
	define( 'TABLE_PRICE_ACF_ASSETS', TABLE_PRICE_ACF_URL . 'assets' );

	include_once TABLE_PRICE_ACF_INCLUDES . '/base.php';
}

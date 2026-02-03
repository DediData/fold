<?php
/**
 * Function file of theme
 *
 * @package Fold
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( '\DediData\Theme_Autoloader' ) ) {
	require __DIR__ . '/includes/DediData/class-theme-autoloader.php';
}
// Set name spaces we use in this plugin
new \DediData\Theme_Autoloader( array( 'DediData', 'Fold' ) );
/**
 * The function FOLD returns an instance of the Fold class.
 *
 * @return \Fold\Fold as an instance of \Fold\Fold
 */
function FOLD() { // phpcs:ignore Squiz.Functions.GlobalFunction.Found, WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return \Fold\Fold::get_instance( __FILE__ );
}
FOLD();

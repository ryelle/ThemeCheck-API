<?php
/**
 * Theme Check API
 *
 * Rudimentary router
 * Assuming Nginx to rewrite urls like /api/slug/ => index.php?action=slug
 */

namespace ThemeCheck\Router;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/load.php';
require_once __DIR__ . '/api.php';

$app = new \Slim\Slim( array(
	'debug' => true,
) );
$app->get( '/options/', '\ThemeCheck\Router\list_options' );
$app->get( '/validate/:theme+', '\ThemeCheck\Router\validate' );
$app->run();

/**
 * List all available checks
 */
function list_options(){
	global $themechecks;
	\ThemeCheck\Functions\send_json_success( array_keys( $themechecks ) );
}

/**
 * Set up and run all theme checks against the uploaded theme
 */
function validate( $theme ){
	$theme_check = new \ThemeCheck\API;

	// Eventually this would handle uploaded files.
	$theme = 'themes/' . implode( '/', $theme );

	if ( ! $theme_check->set_theme( $theme ) ) {
		\ThemeCheck\Functions\send_json_error( 'Theme not found.' );
	}

	$results = $theme_check->run_all_tests();
	\ThemeCheck\Functions\send_json_success( $results );
}

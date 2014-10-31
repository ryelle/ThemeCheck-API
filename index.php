<?php
/**
 * Theme Check API
 *
 * Rudimentary router
 * Assuming Nginx to rewrite urls like /api/slug/ => index.php?action=slug
 */

namespace ThemeCheck;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/load.php';
require_once __DIR__ . '/api.php';

$app = new \Slim\Slim( array(
	'debug' => true,
) );
$app->get( '/options/', '\ThemeCheck\list_options' );
$app->get( '/validate/:theme+', '\ThemeCheck\validate' );
$app->get( '/check/:theme+', '\ThemeCheck\check' );
$app->run();

/**
 * List all available checks
 */
function list_options(){
	global $themechecks;
	send_json_success( array_keys( $themechecks ) );
}

/**
 * Set up and run all theme checks against the uploaded theme
 */
function validate( $theme ){
	$theme_check = new API;

	// Eventually this would handle uploaded files.
	$theme = 'themes/' . implode( '/', $theme );

	if ( ! $theme_check->set_theme( $theme ) ) {
		send_json_error( 'Theme not found.' );
	}

	$results = $theme_check->run_all_tests();
	send_json_success( $results );
}

/**
 * Set up and run selected theme checks against the uploaded theme
 */
function check( $theme ){
	global $app, $themechecks;
	$options = $app->request->params( 'options' );

	// Filter out options that aren't available
	$options = array_intersect( $options, array_keys( $themechecks ) );

	// Run selected tests
}



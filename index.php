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
$app->get( '/tests/', '\ThemeCheck\list_tests' );
$app->get( '/validate/:theme+', '\ThemeCheck\validate' );
$app->get( '/check/:theme+', '\ThemeCheck\check' );
$app->run();

/**
 * List all available checks
 */
function list_tests(){
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

	$results = $theme_check->run_tests();
	send_json_success( $results );
}

/**
 * Set up and run selected theme checks against the uploaded theme
 */
function check( $theme ){
	global $app, $themechecks;
	$theme_check = new API;

	// Eventually this would handle uploaded files.
	$theme = 'themes/' . implode( '/', $theme );
	if ( ! $theme_check->set_theme( $theme ) ) {
		send_json_error( 'Theme not found.' );
	}

	$tests = $app->request->params( 'tests' );
	if ( ! $tests ){
		$results = $theme_check->run_tests( $tests );
		send_json_success( $results );
	}

	// Filter out tests that aren't available
	$tests = array_intersect( (array) $tests, array_keys( $themechecks ) );

	if ( $theme_check->select_tests( $tests ) ){
		$results = $theme_check->run_tests( $tests );
		send_json_success( $results );
	}

	// We've made it this far because there are no valid tests to run.
	send_json_error( 'No valid tests selected.' );
}



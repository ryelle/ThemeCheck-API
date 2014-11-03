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
$app->post( '/validate/', '\ThemeCheck\validate' );
$app->run();

/**
 * List all available checks
 */
function list_tests(){
	global $themechecks;
	send_json_success( array_keys( $themechecks ) );
}

/**
 *
 * @return  ThemeCheck\API  API Object for this theme
 */
function setup(){
	global $app;
	$theme_check = new API;

	$theme = false;
	if ( isset( $_FILES['theme'] ) ) {
		$theme = $_FILES['theme'];
	} else {
		send_json_error( 'Theme not uploaded.' );
	}

	if ( 'application/zip' != $theme['type'] ) {
		send_json_error( 'Please upload a .zip of your theme.' );
	}

	$theme_path = '/tmp/'. str_replace( '.', '', $theme['name'] ) . '/';

	$zip = new \ZipArchive;
	$res = $zip->open( $theme['tmp_name'] );
	if ($res === TRUE) {
		$zip->extractTo( $theme_path );
		$zip->close();
	} else {
		send_json_error( 'Error unzipping theme.' );
	}

	if ( ! $theme_check->set_theme( $theme_path ) ) {
		send_json_error( 'Theme not found.' );
	}

	return $theme_check;
}

/**
 * Set up and run theme checks against the uploaded theme, filtering out unselected tests if necessary.
 */
function validate(){
	global $app, $themechecks;
	$theme_check = setup();

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

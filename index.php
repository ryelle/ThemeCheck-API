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

/*
 * What endpoints might we want?
 * - List of checks available
 * - Just get a theme's data from style.css?
 * - Send all files and get results back
 */
$app = new \Slim\Slim( array(
	'debug' => true,
) );

// @todo POST with file data
$app->get( '/validate/:theme+', '\ThemeCheck\Router\validate' );
$app->run();

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

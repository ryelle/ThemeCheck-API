<?php
/*
 * Helper functions
 */
namespace ThemeCheck;

/**
 * Send a JSON response back to an Ajax request.
 *
 * @param mixed $response Variable (usually an array or object) to encode as JSON,
 *                        then print and die.
 */
function send_json( $response ) {
	@header( 'Content-Type: application/json; charset=UTF-8' );
	echo json_encode( $response );
	die;
}

/**
 * Send a JSON response back to an Ajax request, indicating success.
 *
 * @param mixed $data Data to encode as JSON, then print and die.
 */
function send_json_success( $data = null ) {
	$response = array( 'success' => true );
	if ( isset( $data ) ) {
		$response['data'] = $data;
	}
	send_json( $response );
}

/**
 * Send a JSON response back to an Ajax request, indicating failure.
 *
 * @param mixed $data Data to encode as JSON, then print and die.
 */
function send_json_error( $data = null ) {
	$response = array( 'success' => false );
	if ( isset( $data ) ) {
		$response['data'] = $data;
	}
	send_json( $response );
}

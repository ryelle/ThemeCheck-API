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

/**
 * Get list of files in a directory and all subdirectories.
 *
 * @param  string  $dir  Directory on server
 * @return array         Array list of files
 */
function listdir( $dir ) {
	$files = array();
	$dir_iterator = new \RecursiveDirectoryIterator( $dir );
	$iterator = new \RecursiveIteratorIterator( $dir_iterator, \RecursiveIteratorIterator::SELF_FIRST );

	foreach ( $iterator as $file ) {
		if ( ! in_array( $file->getFilename(), array( '.', '..' ) ) ) {
			array_push( $files, $file->getPathname() );
		}
	}

	return $files;
}

/**
 * Remove a directory, diving into it to remove subfolders and files first.
 *
 * @param  string  $dir  Directory on server
 * @return  boolean  True if successfully deleted, false if not
 */
function delete_dir( $dir ){
	if ( is_dir( $dir ) === true ) {
		$dir_iterator = new \RecursiveDirectoryIterator( $dir );
		$iterator = new \RecursiveIteratorIterator( $dir_iterator, \RecursiveIteratorIterator::CHILD_FIRST );

		foreach ( $iterator as $file ) {
			if ( in_array( $file->getBasename(), array('.', '..') ) !== true ) {
				if ( $file->isDir() === true ) {
					rmdir( $file->getPathName() );
				} else if ( ( $file->isFile() === true ) || ( $file->isLink() === true ) ) {
					unlink( $file->getPathname() );
				}
			}
		}
		return rmdir( $dir );

	} else if ( ( is_file( $dir ) === true ) || ( is_link( $dir ) === true ) ) {
		return unlink( $dir );
	}

	return false;
}

<?php
/**
 * Theme Check class
 */
namespace ThemeCheck;

class API {
	private $theme = '';
	private $base_path = '';
	private $headers = array(
		'Name'        => 'Theme Name',
		'ThemeURI'    => 'Theme URI',
		'Description' => 'Description',
		'Author'      => 'Author',
		'AuthorURI'   => 'Author URI',
		'Version'     => 'Version',
		'Template'    => 'Template',
		'Status'      => 'Status',
		'Tags'        => 'Tags',
		'TextDomain'  => 'Text Domain',
		'DomainPath'  => 'Domain Path',
	);

	public $is_child = false;

	/**
	 * Set the theme we want to check
	 *
	 * @param  string  $theme  Path to the theme folder to check
	 */
	public function set_theme( $zip ) {
		if ( is_a( $zip, 'ZipArchive' ) ) {
			$this->theme = $zip;
			$this->base_path = $this->find_theme( $zip );
			$this->headers = $this->parse_style_header( $zip, $this->base_path );
			if ( $this->headers['Template'] ) {
				$this->is_child = true;
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Grab the base theme path by looking for style.css.
	 *
	 * @param  ZipArchive  $zip  Uploaded theme opened via ZipArchive::open
	 * @return  string  Path to theme inside the zip
	 */
	public function find_theme( $zip ){
		$path = '';
		$style = $zip->locateName( 'style.css' );
		if ( ! $style ) {
			// First entry should be the directory, if we're looking at a zipped folder.
			$path = $zip->getNameIndex( 0 );
			if ( substr( $path, -1 ) == '/' ) {
				$style = $zip->locateName( $path . 'style.css' );
			}
		}
		// If we still don't have a style.css, we don't have a theme.
		if ( ! $style ) {
			send_json_error( "Required file style.css does not exist. This file must be present in a valid theme." );
		}

		return $path;
	}

	/**
	 * Parse style.css for the theme data
	 *
	 * @param  ZipArchive  $zip  Uploaded theme opened via ZipArchive::open
	 * @param  string      $base_path  Path to the theme relative to the zip
	 * @return  array|boolean  Assoc array of theme information, or false if we can't read style.css
	 */
	public function parse_style_header( $zip, $base_path = '' ) {
		$headers = $this->headers;

		// Pull only the first 8kiB of the file in.
		$style = $zip->getFromName( $base_path . 'style.css', 8192 );
		if ( false === $style ) {
			return false;
		}

		// Make sure we catch CR-only line endings.
		$style = str_replace( "\r", "\n", $style );

		foreach ( $headers as $field => $regex ) {
			if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $style, $match ) && $match[1] ) {
				$headers[ $field ] = trim( preg_replace( "/\s*(?:\*\/|\?>).*/", '', $match[1] ) );
			} else {
				$headers[ $field ] = '';
			}
		}

		return $headers;
	}

	/**
	 * Get headers for the currently-selected theme
	 *
	 * @return  array|boolean  Assoc array of headers if we have a theme, false if not.
	 */
	public function get_headers(){
		// Check that the theme is set
		if ( $this->theme ) {
			return $this->headers;
		}
		return false;
	}

	/**
	 * Run the selected checks against this theme.
	 *
	 * @return  array  Associative array of results and run information.
	 */
	public function run_tests(){
		global $themechecks;
		$results = array();
		$passes = $fails = 0;

		$php = $css = $other = array();

		// Pull the files out of the zip.
		for ( $i = 0; $i < $this->theme->numFiles; $i++ ) {
			$file_name = $this->theme->getNameIndex( $i );

			// Don't scan into node_modules or .sass-cache, but keep the top-level folder so it's caught by Filename_Check.
			if ( preg_match( '/(node_modules|\.sass-cache|__macosx)\/.+/i', $file_name ) ){
				continue;
			}

			$extension = substr( strrchr( $file_name, '.' ), 1 );
			if ( $extension == 'php' ) {
				$php[$file_name] = preg_replace('/\s\s+/', ' ', $this->theme->getFromIndex( $i ) );
			} else if ( $extension == 'css' ) {
				$css[$file_name] = $this->theme->getFromIndex( $i );
			} else if ( substr( $file_name, -1 ) == '/' ) {
				$other[$file_name] = '';
			} else if ( in_array( $extension, array( 'jpg', 'jpeg', 'png', 'gif' ) ) ) {
				$other[$file_name] = '';
			} else {
				$other[$file_name] = $this->theme->getFromIndex( $i );
			}
		}

		// A child theme might not have any PHP, so only fail this if there is no Template defined.
		if ( empty( $php ) && '' == $this->is_child ){
			send_json_error( "Invalid theme, no PHP files were found." );
		}

		foreach ( $themechecks as $name => $test ) {
			$test->theme = $this->theme;
			$test->base_path = $this->base_path;
			if ( $test->check( $php, $css, $other ) ) {
				$passes++;
			} else {
				$fails++;
			}

			foreach ( $test->get_error() as $error ) {
				array_push( $results, $error );
			}
		}

		$total_results = count( $results );

		return array(
			'total'   => \ThemeCheck::get_increment(),
			'passes'  => $passes,
			'fails'   => $fails,
			'count'   => $total_results,
			'results' => $results,
		);
	}

	/**
	 * Discard the tests that aren't selected.
	 *
	 * @param   array  $tests  List of selected tests
	 * @return  boolean  Check if we have any tests selected now
	 */
	public function select_tests( $tests ){
		global $themechecks;
		foreach ( $themechecks as $key => $value ) {
			if ( ! in_array( $key, $tests ) ){
				unset( $themechecks[$key] );
			}
		}

		return ( ! empty( $themechecks ) );
	}

}

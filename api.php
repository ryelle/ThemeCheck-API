<?php
/**
 * Theme Check class
 */
namespace ThemeCheck;

class API {
	private $theme = '';
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

	/**
	 * Set the theme we want to check
	 *
	 * @param  string  $theme  Path to the theme folder to check
	 */
	public function set_theme( $theme ) {
		if ( file_exists( $theme ) ) {
			$this->theme = $this->find_theme( $theme );
			$this->headers = $this->parse_style_header( $this->theme );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Grab the base theme directory by looking for style.css.
	 *
	 * @param  string  $theme  Directory of uploaded, unzipped theme
	 * @return  string  Full path to theme
	 */
	public function find_theme( $theme ){
		$base_path = $theme;
		$files = scandir( $theme );
		if ( ! in_array( 'style.css', $files ) ){
			foreach ( $files as $maybe_folder ) {
				if ( in_array( $maybe_folder, array( '.', '..' ) ) ) {
					continue;
				}
				if ( is_dir( $theme . $maybe_folder ) ) {
					$subfiles = scandir( $theme . $maybe_folder );
					if ( in_array( 'style.css', $subfiles ) ) {
						$theme .= $maybe_folder . '/';
						break;
					}
				}
			}
		}
		if ( ! file_exists( $theme . 'style.css' ) ){
			// Invalid theme, should be deleted.
			delete_dir( $base_path );
			send_json_error( "Required file style.css does not exist. This file must be present in a valid theme." );
		}

		return $theme;
	}

	/**
	 * Parse style.css for the theme data
	 *
	 * @return  array  Assoc array of theme information
	 */
	public function parse_style_header( $theme ) {
		$headers = $this->headers;

		// We don't need to write to the file, so just open for reading.
		$fp = fopen( $theme . 'style.css', 'r' );

		// Pull only the first 8kiB of the file in.
		$file_data = fread( $fp, 8192 );

		// PHP will close file handle, but we are good citizens.
		fclose( $fp );

		// Make sure we catch CR-only line endings.
		$file_data = str_replace( "\r", "\n", $file_data );

		foreach ( $headers as $field => $regex ) {
			if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
				$headers[ $field ] = trim( preg_replace( "/\s*(?:\*\/|\?>).*/", '', $match[1] ) );
			else
				$headers[ $field ] = '';
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

		$files = listdir( $this->theme );
		$php = $css = $other = array();

		foreach ( $files as $key => $filename ) {
			if ( substr( $filename, -4 ) == '.php' ) {
				$php[$filename] = php_strip_whitespace( $filename );
			} else if ( substr( $filename, -4 ) == '.css' ) {
				$css[$filename] = file_get_contents( $filename );
			} else {
				$other[$filename] = ( ! is_dir( $filename ) ) ? file_get_contents( $filename ) : '';
			}
		}
		if ( empty( $php ) ){
			send_json_error( "Invalid theme, no PHP files were found." );
		}

		foreach ( $themechecks as $name => $test ) {
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

		// We're done, and should delete our uploaded theme.
		delete_dir( $this->theme );

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

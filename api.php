<?php
/**
 * Theme Check class
 */
namespace ThemeCheck;

class API {
	private $theme = '';
	private $header = array();

	/**
	 * Set the theme we want to check
	 *
	 * @param  string  $theme  Path to the theme folder to check
	 */
	public function set_theme( $theme ) {
		if ( file_exists( $theme ) ) {
			$this->header = $this->parse_style_header( $theme );
			$this->theme = $theme;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Parse style.css for the theme data
	 *
	 * @return  array  Assoc array of theme information
	 */
	public function parse_style_header( $theme ) {
		// Ugh.
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

		foreach ( $files as $key => $filename ) {
			if ( substr( $filename, -4 ) == '.php' ) {
				$php[$filename] = php_strip_whitespace( $filename );
			} else if ( substr( $filename, -4 ) == '.css' ) {
				$css[$filename] = file_get_contents( $filename );
			} else {
				$other[$filename] = ( ! is_dir( $filename ) ) ? file_get_contents( $filename ) : '';
			}
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

		return array(
			'total'   => \ThemeCheck::get_increment(),
			'passes'  => $passes,
			'fails'   => $fails,
			'count'   => $total_results,
			'results' => $results,
		);
	}

}

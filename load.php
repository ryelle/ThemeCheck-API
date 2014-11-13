<?php
/**
 * Define our levels as constants
 */
define( 'TC_REQUIRED', 0 );
define( 'TC_WARNING', 1 );
define( 'TC_RECOMMENDED', 2 );
define( 'TC_INFO', 3 );

// interface that all checks should implement
abstract class ThemeCheck {
	/**
	 * @todo docs
	 */
	protected $error = array();

	/**
	 * Reference to the current theme path
	 */
	public $theme = array();

	// should return true for good/okay/acceptable, false for bad/not-okay/unacceptable
	public function check( $php_files, $css_files, $other_files ){
		return false;
	}

	// should return an array of strings explaining any problems found
	public function get_error() {
		return $this->error;
	}

	static function increment(){
		global $tc_count;
		if ( ! isset( $tc_count ) ){
			$tc_count = 0;
		}
		$tc_count++;
	}

	static function get_increment(){
		global $tc_count;
		return $tc_count;
	}

	/**
	 * Search through a file to find where a particular piece of code is.
	 *
	 * @param  string  $code  Line of code
	 * @param  string  $file_path  Path to file to be searched
	 * @return  int  Line number of code, 0 if not found.
	 */
	public function get_line( $code, $file_contents ) {
		$code = trim( $code );
		if ( empty( $code ) ){
			return 0;
		}

		// Count the number of linebreaks before our flagged code.
		$offset = strpos( $file_contents, $code );
		if ( false !== $offset ) {
			$count = substr_count( $file_contents, "\n", 0, $offset );
			// We've found x linebreaks before this one, so this is on the next.
			return $count + 1;
		}

		return 0;
	}
}

// load all the checks in the checks directory
foreach ( glob( dirname( __FILE__ ) . "/checks/*.php" ) as $file ) {
	require_once( $file );
}

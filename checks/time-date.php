<?php
class Time_Date_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$tests = array(
			'/date_i18n\(\s?["\'][^\'"]+["\']\s?\)/',
			'/[^_]the_date\(\s?["\']([^\'"]+)\s?["\']\s?/',
			'/[^_]the_time\(\s?["\']([^\'"]+)\s?["\']\s?/',
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $tests as $test ) {
				if ( preg_match( $test, $file_contents, $matches ) ) {
					$file_name = basename( $file_path );
					$line = \ThemeCheck\get_line( $matches[0], $file_path );
					$this->error[] = array(
						'level' => TC_INFO,
						'file'  => $file_name,
						'line'  => $line,
						'error' => sprintf( "At least one hard coded date was found. Consider <code>get_option( 'date_format' )</code> instead.", $matches[0] ),
						'test'  => __CLASS__,
					);
				}
			}
		}

		return $pass;
	}
}

$themechecks['time-date'] = new Time_Date_Check;

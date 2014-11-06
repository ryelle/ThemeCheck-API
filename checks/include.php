<?php

class Include_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$tests = array(
			'/(?<![a-z0-9_])(?:requir|includ)e(?:_once)?\s?\(/' => 'The theme appears to use include or require. If these are being used to include separate sections of a template from independent files, then <code>get_template_part()</code> should be used instead.',
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $tests as $test => $reason ) {
				if ( preg_match( $test, $file_contents, $matches ) ) {
					$file_name = basename( $file_path );
					$line = \ThemeCheck\get_line( $matches[0], $file_path );
					$this->error[] = array(
						'level' => TC_RECOMMENDED,
						'file'  => $file_name,
						'line'  => $line,
						'error' => $reason,
						'test'  => __CLASS__,
					);
				}
			}
		}

		return $pass;
	}
}

$themechecks['include'] = new Include_Check;

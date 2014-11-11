<?php

class PHP_Short_Tags_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			// Also capture the next 4 characters so we can find the short tag
			// (otherwise get_line matches the first php tag).
			if ( preg_match( '/<\?(\=?)(?!php|xml).{4}/', $file_contents, $matches ) ) {
				$file_name = basename( $file_path );
				$line = $this->get_line( $matches[0], $file_contents );
				$this->error[] = array(
					'level' => TC_WARNING,
					'file'  => $file_name,
					'line'  => $line,
					'error' => 'Found PHP short tags in file',
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		return $pass;
	}
}

$themechecks['php-short-tags'] = new PHP_Short_Tags_Check;

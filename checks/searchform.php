<?php

class Searchform_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$tests = array(
			array(
				'level'   => TC_REQUIRED,
				'pattern' => '/(include\s?\(\s?TEMPLATEPATH\s?\.?\s?["|\']\/searchform.php["|\']\s?\))/',
				'reason'  => 'Please use <code>get_search_form()</code> instead of including searchform.php directly.',
			),
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $tests as $test ) {
				if ( preg_match( $test['pattern'], $file_contents, $matches ) ) {
					$file_name = basename( $file_path );
					$line = $this->get_line( $matches[1], $file_path );

					$this->error[] = array(
						'level' => $test['level'],
						'file'  => $file_name,
						'line'  => $line,
						'error' => $test['reason'],
						'test'  => __CLASS__,
					);
					$pass = false;
				}
			}
		}

		return $pass;
	}
}

$themechecks['searchform'] = new Searchform_Check;

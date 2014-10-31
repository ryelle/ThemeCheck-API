<?php

class Style_Headers_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$css  = implode( ' ', $css_files );

		$tests = array(
			'[ \t\/*#]*Theme Name:' => '<strong>Theme name:</strong> is missing from your style.css header.',
			'[ \t\/*#]*Description:' => '<strong>Description:</strong> is missing from your style.css header.',
			'[ \t\/*#]*Author:' => '<strong>Author:</strong> is missing from your style.css header.',
			'[ \t\/*#]*Version' => '<strong>Version:</strong> is missing from your style.css header.',
			'[ \t\/*#]*License:' => '<strong>License:</strong> is missing from your style.css header.',
			'[ \t\/*#]*License URI:' => '<strong>License URI:</strong> is missing from your style.css header.',
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $tests as $test => $reason ) {
			if ( ! preg_match( '/' . $test . '/i', $css, $matches ) ) {
				$this->error[] = array(
					'level' => TC_REQUIRED,
					'file'  => false,
					'line'  => false,
					'error' => $reason,
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		return $pass;
	}
}

$themechecks['style-headers'] = new Style_Headers_Check;

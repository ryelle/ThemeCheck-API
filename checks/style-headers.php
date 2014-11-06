<?php

class Style_Headers_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$css  = implode( ' ', $css_files );

		$tests = array(
			array(
				'level' => TC_REQUIRED,
				'pattern' => '[ \t\/*#]*Theme Name:',
				'reason' => '<strong>Theme name:</strong> is missing from your style.css header.',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => '[ \t\/*#]*Description:',
				'reason' => '<strong>Description:</strong> is missing from your style.css header.',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => '[ \t\/*#]*Author:',
				'reason' => '<strong>Author:</strong> is missing from your style.css header.',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => '[ \t\/*#]*Version',
				'reason' => '<strong>Version:</strong> is missing from your style.css header.',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => '[ \t\/*#]*License:',
				'reason' => '<strong>License:</strong> is missing from your style.css header.',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => '[ \t\/*#]*License URI:',
				'reason' => '<strong>License URI:</strong> is missing from your style.css header.',
			), array(
				'level' => TC_RECOMMENDED,
				'pattern' => '[ \t\/*#]*Theme URI:',
				'reason' => '<strong>Theme URI:</strong> is missing from your style.css header.',
			), array(
				'level' => TC_RECOMMENDED,
				'pattern' => '[ \t\/*#]*Author URI:',
				'reason' => '<strong>Author URI:</strong> is missing from your style.css header.',
			),
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $tests as $test ) {
			if ( ! preg_match( '/' . $test['pattern'] . '/i', $css, $matches ) ) {
				$this->error[] = array(
					'level' => $test['level'],
					'file'  => false,
					'line'  => false,
					'error' => $test['reason'],
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		return $pass;
	}
}

$themechecks['style-headers'] = new Style_Headers_Check;

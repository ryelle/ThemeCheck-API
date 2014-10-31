<?php

class CSS_Classes_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$css  = implode( ' ', $css_files );

		$tests = array(
			'\.sticky' => '<strong>.sticky</strong> css class is needed in your theme css.',
			'\.bypostauthor' => '<strong>.bypostauthor</strong> css class is needed in your theme css.',
			'\.alignleft' => '<strong>.alignleft</strong> css class is needed in your theme css.',
			'\.alignright' => '<strong>.alignright</strong> css class is needed in your theme css.',
			'\.aligncenter' => '<strong>.aligncenter</strong> css class is needed in your theme css.',
			'\.wp-caption' => '<strong>.wp-caption</strong> css class is needed in your theme css.',
			'\.wp-caption-text' => '<strong>.wp-caption-text</strong> css class is needed in your theme css.',
			'\.gallery-caption' => '<strong>.gallery-caption</strong> css class is needed in your theme css.',
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

$themechecks['css-classes'] = new CSS_Classes_Check;

<?php

class Custom_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( ! preg_match( '#add_theme_support\s?\(\s?[\'|"]custom-header#', $php ) ) {
			$this->error[] = array(
				'level' => TC_RECOMMENDED,
				'file'  => false,
				'line'  => false,
				'error' => 'No reference to <code>add_theme_support( "custom-header", $args )</code> was found in the theme. It is recommended that the theme implement this functionality if using an image for the header.',
				'test'  => __CLASS__,
			);
		}

		if ( ! preg_match( '#add_theme_support\s?\(\s?[\'|"]custom-background#', $php ) ) {
			$this->error[] = array(
				'level' => TC_RECOMMENDED,
				'file'  => false,
				'line'  => false,
				'error' => 'No reference to <code>add_theme_support( "custom-background", $args )</code> was found in the theme. If the theme uses background images or solid colors for the background, then it is recommended that the theme implement this functionality.',
				'test'  => __CLASS__,
			);
		}

		return $pass;
	}
}

$themechecks['custom'] = new Custom_Check;

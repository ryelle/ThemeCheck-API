<?php

class Artisteer_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( strpos( $php, 'art_normalize_widget_style_tokens' ) !== false
		  || strpos( $php, 'art_include_lib' ) !== false
		  || strpos( $php, '_remove_last_slash($url) {' ) !== false
		  || strpos( $php, 'adi_normalize_widget_style_tokens' ) !== false
		  || strpos( $php, 'm_normalize_widget_style_tokens' ) !== false
		  || strpos( $php, "bw = '<!--- BEGIN Widget --->';" ) !== false
		  || strpos( $php, "ew = '<!-- end_widget -->';" ) !== false
		  || strpos( $php, "end_widget' => '<!-- end_widget -->'") !== false
		) {
			$this->error[] = array(
				'level' => TC_WARNING,
				'file'  => false,
				'line'  => false,
				'error' => 'This theme appears to have been auto-generated. Generated themes are not allowed in the themes directory.',
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks['artisteer'] = new Artisteer_Check;

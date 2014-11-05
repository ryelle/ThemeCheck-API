<?php

class Content_Width_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( strpos( $php, '$content_width' ) === false
		  && ! preg_match( '/add_filter\(\s?("|\')embed_defaults/', $php )
		  && ! preg_match( '/add_filter\(\s?("|\')content_width/', $php )
		) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => "No content width has been defined.",
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks[ 'content-width' ] = new Content_Width_Check;

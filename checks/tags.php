<?php

class Tags_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( strpos( $php, 'the_tags' ) === false
		  && strpos( $php, 'get_the_tag_list' ) === false
		  && strpos( $php, 'get_the_term_list' ) === false
		) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => "This theme doesn't seem to display tags. Modify it to display tags in appropriate locations.",
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks['tags'] = new Tags_Check;

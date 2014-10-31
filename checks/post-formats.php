<?php

class Post_Formats_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php  = implode( ' ', $php_files );
		$css  = implode( ' ', $css_files );

		$tests = array(
			'/add_theme_support\(\s?("|\')post-formats("|\')/m',
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $tests as $test ) {
				if ( preg_match( $test, $file_contents, $matches ) ) {

					if ( ! strpos( $php, 'get_post_format' )
					  && ! strpos( $php, 'has_post_format' )
					  && ! strpos( $css, '.format' )
					) {
						$file_name = basename( $file_path );
						$error = ltrim( rtrim( $matches[0], '(' ) );
						$this->error[] = array(
							'level' => TC_REQUIRED,
							'file'  => false,
							'line'  => false,
							'error' => sprintf( 'Post format support was added in the file <code>%s</code>. However get_post_format and/or has_post_format were not found, and no use of formats in the CSS was detected.', $file_name ),
							'test'  => __CLASS__,
						);
						$pass = false;
					}
				}
			}
		}

		return $pass;
	}
}

$themechecks['post-formats'] = new Post_Formats_Check;

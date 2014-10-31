<?php

/**
 * Checks for the use of deprecated function parameters.
 */
class Deprecated_Args_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$functions = array(
			'get_bloginfo' => array(
				'home'                 => 'home_url()',
				'url'                  => 'home_url()',
				'wpurl'                => 'site_url()',
				'stylesheet_directory' => 'get_stylesheet_directory_uri()',
				'template_directory'   => 'get_template_directory_uri()',
				'template_url'         => 'get_template_directory_uri()',
				'text_direction'       => 'is_rtl()',
				'feed_url'             => "get_feed_link( 'feed' ), where feed is rss, rss2 or atom",
			),
			'bloginfo' => array(
				'home'                 => 'echo esc_url( home_url() )',
				'url'                  => 'echo esc_url( home_url() )',
				'wpurl'                => 'echo esc_url( site_url() )',
				'stylesheet_directory' => 'echo esc_url( get_stylesheet_directory_uri() )',
				'template_directory'   => 'echo esc_url( get_template_directory_uri() )',
				'template_url'         => 'echo esc_url( get_template_directory_uri() )',
				'text_direction'       => 'is_rtl()',
				'feed_url'             => "echo esc_url( get_feed_link( 'feed' ) ), where feed is rss, rss2 or atom",
			),
			'get_option' => array(
				'home'     => 'home_url()',
				'site_url' => 'site_url()',
			)
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $functions as $function => $invalid_args ) {

				// Loop through the parameters and look for all function/parameter combinations.
				foreach ( $invalid_args as $parameter => $replacement ) {
					if ( preg_match( '/' . $function . '\(\s*("|\')' . $parameter . '("|\')\s*\)/', $file_contents, $matches ) ) {

						$file_name = basename( $file_path );
						$error = ltrim( rtrim( $matches[0], '(' ) );

						$this->error[] = array(
							'level' => TC_REQUIRED,
							'file'  => $file_name,
							'line'  => 0, // @todo
							'error' => sprintf( '<code>%s</code> was found. It is deprecated, use <code>%s</code> instead.', $error, $replacement ),
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

$themechecks['deprecated-args'] = new Deprecated_Args_Check;

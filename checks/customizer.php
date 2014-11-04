<?php
/**
 * Checks for the Customizer.
 */
class Customizer_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files) {
		$pass = true;

		ThemeCheck::increment(); // Keep track of how many checks we do.

		/**
		 * Check whether every Customizer setting has a sanitization callback set.
		 * Get the arguments passed to the add_setting method, then check if we
		 * have a sanitize_callback or sanitize_js_callback.
		 */
		foreach ( $php_files as $file_path => $file_contents ) {
			if ( preg_match_all( '/\$wp_customize->add_setting\(([^;]+)/', $file_contents, $matches ) ) {
				foreach ( $matches[1] as $match ) {
					if ( false === strpos( $match, 'sanitize_callback' ) && false === strpos( $match, 'sanitize_js_callback' ) ) {
						$file_name = basename( $file_path );
						$line = \ThemeCheck\get_line( $match, $file_path );
						$this->error[] = array(
							'level' => TC_REQUIRED,
							'file'  => $file_name,
							'line'  => null,
							'error' => 'Found a Customizer setting that did not have a sanitization callback function. Every call to the <strong>add_setting()</strong> method needs to have a sanitization callback function passed.',
							'test'  => __CLASS__,
						);
						$pass = false;

					} else {
						// There's a callback, check that no empty parameter is passed.
						if ( preg_match( '/[\'"](?:sanitize_callback|sanitize_js_callback)[\'"]\s*=>\s*[\'"]\s*[\'"]/', $match ) ) {
							$file_name = basename( $file_path );
							$line = \ThemeCheck\get_line( $match, $file_path );
							$this->error[] = array(
								'level' => TC_REQUIRED,
								'file'  => $file_name,
								'line'  => null,
								'error' => 'Found a Customizer setting that had an empty value passed as sanitization callback. You need to pass a function name as sanitization callback.',
								'test'  => __CLASS__,
							);
							$pass = false;
						}
					}
				}
			}
		}

		return $pass;
	}
}

$themechecks['customizer'] = new Customizer_Check;

<?php

class Textdomain_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$header = ( new \ThemeCheck\API )->parse_style_header( $this->theme, $this->base_path );
		$header['TextDomain'] = strtolower( $header['TextDomain'] );

		// Checks for a textdomain in __(), _e(), _x(), _n(), and _nx().
		$textdomain_regex = '/[\s\(]_x\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?\)|[\s\(;]_[_e]\s?\(\s?[\'"][^\'"]*[\'"]\s?\)|[\s\(]_n\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[$a-z\(\)0-9]*\s?\)|[\s\(]_nx\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[$a-z\(\)0-9]*\s?,\s?[\'"][^\'"]*[\'"]\s?\)/';

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			if ( preg_match_all( $textdomain_regex, $file_contents, $matches ) ) {
				$file_name = basename( $file_path );
				foreach ( $matches[0] as $match ) {
					$line = $this->get_line( trim( $match ), $file_contents );
					$this->error[] = array(
						'level' => TC_RECOMMENDED,
						'file'  => $file_name,
						'line'  => $line,
						'error' => 'Text domain problems were found.',
						'test'  => __CLASS__,
					);
				}
			}
		}

		// Check if we have a textdomain in style.css. Considering this required if tagged 'translation-ready'.
		if ( empty( $header['TextDomain'] ) ){
			$error = array(
				'level' => TC_RECOMMENDED,
				'file'  => 'style.css',
				'line'  => false,
				'error' => 'Text domain is not set in style.css.',
				'test'  => __CLASS__,
			);
			if ( false !== strpos( $header['Tags'], 'translation-ready' ) ) {
				$error['level'] = TC_REQUIRED;
				$pass = false;
			}
			$this->error[] = $error;

			// Don't bother checking next step, since we don't have a textdomain to check against.
			return $pass;
		}

		$get_domain_regexs = array(
			'/[\s\(;]_[_e]\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"]([^\'"]*)[\'"]\s?\)/',
			'/[\s\(]_x\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"]([^\'"]*)[\'"]\s?\)/',
			'/[\s\(]_n\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[$a-z\(\)0-9]*\s?,\s?[\'"]([^\'"]*)[\'"]\s?\)/',
			'/[\s\(]_nx\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[$a-z\(\)0-9]*\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"]([^\'"]*)[\'"]\s?\)/',
		);

		foreach ( $php_files as $file_path => $file_contents ) {
			$file_name = basename( $file_path );
			foreach ( $get_domain_regexs as $regex ) {
				if ( preg_match_all( $regex, $file_contents, $matches, PREG_SET_ORDER ) ) {
					foreach ( $matches as $match ){
						if ( $header['TextDomain'] !== $match[1] ) {
							$line = $this->get_line( trim( $match[0] ), $file_contents );
							$this->error[] = array(
								'level' => TC_RECOMMENDED,
								'file'  => $file_name,
								'line'  => $line,
								'error' => sprintf( 'Text domain problems were found, domain <code>%s</code> must match the theme slug.', $match[1] ),
								'test'  => __CLASS__,
							);
						}
					}
				}
			}
		}

		// If we don't have the tokenizer, just return this check.
		if ( ! function_exists( 'token_get_all' ) ) {
			return $pass;
		}

		$get_domain_regexs = array(
			'/[\s\(;]_[_e]\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?([^\)]*)\s?\)/',
			'/[\s\(]_x\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?([^\)]*)\s?\)/',
			'/[\s\(]_n\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[$a-z\(\)0-9]*\s?,\s?([^\)]*)\s?\)/',
			'/[\s\(]_nx\s?\(\s?[\'"][^\'"]*[\'"]\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?[$a-z\(\)0-9]*\s?,\s?[\'"][^\'"]*[\'"]\s?,\s?([^\)]*)\s?\)/',
		);

		foreach ( $php_files as $file_path => $file_contents ) {
			$file_name = basename( $file_path );
			foreach ( $get_domain_regexs as $regex ) {
				if ( preg_match_all( $regex, $file_contents, $matches, PREG_SET_ORDER ) ) {
					foreach ( $matches as $match ){
						$error = $match[0];
						$tokens = @token_get_all( '<?php '.$match[1].';' );
						if ( empty( $tokens ) ) {
							continue;
						}
						foreach ( $tokens as $token ) {
							if ( is_array( $token ) && in_array( $token[0], array( T_VARIABLE, T_CONST, T_STRING ) ) ) {
								$line = $this->get_line( trim( $error ), $file_contents );
								$this->error[] = array(
									'level' => TC_RECOMMENDED,
									'file'  => $file_name,
									'line'  => $line,
									'error' => sprintf( 'Text domain must be a string: <code>%s</code> is not a valid text domain.', trim( $match[1] ) ),
									'test'  => __CLASS__,
								);
							}
						}
					}
				}
			}
		}

		return $pass;
	}
}

$themechecks['textdomain'] = new Textdomain_Check;

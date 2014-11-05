<?php

class Links_Check extends ThemeCheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$header = ( new \ThemeCheck\API )->parse_style_header( $this->theme );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		// regex borrowed from TAC
		$url_re = '([[:alnum:]\-\.])+(\\.)([[:alnum:]]){2,4}([[:blank:][:alnum:]\/\+\=\%\&\_\\\.\~\?\-]*)';
		$title_re = '[[:blank:][:alnum:][:punct:]]*'; // 0 or more: any num, letter(upper/lower) or any punc symbol
		$space_re = '(\\s*)';
		$link_regex = "/(<a)(\\s+)(href" . $space_re . "=" . $space_re . "\"" . $space_re . "((http|https|ftp):\\/\\/)?)" . $url_re . "(\"" . $space_re . $title_re . $space_re . ">)" . $title_re . "(<\\/a>)/is";

		foreach ( $php_files as $file_path => $file_contents ) {
			$line = false;

			if ( preg_match_all( $link_regex, $file_contents, $matches, PREG_SET_ORDER ) ) {
				$file_name = basename( $file_path );
				foreach( $matches as $key ) {
					if ( preg_match( '/\<a\s?href\s?=\s?["|\'](.*?)[\'|"](.*?)\>(.*?)\<\/a\>/is', $key[0], $stripped ) ) {
						if ( ! empty( $header['AuthorURI'] )
						  && ! empty( $header['ThemeURI'] )
						  && $stripped[1]
						  && false === strpos( $stripped[1], $header['ThemeURI'] )
						  && false === strpos( $stripped[1], $header['AuthorURI'] )
						  && false === strpos( $stripped[1], 'wordpress.' )
						) {
							$line = \ThemeCheck\get_line( $stripped[1], $file_path );
						}
					}
					if ( false !== $line ) {
						$this->error[] = array(
							'level' => TC_INFO,
							'file'  => $file_name,
							'line'  => $line,
							'error' => sprintf( 'Possible hard-coded links were found: %s.', $stripped[0] ),
							'test'  => __CLASS__,
						);
					}
				}
			}
		}

		return $pass;
	}
}

$themechecks['links'] = new Links_Check;

<?php

class Line_Endings_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			if ( preg_match( "/\r\n/", $file_contents ) && preg_match( "/[^\r]\n/", $file_contents ) ) {
				$file_name = basename( $file_path );
				$this->error[] = array(
					'level' => TC_WARNING,
					'file'  => $file_name,
					'line'  => false,
					'error' => "Both DOS and UNIX style line endings were found. This causes a problem with SVN repositories and must be corrected before the theme can be accepted. Please change the file to use only one style of line endings.",
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		foreach ( $css_files as $file_path => $file_contents ) {
			if ( preg_match( "/\r\n/", $file_contents ) && preg_match( "/[^\r]\n/", $file_contents ) ) {
				$file_name = basename( $file_path );
				$this->error[] = array(
					'level' => TC_WARNING,
					'file'  => $file_name,
					'line'  => false,
					'error' => "Both DOS and UNIX style line endings were found. This causes a problem with SVN repositories and must be corrected before the theme can be accepted. Please change the file to use only one style of line endings.",
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		foreach ( $other_files as $file_path => $file_contents ) {
			$e = pathinfo( $file_path );
			if ( isset( $e['extension'] ) && in_array( $e['extension'], array( 'txt','js' ) ) ) {
				if ( preg_match( "/\r\n/", $file_contents ) && preg_match( "/[^\r]\n/", $file_contents ) ) {
					$file_name = basename( $file_path );
					$this->error[] = array(
						'level' => TC_WARNING,
						'file'  => $file_name,
						'line'  => false,
						'error' => "Both DOS and UNIX style line endings were found. This causes a problem with SVN repositories and must be corrected before the theme can be accepted. Please change the file to use only one style of line endings.",
						'test'  => __CLASS__,
					);
					$pass = false;
				}
			}
		}

		return $pass;
	}
}

$themechecks['line-endings'] = new Line_Endings_Check;

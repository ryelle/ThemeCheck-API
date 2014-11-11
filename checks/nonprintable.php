<?php

class NonPrintable_Check  extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			// 09 = tab
			// 0A = line feed
			// 0D = new line
			if ( preg_match( '/[\x00-\x08\x0B-\x0C\x0E-\x1F\x80-\xFF]/', $file_contents, $matches ) ) {
				$file_name = basename( $file_path );
				$line = $this->get_line( $matches[0], $file_contents );
				$this->error[] = array(
					'level' => TC_INFO,
					'file'  => $file_name,
					'line'  => $line,
					'error' => sprintf( 'Non-printable characters <code>%1$s</code> were found in the <strong>%2$s</strong> file. You may want to check this file for errors.', htmlentities( $matches[0] ), $file_name ),
					'test'  => __CLASS__,
				);
			}
		}

		return $pass;
	}
}

$themechecks['nonprintable'] = new NonPrintable_Check;

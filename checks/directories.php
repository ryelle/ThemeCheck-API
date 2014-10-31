<?php

class Directories_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$files = array();

		foreach ( $php_files as $file_path => $file_contents ) {
			if ( strpos( $file_path, '.git' ) !== false
			  || strpos( $file_path, '.svn' ) !== false
			) {
				$files[] = $file_path;
			}
		}

		foreach ( $css_files as $file_path => $file_contents ) {
			if ( strpos( $file_path, '.git' ) !== false
			  || strpos( $file_path, '.svn' ) !== false
			  || strpos( $file_path, '.hg' ) !== false
			  || strpos( $file_path, '.bzr' ) !== false
			) {
				$files[] = $file_path;
			}
		}

		foreach ( $other_files as $file_path => $file_contents ) {
			if ( strpos( $file_path, '.git' ) !== false
			  || strpos( $file_path, '.svn' ) !== false
			  || strpos( $file_path, '.hg' ) !== false
			  || strpos( $file_path, '.bzr' ) !== false
			) {
				$files[] = $file_path;
			}
		}

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( ! empty( $files ) ) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => sprintf( 'Found <code>%s</code>. Please remove any extraneous directories from the ZIP file before uploading it.', implode( '</code>, <code>', $files ) ),
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks['directories'] = new Directories_Check;

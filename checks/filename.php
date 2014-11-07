<?php

class Filename_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$filenames = array();

		foreach ( $php_files as $file_path => $file_contents ) {
			array_push( $filenames, strtolower( basename( $file_path ) ) );
		}
		foreach ( $other_files as $file_path => $file_contents ) {
			array_push( $filenames, strtolower( basename( $file_path ) ) );
		}
		foreach ( $css_files as $file_path => $file_contents ) {
			array_push( $filenames, strtolower( basename( $file_path ) ) );
		}

		$blacklist = array(
			'thumbs.db'          => 'Windows thumbnail store',
			'desktop.ini'        => 'windows system file',
			'project.properties' => 'NetBeans project file',
			'project.xml'        => 'NetBeans project file',
			'.kpf'               => 'Komodo project file',
			'php.ini'            => 'PHP server settings file',
			'dwsync.xml'         => 'Dreamweaver project file',
			'error_log'          => 'PHP error log',
			'web.config'         => 'Server settings file',
			'.sql'               => 'SQL dump file',
			'__macosx'           => 'OSX system file',
			'__MACOSX'           => 'OSX system file',
		);

		$musthave = array( 'index.php', 'comments.php', 'style.css' );
		$recommended = array(
			'readme.txt' => 'Please see <a href="http://codex.wordpress.org/Theme_Review#Theme_Documentation">Theme_Documentation</a> for more information.',
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $blacklist as $file => $reason ) {
			if ( in_array( $file, $filenames ) ) {
				$this->error[] = array(
					'level' => TC_REQUIRED,
					'file'  => $file,
					'line'  => false,
					'error' => sprintf( 'Found %1$s: <code>%2$s</code>.', $reason, $file ),
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		if ( $found = preg_grep( '/^\.+[a-zA-Z0-9-_]/', $filenames ) ) {
			$hidden_files = implode( array_unique( $found ), ' ' );
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => $hidden_files,
				'line'  => false,
				'error' => sprintf( 'Found hidden files or folders: <code>%s</code>.', $hidden_files ),
				'test'  => __CLASS__,
			);
		}

		// @todo Child themes?
		foreach ( $musthave as $file ) {
			if ( ! in_array( $file, $filenames ) ) {
				$this->error[] = array(
					'level' => TC_WARNING,
					'file'  => false,
					'line'  => false,
					'error' => sprintf( 'Could not find the required file <code>%1$s</code> in the theme.', $file ),
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		foreach ( $recommended as $file => $reason ) {
			if ( ! in_array( $file, $filenames ) ) {
				$this->error[] = array(
					'level' => TC_RECOMMENDED,
					'file'  => false,
					'line'  => false,
					'error' => sprintf( 'Could not find the required file <code>%1$s</code> in the theme. %2$s', $file, $reason ),
					'test'  => __CLASS__,
				);
			}
		}

		return $pass;
	}
}

$themechecks['filename'] = new Filename_Check;

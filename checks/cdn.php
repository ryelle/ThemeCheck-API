<?php
/**
 * Checks for resources being loaded from CDNs.
 */

class CDN_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		ThemeCheck::increment(); // Keep track of how many checks we do.

		$cdn_list = array(
			'bootstrap-maxcdn'      => 'maxcdn.bootstrapcdn.com/bootstrap',
			'bootstrap-netdna'      => 'netdna.bootstrapcdn.com/bootstrap',
			'bootswatch-maxcdn'     => 'maxcdn.bootstrapcdn.com/bootswatch',
			'bootswatch-netdna'     => 'netdna.bootstrapcdn.com/bootswatch',
			'font-awesome-maxcdn'   => 'maxcdn.bootstrapcdn.com/font-awesome',
			'font-awesome-netdna'   => 'netdna.bootstrapcdn.com/font-awesome',
			'html5shiv-google'      => 'html5shiv.googlecode.com/svn/trunk/html5.js',
			'html5shiv-maxcdn'      => 'oss.maxcdn.com/libs/html5shiv',
			'jquery'                => 'code.jquery.com/jquery-',
			'respond-js'            => 'oss.maxcdn.com/libs/respond.js',
		);

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $cdn_list as $cdn_slug => $cdn_url ) {
				if ( false !== strpos( $file_contents, $cdn_url ) ) {
					$file_name = basename( $file_path );
					$line = \ThemeCheck\get_line( $cdn_url, $file_path );
					$this->error[] = array(
						'level' => TC_RECOMMENDED,
						'file'  => $file_name,
						'line'  => $line,
						'error' => sprintf( 'Found the URL of a CDN in the code: <code>%s</code>. You should not load any resources from a CDN, please bundle them with the theme.', $cdn_url ),
						'test'  => __CLASS__,
					);
				}
			}
		}

		return $pass;
	}
}

$themechecks['cdn'] = new CDN_Check;

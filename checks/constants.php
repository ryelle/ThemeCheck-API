<?php

class Constants_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$constants = array(
			'STYLESHEETPATH' => 'get_stylesheet_directory()',
			'TEMPLATEPATH'   => 'get_template_directory()',
			'PLUGINDIR'      => 'WP_PLUGIN_DIR',
			'MUPLUGINDIR'    => 'WPMU_PLUGIN_DIR',
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $constants as $invalid => $replacement ) {
				if ( strpos( $file_contents, $invalid ) ) {
					$file_name = basename( $file_path );
					$line = $this->get_line( $invalid, $file_path );
					$this->error[] = array(
						'level' => TC_RECOMMENDED,
						'file'  => $file_name,
						'line'  => $line,
						'error' => sprintf( '<code>%1$s</code> was found, use <code>%2$s</code> instead.', $invalid, $replacement ),
						'test'  => __CLASS__,
					);
				}
			}
		}

		return $pass;
	}
}

$themechecks['constants'] = new Constants_Check;

<?php

class Editor_Style_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( strpos( $php, 'add_editor_style' ) === false ) {
			$this->error[] = array(
				'level' => TC_RECOMMENDED,
				'file'  => false,
				'line'  => false,
				'error' => 'No reference to <strong>add_editor_style()</strong> was found in the theme. It is recommended that the theme implement editor styling, so as to make the editor content match the resulting post output in the theme, for a better user experience.',
				'test'  => __CLASS__,
			);
		}

		return $pass;
	}
}

$themechecks['editor-style'] = new Editor_Style_Check;

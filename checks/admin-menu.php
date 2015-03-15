<?php

/**
 * Check that the theme isn't creating any extra pages in WP admin
 */
class Admin_Menu_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		// //check for levels deprecated in 2.0 in creating menus.
		$tests = array(
			array(
				'level'   => TC_REQUIRED,
				'pattern' => '/([^_]add_(admin|submenu|menu|dashboard|posts|media|links|pages|comments|plugins|users|management|options)_page\()/',
				'reason'  => 'Themes should use <code>add_theme_page()</code> for adding admin pages.',
			), array(
				'level'   => TC_WARNING,
				'pattern' => '/([^_](add_(admin|submenu|menu|dashboard|posts|media|links|pages|comments|theme|plugins|users|management|options)_page)\s?\([^,]*,[^,]*,\s[\'|"]?(level_[0-9]|[0-9])[^;|\r|\r\n]*)/',
				'reason'  => 'User levels were deprecated in <strong>2.0</strong>. Please see <a href="https://codex.wordpress.org/Roles_and_Capabilities">Roles_and_Capabilities</a>',
			), array(
				'level'   => TC_WARNING,
				'pattern' => '/[^a-z0-9](current_user_can\s?\(\s?[\'\"]level_[0-9][\'\"]\s?\))[^\r|\r\n]*/',
				'reason'  => 'User levels were deprecated in <strong>2.0</strong>. Please see <a href="https://codex.wordpress.org/Roles_and_Capabilities">Roles_and_Capabilities</a>',
			),
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $tests as $test ) {
				if ( preg_match( $test['pattern'], $file_contents, $matches ) ) {
					$file_name = basename( $file_path );
					$line = $this->get_line( $matches[1], $file_contents );

					$this->error[] = array(
						'level' => $test['level'],
						'file'  => $file_name,
						'line'  => $line,
						'error' => $test['reason'],
						'test'  => __CLASS__,
					);
					$pass = false;
				}
			}
		}

		return $pass;
	}
}

$themechecks['admin-menu'] = new Admin_Menu_Check;

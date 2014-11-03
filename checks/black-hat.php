<?php

/**
 * Check for any functions that could be used to run arbitrary code or mess with server settings.
 */
class Black_Hat_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$tests = array(
			array(
				'level' => TC_WARNING,
				'pattern' => '/(?<![_|a-z0-9|\.])eval\s?\(/i',
				'reason' => '<code>eval()</code> is not allowed.',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/[^a-z0-9](?<!_)(popen|proc_open|[^_]exec|shell_exec|system|passthru)\(/',
				'reason' => 'PHP system calls are often disabled by server admins and should not be in themes',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/\s?ini_set\(/',
				'reason' => 'Themes should not change server PHP settings',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/base64_decode/',
				'reason' => '<code>base64_decode()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/base64_encode/',
				'reason' => '<code>base64_encode()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/uudecode/ims',
				'reason' => '<code>uudecode()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/str_rot13/ims',
				'reason' => '<code>str_rot13()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/cx=[0-9]{21}:[a-z0-9]{10}/',
				'reason' => 'Google search code detected',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/pub-[0-9]{16}/i',
				'reason' => 'Google advertising code detected',
			),
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $tests as $test ) {
				if ( preg_match( $test['pattern'], $file_contents, $matches ) ) {
					$file_name = basename( $file_path );
					$line = \ThemeCheck\get_line( $matches[0], $file_path );
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

$themechecks['black-hat'] = new Black_Hat_Check;

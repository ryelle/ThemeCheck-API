<?php
/**
 * Checks for Plugin Territory Guidelines.
 *
 * See http://make.wordpress.org/themes/guidelines/guidelines-plugin-territory/
 */

class Plugin_Territory_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );

		$tests = array(
			array(
				'level'   => TC_REQUIRED,
				'pattern' => 'register_post_type',
				'reason'  => 'The theme uses the <code>%s</code> function, which is plugin-territory functionality.',
			), array(
				'level'   => TC_REQUIRED,
				'pattern' => 'register_taxonomy',
				'reason'  => 'The theme uses the <code>%s</code> function, which is plugin-territory functionality.',
			), array(
				'level'   => TC_WARNING,
				'pattern' => 'add_shortcode',
				'reason'  => 'The theme uses the <code>%s</code> function. Custom post-content shortcodes are plugin-territory functionality.',
			),
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $tests as $test ) {
			if ( false !== strpos( $php, $test['pattern'] ) ) {
				$this->error[] = array(
					'level' => $test['level'],
					'file'  => false,
					'line'  => false,
					'error' => sprintf( $test['reason'], $function ),
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		return $pass;
	}
}

$themechecks['plugin-territory'] = new Plugin_Territory_Check;

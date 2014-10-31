<?php

class Widgets_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php  = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		// no widgets registered or used...
		if ( strpos( $php, 'register_sidebar' ) === false
		  && strpos( $php, 'dynamic_sidebar' ) === false
		) {
			$this->error[] = array(
				'level' => TC_RECOMMENDED,
				'file'  => false,
				'line'  => false,
				'error' => "This theme contains no sidebars/widget areas. See <a href='http://codex.wordpress.org/Widgets_API'>Widgets API</a>",
				'test'  => __CLASS__,
			);
			$pass = true;
		}

		if ( strpos( $php, 'register_sidebar' ) !== false
		  && strpos( $php, 'dynamic_sidebar' ) === false
		) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => 'The theme appears to use <strong>register_sidebar()</strong> but no <strong>dynamic_sidebar()</strong> was found. See: <a href="http://codex.wordpress.org/Function_Reference/dynamic_sidebar">dynamic_sidebar</a>',
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		if ( strpos( $php, 'register_sidebar' ) === false
		  && strpos( $php, 'dynamic_sidebar' ) !== false
		) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => 'The theme appears to use <strong>dynamic_sidebars()</strong> but no <strong>register_sidebar()</strong> was found. See: <a href="http://codex.wordpress.org/Function_Reference/register_sidebar">register_sidebar</a>',
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		// There are widgets registered, is the widgets_init action present?
		if ( strpos( $php, 'register_sidebar' ) !== false
		  && preg_match( '/add_action\(\s*("|\')widgets_init("|\')\s*,/', $php ) === false
		) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => 'Sidebars need to be registered in a custom function hooked to the <strong>widgets_init</strong> action. See: <a href="http://codex.wordpress.org/Function_Reference/register_sidebar">register_sidebar()</a>',
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks['widgets'] = new Widgets_Check;

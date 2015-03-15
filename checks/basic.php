<?php

/**
 * Simple string-checks for basic requirements.
 */
class Basic_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$tests = array(
			array(
				'level' => TC_REQUIRED,
				'pattern' => 'DOCTYPE',
				'reason' => 'Could not find <code>DOCTYPE</code>. See: <a href="https://codex.wordpress.org/HTML_to_XHTML">https://codex.wordpress.org/HTML_to_XHTML</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'wp_footer\(',
				'reason' => 'Could not find <code>wp_footer</code>. See: <a href="https://codex.wordpress.org/Function_Reference/wp_footer">wp_footer</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'wp_head\(',
				'reason' => 'Could not find <code>wp_head</code>. See: <a href="https://codex.wordpress.org/Function_Reference/wp_head">wp_head</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'language_attributes',
				'reason' => 'Could not find <code>language_attributes</code>. See: <a href="https://codex.wordpress.org/Function_Reference/language_attributes">language_attributes</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'charset',
				'reason' => 'Could not find <code>charset</code>. There must be a charset defined in the Content-Type or the meta charset tag in the head.',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'add_theme_support\(\s?("|\')automatic-feed-links("|\')\s?\)',
				'reason' => 'Could not find <code>add_theme_support("automatic-feed-links")</code>. See: <a href="https://codex.wordpress.org/Function_Reference/add_theme_support">add_theme_support</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'comments_template\(',
				'reason' => 'Could not find <code>comments_template</code>. See: <a href="https://codex.wordpress.org/Template_Tags/comments_template">comments_template</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'wp_list_comments\(',
				'reason' => 'Could not find <code>wp_list_comments</code>. See: <a href="https://codex.wordpress.org/Template_Tags/wp_list_comments">wp_list_comments</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'comment_form\(',
				'reason' => 'Could not find <code>comment_form</code>. See: <a href="https://codex.wordpress.org/Template_Tags/comment_form">comment_form</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'body_class',
				'reason' => 'Could not find <code>body_class</code>. See: <a href="https://codex.wordpress.org/Template_Tags/body_class">body_class</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'wp_link_pages\(',
				'reason' => 'Could not find <code>wp_link_pages</code>. See: <a href="https://codex.wordpress.org/Function_Reference/wp_link_pages">wp_link_pages</a>',
			), array(
				'level' => TC_REQUIRED,
				'pattern' => 'post_class\(',
				'reason' => 'Could not find <code>post_class</code>. See: <a href="https://codex.wordpress.org/Template_Tags/post_class">post_class</a>',
			),
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		$php = implode( ' ', $php_files );

		foreach ( $tests as $test ) {
			if ( ! preg_match( '/' . $test['pattern'] . '/i', $php ) ) {
				$this->error[] = array(
					'level' => $test['level'],
					'file'  => false,
					'line'  => false,
					'error' => $test['reason'],
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		return $pass;
	}
}

$themechecks['basic'] = new Basic_Check;

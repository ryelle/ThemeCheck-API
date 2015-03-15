<?php

class Comment_Reply_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( ! preg_match( '/wp_enqueue_script\(\s?("|\')comment-reply("|\')/i', $php ) ) {
			if ( ! preg_match( '/comment-reply/', $php ) ) {
				$this->error[] = array(
					'level' => TC_REQUIRED,
					'file'  => false,
					'line'  => false,
					'error' => 'Could not find the <strong>comment-reply</strong> script enqueued. See: <a href="https://codex.wordpress.org/Migrating_Plugins_and_Themes_to_2.7/Enhanced_Comment_Display">Migrating Plugins and Themes to 2.7/Enhanced Comment Display</a>.',
					'test'  => __CLASS__,
				);
				$pass = false;
			} else {
				$this->error[] = array(
					'level' => TC_INFO,
					'file'  => false,
					'line'  => false,
					'error' => 'Could not find the <strong>comment-reply</strong> script enqueued, however a reference to \'comment-reply\' was found. Make sure that the comment-reply script is being enqueued properly on singular pages.',
					'test'  => __CLASS__,
				);
			}
		}

		return $pass;
	}
}

$themechecks['comment-reply'] = new Comment_Reply_Check;

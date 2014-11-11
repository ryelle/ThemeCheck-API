<?php

class Post_Thumbnail_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( strpos( $php, 'post-thumbnails' ) === false ) {
			$this->error[] = array(
				'level' => TC_INFO,
				'file'  => false,
				'line'  => false,
				'error' => "No reference to post-thumbnails was found in the theme. If the theme has a thumbnail like functionality, it should be implemented with <code>add_theme_support( 'post-thumbnails' )</code>in the functions.php file.",
				'test'  => __CLASS__,
			);
		} elseif ( ( strpos( $php, 'the_post_thumbnail' ) === false ) && ( strpos( $php, 'get_post_thumbnail' ) === false ) ) {
			$this->error[] = array(
				'level' => TC_RECOMMENDED,
				'file'  => false,
				'line'  => false,
				'error' => 'No reference to <code>the_post_thumbnail()</code> was found in the theme. It is recommended that the theme implement this functionality instead of using custom fields for thumbnails.',
				'test'  => __CLASS__,
			);
		}

		return $pass;
	}
}

$themechecks['post-thumbnail'] = new Post_Thumbnail_Check;

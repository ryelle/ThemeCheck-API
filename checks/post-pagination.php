<?php

class Post_Pagination_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php  = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( strpos( $php, 'posts_nav_link' ) === false
		  && strpos( $php, 'paginate_links' ) === false
		  && strpos( $php, 'the_posts_pagination' ) === false
		  && strpos( $php, 'the_posts_navigation' ) === false
		  && ( strpos( $php, 'previous_posts_link' ) === false
		    && strpos( $php, 'next_posts_link' ) === false
		  )
		) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => "The theme doesn't have post pagination code in it. Use <code>posts_nav_link()</code> or <code>paginate_links()</code> or <strong>the_posts_pagination()</strong> or <strong>the_posts_navigation()</strong> or <code>next_posts_link()</code> and <code>previous_posts_link()</code> to add post pagination.",
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks['post-pagination'] = new Post_Pagination_Check;

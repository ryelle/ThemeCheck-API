<?php

class Comment_Pagination_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( strpos( $php, 'paginate_comments_links' ) === false
		  && ( strpos( $php, 'next_comments_link' ) === false
		    && strpos( $php, 'previous_comments_link' ) === false
		  )
		) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => "The theme doesn't have comment pagination code in it. Use <strong>paginate_comments_links()</strong> or <strong>next_comments_link()</strong> and <strong>previous_comments_link()</strong> to add comment pagination.",
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks['comment-pagination'] = new Comment_Pagination_Check;

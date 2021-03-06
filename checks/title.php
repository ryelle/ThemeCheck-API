<?php
/**
 * Checks for the title:
 * Are there <title> and </title> tags?
 * Is there a call to wp_title()?
 * There can't be any hardcoded text in the <title> tag.
 *
 * See: http://make.wordpress.org/themes/guidelines/guidelines-theme-check/
 */
class Title_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$php = implode( ' ', $php_files );
		$needs_title_tag = false;

		ThemeCheck::increment(); // Keep track of how many checks we do.

		// Look for add_theme_support( 'title-tag' ) first
		if ( ! preg_match( '#add_theme_support\s?\(\s?[\'|"]title-tag#', $php ) ) {
			$this->error[] = array(
				'level' => TC_RECOMMENDED,
				'file'  => false,
				'line'  => false,
				'error' => 'No reference to <code>add_theme_support( "title-tag" )</code> was found in the theme. It is recommended that the theme implement this functionality for WordPress 4.1 and above.',
				'test'  => __CLASS__,
			);
			$needs_title_tag = true;
		}

		/**
		 * Look for <title> and </title> tags.
		 */
		if ( ( false === strpos( $php, '<title>' ) || false === strpos( $php, '</title>' ) ) && $needs_title_tag ) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => 'The theme needs to have <code>&lt;title&gt;</code> tags, ideally in the <code>header.php</code> file.',
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		/**
		 * Check whether there is a call to wp_title().
		 */
		if ( ( false === strpos( $php, 'wp_title(' ) ) && $needs_title_tag ) {
			$this->error[] = array(
				'level' => TC_REQUIRED,
				'file'  => false,
				'line'  => false,
				'error' => 'The theme needs to have a call to <code>wp_title()</code>, ideally in the <code>header.php</code> file.',
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		/**
		 * Check whether the the <title> tag contains something besides a call to wp_title().
		 */
		foreach ( $php_files as $file_path => $file_content ) {
			/**
			 * First looks ahead to see of there's <title>...</title>
			 * Then performs a negative look ahead for <title><?php wp_title(...); ?></title>
			 */
			if ( preg_match( '/(?=<title>(.*)<\/title>)(?!<title>\s*<\?php\s*wp_title\([^\)]*\);\s*\?>\s*<\/title>)/s', $file_content ) ) {
				$this->error[] = array(
					'level' => TC_REQUIRED,
					'file'  => false,
					'line'  => false,
					'error' => 'The <code>&lt;title&gt;</code> tags can only contain a call to <code>wp_title()</code>. Use the <code>wp_title filter</code> to modify the output',
					'test'  => __CLASS__,
				);
				$pass = false;
			}
		}

		return $pass;
	}
}

$themechecks['title'] = new Title_Check;

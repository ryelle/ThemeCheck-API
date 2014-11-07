<?php

class Style_Tags_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$header = ( new \ThemeCheck\API )->parse_style_header( $this->theme, $this->base_path );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		if ( ! isset( $header[ 'Tags' ] ) || ! $header[ 'Tags' ] ) {
			$this->error[] = array(
				'level' => TC_RECOMMENDED,
				'file'  => 'style.css',
				'line'  => false,
				'error' => '<strong>Tags:</strong> is either empty or missing in style.css header.',
				'test'  => __CLASS__,
			);
			return $pass;
		}

		$allowed_tags = array( 'black', 'blue', 'brown', 'gray', 'green', 'orange', 'pink', 'purple', 'red', 'silver', 'tan', 'white', 'yellow', 'dark', 'light', 'one-column', 'two-columns', 'three-columns', 'four-columns', 'left-sidebar', 'right-sidebar', 'fixed-layout', 'fluid-layout', 'responsive-layout', 'flexible-header', 'accessibility-ready', 'blavatar', 'buddypress', 'custom-background', 'custom-colors', 'custom-header', 'custom-menu', 'editor-style', 'featured-image-header', 'featured-images', 'front-page-post-form', 'full-width-template', 'microformats', 'post-formats', 'rtl-language-support', 'sticky-post', 'theme-options', 'threaded-comments', 'translation-ready', 'holiday', 'photoblogging', 'seasonal' );

		$tags = explode( ',', $header['Tags'] );
		foreach ( $tags as $tag ) {
			$tag = strtolower( trim( $tag ) );
			if ( ! in_array( $tag, $allowed_tags ) ) {
				if ( in_array( $tag, array( 'flexible-width', 'fixed-width' ) ) ) {
					$this->error[] = array(
						'level' => TC_WARNING,
						'file'  => 'style.css',
						'line'  => false,
						'error' => 'The flexible-width and fixed-width tags changed to fluid-layout and fixed-layout tags in WordPress 3.8. Additionally, the responsive-layout tag was added. Please change to using one of the new tags.',
						'test'  => __CLASS__,
					);
				} else {
					$this->error[] = array(
						'level' => TC_WARNING,
						'file'  => 'style.css',
						'line'  => false,
						'error' => sprintf( 'Found invalid tag <code>%s</code>.', $tag ),
						'test'  => __CLASS__,
					);
					$pass = false;
				}
			}
		}

		return $pass;
	}
}

$themechecks['style-tags'] = new Style_Tags_Check;

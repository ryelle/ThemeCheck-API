<?php

class Screenshot_Checks extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;
		$file_names = array_keys( $other_files );
		$file_names = array_map( 'strtolower', $file_names );

		ThemeCheck::increment(); // Keep track of how many checks we do.

		$screenshot = false;
		foreach ( array( 'png', 'gif', 'jpg', 'jpeg' ) as $ext ) {
			if ( in_array( $this->base_path . "screenshot.$ext", $file_names ) ) {
				$screenshot = $this->base_path . "screenshot.$ext";
			}
		}

		if ( $screenshot ) {
			$image = getimagesize( 'zip://'. $this->theme->filename .'#'.$screenshot );
			if ( $image[0] > 880 || $image[1] > 660 ) {
				$this->error[] = array(
					'level' => TC_RECOMMENDED,
					'file'  => false,
					'line'  => false,
					'error' => sprintf( 'Screenshot is wrong size! Detected: <strong>%1$sx%2$spx</strong>. Maximum allowed size is 880x660px.', $image[0], $image[1] ),
					'test'  => __CLASS__,
				);
			}
			if ( $image[1] / $image[0] != 0.75 ) {
				$this->error[] = array(
					'level' => TC_RECOMMENDED,
					'file'  => false,
					'line'  => false,
					'error' => 'Screenshot dimensions are wrong! Ratio of width to height should be 4:3.',
					'test'  => __CLASS__,
				);
			}
			if ( $image[0] != 880 || $image[1] != 660 ) {
				$this->error[] = array(
					'level' => TC_RECOMMENDED,
					'file'  => false,
					'line'  => false,
					'error' => 'Screenshot size should be 880x660, to account for HiDPI displays. Any 4:3 image size is acceptable, but 880x660 is preferred.',
					'test'  => __CLASS__,
				);
			}
		} else {
			$this->error[] = array(
				'level' => TC_WARNING,
				'file'  => false,
				'line'  => false,
				'error' => 'No screenshot detected! Please include a screenshot.png or screenshot.jpg.',
				'test'  => __CLASS__,
			);
			$pass = false;
		}

		return $pass;
	}
}

$themechecks['screenshot'] = new Screenshot_Checks;

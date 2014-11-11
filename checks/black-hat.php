<?php

/**
 * Check for any functions that could be used to run arbitrary code or mess with server settings.
 */
class Black_Hat_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$tests = array(
			array(
				'level' => TC_WARNING,
				'pattern' => '/(?<![_|a-z0-9|\.])eval\s?\(/i',
				'reason' => '<code>eval()</code> is not allowed.',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/[^a-z0-9](?<!_)(popen|proc_open|[^_]exec|shell_exec|system|passthru)\(/',
				'reason' => 'PHP system calls are often disabled by server admins and should not be in themes',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/\s?ini_set\(/',
				'reason' => 'Themes should not change server PHP settings',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/base64_decode/',
				'reason' => '<code>base64_decode()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/base64_encode/',
				'reason' => '<code>base64_encode()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/uudecode/ims',
				'reason' => '<code>uudecode()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/str_rot13/ims',
				'reason' => '<code>str_rot13()</code> is not allowed',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/cx=[0-9]{21}:[a-z0-9]{10}/',
				'reason' => 'Google search code detected',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/pub-[0-9]{16}/i',
				'reason' => 'Google advertising code detected',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/[^a-z0-9](?<!_)(file_get_contents|curl_exec|curl_init|readfile|fopen|fsockopen|pfsockopen|fclose|fread|fwrite|file_put_contents)\s?\(/',
				'reason' => 'File operations should use the WP_Filesystem methods instead of direct PHP filesystem calls',
			), array(
				'level' => TC_INFO,
				'pattern' => '/<(iframe)[^>]*>/',
				'reason' => 'iframes are sometimes used to load unwanted adverts and code on your site',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/wshell\.php/',
				'reason' => 'This may be a script used by hackers to get control of your server.',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/ShellBOT/',
				'reason' => 'This may be a script used by hackers to get control of your server.',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/uname -a/',
				'reason' => 'Tells a hacker what operating system your server is running',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/YW55cmVzdWx0cy5uZXQ=/',
				'reason' => 'base64 encoded text found in Search Engine Redirect hack <a href="http://blogbuildingu.com/wordpress/wordpress-search-engine-redirect-hack">[1]</a>',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/\$_COOKIE\[\'yahg\'\]/',
				'reason' => 'YAHG Googlerank.info exploit code <a href="http://creativebriefing.com/wordpress-hacked-googlerankinfo/">[1]</a>',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/ekibastos/',
				'reason' => 'Possible Ekibastos attack <a href="http://ocaoimh.ie/did-your-wordpress-site-get-hacked/">[1]</a>',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/<script>\/\*(GNU GPL|LGPL)\*\/ try\{window.onload.+catch\(e\) \{\}<\/script>/',
				'reason' => "Possible 'Gumblar' JavaScript attack <a href='http://threatinfo.trendmicro.com/vinfo/articles/securityarticles.asp?xmlfile=042710-GUMBLAR.xml'>[1]</a> <a href='http://justcoded.com/article/gumblar-family-virus-removal-tool/'>[2]</a>",
			), array(
				'level' => TC_WARNING,
				'pattern' => '/php \$[a-zA-Z]*=\'as\';/',
				'reason' => 'Symptom of the "Pharma Hack" <a href="http://blog.sucuri.net/2010/07/understanding-and-cleaning-the-pharma-hack-on-wordpress.html">[1]</a>',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/defined?\(\'wp_class_support/',
				'reason' => 'Symptom of the "Pharma Hack" <a href="http://blog.sucuri.net/2010/07/understanding-and-cleaning-the-pharma-hack-on-wordpress.html">[1]</a>',
			), array(
				'level' => TC_WARNING,
				'pattern' => '/AGiT3NiT3NiT3fUQKxJvI/',
				'reason' => 'Malicious footer code injection detected!',
			),
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $tests as $test ) {
				if ( preg_match( $test['pattern'], $file_contents, $matches ) ) {
					$file_name = basename( $file_path );
					$line = $this->get_line( $matches[0], $file_contents );
					$this->error[] = array(
						'level' => $test['level'],
						'file'  => $file_name,
						'line'  => $line,
						'error' => $test['reason'],
						'test'  => __CLASS__,
					);
					$pass = false;
				}
			}
		}

		return $pass;
	}
}

$themechecks['black-hat'] = new Black_Hat_Check;

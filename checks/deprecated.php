<?php

class Deprecated_Check extends ThemeCheck {

	function check( $php_files, $css_files, $other_files ) {
		$pass = true;

		$functions = array(
			// start wp-includes deprecated
			array(
				'deprecated' => 'get_postdata',
				'replacement' => 'get_post()',
				'version' => '1.5.1',
			),
			array(
				'deprecated' => 'start_wp',
				'replacement' => 'the Loop',
				'version' => '1.5',
			),
			array(
				'deprecated' => 'the_category_id',
				'replacement' => 'get_the_category()',
				'version' => '0.71',
			),
			array(
				'deprecated' => 'the_category_head',
				'replacement' => 'get_the_category_by_ID()',
				'version' => '0.71',
			),
			array(
				'deprecated' => 'previous_post',
				'replacement' => 'previous_post_link()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'next_post',
				'replacement' => 'next_post_link()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_create_post',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_create_draft',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_edit_post',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_delete_post',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_set_post_date',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_edit_post_comments',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_delete_post_comments',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'user_can_edit_user',
				'replacement' => 'current_user_can()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'get_linksbyname',
				'replacement' => 'get_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'wp_get_linksbyname',
				'replacement' => 'wp_list_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_linkobjectsbyname',
				'replacement' => 'get_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_linkobjects',
				'replacement' => 'get_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_linksbyname_withrating',
				'replacement' => 'get_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_links_withrating',
				'replacement' => 'get_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_autotoggle',
				'replacement' => '',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'list_cats',
				'replacement' => 'wp_list_categories',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'wp_list_cats',
				'replacement' => 'wp_list_categories',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'dropdown_cats',
				'replacement' => 'wp_dropdown_categories()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'list_authors',
				'replacement' => 'wp_list_authors()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'wp_get_post_cats',
				'replacement' => 'wp_get_post_categories()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'wp_set_post_cats',
				'replacement' => 'wp_set_post_categories()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_archives',
				'replacement' => 'wp_get_archives',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_author_link',
				'replacement' => 'get_author_posts_url()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'link_pages',
				'replacement' => 'wp_link_pages()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_settings',
				'replacement' => 'get_option()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'permalink_link',
				'replacement' => 'the_permalink()',
				'version' => '1.2',
			),
			array(
				'deprecated' => 'permalink_single_rss',
				'replacement' => 'permalink_rss()',
				'version' => '2.3',
			),
			array(
				'deprecated' => 'wp_get_links',
				'replacement' => 'wp_list_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_links',
				'replacement' => 'get_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_links_list',
				'replacement' => 'wp_list_bookmarks()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'links_popup_script',
				'replacement' => '',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_linkrating',
				'replacement' => 'sanitize_bookmark_field()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'get_linkcatname',
				'replacement' => 'get_category()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'comments_rss_link',
				'replacement' => 'post_comments_feed_link()',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'get_category_rss_link',
				'replacement' => 'get_category_feed_link()',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'get_author_rss_link',
				'replacement' => 'get_author_feed_link()',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'comments_rss',
				'replacement' => 'get_post_comments_feed_link()',
				'version' => '2.2',
			),
			array(
				'deprecated' => 'create_user',
				'replacement' => 'wp_create_user()',
				'version' => '2.0',
			),
			array(
				'deprecated' => 'gzip_compression',
				'replacement' => '',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'get_commentdata',
				'replacement' => 'get_comment()',
				'version' => '2.7',
			),
			array(
				'deprecated' => 'get_catname',
				'replacement' => 'get_cat_name()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_category_children',
				'replacement' => 'get_term_children',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_description',
				'replacement' => 'get_the_author_meta(\'description\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_description',
				'replacement' => 'the_author_meta(\'description\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_login',
				'replacement' => 'the_author_meta(\'login\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_firstname',
				'replacement' => 'get_the_author_meta(\'first_name\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_firstname',
				'replacement' => 'the_author_meta(\'first_name\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_lastname',
				'replacement' => 'get_the_author_meta(\'last_name\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_lastname',
				'replacement' => 'the_author_meta(\'last_name\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_nickname',
				'replacement' => 'get_the_author_meta(\'nickname\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_nickname',
				'replacement' => 'the_author_meta(\'nickname\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_email',
				'replacement' => 'get_the_author_meta(\'email\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_email',
				'replacement' => 'the_author_meta(\'email\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_icq',
				'replacement' => 'get_the_author_meta(\'icq\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_icq',
				'replacement' => 'the_author_meta(\'icq\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_yim',
				'replacement' => 'get_the_author_meta(\'yim\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_yim',
				'replacement' => 'the_author_meta(\'yim\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_msn',
				'replacement' => 'get_the_author_meta(\'msn\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_msn',
				'replacement' => 'the_author_meta(\'msn\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_aim',
				'replacement' => 'get_the_author_meta(\'aim\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_aim',
				'replacement' => 'the_author_meta(\'aim\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_author_name',
				'replacement' => 'get_the_author_meta(\'display_name\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_url',
				'replacement' => 'get_the_author_meta(\'url\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_url',
				'replacement' => 'the_author_meta(\'url\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_the_author_ID',
				'replacement' => 'get_the_author_meta(\'ID\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_author_ID',
				'replacement' => 'the_author_meta(\'ID\')',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'the_content_rss',
				'replacement' => 'the_content_feed()',
				'version' => '2.9',
			),
			array(
				'deprecated' => 'make_url_footnote',
				'replacement' => '',
				'version' => '2.9',
			),
			array(
				'deprecated' => '_c',
				'replacement' => '_x()',
				'version' => '2.9',
			),
			array(
				'deprecated' => 'translate_with_context',
				'replacement' => '_x()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'nc',
				'replacement' => 'nx()',
				'version' => '3.0',
			),
			array(
				'deprecated' => '__ngettext',
				'replacement' => '_n_noop()',
				'version' => '2.8',
			),
			array(
				'deprecated' => '__ngettext_noop',
				'replacement' => '_n_noop()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'get_alloptions',
				'replacement' => 'wp_load_alloptions()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'get_the_attachment_link',
				'replacement' => 'wp_get_attachment_link()',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'get_attachment_icon_src',
				'replacement' => 'wp_get_attachment_image_src()',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'get_attachment_icon',
				'replacement' => 'wp_get_attachment_image()',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'get_attachment_innerhtml',
				'replacement' => 'wp_get_attachment_image()',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'get_link',
				'replacement' => 'get_bookmark()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'sanitize_url',
				'replacement' => 'esc_url()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'clean_url',
				'replacement' => 'esc_url()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'js_escape',
				'replacement' => 'esc_js()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'wp_specialchars',
				'replacement' => 'esc_html()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'attribute_escape',
				'replacement' => 'esc_attr()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'register_sidebar_widget',
				'replacement' => 'wp_register_sidebar_widget()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'unregister_sidebar_widget',
				'replacement' => 'wp_unregister_sidebar_widget()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'register_widget_control',
				'replacement' => 'wp_register_widget_control()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'unregister_widget_control',
				'replacement' => 'wp_unregister_widget_control()',
				'version' => '2.8',
			),
			array(
				'deprecated' => 'delete_usermeta',
				'replacement' => 'delete_user_meta()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'get_usermeta',
				'replacement' => 'get_user_meta()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'update_usermeta',
				'replacement' => 'update_user_meta()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'automatic_feed_links',
				'replacement' => 'add_theme_support( \'automatic-feed-links\' )',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'get_profile',
				'replacement' => 'get_the_author_meta()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'get_usernumposts',
				'replacement' => 'count_user_posts()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'funky_javascript_callback',
				'replacement' => '',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'funky_javascript_fix',
				'replacement' => '',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'is_taxonomy',
				'replacement' => 'taxonomy_exists()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'is_term',
				'replacement' => 'term_exists()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'is_plugin_page',
				'replacement' => '$plugin_page and/or get_plugin_page_hookname() hooks',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'update_category_cache',
				'replacement' => 'No alternatives',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'get_users_of_blog',
				'replacement' => 'get_users()',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'wp_timezone_supported',
				'replacement' => '',
				'version' => '3.2',
			),
			array(
				'deprecated' => 'the_editor',
				'replacement' => 'wp_editor',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'get_user_metavalues',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'sanitize_user_object',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'get_boundary_post_rel_link',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'start_post_rel_link',
				'replacement' => 'none available ',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'get_index_rel_link',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'index_rel_link',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'get_parent_post_rel_link',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'parent_post_rel_link',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'wp_admin_bar_dashboard_view_site_menu',
				'replacement' => '',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'is_blog_user',
				'replacement' => 'is_member_of_blog()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'debug_fopen',
				'replacement' => 'error_log()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'debug_fwrite',
				'replacement' => 'error_log()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'debug_fclose',
				'replacement' => 'error_log()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'get_themes',
				'replacement' => 'wp_get_themes()',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'get_theme',
				'replacement' => 'wp_get_theme()',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'get_current_theme',
				'replacement' => 'wp_get_theme()',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'clean_pre',
				'replacement' => '',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'add_custom_image_header',
				'replacement' => 'add_theme_support( \'custom-header\', $args )',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'remove_custom_image_header',
				'replacement' => 'remove_theme_support( \'custom-header\' )',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'add_custom_background',
				'replacement' => 'add_theme_support( \'custom-background\', $args )',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'remove_custom_background',
				'replacement' => 'remove_theme_support( \'custom-background\' )',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'get_theme_data',
				'replacement' => 'wp_get_theme()',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'update_page_cache',
				'replacement' => 'update_post_cache()',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'clean_page_cache',
				'replacement' => 'clean_post_cache()',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'wp_explain_nonce',
				'replacement' => 'wp_nonce_ays',
				'version' => '3.4.1',
			),
			array(
				'deprecated' => 'sticky_class',
				'replacement' => 'post_class()',
				'version' => '3.5',
			),
			array(
				'deprecated' => '_get_post_ancestors',
				'replacement' => '',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'wp_load_image',
				'replacement' => 'wp_get_image_editor()',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'image_resize',
				'replacement' => 'wp_get_image_editor()',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'wp_get_single_post',
				'replacement' => 'get_post()',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'user_pass_ok',
				'replacement' => 'wp_authenticate()',
				'version' => '3.5',
			),
			array(
				'deprecated' => '_save_post_hook',
				'replacement' => '',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'gd_edit_image_support',
				'replacement' => 'wp_image_editor_supports',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'get_user_id_from_string',
				'replacement' => 'get_user_by()',
				'version' => '3.6',
			),
			array(
				'deprecated' => 'wp_convert_bytes_to_hr',
				'replacement' => 'size_format()',
				'version' => '3.6',
			),
			array(
				'deprecated' =>'_search_terms_tidy',
				'replacement'  => '',
				'version' => '3.7',
			),
			array(
				'deprecated' => 'get_blogaddress_by_domain',
				'replacement' => '',
				'version' => '3.7',
			),
			// end wp-includes deprecated

			// start wp-admin deprecated
			array(
				'deprecated' => 'tinymce_include',
				'replacement' => 'wp_tiny_mce()',
				'version' => '2.1',
			),
			array(
				'deprecated' => 'documentation_link',
				'replacement' => '',
				'version' => '2.5',
			),
			array(
				'deprecated' => 'wp_shrink_dimensions',
				'replacement' => 'wp_constrain_dimensions()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'dropdown_categories',
				'replacement' => 'wp_category_checklist()',
				'version' => '2.6',
			),
			array(
				'deprecated' => 'dropdown_link_categories',
				'replacement' => 'wp_link_category_checklist()',
				'version' => '2.6',
			),
			array(
				'deprecated' => 'wp_dropdown_cats',
				'replacement' => 'wp_dropdown_categories()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'add_option_update_handler',
				'replacement' => 'register_setting()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'remove_option_update_handler',
				'replacement' => 'unregister_setting()',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'codepress_get_lang',
				'replacement' => '',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'codepress_footer_js',
				'replacement' => '',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'use_codepress',
				'replacement' => '',
				'version' => '3.0',
			),
			array(
				'deprecated' => 'get_author_user_ids',
				'replacement' => '',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'get_editable_authors',
				'replacement' => '',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'get_editable_user_ids',
				'replacement' => '',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'get_nonauthor_user_ids',
				'replacement' => '',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'WP_User_Search',
				'replacement' => 'WP_User_Query',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'get_others_unpublished_posts',
				'replacement' => '',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'get_others_drafts',
				'replacement' => '',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'get_others_pending',
				'replacement' => '',
				'version' => '3.1',
			),
			array(
				'deprecated' => 'wp_dashboard_quick_press',
				'replacement' => '',
				'version' => '3.2',
			),
			array(
				'deprecated' => 'wp_tiny_mce',
				'replacement' => 'wp_editor',
				'version' => '3.2',
			),
			array(
				'deprecated' => 'wp_preload_dialogs',
				'replacement' => 'wp_editor()',
				'version' => '3.2',
			),
			array(
				'deprecated' => 'wp_print_editor_js',
				'replacement' => 'wp_editor()',
				'version' => '3.2',
			),
			array(
				'deprecated' => 'wp_quicktags',
				'replacement' => 'wp_editor()',
				'version' => '3.2',
			),
			array(
				'deprecated' => 'favorite_actions',
				'replacement' => 'WP_Admin_Bar',
				'version' => '3.2',
			),
			array(
				'deprecated' => 'screen_layout',
				'replacement' => '$current_screen->render_screen_layout()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'screen_options',
				'replacement' => '$current_screen->render_per_page_options()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'screen_meta',
				'replacement' => ' $current_screen->render_screen_meta()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'media_upload_image',
				'replacement' => 'wp_media_upload_handler()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'media_upload_audio',
				'replacement' => 'wp_media_upload_handler()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'media_upload_video',
				'replacement' => 'wp_media_upload_handler()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'media_upload_file',
				'replacement' => 'wp_media_upload_handler()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'type_url_form_image',
				'replacement' => 'wp_media_insert_url_form( \'image\' )',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'type_url_form_audio',
				'replacement' => 'wp_media_insert_url_form( \'audio\' )',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'type_url_form_video',
				'replacement' => 'wp_media_insert_url_form( \'video\' )',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'type_url_form_file',
				'replacement' => 'wp_media_insert_url_form( \'file\' )',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'add_contextual_help',
				'replacement' => 'get_current_screen()->add_help_tab()',
				'version' => '3.3',
			),
			array(
				'deprecated' => 'get_allowed_themes',
				'replacement' => 'wp_get_themes( array( \'allowed\' => true ) )',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'get_broken_themes',
				'replacement' => 'wp_get_themes( array( \'errors\' => true )',
				'version' => '3.4',
			),
			array(
				'deprecated' => 'current_theme_info',
				'replacement' => 'wp_get_theme()',
				'version' => '3.4',
			),
			array(
				'deprecated' => '_insert_into_post_button',
				'replacement' => '',
				'version' => '3.5',
			),
			array(
				'deprecated' => '_media_button',
				'replacement' => '',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'get_post_to_edit',
				'replacement' => 'get_post()',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'get_default_page_to_edit',
				'replacement' => 'get_default_post_to_edit()',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'wp_create_thumbnail',
				'replacement' => 'image_resize()',
				'version' => '3.5',
			),
			array(
				'deprecated' => 'wp_nav_menu_locations_meta_box',
				'replacement' => '',
				'version' => '3.6',
			),
			array(
				'deprecated' => 'the_attachment_links',
				'replacement' => '',
				'version' =>  '3.7',
			),
			array(
				'deprecated' => 'wp_update_core',
				'replacement' => 'new Core_Upgrader()',
				'version' =>  '3.7',
			),
			array(
				'deprecated' => 'wp_update_plugin',
				'replacement' => 'new Plugin_Upgrader()',
				'version' =>  '3.7',
			),
			array(
				'deprecated' => 'wp_update_theme',
				'replacement' => 'new Theme_Upgrader()',
				'version' =>  '3.7',
			),
			array(
				'deprecated' => 'get_screen_icon',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'screen_icon',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_incoming_links',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_incoming_links_control',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_incoming_links_output',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_plugins',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_primary_control',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_recent_comments_control',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_secondary',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_secondary_control',
				'replacement' => '',
				'version' => '3.8',
			),
			array(
				'deprecated' => 'wp_dashboard_secondary_output',
				'replacement' => '',
				'version' => '3.8',
			),
			// end wp-admin
		);

		ThemeCheck::increment(); // Keep track of how many checks we do.

		foreach ( $php_files as $file_path => $file_contents ) {
			foreach ( $functions as $function ) {
			// foreach ( $checks as $alt => $check ) {
				if ( preg_match( '/[\s?]' . $function['deprecated'] . '\(/', $file_contents, $matches ) ) {

					$file_name = basename( $file_path );
					$error = ltrim( rtrim( $matches[0], '(' ) );
					if ( ! empty( $function['replacement'] ) ) {
						$error_string = sprintf( '<code>%s</code> was found. It is deprecated since %s, use <code>%s</code> instead.', $error, $function['version'], $function['replacement'] );
					} else {
						$error_string = sprintf( '<code>%s</code> was found. It is deprecated since %s and should be removed.', $error, $function['version'] );
					}

					$this->error[] = array(
						'level' => TC_REQUIRED,
						'file'  => $file_name,
						'line'  => 0, // @todo
						'error' => $error_string,
						'test'  => __CLASS__,
					);
					$pass = false;
				}
			}
		}

		return $pass;
	}
}

$themechecks['deprecated'] = new Deprecated_Check;

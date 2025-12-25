<?php
/**
 *
 * 管理画面用の設定
 *
 * @package jsnd-jp-theme.
 */

/**
 * 基本
 */
function custom_theme_setup() {

	// タイトルタグ自動生成.
	add_theme_support( 'title-tag' );

	// アイキャッチ.
	add_theme_support( 'post-thumbnails' );

	// ブロックエディター用のエディタースタイルを有効化。.
	add_theme_support( 'editor-styles' );

	// クラシックエディタ用のスタイルを読み込み。.
	$editor_styles = array();

	$classic_editor_css = '/_admin-assets/css/editor-style.css';
	if ( file_exists( get_theme_file_path( $classic_editor_css ) ) ) {
		$editor_styles[] = ltrim( $classic_editor_css, '/' ) . '?ver=' . filemtime( get_theme_file_path( $classic_editor_css ) );
	}

	if ( ! empty( $editor_styles ) ) {
		add_editor_style( $editor_styles );
	}
}
add_action( 'after_setup_theme', 'custom_theme_setup' );


/**
 * ブロックエディター専用のCSSを読み込み
 */
function jsnd_enqueue_block_editor_styles() {
	$gutenberg_css  = '/_admin-assets/css/gutenberg-editor.css';
	$gutenberg_path = get_theme_file_path( $gutenberg_css );

	if ( file_exists( $gutenberg_path ) ) {
		wp_enqueue_style(
			'jsnd-gutenberg-editor-styles',
			get_theme_file_uri( $gutenberg_css ),
			array(),
			filemtime( $gutenberg_path )
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'jsnd_enqueue_block_editor_styles' );

/**
 * 管理画面用：CSSとJS追加
 */
function add_myadmin_files() {
	// CSS.
	wp_enqueue_style(
		'my-admin-style',
		get_template_directory_uri() . '/_admin-assets/css/admin-style.css',
		array(),
		filemtime( get_theme_file_path( '/_admin-assets/css/admin-style.css' ) )
	);

	// JS.
	wp_enqueue_script(
		'my-admin-script',
		get_template_directory_uri() . '/_admin-assets/js/admin-style.js',
		array( 'jquery' ),
		filemtime( get_theme_file_path( '/_admin-assets/js/admin-style.js' ) ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'add_myadmin_files' );


// /**
// * ログイン用：CSSとJS追加
// */
// function add_mylogin_css() {
// CSS.
// wp_enqueue_style(
// 'my-login-style',
// get_template_directory_uri() . '/_admin-assets/css/login-style.css',
// array(),
// filemtime( get_theme_file_path( '/_admin-assets/css/login-style.css' ) )
// );
// }
// add_action( 'login_enqueue_scripts', 'add_mylogin_css' );

/**
 * #wpadminbarのpositionをabsoluteに変更
 */
function change_admin_bar_position() {
	echo '<style type="text/css">#wpadminbar { position: absolute; }</style
>';
}
add_action( 'wp_head', 'change_admin_bar_position' );



/**
 * デフォルトの投稿タイプを完全に非表示にする.
 *
 * @param array  $args      ポストタイプ登録引数.
 * @param string $post_type ポストタイプ名.
 * @return array
 */
function jsnd_disable_default_post_type( $args, $post_type ) {
	if ( 'post' !== $post_type ) {
		return $args;
	}

	$args['public']              = false;
	$args['show_ui']             = false;
	$args['show_in_menu']        = false;
	$args['show_in_admin_bar']   = false;
	$args['show_in_nav_menus']   = false;
	$args['show_in_rest']        = false;
	$args['exclude_from_search'] = true;
	$args['publicly_queryable']  = false;
	$args['has_archive']         = false;
	$args['rewrite']             = false;

	return $args;
}
add_filter( 'register_post_type_args', 'jsnd_disable_default_post_type', 10, 2 );

/**
 * 「投稿」メニューとツールバー項目を削除する.
 */
function jsnd_remove_default_post_ui() {
	remove_menu_page( 'edit.php' );
}
add_action( 'admin_menu', 'jsnd_remove_default_post_ui', 999 );

/**
 * 管理バーの「新規投稿」を削除する.
 *
 * @param WP_Admin_Bar $wp_admin_bar 管理バーインスタンス.
 */
function jsnd_remove_new_post_from_admin_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}
add_action( 'admin_bar_menu', 'jsnd_remove_new_post_from_admin_bar', 999 );

/**
 * 投稿関連のダッシュボードウィジェットを非表示にする.
 */
function jsnd_cleanup_post_dashboard_widgets() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'jsnd_cleanup_post_dashboard_widgets' );

/**
 * Classic Editor (TinyMCE) で利用するカラーパレット.
 *
 * @return array[]
 */
function jsnd_theme_classic_editor_colors() {
	return array(
		array(
			'color' => '#20a647',
			'label' => __( 'Primary', 'jsnd-jp-theme' ),
		),
		array(
			'color' => '#033824',
			'label' => __( 'Secondary', 'jsnd-jp-theme' ),
		),
		array(
			'color' => '#e5121f',
			'label' => __( 'Red', 'jsnd-jp-theme' ),
		),
		array(
			'color' => '#f48700',
			'label' => __( 'Orange', 'jsnd-jp-theme' ),
		),

	);
}

/**
 * Advanced Editor Tools (TinyMCE) の文字色パレットをテーマカラーに差し替え.
 *
 * @param array $init TinyMCE init 設定.
 * @return array
 */
function jsnd_theme_tinymce_color_palette( $init ) {
	$palette = jsnd_theme_classic_editor_colors();

	if ( empty( $palette ) ) {
		return $init;
	}

	$textcolor_map = array();

	foreach ( $palette as $entry ) {
		if ( empty( $entry['color'] ) || empty( $entry['label'] ) ) {
			continue;
		}

		$hex   = sanitize_hex_color( $entry['color'] );
		$label = wp_strip_all_tags( $entry['label'] );

		if ( empty( $hex ) || '' === $label ) {
			continue;
		}

		$textcolor_map[] = strtoupper( ltrim( $hex, '#' ) );
		$textcolor_map[] = $label;
	}

	if ( empty( $textcolor_map ) ) {
		return $init;
	}

	$columns                = 4;
	$init['textcolor_map']  = wp_json_encode( $textcolor_map );
	$init['textcolor_cols'] = $columns;
	$init['textcolor_rows'] = (int) ceil( count( $textcolor_map ) / ( 2 * $columns ) );

	return $init;
}
add_filter( 'tiny_mce_before_init', 'jsnd_theme_tinymce_color_palette', 20 );


/**
 * 投稿のカテゴリとカスタム投稿のカスタムタクソノミーのスラッグが
 * 空か日本語の場合は変換
 *
 * カスタムタクソノミーは'{XXX}'を変更する
 * 例：create_{XXXX} → create_area
 *
 * @param int $term_id カテゴリーID.
 */
function post_taxonomy_auto_slug( $term_id ) {
	$tax  = str_replace( 'create_', '', current_filter() );
	$term = get_term( $term_id, $tax );
	if ( preg_match( '/(%[0-9a-f]{2})+/', $term->slug ) ) {
		$args = array(
			'slug' => $term->taxonomy . '-' . $term->term_id,
		);
		wp_update_term( $term_id, $tax, $args );
	}
}
add_action( 'create_pn-category', 'post_taxonomy_auto_slug', 10 );
// add_action( 'create_post_tag', 'post_taxonomy_auto_slug', 10 );.
// add_action( 'create_c_tag', 'post_taxonomy_auto_slug', 10 );.

/**
 * カスタム投稿：更新情報"pastnews"の一覧に
 * ACFの"acf_page_type_check"を表示。
 * 表示するのはラベルのみ。
 *
 * @param array $columns カラム配列.
 * @return array
 */
function jsnd_add_pastnews_page_type_column( $columns ) {
	$injected_columns = array();

	foreach ( $columns as $key => $label ) {
		if ( 'date' === $key ) {
			$injected_columns['acf_page_type_check'] = 'ページタイプ';
			$injected_columns['acf_post_has_new']    = 'NEWアイコン';
			$injected_columns['acf_post_list_fixed'] = '固定表示';
		}
		$injected_columns[ $key ] = $label;
	}

	return $injected_columns;
}
add_filter( 'manage_pastnews_posts_columns', 'jsnd_add_pastnews_page_type_column' );

/**
 * カスタム投稿："other"の一覧に
 * ACFの"acf_page_type_check"・"acf_post_has_new"・"acf_post_list_fixed"を表示。
 *
 * @param array $columns カラム配列.
 * @return array
 */
function jsnd_add_other_columns( $columns ) {
	$injected_columns = array();

	foreach ( $columns as $key => $label ) {
		if ( 'date' === $key ) {
			$injected_columns['acf_page_type_check'] = 'ページタイプ';
			$injected_columns['acf_post_has_new']    = 'NEWアイコン';
			$injected_columns['acf_post_list_fixed'] = '固定表示';
		}
		$injected_columns[ $key ] = $label;
	}

	return $injected_columns;
}
add_filter( 'manage_other_posts_columns', 'jsnd_add_other_columns' );

/**
 * カスタム投稿："hot-topics"の一覧に
 * ACFの"acf_page_type_check"・"acf_post_has_new"・"acf_hot_topics_highlight"を表示。
 *
 * @param array $columns カラム配列.
 * @return array
 */
function jsnd_add_hot_topics_columns( $columns ) {
	$injected_columns = array();

	foreach ( $columns as $key => $label ) {
		if ( 'date' === $key ) {
			$injected_columns['acf_page_type_check']      = 'ページタイプ';
			$injected_columns['acf_post_has_new']         = 'NEWアイコン';
			$injected_columns['acf_hot_topics_highlight'] = '強調';
			$injected_columns['acf_post_list_fixed']      = '固定表示';
		}
		$injected_columns[ $key ] = $label;
	}

	return $injected_columns;
}
add_filter( 'manage_hot-topics_posts_columns', 'jsnd_add_hot_topics_columns' );

/**
 * カスタム投稿："pastnews"・"hot-topics"・"other"の一覧に
 * ACFの"acf_page_type_check"・"acf_post_has_new"・"acf_hot_topics_highlight"・"acf_post_list_fixed"の値を表示。
 *
 * @param string $column  カラム名.
 * @param int    $post_id 投稿ID.
 */
function show_post_acf_column( $column, $post_id ) {
	if ( 'acf_page_type_check' === $column ) {
		$field_object = get_field_object( 'acf_page_type_check', $post_id );
		$value        = get_field( 'acf_page_type_check', $post_id );

		if ( is_array( $value ) && isset( $value['value'] ) ) {
			$value = $value['value'];
		}

		if ( $field_object && is_scalar( $value ) && isset( $field_object['choices'][ $value ] ) ) {
			echo esc_html( $field_object['choices'][ $value ] );
		}
	}

	if ( 'acf_post_has_new' === $column ) {
		$value = get_field( 'acf_post_has_new', $post_id );
		if ( $value ) {
			echo '表示';
		} else {
			echo '-';
		}
	}

	if ( 'acf_hot_topics_highlight' === $column ) {
		$value = get_field( 'acf_hot_topics_highlight', $post_id );
		echo $value ? '強調' : '-';
	}

	if ( 'acf_post_list_fixed' === $column ) {
		$value = get_field( 'acf_post_list_fixed', $post_id );
		echo $value ? '固定中' : '-';
	}
}
add_action( 'manage_pastnews_posts_custom_column', 'show_post_acf_column', 10, 2 );
add_action( 'manage_hot-topics_posts_custom_column', 'show_post_acf_column', 10, 2 );
add_action( 'manage_other_posts_custom_column', 'show_post_acf_column', 10, 2 );

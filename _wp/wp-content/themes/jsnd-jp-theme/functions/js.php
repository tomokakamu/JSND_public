<?php
/**
 * JSの指定
 *
 * @package jsnd-jp-theme.
 */

/**
 * JSの指定
 * wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
 */
function add_theme_js() {

	// トップページ.
	if ( is_front_page() ) {
		// home.jsがmain.jsをインポートするため、home.jsのみ読み込む.
		wp_enqueue_script(
			'frontpage',
			get_theme_file_uri( '/dist/assets/home.js' ),
			array(), // ES Modulesは依存関係を空にする.
			filemtime( get_theme_file_path( '/dist/assets/home.js' ) ),
			false
		);
		wp_script_add_data( 'frontpage', 'type', 'module' );
	} else {
		// その他のページはmain.jsを読み込む.
		wp_enqueue_script(
			'main',
			get_theme_file_uri( '/dist/assets/main.js' ),
			array(), // ES Modulesは依存関係を空にする.
			filemtime( get_theme_file_path( '/dist/assets/main.js' ) ),
			false
		);
		wp_script_add_data( 'main', 'type', 'module' );
	}
}
add_action( 'wp_enqueue_scripts', 'add_theme_js' );

/**
 * ViteのES Modulesにtype="module"を付与.
 *
 * テーマ内のモジュールバンドルを明示的にmoduleとしてマークする。
 *
 * @param string $tag    生成されたscriptタグ.
 * @param string $handle ハンドル名.
 * @param string $src    スクリプトURL.
 * @return string
 */
function add_module_type_attribute( $tag, $handle, $src ) {
	$module_handles = array( 'main', 'frontpage' );

	if ( in_array( $handle, $module_handles, true ) ) {
		$tag = sprintf(
			'<script type="module" src="%1$s" id="%2$s-js"></script>',
			esc_url( $src ),
			esc_attr( $handle )
		);
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'add_module_type_attribute', 10, 3 );

<?php
/**
 * 各種CSSの読み込み
 *
 * @package WordPress.
 */


/**
 * CSSの指定
 * wp_enqueue_style( $handle, $src, $deps, $ver, $media);
 */
function add_theme_css() {
	// 現在の言語を取得.
	$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';

	// main.
	wp_enqueue_style(
		'main',
		get_theme_file_uri( '/dist/assets/main.css' ),
		array(),
		filemtime( get_theme_file_path( '/dist/assets/main.css' ) )
	);


	// トップページ.
	if ( is_front_page() ) {
		wp_enqueue_style(
			'frontpage',
			get_theme_file_uri( '/dist/assets/home.css' ),
			array(),
			filemtime( get_theme_file_path( '/dist/assets/home.css' ) )
		);
	}


	// 英語版.
	if ( 'en' === $lang ) {
		// 英語用.
		wp_enqueue_style(
			'en',
			get_theme_file_uri( '/dist/assets/en.css' ),
			array(),
			filemtime( get_theme_file_path( '/dist/assets/en.css' ) )
		);
	}

}
add_action( 'wp_enqueue_scripts', 'add_theme_css' );

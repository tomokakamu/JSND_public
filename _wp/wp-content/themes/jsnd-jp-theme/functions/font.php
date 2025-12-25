<?php
/**
 * フォントの設定
 *
 * @package jsnd-jp-theme.
 */

// セキュリティ（直接アクセス防止）.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Google Fonts (Noto Sans JP) をフロントで読み込む.
 * display=swap を付与し FOUT を最小化。
 */
function companyname_enqueue_google_fonts() {
	$handle = 'companyname-google-fonts';
	// 追加したいフォントファミリー（太さ可変 100..900）.
	$font_url = 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap';

	// 既に登録済みでなければ enqueue.
	if ( ! wp_style_is( $handle, 'enqueued' ) ) {
		wp_enqueue_style( $handle, $font_url, array(), null ); // バージョン null でキャッシュ最適化（Google側が管理）.
	}
}
add_action( 'wp_enqueue_scripts', 'companyname_enqueue_google_fonts', 5 );

/**
 * resource hints で preconnect を追加（パフォーマンス最適化）.
 *
 * @param array  $urls          既存の URL.
 * @param string $relation_type relation タイプ (dns-prefetch, preconnect 等).
 * @return array
 */
function companyname_resource_hints_for_google_fonts( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		// fonts.googleapis.com への preconnect.
		$urls[] = 'https://fonts.googleapis.com';
		// crossorigin が必要な gstatic.
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => true,
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'companyname_resource_hints_for_google_fonts', 10, 2 );

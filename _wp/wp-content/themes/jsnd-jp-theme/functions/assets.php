<?php
/**
 * アセット（画像等）のパス解決ヘルパー。
 * - dist に最適化済みがあればそれを返す。
 * - なければテーマ内のオリジナルへフォールバック。
 *
 * @package companyname-theme
 */

if ( ! function_exists( 'theme_asset_uri' ) ) {
	/**
	 * 画像などのアセット URI を返す.
	 *
	 * @param string $path 例: 'img/logo.png' や '/img/logo.png'.
	 * @return string フロントから参照できる URI.
	 */
	function theme_asset_uri( $path ) {
		// 正規化: 先頭スラッシュ排除、バックスラッシュ→スラッシュ、ヌルバイト除去.
		$normalized = ltrim( (string) $path, '/' );
		$normalized = str_replace( "\0", '', $normalized );
		$normalized = str_replace( '\\', '/', $normalized );

		// パストラバーサル対策: '.' と '..' を除去して再構築.
		$parts = array_filter( explode( '/', $normalized ), 'strlen' );
		$safe  = array();
		foreach ( $parts as $seg ) {
			if ( '.' === $seg ) {
				continue;
			}
			if ( '..' === $seg ) {
				// 1つ戻る（無ければ無視）.
				array_pop( $safe );
				continue;
			}
			$safe[] = $seg;
		}
		$normalized = implode( '/', $safe );

		// 許可ディレクトリの制限（画像のみ）.
		if ( 0 !== strpos( $normalized, 'img/' ) && 'img' !== $normalized ) {
			// 想定外のパスはテーマURIにフォールバック.
			return get_template_directory_uri();
		}

		// 拡張子ホワイトリスト（非画像は返さない）.
		$ext          = strtolower( pathinfo( $normalized, PATHINFO_EXTENSION ) );
		$allowed_exts = array( 'png', 'jpg', 'jpeg', 'webp', 'gif', 'svg' );
		if ( ! in_array( $ext, $allowed_exts, true ) ) {
			return get_template_directory_uri();
		}

		// dist 側（最適化後）.
		$dist_rel  = 'dist/' . $normalized; // 例: dist/img/logo.png.
		$dist_path = get_theme_file_path( '/' . $dist_rel );
		if ( file_exists( $dist_path ) ) {
			return get_theme_file_uri( '/' . $dist_rel );
		}

		// src 側（開発オリジナル).
		$src_rel  = 'src/' . $normalized; // 例: src/img/logo.png.
		$src_path = get_theme_file_path( '/' . $src_rel );
		if ( file_exists( $src_path ) ) {
			return get_theme_file_uri( '/' . $src_rel );
		}

		// テーマ直下の相対パスも一応チェック.
		$theme_rel  = $normalized; // 例: img/logo.png.
		$theme_path = get_theme_file_path( '/' . $theme_rel );
		if ( file_exists( $theme_path ) ) {
			return get_theme_file_uri( '/' . $theme_rel );
		}

		// 見つからない場合はテーマ URI を返す（404 回避）.
		return get_template_directory_uri();
	}
}

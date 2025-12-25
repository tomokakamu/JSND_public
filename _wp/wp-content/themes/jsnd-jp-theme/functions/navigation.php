<?php
/**
 *
 * ナビゲーション
 *
 * @package jsnd-jp-theme.
 */

/**
 *
 */
function register_site_menus() {
	register_nav_menus(
		array(
			'header-menu'         => __( 'ヘッダーメニュー' ),
			'footer-menu'         => __( 'フッターメニュー' ),
			'sidebar-text-banner' => __( 'サイドバーテキストバナー' ),
		)
	);
}
add_action( 'init', 'register_site_menus' );

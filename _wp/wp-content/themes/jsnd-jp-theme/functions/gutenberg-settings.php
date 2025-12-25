<?php
/**
 * グーテンベルグ関連設定
 *
 * @package jsnd-jp-theme.
 */

// /**
// * 投稿タイプでグーテンベルグ無効化
// *
// * @param string $use_block_editor test.
// * @param string $post_type test.
// */
// function disable_block_editor( $use_block_editor, $post_type ) {
// if ( 'pastnews' === $post_type ) {
// return false; // 固定ページ.
// }
// return $use_block_editor;
// }
// add_filter( 'use_block_editor_for_post_type', 'disable_block_editor', 10, 10 );

/**
 * デフォルトのブロックパターンを無効化.
 */
function jsnd_disable_default_block_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'jsnd_disable_default_block_patterns' );


/**
 * トップページのみグーテンベルグ無効
 *
 * @param bool    $use_block_editor ブロックエディターを使用するかどうか.
 * @param WP_Post $post 投稿オブジェクト.
 * @return bool
 */
function disable_block_editor_for_front_page( $use_block_editor, $post ) {
	if ( ! $post ) {
		return $use_block_editor;
	}

	// 固定ページのみ対象.
	if ( 'page' !== $post->post_type ) {
		return $use_block_editor;
	}

	// フロントページとして設定されている固定ページはクラシックエディタに.
	$front_page_id = get_option( 'page_on_front' );
	if ( $front_page_id && (int) $front_page_id === $post->ID ) {
		return false;
	}

	return $use_block_editor;
}
add_filter( 'use_block_editor_for_post', 'disable_block_editor_for_front_page', 10, 2 );

/**
 * Set Spacer block default height to theme preset so the preset is selected by default.
 *
 * @param array $metadata Block type metadata.
 * @return array
 */
function jsnd_override_spacer_default_height( $metadata ) {
	if ( isset( $metadata['name'] ) && 'core/spacer' === $metadata['name'] ) {
		if ( isset( $metadata['attributes']['height'] ) ) {
			$metadata['attributes']['height']['default'] = 'var:preset|spacing|base';
		}
	}

	return $metadata;
}
add_filter( 'block_type_metadata', 'jsnd_override_spacer_default_height' );

/**
 * カスタムブロックスタイルを登録.
 *
 * @return void
 */
function jsnd_register_custom_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/group',
		array(
			'name'  => 'center-all',
			'label' => __( '中央配置', 'jsnd-jp-theme' ),
		)
	);

	register_block_style(
		'core/separator',
		array(
			'name'  => 'thick-2px',
			'label' => __( '太線（2px）', 'jsnd-jp-theme' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'pdf',
			'label' => __( 'PDF', 'jsnd-jp-theme' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'external-link',
			'label' => __( '外部リンク', 'jsnd-jp-theme' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'download',
			'label' => __( 'ダウンロード', 'jsnd-jp-theme' ),
		)
	);
}
add_action( 'init', 'jsnd_register_custom_block_styles' );

/**
 * 不要なセパレータースタイルを無効化.
 *
 * @return void
 */
function jsnd_unregister_unwanted_separator_styles() {
	if ( ! function_exists( 'wp_add_inline_script' ) ) {
		return;
	}

	$script = <<<JS
		wp.domReady( function() {
			if ( ! wp.blocks || ! wp.blocks.unregisterBlockStyle ) {
				return;
			}

			[ 'wide', 'dots' ].forEach( function( style ) {
				wp.blocks.unregisterBlockStyle( 'core/separator', style );
			} );
		} );
	JS;

	wp_add_inline_script( 'wp-blocks', $script );
}
add_action( 'enqueue_block_editor_assets', 'jsnd_unregister_unwanted_separator_styles' );

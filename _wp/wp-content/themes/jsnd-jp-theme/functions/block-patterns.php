<?php
/**
 * Block pattern registration.
 *
 * @package jsnd-jp-theme
 */

/**
 * Register block pattern category and patterns.
 *
 * Loads markup from files in the /patterns directory so it can be indexed in the editor.
 *
 * @return void
 */
function jsnd_theme_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	if ( function_exists( 'register_block_pattern_category' ) && class_exists( 'WP_Block_Pattern_Categories_Registry' ) ) {
		$category_slug = 'jsnd-components';
		$registry      = WP_Block_Pattern_Categories_Registry::get_instance();

		if ( ! $registry->is_registered( $category_slug ) ) {
			register_block_pattern_category(
				$category_slug,
				array(
					'label' => __( 'カスタムパターン', 'jsnd-jp-theme' ),
				)
			);
		}
	}

	$patterns = array(
		'card-layout'            => array(
			'file'     => 'patterns/card-layout.php',
			'title'    => __( 'カードレイアウト', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( 'カード', 'jsnd-jp-theme' ),
				__( 'レイアウト', 'jsnd-jp-theme' ),
				__( 'リンク', 'jsnd-jp-theme' ),
			),
		),
		'book-item'              => array(
			'file'     => 'patterns/book-item.php',
			'title'    => __( '書籍レイアウト', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( '書籍', 'jsnd-jp-theme' ),
				__( 'レイアウト', 'jsnd-jp-theme' ),
				__( 'ボタン', 'jsnd-jp-theme' ),
			),
		),
		'book-item-large'        => array(
			'file'     => 'patterns/book-item-large.php',
			'title'    => __( '書籍レイアウト（詳細）', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( '書籍', 'jsnd-jp-theme' ),
				__( 'レイアウト', 'jsnd-jp-theme' ),
				__( 'テーブル', 'jsnd-jp-theme' ),
			),
		),
		'text-image'             => array(
			'file'     => 'patterns/text-image.php',
			'title'    => __( 'テキスト＋画像レイアウト', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( 'テキスト', 'jsnd-jp-theme' ),
				__( '画像', 'jsnd-jp-theme' ),
				__( 'レイアウト', 'jsnd-jp-theme' ),
			),
		),
		'simple-panel'           => array(
			'file'     => 'patterns/simple-panel.php',
			'title'    => __( 'シンプルパネル', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( 'パネル', 'jsnd-jp-theme' ),
				__( 'ボックス', 'jsnd-jp-theme' ),
				__( 'リンク', 'jsnd-jp-theme' ),
			),
		),
		'simple-table'           => array(
			'file'     => 'patterns/simple-table.php',
			'title'    => __( 'シンプルテーブル', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( 'テーブル', 'jsnd-jp-theme' ),
				__( '表', 'jsnd-jp-theme' ),
			),
		),
		'file-link'              => array(
			'file'     => 'patterns/file-link.php',
			'title'    => __( 'ファイルリンク', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( 'ファイル', 'jsnd-jp-theme' ),
				__( 'リンク', 'jsnd-jp-theme' ),
				__( 'ダウンロード', 'jsnd-jp-theme' ),
			),
		),
		'text-flex-nowrap'       => array(
			'file'     => 'patterns/text-flex-nowrap.php',
			'title'    => __( 'テキスト横並び（改行なし）', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( 'テキスト', 'jsnd-jp-theme' ),
				__( '横並び', 'jsnd-jp-theme' ),
				__( '改行なし', 'jsnd-jp-theme' ),
			),
		),
		'round-border-background' => array(
			'file'     => 'patterns/round-border-background.php',
			'title'    => __( '角丸背景', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( '背景', 'jsnd-jp-theme' ),
				__( '角丸', 'jsnd-jp-theme' ),
				__( 'ボックス', 'jsnd-jp-theme' ),
			),
		),
		'background-gray'        => array(
			'file'     => 'patterns/background-gray.php',
			'title'    => __( '背景：グレー', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( '背景', 'jsnd-jp-theme' ),
				__( 'グレー', 'jsnd-jp-theme' ),
				__( 'ボックス', 'jsnd-jp-theme' ),
			),
		),
		'background-light-green' => array(
			'file'     => 'patterns/background-light-green.php',
			'title'    => __( '背景：ライトグリーン', 'jsnd-jp-theme' ),
			'keywords' => array(
				__( '背景', 'jsnd-jp-theme' ),
				__( 'ライトグリーン', 'jsnd-jp-theme' ),
				__( 'ボックス', 'jsnd-jp-theme' ),
			),
		),
	);

	foreach ( $patterns as $slug => $pattern ) {
		$pattern_path = get_theme_file_path( $pattern['file'] );

		if ( ! file_exists( $pattern_path ) ) {
			continue;
		}

		ob_start();
		include $pattern_path;
		$pattern_content = trim( ob_get_clean() );

		if ( '' === $pattern_content ) {
			continue;
		}

		register_block_pattern(
			"jsnd-jp-theme/{$slug}",
			array(
				'title'         => $pattern['title'],
				'categories'    => array( 'jsnd-components' ),
				'content'       => $pattern_content,
				'viewportWidth' => 1200,
				'keywords'      => $pattern['keywords'],
			)
		);
	}

	// バリエーション：ボタン.
	register_block_style(
		'core/button',
		array(
			'name'  => 'normal',
			'label' => '矢印',
		)
	);
	register_block_style(
		'core/button',
		array(
			'name'  => 'pdf',
			'label' => 'PDFリンク',
		)
	);
	register_block_style(
		'core/button',
		array(
			'name'  => 'external-link',
			'label' => '外部リンク',
		)
	);

	// バリエーション：グループ（背景色）.
	register_block_style(
		'core/group',
		array(
			'name'  => 'background-gray',
			'label' => '背景：グレー',
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'background-light-green',
			'label' => '背景：ライトグリーン',
		)
	);

	// バリエーション：リスト（ドット色）.
	register_block_style(
		'core/list',
		array(
			'name'  => 'dot-text-color',
			'label' => 'ドット色：テキストカラー',
		)
	);
}
add_action( 'init', 'jsnd_theme_register_block_patterns', 9 );

/**
 * Disable bundled core block patterns and remote pattern loading.
 *
 * Runs early in the theme setup lifecycle so only theme-defined patterns appear
 * in the inserter.
 *
 * @return void
 */
function jsnd_theme_disable_core_block_patterns() {
	remove_theme_support( 'core-block-patterns' );
	add_filter( 'should_load_remote_block_patterns', '__return_false' );
}
add_action( 'after_setup_theme', 'jsnd_theme_disable_core_block_patterns', 9 );

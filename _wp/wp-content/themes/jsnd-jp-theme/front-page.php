<?php
/**
 *
 * 場所：固定ページ
 * 種類：トップページ
 *
 * 英語の分岐：有
 *
 * <?php echo esc_url( get_template_directory_uri() ); ?>
 * <?php echo esc_url( home_url( '/' ) ); ?>
 *
 * @package jsnd-jp-theme.
 */

// 現在の言語を取得.
$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';

get_header(); ?>

<?php
// メインスライダー.
get_template_part( 'template-parts/home-kv' );
?>

<div class="u-width--primary">

	<?php
	// 言語別.
	if ( 'en' === $lang ) {
		// 英語用.
		get_template_part( 'template-parts/en/home-news-pastnews' );
	} else {
		// ページリンク.
		get_template_part( 'template-parts/home-about' );

		// ホットトピックス.
		get_template_part( 'template-parts/home-hot-topics' );

		// 更新情報.
		get_template_part( 'template-parts/home-news-pastnews' );

		// その他お知らせ.
		get_template_part( 'template-parts/home-news-other' );
	}
	?>

</div>

<?php
// 画像付きページリンク.
get_template_part( 'template-parts/home-page-link' );

// バナーセクション.
get_template_part( 'template-parts/home-banner' );

get_footer();

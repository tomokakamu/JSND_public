<?php
/**
 *
 * エラーページ
 *
 * @package jsnd-jp-theme.
 */

get_header(); ?>

	<div class="l-page-header">
		<div class="u-width--primary">
			<h1 class="l-page-header__title">ページが見つかりませんでした</h1>
		</div>
	</div>
	<div class="u-width--primary">
		<div class="l-content">
			<section class="p-page-content l-content--main">
				<p>お探しのページは存在しないか、移動・削除された可能性があります。<br>URLに誤りがないかご確認ください。</p>
				<div style="height:var(--wp--preset--spacing--base)" aria-hidden="true" class="wp-block-spacer"></div>
				<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
					<div class="wp-block-button is-style-normal"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ</a></div>
					<div class="wp-block-button is-style-normal"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>sitemap/">サイトマップへ</a></div>
				</div>
			</section>
		</div>
	</div>

<?php get_footer(); ?>

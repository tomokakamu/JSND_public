<?php
/**
 *
 * 場所：投稿
 * 種類：サイトバー
 *
 * 英語の分岐：有
 *
 * @package jsnd-jp-theme.
 */

// 現在の言語を取得.
$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';
?>
<aside class="l-content--side">
	<div class="c-sidebar">
		<?php
		/**
		 * 言語別.
		 */

		// 英語用.
		if ( 'en' === $lang ) :
			?>
			<?php get_template_part( 'components/sidebar-page-list' ); ?>
			<?php
			// 日本語用.
		else :
			?>
			<?php if ( is_page() && ! is_page( 'sitemap' ) ) : ?>
				<?php get_template_part( 'components/sidebar-page-list' ); ?>
			<?php endif; ?>
			<div class="c-sidebar__item">
				<?php get_template_part( 'components/banner-has-image' ); ?>
			</div>
			<div class="c-sidebar__item">
				<?php get_template_part( 'components/sidebar-text-banner' ); ?>
			</div>
		<?php endif; ?>
		
	</div>
</aside>

<?php
/**
 * 共通ファイル：フッター
 *
 * 英語の分岐：有
 *
 * @package jsnd-jp-theme.
 */

// 現在の言語を取得.
$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';

?>
</main>

<footer class="l-footer">
	<div class="c-footer u-width--primary">
		<div class="c-footer__inner">
			<?php
			// ページトップ.
			if ( 'en' === $lang ) {
				// 英語用.
				get_template_part( 'components/en/pagetop' );
			} else {
				// 日本語用.
				get_template_part( 'components/pagetop' );
			}
			?>
			<?php
			// 英語用.
			if ( 'en' === $lang ) :
				?>
				<div class="c-footer__logo">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/common-logo-white_en.png" alt="THE JAPANESE SOCIETY OF NUTRITION AND DIETETICS">
				</div>
				<?php
				// 日本語用.
			else :
				?>
				<div class="c-footer__logo">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/common-logo-white.png" alt="特定非営利活動法人 日本栄養改善学会">
				</div>
				<div class="c-footer__address">
					<div class="c-footer__address-col">
						<p>TEL：070-3204-7411　FAX：03-5817-8618</p>
						<p>E-mail：<img src="data:image/png;base64,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" height="15.5" alt="特定非営利活動法人 日本栄養改善学会：メールアドレス"></p>
					</div>
				</div>
			<?php endif; ?>
			
			<?php
			// フッターナビゲーション（日本語用のみ）.
			if ( 'ja' === $lang ) {
				$args = array(
					'theme_location'  => 'footer-menu',
					// 'container'       => 'nav',
					'container_class' => 'c-footer__navigation',
				);
					wp_nav_menu( $args );
			}
			?>
			<p class="c-footer__copyright">Copyright &copy; THE JAPANESE SOCIETY OF NUTRITION AND DIETETICS, All rights reserved.</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

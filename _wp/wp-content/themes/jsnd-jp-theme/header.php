<?php
/**
 * 共通ファイル：ヘッダー
 *
 * 英語の分岐：有
 *
 * @package jsnd-jp-theme.
 */

// 現在の言語を取得.
$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';
?>
<!DOCTYPE html>
<html dir="ltr" lang="ja">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MLNGZFXJ');</script>
	<!-- End Google Tag Manager -->
	<?php wp_head(); ?>	
</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MLNGZFXJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<header id="js-header" class="l-header">
	<div class="c-header">
		<div class="u-width--primary">
			<div class="c-header__top">
				<div class="c-header__logo">
					<?php
					// ロゴとリンク.
					if ( function_exists( 'pll_home_url' ) ) {
						$home_ja = pll_home_url( 'ja' );
						$home_en = pll_home_url( 'en' );
					}

					// 英語用.
					if ( 'en' === $lang ) :
						?>
						<a href="<?php echo esc_url( $home_en ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/common-logo-color_en.png" width="470" height="60" alt="THE JAPANESE SOCIETY OF NUTRITION AND DIETETICS"></a>
						<?php
						// 日本語用.
					else :
						?>
						<a href="<?php echo esc_url( $home_ja ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/common-logo-color.png" width="350" height="52" alt="特定非営利活動法人 日本栄養改善学会"></a>
					<?php endif; ?>
				</div>
				<div class="u-display-hidden--m">
					<?php
					// ヘッダーボタンリスト.
					if ( 'en' === $lang ) {
						// 英語用.
						get_template_part( 'components/en/header-button-list' );
					} else {
						// 日本語用.
						get_template_part( 'components/header-button-list' );
					}
					?>
				</div>
			</div>
			<div class="c-header__bottom">
				<?php
					// ナビゲーションボタン.
					get_template_part( 'components/navigation-trigger' );
				?>
				<div class="l-navigation">
					<div class="c-navigation__wrapper">
						<div class="c-navigation__inner js-simplebar-mobile" data-simplebar-auto-hide="false">
							<div class="u-display-visible--m">
								<?php
								// ヘッダーボタンリスト.
								if ( 'en' === $lang ) {
									// 英語用.
									get_template_part( 'components/en/header-button-list' );
								} else {
									// 日本語用.
									get_template_part( 'components/header-button-list' );
								}
								?>
							</div>
							<?php
							// ナビゲーション.
							$args = array(
								'theme_location'  => 'header-menu',
								'menu_class'      => 'js-navigation c-navigation__list',
								'container'       => 'nav',
								'container_class' => 'c-navigation',
							);
							wp_nav_menu( $args );
							?>
							<div class="u-display-visible--m">
								<?php
								// 言語切替ボタン.
								if ( 'en' === $lang ) {
									// 英語用.
									get_template_part( 'components/en/button-ja' );
								} else {
									// 日本語用.
									get_template_part( 'components/button-en' );
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<main class="l-main">

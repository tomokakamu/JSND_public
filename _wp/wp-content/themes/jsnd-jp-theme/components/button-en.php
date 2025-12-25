<?php
/**
 *
 * ページトップボタン
 * header.php
 *
 * @package jsnd-jp-theme.
 */

if ( function_exists( 'pll_home_url' ) ) {
	$home_en = pll_home_url( 'en' );
}
?>
<a class="c-button c-button--round is--gray" href="<?php echo esc_url( $home_en ); ?>">English</a>

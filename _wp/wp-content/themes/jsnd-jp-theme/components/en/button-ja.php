<?php
/**
 *
 * ページトップボタン
 * 場所：footer.php
 *
 * @package jsnd-jp-theme.
 */

if ( function_exists( 'pll_home_url' ) ) {
	$home_ja = pll_home_url( 'ja' );
}
?>
<a class="c-button c-button--round is--gray" href="<?php echo esc_url( $home_ja ); ?>">Japanese</a>

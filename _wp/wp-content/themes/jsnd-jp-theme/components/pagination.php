<?php
/**
 *
 * ページネーション
 * 場所：index.php & archive.php
 *
 * @package jsnd-jp-theme.
 */

// 現在の言語を取得.
$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';

?>
<div class="c-pagination">
	<?php
	global $wp_query;
	$bignum = 999999999;
	$args   = array(
		'base'      => str_replace( $bignum, '%#%', esc_url( get_pagenum_link( $bignum ) ) ),
		'format'    => '',
		'current'   => max( 1, get_query_var( 'paged' ) ),
		'total'     => $wp_query->max_num_pages,
		'prev_text' => 'en' === $lang ? 'Prev' : '前へ',
		'next_text' => 'en' === $lang ? 'Next' : '次へ',
		'type'      => 'array',
		'mid_size'  => 1,
		'end_size'  => 1,
	);

	$links = paginate_links( $args );
	if ( ! $links ) {
		$links = array();
	}

	// 配列の中に 'prev' / 'next' クラスを持つものがあるかチェック.
	$has_prev = false;
	$has_next = false;
	foreach ( $links as $link ) {
		if ( strpos( $link, 'prev' ) !== false ) {
			$has_prev = true;
		}
		if ( strpos( $link, 'next' ) !== false ) {
			$has_next = true;
		}
	}

	// HTML出力.
	if ( $wp_query->max_num_pages > 0 ) {
		echo '<nav class="navigation pagination" aria-label="投稿">';
		echo '<h2 class="screen-reader-text">投稿ナビゲーション</h2>';
		echo '<div class="nav-links">';
		echo '<ul class="page-numbers">';

		// 前へ（なければ非活性で追加）.
		if ( ! $has_prev ) {
			$prev_text = 'en' === $lang ? 'Prev' : '前へ';
			echo '<li><span class="page-numbers prev is-off">' . esc_html( $prev_text ) . '</span></li>';
		}

		// 数字部分などを出力.
		foreach ( $links as $link ) {
			echo '<li>' . $link . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		// 次へ（なければ非活性で追加）.
		if ( ! $has_next ) {
			$next_text = 'en' === $lang ? 'Next' : '次へ';
			echo '<li><span class="page-numbers next is-off">' . esc_html( $next_text ) . '</span></li>';
		}

		echo '</ul>';
		echo '</div>';
		echo '</nav>';
	}
	?>
</div>

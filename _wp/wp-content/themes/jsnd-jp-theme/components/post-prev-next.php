<?php
/**
 *
 * 次の記事、前の記事
 * 場所：single.php
 *
 * @package jsnd-jp-theme.
 */

?>
<div class="prevNext-list">
	<?php if ( get_next_post() ) : ?>
	<div class="next bottom-link"><?php next_post_link( '%link', '<span class="arrow arrow-left"></span><span class="txt">次の記事</span>' ); ?></div>
	<?php else : ?>
	<div class="next bottom-link is--off"></div>
	<?php endif; ?>
	<?php
	if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
		$post_url = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
	}
	$post_url_array = explode( '/', $post_url );
	$post_page_slug = $post_url_array[1];
	?>
	<div class="list-link bottom-link"><a href="<?php echo esc_url( home_url( '/' . $post_page_slug . '/' ) ); ?>">一覧に戻る</a></div>
	<?php if ( get_previous_post() ) : ?>
	<div class="prev bottom-link"><?php previous_post_link( '%link', '<span class="txt">前の記事</span><span class="arrow arrow-right"></span>' ); ?></div>
	<?php else : ?>
	<div class="next bottom-link is--off"></div>
	<?php endif; ?>
</div>

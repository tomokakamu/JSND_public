<?php
/**
 *
 * ページトップボタン
 * 場所：footer.php
 *
 *  is--disableは無効化です
 *
 * @package jsnd-jp-theme.
 */

?>
<ul class="c-header-button-list">
	<li class="c-header-button-list__item">
		<a class="c-button c-button--round is--orange" href="<?php echo esc_url( home_url( '/' ) ); ?>nyukai/nyukaiannnai/">入会案内</a>
		<?php
		/*
		1/30からリンクが変更
		<a class="c-button c-button--round is--orange" href="<?php echo esc_url( home_url( '/' ) ); ?>nyukaiannnai/">入会案内</a>
		*/
		?>
	</li>
	<li class="c-header-button-list__item">
		<?php
		/*
		26/1/30からリンクが変更
		<a class="c-button c-button--round is--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>nyukai/mypage/">会員マイページ</a>
		*/
		?>
		<a class="c-button c-button--round is--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>nyukai/mypage/">会員マイページ</a>
	</li>
	<li class="c-header-button-list__item  is--en">
		<?php get_template_part( 'components/button-en' ); ?>
	</li>
</ul>

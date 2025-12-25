<?php
/**
 * 場所：トップページ
 * 種類：パーツ（その他お知らせ）
 *
 * @package jsnd-jp-theme.
 */

$other_post_query  = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_type'      => 'other',
	)
);
$other_total_posts = $other_post_query->found_posts;

// acf_post_list_fixed が true のものを先頭に並び替え.
if ( $other_post_query->have_posts() ) {
	$fixed_posts  = array();
	$normal_posts = array();

	foreach ( $other_post_query->posts as $post_item ) {
		if ( get_field( 'acf_post_list_fixed', $post_item->ID ) ) {
			$fixed_posts[] = $post_item;
		} else {
			$normal_posts[] = $post_item;
		}
	}

	$merged_posts = array_merge( $fixed_posts, $normal_posts );

	// 10件に切り詰め.
	$other_post_query->posts      = array_slice( $merged_posts, 0, 10 );
	$other_post_query->post_count = count( $other_post_query->posts );
}
?>
<?php if ( $other_post_query->have_posts() ) : ?>
	<div class=" p-home-news">
		<div class="p-home__section-header">
			<h2 class="p-home__section-header__main">その他お知らせ</h2>
			<div class="p-home__section-header__sub">News</div>
		</div>
		<ul class="js-home-news c-news-list">
			<?php
			while ( $other_post_query->have_posts() ) :
				$other_post_query->the_post();

				// ACFの設定「ページのタイプ」で条件分岐.
				$acf_page_type_check = get_field( 'acf_page_type_check' );
				if ( is_array( $acf_page_type_check ) && isset( $acf_page_type_check['value'] ) ) {
					$acf_page_type_check = $acf_page_type_check['value'];
				}

				$acf_page_url        = get_field( 'acf_page_url' );
				$acf_page_url_target = get_field( 'acf_page_url_target' );
				$acf_post_has_new    = get_field( 'acf_post_has_new' ); // NEWアイコン.

				// ページタイプに基づいてリンクURLを決定.
				if ( 'title_only' === $acf_page_type_check ) {
					// タイトルのみの場合はリンクなし.
					$link_url = '';
				} elseif ( 'link' === $acf_page_type_check && $acf_page_url ) {
					// 外部リンクが選択され、URLが入力されている場合.
					$link_url = $acf_page_url;
				} else {
					// 通常ページまたはURLが未入力の場合は記事ページへ.
					$link_url = get_the_permalink();
				}

				$link_target = $acf_page_url_target ? ' target="_blank" rel="noopener noreferrer"' : '';

				// その他お知らせのみ.
				$acf_post_list_fixed = get_field( 'acf_post_list_fixed' ); // 一覧固定表示.
				?>
				<li class="c-news-list__item">
					<?php if ( 'title_only' === $acf_page_type_check ) : ?>
					<span class="c-news-list__inner">
					<?php else : ?>
					<a class="c-news-list__inner" href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php endif; ?>
						<div class=" c-news-list__header">
							<time class="c-news-list__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
							<h3 class="c-news-list__title"><span><?php the_title(); ?></span></h3>
							<?php if ( $acf_post_has_new ) : ?>
							<div class="c-icon c-icon--new"></div>
							<?php endif; ?>
						</div>
						<?php if ( empty( $acf_page_type_check ) || 'normal' === $acf_page_type_check || 'link' === $acf_page_type_check ) : ?>
							<?php if ( $acf_page_url_target ) : ?>
								<div class="c-icon c-icon--window-border c-news-list__icon"></div>
							<?php else : ?>
								<div class="c-icon c-icon--circle-arrow c-news-list__icon"></div>
							<?php endif; ?>
						<?php endif; ?>
					<?php if ( 'title_only' === $acf_page_type_check ) : ?>
					</span>
					<?php else : ?>
					</a>
					<?php endif; ?>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php if ( $other_total_posts > 5 ) : ?>
		<div class="c-button__wrap">
			<button class="js-post-more c-button c-button--round is--secondary is-more">もっと見る・・・<span class="c-icon c-icon--circle-arrow"></span></button>
		</div>
		<?php endif; ?>
		<div class="c-button__wrap p-home-news__button-list">
			<a class="c-button c-button--round is--primary is-list" href="<?php echo esc_url( home_url( '/' ) ); ?>news/other/">その他のお知らせ一覧<span class="c-icon c-icon--arrow"></span></a>
		</div>
	</div>
	<?php
endif;
wp_reset_postdata();

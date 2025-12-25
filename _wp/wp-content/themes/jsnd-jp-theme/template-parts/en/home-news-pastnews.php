<?php
/**
 * 場所：トップページ
 * 種類：パーツ（更新情報）
 *
 * @package jsnd-jp-theme.
 */

$pastnews_post_query  = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_type'      => 'pastnews',
		'post_status'    => 'publish',
	)
);
$pastnews_total_posts = $pastnews_post_query->found_posts;

// acf_post_list_fixed が true のものを先頭に並び替え.
if ( $pastnews_post_query->have_posts() ) {
	$fixed_posts  = array();
	$normal_posts = array();

	foreach ( $pastnews_post_query->posts as $post_item ) {
		if ( get_field( 'acf_post_list_fixed', $post_item->ID ) ) {
			$fixed_posts[] = $post_item;
		} else {
			$normal_posts[] = $post_item;
		}
	}

	$merged_posts = array_merge( $fixed_posts, $normal_posts );

	// 10件に切り詰め.
	$pastnews_post_query->posts      = array_slice( $merged_posts, 0, 10 );
	$pastnews_post_query->post_count = count( $pastnews_post_query->posts );
}
?>
<?php if ( $pastnews_post_query->have_posts() ) : ?>
<div class="p-home-information">
	<div class="p-home__section-header">
		<h2 class="p-home__section-header__main">NEWS</h2>
		<div class="p-home__section-header__sub">Information</div>
	</div>
	<ul class="js-home-information c-information-list">
		<?php
		while ( $pastnews_post_query->have_posts() ) :
			$pastnews_post_query->the_post();

			// ACFの情報取得.

			// 「ページのタイプ」の条件分岐.
			$acf_page_type_check = get_field( 'acf_page_type_check' );
			if ( is_array( $acf_page_type_check ) && isset( $acf_page_type_check['value'] ) ) {
				$acf_page_type_check = $acf_page_type_check['value'];
			}

			$acf_page_url        = get_field( 'acf_page_url' ); // リンクがある場合.
			$acf_page_url_target = get_field( 'acf_page_url_target' ); // 新しいタブで開くかどうか.
			$link_url            = $acf_page_url ? $acf_page_url : get_the_permalink();

			$acf_post_has_new = get_field( 'acf_post_has_new' ); // NEWアイコン.

			$link_target = $acf_page_url_target ? ' target="_blank" rel="noopener noreferrer"' : '';
			?>
			<li class="c-information-list__item">
				<?php
				// リンクとspanの切り替え.
				if ( 'title_only' === $acf_page_type_check ) :
					?>
				<span class="c-information-list__link">
				<?php else : ?>
				<a class="c-information-list__link" href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php endif; ?>
					<div class="c-information-list__data">
						<time class="c-information-list__date" datetime="<?php the_time( 'Y-m-d' ); ?>">
							<span class="is--year"><?php the_time( 'Y' ); ?></span><span class="is--day"><?php the_time( 'm' ); ?>.<?php the_time( 'd' ); ?></span></time>
						</time>
						<div class="c-information-list__category">
						<?php
						// カスタムタクソノミー：カテゴリ.
						$tax_cat_terms = get_the_terms( $post->ID, 'pn-category' );
						if ( $tax_cat_terms && ! is_wp_error( $tax_cat_terms ) ) :
							foreach ( $tax_cat_terms as $tax_cat_term ) :
								$tax_cat_name = $tax_cat_term->name; // 名前.
								?>
								<span class="c-category"><?php echo esc_html( $tax_cat_name ); ?></span>
							<?php endforeach; ?>
						<?php endif; ?>
						</div>
					</div>
					<!-- /.c-information-list__data -->
					<div class="c-information-list__content">
						<h3 class="c-information-list__title"><span><?php the_title(); ?></span></h3>
						<?php
						// NEWアイコンの表示.
						if ( $acf_post_has_new ) :
							?>
						<div class="c-icon c-icon--new"></div>
						<?php endif; ?>
					</div>
					<?php
					// アイコンの表示条件分岐.
					if ( empty( $acf_page_type_check ) || 'normal' === $acf_page_type_check || 'link' === $acf_page_type_check ) :
						?>
						<?php if ( $acf_page_url_target ) : ?>
							<div class="c-icon c-icon--window-border c-information-list__icon"></div>
						<?php else : ?>
							<div class="c-icon c-icon--circle-arrow c-information-list__icon"></div>
						<?php endif; ?>
					<?php endif; ?>

				<?php
				// リンクとspanの切り替え.
				if ( 'title_only' === $acf_page_type_check ) :
					?>
				</span>
				<?php else : ?>
				</a>
				<?php endif; ?>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php if ( $pastnews_total_posts > 5 ) : ?>
	<div class="c-button__wrap">
		<button class="js-post-more c-button c-button--round is--secondary is-more">MORE<span class="c-icon c-icon--circle-arrow"></span></button>
	</div>
	<?php endif; ?>
	<?php
	/*
	<div class="c-button__wrap p-home-information__button-list">
		<a class="c-button c-button--round is--primary is-list" href="<?php echo esc_url( home_url( '/' ) ); ?>news/pastnews/">更新情報一覧<span class="c-icon c-icon--arrow"></span></a>
	</div>
	*/
	?>
</div>
	
	<?php
endif;
wp_reset_postdata();

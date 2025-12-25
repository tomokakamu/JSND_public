<?php
/**
 * 場所：トップページ
 * 種類：パーツ（ホットトピックス）
 *
 * @package jsnd-jp-theme.
 */

$hottopics_post_query = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_type'      => 'hot-topics',
		'post_status'    => 'publish',
	)
);

// acf_hot_topics_highlight と acf_post_list_fixed の状態で並び替え.
if ( $hottopics_post_query->have_posts() ) {
	$highlight_fixed_posts = array();
	$highlight_posts       = array();
	$normal_fixed_posts    = array();
	$normal_posts          = array();

	foreach ( $hottopics_post_query->posts as $post_item ) {
		$is_highlight = get_field( 'acf_hot_topics_highlight', $post_item->ID );
		$is_fixed     = get_field( 'acf_post_list_fixed', $post_item->ID );

		if ( $is_highlight && $is_fixed ) {
			$highlight_fixed_posts[] = $post_item;
		} elseif ( $is_highlight ) {
			$highlight_posts[] = $post_item;
		} elseif ( $is_fixed ) {
			$normal_fixed_posts[] = $post_item;
		} else {
			$normal_posts[] = $post_item;
		}
	}
	$hottopics_post_query->posts = array_merge( $highlight_fixed_posts, $highlight_posts, $normal_fixed_posts, $normal_posts );
}

$hottopics_total_posts = $hottopics_post_query->found_posts;
?>
<?php if ( $hottopics_post_query->have_posts() ) : ?>
<div id="hot-topics" class="p-home-hot-topics">
	<div class="p-home__section-header">
		<h2 class="p-home__section-header__main">ホットトピックス</h2>
		<div class="p-home__section-header__sub">Hot Topics</div>
	</div>
	<?php
	$is_first_post = true;
	$current_mode  = '';

	while ( $hottopics_post_query->have_posts() ) :
		$hottopics_post_query->the_post();

		/**
		 * ACFの情報取得.
		 */

		// 「ページのタイプ」の条件分岐.
		$acf_page_type_check = get_field( 'acf_page_type_check' );
		if ( is_array( $acf_page_type_check ) && isset( $acf_page_type_check['value'] ) ) {
			$acf_page_type_check = $acf_page_type_check['value'];
		}

		$acf_page_url        = get_field( 'acf_page_url' ); // リンクがある場合.
		$acf_page_url_target = get_field( 'acf_page_url_target' ); // 新しいタブで開くかどうか.
		$acf_page_url_name   = get_field( 'acf_page_url_name' ); // リンク先の団体名.
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

		$acf_hot_topics_highlight = get_field( 'acf_hot_topics_highlight' );

		if ( $is_first_post ) {
			if ( $acf_hot_topics_highlight ) {
				echo '<div class="p-home-hot-topics__list">';
				$current_mode = 'highlight';
			} else {
				echo '<div class="js-hot-topics p-home-hot-topics__list is--bottom">';
				$current_mode = 'normal';
			}
			$is_first_post = false;
		} elseif ( 'highlight' === $current_mode && ! $acf_hot_topics_highlight ) {
			echo '</div>';
			echo '<div class="js-hot-topics p-home-hot-topics__list is--bottom">';
			$current_mode = 'normal';
		}
		?>
		<?php if ( $acf_hot_topics_highlight ) : ?>
			<!-- 強調 -->
			<div class="p-home-hot-topics__item">
				<?php
				// リンクとspanの切り替え.
				if ( 'title_only' === $acf_page_type_check ) :
					?>
				<span class="c-panel-link is--orange">
				<?php else : ?>
				<a class="c-panel-link is--orange has-icon" href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php endif; ?>
				
					<div class="c-panel-link__content">
						<p style="display: flex; align-items: center; gap:1em;">
							<?php the_title(); ?>
							<?php
								// NEWアイコンの表示.
							if ( $acf_post_has_new ) :
								?>
								<span class="c-icon c-icon--new"></span>
								<?php endif; ?>
							</p>
					</div>
					<?php
					// アイコンの表示条件分岐.
					if ( empty( $acf_page_type_check ) || 'normal' === $acf_page_type_check || 'link' === $acf_page_type_check ) :
						?>
						<?php if ( $acf_page_url_target ) : ?>
							<div class="c-icon c-icon--window"></div>
						<?php else : ?>
							<div class="c-icon c-icon--circle-arrow"></div>
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
			</div>
		<?php else : ?>
			<!-- 通常 -->
			<div class="p-home-hot-topics__item">
				<?php
				// リンクとspanの切り替え.
				if ( 'title_only' === $acf_page_type_check ) :
					?>
				<span class="c-panel-link has-icon">
				<?php else : ?>
				<a class="c-panel-link has-icon" href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php endif; ?>
					<div class="c-panel-link__content">
						<div class="c-panel-link__data">
							<time class="c-panel-link__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
							<?php
							// NEWアイコンの表示.
							if ( $acf_post_has_new ) :
								?>
							<div class="c-icon c-icon--new"></div>
							<?php endif; ?>
						</div>
						<h3 class="c-panel-link__title is-normal"><?php the_title(); ?></h3>
						<p class="c-panel-link__text"><?php echo esc_html( $acf_page_url_name ); ?></p>
					</div>
					<?php
					// アイコンの表示条件分岐.
					if ( empty( $acf_page_type_check ) || 'normal' === $acf_page_type_check || 'link' === $acf_page_type_check ) :
						?>
						<?php if ( $acf_page_url_target ) : ?>
							<div class="c-icon c-icon--window-border"></div>
						<?php else : ?>
							<div class="c-icon c-icon--circle-arrow"></div>
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
			</div>
		<?php endif; ?>
		<?php endwhile; ?>
		</div>
		<?php if ( $hottopics_total_posts > 2 ) : ?>
		<div class="c-button__wrap">
			<button class="js-post-more c-button c-button--round is--secondary is-more">もっと見る・・・<span class="c-icon c-icon--circle-arrow"></span></button>
		</div>
		<?php endif; ?>
	</div>
	<?php
endif;
wp_reset_postdata();

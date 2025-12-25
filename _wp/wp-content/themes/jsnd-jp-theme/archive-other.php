<?php
/**
 * タイプ：カスタム投稿アーカイブ
 * 場所：その他のお知らせ
 *
 * @package jsnd-jp-theme.
 */

// 投稿タイプのラベルを取得.
$post_type_title = get_post_type_object( get_post_type() )->labels->singular_name;

get_header(); ?>

<?php
// パンくずリスト.
get_template_part( 'components/breadcrumb' );
?>

<div class="l-page-header">
	<div class="u-width--primary">
		<h1 class="l-page-header__title"><?php echo esc_html( $post_type_title ); ?></h1>
	</div>
</div>

<?php
/**
 * ページ内容の取得：ループ（メイン）：スタート
 */
// 固定表示対応：全件取得して並び替え.
global $wp_query;
$current_paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$posts_per_page = get_option( 'posts_per_page' ); // 管理画面の表示件数設定を取得.

$args      = array(

	'post_type'      => 'other',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
);
$all_query = new WP_Query( $args );

if ( $all_query->have_posts() ) {
	$fixed_posts  = array();
	$normal_posts = array();

	foreach ( $all_query->posts as $post_item ) {
		if ( get_field( 'acf_post_list_fixed', $post_item->ID ) ) {
			$fixed_posts[] = $post_item;
		} else {
			$normal_posts[] = $post_item;
		}
	}

	$merged_posts = array_merge( $fixed_posts, $normal_posts );

	// ページネーション用に切り出し.
	$total_posts   = count( $merged_posts );
	$max_num_pages = ceil( $total_posts / $posts_per_page );
	$offset        = ( $current_paged - 1 ) * $posts_per_page;
	$current_posts = array_slice( $merged_posts, $offset, $posts_per_page );

	// メインクエリを上書き.
	$wp_query->posts               = $current_posts;
	$wp_query->post_count          = count( $current_posts );
	$wp_query->found_posts         = $total_posts;
	$wp_query->max_num_pages       = $max_num_pages;
	$wp_query->is_paged            = ( $current_paged > 1 );
	$wp_query->query_vars['paged'] = $current_paged;
}

if ( have_posts() ) :
	?>
	<div class="u-width--primary">
		<div class="l-content l-content--2column">
			<section class="l-content--main">
				<ul class="c-news-list">
					<?php
					while ( have_posts() ) :
						the_post();

						// 「ページのタイプ」の条件分岐.
						$acf_page_type_check = get_field( 'acf_page_type_check' );
						if ( is_array( $acf_page_type_check ) && isset( $acf_page_type_check['value'] ) ) {
							$acf_page_type_check = $acf_page_type_check['value'];
						}

						$acf_page_url        = get_field( 'acf_page_url' ); // リンクがある場合.
						$acf_page_url_target = get_field( 'acf_page_url_target' ); // 新しいタブで開くかどうか.
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
				<?php
					// ページネーション.
					get_template_part( 'components/pagination' );
				?>
				<?php
					/**
					 * 固定ページ"other-news-content"の内容を取得
					 */

					// ページ情報を取得.
					$other_news_page = get_page_by_path( 'other-news-content', OBJECT, 'page' );
					// 公開済みの場合のみ表示.
				if ( $other_news_page instanceof WP_Post ) :
					$page_post = $other_news_page;
					setup_postdata( $page_post );
					$other_news_content = apply_filters( 'the_content', $page_post->post_content );
					wp_reset_postdata();
					?>
					<div class="p-page-content u-mt--l">
						<?php echo wp_kses_post( $other_news_content ); ?>
					</div>
				<?php endif; ?>
			</section>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>

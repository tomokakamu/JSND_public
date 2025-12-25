<?php
/**
 * 場所：カスタム投稿
 * 種類：一覧
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
$posts_per_page = get_option( 'posts_per_page' );

$args      = array(
	'post_type'      => 'pastnews',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
);
$all_query = new WP_Query( $args );

if ( $all_query->have_posts() ) {
	$fixed_posts  = array();
	$normal_posts = array();

	foreach ( $all_query->posts as $post_item ) {
		// ACFフィールドの値を取得（グローバル$post変数の影響を避けるため、第2引数を明示）.
		$is_fixed = get_field( 'acf_post_list_fixed', $post_item->ID );

		if ( $is_fixed ) {
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
		<?php
			// 英語用.
		if ( 'en' === $lang ) :
			$content_class = 'l-content';
		else :
			$content_class = 'l-content l-content--2column';
			?>
		<?php endif; ?>
		<div class="<?php echo esc_attr( $content_class ); ?>">
			<section class="l-content--main">
				<ul class="c-information-list">
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
				<?php
					// ページネーション.
					get_template_part( 'components/pagination' );
				?>
			</section>
			<?php
			// 日本語のみサイドバーあり.
			if ( 'ja' === $lang ) {
				get_sidebar();
			}
			?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>

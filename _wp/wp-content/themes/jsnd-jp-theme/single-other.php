<?php
/**
 *
 * 場所：カスタム投稿：その他のお知らせ
 * 種類：記事詳細
 *
 * @package jsnd-jp-theme.
 */

// ACFの設定「ページのタイプ」で条件分岐.
$acf_page_type_check = get_field( 'acf_page_type_check' );

// タイトルのみ、またはリンク付きの場合は一覧に一覧にリダイレクト.
if ( 'title_only' === $acf_page_type_check || 'link' === $acf_page_type_check ) {
	wp_redirect( home_url( '/other/' ) );
	exit;
}

get_header(); ?>

<?php
// パンくずリスト.
get_template_part( 'components/breadcrumb' );
?>

	<?php
	/**
	 * ページ内容の取得：ループ（メイン）：スタート
	 */
	if ( have_posts() ) :

		// 投稿タイプのラベルを取得.
		$post_type_title = get_post_type_object( get_post_type() )->labels->singular_name;
		?>

		<div class="l-page-header">
			<div class="u-width--primary">
				<p class="l-page-header__title"><?php echo esc_html( $post_type_title ); ?></p>
			</div>
		</div>

		<div class="u-width--primary">
			<div class="l-content l-content--2column">
				<section class="p-page-content l-content--main">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<div class="c-post-data">
							<div class="c-post-data__meta">
								<time class="c-post-data__time" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
							</div>
							<h1 class="c-post-data__title"><?php the_title(); ?></h1>
						</div>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</section>
				<?php get_sidebar(); ?>
			</div>
		</div>

	<?php endif; ?>

<?php get_footer(); ?>

<?php
/**
 *
 * 場所：カスタム投稿
 * 種類：記事詳細
 *
 * 英語の分岐：有
 *
 * @package jsnd-jp-theme.
 */

// 現在の言語を取得.
$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';

// ACFの設定「ページのタイプ」で条件分岐.
$acf_page_type_check = get_field( 'acf_page_type_check' );

// タイトルのみ、またはリンク付きの場合は一覧に一覧にリダイレクト.
if ( 'title_only' === $acf_page_type_check || 'link' === $acf_page_type_check ) {
	wp_redirect( home_url( '/pastnews/' ) );
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
				<?php
				// 英語用.
				if ( 'en' === $lang ) :
					?>
					<p class="l-page-header__title">NEWS</p>
					<?php
					// 日本語用.
				else :
					?>
					<p class="l-page-header__title"><?php echo esc_html( $post_type_title ); ?></p>
				<?php endif; ?>
			</div>
		</div>

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
				<section class="p-page-content l-content--main">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<div class="c-post-data">
							<div class="c-post-data__meta">
								<time class="c-post-data__time" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
								<?php
								// カスタムタクソノミー：カテゴリ.
								$tax_cat_terms = get_the_terms( $post->ID, 'pn-category' );
								if ( $tax_cat_terms && ! is_wp_error( $tax_cat_terms ) ) :
									foreach ( $tax_cat_terms as $tax_cat_term ) :
										$tax_cat_name = $tax_cat_term->name; // 名前.
										?>
										<div class="c-post-data__category">
											<span class="c-category"><?php echo esc_html( $tax_cat_name ); ?></span>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<h1 class="c-post-data__title"><?php the_title(); ?></h1>
						</div>
						
						<?php the_content(); ?>
					<?php endwhile; ?>
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

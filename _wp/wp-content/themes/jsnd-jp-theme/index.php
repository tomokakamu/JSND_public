<?php
/**
 *
 * 場所：固定ページ
 * タイトル：お知らせ一覧
 *
 * @package jsnd-jp-theme.
 */

get_header(); ?>

<section class="l-content--page">

<?php
// パンくずリスト.
get_template_part( 'components/breadcrumb' );
?>

	<div class="l-inner l-inner--common">

		<div class="c-title--page">
			<?php
				$queried_object = get_queried_object();
				$page_title     = $queried_object->post_title;
			?>
			<h1 class="c-title--page__text"><?php echo esc_html( $page_title ); ?></h1>
		</div>

	<?php
	/**
	 * ページ内容の取得：ループ（メイン）：スタート
	 */
	if ( have_posts() ) :
		?>
		<ul class="c-list--post">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<li class="c-list--post__item">
				<a href="<?php the_permalink(); ?>">
					<time class="c-list--post__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
				<?php
				$category = get_the_category();
				$cat_name = $category[0]->cat_name; // カテゴリー名.
				$cat_slug = $category[0]->category_nicename; // カテゴリースラッグ.
				?>
					<div class="c-list--post__category">
						<div class="c-icon--category <?php echo esc_html( $cat_slug ); ?>"><?php echo esc_html( $cat_name ); ?></div>
					</div>
					<p class="c-list--post__title"><?php the_title(); ?></p>
					<div class="c-icon--arrow"></div>
				</a>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php
			// ナビゲーションボタン.
			get_template_part( 'components/pagination' );
		?>
				<?php else : ?>
	<?php endif; ?>

	</div>
	<!-- / .inner-common -->

</section>

<?php get_footer(); ?>

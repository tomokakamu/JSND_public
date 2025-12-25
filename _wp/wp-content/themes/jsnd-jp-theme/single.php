<?php
/**
 *
 * 場所：投稿
 * 種類：記事詳細
 *
 * @package jsnd-jp-theme.
 */

get_header(); ?>

<section class="l-content--page">

<?php
	// パンくずリスト.
	get_template_part( 'components/breadcrumb' );
?>
<div class="l-inner l-inner--s">

	<?php // 投稿のループ. ?>
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();

			// カテゴリーの情報取得.
			$category = get_the_category();
			$cat_name = $category[0]->cat_name; // カテゴリー名.
			$cat_slug = $category[0]->category_nicename; // カテゴリースラッグ.

			?>
			<div class="p-title--page">
				<h1 class="c-title--page"><?php the_title(); ?></h1>
			</div>
			<time class="c-list--post__date" datetime="<?php the_time( 'Y-m-d' ); ?>">Date:<?php the_time( 'Y.m.d' ); ?></time>
			<div class="c-icon--category <?php echo esc_html( $cat_slug ); ?>"><?php echo esc_html( $cat_name ); ?></div>
			<div class="p-post-content">
				<?php the_content(); ?>
			</div>
			<?php
			// タグの情報取得.
			$post_tags = get_the_tags();
			// $count     = count( $post_tags );
			if ( $post_tags ) {
				echo '<div>';
				foreach ( $post_tags as $tag ) { // phpcs:ignore
					echo '<span>' . esc_html( $tag->name ) . '</span>';
				}
				echo '</div>';
			}
			?>
			<?php endwhile; ?>

			<?php
			// ナビゲーションボタン.
			get_template_part( 'components/post-prev-next' );
			?>

	<?php endif; ?>

	<?php get_sidebar(); ?>

	</div>
	<!-- / .inner-common -->

</section>

<?php get_footer(); ?>

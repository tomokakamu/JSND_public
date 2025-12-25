<?php
/**
 *
 * 場所：固定ページ：共通
 *
 * @package jsnd-jp-theme.
 */

get_header(); ?>

<?php
// パンくずリスト.
get_template_part( 'components/breadcrumb' );
?>
<?php
/**
 * ページ内容の取得：メインループ：スタート
 */
if ( have_posts() ) :

	$acf_custom_page_title = get_field( 'acf_custom_page_title' );
	?>
	<div class="l-page-header">
		<div class="u-width--primary">
			<?php if ( $acf_custom_page_title ) : ?>
				<h1 class="l-page-header__title"><?php echo esc_html( $acf_custom_page_title ); ?></h1>
			<?php else : ?>
			<h1 class="l-page-header__title"><?php the_title(); ?></h1>
			<?php endif; ?>
		</div>
	</div>
	<div class="u-width--primary">
		<div class="l-content l-content--2column">
			<section class="p-page-content l-content--main">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</section>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>

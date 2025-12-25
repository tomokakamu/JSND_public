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
				<div class="p-sitemap">
					<?php
					// ナビゲーション.
					$args = array(
						'theme_location' => 'header-menu',
						'menu_class'     => 'js-navigation p-sitemap__list',
						'container'      => 'nav',
						// 'container_class' => '',
					);
					wp_nav_menu( $args );
					?>
					<?php // ここからカスタム投稿アーカイブ、"pastnews"と"other"を取得. ?>
					<?php
					$custom_post_types = array( 'other','pastnews' );
					$archive_links     = array();

					foreach ( $custom_post_types as $post_type ) {
						$post_type_object = get_post_type_object( $post_type );
						if ( $post_type_object && $post_type_object->has_archive ) {
							$archive_links[] = array(
								'url'   => get_post_type_archive_link( $post_type ),
								'title' => $post_type_object->labels->name,
							);
						}
					}

					if ( ! empty( $archive_links ) ) :
						?>
						<div class="p-sitemap--archives">
							<ul class="sub-menu">
								<?php foreach ( $archive_links as $archive ) : ?>
									<li class="menu-item">
										<a href="<?php echo esc_url( $archive['url'] ); ?>">
											<?php echo esc_html( $archive['title'] ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<?php // ここから固定ページから取得. ?>
					<?php
					$menu_locations = get_nav_menu_locations();
					$header_menu_id = isset( $menu_locations['header-menu'] ) ? (int) $menu_locations['header-menu'] : 0;
					$menu_page_ids  = array();

					if ( $header_menu_id > 0 ) {
						$menu_items = wp_get_nav_menu_items( $header_menu_id );
						if ( $menu_items ) {
							foreach ( $menu_items as $menu_item ) {
								if ( 'page' === $menu_item->object && ! empty( $menu_item->object_id ) ) {
									$id              = (int) $menu_item->object_id;
									$menu_page_ids[] = $id;
								}
							}
						}
					}

					$menu_page_ids = array_unique( array_filter( $menu_page_ids ) );

					$unlisted_pages = get_pages(
						array(
							'post_type'   => 'page',
							'exclude'     => $menu_page_ids,
							'post_status' => 'publish',
							'sort_column' => 'menu_order,post_title',
							'sort_order'  => 'ASC',
						)
					);

					// スラッグ "sitemap" のページを除外.
					if ( $unlisted_pages ) {
						$unlisted_pages = array_filter(
							$unlisted_pages,
							function ( $page ) {
								return 'sitemap' !== $page->post_name;
							}
						);
					}

					if ( $unlisted_pages ) :
						// 親がナビゲーションに含まれる場合はトップ階層扱いでまとめる.
						$unlisted_map      = array();
						$pages_by_parent   = array();
						$root_parent_id    = 0;
						$root_parent_items = array();

						foreach ( $unlisted_pages as $page ) {
							$unlisted_map[ $page->ID ] = true;
						}

						foreach ( $unlisted_pages as $page ) {
							$parent_id = (int) $page->post_parent;
							if ( ! isset( $unlisted_map[ $parent_id ] ) ) {
								$parent_id = $root_parent_id;
							}

							if ( ! isset( $pages_by_parent[ $parent_id ] ) ) {
								$pages_by_parent[ $parent_id ] = array();
							}

							$pages_by_parent[ $parent_id ][] = $page;
						}

						$root_parent_items = isset( $pages_by_parent[ $root_parent_id ] ) ? $pages_by_parent[ $root_parent_id ] : array();
						?>
						<div class="p-sitemap--pages">
							<ul class="sub-menu">
								<?php foreach ( $root_parent_items as $page ) : ?>
									<li class="menu-item">
										<a href="<?php echo esc_url( get_permalink( $page ) ); ?>">
											<?php echo esc_html( get_the_title( $page ) ); ?>
										</a>
										<?php if ( isset( $pages_by_parent[ $page->ID ] ) && $pages_by_parent[ $page->ID ] ) : ?>
											<ul class="sub-menu">
												<?php foreach ( $pages_by_parent[ $page->ID ] as $child_page ) : ?>
													<li class="menu-item">
														<a href="<?php echo esc_url( get_permalink( $child_page ) ); ?>">
															<?php echo esc_html( get_the_title( $child_page ) ); ?>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			</section>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>

<?php
/**
 *
 * 固定ページのリスト（固定ページ階層から取得）
 * 場所：sidebar.php
 *
 * @package jsnd-jp-theme.
 */

if ( ! is_page() ) {
	return;
}

global $post;

if ( ! $post instanceof WP_Post ) {
	return;
}

$current_page_id = (int) $post->ID;

// 見出しに使う親ページを取得.
$parent_page = null;

if ( 0 !== (int) $post->post_parent ) {
	$parent_page = get_post( $post->post_parent );
}

if ( ! $parent_page instanceof WP_Post ) {
	$parent_page = $post;
}

$parent_title = get_the_title( $parent_page );
$parent_link  = get_permalink( $parent_page );

// 親ページ直下の子ページを取得.
$child_pages = get_posts(
	array(
		'post_type'      => 'page',
		'post_parent'    => $parent_page->ID,
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => array( 'publish', 'private' ),
	)
);

$show_root_item      = 0 !== (int) $post->post_parent && 0 === (int) $parent_page->post_parent;
$prepend_parent_item = $show_root_item || 0 === (int) $post->post_parent;

?>
<div class="c-sidebar__item">
	<h2 class="c-sidebar-page-list__title"><?php echo esc_html( $parent_title ); ?></h2>
	<ul class="c-sidebar-page-list">
		<?php if ( $prepend_parent_item ) : ?>
			<?php
			$parent_item_classes = 'c-sidebar-page-list__item';
			if ( (int) $parent_page->ID === $current_page_id ) {
				$parent_item_classes .= ' is-current';
			}
			?>
			<li class="<?php echo esc_attr( $parent_item_classes ); ?>">
				<a href="<?php echo esc_url( $parent_link ); ?>">
					<?php echo esc_html( $parent_title ); ?>
					<span class="c-icon c-icon--circle-arrow"></span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ( empty( $child_pages ) ) : ?>
			<?php if ( ! $prepend_parent_item ) : ?>
				<?php
				$parent_classes = 'c-sidebar-page-list__item';
				if ( (int) $parent_page->ID === $current_page_id ) {
					$parent_classes .= ' is-current';
				}
				?>
				<li class="<?php echo esc_attr( $parent_classes ); ?>">
					<a href="<?php echo esc_url( $parent_link ); ?>">
						<?php echo esc_html( $parent_title ); ?>
						<span class="c-icon c-icon--circle-arrow"></span>
					</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>
		<?php foreach ( $child_pages as $child_page ) : ?>
			<?php
			$item_classes = 'c-sidebar-page-list__item';

			if ( (int) $child_page->ID === $current_page_id ) {
				$item_classes .= ' is-current';
			}
			?>
			<li class="<?php echo esc_attr( $item_classes ); ?>">
				<a href="<?php echo esc_url( get_permalink( $child_page ) ); ?>">
					<?php echo esc_html( get_the_title( $child_page ) ); ?>
					<span class="c-icon c-icon--circle-arrow"></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

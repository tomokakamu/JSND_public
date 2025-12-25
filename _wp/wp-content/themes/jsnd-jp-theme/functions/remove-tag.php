<?php
/**
 * 不要なタグの削除
 *
 * @package jsnd-jp-theme.
 */

// RSSフィードのURL.
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

// 絵文字.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles', 10 );

// 外部ブログツールからの投稿を受け入れ.
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

// バージョン表記.
remove_action( 'wp_head', 'wp_generator' );

// 短縮URL.
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// REST APIのURL表示.
remove_action( 'wp_head', 'rest_output_link_wp_head' );

// oEmbed.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

/**
 * <body>のclassで不要なものを削除.
 *
 * @param string $wp_classes class_list.
 * @param string $extra_classes class_list.
 */
function _remove_body_class( $wp_classes, $extra_classes ) {
	// templateが付いているclass名か数字が付いているclass名をまとめて削除.
	$wp_classes = preg_grep( '/template|\d/', $wp_classes, PREG_GREP_INVERT );
	return array_merge( $wp_classes, (array) $extra_classes );
}
add_filter( 'body_class', '_remove_body_class', 10, 2 );

/**
 * 固定ページにbodyのclassにスラッグを入れる.
 *
 * @param string $classes class_name.
 */
function add_page_slug_class_name( $classes ) {
	if ( is_page() ) {
		$page      = get_post( get_the_ID() );
		$classes[] = $page->post_name;
		$parent_id = $page->post_parent;
		if ( 0 === $parent_id ) {
			$classes[] = get_post( $parent_id )->post_name;
		} else {
			$page_parent_name = get_ancestors( $page->ID, 'page', 'post_type' );
			$progenitor_id    = array_pop( $page_parent_name );
			$classes[]        = get_post( $progenitor_id )->post_name . '-child';
		}
	}
	return $classes;
}
add_filter( 'body_class', 'add_page_slug_class_name' );

// アーカイブのタイトルの調整.
add_filter(
	'get_the_archive_title',
	function ( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false ); // カテゴリー：を消す.
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );  // タグ：を消す.
		} elseif ( is_date() ) {
			$title = get_the_time( 'Y年' );  // 月：を消す.
		}
		return $title;
	}
);

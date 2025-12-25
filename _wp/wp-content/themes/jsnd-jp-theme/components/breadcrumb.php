<?php
/**
 *
 * パンくずリスト
 * 場所：トップ以外
 *
 * @package jsnd-jp-theme.
 */

if ( ! function_exists( 'jsnd_get_posts_page_data' ) ) {
	/**
	 * 投稿一覧ページの情報を取得する.
	 *
	 * @return array
	 */
	function jsnd_get_posts_page_data() {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		$posts_page    = $posts_page_id ? get_post( $posts_page_id ) : get_page_by_path( 'news' );

		if ( $posts_page instanceof WP_Post ) {
			return array(
				'title' => $posts_page->post_title,
				'url'   => get_permalink( $posts_page ),
			);
		}

		return array(
			'title' => '',
			'url'   => '',
		);
	}
}

if ( ! function_exists( 'jsnd_render_breadcrumb_item' ) ) {
	/**
	 * パンくずの1項目を出力する.
	 *
	 * @param string $url      リンクURL.
	 * @param string $label    表示ラベル.
	 * @param int    $position 階層位置.
	 *
	 * @return void
	 */
	function jsnd_render_breadcrumb_item( $url, $label, $position ) {
		if ( '' === $label ) {
			return;
		}
		?>
			<li class="c-breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a itemprop="item" href="<?php echo esc_url( $url ); ?>">
					<span itemprop="name"><?php echo esc_html( $label ); ?></span>
				</a>
				<meta itemprop="position" content="<?php echo esc_attr( $position ); ?>" />
			</li>
		<?php
	}
}

if ( ! function_exists( 'jsnd_collect_breadcrumb_items' ) ) {
	/**
	 * パンくず配列を組み立てる.
	 *
	 * @param string $posts_page_title 投稿一覧タイトル.
	 * @param string $posts_page_url   投稿一覧URL.
	 *
	 * @return array
	 */
	function jsnd_collect_breadcrumb_items( $posts_page_title, $posts_page_url ) {
		$breadcrumbs = array();

		// Polylangの現在の言語を取得.
		$current_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ja';
		$home_label   = ( 'en' === $current_lang ) ? 'HOME' : 'ホーム';

		$breadcrumbs[] = array(
			'url'   => home_url( '/' ),
			'label' => $home_label,
		);

		$custom_post_types = array( 'pastnews', 'other', 'hot-topics' );

		if ( is_singular( $custom_post_types ) ) {
			$post_type     = get_post_type();
			$post_type_obj = $post_type ? get_post_type_object( $post_type ) : null;
			$page_slug     = $post_type_obj ? $post_type_obj->name : '';
			$page_title    = $post_type_obj ? $post_type_obj->label : '';
			$archive_url   = $page_slug ? get_post_type_archive_link( $page_slug ) : '';

			if ( ! $archive_url && $page_slug ) {
				$archive_url = home_url( '/' . $page_slug . '/' );
			}

			// 特殊対応：hot-topicsの場合はトップの#hot-topicsへリンク.
			if ( 'hot-topics' === $post_type ) {
				$archive_url = home_url( '/#hot-topics' );
			}

			if ( $page_title && $archive_url ) {
				$breadcrumbs[] = array(
					'url'   => $archive_url,
					'label' => $page_title,
				);
			}

			$breadcrumbs[] = array(
				'url'   => get_permalink(),
				'label' => get_the_title(),
			);
		} elseif ( is_post_type_archive( $custom_post_types ) ) {
			$post_type = get_post_type();

			if ( ! $post_type ) {
				$post_type = get_query_var( 'post_type' );

				if ( is_array( $post_type ) ) {
					$post_type = reset( $post_type );
				}
			}

			$post_type_obj = $post_type ? get_post_type_object( $post_type ) : null;
			$archive_url   = $post_type_obj ? get_post_type_archive_link( $post_type_obj->name ) : '';
			$page_title    = $post_type_obj ? $post_type_obj->label : '';

			if ( ! $archive_url && $post_type_obj ) {
				$archive_url = home_url( '/' . $post_type_obj->name . '/' );
			}

			if ( $page_title && $archive_url ) {
				$breadcrumbs[] = array(
					'url'   => $archive_url,
					'label' => $page_title,
				);
			}
		} elseif ( is_home() && $posts_page_title ) {
			$breadcrumbs[] = array(
				'url'   => $posts_page_url,
				'label' => $posts_page_title,
			);
		} elseif ( is_page() ) {
			global $post;

			if ( $post instanceof WP_Post ) {
				$ancestors = get_post_ancestors( $post->ID );
				$ancestors = array_reverse( $ancestors );

				foreach ( $ancestors as $ancestor_id ) {
					$breadcrumbs[] = array(
						'url'   => get_permalink( $ancestor_id ),
						'label' => get_the_title( $ancestor_id ),
					);
				}

				$breadcrumbs[] = array(
					'url'   => get_permalink( $post->ID ),
					'label' => get_the_title( $post->ID ),
				);
			}
		} elseif ( is_single() ) {
			if ( $posts_page_title && $posts_page_url ) {
				$breadcrumbs[] = array(
					'url'   => $posts_page_url,
					'label' => $posts_page_title,
				);
			}

			$breadcrumbs[] = array(
				'url'   => get_permalink(),
				'label' => get_the_title(),
			);
		} elseif ( is_archive() ) {
			if ( $posts_page_title && $posts_page_url ) {
				$breadcrumbs[] = array(
					'url'   => $posts_page_url,
					'label' => $posts_page_title,
				);
			}

			$archive_label = get_the_archive_title();
			$current_url   = '';
			$queried       = get_queried_object();

			if ( $queried instanceof WP_Term ) {
				$term_link = get_term_link( $queried );

				if ( ! is_wp_error( $term_link ) ) {
					$current_url = $term_link;
				}

				$archive_label = $queried->name;
			} elseif ( is_post_type_archive() ) {
				$post_type_obj = get_post_type_object( get_post_type() );

				if ( $post_type_obj ) {
					$current_url   = get_post_type_archive_link( $post_type_obj->name );
					$archive_label = $post_type_obj->label;
				}
			}

			if ( ! $current_url && ! empty( $_SERVER['REQUEST_URI'] ) ) {
				$request_uri = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
				$current_url = home_url( $request_uri );
			}

			if ( $archive_label ) {
				$breadcrumbs[] = array(
					'url'   => $current_url,
					'label' => $archive_label,
				);
			}
		}

		return $breadcrumbs;
	}
}

$posts_page_data  = jsnd_get_posts_page_data();
$posts_page_title = $posts_page_data['title'];
$posts_page_url   = $posts_page_data['url'];
$breadcrumbs      = jsnd_collect_breadcrumb_items( $posts_page_title, $posts_page_url );
?>
<div class="c-breadcrumb">
	<div class="c-breadcrumb__wrapper u-width--primary">
		<ol class="c-breadcrumb__list" itemscope itemtype="https://schema.org/BreadcrumbList">
			<?php foreach ( $breadcrumbs as $index => $breadcrumb ) : ?>
				<?php jsnd_render_breadcrumb_item( $breadcrumb['url'], $breadcrumb['label'], $index + 1 ); ?>
			<?php endforeach; ?>
		</ol>
	</div>
</div>

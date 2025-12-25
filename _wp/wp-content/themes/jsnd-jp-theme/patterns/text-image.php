<?php
/**
 * Title: テキスト＋画像レイアウト
 * Slug: jsnd-jp-theme/text-image
 * Categories: jsnd-components
 * Keywords: テキスト, 画像, レイアウト
 * Viewport Width: 1200
 */
?>
<!-- wp:group {"className":"p-text-image","layout":{"type":"constrained"}} -->
<div class="wp-block-group p-text-image">
	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"p-text-image__image is--right"} -->
	<figure class="wp-block-image size-full p-text-image__image is--right"><img src="<?php echo esc_url( get_template_directory_uri() . '/dist/assets/no-image-admin.png' ); ?>" alt=""/></figure>
	<!-- /wp:image -->

	<!-- wp:group {"className":"p-text-image__text","layout":{"type":"constrained"}} -->
	<div class="wp-block-group p-text-image__text">
		<!-- wp:paragraph -->
		<p>テキストを入力してください</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

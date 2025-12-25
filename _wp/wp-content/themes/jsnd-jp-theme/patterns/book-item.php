<?php
/**
 * Title: 書籍レイアウト
 * Slug: jsnd-jp-theme/book-item
 * Categories: jsnd-components
 * Keywords: 書籍, レイアウト, ボタン
 * Viewport Width: 1200
 */
?>
<!-- wp:group {"className":"p-book-item","layout":{"type":"constrained"}} -->
<div class="wp-block-group p-book-item">
	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"p-book-item__image"} -->
	<figure class="wp-block-image size-full p-book-item__image"><img alt=""/></figure>
	<!-- /wp:image -->

	<!-- wp:group {"className":"p-book-item__body","layout":{"type":"constrained"}} -->
	<div class="wp-block-group p-book-item__body">
		<!-- wp:heading {"level":3,"className":"p-book-item__title"} -->
		<h3 class="wp-block-heading p-book-item__title">ここにテキストが入ります。</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"small"} -->
		<p class="has-sm-font-size">ここにテキストが入ります。</p>
		<!-- /wp:paragraph -->

		<!-- wp:button {"className":"is-style-normal"} -->
		<div class="wp-block-button is-style-normal"><a class="wp-block-button__link wp-element-button" href="#">購入する</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

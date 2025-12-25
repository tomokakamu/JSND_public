<?php
/**
 * Title: 書籍レイアウト（詳細）
 * Slug: jsnd-jp-theme/book-item-large
 * Categories: jsnd-components
 * Keywords: 書籍, レイアウト, テーブル
 * Viewport Width: 1200
 */
?>
<!-- wp:group {"className":"p-book-item","layout":{"type":"constrained"}} -->
<div class="wp-block-group p-book-item is--large">
	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"p-book-item__image"} -->
	<figure class="wp-block-image size-full p-book-item__image"><img alt=""/></figure>
	<!-- /wp:image -->

	<!-- wp:group {"className":"p-book-item__body","layout":{"type":"constrained"}} -->
	<div class="wp-block-group p-book-item__body">
		
		<!-- wp:paragraph {"fontSize":"small"} -->
		<p class="has-sm-font-size">ここにテキストが入ります。</p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"className":"p-background is--gray","layout":{"type":"constrained"}} -->
		<div class="wp-block-group p-background is--gray">
			<!-- wp:group {"className":"p-book-item__meta","layout":{"type":"constrained"}} -->
			<div class="wp-block-group p-book-item__meta">
				<!-- wp:group {"className":"p-book-item__meta-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"flex-start","alignItems":"flex-start"}} -->
				<div class="wp-block-group p-book-item__meta-row">
					<!-- wp:paragraph {"className":"p-book-item__meta-label"} -->
					<p class="p-book-item__meta-label">項目</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"p-book-item__meta-value"} -->
					<p class="p-book-item__meta-value">内容</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:button {"className":"is-style-normal"} -->
		<div class="wp-block-button is-style-normal"><a class="wp-block-button__link wp-element-button" href="#">購入する</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

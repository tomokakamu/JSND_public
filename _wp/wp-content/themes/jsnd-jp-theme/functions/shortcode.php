<?php
/**
 *
 * ショートコード
 *
 * @package jsnd-jp-theme.
 */

/**
 * テンプレートURL
 * 使い方：[template_url]
 */
function shortcode_templateurl() {
	return get_bloginfo( 'template_url' );
}
add_shortcode( 'template_url', 'shortcode_templateurl' );

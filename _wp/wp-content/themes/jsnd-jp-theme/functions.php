<?php
/**
 * 設定一覧：Functions.php
 *
 * @package jsnd-jp-theme.
 */

/**
 * -------------------------------------------------------------
 * サイトの表示に関するもの
 * -------------------------------------------------------------
 */


// 不要なタグの削除.
require get_template_directory() . '/functions/remove-tag.php';

// webフォント.
require get_template_directory() . '/functions/font.php';

// CSSとJSの読み込み.
require get_template_directory() . '/functions/css.php';
require get_template_directory() . '/functions/js.php';
// アセットヘルパー（dist の最適化済み画像を優先参照）.
require get_template_directory() . '/functions/assets.php';

// ナビゲーション.
require get_template_directory() . '/functions/navigation.php';

/**
 * --------------------------------------------------------------
 * 管理画面に関するもの
 * --------------------------------------------------------------
 */

// 管理画面の設定.
require get_template_directory() . '/functions/admin-settings.php';

// グーテンベルグ関連設定.
require get_template_directory() . '/functions/gutenberg-settings.php';

// ブロックパターン.
require get_template_directory() . '/functions/block-patterns.php';

// ショートコード.
require get_template_directory() . '/functions/shortcode.php';

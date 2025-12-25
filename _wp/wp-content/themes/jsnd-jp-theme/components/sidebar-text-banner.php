<?php
/**
 *
 * バナー：シンプルver
 * 場所：sidebar.php
 *
 * @package jsnd-jp-theme.
 */

?>
<?php
// ナビゲーション.
$args = array(
	'theme_location' => 'sidebar-text-banner',
	'menu_class'     => 'c-sidebar-text-banner',
	// 'container'       => 'nav',
	// 'container_class' => '',
);
wp_nav_menu( $args );

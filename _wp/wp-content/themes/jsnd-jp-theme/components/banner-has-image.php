<?php
/**
 *
 * 固定ページのリスト
 * 場所：sidebar.php
 *
 * @package jsnd-jp-theme.
 */


// PDFファイルのキャッシュ対策：filemtimeをクエリパラメータに追加.
$pdf_url = home_url( '/' ) . 'pdf/nyukai_leaflet.pdf';

// ABSPATHは wp ディレクトリまでなので、その親ディレクトリを取得.
$pdf_path = dirname( ABSPATH ) . '/pdf/nyukai_leaflet.pdf';

if ( file_exists( $pdf_path ) ) {
	$mtime   = filemtime( $pdf_path );
	$pdf_url = add_query_arg( 'v', $mtime, $pdf_url );
}

?>
<ul class="c-sidebar-banner-has-image">
	<li class="c-sidebar-banner-has-image__item">
		<a href="<?php echo esc_url( $pdf_url ); ?>" target="_blank" rel="noopener noreferrer">
			<div class="c-sidebar-banner-has-image__image">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/banner-gakkai_sidebar.png" alt="">
			</div>
			<div class="c-sidebar-banner-has-image__text">
				<span>学会リーフレット</span>
				<span class="c-icon c-icon--pdf is-white"></span>
			</div>
		</a>
	</li>
	<li class="c-sidebar-banner-has-image__item">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>shokai/">
			<div class="c-sidebar-banner-has-image__image">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/banner-movie_sidebar.jpg" alt="">
			</div>
			<div class="c-sidebar-banner-has-image__text">
				<span>
					<span class="c-sidebar-banner-has-image__badge">学生会員・若手会員向け</span>
					動画シリーズ
				</span>
				<span class="c-icon c-icon--circle-arrow"></span>
			</div>
		</a>
	</li>
	<li class="c-sidebar-banner-has-image__item">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>seibunhyo/">
			<div class="c-sidebar-banner-has-image__image">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/banner-seibun_sidebar.jpg" alt="">
			</div>
			<div class="c-sidebar-banner-has-image__text">
				<span>正しく使おう成分表</span>
				<span class="c-icon c-icon--circle-arrow"></span>
			</div>
		</a>
	</li>
	<li class="c-sidebar-banner-has-image__item">
		<?php
			/*
			1/30からリンクが変更
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>nyukaiannnai/">
			<div class="c-sidebar-banner-has-image__image">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/banner-nyukai_sidebar.jpg" alt="">
			</div>
			<div class="c-sidebar-banner-has-image__text">
				<span>入会案内</span>
				<span class="c-icon c-icon--circle-arrow"></span>
			</div>
		</a>
			*/
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>nyukai2/">
			<div class="c-sidebar-banner-has-image__image">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/assets/banner-nyukai_sidebar.jpg" alt="">
			</div>
			<div class="c-sidebar-banner-has-image__text">
				<span>入会案内</span>
				<span class="c-icon c-icon--circle-arrow"></span>
			</div>
		</a>
	</li>
</ul>

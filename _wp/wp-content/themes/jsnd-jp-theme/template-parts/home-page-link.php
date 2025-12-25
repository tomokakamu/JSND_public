<?php
/**
 * 場所：トップページ
 * 種類：パーツ（画像付きページリンク）
 *
 * @package jsnd-jp-theme.
 */

if ( have_rows( 'acf_top_banner_repeater' ) ) :
	?>
	<div class="p-home-page-link">
		<div class="u-width--primary">
			<ul class="p-home-page-link__list">
			<?php
			while ( have_rows( 'acf_top_banner_repeater' ) ) :
				the_row();
				$image        = get_sub_field( 'image' );
				$banner_title = get_sub_field( 'title' );
				$url          = get_sub_field( 'url' );

				$image_markup = '';

				if ( is_array( $image ) && ! empty( $image['url'] ) ) {
					$img_src    = $image['url'];
					$img_alt    = isset( $image['alt'] ) ? $image['alt'] : '';
					$img_width  = isset( $image['width'] ) ? (int) $image['width'] : '';
					$img_height = isset( $image['height'] ) ? (int) $image['height'] : '';

					$image_markup  = '<img src="' . esc_url( $img_src ) . '"';
					$image_markup .= ' alt="' . esc_attr( $img_alt ) . '"';
					if ( $img_width ) {
						$image_markup .= ' width="' . esc_attr( $img_width ) . '"';
					}
					if ( $img_height ) {
						$image_markup .= ' height="' . esc_attr( $img_height ) . '"';
					}
					$image_markup .= ' loading="lazy">';
				} elseif ( is_numeric( $image ) ) {
					$image_markup = wp_get_attachment_image(
						(int) $image,
						'full',
						false,
						array(
							'loading' => 'lazy',
						)
					);
				} elseif ( is_string( $image ) && '' !== trim( $image ) ) {
					$image_markup = '<img src="' . esc_url( $image ) . '" alt="" loading="lazy">';
				}

				$icon_class  = 'c-icon--circle-arrow';
				$target_attr = '';
				$final_url   = $url;

				if ( preg_match( '/\\.pdf$/i', $url ) ) {
					$icon_class  = 'c-icon--pdf';
					$target_attr = ' target="_blank" rel="noopener noreferrer"';

					// PDFファイルのキャッシュ対策：filemtimeをクエリパラメータに追加.
					$parsed_url  = wp_parse_url( $url );
					$home_parsed = wp_parse_url( home_url() );

					// サイト内のURLまたは相対パスの場合.
					if ( ! isset( $parsed_url['host'] ) || ( isset( $parsed_url['host'] ) && $parsed_url['host'] === $home_parsed['host'] ) ) {
						// URLパスからファイルパスを構築.
						if ( isset( $parsed_url['path'] ) ) {
							// home_url のパス部分を除去して相対パスを取得.
							$relative_path = isset( $home_parsed['path'] ) ? str_replace( $home_parsed['path'], '', $parsed_url['path'] ) : $parsed_url['path'];
							// ABSPATHの親ディレクトリからファイルパスを構築.
							$file_path = dirname( ABSPATH ) . '/' . ltrim( $relative_path, '/' );

							// ファイルが存在する場合、filemtimeを追加.
							if ( file_exists( $file_path ) ) {
								$mtime     = filemtime( $file_path );
								$final_url = add_query_arg( 'v', $mtime, $url );
							}
						}
					}
				}
				?>
				<li class="p-home-page-link__item">
					<a href="<?php echo esc_url( $final_url ); ?>"<?php echo $target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<div class="p-home-page-link__image">
							<?php echo $image_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="p-home-page-link__title">
							<span class="p-home-page-link__text"><?php echo esc_html( $banner_title ); ?></span>
							<div class="c-icon <?php echo esc_attr( $icon_class ); ?>"></div>
						</div>
					</a>
				</li>
			<?php endwhile; ?>
			</ul>
		</div>
	</div>
	<?php endif; ?>

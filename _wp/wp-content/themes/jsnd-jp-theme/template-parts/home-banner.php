<?php
/**
 * 場所：トップページ
 * 種類：パーツ（バナーセクション）
 *
 * @package jsnd-jp-theme.
 */

if ( have_rows( 'acf_front_page_banner' ) ) : ?>
	<div class="p-home-banner">
		<div class="u-width--primary">
			<ul class="p-home-banner__list">
				<?php
				while ( have_rows( 'acf_front_page_banner' ) ) :
					the_row();
					$image        = get_sub_field( 'image' );
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

					if ( '' === $image_markup ) {
						continue;
					}

					$link_url    = $url ? esc_url( $url ) : '';
					$link_target = get_sub_field( 'target' );
					$target_attr = '';

					if ( is_string( $link_target ) ) {
						$link_target = trim( $link_target );
					}

					if ( true === $link_target || '1' === $link_target || 1 === $link_target || 'true' === strtolower( (string) $link_target ) ) {
						$target_attr = ' target="_blank" rel="noopener noreferrer"';
					}
					?>
					<li class="p-home-banner__item">
						<?php if ( $link_url ) : ?>
							<a href="<?php echo $link_url; ?>"<?php echo $target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
								<?php echo $image_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php else : ?>
							<span class="p-front-page__banner-image">
								<?php echo $image_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						<?php endif; ?>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>

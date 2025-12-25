<?php
/**
 * 場所：トップページのキービジュアル
 * 種類：パーツ
 *
 * @package jsnd-jp-theme.
 */

if ( have_rows( 'acf_front_page_slider' ) ) : ?>
	<div class="p-home-kv">
		<div class="u-width--primary">
			<div id="js-front-page-slider">
				<div class="swiper">
					<div class="swiper-wrapper">
						<?php
						while ( have_rows( 'acf_front_page_slider' ) ) :
							the_row();
							$slide_image  = get_sub_field( 'image' );
							$slide_url    = get_sub_field( 'url' );
							$slide_target = get_sub_field( 'target' );
							$slide_markup = '';

							if ( is_array( $slide_image ) && ! empty( $slide_image['url'] ) ) {
								$img_src    = $slide_image['url'];
								$img_alt    = isset( $slide_image['alt'] ) ? $slide_image['alt'] : '';
								$img_width  = isset( $slide_image['width'] ) ? (int) $slide_image['width'] : '';
								$img_height = isset( $slide_image['height'] ) ? (int) $slide_image['height'] : '';

								$slide_markup  = '<img src="' . esc_url( $img_src ) . '"';
								$slide_markup .= ' alt="' . esc_attr( $img_alt ) . '"';
								if ( $img_width ) {
									$slide_markup .= ' width="' . esc_attr( $img_width ) . '"';
								}
								if ( $img_height ) {
									$slide_markup .= ' height="' . esc_attr( $img_height ) . '"';
								}
								$slide_markup .= ' loading="lazy">';
							} elseif ( is_numeric( $slide_image ) ) {
								$slide_markup = wp_get_attachment_image(
									(int) $slide_image,
									'full',
									false,
									array(
										'loading' => 'lazy',
									)
								);
							} elseif ( is_string( $slide_image ) && '' !== trim( $slide_image ) ) {
								$slide_markup = '<img src="' . esc_url( $slide_image ) . '" alt="" loading="lazy">';
							}

							if ( '' === $slide_markup ) {
								continue;
							}

							$slide_link  = $slide_url ? esc_url( $slide_url ) : '';
							$target_attr = '';

							if ( is_string( $slide_target ) ) {
								$slide_target = trim( $slide_target );
							}

							if ( true === $slide_target || '1' === $slide_target || 1 === $slide_target || 'true' === strtolower( (string) $slide_target ) ) {
								$target_attr = ' target="_blank" rel="noopener noreferrer"';
							}
							?>
							<div class="swiper-slide">
								<?php if ( $slide_link ) : ?>
									<a href="<?php echo $slide_link; ?>"<?php echo $target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php echo $slide_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</a>
								<?php else : ?>
									<?php echo $slide_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php endif; ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<div class="p-home-kv__controls">
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>
<?php endif; ?>

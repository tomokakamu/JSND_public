<?php
/**
 * 場所：トップページ
 * 種類：パーツ（ページリンク）
 *
 * @package jsnd-jp-theme.
 */

if ( have_rows( 'acf_top_page_repeater' ) ) :
	?>
	<div class="p-home-about">
		<ul class="c-panel-link__list p-home-about__list">
			<?php
			while ( have_rows( 'acf_top_page_repeater' ) ) :
				the_row();
				$acf_top_page_title   = get_sub_field( 'acf_top_page_title' );
				$acf_top_page_content = get_sub_field( 'acf_top_page_content' );
				$acf_top_page_url     = get_sub_field( 'acf_top_page_url' );
				?>
				<li class="c-panel-link__item">
					<a class="c-panel-link" href="<?php echo esc_url( $acf_top_page_url ); ?>">
						<h3 class="c-panel-link__title has-icon"><?php echo esc_html( $acf_top_page_title ); ?><span class="c-icon c-icon--circle-arrow"></span></h3>
						<?php if ( $acf_top_page_content ) : ?>
						<p class="c-panel-link__text"><?php echo wp_kses_post( $acf_top_page_content ); ?></p>
						<?php endif; ?>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php endif; ?>

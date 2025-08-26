<?php
/**
 * Part for displaying Header Carousel
 *
 * @package Fold
 */

declare(strict_types=1);

$attachments      = get_uploaded_header_images();
$header_image     = get_custom_header();
$header_image_url = is_string( $header_image->url ) ? $header_image->url : '';
if ( ( is_home() || is_front_page() ) && count( $attachments ) > 0 ) {
	?>
	<section class="main-slider">
		<div id="HeaderCarousel" class="carousel rounded-bottom-3 slide shadow carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
			<div class="carousel-indicators d-none d-sm-flex">
				<?php
				$attachments_count = count( $attachments );
				for ( $counter = 0; $counter < $attachments_count; $counter++ ) {
					?>
					<button type="button" data-bs-target="#HeaderCarousel" data-bs-slide-to="<?php echo esc_attr( (string) $counter ); ?>" <?php echo 0 === $counter ? ' class="shadow-sm active"' : ' class="shadow-sm"'; ?> <?php echo 0 === $counter ? ' aria-current="true"' : ''; ?> aria-label="Slide <?php echo esc_attr( (string) $counter ); ?>"></button>
					<?php
				}
				?>
			</div>
			<div class="carousel-inner rounded-bottom-3">
				<?php
				$counter = 1;
				foreach ( $attachments as $attachment ) {
					if ( ! is_array( $attachment ) ) {
						continue;
					}
					$attachment_attachment_id = array_key_exists( 'attachment_id', $attachment ) ? $attachment['attachment_id'] : '';
					$attachment_attachment_id = is_numeric( $attachment_attachment_id ) ? intval( $attachment_attachment_id ) : 0;
					$img_src                  = wp_get_attachment_image_url( $attachment_attachment_id, 'full' );
					$img_src                  = is_string( $img_src ) ? $img_src : '';
					$img_srcset               = wp_get_attachment_image_srcset( $attachment_attachment_id, 'full' );
					$img_srcset               = is_string( $img_srcset ) ? $img_srcset : '';

					/*
					http://localhost/!!wordpress/wp-content/uploads/2018/09/wp1-300x120.jpg 300w,
					http://localhost/!!wordpress/wp-content/uploads/2018/09/wp1-600x240.jpg 600w,
					http://localhost/!!wordpress/wp-content/uploads/2018/09/wp1-768x307.jpg 768w,
					http://localhost/!!wordpress/wp-content/uploads/2018/09/wp1.jpg 1000w"
					*/
					$sizes      = wp_get_attachment_image_sizes( $attachment_attachment_id, 'full' );
					$sizes      = is_string( $sizes ) ? $sizes : '';
					$attachment = wp_prepare_attachment_for_js( $attachment_attachment_id );

					$image_data = wp_get_attachment_image_src( $attachment_attachment_id, 'full' );
					$width      = '100%';
					$height     = 'auto';
					if ( is_array( $image_data ) ) {
						$width  = $image_data[1];
						$height = $image_data[2];
					}
					?>
					<div class="carousel-item<?php echo 1 === $counter ? ' active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php /* translators: %s: Slide Number */ printf( esc_html__( 'Slide %s', 'fold' ), esc_attr( strval( $counter ) ) ); ?>">
					<?php
					if ( is_array( $attachment ) ) {
						?>
						<div class="rounded-bottom-3 overlay"></div>
						<img <?php echo 1 === $counter ? 'fetchpriority="high"' : 'loading="lazy"'; ?> class="rounded-bottom-3 w-100 slide-<?php echo esc_attr( strval( $counter ) ); ?>" src="<?php echo esc_url( $img_src ); ?>" srcset="<?php echo esc_attr( $img_srcset ); ?>" sizes="<?php echo esc_attr( $sizes ); ?>" width="<?php echo esc_attr( (string) $width ); ?>" height="<?php echo esc_attr( (string) $height ); ?>" title="<?php echo esc_attr( $attachment['title'] ); ?>" alt="<?php echo esc_attr( $attachment['title'] ); ?>" />
						<?php
					}
					if ( display_header_text() ) {
						?>
						<div class="carousel-caption">
						<?php
						if ( isset( $attachment['title'] ) ) {
							?>
							<h4>
								<a href="<?php echo esc_url( $attachment['alt'] ); ?>" title="<?php echo esc_attr( $attachment['title'] ); ?>"><?php echo esc_html( $attachment['title'] ); ?></a>
							</h4>
							<?php
						}
						if ( isset( $attachment['caption'] ) ) {
							?>
							<h5 class="d-none d-sm-block"><?php echo esc_html( $attachment['caption'] ); ?></h5>
							<?php
						}
						if ( isset( $attachment['description'] ) ) {
							?>
							<p class="d-none d-md-inline-block"><?php echo esc_html( $attachment['description'] ); ?></p>
							<?php
						}
						?>
						</div>
						<?php
					}//end if
					?>
					</div>
					<?php
					// $attachment['title']
					// $attachment['url']
					// $attachment['alt']
					// $attachment['description']
					// $attachment['caption']
					// $attachment['sizes']['thumbnail']['url']
					// $attachment['sizes']['thumbnail']['width']
					// $attachment['sizes']['thumbnail']['height']
					$counter++;
				}//end foreach
				?>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#HeaderCarousel" data-bs-slide="prev" role="button">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#HeaderCarousel" data-bs-slide="next" role="button">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</section>
	<?php
} elseif ( ( is_home() || is_front_page() ) && '' !== $header_image_url ) {
	?>
	<section class="main-slider">
		<div id="HeaderCarousel" class="carousel rounded-bottom-3 slide shadow carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
			<div class="carousel-inner rounded-bottom-3">
				<div class="carousel-item active rounded-bottom-3">
					<div class="overlay"></div>
					<?php the_custom_header_markup(); ?>
					<?php
					if ( display_header_text() ) {
						?>
						<div class="carousel-caption">
							<h4><?php echo esc_html( get_bloginfo() ); ?></h4>
							<h5 class="d-none d-sm-block"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></h5>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<?php
} else {
	?>
	<section class="main-slider">
		<div id="HeaderCarousel" class="carousel rounded-bottom-3 slide shadow carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
			<div class="carousel-inner rounded-bottom-3">
				<div class="carousel-item active">
					<div class="rounded-bottom-3 overlay"></div>
					<?php
					if (
						'yes' === get_theme_mod( 'display_featured_in_header', 'no' ) &&
						has_post_thumbnail() &&
						( ! function_exists( 'is_woocommerce' ) || ! is_woocommerce() )
					) {
							// check if woocommerce is not loaded
							// $current_post         = get_post();
							// $post_thumbnail_id    = is_object( $current_post ) ? get_post_thumbnail_id( intval( $current_post->ID ) ) : 0;
							// $featured_image_array = wp_get_attachment_image_src( intval( $post_thumbnail_id ), 'full' );
							// $featured_image       = $featured_image_array[0] ?? '';
						?>
						<?php
						the_post_thumbnail(
							'full',
							array(
								'class'   => 'rounded-bottom-3 w-100 slide-1 featured-media',
								'alt'     => get_the_title(),
								'title'   => get_the_title(),
								'loading' => 'eager',
								// 'loading' => 'lazy',
								// 'decoding' => 'async',
								// 'decoding' => 'sync',
								// 'decoding' => 'auto',
							)
						);
					} else {
						$theme_mod_default_header_background = get_theme_mod( 'default_header_background', get_stylesheet_directory_uri() . '/assets/images/header-bg.webp' );
						$theme_mod_default_header_background = is_string( $theme_mod_default_header_background ) ? $theme_mod_default_header_background : get_stylesheet_directory_uri() . '/assets/images/header-bg.webp';
						if ( '' === $theme_mod_default_header_background ) {
							$theme_mod_default_header_background = get_stylesheet_directory_uri() . '/assets/images/header-bg.webp';
						}
						$attachment_id = attachment_url_to_postid( $theme_mod_default_header_background );
						if ( 0 !== $attachment_id ) {
							$img_src    = wp_get_attachment_image_url( $attachment_id, 'full' );
							$img_src    = is_string( $img_src ) ? $img_src : '';
							$img_srcset = wp_get_attachment_image_srcset( $attachment_id, 'full' );
							$img_srcset = is_string( $img_srcset ) ? $img_srcset : '';
							$sizes      = wp_get_attachment_image_sizes( $attachment_id, 'full' );
							$sizes      = is_string( $sizes ) ? $sizes : '';
							$image_data = wp_get_attachment_image_src( $attachment_id, 'full' );
							$width      = '100%';
							$height     = 'auto';
							if ( is_array( $image_data ) ) {
								$width  = $image_data[1];
								$height = $image_data[2];
							}
							?>
							<img decoding="async" fetchpriority="high" class="rounded-bottom-3 w-100 slide-1" src="<?php echo esc_url( $img_src ); ?>" srcset="<?php echo esc_attr( $img_srcset ); ?>" sizes="<?php echo esc_attr( $sizes ); ?>" width="<?php echo esc_attr( (string) $width ); ?>" height="<?php echo esc_attr( (string) $height ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
							<?php
						} else {
							$theme_mod_default_header_300 = get_stylesheet_directory_uri() . '/assets/images/header-bg-300.webp';
							$theme_mod_default_header_600 = get_stylesheet_directory_uri() . '/assets/images/header-bg-600.webp';
							$theme_mod_default_header_768 = get_stylesheet_directory_uri() . '/assets/images/header-bg-768.webp';
							?>
							<img decoding="async" fetchpriority="high" class="rounded-bottom-3 w-100 slide-1" width="1000" height="auto" src="<?php echo esc_url( $theme_mod_default_header_background ); ?>" srcset="<?php echo esc_url( $theme_mod_default_header_background ); ?> 1000w, <?php echo esc_url( $theme_mod_default_header_600 ); ?> 600w, <?php echo esc_url( $theme_mod_default_header_300 ); ?> 300w, <?php echo esc_url( $theme_mod_default_header_768 ); ?> 768w" sizes="(max-width: 1000px) 100vw, 1000px" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
							<?php
						}//end if
					}//end if
					?>
					<div class="carousel-caption"><?php FOLD()::print_title(); ?></div>
				</div>
			</div>
		</div>
	</section>
	<?php
}//end if

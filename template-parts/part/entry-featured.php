<?php
/**
 * Part for displaying Entry Featured
 *
 * @package Fold
 */

if ( 'no' === get_theme_mod( 'display_featured_in_header', 'no' ) ) {
	if ( has_post_thumbnail() ) { ?>
		<div class="featured-image text-center">
			<?php
			$current_post_id                   = get_the_ID();
			$current_post_id                   = is_int( $current_post_id ) ? $current_post_id : 0;
			$post_thumbnail_id                 = get_post_thumbnail_id( $current_post_id );
			$post_thumbnail_id                 = is_int( $post_thumbnail_id ) ? $post_thumbnail_id : 0;
			$featured_image_array              = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
			$featured_image_array              = is_array( $featured_image_array ) ? $featured_image_array : array();
			$featured_image_array[0]         ??= '';
			$post_meta_wp_attachment_image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
			$post_meta_wp_attachment_image_alt = is_string( $post_meta_wp_attachment_image_alt ) ? $post_meta_wp_attachment_image_alt : '';
			$alt_tag_value                     = trim( wp_strip_all_tags( $post_meta_wp_attachment_image_alt ) );
			if ( ! is_single() ) {
				$permalink       = get_permalink();
				$permalink       = is_string( $permalink ) ? $permalink : '/';
				$title_attribute = the_title_attribute( array( 'echo' => false ) );
				$title_attribute = is_string( $title_attribute ) ? $title_attribute : '';
				echo '<a href="' . esc_url( $permalink ) . '" title="' . esc_attr( $title_attribute ) . '">';
			}
			?>
			<img loading="lazy" decoding="async" class="entry-header-image" src="<?php echo esc_url( $featured_image_array[0] ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php echo esc_attr( $alt_tag_value ); ?>" />
			<?php
			if ( ! is_single() ) {
				echo '</a>';
			}
			?>
		</div>
		<?php
	}//end if
}//end if

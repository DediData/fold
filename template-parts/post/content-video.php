<?php
/**
 * Template part for displaying video posts
 *
 * @package Fold
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'shadow rounded mb-3 p-3' ); ?>>
	<?php get_template_part( 'template-parts/part/entry-header' ); ?>
	<div class="entry-content">
		<?php get_template_part( 'template-parts/part/entry-featured' ); ?>
		<?php
		$content = apply_filters( 'the_content', get_the_content() );
		$content = is_string( $content ) ? $content : '';
		// Only get video from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
		}
		if ( ! is_single() ) {
			// If not a single post, highlight the video file.
			if ( isset( $video ) && is_array( $video ) ) {
				foreach ( $video as $video_html ) {
					echo '<div class="entry-video">';
					if ( is_string( $video_html ) ) {
						echo wp_kses_post( $video_html );
					}
					echo '</div>';
				}
			}
		}
		/* translators: %s: Name of current post */
		the_content( '<span class="fas fa-eye btn btn-default"></span> ' . esc_html__( 'Continue reading', 'fold' ) );
		get_template_part( 'template-parts/part/entry-pagination' );
		?>
	</div>
	<div>
		<?php get_template_part( 'template-parts/part/entry-footer' ); ?>
	</div>
</article>
<?php
// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || intval( get_comments_number() ) > 0 ) {
	comments_template();
}

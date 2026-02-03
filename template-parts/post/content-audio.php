<?php
/**
 * Template part for displaying audio posts
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
		// Only get audio from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$audio = get_media_embedded_in_content( $content, array( 'audio' ) );
		}
		if ( ! is_single() ) {
			// If not a single post, highlight the audio file.
			if ( isset( $audio ) && is_array( $audio ) ) {
				foreach ( $audio as $audio_html ) {
					echo '<div class="entry-audio">';
					if ( is_string( $audio_html ) ) {
						echo wp_kses_post( $audio_html );
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

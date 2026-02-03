<?php
/**
 * Fold Main Class
 *
 * @package Fold
 */

namespace Fold;

/**
 * Class Walker_Bootstrap_Comment
 */
final class Walker_Bootstrap_Comment extends \Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 * @see wp_list_comments()
	 * @param \WP_Comment  $comment Comment to display.
	 * @param integer      $depth   Depth of the current comment.
	 * @param array<mixed> $args    An array of arguments.
	 * @return void
	 * @SuppressWarnings(PHPMD.Superglobals)
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = isset( $args['style'] ) && 'div' === $args['style'] ? 'div' : 'li';
		?>
		<<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<div id="comment-author" class="shadow rounded mb-3">
				<?php
				if ( isset( $args['avatar_size'] ) && 0 !== $args['avatar_size'] ) {
					$other_args          = array();
					$other_args['class'] = 'rounded shadow';
					echo get_avatar( $comment, intval( $args['avatar_size'] ), '', 'avatar', $other_args );
				}
				?>
			</div>
			<div id="comment-content" class="shadow rounded mb-3 p-2">
				<header class="has-arrow-right">
					<?php
					printf( '<i class="fas fa-user" aria-hidden="true"></i> <b class="fn">%s</b>', get_comment_author_link( $comment ) );
					?>
					<div class="float-end">
						<i class="fas fa-clock-o" aria-hidden="true"></i>
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<?php
							$wpp_settings   = $GLOBALS['wpp_settings'] ?? array();
							$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
							$time_string    = get_comment_time( 'c' );
							if (
								is_array( $active_plugins ) &&
								in_array( 'wp-parsidate/wp-parsidate.php', $active_plugins, true ) &&
								'enable' === $wpp_settings['persian_date']
							) {
								$time_string = \gregdate( 'c', \eng_number( get_comment_time( 'c' ) ) );
							}
							$time_string = is_string( $time_string ) ? $time_string : '';
							?>
							<time datetime="<?php echo esc_attr( $time_string ); ?>">
								<?php
									/* translators: 1: comment date, 2: comment time */
									echo esc_html( sprintf( __( '%1$s at %2$s', 'fold' ), get_comment_date( '', $comment ), get_comment_time() ) );
								?>
							</time>
						</a>
					</div>
					<?php if ( '0' === $comment->comment_approved ) { ?>
						<p><?php esc_html_e( 'Your comment is awaiting moderation.', 'fold' ); ?></p>
					<?php } ?>
					</header>
				<?php comment_text(); ?>
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'] ?? 0,
							'before'    => '',
							'after'     => '',
						)
					)
				);
				?>
				<div class="float-end">
					<?php edit_comment_link( '<i class="fas fa-pencil mt-1" aria-hidden="true"></i> ' . esc_html__( 'Edit', 'fold' ), '', '' ); ?>
				</div>
			</div>
		<?php
	}
}

<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Fold
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

declare(strict_types=1);

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="shadow rounded mb-3 p-3">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) {
		?>
		<h2>
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( esc_html__( 'One Reply to &ldquo;%s&rdquo;', 'fold' ), esc_html( get_the_title() ) );
			} else {
				printf(
					esc_html(
						/* translators: 1: number of comments, 2: post title */
						_n(
							'%1$s Reply to &ldquo;%2$s&rdquo;',
							'%1$s Replies to &ldquo;%2$s&rdquo;',
							intval( $comments_number ),
							'fold'
						)
					),
					esc_html( number_format_i18n( intval( $comments_number ) ) ),
					esc_html( get_the_title() )
				);
			}
			?>
		</h2>
		<div>
			<?php
			FOLD()::comments_pagination(
				array(
					'prev_text' => '<span>' . esc_html__( 'Previous', 'fold' ) . '</span>',
					'next_text' => '<span>' . esc_html__( 'Next', 'fold' ) . '</span>',
					'type'      => 'list',
				)
			);
			?>
			<ol id="comment-list">
				<?php
					wp_list_comments(
						array(
							'walker'      => new \Fold\Walker_Bootstrap_Comment(),
							'avatar_size' => 100,
							'style'       => 'ol',
							'short_ping'  => true,
						)
					);
				?>
			</ol>
			<?php
			FOLD()::comments_pagination(
				array(
					'prev_text' => '<span>' . esc_html__( 'Previous', 'fold' ) . '</span>',
					'next_text' => '<span>' . esc_html__( 'Next', 'fold' ) . '</span>',
					'type'      => 'list',
				)
			);
			?>
		</div>
		<?php
	}//end if
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && (bool) get_comments_number() && post_type_supports( (string) get_post_type(), 'comments' ) ) {
		?>
		<p><?php esc_html_e( 'Comments are closed.', 'fold' ); ?></p>
		<?php
	}
	?>
	<?php FOLD()::validate_comment_form(); ?>
</div>

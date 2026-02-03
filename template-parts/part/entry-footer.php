<?php
/**
 * Part for displaying Entry Footer
 *
 * @package Fold
 */

?>
<footer class="entry-footer">
	<?php
	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', ' ' );
	$id_number = get_the_ID();
	$id_number = is_int( $id_number ) ? $id_number : 0;
	if ( is_string( $tags_list ) && ! is_archive() && ! is_front_page() ) {
		?>
		<div class="tags-links">
			<span class="fas fa-tags fa-lg" title="<?php esc_attr_e( 'Tags', 'fold' ); ?>"></span>&nbsp;
			<?php echo wp_kses_post( $tags_list ); ?>
		</div>
		<?php
	}
	if ( is_single() || is_archive() ) {
		$author_meta_id = intval( get_the_author_meta( 'ID' ) );
		// Get Categories for posts.
		$categories_list = get_the_category_list( esc_html__( ', ', 'fold' ) );
		?>
		<div class="footer-item cat-links">
			<i class="fas fa-list-ul fa-lg" title="<?php esc_attr_e( 'Categories', 'fold' ); ?>" aria-hidden="true"></i>
				<?php echo wp_kses_post( $categories_list ); ?>
		</div>
		<div class="footer-item author-name">
			<i class="fas fa-user fa-lg" title="<?php esc_attr_e( 'Author', 'fold' ); ?>" aria-hidden="true"></i>
			<span class="author" title="<?php esc_attr_e( 'Author', 'fold' ); ?>">
				<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( $author_meta_id ) ); ?>"><?php echo get_the_author(); ?></a>
			</span>
		</div>
		<div class="footer-item">
			<?php FOLD()::posted_on(); ?>
			<?php FOLD()::modified_on(); ?>
		</div>
		<?php
	}//end if
	if ( function_exists( 'wp_statistics_pages' ) && (bool) get_theme_mod( 'display_visits', true ) && ! is_front_page() ) {
		?>
		<div class="footer-item total-hits">
			<i class="fas fa-bar-chart fa-lg" title="<?php esc_attr_e( 'Total Hits', 'fold' ); ?>" aria-hidden="true"></i>
			<span class="stat-hits" title="<?php esc_attr_e( 'Total Hits', 'fold' ); ?>">
				<?php
				$total_page_view = wp_statistics_pages( 'total', '', $id_number );
				$total_page_view = is_string( $total_page_view ) ? $total_page_view : '0';
				echo esc_html( $total_page_view );
				?>
			</span>
		</div>
		<?php
	}
	if ( comments_open( $id_number ) ) {
		?>
		<div class="footer-item comments-number">
			<i class="fas fa-comments fa-lg" title="<?php esc_attr_e( 'Comments Number', 'fold' ); ?>" aria-hidden="true"></i>
			<span class="comments-count" title="<?php esc_attr_e( 'Comments Number', 'fold' ); ?>">
				<?php
				$comments_number = get_comments_number();
				$comments_number = (string) $comments_number;
				echo esc_html( $comments_number );
				?>
			</span>
		</div>
		<?php
	}
	?>
</footer>

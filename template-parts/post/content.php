<?php
/**
 * Template part for displaying posts
 *
 * @package Fold
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

$post_class = '';
if ( ! str_contains( get_page_template(), 'template-fullwidth.php' ) ) {
	$post_class = 'shadow rounded mb-3 p-3';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<?php
	if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() || is_product() || is_product_category() || is_product_tag() ) ) {
		?>
		<div class="pb-2"><?php woocommerce_breadcrumb(); ?></div>
		<?php
	}
	get_template_part( 'template-parts/part/entry-header' );
	?>
	<div class="entry-content">
		<?php get_template_part( 'template-parts/part/entry-featured' ); ?>
		<?php
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

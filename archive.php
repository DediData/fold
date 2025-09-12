<?php
/**
 * The archive template file
 *
 * @package Fold
 */

declare(strict_types=1);

get_header(); ?>
<main id="main" class="container mt-3">
<?php
// @phan-suppress-next-line PhanPluginRedundantAssignmentInGlobalScope
$extra_class = '';
if ( is_active_sidebar( 'sidebar-1' ) ) {
	$extra_class = ' col-md-8 col-lg-9 order-1 order-md-2 p-2';
	?>
	<div class="row">
	<?php
}
?>
		<div id="primary" class="col-12<?php echo esc_attr( $extra_class ); ?>">
			<?php
			dynamic_sidebar( 'content-top' );
			the_archive_description( '<div class="text-justify">', '</div>' );

			if ( have_posts() ) {
				?>
				<div class="panel-group" id="accordion">
					<?php
					/* Start the Loop */
					while ( have_posts() ) {
						the_post();

						/*
						* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						get_template_part( 'template-parts/post/content', (string) get_post_format() );
					}
					?>
				</div>
				<?php
				FOLD()::posts_pagination(
					array(
						'prev_text' => '<span>' . esc_html__( 'Previous', 'fold' ) . '</span>',
						'next_text' => '<span>' . esc_html__( 'Next', 'fold' ) . '</span>',
						'type'      => 'list',
						'end_size'  => 3,
						'mid_size'  => 3,
					)
				);
			}//end if
			?>
			<?php dynamic_sidebar( 'content-bottom' ); ?>
		</div>
<?php
if ( is_active_sidebar( 'sidebar-1' ) ) {
	get_sidebar();
	?>
	</div>
	<?php
}
?>
</main>
<?php
get_footer();

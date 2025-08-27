<?php
/**
 * The main template file
 *
 * @package Fold
 */

declare(strict_types=1);

get_header(); ?>
<main id="main" class="mt-3">
	<div class="container">
		<?php
		// @phan-suppress-next-line PhanPluginRedundantAssignmentInGlobalScope
		$extra_class = '';
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$extra_class = ' col-md-8 col-lg-9 order-2 p-2';
			echo '<div class="row">';
		}
		?>
		<div id="primary" class="col-12<?php echo esc_attr( $extra_class ); ?>">
			<?php
			dynamic_sidebar( 'content-top' );
			if ( is_tag() && (bool) tag_description() ) {
				?>
				<div class="shadow rounded mb-3 text-justify"><?php echo tag_description(); ?></div>
				<?php
			}
			if ( have_posts() ) {
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
			dynamic_sidebar( 'content-bottom' );
			?>
		</div>
		<?php
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			get_sidebar();
			echo '</div>';
		}
		?>
	</div>
</main>
<?php
get_footer();

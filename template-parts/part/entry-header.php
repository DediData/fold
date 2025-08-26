<?php
/**
 * Part for displaying Entry Header
 *
 * @package Fold
 */

declare(strict_types=1);

?>
<header class="entry-header">
	<div class="row">
	<?php
	if ( is_archive() || is_front_page() || is_home() || is_search() ) {
		?>
		<div class="col <?php echo is_archive() ? 'float-start' : 'col-12'; ?>">
			<?php
			$icons     = FOLD()::get_post_icon();
			$id_number = get_the_ID();
			$id_number = is_int( $id_number ) ? $id_number : 0;
			if ( is_single() || is_page() ) {
				the_title( '<h1 class="entry-title">' . $icons, '</h1>' );
			} else {
				$permalink = get_permalink();
				$permalink = is_string( $permalink ) ? $permalink : '';
				the_title( '<h2 class="entry-title text-start">' . $icons . '<a href="' . esc_url( $permalink ) . '" title="' . esc_attr( get_the_title() ) . '" rel="bookmark">', '</a></h2>' );
			}
			?>
		</div>
			<?php
		}
		?>
	</div>
</header>

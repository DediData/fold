<?php
/**
 * Footer Column 4 Sidebar
 *
 * @package Fold
 */

if ( is_active_sidebar( 'footer-column-4' ) ) {
	?>
	<section class="col-12 col-sm-3">
		<?php dynamic_sidebar( 'footer-column-4' ); ?>
	</section>
	<?php
}

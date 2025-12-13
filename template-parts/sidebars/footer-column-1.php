<?php
/**
 * Footer Column 1 Sidebar
 *
 * @package Fold
 */

declare(strict_types=1);

if ( is_active_sidebar( 'footer-column-1' ) ) {
	?>
	<section class="col-12 col-sm-3">
		<?php dynamic_sidebar( 'footer-column-1' ); ?>
	</section>
	<?php
}

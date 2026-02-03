<?php
/**
 * Footer Column Bottom
 *
 * @package Fold
 */

if ( is_active_sidebar( 'footer-bottom' ) ) {
	?>
	<section id="footer-bottom-sidebar" class="row justify-content-center mt-3">
		<?php dynamic_sidebar( 'footer-bottom' ); ?>
	</section>
	<?php
}

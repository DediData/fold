<?php
/**
 * Footer Column Top
 *
 * @package Fold
 */

if ( is_active_sidebar( 'footer-top' ) ) {
	?>
	<section id="footer-top-sidebar" class="row justify-content-center mb-3">
		<?php dynamic_sidebar( 'footer-top' ); ?>
	</section>
	<?php
}

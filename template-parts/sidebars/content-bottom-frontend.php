<?php
/**
 * Frontend Content Bottom Sidebar
 *
 * @package Fold
 */

if ( ( is_home() || is_front_page() ) && is_active_sidebar( 'frontend-content-bottom' ) ) {
	?>
	<section id="frontend-content-bottom-sidebar" style="height: fit-content;" class="shadow rounded p-3 mb-3">
		<?php dynamic_sidebar( 'frontend-content-bottom' ); ?>
	</section>
	<?php
}

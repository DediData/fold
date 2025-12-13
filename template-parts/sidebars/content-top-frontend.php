<?php
/**
 * Frontend Content Top Sidebar
 *
 * @package Fold
 */

declare(strict_types=1);

if ( ( is_home() || is_front_page() ) && is_active_sidebar( 'frontend-content-top' ) ) {
	?>
	<section id="frontend-content-top-sidebar" style="height: fit-content;" class="shadow rounded p-3 mb-3">
	<?php dynamic_sidebar( 'frontend-content-top' ); ?>
	</section>
	<?php
}

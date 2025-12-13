<?php
/**
 * Content Bottom Sidebar
 *
 * @package Fold
 */

declare(strict_types=1);

if ( is_active_sidebar( 'content-bottom' ) ) {
	?>
	<section id="content-bottom-sidebar" style="height: fit-content;" class="shadow rounded p-3 mb-3">
		<?php dynamic_sidebar( 'content-bottom' ); ?>
	</section>
	<?php
}

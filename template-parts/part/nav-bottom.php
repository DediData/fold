<?php
/**
 * Part for displaying Nav Bottom
 *
 * @package Fold
 */

declare(strict_types=1);

if ( has_nav_menu( 'bottom' ) || is_customize_preview() ) { ?>
	<nav id="bottom-menu" class="mega-menu navbar navbar-expand-md shadow container rounded transition">
		<div class="container-fluid">
			<button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#bottom-navbar-collapse" aria-controls="bottom-navbar-collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'fold' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="bottom-navbar-collapse" class="collapse navbar-collapse">
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'bottom',
						'depth'           => 1,
						'menu_class'      => 'navbar-nav mega-menu mx-auto transition',
						'menu_id'         => '',
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'fallback_cb'     => '\Fold\Walker_Bootstrap_Nav::fallback',
						'walker'          => new \Fold\Walker_Bootstrap_Nav(),
					)
				);
				?>
			</div>
		</div>
	</nav>
	<?php
}//end if

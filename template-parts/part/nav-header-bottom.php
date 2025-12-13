<?php
/**
 * Part for displaying Nav Header
 *
 * @package Fold
 */

declare(strict_types=1);

if ( has_nav_menu( 'header' ) || has_nav_menu( 'header-right' ) || is_customize_preview() ) {
	$menu_mode = get_theme_mod( 'menu_mode', 'mega-menu' );
	if ( false === in_array( $menu_mode, array( 'mega-menu', 'normal-menu' ), true ) ) {
		$menu_mode = 'mega-menu';
	}
	?>
	<nav id="header-menu" class="navbar navbar-expand-md shadow container rounded bg-gradient <?php echo esc_attr( FOLD()->primary_bg_mode ); ?>">
		<div class="container-fluid">
			<button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#header-navbar-collapse" aria-controls="header-navbar-collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'fold' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="header-navbar-collapse" class="collapse navbar-collapse">
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'header',
						'depth'           => 3,
						'menu_class'      => $menu_mode . ' navbar-nav transition mx-2',
						'menu_id'         => '',
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'fallback_cb'     => '\Fold\Walker_Bootstrap_Nav::fallback',
						'walker'          => new \Fold\Walker_Bootstrap_Nav(),
					)
				);
				wp_nav_menu(
					array(
						'theme_location'  => 'header-right',
						'depth'           => 3,
						'menu_class'      => $menu_mode . ' navbar-nav transition ms-auto',
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

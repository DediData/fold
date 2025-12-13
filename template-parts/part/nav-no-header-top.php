<?php
/**
 * Part for displaying Nav Top
 *
 * @package Fold
 */

declare(strict_types=1);

$theme_mod_display_login_link  = get_theme_mod( 'display_login_link', false );
$theme_mod_display_search_icon = get_theme_mod( 'display_search_icon', 'yes' );
$theme_mod_display_cart_icon   = get_theme_mod( 'display_cart_icon', 'yes' );
if ( has_nav_menu( 'primary' ) || has_nav_menu( 'second-top-bar' ) || true === $theme_mod_display_login_link || 'yes' === $theme_mod_display_search_icon || 'yes' === $theme_mod_display_cart_icon || is_customize_preview() ) {
	$menu_mode = get_theme_mod( 'menu_mode', 'mega-menu' );
	if ( false === in_array( $menu_mode, array( 'mega-menu', 'normal-menu' ), true ) ) {
		$menu_mode = 'mega-menu';
	}
	?>
	<nav id="no-header-top-menu" class="top-menu navbar navbar-expand-md">
		<div class="container-fluid">
			<button class="navbar-toggler z-3" type="button" data-bs-toggle="collapse" data-bs-target="#top-navbar-collapse" aria-controls="top-navbar-collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'fold' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand d-block d-md-none" href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>"><i class="fas fa-home fa-lg" aria-hidden="true"></i></a>
			<div id="top-navbar-collapse" class="collapse navbar-collapse">
				<div id="first-header-bar" class="header-bar d-flex justify-content-center align-items-center bg-gradient">
					<a class="navbar-brand d-none d-md-block" href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>"><i class="fas fa-home fa-lg" aria-hidden="true"></i></a>
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'depth'           => 3,
							'menu_class'      => $menu_mode . ' navbar-nav mx-2',
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
				<div id="header-logo" class="px-4 position-relative d-none d-lg-block">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				}
				?>
				</div>
				<div id="second-header-bar" class="header-bar d-flex justify-content-center align-items-center navbar-nav bg-gradient">
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'top-menu-side',
							'depth'           => 3,
							'menu_class'      => $menu_mode . ' navbar-nav mx-2',
							'menu_id'         => '',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'fallback_cb'     => '\Fold\Walker_Bootstrap_Nav::fallback',
							'walker'          => new \Fold\Walker_Bootstrap_Nav(),
						)
					);

					if ( class_exists( 'WooCommerce' ) && 'yes' === $theme_mod_display_cart_icon ) {
						$cart_count = WC()->cart->get_cart_contents_count();
						$cart_url   = wc_get_cart_url();
						?>
						<a id="cart-item" class="menu-item float-end px-3 py-2 cart-icon-link position-relative" href="<?php echo esc_url( $cart_url ); ?>" title="<?php esc_attr_e( 'View Cart', 'fold' ); ?>" role="button">
							<i class="fas fa-lg fa-shopping-cart"></i>
							<span class="position-absolute translate-middle badge rounded-pill bg-danger cart-count">
								<?php echo esc_html( $cart_count ); ?>
							</span>
						</a>
						<?php
					}
					if ( 'yes' === $theme_mod_display_search_icon ) {
						?>
						<a id="search-item" class="menu-item float-end p-2" title="<?php esc_attr_e( 'Search', 'fold' ); ?>" data-bs-toggle="modal" data-bs-target="#searchModal" aria-haspopup="true" role="button">
							<i class="fas fa-lg fa-search"></i>
						</a>
						<?php
					}

					if ( true === $theme_mod_display_login_link ) {
						$login_link_texts                = FOLD()::login_link_texts();
						$theme_mod_login_link_text       = get_theme_mod( 'login_link_text', 'Login' );
						$theme_mod_login_link_text       = is_string( $theme_mod_login_link_text ) ? $theme_mod_login_link_text : '';
						$theme_mod_login_link_text_value = array_key_exists( $theme_mod_login_link_text, $login_link_texts ) ? $login_link_texts[ $theme_mod_login_link_text ] : '';
						$theme_mod_login_link_text_value = is_string( $theme_mod_login_link_text_value ) ? $theme_mod_login_link_text_value : '';
						?>
						<a id="login-menu-item" class="menu-item float-end p-2" title="<?php echo esc_attr( $theme_mod_login_link_text_value ); ?>" data-bs-toggle="modal" data-bs-target="#popup-login" aria-haspopup="true" role="button">
							<i class="fas fa-lg fa-user"></i>&nbsp;<?php echo esc_html( $theme_mod_login_link_text_value ); ?>
						</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</nav>
	<?php
}//end if

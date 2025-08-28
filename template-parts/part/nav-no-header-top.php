<?php
/**
 * Part for displaying Nav Top
 *
 * @package Fold
 */

declare(strict_types=1);

$theme_mod_display_login_link = get_theme_mod( 'display_login_link' );
if ( has_nav_menu( 'primary' ) || true === $theme_mod_display_login_link || is_customize_preview() ) { ?>
	<nav id="no-header-top-menu" class="mega-menu navbar navbar-expand-md shadow container rounded-bottom z-10000 transition">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>"><i class="fas fa-home" aria-hidden="true"></i></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#top-navbar-collapse" aria-controls="top-navbar-collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'fold' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="top-navbar-collapse" class="collapse navbar-collapse">
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'depth'           => 3,
						'menu_class'      => 'navbar-nav mega-menu transition mx-2',
						'menu_id'         => '',
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'fallback_cb'     => '\Fold\Walker_Bootstrap_Nav::fallback',
						'walker'          => new \Fold\Walker_Bootstrap_Nav(),
					)
				);
				?>
				<ul id="top-menu-side" class="navbar-nav ms-auto">
					<?php
					if ( true === $theme_mod_display_login_link ) {
						$login_link_texts                = FOLD()::login_link_texts();
						$theme_mod_login_link_text       = get_theme_mod( 'login_link_text' );
						$theme_mod_login_link_text       = is_string( $theme_mod_login_link_text ) ? $theme_mod_login_link_text : '';
						$theme_mod_login_link_text_value = array_key_exists( $theme_mod_login_link_text, $login_link_texts ) ? $login_link_texts[ $theme_mod_login_link_text ] : '';
						$theme_mod_login_link_text_value = is_string( $theme_mod_login_link_text_value ) ? $theme_mod_login_link_text_value : '';
						?>
						<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" class="menu-item float-end" id="login-menu-item">
							<a title="<?php echo esc_attr( $theme_mod_login_link_text_value ); ?>" id="login-button" data-bs-toggle="modal" data-bs-target="#popup-login" aria-haspopup="true" role="button">
								<i class="fas fa-lg fa-user"></i>&nbsp;<?php echo esc_html( $theme_mod_login_link_text_value ); ?>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
	</nav>
	<?php
}//end if

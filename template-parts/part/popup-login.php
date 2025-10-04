<?php
/**
 * Part for displaying Popup Login
 *
 * @package Fold
 */

declare(strict_types=1);

$theme_mod_display_login_link = get_theme_mod( 'display_login_link', false );
if ( isset( $theme_mod_display_login_link ) ) {
	$login_link_texts            = FOLD()::login_link_texts();
	$login_link_text             = get_theme_mod( 'login_link_text', 'Login' );
	$login_link_text             = is_string( $login_link_text ) ? $login_link_text : 'Login';
	$theme_mod_login_form_system = get_theme_mod( 'login_form_system', 'WordPress' );
	$login_link_text_value       = array_key_exists( $login_link_text, $login_link_texts ) ? $login_link_texts[ $login_link_text ] : '';
	$login_link_text_value       = is_string( $login_link_text_value ) ? $login_link_text_value : '';

	if ( 'WordPress' === $theme_mod_login_form_system ) {
		?>
		<div class="main-box modal fade transition" style="top: 20%;" id="popup-login" role="dialog" tabindex="-1" aria-labelledby="Popup Login" aria-hidden="true">
			<div class="modal-dialog shadow" role="document" style="width: 400px;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="popup-login-label"><?php echo esc_html( $login_link_text_value ); ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'fold' ); ?>"></button>
					</div>
					<div class="modal-body">
						<form id="login-form" data-toggle="validator" method="post" action="<?php echo esc_url( site_url( '/wp-login.php' ) ); ?>">
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-at fa-lg"></i></span>
									<input id="login-username" style="direction: ltr;" type="email" class="form-control" name="log" autocomplete="username"
										placeholder="<?php esc_attr_e( 'Email Address', 'fold' ); ?>" required="required" data-error="<?php esc_attr_e( 'Please enter your valid email address!', 'fold' ); ?>" />
								</div>
								<span class="fas form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-key fa-lg"></i></span>
									<input id="login-password" style="direction: ltr;" type="password" class="form-control" name="pwd" autocomplete="current-password"
										placeholder="<?php esc_attr_e( 'Password', 'fold' ); ?>"  required="required" data-error="<?php esc_attr_e( 'Please enter your password!', 'fold' ); ?>" />
								</div>
								<span class="fas form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="text-center form-group">
									<input type="submit" class="btn btn-primary" value="<?php esc_attr_e( 'Login', 'fold' ); ?>" />&nbsp;
									<?php
									$option_users_can_register = get_option( 'users_can_register' );
									if ( isset( $option_users_can_register ) ) {
										?>
									<a class="btn btn-success" href="<?php echo esc_url( site_url( '/wp-login.php?action=register' ) ); ?>" rel="nofollow"><?php esc_html_e( 'Register!', 'fold' ); ?></a>&nbsp;
										<?php
									}
									?>
									<a class="btn btn-warning"  rel="nofollow" href="<?php echo esc_url( site_url( '/wp-login.php?action=lostpassword' ) ); ?>"><?php esc_html_e( 'Forgot Password?', 'fold' ); ?></a>&nbsp;
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e( 'Close', 'fold' ); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	} elseif ( 'WooCommerce' === $theme_mod_login_form_system ) {
		?>
		<div class="main-box modal fade transition" style="top: 20%;" id="popup-login" role="dialog">
			<div class="modal-dialog shadow" role="document" style="width: 400px;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="popup-login-label"><?php echo esc_html( $login_link_text_value ); ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'fold' ); ?>"></button>
					</div>
					<div class="modal-body">
						<form id="login-form" data-toggle="validator" method="post" action="<?php echo esc_url( get_home_url() . '/my-account/' ); ?>">
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-at fa-lg"></i></span>
									<input id="username" style="direction: ltr;" type="email" class="form-control" name="username" autocomplete="username"
										placeholder="<?php esc_attr_e( 'Email Address', 'fold' ); ?>" required="required" data-error="<?php esc_attr_e( 'Please enter your valid email address!', 'fold' ); ?>" />
								</div>
								<span class="fas form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-key fa-lg"></i></span>
									<input id="password" style="direction: ltr;" type="password" class="form-control" name="password" autocomplete="current-password"
										placeholder="<?php esc_attr_e( 'Password', 'fold' ); ?>"  required="required" data-error="<?php esc_attr_e( 'Please enter your password!', 'fold' ); ?>" />
								</div>
								<span class="fas form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="text-center form-group">
									<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
									<input type="submit" name="login" class="btn btn-primary" value="<?php esc_attr_e( 'Login', 'fold' ); ?>" />&nbsp;
									<a class="btn btn-success" href="<?php echo esc_url( get_home_url() . '/my-account/' ); ?>" rel="nofollow"><?php esc_html_e( 'Register!', 'fold' ); ?></a>&nbsp;
									<a class="btn btn-warning"  rel="nofollow" href="<?php echo esc_url( get_home_url() . '/my-account/lost-password/' ); ?>"><?php esc_html_e( 'Forgot Password?', 'fold' ); ?></a>&nbsp;
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e( 'Close', 'fold' ); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	} elseif ( 'WHMCS' === $theme_mod_login_form_system ) {
		$theme_mod_whmcs_url = get_theme_mod( 'whmcs_url', 'https://panel.dedidata.com' );
		$theme_mod_whmcs_url = is_string( $theme_mod_whmcs_url ) ? $theme_mod_whmcs_url : '';
		?>
		<div class="main-box modal fade transition" style="top: 20%;" id="popup-login" role="dialog">
			<div class="modal-dialog shadow" role="document" style="width: 400px;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="popup-login-label"><?php echo esc_html( $login_link_text_value ); ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'fold' ); ?>"></button>
					</div>
					<div class="modal-body">
						<form id="login-form" data-toggle="validator" method="post" action="<?php echo esc_url( $theme_mod_whmcs_url . '/dologin.php' ); ?>">
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-at fa-lg"></i></span>
									<input id="login-username" style="direction: ltr;" type="email" class="form-control" name="username" autocomplete="username"
										placeholder="<?php esc_attr_e( 'Email Address', 'fold' ); ?>" required="required" data-error="<?php esc_attr_e( 'Please enter your valid email address!', 'fold' ); ?>" />
								</div>
								<span class="fas form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group has-feedback">
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-key fa-lg"></i></span>
									<input id="login-password" style="direction: ltr;" type="password" class="form-control" name="password" autocomplete="current-password"
										placeholder="<?php esc_attr_e( 'Password', 'fold' ); ?>"  required="required" data-error="<?php esc_attr_e( 'Please enter your password!', 'fold' ); ?>" />
								</div>
								<span class="fas form-control-feedback" aria-hidden="true"></span>
								<div class="help-block with-errors"></div>
							</div>
							<div class="text-center form-group">
									<input type="submit" class="btn btn-primary" value="<?php esc_attr_e( 'Login', 'fold' ); ?>" />&nbsp;
									<a class="btn btn-success" href="<?php echo esc_url( $theme_mod_whmcs_url . '/register.php' ); ?>" rel="nofollow"><?php esc_html_e( 'Register!', 'fold' ); ?></a>&nbsp;
									<a class="btn btn-warning"  rel="nofollow" href="<?php echo esc_url( $theme_mod_whmcs_url . '/pwreset.php' ); ?>"><?php esc_html_e( 'Forgot Password?', 'fold' ); ?></a>&nbsp;
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php esc_html_e( 'Close', 'fold' ); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}//end if
}//end if

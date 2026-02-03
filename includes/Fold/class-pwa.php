<?php
/**
 * PWA Class
 *
 * @package Fold
 */

namespace Fold;

/**
 * Class PWA
 */
final class PWA extends \DediData\Singleton {

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( is_admin() ) {
			return;
		}
		if ( true !== get_theme_mod( 'enable_pwa', 'true' ) ) {
			return;
		}
		add_action( 'wp_loaded', array( $this, 'manifest' ), 10, 0 );
		add_action( 'wp_loaded', array( $this, 'service_worker' ), 10, 0 );
		add_action( 'wp_loaded', array( $this, 'offline_page' ), 10, 0 );
		add_action( 'wp_footer', array( $this, 'register_service_worker' ), 10, 0 );
		add_action( 'wp_footer', array( $this, 'toast' ), 10, 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'wpa_install' ), 10, 0 );
		add_action(
			'wp_head',
			static function () {
				echo '<link rel="manifest" href="' . esc_url( home_url( '/manifest.json' ) ) . '">';
			}
		);
	}

	/**
	 * Generates a JSON manifest file for a web application with site information, icons, screenshots, protocol handlers, and display settings.
	 *
	 * @return void Generating a JSON manifest file for a web application. The function first checks if the requested URI is for `manifest.json`. If not, it returns early.
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 */
	public function manifest() {
		$server_request_uri = filter_input( \INPUT_SERVER, 'REQUEST_URI', \FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ! isset( $server_request_uri ) ) {
			return;
		}

		$path = wp_parse_url( $server_request_uri, \PHP_URL_PATH );
		// only handle /manifest.json
		if ( 'manifest.json' !== basename( (string) $path ) ) {
			return;
		}

		header( 'Content-Type: application/manifest+json; charset=utf-8' );

		// Site info
		$site_name        = get_bloginfo( 'name' );
		$short_name       = mb_substr( $site_name, 0, 12 );
		$theme_color      = '#0a84ff';
		$background_color = '#ffffff';

		// site icon from customizer
		$site_icon_id = get_option( 'site_icon' );
		$icons        = array();

		$allowed_exts  = array( 'png', 'svg', 'webp' );
		$allowed_mimes = array(
			'image/png',
			'image/svg+xml',
			'image/webp',
		);

		if ( is_string( $site_icon_id ) ) {
			// get attachment metadata
			$meta = wp_get_attachment_metadata( intval( $site_icon_id ) );
			// get mime type
			$mime_type = get_post_mime_type( intval( $site_icon_id ) );

			if ( $meta ) {
				// full size
				$full_url = wp_get_attachment_url( (int) $site_icon_id );
				if ( is_string( $full_url ) && intval( $meta['width'] ) > 144 && intval( $meta['height'] > 144 ) ) {
					$ext = strtolower( pathinfo( $full_url, \PATHINFO_EXTENSION ) );
					if ( in_array( $ext, $allowed_exts, true ) ) {
						$icons[] = array(
							'src'   => $full_url,
							'sizes' => isset( $meta['width'], $meta['height'] ) ? strval( $meta['width'] ) . 'x' . strval( $meta['height'] ) : '',
							'type'  => is_string( $mime_type ) && in_array( $mime_type, $allowed_mimes, true ) ? $mime_type : 'image/' . $ext,
						);
					}
				}

				// other sizes
				if ( count( $meta['sizes'] ) > 0 ) {
					foreach ( $meta['sizes'] as $size_name => $size_data ) {
						$src = wp_get_attachment_image_url( (int) $site_icon_id, (string) $size_name );
						if ( ! is_string( $src ) ) {
							continue;
						}
						$ext = strtolower( pathinfo( $src, \PATHINFO_EXTENSION ) );
						if ( ! in_array( $ext, $allowed_exts, true ) ) {
							continue;
						}
						$size_data = (array) $size_data;
						if ( ! isset( $size_data['width'] ) || ! isset( $size_data['height'] ) ) {
							continue;
						}
						// Google requirement
						if ( (int) $size_data['width'] < 144 || (int) $size_data['height'] < 144 ) {
							continue;
						}
						$icons[] = array(
							'src'   => $src,
							'sizes' => (string) $size_data['width'] . 'x' . (string) $size_data['height'],
							'type'  => is_string( $mime_type ) && in_array( $mime_type, $allowed_mimes, true ) ? $mime_type : 'image/' . $ext,
						);
					}//end foreach
				}//end if
			}//end if
		}//end if

		// fallback to default icon if no icons found
		if ( count( $icons ) < 1 ) {
			$icons[] = array(
				// Default icon
				'src'   => get_template_directory_uri() . '/assets/images/app.png',
				'sizes' => '512x512',
				'type'  => 'image/png',
			);
		}

		// screenshot wide from theme files
		$screenshots = array(
			// Desktop
			array(
				'src'         => get_template_directory_uri() . '/screenshot.jpg',
				'sizes'       => '1200x900',
				// 'sizes'    => '1280x720',
				'type'        => 'image/jpeg',
				'form_factor' => 'wide',
			),
			// Mobile
			array(
				'src'   => get_template_directory_uri() . '/screenshot-mobile.jpg',
				'sizes' => '720x1280',
				'type'  => 'image/jpeg',
				// form_factor = "narrow" (Optional)
			),
		);

		// Optional protocol handler (You can remove it if you don't use)
		$protocol_handlers = array(
			array(
				'protocol' => 'web+myapp',
				'url'      => site_url( '/?handler=%s' ),
			),
		);

		$display_override = array(
			'fullscreen',
			// 'minimal-ui',
			'window-controls-overlay',
			'standalone',
		);

		// OUTPUT JSON
		echo wp_json_encode(
			array(
				'id'                => site_url( '/' ),
				'name'              => $site_name,
				'short_name'        => $short_name,
				'start_url'         => '/',
				'display'           => 'standalone',
				'background_color'  => $background_color,
				'theme_color'       => $theme_color,
				'icons'             => $icons,
				'screenshots'       => $screenshots,
				'protocol_handlers' => $protocol_handlers,
				'display_override'  => $display_override,
			),
			\JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES
		);
		exit;
	}

	/**
	 * Generates a service worker script for a WordPress theme to handle caching and offline functionality.
	 *
	 * @return void Returning a JavaScript code block that defines a service worker for a WordPress theme's Progressive Web App (PWA) functionality.
	 * The service worker handles caching of core assets, offline functionality, installation, activation, and fetching of resources.
	 * It also includes logic to serve offline content when the user is offline and to cache static assets for faster loading.
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 */
	public function service_worker() {
		$server_request_uri = filter_input( \INPUT_SERVER, 'REQUEST_URI', \FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$path               = wp_parse_url( (string) $server_request_uri, \PHP_URL_PATH );
		if ( 'sw.js' !== basename( (string) $path ) ) {
			return;
		}

		nocache_headers();
		header( 'Content-Type: application/javascript; charset=utf-8' );
		$theme   = wp_get_theme();
		$version = $theme->get( 'Version' );
		?>
		/** === WordPress Theme PWA Service Worker === **/
		const CACHE_VERSION = 'fold-<?php echo esc_js( $version ); ?>';
		const STATIC_CACHE  = `pwa-static-${CACHE_VERSION}`;
		const OFFLINE_URL   = '/offline.html';

		/* Files that MUST be available offline */
		const CORE_ASSETS = [
			OFFLINE_URL
			/* '/', */
			/* '/wp-content/themes/your-theme/style.css', */
			/* '/wp-content/themes/your-theme/script.js' */
			// Images or other important files
		]

		/* ================= INSTALL ================= */
		self.addEventListener(
			'install',
			event => {
				event.waitUntil(
					caches.open( STATIC_CACHE ).then( cache => cache.addAll( CORE_ASSETS ) )
				);
				self.skipWaiting();
			}
		);

		/* ================= ACTIVATE ================= */
		self.addEventListener(
			'activate',
			event => {
				event.waitUntil(
					caches.keys().then(
						keys => Promise.all(
							keys
							.filter( key => key !== STATIC_CACHE )
							.map( key => caches.delete( key ) )
						)
					)
				);
				self.clients.claim();
			}
		);

		/* ================= FETCH ================= */
		self.addEventListener(
			'fetch',
			event => {
				const req = event.request;
				if (req.method !== 'GET') return;
				/* ---- 1. HTML navigation (SEO SAFE) ---- */
				if (req.mode === 'navigate') {
					event.respondWith(
						fetch( req ).catch( () => caches.match( OFFLINE_URL ) )
					);
					return;
				}

				/* ---- 2. Static assets ---- */
				if (
					req.destination === 'style' ||
					req.destination === 'script' ||
					req.destination === 'image' ||
					req.destination === 'font'
				) {

					/* only same-origin */
					if (new URL( req.url ).origin !== self.location.origin) {
						return;
					}
					event.respondWith(
						caches.open( STATIC_CACHE ).then(
							cache => cache.match( req ).then(
								cached => {
									if (cached) return cached;
									return fetch( req ).then(
										response => {
											if (response && response.status === 200) {
												cache.put( req, response.clone() );
											}
											return response;
										}
									);
								}
							)
						)
					);
				}//end if
			}
		);
		<?php
		exit;
	}

	/**
	 * Generates an HTML page to display a message when the user accesses a specific URL while offline.
	 *
	 * @return void HTML content for an offline page will be returned.
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 */
	public function offline_page() {
		$server_request_uri = filter_input( \INPUT_SERVER, 'REQUEST_URI', \FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$path               = wp_parse_url( (string) $server_request_uri, \PHP_URL_PATH );
		if ( 'offline.html' !== basename( (string) $path ) ) {
			return;
		}

		header( 'Content-Type: text/html; charset=utf-8' );
		$lang = get_locale();
		?>
		<!DOCTYPE html>
		<html lang="<?php echo esc_attr( $lang ); ?>">
		<head>
		<meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow">
		<link rel="canonical" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<title><?php echo esc_html__( 'Offline', 'fold' ); ?></title>
		<style>
			body { font-family: sans-serif; text-align: center; padding: 2rem; }
		</style>
		</head>
		<body>
			<h1><?php echo esc_html__( 'You are offline', 'fold' ); ?></h1>
			<p><?php echo esc_html__( 'Please check your internet connection', 'fold' ); ?></p>
		</body>
		</html>
		<?php
		exit;
	}

	/**
	 * Registers a service worker in PHP to enable offline capabilities.
	 *
	 * @return void
	 */
	public function register_service_worker() {
		?>
		<script>
			if ('serviceWorker' in navigator) {
				navigator.serviceWorker.register('/sw.js');
			}
		</script>
		<?php
	}

	/**
	 * Generates HTML code for displaying toast notifications prompting users to install an app on Android/Desktop or add to home screen on iOS.
	 *
	 * @return void
	 */
	public function toast() {
		?>
		<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1060;">
			<!-- Toast Android / Desktop -->
			<div id="pwa-install-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
				<strong class="me-auto">
					<?php echo esc_html__( 'Install App', 'fold' ); ?>
				</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast"
					aria-label="<?php echo esc_attr__( 'Close', 'fold' ); ?>">
				</button>
				</div>
				<div class="toast-body">
				<?php echo esc_html__( 'For faster access, install the app.', 'fold' ); ?>
					<div class="mt-2 d-flex gap-2">
					<button id="pwa-install-confirm" class="btn btn-primary btn-sm">
						<?php echo esc_html__( 'Install', 'fold' ); ?>
					</button>
					<button id="pwa-install-dismiss" class="btn btn-secondary btn-sm">
						<?php echo esc_html__( 'Later', 'fold' ); ?>
					</button>
					</div>
				</div>
			</div>

			<!-- Toast iOS -->
			<div id="pwa-ios-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
				<strong class="me-auto">
					<?php echo esc_html__( 'Add to Home Screen', 'fold' ); ?>
				</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast"
					aria-label="<?php echo esc_attr__( 'Close', 'fold' ); ?>">
				</button>
				</div>
				<div class="toast-body">
					<?php
					printf(
						/* translators: 1: iOS share icon, 2: "Add to Home Screen" label */
						esc_html__( 'In Safari, tap %1$s and choose %2$s.', 'fold' ),
						'<span class="ios-share-icon mx-1 align-middle" aria-hidden="true">
							<!-- iOS Share Icon -->
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none"
								stroke="currentColor" stroke-width="2"
								stroke-linecap="round" stroke-linejoin="round"
								style="vertical-align: middle;">
								<path d="M12 3v12"></path>
								<path d="M8 7l4-4 4 4"></path>
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							</svg>
						</span>',
						'<strong>' . esc_html__( 'Add to Home Screen', 'fold' ) . '</strong>'
					);
					?>
					<div class="mt-2 text-end">
						<button id="pwa-ios-dismiss" class="btn btn-secondary btn-sm">
							<?php echo esc_html__( 'OK', 'fold' ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Enqueues a script named 'pwa-install' with a specific version and additional attributes for a WordPress theme.
	 *
	 * @return void
	 */
	public function wpa_install() {
		$theme_version = wp_get_theme()->get( 'Version' );
		/** @psalm-suppress RedundantConditionGivenDocblockType, DocblockTypeContradiction */
		$theme_version = ! is_array( $theme_version ) ? $theme_version : '';
		wp_enqueue_script(
			'pwa-install',
			get_stylesheet_directory_uri() . '/assets/js/pwa-install.js',
			array(),
			$theme_version,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}

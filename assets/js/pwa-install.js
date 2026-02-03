/**
 * PWA Install Script
 *
 * @package Fold
 */

const WEEK = 7 * 24 * 60 * 60 * 1000;
// Detect iOS
function isIOS() {
	return /iphone|ipad|ipod/i.test( navigator.userAgent );
}

// Detect Real Safari (Not Chrome)
function isSafari() {
	return /^((?!chrome|android).)*safari/i.test( navigator.userAgent );
}

// is PWA installed on iOS
function isInStandaloneMode() {
	return ('standalone' in navigator) && navigator.standalone;
}

// Check the time
function canShow(key) {
	const last = localStorage.getItem( key );
	if ( ! last) return true;
	return ( Date.now() - parseInt( last, 10 ) ) > WEEK;
}

/* ===== iOS FLOW ===== */
if ( isIOS() && isSafari() && ! isInStandaloneMode() && canShow( 'pwa-ios-dismissed-at' ) ) {

	const iosToastEl = document.getElementById( 'pwa-ios-toast' );

	if (iosToastEl && window.bootstrap) {
		const toast = new bootstrap.Toast( iosToastEl, { delay: 12000 } );
		toast.show();
		const dismissBtn = document.getElementById( 'pwa-ios-dismiss' );
		dismissBtn?.addEventListener(
			'click',
			() => {
				localStorage.setItem( 'pwa-ios-dismissed-at', Date.now().toString() );
				toast.hide();
			}
		);
	}
}

/* ===== ANDROID / DESKTOP FLOW ===== */
let deferredPrompt;
const installToastEl = document.getElementById( 'pwa-install-toast' );
const confirmBtn     = document.getElementById( 'pwa-install-confirm' );
const dismissBtn     = document.getElementById( 'pwa-install-dismiss' );

window.addEventListener(
	'beforeinstallprompt',
	(e) => {
		if ( ! canShow( 'pwa-install-dismissed-at' ) ) return;
		e.preventDefault();
		deferredPrompt = e;
		if (installToastEl && window.bootstrap) {
			const toast = new bootstrap.Toast( installToastEl, { delay: 10000 } );
			toast.show();
		}
	}
);

confirmBtn?.addEventListener(
	'click',
	() => {
		if ( ! deferredPrompt ) return;
		deferredPrompt.prompt();
		deferredPrompt.userChoice.finally( () => deferredPrompt = null );
	}
);

dismissBtn?.addEventListener(
	'click',
	() => {
		localStorage.setItem( 'pwa-install-dismissed-at', Date.now().toString() );
		bootstrap.Toast.getInstance( installToastEl )?.hide();
	}
);

window.addEventListener(
	'appinstalled',
	() => {
		localStorage.setItem( 'pwa-installed', '1' );
	}
);

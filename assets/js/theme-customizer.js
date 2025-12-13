/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 *
 * @package Fold
 */

( function ( $ ) {

	/*
	wp.customize( 'YOUR_SETTING_ID', function( value ) {
		value.bind( function( newVal ) {
			// Do stuff (newVal variable contains your "new" setting data)
		} );
	} );
	*/

	// Update the site title in real time...
	wp.customize(
		'blogname',
		function ( value ) {
			value.bind(
				function ( newVal ) {
					$( '.site-title a' ).html( newVal );
				}
			);
		}
	);

	// Update the site description in real time...
	wp.customize(
		'blogdescription',
		function ( value ) {
			value.bind(
				function ( newVal ) {
					$( '.site-description' ).html( newVal );
				}
			);
		}
	);

	// Update site title color in real time...
	wp.customize(
		'header_textcolor',
		function ( value ) {
			value.bind(
				function ( newVal ) {
					$( '#HeaderCarousel .carousel-caption h1' ).css( 'color', newVal );
					$( '#HeaderCarousel .carousel-caption h4' ).css( 'color', newVal );
					$( '#HeaderCarousel .carousel-caption h4 a' ).css( 'color', newVal );
					$( '#HeaderCarousel .carousel-caption h5' ).css( 'color', newVal );
					$( '#HeaderCarousel .carousel-caption p' ).css( 'color', newVal );
					$( '#top-menu.in-top #menu-main-menu>li>a' ).css( 'color', newVal );
					$( '#top-menu.in-top #second-header-bar>li>a' ).css( 'color', newVal );
					$( '#top-menu.in-top .navbar-toggler-icon' ).css( 'background-color', newVal );
					$( '#top-menu.in-top .navbar-nav > li::after' ).css( 'border-color', newVal );
					$( '#top-menu.in-top .navbar-nav > a::after' ).css( 'border-color', newVal );
				}
			);
		}
	);

	// Update site background color...
	wp.customize(
		'background_color',
		function ( value ) {
			value.bind(
				function ( newVal ) {
					$( 'body' ).css( 'background-color', newVal );
				}
			);
		}
	);
} )( jQuery );

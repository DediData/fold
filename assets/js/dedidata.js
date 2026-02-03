/**
 * DediData Script
 *
 * @package Fold
 */

jQuery( document ).ready(
	function ( $ ) {
		// marking your touch and wheel event listeners as `passive` to improve your page's scroll performance.
		jQuery.event.special.touchstart = {
			setup: function (_, ns, handle) {
				this.addEventListener( "touchstart", handle, {passive: ! ns.includes( "noPreventDefault" )} );
			}
		};
		jQuery.event.special.touchmove  = {
			setup: function (_, ns, handle) {
				this.addEventListener( "touchmove", handle, {passive: ! ns.includes( "noPreventDefault" )} );
			}
		};
		jQuery.event.special.wheel      = {
			setup: function (_, ns, handle) {
				this.addEventListener( "wheel", handle, {passive: true} );
			}
		};
		jQuery.event.special.mousewheel = {
			setup: function (_, ns, handle) {
				this.addEventListener( "mousewheel", handle, {passive: true} );
			}
		};

		// Move some of main menu items to second header if there isn't any menu there
		const $first = $( '#first-header-bar ul' ).first();
		if ( $first.length) {
			let $second      = $( '#second-header-bar ul' ).first();
			const firstCount = $first.children( 'li' ).length;
			if (firstCount > 1) {
				// create ul if there isn't any in second
				if ( ! $second.length ) {
					$second = $( '<ul id="menu-top-bar-first" class="navbar-nav mx-2"></ul>' );
					$( '#second-header-bar' ).prepend( $second );
					if ( $( '#first-header-bar ul' ).hasClass( 'normal-menu' ) ) {
						$( '#second-header-bar' ).addClass( 'normal-menu' );
					} else {
						$( '#second-header-bar' ).addClass( 'mega-menu' );
					}
					const liCount = $first.children( 'li' ).length;
					if (liCount > 1) {
						let half      = Math.floor( liCount / 2 );
						half         += 1;
						const $toMove = $first.children( 'li' ).slice( half );
						$toMove.appendTo( $second );
					}
				}
			}
		}//end if

		// Change theme light/dark
		// Reading theme from localStorage
		let currentData = $( ':root' ).attr( 'data-bs-theme' );
		if ( currentData !== 'light' && currentData !== 'dark' ) {
			currentData = 'light';
		}
		let savedTheme = currentData;
		if ( ! $( 'body' ).hasClass( 'light-only-theme' ) && ! $( 'body' ).hasClass( 'dark-only-theme' ) ) {
			savedTheme = localStorage.getItem( 'theme' ) || currentData;
		}
		$( ':root' ).attr( 'data-bs-theme', savedTheme );
		$( '#theme-toggle' ).text( savedTheme === 'dark' ? '☀️' : '🌙' );
		if ( savedTheme === 'dark' ) {
			if ( ! $( 'body' ).hasClass( 'dark-only-theme' ) && null !== localStorage.getItem( 'theme' ) && currentData !== localStorage.getItem( 'theme' ) ) {
				$( '.bg-light' ).removeClass( 'bg-light' ).addClass( 'bg-TEMP' );
				$( '.bg-dark' ).removeClass( 'bg-dark' ).addClass( 'bg-light' );
				$( '.bg-TEMP' ).removeClass( 'bg-TEMP' ).addClass( 'bg-dark' );
			}
			$( 'body.light-theme' ).removeClass( 'light-theme' ).addClass( 'dark-theme' );
			$( 'body' ).addClass( 'is-dark-theme' );
		} else {
			if ( ! $( 'body' ).hasClass( 'light-only-theme' ) && null !== localStorage.getItem( 'theme' ) && currentData !== localStorage.getItem( 'theme' ) ) {
				$( '.bg-dark' ).removeClass( 'bg-dark' ).addClass( 'bg-TEMP' );
				$( '.bg-light' ).removeClass( 'bg-light' ).addClass( 'bg-dark' );
				$( '.bg-TEMP' ).removeClass( 'bg-TEMP' ).addClass( 'bg-light' );
			}
			$( 'body.dark-theme' ).removeClass( 'dark-theme' ).addClass( 'light-theme' );
			$( 'body' ).removeClass( 'is-dark-theme' );
		}
		// Click on button
		$( '#theme-toggle' ).on(
			'click',
			function () {
				const current = $( ':root' ).attr( 'data-bs-theme' );
				const next    = current === 'dark' ? 'light' : 'dark';
				$( ':root' ).attr( 'data-bs-theme', next );
				localStorage.setItem( 'theme', next );
				$( this ).text( next === 'dark' ? '☀️' : '🌙' );

				if ( next === 'dark' ) {
					$( '.bg-light' ).removeClass( 'bg-light' ).addClass( 'bg-TEMP' );
					$( '.bg-dark' ).removeClass( 'bg-dark' ).addClass( 'bg-light' );
					$( '.bg-TEMP' ).removeClass( 'bg-TEMP' ).addClass( 'bg-dark' );
					$( 'body.light-theme' ).removeClass( 'light-theme' ).addClass( 'dark-theme' );
					$( 'body' ).removeClass( 'light-theme' ).addClass( 'is-dark-theme' );
				} else {
					$( '.bg-dark' ).removeClass( 'bg-dark' ).addClass( 'bg-TEMP' );
					$( '.bg-light' ).removeClass( 'bg-light' ).addClass( 'bg-dark' );
					$( '.bg-TEMP' ).removeClass( 'bg-TEMP' ).addClass( 'bg-light' );
					$( 'body.dark-theme' ).removeClass( 'dark-theme' ).addClass( 'light-theme' );
					$( 'body' ).removeClass( 'is-dark-theme' );
				}
			}
		);

		$( '#top-menu img' ).addClass( 'transition' );
		$( '#no-header-top-menu img' ).addClass( 'transition' );

		/* Start open submenus be default on mobile devices */
		function openSubMenus() {
			if ($( window ).width() < 768) {
				$( "#top-navbar-collapse .menu-item-has-children" ).addClass( 'open' );
				$( "#header-navbar-collapse .menu-item-has-children" ).addClass( 'open' );
				$( ".widget_nav_menu .menu-item-has-children" ).addClass( 'open' );
				$( "#top-navbar-collapse .menu-item-has-children a" ).attr( 'aria-expanded', 'true' );
				$( "#header-navbar-collapse .menu-item-has-children a" ).attr( 'aria-expanded', 'true' );
				$( ".widget_nav_menu .menu-item-has-children a" ).attr( 'aria-expanded', 'true' );
			} else {
				$( "#top-navbar-collapse .menu-item-has-children" ).removeClass( 'open' );
				$( "#header-navbar-collapse .menu-item-has-children" ).removeClass( 'open' );
				$( ".widget_nav_menu .menu-item-has-children" ).removeClass( 'open' );
				$( "#top-navbar-collapse .menu-item-has-children a" ).attr( 'aria-expanded', 'false' );
				$( "#header-navbar-collapse .menu-item-has-children a" ).attr( 'aria-expanded', 'false' );
				$( ".widget_nav_menu .menu-item-has-children a" ).attr( 'aria-expanded', 'false' );
			}
		}

		$( '#top-menu .navbar-toggler' ).click(
			function () {
				setTimeout( openSubMenus, 100 );
			}
		);
		$( '#no-header-top-menu .navbar-toggler' ).click(
			function () {
				setTimeout( openSubMenus, 100 );
			}
		);
		$( '#header-menu .navbar-toggler' ).click(
			function () {
				setTimeout( openSubMenus, 100 );
			}
		);
		openSubMenus();
		/* End open submenus be default on mobile devices */

		let isTouchDevice = (
			('ontouchstart' in window) ||
			(navigator.maxTouchPoints > 0) ||
			(navigator.msMaxTouchPoints > 0)
		);

		function sleep(milliseconds) {
			let start = new Date().getTime();
			for (let i = 0; i < 1e7; i++) {
				if ((new Date().getTime() - start) > milliseconds) {
					break;
				}
			}
		}

		/*
		if ( ! isTouchDevice ) {

			// open top menu item on focus in
			$( ".dropdown" ).hover(
				function () {
					if ( ! ( $( this ).hasClass( 'open' ) ) ) {
						$( ".dropdown" ).removeClass( "open" );
						$( this ).addClass( "open" );
					}
				},
				function () {
					if ($( this ).hasClass( 'open' )) {
						// sleep( 50 );
						$( this ).removeClass( "open" );
					}
				}
			);

			// prevent blinking
			$( ".submenu-link" ).click(
				function (e) {
					e.stopPropagation();
				}
			);
		}//end if

		// open top menu item on focus in
		$( '.dropdown' ).focusin(
			function () {
				if ( ! ( $( this ).hasClass( 'open' ) ) ) {
					$( ".dropdown" ).removeClass( "open" );
					$( this ).addClass( "open" );
				}
			}
		);

		*/

		let dropDownT = $( '.dropDownT' );
		/* Double-click on root items links on Touch devices, and Click on non touch devices to open link */
		if (isTouchDevice) {
			dropDownT.dblclick(
				function () {
					window.location = $( this ).attr( "href" );
				}
			);
		} else {
			$( ".dropDownT" ).click(
				function () {
					window.location = $( this ).attr( "href" );
					// e.stopPropagation();
				}
			);
		}

		// open first level links when double tap
		let tapped = false;
		dropDownT.on(
			"touchstart",
			function () {
				if ( ! tapped ) {
					// if tap is not set, set up single tap
					tapped = setTimeout(
						function () {
							tapped = null;
							// Insert things you want to do when single tapped
						},
						300
						// wait 300ms then run single click code
					);
				} else {
					// tapped within 300ms of last tap. double tap
					clearTimeout( tapped );
					// stop single tap callback
					tapped = null;
					// insert things you want to do when double tapped
					window.location = $( this ).attr( "href" );
				}
			}
		);

		function SetTopMegaMenu() {
			let Window5   = Math.round( $( window ).width() * 0.05 );
			let Window10  = Math.round( $( window ).width() * 0.1 );
			let Window50  = Math.round( $( window ).width() * 0.50 );
			let Window90  = Math.round( $( window ).width() * 0.9 );
			let Window95  = Math.round( $( window ).width() * 0.95 );
			let Window100 = Math.round( $( window ).width() );
			if ($( "body" ).css( 'direction' ) === 'rtl') {
				// RTL
				$( ".rtl .top-menu .mega-menu .dropdown-menu" ).each(
					function () {
						let MegaMenuDropdown    = $( this );
						let ParentListItemRight = Math.round( MegaMenuDropdown.parent().offset().left + MegaMenuDropdown.parent().outerWidth() );
						let ListsItemsLength    = $( this ).children( "li" ).length;
						if ($( window ).width() >= 1024) {
							if (ListsItemsLength > 3) {
								MegaMenuDropdown.css( 'width', '1000px' );
							} else if (ListsItemsLength === 3) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								MegaMenuDropdown.css( 'right', '0' );
								MegaMenuDropdown.css( 'left', 'auto' );
								if ( MegaMenuDropdown.offset().left < Window10 ) {
									MegaMenuDropdown.css( 'right', Math.round( ( ParentListItemRight - Window100 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2  ) ) + 'px' );
								}
							} else {
								// Parent is in the left side
								MegaMenuDropdown.css( 'right', 'auto' );
								MegaMenuDropdown.css( 'left', '0' );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window90 ) {
									MegaMenuDropdown.css( 'left', 'auto' );
									MegaMenuDropdown.css( 'right', Math.round( ( ParentListItemRight - Window100 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2  ) ) + 'px' );
								}
							}
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							if (ListsItemsLength > 2) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								MegaMenuDropdown.css( 'right', '0' );
								MegaMenuDropdown.css( 'left', 'auto' );
								if ( MegaMenuDropdown.offset().left < Window5 ) {
									MegaMenuDropdown.css( 'right', Math.round( ( ParentListItemRight - Window100 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2  ) ) + 'px' );
								}
							} else {
								// Parent is in the left side
								MegaMenuDropdown.css( 'right', 'auto' );
								MegaMenuDropdown.css( 'left', '0' );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window95 ) {
									MegaMenuDropdown.css( 'left', 'auto' );
									MegaMenuDropdown.css( 'right', Math.round( ( ParentListItemRight - Window100 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2  ) ) + 'px' );
								}
							}
						} else if ( $( window ).width() < 768) {
							MegaMenuDropdown.css( 'right', '0' );
							MegaMenuDropdown.css( 'left', 'auto' );
							MegaMenuDropdown.css( 'width', '100%' );
						}//end if
					}
				);
			} else {
				// LTR
				$( ".top-menu .mega-menu .dropdown-menu" ).each(
					function () {
						let MegaMenuDropdown   = $( this );
						let ParentListItemLeft = Math.round( MegaMenuDropdown.parent().offset().left );
						let ListsItemsLength   = $( this ).children( "li" ).length;
						if ($( window ).width() >= 1024) {
							if (ListsItemsLength > 3) {
								MegaMenuDropdown.css( 'width', '1000px' );
							} else if (ListsItemsLength === 3) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								MegaMenuDropdown.css( 'left', '0' );
								MegaMenuDropdown.css( 'right', 'auto' );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window90 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentListItemLeft * -1 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2 ) ) + 'px' );
								}
							} else {
								// Parent is in the right side
								MegaMenuDropdown.css( 'left', 'auto' );
								MegaMenuDropdown.css( 'right', '0' );
								if ( MegaMenuDropdown.offset().left < Window10 ) {
									MegaMenuDropdown.css( 'right', 'auto' );
									MegaMenuDropdown.css( 'left', Math.round( ( ParentListItemLeft * -1 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2  ) ) + 'px' );
								}
							}
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							if (ListsItemsLength > 2) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								MegaMenuDropdown.css( 'left', '0' );
								MegaMenuDropdown.css( 'right', 'auto' );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window95 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentListItemLeft * -1 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2 ) ) + 'px' );
								}
							} else {
								// Parent is in the right side
								MegaMenuDropdown.css( 'left', 'auto' );
								MegaMenuDropdown.css( 'right', '0' );
								if ( MegaMenuDropdown.offset().left < Window5 ) {
									MegaMenuDropdown.css( 'right', 'auto' );
									MegaMenuDropdown.css( 'left', Math.round( ( ParentListItemLeft * -1 ) + ( ( Window100 - MegaMenuDropdown.outerWidth() ) / 2  ) ) + 'px' );
								}
							}
						} else if ( $( window ).width() < 768) {
							MegaMenuDropdown.css( 'right', '0' );
							MegaMenuDropdown.css( 'left', 'auto' );
							MegaMenuDropdown.css( 'width', '100%' );
						}//end if
					}
				);
			}//end if
		}

		SetTopMegaMenu();

		function SetHeaderMegaMenu() {
			let Window5  = $( window ).width() * 0.05;
			let Window50 = $( window ).width() * 0.50;
			let Window95 = $( window ).width() * 0.95;
			if ($( "body" ).css( 'direction' ) === 'rtl') {
				// RTL
				$( ".rtl #header-menu .mega-menu .dropdown-menu" ).each(
					function () {
						let MegaMenuDropdown    = $( this );
						let ParentContainer     = MegaMenuDropdown.parent().parent().parent().parent();
						let ParentListItemRight = Math.round( MegaMenuDropdown.parent().offset().left + MegaMenuDropdown.parent().outerWidth() );
						let ParentListItemLeft  = Math.round( MegaMenuDropdown.parent().offset().left );
						let ListsItemsLength    = $( this ).children( "li" ).length;
						if ($( window ).width() >= 1024) {
							if (ListsItemsLength > 3) {
								MegaMenuDropdown.css( 'width', '1000px' );
							} else if (ListsItemsLength === 3) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							MegaMenuDropdown.css( "right", "auto" );
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								MegaMenuDropdown.css( "left", "auto" );
								if ( MegaMenuDropdown.offset().left < Window5 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the left side
								MegaMenuDropdown.css( "left", ParentListItemLeft - ParentContainer.offset().left + 'px' );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window95 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							if (ListsItemsLength > 2) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							MegaMenuDropdown.css( 'right', 'auto' );
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								MegaMenuDropdown.css( 'left', 'auto' );
								if ( MegaMenuDropdown.offset().left < Window5 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the left side
								MegaMenuDropdown.css( 'left', ParentListItemLeft - ParentContainer.offset().left + 'px' );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window95 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}//end if
						} else if ( $( window ).width() < 768) {
							MegaMenuDropdown.css( 'right', 'auto' );
							MegaMenuDropdown.css( 'left', 'auto' );
							MegaMenuDropdown.css( 'width', '100%' );
							MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
						}//end if
					}
				);
			} else {
				// LTR
				$( "#header-menu .mega-menu .dropdown-menu" ).each(
					function () {
						let MegaMenuDropdown    = $( this );
						let ParentContainer     = MegaMenuDropdown.parent().parent().parent().parent();
						let ParentListItemRight = Math.round( MegaMenuDropdown.parent().offset().left + MegaMenuDropdown.parent().outerWidth() );
						let ParentListItemLeft  = Math.round( MegaMenuDropdown.parent().offset().left );
						let ListsItemsLength    = $( this ).children( "li" ).length;
						if ($( window ).width() >= 1024) {
							if (ListsItemsLength > 3) {
								MegaMenuDropdown.css( 'width', '1000px' );
							} else if (ListsItemsLength === 3) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							MegaMenuDropdown.css( "left", "auto" );
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								MegaMenuDropdown.css( "right", "auto" );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window95 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the right side
								MegaMenuDropdown.css( "right", Math.round( ( ParentContainer.offset().left + ParentContainer.outerWidth() ) - ParentListItemRight ) + 'px' );
								if ( MegaMenuDropdown.offset().left < Window5 ) {
									MegaMenuDropdown.css( 'right', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							if (ListsItemsLength > 2) {
								MegaMenuDropdown.css( 'width', '750px' );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( 'width', '500px' );
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( 'width', '250px' );
							}//end if
							MegaMenuDropdown.css( "left", "auto" );
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								MegaMenuDropdown.css( "right", "auto" );
								if ( MegaMenuDropdown.offset().left + MegaMenuDropdown.outerWidth() > Window95 ) {
									MegaMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the right side
								MegaMenuDropdown.css( "right", Math.round( ( ParentContainer.offset().left + ParentContainer.outerWidth() ) - ParentListItemRight ) + 'px' );
								if ( MegaMenuDropdown.offset().left < Window5 ) {
									MegaMenuDropdown.css( 'right', Math.round( ( ParentContainer.outerWidth() - MegaMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}
						} else if ( $( window ).width() < 768) {
							MegaMenuDropdown.css( 'right', 'auto' );
							MegaMenuDropdown.css( 'left', 'auto' );
							MegaMenuDropdown.css( 'width', '100%' );
							MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
						}//end if
					}
				);
			}//end if
		}

		SetHeaderMegaMenu();

		function SetNormalMenu() {
			let Window5  = $( window ).width() * 0.05;
			let Window50 = $( window ).width() * 0.50;
			let Window95 = $( window ).width() * 0.95;
			if ($( "body" ).css( 'direction' ) === 'rtl') {
				// RTL
				$( ".rtl .normal-menu .dropdown-menu" ).each(
					function () {
						let NormalMenuDropdown = $( this );
						NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
						let ParentListItemRight = NormalMenuDropdown.parent().offset().left + NormalMenuDropdown.parent().outerWidth();
						if ($( window ).width() >= 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								NormalMenuDropdown.css( 'right', '0' );
								NormalMenuDropdown.css( 'left', 'auto' );
							} else {
								// Parent is in the left side
								NormalMenuDropdown.css( 'right', 'auto' );
								NormalMenuDropdown.css( 'left', '0' );
							}//end if
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								NormalMenuDropdown.css( 'right', '0' );
								NormalMenuDropdown.css( 'left', 'auto' );
							} else {
								// Parent is in the left side
								NormalMenuDropdown.css( 'left', '0' );
								NormalMenuDropdown.css( 'right', 'auto' );
							}//end if
						} else if ( $( window ).width() < 768) {
							NormalMenuDropdown.css( "width", "100%" );
						}//end if
					}
				);
				$( ".rtl #header-menu .normal-menu .dropdown-menu" ).each(
					function () {
						let NormalMenuDropdown  = $( this );
						let ParentListItemRight = NormalMenuDropdown.parent().offset().left + NormalMenuDropdown.parent().outerWidth();
						let ParentContainer     = NormalMenuDropdown.parent().parent().parent().parent();
						let ParentListItemLeft  = Math.round( NormalMenuDropdown.parent().offset().left );
						NormalMenuDropdown.css( "right", "auto" );
						NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
						if ($( window ).width() >= 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								if ( NormalMenuDropdown.offset().left < Window5 ) {
									NormalMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the left side
								NormalMenuDropdown.css( "left", ParentListItemLeft - ParentContainer.offset().left + 'px' );
								if ( NormalMenuDropdown.offset().left + NormalMenuDropdown.outerWidth() > Window95 ) {
									NormalMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemRight < 270) {
								NormalMenuDropdown.css( 'left', 'auto' );
							}
							if (ParentListItemRight > Window50) {
								// Parent is in the right side
								if ( NormalMenuDropdown.offset().left < Window5 ) {
									NormalMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the left side
								NormalMenuDropdown.css( "left", ParentListItemLeft - ParentContainer.offset().left + 'px' );
								if ( NormalMenuDropdown.offset().left + NormalMenuDropdown.outerWidth() > Window95 ) {
									NormalMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}
						} else if ( $( window ).width() < 768) {
							NormalMenuDropdown.css( "width", "100%" );
						}//end if
					}
				);
			} else {
				// LTR
				$( ".normal-menu .dropdown-menu" ).each(
					function () {
						let NormalMenuDropdown = $( this );
						NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
						let ParentListItemLeft = NormalMenuDropdown.parent().offset().left;
						if ($( window ).width() >= 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								NormalMenuDropdown.css( 'left', '0' );
								NormalMenuDropdown.css( 'right', 'auto' );
							} else {
								// Parent is in the right side
								NormalMenuDropdown.css( 'left', 'auto' );
								NormalMenuDropdown.css( 'right', '0' );
							}//end if
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								NormalMenuDropdown.css( 'left', '0' );
								NormalMenuDropdown.css( 'right', 'auto' );
							} else {
								// Parent is in the right side
								NormalMenuDropdown.css( 'left', 'auto' );
								NormalMenuDropdown.css( 'right', '0' );
							}//end if
						} else if ( $( window ).width() < 768) {
							NormalMenuDropdown.css( "width", "100%" );
						}//end if
					}
				);
				$( "#header-menu .normal-menu .dropdown-menu" ).each(
					function () {
						let NormalMenuDropdown  = $( this );
						let ParentListItemRight = NormalMenuDropdown.parent().offset().left + NormalMenuDropdown.parent().outerWidth();
						let ParentContainer     = NormalMenuDropdown.parent().parent().parent().parent();
						let ParentListItemLeft  = Math.round( NormalMenuDropdown.parent().offset().left );
						NormalMenuDropdown.css( "left", "auto" );
						NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
						if ($( window ).width() >= 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								NormalMenuDropdown.css( "right", "auto" );
								if ( NormalMenuDropdown.offset().left + NormalMenuDropdown.outerWidth() > Window95 ) {
									NormalMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the right side
								NormalMenuDropdown.css( "right", Math.round( ( ParentContainer.offset().left + ParentContainer.outerWidth() ) - ParentListItemRight ) + 'px' );
								if ( NormalMenuDropdown.offset().left < Window5 ) {
									NormalMenuDropdown.css( 'right', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}
						} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
							NormalMenuDropdown.css( "width", "270px" );
							if (ParentListItemRight < 270) {
								NormalMenuDropdown.css( 'left', 'auto' );
							}
							if (ParentListItemLeft < Window50) {
								// Parent is in the left side
								NormalMenuDropdown.css( "right", "auto" );
								if ( NormalMenuDropdown.offset().left + NormalMenuDropdown.outerWidth() > Window95 ) {
									NormalMenuDropdown.css( 'left', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							} else {
								// Parent is in the right side
								NormalMenuDropdown.css( "right", Math.round( ( ParentContainer.offset().left + ParentContainer.outerWidth() ) - ParentListItemRight ) + 'px' );
								if ( NormalMenuDropdown.offset().left < Window5 ) {
									NormalMenuDropdown.css( 'right', Math.round( ( ParentContainer.outerWidth() - NormalMenuDropdown.outerWidth() ) / 2 ) + 'px' );
								}
							}
						} else if ( $( window ).width() < 768) {
							NormalMenuDropdown.css( "width", "100%" );
						}//end if
					}
				);
			}//end if
		}

		SetNormalMenu();

		let resizeTimer;
		$( window ).on(
			'resize',
			function () {
				// Clear any existing timer
				clearTimeout( resizeTimer );
				resizeTimer = setTimeout(
					function () {
						// Call the SetTopMegaMenu function after 1 second
						SetTopMegaMenu();
						SetHeaderMegaMenu();
						SetNormalMenu();
						setTopMenuBGColor();
						openSubMenus();
						setPageFooterHeight();
					},
					1000
				);
			}
		);


		// scroll to top
		$( window ).scroll(
			function () {
				if ($( this ).scrollTop() > 50) {
					$( '#back-to-top' ).fadeIn();
				} else {
					$( '#back-to-top' ).fadeOut();
				}
			}
		);
		// scroll body to 0px on click
		$( '#back-to-top' ).click(
			function () {
				$( 'body,html' ).animate(
					{
						scrollTop: 0
					},
					1000
				);
				return false;
			}
		);

		let body = $( 'body' );
		$( '.dropdown-menu li a' ).css( 'font-weight', $( '.dropdown-menu>li>a' ).css( 'font-weight' ) );
		$( '#page-footer button' ).css( 'color', body.css( 'color' ) );
		$( '#page-footer input' ).css( 'color', body.css( 'color' ) );
		$( '#page-footer optgroup' ).css( 'color', body.css( 'color' ) );
		$( '#page-footer select' ).css( 'color', body.css( 'color' ) );
		$( '#page-footer textarea' ).css( 'color', body.css( 'color' ) );

		// gallery
		$( 'a[href$=".jpg"], a[href$=".jpeg"], a[href$=".gif"], a[href$=".webp"], a[href$=".png"]' ).attr( 'data-lightbox', 'separate' ).attr( 'data-title', $( this ).find( 'img' ).attr( 'alt' ) );
		$( '.gallery' ).each(
			function () {
				// set the rel for each gallery

				let $links = $( this ).find(
					'.gallery-icon a[href$=".jpg"], .gallery-icon a[href$=".jpeg"], .gallery-icon a[href$=".gif"], .gallery-icon a[href$=".webp"], .gallery-icon a[href$=".png"]'
				);

				$links.attr( 'data-lightbox', 'group-' + $( this ).attr( 'id' ) );

				$( this ).find( '.gallery-icon a' ).each(
					function () {
						$( this ).attr( 'data-title', $( this ).find( 'img' ).attr( 'alt' ) );
					}
				);
			}
		);
		lightbox.option(
			{
				'alwaysShowNavOnTouchDevices': true,
				'wrapAround': true
			}
		);

		// add class to woocommerce product categories
		$( '.widget_product_categories .cat-item' ).not( '.cat-parent' ).addClass( 'shadow-sm rounded p-2 my-2' );
		$( '.widget_product_categories .cat-item.cat-parent' ).addClass( 'my-2' );
		if ( $( '#top-menu' ).length ) {
			$( '.woocommerce-store-notice.demo_store' ).css( 'top', '53px' ).css( 'z-index', '1000' );
		}
		if ( $( '#no-header-top-menu' ).length ) {
			$( '.woocommerce-store-notice.demo_store' ).css( 'position', 'unset' ).css( 'z-index', '1000' );
		}

		let currentTop;
		if (body.hasClass( 'admin-bar' )) {
			if ( $( '#no-header-top-menu' ).length ) {
				currentTop = $( '.admin-bar #no-header-top-menu' ).offset().top;
			} else {
				currentTop = $( '.admin-bar #top-menu' ).offset().top;
			}
		}

		// top navigation
		function setTopMenuBGColor() {
			const currentTheme = $( ':root' ).attr( 'data-bs-theme' );
			let ThemeBg        = 'bg-' + currentTheme;
			if ($( document ).scrollTop() < 50) {
				// Scroll is in top
				$( "#top-menu" ).addClass( "in-top" );
				$( "#top-menu" ).removeClass( "not-in-top" );

				// 600 Because WP admin bar hides on lower 600px
				if ($( window ).width() < 600 && currentTop) {
					// Set top position in mobile devices under 600px
					// $( ".admin-bar #top-menu" ).css( 'top', '46' + 'px' );
					$( ".admin-bar #top-menu" ).css( 'top', 'auto' );
				}

				if ($( window ).width() < 768) {

					$( "#top-menu:has(.closed)" ).removeClass( ThemeBg );
					$( "#top-menu:not(:has(.opened))" ).removeClass( ThemeBg );
					$( "#top-menu:has(.closed) .container-fluid" ).removeClass( ThemeBg );
					$( "#top-menu:not(:has(.closed)) .container-fluid" ).removeClass( ThemeBg );

					$( '#top-menu' ).on(
						'shown.bs.collapse',
						function () {
							$( "#top-menu" ).addClass( "opened" );
							$( "#top-menu" ).removeClass( "closed" );
							$( "#top-menu" ).addClass( ThemeBg );
							$( "#top-menu .container-fluid" ).addClass( ThemeBg );
						}
					)

					$( '#top-menu' ).on(
						'hidden.bs.collapse',
						function () {
							$( "#top-menu" ).addClass( "closed" );
							$( "#top-menu" ).removeClass( "opened" );
							if ($( document ).scrollTop() < 50) {
								$( "#top-menu" ).removeClass( ThemeBg );
								$( "#top-menu .container-fluid" ).removeClass( ThemeBg );
							}
						}
					)
				} else {
					$( "#top-menu" ).removeClass( "shadow-lg" );
					$( "#top-menu #first-header-bar" ).removeClass( ThemeBg );
					$( "#top-menu #second-header-bar" ).removeClass( ThemeBg );
				}//end if
			} else {
				// Scroll is not in top
				$( "#top-menu" ).removeClass( "in-top" );
				$( "#top-menu" ).addClass( "not-in-top" );

				// 600 Because WP admin bar hides on lower 600px
				if ($( window ).width() < 600 && currentTop) {
					// $( ".admin-bar #top-menu" ).css( 'top', currentTop - 46 + 'px' );
					$( ".admin-bar #top-menu" ).css( 'top', '0' );
				} else {
					$( ".admin-bar #top-menu" ).css( 'top', 'auto' );
				}

				if ($( window ).width() < 768) {
					$( "#top-menu" ).addClass( ThemeBg );
					$( "#top-menu" ).addClass( "bg-gradient" );
					$( "#top-menu .container-fluid" ).addClass( ThemeBg );
				} else {
					$( "#top-menu" ).addClass( "shadow-lg" );
					$( "#top-menu #first-header-bar" ).addClass( ThemeBg );
					$( "#top-menu #second-header-bar" ).addClass( ThemeBg );
				}
			}//end if
		}

		setTopMenuBGColor();
		$( document ).on( "scroll", setTopMenuBGColor );

		$( '#searchModal' ).on(
			'shown.bs.modal',
			function () {
				$( this ).find( 'input[autofocus]' ).focus();
			}
		);

		// Fix to support Bootstrap
		$( '.wp-block-table table' ).addClass( 'table table-striped table-bordered table-hover table-condensed table-responsive text-center' );
		$( 'figcaption' ).addClass( 'figure-caption' );

		function setPageFooterHeight() {
			// Fixed Footer
			if ($( window ).width() >= 1024) {
				if ( $( "#page-footer" ).length ) {
					var footerHeight = $( "#page-footer" ).height();
					if ($( window ).height() - 50 > footerHeight) {
						$( "#wrapper" ).css( "margin-bottom" , footerHeight );
					} else {
						$( "#page-footer" ).css( "position" , 'unset' );
					}
				}
			} else {
				// no margin need for lower than 1024 width
				$( "#wrapper" ).css( "margin-bottom" , 'unset' );
			}
		}
		setPageFooterHeight();

		// Advanced Scroll Easing (Custom Cubic Bezier)
		$.easing.ultraEase = function ( x, t, b, c, d ) {
			t /= d;
			return c * ( t < .5 ? 4 * t * t * t : 1 - Math.pow( -2 * t + 2, 3 ) / 2 ) + b;
		};
		// Scroll with effect
		function cinematicScroll(targetSelector, pushHash = true) {
			const $el = $( targetSelector );
			if ( ! $el.length ) return;
			const headerOffset = 100;
			const distance     = Math.abs( $( window ).scrollTop() - $el.offset().top );
			const duration     = Math.min( 1200, Math.max( 500, distance * 0.6 ) );
			$( 'html, body' ).stop().animate(
				{
					scrollTop: $el.offset().top - headerOffset
				},
				duration,
				'ultraEase',
				function () {
					if (pushHash) {
						history.pushState( null, null, targetSelector );
					}
				}
			);
		}
		// Click on the links
		$( 'a[href^="#"]' ).on(
			'click',
			function (e) {
				e.preventDefault();
				const target = $( this ).attr( 'href' );
				cinematicScroll( target, true );
			}
		);
		// Run the effect when loading page (if there is any hash)
		$( window ).on(
			'load',
			function () {
				const hash = window.location.hash;
				if (hash && $( hash ).length) {
					// We need some delay to load DOM completely
					setTimeout(
						() => {
							cinematicScroll(
								hash,
								false
							);
						},
						50
					);
				}
			}
		);

		// SHOW ON SCROLL
		// Containers where effects should be applied
		const INCLUDE_CONTAINERS = [ '#primary', '#secondary', '.content', '.article-body', '.feature', '.fade-item', '.content-wrapper', '.page-content', '.fade-area' ];
		// Elements that must NOT receive effects, even if they are inside include containers
		const EXCLUDE = [ '.widget_nav_menu', '#popup-login', '#searchModal', '#top-menu', '.main-slider', '#header-menu', '.frontend-content-bottom-sidebar', '.-content-bottom-sidebar', '.no-animation', '.no-anim', '.menu', '#footer', '.banner', '#header', '.advertise' ];
		// Effect rules
		const EFFECT_RULES = [
			{ selector: 'img', effect: 'scale' },
			{ selector: 'a:not(:has(img)), li', effect: 'fade' },
			{ selector: 'h1, h2, h3, h4, h5, h6, .wp-block-buttons, button, .feature-item', effect: 'zoom' },
			{ selector: 'farhad', effect: 'pop' },
			{ selector: 'article, section, p, blockquote', effect: 'slide-up' },
		];
		// Finding elements
		const elements = [];
		// Collecting elements
		INCLUDE_CONTAINERS.forEach(
			container => {
				$( container ).find( '*' ).each(
					function () {
						const el = $( this );

						// Skip very small elements
						if (el.outerHeight() < 15) return;

						// Skip excluded elements
						for (const ex of EXCLUDE) {
							if (el.is( ex ) || el.closest( ex ).length > 0) return;
						}

						// Find matching effect
						for (const rule of EFFECT_RULES) {
							if (el.is( rule.selector )) {
								// Only add effect class
								el.addClass( 'effect-' + rule.effect );
								elements.push( el );
								break;
							}
						}
					}
				);
			}
		);
		function checkVisible() {
			const scrollTop      = $( window ).scrollTop();
			const windowBottom   = scrollTop + $( window ).height();
			elements.forEach(
				el => {
					const top    = el.offset().top;
					const bottom = top + el.outerHeight();
					if (bottom > scrollTop + 80 && top < windowBottom - 80) {
						requestAnimationFrame( () => el.addClass( 'effect-show' ) );
					}
				}
			);
		}
		// Run on initial load and scroll
		checkVisible();
		$( window ).on( 'scroll', checkVisible );
		// END SHOW ON SCROLL

		function updateFontSizes(wrapper) {
			const w = wrapper.width();
			// Width 50%
			const h3Size = w * 0.050;
			// Width 40%
			const pSize = w * 0.040;
			wrapper.find( '.flip-back h3' ).css( 'font-size', h3Size + 'px' );
			wrapper.find( '.flip-back p' ).css( 'font-size', pSize + 'px' );
		}

		$( '.flip-photo' ).each(
			function () {
				const figure  = $( this );
				const img     = figure.find( 'img' );
				const caption = figure.find( 'figcaption' );
				const title   = img.attr( 'alt' ) || '';
				const desc    = caption.text() || '';
				const w       = img.width();
				const h       = img.height();
				const wrapper = $( '<div class="flip-wrapper"></div>' ).css(
					{
						width: w,
						height: h
					}
				);
				const inner   = $( '<div class="flip-inner"></div>' );
				const front   = $( '<div class="flip-front"></div>' ).append(
					img.clone().css(
						{ width: w, height: h }
					)
				);
				const back    = $( '<div class="flip-back"></div>' ).css(
					{
						width: w,
						height: h
					}
				).html(
					`
						<div>
							<h3>${title}</h3>
							<p>${desc}</p>
						</div>
					`
				);
				inner.append( front, back );
				wrapper.append( inner );
				figure.replaceWith( wrapper );
				// Set font sizes based on photo width
				updateFontSizes( wrapper );
			}
		);
		// on window resize, resize fonts too
		$( window ).on(
			'resize',
			function () {
				$( '.flip-wrapper' ).each(
					function () {
						updateFontSizes( $( this ) );
					}
				);
			}
		);

		// START DISPLAY POPUP
		(function () {
			// Storage key
			const storageKey = 'fold_popup_seen';
			const $modal     = $( '#widgetModal' );
			if ( ! $modal.length ) {
				return;
			}
			const forcePopup = $modal.data( 'force-popup' ) === 1;
			// Do not block popup if forced
			if ( ! forcePopup && localStorage.getItem( storageKey ) === '1' ) {
				return;
			}
			// Show modal (Bootstrap)
			$modal.modal( 'show' );
			// Save state only if not forced
			if ( ! forcePopup ) {
				$modal.one(
					'hidden.bs.modal',
					function () {
						localStorage.setItem( storageKey, '1' );
					}
				);
			}
		})();
		// END DISPLAY POPUP
	}
);

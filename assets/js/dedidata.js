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
		$( window ).resize( openSubMenus );
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

		function SetMegaMenu() {
			if ($( "body" ).css( 'direction' ) === 'rtl') {
				// RTL
				if ($( window ).width() >= 1024) {
					$( ".rtl .mega-menu .dropdown-menu" ).each(
						function () {
							let MegaMenuDropdown = $( this );
							let Window50         = $( window ).width() * 0.50;
							let Window75         = $( window ).width() * 0.75;
							let Window25         = $( window ).width() * 0.25;
							MegaMenuDropdown.css( "left", "auto" );
							let ParentListItemRight = MegaMenuDropdown.parent().offset().left + MegaMenuDropdown.parent().width();
							let ListsItemsLength    = $( this ).children( "li" ).length;
							if (ListsItemsLength > 3) {
								MegaMenuDropdown.css( "width", "100%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '25%' );
								MegaMenuDropdown.css( "left", "0" );
							} else if (ListsItemsLength === 3) {
								MegaMenuDropdown.css( "width", "75%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '33%' );
								if (ParentListItemRight < Window75) {
									MegaMenuDropdown.css( 'left', '0' );
								}
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( "width", "50%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '50%' );
								if (ParentListItemRight <= Window50) {
									MegaMenuDropdown.css( 'left', '0' );
								}
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( "width", "25%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
								if (ParentListItemRight < Window25) {
									MegaMenuDropdown.css( 'left', '0' );
								}
							}//end if
						}
					);
				} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
					$( ".rtl .mega-menu .dropdown-menu" ).each(
						function () {
							let MegaMenuDropdown = $( this );
							let Window50         = $( window ).width() * 0.50;
							let Window75         = $( window ).width() * 0.75;
							MegaMenuDropdown.css( "left", "auto" );
							let ParentListItemRight = MegaMenuDropdown.parent().offset().left + MegaMenuDropdown.parent().width();
							let ListsItemsLength    = $( this ).children( "li" ).length;
							if (ListsItemsLength > 2) {
								MegaMenuDropdown.css( "width", "100%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '33%' );
								MegaMenuDropdown.css( "left", "0" );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( "width", "75%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '50%' );
								if (ParentListItemRight < Window75) {
									MegaMenuDropdown.css( 'left', '0' );
								}
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( "width", "50%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
								if (ParentListItemRight < Window50) {
									MegaMenuDropdown.css( 'left', '0' );
								}
							}
						}
					);
				} else if ( $( window ).width() < 768) {
					$( ".rtl .mega-menu .dropdown-menu" ).each(
						function () {
							let MegaMenuDropdown = $( this );
							MegaMenuDropdown.css( "left", "auto" );
							MegaMenuDropdown.css( "width", "100%" );
							MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
						}
					);
				}//end if
			} else {
				// LTR
				if ($( window ).width() >= 1024) {
					$( ".mega-menu .dropdown-menu" ).each(
						function () {
							let MegaMenuDropdown = $( this );
							let Window75         = $( window ).width() * 0.75;
							let Window50         = $( window ).width() * 0.50;
							let Window25         = $( window ).width() * 0.25;
							MegaMenuDropdown.css( "right", "auto" );
							let ParentListItemLeft = MegaMenuDropdown.parent().offset().left;
							let ListsItemsLength   = $( this ).children( "li" ).length;
							if (ListsItemsLength > 3) {
								MegaMenuDropdown.css( "width", "100%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '25%' );
								MegaMenuDropdown.css( "right", "0" );
							} else if (ListsItemsLength === 3) {
								MegaMenuDropdown.css( "width", "75%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '33%' );
								if (ParentListItemLeft > Window25) {
									MegaMenuDropdown.css( 'right', '0' );
								}
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( "width", "50%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '50%' );
								if (ParentListItemLeft > Window50) {
									MegaMenuDropdown.css( 'right', '0' );
								}
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( "width", "25%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
								if (ParentListItemLeft > Window75) {
									MegaMenuDropdown.css( 'right', '0' );
								}
							}//end if
						}
					);
				} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
					$( ".mega-menu .dropdown-menu" ).each(
						function () {
							let MegaMenuDropdown = $( this );
							let Window50         = $( window ).width() * 0.50;
							let Window25         = $( window ).width() * 0.25;
							MegaMenuDropdown.css( "right", "auto" );
							let ParentListItemLeft = MegaMenuDropdown.parent().offset().left;
							let ListsItemsLength   = $( this ).children( "li" ).length;
							if (ListsItemsLength > 2) {
								MegaMenuDropdown.css( "width", "100%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '33%' );
								MegaMenuDropdown.css( "right", "0" );
							} else if (ListsItemsLength === 2) {
								MegaMenuDropdown.css( "width", "75%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '50%' );
								if (ParentListItemLeft > Window25) {
									MegaMenuDropdown.css( 'right', '0' );
								}
							} else if (ListsItemsLength === 1) {
								MegaMenuDropdown.css( "width", "50%" );
								MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
								if (ParentListItemLeft > Window50) {
									MegaMenuDropdown.css( 'right', '0' );
								}
							}
						}
					);
				} else if ($( window ).width() < 768) {
					$( ".mega-menu .dropdown-menu" ).each(
						function () {
							let MegaMenuDropdown = $( this );
							MegaMenuDropdown.css( "right", "auto" );
							MegaMenuDropdown.css( "width", "100%" );
							MegaMenuDropdown.children( "li" ).css( 'width', '100%' );
						}
					);
				}//end if
			}//end if
		}

		SetMegaMenu();

		function SetNormalMenu() {
			if ($( "body" ).css( 'direction' ) === 'rtl') {
				// RTL
				if ($( window ).width() >= 1024) {
					$( ".rtl .normal-menu .dropdown-menu" ).each(
						function () {
							let NormalMenuDropdown = $( this );
							NormalMenuDropdown.css( "left", "auto" );
							let ParentListItemRight = NormalMenuDropdown.parent().offset().left + NormalMenuDropdown.parent().width();
							NormalMenuDropdown.css( "width", "270px" );
							NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
							if (ParentListItemRight < 270) {
								NormalMenuDropdown.css( 'left', '0' );
							}
						}
					);
				} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
					$( ".rtl .normal-menu .dropdown-menu" ).each(
						function () {
							let NormalMenuDropdown = $( this );
							NormalMenuDropdown.css( "left", "auto" );
							let ParentListItemRight = NormalMenuDropdown.parent().offset().left + NormalMenuDropdown.parent().width();
							NormalMenuDropdown.css( "width", "270px" );
							NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
							if (ParentListItemRight < 270) {
								NormalMenuDropdown.css( 'left', '0' );
							}
						}
					);
				} else if ( $( window ).width() < 768) {
					$( ".rtl .normal-menu .dropdown-menu" ).each(
						function () {
							let NormalMenuDropdown = $( this );
							NormalMenuDropdown.css( "left", "auto" );
							NormalMenuDropdown.css( "width", "100%" );
							NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
						}
					);
				}//end if
			} else {
				// LTR
				if ($( window ).width() >= 1024) {
					$( ".normal-menu .dropdown-menu" ).each(
						function () {
							let NormalMenuDropdown = $( this );
							let WindowRemain       = $( window ).width() - 270;
							NormalMenuDropdown.css( "right", "auto" );
							let ParentListItemLeft = NormalMenuDropdown.parent().offset().left;
							NormalMenuDropdown.css( "width", "270px" );
							NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
							if (ParentListItemLeft > WindowRemain) {
								NormalMenuDropdown.css( 'right', '0' );
							}
						}
					);
				} else if ($( window ).width() >= 768 && $( window ).width() < 1024) {
					$( ".normal-menu .dropdown-menu" ).each(
						function () {
							let NormalMenuDropdown = $( this );
							let WindowRemain       = $( window ).width() - 270;
							NormalMenuDropdown.css( "right", "auto" );
							let ParentListItemLeft = NormalMenuDropdown.parent().offset().left;
							NormalMenuDropdown.css( "width", "270px" );
							NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
							if (ParentListItemLeft > WindowRemain) {
								NormalMenuDropdown.css( 'right', '0' );
							}
						}
					);
				} else if ($( window ).width() < 768) {
					$( ".normal-menu .dropdown-menu" ).each(
						function () {
							let NormalMenuDropdown = $( this );
							NormalMenuDropdown.css( "right", "auto" );
							NormalMenuDropdown.css( "width", "100%" );
							NormalMenuDropdown.children( "li" ).css( 'width', '100%' );
						}
					);
				}//end if
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
						// Call the SetMegaMenu function after 1 second
						SetMegaMenu();
						SetNormalMenu();
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
					800
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
				$( this ).find( '.gallery-icon a[href$=".jpg"], .gallery-icon a[href$=".jpeg"],.gallery-icon a[href$=".gif"],.gallery-icon a[href$=".webp"], .gallery-icon a[href$=".png"]' ).attr( 'data-lightbox', 'group-' + $( this ).attr( 'id' ) ).lightbox(
					{
						infobar: true,
						protect: true
					}
				);
				$( '.gallery-icon' ).each(
					function () {
						$( this ).find( 'a' ).attr( 'data-title', $( this ).find( 'a img' ).attr( 'alt' ) );
					}
				)
			}
		);

		// add class to woocommerce product categories
		$( '.widget_product_categories .cat-item' ).not( '.cat-parent' ).addClass( 'shadow-sm rounded p-2 my-2' );
		$( '.widget_product_categories .cat-item.cat-parent' ).addClass( 'my-2' );

		$( "#widgetModal" ).modal( "show" );

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
			if ($( document ).scrollTop() < 50) {
				// Scroll is in top
				$( "#top-menu" ).addClass( "in-top" );
				$( "#top-menu:has(.collapsed)" ).removeClass( "bg-primary" );
				// 600 Because WP admin bar hides on lower 600px
				if ($( window ).width() < 600 && currentTop) {
					// Set top position in mobile devices under 600px
					// $( ".admin-bar #top-menu" ).css( 'top', '46' + 'px' );
					$( ".admin-bar #top-menu" ).css( 'top', 'auto' );
				} else {
					$( ".admin-bar #top-menu" ).css( 'top', 'auto' );
				}
				if ($( window ).width() < 768) {
					$( '#top-menu' ).on(
						'shown.bs.collapse',
						function () {
							$( "#top-menu" ).addClass( "bg-primary" );
						}
					)
					$( '#top-menu' ).on(
						'hidden.bs.collapse',
						function () {
							if ($( document ).scrollTop() < 50) {
								$( "#top-menu" ).removeClass( "bg-primary" );
							}
						}
					)
				} else {
					$( "#top-menu" ).removeClass( "bg-primary" );
				}
			} else {
				// Scroll is not in top
				$( "#top-menu" ).removeClass( "in-top" ).addClass( "bg-primary" );
				// 600 Because WP admin bar hides on lower 600px
				if ($( window ).width() < 600 && currentTop) {
					// $( ".admin-bar #top-menu" ).css( 'top', currentTop - 46 + 'px' );
					$( ".admin-bar #top-menu" ).css( 'top', '0' );
				} else {
					$( ".admin-bar #top-menu" ).css( 'top', 'auto' );
				}
			}//end if
		}

		setTopMenuBGColor();
		$( document ).on( "scroll", setTopMenuBGColor );
		$( window ).resize( setTopMenuBGColor );
	}
);

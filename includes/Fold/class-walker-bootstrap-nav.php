<?php
/**
 * Bootstrap Navwalker
 *
 * @package Bootstrap-Navwalker
 */

declare(strict_types=1);

namespace Fold;

/**
 * Description: A custom WordPress nav walker class to implement the Bootstrap navigation style in a custom theme using the WordPress built in menu manager.
 */
final class Walker_Bootstrap_Nav extends \Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 * @param string    $output Passed by reference. Used to append additional content.
	 * @param integer   $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 * @return void
	 * @SuppressWarnings(PHPMD.ElseExpression)
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 0 === $depth ) {
			// main sub menus
			$output .= '<ul role="menu" class="dropdown-menu shadow p-1">';
		} else {
			// sub menu columns
			$output .= '<ul role="menu" class="inner-menu">';
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 * @param string    $output Passed by reference. Used to append additional content.
	 * @param integer   $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 * @return void
	 * @SuppressWarnings(PHPMD.ElseExpression)
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</ul>';
	}

	/**
	 * Starts the element output.
	 *
	 * @see Walker::start_el()
	 * @param string    $output            Passed by reference. Used to append additional content.
	 * @param \WP_Post  $data_object       Menu item data object.
	 * @param integer   $depth             Depth of menu item. Used for padding.
	 * @param \stdClass $args              An object of wp_nav_menu() arguments.
	 * @param integer   $current_object_id Current item ID.
	 * @return void
	 * @SuppressWarnings(PHPMD.ElseExpression)
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$classes   = is_array( $data_object->classes ) ? $data_object->classes : array();
		$classes[] = 'menu-item-' . (string) $data_object->ID;
		$classes[] = 'list-unstyled';
		$classes[] = 'nav-item';
		if ( 0 === $depth ) {
			$classes[] .= ' px-1 py-2';
		}
		if ( 1 === $depth ) {
			$classes[] .= ' px-1 py-1';
		}
		if ( $depth > 1 ) {
			$classes[] .= '';
		}
		$classes[] = '';

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @param \stdClass $args        An object of wp_nav_menu() arguments.
		 * @param \WP_Post  $data_object Menu item data object.
		 * @param int       $depth       Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $data_object, $depth );

		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @param array     $classes     The CSS classes that are applied to the menu item's `<li>` element.
		 * @param \WP_Post  $data_object The current menu item.
		 * @param \stdClass $args        An object of wp_nav_menu() arguments.
		 * @param int       $depth       Depth of menu item. Used for padding.
		 */

		/* Check for GlyphIcons classes and remove them */
		$found_glyph_key = array_search( 'glyphicons', $classes, true );
		if ( false !== $found_glyph_key ) {
			unset( $classes[ $found_glyph_key ] );
			foreach ( $classes as $key => $value ) {
				// phpcs:ignore SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed
				if ( is_string( $value ) && 0 === strpos( $value, 'glyphicons-' ) ) {
					unset( $classes[ $key ] );
				}
			}
		}

		/* Check for FontAwesome classes and remove them */
		foreach ( $classes as $key => $class ) {
			// phpcs:ignore SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed
			if ( is_string( $class ) && 0 === strpos( $class, 'fa' ) ) {
				unset( $classes[ $key ] );
			}
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $data_object, $args, $depth ) );
		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$class_names .= ' active';
		}
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @param string    $menu_id     The ID that is applied to the menu item's `<li>` element.
		 * @param \WP_Post  $data_object The current menu item.
		 * @param \stdClass $args        An object of wp_nav_menu() arguments.
		 * @param int       $depth       Depth of menu item. Used for padding.
		 */
		$current_object_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . (string) $data_object->ID, $data_object, $args, $depth );
		$current_object_id = $current_object_id ? ' id="' . esc_attr( $current_object_id ) . '"' : '';

		/**
		* Dividers, Headers or Disabled
		* =============================
		* Determine whether the item is a Divider, Header, Disabled or regular
		* menu item. To prevent errors we use the strcasecmp() function to so a
		* comparison that is not case sensitive. The strcasecmp() function returns
		* a 0 if the strings are equal.
		*/
		if ( 0 === strcasecmp( (string) $data_object->attr_title, 'divider' ) && 1 < $depth ) {
			$output .= '<li role="presentation" class="divider">';
		} elseif ( 0 === strcasecmp( (string) $data_object->title, 'divider' ) && 1 < $depth ) {
			$output .= '<li role="presentation" class="divider">';
		} elseif ( 0 === strcasecmp( (string) $data_object->attr_title, 'dropdown-header' ) && 1 === $depth ) {
			$output .= '<li role="presentation" class="dropdown-header">' . esc_html( (string) $data_object->title );
		} elseif ( 0 === strcasecmp( (string) $data_object->attr_title, 'disabled' ) ) {
			$output .= '<li role="presentation" class="disabled"><a href="#" class="navbar-link">' . esc_html( (string) $data_object->title ) . '</a>';
		} else {
			$output .= '<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"' . $current_object_id . $class_names . '>';

			$atts           = array();
			$atts['title']  = (string) $data_object->attr_title;
			$atts['target'] = (string) $data_object->target;
			$atts['rel']    = (string) $data_object->xfn;
			$atts['class']  = '';
			// If item has_children add atts to a.
			if ( $args->has_children && 0 === $depth ) {
				// $atts['href']          = '#';
				$atts['href']          = (string) $data_object->url;
				$atts['class']        .= ' dropDownT';
				$atts['data-toggle']   = 'dropdown';
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
				$atts['role']          = 'button';
			} else {
				$atts['href'] = (string) $data_object->url;
				$atts['class'] = '';
				if ( 0 < $depth ) {
					$atts['class'] .= ' submenu-link mb-1 p-2';
				}
				if ( 1 === $depth ) {
					$atts['class'] .= ' submenu-title-link shadow-sm rounded px-1 py-2 mb-1';
				}
				if ( $depth > 1 ) {
					$atts['class'] .= ' submenu-child-link shadow-sm rounded px-1 py-2 my-1';
				}
			}//end if

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param \WP_Post  $data_object The current menu item.
			 * @param \stdClass $args        An object of wp_nav_menu() arguments.
			 * @param int       $depth       Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $data_object, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( '' === $value ) {
					continue;
				}
				$value       = 'href' === $attr ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', (string) $data_object->title, (int) $data_object->ID );

			/**
			 * Filters a menu item's title.
			 *
			 * @param string    $title       The menu item's title.
			 * @param \WP_Post  $data_object The current menu item.
			 * @param \stdClass $args        An object of wp_nav_menu() arguments.
			 * @param int       $depth       Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $data_object, $args, $depth );

			$item_output = $args->before;

			/*
				* Glyphicons/Font-Awesome
				* ===========
				* Since the the menu item is NOT a Divider or Header we check the see
				* if there is a value in the attr_title property. If the attr_title
				* property is NOT null we apply it as the class name for the glyphicon.
				*/
			if ( is_array( $data_object->classes ) ) {
				$obj_class_fa_found = false;
				foreach ( $data_object->classes as $key => $value ) {
					if ( is_string( $value ) && 0 === strpos( $value, 'fa-' ) ) {
						$obj_class_fa_found = true;
					}
				}
				// $pos = strpos( esc_attr( $data_object->attr_title ), 'glyphicon' );
				if ( false !== array_search( 'glyphicons', $data_object->classes, true ) ) {
					foreach ( $data_object->classes as $value ) {
						// phpcs:ignore SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed
						if ( 0 === strpos( $value, 'glyphicons-' ) ) {
							$found_glyphicons = $value;
						}
					}
					$item_output .= '<a ' . $attributes . '><span class="glyphicons ' . esc_attr( $found_glyphicons ) . '" aria-hidden="true"></span>&nbsp;';
				} elseif ( false !== array_search( 'fa', $data_object->classes, true ) || true === $obj_class_fa_found ) {
					$found_fa = '';
					foreach ( $data_object->classes as $value ) {
						// phpcs:ignore SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed
						if ( 0 === strpos( (string) $value, 'fa-' ) ) {
							$found_fa .= ' ' . $value;
						}
					}
					$item_output .= '<a' . $attributes . '><i class="fa fa-lg fa-fw' . esc_attr( $found_fa ) . '" aria-hidden="true"></i>&nbsp;';
				} else {
					$item_output .= '<a' . $attributes . '>';
				}
			} else {
				$item_output .= '<a' . $attributes . '>';
			}//end if

			$description_span = (string) $data_object->description && 0 < $depth ? '<span class="menu-item-description">' . (string) $data_object->description . '</span>' : '';
			$arrow_icon       = '';
			if ( 1 === $depth && $args->has_children ) {
				$arrow_icon = ' <i class="fas fa-2xs fa-angle-double-down" aria-hidden="true"></i>';
			}
			$item_output .= $args->link_before . $title . $arrow_icon . $description_span . $args->link_after;
			$item_output .= $args->has_children && 0 === $depth ? ' <i class="fas fa-2xs fa-angle-double-down" aria-hidden="true"></i></a>' : '</a>';
			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @param string    $item_output The menu item's starting HTML output.
			 * @param \WP_Post  $data_object Menu item data object.
			 * @param int       $depth       Depth of menu item. Used for padding.
			 * @param \stdClass $args        An object of wp_nav_menu() arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $data_object, $depth, $args );
		}//end if
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 * @param string    $output      Passed by reference. Used to append additional content.
	 * @param \WP_Post  $data_object Page data object. Not used.
	 * @param integer   $depth       Depth of page. Not Used.
	 * @param \stdClass $args        An object of wp_nav_menu() arguments.
	 * @return void
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @access public
	 * @param mixed $element           Data object.
	 * @param mixed $children_elements List of elements to continue traversing.
	 * @param mixed $max_depth         Max depth to traverse.
	 * @param mixed $depth             Depth of current element.
	 * @param mixed $args              Arguments.
	 * @param mixed $output            Passed by reference. Used to append additional content.
	 * @return void void on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return;
		}
		$id_field = $this->db_fields['id'];
		// Display this element.
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = isset( $children_elements[ $element->$id_field ] );
		}
		$element->is_dropdown = ( ( isset( $children_elements[ $element->ID ] ) && 0 === $depth ) );
		if ( $element->is_dropdown ) {
			$element->classes[] = 'dropdown';
		}

		if ( $element && ( 1 === $depth ) ) {
			$element->classes[] = 'col menu-col col-lg-3 col-md-4 col-sm-6';
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a menu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array<mixed> $args Passed from the wp_nav_menu function.
	 * @return void
	 */
	public static function fallback( $args ) {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		/* Get Arguments. */
		$container       = $args['container'];
		$container_id    = $args['container_id'];
		$container_class = $args['container_class'];
		$menu_class      = $args['menu_class'];
		$menu_id         = $args['menu_id'];

		if ( $container ) {
			echo '<' . esc_attr( $container );
			if ( $container_id ) {
				echo ' id="' . esc_attr( $container_id ) . '"';
			}
			if ( $container_class ) {
				echo ' class="' . sanitize_html_class( $container_class ) . '"';
			}
			echo '>';
		}
		echo '<ul';
		if ( $menu_id ) {
			echo ' id="' . esc_attr( $menu_id ) . '"';
		}
		if ( $menu_class ) {
			echo ' class="' . esc_attr( $menu_class ) . '"';
		}
		echo '>';
		echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="">' . esc_html__( 'Add a menu', 'fold' ) . '</a></li>';
		echo '</ul>';
		// phpcs:ignore SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed
		if ( $container ) {
			echo '</' . esc_attr( $container ) . '>';
		}
	}
}

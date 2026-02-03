<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @package Fold
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

namespace Fold;

/**
 * Class Customizer
 */
final class Customizer {

	/**
	 * Used to declare a static variable that retains its value across function calls.
	 *
	 * @var array<string> $login_form_systems
	 */
	private static $login_form_systems = array(
		'WordPress'   => 'WordPress',
		'WooCommerce' => 'WooCommerce',
		'WHMCS'       => 'WHMCS',
	);

	/**
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows
	 * you to add new sections and controls to the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * @see add_action('customize_register',$func)
	 * @param \WP_Customize_Manager $wp_customize WP Customize Manager.
	 * @return void Return nothing
	 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 */
	public static function register( \WP_Customize_Manager $wp_customize ): void {

		$wp_customize->add_setting(
			'light_primary_color',
			array(
				// Default setting/value to save
				'default'           => '#0d6efd',
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_hex_color',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				// 'transport'      => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'light_primary_color',
				array(
					'label'    => esc_html__( 'Primary Theme Color for Light Mode', 'fold' ),
					'section'  => 'colors',
					'settings' => array( 'light_primary_color' ),
					'priority' => 10,
				)
			)
		);

		$wp_customize->add_setting(
			'dark_primary_color',
			array(
				// Default setting/value to save
				'default'           => '#3090ff',
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_hex_color',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				// 'transport'      => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'dark_primary_color',
				array(
					'label'    => esc_html__( 'Primary Theme Color for Dark Mode', 'fold' ),
					'section'  => 'colors',
					'settings' => array( 'dark_primary_color' ),
					'priority' => 10,
				)
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'bootstrap_theme',
			array(
				// Default setting/value to save
				'default'           => 'light',
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => '\Fold\Customizer::sanitize_text',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				// 'transport'      => 'postMessage',
			)
		);

		/*
		Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
		Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
		*/
		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'bootstrap_theme',
				array(
					// Admin-visible name of the control
					'label'       => esc_html__( 'Select Theme', 'fold' ),
					'description' => esc_html__( 'Using this option you can change the theme colors', 'fold' ),
					// Which setting to load and manipulate (serialized is okay)
					'setting'     => 'bootstrap_theme',
					// Determines the order this control appears in for the specified section
					'priority'    => 9,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'     => 'colors',
					'type'        => 'select',
					'choices'     => array(
						'light'      => esc_html__( 'Default Light - User Switchable', 'fold' ),
						'dark'       => esc_html__( 'Default Dark - User Switchable', 'fold' ),
						'light-only' => esc_html__( 'Light Only', 'fold' ),
						'dark-only'  => esc_html__( 'Dark Only', 'fold' ),
					),
				)
			)
		);

		$wp_customize->add_section(
			'fold-options',
			array(
				// Visible title of section
				'title'       => esc_html__( 'Theme Options', 'fold' ),
				// Determines what order this appears in
				'priority'    => 20,
				// Capability needed to tweak
				'capability'  => 'edit_theme_options',
				// Descriptive tooltip
				'description' => esc_html__( 'Allows you to customize settings for Theme.', 'fold' ),
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'menu_mode',
			array(
				// Default setting/value to save
				'default'           => 'mega-menu',
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => '\Fold\Customizer::sanitize_text',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				// 'transport'      => 'postMessage',
			)
		);

		/*
		Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
		Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
		*/
		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'menu_mode',
				array(
					// Admin-visible name of the control
					'label'       => esc_html__( 'Select Menu Mode', 'fold' ),
					'description' => esc_html__( 'Using this option you can change the menu mode', 'fold' ),
					// Which setting to load and manipulate (serialized is okay)
					'setting'     => 'menu_mode',
					// Determines the order this control appears in for the specified section
					'priority'    => 10,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'     => 'fold-options',
					'type'        => 'select',
					'choices'     => array(
						'mega-menu'   => esc_html__( 'Mega Menu', 'fold' ),
						'normal-menu' => esc_html__( 'Normal Menu', 'fold' ),
					),
				)
			)
		);

		if ( function_exists( 'wp_statistics_pages' ) ) {
			$wp_customize->add_setting(
				// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
				'display_visits',
				array(
					// Default setting/value to save
					'default'           => 'true',
					// Is this an 'option' or a 'theme_mod'?
					'type'              => 'theme_mod',
					// Optional. Special permissions for accessing this setting.
					'capability'        => 'edit_theme_options',
					// Theme features required to support the panel. Default is none.
					'theme_supports'    => array(),
					// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
					'transport'         => 'refresh',
					// 'validate_callback' => '',
					'sanitize_callback' => '\Fold\Customizer::sanitize_checkbox',
					'dirty'             => false,
				)
			);

			/*
			Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
			Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
			*/
			$wp_customize->add_control(
				new \WP_Customize_Control(
					// Pass the $wp_customize object (required)
					$wp_customize,
					// Set a unique ID for the control
					'display_visits',
					array(
						// Which setting to load and manipulate (serialized is okay)
						'setting'        => 'display_visits',
						// Optional. Special permissions for accessing this setting.
						'capability'     => 'edit_theme_options',
						// Determines the order this control appears in for the specified section , Default: 10
						'priority'       => 13,
						// ID of the section this control should render in (can be one of yours, or a WordPress default section)
						'section'        => 'fold-options',
						// Admin-visible name of the control
						'label'          => esc_html__( 'Display visits?', 'fold' ),
						'description'    => esc_html__( 'Display number of visits in pages and posts', 'fold' ),
						// List of custom input attributes for control output, where attribute names are the keys and values are the values.
						'input_attrs'    => array(),
						// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
						// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
						'allow_addition' => false,
						// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
						'type'           => 'checkbox',
						// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.

						/*
						'choices'		 => array(
							// List of choices for 'radio' or 'select' type controls
							'yes'	=> esc_html__( 'Yes', 'fold' ),
							'no'	=> esc_html__( 'No', 'fold' ),
						),
						*/
					)
				)
			);
		}//end if

		$wp_customize->add_section(
			'fold-login-form-options',
			array(
				// Visible title of section
				'title'       => esc_html__( 'Popup Login Form', 'fold' ),
				// Determines what order this appears in
				'priority'    => 22,
				// Capability needed to tweak
				'capability'  => 'edit_theme_options',
				// Descriptive tooltip
				'description' => esc_html__( 'Allows you to customize login link and login form.', 'fold' ),
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'display_login_link',
			array(
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// Theme features required to support the panel. Default is none.
				'theme_supports'    => array(),
				// Default value for the setting. Default is empty string.
				'default'           => 'false',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'transport'         => 'refresh',
				'sanitize_callback' => '\Fold\Customizer::sanitize_checkbox',
				'dirty'             => false,
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'display_login_link',
				array(
					// Which setting to load and manipulate (serialized is okay)
					'setting'        => 'display_login_link',
					// Optional. Special permissions for accessing this setting.
					'capability'     => 'edit_theme_options',
					// Determines the order this control appears in for the specified section , Default: 10
					'priority'       => 11,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'        => 'fold-login-form-options',
					// Admin-visible name of the control
					'label'          => esc_html__( 'Display login link?', 'fold' ),
					'description'    => esc_html__( 'Display a link on top menu for login user', 'fold' ),
					// List of custom input attributes for control output, where attribute names are the keys and values are the values.
					'input_attrs'    => array(),
					// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
					// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
					'allow_addition' => false,
					// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
					'type'           => 'checkbox',
					// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.

					/*
					'choices'			=> array(
						// List of choices for 'radio' or 'select' type controls
						'yes'	=> esc_html__( 'Yes', 'fold' ),
						'no'	=> esc_html__( 'No', 'fold' ),
					),
					*/
				)
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'login_link_text',
			array(
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// Theme features required to support the panel. Default is none.
				'theme_supports'    => array(),
				// Default value for the setting. Default is empty string.
				'default'           => 'Login',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'transport'         => 'refresh',
				// 'validate_callback' => '',
				'sanitize_callback' => '\Fold\Customizer::sanitize_login_link_texts',
				'dirty'             => false,
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'login_link_text',
				array(
					// Which setting to load and manipulate (serialized is okay)
					'setting'        => 'login_link_text',
					// Optional. Special permissions for accessing this setting.
					'capability'     => 'edit_theme_options',
					// Determines the order this control appears in for the specified section , Default: 10
					'priority'       => 12,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'        => 'fold-login-form-options',
					// Admin-visible name of the control
					'label'          => esc_html__( 'Login link text', 'fold' ),
					'description'    => esc_html__( 'Please select the login link text', 'fold' ),
					// List of custom input attributes for control output, where attribute names are the keys and values are the values.
					'input_attrs'    => array(),
					// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
					// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
					'allow_addition' => false,
					// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
					'type'           => 'select',
					// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.
					// List of choices for 'radio' or 'select' type controls
					'choices'        => FOLD()::login_link_texts(),
				)
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'login_form_system',
			array(
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// Theme features required to support the panel. Default is none.
				'theme_supports'    => array(),
				// Default value for the setting. Default is empty string.
				'default'           => 'WordPress',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'transport'         => 'refresh',
				// 'validate_callback' => '',
				'sanitize_callback' => '\Fold\Customizer::sanitize_login_form_systems',
				'dirty'             => false,
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'login_form_system',
				array(
					// Which setting to load and manipulate (serialized is okay)
					'setting'        => 'login_form_system',
					// Optional. Special permissions for accessing this setting.
					'capability'     => 'edit_theme_options',
					// Determines the order this control appears in for the specified section , Default: 10
					'priority'       => 13,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'        => 'fold-login-form-options',
					// Admin-visible name of the control
					'label'          => esc_html__( 'Login form system', 'fold' ),
					'description'    => esc_html__( 'Please select the login form system', 'fold' ),
					// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
					// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
					'allow_addition' => false,
					// 'active_callback' => '',
					// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
					'type'           => 'select',
					// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.
					// List of choices for 'radio' or 'select' type controls
					'choices'        => self::$login_form_systems,
				)
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'whmcs_url',
			array(
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// Theme features required to support the panel. Default is none.
				'theme_supports'    => array(),
				// Default value for the setting. Default is empty string.
				'default'           => 'https://panel.dedidata.com',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'transport'         => 'refresh',
				// 'validate_callback' => '',
				'sanitize_callback' => '\Fold\Customizer::sanitize_text',
				'dirty'             => false,
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'whmcs_url',
				array(
					// Which setting to load and manipulate (serialized is okay)
					'setting'        => 'whmcs_url',
					// Optional. Special permissions for accessing this setting.
					'capability'     => 'edit_theme_options',
					// Determines the order this control appears in for the specified section , Default: 10
					'priority'       => 14,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'        => 'fold-login-form-options',
					// Admin-visible name of the control
					'label'          => esc_html__( 'WHMCS URL', 'fold' ),
					'description'    => esc_html__( 'If you selected WHMCS, Please provide the url of your WHMCS', 'fold' ),
					// List of custom input attributes for control output, where attribute names are the keys and values are the values.
					'input_attrs'    => array( 'style' => 'direction:ltr;' ),
					// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
					// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
					'allow_addition' => false,
					// 'active_callback' => '',
					// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
					'type'           => 'text',
					// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.
					// List of choices for 'radio' or 'select' type controls
					// 'choices'      =>  $login_form_systems,
				)
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'display_search_icon',
			array(
				// Default setting/value to save
				'default'           => 'yes',
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				// 'transport'      => 'postMessage',
				'sanitize_callback' => '\Fold\Customizer::sanitize_text',
			)
		);

		/*
		Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
		Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
		*/
		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'display_search_icon',
				array(
					// Admin visible name of the control
					'label'       => esc_html__( 'Display search icon', 'fold' ),
					'description' => esc_html__( 'Display search icon on top menu bar', 'fold' ),
					// Which setting to load and manipulate (serialized is okay)
					'setting'     => 'display_search_icon',
					// Determines the order this control appears in for the specified section
					'priority'    => 15,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'     => 'fold-login-form-options',
					'type'        => 'select',
					'choices'     => array(
						'no'  => esc_html__( 'No', 'fold' ),
						'yes' => esc_html__( 'Yes', 'fold' ),
					),
				)
			)
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$wp_customize->add_setting(
				// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
				'display_cart_icon',
				array(
					// Default setting/value to save
					'default'           => 'yes',
					// Is this an 'option' or a 'theme_mod'?
					'type'              => 'theme_mod',
					// Optional. Special permissions for accessing this setting.
					'capability'        => 'edit_theme_options',
					// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
					// 'transport'      => 'postMessage',
					'sanitize_callback' => '\Fold\Customizer::sanitize_text',
				)
			);

			/*
			Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
			Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
			*/
			$wp_customize->add_control(
				new \WP_Customize_Control(
					// Pass the $wp_customize object (required)
					$wp_customize,
					// Set a unique ID for the control
					'display_cart_icon',
					array(
						// Admin visible name of the control
						'label'       => esc_html__( 'Display cart icon', 'fold' ),
						'description' => esc_html__( 'Display WooCommerce Cart icon on top menu bar', 'fold' ),
						// Which setting to load and manipulate (serialized is okay)
						'setting'     => 'display_cart_icon',
						// Determines the order this control appears in for the specified section
						'priority'    => 16,
						// ID of the section this control should render in (can be one of yours, or a WordPress default section)
						'section'     => 'fold-login-form-options',
						'type'        => 'select',
						'choices'     => array(
							'no'  => esc_html__( 'No', 'fold' ),
							'yes' => esc_html__( 'Yes', 'fold' ),
						),
					)
				)
			);
		}//end if

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'header_text_change_content',
			array(
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// Theme features required to support the panel. Default is none.
				'theme_supports'    => array(),
				// Default value for the setting. Default is empty string.
				'default'           => '',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'transport'         => 'refresh',
				// 'validate_callback' => '',
				'sanitize_callback' => '\Fold\Customizer::sanitize_text',
				'dirty'             => false,
			)
		);

		$wp_customize->add_control(
			new \Fold\Customizer_Library_Content(
				$wp_customize,
				'header_text_change_content',
				array(
					// Which setting to load and manipulate (serialized is okay)
					'setting'     => 'header_text_change_content',
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'     => 'header_image',
					// Optional. Special permissions for accessing this setting.
					'capability'  => 'edit_theme_options',
					// Determines the order this control appears in for the specified section , Default: 10
					'priority'    => 10,
					// Admin visible name of the control
					'label'       => sprintf(
						'<span style="color: red">%s</span>',
						esc_html__( 'How to modify frontpage header texts?', 'fold' )
					),
					'description' => '<p style="text-align: justify">'
						. esc_html__( 'You can modify texts of header images when you are uploading them by modifying Title, Description and Alt fields. ', 'fold' )
						. sprintf(
							/* translators: %1$s: Replaces with link tag, %2$s: Replaces with link tag */
							esc_html__( 'You can also modify them via %1$sMedia Manager%2$s. ', 'fold' ),
							sprintf(
								'<a href="%s">',
								esc_url( get_admin_url( null, 'upload.php?mode=grid' ) )
							),
							'</a>'
						)
						. sprintf(
							/* translators: %1$s: Replaces with link tag, %2$s: Replaces with link tag */
							esc_html__( 'If you cropped your image while uploading the file, So you need to use %1$sMedia Manager/List Mode%2$s to find those cropped images.', 'fold' ),
							sprintf( '<a href="%s">', esc_url( get_admin_url( null, 'upload.php?mode=list' ) ) ),
							'</a>'
						)
						. '</p>',
					// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
					'type'        => 'content',
				)
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'display_featured_in_header',
			array(
				// Default setting/value to save
				'default'           => 'no',
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				// 'transport'      => 'postMessage',
				'sanitize_callback' => '\Fold\Customizer::sanitize_text',
			)
		);

		/*
		Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
		Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
		*/
		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'display_featured_in_header',
				array(
					// Admin-visible name of the control
					'label'       => esc_html__( 'Display featured image in header', 'fold' ),
					'description' => esc_html__( 'To display the featured image of the post/page in header area, Select this option to Yes! So your selected image will be display in header area as background for that post/page', 'fold' ),
					// Which setting to load and manipulate (serialized is okay)
					'setting'     => 'display_featured_in_header',
					// Determines the order this control appears in for the specified section
					'priority'    => 11,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'     => 'header_image',
					'type'        => 'select',
					'choices'     => array(
						'no'  => esc_html__( 'No', 'fold' ),
						'yes' => esc_html__( 'Yes', 'fold' ),
					),
				)
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'default_header_background',
			array(
				// Default setting/value to save
				'default'           => get_stylesheet_directory_uri() . '/assets/images/header-bg.webp',
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				// 'transport'      => 'postMessage',
				'sanitize_callback' => '\Fold\Customizer::sanitize_image',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Upload_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'default_header_background',
				array(
					// Admin-visible name of the control
					'label'       => esc_html__( 'Default header background image', 'fold' ),
					'description' => '<p style="text-align: justify">' . esc_html__( 'if you like to change default header background image for all pages, you can select an image here.', 'fold' ) . '</p>',
					// Which setting to load and manipulate (serialized is okay)
					'setting'     => 'default_header_background',
					// Determines the order this control appears in for the specified section
					'priority'    => 12,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'     => 'header_image',
				)
			)
		);

		$wp_customize->add_section(
			'fold-site-settings',
			array(
				// Visible title of section
				'title'       => esc_html__( 'Site Settings', 'fold' ),
				// Determines what order this appears in
				'priority'    => 21,
				// Capability needed to tweak
				'capability'  => 'edit_theme_options',
				// Descriptive tooltip
				'description' => esc_html__( 'Allows you to customize site settings.', 'fold' ),
			)
		);

		$wp_customize->add_setting(
			// No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			'enable_pwa',
			array(
				// Is this an 'option' or a 'theme_mod'?
				'type'              => 'theme_mod',
				// Optional. Special permissions for accessing this setting.
				'capability'        => 'edit_theme_options',
				// Theme features required to support the panel. Default is none.
				'theme_supports'    => array(),
				// Default value for the setting. Default is empty string.
				'default'           => 'true',
				// What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'transport'         => 'postMessage',
				// 'validate_callback' => '',
				'sanitize_callback' => '\Fold\Customizer::sanitize_checkbox',
				'dirty'             => false,
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Control(
				// Pass the $wp_customize object (required)
				$wp_customize,
				// Set a unique ID for the control
				'enable_pwa',
				array(
					// Which setting to load and manipulate (serialized is okay)
					'setting'        => 'enable_pwa',
					// Optional. Special permissions for accessing this setting.
					'capability'     => 'edit_theme_options',
					// Determines the order this control appears in for the specified section , Default: 10
					'priority'       => 11,
					// ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'section'        => 'fold-site-settings',
					// Admin-visible name of the control
					'label'          => esc_html__( 'Enable PWA (Install APP)', 'fold' ),
					'description'    => esc_html__( 'Enable PWA (Progressive Web Application) Installation (Requires Site Logo!)', 'fold' ),
					// List of custom input attributes for control output, where attribute names are the keys and values are the values.
					'input_attrs'    => array(),
					// Not used for 'checkbox', 'radio', 'select', 'textarea', or 'dropdown-pages' control types. Default empty array.
					// (bool) Show UI for adding new content, currently only used for the dropdown-pages control. Default false.
					'allow_addition' => false,
					// 'active_callback' => '',
					// Control type. Core controls include 'text', 'checkbox', 'textarea', 'radio', 'select', and 'dropdown-pages'.
					'type'           => 'checkbox',
					// Additional input types such as 'email', 'url', 'number', 'hidden', and 'date' are supported implicitly. Default 'text'.

					/*
					'choices'         => array(
						// List of choices for 'radio' or 'select' type controls
						'yes'	=> esc_html__( 'Yes', 'fold' ),
						'no'	=> esc_html__( 'No', 'fold' ),
					),
					*/
				)
			)
		);


		$setting_blog_name = $wp_customize->get_setting( 'blogname' );
		if ( null !== $setting_blog_name ) {
			$setting_blog_name->transport = 'postMessage';
		}
		$setting_description = $wp_customize->get_setting( 'blogdescription' );
		if ( null !== $setting_description ) {
			$setting_description->transport = 'postMessage';
		}
		$setting_text_color = $wp_customize->get_setting( 'header_textcolor' );
		if ( null !== $setting_text_color ) {
			$setting_text_color->transport = 'postMessage';
			$setting_text_color->default   = 'ffffff';
		}
		$setting_back_color = $wp_customize->get_setting( 'background_color' );
		if ( null !== $setting_back_color ) {
			$setting_back_color->transport = 'postMessage';
			$setting_back_color->default   = 'ffffff';
		}
	}

	/**
	 * Takes an input and checks if it is set and evaluates to true.
	 *
	 * @param boolean $input Input value.
	 * @return boolean Return
	 */
	static public function sanitize_checkbox( bool $input ): bool {
		return $input;
	}

	/**
	 * Sanitizes login link texts.
	 *
	 * @param string $input Input value.
	 * @return string Return
	 */
	static public function sanitize_login_link_texts( string $input ): string {
		return array_key_exists( $input, FOLD()::login_link_texts() ) ? $input : 'Login';
	}

	/**
	 * Sanitize a text input.
	 *
	 * This function uses the `sanitize_text_field` function to clean up the text input.
	 *
	 * @param string $input The text input to be sanitized.
	 * @return string The sanitized text.
	 */
	static public function sanitize_text( string $input ): string {
		return sanitize_text_field( $input );
	}

	/**
	 * Sanitizes the input to ensure it is a valid login form system.
	 *
	 * This function checks if the provided input is within the allowed
	 * login form systems. If the input is valid, it returns the input.
	 * Otherwise, it returns 'WordPress' as the default value.
	 *
	 * @param string $input The login form system to be sanitized.
	 * @return string The sanitized login form system.
	 */
	static public function sanitize_login_form_systems( string $input ): string {
		return in_array( $input, self::$login_form_systems, true ) ? $input : 'WordPress';
	}

	/**
	 * Image sanitization callback example.
	 *
	 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
	 * send back the filename, otherwise, return the setting default.
	 *
	 * - Sanitization: image file extension
	 * - Control: text, WP_Customize_Image_Control
	 *
	 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
	 * @param string                $image   Image filename.
	 * @param \WP_Customize_Setting $setting Setting instance.
	 * @return string The image filename if the extension is allowed; otherwise, the setting default.
	 */
	static public function sanitize_image( string $image, \WP_Customize_Setting $setting ): string {
		/*
		 * Array of valid image file types.
		 *
		 * The array includes image mime types that are included in wp_get_mime_types()
		 */
		$mimes = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'tif|tiff'     => 'image/tiff',
		);
		// Return an array with file extension and mime_type.
		$file = wp_check_filetype( $image, $mimes );
		// If $image has a valid mime_type, return it; otherwise, return the default.
		return false !== $file['ext'] ? $image : $setting->default;
	}

	/**
	 * This outputs the javascript needed to automate the live settings preview.
	 * Also keep in mind that this function isn't necessary unless your settings
	 * are using 'transport'=>'postMessage' instead of the default 'transport'
	 * => 'refresh'
	 *
	 * Used by hook: 'customize_preview_init'
	 *
	 * @see add_action('customize_preview_init',$func)
	 * @return void Return
	 */
	public static function live_preview(): void {
		$theme_version = wp_get_theme()->get( 'Version' );
		wp_enqueue_script(
			// Give the script a unique ID
			'fold-theme-customizer',
			// Define the path to the JS file
			get_template_directory_uri() . '/assets/js/theme-customizer.js',
			// Define dependencies
			array( 'jquery', 'customize-preview' ),
			// Define a version (optional)
			$theme_version,
			// Specify whether to put in footer (leave this true)
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}

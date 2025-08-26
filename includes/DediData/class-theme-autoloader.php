<?php
/**
 * DediData Theme Autoloader
 * 
 * @package DediData
 */

declare(strict_types=1);

namespace DediData;

use Exception;
use WP_Error;

/**
 * Class Theme_Autoloader
 */
final class Theme_Autoloader {

	/**
	 * Name Spaces
	 * 
	 * @var array<string> $name_spaces
	 */
	protected $name_spaces;

	/**
	 * Theme File
	 * 
	 * @var string $theme_file
	 */
	protected $theme_file;

	/**
	 * Constructor
	 * 
	 * @param array<string> $name_spaces Name Spaces.
	 * @return void
	 */
	public function __construct( array $name_spaces ) {
		$this->name_spaces = $name_spaces;
		// phpcs:ignore SlevomatCodingStandard.ControlStructures.NewWithoutParentheses.UselessParentheses
		$trace = ( new Exception() )->getTrace();
		if ( ! isset( $trace[0]['file'] ) ) {
			new WP_Error( 'Invalid Trace for Autoload' );
		}
		$this->theme_file = isset( $trace[0] ) && isset( $trace[0]['file'] ) ? $trace[0]['file'] : '';
		spl_autoload_register( array( $this, 'autoloader' ) );
	}

	/**
	 * The autoloader function checks if a class is part of a specific theme and includes the
	 * corresponding class file if it exists.
	 * 
	 * @param string $class_name The class parameter is the name of the class that needs to be auto loaded.
	 * @return void Return
	 */
	public function autoloader( string $class_name ): void {
		$parts = explode( '\\', $class_name );
		// Get class name from full class name
		$class_part = end( $parts );
		// Clear class name from the full class name
		$name_space = rtrim( $class_name, $class_part );
		// Clear / from the end of name space
		$name_space = rtrim( $name_space, '\/' );
		// convert \ to / in name space
		$name_space = str_replace( '\\', '/', $name_space );
		if ( ! in_array( $name_space, $this->name_spaces, true ) ) {
			return;
		}
		$class_file     = $name_space . '/class-' . strtolower( str_replace( '_', '-', $class_part ) . '.php' );
		$theme_path     = dirname( $this->theme_file );
		$file_full_path = $theme_path . '/includes/' . $class_file;
		// phpcs:ignore SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed
		if ( file_exists( $file_full_path ) ) {
			require $file_full_path;
		}
	}
}

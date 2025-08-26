<?php
/**
 * Singleton Class
 * 
 * @package DediData
 */

declare(strict_types=1);

namespace DediData;

use WP_Error;

/**
 * Class Singleton
 */
abstract class Singleton {

	/**
	 * This variable is used to store the single instance of the class that is created and
	 * returned by the `getInstance()` method. It ensures that only one instance of the class is created
	 * and that it can be accessed globally.
	 * 
	 * @var array<object> instance
	 */
	private static $instances = array();
	
	/**
	 * The private constructor prevents direct instantiation of the class.
	 * 
	 * @param mixed $param Optional parameter.
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	private function __construct( $param ) { // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
		// still empty
	}

	/**
	 * The function retrieves a property value from an object if it exists, otherwise it returns an error.
	 * 
	 * @param string $property_name The parameter "property_name" is a string that represents the name of the
	 *                              property you want to retrieve from the current object.
	 * @return mixed If the property exists, the value of the property is returned. If the property does not
	 * exist, a WP_Error object is returned with the message "Property '' does not exist."
	 */
	public function get( string $property_name ) {
		$class_name = static::class;
		if ( property_exists( $class_name, $property_name ) ) {
			return $this->$property_name;
		}

		return new WP_Error( "Property '$property_name' does not exist." );
	}

	/**
	 * The function sets the value of a property in a PHP class if the property exists, otherwise it
	 * returns an error.
	 * 
	 * @param string $property_name The name of the property you want to set the value for.
	 * @param mixed  $value         The value that you want to set for the property.
	 * @return void Return
	 */
	public function set( string $property_name, $value ): void {
		$class_name = static::class;
		if ( ! property_exists( $class_name, $property_name ) ) {
			new WP_Error( "Property '$property_name' does not exist." );
		}

		$this->$property_name = $value;
	}

	/**
	 * The getInstance function returns an instance of the class if it doesn't already exist.
	 * 
	 * @param mixed $param Optional Parameter.
	 * @return object      The instance of the class.
	 */
	public static function get_instance( $param = null ) {
		$class_name = static::class;
		if ( ! isset( self::$instances[ $class_name ] ) ) {
			self::$instances[ $class_name ] = new $class_name( $param );
		}
		return self::$instances[ $class_name ];
	}

	/**
	 * The function uses a shared instance of a class and calls a method on it.
	 * 
	 * @return object The object of class
	 */
	protected static function use_instance_in_function_example() {
		$instance = self::get_instance();
		return $instance->$instance;

		// echo $instance->someMethod();

		// Calling a static method that uses the shared instance
		// DediData\Singleton::use_instance_in_function_example();
	}
}

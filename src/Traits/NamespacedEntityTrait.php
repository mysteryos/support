<?php namespace Cartalyst\Support\Traits;
/**
 * Part of the Support package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Support
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

trait NamespacedEntityTrait {

	/**
	 * Returns the entity namespace.
	 *
	 * @return string
	 */
	public static function getEntityNamespace()
	{
		return isset(static::$entityNamespace) ? static::$entityNamespace : get_called_class();
	}

	/**
	 * Sets the entity namespace.
	 *
	 * @param  string  $namespace
	 * @return void
	 */
	public static function setEntityNamespace($namespace)
	{
		static::$entityNamespace = $namespace;
	}

	/**
	 * Checks if the entity is currently namespaced.
	 *
	 * @return bool
	 */
	public static function isEntityNamespaced()
	{
		return (bool) isset(static::$entityNamespace);
	}

}

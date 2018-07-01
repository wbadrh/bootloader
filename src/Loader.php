<?php

namespace wbadrh\Boot;

use Psr\Container\ContainerInterface;
use League\Container\Container;

/**
 * Container dependency injection
 * https://www.php-fig.org/psr/psr-11/
 */
class Loader implements ContainerInterface
{
	// Container
	private $_container;

	// Registered namespaces
	private $_preload = [];

	// Cached objects
	private $_loaded = [];

	/**
	 * Service loader
	 *
	 * @param String $composer Path to composer.json
	 */
	function __construct(String $composer)
	{
		// Start container
		$this->_container = new Container;

		// Root path of composer
		$root = dirname($composer);
		$root = realpath($root) . '/';

		// Find preloaded namespaces
		$composer = file_get_contents($composer);
		$composer = json_decode($composer, true);
		$composer = $composer['autoload']['psr-4'];

		foreach ($composer as $namespace => $dir) {
			// Build full namespace from path
			foreach (glob($root . $dir . '*.php') as $file) {
				$filename = basename($file, '.php');
				$preload  = $namespace . $filename;

				// Skip looping current class
				if ($preload !== __CLASS__)
					$this->_preload[] = $preload;
			}
		}
	}

	/**
	 * Get container object.
	 * This will always retreive the same object within your whole application.
	 *
	 * @param String $id Namespace.
	 *
	 * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
	 * @throws ContainerExceptionInterface Error while retrieving the entry.
	 *
	 * @return Object Cached namespace.
	 */
	public function get($id)
	{
		// Create object
		if (
			$this->has($id)
		 && !in_array($id, $this->_loaded)
		) {
			$this->_container->share($id)->withArgument($this);
			$this->_loaded[] = $id;
		}

		// Fetch object
		return $this->_container->get($id);
	}

	/**
	 * Find out if the container has access to a certain namespace.
	 *
	 * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
	 * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param String $id Namespace.
	 * @return Boolean Namespace available.
	 */
	public function has($id)
	{
		if (in_array($id, $this->_preload))
			return true;

		return false;
	}
}

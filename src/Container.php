<?php

namespace wbadrh\Boot;

use wbadrh\Boot\Loader;

/**
 * Application objects wrapper.
 * Automatically preload bootloader.
 */
class Container
{
    // Bootloader
    protected $loader;

    /**
     * Pass bootloader to object
     *
     * @param Object $loader Bootloader
     */
    function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load class object with optional constructor replacement.
     *
     * @param String $namespace Single object instance.
     */
    protected function load(String $namespace)
    {
        if (!in_array($namespace, $this->loader->lazy)) {
            // Fetch object
            $object = $this->loader->get($namespace);
            // Constructor replacement
            $object->initialize();

            // Save lazyloaded in parent class
            $this->loader->lazy[] = $namespace;
        }

        return $this->loader->get($namespace);
    }
}

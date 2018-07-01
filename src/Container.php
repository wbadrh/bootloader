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
}

<?php

/** DEMO **/

namespace wbadrh\Boot;

use wbadrh\Boot\Container;

class Router extends Container
{
    public function run()
    {
        // Load shared database object
        $db = $this->loader->get('wbadrh\Boot\Connection');

        echo $db->connection; // Connection not loaded
        echo PHP_EOL;

        // Connect database
        $db->connect();

        echo $db->connection; // Connection loaded
        echo PHP_EOL;

        echo 'run router ...';
    }
}

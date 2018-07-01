<?php

/** DEMO **/

namespace wbadrh\Boot;

use wbadrh\Boot\Container;

class Connection extends Container
{
    public $connection;

    public function connect()
    {
        $this->connection = 'connection ...';
    }
}

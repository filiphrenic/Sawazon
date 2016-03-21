<?php

namespace Routing;

use \Exception;

class RoutingException extends Exception
{
    public function __construct($message = "", Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
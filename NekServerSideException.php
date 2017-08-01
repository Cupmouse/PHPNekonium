<?php

namespace kabayaki\PHPNekonium;


use Throwable;

class NekServerSideException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return parent::__toString();
    }

}
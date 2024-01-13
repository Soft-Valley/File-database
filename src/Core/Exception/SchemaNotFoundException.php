<?php

namespace Tusharkhan\FileDatabase\Core\Exception;

use Throwable;

class SchemaNotFoundException extends \Exception
{
    public function __construct($name , $code = 0, Throwable $previous = null)
    {
        parent::__construct($name . " not found", $code, $previous);
    }
}
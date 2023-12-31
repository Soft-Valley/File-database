<?php

namespace Tusharkhan\FileDatabase\Core\Exception;

class OperatorNotFoundException extends \Exception
{
    public function __construct($operator, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($operator ." operator not found", $code, $previous);
    }
}
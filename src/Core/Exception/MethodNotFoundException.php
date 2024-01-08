<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/2/2024
 */


namespace Tusharkhan\FileDatabase\Core\Exception;

class MethodNotFoundException extends \Exception
{
    public function __construct($methodName, $className, $code = 0, \Throwable $previous = null)
    {
        parent::__construct("Method $methodName() not found in $className", $code, $previous);
    }
}
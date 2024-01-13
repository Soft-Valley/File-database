<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/26/2023
 */


namespace Tusharkhan\FileDatabase\Core\Exception;

use Throwable;

class TableExistsException extends \Exception
{
    public function __construct($table , $code = 0, Throwable $previous = null)
    {
        $message = "Table $table already exists";
        parent::__construct($message, $code, $previous);
    }
}
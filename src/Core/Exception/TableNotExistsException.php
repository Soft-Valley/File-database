<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/27/2023
 */


namespace Tusharkhan\FileDatabase\Core\Exception;

class TableNotExistsException extends \Exception
{
    public function __construct($table)
    {
        parent::__construct("Table $table not exists");
    }
}
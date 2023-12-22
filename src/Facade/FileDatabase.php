<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Facade;

use Illuminate\Support\Facades\Facade;

class FileDatabase extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FileDatabase';
    }
}
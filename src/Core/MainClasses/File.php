<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/24/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File as FacadesFile;

class File
{

    // create directory with read and write permission
    public static function createDirectory($path = null)
    {
        $path = (! $path) ? Config::get('fileDatabase.database_directory') : $path;

        if (!FacadesFile::exists($path)) {
            return (bool)FacadesFile::makeDirectory($path, 0777, true, true);
        }

        return false;
    }

    // create file with read and write permission
    public static function createFile($path)
    {
        if (!FacadesFile::exists($path)) {
            return (bool)FacadesFile::put($path, '');
        }
    }

    public static function set($path, $content)
    {
        if (FacadesFile::exists($path)) {
            return (bool)FacadesFile::put($path, $content);
        }

        return false;
    }

    public static function get($path)
    {
        if (FacadesFile::exists($path)) {
            return FacadesFile::get($path);
        }
    }
}
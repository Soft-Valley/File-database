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
        if (!FacadesFile::exists($path)) {
            return (bool)FacadesFile::makeDirectory($path, 0777, true, true);
        }

        return false;
    }

    // create file with read and write permission
    public static function createFile($path, $content = null)
    {
        if (!FacadesFile::exists($path)) {
            if (FacadesFile::put($path, $content)) {
                return (bool)FacadesFile::chmod($path, 0777);
            }
        }

        return false;
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

    public static function delete($path)
    {
        if (FacadesFile::exists($path)) {
            return (bool)FacadesFile::delete($path);
        }
    }

    public static function deleteDirectory($path)
    {
        if (FacadesFile::exists($path)) {
            return (bool)FacadesFile::deleteDirectory($path);
        }
    }

    public static function exists($path)
    {
        return FacadesFile::exists($path);
    }
}
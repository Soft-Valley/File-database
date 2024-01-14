<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


use Illuminate\Support\Facades\Config;
use Tusharkhan\FileDatabase\Core\MainClasses\File;

if( ! function_exists('isBinary') ){
    function isBinary($data) {
        return ! mb_check_encoding($data, 'UTF-8');
    }
}


if( ! function_exists('isDate')){
    function isDate($data){
        return (bool) strtotime($data);
    }
}

if( ! function_exists('arrayDepth')) {
    function arrayDepth($array)
    {
        if (empty($array) || !is_array($array)) {
            return 0;
        }

        return max(\Illuminate\Support\Arr::map($array, 'arrayDepth')) + 1;
    }
}

if ( ! function_exists('tableDirectory') ){
    function tableDirectory()
    {
        return storage_path(Config::get('fileDatabase.database_directory', 'fileDatabase') . '/' . Config::get('fileDatabase.tables_directory', 'tables'));
    }
}

if( ! function_exists('getTablePath')) {
    function getTablePath($table, $suffix = '')
    {
        $directoryPath = Config::get('fileDatabase.database_directory', 'fileDatabase');
        $tablesPath = Config::get('fileDatabase.tables_directory', 'tables');
        return storage_path($directoryPath . '/' . $tablesPath . '/' . $table . $suffix . '.json');
    }
}

if( ! function_exists('getTableData') ) {
    function getTableData($table, $suffix = '')
    {
        $tablePath = getTablePath($table, $suffix);
        if (File::exists($tablePath)) {
            return json_decode(File::get($tablePath), true);
        }

        return [];
    }
}

if( ! function_exists('isMultidimensionalArray') ) {
    function isMultidimensionalArray($array)
    {
        foreach ($array as $element) {
            if (is_array($element)) {
                return true;
            }
        }

        return false;
    }
}

if( ! function_exists('sortMultidimensionalArray') ) {
    function sortMultidimensionalArray(&$array, $key, $sortType = SORT_ASC)
    {
        $sortKeys = array_column($array, $key);

        array_multisort($sortKeys, $sortType, $array);
    }
}

if ( ! function_exists('migrationNameSpace') ){
    function migrationNameSpace()
    {
        return 'App\\'.
            \Illuminate\Support\Str::studly(config('fileDatabase.root_directory')).
            '\\'.
            \Illuminate\Support\Str::studly(config('fileDatabase.database_file_directory')) .
            '\\'.
            \Illuminate\Support\Str::studly(config('fileDatabase.migrations_directory'));
    }
}

if ( ! function_exists('migrationDirectory') ){
    function migrationDirectory()
    {
        return app_path(str_replace("\\", "/", str_replace("App\\", "", migrationNameSpace())));
    }
}

if ( ! function_exists('migrationFileDatePattern') ){
    function migrationFileDatePattern()
    {
        return '/\d{4}_\d{2}_\d{2}_\d{6}_/';
    }
}

if ( ! function_exists('classInstance') ){
    function classInstance($classWithNamespace)
    {
        return new $classWithNamespace;
    }
}
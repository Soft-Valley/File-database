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
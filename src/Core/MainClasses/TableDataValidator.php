<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/27/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TableDataValidator
{

    public static function validate(MainModel $model, $data)
    {
        $schemaData = getTableData($model->getTable(), '_schema');
        $schemaDataColumns = $schemaData['columns'];
        $errors = [];

        Arr::map($data, function($value, $key) use ($schemaDataColumns, &$errors){
            // check if the key exists in schema
            if( ! array_key_exists($key, $schemaDataColumns) ){
                $errors[$key][] = $key . ' is not a valid column';
                return;
            }

            $length = $schemaDataColumns[$key]['length'];
            $type = $schemaDataColumns[$key]['type'];
            $fieldName = $key;
            $fieldNameCamelCase = Str::title($type);
            $method = 'is' . $fieldNameCamelCase;

            if( ! method_exists(DataTypes::class, $method) ){
                $errors[$fieldName][] = 'Invalid data type';
            } else {
                $isValid = DataTypes::$method($value);
                if( ! $isValid ){
                    $errors[$fieldName][] = $fieldName . ' is not ' . $fieldNameCamelCase . ' type';
                }
            }

            // check length error
            if( strlen((string)$value) > $length ){
                $errors[$fieldName][] = $fieldName . ' length is greater than ' . $length;
            }
        });

        return $errors;
    }
}
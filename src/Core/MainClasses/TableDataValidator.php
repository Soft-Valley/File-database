<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/27/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Tusharkhan\FileDatabase\Core\Exception\SchemaNotFoundException;
use Tusharkhan\FileDatabase\Core\Interfaces\Eloquent;


class TableDataValidator
{

    public static function validate(Eloquent $model, $data)
    {
        $schemaData = self::getTableData($model->getTable(), '_schema');

        if( ! $schemaData ){
            throw new SchemaNotFoundException($model->getTable() . '_schema');
        }


        $model->setSchemaData($schemaData);

        $schemaDataColumns = $schemaData['columns'];
        $errors = [];

        if ( ! $model->isMultiDimensional() ) {
            $data = [$data];
            $model->setDataInsert($data);
        }

        foreach ($data as $key => $value) {
            $errors = self::checkErrors($value, $schemaDataColumns, $errors);
        }

        if( $errors ) return $errors;

        self::processDataToInsertTable($model);
    }

    private static function getTableData($table, $suffix = '')
    {
        $tablePath = self::getTablePath($table, $suffix);
        if (File::exists($tablePath)) {
            return json_decode(File::get($tablePath), true);
        }

        return [];
    }

    private static function getTablePath($table, $suffix = '')
    {
        $directoryPath = Config::get('fileDatabase.database_directory', 'fileDatabase');
        $tablesPath = Config::get('fileDatabase.tables_directory', 'tables');
        return storage_path($directoryPath . '/' . $tablesPath . '/' . $table . $suffix . '.json');
    }

    private static function checkErrors($data, $schemaDataColumns, &$errors)
    {
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

    private static function processDataToInsertTable(Eloquent $model)
    {
        $tableData = getTableData($model->getTable());
        $model->setPreviousData($tableData ?? []);

        $lastId = 0;
        if (!empty($tableData)) {
            $lastId = end($tableData)[$model->getPrimaryKey()];
        }

        $newData = Arr::map($model->getDataInsert(), function ($value, $key) use (&$lastId, $model) {

            if (!in_array('*', $model->getFillable())) {
                $value = Arr::only($value, $model->getFillable());
            }

            $newInsertArr = [
                $model->getPrimaryKey() => $lastId + 1
            ];

            if ($model->isTimestamp()) {
                $newInsertArr['created_at'] = date('Y-m-d H:i:s');
                $newInsertArr['updated_at'] = date('Y-m-d H:i:s');
            }

            $value = array_merge($value, $newInsertArr);

            $lastId++;

            return $value;
        });


        // merge new data with old data
        $model->setData($newData);
    }
}
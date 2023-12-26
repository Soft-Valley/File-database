<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/27/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

class TableDataValidator
{
    public static function validate(MainModel $model, $data)
    {
        $tablePath = getTablePath($model->getTable());

        if (File::exists($tablePath)) {
            $schema = File::get($tablePath);
            $schema = json_decode($schema, true);
            $schema = Arr::pluck($schema, 'type', 'name');
            $schema = array_map(function ($item) {
                return DataTypes::getDataType($item);
            }, $schema);
            $schema = array_filter($schema, function ($item) {
                return $item !== null;
            });
            $schema = array_keys($schema);
            $schema = array_flip($schema);
            $schema = array_fill_keys(array_keys($schema), null);
            $data = array_merge($schema, $data);
        }


    }
}
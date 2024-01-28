<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Arr;
use Tusharkhan\FileDatabase\Core\Exception\MethodNotFoundException;
use Tusharkhan\FileDatabase\Core\Interfaces\Eloquent;
use Tusharkhan\FileDatabase\Core\AbstractClasses\Eloquent as EloquentAbstract;

class MainModel extends EloquentAbstract implements  Eloquent
{
    public static function __callStatic(string $name, array $arguments)
    {
        return (self::newQuery())->$name(...$arguments);
    }

    public static function create($data)
    {
        $instance = new static();
        $instance->dataInsert = $data;
        return $instance->save();
    }

    public function validateData($data = null)
    {
        return TableDataValidator::validate($this, $data ?? $this->getDataInsert());
    }

    public static function delete($id)
    {
        $query = self::newQuery();
        $instance = $query->getModel();
        $tableData = $query->getTableData()->toArray();

        $data = Arr::where($tableData, function ($value, $key) use ($id, $instance) {
            return $value[$instance->getPrimaryKey()] != $id;
        });

        $instance->setData(array_values($data));

        return count($instance->insertIntoTable()) > 0;
    }

    public static function update($id, $data)
    {
        $query = self::newQuery();
        $instance = $query->getModel();
        $tableData = $query->getTableData()->toArray();

        $searchData = Arr::where($tableData, function ($value, $key) use ($id, &$selectedKey, $instance) {
            if ($value[$instance->getPrimaryKey()] == $id) {
                $selectedKey = $key;
                return $value;
            }

            return null;
        });

        if ( $searchData ){
            $arr = array_values($searchData)[0];
            Arr::map($data, function ($value, $key) use (&$arr) {
                $arr[$key] = $value;
            });

            $tableData[$selectedKey] = $arr;

            $instance->setData($tableData);

            return count($instance->insertIntoTable()) > 0;
        }

        return false;
    }

    public function save()
    {
        $errors = $this->validateData();

        if ($errors) {
            return $errors;
        }

        return $this->insertIntoTable();
    }


    public static function newQuery()
    {
        return (new Query(new static()));
    }


    public static function with(array|string $with)
    {
        return self::newQuery()->with($with);
    }


    public static function all()
    {
        return self::newQuery()->getTableData();
    }

    /**
     * @throws MethodNotFoundException
     */
    public static function find($id)
    {
        return self::newQuery()->find($id);
    }
}
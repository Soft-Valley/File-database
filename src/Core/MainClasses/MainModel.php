<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use ArrayIterator;
use Illuminate\Support\Arr;
use Tusharkhan\FileDatabase\Core\Interfaces\Eloquent;
use Tusharkhan\FileDatabase\Core\AbstractClasses\Eloquent as EloquentAbstract;

class MainModel extends EloquentAbstract implements \IteratorAggregate, Eloquent
{

//    public static function query()
//    {
//        $instance = new static();
//        $getTable = $instance->getTable();
//        $tableData = getTableData($getTable);
//        $instance->setData(collect($tableData));
//
//        return $instance->getData();
//    }

    public static function __callStatic(string $name, array $arguments)
    {
        $instance = new static();

        if ( $name != 'with' )
            $instance->setQuery([$name, $arguments]);
        else
            $instance->setRelations($arguments);

        return $instance;
    }

    public function __call(string $name, array $arguments)
    {
        if ( $name != 'with' )
            $this->setQuery([$name, $arguments]);
        else
            $this->setRelations($arguments);

        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function create($data)
    {
        $this->setDataInsert($data);
        return $this->save();
    }

    public function validateData($data = null)
    {
        return TableDataValidator::validate($this, $data ?? $this->getDataInsert());
    }

    public function delete($id)
    {
        $tablePath = $this->getTable();
        $tableData = getTableData($tablePath);

        $data = Arr::where($tableData, function ($value, $key) use ($id) {
            return $value[$this->getPrimaryKey()] != $id;
        });

        $this->setData(array_values($data));

        return count($this->insertIntoTable()) > 0;
    }

    public function update($id, $data)
    {
        if ( ! isset($data['updated_at']) )
        {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $tablePath = $this->getTable();
        $tableData = getTableData($tablePath);
        $selectedKey = null;

        $searchData = Arr::where($tableData, function ($value, $key) use ($id, &$selectedKey) {
            if ($value[$this->getPrimaryKey()] == $id) {
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

            $this->setData($tableData);

            return count($this->insertIntoTable()) > 0;
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

    // fetch all data from table
    public static function all()
    {
        $instance = new static();
        $tablePath = $instance->getTable();
        $tableData = getTableData($tablePath);

        $instance->setData(collect($tableData));

        return $instance->data;
    }

    // fetch data from table by id
    public static function find($id)
    {
        $instance = new static();
        $tablePath = $instance->getTable();
        $tableData = getTableData($tablePath);
        $data = Arr::where($tableData, function ($value, $key) use ($id, $instance) {
            return $value[$instance->getPrimaryKey()] == $id;
        });

        $instance->setData(collect($data[0] ?? []));

        return $instance->data;
    }
}
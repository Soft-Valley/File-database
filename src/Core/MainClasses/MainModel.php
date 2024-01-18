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

    public static function __callStatic(string $name, array $arguments)
    {
        $instance = new static();

        $instance->setRelationsAndQuery($instance, $name, $arguments);

        return $instance;
    }

    public function __call(string $name, array $arguments)
    {
        $this->setRelationsAndQuery($this, $name, $arguments);

        return $this;
    }

    private function setRelationsAndQuery(&$instance, string $name, array $arguments)
    {
        if ( $name != 'with' )
            $instance->setQuery([$name, $arguments]);
        else
            $instance->setWith($arguments);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
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
        $instance = new static();
        $tablePath = $instance->getTable();
        $tableData = getTableData($tablePath);

        $data = Arr::where($tableData, function ($value, $key) use ($id, $instance) {
            return $value[$instance->getPrimaryKey()] != $id;
        });

        $instance->setData(array_values($data));

        return count($instance->insertIntoTable()) > 0;
    }

    public static function update($id, $data)
    {
        $instance = new static();
        if ( ! isset($data['updated_at']) ) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $tablePath = $instance->getTable();
        $tableData = getTableData($tablePath);
        $selectedKey = null;

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
}
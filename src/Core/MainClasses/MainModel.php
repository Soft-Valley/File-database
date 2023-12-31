<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use ArrayIterator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tusharkhan\FileDatabase\Core\Interfaces\Eloquent;
use Tusharkhan\FileDatabase\Core\AbstractClasses\Eloquent as EloquentAbstract;
use Tusharkhan\FileDatabase\Core\Traits\MainQuery;

class MainModel extends EloquentAbstract implements \IteratorAggregate, Eloquent
{
    use MainQuery;

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
}
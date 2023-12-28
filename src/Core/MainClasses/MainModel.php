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

class MainModel extends EloquentAbstract implements \IteratorAggregate, Eloquent
{
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
        // TODO: Implement delete() method.
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
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
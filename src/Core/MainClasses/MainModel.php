<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use ArrayIterator;
use Illuminate\Support\Str;

class MainModel implements \IteratorAggregate
{

    protected $table;

    protected $structure;

    protected $model;

    protected $data = [];

    protected $timestamp = true;

    protected $attribute;

    protected $primaryKey = 'id';

    protected $incrementing = true;

    protected $relations;

    protected $fillable = [];

    protected $append;

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function getTable()
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function validateData()
    {
        TableDataValidator::validate($this, $this->data);
    }
}
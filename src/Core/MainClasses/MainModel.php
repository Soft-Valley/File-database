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

    protected $dataInsert = [];


    private $schemaData;

    /**
     * @return mixed
     */
    public function getSchemaData()
    {
        return $this->schemaData;
    }

    /**
     * @param mixed $schemaData
     */
    public function setSchemaData($schemaData): void
    {
        $this->schemaData = $schemaData;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function __set(string $name, $value): void
    {
        $this->dataInsert[$name] = $value;
    }

    public function __get(string $name)
    {
        return $this->dataInsert[$name] ?? null;
    }

    public function create($data)
    {
        $arr = [];
        // add data into dataInsert
        if ( isMultidimensionalArray($data) ){
            foreach ($data as $key => $value) {
                $arr[] = array_merge($value, $this->dataInsert);
            }
        } else {
            $arr[] = array_merge($data, $this->dataInsert);
        }

        $this->dataInsert = $arr;

        $errors = $this->validateData();

        if ( count($errors) > 0 ) {
            return $errors;
        }

        $this->processDataToInsert();
    }

    public function getTable()
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function validateData()
    {
        return TableDataValidator::validate($this, $this->dataInsert);
    }

    private function processDataToInsert()
    {
        dd($this->getSchemaData(), $this->dataInsert);
    }
}
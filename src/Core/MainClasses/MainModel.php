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

class MainModel implements \IteratorAggregate, Eloquent
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

    protected $fillable = ['*'];

    protected $append;

    protected $dataInsert = [];

    private $schemaData;

    private $previousData;

    /**
     * @return mixed
     */
    public function getPreviousData()
    {
        return $this->previousData;
    }

    /**
     * @param mixed $previousData
     */
    public function setPreviousData($previousData): void
    {
        $this->previousData = $previousData;
    }

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
        $this->setDataInsert($data);

        $errors = $this->validateData();

        if ( count($errors) > 0 ) {
            return $errors;
        }

        $this->processDataToInsertTable();

        $tablePath = getTablePath($this->getTable());

        return File::set($tablePath, json_encode(array_merge($this->data, $this->getPreviousData()), JSON_PRETTY_PRINT)) ? $this->data : [];
    }

    public function getTable()
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function validateData()
    {
        return TableDataValidator::validate($this, $this->dataInsert);
    }

    private function processDataToInsertTable()
    {
        $tableData = getTableData($this->getTable());

        $this->setPreviousData($tableData);

        $lastId = 0;
        if ( ! empty($tableData) ) {
            $lastId = end($tableData)[$this->primaryKey];
        }

        $newData = Arr::map($this->dataInsert, function($value, $key) use (&$lastId){

            if ( ! in_array('*', $this->fillable) ){
                $value = Arr::only($value, $this->fillable);
            }

            $newInsertArr = [
                $this->primaryKey => $lastId + 1
            ];

            if ( $this->timestamp ){
                $newInsertArr['created_at'] = date('Y-m-d H:i:s');
                $newInsertArr['updated_at'] = date('Y-m-d H:i:s');
            }

            $value = array_merge($value, $newInsertArr);

            $lastId++;

            return $value;
        });

        // merge new data with old data
        $this->data = $newData;
    }

    private function setDataInsert($data)
    {
        if ( isMultidimensionalArray($data) ){
            $this->dataInsert = Arr::map($data, function($value, $key){
                return array_merge($value, $this->dataInsert);
            });
        } else {
            $this->dataInsert = [array_merge($data, $this->dataInsert)];
        }
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/29/2023
 */


namespace Tusharkhan\FileDatabase\Core\AbstractClasses;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tusharkhan\FileDatabase\Core\Exception\MethodNotFoundException;
use Tusharkhan\FileDatabase\Core\MainClasses\File;
use Tusharkhan\FileDatabase\Core\MainClasses\Query;
use Tusharkhan\FileDatabase\Core\Traits\Relations;

abstract class Eloquent
{
    use Relations;

    protected $table;

    protected $with = [];

    protected $model;

    protected $data = [];

    protected $timestamp = true;

    protected $attribute;

    protected $primaryKey = 'id';

    protected $incrementing = true;

    protected $relations = [];

    protected $fillable = ['*'];

    protected $append;

    protected $query = [];

    protected $dataInsert = [];

    private $schemaData;

    private $previousData = [];

    private $isMultiDimensional = false;

    public function __construct()
    {
        $this->setTable($this->getTable());
    }

    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        $this->dataInsert[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->dataInsert[$name] ?? null;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return array|Collection
     */
    public function getData(): array|Collection
    {
        return $this->data;
    }

    /**
     * @param array|Collection $data
     * @return void
     */
    public function setData(array|Collection $data): void
    {
        $this->data = $data;
    }

    /**
     * @return bool
     */
    public function isTimestamp(): bool
    {
        return $this->timestamp;
    }

    /**
     * @param bool $timestamp
     * @return void
     */
    public function setTimestamp(bool $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute): void
    {
        $this->attribute = $attribute;
    }

    /**
     * @return bool
     */
    public function isIncrementing(): bool
    {
        return $this->incrementing;
    }

    /**
     * @param bool $incrementing
     * @return void
     */
    public function setIncrementing(bool $incrementing): void
    {
        $this->incrementing = $incrementing;
    }

    /**
     * @return string[]
     */
    public function getFillable(): array
    {
        return $this->fillable;
    }

    /**
     * @param array $fillable
     * @return void
     */
    public function setFillable(array $fillable): void
    {
        $this->fillable = $fillable;
    }

    /**
     * @return mixed
     */
    public function getAppend()
    {
        return $this->append;
    }

    /**
     * @param mixed $append
     */
    public function setAppend($append): void
    {
        $this->append = $append;
    }

    /**
     * @return array
     */
    public function getDataInsert(): array
    {
        return $this->dataInsert;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    /**
     * @param array $dataInsert
     * @return void
     */
    public function setDataInsert(array $dataInsert): void
    {
        $this->setIsMultiDimensional(isMultidimensionalArray($dataInsert));

        if ($this->isMultiDimensional()) {
            $this->dataInsert = Arr::map($dataInsert, function ($value, $key) {
                return array_merge($value, $this->dataInsert);
            });
        } else {
            $this->dataInsert = [array_merge($dataInsert, $this->dataInsert)];
        }
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * @param string $primaryKey
     * @return void
     */
    public function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

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
     * @return array|mixed
     */
    public function insertIntoTable()
    {
        $tablePath = getTablePath($this->getTable());

        $insertData  = array_merge($this->data, $this->getPreviousData());

        sortMultidimensionalArray($insertData, $this->getPrimaryKey());

        return File::set($tablePath, json_encode($insertData, JSON_PRETTY_PRINT))
            ? $this->data : [];
    }

    /**
     * @return bool
     */
    public function isMultiDimensional(): bool
    {
        return $this->isMultiDimensional;
    }

    /**
     * @param bool $isMultiDimensional
     * @return void
     */
    public function setIsMultiDimensional(bool $isMultiDimensional): void
    {
        $this->isMultiDimensional = $isMultiDimensional;
    }

    /**
     * @param string $getTable
     * @return void
     */
    public function setTable(string $getTable)
    {
        $this->table = $getTable;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query[] = $query;
    }

    public function getWith(): array
    {
        return $this->with;
    }

    public function setWith(array|string $with): void
    {
        $this->with = $with;
    }

    /**
     * @return bool|mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return array|Collection
     * @throws MethodNotFoundException
     */
    public function get()
    {
        return (new Query($this))->filterDataFromModel();
    }
}
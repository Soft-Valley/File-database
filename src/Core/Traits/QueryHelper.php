<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/28/2024
 */


namespace Tusharkhan\FileDatabase\Core\Traits;

use Tusharkhan\FileDatabase\Core\Exception\MethodNotFoundException;

trait QueryHelper
{
    public function where($column, $operator = null, $value = null)
    {
        if (! $value) {
            $value = $operator;
            $operator = '=';
        }

        $this->setTableData($this->getTableData()->where($column, $operator, $value));

        return $this;
    }

    public function avg($column = null)
    {
        return $this->getTableData()->avg($column);
    }

    public function count()
    {
        return $this->getTableData()->count();
    }

    public function max($column = null)
    {
        return $this->getTableData()->max($column);
    }

    public function min($column = null)
    {
        return $this->getTableData()->min($column);
    }

    public function sum($column = null)
    {
        return $this->getTableData()->sum($column);
    }

    public function chunk($count)
    {
        $this->setTableData($this->getTableData()->chunk($count));

        return $this;
    }

    public function dd()
    {
        $this->getTableData()->dd();
    }

    public function filter(callable $callback = null)
    {
        $this->setTableData($this->getTableData()->filter($callback));

        return $this;
    }

    /**
     * @throws MethodNotFoundException
     */
    public function find($id)
    {
        $primaryKey = $this->model->getPrimaryKey();

        return $this->where($primaryKey, '=',$id)->first();
    }


    /**
     * @throws MethodNotFoundException
     */
    public function first()
    {
        $getData = $this->get();
        $values = $getData->values();
        return (count($values) > 0) ? $getData->first() : null;
    }

    /**
     * @throws \Exception
     */
    public function findOrFail($id)
    {
        $data = $this->find($id);

        if (!$data) {
            throw new \Exception('Item not found');
        }

        return $data;
    }

    public function groupBy(callable|array|string $groupBy)
    {
        $this->setTableData($this->getTableData()->groupBy($groupBy));

        return $this;
    }

    public function last()
    {
        return $this->getTableData()->last();
    }

    public function map(callable $callback)
    {
        $this->setTableData($this->getTableData()->map($callback));

        return $this;
    }

    public function pluck($value, $key = null)
    {
        return $this->getTableData()->pluck($value, $key);
    }

    public function reverse()
    {
        $this->setTableData($this->getTableData()->reverse());

        return $this;
    }

    public function skip($count)
    {
        $this->setTableData($this->getTableData()->skip($count));

        return $this;
    }

    public function sortBy($callback, $options = SORT_REGULAR, $descending = false)
    {
        $this->setTableData($this->getTableData()->sortBy($callback, $options, $descending));

        return $this;
    }

    public function take($count)
    {
        $this->setTableData($this->getTableData()->take($count));

        return $this;
    }

    public function toArray()
    {
        return $this->getTableData()->toArray();
    }

    public function toJson($options = 0)
    {
        return $this->getTableData()->toJson($options);
    }

    public function whereBetween($column, array $values)
    {
        $this->setTableData($this->getTableData()->whereBetween($column, $values));

        return $this;
    }

    public function whereIn($column, $values, $strict = false)
    {
        $this->setTableData($this->getTableData()->whereIn($column, $values, $strict));

        return $this;
    }

    public function whereNotBetween($column, array $values)
    {
        $this->setTableData($this->getTableData()->whereNotBetween($column, $values));

        return $this;
    }

    public function whereNotIn ($column, $values, $strict = false)
    {
        $this->setTableData($this->getTableData()->whereNotIn($column, $values, $strict));

        return $this;
    }

    public function whereNull($column)
    {
        $this->setTableData($this->getTableData()->whereNull($column));

        return $this;
    }

    public function whereNotNull($column)
    {
        $this->setTableData($this->getTableData()->whereNotNull($column));

        return $this;
    }
}
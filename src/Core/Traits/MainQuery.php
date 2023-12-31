<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Core\Traits;

use Illuminate\Support\Arr;
use Tusharkhan\FileDatabase\Core\Exception\OperatorNotFoundException;

trait MainQuery
{
    // initial static query method with all data
    public static function query()
    {
        $instance = new static;
        $instance->all();

        return $instance;
    }

    // fetch all data from table
    public function all()
    {
        $tablePath = $this->getTable();
        $tableData = getTableData($tablePath);

        $this->setData($tableData);

        return $this;
    }

    // fetch data from table by id
    public function find($id)
    {
        $tableData = $this->getData();
        $data = Arr::where($tableData, function ($value, $key) use ($id) {
            return $value[$this->getPrimaryKey()] == $id;
        });

        $this->setData($data);

        return $this;
    }

    // fetch data from table by column name
    public function where($column, $operator = null, $value = null)
    {
        $tableData = $this->getData();

        $data = Arr::where($tableData, function ($value, $key) use ($column, $operator, $value) {
            if (is_array($column)) {
                foreach ($column as $key => $val) {
                    if ($value[$key] != $val) {
                        return false;
                    }
                }

                return true;
            }

            if (is_callable($column)) {
                return $column($value, $key);
            }

            if (func_num_args() === 2) {
                $value = $operator;
                $operator = '=';
            }

            switch ($operator) {
                case '=':
                    return $value == $value[$column];
                case '<>':
                case '!=':
                    return $value != $value[$column];
                case '>':
                    return $value > $value[$column];
                case '>=':
                    return $value >= $value[$column];
                case '<':
                    return $value < $value[$column];
                case '<=':
                    return $value <= $value[$column];
                case 'like':
                    return fnmatch($value, $value[$column]);
                case 'not like':
                    return !fnmatch($value, $value[$column]);
                case 'in':
                    return in_array($value, $value[$column]);
                case 'not in':
                    return !in_array($value, $value[$column]);
                case 'between':
                    return $value[$column] >= $value[0] && $value[$column] <= $value[1];
                case 'not between':
                    return $value[$column] < $value[0] || $value[$column] > $value[1];
                case 'null':
                    return is_null($value[$column]);
                case 'not null':
                    return !is_null($value[$column]);
                case 'array':
                    return is_array($value[$column]);
                case 'not array':
                    return !is_array($value[$column]);
                case 'object':
                    return is_object($value[$column]);
                case 'not object':
                    return !is_object($value[$column]);
                case 'empty':
                    return empty($value[$column]);
                case 'not empty':
                    return !empty($value[$column]);
                case 'datetime':
                case 'time':
                case 'date':
                    return is_string($value[$column]) && strtotime($value[$column]) !== false;
                case 'not datetime':
                case 'not time':
                case 'not date':
                    return !is_string($value[$column]) || strtotime($value[$column]) === false;
                case 'boolean':
                    return is_bool($value[$column]);
                case 'not boolean':
                    return !is_bool($value[$column]);
                case 'numeric':
                    return is_numeric($value[$column]);
                case 'not numeric':
                    return !is_numeric($value[$column]);
                case 'integer':
                    return is_int($value[$column]);
                case 'not integer':
                    return !is_int($value[$column]);
                case 'float':
                    return is_float($value[$column]);
                case 'not float':
                    return !is_float($value[$column]);
                case 'string':
                    return is_string($value[$column]);
                case 'not string':
                    return !is_string($value[$column]);
                case 'scalar':
                    return is_scalar($value[$column]);

                default:
                    throw new OperatorNotFoundException($operator);

            }
        });

        $this->setData($data);

        return $this;

    }

    // fetch data from table by column name
    public function whereIn($column, $values)
    {
        $tableData = $this->getData();

        $data = Arr::where($tableData, function ($value, $key) use ($column, $values) {
            return in_array($value[$column], $values);
        });

        $this->setData($data);

        return $this;
    }

    // fetch data from table by column name
    public function whereNotIn($column, $values)
    {
        $tableData = $this->getData();

        $data = Arr::where($tableData, function ($value, $key) use ($column, $values) {
            return !in_array($value[$column], $values);
        });

        $this->setData($data);

        return $this;
    }

    // fetch data from table by column name

    public function whereBetween($column, $values)
    {
        $tableData = $this->getData();

        $data = Arr::where($tableData, function ($value, $key) use ($column, $values) {
            return $value[$column] >= $values[0] && $value[$column] <= $values[1];
        });

        $this->setData($data);

        return $this;
    }

    // fetch data from table by column name
    public function whereNotBetween($column, $values)
    {
        $tableData = $this->getData();

        $data = Arr::where($tableData, function ($value, $key) use ($column, $values) {
            return $value[$column] < $values[0] || $value[$column] > $values[1];
        });

        $this->setData($data);

        return $this;
    }

    // fetch data from table by column name
    public function whereNull($column)
    {
        $tableData = $this->getData();

        $data = Arr::where($tableData, function ($value, $key) use ($column) {
            return is_null($value[$column]);
        });

        $this->setData($data);

        return $this;
    }

    // fetch data from table by column name
    public function whereNotNull($column)
    {
        $tableData = $this->getData();

        $data = Arr::where($tableData, function ($value, $key) use ($column) {
            return !is_null($value[$column]);
        });

        $this->setData($data);

        return $this;
    }

    // order by data from table by column name
    public function orderBy($column, $direction = 'asc')
    {
        $tableData = $this->getData();

        $data = Arr::sort($tableData, function ($value, $key) use ($column, $direction) {
            if (is_array($column)) {
                foreach ($column as $key => $val) {
                    if ($value[$key] != $val) {
                        return false;
                    }
                }

                return true;
            }

            if (is_callable($column)) {
                return $column($value, $key);
            }

            if (func_num_args() === 2) {
                $direction = $column;
                $column = $this->getPrimaryKey();
            }

            if ($direction === 'asc') {
                return $value[$column] > $value[$column];
            }

            return $value[$column] < $value[$column];
        });

        $this->setData($data);

        return $this;
    }

    // order by data from table by column name
    public function latest($column = 'created_at')
    {
        return $this->orderBy($column, 'desc');
    }

    // order by data from table by column name
    public function oldest($column = 'created_at')
    {
        return $this->orderBy($column, 'asc');
    }

    // order by data from table by column name
    public function limit($limit)
    {
        $tableData = $this->getData();

        $data = array_slice($tableData, 0, $limit);

        $this->setData($data);

        return $this;
    }

    // order by data from table by column name
    public function offset($offset)
    {
        $tableData = $this->getData();

        // slice array
        $data = array_slice($tableData, $offset);

        $this->setData($data);

        return $this;
    }

    // order by data from table by column name
    public function take($limit)
    {
        return $this->limit($limit);
    }

    // order by data from table by column name
    public function skip($offset)
    {
        return $this->offset($offset);
    }

    // order by data from table by column name
    public function first()
    {
        $tableData = $this->getData();

        $data = array_slice($tableData, 0, 1);

        $this->setData($data);

        return $this;
    }

    // order by data from table by column name
    public function get()
    {
        return $this->getData();
    }

    // order by data from table by column name
    public function count()
    {
        return count($this->getData());
    }

    // order by data from table by column name
    public function max($column)
    {
        $tableData = $this->getData();

        $data = Arr::sort($tableData, function ($value, $key) use ($column) {
            return $value[$column] > $value[$column];
        });

        $this->setData($data);

        return $this->first();
    }

    // order by data from table by column name
    public function min($column)
    {
        $tableData = $this->getData();

        $data = Arr::sort($tableData, function ($value, $key) use ($column) {
            return $value[$column] < $value[$column];
        });

        $this->setData($data);

        return $this->first();
    }

    // order by data from table by column name
    public function avg($column)
    {
        $tableData = $this->getData();

        $data = Arr::sort($tableData, function ($value, $key) use ($column) {
            return $value[$column] > $value[$column];
        });

        $this->setData($data);

        return $this->first();
    }

    // order by data from table by column name
    public function sum($column)
    {
        $tableData = $this->getData();

        //sum array
        $data = array_sum(array_column($tableData, $column));

        $this->setData([
            $column => $data
        ]);

        return $this->first();
    }
}
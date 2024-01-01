<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/1/2024
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Collection;
use Tusharkhan\FileDatabase\Core\Exception\MethodNotFoundException;

class Query
{

    protected $model;

    private $query;

    private $relations;

    private $tableData;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function filterDataFromModel()
    {
        $tablePath = $this->model->getTable();
        $this->tableData = collect(getTableData($tablePath));

        $allQuery = $this->model->getQuery();

        $allRelations = $this->model->getRelations();

        $allData = $this->tableData;

        $this->query = $allQuery;

        foreach ($allQuery as $query) {
            $methodName = $query[0];
            $arguments = $query[1];

            // check if method exists, if exists then call it with arguments and if not then throw exception
            if (method_exists(Collection::class, $methodName)) {
                $allData = $allData->$methodName(...$arguments);

            } else {
                throw new MethodNotFoundException($methodName, $this->model::class);
            }
        }

        $this->model->setData($allData);

        return $this->model->getData();
    }
}
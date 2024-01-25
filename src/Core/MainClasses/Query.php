<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/1/2024
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Collection;
use Tusharkhan\FileDatabase\Core\AbstractClasses\Eloquent;
use Tusharkhan\FileDatabase\Core\Exception\MethodNotFoundException;
use Tusharkhan\FileDatabase\Core\Exception\ModelNotFoundException;

class Query
{

    protected $model;

    private $with;

    private $tableData;

    private $currentRelationName;

    private $currentWithName;

    public function __construct(Eloquent $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function with(array | string $relation)
    {
        if ( is_array($relation) ) {
            $this->with = $relation;
        } else {
            $this->with = explode(',', str_replace(' ', '', $relation));
        }

        $this->model->setWith($this->with);

        return $this;
    }



    public function filterDataFromModel(): array|Collection
    {
        $tablePath = $this->model->getTable();
        $this->tableData = collect(getTableData($tablePath));

        $allQuery = $this->model->getQuery();

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

        $this->addRelationsData();

        return $this->model->getData();
    }

    public function addRelationsData()
    {
        $this->with = $this->model->getWith();

        if (count($this->with) > 0) {
            foreach ($this->with as $relation) {
                $this->addRelationData($relation);
            }
        }
    }

    private function addRelationData(mixed $relation)
    {
        // check if relation exists, if exists then call it with arguments and if not then throw exception
        if (!method_exists($this->model::class ,$relation)) {
            throw new MethodNotFoundException($relation, $this->model::class);
        }

        $this->currentWithName = $relation;
        $relationData = $this->model->$relation();

        $this->relations = $this->model->getRelations();

        $relationData = $this->getRelationData($relationData);

        $this->model->setData($relationData);
    }

    private function getRelationData(mixed $relation)
    {
        $relationModel = $this->getRelationModel($relation);

        $relationTable = $relationModel->getTable();

        $relationTableData = getTableData($relationTable);

        $relationTableData = collect($relationTableData);

        return $this->filterRelationData($relationTableData, $relationModel, $relation);
    }

    private function getRelationModel(mixed $relation)
    {
        $relationName = array_key_first($relation);

        $relationModel = $relation[$relationName]['related'];

        $this->currentRelationName = $relationName;

        // check if class exists, if exists then call it with arguments and if not then throw exception
        if (!class_exists($relationModel)) {
            throw new ModelNotFoundException($relationModel);
        }

        // return new instance of relation model
        return new $relationModel();
    }

    private function filterRelationData(Collection $relationTableData, mixed $relationModel, mixed $relation)
    {
        $foreignKey = $relation[$this->currentRelationName]['foreignKey'];
        $localKey = $relation[$this->currentRelationName]['localKey'];

        return $this->addRelationDataByKey($relationTableData,  $foreignKey, $localKey);
    }

    private function addRelationDataByKey(Collection $relationTableData,  $foreignKey, $localKey)
    {
        return $this->model->getData()->map(function ($item) use ($foreignKey, $relationTableData, $localKey) {
            switch ($this->currentRelationName) {
                case 'belongsTo':
                case 'hasOne':
                    $item[$this->currentWithName] = $relationTableData->where($localKey, $item[$foreignKey])->first();
                    break;
                case 'hasMany':
                    $item[$this->currentWithName] = $relationTableData->where($localKey, $item[$foreignKey])->values();
                    break;
                case 'belongsToMany':
                    $item[$this->currentWithName] = $relationTableData->whereIn($localKey, $item[$foreignKey])->values();
                    break;
            }

            return $item;
        });
    }

    public function where($column, mixed $operator, mixed $value)
    {
        $this->model->setQuery('where', [$column, $operator, $value]);

        return $this;
    }
}
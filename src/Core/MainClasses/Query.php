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
use Tusharkhan\FileDatabase\Core\Traits\QueryHelper;

class Query
{
    use QueryHelper;

    protected $model;

    private $with;

    private $tableData;

    private $currentRelationName;

    private $currentWithName;

    public function __construct(Eloquent $model)
    {
        $this->model = $model;
        $tableName = $model->getTable();
        $this->tableData = collect(getTableData($tableName));
        $this->model->setData($this->tableData);

        return $this;
    }


    public function getTableData()
    {
        return $this->tableData;
    }

    public function setTableData(Collection $tableData): void
    {
        $this->tableData = $tableData;
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

    /**
     * @throws MethodNotFoundException
     */
    public function get()
    {
        return $this->filterDataFromModel();
    }

    /**
     * @throws MethodNotFoundException
     */
    public function filterDataFromModel(): array|Collection
    {
        $this->addRelationsData();

        return $this->getTableData();
    }

    /**
     * @throws MethodNotFoundException
     */
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

        $relationData = $this->getRelationData($relationData);

        $this->setTableData($relationData);
    }

    private function getRelationData(mixed $relation)
    {
        $relationModel = $this->getRelationModel($relation);

        $relationTableData = $relationModel::all();

        return $this->filterRelationData($relationTableData, $relation);
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

    private function filterRelationData(Collection $relationTableData, mixed $relation)
    {
        $foreignKey = $relation[$this->currentRelationName]['foreignKey'];
        $localKey = $relation[$this->currentRelationName]['localKey'];

        return $this->addRelationDataByKey($relationTableData,  $foreignKey, $localKey);
    }

    private function addRelationDataByKey(Collection $relationTableData,  $foreignKey, $localKey)
    {
        return $this->getTableData()->values()->map(function ($item) use ($foreignKey, $relationTableData, $localKey) {
            switch ($this->currentRelationName) {
                case 'belongsTo':
                case 'hasOne':
                    $item[$this->currentWithName] = collect($relationTableData->where($localKey, $item[$foreignKey])->first());
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
}
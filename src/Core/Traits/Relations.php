<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/5/2024
 */


namespace Tusharkhan\FileDatabase\Core\Traits;

use Illuminate\Support\Arr;
use Tusharkhan\FileDatabase\Core\AbstractClasses\Eloquent;

trait Relations
{
    public function hasOne(string $related, $foreignKey = null, $localKey = null)
    {
        $relationData = [
            'hasOne' => [
                'related' => $related,
                'foreignKey' => $foreignKey ?? $this->getRelatedForeignKey($related),
                'localKey' => $localKey ?? $this->getRelatedPrimaryKey($related)
            ]
        ];
        $this->setRelations($relationData);

        return $relationData;
    }

    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $relationData = [
            'hasMany' => [
                'related' => $related,
                'foreignKey' => $foreignKey ?? $this->getRelatedForeignKey($related),
                'localKey' => $localKey ?? $this->getRelatedPrimaryKey($related)
            ]
        ];

        $this->setRelations($relationData);

        return $relationData;
    }

    public function belongsTo($related, $foreignKey = null, $localKey = null)
    {
        $relationData = [
            'belongsTo' => [
                'related' => $related,
                'foreignKey' => $foreignKey ?? $this->getRelatedForeignKey($related),
                'localKey' => $localKey ?? $this->getRelatedPrimaryKey($related)
            ]
        ];

        $this->setRelations($relationData);

        return $relationData;
    }

    public function belongsToMany($related, $foreignKey = null, $localKey = null)
    {
        $relationData = [
            'belongsToMany' => [
                'related' => $related,
                'foreignKey' => $foreignKey ?? $this->getRelatedForeignKey($related),
                'localKey' => $localKey ?? $this->getRelatedPrimaryKey($related)
            ]
        ];

        $this->setRelations($relationData);

        return $relationData;
    }

    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    public function getRelations()
    {
        return $this->relations;
    }

    private function classInstance($classNamespace)
    {
        return classInstance($classNamespace);
    }

    private function getRelatedPrimaryKey($classNamespace)
    {
        return $this->classInstance($classNamespace)->getPrimaryKey();
    }

    private function getRelatedTable($classNamespace)
    {
        return $this->classInstance($classNamespace)->getTable();
    }

    private function getRelatedForeignKey($classNamespace)
    {
        return $this->getRelatedTable($classNamespace). '_id';
    }
}
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
                'foreignKey' => $foreignKey,
                'localKey' => $localKey
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
                'foreignKey' => $foreignKey,
                'localKey' => $localKey
            ]
        ];

        $this->setRelations($relationData);

        return $relationData;
    }

    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
    {
        $relationData = [
            'belongsTo' => [
                'related' => $related,
                'foreignKey' => $foreignKey,
                'ownerKey' => $ownerKey,
                'relation' => $relation
            ]
        ];

        $this->setRelations($relationData);

        return $relationData;
    }

    public function belongsToMany($related, $table = null, $foreignKey = null, $relatedKey = null, $relation = null)
    {
        $relationData = [
            'belongsToMany' => [
                'related' => $related,
                'table' => $table,
                'foreignKey' => $foreignKey,
                'relatedKey' => $relatedKey,
                'relation' => $relation
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
}
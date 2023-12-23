<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/24/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

class Schema
{
    public $table;

    public $callback;

    /**
     * create
     *
     * @param  mixed $table
     * @param  mixed $callback
     * @return Schema
     */
    public static function create($table, $callback)
    {
        $schema = new self();
        $schema->table = $table;
        $schema->callback = $callback;
        return $schema;
    }

    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        $builder = new Builder();
        $builder->table = $this->table;
        $this->callback->__invoke($builder);
        $builder->createTable($builder);
    }
}
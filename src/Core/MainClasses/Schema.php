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
    public static function process($table, $callback)
    {
        $schema = new self();
        $schema->table = $table;
        $schema->callback = $callback;
        return $schema;
    }

    /**
     * run
     *
     * @return bool
     * @throws \Exception
     */
    public function run()
    {
        $builder = new Builder();
        $builder->table = $this->table;
        $this->callback->__invoke($builder);
        return $builder->createTable($builder);
    }

    /**
     * update
     *
     * @return bool
     * @throws \Exception
     */
    public function update()
    {
        $builder = new Builder();
        $builder->table = $this->table;
        $this->callback->__invoke($builder);
        return $builder->updateTable($builder);
    }

    /**
     * drop
     *
     * @return bool
     * @throws \Exception
     */
    public static function drop($tableName)
    {
        $builder = new Builder();
        return $builder->dropTable($tableName);
    }
}
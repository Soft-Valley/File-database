<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/24/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Tusharkhan\FileDatabase\Core\Exception\TableExistsException;
use Tusharkhan\FileDatabase\Core\Traits\BuilderHelper;

class Builder
{
    // TODO : add remove column method for update table

    use BuilderHelper;

    public $table;

    protected $columns = [];

    protected $removeColumns = [];

    /**
     * @param Builder $builder
     * @return bool
     * @throws TableExistsException
     */
    public function createTable(Builder $builder)
    {
        $table = $builder->getTableName();

        if (File::exists($this->getTablePath($table))) {
            throw new TableExistsException($table);
        }

        $columns = $builder->columns;
        $this->createDirectory();

        return $this->createTableAndSchema(
            $table,
            $this->schemaData($table, $columns)
        );
    }

    /**
     * @param $table
     * @param $json
     * @return bool
     */
    public function updateTable(Builder $builder)
    {
        $table = $builder->getTableName();

        $tableData = $this->getTableData($table);
        $schemaData = $this->getTableData($table, '_schema');

        $columnsUpdate = $builder->columns;
        // update schema
        $columns = array_replace($schemaData['columns'], $columnsUpdate);

        // check if any new fiels added
        $newColumns = array_diff_key($columns, $schemaData['columns']);

        // add new columns
        $this->addNewColumns($tableData, $newColumns);
        // remove selected columns
        $this->removeTableColumns($tableData);
        $this->removeSchemaColumns($columns);

        $schemaData['columns'] = $columns;

        return $this->updateTableAndSchema($table, $schemaData, $tableData);
    }

    /**
     * @param $table
     * @param $json
     * @return bool
     */
    public function dropTable($table){
        $tablePath = $this->getTablePath($table);
        $tableSchemaPath = $this->getTablePath($table, '_schema');

        if (File::exists($tablePath)) {
            File::delete($tablePath);
            File::delete($tableSchemaPath);
            return true;
        }
        return false;
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/26/2023
 */


namespace Tusharkhan\FileDatabase\Core\Traits;

use Illuminate\Support\Facades\Config;
use Tusharkhan\FileDatabase\Core\MainClasses\DataTypes;
use Tusharkhan\FileDatabase\Core\MainClasses\File;

trait BuilderHelper
{
    public function string($name, $length = 255)
    {
        $this->columns[$name] = [
            'type' => DataTypes::STRING,
            'length' => $length
        ];
        return $this;
    }

    public function char($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::CHAR,
            'length' => 1
        ];
        return $this;
    }

    public function varchar($name, $length = 255)
    {
        $this->columns[$name] = [
            'type' => DataTypes::VARCHAR,
            'length' => $length
        ];
        return $this;
    }

    public function text($name, $length = 4294967295)
    {
        $this->columns[$name] = [
            'type' => DataTypes::TEXT,
            'length' => $length
        ];
    }

    public function tinyInt($name, $length = 3)
    {
        $this->columns[$name] = [
            'type' => DataTypes::TINYINT,
            'length' => $length
        ];
    }

    public function smallInt($name, $length = 5)
    {
        $this->columns[$name] = [
            'type' => DataTypes::SMALLINT,
            'length' => $length
        ];
    }

    public function mediumInt($name, $length = 8)
    {
        $this->columns[$name] = [
            'type' => DataTypes::MEDIUMINT,
            'length' => $length
        ];
    }

    public function int($name, $length = 10)
    {
        $this->columns[$name] = [
            'type' => DataTypes::INT,
            'length' => $length
        ];
    }

    public function bigInt($name, $length = 20)
    {
        $this->columns[$name] = [
            'type' => DataTypes::BIGINT,
            'length' => $length
        ];
    }

    public function binary($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::BINARY,
            'length' => 1
        ];
    }

    public function float($name, $length = 10)
    {
        $this->columns[$name] = [
            'type' => DataTypes::FLOAT,
            'length' => $length
        ];
    }

    public function double($name, $length = 10)
    {
        $this->columns[$name] = [
            'type' => DataTypes::DOUBLE,
            'length' => $length
        ];
    }

    public function date($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::DATE,
            'length' => 10
        ];
    }

    public function dateTime($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::DATETIME,
            'length' => 19
        ];
    }

    public function timeStamp($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::TIMESTAMP,
            'length' => 19
        ];
    }

    public function time($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::TIME,
            'length' => 8
        ];
    }


    private function getTablePath($table, $suffix = '')
    {
        $directoryPath = Config::get('fileDatabase.database_directory', 'fileDatabase');
        $tablesPath = Config::get('fileDatabase.tables_directory', 'tables');
        return storage_path($directoryPath . '/' . $tablesPath . '/' . $table . $suffix . '.json');
    }


    private function createDirectory()
    {
        $directoryPath = Config::get('fileDatabase.database_directory', 'fileDatabase');
        $tablesPath = Config::get('fileDatabase.tables_directory', 'tables');

        File::createDirectory(storage_path($directoryPath));
        File::createDirectory(storage_path($directoryPath . '/' . $tablesPath));
    }

    private function createTableAndSchema($table, $json)
    {
        File::createFile($this->getTablePath($table), '');
        return File::createFile($this->getTablePath($table, '_schema'), $json);
    }

    public function getTableName()
    {
        return $this->table;
    }

    private function schemaData($table, $columns){
        $data = [];
        $data['columns'] = $columns;
        $data['primary_key'] = 'id';
        $data['auto_increment'] = 1;
        $data['table'] = $table;

        return json_encode($data, JSON_PRETTY_PRINT);
    }


    private function updateTableAndSchema($table, $schemaData, $tableData)
    {
        if( $tableData )File::set($this->getTablePath($table), json_encode($tableData, JSON_PRETTY_PRINT));
        File::set($this->getTablePath($table, '_schema'), json_encode($schemaData, JSON_PRETTY_PRINT));

        return true;
    }

    private function getTableData($table, $suffix = '')
    {
        $tablePath = $this->getTablePath($table, $suffix);
        if (File::exists($tablePath)) {
            return json_decode(File::get($tablePath), true);
        }
    }

    private function addNewColumns(mixed &$tableData, array $newColumns)
    {
        $newColumnAdd = [];

        foreach ($newColumns as $key => $value) {
            $newColumnAdd[$key] = null;
        }

        foreach ($tableData as $key => $value) {
            $tableData[$key] = array_merge($value, $newColumnAdd);
        }
    }
}
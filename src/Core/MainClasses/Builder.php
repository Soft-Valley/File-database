<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/24/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Facades\Config;

class Builder
{
    public $table;

    public $prefix;

    public $columns = [];

    public function prefix($prefix = '')
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function getTableName()
    {
        return $this->prefix . $this->table;
    }

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

    public function text($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::TEXT,
            'length' => 4294967295
        ];
    }

    public function tinyInt($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::TINYINT,
            'length' => 3
        ];
    }

    public function smallInt($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::SMALLINT,
            'length' => 5
        ];
    }

    public function mediumInt($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::MEDIUMINT,
            'length' => 8
        ];
    }

    public function int($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::INT,
            'length' => 10
        ];
    }

    public function bigInt($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::BIGINT,
            'length' => 20
        ];
    }

    public function binary($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::BINARY,
            'length' => 1
        ];
    }

    public function float($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::FLOAT,
            'length' => 10
        ];
    }

    public function double($name)
    {
        $this->columns[$name] = [
            'type' => DataTypes::DOUBLE,
            'length' => 10
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

    // create table
    public function createTable($builder)
    {
        $table = $builder->getTableName();
        $columns = $builder->columns;
        $path = $table . '.json';
        $data = [];
        $data['columns'] = $columns;
        $data['primary_key'] = 'id';
        $data['auto_increment'] = 1;
        $data['table'] = $table;

        $json = json_encode($data, JSON_PRETTY_PRINT);


        $directoryPath = Config::get('fileDatabase.database_directory', 'FileDatabase');
        $tablesPath = Config::get('fileDatabase.tables_directory', 'tables');

        File::createDirectory($directoryPath);
        File::createDirectory($directoryPath . '/' . $tablesPath);

        File::createFile($directoryPath . '/' . $tablesPath . '/' . $path);

        return File::set($directoryPath . '/' . $tablesPath . '/' . $path, $json);
    }
}
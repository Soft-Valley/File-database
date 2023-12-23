<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/24/2023
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

class Builder
{
    public $table;

    public $prefix;

    public $columns = [];

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
        $table = $builder->table;
        $columns = $builder->columns;
        $prefix = $builder->prefix;
        $path = $prefix . $table . '.json';
        $data = [];
        $data['columns'] = $columns;
        $data['primary_key'] = 'id';
        $data['auto_increment'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['deleted_at'] = null;
        $data['data'] = [];
        $data['indexes'] = [];
        $data['foreign_keys'] = [];
        $data['unique_keys'] = [];
        $data['engine'] = 'InnoDB';
        $data['charset'] = 'utf8mb4';
        $data['collation'] = 'utf8mb4_unicode_ci';
        $data['comment'] = null;
        $data['row_format'] = 'Dynamic';
        $data['table'] = $table;

        $json = json_encode($data, JSON_PRETTY_PRINT);
        dd($json);
        if (!file_exists($path)) {
            file_put_contents($path, $json);
        }
    }
}
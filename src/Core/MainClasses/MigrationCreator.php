<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Illuminate\Support\Str;
use Tusharkhan\FileDatabase\Core\Exception\TableExistsException;

class MigrationCreator
{
    private $name;
    private $options;
    private $table;

    public function __construct($name, $options)
    {
        $this->name = Str::studly($name);
        $this->options = $options;
    }

    public function run()
    {
        if ( $this->options['create'] ){
            return $this->create();
        } elseif ( $this->options['update'] ){
            return $this->update();
        } elseif ( $this->options['drop'] ){
            return $this->dropTable();
        }

        return false;
    }

    public function create()
    {
        return $this->processStub('create');
    }

    private function update()
    {
        return $this->processStub('update');
    }

    private function dropTable()
    {
        return $this->processStub('drop');
    }

    private function getStub(string $string)
    {
        return file_get_contents(__DIR__ . "/../Stubs/migration/{$string}.stub");
    }

    private function createFile(array|bool|string $stub)
    {
        $path = $this->getPath($this->name);
        if (file_exists($path)) {
            throw new TableExistsException($this->table);
        }

        try {
            File::createDirectory($this->migrationDirectory());
            File::createFile($path);
            File::set($path, $stub);

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function getPath(bool|array|string|null $name)
    {
        return $this->migrationDirectory() . '/' . date('Y_m_d_His') . '_' . Str::snake($name) . '.php';
    }

    private function migrationDirectory()
    {
        return migrationDirectory();
    }

    private function processStub($option)
    {
        // get stub data
        $stub = $this->getStub($option);
        $this->table = $this->options[$option];

        // replace stub data
        $stub = str_replace('{{table_name}}', $this->options[$option], $stub);
        $stub = str_replace('{{ClassName}}', $this->name, $stub);
        $stub = str_replace('{{Namespace}}', migrationNameSpace(), $stub);

        // create migration file
        return $this->createFile($stub);
    }
}
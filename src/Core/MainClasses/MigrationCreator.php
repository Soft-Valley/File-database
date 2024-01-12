<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */


namespace Tusharkhan\FileDatabase\Core\MainClasses;

use Tusharkhan\FileDatabase\Core\Exception\TableExistsException;

class MigrationCreator
{
    private $name;
    private $options;
    private $table;

    /**
     * @param array|bool|string|null $name
     * @param array|bool|string|null $options
     */
    public function __construct($name, $options)
    {
        $this->name = $name;
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
    }

    /**
     * @throws TableExistsException
     */
    public function create()
    {
        // get stub data
        $stub = $this->getStub('create');
        $this->table = $this->options['create'];

        // replace stub data
        $stub = str_replace('{{table_name}}', $this->options['create'], $stub);
        $stub = str_replace('{{ClassName}}', $this->name, $stub);
        $stub = str_replace('{{Namespace}}', $this->createNameSpace(), $stub);

        // create migration file
        return $this->createFile($stub);
    }

    private function update()
    {
        $migration = new Migration($this->name);
        $migration->update();
    }

    private function createTable()
    {
        $migration = new Migration($this->name);
        $migration->create();
    }

    private function dropTable()
    {
        $migration = new Migration($this->name);
        $migration->drop();
    }

    private function getStub(string $string)
    {
        return file_get_contents(__DIR__ . "/../Stubs/migration/{$string}.stub");
    }

    private function createNameSpace()
    {
        return 'App\\'.config('fileDatabase.root_directory').'\\'.config('fileDatabase.database_file_directory') . '\\'. config('fileDatabase.migrations_directory');
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
        return $this->migrationDirectory() . '/' . date('Y_m_d_His') . '_' . $name . '.php';
    }

    private function migrationDirectory()
    {
        return config('fileDatabase.root_directory') . '/' . config('fileDatabase.database_file_directory') . '/' . config('fileDatabase.migrations_directory');
    }
}
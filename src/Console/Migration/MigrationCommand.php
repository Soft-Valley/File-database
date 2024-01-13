<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */


namespace Tusharkhan\FileDatabase\Console\Migration;

use Illuminate\Console\Command;
use Tusharkhan\FileDatabase\Core\MainClasses\MigrationCreator;

class MigrationCommand extends Command
{
    protected $signature = 'fdb:migration {name : The name of the migration}
        {--update= : Updated table }
        {--create= : Create table}
        {--drop= : Drop table}';

    protected $description = 'Create update or drop table';

    public function handle()
    {
        $name = $this->argument('name');

        $migration = new MigrationCreator($name, $this->options());

        if ($migration->run())
            $this->info('Migration created successfully.');
        else
            $this->error('Migration not created.');
    }
}
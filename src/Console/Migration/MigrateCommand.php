<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/14/2024
 */


namespace Tusharkhan\FileDatabase\Console\Migration;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Tusharkhan\FileDatabase\Core\MainClasses\File;

class MigrateCommand extends Command
{
    protected $signature = 'fdb:migrate {--fresh : remove all table and up}';

    protected $description = 'Migrate all tables';

    public function handle()
    {
        if ($this->option('fresh')) {
            if ( File::deleteDirectory(tableDirectory()) ){
                $this->info('File Database | Remove all database json success!');
            } else {
                $this->error('File Database | Remove all database json failed!');
            }
        }

        $this->runAllMigrateUP();
    }

    private function runAllMigrateUP()
    {
        $count = 0;
        $fileSystem = new Filesystem();
        $listFileMigrate = $fileSystem->glob(migrationDirectory() . '/*.php');

        foreach ($listFileMigrate as $file) {
            $this->resolve($file);
            $count++;
        }

        if ($count == 0) {
            $this->info('File Database | Nothing to migrate');
        }
    }

    private function resolve(string $file)
    {
        $fileSystem = new Filesystem();
        $fileName = preg_replace(migrationFileDatePattern(), '', $file);
        $class = Str::studly(Str::replace(['.php'], '', basename($fileName)));
        $nameSpace = migrationNameSpace();
        $class = $nameSpace . '\\' . $class;

        $fileSystem->requireOnce($file);

        if (class_exists($class)) {
            $migration = new $class();
            $migration->up();
        }
    }
}
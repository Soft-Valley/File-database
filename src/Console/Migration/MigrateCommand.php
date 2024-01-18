<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/14/2024
 */


namespace Tusharkhan\FileDatabase\Console\Migration;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tusharkhan\FileDatabase\Core\MainClasses\File;

class MigrateCommand extends Command
{
    protected $signature = 'fdb:migrate {--fresh : remove all table and up} {--drop : Drop table}';

    protected $description = 'Migrate all tables';

    private $fileSystem;

    public function __construct()
    {
        parent::__construct();

        $this->fileSystem = new Filesystem();
    }

    public function handle()
    {
        if ($this->option('fresh') || $this->option('drop') ) {
            if ( $this->deleteAllFiles() ){
                $this->info('File Database | Remove all database json success!');
            } else {
                $this->error('File Database | Remove all database json failed!');
            }
        }

        if (!$this->option('drop')) {
            $this->runAllMigrateUP();
        }
    }

    private function deleteAllFiles()
    {
        if ( ! $this->fileSystem->exists(tableDirectory()) ){
            File::createDirectory(tableDirectory());
        }

        foreach ($this->fileSystem->allFiles(tableDirectory()) as $index => $item) {
            File::delete($item->getPathname());
        }

        return true;
    }

    private function runAllMigrateUP()
    {
        $count = 0;
        $listFileMigrate = $this->fileSystem->glob(migrationDirectory() . '/*.php');

        foreach ($listFileMigrate as $file) {
            $this->resolve($file);
            $count++;
        }

        if ($count == 0) {
            $this->info('File Database | Nothing to migrate');
        }

        $this->info('File Database | total '.$count.' Migrated successfully!');
    }

    private function resolve(string $file)
    {
        $fileName = preg_replace(migrationFileDatePattern(), '', $file);
        $class = Str::studly(Str::replace(['.php'], '', basename($fileName)));
        $nameSpace = migrationNameSpace();
        $class = $nameSpace . '\\' . $class;

        if ( $this->checkIfMigrated($class, $file) ){
            $this->fileSystem->requireOnce($file);

            if (class_exists($class)) {
                $migration = new $class();
                $migration->up();
            }
        }
    }

    private function checkIfMigrated(string $class, string $file)
    {
        $path = tableDirectory() . '/migrations.json';

        if ( ! File::exists($path) ){
            File::createFile($path);
            File::set($path, json_encode([$this->createInsertData($class, $file)]));

            return true;
        } else {
            $migrations = File::get($path);
            $migrations = json_decode($migrations, true);

            if ( $migrations ){
                $res =  Arr::where($migrations, function ($value, $key) use ($class, $file) {
                    return $value['class'] == $class && $value['file'] == $file;
                });

                if ( count($res) == 0 ){
                    $migrations[] = $this->createInsertData($class, $file);
                    File::set($path, json_encode($migrations));

                    return true;
                } else {
                    return false;
                }
            } else {
                File::set($path, json_encode([$this->createInsertData($class, $file)]));

                return true;
            }
        }
    }

    private function createInsertData(string $class, string $file)
    {
        return [
            'class' => $class,
            'file' => $file,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
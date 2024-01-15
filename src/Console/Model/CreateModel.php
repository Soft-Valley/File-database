<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/15/2024
 */


namespace Tusharkhan\FileDatabase\Console\Model;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Tusharkhan\FileDatabase\Core\MainClasses\File;

class CreateModel extends Command
{
    protected $signature = 'fdb:model {name} {--m : Create migration}';

    protected $description = 'Create a new model class';

    private $errors = [];

    private $info = [];

    public function handle()
    {
        $this->createModel();

        if ( ! empty($this->errors) ){
            foreach ($this->errors as $error){
                $this->error($error);
            }
        }

        if ( ! empty($this->info) ){
            foreach ($this->info as $info){
                $this->info($info);
            }
        }
    }

    private function createModel()
    {
        $name = $this->argument('name');
        $migration = $this->option('m');

        $stub = $this->getStub();

        $stub = str_replace('{{model}}', Str::studly($name), $stub);
        $stub = str_replace("{{namespace}}", modelNamespace(), $stub);
        $this->createFile($stub);

        if ( empty($this->errors) ){
            if ( $migration ){
                $this->call('fdb:migration', [
                    'name' => Str::studly($name),
                    '--create' => Str::snake(Str::plural($name))
                ]);
            }
        }
    }

    private function getStub()
    {
        return file_get_contents(__DIR__ . "/../../Core/stubs/model/model.stub");
    }

    private function createFile(array|string $stub)
    {
        $name = $this->argument('name');

        $directory = modelDirectory();
        $fileName = Str::studly($name) . '.php';

        File::createDirectory(modelDirectory());

        if (File::exists($directory . '/' . $fileName)) {
            $this->errors[] = "Model {$name} already exists.";
        } else {
            File::createFile($directory . '/' . $fileName, $stub);
            $this->info[] = "Model {$name} created successfully.";
        }
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */


namespace Tusharkhan\FileDatabase\Core\Helpers;

use Illuminate\Foundation\Console\AboutCommand;
use Tusharkhan\FileDatabase\Console\Migration\MigrateCommand;
use Tusharkhan\FileDatabase\Console\Migration\MigrationFileCreateCommand;
use Tusharkhan\FileDatabase\Console\Model\CreateModel;

trait ServiceProviderHelper
{

    private function bootAboutCommand()
    {
        AboutCommand::add('FileDatabase', fn() => [
            'version' => '1.0.0',
            'php' => PHP_VERSION,
            'laravel' => app()->version(),
            'sapi' => php_sapi_name(),
            'os' => PHP_OS,
        ]);
    }

    private function bootCommands()
    {
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrationFileCreateCommand::class,
                MigrateCommand::class,
                CreateModel::class
            ]);
        }
    }

    private function bootHelper()
    {
         require_once __DIR__ . '/functions.php';
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */


namespace Tusharkhan\FileDatabase\Core\Helpers;

use Illuminate\Foundation\Console\AboutCommand;
use Tusharkhan\FileDatabase\Console\Migration\MigrationCommand;

trait ServiceProviderHelper
{
    private function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../../config/fileDatabase.php', 'fileDatabase');
    }

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

    private function bootConfig()
    {
        // check if config file exists
        if (!file_exists(config_path('fileDatabase.php')) && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/fileDatabase.php' => config_path('fileDatabase.php'),
            ], 'config');
        }
    }

    private function bootCommands()
    {
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                MigrationCommand::class,
            ]);
        }
    }
}
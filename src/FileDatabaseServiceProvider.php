<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase;

use Illuminate\Support\ServiceProvider;

class FileDatabaseServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fileDatabase.php', 'fileDatabase');
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
}
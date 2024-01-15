<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase;

use Illuminate\Support\ServiceProvider;
use Tusharkhan\FileDatabase\Core\Helpers\ServiceProviderHelper;

class FileDatabaseServiceProvider extends ServiceProvider
{
    use ServiceProviderHelper;

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/fileDatabase.php', 'fileDatabase');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/fileDatabase.php' => config_path('fileDatabase.php'),
            ], 'fdb-config');
        }

        $this->bootAboutCommand();
        $this->bootCommands();
        $this->bootHelper();
    }
}
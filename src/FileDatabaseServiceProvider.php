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
        $this->registerConfig();
    }

    public function boot()
    {
        $this->bootConfig();
        $this->bootAboutCommand();
        $this->bootCommands();
    }
}
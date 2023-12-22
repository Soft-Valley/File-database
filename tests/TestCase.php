<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */

namespace TusharKhan\FileDatabase\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Tusharkhan\FileDatabase\FileDatabaseServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'FileDatabase' => 'Tusharkhan\FileDatabase\Facade\FileDatabase',
        ];
    }
}
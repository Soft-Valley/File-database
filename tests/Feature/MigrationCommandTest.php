<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */

namespace TusharKhan\FileDatabase\Tests\Feature;

class MigrationCommandTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
    public function test_migration_create_command()
    {
        $this->artisan('fdb:migration', [
            'name' => 'User',
            '--create' => 'users',
        ])->assertExitCode(0);
    }


    public function test_migration_update_command()
    {
        $this->artisan('fdb:migration', [
            'name' => 'TestTableUpdate',
            '--update' => 'test_table',
        ])->assertExitCode(0);
    }

    public function test_migration_drop()
    {
        $this->artisan('fdb:migration', [
            'name' => 'TestTableDrop',
            '--drop' => 'test_table',
        ])->assertExitCode(0);
    }

    public function test_run_migrate_command()
    {
        $this->artisan('fdb:migrate')->assertExitCode(0);
    }

    public function test_run_migrate_fresh()
    {
        $this->artisan('fdb:migrate --fresh')->assertExitCode(0);
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */


class MigrationCommandTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
    public function test_migration_command()
    {
        // create
        $this->artisan('fdb:migration', [
            'name' => 'TestTable',
            '--create' => 'test_table',
        ])->assertExitCode(0);

        // update
        $this->artisan('fdb:migration', [
            'name' => 'TestTableUpdate',
            '--update' => 'test_table',
        ])->assertExitCode(0);

        // drop
        $this->artisan('fdb:migration', [
            'name' => 'TestTableDrop',
            '--drop' => 'test_table',
        ])->assertExitCode(0);
    }
}
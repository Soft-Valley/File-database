<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/15/2024
 */

namespace TusharKhan\FileDatabase\Tests\Feature;

class ModelCommandTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
    public function test_create_model_command()
    {
        $this->artisan('fdb:model', ['name' => 'User'])->assertExitCode(0);
    }

    public function test_create_model_with_migration()
    {
        $this->artisan('fdb:model', ['name' => 'Email', '--m' => true])->assertExitCode(0);
    }
}
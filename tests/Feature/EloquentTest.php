<?php

namespace TusharKhan\FileDatabase\Tests\Feature;

/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */


class EloquentTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
    public function test_eloquent_method()
    {
        $testModel = new TestModel();
        $testModel->name = 'tushar';
        $testModel->char = 't';
        $testModel->varchar = 'tushar';
        $testModel->text = 'tushar';
        $testModel->tinyInt = 11;


        $this->assertIsArray($testModel->save());
    }

    public function test_delete_record()
    {
        $testModel = new TestModel();

        $this->assertTrue($testModel->delete(1));
    }

    public function test_update_record()
    {
        $testModel = new TestModel();

        $this->assertTrue($testModel->update(3, [
            'name' => 'tushar 2',
            'char' => 'f',
            'varchar' => 'tushar',
            'text' => 'tushar',
            'tinyInt' => 11
        ]));
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace TusharKhan\FileDatabase\Tests\Feature;

use Tusharkhan\FileDatabase\Core\Exception\TableNotExistsException;
use Tusharkhan\FileDatabase\Core\MainClasses\Builder;
use Tusharkhan\FileDatabase\Core\MainClasses\Schema;
use Tusharkhan\FileDatabase\Models\TestModel;
use TusharKhan\FileDatabase\Tests\TestCase;

class FeatureTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_schema_create()
    {
        $dd = Schema::process('test_models', function (Builder $table) {
            $table->string('name');
            $table->char('char');
            $table->varchar('varchar');
            $table->text('text');
            $table->tinyInt('tinyInt');
            $table->primary('test_models_id');
        })->run();

        $this->assertTrue($dd);
    }

    public function test_schema_create_with_exception()
    {
        $this->expectException(TableNotExistsException::class);
        $this->expectExceptionMessage('Table test_table already exists');

        $dd = Schema::process('test_table', function (Builder $table) {
            $table->string('name');
            $table->char('char');
            $table->varchar('varchar');
            $table->text('text');
            $table->tinyInt('tinyInt');
        })->run();

        $this->assertTrue($dd);
    }

    /**
     * @throws \Exception
     */
    public function test_update_table()
    {
        $dd = Schema::process('test_table', function (Builder $table) {
            $table->date('date_new');
            $table->dateTime('date_time_new');
            $table->string('name');
            $table->remove('description');
        })->update();

        $this->assertTrue($dd);
    }


    public function test_drop_table()
    {
        $dd = Schema::drop('test_models');

        $this->assertTrue($dd);
    }

    /**
     * @throws \Exception
     */
    public function test_drop_table_with_exception()
    {
        $this->expectException(TableNotExistsException::class);
        $this->expectExceptionMessage('Table gg_table not exists');

        $dd = Schema::drop('gg_table');

        $this->assertTrue($dd);
    }

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

    public function test_call_query_methods()
    {
        $testModelQuery = TestModel::where('name', 'tushar 2')
            ->where('name', 'tushar 3')
            ->get();
        dd($testModelQuery);
    }
}
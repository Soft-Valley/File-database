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
use TusharKhan\FileDatabase\Tests\TestCase;

class FeatureTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_schema_create()
    {
        $dd = Schema::process('test_table', function (Builder $table) {
            $table->string('name');
            $table->char('char');
            $table->varchar('varchar');
            $table->text('text');
            $table->tinyInt('tinyInt');
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
        $dd = Schema::drop('test_table');

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
}
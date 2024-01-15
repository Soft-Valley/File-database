<?php

namespace TusharKhan\FileDatabase\Tests\Feature;

/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */

use Tusharkhan\FileDatabase\Core\MainClasses\Builder;
use Tusharkhan\FileDatabase\Core\MainClasses\Schema;

class SchemaTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
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
}
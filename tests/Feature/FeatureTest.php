<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace TusharKhan\FileDatabase\Tests\Feature;

use Tusharkhan\FileDatabase\Core\MainClasses\Builder;
use Tusharkhan\FileDatabase\Core\MainClasses\Schema;
use TusharKhan\FileDatabase\Tests\TestCase;

class FeatureTest extends TestCase
{
    public function test_schema()
    {
        $dd = Schema::create('mangoes', function (Builder $table) {
            $table->string('name');
            $table->char('char');
            $table->varchar('varchar');
            $table->text('text');
            $table->tinyInt('tinyInt');
        })->run();

        $this->assertTrue($dd);
    }
}
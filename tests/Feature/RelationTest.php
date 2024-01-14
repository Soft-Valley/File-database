<?php
namespace TusharKhan\FileDatabase\Tests\Feature;

/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */

use Illuminate\Support\Collection;

class RelationTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
    public function test_hasOne_method()
    {
        $testModelQuery = TestModel::with('page')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery);

        $page = $testModelQuery->first()['page'];

        $this->assertIsArray($page);
    }

    public function test_hasMany_method()
    {
        $testModelQuery = TestModel::with('pages')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery);

        $this->assertInstanceOf(Collection::class, $testModelQuery->first()['pages']);
    }

    public function test_belongs_to_method()
    {
        $testModelQuery = TestModel::with('belongsToPage')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery);

        $this->assertIsArray($testModelQuery->first()['belongsToPage']);
    }

    public function test_belongs_to_many_method()
    {
        $testModelQuery = TestModel::with('belongsToManyPages')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery);

        $this->assertInstanceOf(Collection::class, $testModelQuery->first()['belongsToManyPages']);
    }
}
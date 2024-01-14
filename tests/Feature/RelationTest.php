<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */

namespace TusharKhan\FileDatabase\Tests\Feature;

use App\FileDatabase\Models\User;
use App\FileDatabase\Models\Email;
use Illuminate\Support\Collection;

class RelationTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
    public function test_hasOne_method()
    {
        $testModelQuery = User::with('email')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery);

        $page = $testModelQuery->first()['email'];

        $this->assertIsArray($page);
    }

    public function test_hasMany_method()
    {
        $testModelQuery = User::with('emails')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery[0]['emails']);
    }

    public function test_belongs_to_method()
    {
        $testModelQuery = Email::with('user')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery);

        $this->assertIsArray($testModelQuery->first()['user']);
    }

    public function test_belongs_to_many_method()
    {
        $testModelQuery = Email::with('users')->get();

        $this->assertInstanceOf(Collection::class, $testModelQuery);

        $this->assertInstanceOf(Collection::class, $testModelQuery->first()['users']);
    }
}
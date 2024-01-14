<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/13/2024
 */

namespace TusharKhan\FileDatabase\Tests\Feature;

use App\FileDatabase\Models\Email;
use App\FileDatabase\Models\User;

class EloquentTest extends \TusharKhan\FileDatabase\Tests\TestCase
{
    public function test_eloquent_method()
    {
        $testModel = new User();
        $testModel->name = 'tushar 2';
        $testModel->phone = '014355454';
        $testModel->age = 12;
        $testModel->gender = 1;

        $this->assertIsArray($testModel->save());
    }

    public function test_delete_record()
    {
        $testModel = new User();

        $this->assertTrue($testModel->delete(2));
    }

    public function test_update_record()
    {
        $testModel = new User();

        $this->assertTrue($testModel->update(3, [
            'name' => 'tushar 4',
        ]));
    }

    public function test_create_email_data()
    {
        $email = new Email();

        $this->assertIsArray($email->create([
            'user_id' => 1,
            'email' => 'test2@email.com'
        ]));
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace TusharKhan\FileDatabase\Tests\Unit;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Tusharkhan\FileDatabase\Core\MainClasses\DataTypes;
use Tusharkhan\FileDatabase\Core\MainClasses\File;
use Tusharkhan\FileDatabase\Models\TestModel;
use TusharKhan\FileDatabase\Tests\TestCase;

class UnitTest extends TestCase
{
    public function test_is_binary()
    {
        $this->assertEquals('binary', isBinary("\xF5\x80\x80\x80"));
    }

    public function test_is_date_data()
    {
        $this->assertTrue( isDate('2020-12-12'));
        $this->assertTrue( isDate('12-12-2020'));
        $this->assertTrue( isDate('12/12/2020'));
        $this->assertTrue( isDate('12-12-2020 12:12:12'));
        $this->assertTrue( isDate('12:12:12'));
    }

    public function test_create_directory()
    {
        $this->assertTrue( File::createDirectory(storage_path('fileDatabase/tables')) );
    }

    public function test_create_file()
    {
        $path = storage_path('fileDatabase/tables/test.json');

        File::createFile($path);

        $jsonData = json_encode([
            'name' => 'tushar',
            'age' => 23
        ], JSON_PRETTY_PRINT);

        File::set($path, $jsonData);

        $data  = File::get($path);

        $this->assertEquals($jsonData, $data);
    }

    public function test_array_depth_function()
    {
        $array = [
            'name' => 'tushar',
            'age' => 23,
            'address' => [
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'post_code' => [
                    'code' => 1207,
                    'area' => 'Mohammadpur',
                    'house' => [
                        'house_no' => '12',
                        'house_name' => 'Tushar Villa'
                    ]
                ]
            ]
        ];

        $this->assertEquals(4, arrayDepth($array));
    }

    public function test_anything()
    {
        $arr = [
            [
                "name" => "tus",
                "age" => 12,
                "id" => 1
            ],
            [
                "name" => "tus 2",
                "age" => 12,
                "id" => 2
            ],
            [
                "name" => "tus 3",
                "age" => 12,
                "id" => 3
            ],
            [
                "name" => "tus 4",
                "age" => 12,
                "id" => 4
            ],
            [
                "name" => "tus 5",
                "age" => 12,
                "id" => 5
            ],
            [
                "name" => "tus 6",
                "age" => 12,
                "id" => 6
            ],
            [
                "name" => "tus 7",
                "age" => 12,
                "id" => 7
            ],
            [
                "name" => "tus 8",
                "age" => 12,
                "id" => 8
            ],
            [
                "name" => "tus 9",
                "age" => 12,
                "id" => 9
            ],
            [
                "name" => "tus 10",
                "age" => 12,
                "id" => 10
            ],
            [
                "name" => "tus 11",
                "age" => 12,
                "id" => 11
            ],
            [
                "name" => "tus 12",
                "age" => 12,
                "id" => 12
            ],
            [
                "name" => "tus 13",
                "age" => 12,
                "id" => 13
            ],
            [
                "name" => "tus 14",
                "age" => 12,
                "id" => 14
            ],
            [
                "name" => "tus 15",
                "age" => 12,
                "id" => 15
            ],
            [
                "name" => "tus 16",
                "age" => 12,
                "id" => 16
            ],
            [
                "name" => "tus 17",
                "age" => 12,
                "id" => 17
            ],
            [
                "name" => "tus 18",
                "age" => 12,
                "id" => 18
            ]
        ];

        $data = Arr::where($arr, function ($value, $key) {
            return $value['id'] == 10;
        });

        dd(array_values($data));
    }
}
<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace TusharKhan\FileDatabase\Tests\Unit;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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
        $insertData = [
            [
                'belongsToMany' => [
                    'related' => 'related',
                    'table' => '$table',
                    'foreignKey' => '$foreignKey',
                    'relatedKey' => '$relatedKey',
                    'relation' => '$relation'
                ]
            ],
//            [
//                "char" => "t",
//                "varchar" => "tushar",
//                "name" => "tushar 3",
//                "text" => "tushar",
//            ],
//            [
//                "char" => "t",
//                "varchar" => "tushar",
//                "name" => "tushar 2",
//                "text" => "tushar",
//            ]
        ];

//        $insertData = [
//            "char" => "t",
//            "varchar" => "tushar",
//            "name" => "tushar",
//            "text" => "tushar",
//        ];

        $insertData = Collection::wrap([
            [
                "char" , "t",
                "varchar" , "tushar"
            ]
        ]);

//        $insertData = $insertData->where('name', 'tushar 2')->where('name', 'tushar 3');

        dd(getTableData('pages'));
    }
}
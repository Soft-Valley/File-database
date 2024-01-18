<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/29/2023
 */


namespace Tusharkhan\FileDatabase\Core\Interfaces;

interface Eloquent
{
    public static function create($data);

    public static function delete($id);

    public static function update($id, $data);

    public function save();
}
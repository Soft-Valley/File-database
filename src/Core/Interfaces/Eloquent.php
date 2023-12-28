<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/29/2023
 */


namespace Tusharkhan\FileDatabase\Core\Interfaces;

interface Eloquent
{
    public function create($data);

    public function delete($id);

    public function update($id, $data);

    public function save();
}
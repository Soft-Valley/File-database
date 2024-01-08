<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/27/2023
 */


namespace Tusharkhan\FileDatabase\Models;

use Tusharkhan\FileDatabase\Core\MainClasses\MainModel;

class TestModel extends MainModel
{
    protected $primaryKey = 'test_models_id';

    protected $fillable = ['*'];

    public function page()
    {
        return $this->hasOne(Pages::class, 'test_models_id', 'test_models_id');
    }

    public function pages()
    {
        return $this->hasMany(Pages::class, 'test_models_id', 'test_models_id');
    }
}
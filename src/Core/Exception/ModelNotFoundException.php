<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 1/7/2024
 */


namespace Tusharkhan\FileDatabase\Core\Exception;

class ModelNotFoundException extends \Exception
{
    public function __construct($model, $code = 0, \Throwable $previous = null)
    {
        parent::__construct("Model $model not found. Please check the model path and Name.", $code, $previous);
    }
}
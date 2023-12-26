<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


if( ! function_exists('isBinary') ){
    function isBinary($data) {
        return ! mb_check_encoding($data, 'UTF-8');
    }
}


if( ! function_exists('isDate')){
    function isDate($data){
        return (bool) strtotime($data);
    }
}

if( ! function_exists('arrayDepth')) {
    function arrayDepth($array)
    {
        if (empty($array) || !is_array($array)) {
            return 0;
        }

        return max(\Illuminate\Support\Arr::map($array, 'arrayDepth')) + 1;
    }
}
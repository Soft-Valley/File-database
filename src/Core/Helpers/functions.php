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
    function arrayDepth(array $array)
    {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = arrayDepth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }
}
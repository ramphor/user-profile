<?php
if (!function_exists('array_get')) {
    function array_get($array, $key, $defaultValue = false)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }
        return $defaultValue;
    }
}

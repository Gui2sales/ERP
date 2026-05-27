<?php

namespace App\Utils;

class Utils
{
    public static function recursivelyReplaceArrayValues($array, $search, $replace)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = self::recursivelyReplaceArrayValues($value, $search, $replace);
            } else if (is_string($value)) {
                $array[$key] = str_replace($search, $replace, $value);
            }
        }
        return $array;
    }

    public static function removeExtraSpaces(string $input): string
    {
        return preg_replace('/\s+/', ' ', trim($input));
    }
}

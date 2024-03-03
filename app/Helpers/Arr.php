<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Arr as LaravelArr;

class Arr extends LaravelArr
{
    public static function arrayFilterValues(array $array, array $needValue): array
    {
        $resultArray = [];

        foreach ($needValue as $key) {
            if (array_key_exists($key, $array)) {
                $resultArray[$key] = $array[$key];
            }
        }

        return $resultArray;
    }
}

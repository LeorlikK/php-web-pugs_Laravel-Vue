<?php

namespace App\Service;

class MediaSizeService
{
    public static function translate(int $size):string
    {
        $unit = 'KB';
        if ($size == 0) {
            return $size.$unit;
        }
        if ($size > 1048576 && $size < 1073741824){
            $round = round($size/1048576, 1);
            $unit = 'Mb';
            return $round.$unit;
        }
        if ($size > 1073741824){
            $round = round($size/1073741824, 1);
            $unit = 'Gb';
            return $round.$unit;
        }

        return $size.$unit;
    }
}

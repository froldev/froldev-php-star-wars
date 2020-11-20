<?php

namespace App\Service;

/**
 *  class Yodalizer
 */
class Yodalizer
{

    public static function yodalizeIt(string $str):string
    {
        $explodeSentence = explode(" ", $str);
        $reverseArray = array_reverse($explodeSentence);
        $reverseSentence = implode(" ", $reverseArray);
        return ucfirst($reverseSentence);
    }
}

<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Mengubah string menjadi kapital di setiap awal kata
     *
     * @param string $string
     * @return string
     */
    public static function titleCase($string)
    {
        return ucwords(strtolower($string));
    }
}
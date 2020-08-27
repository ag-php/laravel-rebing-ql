<?php

declare(strict_types=1);

namespace App\Base\Util;

class StringBetween
{
    /**
     * Undocumented function.
     *
     * @param string $string to find
     * @param string $start  where it start
     * @param string $end    where it ends
     *
     * @return string
     */
    public static function find(string $string, string $start, string $end): string
    {
        $string = ' '.$string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }

        $ini += strlen($start);
        $len = (strpos($string, $end, $ini) - $ini);

        return substr($string, $ini, $len);
    }
}

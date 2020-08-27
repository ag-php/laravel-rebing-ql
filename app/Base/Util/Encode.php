<?php

declare(strict_types=1);

namespace App\Base\Util;

class Encode
{
    /**
     * To encode convert an array, to a json, and encode it.
     *
     * @param array $array any array data
     *
     * @return string
     */
    public static function jsonEncode(array $array) : string
    {
        $json = json_encode($array);

        return self::base64UrlEncode($json);
    }

    /**
     * Return a base 64 encode, replacing the values + by - and / by _
     * Also, the removed the = value in the end.
     *
     * @param string $value to encode
     *
     * @return string
     */
    public static function base64UrlEncode(string $value) : string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    /**
     * Decode base 64 from Url.
     *
     * @param string $value to decode
     *
     * @return string
     */
    public static function base64UrlDecode(string $value): string
    {
        return base64_decode(
            strtr($value, '-_', '+/').str_repeat('=', (3 - (3 + strlen($value)) % 4))
        );
    }
}

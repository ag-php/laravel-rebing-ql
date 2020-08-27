<?php

declare(strict_types=1);

namespace App\Base\Globals;

use App\Base\Model\Lang\Lang as LangModel;

class Langs
{
    public static function getDefault() : string
    {
        if (\Auth::User()) {
            return \Auth::User()->lang_id;
        }

        $browserLang = self::getBrowserLanguage();

        return self::getLang($browserLang);
    }

    public static function getLang(string $lang_id) : string
    {
        $lang = LangModel::find(strtoupper($lang_id));
        if ($lang) {
            return $lang->lang_id;
        }

        return 'EN';
    }

    public static function getBrowserLanguage() : string
    {
        if (! array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)) {
            return 'EN';
        }

        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        $acceptLang = [
            'en',
            'es',
        ];

        $lang = in_array($lang, $acceptLang) ? $lang : 'EN';

        return strtoupper($lang);
    }
}

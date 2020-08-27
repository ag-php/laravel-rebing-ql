<?php

declare(strict_types=1);
/**
 * To create a translation
 * php version 7.2.10.
 *
 * @category Logic
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */

namespace App\Base\Logic\Translation;

use App\Base\Globals\Langs;
use App\Base\Logic\OptionalParams\TranslationCodeParam;
use App\Base\Model\Lang\Text;
use App\Base\Model\Lang\Translation;
use Illuminate\Support\Facades\DB;

/**
 * To create a translation
 * php version 7.2.10.
 *
 * @category Logic
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */
class TranslationCreate
{
    /**
     * Create a new translation with texts.
     *
     * array  $texts array [text, lang_id]
     * string $code  unique code for the translation
     * array  $optionals : is_blocked | code
     *
     * @return Translation object
     */
    public static function create(array $texts, array $optionals = [], $defaultLang = null): Translation
    {
        $defaultLang = $defaultLang ? $defaultLang : Langs::getDefault();
        try {
            DB::beginTransaction();
            $translation = Translation::create([
                'code' => uniqid(),
            ])->fresh();

            $trans = [];
            foreach ($texts as $text) {
                $Text = Text::firstOrNew([
                    'lang_id' => $text['lang_id'],
                    'translation_id' => $translation->translation_id,
                ]);
                $Text->text = $text['text'];
                $Text->save();
                $trans[] = $Text;
            }

            // Get the code from optionals or
            // Update the uniqid() by the first word + translation_id
            $codeParam = new TranslationCodeParam($optionals, $translation, $defaultLang);
            $code = $codeParam->getValue($texts);

            $translation->code = $code;
            if (isset($optionals['is_blocked'])) {
                $translation->is_blocked = $optionals['is_blocked'];
            }
            $translation->save();

            DB::commit();

            return $translation;
        } catch (\Exception $error) {
            DB::rollback();
            throw $error;
        }//end try
    }

    /**
     * Undocumented function.
     *
     * @param string $text Undocumented
     *
     * @return Translation
     */
    public static function createEN(string $text) : Translation
    {
        return self::createByLang('EN', $text);
    }

    //end createEN()

    /**
     * Undocumented function.
     *
     * @param string $lang_id Undocumented
     * @param string $text   Undocumented
     *
     * @return Translation
     */
    public static function createByLang(string $lang_id, string $text) : Translation
    {
        return self::create(
            [[
                'lang_id' => $lang_id,
                'text'   => $text,
            ]]
        );
    }

    //end createByLang()

    /**
     * Return the first translation found or create it in the DB if it does not exist.
     *
     * @param string $text   text of the new translation to create or find
     * @param string $lang_id lang of the current text
     *
     * @return Translation
     */
    public static function firstOrCreate(string $text, string $lang_id) : Translation
    {
        $translation_id = self::isLangText($text, $lang_id);

        return ($translation_id > 0) ?
            Translation::find($translation_id) :
            self::createByLang($lang_id, $text);
    }

    //end firstOrCreate()

    public static function isLangText(string $text, string $lang_id)
    {
        $query = Text::whereRaw(
            'lang.unaccent(lang.text.text) ilike lang.unaccent(?)',
            [$text]
        )->where('lang.text.lang_id', $lang_id);
        $textModel = $query->first();

        return $textModel ? $textModel->translation_id : 0;
    }
}//end class

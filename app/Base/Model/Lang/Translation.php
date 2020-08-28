<?php

declare(strict_types=1);

/**
 * Undocumented class
 * php version 7.2.10.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */

namespace App\Base\Model\Lang;

use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Undocumented class.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     https://albertcito.com
 */
class Translation extends BaseModel
{
    protected $table = 'lang.translation';

    protected $primaryKey = 'translation_id';

    protected $fillable = [
        'code',
        'created_by',
        'is_blocked',
    ];

    /**
     * Undocumented function.
     *
     * @param array $lang_id Undocumented
     *
     * @return void
     */
    public function texts($lang_id = [], bool $active = null)
    {
        $query = VText::where('vtext.translation_id', $this->translation_id);
        if (count($lang_id)) {
            $query->whereIn('vtext.lang_id', $lang_id);
        }
        if ($active !== null) {
            $query->where('vtext.active', $active);
        }

        return $query;
    }

    //end texts()

    /**
     * Return the translation in a language selected,
     * or in other language if that does not exist.
     *
     * @param string $lang_id the language id form the lang.lang table
     *
     * @return Translation
     */
    public function text(string $lang_id) : VText
    {
        $query = $this->texts([$lang_id]);
        $text = $query->first();

        return $text;
    }

    /**
     * To return an array like:  ['EN': 'hello', 'ES': 'Hola'].
     *
     * @param array $translationsID translation to return
     * @param array $langID         it's optional. Empty means all the languages.
     *
     * @return array
     */
    public static function textsByID(array $translationsID, array $langID = [], bool $active = null)
    {
        $query = VText::whereIn('vtext.translation_id', $translationsID);
        if (count($langID)) {
            $query->whereIn('vtext.lang_id', $langID);
        }
        if ($active !== null) {
            $query->where('vtext.active', $active);
        }

        return $query;
    }

    /**
     * To return an array like:  ['EN': 'hello', 'ES': 'Hola'].
     *
     * @param array $translationsID translation to return
     * @param array $langID         it's optional. Empty means all the languages.
     *
     * @return array
     */
    public static function dictionary(array $translationsID, $translations)
    {
        $dictionary = [];
        foreach ($translationsID as $translationID) {
            $dictionary[$translationID] = [];
            foreach ($translations as $translation) {
                if ($translation->translation_id === $translationID) {
                    $langID = $translation->lang_id;
                    $dictionary[$translationID][$langID] = $translation->text;
                }
            }
        }

        return $dictionary;
    }
}

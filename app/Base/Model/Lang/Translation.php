<?php

declare(strict_types=1);

namespace App\Base\Model\Lang;

use Illuminate\Database\Eloquent\Builder;
use App\Base\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

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
     *
     *
     * @param array $langID
     * @param boolean $active
     *
     * @return Builder
     */
    public function texts($langID = [], bool $active = null): Builder
    {
        $query = VText::where('vtext.translation_id', $this->translation_id);
        if (count($langID)) {
            $query->whereIn('vtext.lang_id', $langID);
        }
        if ($active !== null) {
            $query->where('vtext.active', $active);
        }

        return $query;
    }

    /**
     * Return the translation in a language selected,
     * or in other language if that does not exist.
     *
     * @param string $langID the language id form the lang.lang table
     *
     * @return Model
     */
    public function text(string $langID): Model
    {
        $text = $this->texts([$langID])->first();
        if (!$text) {
            throw new \Exception("Something went wrong with " . $langID);
        }
        return $text;
    }

    /**
     * To return an array like:  ['EN': 'hello', 'ES': 'Hola'].
     *
     * @param array $translationsID translation to return
     * @param array $langID         it's optional. Empty means all the languages.
     *
     * @return Builder type VText
     */
    public static function textsByID(
        array $translationsID,
        array $langID = [],
        bool $active = null
    ): Builder {
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
     * @param array $translationsID
     * @param array $translations
     *
     * @return array
     */
    public static function dictionary(array $translationsID, $translations): array
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

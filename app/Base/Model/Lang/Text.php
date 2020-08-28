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

class Text extends BaseModel
{
    protected $table = 'lang.text';

    protected $primaryKey = 'text_id';

    protected $fillable = [
        'lang_id',
        'translation_id',
        'text',
        'slug',
        'ext',
        'mime',
        'size',
        'created_by',
    ];

    /**
     * Save many text for the same translation, it's updated or create a new one.
     *
     * @param int $translation_id translation to save
     * @param array   $texts         text to be saved
     *
     * @return array
     */
    public static function saveText(int $translation_id, array $texts) : array
    {
        $textModels = [];
        foreach ($texts as $text) {
            $word = self::where([
                'translation_id' => $translation_id,
                'lang_id'        => $text['lang_id'],
            ])->first();

            if ($word) {
                $word->update($text);
            } else {
                $textModels[] = self::create([
                    'lang_id'        => $text['lang_id'],
                    'text'           => $text['text'],
                    'translation_id' => $translation_id,
                ])->fresh();
            }
        }

        return $textModels;
    }
}

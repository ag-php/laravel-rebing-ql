<?php

declare(strict_types=1);

namespace App\Base\Logic\Translation;

use App\Base\Exceptions\MessageError;
use App\Base\Model\Lang\Translation;
use Cocur\Slugify\Slugify;

class TranslationCode
{
    private $translation;
    private $defaultLang;

    /**
     * Undocumented function.
     *
     * @param Translation $translation
     * @param string $defaultLang
     */
    public function __construct(Translation $translation, $defaultLang)
    {
        $this->translation = $translation;
        $this->defaultLang = $defaultLang;
    }

    //end __construct()

    /**
     * Verify if the code is unique.
     * Return the same code.
     * If it's duplicated, return MessageError Exception.
     *
     * @param string $newCode the code to verify
     *
     * @return string
     */
    public function getCodeVerified(string $newCode) : string
    {
        $translation = Translation::where('code', $newCode)
            ->where('translation_id', '!=', $this->translation->translation_id)
            ->first();
        if ($translation) {
            throw (new MessageError(
                __(
                    'translation.code_duplicate',
                    [
                        'translation_id' => $translation->translation_id,
                        'code'           => $newCode,
                    ]
                )
            ));
        }

        return $newCode;
    }

    //end getCodeVerified()

    /**
     * Return the default code like {text}-{translationID}.
     *
     * @param array $texts [{lang_id, text}] at least it must have a value
     *
     * @return string
     */
    public function defaultCode(array $texts): string
    {
        $textCode = $texts[0];
        if ($textCode['lang_id'] !== $this->defaultLang) {
            foreach ($texts as $text) {
                if ($text['lang_id'] === $this->defaultLang) {
                    $textCode = $text;
                    break;
                }
            }
        }

        $code = substr($textCode['text'], 0, 20);
        $slugify = new Slugify();
        $code = $slugify->slugify($code, '_');

        $translation = Translation::where('code', $code)
            ->where('translation_id', '!=', $this->translation->translation_id)
            ->first();
        if (! $translation) {
            return $code;
        }

        return $code.'_'.$this->translation->translation_id;
    }

    //end defaultCode()
}//end class

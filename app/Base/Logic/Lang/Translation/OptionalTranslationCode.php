<?php

declare(strict_types=1);

namespace App\Base\Logic\Lang\Translation;

use App\Base\Model\Lang\Translation;

class OptionalTranslationCode
{
    private string $code;
    private Translation $translation;

    public function __construct(string $code, Translation $translation)
    {
        $this->code = $code;
        $this->translation = $translation;
    }

    private function isDuplicated(): bool
    {
        $codeQuery = Translation::where('code', $this->code);
        if ($this->translation->exists) {
            $codeQuery->where('translation_id', '!=', $this->translation->translation_id);
        }

        return $codeQuery->first() ? true : false;
    }

    public function getCode(): string
    {
        if (! $this->isDuplicated()) {
            return $this->code;
        }

        $strAdd = $this->translation->exists
            ? '_'.$this->translation->translation_id
            : '_'.uniqid();

        return $this->code.$strAdd;
    }
}

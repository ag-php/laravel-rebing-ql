<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting

namespace App\Base\Logic\OptionalParams;

use App\Base\Exceptions\MessageError;
use App\Base\Globals\Roles;
use App\Base\Logic\Translation\TranslationCode;
use App\Base\Model\Lang\Translation;

class TranslationCodeParam
{
    private Translation $translation;
    private string $defaultLang;
    private OptionalParams $optionalParams;

    /**
     * Undocumented function.
     *
     * @param array       $optionals   array with possible values.
     * @param Translation $translation Model, may be null.
     */
    public function __construct(array $optionals, Translation $translation, string $defaultLang)
    {
        $this->optionalParams = new OptionalParams($optionals, 'code');
        $this->translation = $translation;
        $this->defaultLang = $defaultLang;
    }

    //end __construct()

    /**
     * This function return a new code to be used in the current translation.
     * - If the user does not have rights, return MessageError Exception.
     *
     * @param array $texts array with possible values.
     *
     * @return string
     */
    public function getValueOrFail(array $texts = null) : string
    {
        // If translation is blocked. Only a super admin can modify it.
        if ($this->translation->is_blocked && ! Roles::isSuperUser()) {
            // If is the same code that is in DB return the current DB code.
            if ($this->optionalParams->existParam()
                && $this->translation->code === $this->optionalParams->getValue()
            ) {
                return $this->translation->code;
            }

            throw with(
                new MessageError(
                    __(
                        'translation.translation_blocked_code',
                        ['translation_id' => $this->translation->translation_id]
                    )
                )
            );
        }

        return $this->getValue($texts);
    }

    /**
     * This function return a new code to be used in the current translation.
     *
     * - Return $translation->code if the user does not have rights.
     * - Return the code if it exist in the $options array.
     * - Return a value from $texts from the default lang (EN) text + translation ID.
     * - Return translation->code by default.
     *
     * @param array $texts array with possible values.
     *
     * @return string
     */
    public function getValue(array $texts = null) : string
    {
        if ($this->translation->is_blocked && ! Roles::isSuperUser()) {
            return $this->translation->code;
        }

        $translationCode = new TranslationCode($this->translation, $this->defaultLang);

        if ($this->optionalParams->existParam()) {
            $newCode = $this->optionalParams->getValue();

            return $translationCode->getCodeVerified($newCode);
        }

        // To get the default code from the English (default lang) text.
        if ($texts !== null) {
            return $translationCode->defaultCode($texts);
        }

        return $this->translation->code;
    }
}//end class

<?php

declare(strict_types=1);

namespace App\Base\Logic\Translation;

use App\Base\Enums\SimpleMessage as SimpleMessageEnum;
use App\Base\Exceptions\MessageError;
use App\Base\Globals\Langs;
use App\Base\GraphQL\Classes\SimpleMessage;
use App\Base\Logic\OptionalParams\BlockedParam;
use App\Base\Logic\OptionalParams\TranslationCodeParam;
use App\Base\Model\Lang\Text;
use App\Base\Model\Lang\Translation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * To update a existing translation.
 *
 * @author Albert Tjornehoj
 */
class TranslationUpdate
{
    private Translation $translation;
    private bool $allowSuperUser;

    public function __construct(Translation $translation, bool $allowSuperUser = true)
    {
        $this->translation = $translation;
        $this->allowSuperUser = $allowSuperUser;
    }

    /**
     * Update the current translation.
     *
     * string $code      unique code for the translation
     * array  $texts     text to be saved
     * array  $optionals array [text, lang_id]
     *
     * @return array
     */
    public function update(array $texts, array $optionals = []): array
    {
        $translationArgs = [];

        $codeParam = new TranslationCodeParam($optionals, $this->translation, Langs::getDefault());
        $translationArgs['code'] = $codeParam->getValueOrFail();

        $blockedParam = new BlockedParam($optionals, $this->translation->is_blocked, $this->allowSuperUser);
        $translationArgs['is_blocked'] = $blockedParam->getValue();

        $newTexts = $this->getTextsOrFail($blockedParam, $texts);
        $is_blocked = $this->translation->is_blocked;
        try {
            DB::beginTransaction();

            $this->translation->update($translationArgs);
            Text::saveText($this->translation->translation_id, $newTexts);

            DB::commit();

            $messages = new Collection([]);

            if (count($newTexts) !== count($texts)) {
                $langsList = $this->getLangsList($newTexts);
                $messages->push(
                    new SimpleMessage(
                        __(
                            'translation.translation_langs_update',
                            ['langs' => $langsList]
                        ),
                        SimpleMessageEnum::INFO(),
                    )
                );
            } else {
                $messages->push(
                    new SimpleMessage(
                        __(
                            'graphql.updated_success',
                            ['item' => $this->translation->translation_id]
                        ),
                        SimpleMessageEnum::SUCCESS()
                    )
                );
            }//end if

            if ($is_blocked) {
                $messages->push(
                    new SimpleMessage(
                        __('translation.translation_blocked_update'),
                        SimpleMessageEnum::WARNING()
                    )
                );
            }

            return [
                'data'     => $this->translation,
                'messages' => $messages,
            ];
        } catch (\Exception $error) {
            DB::rollback();
            throw $error;
        }//end try
    }

    //end update()

    /**
     * If translation is blocked and user doesn't have rights, so the
     * function return only the texts empty in the DB. If the texts empty
     * are zero, it fail.
     *
     * BlockedParam $blockedParam
     * array        $texts        App\Base\GraphQL\InputObjectType\TranslationInput.
     *
     * @return array
     */
    private function getTextsOrFail(BlockedParam $blockedParam, array $texts): array
    {
        if ($this->translation->is_blocked && ! $blockedParam->hasRights()) {
            $newTexts = $this->getTextsEmpty($texts);
            if (count($newTexts) === 0) {
                throw with(
                    new MessageError(
                        __(
                            'translation.translation_blocked_texts',
                            ['translation_id' => $this->translation->translation_id]
                        )
                    )
                );
            }

            return $newTexts;
        }

        return $texts;
    }

    //end getTextsOrFail()

    /**
     * The function removed all the text that are not empty in the DB.
     * It return only the text that are empty in the DB.
     *
     * array $texts App\Base\GraphQL\InputObjectType\TranslationInput.
     *
     * @return array
     */
    private function getTextsEmpty(array $texts) : array
    {
        $newTexts = [];
        foreach ($texts as $text) {
            $textLang = Text::where(
                [
                    'lang_id'        => $text['lang_id'],
                    'translation_id' => $this->translation->translation_id,
                ]
            )->count();
            if ($textLang === 0) {
                $newTexts[] = $text;
            }
        }

        return $newTexts;
    }

    //end getTextsEmpty()

    /**
     * To get a lang_id list separated by coma.
     *
     * array  $texts     App\Base\GraphQL\InputObjectType\TranslationInput.
     * string $delimiter Delimiter to the lang_id values.
     *
     * @return string
     */
    private function getLangsList(array $texts, string $delimiter = ', '): string
    {
        $langs = array_map(
            function ($text) {
                return $text['lang_id'];
            },
            $texts
        );

        return implode($delimiter, $langs);
    }

    //end getLangsList()
}//end class

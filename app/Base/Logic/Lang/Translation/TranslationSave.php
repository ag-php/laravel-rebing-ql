<?php

declare(strict_types=1);

namespace App\Base\Logic\Lang\Translation;

use App\Base\Classes\Save\IData;
use App\Base\Enums\SimpleMessage as SimpleMessageEnum;
use App\Base\GraphQL\Classes\SimpleMessage;
use App\Base\Model\Lang\Text;
use App\Base\Model\Lang\Translation;

class TranslationSave implements IData
{
    private string $event;
    private Translation $translation;
    private array $texts;
    private array $optionals;
    private array $messages = [];

    public function __construct(
        Translation $translation,
        array $texts,
        array $optionals
    ) {
        $this->translation = $translation;
        $this->event = $this->translation->exists ? 'update' : 'create';
        $this->texts = $texts;
        $this->optionals = $optionals;
    }

    public function messages(): array
    {
        return $this->messages;
    }

    public function id(): int
    {
        return $this->translation->translation_id;
    }

    public function data(): Translation
    {
        return $this->translation;
    }

    public function save(): void
    {
        // Update isBlocked optional argument
        if (isset($this->optionals['isBlocked'])) {
            $this->translation->is_blocked = $this->optionals['isBlocked'];
        }

        // Update code optional argument
        if (! empty($this->optionals['code'])) {
            $optionalCode = new OptionalTranslationCode(
                $this->optionals['code'],
                $this->translation
            );
            $this->translation->code = $optionalCode->getCode();
            if ($this->translation->code !== $this->optionals['code']) {
                $this->messages[] = new SimpleMessage(
                    'The code was modified to: "'.$this->translation->code.'"',
                    SimpleMessageEnum::INFO(),
                );
            }
        }

        $this->translation->save();

        // Save texts
        $this->saveTexts();

        // Success message
        $msg = ($this->event === 'update')
            ? 'graphql.updated_success'
            : 'graphql.created_success';

        $this->messages[] = new SimpleMessage(
            trans($msg, ['item' => $this->id()]),
            SimpleMessageEnum::SUCCESS(),
        );
    }

    private function saveTexts(): void
    {
        foreach ($this->texts as $newText) {
            $text = Text::firstOrNew([
                'lang_id' => $newText['langID'],
                'translation_id' => $this->id(),
            ]);
            $text->text = $newText['text'];
            $text->save();
        }
    }
}

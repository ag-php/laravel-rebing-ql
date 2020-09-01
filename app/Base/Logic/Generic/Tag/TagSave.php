<?php

declare(strict_types=1);

namespace App\Base\Logic\Generic\Tag;

use App\Base\Classes\Save\IData;
use App\Base\Enums\SimpleMessage as SimpleMessageEnum;
use App\Base\GraphQL\Classes\SimpleMessage;
use App\Base\Model\Generic\Tag;

class TagSave implements IData
{
    private Tag $tag;
    private int $translationID;
    private array $optionals;
    private array $messages = [];

    public function __construct(
        Tag $tag,
        int $translationID,
        array $optionals
    ) {
        $this->tag = $tag;
        $this->translationID = $translationID;
        $this->optionals = $optionals;
    }

    public function messages(): array
    {
        return $this->messages;
    }

    public function id(): int
    {
        return $this->tag->tag_id;
    }

    public function data(): Tag
    {
        return $this->tag;
    }

    public function save(): void
    {
        // Success message
        $msg = ($this->tag->exists)
         ? 'graphql.updated_success'
         : 'graphql.created_success';

        // Update isBlocked optional argument
        if (isset($this->optionals['isBlocked'])) {
            $this->translation->is_blocked = $this->optionals['isBlocked'];
        }
        $this->tag->translation_id = $this->translationID;
        $this->tag->save();

        $this->messages[] = new SimpleMessage(
            trans($msg, ['item' => $this->id()]),
            SimpleMessageEnum::SUCCESS(),
        );
    }
}

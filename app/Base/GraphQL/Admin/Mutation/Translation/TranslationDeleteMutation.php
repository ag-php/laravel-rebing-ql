<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Mutation\Translation;

use App\Base\Enums\SimpleMessage as SimpleMessageEnum;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\GraphQL\Classes\SimpleMessage;
use App\Base\Model\Lang\Translation;
use App\Base\Rules\Blocked;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class TranslationDeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'translationDelete',
        'description' => 'Translation delete mutation',
    ];

    public function type(): Type
    {
        return MessageWrapper::type('TranslationType');
    }

    public function args(): array
    {
        return [
            'translationID' => [
                'type' => Type::int(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:pgsql.lang.translation,translation_id',
                    new Blocked(
                        Translation::class,
                        'translation_id'
                    ),
                ],
            ],
        ];
    }

    public function resolve(?Object $root, array $args): array
    {
        $translation = Translation::find($args['translationID']);
        // phpstan think that $translation may be null
        // because it can see the validation in args
        // @phpstan-ignore-next-line
        $translation->delete();
        $msgTag = trans('graphql.deleted_success', ['item' => $args['translationID']]);

        return [
            'data' => $translation,
            'messages' => [new SimpleMessage($msgTag, SimpleMessageEnum::SUCCESS())],
        ];
    }
}

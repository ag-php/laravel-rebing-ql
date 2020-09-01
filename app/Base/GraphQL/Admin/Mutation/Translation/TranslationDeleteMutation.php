<?php

namespace App\Base\GraphQL\Admin\Mutation\Translation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Base\Model\Lang\Translation;
use App\Base\Rules\Blocked;
use Illuminate\Support\Collection;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\GraphQL\Classes\SimpleMessage;
use App\Base\Enums\SimpleMessage as SimpleMessageEnum;

class TranslationDeleteMutation extends Mutation
{

    protected $attributes = [
        'name' => 'translationDelete',
        'description' => 'Translation delete mutation'
    ];

    public function type(): Type
    {
        return MessageWrapper::type('TranslationType');
    }

    public function args(): array
    {
        return [
            'symbol_id' => [
                'type' => Type::int(),
                'rules' => [
                    'required',
                    'integer',
                    'exists:pgsql.lang.translation,translation_id',
                    new Blocked(
                        Translation::class,
                        'symbol_id'
                    ),
                ]
            ],
        ];

    }

    public function resolve(?Object $root, array $args): array
    {
        $translation = Translation::find($args['translation_id']);
        // phpstan think that $translation may be null
        // because it can see the validation in args
        // @phpstan-ignore-next-line
        $translation->delete();
        $msgTag = trans('graphql.deleted_success', [ 'item' => $args['translation_id'] ]);
        return [
            'data' => $translation,
            'messages' => new Collection([ new SimpleMessage($msgTag, SimpleMessageEnum::SUCCESS()) ]),
        ];
    }

}

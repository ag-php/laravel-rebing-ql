<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Type;

use App\Base\Logic\Lang\Translation\TextField;
use App\Base\Model\Lang\Translation;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TagType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'TagType',
        'description' => 'A Tag type',
    ];

    public function fields() : array
    {
        $textField = new TextField();

        return [
            'tagID' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Tag ID',
                'alias' => 'tag_id',
            ],
            'translationID' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Translation  name',
                'alias' => 'translation_id',
            ],
            'isBlocked'     => [
                'type'        => Type::nonNull(Type::boolean()),
                'description' => 'Flag to indicate if lang is blocked (tag no modificable)',
                'alias' => 'is_blocked',
            ],
            'translation'   => [
                'type'        => GraphQL::type('TranslationType'),
                'description' => 'Translation data',
                'resolve'     => function ($root) {
                    return Translation::find($root->translation_id);
                },
            ],
            'texts' => $textField->texts(),
            'text' => $textField->text(),
        ];
    }
}

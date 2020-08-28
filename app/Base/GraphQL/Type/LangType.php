<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LangType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'LangType',
        'description' => 'A Lang type',
    ];

    public function fields() : array
    {
        return [
            'langID'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The lang ID',
                'alias' => 'lang_id',
            ],
            'name'      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The lang name (english, spanish...)',
            ],
            'localName' => [
                'type'        => Type::string(),
                'description' => 'Local name example: Spanish = Español',
                'alias' => 'local_name',
            ],
            'active'    => [
                'type'        => Type::boolean(),
                'description' => 'flag to indicate if lang is active',
            ],
            'isBlocked' => [
                'type'        => Type::boolean(),
                'description' => 'flag to indicate if lang is blocked',
                'alias' => 'is_blocked',
            ],
        ];
    }
}

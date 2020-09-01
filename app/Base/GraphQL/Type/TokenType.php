<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Type;

use App\Base\Logic\DateFormat\DateFormat;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TokenType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'TokenType',
        'description' => 'A type of Token table',
    ];

    public function fields() : array
    {
        return [
            'tokenID'  => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Token identification, primary key',
                'alias' => 'token_id',
            ],
            'type'     => [
                'type'        => Type::string(),
                'description' => 'User From identification',
            ],
            'usedAt'   => [
                'type'        => Type::string(),
                'description' => 'From who the email was sent',
                'alias' => 'used_at',
                'resolve'     => function ($root) {
                    if (! $root->used_at) {
                        return;
                    }

                    $dateFormat = new DateFormat($root->used_at);

                    return $dateFormat->getFullTime();
                },
            ],
            'expireAt' => [
                'type'        => Type::string(),
                'description' => 'User name From who the email was sent',
                'alias' => 'expire_at',
                'resolve'     => function ($root) {
                    $dateFormat = new DateFormat($root->expire_at);

                    return $dateFormat->getFullTime();
                },
            ],
            'createdAt'   => [
                'type'        => Type::string(),
                'description' => 'Sent date time',
                'alias' => 'created_at',
                'resolve'     => function ($root) {
                    if (! $root->created_at) {
                        return;
                    }

                    $dateFormat = new DateFormat($root->created_at);

                    return $dateFormat->getFullTime();
                },
            ],
        ];
    }
}

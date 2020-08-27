<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

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

    // phpcs:disable PEAR.Commenting.FunctionComment.Missing
    public function fields() : array
    {
        return [
            'token_id'  => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Token identification, primary key',
            ],
            'type'     => [
                'type'        => Type::string(),
                'description' => 'User From identification',
            ],
            'used_at'   => [
                'type'        => Type::string(),
                'description' => 'From who the email was sent',
                'resolve'     => function ($root) {
                    if (! $root->used_at) {
                        return;
                    }

                    $dateFormat = new DateFormat($root->used_at);

                    return $dateFormat->getFullTime();
                },
            ],
            'expire_at' => [
                'type'        => Type::string(),
                'description' => 'User name From who the email was sent',
                'resolve'     => function ($root) {
                    $dateFormat = new DateFormat($root->expire_at);

                    return $dateFormat->getFullTime();
                },
            ],
            'created_at'   => [
                'type'        => Type::string(),
                'description' => 'Sent date time',
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

    //end fields()
}//end class

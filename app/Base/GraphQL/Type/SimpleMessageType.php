<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Type;

use App\Base\Enums\SimpleMessage as SimpleMessageEnum;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SimpleMessageType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'SimpleMessageType',
        'description' => 'A type of a simple message',
    ];

    public function fields() : array
    {
        $status = implode(', ', SimpleMessageEnum::getValues());

        return [
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Simple Message',
            ],
            'type'    => [
                'type' => Type::string(),
                'description' => 'Values: '.$status,
                //'defaultValue' => SimpleMessageEnum::SUCCESS,
            ],
            'code'    => [
                'type' => Type::int(),
            ],
        ];
    }
}

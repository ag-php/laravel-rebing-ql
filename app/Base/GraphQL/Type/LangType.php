<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

namespace App\Base\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LangType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'LangType',
        'description' => 'A Lang type',
    ];

    // phpcs:disable PEAR.Commenting.FunctionComment.Missing
    public function fields() : array
    {
        return [
            'lang_id'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The lang ID',
            ],
            'name'      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The lang name (english, spanish...)',
            ],
            'local_name' => [
                'type'        => Type::string(),
                'description' => 'Local name example: Spanish = Español',
            ],
            'active'    => [
                'type'        => Type::boolean(),
                'description' => 'flag to indicate if lang is active',
            ],
            'is_blocked' => [
                'type'        => Type::boolean(),
                'description' => 'flag to indicate if lang is blocked',
            ],
        ];
    }

    //end fields()
}//end class

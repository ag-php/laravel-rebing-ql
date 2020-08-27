<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

namespace App\Base\GraphQL\Type;

use App\Base\Logic\Translation\TextField;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TranslationType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'TranslationType',
        'description' => 'A Translation type',
    ];

    // phpcs:disable PEAR.Commenting.FunctionComment.Missing
    public function fields() : array
    {
        $textField = new TextField();

        return [
            'translation_id' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The Translation ID',
                'alias'       => 'translation_id',
            ],
            'code'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The Translation code',
            ],
            'is_blocked'     => [
                'type'        => Type::nonNull(Type::boolean()),
                'description' => 'The Translation code',
                'alias'       => 'is_blocked',
            ],
            'texts' => $textField->texts(),
            'text' => $textField->text(),
        ];
    }
}

<?php

declare(strict_types=1);

// phpcs:disable PEAR.Commenting.FileComment.Missing

namespace App\Base\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TextType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'TextType',
        'description' => 'A Text',
    ];

    // phpcs:disable PEAR.Commenting.FunctionComment.Missing
    public function fields() : array
    {
        return [
            'translation_id'  => [
                'type'        => Type::int(),
                'description' => 'The Group ID',
            ],
            'code'           => [
                'type'        => Type::string(),
                'description' => 'translation_code',
            ],
            'lang_id'         => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The Lang ID',
            ],
            'text_id'         => [
                'type'        => Type::int(),
                'description' => 'The Word ID',
            ],
            'text'           => [
                'type'        => Type::string(),
                'description' => 'Text name',
            ],
            'original_text_id' => [
                'type'        => Type::int(),
                'description' => 'The original text ID',
            ],
            'original_lang_id' => [
                'type'        => Type::string(),
                'description' => 'The original lang ID',
            ],
            'is_available' => [
                'type'        => Type::boolean(),
                'description' => 'TRUE or FALSE, to know if the text is available in its language',
            ],
        ];
    }

    //end fields()
}//end class

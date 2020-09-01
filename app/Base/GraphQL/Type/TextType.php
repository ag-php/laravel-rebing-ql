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
            'translationID'  => [
                'type'        => Type::int(),
                'description' => 'The Group ID',
                'alias' => 'translation_id',
            ],
            'code'           => [
                'type'        => Type::string(),
                'description' => 'translation_code',
            ],
            'langID'         => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The Lang ID',
                'alias' => 'lang_id',
            ],
            'textID'         => [
                'type'        => Type::int(),
                'description' => 'The Word ID',
                'alias' => 'text_id',
            ],
            'text'           => [
                'type'        => Type::string(),
                'description' => 'Text name',
            ],
            'originalTextID' => [
                'type'        => Type::int(),
                'description' => 'The original text ID',
                'alias' => 'original_text_id',
            ],
            'originalLangID' => [
                'type'        => Type::string(),
                'description' => 'The original lang ID',
                'alias' => 'original_lang_id',
            ],
            'isAvailable' => [
                'type'        => Type::boolean(),
                'description' => 'TRUE or FALSE, to know if the text is available in its language',
                'alias' => 'is_available',
            ],
        ];
    }

}

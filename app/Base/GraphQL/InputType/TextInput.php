<?php

declare(strict_types=1);

namespace App\Base\GraphQL\InputType;

use App\Base\Rules\NoHTMLTags;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class TextInput extends InputType
{
    protected $attributes = [
        'name' => 'TextInput',
        'description' => 'A text input',
    ];

    public function fields(): array
    {
        return [
            'text'   => [
                'name'  => 'text',
                'type'  => Type::string(),
                'rules' => [
                    'string',
                    'required',
                    'min:1',
                    new NoHTMLTags,
                ],
            ],
            'langID' => [
                'type'  => Type::string(),
                'rules' => [
                    'required',
                    'exists:pgsql.lang.lang,lang_id',
                ],
            ],
        ];
    }
}

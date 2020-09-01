<?php

namespace App\Base\GraphQL\InputType;

use Rebing\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;
use App\Base\Rules\NoHTMLTags;

class TextInput extends InputType
{
    protected $attributes = [
        'name' => 'TextInput',
        'description' => 'A text input'
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

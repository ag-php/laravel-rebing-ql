<?php

namespace App\Base\GraphQL\Admin\Query\Translation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Base\Model\Lang\Translation;
use App\Base\Exceptions\MessageError;
use Illuminate\Support\Collection;
use App\Base\GraphQL\Classes\{
    SimpleMessage,
    MessageWrapper
};

class TranslationQuery extends Query
{

    protected $attributes = [
        'name'        => 'translationQuery',
        'description' => 'A query to get the Translation Type',
    ];

    public function type(): Type
    {
        return MessageWrapper::type('TranslationType');

    }

    public function args(): array
    {
        return [
            'translation_id' => [
                'type'  => Type::int(),
                'rules' => ['required'],
            ],
        ];

    }

    public function resolve(?Object $root, array $args): array
    {
        $translation = Translation::find($args['translation_id']);
        if (!$translation) {
            throw new MessageError("Not found", 404);
        }
        $message = __(
            'graphql.created_success',
            [ 'item' => $args['translation_id'] ]
        );
        return [
            'data' => $translation,
            'messages' => [],
        ];

    }

}

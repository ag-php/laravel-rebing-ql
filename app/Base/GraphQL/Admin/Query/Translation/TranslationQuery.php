<?php

declare(strict_types=1);

namespace App\Base\GraphQL\Admin\Query\Translation;

use App\Base\Exceptions\MessageError;
use App\Base\GraphQL\Classes\MessageWrapper;
use App\Base\Model\Lang\Translation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

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
            'translationID' => [
                'type'  => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve(?Object $root, array $args): array
    {
        $translation = Translation::find($args['translationID']);
        if (! $translation) {
            throw new MessageError('Not found', 404);
        }
        $message = __(
            'graphql.created_success',
            ['item' => $args['translationID']]
        );

        return [
            'data' => $translation,
            'messages' => [],
        ];
    }
}
